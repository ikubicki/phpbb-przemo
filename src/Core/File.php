<?php

namespace PhpBB\Core;

class File
{

    protected $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    public function clear()
    {
        file_put_contents($this->filename, null);
        return $this;
    }

    public function writeLine($string)
    {
        return $this->write($string . PHP_EOL);
    }

    public function write($string)
    {
        file_put_contents($this->filename, $string, FILE_APPEND);
        return $this;
    }

    public function output()
    {
        readfile($this->filename);
    }
}