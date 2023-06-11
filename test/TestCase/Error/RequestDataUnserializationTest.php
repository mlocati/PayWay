<?php

namespace MLocati\PayWay\Test\TestCase\Error;

use MLocati\PayWay\Error\RequestData;
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
                ['rc' => ''],
                [],
            ],
            [
                ['rc' => 'RC CODE'],
                ['rc' => 'RC CODE'],
            ],
            [
                ['rc' => 'RC CODE', 'something_else' => "I don't know you"],
                ['rc' => 'RC CODE', '_unrecognizedData' => ['something_else' => "I don't know you"]],
            ],
            [
                ['tid' => ['whoops']],
                ['_unrecognizedData' => ['tid' => ['whoops']]],
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
