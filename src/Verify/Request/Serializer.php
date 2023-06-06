<?php

namespace MLocati\PayWay\Verify\Request;

use MLocati\PayWay\Service\SerializerTrait;
use MLocati\PayWay\Verify\Request;

class Serializer
{
    use SerializerTrait;

    const NS_SOAPENVELOPE = 'http://schemas.xmlsoap.org/soap/envelope/';

    const NS_IGFS = 'http://services.api.web.cg.igfs.apps.netsw.it/';

    /**
     * @param string $signatureKey
     *
     * @throws \MLocati\PayWay\Exception\MissingRequiredField
     * @throws \MLocati\PayWay\Exception\FieldValueTooLong
     * @throws \MLocati\PayWay\Exception\FieldValueOutOfRange
     * @throws \MLocati\PayWay\Exception\InvalidFieldUrl
     * @throws \MLocati\PayWay\Exception\UnableToCreateSignature
     *
     * @return string
     */
    public function serialize(Request $request, $signatureKey)
    {
        $doc = $this->createDocument($request, $signatureKey);

        return $doc->saveXML();
    }

    /**
     * @param string $signatureKey
     *
     * @throws \MLocati\PayWay\Exception\UnableToCreateSignature
     *
     * @return \DOMDocument
     */
    public function createDocument(Request $request, $signatureKey)
    {
        $request->check();
        $init = $this->createSoapEnvelope('Verify');
        $doc = $init->ownerDocument;
        $init->appendChild($xRequest = $doc->createElement('request'));
        $this->appendNode($xRequest, 'apiVersion', $request->getApiVersion());
        $this->appendNode($xRequest, 'tid', $request->getTID());
        $this->appendNode($xRequest, 'merIC', $request->getMerID());
        $this->appendNode($xRequest, 'payInstr', $request->getPayInstr());
        $this->appendNode($xRequest, 'reqTime', $this->serializeDateTime($request->getReqTime()));
        $this->appendNode($xRequest, 'signature', $request->getSignature($signatureKey));
        $this->appendNode($xRequest, 'shopID', $request->getShopID());
        $this->appendNode($xRequest, 'paymentID', $request->getPaymentID());
        $this->appendNode($xRequest, 'refTranID', $this->serializeInteger($request->getRefTranID()));

        return $doc;
    }
}
