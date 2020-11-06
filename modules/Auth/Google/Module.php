<?php

namespace PhpBB\Modules\Auth\Google;
use PhpBB\Forum\Authenticator;

class Module extends Authenticator
{
    public function verify()
    {
        $token = $this->g['t'] ?? null;
        $hash = $this->g['a'] ?? null;

        try {
            $user = $this->getGUser($token);
            if (!$user) {
                return false;
            }
            if ($user->sub != $hash) {
                return false;
            }
            $result = $this->findRecord('google', $user->email, $user->sub);
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

    private function getGUser($token)
    {
        $client = $this->getHttpClient('https://oauth2.googleapis.com/');
        $response = $client->get('tokeninfo?id_token=' . $token);
        if ($response->getStatusCode() < 300) {
            return json_decode($response->getBody()->getContents(), false);
        }
    }
}