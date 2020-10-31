<?php

namespace PhpBB\Data;

class Entity
{

    protected $_new = true;
    protected $_key;
    protected $_collection;
    protected $_refs = [];

    /**
     * 
     * @author ikubicki
     * @param array $refs
     */
    public function setRefs(array $refs)
    {
        $this->_refs = $refs;
    }

    /**
     * 
     * @author ikubicki
     * @param string $field
     * @param Entity $entity
     */
    public function addRef($field, Entity $entity)
    {
        $this->_refs[$field] = $entity;
    }

    /**
     * 
     * @author ikubicki
     * @param string $field
     * @return Entity|boolean
     */
    public function getRef($field)
    {
        return $this->_refs[$field] ?? false;
    }

    /**
     * 
     * @author ikubicki
     * @param string $class
     * @return Collection
     */
    public function getCollection($class): Collection
    {
        return $this->_collection ?: new $class;
    }

    /**
     * 
     * @author ikubicki
     * @param Collection $collection
     */
    public function setCollection(Collection $collection)
    {
        $this->_collection = $collection;
    }

    /**
     * 
     * @author ikubicki
     * @return string
     */
    public function getKey() 
    {
        return $this->_key;
    }

    /**
     * 
     * @author ikubicki
     * @param string $key
     */
    public function setKey($key) 
    {
        $this->_key = $key;
    }

    /**
     * 
     * @author ikubicki
     * @return string|boolean
     */
    public function getKeyValue() 
    {
        $key = $this->_key;
        return $this->$key ?? false;
    }

    /**
     * 
     * @author ikubicki
     * @param string $value
     */
    public function setKeyValue($value) 
    {
        $key = $this->_key;
        $this->$key = $value;
    }

    /**
     * 
     * @author ikubicki
     * @return boolean
     */
    public function isNew(): boolean
    {
        return $this->_new;
    }

    /**
     * 
     * @author ikubicki
     * @param boolean $new
     */
    public function setNew($new = true)
    {
        $this->_new = $new;
    }

    /**
     * 
     * @author ikubicki
     * @param array $record
     */
    public function import(array $record)
    {
        foreach((array) $record as $property => $value) {
            $this->$property = $value;
        }
    }

    /**
     * 
     * @author ikubicki
     * @static
     * @param array $properties
     * @return Entity
     */
    public static function __set_state(array $properties)
    {
        $entity = new static;
        foreach($properties as $property => $values) {
            $entity->$property = $values;
        }
        return $entity;
    }

    /**
     * 
     * @author ikubicki
     */
    public function save()
    {
        throw new \Exception(sprintf('%s::save() method is not implemented!', get_called_class()));
    }

    /**
     * 
     * @author ikubicki
     */
    public function delete()
    {
        throw new \Exception(sprintf('%s::delete() method is not implemented!', get_called_class()));
    }
}