<?php
/***************************************************************************
 *                topic_spy.php
 *                -------------------
 *   begin        : Monday, October 20, 2005
 *   copyright    : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   email        : przemo@przemo.org
 *   version      : 1.12.0
 *
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 ***************************************************************************/

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

// Start session management
$userdata = session_pagestart($user_ip, PAGE_VIEWMEMBERS);
init_userprefs($userdata);
// End session management

if ( $userdata['user_level'] != ADMIN && $userdata['user_level'] != MOD )
{
	message_die(GENERAL_MESSAGE, $lang['Not_Authorised']);
}

$user_id = get_vars(POST_USERS_URL, 0, 'GET,POST', true);
$spy_user = ($user_id) ? $user_id : get_vars('username', '', 'POST,GET');
$spy_userdata = get_userdata($spy_user);

$user_id = $spy_userdata['user_id'];

if ( !$user_id )
{
	message_die(GENERAL_MESSAGE, $lang['No_user_id_specified']);
}

if ( $spy_userdata['user_level'] == ADMIN && $userdata['user_level'] != ADMIN && !$board_config['mod_spy_admin'] )
{
	message_die(GENEREL_MESSAGE, $lang['Not_Authorised']);
}

$user_topics_per_page = ($userdata['user_topics_per_page'] > $board_config['topics_per_page']) ? $board_config['topics_per_page'] : $userdata['user_topics_per_page'];

$start = get_vars('start', 0, 'GET,POST', true);

// Generate page
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'body' => 'topic_spy_body.tpl')
);

$keys = array();
$keys = get_auth_keys('Root', true, -1, -1, 'auth_read');
$s_flist = '';
for ($i = 0; $i < count($keys['id']); $i++)
{
	if ( ($tree['type'][ $keys['idx'][$i] ] == POST_FORUM_URL) && $tree['auth'][ $keys['id'][$i] ]['auth_read'] )
	{
		$s_flist .= (($s_flist != '') ? ', ' : '') . $tree['id'][ $keys['idx'][$i] ];
	}
}
if ( $s_flist == '' )
{
	$s_flist = '0';
}

$no_password_forum = ($userdata['user_level'] != ADMIN) ? "AND f.password = ''" : '';

$sql = "SELECT t.topic_id, t.topic_title, t.topic_poster, t.topic_color, f.forum_name, f.forum_color, f.forum_moderate, f.forum_id, v.view_count, v.view_time, u.username, u.user_id
	FROM (" . TOPICS_TABLE . " t, " . TOPIC_VIEW_TABLE . " v, " . FORUMS_TABLE . " f, " . USERS_TABLE . " u)
	WHERE v.user_id = $user_id
		AND v.topic_id = t.topic_id
		AND t.forum_id = f.forum_id
		AND t.topic_poster = u.user_id
		AND f.forum_id IN ($s_flist)
		$no_password_forum
	GROUP by v.topic_id
	ORDER BY v.view_time DESC
	LIMIT $start, $user_topics_per_page";
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query topics', '', __LINE__, __FILE__, $sql);
}

if ( $row = $db->sql_fetchrow($result) )
{
	$i = 0;
	do
	{
		if ($row['forum_moderate'] == 1 && ($userdata['user_level'] != ADMIN)) 
		{ 
			$row['topic_title'] = '<i>'. $lang['Post_no_approved'] .'</i>'; 
		}
		$template->assign_block_vars('spy_row', array(
			'ROW_CLASS' => ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'],
			'TOPIC_TITLE' => ($row['topic_color']) ? '<span style="color: ' . $row['topic_color'] . '">' . $row['topic_title'] . '</span>' : $row['topic_title'],
			'FORUM_NAME' => ($row['forum_color']) ? '<span style="color: ' . $row['forum_color'] . '">' . $row['forum_name'] . '</span>' : $row['forum_name'],
			'U_VIEW_FORUM' => append_sid("viewforum.$phpEx?" . POST_FORUM_URL . '=' . $row['forum_id']),
			'U_VIEW_TOPIC' => append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . '=' . $row['topic_id']),
			'USER_ID' => $row['user_id'],
			'VIEW_COUNT' => $row['view_count'],
			'LAST_VIEW' => create_date($board_config['default_dateformat'], $row['view_time'], $board_config['board_timezone']),
			'TOPIC_AUTHOR' => ($row['user_id'] != ANONYMOUS) ? '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '=' . $row['user_id']) . '" class="mainmenu">' . $row['username'] . '</a>' : '',
			)
		);

		$i++;
	}
	while ( $row = $db->sql_fetchrow($result) );
}

$db->sql_freeresult($result);

$sql = "SELECT COUNT(t.topic_id) as total
	FROM (" . TOPICS_TABLE . " t, " . TOPIC_VIEW_TABLE . " v, " . FORUMS_TABLE . " f)
		WHERE v.user_id = $user_id
			AND v.topic_id = t.topic_id
			AND t.forum_id = f.forum_id
			AND f.forum_id IN ($s_flist)
			$no_password_forum";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Error getting total users', '', __LINE__, __FILE__, $sql);
}

if ( $total = $db->sql_fetchrow($result) )
{
	$total_topics = $total['total'];
	$pagination = generate_pagination("topic_spy.$phpEx?u=$user_id", $total_topics, $user_topics_per_page, $start). '&nbsp;';
}

$template->assign_vars(array(
	'S_MODE_ACTION' =>append_sid("topic_spy.$phpEx"),
	'SEARCHED_USERNAME' => $spy_userdata['username'],

	'L_SEARCH_MATCHES' => sprintf($lang['Found_search_matches'], $total_topics),
	'L_TOPIC_TITLE' => $lang['Sort_Topic_Title'],
	'L_FORUM' => $lang['Forum'],
	'L_TOPIC_COUNT' => $lang['Topic_count'],
	'L_TOPIC_LAST' => $lang['Topic_time'],
	'L_AUTHOR' => $lang['Author'])
);

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>