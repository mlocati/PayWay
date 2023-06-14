<?php

namespace MLocati\PayWay\Service;

use DateTime;
use DateTimeInterface;
use DOMElement;
use MLocati\PayWay\Exception;
use ValueError;

trait BaseResponseTrait
{
    use JsonCleanupTrait;

    /**
     * @var string
     */
    private $tid = '';

    /**
     * @var string
     */
    private $payInstr = '';

    /**
     * @var \DateTimeInterface|null
     */
    private $reqTime;

    /**
     * @var string
     */
    private $rc = '';

    /**
     * @var bool
     */
    private $error = false;

    /**
     * @var string
     */
    private $errorDesc = '';

    /**
     * @var string
     */
    private $signature = '';

    /**
     * @var string[]
     */
    private $unrecognizedXmlElements = [];

    /**
     * @return string
     */
    public function getTid()
    {
        return $this->tid;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setTid($value)
    {
        $this->tid = (string) $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getPayInstr()
    {
        return $this->payInstr;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setPayInstr($value)
    {
        $this->payInstr = (string) $value;

        return $this;
    }

    /**
     * @return $this
     */
    public function getReqTime()
    {
        return $this->reqTime;
    }

    /**
     * @return $this
     */
    public function setReqTime(DateTimeInterface $value = null)
    {
        $this->reqTime = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getRc()
    {
        return $this->rc;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setRc($value)
    {
        $this->rc = (string) $value;

        return $this;
    }

    /**
     * @return bool
     */
    public function isError()
    {
        return $this->error;
    }

    /**
     * @param bool $value
     *
     * @return $this
     */
    public function setError($value)
    {
        $this->error = (bool) $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getErrorDesc()
    {
        return $this->errorDesc;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setErrorDesc($value)
    {
        $this->errorDesc = (string) $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setSignature($value)
    {
        $this->signature = (string) $value;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getUnrecognizedXmlElements()
    {
        return $this->unrecognizedXmlElements;
    }

    /**
     * @param string[]|\DOMElement[] $value
     *
     * @return $this
     */
    public function setUnrecognizedXmlElements(array $value)
    {
        $this->unrecognizedXmlElements = [];
        foreach ($value as $item) {
            $this->addUnrecognizedXmlElement($item);
        }

        return $this;
    }

    /**
     * @param string|\DOMElement $value
     *
     * @return $this
     */
    public function addUnrecognizedXmlElement($value)
    {
        if ($value instanceof DOMElement) {
            $value = $value->ownerDocument->saveXML($value);
        }
        $this->unrecognizedXmlElements[] = $value;

        return $this;
    }

    /**
     * Check the HMAC-SHA256 signature.
     *
     * @param string $key
     *
     * @throws \MLocati\PayWay\Exception\InvalidSignature
     */
    public function checkSignature($key)
    {
        $data = implode('', $this->getSignatureFields());
        try {
            $expectedRawSignature = hash_hmac('sha256', $data, $key, true);
        } catch (ValueError $x) {
            throw new Exception\UnableToCreateSignature($x->getMessage());
        }
        if ($expectedRawSignature === false) {
            throw new Exception\UnableToCreateSignature();
        }
        $expectedSignature = base64_encode($expectedRawSignature);
        if ($this->signature !== $expectedSignature) {
            throw new Exception\InvalidSignature($expectedSignature, $this->signature);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @see \JsonSerializable::jsonSerialize()
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->cleanupJson([
            'tid' => $this->tid,
            'payInstr' => $this->payInstr,
            'reqTime' => $this->reqTime === null ? '' : $this->reqTime->format(DateTime::RFC3339),
            'rc' => $this->rc,
            'error' => $this->error,
            'errorDesc' => $this->errorDesc,
            'signature' => $this->signature,
            '_unrecognizedXmlElements' => $this->unrecognizedXmlElements,
        ]);
    }

    /**
     * @return string[]
     *
     * @private
     */
    abstract protected function getSignatureFields();
}
