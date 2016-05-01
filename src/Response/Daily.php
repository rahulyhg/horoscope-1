<?php
namespace Horoscope\Lib\Response;

use Horoscope\Lib\Response\Response;

final class Daily extends Response
{
    public function __construct($data, $type)
    {
        parent::__construct($data, $type);
    }

    public function today($sign)
    {
        return $this->respond($sign, 'today');
    }

    public function yesterday($sign)
    {
        return $this->respond($sign, 'yesterday');
    }

    public function tomorrow($sign)
    {
        return $this->respond($sign, 'tomorrow');
    }
}