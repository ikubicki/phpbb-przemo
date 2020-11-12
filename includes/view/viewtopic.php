<?php

use PhpBB\Forum\Url;
use PhpBB\Core\Context;

$request = Context::getService('request');
$template = Context::getService('templates');
$phrases = Context::getService('phrases');
$topic_id = $request->t;

$votes = new PhpBB\Modules\Votes\Module;
$votes->start();
$topic = (new PhpBB\Model\TopicsCollection)->get($topic_id);

if (empty($topic)) {
    error404('topic');
}

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

$template->vars([
    'title' => $topic->getTitle(),
    'posts' => isset($topic) ? $topic->getReplies(1, 10) : null,
    'topic' => $topic ?? null,
]);

$template->component('POSTS', 'main/components/posts.html');
if($session->isAuthenticated()) {
    $template->component('QUICKREPLY', 'main/components/quickreply.html');
}
$template->var('A_ITEMS', Context::getService('tree')->trace($forum));
$template->display('main/viewtopic.html');
