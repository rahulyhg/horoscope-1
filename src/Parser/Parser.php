<?php
namespace Horoscope\Lib\Parser;

use Horoscope\Lib\Interfaces\Parsing;
use PHPHtmlParser\Dom;

abstract class Parser implements Parsing
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
     * @var Dom
     */
    protected $dom;

    /**
     * Parser constructor.
     * @param string $data
     * @param null $type
     */
    public function __construct($data, $type = null)
    {
        $this->raw_data = $data;
        $this->type = $type;
        $this->dom = new Dom();
    }

    /**
     * @return mixed
     */
    abstract public function parse();
}