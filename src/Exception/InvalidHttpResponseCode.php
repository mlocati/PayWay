<?php

namespace MLocati\PayWay\Exception;

use MLocati\PayWay\Exception;
use MLocati\PayWay\Http\Response;

class InvalidHttpResponseCode extends Exception
{
    /**
     * @var \MLocati\PayWay\Http\Response
     */
    private $httpResponse;

    public function __construct(Response $httpResponse)
    {
        $this->httpResponse = $httpResponse;
        parent::__construct("Invalid HTTP response code: {$this->httpResponse->getCode()}");
    }

    /**
     * @return \MLocati\PayWay\Http\Response
     */
    public function getHttpResponse()
    {
        return $this->httpResponse;
    }
}
