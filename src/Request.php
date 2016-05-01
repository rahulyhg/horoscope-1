<?php
namespace Horoscope\Lib;

use GuzzleHttp\Client;
use Horoscope\Lib\Error as Err;

class Request
{
    /**
     * A very simple to fetch a url and return the response
     * using Guzzle.
     * @param $url
     * @return \Psr\Http\Message\StreamInterface
     */
    public static function url($url)
    {
        try {
            $client = new Client();
            $res = $client->request('GET', $url);
            return $res->getBody();
        } catch (\Exception $e) {
            Err::response($e->getMessage());
        }
        return false;
    }
}