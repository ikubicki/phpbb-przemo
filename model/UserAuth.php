<?php

namespace PhpBB\Model;
use PhpBB\Data\Entity;

class UserAuth extends Entity
{
    public $user_id;
    public $type;
    public $index;
    public $hash;
    public $salt;
    public $active;

    public function getUser()
    {
        if (!$this->getRef('user')) {
            $user = $this->getUsersCollection()->get($this->user_id);
            $this->addRef('user', $user);
        }
        return $this->getRef('user');
    }

    protected function getUsersCollection()
    {
        return new UsersCollection;
    }
}