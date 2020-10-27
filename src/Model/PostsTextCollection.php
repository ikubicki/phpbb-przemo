<?php

namespace PhpBB\Model;
use PhpBB\Data\Collection;
use PhpBB\Data\Entity;

class PostsTextCollection extends Collection
{
    public function __construct($name = null, $class = null)
    {
        parent::__construct('posts_text', PostText::class, 'post_id');
    }

    public static function registerEntity($namespace, Entity $entity)
    {
        parent::registerEntity('posts_text', $entity);
    }
}