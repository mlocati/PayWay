<?php

namespace MLocati\PayWay\Service;

use RuntimeException;

abstract class Dictionary
{
    /**
     * @return array
     */
    public static function getDictionary()
    {
        if (static::$dictionary === null) {
            $dictionary = include __DIR__ . '/../data/' . static::getDictionaryFile();
            if (!is_array($dictionary)) {
                throw new RuntimeException('Failed to retrieve the dictionary');
            }
            static::$dictionary = $dictionary;
        }

        return static::$dictionary;
    }

    /**
     * @param string|mixed $code
     *
     * @return string Empty string if $code is not valid
     */
    public static function getName($code)
    {
        if (!is_string($code) || $code === '') {
            return '';
        }
        $dictionary = static::getDictionary();

        return isset($dictionary[$code]) ? $dictionary[$code] : '';
    }

    /**
     * @param string|mixed $code
     *
     * @return bool
     */
    public static function isCodeValid($code)
    {
        return static::getName($code) !== '';
    }

    /**
     * @return string[]
     */
    public static function getAvailableCodes()
    {
        return array_keys(static::getDictionary());
    }
}
