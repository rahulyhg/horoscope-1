<?php
namespace Horoscope\Lib\Response;

use \Horoscope\Lib\Response\Response;

final class Monthly extends Response
{
    public function __construct($data, $type)
    {
        parent::__construct($data, $type);
    }

    public function monthly($sign)
    {
        return $this->respond($sign);
    }
}