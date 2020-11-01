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
    public $user_level;
    public $user_jr;
    public $user_session_time;

    public function getName()
    {
        return $this->username;
    }

    public function getUrl($class = '')
    {
        return new Url('index.php?u=' . $this->user_id, $this->username, ['class' => $class]);
    }

    public function getPostsCount()
    {
        return $this->user_posts;
    }
    
    public function getAvatar($class = '')
    {
        return new Image('/modules/Avatars/index.php?user=' . $this->user_id, ['class' => $class]);
    }

    public function getSignature()
    {
        return $this->user_sig;
    }

    public function isAdministrator()
    {
        return $this->user_level == 1;
    }

    public function isJuniorAdministrator()
    {
        return $this->user_jr > 0;
    }

    public function isModerator()
    {
        return $this->user_level == 2;
    }

    public function isOnline()
    {
        return time() - $this->user_session_time < 300;
    }
}