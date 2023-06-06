<?php

namespace MLocati\PayWay\Service;

use DateTime;
use DateTimeInterface;
use DOMDocument;
use DOMElement;

trait SerializerTrait
{
    /**
     * @return \DOMElement
     */
    protected function createSoapEnvelope($service)
    {
        $doc = new DOMDocument('1.0', 'UTF-8');
        $doc->appendChild($envelope = $doc->createElementNS(static::NS_SOAPENVELOPE, 'soapenv:Envelope'));
        $envelope->appendChild($body = $doc->createElementNS(static::NS_SOAPENVELOPE, 'soapenv:Body'));
        $body->appendChild($container = $doc->createElementNS(static::NS_IGFS, 'ser:' . $service));

        return $container;
    }

    /**
     * @param string $name
     * @param string $value
     * @param bool $evenIfEmpty
     *
     * @return \DOMElement|null
     */
    protected function appendNode(DOMElement $parent, $name, $value, $evenIfEmpty = false)
    {
        if ($value === '' && !$evenIfEmpty) {
            return null;
        }
        $doc = $parent->ownerDocument;
        $parent->appendChild($child = $doc->createElement($name));
        if ($value !== '') {
            $child->appendChild($doc->createTextNode($value));
        }

        return $child;
    }

    /**
     * @param bool|null $value
     *
     * @return string
     */
    protected function serializeBoolean($value)
    {
        if ($value === null) {
            return '';
        }

        return $value ? 'true' : 'false';
    }

    /**
     * @return string
     */
    protected function serializeDateTime(DateTimeInterface $value = null)
    {
        if ($value === null) {
            return '';
        }
        if (defined('DateTime::RFC3339_EXTENDED')) {
            return $value->format(DateTime::RFC3339_EXTENDED);
        }

        return $value->format('Y\\-m\\-d\\TH\\:i\\:s\\.\\0\\0\\0P');
    }

    /**
     * @param int|null $value
     *
     * @return string
     */
    protected function serializeInteger($value)
    {
        return (string) $value;
    }
}
