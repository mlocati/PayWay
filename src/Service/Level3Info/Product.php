<?php

namespace MLocati\PayWay\Service\Level3Info;

use JsonSerializable;
use MLocati\PayWay\Service\JsonCleanupTrait;

class Product implements JsonSerializable
{
    use JsonCleanupTrait;

    /**
     * Undocumented.
     *
     * @var string
     */
    private $productCode = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $productDescription = '';

    /**
     * Undocumented.
     *
     * @var int|null
     */
    private $items;

    /**
     * Undocumented.
     *
     * @var int|null
     *
     * @example 0.07 EUR = 7
     * @example 1.00 EUR = 100
     * @example 12.05 EUR = 1205
     */
    private $amount;

    /**
     * Undocumented.
     *
     * @var string
     */
    private $imgURL = '';

    /**
     * @return string
     */
    public function getProductCode()
    {
        return $this->productCode;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setProductCode($value)
    {
        $this->productCode = (string) $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getProductDescription()
    {
        return $this->productDescription;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setProductDescription($value)
    {
        $this->productDescription = $value;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param int|null $value
     *
     * @return $this
     */
    public function setItems($value)
    {
        $this->items = $value === null || $value === '' ? null : (int) $value;

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
     * @see \MLocati\PayWay\Service\Level3Info\Product::getAmountAsCents()
     */
    public function getAmountAsFloat()
    {
        return $this->amount === null ? null : ((float) $this->amount) / 100.;
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
     * @see \MLocati\PayWay\Service\Level3Info\Product::setAmountAsCents()
     */
    public function setAmountAsFloat($value)
    {
        return $this->setAmountAsCents(empty($value) ? $value : round((float) $value * 100.));
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
     * @see \MLocati\PayWay\Service\Level3Info\Product::getAmountAsFloat()
     */
    public function getAmountAsCents()
    {
        return $this->amount;
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
     * @see \MLocati\PayWay\Service\Level3Info\Product::setAmountAsFloat()
     */
    public function setAmountAsCents($value)
    {
        $this->amount = $value === null || $value === '' ? null : (int) $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getImgURL()
    {
        return $this->imgURL;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setImgURL($value)
    {
        $this->imgURL = (string) $value;

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
            'productCode' => $this->productCode,
            'productDescription' => $this->productDescription,
            'items' => $this->items,
            'amount' => $this->amount,
            'imgURL' => $this->imgURL,
        ]);
    }
}
