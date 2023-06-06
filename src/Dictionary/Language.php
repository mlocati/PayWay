<?php

namespace MLocati\PayWay\Dictionary;

use MLocati\PayWay\Service\Dictionary;

class Language extends Dictionary
{
    const CODE_ITALIAN = 'IT';

    /**
     * @var array|null
     */
    protected static $dictionary;

    protected static function getDictionaryFile()
    {
        return 'languages.php';
    }
}
