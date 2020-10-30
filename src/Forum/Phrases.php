<?php

namespace PhpBB\Forum;

class Phrases
{

    protected static $phrases = [];

    public function __construct(array $phrases = [])
    {
        $this->load($phrases);
    }

    public function __call($key, $a)
    {
        return $this->get($key);
    }

    public function load(array $phrases)
    {
        self::$phrases = self::$phrases + $phrases;
    }

    public function get($key)
    {
        return self::$phrases[$key] ?? $key;
    }
}