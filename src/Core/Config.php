<?php

namespace PHPBB\Przemo\Core;

class Config
{
    /**
     * @var \PHPBB\Przemo\Core\Registry
     */
    protected $registry;
    
    /**
     *
     * @var string
     */
    protected $separator = '|';
    
    /**
     * 
     * @author ikubicki
     * @param string $property
     * @return mixed
     */
    public function __get($property)
    {
        $value = $this->get($property, null);
        if ($value === null) {
            return new NullRegistry;
        }
        return $value;
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $property
     * @return Config
     */
    public function create($property)
    {
        $this->set($property, new Registry);
        return $this->get($property);
    }
    
    /**
     * 
     * @author ikubicki
     * @param array $rawConfiguration
     * @return Config
     */
    public function import($rawConfiguration)
    {
        if (!is_array($rawConfiguration)) {
            return $this;
        }
        foreach($rawConfiguration as $property => $value) {
            $this->set($property, $value);
        }
        return $this;
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $property
     * @return boolean
     */
    public function has($property)
    {
        return $this->registry->has($property);
    }
    
    /**
     *
     * @author ikubicki
     * @param string $property
     * @param mixed $alternative
     * @return mixed
     */
    public function get($property, $alternative = false)
    {
        if ($this->registry->has($property)) {
            $value = $this->registry->get($property);
            if ($value instanceof Registry) {
                $config = new Config;
                $config->registry = $value;
                return $config;
            }
            return $value;
        }
        return $alternative;
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $property
     * @param mixed $value
     * @return Config
     */
    public function set($property, $value)
    {
        if (!$this->registry) {
            $this->registry = new Registry;
        }
        $this->registry->set($property, $value);
        return $this;
    }
}