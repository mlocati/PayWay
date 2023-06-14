<?php

namespace MLocati\PayWay\Exception;

use MLocati\PayWay\Exception;

class InvalidSignature extends Exception
{
    /**
     * @var string
     */
    private $expectedSignature;

    /**
     * @var string
     */
    private $actualSignature;

    /**
     * @param string $expectedSignature
     * @param string $actualSignature
     */
    public function __construct($expectedSignature, $actualSignature)
    {
        $this->expectedSignature = (string) $expectedSignature;
        $this->actualSignature = (string) $actualSignature;
        parent::__construct("The signature of the response is not valid (expected: '{$this->expectedSignature}', actual: '{$this->actualSignature}')");
    }

    /**
     * @return string
     */
    public function getExpectedSignature()
    {
        return $this->expectedSignature;
    }

    /**
     * @return string
     */
    public function getActualSignature()
    {
        return $this->actualSignature;
    }
}
