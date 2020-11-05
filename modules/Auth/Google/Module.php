<?php

namespace PhpBB\Modules\Auth\Google;
use PhpBB\Forum\Authenticator;

class Module extends Authenticator
{
    public function verify()
    {
        $token = $this->g['t'] ?? null;
        $hash = $this->g['a'] ?? null;

        $client = $this->getHttpClient('https://oauth2.googleapis.com/');

        try {
            $response = $client->get('tokeninfo?id_token=' . $token);
            $json = json_decode($response->getBody()->getContents(), false);
            if ($json->sub != $hash) {
                return false;
            }
            return $this->findRecord('google', $json->email, $json->sub);
        }
        catch(\Throwable $t) {
            error_log($t->getMessage());
        }
        return false;
    }
}