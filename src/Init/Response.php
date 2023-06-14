<?php

namespace MLocati\PayWay\Init;

use JsonSerializable;
use MLocati\PayWay\Service\BasePaymentInitResponseTrait;

class Response implements JsonSerializable
{
    use BasePaymentInitResponseTrait {
        jsonSerialize as jsonSerializeBasePaymentInitResponse;
    }

    /**
     * @var string
     */
    protected $paymentID = '';

    /**
     * @var string
     */
    protected $redirectURL = '';

    /**
     * @return string
     */
    public function getPaymentID()
    {
        return $this->paymentID;
    }

    /**
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
     * @return string
     */
    public function getRedirectURL()
    {
        return $this->redirectURL;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setRedirectURL($value)
    {
        $this->redirectURL = (string) $value;

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
        return $this->jsonSerializeBasePaymentInitResponse() + $this->cleanupJson([
            'paymentID' => $this->paymentID,
            'redirectURL' => $this->redirectURL,
        ]);
    }

    /**
     * {@inheritdoc}
     *
     * see \MLocati\PayWay\Service\BaseResponseTrait::getSignatureFields()
     */
    protected function getSignatureFields()
    {
        return [
            $this->tid,
            $this->shopID,
            $this->rc,
            $this->errorDesc,
            $this->paymentID,
            $this->redirectURL,
        ];
    }
}
