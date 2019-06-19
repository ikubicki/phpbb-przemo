<?php
/***************************************************************************
 *                           usercp_viewprofile.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   modification         : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   date modification    : ver. 1.12.4 2005/09/27 17:48
 *
 *   $Id: usercp_viewprofile.php,v 1.5.2.6 2005/09/14 18:14:30 acydburn Exp $
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
	exit;
}

if ( empty($HTTP_GET_VARS[POST_USERS_URL]) || $HTTP_GET_VARS[POST_USERS_URL] == ANONYMOUS || $HTTP_GET_VARS[POST_USERS_URL] == -2 )
{
	message_die(GENERAL_MESSAGE, $lang['No_user_id_specified']);
}
$profiledata = get_userdata(intval($HTTP_GET_VARS[POST_USERS_URL]));

if (!$profiledata)
{
	message_die(GENERAL_MESSAGE, $lang['No_user_id_specified']);
}

$user_id = $profiledata['user_id'];
$user_posts = $profiledata['user_posts'];
$user_avatar = $profiledata['user_avatar'];
$user_avatar_height = $profiledata['user_avatar_height'];
$user_avatar_width = $profiledata['user_avatar_width'];
$user_avatar = $profiledata['user_avatar'];
$user_rank = $profiledata['user_rank'];
$username = $profiledata['username'];

$viewing_user_id = $userdata['user_id'];
$viewing_user_level = $userdata['user_level'];

include($phpbb_root_path . 'includes/bbcode.'.$phpEx);

$orig_word = array();
$replacement_word = array();
$replacement_word_html = array();
obtain_word_list($orig_word, $replacement_word, $replacement_word_html);

// Output page header and profile_view template
$template->set_filenames(array(
	'body' => 'profile_view_body.tpl')
);

make_jumpbox('viewforum.'.$phpEx);

$regdate = $profiledata['user_regdate'];
$memberdays = max(1, round( ( CR_TIME - $regdate ) / 86400 ));
$posts_per_day = $user_posts / $memberdays;

if ( $user_posts != 0 )
{
	$total_posts = get_db_stat('postcount');
	$percentage = ( $total_posts ) ? min(100, ($user_posts / $total_posts) * 100) : 0;
}
else
{
	$total_posts = 0;
	$percentage = 0;
}

$avatar_img = '';
if ( $profiledata['user_avatar_type'] && $profiledata['user_allowavatar'] )
{
    switch( $profiledata['user_avatar_type'] )
    {
        case USER_AVATAR_UPLOAD:
            $avatar_img = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $user_avatar . '" alt="" border="0" />' : '';
            break;
        case USER_AVATAR_REMOTE:
			if ( $board_config['allow_avatar_remote'] )
			{
				if ( ($user_avatar_height && $user_avatar_height > 0) && ($user_avatar_width && $user_avatar_width > 0) )
				{
					$avatar_img = '<img src="' . $user_avatar . '" height="' . $user_avatar_height . '" width="' . $user_avatar_width . '" alt="" border="0" />';
				}
				else
				{
					$avatar_img = '<img src="' . $user_avatar . '" alt="" border="0" />';
				}
			}
			else $avatar_img = '';
            break;
        case USER_AVATAR_GALLERY:
            $avatar_img = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $user_avatar . '" alt="" border="0" />' : '';
            break;
    }
}

$poster_rank = '';
$rank_image = '';
if ( $user_rank )
{
	$sql = "SELECT *
		FROM " . RANKS_TABLE . "
		WHERE rank_id = " . $user_rank;
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain user speical rank ', '', __LINE__, __FILE__, $sql);
	}
	if ( $row = $db->sql_fetchrow($result) )
	{
		$poster_rank = $row['rank_title'];
		if ( $poster_rank )
		{
			$poster_rank = $poster_rank . '<br />';
		}
		if ( strstr($poster_rank,'-#') )
		{
			$poster_rank = '';
		}
		$rank_image = ( $row['rank_image'] ) ? '<img src="' . $images['rank_path'] . $row['rank_image'] . '" alt="" border="0" /><br />' : '';
	}
	$db->sql_freeresult($result);
}
else
{
	$sql = "SELECT *
	FROM " . RANKS_TABLE . "
		WHERE rank_special = 0
		ORDER BY rank_min DESC";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain ranks information', '', __LINE__, __FILE__, $sql);
	}

	$ranksrow = array();
	while ( $row = $db->sql_fetchrow($result) )
	{
		$ranksrow[$row['rank_group']][] = $row;
		$ranksrow[$row['rank_group']]['count']++;
	}
	$db->sql_freeresult($result);

	$sql = "SELECT ug.group_id
		FROM (" . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g)
		WHERE ug.user_id = " . $user_id . "
			AND g.group_id = ug.group_id
			AND g.group_single_user = 0
			AND ug.user_pending <> 1
		ORDER BY g.group_order ASC";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_MESSAGE, 'Can not find username');
	}
	$rank_group_id = 0;
	while ( $row = $db->sql_fetchrow($result) )
	{
		if ( isset($ranksrow[$row['group_id']]) )
		{
			$rank_group_id = $row['group_id'];
			break;
		}
	}
	$db->sql_freeresult($result);

	for($i = 0; $i < $ranksrow[$rank_group_id]['count']; $i++)
	{
		if ( $user_posts >= $ranksrow[$rank_group_id][$i]['rank_min'] )
		{
			$poster_rank = $ranksrow[$rank_group_id][$i]['rank_title'];
			if ( $poster_rank )
			{
				$poster_rank = $poster_rank . '<br />';
			}
			if ( strstr($poster_rank,'-#') )
			{
				$poster_rank = '';
			}
			$rank_image = ( $ranksrow[$rank_group_id][$i]['rank_image'] ) ? '<img src="' . $images['rank_path'] . $ranksrow[$rank_group_id][$i]['rank_image'] . '" alt="" border="0" /><br />' : '';
			break;
		}
	}
}
$temp_url = append_sid("privmsg.$phpEx?mode=post&amp;" . POST_USERS_URL . "=" . $user_id);
$pm_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_pm'] . '" alt="' . $lang['Send_private_message'] . '" title="' . $lang['Send_private_message'] . '" border="0" /></a>';
$pm = '<a href="' . $temp_url . '">' . $lang['Send_private_message'] . '</a>';

if ( $board_config['login_require'] && !$userdata['session_logged_in'] || ( $board_config['crestrict'] && !$userdata['session_logged_in'] ) )
{
	$message = $lang['login_require'] . '<br /><br />' . sprintf($lang['login_require_register'], '<a href="' . append_sid("profile.$phpEx?mode=register") . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

if ( !empty($profiledata['user_viewemail']) || $viewing_user_level == ADMIN )
{
	$email_uri = ( $board_config['board_email_form'] ) ? append_sid("profile.$phpEx?mode=email&amp;" . POST_USERS_URL .'=' . $user_id) : 'mailto:' . $profiledata['user_email'];

	$email_img = '<a href="' . $email_uri . '"><img src="' . $images['icon_email'] . '" alt="' . $lang['Send_email'] . '" title="' . $lang['Send_email'] . '" border="0" /></a>';
	$email = '<a href="' . $email_uri . '">' . $lang['Send_email'] . '</a>';
}
else
{
	$email_img = '&nbsp;';
	$email = '&nbsp;';
}

$www_img = ( $profiledata['user_website'] ) ? '<a href="' . $profiledata['user_website'] . '" target="_userwww" rel="nofollow"><img src="' . $images['icon_www'] . '" alt="' . $lang['Visit_website'] . '" title="' . $lang['Visit_website'] . '" border="0" /></a>' : '&nbsp;';
$www = ( $profiledata['user_website'] ) ? '<a href="' . $profiledata['user_website'] . '" target="_userwww" rel="nofollow">' . $profiledata['user_website'] . '</a>' : '&nbsp;';

if ( !empty($profiledata['user_icq']) )
{
	$icq_status_img = '<a href="http://wwp.icq.com/' . $profiledata['user_icq'] . '#pager"><img src="http://web.icq.com/whitepages/online?icq=' . $profiledata['user_icq'] . '&amp;img=5" alt="" width="18" height="18" border="0" /></a>';
	$icq_img = '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $profiledata['user_icq'] . '"><img src="' . $images['icon_icq'] . '" alt="' . $lang['ICQ'] . '" title="' . $lang['ICQ'] . '" border="0" /></a>';
	$icq =	'<a href="http://wwp.icq.com/scripts/search.dll?to=' . $profiledata['user_icq'] . '">' . $lang['ICQ'] . '</a>';
}
else
{
	$icq_status_img = '&nbsp;';
	$icq_img = '&nbsp;';
	$icq = '&nbsp;';
}

if ( !empty($profiledata['user_aim']) )
{
	if ( $profiledata['user_viewaim'] )
	{
		$aim_status_img = '<a href="gg:' . $profiledata['user_aim'] . '"><img src="http://status.gadu-gadu.pl/users/status.asp?id=' . $profiledata['user_aim'] . '&amp;styl=1" alt="" border="0" width="16" height="16" /></a>';
		$aim_img = '<a href="' . append_sid("gg.$phpEx?mode=gadu&amp;u=$user_id") . '"><img src="' . $images['icon_aim'] . '" alt="' . $lang['AIM'] . '" title="' . $lang['AIM'] . ': ' . $profiledata['user_aim'] . '" border="0" /></a>';
	}
	else
	{
		$aim_status_img = '';
		$aim_img = '<a href="' . append_sid("gg.$phpEx?mode=gadu&amp;u=$user_id") . '"><img src="' . $images['icon_aim'] . '" alt="" border="0" /></a>';
	}
}
else
{
	$aim_status_img = '';
	$aim_img = '';
	$aim = '';
}
$msn_img = ( $profiledata['user_msnm'] ) ? $profiledata['user_msnm'] : '&nbsp;';
$msn = $msn_img;

$yim_img = ( $profiledata['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $profiledata['user_yim'] . '&amp;.src=pg"><img src="' . $images['icon_yim'] . '" alt="' . $lang['YIM'] . '" title="' . $lang['YIM'] . '" alt="" border="0" /></a>' : '';
$yim = ( $profiledata['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $profiledata['user_yim'] . '&amp;.src=pg">' . $lang['YIM'] . '</a>' : '';

$temp_url = append_sid("search.$phpEx?search_author=" . urlencode($username) . "&amp;showresults=posts");
$search_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_search'] . '" alt="' . sprintf($lang['Search_user_posts'], $profiledata['username']) . '" title="' . sprintf($lang['Search_user_posts'], $profiledata['username']) . '" border="0" /></a>';
$search = '<a href="' . $temp_url . '">' . sprintf($lang['Search_user_posts'], $profiledata['username']) . '</a>';

if ( $board_config['clevelp'] )
{
	if ( $user_posts < 1 )
	{
		$level_level = 0;
	}
	else
	{
		$level_level = floor( pow( log10( $user_posts ), 3 ) ) + 1;
	}

	$level_avg_ppd = 5;
	$level_bonus_redux = 5;

	if ( $level_level < 1 )
	{
		$level_hp = '0 / 0';
		$level_hp_percent = 0;
	}
	else
	{
		$level_max_hp = floor( (pow( $level_level, (1/4) ) ) * (pow( 10, pow( $level_level+2, (1/3) ) ) ) / (1.5) );

		if ( $posts_per_day >= $level_avg_ppd )
		{
			$level_hp_percent = floor( (.5 + (($posts_per_day - $level_avg_ppd) / ($level_bonus_redux * 2)) ) * 100);
		}
		else
		{
			$level_hp_percent = floor( $posts_per_day / ($level_avg_ppd / 50) );
		}
	
		if ( $level_hp_percent > 100 )
		{
			$level_max_hp += floor( ($level_hp_percent - 100) * pi() );
			$level_hp_percent = 100;
		}
		else
		{
			$level_hp_percent = max(0, $level_hp_percent);
		}
	
		$level_cur_hp = floor($level_max_hp * ($level_hp_percent / 100) );
		$level_cur_hp = max(0, $level_cur_hp);
		$level_cur_hp = min($level_max_hp, $level_cur_hp);
		$level_hp = $level_cur_hp . ' / ' . $level_max_hp;
	}

	$level_user_days = max(1, round( ( CR_TIME - $profiledata['user_regdate'] ) / 86400 ));
	$level_post_mp_cost = 2.5;
	$level_mp_regen_per_day = 4;

	if ( $level_level < 1 )
	{
		$level_mp = '0 / 0';
		$level_mp_percent = 0;
	}
	else
	{
		$level_max_mp = floor( (pow( $level_level, (1/4) ) ) * (pow( 10, pow( $level_level+2, (1/3) ) ) ) / (pi()) );
		$level_mp_cost = $user_posts * $level_post_mp_cost;
		$level_mp_regen = max(1, $level_user_days * $level_mp_regen_per_day);
		$level_cur_mp = floor($level_max_mp - $level_mp_cost + $level_mp_regen);
		$level_cur_mp = max(0, $level_cur_mp);
		$level_cur_mp = min($level_max_mp, $level_cur_mp);
		$level_mp = $level_cur_mp . ' / ' . $level_max_mp;
		$level_mp_percent = floor($level_cur_mp / $level_max_mp * 100 );
	}

	if ( $level_level == 0 )
	{
		$level_exp = '0 / 0';
		$level_exp_percent = 100;
	}
	else
	{
		$level_posts_for_next = floor( pow( 10, pow( $level_level, (1/3) ) ) );
		@$level_posts_for_this = max(1, floor( pow( 10, pow( ($level_level - 1), (1/3) ) ) ) );
		$level_exp = ($user_posts - $level_posts_for_this) . ' / ' . ($level_posts_for_next - $level_posts_for_this);
		$level_exp_percent = floor( ( ($user_posts - $level_posts_for_this) / max( 1, ($level_posts_for_next - $level_posts_for_this ) ) ) * 100);
	}
}
/* END HP/MP/EXP MOD */

