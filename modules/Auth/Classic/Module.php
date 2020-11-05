<?php

namespace PhpBB\Modules\Auth\Classic;
use PhpBB\Forum\Authenticator;
use PhpBB\Core\Context;
use PhpBB\Model\UserAuth;

class Module extends Authenticator
{

    public function verify()
    {   
        $index = $this->login ?? null;
        $password = $this->password ?? null;
        if ($index) {
            $record = $this->findRecord('classic', $index);
            if (!$record) {
                return (new Legacy)->verify();
            }
            if ($record->hash === $this->hash($password, $record->salt)) {
                return $record;
            }
        }
        return false;
    }

    public function hash($text, &$salt = null)
    {
        if (!$salt) {
            $salt = substr(sha1(microtime()), mt_rand(0, 7), mt_rand(16, 32));
        }
        $encryption = Context::getService('encryption');
        return $encryption->encrypt($text . $salt);
    }

    public function add($userId, $index, $hash, $salt = null)
    {
        $record = $this->findRecord('classic', $index);
        if (!$record) {
            $record = new UserAuth;
            $record->type = 'classic';
            $record->user_id = $userId;
            $record->index = $index;
        }
        $record->hash = $hash;
        $record->salt = $salt;
        $record->active = 1;
        $record->save();
        return $record;
    }
}