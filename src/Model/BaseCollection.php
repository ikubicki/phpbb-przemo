<?php

namespace PHPBB\Przemo\Model;

use ReflectionClass;
use PHPBB\Przemo\Core\StaticRegistry;
use PHPBB\Przemo\Query;
use PHPBB\Przemo\Sources;

class BaseCollection
{
    
    /**
     * @var ReflectionClass
     */
    protected $reflection;
    
    /**
     *
     * @author ikubicki
     * @param integer|string|array $ids
     * @return array|BaseEntity
     */
    public function get($ids)
    {
        $entity = $this->createEntity();
        $primaryKey = $entity->primaryKeyName();
        unset($entity);
        if (!is_array($ids)) {
            return $this->retrieve([$ids])[$ids];
        }
        return $this->search([$primaryKey => $ids]);
    }
    
    /**
     *
     * @author ikubicki
     * @param array $criteria
     * @return array|BaseEntity
     */
    public function search(array $criteria)
    {
        $entities = [];
        $query = $this->createGetQuery();
        $query->criteria = $criteria;
        $records = $this->getSources()->handle($query);
        foreach ($records as $record) {
            $entity = $this->createEntity($query);
            $entity->import($record);
            $entities[$entity->id] = $entity;
        }
        return $entities;
    }
    
    /**
     *
     * @author ikubicki
     * @param array|BaseEntity $entities
     * @return boolean
     */
    public function store($entities)
    {
        if ($entities instanceof BaseEntity) {
            $entities = [$entities];
        }
        $result = true;
        $insertQuery = $this->createSetQuery();
        foreach ($entities as $entity) {
            if ($entity->primaryKey()) {
                $updateQuery = $this->createSetQuery()->addItem($entity);
                $updateQuery->removeField($entity->primaryKeyName());
                $updateQuery->addCriteria($entity->primaryKeyName(), $entity->primaryKey());
                $this->getSources()->handle($updateQuery);
                continue;
            }
            $result = $insertQuery->addItem($entity) && $result;
        }
        if (count($insertQuery->items)) {
            return $this->getSources()->handle($insertQuery);
        }
        return $result;
    }
    
    /**
     *
     * @author ikubicki
     * @param array|BaseEntity $entities
     * @return boolean
     */
    public function dump($entities)
    {
        if ($entities instanceof BaseEntity) {
            $entities = [$entities];
        }
        $ids = [];
        foreach ($entities as $entity) {
            $ids[] = $entity->primaryKey();
        }
        $ids = array_filter($ids);
        if (count($ids)) {
            $query = $this->createDeleteQuery();
            $query->addCriteria($entity->primaryKeyName(), $ids);
            return $this->getSources()->handle($query);
        }
    }
    
    /**
     * 
     * @author ikubicki
     * @return Query\Get
     */
    protected function createGetQuery()
    {
        $query = new Query\Get;
        $query->collection = $this->getCollectionName();
        return $query;
    }
    
    /**
     * 
     * @author ikubicki
     * @return Query\Set
     */
    protected function createSetQuery()
    {
        $query = new Query\Set;
        $query->collection = $this->getCollectionName();
        return $query;
    }
    
    /**
     * 
     * @author ikubicki
     * @return Query\Delete
     */
    protected function createDeleteQuery()
    {
        $query = new Query\Delete;
        $query->collection = $this->getCollectionName();
        return $query;
    }
    
    /**
     * 
     * @author ikubicki
     * @param array $entities
     * @return array
     */
    protected function entitiesToArray(array $entities)
    {
        $items = [];
        foreach($entities as $entity) {
            $items = $entity->toArray();
        }
        return $items;
    }
    
    /**
     *
     * @author ikubicki
     * @return string
     */
    protected function getCollectionName()
    {
        return $this->getReflection()->getShortName();
    }
    
    /**
     *
     * @author ikubicki
     * @return string
     */
    protected function getCollectionNamespace()
    {
        return $this->getReflection()->getNamespaceName();
    }
    
    /**
     * 
     * @author ikubicki
     * @return ReflectionClass
     */
    protected function getReflection()
    {
        if (!$this->reflection) {
            $this->reflection = new \ReflectionClass($this);
        }
        return $this->reflection;
    }
    
    /**
     * 
     * @author ikubicki
     * @return BaseEntity
     */
    protected function createEntity()
    {
        $class = $this->getCollectionNamespace() . '\\' . $this->getEntityName();
        $entity = new $class;
        $entity->setCollection($this);
        return $entity;
    }
    
    /**
     *
     * @author ikubicki
     * @return string
     */
    protected function getEntityName()
    {
        $collectionName = $this->getReflection()->getShortName();
        if (substr($collectionName, -2) == 'es') {
            return substr($collectionName, 0, strlen($collectionName) - 2);
        }
        return substr($collectionName, 0, strlen($collectionName) - 1);
    }
    
    /**
     * 
     * @author ikubicki
     * @return Sources\AbstractSource
     */
    protected function getSources()
    {
        return StaticRegistry::get('sources');
    }
}