if ( !empty($profiledata['user_gender']) )
{
	switch ($profiledata['user_gender'])
	{
		case 1:
			$gender = $lang['Male'];
		break;
		case 2:
			$gender = $lang['Female'];
		break;
		default:
			$gender = $lang['No_gender_specify'];
	}
}
else
{
	$gender = $lang['No_gender_specify'];
}

// Generate page
$page_title = $lang['Viewing_profile'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);
if ( defined('ATTACHMENTS_ON') )
{
	display_upload_attach_box_limits($user_id);
}

$poster_custom_rank = '';
if ( $profiledata['user_custom_rank'] )
{
	$poster_custom_rank = ( $profiledata['user_custom_rank'] ) ? $profiledata['user_custom_rank'] : '&nbsp;';
	if ( $poster_custom_rank )
	{
		$poster_custom_rank = $poster_custom_rank . '<br />';
	}
	$poster_rank = '';
}

if ( $board_config['ignore_topics'] && $viewing_user_id == $user_id )
{
	$sql = "SELECT topic_id FROM " . TOPICS_IGNORE_TABLE . "
		WHERE user_id = " . $userdata['user_id'] . "
		LIMIT 1";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain ignore topics', '', __LINE__, __FILE__, $sql);
	}
	if ( $row = $db->sql_fetchrow($result) )
	{
		$template->assign_block_vars('ignore_topics',array());
	}
}

