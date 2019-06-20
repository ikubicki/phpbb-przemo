<?php

namespace PHPBB\Przemo\Core;

final class NullRegistry
{
    
    /**
     * 
     * @author ikubicki
     * @return array
     */
    public function export()
    {
        return [];
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $property
     * @return boolean
     */
    public function has($property)
    {
        return false;
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $property
     * @param mixed $alternative
     * @return mixed
     */
    public function get($property, $alternative = null)
    {
        return $alternative === null ? $alternative : $this;
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $property
     * @param string $value
     */
    public function set($property, $value)
    {
        // do nothing
    }
}