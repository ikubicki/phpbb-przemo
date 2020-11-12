<?php

namespace PhpBB\Modules\Shouts;

/**
 * Shouts module
 * 
 * @author ikubicki
 */
class Shouts
{

    protected $session = [
        'id' => null,
    ];
    protected $messages = [];
    protected $token;
    protected $action = 'refresh';
    protected $online = [];

    /**
     * Constructor
     * 
     * @author ikubicki
     * @param string $encryption_key
     * @param string $token
     */
    public function __construct($token = null)
    {
        $this->token = $token ?: null;
    }

    /**
     * Token setter
     * 
     * @author ikubicki
     * @param string $token
     * @return array
     */
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

    /**
     * User ID setter
     * 
     * @author ikubicki
     * @param integer $userId
     */
    public function setUserId($userId)
    {
        if ($this->session['id'] != $userId) {
            $this->session['id'] = $userId;
            $this->generateToken();
        }
    }

    /**
     * Action setter
     * 
     * @author ikubicki
     * @param string $action
     */
    public function setAction($action)
    {
        if ($this->action != $action) {
            $this->action = $action;
            $this->generateToken();
        }
    }

    /**
     * Generates token
     * 
     * @author ikubicki
     */
    protected function generateToken()
    {
        $payload = json_encode([$this->session['id'], md5(microtime()), $this->action]);
        $this->token = $this->encrypt($payload);
    }

    /**
     * Extracts data from token
     * 
     * @author ikubicki
     * @param string $token
     * @return array
     */
    protected function getTokenData($token)
    {
        $payload = $this->decrypt($token);
        return json_decode($payload);
    }

    /**
     * Encrypts the data
     * 
     * @author ikubicki
     * @param string $payload
     * @return string
     */
    protected function encrypt($payload)
    {
        $encryption = Context::getService('encryption');
        return $encryption->encrypt($payload);
    }

    /**
     * Decrypts string
     * 
     * @author ikubicki
     * @param string $token
     * @return string
     */
    protected function decrypt($token)
    {
        $encryption = Context::getService('encryption');
        return $encryption->decrypt($token);
    }

    /**
     * Verifies whether token is valud
     * 
     * @author ikubicki
     * @param integer $userId
     * @param string $action
     * @return boolean
     */
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

    /**
     * Adds message
     * 
     * @author ikubicki
     * @param string $message
     */
    public function addMessage($message)
    {
        $this->messages[] = $message;
    }

    /**
     * Adds online users ID
     * 
     * @author ikubicki
     * @param integer $userId
     */
    public function addOnline($userId)
    {
        $this->online[$userId] = $userId;
    }

    /**
     * Triggers error
     * 
     * @author ikubicki
     * @param string $error
     */
    public function error($error)
    {
        $this->send(['error' => $error]);
    }

    /**
     * Prints JSON to output and exit
     * 
     * @author ikubicki
     * @param array $extras
     */
    public function send(array $extras = [])
    {
        $data = [
            'session' => $this->session,
            'token' => $this->token,
            'action' => $this->action,
            'online' => array_values($this->online),
            'messages' => $this->messages,
        ];
        ob_clean();
        header('Content-Type: application/json');
        echo json_encode($data + $extras);
        exit;
    }
}