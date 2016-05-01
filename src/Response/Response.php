<?php
namespace Horoscope\Lib\Response;

use Horoscope\Lib\Interfaces\Signs;

abstract class Response implements Signs
{
    /**
     * @var array The response data
     */
    protected $data;

    /**
     * @var string The type of horoscope
     */
    protected $type;

    public function __construct($data, $type)
    {
        $this->data = $data;
        $this->type = $type;
    }

    protected function respond($sign, $type = null)
    {
        $type = is_null($type) ? $this->type : $type;
        if (!isset($this->data[$type])) {
            return false;
        }

        $return = $this->data[$type];
        return isset($return[$sign]) ? $return[$sign] : '';
    }

    public function aries($type = null)
    {
        return $this->respond('aries', $type);
    }

    public function taurus($type = null)
    {
        return $this->respond('taurus', $type);
    }

    public function gemini($type = null)
    {
        return $this->respond('gemini', $type);
    }

    public function cancer($type = null)
    {
        return $this->respond('cancer', $type);
    }

    public function leo($type = null)
    {
        return $this->respond('leo', $type);
    }

    public function virgo($type = null)
    {
        return $this->respond('virgo', $type);
    }

    public function libra($type = null)
    {
        return $this->respond('libra', $type);
    }

    public function scorpio($type = null)
    {
        return $this->respond('scorpio', $type);
    }

    public function sagittarius($type = null)
    {
        return $this->respond('sagittarius', $type);
    }

    public function capricorn($type = null)
    {
        return $this->respond(null, $type);
    }

    public function aquarius($type = null)
    {
        return $this->respond('aquarius', $type);
    }

    public function pisces($type = null)
    {
        return $this->respond('pisces', $type);
    }
}