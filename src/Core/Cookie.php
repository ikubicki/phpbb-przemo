<?php

namespace PhpBB\Core;

class Cookie
{

    public $expire;
    
    protected $options = [];

    public function __construct($options)
    {
        $this->name = $options['name'] ?? false;
        $this->expire = $options['expire'] ?? null;
        if (!$this->name) {
            throw new \Exception('Cookie name is mandatory!');
        }
        $this->options = $this->options + $options;
    }

    public function read()
    {
        return $_COOKIE[$this->name] ?? false;
    }

    public function delete()
    {
        $this->write(null);
    }

    public function write($contents)
    {
        $options = [
            'expires' => $this->expire ?: 0,
            'path' => $this->options['path'] ?? '',
            'domain' => $this->options['domain'] ?? '',
            'secure' => $this->options['secure'] ?? true,
            'httponly' => $this->options['httponly'] ?? true,
            'samesite' => $this->options['samesite'] ?? 'None',
        ];
        setcookie($this->name, false, $options + ['expires' => time() - 86400]);
        unset($_COOKIE[$this->name]);
        if ($contents) {
            setcookie($this->name, $contents, $options);
            $_COOKIE[$this->name] = $contents;
        }
    }
}