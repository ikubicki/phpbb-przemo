<?php

$rootdir = __DIR__;
include $rootdir . '/vendor/autoload.php';

start($rootdir);

$config = PhpBB\Core\Context::getService('config');
$session = PhpBB\Core\Context::getService('session');
$templates = PhpBB\Core\Context::getService('templates');
$request = PhpBB\Core\Context::getService('request');
// $template->addPath($phpbb_root_path . '/templates/test');

if ($request->has('logout')) {
    $username = $session->getUser()->username;
    $session->terminate();
    $templates->var('username', $username);
    $templates->display('auth-logout.html');
    exit;
}
if ($request->isPost()) {
    if (recaptcha_check()) {
        $authenticator = get_authenticator($request->post->auth);
        if ($authenticator) {
            $response = $authenticator->verify();
            if ($authenticator->getError()) {
                $templates->var('error', $authenticator->getError());
            }
            else if ($response) {
                $response->getUser()->authenticate($request->post->remember > 0);
            }
        }
    }
    else {
        $templates->var('error', 'Recaptcha error');
    }
}
if ($session->isAuthenticated()) {
    redirect('index.php');
}
$templates->display('auth.html');
