<?php

namespace MLocati\PayWay\Test\TestCase\Http;

use MLocati\PayWay\Client;
use MLocati\PayWay\Exception;
use MLocati\PayWay\Http\Event;
use MLocati\PayWay\Http\Response;
use MLocati\PayWay\Init;
use MLocati\PayWay\Test\Service\FakeHttpDriver;
use MLocati\PayWay\Test\Service\TestCase;
use RuntimeException;

class ClientTest extends TestCase
{
    /**
     * @var \MLocati\PayWay\Init\Request
     */
    private static $sampleInitRequest;

    public static function provideWrongUrls()
    {
        return [
            [''],
            ['foo.bar'],
            ['//foo.bar'],
            ['https://foo.bar'],
            ['https://foo.bar/path?parameter'],
        ];
    }

    /**
     * @dataProvider provideWrongUrls
     */
    public function testWrongUrl($wrongUrl)
    {
        $this->isGoingToThrowException(RuntimeException::class, "'{$wrongUrl}' is not a valid base URL of the web services");
        new Client($wrongUrl, 'xxx');
    }

    public function testWrongKey()
    {
        $this->isGoingToThrowException(RuntimeException::class, 'Missing the signature key');
        new Client('https://foo.bar/path', '');
    }

    public function testWrongReturnCode()
    {
        $driver = new FakeHttpDriver(new Response(501, ['Content-Type: text/plain'], 'This is the body'));
        $client = new Client('https://foo.bar/path', 'key', $driver);
        $this->isGoingToThrowException(Exception\InvalidHttpResponseCode::class, 'Invalid HTTP response code: 501');
        $client->init(self::$sampleInitRequest);
    }

    public function testWrongReturnContent()
    {
        $driver = new FakeHttpDriver(new Response(200, ['Content-Type: text/plain'], 'This is the body'));
        $client = new Client('https://foo.bar/path', 'key', $driver);
        $this->isGoingToThrowException(Exception\InvalidXml::class, 'The XML is not valid');
        $client->init(self::$sampleInitRequest);
    }

    public function testListeners()
    {
        $driver = new FakeHttpDriver(new Response(200, ['Content-Type: text/plain'], 'This is the body'));
        $client = new Client('https://foo.bar/path', 'key', $driver);
        $receivedEvent = null;
        $listener = function (Event $event) use ($driver, &$receivedEvent) {
            $receivedEvent = $event;
            $this->assertSame($event->getResponse(), $driver->getResponseToProvide());
        };

        $receivedEvent = null;
        $client->addListener($listener);
        try {
            $client->init(self::$sampleInitRequest);
        } catch (Exception\InvalidXml $_) {
        }
        $this->assertNotNull($receivedEvent);

        $receivedEvent = null;
        $client->removeListener($listener);
        try {
            $client->init(self::$sampleInitRequest);
        } catch (Exception\InvalidXml $_) {
        }
        $this->assertNull($receivedEvent);
    }

    protected static function baseSetUpBeforeClass()
    {
        $request = new Init\Request();
        self::$sampleInitRequest = $request
            ->setTID('tid')
            ->setShopID('shopid')
            ->setAmountAsFloat(1)
            ->setNotifyURL('https://foo.bar/path')
            ->setErrorURL('https://foo.bar/path')
        ;
    }
}
