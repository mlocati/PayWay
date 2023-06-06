<?php

namespace MLocati\PayWay\Service;

trait BasePaymentInitRequestTrait
{
    use BaseRequestTrait {
        jsonSerialize as jsonSerializeBaseRequest;
    }

    /**
     * The unique identifier, on the merchant side, of the transaction request.
     * The value can be chosen as desired by the person making the call.
     * Important: don't use the same value more than once.
     *
     * @var string
     */
    private $shopID = '';

    /**
     * Get the unique identifier, on the merchant side, of the transaction request.
     * The value can be chosen as desired by the person making the call.
     * Important: don't use the same value more than once.
     *
     * @return string
     */
    public function getShopID()
    {
        return $this->shopID;
    }

    /**
     * Set the unique identifier, on the merchant side, of the transaction request.
     * The value can be chosen as desired by the person making the call.
     * Important: don't use the same value more than once.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setShopID($value)
    {
        $this->shopID = (string) $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see \JsonSerializable::jsonSerialize()
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->jsonSerializeBaseRequest() + $this->cleanupJson([
            'shopID' => $this->shopID,
        ]);
    }

    /**
     * @throws \MLocati\PayWay\Exception\MissingRequiredField
     * @throws \MLocati\PayWay\Exception\FieldValueTooLong
     * @throws \MLocati\PayWay\Exception\FieldValueOutOfRange
     * @throws \MLocati\PayWay\Exception\InvalidFieldUrl
     */
    private function checkBasePaymentInitRequest()
    {
        $this->checkBaseRequest();
        $this->checkStringField('shopID', true, 256);
    }
}
