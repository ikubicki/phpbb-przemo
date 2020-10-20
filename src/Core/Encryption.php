<?php

namespace PhpBB\Core;

class Encryption
{

    protected $key;

    public function __construct($key = null, $vector = null, $algorithm = 'AES-128-CBC')
    {
        $this->key = $key;
        $this->vector = $vector;
        $this->algorithm = $algorithm;

        if (strlen($this->key) < 4) {
            $this->key = md5_file(__FILE__);
        }
        if (strlen($this->vector) != 16) {
            $this->vector = substr(md5($this->key), 4, 16);
        }
    }

    public function encrypt($data)
    {
        $token = openssl_encrypt($data, $this->algorithm, $this->key, 0, $this->vector);
        return trim(strtr($token, '+/', '-_'), '=');
    }

    public function decrypt($token)
    {
        $token = strtr($token, '-_', '+/');
        return openssl_decrypt($token, $this->algorithm, $this->key, 0, $this->vector);
    }
}