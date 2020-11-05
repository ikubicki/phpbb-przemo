<?php

namespace PhpBB\Core\Request;

class Cookies
{
    public function __get($parameter)
    {
        return $this->get($parameter);
    }

    public function get($parameter, $alternative = null)
    {
        return $_COOKIE[$parameter] ?? $alternative;
    }

    public function dump()
    {
        return $_COOKIE;
    }
}