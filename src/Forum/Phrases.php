<?php

namespace PhpBB\Forum;
use PhpBB\Core\Context;

class Phrases
{

    protected static $directory;
    protected static $language;
    protected static $phrases = [];

    public function __construct($directory = null)
    {
        self::$directory = $directory;
        self::$language = $this->detect();
        $this->load('main');
    }

    public function detect()
    {
        $request = Context::getService('request');
        $header = $request->headers->accept_language ?? 'en';
        foreach(explode(',', explode(';', $header)[0]) as $code) {
            $code = explode('-', $code)[0];
            if (file_exists(self::$directory . "/$code")) {
                return self::$language = $code;;
            }
        }
        throw new \Exception('Language packs are not installed!');
    }

    public function __get($key)
    {
        return $this->get($key);
    }

    public function __call($key, $arguments)
    {
        return $this->get($key);
    }

    public function load($module)
    {
        $lang = [];
        $filename = $this->filename($module);
        if (file_exists($filename)) {
            include $filename;
            $this->import($lang);
        }
    }

    public function import(array $phrases)
    {
        self::$phrases = self::$phrases + $phrases;
    }

    public function get($key)
    {
        return self::$phrases[$key] ?? $key;
    }

    protected function filename($module)
    {
        return self::$directory . "/" . self::$language . '/lang_' . $module . '.php';
    }
}