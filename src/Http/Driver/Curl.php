<?php

namespace MLocati\PayWay\Http\Driver;

use MLocati\PayWay\Exception\NetworkUnavailable;
use MLocati\PayWay\Http\Driver;
use MLocati\PayWay\Http\Response;

class Curl implements Driver
{
    /**
     * {@inheritdoc}
     *
     * @see \MLocati\PayWay\Http\Driver::send()
     */
    public function send($url, $method, array $headers, $body = '')
    {
        $ch = function_exists('curl_init') ? curl_init() : '';
        if (!$ch) {
            throw new NetworkUnavailable('curl_init() failed');
        }
        try {
            $responseHeaders = [];
            $options = [
                CURLOPT_URL => $url,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADERFUNCTION => function ($ch, $header) use (&$responseHeaders) {
                    $this->collectHeader($header, $responseHeaders);

                    return strlen($header);
                },
            ];
            $method = strtoupper($method);
            switch ($method) {
                case 'GET':
                    $options[CURLOPT_HTTPGET] = true;
                    break;
                case 'POST':
                    $options[CURLOPT_POST] = true;
                    break;
                case 'PUT':
                    $options[CURLOPT_PUT] = true;
                    break;
                case 'HEAD':
                    $options[CURLOPT_NOBODY] = true;
                    break;
                default:
                    $options[CURLOPT_CUSTOMREQUEST] = $method;
                    break;
            }
            $body = (string) $body;
            if ($body !== '') {
                $options[CURLOPT_POSTFIELDS] = $body;
            }
            $serializedHeaders = $this->serializeHeaders($headers);
            if ($serializedHeaders !== []) {
                $options[CURLOPT_HTTPHEADER] = $serializedHeaders;
            }
            if (!curl_setopt_array($ch, $options)) {
                throw new NetworkUnavailable($this->describeCurlError($ch, 'curl_setopt_array() failed: %s'));
            }
            $responseBody = curl_exec($ch);
            if ($responseBody === false) {
                throw new NetworkUnavailable($this->describeCurlError($ch, 'curl_exec() failed: %s'));
            }
            $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        } finally {
            curl_close($ch);
        }

        return new Response($responseCode, $responseHeaders, $responseBody);
    }

    /**
     * @return string[]
     */
    protected function serializeHeaders(array $headers)
    {
        $result = [];
        foreach ($headers as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $item) {
                    $result[] = "{$key}: {$item}";
                }
            } else {
                $result[] = "{$key}: {$value}";
            }
        }

        return $result;
    }

    /**
     * @param string $header
     */
    protected function collectHeader($header, array &$responseHeaders)
    {
        $match = null;
        $header = trim($header);
        if ($header === '') {
            return;
        }
        if (preg_match('/^(?<name>[^:]*?)\s*:\s*(?<value>.*)$/', $header, $match)) {
            $name = $match['name'];
            $value = $match['value'];
        } else {
            $name = $header;
            $value = '';
        }
        foreach (array_keys($responseHeaders) as $alreadyName) {
            if (strcasecmp($alreadyName, $name) === 0) {
                if (is_string($responseHeaders[$alreadyName])) {
                    $responseHeaders[$alreadyName] = [$responseHeaders[$alreadyName], $value];
                } else {
                    $responseHeaders[$alreadyName][] = $value;
                }
                break;
            }
        }
        $responseHeaders[$name] = $value;
    }

    /**
     * @param resource|\CurlHandle $ch
     * @param string $messagePattern
     */
    protected function describeCurlError($ch, $messagePattern)
    {
        $errorMessage = curl_error($ch);
        $errorMessage = is_string($errorMessage) ? trim($errorMessage) : '';
        if ($errorMessage === '') {
            $errorCode = curl_errno($ch);
            if (!empty($errorCode)) {
                $errorMessage = "cURL error #{$errorCode}";
            }
        }
        if ($errorMessage === '') {
            $errorMessage = 'unknows error';
        }

        return sprintf($messagePattern, $errorMessage);
    }
}
