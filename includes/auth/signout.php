<?php

$session = PhpBB\Core\Context::getService('session');
$templates = PhpBB\Core\Context::getService('templates');
$request = PhpBB\Core\Context::getService('request');

if (!$session->isAuthenticated()) {
    redirect('index.php');
}
$username = $session->getUser()->username;
$session->terminate();
$templates->var('username', $username);
$templates->display('main/signout.html');