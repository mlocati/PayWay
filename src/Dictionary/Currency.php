<?php

namespace MLocati\PayWay\Dictionary;

use MLocati\PayWay\Service\Dictionary;

class Currency extends Dictionary
{
    const CODE_EUR = 'EUR';

    /**
     * @var array|null
     */
    protected static $dictionary;

    protected static function getDictionaryFile()
    {
        return 'currencies.php';
    }
}
