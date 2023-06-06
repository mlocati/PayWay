<?php

namespace MLocati\PayWay\Exception;

use MLocati\PayWay\Exception;

class MissingRequiredField extends Exception
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
        parent::__construct("Missing required field: {$this->fieldName}");
    }

    /**
     * @return string
     */
    public function getFieldName()
    {
        return $this->fieldName;
    }
}
