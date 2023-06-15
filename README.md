[![Tests](https://github.com/mlocati/PayWay/actions/workflows/test.yml/badge.svg?branch=main)](https://github.com/mlocati/PayWay/actions/workflows/test.yml)
[![Coverage](https://coveralls.io/repos/github/mlocati/PayWay/badge.svg?branch=main)](https://coveralls.io/github/mlocati/PayWay?branch=main)

# MLocati's unofficial BCC PayWay (IGFS Buy Now) client library for PHP

> **Warning**
>
> This package is still in a development stage: **DO NOT USE IT**
>

This unofficial PHP library can help you accepting payments using the BCC (Banca di Credito Cooperativo) PayWay, which is a service powered by the IGFS (Internet Gateway Financial Systems) Buy Now service.

It supports any PHP version, ranging from PHP 5.5 to the most recent PHP versions (8.2 as for now).

## Sample usage to receive a payment

### Initialization

If you want to accept a payment for 123.45 &euro; from customers, you first need to initialize the process:

```php
use MLocati\PayWay\Init\Request;
use MLocati\PayWay\Dictionary\TrType;
use MLocati\PayWay\Dictionary\Currency;
use MLocati\PayWay\Dictionary\Language;

$request = new Request();
$request
    // Set your terminal ID
    ->setTID('YourTerminalID')
    // Set an unique identifier (of your choiche) of the transaction
    ->setShopID('Order987Attempt1')
    // Set your customer's email address (a notification email will be sent to this address)
    ->setShopUserRef('customer@email.com')
    // The user have to pay, without any back office authorization
    ->setTrType(TrType::CODE_PURCHASE)
    // You can also call setAmountAsCents(12345), which accepts integer numbers instead of floating point numbers
    ->setAmountAsFloat(123.45)
    // Set the currency: for the list of available currencies, use Currency::getDictionary()
    ->setCurrencyCode(Currency::CODE_EUR)
    // Set the language to be displayed to the customer when filling-in the data: for the list of available language, use Language::getDictionary()
    ->langID(Language::CODE_ITALIAN)
    // The page where the customer will be redirected to once your customer will have paid
    ->setNotifyURL('https://your.domain/process-completed?shopID=Order987Attempt1')
    // A page to be called in case of technical issues (please remark that if the transaction failed, the customer will be still redirected to the notifyURL page)
    ->setErrorURL('https://your.domain/whoops')
    // An optional page for Server2Server calls: it will receive a POST request with the transaction details
    ->setCallbackURL('https://your.domain/process-completed')
;
```

Next, you have to send the initialization request to your bank's web server:

```php
use MLocati\PayWay\Client;
use MLocati\PayWay\Dictionary\RC;

$client = new Client(
    'https://your.bank.com/UNI_CG_SERVICES/services',
    'Your kSig digital signature'
);

$response = $client->init($request);

if ($response->getRc() !== RC::TRANSACTION_OK || $response->isError() || $response->getRedirectURL() === '') {
    throw new \Exception('Transaction failed: ' . $response->getErrorDesc());
}
```

At this point, you you have a succesfull initialization response.
You have to store the result of `$response->getPaymentID()` for later usage (for example, in a database table).

### Customer interaction

Now you can redirect your customers to the external payment page:

```php
header('Location: ' . $response->getRedirectURL());
```

At the resulting page, the customers will fulfill a form with their credit card data.

### Verify the ransaction result

Once the customers completed the payment (or canceled it), they will return to your website, at the page specified in the notify URL.

In the notify URL page, you then have to check the result of the payment transaction.

You may want to use something like this:

```php
use MLocati\PayWay\Verify\Request;
use MLocati\PayWay\Dictionary\RC;

$shopID = isset($_GET['shopID']) && is_string($_GET['shopID']) ? $_GET['shopID'] : '';
$paymentID = retrieveStoredPaymentID($shopID);
if ($paymentID === '') {
    throw new \Exception('Unexpected shopID parameter');
}
$request = new Request();
$request
    // Set your terminal ID
    ->setTID('YourTerminalID')
    // Set the unique identifier of the transaction
    ->setShopID($shopID)
    // Set the remote server-assigned payment ID
    ->setPaymentID($paymentID)
;

$response = $client->verify($request);

if ($response->getRc() !== RC::TRANSACTION_OK || $response->isError()) {
    throw new \Exception('Transaction failed: ' . $response->getErrorDesc());
}
```

## Server2Server communication (callback URL)

If in the initialization process you configured the callback URL, you can check the received parameters by using some code like this:

```php
use MLocati\PayWay\Server2Server\RequestData;

$request = Server2Server\RequestData::createFromGlobals();
```

And you can inspect what `$request` contains to verify the transaction result (same process as above).


