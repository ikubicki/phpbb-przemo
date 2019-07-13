<?php

namespace PHPBB\Przemo\Model;

class BaseEntity
{
    
    /**
     * @var BaseCollection
     */
    protected $collection;
    
    /**
     * Default constructor
     * 
     * @author ikubicki
     */
    public function __construct()
    {
        $this->created_at = time();
    }
    
    /**
     * 
     * @author ikubicki
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }
    
    /**
     * 
     * @author ikubicki
     * @param array $columns
     */
    public function import(array $columns = [])
    {
        foreach ($columns as $column => $value) {
            $this->$column = $value;
        }
    }
    
    /**
     * 
     * @author ikubicki
     * @return boolean
     */
    public function delete()
    {
        $this->getCollection()->dump($this);
    }
    
    /**
     * 
     * @author ikubicki
     * @return boolean
     */
    public function save()
    {
        return $this->getCollection()->store($this);
    }
    
    /**
     * 
     * @author ikubicki
     * @return BaseCollection
     */
    public function getCollection()
    {
        if (empty($this->collection)) {
            $class = get_called_class();
            $prefix = substr($class, -1) == 's' ? 'es' : 's';
            $class .= $prefix;
            $this->collection = new $class;
        }
        return $this->collection;
    }
}