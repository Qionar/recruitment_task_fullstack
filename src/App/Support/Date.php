<?php

namespace App\Support;

use DateTime;

class Date
{
    public static function validateByFormat($date, string $format = DateTime::ISO8601)
    {
        $formatedDate = DateTime::createFromFormat($format, $date);

        return $formatedDate && $formatedDate->format($format) === $date;
    }
}