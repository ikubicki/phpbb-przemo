<?php

namespace PHPBB\Przemo\Model;

class BaseEntity
{
    
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
}