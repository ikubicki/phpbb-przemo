<?php

namespace PhpBB\Model;
use PhpBB\Data\Collection;
use PhpBB\Data\Entity;

class UsersAuthCollection extends Collection
{
    public function __construct($name = null, $class = null)
    {
        parent::__construct('users_auth', UserAuth::class, ['type', 'index']);
    }

    public static function registerEntity($namespace, Entity $entity)
    {
        parent::registerEntity('users_auth', $entity);
    }
}