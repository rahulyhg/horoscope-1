<?php
namespace Horoscope\Lib;

use \Horoscope\Lib\Interfaces\Parsing;

Class Parser implements Parsing
{
    /**
     * @var string
     */
    protected $raw_data;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $lang;

    /**
     * @var
     */
    protected $parser;

    /**
     * @var string The namespace where language specific parser is located.
     */
    protected $parser_namespace;

    /**
     * Parser constructor.
     * @param null $body
     * @param null $type
     * @param null $lang
     */
    public function __construct($body = null, $type = null, $lang = null)
    {
        $this->initialize($body, $type, $lang);
        $this->parser_namespace = '\\Horoscope\\lib\\parser\\';
    }

    /**
     * Initialize the class. Feeds the raw data, type and language to the parser.
     * @param $body
     * @param null $type
     * @param $lang
     * @return object
     */
    public function initialize($body, $type = null, $lang)
    {
        $this->raw_data = $body;
        $this->type = $type;
        $this->lang = $lang;

        return $this;
    }

    public function parse()
    {
        $parser = $this->parser_namespace . ucfirst(strtolower($this->lang));
        $this->parser = new $parser($this->raw_data, $this->type);
        return $this->parser->parse();
    }
}