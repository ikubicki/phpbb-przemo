<?php

$rootdir = __DIR__;
include $rootdir . '/vendor/autoload.php';

start($rootdir);

$request = PhpBB\Core\Context::getService('request');
if ($request->has('signup')) {
    require $rootdir . '/includes/auth/signup.php';
}
else if ($request->has('signout')) {
    require $rootdir . '/includes/auth/signout.php';
}
else {
    require $rootdir . '/includes/auth/signin.php';
}