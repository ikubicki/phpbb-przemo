<?php

namespace PhpBB\Model;
use PhpBB\Data\Collection;
use PhpBB\Data\Entity;

class TopicsCollection extends Collection
{
    public function __construct($name = null, $class = null)
    {
        parent::__construct('topics', Topic::class, 'topic_id');
    }

    public static function registerEntity($namespace, Entity $entity)
    {
        parent::registerEntity('topics', $entity);
    }
}