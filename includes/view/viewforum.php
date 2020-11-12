<?php

use PhpBB\Forum\Url;
use PhpBB\Core\Context;

$request = Context::getService('request');
$template = Context::getService('templates');
$phrases = Context::getService('phrases');
$forum_id = $request->f;

$tree = $forum = (new PhpBB\Model\ForumsCollection)->get($forum_id);

if (empty($forum)) {
    error404('forum');
}

$nesting = - $forum->getNesting() - 1;

$template->vars([
    'title' => $forum->getName(),
    'forums' => $tree ? $tree->flat(true, $nesting) : null,
    'topics' => isset($forum) ? $forum->getTopics(1, 30) : null,
    'forum' => $forum ?? null,
]);

$template->component('FORUMS', 'main/components/forums.html');
$template->component('TOPICS', 'main/components/topics.html');
$template->var('A_ITEMS', Context::getService('tree')->trace($forum));
$template->display('main/viewforum.html');
