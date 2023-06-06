<?php

namespace MLocati\PayWay\Service;

use DateTime;

use DateTimeImmutable;
use DOMDocument;
use DOMElement;
use DOMXPath;
use MLocati\PayWay\Exception;

trait UnserializerTrait
{
    /**
     * @param string|mixed $raw
     *
     * @throws \MLocati\PayWay\Exception\InvalidXml
     *
     * @return \DOMElement
     */
    protected function loadDocument($raw, $rootSelector)
    {
        if (!is_string($raw) || $raw === '') {
            throw new Exception\InvalidXml('');
        }
        $doc = new DOMDocument('1.0', 'UTF-8');
        $flags = LIBXML_NOCDATA | LIBXML_NOERROR | LIBXML_NOWARNING;
        if (defined('LIBXML_BIGLINES')) {
            $flags |= LIBXML_BIGLINES;
        }
        if (!$doc->loadXML($raw, $flags)) {
            throw new Exception\InvalidXml($raw);
        }
        $xpath = new DOMXPath($doc);
        $xpath->registerNamespace('soap', static::NS_SOAPENVELOPE);
        $xpath->registerNamespace('igfs', static::NS_IGFS);
        $nodes = $xpath->query($rootSelector);
        if ($nodes->length === 1) {
            return $nodes->item(0);
        }

        throw $this->buildException($raw, $xpath);
    }

    /**
     * @return \Generator|\DOMElement[]
     */
    protected function listDOMElements(DOMElement $parent)
    {
        for ($child = $parent->firstChild; $child = $child->nextSibling; $child) {
            if ($child instanceof DOMElement) {
                yield $child;
            }
        }
    }

    /**
     * @param string $raw
     *
     * @return \MLocati\PayWay\Exception\InvalidXml
     */
    protected function buildException($raw, DOMXPath $xpath)
    {
        $nodes = $xpath->query('/soap:Envelope/soap:Body/soap:Fault/faultstring');
        $description = $nodes->length === 1 ? trim((string) $nodes->item(0)->textContent) : '';
        $nodes = $xpath->query('/soap:Envelope/soap:Body/soap:Fault/faultcode');
        $code = $nodes->length === 1 ? trim((string) $nodes->item(0)->textContent) : '';
        if ($description === '' || $code === '') {
            $details = $description . $code;
        } elseif ($description === '' && $code === '') {
            $details = '';
        } else {
            $details = "{$description} (error code: {$code}}";
        }

        return new Exception\InvalidXml($raw, $details);
    }

    /**
     * @param string|null $value
     *
     * @throws \MLocati\PayWay\Exception\InvalidValue
     *
     * @return bool|null
     */
    protected function unserializeBoolean($value)
    {
        $value = (string) $value;
        if ($value === '') {
            return null;
        }
        switch (strtolower($value)) {
            case 'true':
            case '1':
            case 'on':
            case 'yes':
            case 't':
            case 'y':
                return true;
            case 'false':
            case '0':
            case 'off':
            case 'no':
            case 'f':
            case 'n':
                return false;
        }

        throw new Exception\InvalidValue("'{$value}' can't be converted to a boolean");
    }

    /**
     * @param string|null $value
     *
     * @throws \MLocati\PayWay\Exception\InvalidValue
     *
     * @return \DateTimeImmutable|null
     */
    protected function unserializeDateTime($value)
    {
        $value = (string) $value;
        if ($value === '') {
            return null;
        }
        if (defined('DateTime::RFC3339_EXTENDED')) {
            $result = DateTimeImmutable::createFromFormat(DateTime::RFC3339_EXTENDED, $value);
            if ($result !== false) {
                return $result;
            }
        }
        $result = DateTimeImmutable::createFromFormat(DateTime::RFC3339, $value);
        if ($result !== false) {
            return $result;
        }
        $fixed = preg_replace('/(T\d+:\d+:\d+)\.\d*/', '\1', $value);
        $result = DateTimeImmutable::createFromFormat(DateTime::RFC3339, $fixed);
        if ($result !== false) {
            return $value;
        }

        throw new Exception\InvalidValue("'{$value}' can't be converted to a date/time");
    }

    /**
     * @param string|null $value
     *
     * @throws \MLocati\PayWay\Exception\InvalidValue
     *
     * @return int|null
     */
    protected function unserializeInteger($value)
    {
        $value = (string) $value;
        if ($value === '') {
            return null;
        }
        if (preg_match('/^[+\-]?[0-9]+$/', $value)) {
            return (int) $value;
        }

        throw new Exception\InvalidValue("'{$value}' can't be converted to an integer number");
    }
}
