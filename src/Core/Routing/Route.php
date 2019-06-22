<?php

namespace PHPBB\Przemo\Core\Routing;

class Route
{
    
    /**
     * @var string
     */
    public $application;
    
    /**
     * @var string
     */
    public $module;
    
    /**
     * @var array
     */
    public $parameters = [];
    
    /**
     * 
     * @author ikubicki
     * @param string $application
     * @param string $module
     * @param array $parameters
     */
    public function __construct($application, $module, array $parameters = [])
    {
        $this->application = $application;
        $this->module = $module;
        $this->parameters = $parameters;
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $default
     * @return string
     */
    public function getAction($default = 'index')
    {
        if (empty($this->parameters['action'])) {
            return $default;
        }
        return $this->parameters['action'];
    }
    
    /**
     * 
     * @author ikubicki
     * @return string
     */
    public function __toString()
    {
        return $this->getUrl(true);
    }
    
    /**
     *
     * @author ikubicki
     * @return string
     */
    public function getUrl($absolute = false)
    {
        $query = $this->parameters;
        if ($this->module != 'index') {
            $query['module'] = $this->module;
        }
        if (isset($query['action']) && $query['action'] == 'index') {
            unset($query['action']);
        }
        $query = http_build_query($query);
        $path = $this->getPath();
        if ($absolute) {
            $protocol = $this->isSecured() ? 'https' : 'http';
            $host = $this->getHostname();
            $path = "{$protocol}://{$host}{$path}";
        }
        return "{$path}{$this->application}.php" . ($query ? "?$query" : '');
    }
    
    /**
     * 
     * @author ikubicki
     * @return string
     */
    public function getPath()
    {
        // @TODO support paths, especially with mod rewrite
        return '/';
    }
    
    /**
     *
     * @author ikubicki
     * @return boolean
     */
    public function isSecured()
    {
        if (empty($_SERVER['HTTPS']) && empty($_SERVER['HTTP_X_FORWARDED_SSL'])) {
            return false;
        }
        return true;
    }
    
    /**
     *
     * @author ikubicki
     * @return string
     */
    public function getHostname()
    {
        if (empty($_SERVER['HTTP_HOST'])) {
            $ip = $_SERVER['SERVER_ADDR'];
            $port = $_SERVER['SERVER_PORT'];
            if ($port == 80 || $port == 443) {
                return $ip;
            }
            return "$ip:$port";
        }
        return $_SERVER['HTTP_HOST'];
    }
}

