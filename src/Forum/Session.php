<?php

namespace PhpBB\Forum;

use PhpBB\Core\Context;
use PhpBB\Data\Cache;
use PhpBB\Model\UsersCollection;

class Session
{

    protected $id;
    protected $data = [];
    protected $cookie;
    protected $user;

    public function __construct($cookie = false)
    {
        $this->cookie = $cookie;
        if ($this->cookie) {
            /* @todo make it configurable
            if (time() - $this->unsalt() > 3600) {
                $this->terminate();
                return;
            }
            */
            $this->extractCookieData($this->cookie->read());
            if (time() - $this->unsalt() > 1800) {
                $this->generateId();
            }
            
        }
    }

    public function terminate()
    {
        $this->id = null;
        $this->data = [];
        if ($this->cookie) {
            $this->cookie->delete();
        }
    }

    public function set(array $data)
    {
        $changed = false;
        foreach($data as $property => $value) {
            if ($this->data[$property] != $value) {
                $changed = true;
            }
        }
        if ($changed) {
            $this->data = $this->data + $data;
            $this->generateId();
        }
    }

    public function id()
    {
        return $this->id;
    }

    public function all()
    {
        return $this->data;
    }

    public function isAuthenticated()
    {
        return $this->data['user_id'] > 0;
    }

    public function isAdministrator()
    {
        return $this->isAuthenticated() && ($this->getUser()->isAdministrator() || $this->getUser()->isJuniorAdministrator());
    }

    public function getUser()
    {
        if (!$this->user) {
            $this->user = $this->getUsersCollection()->get($this->data['user_id'] ?? -1);
        }
        return $this->user;
    }

    public function getUrl()
    {
        return new Url('profile.php', $this->getUser()->getName());
    }

    protected function salt()
    {
        $this->data['salt'] = base_convert(microtime(true) * 100000, 10, 36);
    }

    protected function unsalt()
    {
        return (int) (base_convert($this->data['salt'], 36, 10) / 1000000);
    }

    protected function generateId()
    {
        $encryption = Context::getService('encryption');
        $this->salt();
        $this->id = $encryption->encrypt(json_encode($this->data));
        if ($this->cookie) {
            $this->cookie->write($this->id);
        }
    }

    protected function extractCookieData($token)
    {
        $encryption = Context::getService('encryption');
        $this->id = $token;
        $this->data = json_decode($encryption->decrypt($token), true);
    }

    protected function getUsersCollection()
    {
        return new UsersCollection;
        //return new Cache(new UsersCollection);
    }
}