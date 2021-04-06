<?php

use PhpBB\Core\Context;

$config = Context::getService('config');
$session = Context::getService('session');
$templates = Context::getService('templates');
$request = Context::getService('request');

if ($session->isAuthenticated()) {
    redirect('index.php');
}

// verification
$authenticators = Context::getModules('Auth');
foreach ($authenticators as $authenticator) {
    if (!$authenticator->check()) {
        if($authenticator->getError()) {
            $error = $authenticator->getError();
            break;
        }
    }
}
if (!empty($error)) {
    $templates->var('error', $error);
}
else {
    foreach ($authenticators as $authenticator) {
        $authenticator->create();
    }
}
$templates->display('main/signup.html');
