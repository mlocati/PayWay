<?php

namespace MLocati\PayWay\Service;

use DateTime;
use DateTimeInterface;
use JsonSerializable;

class MandateInfo implements JsonSerializable
{
    use JsonCleanupTrait;

    /**
     * Undocumented.
     *
     * @var string
     */
    private $mandateID = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $contractID = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $sequenceType = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $frequency = '';

    /**
     * Undocumented.
     *
     * @var \DateTimeInterface|null
     */
    private $durationStartDate;

    /**
     * Undocumented.
     *
     * @var \DateTimeInterface|null
     */
    private $durationEndDate;

    /**
     * Undocumented.
     *
     * @var \DateTimeInterface|null
     */
    private $firstCollectionDate;

    /**
     * Undocumented.
     *
     * @var \DateTimeInterface|null
     */
    private $finalCollectionDate;

    /**
     * Undocumented.
     *
     * @var int|null
     */
    private $maxAmount;

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getMandateID()
    {
        return $this->mandateID;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setMandateID($value)
    {
        $this->mandateID = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getContractID()
    {
        return $this->contractID;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setContractID($value)
    {
        $this->contractID = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getSequenceType()
    {
        return $this->sequenceType;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setSequenceType($value)
    {
        $this->sequenceType = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setFrequency($value)
    {
        $this->frequency = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return \DateTimeInterface|null
     */
    public function getDurationStartDate()
    {
        return $this->durationStartDate;
    }

    /**
     * Undocumented.
     *
     * @return $this
     */
    public function setDurationStartDate(DateTimeInterface $value = null)
    {
        $this->durationStartDate = $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return \DateTimeInterface|null
     */
    public function getDurationEndDate()
    {
        return $this->durationEndDate;
    }

    /**
     * Undocumented.
     *
     * @return $this
     */
    public function setDurationEndDate(DateTimeInterface $value = null)
    {
        $this->durationEndDate = $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return \DateTimeInterface|null
     */
    public function getFirstCollectionDate()
    {
        return $this->firstCollectionDate;
    }

    /**
     * Undocumented.
     *
     * @return $this
     */
    public function setFirstCollectionDate(DateTimeInterface $value = null)
    {
        $this->firstCollectionDate = $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return \DateTimeInterface|null
     */
    public function getFinalCollectionDate()
    {
        return $this->finalCollectionDate;
    }

    /**
     * Undocumented.
     *
     * @return $this
     */
    public function setFinalCollectionDate(DateTimeInterface $value = null)
    {
        $this->finalCollectionDate = $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return float|int|null
     *
     * @example 0.07 EUR = 0.07
     * @example 1.00 EUR = 1
     * @example 12.05 EUR = 12.05
     *
     * @see \MLocati\PayWay\Service\MandateInfo::getMaxAmountAsCents()
     */
    public function getMaxAmountAsFloat()
    {
        return $this->maxAmount === null ? null : ((float) $this->maxAmount) / 100.;
    }

    /**
     * Undocumented.
     *
     * @param float|int|null $value
     *
     * @return $this
     *
     * @example 0.07 EUR = 0.07
     * @example 1.00 EUR = 1
     * @example 12.05 EUR = 12.05
     *
     * @see \MLocati\PayWay\Service\MandateInfo::setMaxAmountAsCents()
     */
    public function setMaxAmountAsFloat($value)
    {
        return $this->setMaxAmountAsCents(empty($value) ? $value : round((float) $value * 100.));
    }

    /**
     * Undocumented.
     *
     * @var int|null
     *
     * @example 0.07 EUR = 7
     * @example 1.00 EUR = 100
     * @example 12.05 EUR = 1205
     *
     * @see \MLocati\PayWay\Service\MandateInfo::getMaxAmountAsFloat()
     */
    public function getMaxAmountAsCents()
    {
        return $this->maxAmount;
    }

    /**
     * Undocumented.
     *
     * @param int|null $value
     *
     * @return $this
     *
     * @example 0.07 EUR = 7
     * @example 1.00 EUR = 100
     * @example 12.05 EUR = 1205
     *
     * @see \MLocati\PayWay\Service\MandateInfo::setMaxAmountAsFloat()
     */
    public function setMaxAmountAsCents($value)
    {
        $this->maxAmount = $value === null || $value === '' ? null : (int) $value;

        return $this;
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
            'mandateID' => $this->mandateID,
            'contractID' => $this->contractID,
            'sequenceType' => $this->sequenceType,
            'frequency' => $this->frequency,
            'durationStartDate' => $this->durationStartDate === null ? '' : $this->durationStartDate->format(DateTime::RFC3339),
            'durationEndDate' => $this->durationEndDate === null ? '' : $this->durationEndDate->format(DateTime::RFC3339),
            'firstCollectionDate' => $this->firstCollectionDate === null ? '' : $this->firstCollectionDate->format(DateTime::RFC3339),
            'finalCollectionDate' => $this->finalCollectionDate === null ? '' : $this->finalCollectionDate->format(DateTime::RFC3339),
            'maxAmount' => $this->maxAmount,
        ]);
    }
}
