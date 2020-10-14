<?php

define('IN_PHPBB', true);
define('SHOUTBOX', true);
$phpbb_root_path = '../../';
$shoutbox_config = [];
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);

$user_id = intval($userdata['user_id']);
$topic_id = intval($_POST['topic']);
$post_id = max(intval($_POST['up']), intval($_POST['down']));
$vote = $_POST['up'] ? 1 : ($_POST['down'] ? -1 : 0);

if ($post_id && $vote) {

    $resutset = $db->sql_query("
        SELECT post_id, topic_id, forum_id
        FROM phpbb_posts
        WHERE post_id = $post_id
    ");

    $row = $db->sql_fetchrow($resutset);
    if ($row && $topic_id == $row['topic_id']) {

        $post_id = intval($row['post_id']);
        $topic_id = intval($row['topic_id']);
        $forum_id = intval($row['forum_id']);

        $db->sql_query("
            INSERT INTO phpbb_posts_votes
            (forum_id, topic_id, post_id, user_id, vote, timestamp)
            VALUES
            ($forum_id, $topic_id, $post_id, $user_id, $vote, unix_timestamp())
            ON DUPLICATE KEY UPDATE
            vote = $vote,
            timestamp = values(timestamp);
        ");
        $db->sql_query("
            UPDATE phpbb_topics
            SET topic_votes_sum = (
                SELECT SUM(vote) FROM phpbb_posts_votes WHERE topic_id = $topic_id
            )
            WHERE topic_id = $topic_id
        ");
    }
}

$r = $db->sql_query("
    SELECT post_id, SUM(vote) votes_sum, COUNT(1) votes_count, SUM(IF(user_id = $user_id, vote, null)) my_vote
    FROM phpbb_posts_votes
    WHERE topic_id = $topic_id
    GROUP BY post_id
");

$data = [
    'posts' => [],
];
do {
    $row = $db->sql_fetchrow($r);
    if (!$row) {
        break;
    }
    $data['posts'][$row['post_id']] = [
        'id' => $row['post_id'],
        'sum' => $row['votes_sum'],
        'count' => $row['votes_count'],
        'voted' => $row['my_vote'],
    ];
}
while(true);

header('Content-type: application/json');
echo json_encode($data);