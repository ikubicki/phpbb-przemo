<?php

use PhpBB\Core\Context;
use PhpBB\Model\PostsCollection;
use PhpBB\Modules\Votes\Model\PostsVotesCollection;

$rootdir = __DIR__ . '/../..';
include $rootdir . '/vendor/autoload.php';

start($rootdir);

$session = Context::getService('session');
$request = Context::getService('request');

$user_id = $session->getUserId();
$topic_id = intval($request->post->topic);
$post_id = max($request->post->int('up'), $request->post->int('down'));
$vote = $request->post->has('up') ? 1 : ($request->post->has('down') ? -1 : 0);

$collection = new PostsVotesCollection;

if ($user_id > 1 && $post_id && $vote) {

    $post = (new PostsCollection)->get($post_id);
    if ($post && $topic_id == $post->topic_id) {

        $post_id = $post->post_id;
        $topic_id = $post->topic_id;
        $forum_id = $post->forum_id;

        $collection->new($user_id, $post, $vote);
        $topic = $post->getTopic();
        $sum = $collection->sumVotesForTopic($topic_id);
        if ($sum != $topic->topic_votes_sum) {
            $topic->topic_votes_sum = $sum;
            $topic->save();
        }
    }
}

$data = [
    'posts' => $collection->getTopicVotes($user_id, $topic_id),
];

ob_clean();
header('Content-type: application/json');
echo json_encode($data);