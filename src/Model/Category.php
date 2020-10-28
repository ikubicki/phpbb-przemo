<?php

namespace PhpBB\Model;
use PhpBB\Forum\Url;

class Category extends ForumHierarchicalEntity
{

    public function getType()
    {
        return 'category';
    }

    public function getName()
    {
        return $this->cat_title;
    }

    public function getDescription()
    {
        return $this->cat_desc;
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

    public function getUrl($class = null)
    {
        return new Url('test.php?c=' . $this->cat_id, $this->getName(), ['class' => $class]);
    }

    public function getPostsCount()
    {
        return null;
    }

    public function getTopicsCount()
    {
        return null;
    }
}