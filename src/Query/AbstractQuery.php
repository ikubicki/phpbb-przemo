<?php

namespace PHPBB\Przemo\Query;

use PHPBB\Przemo\Model\BaseEntity;

abstract class AbstractQuery
{
    
    /**
     * @var string
     */
    const OPERATION = null;
    
    /**
     * @var string
     */
    const ORDER_ASCENDING = 'asc';
    
    /**
     * @var string
     */
    const ORDER_DESCENDING = 'desc';
    
    /**
     * @var string
     */
    public $collection;
    
    /**
     * @var string
     */
    public $primaryKey;
    
    /**
     * @var array
     */
    public $items = [];
    
    /**
     * @var array
     */
    public $fields = [];
    
    /**
     * @var array
     */
    public $criteria = [];
    
    /**
     * @var integer
     */
    public $limit = null;
    
    /**
     * @var integer
     */
    public $offset = null;
    
    /**
     * @var array
     */
    public $order = [];
    
    /**
     * @var array
     */
    public $ids = [];
    
    /**
     * @var boolean
     */
    public $errors = false;
    
    /**
     * 
     * @author ikubicki
     * @param array $items
     */
    public function addItems(array $items)
    {
        foreach ($items as $itemFields) {
            $this->addItem($itemFields);
        }
        return $this;
    }
    
    /**
     * 
     * @author ikubicki
     * @param BaseEntity $item
     */
    public function addItem(BaseEntity $item)
    {
        $itemFields = $item->toArray();
        $this->primaryKey = $item->primaryKeyName();
        $this->items[] = $itemFields;
        $this->fields = array_unique($this->fields + array_keys($itemFields));
        if (!empty($itemFields[$this->primaryKey])) {
            $this->ids[] = $itemFields[$this->primaryKey];
        }
        return $this;
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $field
     */
    public function removeField($field)
    {
        foreach ($this->items as $item) {
            unset($item[$field]);
        }
    }
    
    /**
     *
     * @author ikubicki
     * @param array $itemFields
     */
    public function addCriteria($field, $values)
    {
        if (!is_array($values)) {
            $values = [$values];
        }
        if (array_key_exists($field, $this->criteria)) {
            $values = array_merge(array_values($values) + $this->criteria[$field]);
        }
        $this->criteria[$field] = $values;
        $this->fields[] = $field;
        $this->fields = array_unique($this->fields);
        if ($field == $this->primaryKey) {
            $this->ids = array_merge($this->ids, $values);
            $this->ids = array_unique($this->ids);
        }
        return $this;
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $field
     * @param string $direction
     */
    public function addOrder($field, $direction = self::ORDER_ASCENDING)
    {
        $this->order[] = [$field, $direction];
        $this->fields[] = $field;
        $this->fields = array_unique($this->fields);
        return $this;
    }
}