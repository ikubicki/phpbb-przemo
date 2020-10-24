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
    protected $schema;
    protected $joins = [];

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
        return $this->find($criteria, $order, 1, $offset)[0] ?? false;
    }

    public function all(array $order = [])
    {
        return $this->find([], $order);
    }

    public function find($criteria = [], array $order = [], $limit = null, $offset = 0)
    {
        $this->criteria = $criteria;
        $this->order = $order;
        $this->limit = $limit;
        $this->offset = $offset;

        $query = $this->query($this);
        list($statement, $values) = $query->select();
        $records = $this->getConnection()->all($statement, $values);
        foreach($records as $i => $record) {
            $records[$i] = $this->hydrate($record);
        }

        return $records;
    }

    public function leftjoin($collection, $idx, $ref, array $on = [], $alias = null)
    {
        return $this->join('left join', $collection, $idx, $ref, $on, $alias);
    }

    public function rightjoin($collection, $idx, $ref, array $on = [], $alias = null)
    {
        return $this->join('right join', $collection, $idx, $ref, $on, $alias);
    }

    public function join($type = 'join', $collection, $idx, $ref, array $on = [], $alias = null)
    {
        if (!count($this->schema)) {
            throw new \Exception(
                sprintf('Your collection [%s] must have schema defined in order to use join()', $this->name)
            );
        }
        if (!count($collection->schema)) {
            throw new \Exception(
                sprintf('Dependent collection [%s] must have schema defined in order to use join()', $collection->name)
            );
        }
        if (!$alias) {
            $alias = $collection->name . '__' . strval(count($this->joins[$collection->name] ?? []));
        }
        $on[$idx] = $ref;
        $this->joins[$alias] = [
            'collection' => $collection,
            'prefixed' => $collection->getName(),
            'schema' => $collection->schema,
            'join' => $type,
            'ref' => $ref,
            'on' => $on,
        ];
        return $this;
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

    public function getJoins()
    {
        return (array) $this->joins;
    }

    public static function registerEntity($namespace, Entity $entity)
    {
        Context::registerEntity($namespace, $entity);
    }

    protected function query($collection)
    {
        $class = Context::getValue('query-builder');
        return new $class($collection);
    }

    protected function hydrate($record)
    {
        $refs = [];
        if (count($this->joins)) {
            $refs = $this->extractRefs($record);
        }
        $entity = new $this->class;
        $entity->setCollection($this);
        $entity->setKey($this->key);
        $entity->import($record);
        $entity->setRefs($refs);
        if ($this->key) {
            self::registerEntity($this->name, $entity);
        }
        return $entity;
    }

    protected function extractRefs(&$record)
    {
        $_refs = [];
        foreach ($this->joins as $alias => $join) {
            $_refs[$alias] = [
                'data' => [],
                'ref' => $join['ref'],
                'collection' => $join['collection']
            ];
            foreach (array_keys($record) as $field) {
                if (stripos($field, "$alias,") === 0) {
                    $_refs[$alias]['data'][substr($field, strlen($alias) + 1)] = $record[$field];
                    unset($record[$field]);
                }
            }
        }
        $refs = [];
        foreach ($_refs as $ref) {
            if (count($ref['data'])) {
                $refs[$ref['ref']] = $ref['collection']->hydrate($ref['data']);
            }
        }
        unset($_refs);
        return $refs;
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