<?php

namespace PhpBB\Model;
use PhpBB\Data\Entity;
use PhpBB\Forum\Url;
use PhpBB\Forum\Image;

class User extends Entity
{
    public $user_id;
    public $username;
    public $user_sig;
    public $user_posts;

    public function getUrl($class = '')
    {
        return new Url('test.php?p=' . $this->user_id, $this->username, ['class' => $class]);
    }

    public function getPostsCount()
    {
        return $this->user_posts;
    }
    
    public function getAvatar($class = '')
    {
        return new Image('/modules/avatars/avatar.php?user=' . $this->user_id, ['class' => $class]);
    }

    public function getSignature()
    {
        return $this->user_sig;
    }
}