$auth_forums = array();
foreach($tree['auth'] as $key => $val)
{
	if ( $val['auth_read'] && strpos($key, POST_FORUM_URL) !== false)
	{
		$auth_forums[] = str_replace(POST_FORUM_URL, '', $key);
	}
}

$auth_forums = implode(',', $auth_forums);
$auth_forums = ($auth_forums) ? $auth_forums : '0';

if ( $auth_forums && $board_config['overlib'] && $userdata['overlib'])
{
	include($phpbb_root_path . 'includes/functions_add.'.$phpEx);

	$text_field_sql = ', pt.post_text, t.topic_title, t.topic_accept, t.topic_poster';
	$text_where = "AND pt.post_id = p.post_id AND p.topic_id = t.topic_id";
	$text_table = ", " . POSTS_TEXT_TABLE . " pt, " . TOPICS_TABLE . " t";
}
else
{
	$text_field_sql = $text_where = $text_table = '';
}

$last_post_time = '';
$sql = "SELECT p.post_time as max_post_time, p.post_id as max_post_id $text_field_sql
	FROM (" . POSTS_TABLE . " p $text_table)
	WHERE p.poster_id = $user_id
	$text_where
	AND p.forum_id IN($auth_forums)
	AND p.post_approve = 1
	ORDER BY p.post_id DESC
	LIMIT 1"; 
