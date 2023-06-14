<?php

namespace MLocati\PayWay\Init;

use DateTime;
use DateTimeInterface;
use JsonSerializable;
use MLocati\PayWay\Dictionary;
use MLocati\PayWay\Exception;
use MLocati\PayWay\Service;

class Request implements JsonSerializable
{
    use Service\BasePaymentInitRequestTrait {
        jsonSerialize as jsonSerializeBasePaymentInitRequest;
    }

    /**
     * The customer ID (eg. email address).
     * If it's an email address, a notification email will be sent to it.
     *
     * @var string
     */
    private $shopUserRef = '';

    /**
     * The customer last and first name, separated by a comma.
     *
     * @var string
     *
     * @example doe,john
     */
    private $shopUserName = '';

    /**
     * The customer account from the merchant portal.
     *
     * @var string
     */
    private $shopUserAccount = '';

    /**
     * The customer mobile phone.
     *
     * @var string
     */
    private $shopUserMobilePhone = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $shopUserIMEI = '';

    /**
     * The type of the request.
     *
     * @var string
     *
     * @see \MLocati\PayWay\Dictionary\TrType
     */
    private $trType = Dictionary\TrType::CODE_PURCHASE;

    /**
     * The virtual amount in decimal.
     * Mandatory with trType PURCHASE o AUTH.
     * Optional with trType VERIFY.
     *
     * @var int|null
     *
     * @example 0.07 EUR = 7
     * @example 1.00 EUR = 100
     * @example 12.05 EUR = 1205
     */
    private $amount;

    /**
     * The currency ISO code.
     * Mandatory with trType PURCHASE o AUTH.
     * Optional with trType VERIFY.
     *
     * @var string
     *
     * @see \MLocati\PayWay\Dictionary\Currency
     *
     * @example 'EUR'
     * @example 'USD'
     */
    private $currencyCode = Dictionary\Currency::CODE_EUR;

    /**
     * The ISO 639—2 code of the language used for the data entry payment page.
     *
     * @var string
     *
     * @see \MLocati\PayWay\Dictionary\Language
     *
     * @example 'IT'
     * @example 'EN'
     */
    private $langID = Dictionary\Language::CODE_ITALIAN;

    /**
     * The URL relating to the request outcome notification page.
     *
     * @var string
     */
    private $notifyURL = '';

    /**
     * The URL relating to the error page associated with a request.
     * The error cause is returned by the addition query string parameter rc.
     * This URL will be called only incase of technical problems: if the transaction has a negative outcome (eg lack of funds) it is redirected to the notifyURL.
     *
     * @var string
     */
    private $errorURL = '';

    /**
     * The URL for Server2Server notifications.
     *
     * @var string
     *
     * @see \MLocati\PayWay\Server2Server\RequestData
     */
    private $callbackURL = '';

    /**
     * The field #1 available to merchant.
     *
     * @var string
     */
    private $addInfo1 = '';

    /**
     * The field #2 available to merchant.
     *
     * @var string
     */
    private $addInfo2 = '';

    /**
     * The field #3 available to merchant.
     *
     * @var string
     */
    private $addInfo3 = '';

    /**
     * The field #4 available to merchant.
     *
     * @var string
     */
    private $addInfo4 = '';

    /**
     * The field #5 available to merchant.
     *
     * @var string
     */
    private $addInfo5 = '';

    /**
     * The token ID associated to the payment instrument.
     * Used when the card number tokenization is set to EXTERNAL instead of AUTOGEN.
     *
     * @var string
     */
    private $payInstrToken = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $billingID = '';

    /**
     * Should a new token be generated?
     *
     * @var bool|null
     */
    private $regenPayInstrToken;

    /**
     * Undocumented.
     *
     * @var bool|null
     */
    private $keepOnRegenPayInstrToken;

    /**
     * Undocumented.
     *
     * @var \DateTimeInterface|null
     */
    private $payInstrTokenExpire;

    /**
     * Undocumented.
     *
     * @var int|null
     */
    private $payInstrTokenUsageLimit;

    /**
     * Undocumented.
     *
     * @var string
     */
    private $payInstrTokenAlg = '';

    /**
     * The holder last and first name, separated by a comma, for prefilling respective fields.
     *
     * @var string
     *
     * @example doe,john
     */
    private $accountName = '';

