<?php

namespace PHPBB\Przemo\Core;

use Symfony\Component\HttpFoundation\Request;
use PHPBB\Przemo\Core\Form\Select;
use PHPBB\Przemo\Core\Form\Text;

class Form
{
    
    /**
     * @var string
     */
    const METHOD_POST = 'post';
    
    /**
     * @var string
     */
    const METHOD_GET = 'get';
    
    /**
     * @var string
     */
    public $name;
    
    /**
     * @var string
     */
    public $action;
    
    /**
     * @var string
     */
    public $method = self::METHOD_POST;
    
    /**
     * @var array
     */
    public $fields = [];
    
    /**
     * @var array
     */
    public $hidden_fields = [];
    
    /**
     * @var Request
     */
    protected $request;
    
    /**
     * @var string
     */
    protected $algorithm = 'AES-256-CBC';
    
    /**
     * @var string
     */
    protected $encryptionKey;
    
    /**
     * @var string
     */
    protected $initializationVector;
    
    /**
     * 
     * @author ikubicki
     * @param Request $request
     */
    public function __construct(Request $request = null)
    {
        $this->request = $request;
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $field
     * @param array $useless
     * @return mixed
     */
    public function __call($field, $useless = [])
    {
        if (isset($this->fields[$field])) {
            return $this->fields[$field];
        }
    }
    
    /**
     *
     * @author ikubicki
     * @param string $name
     * @param mixed $field
     * @param string $value
     */
    public function addField($name, $field, $value = false)
    {
        $this->fields[$name] = $field;
        $field->name = $name;
        if ($this->request && $this->request->request->has($name)) {
            $field->value = $this->request->request->get($name);
        }
        else if ($value !== false) {
            $field->value = $value;
        }
    }
    
    /**
     *
     * @author ikubicki
     * @param string $name
     * @param string $value
     */
    public function addHiddenField($name, $value = false)
    {
        if ($value === false && $this->request && $this->request->request->has($name)) {
            $value = $this->request->request->get($name);
        }
        $this->hidden_fields[$name] = $value;
    }
    
    /**
     *
     * @author ikubicki
     * @param string $value
     * @return Text
     */
    public function text($value = null)
    {
        return new Text($value);
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $value
     * @return Select
     */
    public function select($value = null)
    {
        return new Select($value);
    }
    
    /**
     * 
     * @author ikubicki
     * @param string $field
     */
    public function addCrfHiddenField($field = 'crft')
    {
        $this->addHiddenField($field, $this->getCrfToken());
    }
    
    /**
     * 
     * @author ikubicki
     * @param array $errors
     */
    public function setValidationErrors(array $errors = [])
    {
        foreach ($errors as $field => $error) {
            if (isset($this->fields[$field])) {
                $this->fields[$field]->error = $error;
            }
        }
    }
    
    /**
     * 
     * @author ikubicki
     * @param unknown $encryptionKey
     */
    public function setEncryptionKey($encryptionKey, $initializationVector = null)
    {
        $this->encryptionKey = $encryptionKey;
        if (!$initializationVector) {
            $initializationVector = substr(md5($this->encryptionKey), 8, 16);
        }
        $this->initializationVector = $initializationVector;
    }
    
    /**
     * 
     * @author ikubicki
     * @return string
     */
    public function getCrfToken($field = 'crft')
    {
        if ($this->request && $this->request->request->has($field) && $this->verifyCrfToken($field)) {
            return $this->request->request->get($field);
        }
        return $this->generateCrfToken();
    }
    
    /**
     * 
     * @author ikubicki
     * @return boolean
     */
    public function verifyCrfToken($field = 'crft')
    {
        if ($this->request && $this->request->request->get($field)) {
            $payload = openssl_decrypt($this->request->request->get($field), $this->algorithm, $this->encryptionKey, 0, $this->initializationVector);
            $payload = json_decode($payload);
            if (empty($payload->time) || $payload->time < time()) {
                return false;
            }
            if (empty($payload->ip) || $payload->ip != $this->request->server->get('REMOTE_ADDR')) {
                return false;
            }
        }
        return true;
    }
    
    /**
     * 
     * @author ikubicki
     * @return string
     */
    protected function generateCrfToken()
    {
        if (!$this->encryptionKey) {
            throw new \Exception('No encryption key');
        }
        $payload = json_encode([
            'time' => time() + 1800,
            'ip' => $this->request ? $this->request->server->get('REMOTE_ADDR') : '',
        ]);
        return openssl_encrypt($payload, $this->algorithm, $this->encryptionKey, 0, $this->initializationVector);
    }
}