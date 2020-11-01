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
    protected $values;

    public function __construct($collection)
    {
        $this->from = $collection->getName();
        $this->where = $collection->getCriteria();
        $this->limit = $collection->getLimit();
        $this->order = $collection->getOrder();
        $this->offset = $collection->getOffset();
        $this->joins = $collection->getJoins();
        $this->schema = $collection->getSchema();
        $this->values = $collection->getValues();
    }

    public function select(array $fields = [])
    {
        return $this->buildSelect($fields);
    }

    public function insert()
    {
        return $this->buildInsert();
    }

    public function update()
    {
        return $this->buildUpdate();
    }

    public function delete()
    {
        return $this->buildDelete();
    }

    protected function buildSelect(array $fields)
    {
        if (!count($fields)) {
            $fields = $this->getFields();
        }
        $values = [];
        $query = "SELECT " . implode(', ', $fields) . PHP_EOL .
            "FROM `$this->from`" . PHP_EOL .
            $this->buildJoins() . PHP_EOL . 
            $this->buildWhere($values) . PHP_EOL .
            $this->buildOrder() . PHP_EOL .
            $this->buildLimit() . PHP_EOL .
            $this->buildOffset();
        return [$query, $values];
    }

    protected function buildInsert()
    {
        $values = [];
        $query = "INSERT INTO `$this->from` " . PHP_EOL .
            '(' . implode(', ', $this->getFields()) . ')' . PHP_EOL . 
            'VALUES ' . $this->buildValues($values);
        return [$query, $values];
    }

    protected function buildUpdate()
    {
        $values = [];
        $query = "UPDATE `$this->from` " . PHP_EOL .
            'SET ' . implode(', ', $this->getValueSetters($values)) . PHP_EOL . 
            $this->buildWhere($values) . PHP_EOL .
            $this->buildOrder() . PHP_EOL .
            $this->buildLimit() . PHP_EOL .
            $this->buildOffset();
        return [$query, $values];
    }

    protected function buildDelete()
    {
        $values = [];
        $query = "DELETE FROM `$this->from` " . PHP_EOL .
            $this->buildWhere($values) . PHP_EOL .
            $this->buildOrder() . PHP_EOL .
            $this->buildLimit() . PHP_EOL .
            $this->buildOffset();
        return [$query, $values];
    }
    
    protected function buildValues(&$values)
    {
        foreach ($this->schema as $field) {
            $values[] = $this->values[$field] ?? null;
        }
        $placeholders = array_fill(0, count($values), '?');
        return sprintf('(%s)', implode(', ', $placeholders));
    }

    protected function getValueSetters(&$values)
    {
        $setters = [];
        foreach ($this->values as $field => $value) {
            $values[] = $value;
            $setters[] = "`$this->from`.`$field` = ?";
        }
        return $setters;
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
            $clause = null;
            foreach($this->where as $field => $where) {
                if ($clause) {
                    $clause .= ' AND ';
                }
                if (is_numeric($field)) {
                    $clause .= $where;
                    continue;
                }
                if (strpos($field, '`') == false) {
                    $field = "`$this->from`.`$field`";
                }
                $clause .= $field;
                if (is_array($where)) {
                    $clause .= sprintf(
                        ' IN (%s)',
                        implode(', ', array_fill(0, count($where), '?'))
                    );
                    $values = array_merge($values, array_values($where));
                }
                else {
                    $clause .= ' = ?';
                    $values[] = $where;
                }
            }
            return "WHERE $clause";
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
        if (count($this->schema)) {
            $fields = $this->prefixFields($this->from, $this->schema);
            foreach($this->joins as $alias => $join) {
                $fields = array_merge($fields, 
                    $this->prefixFields($alias, $join['schema'], $alias . ',')
                );
            }
        }
        else {
            $fields = ['*'];
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