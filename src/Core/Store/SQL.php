<?php

namespace PHPBB\Przemo\Core\Store;

use PHPBB\Przemo\Core\Config;
use PHPBB\Przemo\Core\StaticRegistry;

class SQL
{
    
    protected $dsn;
    protected $user;
    protected $pass;
    protected $prefix;
    protected $options;
    
    /**
     * @var \PDO
     */
    protected $connection;
    
    public function __construct()
    {
        if ($this->getDsn()) {
            $this->connect();
        }
    }
    
    public function __call($method, array $arguments)
    {
        if ($this->connection) {
            return call_user_func_array([$this->connection, $method], $arguments);
        }
    }
    
    public function connect()
    {
        $this->connection = new \PDO($this->getDsn(), $this->getUser(), $this->getPass(), $this->getOptions());
    }
    
    public function disconnect()
    {
        $this->connection = null;
    }
    
    public function getDsn()
    {
        if (!$this->dsn) {
            $this->dsn = $this->getConfig()->database->get('dsn', null);
        }
        return $this->dsn;
    }
    
    public function setDsn($dsn)
    {
        $this->dsn = $dsn;
    }
    
    public function getUser()
    {
        if (!$this->user) {
            $this->user = $this->getConfig()->database->get('user', null);
        }
        return $this->user;
    }
    
    public function setUser($user)
    {
        $this->user = $user;
    }
    
    public function getPass()
    {
        if (!$this->pass) {
            $this->pass = $this->getConfig()->database->get('pass', null);
        }
        return $this->pass;
    }
    
    public function setPass($pass)
    {
        $this->pass = $pass;
    }
    
    public function getOptions()
    {
        if (!$this->options) {
            $this->options = $this->getConfig()->database->array('options', []);
        }
        return $this->options;
    }
    
    public function addOption($key, $value)
    {
        if (!$this->options) {
            $this->options = [];
        }
        $this->options[$key] = $value;
    }
    
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }
    
    public function query($query, array $parameters = [])
    {
        return new SQLStatement($this->connection->prepare($query), $parameters);
    }
    
    /**
     * 
     * @author ikubicki
     * @return Config
     */
    protected function getConfig()
    {
        return StaticRegistry::get('configuration');
    }
}