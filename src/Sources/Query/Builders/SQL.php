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
    
    /**
     *
     * @author ikubicki
     * @return string
     */
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
    
    /**
     *
     * @author ikubicki
     * @return string
     */
    public function getInsertOrUpdateStatement()
    {
        if ($this->containsIds()) {
            return $this->getUpdateStatement();
        }
        return $this->getInsertStatement();
    }
    
    /**
     *
     * @author ikubicki
     * @return string
     */
    public function getSelectStatement()
    {
        list ($where, $values) = $this->getWhere();
        $where = $where ? "WHERE $where" : '';
        
        $statement = "SELECT * " . 
            "FROM {$this->getTableName()} " . 
            "{$where} " . 
            "{$this->getLimit()} " .
            "{$this->getOffset()};";
        return [$statement, $values];
    }
    
    /**
     *
     * @author ikubicki
     * @return string
     */
    public function getInsertStatement()
    {
        list ($placeholders, $values) = $this->getBatches();
        $statement = "INSERT {$this->getInsertIgnore()} " . 
            "INTO {$this->getTableName()} " . 
            "({$this->getFields()}) " .
            "VALUES $placeholders;";
        return [$statement, $values];
    }
    
    /**
     *
     * @author ikubicki
     * @return string
     */
    public function getUpdateStatement()
    {
        if (count($this->query->items) > 1) {
            throw new \Exception('Too many updates! Use multiple updates and transactions instead.');
        }
        list ($setters, $values1) = $this->getSetters();
        list ($where, $values2) = $this->getWhere();
        $where = $where ? "WHERE $where" : '';
        
        $statement = "UPDATE {$this->getTableName()} " .
            "SET $setters " .
            "$where;";
        return [$statement, array_merge($values1, $values2)];
    }
    
    /**
     *
     * @author ikubicki
     * @return string
     */
    public function getDeleteStatement()
    {
        list ($where, $values) = $this->getWhere();
        $where = $where ? "WHERE $where" : '';
        
        $statement = "DELETE FROM {$this->getTableName()} " .
            "$where " .
            "{$this->getLimit()} " .
            "{$this->getOffset()};";
        return [$statement, $values];
    }
    
    /**
     * 
     * @author ikubicki
     * @return string
     */
    protected function getWhere()
    {
        $criteria = '';
        $values = [];
        if (count($this->query->criteria)) {
            foreach ($this->query->criteria as $field => $value) {
                $criteria .= ($criteria ? ' AND ' : '');
                if (is_array($value)) {
                    $placeholders = '';
                    $iteration = 0;
                    foreach ($value as $valueItem) {
                        $placeholders .= $iteration ? ', ' : '';
                        $placeholders .= ":$field$iteration";
                        $values[":$field$iteration"] = $valueItem;
                        $iteration++;
                    }
                    $criteria .= "`$field` IN ($placeholders)";
                }
                else {
                    $criteria .= "`$field` = :$field";
                    $values[":$field"] = $value;
                }
            }
        }
        return [$criteria, $values];
    }
    
    /**
     * 
     * @author ikubicki
     * @return boolean
     */
    protected function containsIds()
    {
        return count($this->query->ids) > 0;
    }
    
    /**
     * 
     * @author ikubicki
     * @return string
     */
    protected function getInsertIgnore()
    {
        return $this->query->errors ? '' :  'IGNORE';
    }
    
    /**
     * 
     * @author ikubicki
     * @return string
     */
    protected function getTableName()
    {
        if (empty($this->table)) {
            $collection = $this->getSnakeCase($this->query->collection);
            $this->table = $this->getConfig()->database->get('prefix', '') . $collection;
        }
        return $this->table;
    }
    
    /**
     *
     * @author ikubicki
     * @return string
     */
    protected function getFields()
    {
        return '`' . implode('`, `', $this->query->fields) . '`';
    }
    
    /**
     *
     * @author ikubicki
     * @return string
     */
    protected function getBatches()
    {
        $batches = '';
        $group = 0;
        foreach ($this->query->items as $item) {
            $batches .= $group ? ', ' : '';
            $batches .= '(';
            $iteration = 0;
            foreach ($this->query->fields as $field) {
                $batches .= $iteration ? ', ' : '';
                $batches .= ":$field$group";
                $values[":$field$group"] = $item[$field];
                $iteration++;
            }
            $batches .= ')';
            $group++;
        }
        return [$batches, $values];
    }
    
    /**
     * 
     * @author ikubicki
     * @return string
     */
    protected function getSetters()
    {
        $fields = '';
        $values = [];
        $item = $this->query->items[0];
        unset($item[$this->query->primaryKey]);
        foreach ($item as $field => $value) {
            $fields .= ($fields ? ', ' : '');
            $fields .= "`$field` = :$field";
            $values[":$field"] = $value;
        }
        return [$fields, $values];
    }
    
    /**
     * 
     * @author ikubicki
     * @return string
     */
    protected function getLimit()
    {
        if ($this->query->limit !== null) {
            return 'LIMIT ' . $this->query->limit;
        }
        return '';
    }
    
    /**
     * 
     * @author ikubicki
     * @return string
     */
    protected function getOffset()
    {
        if ($this->query->offset !== null) {
            return 'OFFSET ' . $this->query->offset;
        }
        return '';
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