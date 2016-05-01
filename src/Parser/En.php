<?php
namespace Horoscope\lib\parser;

use Horoscope\Lib\Parser\Parser as LangParser;
use Horoscope\Lib\Helpers\Cleaner;

class En extends LangParser
{
    /**
     * En constructor.
     * @param $data
     * @param null $type
     */
    public function __construct($data, $type = null)
    {
        parent::__construct($data, $type);
    }

    /**
     * The main target container.
     * Determines the type of horoscope to be fetched.
     * @param $target
     * @return array
     */
    private function getHoroscope($target)
    {
        $main_node = $this->dom->find($target);
        $index = $this->type == 'weekly' || $this->type == 'yearly' ? 0 : 1;
        $horoscope = $main_node->find('.shareable-section-wrapper')[$index];
        $horoscopes = $horoscope->find('.shareable-section');
        $data = [];
        foreach ($horoscopes as $h) {
            $sign = Cleaner::sign(strtolower($h->find('h2')->getAttribute('id')));
            if ($this->type == 'monthly') {
                $ps = $h->find('p');
                $texts = [];
                foreach ($ps as $p) {
                    array_push($texts, $p->text);
                }
                $value = implode("\n", $texts);
            } else {
                $value = $h->text;
            }
            $data[$sign] = $value;
        }
        return $data;
    }

    /**
     * Fetch yearly horoscope
     * @param $target
     * @return array
     */
    private function getYearlyHoroscope($target)
    {
        $main_node = $this->dom->find($target)[0];
        $wrapper = $main_node->find('.shareable-section-wrapper');
        $container = $wrapper->find('.shareable-section');
        $horoscope = [];
        foreach ($container as $k => $content) {
            if (!$k) {
                //the first one contains overview
                //so skip it
                continue;
            }
            $ps = $content->find('p');
            $hs = $content->find('h3');
            $sign = Cleaner::sign($content->find('h2')->getAttribute('id'));

            $horoscope[$sign] = [];
            foreach ($ps as $l => $p) {
                if ($l % 3 == 0) {
                    $temp = [];
                    $tag = $hs[intval($l / 3)]->text;
                }
                array_push($temp, $p->text);
                if (($l + 1) % 3 == 0) {
                    $horoscope[$sign][$tag] = $temp;
                }
            }
        }
        return $horoscope;
    }

    /***
     * Parse out the horoscope from html string
     * @return mixed
     */
    public function parse()
    {
        $this->dom->loadStr($this->raw_data, array());
        $return = [];
        switch (strtolower($this->type)) {
            case 'daily':
                $today = $this->getHoroscope('#today');
                $yesterday = $this->getHoroscope('#yesterday');
                $tomorrow = $this->getHoroscope('#tomorrow');
                $return = ['today' => $today, 'yesterday' => $yesterday, 'tomorrow' => $tomorrow];
                break;
            case 'weekly':
            case 'monthly':
                $horoscope = $this->getHoroscope('.fl-rich-text');
                $return = [strtolower($this->type) => $horoscope];
                break;
            case 'yearly':
                $horoscope = $this->getYearlyHoroscope('.fl-rich-text');
                //let combine the values to a simpler version of the detailed horoscope
                $short = [];//a compact version of the horoscope
                foreach ($horoscope as $sign => $value) {
                    $temp = [];
                    foreach ($value as $tag => $description) {
                        $t = implode("\n", $description);
                        array_push($temp, sprintf('<strong>%s</strong>', $tag));
                        array_push($temp, $t);
                    }
                    $short[$sign] = implode("\n", $temp);
                }
                //the detailed version of the horoscope will be used in future.
                $return = ['yearly' => $short, 'detailed' => $horoscope];
                break;
        }
        return $return;
    }
}