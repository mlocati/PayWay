<?php

namespace MLocati\PayWay\Service;

use JsonSerializable;

class TermInfo implements JsonSerializable
{
    use JsonCleanupTrait;

    /**
     * Undocumented.
     *
     * @var string
     */
    private $tid = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $payInstrToken = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $billingID = '';

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getTid()
    {
        return $this->tid;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setTid($value)
    {
        $this->tid = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getPayInstrToken()
    {
        return $this->payInstrToken;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setPayInstrToken($value)
    {
        $this->payInstrToken = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getBillingID()
    {
        return $this->billingID;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setBillingID($value)
    {
        $this->billingID = (string) $value;

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
        return $this->cleanupJson([
            'tid' => $this->tid,
            'payInstrToken' => $this->payInstrToken,
            'billingID' => $this->billingID,
        ]);
    }
}
