<?php

namespace PhpBB\Modules\Recaptcha;
use GuzzleHttp\Client;

class Module
{

    protected $verbose = false;

    public function __construct($verbose = false)
    {
        $this->verbose = $verbose;
    }

    public function verify($secret, $token, $action = null, $hostname = null)
    {
        $response = $this->getHttpClient()->post('siteverify', ['form_params' => [
            'secret' => $secret,
            'response' => $token,
        ]]);
        $response = $response->getBody()->getContents();
        if ($response) {
            $response = json_decode($response, false);
            if ($response && $response->success) {
                if ($action && $response->action != $action) {
                    return $this->fail('Action mistmatch!');
                }
                if ($hostname && $response->hostname != $hostname) {
                    return $this->fail('Hostname mistmatch!');
                }
                if ($response->score < 0.5) {
                    return $this->fail(sprintf('Low score: %f', $response->score));
                }
                return true;
            }
        }
        return $this->fail('Invalid recaptcha token!');
    }

    protected function fail($error)
    {
        if ($this->verbose) {
            throw new \Exception($error);
        }
        return false;
    }

    protected function getHttpClient()
    {
        return new Client([
            'base_uri' => 'https://www.google.com/recaptcha/api/',
            'timeout' => 3,
        ]);
    }
}