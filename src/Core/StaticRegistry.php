<?php

namespace PHPBB\Przemo\Core;

final class StaticRegistry
{
    
    /**
     * 
     * @var array
     */
    protected static $registry = [];
    
    /**
     * 
     * @author ikubicki
     * @param array $import
     */
    public static function import(array $import)
    {
        foreach($import as $property => $value) {
            self::$registry[$property] = $value;
        }
    }
    
    /**
     * 
     * @author ikubicki
     * @return array
     */
    public static function export()
    {
        return self::$registry;
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $property
     * @return boolean
     */
    public static function has($property)
    {
        return array_key_exists($property, self::$registry);
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $property
     * @param mixed $alternative
     * @return mixed
     */
    public static function get($property, $alternative = null)
    {
        if (self::has($property)) {
            return self::$registry[$property];
        }
        return $alternative;
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $property
     * @param string $value
     */
    public static function set($property, $value)
    {
        self::$registry[$property] = $value;
    }
}