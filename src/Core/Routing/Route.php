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
        $query = $this->parameters;
        if ($this->module != 'index') {
            $query['module'] = $this->module;
        }
        if (isset($query['action']) && $query['action'] == 'index') {
            unset($query['action']);
        }
        $query = http_build_query($query);
        return "{$this->application}.php" . ($query ? "?$query" : '');  
    }
}

