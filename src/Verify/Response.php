<?php

namespace MLocati\PayWay\Verify;

use JsonSerializable;
use MLocati\PayWay\Service;

class Response implements JsonSerializable
{
    use Service\BasePaymentInitResponseTrait {
        jsonSerialize as jsonSerializeBasePaymentInitResponse;
    }

    /**
     * @var string
     */
    private $paymentID = '';

    /**
     * @var int|null
     */
    private $tranID;

    /**
     * @var string
     */
    private $authCode = '';

    /**
     * @var string
     */
    private $enrStatus = '';

    /**
     * @var string
     */
    private $authStatus = '';

    /**
     * @var string
     */
    private $eci = '';

    /**
     * @var string
     */
    private $brand = '';

    /**
     * @var string
     */
    private $acquirerID = '';

    /**
     * @var string
     */
    private $maskedPan = '';

    /**
     * @var string
     */
    private $addInfo1 = '';

    /**
     * @var string
     */
    private $addInfo2 = '';

    /**
     * @var string
     */
    private $addInfo3 = '';

    /**
     * @var string
     */
    private $addInfo4 = '';

    /**
     * @var string
     */
    private $addInfo5 = '';

    /**
     * @var string
     */
    private $payInstrToken = '';

    /**
     * @var int|null
     */
    private $expireMonth;

    /**
     * @var int|null
     */
    private $expireYear;

    /**
     * @var \MLocati\PayWay\Service\Level3Info|null
     */
    private $level3Info;

    /**
     * @var int|null
     */
    private $additionalFee;

    /**
     * @var string
     */
    private $status = '';

    /**
     * @var string
     */
    private $accountName = '';

    /**
     * @var string
     */
    private $nssResult = '';

    /**
     * @var string
     */
    private $topUpID = '';

    /**
     * @var string
     */
    private $payloadContent; // byte[]

    /**
     * @var string
     */
    private $payloadContentType = '';

    /**
     * @var array
     */
    private $payTraceData = [];

    /**
     * @var array
     */
    private $payAddData = [];

    /**
     * @var string
     */
    private $payUserRef = '';

    /**
     * @var string
     */
    private $shopUserMobilePhone = '';

    /**
     * @var string
     *
     * @see \MLocati\PayWay\Dictionary\ScaExemptionType
     */
    private $scaExemptionType = '';

