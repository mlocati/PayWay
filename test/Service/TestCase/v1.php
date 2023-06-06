<?php

namespace MLocati\PayWay\Test\Service\TestCase;

use MLocati\PayWay\Test\Service\TestCaseBase;

abstract class v1 extends TestCaseBase
{
    /**
     * {@inheritdoc}
     *
     * @see \PHPUnit\Framework\TestCase::setUpBeforeClass()
     */
    public static function setUpBeforeClass()
    {
        static::baseSetUpBeforeClass();
    }

    /**
     * {@inheritdoc}
     *
     * @see \PHPUnit\Framework\TestCase::tearDownAfterClass()
     */
    public static function tearDownAfterClass()
    {
        static::baseTearDownAfterClass();
    }

    /**
     * {@inheritdoc}
     *
     * @see \PHPUnit\Framework\TestCase::setUp()
     */
    final protected function setUp()
    {
        $this->baseSetUp();
    }

    /**
     * {@inheritdoc}
     *
     * @see \PHPUnit\Framework\TestCase::tearDown()
     */
    final protected function tearDown()
    {
        $this->baseTearDown();
    }

    /**
     * @param string $expected
     * @param string $message
     */
    protected function assertPHPType($expected, $actual, $message = '')
    {
        $this->assertInternalType($expected, $actual, $message);
    }
}
