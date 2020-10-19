<?php

namespace PhpBB\Data;

use PhpBB\Core\Context;

class Collection
{
    protected $name;
    protected $criteria;
    protected $limit;
    protected $offset;
    protected $order;

    public function __construct($name = null, $class = null, $key = null)
    {
        $this->name = $name;
        $this->key = $key;
        $this->class = Entity::class;
        if ($class) {
            $this->class = $class;
            $this->schema = array_keys(get_class_vars($class));
        }
    }

    public function getSchema()
    {
        return (array) $this->schema;
    }

    public function getName()
    {
        return $this->getPrefix() . $this->name;
    }

    public function getCriteria()
    {
        return $this->criteria;
    }

    public function getLimit()
    {
        return (int) $this->limit;
    }
    
    public function getOrder()
    {
        return (array) $this->order;
    }

    public function getOffset()
    {
        return (int) $this->offset;
    }

    public function get($id)
    {
        if (!$this->key) {
            return false;
        }
        $entity = Context::getEntity($this->name, $id);
        if ($entity) {
            return $entity;
        }
        return $this->one([$this->key => $id]);
    }

    public function one($criteria, array $order = [], $offset = 0)
    {
        return $this->find($criteria, $order, 1, $offset);
    }

    public function find($criteria = [], array $order = [], $limit = null, $offset = 0)
    {
        $this->criteria = $criteria;
        $this->order = $order;
        $this->limit = $limit;
        $this->offset = $offset;

        $query = $this->query($this);
        list($statement, $values) = $query->select($this->getSchema());
        $records = $this->getConnection()->all($statement, $values);
        foreach($records as $i => $record) {
            $records[$i] = $this->hydrate($record);
        }

        return $records;
    }

    protected function query($collection)
    {
        $class = Context::getValue('query-builder');
        return new $class($collection);
    }

    protected function hydrate($record)
    {
        $entity = new $this->class;
        $entity->setCollection($this);
        $entity->setKey($this->key);
        $entity->import($record);
        if ($this->key) {
            self::registerEntity($this->name, $entity);
        }
        return $entity;
    }

    public static function registerEntity($namespace, Entity $entity)
    {
        Context::registerEntity($namespace, $entity);
    }

    protected function getConnection()
    {
        return Context::getService('db-connection');
    }

    protected function getPrefix()
    {
        return Context::getValue('collection-prefix');
    }

    public static function __set_state(array $properties)
    {
        return false;
    }
}