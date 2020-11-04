<?php

$rootdir = __DIR__;
include $rootdir . '/vendor/autoload.php';

start($rootdir);

$config = PhpBB\Core\Context::getService('config');
$phrases = PhpBB\Core\Context::getService('phrases');
$session = PhpBB\Core\Context::getService('session');
$templates = PhpBB\Core\Context::getService('templates');
$request = PhpBB\Core\Context::getService('request');
// $template->addPath($phpbb_root_path . '/templates/test');
$templates->var('error', $request->e);


$templates->display('auth.html');

if ($_POST) {
    var_dump($_POST);exit;
}
