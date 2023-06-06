<?php

namespace MLocati\PayWay\Exception;

use MLocati\PayWay\Exception;

class InvalidFieldUrl extends Exception
{
    /**
     * @var string
     */
    private $fieldName;

    /**
     * @param string $fieldName
     */
    public function __construct($fieldName)
    {
        $this->fieldName = (string) $fieldName;
        parent::__construct("The value of the field {$this->fieldName} is not a valid URL");
    }

    /**
     * @return string
     */
    public function getFieldName()
    {
        return $this->fieldName;
    }
}
