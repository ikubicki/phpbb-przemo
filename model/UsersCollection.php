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

    public function byName($username)
    {
        return $this->one([
            'username' => $username,
        ]);
    }

    public function create($username)
    {
        $entity = $this->byName($username);
        if (!$entity) {
            $entity = new User;
            $entity->user_active = 0;
            $entity->username = $username;
            $entity->user_regdate = time();
            $entity->save();
        }
        return $entity;
    }
}