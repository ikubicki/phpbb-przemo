<?php

namespace PHPBB\Przemo\Model;

class BaseEntity
{
    
    public function __construct()
    {
        $this->created_at = time();
    }
    
    public function import(array $columns = [])
    {
        foreach ($columns as $column => $value) {
            $this->$column = $value;
        }
    }
}