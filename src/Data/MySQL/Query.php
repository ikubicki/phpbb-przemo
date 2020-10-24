<?php

namespace PhpBB\Data\MySQL;

class Query
{

    protected $from;
    protected $where;
    protected $limit;
    protected $order;
    protected $offset;
    protected $joins;

    public function __construct($collection)
    {
        $this->from = $collection->getName();
        $this->where = $collection->getCriteria();
        $this->limit = $collection->getLimit();
        $this->order = $collection->getOrder();
        $this->offset = $collection->getOffset();
        $this->joins = $collection->getJoins();
        $this->schema = $collection->getSchema();
    }

    public function select(array $fields = [])
    {
        return $this->buildSelect($fields);
    }

    protected function buildSelect(array $fields)
    {
        if (!count($fields)) {
            $fields = $this->getFields();
        }
        $values = [];
        $query = "SELECT " . implode(', ', $fields) . PHP_EOL .
            "FROM $this->from" . PHP_EOL .
            $this->buildJoins() . PHP_EOL . 
            $this->buildWhere($values) . PHP_EOL .
            $this->buildOrder() . PHP_EOL .
            $this->buildLimit() . PHP_EOL .
            $this->buildOffset();
        return [$query, $values];
    }

    protected function buildJoins()
    {
        $query = '';
        foreach($this->joins as $alias => $join) {
            $query .= $join['join'] . ' ';
            $query .= sprintf('`%s` as `%s`', $join['prefixed'], $alias) . PHP_EOL;
            if (sizeof($join['on'])) {
                $fields = [];
                foreach($join['on'] as $joinField => $referenceField) {
                    $fields[] = sprintf('`%s`.`%s` = `%s`.`%s`', $alias, $joinField, $this->from, $referenceField);
                }
                $query .= 'ON ' . implode(' AND ', $fields) . PHP_EOL;
            }
        }
        return $query;
    }

    protected function buildWhere(&$values)
    {
        if (is_string($this->where) && strlen($this->where)) {
            return 'WHERE ' . $this->where;
        }
        if (is_array($this->where) && count($this->where)) {
            $values = array_values($this->where);
            return "WHERE " . implode(', ', array_map(function($v) {
                return $v . ' = ?';
            }, array_keys($this->where)));
        }
    }

    protected function buildOrder()
    {
        if (count($this->order)) {
            return "ORDER BY " . implode(', ', array_map(function($v, $k) {
                return $k . ' ' . strtoupper($v);
            }, $this->order, array_keys($this->order)));
        }
    }

    protected function buildLimit()
    {
        if ($this->limit) {
            return "LIMIT $this->limit";
        }
    }

    protected function buildOffset()
    {
        if ($this->offset) {
            return "OFFSET $this->offset";
        }
    }

    protected function getFields()
    {
        $fields = $this->prefixFields($this->from, $this->schema);
        foreach($this->joins as $alias => $join) {
            $fields = array_merge($fields, 
                $this->prefixFields($alias, $join['schema'], $alias . ',')
            );
        }
        return $fields;
    }

    protected function prefixFields($schema, $fields, $alias = null)
    {
        $callback = function($field) use ($schema, $alias) {
            return $alias ? "`$schema`.`$field` as `$alias$field`" : "`$schema`.`$field`";
        };
        return array_map($callback, $fields);
    }
}