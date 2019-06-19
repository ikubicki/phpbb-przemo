<?php
define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

$userdata = session_pagestart($user_ip, PAGE_STAFF, $session_length);
init_userprefs($userdata);

$page_title = $lang['Staff'];
include('includes/page_header.'.$phpEx);

if ( $board_config['login_require'] && !$userdata['session_logged_in'] || ( $board_config['crestrict'] && !$userdata['session_logged_in'] ) )
{
	$message = $lang['login_require'] . '<br /><br />' . sprintf($lang['login_require_register'], '<a href="' . append_sid("profile.$phpEx?mode=register") . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

if ( !$board_config['staff_enable'] )
{
	message_die(GENERAL_MESSAGE, 'Not authorised to this');
}

$template->set_filenames(array(
	'body' => 'staff_body.tpl')
);

$sql = "SELECT ug.user_id, f.forum_id, f.forum_name
FROM (" . AUTH_ACCESS_TABLE . " aa, " . USER_GROUP_TABLE . " ug, " . FORUMS_TABLE . " f)
WHERE aa.auth_mod = " . TRUE . "
	AND ug.group_id = aa.group_id
	AND f.forum_id = aa.forum_id";
if ( !$result = $db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, 'Could not query forums.', '', __LINE__, __FILE__, $sql);
}

while( $row = $db->sql_fetchrow($result) )
{ 
	$forum_id = $row['forum_id'];
	$is_auth = array();
	$is_auth = $tree['auth'][POST_FORUM_URL . $forum_id];
	$staff2[$row['user_id']][$row['forum_id']] = ($is_auth['auth_read']) ? '<a href="' . append_sid("viewforum.$phpEx?f=$forum_id") . '" class="genmed">' . $row['forum_name'] . '</a><br />' : '';
}

$total_posts = get_db_stat('postcount');

$sql = "SELECT *
	FROM " . RANKS_TABLE . "
	ORDER BY rank_min DESC";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain ranks information', '', __LINE__, __FILE__, $sql);
}

$ranksrow = $sp_ranksrow = $rest_ranks = array();
while ( $row = $db->sql_fetchrow($result) )
{
	if ( $row['rank_special'] )
	{
		$sp_ranksrow[$row['rank_id']] = $row;
	}
	else
	{
		$ranksrow[$row['rank_group']][] = $row;
		$ranksrow[$row['rank_group']]['count']++;		
	}
}
$sql = "SELECT ug.group_id, ug.user_id
	FROM (" . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g, " . RANKS_TABLE . " r)
	WHERE g.group_id = r.rank_group
		AND g.group_id = ug.group_id
		AND g.group_single_user = 0
		AND ug.user_pending <> 1
	ORDER BY g.group_order DESC";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_MESSAGE, "Can not find username");
}
while ( $row = $db->sql_fetchrow($result) )
{
	$rest_ranks[$row['user_id']] = $row['group_id'];
}

$db->sql_freeresult($result);

$group_sql = '';

switch( $HTTP_GET_VARS[POST_GROUPS_URL] )
{
	case 'admin':
		$group_sql = 'user_level = ' . ADMIN;
	break;
	case 'mod':
		$group_sql = 'user_level = ' . MOD;
	break;
	case 'junior':
		$group_sql = 'user_jr = 1';
	break;
	default : $group_sql = 'user_level >= 1 OR user_jr = 1';
}

$sql = "SELECT *
	FROM " . USERS_TABLE . "
	WHERE ( $group_sql )
	GROUP by user_id
	ORDER BY IF(user_level = 1, 1, IF(user_jr = 1, 2, 3)) ASC";
