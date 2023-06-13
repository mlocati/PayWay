<?php

namespace MLocati\PayWay;

use RuntimeException;

class Client
{
    /**
     * @var string always ending with a slash
     */
    protected $servicesUrlPrefix;

    /**
     * @var string
     */
    protected $signatureKey;

    /**
     * @var \MLocati\PayWay\Http\Driver
     */
    protected $driver;

    /**
     * @var callable[]
     */
    protected $listeners = [];

    /**
     * @var \MLocati\PayWay\Init\Request\Serializer|null
     */
    private $initSerializer;

    /**
     * @var \MLocati\PayWay\Init\Response\Unserializer|null
     */
    private $initUnserializer;

    /**
     * @var \MLocati\PayWay\Verify\Request\Serializer|null
     */
    private $verifySerializer;

    /**
     * @var \MLocati\PayWay\Verify\Response\Unserializer|null
     */
    private $verifyUnserializer;

    /**
     * @param string|object|mixed $servicesUrl
     */
    public function __construct($servicesUrl, $signatureKey, Http\Driver $driver = null)
    {
        $servicesUrlPrefix = static::normalizeServicesUrl($servicesUrl);
        if ($servicesUrlPrefix === '') {
            throw new RuntimeException("'{$servicesUrl}' is not a valid base URL of the web services");
        }
        $this->servicesUrlPrefix = $servicesUrlPrefix;
        $this->signatureKey = is_string($signatureKey) ? $signatureKey : '';
        if ($this->signatureKey === '') {
            throw new RuntimeException('Missing the signature key');
        }
        $this->driver = $driver === null ? static::buildDefaultDriver() : $driver;
    }

    /**
     * Normalize the value of the services URL.
     *
     * @param string|object|mixed $value
     *
     * @return string empty string in case of errors
     */
    public static function normalizeServicesUrl($value)
    {
        switch (gettype($value)) {
            case 'string':
                break;
            case 'object':
                if (!method_exists($value, '__toString')) {
                    return '';
                }
                $value = (string) $value;
                break;
            default:
                return '';
        }
        $value = trim($value);
        if ($value === '' || strpos($value, '?') !== false || strpos($value, '#') !== false) {
            return '';
        }
        if (!filter_var($value, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
            return '';
        }

        return rtrim($value, '/') . '/';
    }

    /**
     * @return \MLocati\PayWay\Init\Response
     */
    public function init(Init\Request $request)
    {
        $xml = $this->getInitSerializer()->serialize($request, $this->signatureKey);
        $rawResponse = $this->postSoapRequest('PaymentInitGatewayPort', $xml);
        if (!$rawResponse->is2xx()) {
            throw new Exception\InvalidHttpResponseCode($rawResponse);
        }

        return $this->getInitUnserializer()->unserialize($rawResponse->getBody());
    }

    /**
     * @return \MLocati\PayWay\Verify\Response
     */
    public function verify(Verify\Request $request)
    {
        $xml = $this->getVerifySerializer()->serialize($request, $this->signatureKey);
        $rawResponse = $this->postSoapRequest('PaymentInitGatewayPort', $xml);
        if (!$rawResponse->is2xx()) {
            throw new Exception\InvalidHttpResponseCode($rawResponse);
        }

        return $this->getVerifyUnserializer()->unserialize($rawResponse->getBody());
    }

    /**
     * @return $this
     */
    public function addListener(callable $value)
    {
        $this->listeners[] = $value;

        return $this;
    }

    /**
     * @return $this
     */
    public function removeListener(callable $value)
    {
        $this->listeners = array_filter($this->listeners, static function (callable $item) use ($value) {
            return $item !== $value;
        });

        return $this;
    }

    /**
     * @return \MLocati\PayWay\Http\Driver
     */
    protected static function buildDefaultDriver()
    {
        if (extension_loaded('curl')) {
            return new Http\Driver\Curl();
        }

        throw new RuntimeException("The cURL extension is required if you don't provide your own HTTP driver");
    }

    /**
     * @return \MLocati\PayWay\Init\Request\Serializer
     */
    protected function getInitSerializer()
    {
        if ($this->initSerializer === null) {
            $this->initSerializer = new Init\Request\Serializer();
        }

        return $this->initSerializer;
    }

    /**
     * @return \MLocati\PayWay\Init\Response\Unserializer
     */
    protected function getInitUnserializer()
    {
        if ($this->initUnserializer === null) {
            $this->initUnserializer = new Init\Response\Unserializer();
        }

        return $this->initUnserializer;
    }

    /**
     * @return \MLocati\PayWay\Verify\Request\Serializer
     */
    protected function getVerifySerializer()
    {
        if ($this->verifySerializer === null) {
            $this->verifySerializer = new Verify\Request\Serializer();
        }

        return $this->verifySerializer;
    }

    /**
     * @return \MLocati\PayWay\Verify\Response\Unserializer
     */
    protected function getVerifyUnserializer()
    {
        if ($this->verifyUnserializer === null) {
            $this->verifyUnserializer = new Verify\Response\Unserializer();
        }

        return $this->verifyUnserializer;
    }

    /**
     * @param string $path
     * @param string $xml
     *
     * @return \MLocati\PayWay\Http\Response
     */
    private function postSoapRequest($path, $xml)
    {
        $url = $this->servicesUrlPrefix . $path;
        $response = $this->driver->send(
            $url,
            'POST',
            [
                'Content-Type' => 'text/xml; charset=utf-8',
                'SOAPAction' => '',
                'Content-Length: ' . strlen($xml),
            ],
            $xml
        );
        if ($this->listeners !== []) {
            $event = new Http\Event($url, 'POST', $xml, $response);
            foreach ($this->listeners as $listener) {
                $listener($event);
            }
        }

        return $response;
    }
}