if ( !($result = $db->sql_query($sql)) ) 
{ 
	message_die(GENERAL_ERROR, 'Error getting user last post time', '', __LINE__, __FILE__, $post_time_sql); 
} 
if ( $row = $db->sql_fetchrow($result) )
{
	$template->assign_block_vars('posts',array());
	$last_post_url = append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=" . $row['max_post_id']) . '#' . $row['max_post_id'];
	$last_post_time = create_date($board_config['default_dateformat'], $row['max_post_time'], $board_config['board_timezone']);

	if ( $text_table )
	{
		$first_and_last_post = false;
		$prepared_overlib_text = prepare_overlib_text($row['post_text'], '');

		if (!$board_config['show_badwords'])
		{
			$topic_title = ($count_orig_word) ? preg_replace($orig_word, $replacement_word, $row['topic_title']) : $row['topic_title'];
			$overlib_text = ($count_orig_word) ? preg_replace($orig_word, $replacement_word, $prepared_overlib_text[0]) : $prepared_overlib_text[0];
		}
		else
		{
			$topic_title = $row['topic_title'];
			replace_bad_words($orig_word, $replacement_word, $topic_title);
			$overlib_text = $prepared_overlib_text[0];
			replace_bad_words($orig_word, $replacement_word, $overlib_text);
		}

		$topic_title = ($row['topic_accept'] || $userdata['user_level'] == ADMIN || $row['topic_poster'] == $userdata['user_id']) ? $topic_title : '<i>' . $lang['Post_no_approved'] . '</i>';
		$template->assign_block_vars('posts.title_overlib',array(
			'L_POST_TEXT' => $lang['Sort_Topic_Title'] . ': ' . replace_encoded(str_replace("'", '&amp;#039;', $topic_title)),
			'POST_TEXT' => $overlib_text)
		);
	}

	$sql = "SELECT COUNT(t.topic_id) AS t_total
		FROM (" . TOPICS_TABLE . " t, " . FORUMS_TABLE . " f)
		WHERE t.topic_poster = $user_id
			AND t.forum_id = f.forum_id
			AND f.no_count < 1";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not list user topics', '', __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);
	$total_topics = $row['t_total'];

	$sql = "SELECT COUNT(t.topic_id) AS v_total
		FROM (" . TOPICS_TABLE . " t, " . FORUMS_TABLE . " f)
		WHERE t.topic_poster = $user_id
			AND t.forum_id = f.forum_id
			AND f.no_count < 1
			AND t.topic_vote > 0";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not list user topics', '', __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);
	$total_topics_vote = $row['v_total'];

	if ( defined('ATTACHMENTS_ON') )
	{
		$sql = "SELECT COUNT(p.post_id) AS pa_total
			FROM (" . POSTS_TABLE . " p, " . ATTACHMENTS_TABLE . " a, " . TOPICS_TABLE . " t, " . FORUMS_TABLE . " f)
			WHERE p.poster_id = $user_id
				AND p.post_id = a.post_id
				AND p.topic_id = t.topic_id
				AND t.forum_id = f.forum_id
				AND f.no_count < 1";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not list user topics', '', __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);
		$attach_total = $row['pa_total'];
	}
	else
	{
		$attach_total = 0;
	}
}