if ( !($results = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain user information.', '', __LINE__, __FILE__, $sql);
}

while($staff = $db->sql_fetchrow($results))
{
	if ( $staff['user_level'] == 1 || ($staff['user_level'] == 2 && $staff['user_level'] == MOD) || $staff['user_jr'] != '' )
	{
		if ( $staff['user_avatar'] )
		{
			switch( $staff['user_avatar_type'] )
			{
				case USER_AVATAR_UPLOAD:
				$avatar = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $staff['user_avatar'] . '" border="0" alt="" />' : '';
				break;
				case USER_AVATAR_REMOTE:
				$avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $staff['user_avatar'] . '" alt="" border="0" />' : '';
				break;
				case USER_AVATAR_GALLERY:
				$avatar = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $staff['user_avatar'] . '" alt="" border="0" />' : '';
				break;
			}
		}
		else
		{
			$avatar = '';
		}

		$gender_image = '';
		switch ($staff['user_gender'])
		{
			case 1 : $gender_image = "&nbsp;<img src=\"" . $images['icon_minigender_male'] . "\" alt=\"" . $lang['Gender']. ":".$lang['Male']."\" title=\"".$lang['Male']. "\" border=\"0\" />"; break;
			case 2 : $gender_image = "&nbsp;<img src=\"" . $images['icon_minigender_female'] . "\" alt=\"" . $lang['Gender']. ":".$lang['Female']. "\" title=\"".$lang['Female']. "\" border=\"0\" />"; break;
			default : $gender_image = '';
		}
		if ( !$board_config['gender'] ) $gender_image = '';

		$level = ($staff['user_level'] == 1) ? $lang['Admin'] . '<br />' : '';
		$level .= ($staff['user_jr'] && $staff['user_level'] != 1) ? $lang['Junior'] . '<br />' : '';
		$level .= ($staff['user_level'] == 2) ? $lang['Moderator'] . '<br />' : '';
		

		$forums = '';
		if ( !empty($staff2[$staff['user_id']]) ) 
		{
			asort($staff2[$staff['user_id']]);
			$forums = implode(' ',$staff2[$staff['user_id']]); 
		}

		$memberdays = max(1, round( ( CR_TIME - $staff['user_regdate'] ) / 86400 ));
		$posts_per_day = $staff['user_posts'] / $memberdays;
		if ( $staff['user_posts'] != 0 )
		{
			$percentage = ( $total_posts ) ? min(100, ($staff['user_posts'] / $total_posts) * 100) : 0;
		}
		else
		{
			$percentage = 0;
		}
		$user_id = $staff['user_id'];

		$mailto = ($board_config['board_email_form']) ? append_sid("profile.$phpEx?mode=email&amp;" . POST_USERS_URL .'=' . $staff['user_id']) : 'mailto:' . $staff['user_email'];
		$mail = ($staff['user_email']) ? '<a href="' . $mailto . '"><img src="' . $images['icon_email'] . '" alt="' . $lang['Send_email'] . '" title="' . $lang['Send_email'] . '" border="0" /></a>' : '';

		$pmto = append_sid("privmsg.$phpEx?mode=post&amp;" . POST_USERS_URL . "=$staff[user_id]");
		$pm = '<a href="' . $pmto . '"><img src="' . $images['icon_pm'] . '" alt="' . $lang['Send_private_message'] . '" title="' . $lang['Send_private_message'] . '" border="0" /></a>';

		$msn = ($staff['user_msnm']) ? '<a href="mailto: '.$staff['user_msnm'].'"><img src="' . $images['icon_msnm'] . '" alt="' . $lang['MSNM'] . '" title="' . $lang['MSNM'] . '" border="0" /></a>' : '';
		$yim = ($staff['user_yim']) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $staff['user_yim'] . '&amp;.src=pg"><img src="' . $images['icon_yim'] . '" alt="' . $lang['YIM'] . '" title="' . $lang['YIM'] . '" border="0" /></a>' : '';

		if ( !empty($staff['user_aim']) )
		{
			$gg_url = append_sid("gg.$phpEx?mode=gadu&amp;" . POST_USERS_URL . "=$user_id");
			if ( $staff['user_viewaim'] )
			{
				$aim_status_img = '<a href="gg:' .$staff['user_aim'] . '"><img alt="' .$staff['user_aim'] . '" src="http://status.gadu-gadu.pl/users/status.asp?id=' . $staff['user_aim'] . '&amp;styl=1" border="0" width="16" height="16" /></a>';
				$aim_img = '<a href="' . $gg_url . '"><img src="' . $images['icon_aim'] . '" alt="' . $lang['AIM'] . '" title="' . $lang['AIM'] . ': ' . $staff['user_aim'] . '" border="0" /></a>';
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

		$icq = ($staff['user_icq']) ? '<a href="http://wwp.icq.com/scripts/contact.dll?msgto=' . $staff['user_icq'] . '"><img src="' . $images['icon_icq'] . '" alt="' . $lang['ICQ'] . '" title="' . $lang['ICQ'] . '" border="0" /></a>' : '';
		$www = ($staff['user_website']) ? '<a href="' . $staff['user_website'] . '" target="_userwww" rel="nofollow"><img src="' . $images['icon_www'] . '" alt="' . $lang['Visit_website'] . '" title="' . $lang['Visit_website'] . '" border="0" /></a>' : '';

		$rank_image = '';

		if ( isset($sp_ranksrow[$staff['user_rank']]) )
		{
			if ( $sp_ranksrow[$staff['user_rank']]['rank_image'] )
			{
				$rank_image = '<img src="' . $images['rank_path'] . $sp_ranksrow[$staff['user_rank']]['rank_image'] . '" border="0" alt="" /><br />';
			}
		}
		else
		{
			$rank_group_id = 0;

			if ( isset($rest_ranks[$staff['user_id']]) )
			{
				$rank_group_id = $rest_ranks[$staff['user_id']];
			}
			for($i = 0; $i < $ranksrow[$rank_group_id]['count']; $i++)
			{
				if ( $staff['user_posts'] >= $ranksrow[$rank_group_id][$i]['rank_min'] )
				{
					if ( $ranksrow[$rank_group_id][$i]['rank_image'] )
					{
						$rank_image = '<img src="' . $images['rank_path'] . $ranksrow[$rank_group_id][$i]['rank_image'] . '" border="0" alt="" /><br />';
						break;
					}
				}
			}
		}

		$colored_username = color_username($staff['user_level'], $staff['user_jr'], $staff['user_id'], $staff['username']);
		$staff_username = $colored_username[0];

		$staff_username = $staff_username . $gender_image . '<br />';

		$template->assign_block_vars('staff', array(
			'AVATAR' => $avatar,
			'RANK_IMAGE' => $rank_image,
			'U_NAME' => append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$staff[user_id]"),
			'NAME' => $staff_username,
			'USERNAME_COLOR' => $colored_username[1],
			'LEVEL' => $level,
			'FORUMS' => ($board_config['staff_forums']) ? $forums : '',
			'JOINED' => create_date($board_config['default_dateformat'], $staff['user_regdate'], $board_config['board_timezone']),
			'PERIOD' => sprintf($lang['Period'], $memberdays),
			'POSTS' => $staff['user_posts'],
			'POST_DAY' => sprintf($lang['User_post_day_stats'], $posts_per_day), 
			'POST_PERCENT' => sprintf($lang['User_post_pct_stats'], $percentage), 
			'MAIL' => $mail,
			'PM' => $pm,
			'MSN' => $msn,
			'YIM' => $yim,
			'AIM' => $aim_img,
			'AIM_STATUS_IMG' => $aim_status_img,
			'ICQ' => $icq,
			'WWW' => $www)
		);

		if ( $board_config['cgg'] )
		{
			$template->assign_block_vars('staff.aim_row', array());
		}
	}
	$users_match = true;
}

if ( !$users_match )
{
	message_die(GENERAL_MESSAGE, $lang['No_match']);
}

$template->assign_vars(array( 
	'L_AVATAR' => $lang['Avatar'], 
	'L_USERNAME' => $lang['Username'], 
	'L_POSTS' => $lang['Posts'],
	'L_FORUMS' => ($board_config['staff_forums']) ? $lang['Forum'] : '',
	'L_JOINED' => $lang['Joined'], 
	'L_EMAIL' => $lang['Email'],
	'L_PM' => $lang['Private_Message'],
	'L_MESSENGER' => 'Messenger',
	'L_WWW' => $lang['Website'])
);

if ( $board_config['cgg'] )
{
	$template->assign_block_vars('aim', array());
}

$template->pparse('body');

include('includes/page_tail.'.$phpEx);

?>