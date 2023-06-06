<?php

namespace MLocati\PayWay\Init\Response;

use MLocati\PayWay\Init\Response;
use MLocati\PayWay\Service\UnserializerTrait;

class Unserializer
{
    use UnserializerTrait;

    const NS_SOAPENVELOPE = 'http://schemas.xmlsoap.org/soap/envelope/';

    const NS_IGFS = 'http://services.api.web.cg.igfs.apps.netsw.it/';

    /**
     * @param string $raw
     *
     * @throws \MLocati\PayWay\Exception\InvalidXml
     */
    public function unserialize($raw)
    {
        $xResponse = $this->loadDocument($raw, '/soap:Envelope/soap:Body/igfs:InitResponse/response');
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
            }
            if (!method_exists($response, $setter)) {
                $response->addUnrecognizedXmlElement($child);
                continue;
            }
            $response->{$setter}($value);
        }

        return $response;
    }
}
