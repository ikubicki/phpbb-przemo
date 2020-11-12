<?php

$session = PhpBB\Core\Context::getService('session');
$templates = PhpBB\Core\Context::getService('templates');
$request = PhpBB\Core\Context::getService('request');

if ($session->isAuthenticated()) {
    redirect('index.php');
}
if ($request->isPost()) {
    if (recaptcha_check()) {
        $authenticator = get_authenticator($request->post->auth);
        if ($authenticator) {
            $response = $authenticator->authenticate();
            if ($authenticator->getError()) {
                $templates->var('error', $authenticator->getError());
            }
            else if ($response) {
                $response->getUser()->authenticate($request->post->remember > 0);
                redirect('index.php');
            }
        }
    }
    else {
        $templates->var('error', 'Recaptcha error');
    }
}
$templates->display('main/signin.html');
