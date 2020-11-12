<?php

use PhpBB\Forum\Url;

$rootdir = __DIR__;
include $rootdir . '/vendor/autoload.php';

start($rootdir);
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

$session = PhpBB\Core\Context::getService('session');
$request = PhpBB\Core\Context::getService('request');

$category_id = $request->get->get('c');
$forum_id = $request->get->get('f');
$topic_id = $request->get->get('t');
$user_id = $request->get->get('u');

if ($topic_id) {
    require __DIR__ . '/includes/browse/viewtopic.php';
}
else if ($forum_id) {
    require __DIR__ . '/includes/browse/viewforum.php';
}
else if ($user_id) {
    require __DIR__ . '/includes/browse/viewuser.php';
}
else {
    require __DIR__ . '/includes/browse/viewcategory.php';
}
var_dump(getenv('DEBUG'));
if (getenv('DEBUG')) {
    foreach(PhpBB\Data\MySQL\Connection::$queries as $query) 
        printf('<p>%s</p>', $query);
}
