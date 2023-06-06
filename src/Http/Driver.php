<?php

namespace MLocati\PayWay\Http;

interface Driver
{
    /**
     * @param string $url
     * @param string $method 'GET', 'POST', ...
     * @param array $headers keys are the header names, values are the header values
     * @param string $body the raw request body
     *
     * @throws \MLocati\PayWay\Exception\NetworkUnavailable in case the network communication failed
     *
     * @return \MLocati\PayWay\Http\Response
     */
    public function send($url, $method, array $headers, $body = '');
}
