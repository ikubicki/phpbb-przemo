<?php

$rootdir = __DIR__;
include $rootdir . '/vendor/autoload.php';

start($rootdir);

$config = PhpBB\Core\Context::getService('config');
// $phrases = PhpBB\Core\Context::getService('phrases');
$session = PhpBB\Core\Context::getService('session');
$templates = PhpBB\Core\Context::getService('templates');
$request = PhpBB\Core\Context::getService('request');
// $template->addPath($phpbb_root_path . '/templates/test');

if ($request->isPost()) {
    if (recaptcha_check()) {
        $authenticator = get_authenticator($request->post->auth);
        $response = $authenticator ? $authenticator->verify() : false;
        if ($response) {
            var_dump($response->getUser());
        }
    }
    else {
        $templates->var('error', 'Recaptcha error');
    }
}
$templates->display('auth.html');
