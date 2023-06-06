<?php

namespace MLocati\PayWay\Dictionary;

use MLocati\PayWay\Service\Dictionary;

class Country extends Dictionary
{
    const CODE_ITALY = 'ITA';

    /**
     * @var array|null
     */
    protected static $dictionary;

    protected static function getDictionaryFile()
    {
        return 'countries.php';
    }
}
