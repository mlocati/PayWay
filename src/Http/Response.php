<?php

namespace MLocati\PayWay\Http;

use JsonSerializable;

class Response implements JsonSerializable
{
    /**
     * @var int
     */
    private $code;

    /**
     * @var array keys are the header names, values are strings or (in case of multiple headers) arrays of strings
     */
    private $headers;

    /**
     * @var string
     */
    private $body;

    /**
     * @param int $code
     * @param array $headers keys are the header names, values are strings or (in case of multiple headers) arrays of strings
     * @param string $body
     */
    public function __construct($code, array $headers, $body)
    {
        $this->code = (int) $code;
        $this->headers = $headers;
        $this->body = (string) $body;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return array keys are the header names, values are strings or (in case of multiple headers) arrays of strings
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return bool
     */
    public function is2xx()
    {
        return $this->code >= 200 && $this->code < 300;
    }

    /**
     * {@inheritdoc}
     *
     * @see \JsonSerializable::jsonSerialize()
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            'code' => $this->code,
            'headers' => $this->headers,
            'body' => $this->body,
        ];
    }
}
