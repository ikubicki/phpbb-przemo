<?php

namespace PhpBB\Forum;
use PhpBB\Core\Context;
use GuzzleHttp\Client;
use PhpBB\Model\UserAuth;
use PhpBB\Model\UsersCollection;
use PhpBB\Model\UsersAuthCollection;

class Authenticator
{

    /**
     * @var Config $config
     */
    protected $config;

    /**
     * @var string $error
     */
    protected $error;
    
    /**
     * __construct
     *
     * @author ikubicki
     * @return void
     */
    public function __construct()
    {
        $this->config = Context::getService('config');
    }
    
    /**
     * Sets an error
     *
     * @author ikubicki
     * @param string $error
     */
    public function setError($error)
    {
        $this->error = Context::getService('phrases')->get($error);
    }
    
    /**
     * Returns an error
     *
     * @author ikubicki
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }
    
    /**
     * Returns POST parameter
     *
     * @author ikubicki
     * @param string $property
     * @return string
     */
    public function __get($property)
    {
        return Context::getService('request')->post->get($property);
    }
    
    /**
     * Verifies authentication attempt
     *
     * @author ikubicki
     * @return bool
     */
    public function verify()
    {
        return false;
    }
    
    /**
     * Returns user authentication entry
     *
     * @author ikubicki
     * @param string $type
     * @param string $index
     * @param string $hash
     * @return UserAuth|bool
     */
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
    
    /**
     * Returns Guzzle HTTP client
     *
     * @author ikubicki
     * @param string $baseUri
     * @return Client
     */
    protected function getHttpClient($baseUri)
    {
        return new Client([
            'base_uri' => $baseUri,
            'timeout' => 3,
        ]);
    }
    
    /**
     * Returns users colletion object
     *
     * @author ikubicki
     * @return UsersCollection
     */
    private function getUsersCollection()
    {
        return new UsersCollection;
    }

    /**
     * Returns users authentications collection object
     *
     * @author ikubicki
     * @return UsersAuthCollection
     */
    private function getUsersAuthCollection()
    {
        return new UsersAuthCollection;
    }
}