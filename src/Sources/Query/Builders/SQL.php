<?php

namespace PHPBB\Przemo\Sources\Query\Builders;

use PHPBB\Przemo\Query;
use PHPBB\Przemo\Core\StaticRegistry;
use PHPBB\Przemo\Core\Config;

class SQL
{
    
    /**
     * @var AbstractQuery
     */
    protected $query;
    
    /**
     * @var string
     */
    protected $table;
    
    /**
     * 
     * @author ikubicki
     * @param AbstractQuery $query
     */
    public function __construct(Query\AbstractQuery $query)
    {
        $this->query = $query;
    }
    
    public function getStatement()
    {
        switch (get_class($this->query))
        {
            default:
            case Query\Get::class:
                return $this->getSelectStatement();
            case Query\Set::class:
                return $this->getInsertOrUpdateStatement();
            case Query\Delete::class:
                return $this->getDeleteStatement();
        }
    }
    
    public function getSelectStatement()
    {
        $statement = "SELECT * " . 
            "FROM {$this->getTableName()} " . 
            "WHERE {$this->getConditionFields()} " . 
            "LIMIT {$this->getLimit()} " .
            "OFFSET {$this->getOffset()} ";
        return [$statement, $this->getConditionValues()];
    }
    
    public function getInsertOrUpdateStatement()
    {
        if ($this->containsIds()) {
            return $this->getUpdateStatement();
        }
        return $this->getInsertStatement();
    }
    
    public function getInsertStatement()
    {
        $statement = "INSERT {$this->getInsertIgnore()} INTO {$this->getTableName()} ({$this->getFields()}) " .
            "VALUES {$this->getPlaceholderGroups()} ";
        return [$statement, $this->getItemsValues() + $this->getConditionValues()];
    }
    
    public function getUpdateStatement()
    {
        $statement = "UPDATE {$this->getTableName()} " .
            "SET {$this->getItemsFields()} " .
            "WHERE {$this->getConditionFields()} ";
        return [$statement, $this->getItemsValues() + $this->getConditionValues()];
    }
    
    public function getDeleteStatement()
    {
        $statement = "DELETE FROM {$this->getTableName()} " .
            "WHERE {$this->getConditionFields()} " .
            "LIMIT {$this->getLimit()} " .
            "OFFSET {$this->getOffset()} ";
        return [$statement, $this->getConditionValues()];
    }
    
    protected function containsIds()
    {
        return count($this->query->ids);
    }
    
    protected function getInsertIgnore()
    {
        return $this->query->errors ? '' :  'IGNORE';
    }
    
    protected function getTableName()
    {
        if (empty($this->table)) {
            $this->table = $this->getConfig()->database->get('prefix', '') . $this->query->collection;
        }
        return $this->table;
    }
    
    protected function getFields()
    {
        return '';
    }
    
    protected function getPlaceholderGroups()
    {
        return '';
    }
    
    protected function getItemsFields()
    {
        return '';
    }
    
    protected function getConditionFields()
    {
        return '';
    }
    
    protected function getItemsValues()
    {
        return [];
    }
    
    protected function getConditionValues()
    {
        return [];
    }
    
    protected function getLimit()
    {
        return $this->query->limit;
    }
    
    protected function getOffset()
    {
        return $this->query->offset;
    }
    
    /**
     * 
     * @author ikubicki
     * @return Config
     */
    protected function getConfig()
    {
        return StaticRegistry::get('configuration');
    }
}