<?php

namespace MLocati\PayWay\Test\Service\TestCase;

use MLocati\PayWay\Test\Service\TestCaseBase;

abstract class v2 extends TestCaseBase
{
    /**
     * {@inheritdoc}
     *
     * @see \PHPUnit\Framework\TestCase::setUpBeforeClass()
     */
    public static function setUpBeforeClass(): void
    {
        static::baseSetUpBeforeClass();
    }

    /**
     * {@inheritdoc}
     *
     * @see \PHPUnit\Framework\TestCase::tearDownAfterClass()
     */
    public static function tearDownAfterClass(): void
    {
        static::baseTearDownAfterClass();
    }

    /**
     * {@inheritdoc}
     *
     * @see \PHPUnit\Framework\TestCase::setUp()
     */
    final protected function setUp(): void
    {
        $this->baseSetUp();
    }

    /**
     * {@inheritdoc}
     *
     * @see \PHPUnit\Framework\TestCase::tearDown()
     */
    final protected function tearDown(): void
    {
        $this->baseTearDown();
    }

    /**
     * @param string $expected
     * @param string $message
     */
    protected function assertPHPType($expected, $actual, $message = '')
    {
        switch (strtolower($expected)) {
            case 'array':
                $this->assertIsArray($actual, $message);
                break;
            case 'boolean':
            case 'bool':
                $this->assertIsBool($actual, $message);
                break;
            case 'double':
            case 'float':
            case 'real':
                $this->assertIsFloat($actual, $message);
                break;
            case 'integer':
            case 'int':
                $this->assertIsInt($actual, $message);
                break;
            case 'null':
                $this->assertNull($actual, $message);
                break;
            case 'numeric':
                $this->assertIsNumeric($actual, $message);
                break;
            case 'object':
            case 'numeric':
                $this->assertIsObject($actual, $message);
                break;
            case 'resource':
                $this->assertIsResource($actual, $message);
                break;
            case 'string':
                $this->assertIsString($actual, $message);
                break;
            case 'scalar':
                $this->assertIsScalar($actual, $message);
                break;
            case 'callable':
                $this->assertIsCallable($actual, $message);
                break;
            case 'iterable':
                $this->assertIsIterable($actual, $message);
                break;
            default:
                throw new \Exception('Invalid type for ' . __METHOD__);
        }
    }
}
