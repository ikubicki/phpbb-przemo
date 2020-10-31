<?php

use PhpBB\Forum\Url;

define('IN_PHPBB', true);
$phpbb_root_path = './';
$phpEx = 'php';
include($phpbb_root_path . 'common.'.$phpEx);

$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

$request = PhpBB\Core\Context::getService('request');
$category_id = $request->get->get('c');
$forum_id = $request->get->get('f');
$topic_id = $request->get->get('t');
$user_id = $request->get->get('u');

if ($topic_id) {
    $what = 'viewtopic';
}
else if ($forum_id) {
    $what = 'viewforum';
}
else if ($user_id) {
    $what = 'viewuser';
}
else {
    $what = 'viewcategory';
}

$template = PhpBB\Core\Context::getService('templates');

switch($what) {
    case 'viewcategory':
        $category = (new PhpBB\Model\CategoriesCollection)->get($category_id);
        if ($category) {
            $tree = $category;
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
$phrases = PhpBB\Core\Context::getService('phrases');
$phrases->load($lang);
$session = PhpBB\Core\Context::getService('session');
$template->addPath($phpbb_root_path . '/templates/test');
$template->var('c', $board_config);
$template->var('l', $phrases);
$template->var('s', $session);
$template->defaults([
    'SITE_NAME' => $board_config['sitename'],
    'SITE_DESCRIPTION' => $board_config['site_desc'],
]);

$config = PhpBB\Core\Context::getService('config');
$config->unset('x_5b72910d3c47fd1b5055a047f52d764a');

$template->vars([
    'title' => $what . '.html',
    'what' => $what,
    'forums' => $tree ? $tree->flat(true, $nesting) : null,
    'topics' => isset($forum) ? $forum->getTopics(1, 30) : null,
    'posts' => isset($topic) ? $topic->getPosts(1, 10) : null,
    'forum' => $forum ?? null,
    'category' => $category ?? null,
    'topic' => $topic ?? null,
]);

$template->component('FORUMS', 'components/forums.html');
$template->component('TOPICS', 'components/topics.html');
$template->component('POSTS', 'components/posts.html');
$template->component('QUICKREPLY', 'components/quickreply.html');

$navigation = [];

if (isset($forum)) {
    $navigation = PhpBB\Core\Context::getService('tree')->trace($forum);
}
$template->vars([
    'U_HOME' => new Url('index.php', $lang['Forum_index']),
    'A_ITEMS' => $navigation,
]);

$template->component('BREADCRUMBS', 'components/breadcrumbs.html');

if ($what == 'viewcategory') {
    //include $phpbb_root_path . '/modules/Shouts/autoload.php';
    (new PhpBB\Modules\Shouts\Module)->start();
}

$template->display($what . '.html');

// var_dump(memory_get_peak_usage());
// var_dump(memory_get_peak_usage(1));