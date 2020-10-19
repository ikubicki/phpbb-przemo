<?php

namespace PhpBB\Data;

class Entity
{
    protected $key;
    protected $collection;

    public function setKey($key) 
    {
        $this->key = $key;
    }

    public function setCollection($collection)
    {
        $this->collection = $collection;
    }

    public function getKeyValue() 
    {
        $key = $this->key;
        return $this->$key ?? false;
    }

    public function import($record)
    {
        foreach((array) $record as $property => $value) {
            $this->$property = $value;
        }
    }

    public static function __set_state(array $properties)
    {
        $entity = new static;
        foreach($properties as $property => $values) {
            $entity->$property = $values;
        }
        return $entity;
    }
}