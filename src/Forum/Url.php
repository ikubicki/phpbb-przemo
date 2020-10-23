<?php

namespace PhpBB\Forum;

class Url
{

    protected $url;
    protected $text;
    protected $styles;

    public function __construct($url, $text = '', array $styles = [])
    {
        $this->url = $url;
        $this->text = $text;
        $this->styles = array_filter($styles);
    }

    public function __toString()
    {
        return $this->render();
    }

    public function render()
    {
        if (isset($this->styles['class'])) {
            $class = $this->styles['class'];
            unset($this->styles['class']);
            $class = sprintf(' class="%s"', $class);
        }
        if (count($this->styles)) {
            $styles = $this->styles;
            array_walk($styles, function(&$v, $k){
                $v = "$k: $v;";
            });
            $styles = ' style="' . implode(' ', $styles) . '"';
        }
        return sprintf('<a href="%s"%s%s>%s</a>', $this->url, $styles, $class, $this->text);
    }
}