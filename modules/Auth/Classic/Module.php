<?php

namespace PhpBB\Modules\Auth\Classic;
use PhpBB\Forum\Authenticator;
use PhpBB\Core\Context;
use PhpBB\Model\UserAuth;

class Module extends Authenticator
{

    public function check()
    {
        $index = $this->username[0] ?? null;
        $passwords = $this->password ?? [null, null];;
        if ($index && $passwords[0]) {
            if ($this->findRecord('classic', $index)) {
                $this->setError('Username_taken');
                return false;
            }
            if ($passwords[0] != $passwords[1]) {
                $this->setError('Passwords_doesnt_match');
                return false;
            }
            if (!$this->verifyPassword($passwords[0])) {
                $this->setError('Passwords_low_complexity');
                return false;
            }
        }
        return true;
    }

    public function authenticate()
    {   
        $index = $this->username ?? null;
        $password = $this->password ?? null;
        if ($index) {
            $record = $this->findRecord('classic', $index);
            if (!$record) {
                $this->setError('Invalid_login_or_password');
                return (new Legacy)->verify();
            }
            if ($record->hash === $this->hash($password, $record->salt)) {
                return $record;
            }
            $this->setError('Invalid_login_or_password');
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

    protected function verifyPassword($password)
    {
        return strlen($password) > 5 &&
            preg_match('#[a-z]+#', $password) &&
            preg_match('#[A-Z]+#', $password) &&
            preg_match('#[0-9]+#', $password) &&
            preg_match('#[^0-9a-zA-Z]+#', $password);
    }
}