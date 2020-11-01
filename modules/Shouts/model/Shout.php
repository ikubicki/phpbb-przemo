<?php

namespace PhpBB\Modules\Shouts\model;
use PhpBB\Data\Entity;
use PhpBB\Forum\Session;
use PhpBB\Core\Context;

class Shout extends Entity
{
    public $id;
    public $sb_user_id;
    public $msg;
    public $timestamp;

    protected $session;

    public function getAuthor()
    {
        if (!$this->getRef('poster')) {
            $criteria = ['user_id' => $this->sb_user_id];
            $poster = $this->getUsersCollection()->one($criteria);
            $this->addRef('poster', $poster);
        }
        return $this->getRef('poster');
    }

    public function row($permissions)
    {
        global $userdata;
        $date = date('Y-m-d', $this->timestamp);
        $time = date('H:i:s', $this->timestamp);
        $author = $this->getAuthor();
        $message = [
            'id' => $this->id,
            'author' => [
                'id' => $author->user_id,
                'name' => $author->username,
                'url' => $author->getUrl()->url,
                'online' => $author->isOnline(),
            ],
            'text' => $this->msg,
            'time' => $date == date('Y-m-d') ? $time : "$date $time",
        ];
        $message['acl'] = [
            'edit' => $this->checkPermissions($permissions, 'edit'),
            'delete' => $this->checkPermissions($permissions, 'delete'),
        ];
        return $message;
    }

    protected function checkPermissions($permissions, $action)
    {
        $own = $this->getSession()->getUserId() == $this->sb_user_id;
        switch($action) {
            case 'add':
                return $permissions->create;
            case 'edit':
                return $own ? $permissions->edit || time() - $this->timestamp < 60 : $permissions->mod;
            case 'delete':
                return $own ? $permissions->delete || time() - $this->timestamp < 60 : $permissions->admin;
        }
        return false;
    }

    protected function getSession()
    {
        if (!$this->session) {
            $this->session = Context::getService('session');
        }
        return $this->session;
    }
    
    protected function getUsersCollection()
    {
        return new UsersCollection;
    }
}