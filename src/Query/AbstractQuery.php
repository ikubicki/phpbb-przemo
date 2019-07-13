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
     * @var array
     */
    public $items = [];
    
    /**
     * @var array
     */
    public $fields = [
        'id',
        'created_at',
    ];
    
    /**
     * @var array
     */
    public $criteria = [];
    
    /**
     * @var integer
     */
    public $limit = -1;
    
    /**
     * @var integer
     */
    public $offset = 0;
    
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
    public $errors = true;
    
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
     * @param array|BaseEntity $itemFields
     */
    public function addItem($itemFields)
    {
        if ($itemFields instanceof BaseEntity) {
            $itemFields = $itemFields->toArray();
        }
        $this->items[] = $itemFields;
        $this->fields = array_unique($this->fields + array_keys($itemFields));
        if (!empty($itemFields['id'])) {
            $this->ids[] = $itemFields['id'];
        }
        return $this;
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
        if ($field == 'id') {
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