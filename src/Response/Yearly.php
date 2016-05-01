<?php
namespace Horoscope\Lib\Response;

use \Horoscope\Lib\Response\Response;

final class Yearly extends Response
{
    public function __construct($data, $type)
    {
        parent::__construct($data, $type);
    }

    public function yearly($sign)
    {
        return $this->respond($sign);
    }
}