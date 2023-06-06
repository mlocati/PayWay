<?php

namespace MLocati\PayWay\Test\Service;

use PHPUnit\Framework\TestCase;

abstract class TestCaseBase extends TestCase
{
    public static function assertRegularExpression($pattern, $string, $message = '')
    {
        if (method_exists(__CLASS__, 'assertMatchesRegularExpression')) {
            self::assertMatchesRegularExpression($pattern, $string, $message);
        } else {
            self::assertRegExp($pattern, $string, $message);
        }
    }

    protected static function baseSetUpBeforeClass()
    {
    }

    protected function baseSetUp()
    {
    }

    protected function baseTearDown()
    {
    }

    protected static function baseTearDownAfterClass()
    {
    }

    /**
     * @param string $class
     * @param string|null $message
     */
    protected function isGoingToThrowException($class, $message = null)
    {
        if (method_exists($this, 'expectException')) {
            $this->expectException($class);
            if ($message !== null) {
                $this->expectExceptionMessage($message);
            }
        } else {
            parent::setExpectedException($class, $message);
        }
    }
}
