<?php
namespace Horoscope\Lib;

class Config
{
    /**
     * The class config
     * @var array
     */
    protected $config;

    /**
     * The currently selected language
     * @var string
     */
    protected $lang;

    /**
     * The currently selected type
     * @var string
     */
    protected $type;
    /**
     * Currently supported languages.
     * @var array
     */
    protected $languages;
    /**
     * Currently supported types.
     * @var array
     */
    protected $types;

    /**
     * Config constructor.
     * Year wont be used in the current version.
     * @param $year string The selected year
     */
    public function __construct($year = null)
    {
        $en_endpoint = 'http://new.theastrologer.com';
        $np_endpoint = 'http://baralguru.com';

        $year = '%E0%A5%A8%E0%A5%A6%E0%A5%AD%E0%A5%A9';//this is year 2073

        $this->languages = array('en', 'np');
        $this->types = array('daily', 'weekly', 'monthly', 'yearly');

        $this->config = array(
            'en' => array(
                'daily' => sprintf('%s/%s', $en_endpoint, 'daily-horoscope'),
                'weekly' => sprintf('%s/%s', $en_endpoint, 'weekly-horoscope'),
                'monthly' => sprintf('%s/%s', $en_endpoint, 'monthly-horoscope'),
                'yearly' => sprintf('%s/%s', $en_endpoint, sprintf('%d-horoscope', date('Y')))
            ),
            'np' => array(
                'daily' => sprintf('%s/%s-%s', $np_endpoint, 'aajako-rashifal','%E0%A4%86%E0%A4%9C%E0%A4%95%E0%A5%8B-%E0%A4%B0%E0%A4%BE%E0%A4%B6%E0%A4%BF%E0%A4%AB%E0%A4%B2'),
                'weekly' => sprintf('%s/%s', $np_endpoint, 'weekly-horoscope-2'),
                'monthly' => sprintf('%s/%s-%s', $np_endpoint, 'monthly-horoscope','%E0%A4%AE%E0%A4%BE%E0%A4%B8%E0%A4%BF%E0%A4%95-%E0%A4%B0%E0%A4%BE%E0%A4%B6%E0%A4%BF%E0%A4%AB%E0%A4%B2'),
                'yearly' => sprintf('%s/%s', $np_endpoint, $year . '-%E0%A4%B5%E0%A4%BE%E0%A4%B0%E0%A5%8D%E0%A4%B7%E0%A4%BF%E0%A4%95-%E0%A4%B0%E0%A4%BE%E0%A4%B6%E0%A4%BF%E0%A4%AB%E0%A4%B2')
            )
        );
    }

    /**
     * Initialize the class
     * @param $lang
     * @param $type
     * @return $this;
     */
    public function init($lang, $type)
    {
        $this->lang = $lang;
        $this->type = $type;

        return $this;
    }

    /**
     * Get url for a particular language and type
     * @param null $lang
     * @param null $type
     * @return bool
     */
    public function get($lang = null, $type = null)
    {
        if (!is_null($lang)) {
            $this->lang = $lang;
        }

        if (!is_null($type)) {
            $this->type = $type;
        }

        $config = $this->config;
        if (!isset($config[$this->lang])) {
            return false;
        }

        $config = $config[$this->lang];

        return isset($config[$this->type]) ? $config[$this->type] : $config['daily'];
    }

    /**
     * Checks whether the current type is valid or not.
     * @param $type
     * @return mixed
     */
    public function isValidType($type)
    {
        return in_array(strtolower($type), $this->types);
    }

    /**
     * Checks whether the supplied language is currently supported or not.
     * @param $lang
     * @return mixed
     */
    public function isSupportedLanguage($lang)
    {
        return in_array(strtolower($lang), $this->languages);
    }
}