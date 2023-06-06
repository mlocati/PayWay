<?php

namespace MLocati\PayWay\Verify\Response;

use DOMElement;
use MLocati\PayWay\Service;
use MLocati\PayWay\Verify\Response;

class Unserializer
{
    use Service\UnserializerTrait;

    const NS_SOAPENVELOPE = 'http://schemas.xmlsoap.org/soap/envelope/';

    const NS_IGFS = 'http://services.api.web.cg.igfs.apps.netsw.it/';

    /**
     * @param string $raw
     *
     * @throws \MLocati\PayWay\Exception\InvalidXml
     */
    public function unserialize($raw)
    {
        $xResponse = $this->loadDocument($raw, '/soap:Envelope/soap:Body/igfs:VerifyResponse/response');
        $response = new Response();
        foreach ($this->listDOMElements($xResponse) as $child) {
            $tagName = $child->tagName;
            $setter = 'set' . ucfirst($tagName);
            $value = (string) $child->nodeValue;
            switch ($tagName) {
                case 'reqTime':
                    $value = $this->unserializeDateTime($value);
                    break;
                case 'error':
                    $value = $this->unserializeBoolean($value);
                    break;
                case 'tranID':
                case 'expireMonth':
                case 'expireYear':
                    $value = $this->unserializeInteger($value);
                    break;
                case 'additionalFee':
                    $value = $this->unserializeInteger($value);
                    $setter .= 'AsCents';
                    break;
                case 'level3Info':
                    $value = $this->unserializeLevel3Info($child, $response);
                    break;
                case 'payTraceData':
                    list($key, $value) = $this->unserializeEntryAttribute($child, $response);
                    $response->addPayTraceData($key, $value);
                    continue 2;
                case 'payAddData':
                    list($key, $value) = $this->unserializeEntryAttribute($child, $response);
                    $response->addPayAddData($key, $value);
                    continue 2;
            }
            if (!method_exists($response, $setter)) {
                $response->addUnrecognizedXmlElement($child);
                continue;
            }
            $response->{$setter}($value);
        }

        return $response;
    }

    /**
     * @return \MLocati\PayWay\Service\Level3Info
     */
    protected function unserializeLevel3Info(DOMElement $node, Response $response)
    {
        $result = new Service\Level3Info();
        foreach ($this->listDOMElements($node) as $child) {
            $tagName = $child->tagName;
            $setter = 'set' . ucfirst($tagName);
            $value = (string) $child->nodeValue;
            switch ($tagName) {
                case 'destinationDate':
                    $value = $this->unserializeDateTime($value);
                    break;
                case 'freightAmount':
                case 'taxAmount':
                    $value = $this->unserializeInteger($value);
                    $setter .= 'AsCents';
                    break;
                case 'product':
                    $result->addProduct($this->unserializeLevel3InfoProduct($child, $response));
                    continue 2;
            }
            if (!method_exists($result, $setter)) {
                $response->addUnrecognizedXmlElement($child);
                continue;
            }
            $result->{$setter}($value);
        }

        return $result;
    }

    /**
     * @return \MLocati\PayWay\Service\Level3Info\Product
     */
    protected function unserializeLevel3InfoProduct(DOMElement $node, Response $response)
    {
        $result = new Service\Level3Info\Product();
        foreach ($this->listDOMElements($node) as $child) {
            $tagName = $child->tagName;
            $setter = 'set' . ucfirst($tagName);
            $value = (string) $child->nodeValue;
            switch ($tagName) {
                case 'items':
                    $value = $this->unserializeInteger($value);
                    break;
                case 'amount':
                    $value = $this->unserializeInteger($value);
                    $setter .= 'AsCents';
                    break;
            }
            if (!method_exists($result, $setter)) {
                $response->addUnrecognizedXmlElement($child);
                continue;
            }
            $result->{$setter}($value);
        }

        return $result;
    }

    /**
     * @return string[]
     */
    protected function unserializeEntryAttribute(DOMElement $node, Response $response)
    {
        $result = ['', ''];
        foreach ($this->listDOMElements($node) as $child) {
            switch ($child->tagName) {
                case 'key':
                    $result[0] = (string) $child->nodeValue;
                    break;
                case 'value':
                    $result[1] = (string) $child->nodeValue;
                    break;
                default:
                    $response->addUnrecognizedXmlElement($child);
            }
        }

        return $result;
    }
}
