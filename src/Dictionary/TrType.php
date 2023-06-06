<?php

namespace MLocati\PayWay\Dictionary;

use MLocati\PayWay\Service\StringList;

/**
 * PURCHASE
 * Direct accounting payment (no need to authorize it from the back office).
 *
 * AUTH
 * Authorization (the merchant must authorize the payment from the back office).
 *
 * VERIFY
 * Verify that the card to be tokenized is valid.
 * An authorization for a few cents is sent to the acquirer and immediately a request for an implicit reversal is sent.
 * No movement of the amount is made and the ceiling on the customer's card is not blocked.
 */
class TrType extends StringList
{
    const CODE_PURCHASE = 'PURCHASE';
    const CODE_AUTH = 'AUTH';
    const CODE_VERIFY = 'VERIFY';

    /**
     * @var string[]|null
     */
    protected static $list;

    protected static function getListFile()
    {
        return 'tr_type.php';
    }
}
