<?php

namespace MLocati\PayWay\Exception;

use MLocati\PayWay\Exception;

class FieldValueOutOfRange extends Exception
{
    /**
     * @var string
     */
    private $fieldName;

    /**
     * @var string[]
     */
    private $allowedValues;

    /**
     * @param string $fieldName
     * @param string[] $allowedValues
     */
    public function __construct($fieldName, array $allowedValues)
    {
        $this->fieldName = (string) $fieldName;
        $this->allowedValues = $allowedValues;
        parent::__construct("The field {$this->fieldName} contains an invalid value (allowed values are '" . implode("', '", $this->allowedValues) . "')");
    }

    /**
     * @return string
     */
    public function getFieldName()
    {
        return $this->fieldName;
    }

    /**
     * @return string[]
     */
    public function getAllowedValues()
    {
        return $this->allowedValues;
    }
}