if ( $viewing_user_level == ADMIN )
{
	$template->assign_block_vars('admin',array());
	if ( $board_config['warnings_enable'] )
	{
		require($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_warnings.' . $phpEx);
		$template->assign_block_vars('add_warning',array());
	}
}
else if ( $userdata['user_level'] == MOD && $board_config['warnings_enable'] && $board_config['mod_warnings'] )
{
	require($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_warnings.' . $phpEx);
	$template->assign_block_vars('add_warning',array());
}

if ( $board_config['who_viewed'] && ($viewing_user_level == ADMIN || ($userdata['user_level'] == MOD && $board_config['mod_spy']) ) )
{
	$template->assign_block_vars('topic_spy',array());
}

$gender_image = '';
switch ($profiledata['user_gender'])
{
	case 1 :
		$gender_image = '&nbsp;<img src="' . $images['icon_minigender_male'] . '" alt="' . $lang['Gender']. ':' . $lang['Male'] . '" title="' . $lang['Male'] . '" border="0" />';
		break;
	case 2 :
		$gender_image = '&nbsp;<img src="' . $images['icon_minigender_female'] . '" alt="' . $lang['Gender']. ':' . $lang['Female'] . '" title="' . $lang['Female'] . '" border="0" />';
		break;
	default :
		$gender_image = '';
}
if ( !$board_config['gender'] )
{
	$gender_image = '';
}

if ( $profiledata['user_session_start'] )
{
	$last_activity_time = ($profiledata['user_session_time'] - $profiledata['user_session_start']);
	if ( $last_activity_time >= 3600 )
	{
		$last_activity_time = $lang['Hours'] . ': ' . round(($last_activity_time / 60 / 60), 1);
	}
	else
	{
		$last_activity_time = $lang['Minutes'] . ': ' . round(($last_activity_time / 60));
	}

	if ( $profiledata['user_spend_time'] >= 3600 )
	{
		$spend_time = $lang['Hours'] . ': ' . round(($profiledata['user_spend_time'] / 60 / 60), 1);
	}
	else
	{
		$spend_time = $lang['Minutes'] . ': ' . round(($profiledata['user_spend_time'] / 60));
	}
}

if ( $board_config['cllogin'] && ($userdata['user_level'] == ADMIN || $profiledata['user_allow_viewonline']) )
{
	$template->assign_block_vars('last_login', array());

	if ( $userdata['user_level'] == ADMIN )
	{
		$ip_this_user = decode_ip($profiledata['user_ip']);
		$ip_this_user = (isset($HTTP_GET_VARS['host'])) ? @gethostbyaddr($ip_this_user) : $ip_this_user;
		$host_link = ' &nbsp;<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $profiledata['user_id'] . ( (isset($HTTP_GET_VARS['host'])) ? '': '&amp;host=1' ) . "") . '" class="mainmenu">' . ( (isset($HTTP_GET_VARS['host'])) ? 'IP': 'host' ) . '</a>';

		$template->assign_block_vars('last_login.host',array());
	}
}

if (function_exists('get_html_translation_table'))
{
	$u_search_author = urlencode(strtr($username, array_flip(get_html_translation_table(HTML_ENTITIES))));
}
else
{
	$u_search_author = urlencode(str_replace(array('&amp;', '&#039;', '&quot;', '&lt;', '&gt;'), array('&', "'", '"', '<', '>'), $username));
}


if ( $profiledata['user_allowsig'] && $profiledata['user_sig'] != '' && $board_config['allow_sig'] )
{
	$user_sig_bbcode_uid = $profiledata['user_sig_bbcode_uid'];
	$user_sig_image = ($profiledata['user_sig_image'] != '' && $board_config['allow_sig_image']) ? $profiledata['user_sig_image'] : '';
	$user_sig = $profiledata['user_sig'];

	$show_sig_html = ( ($profiledata['user_level'] == MOD && $board_config['mod_html']) || ($board_config['admin_html'] && $profiledata['user_level'] == ADMIN) || ($board_config['jr_admin_html'] && $profiledata['user_jr']) ) ? true : false;

	if ( !$show_sig_html )
	{
		$user_sig = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $user_sig);
	}

	$user_sig = str_replace(array("\n", "\r"), array("<br />", ''), $user_sig);
	if ( $user_sig_image != '' )
	{
		$user_sig_image = (($user_sig != '') ? '<br />' : '<br />') . '<img src="' . $board_config['sig_images_path'] . '/' . $user_sig_image . '" border="0" alt="" />';
	}
	if ( $user_sig_bbcode_uid != '' )
	{
		$user_sig = ($board_config['allow_bbcode']) ? bbencode_second_pass($user_sig, $user_sig_bbcode_uid, $userdata['username']) : preg_replace("/\:$user_sig_bbcode_uid/si", '', $user_sig);
	}
	$user_sig = make_clickable($user_sig);

	if ( !$board_config['show_badwords'] )
	{
		if ( count($orig_word) )
		{
			$user_sig = str_replace('\"', '"', substr(@preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "@preg_replace(\$orig_word, \$replacement_word_html, '\\0')", '>' . $user_sig . '<'), 1, -1));
		}
	}
	else
	{
		replace_bad_words($orig_word, $replacement_word_html, $user_sig);
	}

	if ( $board_config['allow_smilies'] && $userdata['show_smiles'] )
	{
		if ( $profiledata['user_allowsmile'] )
		{
			$user_sig = smilies_pass($user_sig);
		}
	}
	if ( $user_sig_image )
	{
		$template->assign_block_vars('signature_image', array(
			'L_SIGNATURE' => $lang['Signature_panel'],
			'SIG_IMAGE' => $user_sig_image,
			'SIGNATURE' => $user_sig)
		);
	}
	else
	{
		$template->assign_block_vars('signature', array(
			'L_SIGNATURE' => $lang['Signature_panel'],
			'SIGNATURE' => $user_sig)
		);
	}
}

