<?php

namespace PhpBB\Model;
use PhpBB\Data\Collection;
use PhpBB\Data\Entity;

class ForumsCollection extends Collection
{
    public function __construct($name = null, $class = null)
    {
        parent::__construct('forums', Forum::class, 'forum_id');
    }

    public static function registerEntity($namespace, Entity $entity)
    {
        parent::registerEntity('forums', $entity);
    }

    public function getAll()
    {
        return $this
            ->leftjoin(new PostsCollection, 'post_id', 'forum_last_post_id', [], 'latestpost')
            ->all();
    }
}