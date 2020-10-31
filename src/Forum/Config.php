<?php

namespace PhpBB\Forum;
use PhpBB\Model;

class Config
{

    protected $properties = [];
    protected $context;

    /**
     * 
     * @author ikubicki
     * @param array $properties
     * @param string $context
     */
    public function __construct(&$properties = null, $context = null)
    {
        if ($properties === null) {
            $properties = $this->getConfigCollection()->export();
        }
        $this->properties = $properties;
        $this->context = $context;
    }

    /**
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
     * 
     * @author ikubicki
     * @param string $property
     * @param mixed $alternative
     * @return string|Config
     */
    public function get($property, $alternative = null)
    {
        $value = $this->properties[$property] ?? $alternative;
        if ($value[0] == '{' && !$this->context) {
            $value = $this->unserialize($value, true);
        }
        if (is_array($value)) {
            return new self($value, $property);
        }
        return $value;
    }

    /**
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
            return;
        }
        $this->getConfig($property)->delete();
    }

    /**
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
        return;
    }

    /**
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
     * 
     * @author ikubicki
     * @return Model\ConfigCollection
     */
    protected function getConfigCollection()
    {
        return new Model\ConfigCollection;
    }
}