$template->assign_vars(array(
	'USERNAME' => $username,
	'JOINED' => create_date($board_config['default_dateformat'], $profiledata['user_regdate'], $board_config['board_timezone']) . ( (empty($profiledata['user_lastvisit']) && $userdata['user_level'] == ADMIN) ? ' </b><span class="gensmall">(' . $ip_this_user . $temp_link . ')</span>' : '' ),
	'LAST_VISIT' => ($profiledata['user_session_start']) ? create_date($board_config['default_dateformat'], $profiledata['user_session_start'], $board_config['board_timezone']) : $lang['Never'],
	'LAST_ACTIVITY_TIME' => ($profiledata['user_session_start']) ? ' (' . $last_activity_time . ')' : '',
	'USER_VISITS' => $profiledata['user_visit'],
	'USER_SPEND_TIME' => $spend_time,
	'USER_HOST' => $ip_this_user,
	'USER_HOST_LINK' => $host_link,
	'U_LAST_POST' => $last_post_url,
	'LAST_POST_TIME' => $last_post_time,
	'POSTER_RANK' => $poster_rank,
	'RANK_IMAGE' => $rank_image,
	'POSTS_PER_DAY' => $posts_per_day,
	'POSTS' => $user_posts,
	'PERCENTAGE' => $percentage . '%',
	'POST_DAY_STATS' => sprintf($lang['User_post_day_stats'], $posts_per_day),
	'POST_PERCENT_STATS' => sprintf($lang['User_post_pct_stats'], $percentage),
	'USER_ONLINE' => ($profiledata['user_session_time'] > (CR_TIME - 300) && ($profiledata['user_allow_viewonline'] || $userdata['user_level'] == ADMIN)) ? ' <img src="' . $images['icon_online'] . '" border="0" alt="Online">' : '',
	'SEARCH_IMG' => $search_img,
	'SEARCH' => $search,
	'PM_IMG' => $pm_img,
	'PM' => $pm,
	'EMAIL_IMG' => $email_img,
	'EMAIL' => $email,
	'WWW_IMG' => $www_img,
	'WWW' => $www,
	'ICQ_STATUS_IMG' => ($board_config['cicq']) ? $icq_status_img : '',
	'ICQ_IMG' => ($board_config['cicq']) ? $icq_img : '',
	'ICQ' => ($board_config['cicq']) ? $icq : '',
	'AIM_IMG' => ($board_config['cgg']) ? $aim_img : '',
	'AIM_STATUS_IMG' => ($board_config['cgg']) ? $aim_status_img : '',
	'MSN_IMG' => $msn_img,
	'MSN' => ($board_config['cmsn']) ? $msn : '',
	'YIM_IMG' => ($board_config['cyahoo']) ? $yim_img : '',
	'YIM' => $yim,
	'U_ADMIN_EDIT' => append_sid("admin/admin_users.$phpEx?mode=edit&amp;u=$user_id&amp;sid=" . $userdata['session_id']),
	'U_ADMIN_PERMISSION' => append_sid("admin/admin_ug_auth.$phpEx?mode=user&amp;u=$user_id&amp;sid=" . $userdata['session_id']),
	'U_ADD_WARNING' => append_sid("warnings.$phpEx?mode=add&amp;userid=$user_id"),
	'U_TOPIC_SPY' => append_sid("topic_spy.$phpEx?" . POST_USERS_URL . "=" . $user_id),
	'TOPICS' => ($total_topics) ? $total_topics : 0,
	'USER_ID' => $user_id,
	'U_IGNORE_TOPICS' => append_sid("ignore_topics.$phpEx?mode=view"),
	'ATTACHMENTS_TOTAL' => ($attach_total) ? $attach_total : 0,
	'POLLS' => ($total_topics_vote) ? $total_topics_vote : 0,

	'L_USER_VISITS' => $lang['Visits'],
	'L_SPEND_TIME' => $lang['Spend time'],
	'LOCATION' => ($profiledata['user_from']) ? $profiledata['user_from'] : '&nbsp;',
	'OCCUPATION' => ($profiledata['user_occ']) ? $profiledata['user_occ'] : '&nbsp;',
	'INTERESTS' => ($profiledata['user_interests']) ? $profiledata['user_interests'] : '&nbsp;',
	'GENDER' => $gender,
	'CUSTOM_RANK' => $poster_custom_rank,
	'AVATAR_IMG' => $avatar_img,

	'L_ATTACHMENTS' => $lang['Attachments_total'],
	'L_POLLS' => $lang['Polls_total'],
	'L_TOPICS' => $lang['topics'],
	'L_LAST_POST' => $lang['Last_Post'],
	'L_IGNORE_TOPICS' => $lang['list_ignore'],
	'L_TOPIC_SPY' => $lang['Topic_spy'],
	'L_ADD_WARNING' => $lang['add_warning'],
	'L_EDIT' => $lang['edit_mini'],
	'L_PERMISSIONS' => $lang['Permissions'],
	'L_VIEWING_PROFILE' => sprintf($lang['Viewing_user_profile'], $username . $gender_image),
	'L_AVATAR' => $lang['Avatar'],
	'L_POSTER_RANK' => $lang['Poster_rank'],
	'L_JOINED' => ($profiledata['user_gender'] == 2) ? $lang['Joined_she'] : $lang['Joined'],
	'L_LAST_VISIT' => $lang['Last_visit'],
	'L_TOTAL_POSTS' => $lang['Total_posts'],
	'L_SEARCH_USER_POSTS' => ($user_posts > 0 || $last_post_time) ? sprintf($lang['Search_user_posts'], $username) : '',
	'L_CONTACT' => $lang['Contact'],
	'L_EMAIL_ADDRESS' => $lang['Email_address'],
	'L_EMAIL' => $lang['Email'],
	'L_PM' => $lang['Private_Message'],
	'L_ICQ_NUMBER' => $lang['ICQ'],
	'L_YAHOO' => $lang['YIM'],
	'L_AIM' => $lang['AIM'],
	'L_MESSENGER' => $lang['MSNM'],
	'L_WEBSITE' => $lang['Website'],
	'L_LOCATION' => $lang['Location'],
	'L_OCCUPATION' => $lang['Occupation'],
	'L_INTERESTS' => $lang['Interests'],
	'L_GENDER' => $lang['Gender'],
	'L_CUSTOM_RANK' => $lang['Custom_Rank'],
	'L_LEVEL' => $lang['l_level'],
	
	'U_SEARCH_USER' => append_sid("search.$phpEx?search_author=" . $u_search_author),
	'HP' => $level_hp,
	'HP_WIDTH' => $level_hp_percent,
	'HP_EMPTY' => ( 100 - $level_hp_percent ),
	'MP' => $level_mp,
	'MP_WIDTH' => $level_mp_percent,
	'MP_EMPTY' => ( 100 - $level_mp_percent ),
	'EXP' => $level_exp,
	'EXP_WIDTH' => $level_exp_percent,
	'EXP_EMPTY' => ( 100 - $level_exp_percent ),
	'LEVEL' => $level_level,
	'S_PROFILE_ACTION' => append_sid("profile.$phpEx"))
);

