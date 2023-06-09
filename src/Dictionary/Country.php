<?php

namespace MLocati\PayWay\Dictionary;

use MLocati\PayWay\Service\Dictionary;
use RuntimeException;

class Country extends Dictionary
{
    const CODE_ITALY = 'ITA';

    /**
     * @var array|null
     */
    protected static $dictionary;

    /**
     * @var array|null
     */
    private static $codesFromIso3;

    /**
     * Get the ISO 3166-1 alpha-3 code to be used by PayWay starting from an ISO 3166-1 alpha-2 code.
     *
     * @param string|mixed $iso2
     *
     * @return string Empty string if $iso2 is invalid or can't be decoded
     *
     * @example returns 'ITA' from 'IT'
     */
    public static function getCodeFromIso2($iso2)
    {
        if (!is_string($iso2) || $iso2 === '') {
            return '';
        }
        $map = static::getCodesFromIso3();

        return isset($map[$iso2]) ? $map[$iso2] : '';
    }

    protected static function getDictionaryFile()
    {
        return 'country_names.php';
    }

    protected static function getCodesFromIso3()
    {
        if (self::$codesFromIso3 === null) {
            $codesFromIso3 = include static::getDataDir() . 'country_iso2.php';
            if (!is_array($codesFromIso3)) {
                throw new RuntimeException('Failed to retrieve the dictionary');
            }
            self::$codesFromIso3 = $codesFromIso3;
        }

        return self::$codesFromIso3;
    }
}
