<?php

namespace MLocati\PayWay\Dictionary;

use MLocati\PayWay\Service\StringList;

/**
 * CIT_NOCOF: Cardholder Initiated Transaction (CIT) transaction where credentials will not be stored (eg e-commerce).
 * CIT_COF_FIRST: Cardholder Initiated Transaction (CIT) transaction where credentials will be stored for any subsequent MIT transaction (except recurrent/unscheduled).
 * CIT_COF_NEXT: Cardholder Initiated Transaction (CIT) transaction where card data are pre-compiled by stored credentials.
 * CIT_UNSCHEDULED_COF_FIRST: Cardholder Initiated Transaction (CIT) where credentials will be stored for any subsequent MIT RECURRENT transaction.
 * CIT_RECURRENT_COF_FIRST: Cardholder Initiated Transaction (CIT) transaction where credentials will be stored for any subsequent MIT RECURRENT transaction.
 * MIT_COF_NEXT: Merchant Initiated Transaction (MIT) using stored credentials.
 * MIT_UNSCHEDULED_COF_NEXT: Merchant Initiated Transaction (MIT) using stored credentials for a fixed or variable amount that does not occur on a scheduled or regularly occurring transaction date (eg subscription auto recharge)
 * MIT_RECURRENT_COF_NEXT: Merchant Initiated Transaction (MIT) processed at fixed, regular intervals, using stored credentials.
 * MIT_NOSHOW_COF_NEXT: Merchant Initiated Transaction (MIT) No Show using stored credentials.
 * MIT_DELAYCHARGE_COF_NEXT: Merchant Initiated Transaction (MIT) Delay Charge using stored credentials.
 * MOTO_NOCOF: Mail Order / Telephone Order (MOTO) transaction without using stored credentials (eg. postal mail order / telephone order).
 * MOTO_COF_FIRST: Mail Order / Telephone Order (MOTO) transaction where credentials will be stored for any subsequent MIT transaction.
 */
class ScaExemptionType extends StringList
{
    /**
     * @var string[]|null
     */
    protected static $list;

    protected static function getListFile()
    {
        return 'sca_exemption_type.php';
    }
}
