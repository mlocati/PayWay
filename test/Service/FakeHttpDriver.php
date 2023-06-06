<?php

namespace MLocati\PayWay\Test\Service;

use MLocati\PayWay\Http\Driver;
use MLocati\PayWay\Http\Response;

class FakeHttpDriver implements Driver
{
    /**
     * @var \MLocati\PayWay\Http\Response
     */
    private $responseToProvide;

    public function __construct(Response $responseToProvide)
    {
        $this->responseToProvide = $responseToProvide;
    }

    /**
     * @return \MLocati\PayWay\Http\Response
     */
    public function getResponseToProvide()
    {
        return $this->responseToProvide;
    }

    /**
     * @return $this
     */
    public function setResponseToProvide(Response $value)
    {
        $this->responseToProvide = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see \MLocati\PayWay\Http\Driver::send()
     */
    public function send($url, $method, array $headers, $body = '')
    {
        return $this->responseToProvide;
    }
}
