<?php

namespace PhpBB\Model;
use PhpBB\Data\Collection;
use PhpBB\Data\Entity;

class CategoriesCollection extends Collection
{
    public function __construct($name = null, $class = null)
    {
        parent::__construct('categories', Category::class, 'cat_id');
    }

    public static function registerEntity($namespace, Entity $entity)
    {
        parent::registerEntity('categories', $entity);
    }
}