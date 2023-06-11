<?php

namespace MLocati\PayWay\Error;

use JsonSerializable;
use MLocati\PayWay\Service\JsonCleanupTrait;

class RequestData implements JsonSerializable
{
    use JsonCleanupTrait;

    /**
     * @var string
     */
    private $rc;

    /**
     * @var array
     */
    private $unrecognizedData;

    public function __construct(array $data)
    {
        $this->rc = static::popString($data, 'rc');
        $this->unrecognizedData = $data;
    }

    /**
     * @return static
     */
    public static function createFromGlobals()
    {
        return new static(isset($_GET) ? $_GET : []);
    }

    /**
     * @return string
     */
    public function getRC()
    {
        return $this->rc;
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
            'rc' => $this->rc,
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
