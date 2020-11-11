<?php

use PhpBB\Core\Context;

$rootdir = __DIR__;
include $rootdir . '/vendor/autoload.php';

start($rootdir);

$config = Context::getService('config');
$session = Context::getService('session');
$templates = Context::getService('templates');
$request = Context::getService('request');

if ($session->isAuthenticated()) {
    redirect('index.php');
}

// verification
foreach (Context::getModules('Auth') as $authenticator) {
    if (!$authenticator->check()) {
        if($authenticator->getError()) {
            $error = $authenticator->getError();
            break;
        }
    }
}
if ($error) {
    $templates->var('error', $error);
}



$templates->display('signup.html');