    /**
     * Undocumented.
     *
     * @var \MLocati\PayWay\Service\Level3Info|null
     */
    private $level3Info;

    /**
     * Undocumented.
     *
     * @var \MLocati\PayWay\Service\MandateInfo|null
     */
    private $mandateInfo;

    /**
     * The payment description.
     *
     * @var string
     */
    private $description = '';

    /**
     * The payment reason.
     *
     * @var string
     */
    private $paymentReason = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $freeText = '';

    /**
     * Undocumented.
     *
     * @var string
     */
    private $topUpID = '';

    /**
     * Undocumented.
     *
     * @var bool|null
     */
    private $firstTopUp;

    /**
     * Undocumented.
     *
     * @var bool|null
     */
    private $payInstrTokenAsTopUpID;

    /**
     * @deprecated Use txIndicatorType
     *
     * @var bool|null
     */
    private $recurrentIndicator;

    /**
     * The transaction indicator type.
     *
     * @var string
     *
     * @see \MLocati\PayWay\Dictionary\TxIndicatorType
     */
    private $txIndicatorType = '';

    /**
     * The transaction identifier for recurrent/unscheduled payments.
     *
     * @var string
     */
    private $traceChainId = '';

    /**
     * The SCA exemption type reguested by merchant.
     *
     * @var string
     *
     * @see \MLocati\PayWay\Dictionary\ScaExemptionType
     */
    private $scaExemptionType = '';

    /**
     * The transaction validity date/time limit (valid only for external payment instrument).
     *
     * @var \DateTimeInterface|null
     */
    private $validityExpire;

    /**
     * Undocumented.
     *
     * @var int|null
     */
    private $minExpireMonth;

    /**
     * Undocumented.
     *
     * @var int|null
     */
    private $minExpireYear;

    /**
     * Undocumented.
     *
     * @var \MLocati\PayWay\Service\TermInfo[]
     */
    private $termInfos = [];

    /**
     * Undocumented.
     *
     * @var array
     */
    private $payInstrAddData = [];

    /**
     * Get the customer ID (eg. email address).
     * If it's an email address, a notification email will be sent to it.
     *
     * @return string
     */
    public function getShopUserRef()
    {
        return $this->shopUserRef;
    }

    /**
     * Set the customer ID (eg. email address).
     * If it's an email address, a notification email will be sent to it.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setShopUserRef($value)
    {
        $this->shopUserRef = (string) $value;

        return $this;
    }

    /**
     * Get the customer last and first name, separated by a comma.
     *
     * @return string
     *
     * @example doe,john
     */
    public function getShopUserName()
    {
        return $this->shopUserName;
    }

    /**
     * Set the customer last and first name, separated by a comma.
     *
     * @param string $value
     *
     * @return $this
     *
     * @example doe,john
     */
    public function setShopUserName($value)
    {
        $this->shopUserName = (string) $value;

        return $this;
    }

    /**
     * Get the customer account from the merchant portal.
     *
     * @return string
     */
    public function getShopUserAccount()
    {
        return $this->shopUserAccount;
    }

    /**
     * Set the customer account from the merchant portal.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setShopUserAccount($value)
    {
        $this->shopUserAccount = (string) $value;

        return $this;
    }

    /**
     * Get the customer mobile phone.
     *
     * @return string
     */
    public function getShopUserMobilePhone()
    {
        return $this->shopUserMobilePhone;
    }

