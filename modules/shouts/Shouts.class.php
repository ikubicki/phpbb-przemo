<?php

namespace phpBB\Modules\Shouts;

class Shouts
{

    protected $session = [];
    protected $messages = [];
    protected $token;
    protected $action = 'refresh';
    protected $online = [];
    protected $encryption_key;

    public function __construct($encryption_key, $token = null)
    {
        $this->encryption_key = $encryption_key;
        $this->token = $token ?: null;
    }

    public function setToken($token)
    {
        
        if ($token) {
            $this->token = $token;
            $tokenData = $this->getTokenData($token);
            if (!empty($tokenData[0])) {
                $this->session['id'] = intval($tokenData[0]);
            }
            if (!empty($tokenData[2])) {
                $this->action = $tokenData[2];
            }
        }
        return [$this->session['id'], $this->action];
    }

    public function setUserId($userId)
    {
        if ($this->session['id'] != $userId) {
            $this->session['id'] = $userId;
            $this->generateToken();
        }
    }

    public function setAction($action)
    {
        if ($this->action != $action) {
            $this->action = $action;
            $this->generateToken();
        }
    }

    protected function generateToken()
    {
        $payload = json_encode([$this->session['id'], md5(microtime()), $this->action, $this->timestamp]);
        $this->token = $this->encrypt($payload);
    }

    protected function getTokenData($token)
    {
        $payload = $this->decrypt($token);
        return json_decode($payload);
    }

    protected function encrypt($payload)
    {
        $iv = substr(md5($this->encryption_key), 4, 16);
        $token = openssl_encrypt($payload, 'AES-128-CBC', $this->encryption_key, 0, $iv);
        $token = str_replace(['+', '/'], ['.', '_'], $token);
        return trim($token, '=');
    }

    protected function decrypt($token)
    {
        $iv = substr(md5($this->encryption_key), 4, 16);
        $token = str_replace(['.', '_'], ['+', '/'], $token);
        return openssl_decrypt($token, 'AES-128-CBC', $this->encryption_key, 0, $iv);
    }

    public function validateToken($userId, $action)
    {
        // var_dump($userId, $action, $this->session['id'], $this->action);
        if ($this->session['id'] != $userId) {
            return false;
        }
        switch($action) {
            default:
                return false;
            case 'add':
            case 'message':
            case 'refresh':
                break;
            case 'edit':
            case 'delete':
                return $this->action == 'message';
        }
        return true;
    }

    public function addMessage($message)
    {
        $this->messages[] = $message;
    }

    public function addOnline($userId)
    {
        $this->online[$userId] = $userId;
    }

    public function error($error)
    {
        $this->send(['error' => $error]);
    }

    public function send(array $extras = [])
    {
        $data = [
            'session' => $this->session,
            'token' => $this->token,
            'action' => $this->action,
            'online' => array_values($this->online),
            'messages' => $this->messages,
        ];
        header('Content-Type: application/json');
        echo json_encode($data + $extras);
        exit;
    }
}