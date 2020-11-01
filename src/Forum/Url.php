<?php

namespace PhpBB\Forum;

class Url
{

    public $url;
    public $text;
    public $styles;
    protected $cache;

    public function __construct($url, $text = '', array $styles = [])
    {
        $this->url = $url;
        $this->text = $text;
        $this->styles = array_filter($styles);
    }

    public function __toString()
    {
        if (!$this->cache) {
            $this->cache = $this->render();
        }
        return $this->cache;
    }

    public function render($text = null, array $styles = [])
    {
        $styles = $this->styles + $styles;
        if (isset($styles['class'])) {
            $class = $styles['class'];
            unset($styles['class']);
            $class = sprintf(' class="%s"', $class);
        }
        if (count($styles)) {
            array_walk($styles, function(&$v, $k){
                $v = "$k: $v;";
            });
            $styles = ' style="' . implode(' ', $styles) . '"';
        }
        else {
            $styles = '';
        }
        return sprintf('<a href="%s"%s%s>%s</a>', $this->url, $styles, $class ?? '', $text ?: $this->text);
    }
}