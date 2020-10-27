<?php

namespace PhpBB\Forum;

class Image
{

    protected $url;
    protected $options;
    protected $cache;

    public function __construct($url, array $options = [])
    {
        $prefix = '/images/';
        if ($url[0] == '/') {
            $prefix = '';
        }
        $this->url = $prefix . $url;
        $this->options = array_filter($options);
    }

    public function __toString()
    {
        if (!$this->cache) {
            $this->cache = $this->render();
        }
        return $this->cache;
    }

    public function render(array $options = [])
    {
        $options = $this->options + $options;
        $attributes = [];
        if (isset($options['alt'])) {
            $attributes[] = sprintf(' alt="%s"', htmlentities($options['alt']));
        }
        if (isset($options['title'])) {
            $attributes[] = sprintf(' title="%s"', htmlentities($options['title']));
        }
        if (isset($options['class'])) {
            $attributes[] = sprintf(' title="%s"', htmlentities($options['class']));
        }
        return sprintf('<img src="%s"%s />', $this->url, implode($attributes));
    }
}