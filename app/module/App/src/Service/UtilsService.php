<?php

namespace App\Service;

use DateTime;

class UtilsService
{

    /**
     * @param ?string $date
     *
     * @return DateTime
     */
    public static function extractDate(?string $date): DateTime
    {
        if (false === $date) {
            return new DateTime();
        }
        return (new DateTime())->setTimestamp($date);
    }

}