if ( $profiledata['user_from'] )
{
	$template->assign_block_vars('location', array());
}
if ( $profiledata['user_website'] )
{
	$template->assign_block_vars('website', array());
}
if ( $profiledata['user_gender'] )
{
	$template->assign_block_vars('gender', array());
}

if ( $board_config['cjob'] && $profiledata['user_occ'] )
{
	$template->assign_block_vars('job', array());
}
if ( $board_config['cinter'] && $profiledata['user_interests'] )
{
	$template->assign_block_vars('interests', array());
}
if ( $board_config['cmsn'] && $profiledata['user_msnm'] )
{
	$template->assign_block_vars('msn', array());
}
if ( $board_config['cyahoo'] && $profiledata['user_yim'] )
{
	$template->assign_block_vars('yahoo', array());
}
if ( $board_config['cgg'] && $profiledata['user_aim'] )
{
	$template->assign_block_vars('aim', array());
}
if ( $board_config['cicq'] && $profiledata['user_icq'] )
{
	$template->assign_block_vars('icq', array());
}
if ( $board_config['clevelp'] )
{
	$template->assign_block_vars('level', array());
}

if ( $board_config['helped'] && $profiledata['special_rank'] && $profiledata['user_allow_helped'] )
{
	$special_rank = ($profiledata['special_rank'] < 2) ? $profiledata['special_rank'] . $lang['help_1'] : $profiledata['special_rank'] . $lang['help_more'];

	$template->assign_block_vars('helped', array(
		'L_SPECIAL_RANK' => ($profiledata['user_gender'] == 2) ? $lang['postrow_help_she'] : $lang['postrow_help'],
		'SPECIAL_RANK' => '<a href="' . append_sid("search.$phpEx?search_author=" . urlencode($username) . "&amp;gh=helped") . '">' . $special_rank . '</a>')
	);
}

if ( $board_config['warnings_enable'] )
{
	$sql = "SELECT SUM(value) as val
		FROM ". WARNINGS_TABLE ."
		WHERE userid = $user_id
			AND archive = '0'";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Couldnt Query value info from warnings table', '', __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);
	$val = $row['val'];

	if ( $val > 0 )
	{
		$max_warn = $board_config['ban_warnings'];
		$warn_percent = ($val > $max_warn) ? 100 : $val / $max_warn * 100;

		$template->assign_block_vars('warnings', array(
			'WARNINGS' => $lang['Warnings_viewtopic'],
			'HOW' => '<a href="' . append_sid("warnings.$phpEx?mode=detail&amp;userid=" . $user_id . "") . '" class="mainmenu"><b>' . $val . '</b></a>',
			'WRITE' => $board_config['write_warnings'],
			'MAX' => $max_warn,
			'POSTER_W_WIDTH' => $warn_percent,
			'POSTER_W_EMPTY' => (100 - $warn_percent))
		);
	}
}

$custom_fields_exists = (custom_fields('profile', false)) ? true : false;

