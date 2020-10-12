<?php

define('IN_PHPBB', true);
define('SHOUTBOX', true);
$phpbb_root_path = '../../';
$shoutbox_config = [];
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);

$topic_id = intval($_POST['topic']);

$r = $db->sql_query("
    SELECT post_id, SUM(vote) votes_sum, COUNT(1) votes_count, SUM(IF(user_id = 2, vote, null)) my_vote
    FROM phpbb_post_votes
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