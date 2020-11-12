<?php

namespace PhpBB\Forum;
use PhpBB\Core\Context;

class Phrases
{

    /**
     * @var string $directory
     */
    protected static $directory;

    /**
     * @var string $language
     */
    protected static $language;

    /**
     * @var array $phrases
     */
    protected static $phrases = [];
    
    /**
     * __construct
     *
     * @author ikubicki
     * @param string $directory
     */
    public function __construct($directory = null)
    {
        self::$directory = $directory;
        self::$language = $this->detect();
        $this->load('index');
        $this->load('lang_main');
    }
    
    /**
     * Detects language
     *
     * @author ikubicki
     * @return void
     */
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
    
    /**
     * __get
     *
     * @author ikubicki
     * @param string $key
     * @return string
     */
    public function __get($key)
    {
        return $this->get($key);
    }
    
    /**
     * __call
     *
     * @author ikubicki
     * @param string $key
     * @param array $arguments
     * @return string
     */
    public function __call($key, $arguments)
    {
        return $this->get($key);
    }
    
    /**
     * Returns phrase for given key
     *
     * @author ikubicki
     * @param string $key
     * @return string
     */
    public function get($key)
    {
        return self::$phrases[$key] ?? str_replace('_', ' ', $key);
    }

    /**
     * Formats phrase for given key and replacements
     *
     * @author ikubicki
     * @param string $key
     * @param mixed $replacement
     * @param mixed $replacement
     * @param mixed $replacement
     * @return string
     */
    public function format()
    {
        $arguments = func_get_args();
        $arguments[0] = $this->get($arguments[0]);
        return call_user_func_array('sprintf', $arguments);
    }
    
    /**
     * Loads more phrases
     *
     * @author ikubicki
     * @param mixed $module
     * @return Phrases
     */
    public function module($module)
    {
        $this->load($module);
        return $this;
    }
    
    /**
     * Loads phrases for given module name
     *
     * @author ikubicki
     * @param string $module
     */
    protected function load($module)
    {
        $lang = [];
        $userdata = ['user_gender' => 0]; // @todo remove it
        $filename = $this->filename($module);
        if (file_exists($filename)) {
            include $filename;
            $this->import($lang);
        }
    }
    
    /**
     * Imports loaded phrases into registry
     *
     * @author ikubicki
     * @param array $phrases
     */
    protected function import(array $phrases)
    {
        self::$phrases = self::$phrases + $phrases;
    }
    
    /**
     * Returns filename for a given module name
     *
     * @author ikubicki
     * @param string $module
     * @return string
     */
    protected function filename($module)
    {
        return self::$directory . "/" . self::$language . '/' . $module . '.php';
    }
}