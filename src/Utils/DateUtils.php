<?php

namespace App\Utils;

class DateUtils
{
    public static function validateDate(string $date)
    {
        return preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1]).(0[1-9]|1[0-2]).[0-9]{4}$/",$date);
    }
}
