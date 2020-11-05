<?php

namespace PhpBB\Modules\Auth\Facebook;
use PhpBB\Forum\Authenticator;

class Module extends Authenticator
{

    public function verify()
    {
        $token = $this->fb['r'] ?? null;
        $hash = $this->fb['u'] ?? null;
        try {
            $user = $this->getFBUser($this->parseSignedRequest($token, $this->config->facebook_secret));
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