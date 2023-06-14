<?php

namespace MLocati\PayWay\Test\TestCase\Init;

use MLocati\PayWay\Dictionary;
use MLocati\PayWay\Init\Request;
use MLocati\PayWay\Service;
use MLocati\PayWay\Test\Service\TestCase;

class RequestSerializationTest extends TestCase
{
    public function testSerialization()
    {
        $request = $this->createRequest();
        $serializer = new Request\Serializer();
        $serializedDoc = $serializer->createDocument($request, 'ondkmctaf9/MI3I5AZ4LskbmRiw=');
        $serializedDoc->preserveWhiteSpace = true;
        $serializedDoc->formatOutput = true;
        $actualXml = $serializedDoc->saveXML();
        $this->assertSame($this->getExpectedXML(), $actualXml);
        $this->assertSame($this->getExpectedJSON(), $request->jsonSerialize());
    }

    /**
     * @return \MLocati\PayWay\Init\Request
     */
    private function createRequest()
    {
        $request = new Request();

        $request
            ->setTID('TEST_SELECTOR')
            ->setShopID('1701061569')
            ->setShopUserRef('cliente@email.it')
            ->setTrType(Dictionary\TrType::CODE_AUTH)
            ->setAmountAsFloat(1)
            ->setCurrencyCode(Dictionary\Currency::CODE_EUR)
            ->setLangID(Dictionary\Language::CODE_ITALIAN)
            ->setNotifyURL('http://merchant/notify.jsp')
            ->setErrorURL('http://merchant/show.jsp')
            ->setDescription('Descrizione per transazione -1701061569')
        ;
        $request->getLevel3Info()
            ->setDestinationName('Nome Destinatario')
            ->setDestinationStreet('Indirizzo')
            ->setDestinationCity('Citta')
            ->setDestinationState('Provincia')
            ->setDestinationPostalCode('20100')
            ->setDestinationCountryCode(Dictionary\Country::CODE_ITALY)
            ->setFreightAmountAsFloat(0.10)
            ->setTaxAmountAsFloat(0.1)
        ;
        $request->getLevel3Info()->addProduct($product = new Service\Level3Info\Product());
        $product
            ->setProductCode('ProductCode1')
            ->setProductDescription('ProductDescription1')
            ->setItems(2)
            ->setAmountAsFloat(.10)
        ;
        $request->getLevel3Info()->addProduct($product = new Service\Level3Info\Product());
        $product
            ->setProductCode('ProductCode2')
            ->setProductDescription('ProductDescription2')
            ->setItems(2)
            ->setAmountAsCents(10)
        ;
        $request->getLevel3Info()->addProduct($product = new Service\Level3Info\Product());
        $product
            ->setProductCode('ProductCode3')
            ->setProductDescription('ProductDescription3')
            ->setItems(2)
            ->setAmountAsCents(10)
        ;

        $request->getLevel3Info()->addProduct($product = new Service\Level3Info\Product());
        $product
            ->setProductCode('ProductCode4')
            ->setProductDescription('ProductDescription4')
            ->setItems(2)
            ->setAmountAsCents(10)
        ;

        return $request;
    }

    /**
     * @return string
     */
    private function getExpectedXML()
    {
        return str_replace(
            "\r\n",
            "\n",
            <<<'EOT'
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
  <soapenv:Body>
    <ser:Init xmlns:ser="http://services.api.web.cg.igfs.apps.netsw.it/">
      <request>
        <apiVersion>2.4.1</apiVersion>
        <tid>TEST_SELECTOR</tid>
        <signature>WRDepk9x3vsKVFpqDDIvvKLMYxGzyKnSqXpTj0yHnYo=</signature>
        <shopID>1701061569</shopID>
        <shopUserRef>cliente@email.it</shopUserRef>
        <trType>AUTH</trType>
        <amount>100</amount>
        <currencyCode>EUR</currencyCode>
        <langID>IT</langID>
        <notifyURL>http://merchant/notify.jsp</notifyURL>
        <errorURL>http://merchant/show.jsp</errorURL>
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
        <description>Descrizione per transazione -1701061569</description>
      </request>
    </ser:Init>
  </soapenv:Body>
</soapenv:Envelope>

EOT
        );
    }

    private function getExpectedJSON()
    {
        return [
            'apiVersion' => '2.4.1',
            'tid' => 'TEST_SELECTOR',
            'shopID' => '1701061569',
            'shopUserRef' => 'cliente@email.it',
            'trType' => 'AUTH',
            'amount' => 100,
            'currencyCode' => 'EUR',
            'langID' => 'IT',
            'notifyURL' => 'http://merchant/notify.jsp',
            'errorURL' => 'http://merchant/show.jsp',
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
            'description' => 'Descrizione per transazione -1701061569',
        ];
    }
}
