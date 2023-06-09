<?php

namespace MLocati\PayWay\Test\TestCase\Dictionary;

use MLocati\PayWay\Dictionary\Country;
use MLocati\PayWay\Test\Service\TestCase;

class CountryTest extends TestCase
{
    public static function provideIso2AndIso3Codes()
    {
        return [
            [null, ''],
            [123, ''],
            [[], ''],
            ['???', ''],
            ['IT', 'ITA'],
        ];
    }

    /**
     * @dataProvider provideIso2AndIso3Codes
     */
    public function testWrongUrl($iso2, $expectedIso3)
    {
        $actualIso3 = Country::getCodeFromIso2($iso2);
        $this->assertSame($expectedIso3, $actualIso3);
    }
}
