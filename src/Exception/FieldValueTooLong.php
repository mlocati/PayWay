<?php

namespace MLocati\PayWay\Exception;

use MLocati\PayWay\Exception;

class FieldValueTooLong extends Exception
{
    /**
     * @var string
     */
    private $fieldName;

    /**
     * @var int
     */
    private $maxLength;

    /**
     * @param string $fieldName
     */
    public function __construct($fieldName, $maxLength)
    {
        $this->fieldName = (string) $fieldName;
        $this->maxLength = (int) $maxLength;
        parent::__construct("The value of the field {$this->fieldName} is too long (max: {$this->maxLength} characters)");
    }

    /**
     * @return string
     */
    public function getFieldName()
    {
        return $this->fieldName;
    }

    /**
     * @return int
     */
    public function getMaxLength()
    {
        return $this->maxLength;
    }
}