    /**
     * Set the customer mobile phone.
     *
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
     * Undocumented.
     *
     * @return string
     */
    public function getShopUserIMEI()
    {
        return $this->shopUserIMEI;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setShopUserIMEI($value)
    {
        $this->shopUserIMEI = (string) $value;

        return $this;
    }

    /**
     * Get the type of the request.
     *
     * @return string
     *
     * @see \MLocati\PayWay\Dictionary\TrType
     */
    public function getTrType()
    {
        return $this->trType;
    }

    /**
     * Set the type of the request.
     *
     * @param string $value
     *
     * @return $this
     *
     * @see \MLocati\PayWay\Dictionary\TrType
     */
    public function setTrType($value)
    {
        $this->trType = (string) $value;

        return $this;
    }

    /**
     * Get the virtual amount (as a floating number).
     *
     * @return float|int|null
     *
     * @example 0.07 EUR = 0.07
     * @example 1.00 EUR = 1
     * @example 12.05 EUR = 12.05
     *
     * @see \MLocati\PayWay\Init\Request::getAmountAsCents()
     */
    public function getAmountAsFloat()
    {
        return $this->amount === null ? null : ((float) $this->amount) / 100.;
    }

    /**
     * Set the virtual amount (as a floating number).
     *
     * @param float|int|null $value
     *
     * @return $this
     *
     * @example 0.07 EUR = 0.07
     * @example 1.00 EUR = 1
     * @example 12.05 EUR = 12.05
     *
     * @see \MLocati\PayWay\Init\Request::setAmountAsCents()
     */
    public function setAmountAsFloat($value)
    {
        return $this->setAmountAsCents(empty($value) ? $value : round((float) $value * 100.));
    }

    /**
     * Get the virtual amount (in decimal).
     *
     * @var int|null
     *
     * @example 0.07 EUR = 7
     * @example 1.00 EUR = 100
     * @example 12.05 EUR = 1205
     *
     * @see \MLocati\PayWay\Init\Request::getAmountAsFloat()
     */
    public function getAmountAsCents()
    {
        return $this->amount;
    }

    /**
     * Set the virtual amount (as a floating number).
     *
     * @param int|null $value
     *
     * @return $this
     *
     * @example 0.07 EUR = 7
     * @example 1.00 EUR = 100
     * @example 12.05 EUR = 1205
     *
     * @see \MLocati\PayWay\Init\Request::setAmountAsFloat()
     */
    public function setAmountAsCents($value)
    {
        $this->amount = $value === null || $value === '' ? null : (int) $value;

        return $this;
    }

    /**
     * Get the currency ISO code.
     * Mandatory with trType PURCHASE o AUTH.
     * Optional with trType VERIFY.
     *
     * @return string
     *
     * @example 'EUR'
     * @example 'USD'
     *
     * @see \MLocati\PayWay\Dictionary\Currency
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * Set the currency ISO code.
     * Mandatory with trType PURCHASE o AUTH.
     * Optional with trType VERIFY.
     *
     * @param string $value
     *
     * @return $this
     *
     * @example 'EUR'
     * @example 'USD'
     *
     * @see \MLocati\PayWay\Dictionary\Currency
     */
    public function setCurrencyCode($value)
    {
        $this->currencyCode = strtoupper((string) $value);

        return $this;
    }

    /**
     * Get the ISO 639—2 code of the language used for the data entry payment page.
     *
     * @return string
     *
     * @see \MLocati\PayWay\Dictionary\Language
     *
     * @example 'IT'
     * @example 'EN'
     */
    public function getLangID()
    {
        return $this->langID;
    }

    /**
     * Set the ISO 639—2 code of the language used for the data entry payment page.
     *
     * @param string $value
     *
     * @return $this
     *
     * @see \MLocati\PayWay\Dictionary\Language
     *
     * @example 'IT'
     * @example 'EN'
     */
    public function setLangID($value)
    {
        $this->langID = (string) $value;

        return $this;
    }

    /**
     * Get the URL relating to the request outcome notification page.
     *
     * @return string
     */
    public function getNotifyURL()
    {
        return $this->notifyURL;
    }

    /**
     * Set the URL relating to the request outcome notification page.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setNotifyURL($value)
    {
        $this->notifyURL = (string) $value;

        return $this;
    }

    /**
     * Get the URL relating to the error page associated with a request.
     * The error cause is returned by the addition query string parameter rc.
     * This URL will be called only incase of technical problems: if the transaction has a negative outcome (eg lack of funds) it is redirected to the notifyURL.
     *
     * @return string
     */
    public function getErrorURL()
    {
        return $this->errorURL;
    }

    /**
     * Set the URL relating to the error page associated with a request.
     * The error cause is returned by the addition query string parameter rc.
     * This URL will be called only incase of technical problems: if the transaction has a negative outcome (eg lack of funds) it is redirected to the notifyURL.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setErrorURL($value)
    {
        $this->errorURL = (string) $value;

        return $this;
    }

    /**
     * Get the URL for Server2Server notifications.
     *
     * @return string
     *
     * @see \MLocati\PayWay\Server2Server\RequestData
     */
    public function getCallbackURL()
    {
        return $this->callbackURL;
    }

    /**
     * Set the URL for Server2Server notifications.
     *
     * @param string $value
     *
     * @return $this
     *
     * @see \MLocati\PayWay\Server2Server\RequestData
     */
    public function setCallbackURL($value)
    {
        $this->callbackURL = (string) $value;

        return $this;
    }

    /**
     * Get the field #1 available to merchant.
     *
     * @return string
     */
    public function getAddInfo1()
    {
        return $this->addInfo1;
    }

    /**
     * Set the field #1 available to merchant.
     *
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
     * Get the field #2 available to merchant.
     *
     * @return string
     */
    public function getAddInfo2()
    {
        return $this->addInfo2;
    }

    /**
     * Set the field #2 available to merchant.
     *
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
     * Get the field #3 available to merchant.
     *
     * @return string
     */
    public function getAddInfo3()
    {
        return $this->addInfo3;
    }

    /**
     * Set the field #3 available to merchant.
     *
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
     * Get the field #4 available to merchant.
     *
     * @return string
     */
    public function getAddInfo4()
    {
        return $this->addInfo4;
    }

    /**
     * Set the field #4 available to merchant.
     *
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
     * Get the field #5 available to merchant.
     *
     * @return string
     */
    public function getAddInfo5()
    {
        return $this->addInfo5;
    }

    /**
     * Set the field #5 available to merchant.
     *
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
     * Get the token ID associated to the payment instrument.
     * Used when the card number tokenization is set to EXTERNAL instead of AUTOGEN.
     *
     * @return string
     */
    public function getPayInstrToken()
    {
        return $this->payInstrToken;
    }

    /**
     * Set the token ID associated to the payment instrument.
     * Used when the card number tokenization is set to EXTERNAL instead of AUTOGEN.
     *
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
     * Undocumented.
     *
     * @return string
     */
    public function getBillingID()
    {
        return $this->billingID;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setBillingID($value)
    {
        $this->billingID = (string) $value;

        return $this;
    }

    /**
     * Should a new token be generated?
     *
     * @return bool|null
     */
    public function isRegenPayInstrToken()
    {
        return $this->regenPayInstrToken;
    }

    /**
     * Should a new token be generated?
     *
     * @param bool|null $value
     *
     * @return $this
     */
    public function setRegenPayInstrToken($value)
    {
        $this->regenPayInstrToken = $value === null || $value === '' ? null : (bool) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return bool|null
     */
    public function isKeepOnRegenPayInstrToken()
    {
        return $this->keepOnRegenPayInstrToken;
    }

    /**
     * Undocumented.
     *
     * @param bool|null $value
     *
     * @return $this
     */
    public function setKeepOnRegenPayInstrToken($value)
    {
        $this->keepOnRegenPayInstrToken = $value === null || $value === '' ? null : (bool) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return \DateTimeInterface|null
     */
    public function getPayInstrTokenExpire()
    {
        return $this->payInstrTokenExpire;
    }

    /**
     * Undocumented.
     *
     * @return $this
     */
    public function setPayInstrTokenExpire(DateTimeInterface $value = null)
    {
        $this->payInstrTokenExpire = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return int|null
     */
    public function getPayInstrTokenUsageLimit()
    {
        return $this->payInstrTokenUsageLimit;
    }

    /**
     * Undocumented.
     *
     * @param int|null $value
     *
     * @return $this
     */
    public function setPayInstrTokenUsageLimit($value)
    {
        $this->payInstrTokenUsageLimit = $value === null || $value === '' ? null : (int) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getPayInstrTokenAlg()
    {
        return $this->payInstrTokenAlg;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setPayInstrTokenAlg($value)
    {
        $this->payInstrTokenAlg = (string) $value;

        return $this;
    }

    /**
     * Get the holder last and first name, separated by a comma, for prefilling respective fields.
     *
     * @return string
     *
     * @example doe,john
     */
    public function getAccountName()
    {
        return $this->accountName;
    }

    /**
     * Set the holder last and first name, separated by a comma, for prefilling respective fields.
     *
     * @param string $value
     *
     * @return $this
     *
     * @example doe,john
     */
    public function setAccountName($value)
    {
        $this->accountName = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
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
     * Undocumented.
     *
     * @return \MLocati\PayWay\Service\MandateInfo
     */
    public function getMandateInfo()
    {
        if ($this->mandateInfo === null) {
            $this->mandateInfo = new Service\MandateInfo();
        }

        return $this->mandateInfo;
    }

    /**
     * @return $this
     */
    public function setMandateInfo(Service\MandateInfo $value)
    {
        $this->mandateInfo = $value;

        return $this;
    }

    /**
     * Get payment description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set payment description.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setDescription($value)
    {
        $this->description = (string) $value;

        return $this;
    }

    /**
     * Get the payment reason.
     *
     * @return string
     */
    public function getPaymentReason()
    {
        return $this->paymentReason;
    }

    /**
     * Set the payment reason.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setPaymentReason($value)
    {
        $this->paymentReason = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getFreeText()
    {
        return $this->freeText;
    }

    /**
     * Undocumented.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setFreeText($value)
    {
        $this->freeText = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return string
     */
    public function getTopUpID()
    {
        return $this->topUpID;
    }

    /**
     * Undocumented.
     *
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
     * Undocumented.
     *
     * @return bool|null
     */
    public function isFirstTopUp()
    {
        return $this->firstTopUp;
    }

    /**
     * Undocumented.
     *
     * @param bool|null $value
     *
     * @return $this
     */
    public function setFirstTopUp($value)
    {
        $this->firstTopUp = $value === null || $value === '' ? null : (bool) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return bool|null
     */
    public function isPayInstrTokenAsTopUpID()
    {
        return $this->payInstrTokenAsTopUpID;
    }

    /**
     * Undocumented.
     *
     * @param bool|null $value
     *
     * @return $this
     */
    public function setPayInstrTokenAsTopUpID($value)
    {
        $this->payInstrTokenAsTopUpID = $value === null || $value === '' ? null : (bool) $value;

        return $this;
    }

    /**
     * @deprecated Use txIndicatorType
     *
     * @return bool|null
     */
    public function isRecurrentIndicator()
    {
        return $this->recurrentIndicator;
    }

    /**
     * @deprecated Use txIndicatorType
     *
     * @param bool|null $value
     *
     * @return $this
     */
    public function setRecurrentIndicator($value)
    {
        $this->recurrentIndicator = $value === null || $value === '' ? null : (bool) $value;

        return $this;
    }

    /**
     * Get the transaction indicator type.
     *
     * @return string
     *
     * @see \MLocati\PayWay\Dictionary\TxIndicatorType
     */
    public function getTxIndicatorType()
    {
        return $this->txIndicatorType;
    }

    /**
     * Set the transaction indicator type.
     *
     * @param string $value
     *
     * @return $this
     *
     * @see \MLocati\PayWay\Dictionary\TxIndicatorType
     */
    public function setTxIndicatorType($value)
    {
        $this->txIndicatorType = (string) $value;

        return $this;
    }

    /**
     * Get the transaction identifier for recurrent/unscheduled payments.
     *
     * @return string
     */
    public function getTraceChainId()
    {
        return $this->traceChainId;
    }

    /**
     * Set the transaction identifier for recurrent/unscheduled payments.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setTraceChainId($value)
    {
        $this->traceChainId = (string) $value;

        return $this;
    }

    /**
     * Get the SCA exemption type reguested by merchant.
     *
     * @return string
     *
     * @see \MLocati\PayWay\Dictionary\ScaExemptionType
     */
    public function getScaExemptionType()
    {
        return $this->scaExemptionType;
    }

    /**
     * Set the SCA exemption type reguested by merchant.
     *
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
     * Get the transaction validity date/time limit (valid only for external payment instrument).
     *
     * @return \DateTimeInterface|null
     */
    public function getValidityExpire()
    {
        return $this->validityExpire;
    }

    /**
     * Set the transaction validity date/time limit (valid only for external payment instrument).
     *
     * @return $this
     */
    public function setValidityExpire(DateTimeInterface $value = null)
    {
        $this->validityExpire = (string) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return int|null
     */
    public function getMinExpireMonth()
    {
        return $this->minExpireMonth;
    }

    /**
     * Undocumented.
     *
     * @param int|null $value
     *
     * @return $this
     */
    public function setMinExpireMonth($value)
    {
        return $this->minExpireMonth = $value === null || $value === '' ? null : (int) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return int|null
     */
    public function getMinExpireYear()
    {
        return $this->minExpireYear;
    }

    /**
     * Undocumented.
     *
     * @param int|null $value
     *
     * @return $this
     */
    public function setMinExpireYear($value)
    {
        return $this->minExpireYear = $value === null || $value === '' ? null : (int) $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return \MLocati\PayWay\Service\TermInfo[]
     */
    public function getTermInfos()
    {
        return $this->termInfos;
    }

    /**
     * Undocumented.
     *
     * @param \MLocati\PayWay\Service\TermInfo[] $value
     *
     * @return $this
     */
    public function setTermInfos(array $value)
    {
        $this->termInfos = [];
        foreach ($value as $item) {
            $this->addTermInfo($item);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function addTermInfo(Service\TermInfo $value)
    {
        $this->termInfos[] = $value;

        return $this;
    }

    /**
     * Undocumented.
     *
     * @return array
     */
    public function getPayInstrAddData()
    {
        return $this->payInstrAddData;
    }

    /**
     * Undocumented.
     *
     * @return $this
     */
    public function setPayInstrAddData(array $value)
    {
        $this->payInstrAddData = [];
        foreach ($value as $key => $item) {
            $this->addPayInstrAddData($key, $item);
        }

        return $this;
    }

    /**
     * Undocumented.
     *
     * @param string $key
     * @param string $value
     *
     * @return $this
     */
    public function addPayInstrAddData($key, $value)
    {
        $this->payInstrAddData[(string) $key] = (string) $value;

        return $this;
    }

    /**
     * @throws \MLocati\PayWay\Exception\MissingRequiredField
     * @throws \MLocati\PayWay\Exception\FieldValueTooLong
     * @throws \MLocati\PayWay\Exception\FieldValueOutOfRange
     * @throws \MLocati\PayWay\Exception\InvalidFieldUrl
     */
    public function check()
    {
        $this->checkBasePaymentInitRequest();
        $this->checkStringField('shopUserRef', false, 256);
        $this->checkStringField('shopUserName', false, 256);
        $this->checkStringField('shopUserAccount', false, 64);
        $this->checkStringField('shopUserMobilePhone', false, 32);
        $this->checkEnumField('trType', true, Dictionary\TrType::getList());
        switch ($this->trType) {
            case Dictionary\TrType::CODE_PURCHASE:
            case Dictionary\TrType::CODE_AUTH:
                if ($this->amount === null) {
                    throw new Exception\MissingRequiredField('amount');
                }
                break;
        }
        $this->checkEnumField('currencyCode', $this->amount !== null, Dictionary\Currency::getAvailableCodes());
        $this->checkEnumField('langID', true, Dictionary\Language::getAvailableCodes());
        $this->checkUrlField('notifyURL', true, 512);
        $this->checkUrlField('errorURL', true, 512);
        $this->checkUrlField('callbackURL', false, 512);
        $this->checkStringField('addInfo1', false, 256);
        $this->checkStringField('addInfo2', false, 256);
        $this->checkStringField('addInfo3', false, 256);
        $this->checkStringField('addInfo4', false, 256);
        $this->checkStringField('addInfo5', false, 256);
        $this->checkStringField('payInstrToken', false, 256);
        $this->checkStringField('accountName', false, 36);
        if ($this->level3Info !== null) {
            if ($this->level3Info->getSenderCountryCode() !== '' && !in_array($this->level3Info->getSenderCountryCode(), Dictionary\Country::getAvailableCodes(), true)) {
                throw new Exception\FieldValueOutOfRange('level3Info.senderCountryCode', Dictionary\Country::getAvailableCodes());
            }
            if ($this->level3Info->getDestinationCountryCode() !== '' && !in_array($this->level3Info->getDestinationCountryCode(), Dictionary\Country::getAvailableCodes(), true)) {
                throw new Exception\FieldValueOutOfRange('level3Info.destinationCountryCode', Dictionary\Country::getAvailableCodes());
            }
            if ($this->level3Info->getBillingCountryCode() !== '' && !in_array($this->level3Info->getBillingCountryCode(), Dictionary\Country::getAvailableCodes(), true)) {
                throw new Exception\FieldValueOutOfRange('level3Info.billingCountryCode', Dictionary\Country::getAvailableCodes());
            }
            $num = count($this->level3Info->getProducts());
            if ($num > 10) {
                throw new Exception\FieldValueTooLong('level3Info.product', 10);
            }
        }
        $this->checkStringField('description', false, 100);
        $this->checkStringField('paymentReason', false, 99);
        $this->checkEnumField('txIndicatorType', false, Dictionary\TxIndicatorType::getList());
        $this->checkStringField('traceChainId', false, 36);
        $this->checkEnumField('scaExemptionType', false, Dictionary\ScaExemptionType::getList());
    }

    /**
     * {@inheritdoc}
     *
     * @see \JsonSerializable::jsonSerialize()
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->jsonSerializeBasePaymentInitRequest() + $this->cleanupJson([
            'shopUserRef' => $this->shopUserRef,
            'shopUserName' => $this->shopUserName,
            'shopUserAccount' => $this->shopUserAccount,
            'shopUserMobilePhone' => $this->shopUserMobilePhone,
            'shopUserIMEI' => $this->shopUserIMEI,
            'trType' => $this->trType,
            'amount' => $this->amount,
            'currencyCode' => $this->currencyCode,
            'langID' => $this->langID,
            'notifyURL' => $this->notifyURL,
            'errorURL' => $this->errorURL,
            'callbackURL' => $this->callbackURL,
            'addInfo1' => $this->addInfo1,
            'addInfo2' => $this->addInfo2,
            'addInfo3' => $this->addInfo3,
            'addInfo4' => $this->addInfo4,
            'addInfo5' => $this->addInfo5,
            'payInstrToken' => $this->payInstrToken,
            'billingID' => $this->billingID,
            'regenPayInstrToken' => $this->regenPayInstrToken,
            'keepOnRegenPayInstrToken' => $this->keepOnRegenPayInstrToken,
            'payInstrTokenExpire' => $this->payInstrTokenExpire === null ? '' : $this->payInstrTokenExpire->format(DateTime::RFC3339),
            'payInstrTokenUsageLimit' => $this->payInstrTokenUsageLimit,
            'payInstrTokenAlg' => $this->payInstrTokenAlg,
            'accountName' => $this->accountName,
            'level3Info' => $this->level3Info === null ? null : $this->level3Info->jsonSerialize(),
            'mandateInfo' => $this->mandateInfo === null ? null : $this->mandateInfo->jsonSerialize(),
            'description' => $this->description,
            'paymentReason' => $this->paymentReason,
            'freeText' => $this->freeText,
            'topUpID' => $this->topUpID,
            'firstTopUp' => $this->firstTopUp,
            'payInstrTokenAsTopUpID' => $this->payInstrTokenAsTopUpID,
            'recurrentIndicator' => $this->recurrentIndicator,
            'txIndicatorType' => $this->txIndicatorType,
            'traceChainId' => $this->traceChainId,
            'scaExemptionType' => $this->scaExemptionType,
            'validityExpire' => $this->validityExpire === null ? null : $this->validityExpire->format(DateTime::RFC3339),
            'minExpireMonth' => $this->minExpireMonth,
            'minExpireYear' => $this->minExpireYear,
            'termInfo' => array_map(static function (Service\TermInfo $termInfo) {
                return $termInfo->jsonSerialize();
            }, $this->termInfos),
            'payInstrAddData' => $this->payInstrAddData,
        ]);
    }

    protected function getSignatureFields()
    {
        return [
            $this->apiVersion,
            $this->tid,
            $this->merID,
            $this->payInstr,
            $this->shopID,
            $this->shopUserRef,
            $this->shopUserName,
            $this->shopUserAccount,
            $this->shopUserMobilePhone,
            $this->shopUserIMEI,
            $this->trType,
            (string) $this->amount,
            $this->currencyCode,
            $this->langID,
            $this->notifyURL,
            $this->errorURL,
            $this->callbackURL,
            $this->addInfo1,
            $this->addInfo2,
            $this->addInfo3,
            $this->addInfo4,
            $this->addInfo5,
            $this->payInstrToken,
            $this->topUpID,
        ];
    }
}
