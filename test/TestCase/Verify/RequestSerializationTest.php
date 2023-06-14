<?php

namespace MLocati\PayWay\Test\TestCase\Verify;

use MLocati\PayWay\Test\Service\TestCase;
use MLocati\PayWay\Verify\Request;

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
     * @return \MLocati\PayWay\Verify\Request
     */
    private function createRequest()
    {
        $request = new Request();

        $request
            ->setTID('TEST_SELECTOR')
            ->setShopID('1701061569')
            ->setPaymentID('344517213104948134')
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
    <ser:Verify xmlns:ser="http://services.api.web.cg.igfs.apps.netsw.it/">
      <request>
        <apiVersion>2.4.1</apiVersion>
        <tid>TEST_SELECTOR</tid>
        <signature>xcsSKs20XhPUARin3nonxBI6h8haYuNN8Cdcl0PKRvw=</signature>
        <shopID>1701061569</shopID>
        <paymentID>344517213104948134</paymentID>
      </request>
    </ser:Verify>
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
            'paymentID' => '344517213104948134',
        ];
    }
}
