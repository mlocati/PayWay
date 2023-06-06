<?php

namespace MLocati\PayWay\Exception;

use MLocati\PayWay\Exception;

class NetworkUnavailable extends Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
