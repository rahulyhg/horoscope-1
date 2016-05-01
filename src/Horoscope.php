<?php
namespace Horoscope\Lib;

use Horoscope\Lib\Error as Err;
use Horoscope\Lib\Config as Conf;
use Horoscope\Lib\Request;
use Horoscope\Lib\Parser;

class Horoscope
{
    protected $config;
    protected $parser;
    protected $response_namespace;
    protected static $data;

    public function __construct()
    {
        $this->config = new Conf();
        $this->parser = new Parser();
        $this->response_namespace = '\\Horoscope\\Lib\\Response\\';
    }

    public function daily($lang = 'en')
    {
        return $this->get('daily', $lang);
    }

    public function weekly($lang = 'en')
    {
        return $this->get('weekly', $lang);
    }

    public function monthly($lang = 'en')
    {
        return $this->get('monthly', $lang);
    }

    public function yearly($lang = 'en')
    {
        return $this->get('yearly', $lang);
    }

    /**
     * Fetch the horoscope now
     * @param $type
     * @param string $lang
     * @return mixed
     */
    public function get($type, $lang = 'en')
    {
        if (!$this->config->isValidType($type)) {
            return Err::response('Horoscope type not selected.');
        }

        if (!$this->config->isSupportedLanguage($lang)) {
            return Err::response(sprintf('Language %s not supported at the moment.', $lang));
        }

        if (isset(static::$data[$lang][$type])) {
            return static::$data[$lang][$type];
        }

        $this->config->init(strtolower($lang), strtolower($type));
        $url = $this->config->get();
        $response = Request::url($url);

        $response = $this->parser->initialize($response, $type, $lang)->parse();

        $response_class = $this->response_namespace . ucfirst(strtolower($type));
        static::$data[$lang][$type] = new $response_class($response, $type);

        return $this->get($type, $lang);
    }
}