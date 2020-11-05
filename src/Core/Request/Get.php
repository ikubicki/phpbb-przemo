<?php

namespace PhpBB\Core\Request;

class Get
{
    public function __get($parameter)
    {
        return $this->get($parameter);
    }

    public function get($parameter, $alternative = null)
    {
        return $_GET[$parameter] ?? $alternative;
    }

    public function dump()
    {
        return $_GET;
    }
}