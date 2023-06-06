<?php

namespace MLocati\PayWay\Exception;

use MLocati\PayWay\Exception;

class InvalidValue extends Exception
{
    /**
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
