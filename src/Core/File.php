<?php

namespace PhpBB\Core;

class File
{

    protected $filename;
    protected $contents;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    public function exists()
    {
        return file_exists($this->filename);
    }

    public function size()
    {
        if ($this->exists()) {
            return filesize($this->filename);
        }
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function delete()
    {
        if ($this->exists()) {
            unlink($this->filename);
        }
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

    public function load()
    {
        $this->contents = $this->read();
    }

    public function prependLine($string, $autoSave = false)
    {
        return $this->prepend($string . PHP_EOL, $autoSave);
    }

    public function prepend($string, $autoSave = false)
    {
        if ($this->contents === null) {
            $this->load();
        }
        $this->contents = $string . $this->contents;
        if ($autoSave) {
            $this->save();
        }
    }

    public function appendLine($string, $autoSave = false)
    {
        return $this->append($string . PHP_EOL, $autoSave);
    }

    public function append($string, $autoSave = false)
    {
        if ($this->contents === null) {
            $this->load();
        }
        $this->contents = $this->contents . $string;
        if ($autoSave) {
            $this->save();
        }
    }

    public function replace($string, $replacement, $autoSave = false)
    {
        if ($this->contents === null) {
            $this->load();
        }
        $this->contents = str_replace($string, $replacement, $this->contents);
        if ($autoSave) {
            $this->save();
        }
    }

    public function preg_replace($pattern, $replacement, $autoSave = false)
    {
        if ($this->contents === null) {
            $this->load();
        }
        $this->contents = preg_replace($pattern, $replacement, $this->contents);
        if ($autoSave) {
            $this->save();
        }
    }

    public function save()
    {
        if ($this->contents !== null) {
            $this->clear();
            $this->write($this->contents);
        }
    }

    public function copy($filename)
    {
        if ($filename instanceof self) {
            $filename->clear();
            $filename->write($this->read());
            return $filename;
        }
        if ($this->contents !== null) {
            $copy = new self($filename);
            $copy->clear();
            $copy->write($this->contents);
            return $copy;
        }
        if (copy($this->filename, $filename)) {
            return new self($filename);
        }
        return false;
    }

    public function read()
    {
        if ($this->contents !== null) {
            return $this->contents;
        }
        return file_get_contents($this->filename);
    }

    public function output()
    {
        if ($this->contents !== null) {
            echo $this->contents;
            return;
        }
        readfile($this->filename);
    }
}