if ( $custom_fields_exists )
{
	$custom_fields = custom_fields('', 'profile');

	for($j = 0; $j < count($custom_fields[0]); $j++)
	{
		$show_this_field = custom_fields('viewable', $custom_fields[11][$j], $user_id);
		if ( $show_this_field )
		{
			$user_field = $profiledata['user_field_' . $custom_fields[0][$j]];
			$user_allow_field = $profiledata['user_allow_field_' . $custom_fields[0][$j]];
			$desc = str_replace(array('<br>', '-#'), array('', ''), $custom_fields[1][$j]);
			$desc = (isset($lang[$desc])) ? $lang[$desc] : $desc;
			$max_value = $custom_fields[2][$j];
			$min_value = $custom_fields[3][$j];
			$numerics = $custom_fields[4][$j];
			$jumpbox = $custom_fields[5][$j];
			$makelinks = $custom_fields[6][$j];
			$prefix = replace_vars($custom_fields[8][$j], $user_field);
			$suffix = replace_vars($custom_fields[9][$j], $user_field);
			if ( $user_field && $user_allow_field)
			{
				$auth_field = false;
				if ( strlen($user_field) > $max_value )
				{
					$user_field = substr($user_field, 0, intval($max_value));
				}
				if ( strlen($user_field) < $min_value )
				{
					$user_field = '';
				}

				if ( $numerics )
				{
					if ( !is_numeric($user_field) )
					{
						$user_field = '';
					}
				}
				else if ( $makelinks )
				{
					$user_field = make_clickable($user_field);
				}


				if ( $jumpbox && $user_field )
				{
					$options = explode(',', $jumpbox);
					for ($k = 0; $k+1 <= count($options); $k++)
					{
						$auth_field = ($options[$k] == $user_field) ? true : $auth_field;
					}
					if (stristr($options[count($options) -1 ],'.gif') || stristr($options[count($options) -1 ],'.jpg'))
					{
						$field_name = str_replace(array('_', '.gif', '.jpg'), array(' ', '', ''), $user_field);
						$user_field = '<img src="' . $images['images'] . '/custom_fields/' . $user_field . '" border="0" alt="' . $field_name . '" title="' . $field_name . '" align="top" /><br />';
					}
				}
				if ( $prefix || $suffix )
				{
					if ( (strpos($prefix, '<a href="') !== false) && (strpos($suffix, '</a>') !== false) )
					{
						$user_field = $prefix . $user_field . '" title="' . $user_field . '">' . ((strpos($custom_fields[1][$j], '-#') !== false) ? '' : $user_field) . $suffix;
					}
					else
					{
						$user_field = $prefix . $user_field . $suffix;
					}
				}

				if ( ($auth_field || !$jumpbox) && $user_field )
				{
					$template->assign_block_vars('custom_fields', array(
						'DESC' => str_replace(array('<br>', '-#'), array('', ''), $desc),
						'FIELD' => $user_field)
					);
				}
			}
		}
	}
}

if ( $viewing_user_id == $user_id && $custom_fields_exists )
{
	$custom_fields = custom_fields();
	for($i = 0; $i < count($custom_fields[0]); $i++)
	{
		$split_field = 'user_field_' . $custom_fields[0][$i];
		if ( $custom_fields[1][$i] == 'adv_person' )
		{
			$adv_person_field = true;
			break;
		}
	}
	if ( $adv_person_field )
	{
		$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
		$server_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['server_name']));
		$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) : '';
		$script_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['script_path']));
		$script_name = ($script_name == '') ? $script_name : '/' . $script_name;
		$link = $server_protocol . $server_name . $server_port . $script_name . '/index.' . $phpEx . '?ap=' . $user_id;

		$template->assign_block_vars('advert_person',array('LINK' => sprintf($lang['adv_person_link'], '<br /><a href="' . $link . '" class="gensmall">' . $link . '</a>')));
	}
}

$groups = $viewable_groups = array();
$sql = "SELECT g.group_id, g.group_name, g.group_description, g.group_type, g.group_color, g.group_style, g.group_prefix
	FROM (" . USER_GROUP_TABLE . " as l, " . GROUPS_TABLE . " as g)
	WHERE l.user_pending = 0
		AND g.group_single_user = 0
		AND	l.user_id =" . $user_id . "
		AND g.group_id = l.group_id 
	ORDER BY g.group_order";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not read groups', '', __LINE__, __FILE__, $sql);
}
while ($group = $db->sql_fetchrow($result)) $groups[] = $group;

$template->assign_vars(array(
	'L_USERGROUPS' => $lang['Usergroups'])
);

if ( count($groups) > 0 )
{
	for ($i=0; $i < count($groups); $i++)
	{
		$view_groups = false;
		if ( ($groups[$i]['group_type'] != GROUP_HIDDEN) || ($viewing_user_level == ADMIN) )
		{
			$viewable_groups[] = $groups[$i];
		}
		else
		{
			$group_id = $groups[$i]['group_id'];

			$sql = "SELECT * FROM " . USER_GROUP_TABLE . "
				WHERE group_id = " . $group_id . "
					AND user_id = " . $viewing_user_id . "
					AND user_pending = 0";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Couldn\'t obtain viewer group list', '', __LINE__, __FILE__, $sql);
			}
			if ( $row = $db->sql_fetchrow($result) )
			{
				$viewable_groups[] = $groups[$i];
			}
		}
	}
	if ( count($viewable_groups) )
	{
		$template->assign_block_vars('list',array());

		for($i = 0; $i < count($viewable_groups); $i++)
		{
			$template->assign_block_vars('list.groups',array(
				'U_GROUP_NAME' => append_sid("groupcp.$phpEx?" . POST_GROUPS_URL . "=".$viewable_groups[$i]['group_id']),
				'GROUP_COLOR' => ($viewable_groups[$i]['group_color']) ? ' style="color: #' . $viewable_groups[$i]['group_color'] . '"' : '',
				'GROUP_STYLE' => ($viewable_groups[$i]['group_style']) ? ' style="' . $viewable_groups[$i]['group_style'] . '"' : '',
				'SEPARATOR' => ($i != 0) ? '&bull; ' : '',
				'L_GROUP_NAME' => $viewable_groups[$i]['group_prefix'] . $viewable_groups[$i]['group_name'])
			);
		}
	}
}

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>