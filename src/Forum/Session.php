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

    public function getUserId()
    {
        return 2;
        return $this->data['user_id'] ?? -1;
    }

    public function isAuthenticated()
    {
        return $this->getUserId() > 0;
    }

    public function isAdministrator()
    {
        return $this->isAuthenticated() && $this->getUser()->isAdministrator();
    }

    public function isJunior()
    {
        return $this->isAuthenticated() && $this->getUser()->isJuniorAdministrator();
    }

    public function isModerator()
    {
        return $this->isAuthenticated() && $this->getUser()->isModerator();
    }

    public function getPermissions($permissions)
    {
        if ($this->isAdministrator() && isset($permissions['admin'])) {
            return $this->buildPermissions($permissions['admin']);
        }
        if ($this->isJunior() && isset($permissions['jr_admin'])) {
            return $this->buildPermissions($permissions['jr_admin']);
        }
        if ($this->isModerator() && isset($permissions['mod'])) {
            return $this->buildPermissions($permissions['mod']);
        }
        if ($this->isAuthenticated() && isset($permissions['user'])) {
            return $this->buildPermissions($permissions['user']);
        }
        if (isset($permissions['anonymous'])) {
            return $this->buildPermissions($permissions['anonymous']);
        }
        if (is_string($permissions)) {
            return $this->buildPermissions($permissions);
        }
        return $this->buildPermissions(false);
    }

    protected function buildPermissions($map)
    {
        $binmap = str_split(strrev(sprintf('%06d', base_convert($map, 36, 2))));
        array_walk($binmap, function(&$v){$v = $v > 0;});
        return (object) array_combine(['list', 'create', 'edit', 'delete', 'mod', 'admin'], $binmap);
    }

    public function getUser()
    {
        if (!$this->user) {
            $this->user = $this->getUsersCollection()->get($this->getUserId());
        }
        return $this->user;
    }

    public function getUrl()
    {
        return new Url('profile.php', $this->getUser()->getName());
    }

    public function getLogout()
    {
        return new Url('auth.php?logout', $this->phrase('Logout'));
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

    protected function phrase($key)
    {
        return Context::getService('phrases')->get($key);
    }
}