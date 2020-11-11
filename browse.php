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

foreach(PhpBB\Data\MySQL\Connection::$queries as $query) printf('<p>%s</p>', $query);

/*
$template = PhpBB\Core\Context::getService('templates');

switch($what) {
    case 'viewcategory':
        if ($category_id) {
            $tree = $category = (new PhpBB\Model\CategoriesCollection)->get($category_id);
            $nesting = - $category->getNesting() - 1;
        }
        else {
            $tree = PhpBB\Core\Context::getService('tree');
            $nesting = 0;
        }
        break;
    case 'viewforum':
        $forum = (new PhpBB\Model\ForumsCollection)->get($forum_id);
        $nesting = - $forum->getNesting() - 1;
        $tree = $forum;
        break;
    case 'viewtopic':
        $votes = new PhpBB\Modules\Votes\Module;
        $votes->start();
        $topic = (new PhpBB\Model\TopicsCollection)->get($topic_id);
        $images = $topic->getFirstPost()->getImages();
        if (!empty($images[0])) {
            $template->vars([
                'head_classes' => ['topic'],
                'head_style' => sprintf('background-image:url(%s)', $images[0]),
                'SITE_NAME' => $topic->getTitle(),
                'SITE_DESCRIPTION' => $topic->getDescription(),
            ]);
        }
        $forum = $topic->getForum();
        $nesting = - $forum->getNesting() - 1;
        $tree = $forum;
        break;
    case 'viewuser':
        $user = (new PhpBB\Model\UsersCollection)->get($user_id);
        $tree = null;
        $template->vars([
            'user' => $user,
        ]);
        break;
}

$template->vars([
    'title' => $what . '.html',
    'what' => $what,
    'forums' => $tree ? $tree->flat(true, $nesting) : null,
    'topics' => isset($forum) ? $forum->getTopics(1, 30) : null,
    'posts' => isset($topic) ? $topic->getReplies(1, 10) : null,
    'forum' => $forum ?? null,
    'category' => $category ?? null,
    'topic' => $topic ?? null,
]);

$template->component('FORUMS', 'main/components/forums.html');
$template->component('TOPICS', 'main/components/topics.html');
$template->component('POSTS', 'main/components/posts.html');

if ($session->isAuthenticated()) {
    $template->component('QUICKREPLY', 'main/components/quickreply.html');
}

$navigation = [];

if (isset($forum)) {
    $navigation = PhpBB\Core\Context::getService('tree')->trace($forum);
}
$phrases = PhpBB\Core\Context::getService('phrases');
$template->vars([
    'U_HOME' => new Url('index.php', $phrases->Forum_index),
    'A_ITEMS' => $navigation,
]);

if ($what == 'viewcategory') {
    //include $phpbb_root_path . '/modules/Shouts/autoload.php';
    (new PhpBB\Modules\Shouts\Module)->start();
}

$template->display('main/' . $what . '.html');


foreach(PhpBB\Data\MySQL\Connection::$queries as $query) printf('<p>%s</p>', $query);

// var_dump(memory_get_peak_usage());
// var_dump(memory_get_peak_usage(1));
*/