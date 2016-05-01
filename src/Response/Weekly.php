<?php
namespace Horoscope\Lib\Response;

use \Horoscope\Lib\Response\Response;

final class Weekly extends Response
{
    public function __construct($data, $type)
    {
        parent::__construct($data, $type);
    }

    public function weekly($sign)
    {
        return $this->respond($sign);
    }
}