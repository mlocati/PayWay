<?php

namespace MLocati\PayWay\Service;

trait BasePaymentInitResponseTrait
{
    use BaseResponseTrait {
        jsonSerialize as jsonSerializeBaseResponse;
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
        return $this->jsonSerializeBaseResponse() + $this->cleanupJson([
            'shopID' => $this->shopID,
        ]);
    }
}
