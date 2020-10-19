<?php

namespace PhpBB\Model;

class Category extends ForumHierarchicalEntity
{


    public function getName()
    {
        return $this->cat_title;
    }

    public function getIndex()
    {
        return "c:$this->cat_id";
    }

    public function getParentIndex()
    {
        if ($this->cat_main) {
            return "$this->cat_main_type:$this->cat_main";
        }
        return null;
    }

    public function getOrder()
    {
        return $this->cat_order;
    }

    public static function __set_state(array $properties)
    {
        $entity = parent::__set_state($properties);
        CategoriesCollection::registerEntity(null, $entity);
        return $entity;
    }

    public function getUrl()
    {
        return 'index.php?c=' . $this->cat_id;
    }
}