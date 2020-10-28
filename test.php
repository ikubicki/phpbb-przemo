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
$what = $request->get->get('what', 'viewcategory');

switch($what) {
    case 'viewcategory':
        $tree = PhpBB\Core\Context::getService('tree');
        $nesting = 0;
        break;
    case 'viewforum':
        $forum_id = 2;
        $forum = (new PhpBB\Model\ForumsCollection)->get($forum_id);
        $nesting = - $forum->getNesting() - 1;
        $tree = $forum;
        break;
    case 'viewtopic':
        $topic_id = 9;
        $topic = (new PhpBB\Model\TopicsCollection)->get($topic_id);
        $forum = $topic->getForum();
        $nesting = - $forum->getNesting() - 1;
        $tree = $forum;
        break;
}
$template = PhpBB\Core\Context::getService('templates');
$template->addPath($phpbb_root_path . '/templates/test');
$template->var('c', $board_config);
$template->var('l', $lang);

$template->vars([
    'title' => $what . '.html',
    'what' => $what,
    'forums' => $tree->flat(true, $nesting),
    'topics' => isset($forum) ? $forum->getTopics(1, 30) : null,
    'posts' => isset($topic) ? $topic->getPosts(1, 10) : null,
    'forum' => $forum ?? null,
    'topic' => $topic ?? null,
]);

$template->component('FORUMS', 'components/forums.html');
$template->component('TOPICS', 'components/topics.html');
$template->component('POSTS', 'components/posts.html');

$navigation = [];

if (isset($forum)) {
    $navigation = PhpBB\Core\Context::getService('tree')->trace($forum);
}
$template->vars([
    'U_HOME' => new Url('test.php', $lang['Forum_index']),
    'A_ITEMS' => $navigation,
]);
$template->component('BREADCRUMBS', 'components/breadcrumbs.html');

include $phpbb_root_path . '/modules/shouts/shouts.php';

$template->display($what . '.html');