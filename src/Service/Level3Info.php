<?php

namespace MLocati\PayWay\Service;

use DateTime;
use DateTimeInterface;
use JsonSerializable;

class Level3Info implements JsonSerializable
{
    use JsonCleanupTrait;

    /**
     * Undocumented.
     *
     * @var string
     */
    private $invoiceNumber = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $senderPostalCode = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $senderCountryCode = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $destinationName = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $destinationStreet = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $destinationStreet2 = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $destinationStreet3 = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $destinationCity = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $destinationState = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $destinationPostalCode = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $destinationCountryCode = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $destinationPhone = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $destinationFax = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $destinationEmail = '';

    /**
     * Undocumented.
     *
     * @var \DateTimeInterface|null
     */
    private $destinationDate;

    /**
     * Undocumented.
     *
     * @var string
     */
    private $billingName = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $billingStreet = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $billingStreet2 = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $billingStreet3 = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $billingCity = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $billingState = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $billingPostalCode = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $billingCountryCode = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $billingPhone = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $billingFax = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $billingEmail = '';

    /**
     * Undocumented.
     *
     * @var int|null
     */
    private $freightAmount;

    /**
     * Undocumented.
     *
     * @var int|null
     */
    private $taxAmount;

    /**
     * Undocumented.
     *
     * @var string
     */
    private $vat = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $note = '';

