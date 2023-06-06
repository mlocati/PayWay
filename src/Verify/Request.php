<?php

namespace MLocati\PayWay\Verify;

use JsonSerializable;
use MLocati\PayWay\Service\BasePaymentInitRequestTrait;

class Request implements JsonSerializable
{
    use BasePaymentInitRequestTrait {
        jsonSerialize as jsonSerializeBasePaymentInitRequest;
    }

    /**
     * The payment ID code associated with the request.
     *
     * @var string
     */
    private $paymentID = '';

    /**
     * Undocumented.
     *
     * @var int|null
     */
    private $refTranID;

    /**
     * Get the payment ID code associated with the request.
     *
     * @return string
     */
    public function getPaymentID()
    {
        return $this->paymentID;
    }

    /**
     * Set the payment ID code associated with the request.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setPaymentID($value)
    {
        $this->paymentID = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return int|null
     */
    public function getRefTranID()
    {
        return $this->refTranID;
    }

    /**
     * Undocumented.
     *
     * @param int|null $value
     *
     * @return $this
     */
    public function setRefTranID($value)
    {
        $this->refTranID = $value === null || $value === '' ? null : (int) $value;

        return $this;
    }

    /**
     * @throws \MLocati\PayWay\Exception\MissingRequiredField
     * @throws \MLocati\PayWay\Exception\FieldValueTooLong
     * @throws \MLocati\PayWay\Exception\FieldValueOutOfRange
     * @throws \MLocati\PayWay\Exception\InvalidFieldUrl
     */
    public function check()
    {
        $this->checkBasePaymentInitRequest();
        $this->checkStringField('paymentID', true, 32);
    }

    /**
     * {@inheritdoc}
     *
     * @see \JsonSerializable::jsonSerialize()
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->jsonSerializeBasePaymentInitRequest() + $this->cleanupJson([
            'paymentID' => $this->paymentID,
            'refTranID' => $this->refTranID,
        ]);
    }

    protected function getSignatureFields()
    {
        return [
            $this->tid,
            $this->shopID,
            $this->paymentID,
        ];
    }
}
