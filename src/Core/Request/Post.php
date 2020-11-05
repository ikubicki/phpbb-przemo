<?php

namespace PhpBB\Core\Request;

class Post
{
    public function __get($parameter)
    {
        return $this->get($parameter);
    }

    public function get($parameter, $alternative = null)
    {
        return $_POST[$parameter] ?? $alternative;
    }

    public function dump()
    {
        return $_POST;
    }
}