<?php

namespace PhpBB\Forum;
use PhpBB\Model;
use PhpBB\Data\Cache;
use PhpBB\Core\Context;

class Config
{

    protected $properties = [];
    protected $context;
    protected $cache;

    /**
     * Constructor
     * 
     * @author ikubicki
     * @param array $properties
     * @param string $context
     */
    public function __construct(&$properties = [], $context = null)
    {
        $this->properties = $properties;
        $this->context = $context;
    }

    /**
     * Stores cache
     * 
     * @author ikubicki
     */
    public function storeCache()
    {
        if (!empty($this->properties)) {
            $cache = $this->getCache();
            if (!$this->context) {
                $cache->store('config', $this->properties, 86400);
            }
            else {
                $cache->release('config');
            }
        }
    }

    /**
     * Loads cache
     * 
     * @author ikubicki
     * @return bool
     */
    public function isCached()
    {
        if (empty($this->properties)) {
            $cache = $this->getCache();
            // $this->properties = $cache->collect('config');
            return $this->properties && count($this->properties);
        }
        return false;
    }

    /**
     * Loads configuration
     * 
     * @author ikubicki
     */
    public function load()
    {
        $this->properties = $this->getConfigCollection()->export();
    }

    /**
     * Returns configuration property
     * 
     * @author ikubicki
     * @param string $property
     * @return string|Config
     */
    public function __get($property)
    {
        return $this->get($property);
    }

    /**
     * Sets configuration property
     * 
     * @author ikubicki
     * @param string $property
     * @param string|array|null $value
     */
    public function __set($property, $value)
    {
        return $this->set($property, $value);
    }

    /**
     * Returns configuration property
     * 
     * @author ikubicki
     * @param string $property
     * @param mixed $alternative
     * @return string|Config
     */
    public function get($property, $alternative = null)
    {
        $value = $this->properties[$property] ?? $alternative;
        if (is_string($value) && substr($value, 0, 1) == '{' && !$this->context) {
            $value = $this->unserialize($value, true);
        }
        if (is_array($value) && !$this->context) {
            return new self($value, $property);
        }
        return $value;
    }

    /**
     * Loads module configuration
     * 
     * @author ikubicki
     * @param string $module
     * @return Config
     */
    public function module($module): Config
    {
        $properties = $this->get($module);
        if ($properties instanceof self) {
            return $properties;
        }
        if (!is_array($properties)) {
            $properties = [];
        }
        return new self($properties, $module);
    }

    /**
     * Sets config property
     * 
     * @author ikubicki
     * @param string $property
     * @param string|array|null $value
     */
    public function set($property, $value)
    {
        if ($value === null) {
            return $this->unset($property);
        }
        if ($this->context) {
            $new = count($this->properties) < 1;
            var_dump($this->properties);
        }
        else {
            $new = !array_key_exists($property, $this->properties);
        }
        $this->properties[$property] = $value;
        $this->save($property, $new);
    }

    /**
     * Removes config property
     * 
     * @author ikubicki
     * @param string $property
     */
    public function unset($property)
    {
        unset($this->properties[$property]);
        if ($this->context) {
            if (count($this->properties)) {
                $this->getConfig($this->context, $this->serialize($this->properties))->save();
            }
            else {
                $this->getConfig($this->context)->delete();
            }
            $this->storeCache();
            return;
        }
        $this->getConfig($property)->delete();
    }

    /**
     * Stores configuration change
     * 
     * @author ikubicki
     * @param string $property
     * @param boolean $new
     */
    protected function save($property, $new = true)
    {
        if ($this->context) {
            $this->getConfig($this->context, $this->serialize($this->properties), $new)->save();
            return;
        }
        $value = $this->properties[$property];
        if (is_array($value)) {
            $value = $this->serialize($value);
        }
        $this->getConfig($property, $value, $new)->save();
        $this->storeCache();
        return;
    }

    /**
     * Unserializes data
     * 
     * @author ikubicki
     * @param string $string
     * @return array|boolean
     */
    protected function unserialize($string)
    {
        return json_decode($string, true);
    }


    /**
     * Serializes data
     * 
     * @author ikubicki
     * @param string|array $data
     * @return string
     */
    protected function serialize($data): string
    {
        return json_encode($data, JSON_PRETTY_PRINT);
    }

    /**
     * Return config entity
     * 
     * @author ikubicki
     * @param string $name
     * @param string $value
     * @param boolean $new
     * @return Model\Config
     */
    protected function getConfig($name, $value = null, $new = true)
    {
        $entity = new Model\Config;
        $entity->config_name = $name;
        $entity->config_value = $value;
        $entity->setNew($new);
        return $entity;
    }

    /**
     * Returns config collection
     * 
     * @author ikubicki
     * @return Model\ConfigCollection
     */
    protected function getConfigCollection()
    {
        return new Model\ConfigCollection;
    }
    
    /**
     * Returns cache object
     *
     * @author ikubicki
     * @return Cache
     */
    protected function getCache()
    {
        if (!$this->cache) {
            $this->cache = Context::getService('cache');
        }
        return $this->cache;
    }
}