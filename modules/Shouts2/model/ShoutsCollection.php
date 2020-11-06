<?php

namespace PhpBB\Modules\Shouts\model;
use PhpBB\Data\Collection;
use PhpBB\Data\Entity;

class ShoutsCollection extends Collection
{
    public function __construct($name = null, $class = null)
    {
        parent::__construct('shoutbox', Shout::class, 'id');
    }

    public static function registerEntity($namespace, Entity $entity)
    {
        parent::registerEntity('shoutbox', $entity);
    }
}