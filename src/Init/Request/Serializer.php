<?php

namespace MLocati\PayWay\Init\Request;

use MLocati\PayWay\Init\Request;
use MLocati\PayWay\Service\SerializerTrait;

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
        $init = $this->createSoapEnvelope('Init');
        $doc = $init->ownerDocument;
        $init->appendChild($xRequest = $doc->createElement('request'));
        $this->appendNode($xRequest, 'apiVersion', $request->getApiVersion());
        $this->appendNode($xRequest, 'tid', $request->getTID());
        $this->appendNode($xRequest, 'merIC', $request->getMerID());
        $this->appendNode($xRequest, 'payInstr', $request->getPayInstr());
        $this->appendNode($xRequest, 'reqTime', $this->serializeDateTime($request->getReqTime()));
        $this->appendNode($xRequest, 'signature', $request->getSignature($signatureKey));
        $this->appendNode($xRequest, 'shopID', $request->getShopID());
        $this->appendNode($xRequest, 'shopUserRef', $request->getShopUserRef());
        $this->appendNode($xRequest, 'shopUserName', $request->getShopUserName());
        $this->appendNode($xRequest, 'shopUserAccount', $request->getShopUserAccount());
        $this->appendNode($xRequest, 'shopUserMobilePhone', $request->getShopUserMobilePhone());
        $this->appendNode($xRequest, 'shopUserIMEI', $request->getShopUserIMEI());
        $this->appendNode($xRequest, 'trType', $request->getTrType());
        $this->appendNode($xRequest, 'amount', $this->serializeInteger($request->getAmountAsCents()));
        $this->appendNode($xRequest, 'currencyCode', $request->getCurrencyCode());
        $this->appendNode($xRequest, 'langID', $request->getLangID());
        $this->appendNode($xRequest, 'notifyURL', $request->getNotifyURL());
        $this->appendNode($xRequest, 'errorURL', $request->getErrorURL());
        $this->appendNode($xRequest, 'callbackURL', $request->getCallbackURL());
        $this->appendNode($xRequest, 'addInfo1', $request->getAddInfo1());
        $this->appendNode($xRequest, 'addInfo2', $request->getAddInfo2());
        $this->appendNode($xRequest, 'addInfo3', $request->getAddInfo3());
        $this->appendNode($xRequest, 'addInfo4', $request->getAddInfo4());
        $this->appendNode($xRequest, 'addInfo5', $request->getAddInfo5());
        $this->appendNode($xRequest, 'payInstrToken', $request->getPayInstrToken());
        $this->appendNode($xRequest, 'billingID', $request->getBillingID());
        $this->appendNode($xRequest, 'regenPayInstrToken', $this->serializeBoolean($request->isRegenPayInstrToken()));
        $this->appendNode($xRequest, 'keepOnRegenPayInstrToken', $this->serializeBoolean($request->isKeepOnRegenPayInstrToken()));
        $this->appendNode($xRequest, 'payInstrTokenExpire', $this->serializeDateTime($request->getPayInstrTokenExpire()));
        $this->appendNode($xRequest, 'payInstrTokenUsageLimit', $this->serializeInteger($request->getPayInstrTokenUsageLimit()));
        $this->appendNode($xRequest, 'payInstrTokenAlg', $request->getPayInstrTokenAlg());
        $this->appendNode($xRequest, 'accountName', $request->getAccountName());
        $level3Info = $request->getLevel3Info();
        $xLevel3Info = $doc->createElement('level3Info');
        $this->appendNode($xLevel3Info, 'invoiceNumber', $level3Info->getInvoiceNumber());
        $this->appendNode($xLevel3Info, 'senderPostalCode', $level3Info->getSenderPostalCode());
        $this->appendNode($xLevel3Info, 'senderCountryCode', $level3Info->getSenderCountryCode());
        $this->appendNode($xLevel3Info, 'destinationName', $level3Info->getDestinationName());
        $this->appendNode($xLevel3Info, 'destinationStreet', $level3Info->getDestinationStreet());
        $this->appendNode($xLevel3Info, 'destinationStreet2', $level3Info->getDestinationStreet2());
        $this->appendNode($xLevel3Info, 'destinationStreet3', $level3Info->getDestinationStreet3());
        $this->appendNode($xLevel3Info, 'destinationCity', $level3Info->getDestinationCity());
        $this->appendNode($xLevel3Info, 'destinationState', $level3Info->getDestinationState());
        $this->appendNode($xLevel3Info, 'destinationPostalCode', $level3Info->getDestinationPostalCode());
        $this->appendNode($xLevel3Info, 'destinationCountryCode', $level3Info->getDestinationCountryCode());
        $this->appendNode($xLevel3Info, 'destinationPhone', $level3Info->getDestinationPhone());
        $this->appendNode($xLevel3Info, 'destinationFax', $level3Info->getDestinationFax());
        $this->appendNode($xLevel3Info, 'destinationEmail', $level3Info->getDestinationEmail());
        $this->appendNode($xLevel3Info, 'destinationDate', $this->serializeDateTime($level3Info->getDestinationDate()));
        $this->appendNode($xLevel3Info, 'billingName', $level3Info->getBillingName());
        $this->appendNode($xLevel3Info, 'billingStreet', $level3Info->getBillingStreet());
        $this->appendNode($xLevel3Info, 'billingStreet2', $level3Info->getBillingStreet2());
        $this->appendNode($xLevel3Info, 'billingStreet3', $level3Info->getBillingStreet3());
        $this->appendNode($xLevel3Info, 'billingCity', $level3Info->getBillingCity());
        $this->appendNode($xLevel3Info, 'billingState', $level3Info->getBillingState());
        $this->appendNode($xLevel3Info, 'billingPostalCode', $level3Info->getBillingPostalCode());
        $this->appendNode($xLevel3Info, 'billingCountryCode', $level3Info->getBillingCountryCode());
        $this->appendNode($xLevel3Info, 'billingPhone', $level3Info->getBillingPhone());
        $this->appendNode($xLevel3Info, 'billingFax', $level3Info->getBillingFax());
        $this->appendNode($xLevel3Info, 'billingEmail', $level3Info->getBillingEmail());
        $this->appendNode($xLevel3Info, 'freightAmount', $this->serializeInteger($level3Info->getFreightAmountAsCents()));
        $this->appendNode($xLevel3Info, 'taxAmount', $this->serializeInteger($level3Info->getTaxAmountAsCents()));
        $this->appendNode($xLevel3Info, 'vat', $level3Info->getVat());
        $this->appendNode($xLevel3Info, 'note', $level3Info->getNote());
        foreach ($level3Info->getProducts() as $product) {
            $xProduct = $doc->createElement('product');
            $this->appendNode($xProduct, 'productCode', $product->getProductCode());
            $this->appendNode($xProduct, 'productDescription', $product->getProductDescription());
            $this->appendNode($xProduct, 'items', $this->serializeInteger($product->getItems()));
            $this->appendNode($xProduct, 'amount', $this->serializeInteger($product->getAmountAsCents()));
            $this->appendNode($xProduct, 'imgURL', $product->getImgURL());
            if ($xProduct->childNodes->count() > 0) {
                $xLevel3Info->appendChild($xProduct);
            }
        }
        if ($xLevel3Info->childNodes->count() > 0) {
            $xRequest->appendChild($xLevel3Info);
        }
        $mandateInfo = $request->getMandateInfo();
        $xMandateInfo = $doc->createElement('mandateInfo');
        $this->appendNode($xMandateInfo, 'mandateID', $mandateInfo->getMandateID());
        $this->appendNode($xMandateInfo, 'contractID', $mandateInfo->getContractID());
        $this->appendNode($xMandateInfo, 'sequenceType', $mandateInfo->getSequenceType());
        $this->appendNode($xMandateInfo, 'frequency', $mandateInfo->getFrequency());
        $this->appendNode($xMandateInfo, 'durationStartDate', $this->serializeDateTime($mandateInfo->getDurationStartDate()));
        $this->appendNode($xMandateInfo, 'durationEndDate', $this->serializeDateTime($mandateInfo->getDurationEndDate()));
        $this->appendNode($xMandateInfo, 'firstCollectionDate', $this->serializeDateTime($mandateInfo->getFirstCollectionDate()));
        $this->appendNode($xMandateInfo, 'finalCollectionDate', $this->serializeDateTime($mandateInfo->getFinalCollectionDate()));
        $this->appendNode($xMandateInfo, 'maxAmount', $this->serializeInteger($mandateInfo->getMaxAmountAsCents()));
        if ($xMandateInfo->childNodes->count() > 0) {
            $xRequest->appendChild($xMandateInfo);
        }
        $this->appendNode($xRequest, 'description', $request->getDescription());
        $this->appendNode($xRequest, 'paymentReason', $request->getPaymentReason());
        $this->appendNode($xRequest, 'freeText', $request->getFreeText());
        $this->appendNode($xRequest, 'topUpID', $request->getTopUpID());
        $this->appendNode($xRequest, 'firstTopUp', $this->serializeBoolean($request->isFirstTopUp()));
        $this->appendNode($xRequest, 'payInstrTokenAsTopUpID', $this->serializeBoolean($request->isPayInstrTokenAsTopUpID()));
        $this->appendNode($xRequest, 'recurrentIndicator', $this->serializeBoolean($request->isRecurrentIndicator()));
        $this->appendNode($xRequest, 'txIndicatorType', $request->getTxIndicatorType());
        $this->appendNode($xRequest, 'traceChainId', $request->getTraceChainId());
        $this->appendNode($xRequest, 'scaExemptionType', $request->getScaExemptionType());
        $this->appendNode($xRequest, 'validityExpire', $this->serializeDateTime($request->getValidityExpire()));
        $this->appendNode($xRequest, 'minExpireMonth', $this->serializeInteger($request->getMinExpireMonth()));
        $this->appendNode($xRequest, 'minExpireYear', $this->serializeInteger($request->getMinExpireYear()));
        foreach ($request->getTermInfos() as $termInfo) {
            $xTermInfo = $doc->createElement('termInfo');
            $this->appendNode($xTermInfo, 'tid', $termInfo->getTid());
            $this->appendNode($xTermInfo, 'payInstrToken', $termInfo->getPayInstrToken());
            $this->appendNode($xTermInfo, 'billingID', $termInfo->getBillingID());
            if ($xTermInfo->childNodes->count() > 0) {
                $xRequest->appendChild($xTermInfo);
            }
        }
        foreach ($request->getPayInstrAddData() as $key => $value) {
            $xPayInstrAddData = $this->appendNode($xRequest, 'payInstrAddData', '', true);
            $this->appendNode($xPayInstrAddData, 'key', (string) $key, true);
            $this->appendNode($xPayInstrAddData, 'value', $value, true);
        }

        return $doc;
    }
}
