<?php

namespace MLocati\PayWay\Test\Service;

class StringableObject
{
    /**
     * @var string
     */
    private $value;

    /**
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    #[\ReturnTypeWillChange]
    public function __toString()
    {
        return $this->value;
    }
}
