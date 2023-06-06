<?php

namespace MLocati\PayWay\Exception;

use MLocati\PayWay\Exception;

class InvalidXml extends Exception
{
    /**
     * @var string
     */
    private $raw;

    /**
     * @param string $raw
     * @param string $details
     */
    public function __construct($raw, $details = '')
    {
        $this->raw = (string) $raw;
        $message = trim((string) $details);
        if ($message === '') {
            $message = 'The XML is not valid';
        }
        parent::__construct($message);
    }

    /**
     * @return string
     */
    public function getRaw()
    {
        return $this->raw;
    }

}
