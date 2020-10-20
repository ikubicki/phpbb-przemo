<?php

namespace PhpBB\Core\Request;

class Headers
{
    public function __get($header)
    {
        return $this->get($header);
    }

    public function get($header)
    {
        $header = strtoupper(str_replace('-', '_', 'http_' . $header));
        return $_SERVER[$header] ?? null;
    }
}