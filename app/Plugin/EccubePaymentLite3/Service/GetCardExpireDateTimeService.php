<?php

namespace Plugin\EccubePaymentLite3\Service;

use DateTime;
use Exception;

class GetCardExpireDateTimeService
{
    /**
     * Get card expire info
     * @param $cardExpire
     * @return DateTime
     * @throws Exception
     */
    public function getCardExpire($cardExpire)
    {
        $arr = explode('/', $cardExpire);
        $cardExpireYear = $arr[0];
        $cardExpireMonth = $arr[1];

        return new DateTime('last day of '.$cardExpireYear.'-'.$cardExpireMonth);
    }
}
