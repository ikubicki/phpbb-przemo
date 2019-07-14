<?php

namespace PHPBB\Przemo\Model;

class BaseEntity
{
    
    /**
     * @var BaseCollection
     */
    protected $collection;
    
    /**
     * @var string
     */
    protected $primaryKey = 'id';
    
    /**
     * @var array
     */
    protected $fields = [];
    
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
     * @param string $field
     * @return mixed
     */
    public function __get($field)
    {
        return $this->get($field);
    }
    
    /**
     *
     * @author ikubicki
     * @param string $field
     * @param mixed $value
     */
    public function __set($field, $value)
    {
        $this->set($field, $value);
    }
    
    /**
     *
     * @author ikubicki
     * @param string $field
     * @return mixed
     */
    public function get($field)
    {
        if (array_key_exists($field, $this->fields)) {
            return $this->fields[$field];
        }
        return null;
    }
    
    /**
     *
     * @author ikubicki
     * @param string $field
     * @param mixed $value
     */
    public function set($field, $value)
    {
        $this->fields[$field] = $value;
    }
    
    /**
     *
     * @author ikubicki
     * @return string
     */
    public function primaryKeyName()
    {
        return $this->primaryKey;
    }
    
    /**
     *
     * @author ikubicki
     * @return mixed
     */
    public function primaryKey()
    {
        $primaryKey = $this->primaryKey;
        return $this->$primaryKey;
    }
    
    /**
     * 
     * @author ikubicki
     * @return array
     */
    public function toArray()
    {
        return $this->fields;
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
     * @param BaseCollection $collection
     */
    public function setCollection(BaseCollection $collection)
    {
        $this->collection = $collection;
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