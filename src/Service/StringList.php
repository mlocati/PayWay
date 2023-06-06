<?php

namespace MLocati\PayWay\Service;

use RuntimeException;

abstract class StringList
{
    /**
     * @var string[]|null
     */
    protected static $list;

    /**
     * @return array
     */
    public static function getList()
    {
        if (static::$list === null) {
            $list = include __DIR__ . '/../data/' . static::getListFile();
            if (!is_array($list)) {
                throw new RuntimeException('Failed to retrieve the list');
            }
            static::$list = $list;
        }

        return static::$list;
    }

    /**
     * @param string|mixed $code
     *
     * @return bool
     */
    public static function isValid($code)
    {
        return in_array($code, static::getList(), true);
    }
}
