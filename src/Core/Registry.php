<?php

namespace PHPBB\Przemo\Core;

class Registry
{
    
    /**
     * 
     * @var array
     */
    protected $registry = [];
    
    /**
     * 
     * @author ikubicki
     * @param array $import
     */
    public function import(array $import)
    {
        foreach($import as $property => $value) {
            $this->registry[$property] = $value;
        }
    }
    
    /**
     * 
     * @author ikubicki
     * @return array
     */
    public function export()
    {
        return $this->registry;
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $property
     * @return boolean
     */
    public function has($property)
    {
        return array_key_exists($property, $this->registry);
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $property
     * @return mixed
     */
    public function get($property)
    {
        if ($this->has($property)) {
            return $this->registry[$property];
        }
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $property
     * @param string $value
     */
    public function set($property, $value)
    {
        $this->registry[$property] = $value;
    }
}