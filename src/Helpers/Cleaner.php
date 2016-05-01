<?php
namespace Horoscope\Lib\Helpers;

class Cleaner
{
    /**
     * Make sure only characters are present in the
     * sign string.
     * @param $sign
     * @return mixed
     */
    public static function sign($sign)
    {
        return preg_replace("/[^a-z]/", '', strtolower($sign));
    }
}