<?php

namespace MLocati\PayWay\Service;

use DateTime;
use DateTimeInterface;
use MLocati\PayWay\Exception;
use ValueError;

trait BaseRequestTrait
{
    use JsonCleanupTrait;

    /**
     * Undocumented.
     *
     * @var string
     */
    private $apiVersion = '2.4.1';

    /**
     * The merchant terminal code.
     *
     * @var string
     */
    private $tid = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $merID = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $payInstr = '';

    /**
     * @var \DateTimeInterface|null
     */
    private $reqTime;

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setApiVersion($value)
    {
        $this->apiVersion = (string) $value;

        return $this;
    }

    /**
     * Get the merchant terminal code.
     *
     * @return string
     */
    public function getTID()
    {
        return $this->tid;
    }

    /**
     * Set the merchant terminal code.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setTID($value)
    {
        $this->tid = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getMerID()
    {
        return $this->merID;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setMerID($value)
    {
        $this->merID = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getPayInstr()
    {
        return $this->payInstr;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setPayInstr($value)
    {
        $this->payInstr = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return \DateTimeInterface|null
     */
    public function getReqTime()
    {
        return $this->reqTime;
    }

    /**
     * Undocumented.
     *
     * @return $this
     */
    public function setReqTime(DateTimeInterface $value = null)
    {
        $this->reqTime = $value;

        return $this;
    }

    /**
     * Get the HMAC-SHA256 signature.
     *
     * @param string $key
     *
     * @throws \MLocati\PayWay\Exception\UnableToCreateSignature
     *
     * @return string
     */
    public function getSignature($key)
    {
        $data = implode('', $this->getSignatureFields());
        try {
            $rawSignature = hash_hmac('sha256', $data, $key, true);
        } catch (ValueError $x) {
            throw new Exception\UnableToCreateSignature($x->getMessage());
        }
        if ($rawSignature === false) {
            throw new Exception\UnableToCreateSignature();
        }

        return base64_encode($rawSignature);
    }

    /**
     * {@inheritdoc}
     *
     * @see \JsonSerializable::jsonSerialize()
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->cleanupJson([
            'apiVersion' => $this->apiVersion,
            'tid' => $this->tid,
            'merID' => $this->merID,
            'payInstr' => $this->payInstr,
            'reqTime' => $this->reqTime === null ? '' : $this->reqTime->format(DateTime::RFC3339),
        ]);
    }

    /**
     * @return string[]
     *
     * @private
     */
    abstract protected function getSignatureFields();

    /**
     * @throws \MLocati\PayWay\Exception\MissingRequiredField
     * @throws \MLocati\PayWay\Exception\FieldValueTooLong
     * @throws \MLocati\PayWay\Exception\FieldValueOutOfRange
     * @throws \MLocati\PayWay\Exception\InvalidFieldUrl
     */
    private function checkBaseRequest()
    {
        $this->checkStringField('tid', true, 16);
    }

    /**
     * @param string $fieldName
     * @param bool $required
     * @param int $maxLength
     *
     * @throws \MLocati\PayWay\Exception\MissingRequiredField
     * @throws \MLocati\PayWay\Exception\FieldValueTooLong
     */
    private function checkStringField($fieldName, $required, $maxLength)
    {
        $value = $this->{$fieldName};
        if ($value === '') {
            if ($required) {
                throw new Exception\MissingRequiredField($fieldName);
            }
        } elseif (strlen($value) > $maxLength) {
            throw new Exception\FieldValueTooLong($fieldName, $maxLength);
        }
    }

    /**
     * @param string $fieldName
     * @param bool $required
     * @param string[] $allowedValues
     *
     * @throws \MLocati\PayWay\Exception\MissingRequiredField
     * @throws \MLocati\PayWay\Exception\FieldValueOutOfRange
     */
    private function checkEnumField($fieldName, $required, array $allowedValues)
    {
        $value = $this->{$fieldName};
        if ($value === '') {
            if ($required) {
                throw new Exception\MissingRequiredField($fieldName);
            }
        } elseif (!in_array($value, $allowedValues, true)) {
            throw new Exception\FieldValueOutOfRange($fieldName, $allowedValues);
        }
    }

    /**
     * @param string $fieldName
     * @param bool $required
     * @param int $maxLength
     *
     * @throws \MLocati\PayWay\Exception\MissingRequiredField
     * @throws \MLocati\PayWay\Exception\FieldValueTooLong
     * @throws \MLocati\PayWay\Exception\InvalidFieldUrl
     */
    private function checkUrlField($fieldName, $required, $maxLength)
    {
        $value = $this->{$fieldName};
        if ($value === '') {
            if ($required) {
                throw new Exception\MissingRequiredField($fieldName);
            }
        } elseif (strlen($value) > $maxLength) {
            throw new Exception\FieldValueTooLong($fieldName, $maxLength);
        } elseif (!filter_var($value, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
            throw new Exception\InvalidFieldUrl($fieldName);
        }
    }
}
