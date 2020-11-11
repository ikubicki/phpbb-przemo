<?php

use PhpBB\Forum\Url;
use PhpBB\Core\Context;

$request = Context::getService('request');
$template = Context::getService('templates');
$phrases = Context::getService('phrases');
$user_id = $request->u;

$user = (new PhpBB\Model\UsersCollection)->get($user_id);
$tree = null;
$template->vars([
    'user' => $user,
    'title' => $user->username,
]);
$template->display('main/viewuser.html');