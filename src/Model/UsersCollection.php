<?php

namespace PhpBB\Model;
use PhpBB\Data\Collection;
use PhpBB\Data\Entity;

class UsersCollection extends Collection
{
    public function __construct($name = null, $class = null)
    {
        parent::__construct('users', User::class, 'user_id');
    }

    public static function registerEntity($namespace, Entity $entity)
    {
        parent::registerEntity('users', $entity);
    }
}