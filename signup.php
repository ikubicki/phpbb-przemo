<?php

$rootdir = __DIR__;
include $rootdir . '/vendor/autoload.php';

start($rootdir);

$config = PhpBB\Core\Context::getService('config');
$session = PhpBB\Core\Context::getService('session');
$templates = PhpBB\Core\Context::getService('templates');
$request = PhpBB\Core\Context::getService('request');

if ($session->isAuthenticated()) {
    redirect('index.php');
}
var_dump($request->post->dump());
$templates->display('signup.html');
