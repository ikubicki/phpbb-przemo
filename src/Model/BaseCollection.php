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
    public function retrieve($ids)
    {
        if (!is_array($ids)) {
            return $this->retrieve([$ids])[$ids];
        }
        $entities = [];
        $query = $this->createGetQuery();
        $query->ids = $ids;
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
        $query = $this->createSetQuery();
        $query->entities = $entities;
        return $this->getSources()->handle($query);
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
        $query = $this->createDeletetQuery();
        $query->entities = $entities;
        return $this->getSources()->handle($query);
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