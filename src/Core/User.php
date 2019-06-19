<?php

namespace PHPBB\Przemo\Core;

class User
{
    
    /**
     * @var Registry
     */
    protected $registry;
    
    /**
     * 
     * @author ikubicki
     * @param Registry $registry
     */
    public function __construct(Registry $registry = null)
    {
        if (!$registry) {
            $registry = new Registry;
        }
        $this->registry = $registry;
    }
    
    /**
     *
     * @author ikubicki
     * @param string $property
     * @return mixed
     */
    public function __get($property)
    {
        return $this->get($property);
    }
    
    /**
     *
     * @author ikubicki
     * @param string $property
     * @param mixed $value
     */
    public function __set($property, $value)
    {
        $this->set($property, $value);
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