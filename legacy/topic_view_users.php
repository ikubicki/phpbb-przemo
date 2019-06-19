<?php
/***************************************************************************
 *                      topic_view_topic.php
 *                      -------------------
 *   begin              : Friday, May 11, 2001
 *   copyright          : (C) 2001 The phpBB Group
 *   email              : support@phpbb.com
 *   modification       : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   date modification  : ver. 1.12.1 2005/11/08 11:34
 *
 *   $Id: memberlist.php,v 1.8.9 2004/05/12 14:20
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
$userdata = session_pagestart($user_ip, PAGE_TOPIC_VIEW);
init_userprefs($userdata);
// End session management

$user_topics_per_page = ($userdata['user_topics_per_page'] > $board_config['topics_per_page']) ? $board_config['topics_per_page'] : $userdata['user_topics_per_page'];

if ( isset($HTTP_GET_VARS[POST_TOPIC_URL]) )
{
	$topic_id = intval($HTTP_GET_VARS[POST_TOPIC_URL]);
}
else if ( isset($HTTP_POST_VARS[POST_TOPIC_URL]) )
{
	$topic_id = intval($HTTP_POST_VARS[POST_TOPIC_URL]);
}
else
{
	$topic_id = 0;
}

if ( ($board_config['who_viewed_admin'] && ($userdata['user_level'] != ADMIN && $userdata['user_level'] != MOD)) || !$userdata['session_logged_in'] || !$board_config['who_viewed'])
{
	message_die(GENERAL_ERROR, 'Not authorised');
}

// find the forum, in witch the topic are located
$sql = "SELECT f.forum_id
FROM (" . TOPICS_TABLE . " t, " . FORUMS_TABLE . " f)
WHERE f.forum_id = t.forum_id
	AND t.topic_id = $topic_id";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain topic information', '', __LINE__, __FILE__, $sql);
}

if ( !($forum_topic_data = $db->sql_fetchrow($result)) )
{
	message_die(GENERAL_MESSAGE, 'No_such_post');
}
$forum_id = $forum_topic_data['forum_id'];

$start = get_vars('start', 0, 'GET,POST', true);
$sort_order = get_vars('order', '', 'POST,GET');
$sort_order = ($sort_order == 'ASC') ? 'ASC' : 'DESC';
$mode = xhtmlspecialchars(get_vars('mode', '', 'POST,GET'));

// Memberlist sorting
$mode_types_text = array($lang['Sort_Joined'], $lang['Sort_Username'], $lang['Topic_count'], $lang['Topic_time'], $lang['Email'], $lang['Website'], $lang['Sort_Top_Ten']);
$mode_types = array('joindate', 'username', 'topic_count', 'topic_time', 'email', 'website', 'topten');

$select_sort_mode = '<select name="mode">';
for($i = ($userdata['user_level'] == ADMIN ) ? 0:1; $i < count($mode_types_text); $i++)
{
	$selected = ( $mode == $mode_types[$i] ) ? ' selected="selected"' : '';
	$select_sort_mode .= '<option value="' . $mode_types[$i] . '"' . $selected . '>' . $mode_types_text[$i] . '</option>';
}
$select_sort_mode .= '</select>';

$select_sort_order = '<select name="order">';
if($sort_order == 'ASC')
{
	$select_sort_order .= '<option value="ASC" selected="selected">' . $lang['Sort_Ascending'] . '</option><option value="DESC">' . $lang['Sort_Descending'] . '</option>';
}
else
{
	$select_sort_order .= '<option value="ASC">' . $lang['Sort_Ascending'] . '</option><option value="DESC" selected="selected">' . $lang['Sort_Descending'] . '</option>';
}
$select_sort_order .= '</select>';
$select_sort_order .= '<input type="hidden" name="'.POST_TOPIC_URL.'" value="'.$topic_id.'"/>';

// Generate page
$page_title = $lang['Memberlist'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'body' => 'memberlist_body.tpl')
);

make_jumpbox('viewforum.'.$phpEx);

$colspan = 4;

if ( $board_config['cgg'] )
{
	$template->assign_block_vars('aim', array());
	$colspan++;
}

$template->assign_vars(array(
	'L_SELECT_SORT_METHOD' => $lang['Select_sort_method'],
	'L_EMAIL' => $lang['Email'],
	'L_WEBSITE' => $lang['Website'],
	'L_FROM' => $lang['Topic_count'],
	'L_SORT' => $lang['Sort'],
	'L_SUBMIT' => $lang['Sort'],
	'L_AIM' => $lang['AIM'],
	'L_YIM' => $lang['YIM'],
	'L_MSNM' => $lang['MSNM'],
	'L_ICQ' => $lang['ICQ'],
	'L_LOGON' => $lang['Last_logon'], 
	'L_JOINED' => $lang['Joined'], 
	'L_POSTS' => $lang['Topic_time'], 

	'COLSPAN' => $colspan,
	'S_MODE_SELECT' => $select_sort_mode,
	'S_ORDER_SELECT' => $select_sort_order,
	'S_MODE_ACTION' => append_sid("topic_view_users.$phpEx"))
);

if ( !empty($mode) )
{
	switch( $mode )
	{
		case 'joindate':
			$order_by = "u.user_regdate $sort_order LIMIT $start, $user_topics_per_page";
			break;
		case 'username':
			$order_by = "u.username $sort_order LIMIT $start, $user_topics_per_page";
			break;
		case 'topic_count':
			$order_by = "tv.view_count $sort_order LIMIT $start, $user_topics_per_page";
			break;
		case 'topic_time':
			$order_by = "tv.view_time $sort_order LIMIT $start, $user_topics_per_page";
			break;
		case 'email':
			$order_by = "u.user_email $sort_order LIMIT $start, $user_topics_per_page";
			break;
		case 'website':
			$order_by = "u.user_website $sort_order LIMIT $start, $user_topics_per_page";
			break;
		case 'topten':
			$order_by = "u.user_posts $sort_order LIMIT 10";
			break;
		default:
			$order_by = "u.user_regdate $sort_order LIMIT $start, $user_topics_per_page";
			break;
	}
}
else
{
	$order_by = "u.user_regdate $sort_order LIMIT $start, $user_topics_per_page";
}

$db->sql_freeresult($result);
$sql = "SELECT u.username, u.user_id, u.user_level, u.user_jr, u.user_viewemail, u.user_posts, u.user_regdate, u.user_allow_viewonline, u.user_from, u.user_website, u.user_email, u.user_icq, u.user_aim, u.user_viewaim, u.user_yim, u.user_msnm, u.user_avatar, u.user_avatar_type, u.user_allowavatar ,tv.view_time, tv.view_count
	FROM (" . USERS_TABLE . " u, " . TOPIC_VIEW_TABLE . " tv)
	WHERE u.user_id = tv.user_id AND tv.topic_id = $topic_id
	ORDER BY $order_by";
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query users', '', __LINE__, __FILE__, $sql);
}

if ( $row = $db->sql_fetchrow($result) )
{
	$i = 0;
	do
	{
		$username = ($row['user_id'] == ANONYMOUS) ? $lang['Guest'] :$row['username'];
		$user_id = $row['user_id'];

		$colored_username = color_username($row['user_level'], $row['user_jr'], $row['user_id'], $row['username']);

		$from = (!empty($row['user_from'])) ? $row['user_from'] : '&nbsp;';
		$joined = create_date($lang['DATE_FORMAT'], $row['user_regdate'], $board_config['board_timezone']);
		$topic_time = ($row['view_time']) ? create_date($board_config['default_dateformat'], $row['view_time'], $board_config['board_timezone']) : $lang['Never_last_logon'];
		$view_count = ($row['view_count']) ? $row['view_count'] : '';

		$poster_avatar = '';
		if ( $row['user_avatar_type'] && $user_id != ANONYMOUS && $row['user_allowavatar'] )
		{
			switch( $row['user_avatar_type'] )
			{
				case USER_AVATAR_UPLOAD:
					$poster_avatar = ($board_config['allow_avatar_upload']) ? '<img src="' . $board_config['avatar_path'] . '/' . $row['user_avatar'] . '" alt="" border="0" />' : '';
					break;
				case USER_AVATAR_REMOTE:
					$poster_avatar = ($board_config['allow_avatar_remote']) ? '<img src="' . $row['user_avatar'] . '" alt="" border="0" />' : '';
					break;
				case USER_AVATAR_GALLERY:
					$poster_avatar = ($board_config['allow_avatar_local']) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $row['user_avatar'] . '" alt="" border="0" />' : '';
					break;
			}
		}

		if ( !empty($row['user_viewemail']) || $userdata['user_level'] == ADMIN )
		{
			$email_uri = ($board_config['board_email_form']) ? append_sid("profile.$phpEx?mode=email&amp;" . POST_USERS_URL .'=' . $user_id) : 'mailto:' . $row['user_email'];

			$email_img = '<a href="' . $email_uri . '"><img src="' . $images['icon_email'] . '" alt="' . $lang['Send_email'] . '" title="' . $lang['Send_email'] . '" border="0" /></a>';
			$email = '<a href="' . $email_uri . '">' . $lang['Send_email'] . '</a>';
		}
		else
		{
			$email_img = '&nbsp;';
			$email = '&nbsp;';
		}

		$temp_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$user_id");
		$profile_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_profile'] . '" alt="' . $lang['Read_profile'] . '" title="' . $lang['Read_profile'] . '" border="0" /></a>';
		$profile = '<a href="' . $temp_url . '">' . $lang['Read_profile'] . '</a>';

		$temp_url = append_sid("privmsg.$phpEx?mode=post&amp;" . POST_USERS_URL . "=$user_id");
		$pm_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_pm'] . '" alt="' . $lang['Send_private_message'] . '" title="' . $lang['Send_private_message'] . '" border="0" /></a>';
		$pm = '<a href="' . $temp_url . '">' . $lang['Send_private_message'] . '</a>';

		$www_img = ( $row['user_website'] ) ? '<a href="' . $row['user_website'] . '" target="_userwww" rel="nofollow"><img src="' . $images['icon_www'] . '" alt="' . $lang['Visit_website'] . '" title="' . $lang['Visit_website'] . '" border="0" /></a>' : '';
		$www = ( $row['user_website'] ) ? '<a href="' . $row['user_website'] . '" target="_userwww" rel="nofollow">' . $lang['Visit_website'] . '</a>' : '';

		if ( !empty($row['user_icq']) )
		{
			$icq_status_img = '<a href="http://wwp.icq.com/' . $row['user_icq'] . '#pager"><img src="http://web.icq.com/whitepages/online?icq=' . $row['user_icq'] . '&amp;img=5" width="18" height="18" border="0" /></a>';
			$icq_img = '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $row['user_icq'] . '"><img src="' . $images['icon_icq'] . '" alt="' . $lang['ICQ'] . '" title="' . $lang['ICQ'] . '" border="0" /></a>';
			$icq = '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $row['user_icq'] . '">' . $lang['ICQ'] . '</a>';
		}
		else
		{
			$icq_status_img = '';
			$icq_img = '';
			$icq = '';
		}

		if ( !empty($row['user_aim']) )
 		{
			$gg_url = append_sid("gg.$phpEx?mode=gadu&amp;" . POST_USERS_URL . '=' . $user_id);
			if ( $row['user_viewaim'] )
			{
				$aim_status_img = '<a href="' . $gg_url . '"><img title="GG: ' . $row['user_aim'] . '" alt="' . $row['user_aim'] . '" src="http://status.gadu-gadu.pl/users/status.asp?id=' . $row['user_aim'] . '&amp;styl=1" width="16" height="16" border="0" /></a>';
				$aim_img = '<a href="' . $gg_url . '"><img src="' . $images['icon_aim'] . '" alt="' . $lang['AIM'] . '" title="' . $lang['AIM'] . '" border="0" /></a>';
			}
			else
			{
				$aim_status_img = '';
				$aim_img = '<a href="' . $gg_url . '"><img src="' . $images['icon_aim'] . '" alt="" border="0" /></a>';
			}
		}
		else
		{
			$aim_status_img = '';
			$aim_img = '';
		}

		$temp_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$user_id");
		$msn_img = ($row['user_msnm']) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_msnm'] . '" alt="' . $lang['MSNM'] . '" title="' . $lang['MSNM'] . '" border="0" /></a>' : '';
		$msn = ($row['user_msnm']) ? '<a href="' . $temp_url . '">' . $lang['MSNM'] . '</a>' : '';

		$yim_img = ($row['user_yim']) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $row['user_yim'] . '&amp;.src=pg"><img src="' . $images['icon_yim'] . '" alt="' . $lang['YIM'] . '" title="' . $lang['YIM'] . '" border="0" /></a>' : '';
		$yim = ($row['user_yim']) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $row['user_yim'] . '&amp;.src=pg">' . $lang['YIM'] . '</a>' : '';

		$temp_url = append_sid("search.$phpEx?search_author=" . urlencode($username) . "&amp;showresults=posts");
		$search_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_search'] . '" alt="' . sprintf($lang['Search_user_posts'], $username) . '" title="' . sprintf($lang['Search_user_posts'], $username) . '" border="0" /></a>';
		$search = '<a href="' . $temp_url . '">' . sprintf($lang['Search_user_posts'], $username) . '</a>';

		$template->assign_block_vars('memberrow', array(
			'ROW_NUMBER' => $i + ( intval($HTTP_GET_VARS['start']) + 1 ),
			'ROW_COLOR' => '#' . (!($i % 2)) ? $theme['td_color1'] : $theme['td_color2'],
			'ROW_CLASS' => (!($i % 2)) ? $theme['td_class1'] : $theme['td_class2'],
			'USERNAME' => $colored_username[0],
			'USERNAME_COLOR' => $colored_username[1],
			'FROM' => $view_count,
			'JOINED' => $joined,
			'POSTS' => $topic_time,
			'AVATAR_IMG' => $poster_avatar,
			'PROFILE_IMG' => $profile_img, 
			'PROFILE' => $profile, 
			'SEARCH_IMG' => $search_img,
			'SEARCH' => $search,
			'PM_IMG' => $pm_img,
			'PM' => $pm,
			'EMAIL_IMG' => $email_img,
			'EMAIL' => $email,
			'WWW_IMG' => $www_img,
			'WWW' => $www,
			'ICQ_STATUS_IMG' => $icq_status_img,
			'ICQ_IMG' => $icq_img, 
			'ICQ' => $icq, 
			'AIM_IMG' => $aim_img,
			'AIM_STATUS_IMG' => $aim_status_img,
			'MSN_IMG' => $msn_img,
			'MSN' => $msn,
			'YIM_IMG' => $yim_img,
			'YIM' => $yim,
			'U_VIEWPROFILE' => append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$user_id"))
		);

		if ( $board_config['cgg'] )
		{
			$template->assign_block_vars('memberrow.aim_row', array());
		}

		$i++;
	}
	while ( $row = $db->sql_fetchrow($result) );
}

if ( $mode != 'topten' || $user_topics_per_page < 10 )
{
	$sql = "SELECT count(*) AS total
		FROM " . TOPIC_VIEW_TABLE . "
		WHERE topic_id = $topic_id";

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Error getting total users', '', __LINE__, __FILE__, $sql);
	}

	if ( $total = $db->sql_fetchrow($result) )
	{
		$total_members = $total['total'];
		generate_pagination("topic_view_users.$phpEx?".POST_TOPIC_URL."=$topic_id&amp;mode=$mode&amp;order=$sort_order", $total_members, $user_topics_per_page, $start). '&nbsp;';
	}
}

groups_color_explain('staff_explain');

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>