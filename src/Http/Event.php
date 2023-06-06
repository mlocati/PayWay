<?php

namespace MLocati\PayWay\Http;

class Event
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $requestBody;

    /**
     * @var \MLocati\PayWay\Http\Response
     */
    private $response;

    /**
     * @param string $url
     * @param string $method
     * @param string $requestBody
     */
    public function __construct($url, $method, $requestBody, Response $response)
    {
        $this->url = $url;
        $this->method = $method;
        $this->requestBody = $requestBody;
        $this->response = $response;
    }
    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getRequestBody()
    {
        return $this->requestBody;
    }

    /**
     * @return \MLocati\PayWay\Http\Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}