    /**
     * Undocumented.
     *
     * @var \MLocati\PayWay\Service\Level3Info\Product[]
     */
    private $products = [];

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setInvoiceNumber($value)
    {
        $this->invoiceNumber = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getSenderPostalCode()
    {
        return $this->senderPostalCode;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setSenderPostalCode($value)
    {
        $this->senderPostalCode = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getSenderCountryCode()
    {
        return $this->senderCountryCode;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setSenderCountryCode($value)
    {
        $this->senderCountryCode = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getDestinationName()
    {
        return $this->destinationName;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setDestinationName($value)
    {
        $this->destinationName = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getDestinationStreet()
    {
        return $this->destinationStreet;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setDestinationStreet($value)
    {
        $this->destinationStreet = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getDestinationStreet2()
    {
        return $this->destinationStreet2;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setDestinationStreet2($value)
    {
        $this->destinationStreet2 = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getDestinationStreet3()
    {
        return $this->destinationStreet3;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setDestinationStreet3($value)
    {
        $this->destinationStreet3 = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getDestinationCity()
    {
        return $this->destinationCity;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setDestinationCity($value)
    {
        $this->destinationCity = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getDestinationState()
    {
        return $this->destinationState;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setDestinationState($value)
    {
        $this->destinationState = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getDestinationPostalCode()
    {
        return $this->destinationPostalCode;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setDestinationPostalCode($value)
    {
        $this->destinationPostalCode = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getDestinationCountryCode()
    {
        return $this->destinationCountryCode;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setDestinationCountryCode($value)
    {
        $this->destinationCountryCode = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getDestinationPhone()
    {
        return $this->destinationPhone;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setDestinationPhone($value)
    {
        $this->destinationPhone = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getDestinationFax()
    {
        return $this->destinationFax;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setDestinationFax($value)
    {
        $this->destinationFax = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getDestinationEmail()
    {
        return $this->destinationEmail;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setDestinationEmail($value)
    {
        $this->destinationEmail = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return \DateTimeInterface|null
     */
    public function getDestinationDate()
    {
        return $this->destinationDate;
    }

    /**
     * Undocumented.
     *
     * @return $this
     */
    public function setDestinationDate(DateTimeInterface $value = null)
    {
        $this->destinationDate = $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getBillingName()
    {
        return $this->billingName;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setBillingName($value)
    {
        $this->billingName = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getBillingStreet()
    {
        return $this->billingStreet;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setBillingStreet($value)
    {
        $this->billingStreet = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getBillingStreet2()
    {
        return $this->billingStreet2;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setBillingStreet2($value)
    {
        $this->billingStreet2 = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getBillingStreet3()
    {
        return $this->billingStreet3;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setBillingStreet3($value)
    {
        $this->billingStreet3 = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getBillingCity()
    {
        return $this->billingCity;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setBillingCity($value)
    {
        $this->billingCity = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getBillingState()
    {
        return $this->billingState;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setBillingState($value)
    {
        $this->billingState = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getBillingPostalCode()
    {
        return $this->billingPostalCode;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setBillingPostalCode($value)
    {
        $this->billingPostalCode = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getBillingCountryCode()
    {
        return $this->billingCountryCode;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setBillingCountryCode($value)
    {
        $this->billingCountryCode = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getBillingPhone()
    {
        return $this->billingPhone;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setBillingPhone($value)
    {
        $this->billingPhone = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getBillingFax()
    {
        return $this->billingFax;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setBillingFax($value)
    {
        $this->billingFax = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getBillingEmail()
    {
        return $this->billingEmail;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setBillingEmail($value)
    {
        $this->billingEmail = (string) $value;

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
     * @see \MLocati\PayWay\Service\Level3Info::getFreightAmountAsCents()
     */
    public function getFreightAmountAsFloat()
    {
        return $this->freightAmount === null ? null : ((float) $this->freightAmount) / 100.;
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
     * @see \MLocati\PayWay\Service\Level3Info::setFreightAmountAsCents()
     */
    public function setFreightAmountAsFloat($value)
    {
        return $this->setFreightAmountAsCents(empty($value) ? $value : round((float) $value * 100.));
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
     * @see \MLocati\PayWay\Service\Level3Info::getFreightAmountAsFloat()
     */
    public function getFreightAmountAsCents()
    {
        return $this->freightAmount;
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
     * @see \MLocati\PayWay\Service\Level3Info::setFreightAmountAsFloat()
     */
    public function setFreightAmountAsCents($value)
    {
        $this->freightAmount = $value === null || $value === '' ? null : (int) $value;

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
     * @see \MLocati\PayWay\Service\Level3Info::getTaxAmountAsCents()
     */
    public function getTaxAmountAsFloat()
    {
        return $this->taxAmount === null ? null : ((float) $this->taxAmount) / 100.;
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
     * @see \MLocati\PayWay\Service\Level3Info::setTaxAmountAsCents()
     */
    public function setTaxAmountAsFloat($value)
    {
        return $this->setTaxAmountAsCents(empty($value) ? $value : round((float) $value * 100.));
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
     * @see \MLocati\PayWay\Service\Level3Info::getTaxAmountAsFloat()
     */
    public function getTaxAmountAsCents()
    {
        return $this->taxAmount;
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
     * @see \MLocati\PayWay\Service\Level3Info::setTaxAmountAsFloat()
     */
    public function setTaxAmountAsCents($value)
    {
        $this->taxAmount = $value === null || $value === '' ? null : (int) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setVat($value)
    {
        $this->vat = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setNote($value)
    {
        $this->note = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return \MLocati\PayWay\Service\Level3Info\Product[]
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Undocumented.
     *
     * @param \MLocati\PayWay\Service\Level3Info\Product[] $value
     *
     * @return $this
     */
    public function setProducts(array $value)
    {
        $this->products = [];
        foreach ($value as $item) {
            $this->addProduct($item);
        }

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return $this
     */
    public function addProduct(Level3Info\Product $value)
    {
        $this->products[] = $value;

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
            'invoiceNumber' => $this->invoiceNumber,
            'senderPostalCode' => $this->senderPostalCode,
            'senderCountryCode' => $this->senderCountryCode,
            'destinationName' => $this->destinationName,
            'destinationStreet' => $this->destinationStreet,
            'destinationStreet2' => $this->destinationStreet2,
            'destinationStreet3' => $this->destinationStreet3,
            'destinationCity' => $this->destinationCity,
            'destinationState' => $this->destinationState,
            'destinationPostalCode' => $this->destinationPostalCode,
            'destinationCountryCode' => $this->destinationCountryCode,
            'destinationPhone' => $this->destinationPhone,
            'destinationFax' => $this->destinationFax,
            'destinationEmail' => $this->destinationEmail,
            'destinationDate' => $this->destinationDate === null ? '' : $this->destinationDate->format(DateTime::RFC3339),
            'billingName' => $this->billingName,
            'billingStreet' => $this->billingStreet,
            'billingStreet2' => $this->billingStreet2,
            'billingStreet3' => $this->billingStreet3,
            'billingCity' => $this->billingCity,
            'billingState' => $this->billingState,
            'billingPostalCode' => $this->billingPostalCode,
            'billingCountryCode' => $this->billingCountryCode,
            'billingPhone' => $this->billingPhone,
            'billingFax' => $this->billingFax,
            'billingEmail' => $this->billingEmail,
            'freightAmount' => $this->freightAmount,
            'taxAmount' => $this->taxAmount,
            'vat' => $this->vat,
            'note' => $this->note,
            'product' => array_map(static function (Level3Info\Product $item) {
                return $item->jsonSerialize();
            }, $this->products),
        ]);
    }
}
