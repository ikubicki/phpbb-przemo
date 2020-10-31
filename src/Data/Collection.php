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
    protected $values = [];

    /**
     * 
     * @author ikubicki
     * @param string $name
     * @param string $class
     * @param string $class
     */
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

    /**
     * 
     * @author ikubicki
     * @param string $id
     * @return Entity
     */
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

    /**
     * 
     * @author ikubicki
     * @param array|string $criteria
     * @param array $order
     * @param integer $offset
     * @return Entity
     */
    public function one($criteria, array $order = [], $offset = 0)
    {
        return $this->find($criteria, $order, 1, $offset)[0] ?? false;
    }

    /**
     * 
     * @author ikubicki
     * @param array $order
     * @return Entity[]
     */
    public function all(array $order = [])
    {
        return $this->find([], $order);
    }

    /**
     * 
     * @author ikubicki
     * @param array|string $criteria
     * @param array $order
     * @param integer $limit
     * @param integer $offset
     * @return Entity[]
     */
    public function find($criteria = [], array $order = [], $limit = null, $offset = 0)
    {
        $records = $this->export($criteria, $order, $limit, $offset);
        foreach($records as $i => $record) {
            $records[$i] = $this->hydrate($record);
        }
        return $records;
    }

    /**
     * 
     * @author ikubicki
     * @param array|string $criteria
     * @param array $order
     * @param integer $limit
     * @param integer $offset
     * @return array
     */
    public function export($criteria = [], array $order = [], $limit = null, $offset = 0)
    {
        $this->criteria = $criteria;
        $this->order = $order;
        $this->limit = $limit;
        $this->offset = $offset;

        $query = $this->query($this);
        list($statement, $values) = $query->select();
        return $this->getConnection()->all($statement, $values);
    }

    /**
     * 
     * @author ikubicki
     * @param array $entities
     */
    public function store(array $entities)
    {
        foreach ($entities as $entity) {
            $entity->isNew() ? $this->insert($entity) : $this->update($entity);
        }
    }

    /**
     * 
     * @author ikubicki
     * @param array $entities
     */
    public function dump(array $entities)
    {
        $keys = [];
        foreach ($entities as $entity) {
            if (!$entity->getKey()) {
                $entity->setKey($this->key);
            }
            if ($entity->getKeyValue()) {
                $keys[] = $entity->getKeyValue();
            }
            if (count($keys)) {
                $this->criteria = [$this->key => $keys];
                $query = $this->query($this);
                list($statement, $values) = $query->delete();
                if ($this->getConnection()->execute($statement, $values)) {
                    foreach($entities as $entity) {
                        $entity->setNew(true);
                    }
                }
            }
        }
    }

    /**
     * 
     * @author ikubicki
     * @param Entity $entity
     * @return string|boolean
     */
    public function insert(Entity $entity)
    {
        if (!$entity->getKey()) {
            $entity->setKey($this->key);
        }
        $this->values = get_object_vars($entity);
        $query = $this->query($this);
        list($statement, $values) = $query->insert();
        $key = $this->getConnection()->insert($statement, $values);
        $entity->setNew(false);
        if ($key !== false) {
            $key = $entity->getKeyValue();
        }
        $entity->setKeyValue($key);
        return $key;
    }

    /**
     * 
     * @author ikubicki
     * @param Entity $entity
     * @return boolean
     */
    protected function update($entity)
    {
        if (!$entity->getKey()) {
            $entity->setKey($this->key);
        }
        $this->values = get_object_vars($entity);
        $this->criteria = [$this->key => $this->values[$this->key]];
        unset($this->values[$this->key]);
        $query = $this->query($this);
        list($statement, $values) = $query->update();
        return $this->getConnection()->execute($statement, $values);
    }

    /**
     * 
     * @author ikubicki
     * @param Collection $collection
     * @param string $idx
     * @param string $ref
     * @param array $on
     * @param string $ref_alias
     * @return Entity[]
     */
    public function innerjoin(Collection $collection, $idx, $ref, array $on = [], $ref_alias = null)
    {
        return $this->join('inner join', $collection, $idx, $ref, $on, $ref_alias);
    }

    /**
     * 
     * @author ikubicki
     * @param Collection $collection
     * @param string $idx
     * @param string $ref
     * @param array $on
     * @param string $ref_alias
     * @return Entity[]
     */
    public function leftjoin(Collection $collection, $idx, $ref, array $on = [], $ref_alias = null)
    {
        return $this->join('left join', $collection, $idx, $ref, $on, $ref_alias);
    }

    /**
     * 
     * @author ikubicki
     * @param Collection $collection
     * @param string $idx
     * @param string $ref
     * @param array $on
     * @param string $ref_alias
     * @return Entity[]
     */
    public function rightjoin(Collection $collection, $idx, $ref, array $on = [], $ref_alias = null)
    {
        return $this->join('right join', $collection, $idx, $ref, $on, $ref_alias);
    }

    /**
     * 
     * @author ikubicki
     * @param string $type
     * @param Collection $collection
     * @param string $idx
     * @param string $ref
     * @param array $on
     * @param string $ref_alias
     * @return Entity[]
     */
    public function join($type = 'join', Collection $collection, $idx, $ref, array $on = [], $ref_alias = null)
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
        $alias = $ref_alias;
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
            'ref_alias' => $ref_alias,
            'on' => $on,
        ];
        return $this;
    }

    /**
     * 
     * @author ikubicki
     * return array
     */
    public function getSchema()
    {
        return (array) $this->schema;
    }

    /**
     * 
     * @author ikubicki
     * return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * 
     * @author ikubicki
     * return string
     */
    public function getName()
    {
        return $this->getPrefix() . $this->name;
    }

    /**
     * 
     * @author ikubicki
     * return array|string
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * 
     * @author ikubicki
     * return array
     */
    public function getValues()
    {
        return (array) $this->values;
    }

    /**
     * 
     * @author ikubicki
     * return integer
     */
    public function getLimit()
    {
        return (int) $this->limit;
    }
    
    /**
     * 
     * @author ikubicki
     * return array
     */
    public function getOrder()
    {
        return (array) $this->order;
    }

    /**
     * 
     * @author ikubicki
     * return integer
     */
    public function getOffset()
    {
        return (int) $this->offset;
    }

    /**
     * 
     * @author ikubicki
     * return array
     */
    public function getJoins()
    {
        return (array) $this->joins;
    }

    /**
     * 
     * @author ikubicki
     * @static
     * @param string $namespace
     * @param Entity $entity
     */
    public static function registerEntity($namespace, Entity $entity)
    {
        Context::registerEntity($namespace, $entity);
    }

    /**
     * 
     * @author ikubicki
     * @param Collection $collection
     * @return mixed
     */
    protected function query(Collection $collection)
    {
        $class = Context::getValue('query-builder');
        return new $class($collection);
    }

    /**
     * 
     * @author ikubicki
     * @param array $record
     * @return Entity
     */
    protected function hydrate(array $record)
    {
        $refs = [];
        if (count($this->joins)) {
            $refs = $this->extractRefs($record);
        }
        $entity = new $this->class;
        $entity->setNew(false);
        $entity->setCollection($this);
        $entity->setKey($this->key);
        $entity->import($record);
        $entity->setRefs($refs);
        if ($this->key) {
            self::registerEntity($this->name, $entity);
        }
        return $entity;
    }

    /**
     * 
     * @author ikubicki
     * @param array $record
     * @return Entity[]
     */
    protected function extractRefs(&$record)
    {
        $_refs = [];
        foreach ($this->joins as $alias => $join) {
            $_refs[$alias] = [
                'data' => [],
                'ref' => $join['ref_alias'] ?: $join['ref'],
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

    /**
     * 
     * @author ikubicki
     * @return mixed
     */
    protected function getConnection()
    {
        return Context::getService('db-connection');
    }

    /**
     * 
     * @author ikubicki
     * @return string
     */
    protected function getPrefix()
    {
        return Context::getValue('collection-prefix');
    }

    /**
     * 
     * @author ikubicki
     * @return boolean
     */
    public static function __set_state(array $properties)
    {
        return false;
    }
}