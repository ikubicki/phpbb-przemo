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
     */
    public function import($rawConfiguration)
    {
        if (!is_array($rawConfiguration)) {
            return;
        }
        foreach($rawConfiguration as $property => $value) {
            $this->set($property, $value);
        }
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
     */
    public function set($property, $value)
    {
        if (!$this->registry) {
            $this->registry = new Registry;
        }
        if (is_array($value)) {
            $registry = new Registry;
            $registry->import($value);
            $this->registry->set($property, $value);
        }
        else {
            $this->registry->set($property, $value);
        }
    }
}