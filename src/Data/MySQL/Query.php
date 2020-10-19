<?php

namespace PhpBB\Data\MySQL;

class Query
{

    protected $from;
    protected $where;
    protected $limit;
    protected $order;
    protected $offset;

    public function __construct($collection)
    {
        $this->from = $collection->getName();
        $this->where = $collection->getCriteria();
        $this->limit = $collection->getLimit();
        $this->order = $collection->getOrder();
        $this->offset = $collection->getOffset();
    }

    public function select(array $fields = [])
    {
        if (!count($fields)) {
            $fields = ['*'];
        }
        return $this->buildSelect($fields);
    }

    protected function buildSelect(array $fields)
    {
        $values = [];
        $query = "SELECT " . implode(', ', $fields) . PHP_EOL .
            "FROM $this->from" . PHP_EOL .
            $this->buildWhere($values) . PHP_EOL .
            $this->buildOrder() . PHP_EOL .
            $this->buildLimit() . PHP_EOL .
            $this->buildOffset();
        return [$query, $values];
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
}