<?php

namespace PhpBB\Core;

class Request
{

    public $get;
    public $post;
    public $files;
    public $cookies;
    public $headers;
    public $method;

    public function __construct()
    {
        $this->get = new Request\Get;
        $this->post = new Request\Post;
        $this->files = new Request\Files;
        $this->cookies = new Request\Cookies;
        $this->headers = new Request\Headers;
        $this->method = strtolower($_SERVER['REQUEST_METHOD'] ?? 'GET');
    }

    public function __get($parameter)
    {
        return $_REQUEST[$parameter] ?? $_SERVER[$parameter] ?? null;
    }

    public function get()
    {
        return $this->get;
    }

    public function post()
    {
        return $this->post;
    }

    public function files()
    {
        return $this->files;
    }

    public function cookies()
    {
        return $this->cookies;
    }

    public function headers()
    {
        return $this->headers;
    }

    public function isPost()
    {
        return $this->method == 'post';
    }
}