    /**
     * @return string
     */
    public function getPaymentID()
    {
        return $this->paymentID;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setPaymentID($value)
    {
        $this->paymentID = (string) $value;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getTranID()
    {
        return $this->tranID;
    }

    /**
     * @param int|null $value
     *
     * @return $this
     */
    public function setTranID($value)
    {
        $this->tranID = $value === null || $value === '' ? null : (int) $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthCode()
    {
        return $this->authCode;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setAuthCode($value)
    {
        $this->authCode = (string) $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getEnrStatus()
    {
        return $this->enrStatus;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setEnrStatus($value)
    {
        $this->enrStatus = (string) $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getEci()
    {
        return $this->eci;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setEci($value)
    {
        $this->eci = (string) $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthStatus()
    {
        return $this->authStatus;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setAuthStatus($value)
    {
        $this->authStatus = (string) $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setBrand($value)
    {
        $this->brand = (string) $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getAcquirerID()
    {
        return $this->acquirerID;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setAcquirerID($value)
    {
        $this->acquirerID = (string) $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getMaskedPan()
    {
        return $this->maskedPan;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setMaskedPan($value)
    {
        $this->maskedPan = (string) $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddInfo1()
    {
        return $this->addInfo1;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setAddInfo1($value)
    {
        $this->addInfo1 = (string) $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddInfo2()
    {
        return $this->addInfo2;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setAddInfo2($value)
    {
        $this->addInfo2 = (string) $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddInfo3()
    {
        return $this->addInfo3;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setAddInfo3($value)
    {
        $this->addInfo3 = (string) $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddInfo4()
    {
        return $this->addInfo4;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setAddInfo4($value)
    {
        $this->addInfo4 = (string) $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddInfo5()
    {
        return $this->addInfo5;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setAddInfo5($value)
    {
        $this->addInfo5 = (string) $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getPayInstrToken()
    {
        return $this->payInstrToken;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setPayInstrToken($value)
    {
        $this->payInstrToken = (string) $value;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getExpireMonth()
    {
        return $this->expireMonth;
    }

    /**
     * @param int|null $value
     *
     * @return $this
     */
    public function setExpireMonth($value)
    {
        $this->expireMonth = $value === null || $value === '' ? null : (int) $value;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getExpireYear()
    {
        return $this->expireYear;
    }

    /**
     * @param int|null $value
     *
     * @return $this
     */
    public function setExpireYear($value)
    {
        $this->expireYear = $value === null || $value === '' ? null : (int) $value;

        return $this;
    }

    /**
     * @return \MLocati\PayWay\Service\Level3Info
     */
    public function getLevel3Info()
    {
        if ($this->level3Info === null) {
            $this->level3Info = new Service\Level3Info();
        }

        return $this->level3Info;
    }

    /**
     * @return $this
     */
    public function setLevel3Info(Service\Level3Info $value)
    {
        $this->level3Info = $value;

        return $this;
    }

    /**
     * @return float|int|null
     *
     * @example 0.07 EUR = 0.07
     * @example 1.00 EUR = 1
     * @example 12.05 EUR = 12.05
     *
     * @see \MLocati\PayWay\Verify\Response::getAdditionalFeeAsCents()
     */
    public function getAdditionalFeeAsFloat()
    {
        return $this->additionalFee === null ? null : ((float) $this->additionalFee) / 100.;
    }

    /**
     * @param float|int|null $value
     *
     * @return $this
     *
     * @example 0.07 EUR = 0.07
     * @example 1.00 EUR = 1
     * @example 12.05 EUR = 12.05
     *
     * @see \MLocati\PayWay\Verify\Response::setAdditionalFeeAsCents()
     */
    public function setAdditionalFeeAsFloat($value)
    {
        return $this->setAdditionalFeeAsCents(empty($value) ? $value : round((float) $value * 100.));
    }

    /**
     * @var int|null
     *
     * @example 0.07 EUR = 7
     * @example 1.00 EUR = 100
     * @example 12.05 EUR = 1205
     *
     * @see \MLocati\PayWay\Verify\Response::getAdditionalFeeAsFloat()
     */
    public function getAdditionalFeeAsCents()
    {
        return $this->additionalFee;
    }

    /**
     * @param int|null $value
     *
     * @return $this
     *
     * @example 0.07 EUR = 7
     * @example 1.00 EUR = 100
     * @example 12.05 EUR = 1205
     *
     * @see \MLocati\PayWay\Verify\Response::setAdditionalFeeAsFloat()
     */
    public function setAdditionalFeeAsCents($value)
    {
        $this->additionalFee = $value === null || $value === '' ? null : (int) $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setStatus($value)
    {
        $this->status = (string) $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccountName()
    {
        return $this->accountName;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setAccountName($value)
    {
        $this->accountName = (string) $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getNssResult()
    {
        return $this->nssResult;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setNssResult($value)
    {
        $this->nssResult = (string) $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getTopUpID()
    {
        return $this->topUpID;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setTopUpID($value)
    {
        $this->topUpID = (string) $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getPayloadContent()
    {
        return $this->payloadContent;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setPayloadContent($value)
    {
        $this->payloadContent = (string) $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getPayloadContentType()
    {
        return $this->payloadContentType;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setPayloadContentType($value)
    {
        $this->payloadContentType = (string) $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getPayTraceData()
    {
        return $this->payTraceData;
    }

    /**
     * @return $this
     */
    public function setPayTraceData(array $value)
    {
        $this->payTraceData = [];
        foreach ($value as $key => $item) {
            $this->addPayTraceData($key, $item);
        }

        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return $this
     */
    public function addPayTraceData($key, $value)
    {
        $this->payTraceData[(string) $key] = (string) $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getPayAddData()
    {
        return $this->payAddData;
    }

    /**
     * @return $this
     */
    public function setPayAddData(array $value)
    {
        $this->payAddData = [];
        foreach ($value as $key => $item) {
            $this->addPayAddData($key, $item);
        }

        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return $this
     */
    public function addPayAddData($key, $value)
    {
        $this->payAddData[(string) $key] = (string) $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getPayUserRef()
    {
        return $this->payUserRef;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setPayUserRef($value)
    {
        $this->payUserRef = (string) $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getShopUserMobilePhone()
    {
        return $this->shopUserMobilePhone;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setShopUserMobilePhone($value)
    {
        $this->shopUserMobilePhone = (string) $value;

        return $this;
    }

    /**
     * @return string
     *
     * @see \MLocati\PayWay\Dictionary\ScaExemptionType
     */
    public function getScaExemptionType()
    {
        return $this->scaExemptionType;
    }

    /**
     * @param string $value
     *
     * @return $this
     *
     * @see \MLocati\PayWay\Dictionary\ScaExemptionType
     */
    public function setScaExemptionType($value)
    {
        $this->scaExemptionType = (string) $value;

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
        return $this->jsonSerializeBasePaymentInitResponse() + $this->cleanupJson([
            'paymentID' => $this->paymentID,
            'tranID' => $this->tranID,
            'authCode' => $this->authCode,
            'enrStatus' => $this->enrStatus,
            'authStatus' => $this->authStatus,
            'eci' => $this->eci,
            'brand' => $this->brand,
            'acquirerID' => $this->acquirerID,
            'maskedPan' => $this->maskedPan,
            'addInfo1' => $this->addInfo1,
            'addInfo2' => $this->addInfo2,
            'addInfo3' => $this->addInfo3,
            'addInfo4' => $this->addInfo4,
            'addInfo5' => $this->addInfo5,
            'payInstrToken' => $this->payInstrToken,
            'expireMonth' => $this->expireMonth,
            'expireYear' => $this->expireYear,
            'level3Info' => $this->level3Info === null ? null : $this->level3Info->jsonSerialize(),
            'additionalFee' => $this->additionalFee,
            'status' => $this->status,
            'accountName' => $this->accountName,
            'nssResult' => $this->nssResult,
            'topUpID' => $this->topUpID,
            'payloadContent' => $this->payloadContent,
            'payloadContentType' => $this->payloadContentType,
            'payTraceData' => $this->payTraceData,
            'payAddData' => $this->payAddData,
            'payUserRef' => $this->payUserRef,
            'shopUserMobilePhone' => $this->shopUserMobilePhone,
            'scaExemptionType' => $this->scaExemptionType,
        ]);
    }
    
    /**
     * {@inheritdoc}
     *
     * see \MLocati\PayWay\Service\BaseResponseTrait::getSignatureFields()
     */
    protected function getSignatureFields()
    {
        return [
            $this->tid,,
            $this->shopID,,
            $this->rc,,
            $this->errorDesc,,
            $this->paymentID,,
            (string) $this->tranID,,
            $this->authCode,,
            $this->enrStatus,,
            $this->authStatus,
        ];
    }
}
