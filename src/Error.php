<?php
namespace Horoscope\Lib;

use Exception;

class Error extends Exception
{
    /**
     * A very simple function. Not much smooth.
     * @param $message
     * @return array
     */
    public static function response($message)
    {
        return array(
            'type' => 'error',
            'success' => 0,
            'response' => $message
        );
    }
}