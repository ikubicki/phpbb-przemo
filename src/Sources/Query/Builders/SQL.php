<?php

namespace PHPBB\Przemo\Sources\Query\Builders;

use PHPBB\Przemo\Query;
use PHPBB\Przemo\Core\StaticRegistry;
use PHPBB\Przemo\Core\Config;
use PHPBB\Przemo\Query\AbstractQuery;

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
            "OFFSET {$this->getOffset()};";
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
            "VALUES {$this->getPlaceholderGroups()};";
        return [$statement, $this->getItemsValues() + $this->getConditionValues()];
    }
    
    public function getUpdateStatement()
    {
        $statements = '';
        $statement = "UPDATE {$this->getTableName()} " .
            "SET {$this->getItemsFields()} " .
            "WHERE {$this->getConditionFields()};";
        $itemsCount = count($this->query->items);
        for ($i = 0; $i < $itemsCount; $i++) {
            $statements .= "$statement\r\n";
        }
        return [$statements, $this->getItemsValues() + $this->getConditionValues()];
    }
    
    public function getDeleteStatement()
    {
        $statement = "DELETE FROM {$this->getTableName()} " .
            "WHERE {$this->getConditionFields()} " .
            "LIMIT {$this->getLimit()} " .
            "OFFSET {$this->getOffset()};";
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
            $collection = $this->getSnakeCase($this->query->collection);
            $this->table = $this->getConfig()->database->get('prefix', '') . $collection;
        }
        return $this->table;
    }
    
    protected function getFields()
    {
        return '`' . implode('`, `', $this->query->fields) . '`';
    }
    
    protected function getPlaceholderGroups()
    {
        $fieldsCount = count($this->query->fields);
        $itemsCount = count($this->query->items);
        $group = '(' . implode(', ', array_fill(0, $fieldsCount, '?')) . ')';
        return implode(', ', array_fill(0, $itemsCount, $group));
    }
    
    protected function getItemsFields()
    {
        return '';
    }
    
    /**
     * 
     * @author ikubicki
     * @return string
     */
    protected function getConditionFields()
    {
        if (count($this->query->criteria)) {
            $criteria = '';
            foreach ($this->query->criteria as $field => $value) {
                $criteria .= ($criteria ? ' AND ' : '');
                $criteria .= "`$field` = ?";
            }
            return $criteria;
        }
        return '1';
    }
    
    /**
     * 
     * @author ikubicki
     * @return array
     */
    protected function getItemsValues()
    {
        $values = [];
        foreach ($this->query->items as $item) {
            $values = array_merge($values, array_values($item));
        }
        return $values;
    }
    
    /**
     * 
     * @author ikubicki
     * @return array
     */
    protected function getConditionValues()
    {
        return array_values($this->query->criteria);
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
    
    /**
     * 
     * @author ikubicki
     * @param string $string
     * @return string
     */
    protected function getSnakeCase($string)
    {
        return strtolower(preg_replace('#([A-Z]+)#', '_\\1', lcfirst($string)));
    }
}