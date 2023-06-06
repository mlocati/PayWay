<?php

namespace MLocati\PayWay\Test\TestCase\Verify;

use MLocati\PayWay\Exception\InvalidXml;
use MLocati\PayWay\Test\Service\TestCase;
use MLocati\PayWay\Verify\Response;

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
        <ns1:VerifyResponse xmlns:ns1="http://services.api.web.cg.igfs.apps.netsw.it/">
            <response>
                <tid>MyTerminal&lt;Code&gt;</tid>
                <rc>IGFS_20022</rc>
                <error>true</error>
                <errorDesc>CAMPO SIGNATURE NON VALIDO</errorDesc>
                <signature/>
                <shopID>Order123</shopID>
            </response>
        </ns1:VerifyResponse>
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
        <ns1:VerifyResponse xmlns:ns1="http://services.api.web.cg.igfs.apps.netsw.it/">
            <response xmlns:ns2="http://services.api.web.cg.igfs.apps.netsw.it/">
                <tid>TEST_ECOM</tid>
                <payInstr>CC</payInstr>
                <rc>IGFS_000</rc>
                <error>false</error>
                <errorDesc>TRANSAZIONE OK</errorDesc>
                <signature>Ois3yADPsyWTuHf/zgBc4WQd7ZvziIDavp2K1XLpBkI=</signature>
                <shopID>1701061569</shopID>
                <paymentID>344517213104948134</paymentID>
                <tranID>3066511440512679</tranID>
                <authCode>24973</authCode>
                <enrStatus>Y</enrStatus>
                <authStatus>Y</authStatus>
                <brand>VISA</brand>
                <maskedPan>401200******1112</maskedPan>
                <payInstrToken>548051F6AE29013134AA3DF3E7CE6FC5</payInstrToken>
                <expireMonth>12</expireMonth>
                <expireYear>2099</expireYear>
                <level3Info>
                    <destinationName>Nome Destinatario</destinationName>
                    <destinationStreet>Indirizzo</destinationStreet>
                    <destinationCity>Citta</destinationCity>
                    <destinationState>Provincia</destinationState>
                    <destinationPostalCode>20100</destinationPostalCode>
                    <destinationCountryCode>ITA</destinationCountryCode>
                    <freightAmount>10</freightAmount>
                    <taxAmount>10</taxAmount>
                    <product>
                        <productCode>ProductCode1</productCode>
                        <productDescription>ProductDescription1</productDescription>
                        <items>2</items>
                        <amount>10</amount>
                    </product>
                    <product>
                        <productCode>ProductCode2</productCode>
                        <productDescription>ProductDescription2</productDescription>
                        <items>2</items>
                        <amount>10</amount>
                    </product>
                    <product>
                        <productCode>ProductCode3</productCode>
                        <productDescription>ProductDescription3</productDescription>
                        <items>2</items>
                        <amount>10</amount>
                    </product>
                    <product>
                        <productCode>ProductCode4</productCode>
                        <productDescription>ProductDescription4</productDescription>
                        <items>2</items>
                        <amount>10</amount>
                    </product>
                </level3Info>
            </response>
        </ns1:VerifyResponse>
    </soap:Body>
</soap:Envelope>
EOT;
    }

    private function getGoodResponseJSON()
    {
        return [
            'tid' => 'TEST_ECOM',
            'payInstr' => 'CC',
            'rc' => 'IGFS_000',
            'error' => false,
            'errorDesc' => 'TRANSAZIONE OK',
            'signature' => 'Ois3yADPsyWTuHf/zgBc4WQd7ZvziIDavp2K1XLpBkI=',
            'shopID' => '1701061569',
            'paymentID' => '344517213104948134',
            'tranID' => 3066511440512679,
            'authCode' => '24973',
            'enrStatus' => 'Y',
            'authStatus' => 'Y',
            'brand' => 'VISA',
            'maskedPan' => '401200******1112',
            'payInstrToken' => '548051F6AE29013134AA3DF3E7CE6FC5',
            'expireMonth' => 12,
            'expireYear' => 2099,
            'level3Info' => [
                'destinationName' => 'Nome Destinatario',
                'destinationStreet' => 'Indirizzo',
                'destinationCity' => 'Citta',
                'destinationState' => 'Provincia',
                'destinationPostalCode' => '20100',
                'destinationCountryCode' => 'ITA',
                'freightAmount' => 10,
                'taxAmount' => 10,
                'product' => [
                    [
                        'productCode' => 'ProductCode1',
                        'productDescription' => 'ProductDescription1',
                        'items' => 2,
                        'amount' => 10,
                    ],
                    [
                        'productCode' => 'ProductCode2',
                        'productDescription' => 'ProductDescription2',
                        'items' => 2,
                        'amount' => 10,
                    ],
                    [
                        'productCode' => 'ProductCode3',
                        'productDescription' => 'ProductDescription3',
                        'items' => 2,
                        'amount' => 10,
                    ],
                    [
                        'productCode' => 'ProductCode4',
                        'productDescription' => 'ProductDescription4',
                        'items' => 2,
                        'amount' => 10,
                    ],
                ],
            ],
        ];
    }
}
