<?php

namespace MLocati\PayWay\Exception;

use MLocati\PayWay\Exception;

class UnableToCreateSignature extends Exception
{
    public function __construct($reason = '')
    {
        $message = 'Unable to create a signature';
        $reason = (string) $reason;
        if ($reason !== '') {
            $message .= ': ' . $reason;
        }
        parent::__construct($message);
    }
}
