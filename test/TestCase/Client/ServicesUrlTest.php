<?php

namespace MLocati\PayWay\Test\TestCase\Client;

use MLocati\PayWay\Client as PayWayClient;
use MLocati\PayWay\Test\Service\StringableObject;
use MLocati\PayWay\Test\Service\TestCase;

class ServicesUrlTest extends TestCase
{
    public static function provideUrls()
    {
        return [
            [null, ''],
            [[], ''],
            ['???', ''],
            ['test.domain.com', ''],
            ['//test.domain.com', ''],
            ['://test.domain.com', ''],
            ['https://test.domain.com', ''],
            ['test.domain.com/path', ''],
            ['//test.domain.com/path', ''],
            ['://test.domain.com/path', ''],
            ['https://test.domain.com/path#hash', ''],
            ['https://test.domain.com/path?qs', ''],
            ['https://test.domain.com/path', 'https://test.domain.com/path/'],
            ['https://test.domain.com/path/', 'https://test.domain.com/path/'],
            [new StringableObject('https://test.domain.com/path/'), 'https://test.domain.com/path/'],
        ];
    }

    /**
     * @dataProvider provideUrls
     */
    public function testWrongUrl($provided, $expected)
    {
        $actual = PayWayClient::normalizeServicesUrl($provided);
        $this->assertSame($expected, $actual);
    }
}
