<?php
namespace Horoscope\Lib\Parser;

use Horoscope\Lib\Parser\Parser as LangParser;
use PHPHtmlParser\Dom;

final class Np extends LangParser
{
    /**
     * @var array
     */
    protected $i18;

    /**
     * Np constructor.
     * @param string $data
     * @param null $type
     */
    public function __construct($data, $type = null)
    {
        parent::__construct($data, $type);
        $this->i18 = ['aries', 'taurus', 'gemini', 'cancer', 'leo', 'virgo', 'libra', 'scorpio', 'sagittarius', 'capricorn', 'aquarius', 'pisces'];
    }

    /**
     * Parse out horoscope from string
     */
    public function parse()
    {
        $this->dom->loadStr($this->raw_data, []);
        $main = $this->dom->find('.a3s')[0];
        $trs = $main->find('table')->find('tr');
        $data = [];
        foreach ($trs as $k => $tr) {
            $td = $tr->find('td');
            $b = $td->find('b');
            $span = $td->find('span');
            if (mb_strlen($span->text) > 1) {
                $data[$this->i18[$k]] = $span->text;
            } elseif (count($span) == 3) {
                $data[$this->i18[$k]] = strip_tags(str_ireplace(['<br/>', '<br />', '<br>'], "\r\n", str_replace($b->innerHtml, '', $td->innerHtml)));
            } else {
                $data[$this->i18[$k]] = $span->find('span')->text;
            }
        }
        return [$this->type => $data];
    }
}