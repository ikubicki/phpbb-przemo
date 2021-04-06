<?php

namespace PhpBB\Modules\Auth\Facebook;
use PhpBB\Forum\Authenticator;
use PhpBB\Core\Context;
use PhpBB\Model\UserAuth;

class Module extends Authenticator
{

    public function check()
    {
        if ($this->fb['r'] ?? false) {
            if (!$this->authenticate()) {
                return true;
            }
            $this->setError('Facebook_user_taken');
        }
        return false;
    }

    public function create()
    {
        $index = $this->username[0] ?? null;
        $salt = md5(microtime());
        $passwords = $this->password ?? [null, null];
        $hash = $this->hash($passwords[0], $salt);

        $user = $this->getUsersCollection()->create($index);
        if ($user) {
            $record = $this->add($user->user_id, $index, $hash, $salt);
            return $record;
        }
    }

    public function authenticate()
    {
        $config = Context::getService('config');
        if (!$config->facebook_secret) {
            return false;
        }
        $token = $this->fb['r'] ?? null;
        $hash = $this->fb['u'] ?? null;
        try {
            $user = $this->getFBUser($this->parseSignedRequest($token, $config->facebook_secret));
            if (!$user) {
                return false;
            }
            if ($user->id != $hash) {
                return false;
            }
            $result = $this->findRecord('facebook', $user->email, $user->id);
            if (!$result) {
                return null;
            }
            return $result;
        }
        catch(\Throwable $t) {
            error_log($t->getMessage());
        }
        return false;
    }

    function parseSignedRequest($token, $secret)
    {
        list($signature, $payload) = explode('.', $token, 2); 
        $signature = $this->decode($signature);
        $data = json_decode($this->decode($payload), false);
        $signatureCheck = hash_hmac('sha256', $payload, $secret, $raw = true);
        if (!\hash_equals($signature, $signatureCheck)) {
           throw new \Exception('Bad Signed JSON signature!');
        }
        if (time() - $data->issued_at > 3600) {
            throw new \Exception('Request expired!');
        }
        return $data;
    }
     
    private function decode($input)
    {
        return base64_decode(strtr($input, '-_', '+/'));
    }
    
    private function getFBUser($request)
    {
        if ($request) {
            $token = $request->oauth_token ?? '';
            $userId = $request->user_id ?? '';
            $fields = "?fields=id,name,email&access_token=$token";
            $client = $this->getHttpClient('https://graph.facebook.com/');
            $response = $client->get("$userId$fields");
            if ($response->getStatusCode() < 300) {
                return json_decode($response->getBody()->getContents(), false);
            }
        }
    }
}