<?php

namespace MLocati\PayWay\Test\TestCase\Init;

use MLocati\PayWay\Exception\InvalidXml;
use MLocati\PayWay\Init\Response;
use MLocati\PayWay\Test\Service\TestCase;

class ResponseUnserializationTest extends TestCase
{
    public function testUnserializingSoapError()
    {
        $xml = <<<'EOT'
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
    <soap:Body>
        <soap:Fault>
            <faultcode>soap:Client</faultcode>
            <faultstring>Unmarshalling Error: unexpected element (uri:"", local:"unrecognizedField"). Expected elements are &lt;{}traceChainId>,&lt;{}tid>,&lt;{}minExpireYear>,&lt;{}apiVersion>,&lt;{}scaExemptionType>,&lt;{}shopUserMobilePhone>,&lt;{}callbackURL>,&lt;{}recurrent>,&lt;{}payInstrTokenAlg>,&lt;{}billingID>,&lt;{}recurrentIndicator>,&lt;{}level3Info>,&lt;{}mandateInfo>,&lt;{}termInfo>,&lt;{}validityExpire>,&lt;{}addInfo5>,&lt;{}trType>,&lt;{}txIndicatorType>,&lt;{}notifyURL>,&lt;{}addInfo3>,&lt;{}shopID>,&lt;{}addInfo4>,&lt;{}payInstrTokenUsageLimit>,&lt;{}addInfo1>,&lt;{}addInfo2>,&lt;{}keepOnRegenPayInstrToken>,&lt;{}minExpireMonth>,&lt;{}payInstrAddData>,&lt;{}signature>,&lt;{}accountName>,&lt;{}shopUserRef>,&lt;{}description>,&lt;{}reqTime>,&lt;{}firstTopUp>,&lt;{}payInstrTokenExpire>,&lt;{}paymentReason>,&lt;{}payInstr>,&lt;{}shopUserIMEI>,&lt;{}merID>,&lt;{}langID>,&lt;{}payInstrToken>,&lt;{}payInstrTokenAsTopUpID>,&lt;{}amount>,&lt;{}topUpID>,&lt;{}regenPayInstrToken>,&lt;{}errorURL>,&lt;{}freeText>,&lt;{}shopUserAccount>,&lt;{}currencyCode>,&lt;{}shopUserName> </faultstring>
        </soap:Fault>
    </soap:Body>
</soap:Envelope>
EOT;
        $unserializer = new Response\Unserializer();
        $this->isGoingToThrowException(InvalidXml::class);
        $unserializer->unserialize($xml);
    }

    public function testUnserializingErrorResponse()
    {
        $xml = <<<'EOT'
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
    <soap:Body>
        <ns1:InitResponse xmlns:ns1="http://services.api.web.cg.igfs.apps.netsw.it/">
            <response>
                <tid>MyTerminal&lt;Code&gt;</tid>
                <rc>IGFS_20022</rc>
                <error>true</error>
                <errorDesc>CAMPO SIGNATURE NON VALIDO</errorDesc>
                <signature/>
                <shopID>Order123</shopID>
            </response>
        </ns1:InitResponse>
    </soap:Body>
</soap:Envelope>
EOT;
        $unserializer = new Response\Unserializer();
        $response = $unserializer->unserialize($xml);
        $this->assertSame('MyTerminal<Code>', $response->getTid());
        $this->assertSame('', $response->getPayInstr());
        $this->assertSame(null, $response->getReqTime());
        $this->assertSame('IGFS_20022', $response->getRc());
        $this->assertSame(true, $response->isError());
        $this->assertSame('CAMPO SIGNATURE NON VALIDO', $response->getErrorDesc());
        $this->assertSame('', $response->getSignature());
        $this->assertSame('Order123', $response->getShopID());
        $this->assertSame('', $response->getPaymentID());
        $this->assertSame('', $response->getRedirectURL());
        $json = [
            'tid' => 'MyTerminal<Code>',
            'rc' => 'IGFS_20022',
            'error' => true,
            'errorDesc' => 'CAMPO SIGNATURE NON VALIDO',
            'shopID' => 'Order123',
        ];
        $this->assertSame($json, $response->jsonSerialize());
    }

    public function testUnserializingGoodResponse()
    {
        $unserializer = new Response\Unserializer();
        $response = $unserializer->unserialize($this->getGoodResponseXML());
        $this->assertSame($this->getGoodResponseJSON(), $response->jsonSerialize());
    }

    private function getGoodResponseXML()
    {
        return <<<'EOT'
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
    <soap:Body>
        <ns1:InitResponse xmlns:ns1="http://services.api.web.cg.igfs.apps.netsw.it/">
            <response xmlns:ns2="http://services.api.web.cg.igfs.apps.netsw.it/">
                <tid>TEST_SELECTOR</tid>
                <rc>IGFS_000</rc>
                <error>false</error>
                <errorDesc></errorDesc>
                <signature>sORxvFHSWoq/IQEematagsaULZ0tbdviIXQbJNnkChQ=</signature>
                <shopID>1701061569</shopID>
                <paymentID>344517213104948134</paymentID>
                <redirectURL>https://IPGATEWAY/IPS_CG_WEB/app/main/show?referenceData=5CA44411481B07D1</redirectURL>
            </response>
        </ns1:InitResponse>
    </soap:Body>
</soap:Envelope>
EOT;
    }

    private function getGoodResponseJSON()
    {
        return [
            'tid' => 'TEST_SELECTOR',
            'rc' => 'IGFS_000',
            'error' => false,
            'signature' => 'sORxvFHSWoq/IQEematagsaULZ0tbdviIXQbJNnkChQ=',
            'shopID' => '1701061569',
            'paymentID' => '344517213104948134',
            'redirectURL' => 'https://IPGATEWAY/IPS_CG_WEB/app/main/show?referenceData=5CA44411481B07D1',
        ];
    }
}
