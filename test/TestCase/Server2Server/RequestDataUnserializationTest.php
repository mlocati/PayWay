<?php

namespace MLocati\PayWay\Test\TestCase\Server2Server;

use MLocati\PayWay\Server2Server\RequestData;
use MLocati\PayWay\Test\Service\TestCase;

class RequestDataUnserializationTest extends TestCase
{
    public static function provideTestCases()
    {
        return [
            [
                [],
                [],
            ],
            [
                ['tid' => 't ID', 'paymentID' => 'pay ID', 'shopID' => 'shop ID', 'tranID' => 'transaction ID', 'trType' => 'tr Type', 'signature' => 'Sign!'],
                ['tid' => 't ID', 'paymentID' => 'pay ID', 'shopID' => 'shop ID', 'tranID' => 'transaction ID', 'trType' => 'tr Type', 'signature' => 'Sign!'],
            ],
            [
                ['tid' => 't ID', 'something_else' => "I don't know you"],
                ['tid' => 't ID', '_unrecognizedData' => ['something_else' => "I don't know you"]],
            ],
            [
                ['tid' => ['whoops'], 'paymentID' => 'pay ID'],
                ['paymentID' => 'pay ID', '_unrecognizedData' => ['tid' => ['whoops']]],
            ],
        ];
    }

    /**
     * @dataProvider provideTestCases
     */
    public function testUnserializingRequest(array $inputData, array $expectedJson)
    {
        $request = new RequestData($inputData);
        $this->assertSame($expectedJson, $request->jsonSerialize());
    }
}
