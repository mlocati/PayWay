<?php

namespace MLocati\PayWay\Server2Server;

use JsonSerializable;
use MLocati\PayWay\Service\JsonCleanupTrait;

class RequestData implements JsonSerializable
{
    use JsonCleanupTrait;

    /**
     * @var string
     */
    private $tid;

    /**
     * @var string
     */
    private $paymentID;

    /**
     * @var string
     */
    private $shopID;

    /**
     * @var string
     */
    private $tranID;

    /**
     * @var string
     */
    private $trType;

    /**
     * @var string
     */
    private $signature;

    /**
     * @var array
     */
    private $unrecognizedData;

    public function __construct(array $data)
    {
        $this->tid = static::popString($data, 'tid');
        $this->paymentID = static::popString($data, 'paymentID');
        $this->shopID = static::popString($data, 'shopID');
        $this->tranID = static::popString($data, 'tranID');
        $this->trType = static::popString($data, 'trType');
        $this->signature = static::popString($data, 'signature');
        $this->unrecognizedData = $data;
    }

    /**
     * @return static
     */
    public static function createFromGlobals()
    {
        return new static(isset($_POST) ? $_POST : []);
    }

    /**
     * @return string
     */
    public function getTid()
    {
        return $this->tid;
    }

    /**
     * @return string
     */
    public function getPaymentID()
    {
        return $this->paymentID;
    }

    /**
     * @return string
     */
    public function getShopID()
    {
        return $this->shopID;
    }

    /**
     * @return string
     */
    public function getTranID()
    {
        return $this->tranID;
    }

    /**
     * @return string
     */
    public function getTrType()
    {
        return $this->trType;
    }

    /**
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @return array
     */
    public function getUnrecognizedData()
    {
        return $this->unrecognizedData;
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
            'paymentID' => $this->paymentID,
            'shopID' => $this->shopID,
            'tranID' => $this->tranID,
            'trType' => $this->trType,
            'signature' => $this->signature,
            '_unrecognizedData' => $this->unrecognizedData,
        ]);
    }

    /**
     * @param string $key
     *
     * @return string
     */
    private static function popString(array &$data, $key)
    {
        if (!isset($data[$key]) || !is_string($data[$key])) {
            return '';
        }
        $result = $data[$key];
        unset($data[$key]);

        return $result;
    }
}
