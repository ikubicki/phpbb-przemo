<?php

namespace PhpBB\Forum;
use PhpBB\Core\Context;
use GuzzleHttp\Client;
use PhpBB\Model\UsersCollection;
use PhpBB\Model\UsersAuthCollection;

class Authenticator
{

    protected $config;
    protected $error;

    public function __construct()
    {
        $this->config = Context::getService('config');
    }

    public function setError($error)
    {
        $this->error = Context::getService('phrases')->get($error);
    }

    public function getError()
    {
        return $this->error;
    }

    public function __get($property)
    {
        return Context::getService('request')->post->get($property);
    }

    public function verify()
    {
        return false;
    }

    public function findRecord($type, $index, $hash = null)
    {
        $criteria = [
            'type' => $type,
            'index' => $index,
        ];
        if ($hash) {
            $criteria['hash'] = $hash;
        }
        return $this->getUsersAuthCollection()
            ->innerjoin($this->getUsersCollection(), 'user_id', 'user_id', [], 'user')
            ->one($criteria);
    }

    protected function getHttpClient($baseUri)
    {
        return new Client([
            'base_uri' => $baseUri,
            'timeout' => 3,
        ]);
    }

    private function getUsersCollection()
    {
        return new UsersCollection;
    }

    private function getUsersAuthCollection()
    {
        return new UsersAuthCollection;
    }
}