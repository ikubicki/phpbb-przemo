<?php
/***************************************************************************
 *                              memberlist.php
 *                            -------------------
 *   begin                : Friday, May 11, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   modification         : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   date modification    : ver. 1.12.3 2005/10/07 11:22
 *
 *   $Id: memberlist.php,v 1.36.2.11 2005/09/14 18:14:30 acydburn Exp $
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_VIEWMEMBERS);
init_userprefs($userdata);
//
// End session management
//	

include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_profile.' . $phpEx);

$user_topics_per_page = ($userdata['user_topics_per_page'] > $board_config['topics_per_page']) ? $board_config['topics_per_page'] : $userdata['user_topics_per_page'];

$by_letter = xhtmlspecialchars(get_vars('letter', 'all', 'POST,GET'));

if ( $board_config['login_require'] && !$userdata['session_logged_in'] || ( $board_config['crestrict'] && !$userdata['session_logged_in'] ) )
{
	$message = $lang['login_require'] . '<br /><br />' . sprintf($lang['login_require_register'], '<a href="' . append_sid("profile.$phpEx?mode=register") . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

$start = get_vars('start', 0, 'GET,POST', true);
$mode  = get_vars('mode', 'joined', 'POST,GET');
$sort_order = get_vars('order', '', 'POST,GET');
$sort_order = ($sort_order == 'ASC') ? 'ASC' : 'DESC';

//
// Memberlist sorting
//
$mode_types_text = array($lang['Sort_Joined'], $lang['Sort_Last_visit'], $lang['Sort_Username'], $lang['Location'], $lang['Total_posts'], $lang['Email'], $lang['Website'], $lang['Sort_Top_Ten'], ( ($board_config['helped']) ? $lang['helped'] : ''), $lang['Visits'], $lang['Spend time']);
$mode_types = array('joined', 'lastvisit', 'username', 'location', 'posts', 'email', 'website', 'topten', ( ($board_config['helped']) ? 'special_rank' : ''), 'user_visit', 'user_spend_time');

$sql_cf = '';
$custom_fields = custom_fields();

for($i = 0; $i < count($custom_fields[0]); $i++)
{
	if ( !$custom_fields[0][$i] )
	{
		break;
	}
	$show_this_field = custom_fields('viewable', $custom_fields[12][$i], false);
	if ( $show_this_field )
	{
		$split_field = 'u.user_field_' . $custom_fields[0][$i];
		$fields_array[] = $split_field; 
		$cf_real_desc = $custom_fields[1][$i];
		$custom_fields[1][$i] = str_replace(array('-#', '<br>'), array('',''), $custom_fields[1][$i]);
		$cf_lang = (isset($lang[$custom_fields[1][$i]])) ? $lang[$custom_fields[1][$i]] : $custom_fields[1][$i];
		$mode_types_text[] =  $cf_lang;
		$mode_types[] = $split_field;
		$sql_cf .= ', ' . $split_field;
		if ( $mode == $split_field )
		{
			$memberlist_lang_cf = $cf_lang;
			$memberlist_cf = 'user_field_' . $custom_fields[0][$i];
			$prefix = replace_vars($custom_fields[9][$i]);
			$suffix = replace_vars($custom_fields[10][$i]);
		}
		$cf_makelinks = $custom_fields[6][$i];
		$custom_fields_exists = true;
	}
}

$select_sort_mode = '<select name="mode">';
for($i = 0; $i < count($mode_types_text); $i++)
{
	if($mode_types_text[$i] != '')
	{
		$selected = ( $mode == $mode_types[$i] ) ? ' selected="selected"' : '';
		$select_sort_mode .= '<option value="' . $mode_types[$i] . '"' . $selected . '>' . $mode_types_text[$i] . '</option>';
	}
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

//
// Generate page
//
$page_title = $lang['Memberlist'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'body' => 'memberlist_body.tpl')
);
make_jumpbox('viewforum.'.$phpEx);
$mode = ($mode == 'special_rank') ? ( ($board_config['helped']) ? $mode : 'user_regdate' ):$mode;

if ( $mode == 'special_rank' )
{
	$l_from = $lang['helped'];
}
else if ( $memberlist_lang_cf )
{
	$l_from = $memberlist_lang_cf;
}
else if ( $mode == 'user_visit' )
{
	$l_from = $lang['Visits'];
}
else if ( $mode == 'user_spend_time' )
{
	$l_from = $lang['Spend time'];
}
else
{
	$l_from = $lang['Location'];
}

$colspan = 3;

if ( $board_config['cllogin'] )
{
	$template->assign_block_vars('llogin', array());
	$colspan++;
}
if ( $board_config['cgg'] )
{
	$template->assign_block_vars('aim', array());
	$colspan++;
}

$template->assign_vars(array(
	'L_SELECT_SORT_METHOD' => $lang['Select_sort_method'],
	'L_EMAIL' => $lang['Email'],
	'L_WEBSITE' => $lang['Website'],
	'L_FROM' => $l_from,
	'L_SORT' => $lang['Sort'],
	'L_SUBMIT' => $lang['Sort'],
	'L_AIM' => $lang['AIM'],
	'L_YIM' => $lang['YIM'],
	'L_MSNM' => $lang['MSNM'],
	'L_ICQ' => $lang['ICQ'], 
	'L_JOINED' => $lang['Joined'], 
	'L_LAST_VISIT' => $lang['Last_visit'],
	'L_POSTS' => $lang['Posts'], 
	'L_POST_TIME' => $lang['Last_Post'],

	'COLSPAN' => $colspan,
	'S_MODE_SELECT' => $select_sort_mode,
	'S_ORDER_SELECT' => $select_sort_order,
	'S_MODE_ACTION' => append_sid("memberlist.$phpEx"),
	'U_STAFF' => ($board_config['staff_enable']) ? '<a href="' . append_sid("staff.$phpEx") . '" class="nav">' . $lang['Staff'] . '</a>' : '',
	'U_SEARCH_USERS' => '<a href="' . append_sid("seeker.$phpEx") . '" class="nav">' . $lang['Seeker'] . '</a>')
);
$hide_user = '';
switch( $mode )
{
	case 'joined':
		$order_by = "u.user_regdate $sort_order LIMIT $start, " . $user_topics_per_page;
		break;
	case 'lastvisit':
		$order_by = "u.user_session_time $sort_order LIMIT $start, " . $user_topics_per_page;
		$hide_user = " AND u.user_allow_viewonline <> 0 ";
		break;
	case 'username':
		$order_by = "u.username $sort_order LIMIT $start, " . $user_topics_per_page;
		break;
	case 'location':
		$order_by = "u.user_from $sort_order LIMIT $start, " . $user_topics_per_page;
		break;
	case 'posts':
		$order_by = "u.user_posts $sort_order LIMIT $start, " . $user_topics_per_page;
		break;
	case 'email':
		$order_by = "u.user_email $sort_order LIMIT $start, " . $user_topics_per_page;
		break;
	case 'website':
		$order_by = "u.user_website $sort_order LIMIT $start, " . $user_topics_per_page;
		break;
	case 'topten':
		$order_by = "u.user_posts $sort_order LIMIT 10";
		break;
	case 'special_rank':
		$order_by = "u.special_rank $sort_order LIMIT $start, " . $user_topics_per_page;
		break;
	case 'user_visit':
		$order_by = "u.user_visit $sort_order LIMIT $start, " . $user_topics_per_page;
		break;
	case 'user_spend_time':
		$order_by = "u.user_spend_time $sort_order LIMIT $start, " . $user_topics_per_page;
		break;
	default:
		$order_by = "u.user_regdate $sort_order LIMIT $start, " . $user_topics_per_page;
		break;
}

if ( $custom_fields_exists )
{
	for($i = 0; $i < count($custom_fields[0]); $i++)
	{
		$show_this_field = custom_fields('viewable', $custom_fields[12][$i], false);
		if ( $show_this_field )
		{
			$split_field = 'u.user_field_' . $custom_fields[0][$i];
			if ( $mode == $split_field )
			{
				$order_by = "$split_field $sort_order LIMIT $start, " . $user_topics_per_page;
			}
		}
	}
}

// Set per-letter selection
$others_sql = $select_letter = '';
$mode_letter = (!isset($HTTP_GET_VARS['mode']) && !isset($HTTP_POST_VARS['mode'])) ? '' : '&amp;mode=' . $mode;
for ($i = 97; $i <= 122; $i++)
{
	$others_sql .= " AND u.username NOT LIKE '" . chr($i) . "%' ";
	$select_letter .= ( $by_letter == chr($i) ) ? chr($i) . '&nbsp;' : '<a href="' . append_sid("memberlist.$phpEx?letter=" . chr($i) . $mode_letter . "&amp;order=$sort_order") . '">' . chr($i) . '</a>&nbsp;';
}
$select_letter .= ( $by_letter == 'others' ) ? $lang['Others'] . '&nbsp;' : '<a href="' . append_sid("memberlist.$phpEx?letter=others" . $mode_letter . "&amp;order=$sort_order") . '">' . $lang['Others'] . '</a>&nbsp;';
$select_letter .= ( $by_letter == 'all' ) ? $lang['All'] : '<a href="' . append_sid("memberlist.$phpEx?letter=all" . $mode_letter . "&amp;order=$sort_order") . '">' . $lang['All'] . '</a>';

$template->assign_vars(array(
	'L_SORT_PER_LETTER' => $lang['Sort_per_letter'],
	'S_LETTER_SELECT' => $select_letter,
	'S_LETTER_HIDDEN' => '<input type="hidden" name="letter" value="' . $by_letter . '" />')
);

if ( $by_letter == 'all' )
{
	$letter_sql = '';
}
else if ( $by_letter == 'others' )
{
	$letter_sql = $others_sql;
}
else
{
	$letter_sql = " AND u.username LIKE '" . substr($by_letter, 0, 1) . "%' ";
}

$order_by = (isset($HTTP_GET_VARS['letter']) && !isset($HTTP_GET_VARS['mode']) && !isset($HTTP_POST_VARS['mode']) ) ? "u.username $sort_order LIMIT $start, " . $user_topics_per_page : $order_by;

$sql = "SELECT u.username, u.user_id, u.user_level, u.user_allow_viewonline, u.user_jr, u.user_viewemail, u.user_posts, u.user_lastvisit, u.user_session_time, u.user_regdate, u.user_from, u.user_website, u.user_email, u.user_icq, u.user_aim, u.user_viewaim, u.user_yim, u.user_msnm, u.user_avatar, u.user_avatar_type, u.user_allowavatar, u.user_gender, u.user_custom_color, u.can_custom_color, u.special_rank, u.user_visit, u.user_spend_time $sql_cf
	 FROM " . USERS_TABLE . " u
	WHERE u.user_id <> " . ANONYMOUS . "$hide_user $letter_sql
	GROUP BY u.user_id
	ORDER BY $order_by";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query users', '', __LINE__, __FILE__, $sql);
}

if ( $row = $db->sql_fetchrow($result) )
{
	$numusers = $db->sql_numrows();
	$i = 0;
	do
	{
		$username = $row['username'];
		$user_id = $row['user_id'];

		$from = ( !empty($row['user_from']) ) ? $row['user_from'] : '&nbsp;';
		$joined = create_date($board_config['default_dateformat'], $row['user_regdate'], $board_config['board_timezone']);
		if ($row['user_allow_viewonline'] == 1)
		{
			$last_active = ($row['user_lastvisit'] > $row['user_session_time']) ? $row['user_lastvisit'] : $row['user_session_time'];
			$last_visit = ($last_active) ? create_date($board_config['default_dateformat'], $last_active, $board_config['board_timezone']) : $lang['Never'];
		}
		else
		{
			$last_active = '';
			$last_visit = '';
		}

		$posts = ( $row['user_posts'] ) ? $row['user_posts'] : 0;

		$poster_avatar = '';
		if ( $row['user_avatar_type'] && $user_id != ANONYMOUS && $row['user_allowavatar'] )
		{
			switch( $row['user_avatar_type'] )
			{
				case USER_AVATAR_UPLOAD:
					$poster_avatar = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $row['user_avatar'] . '" alt="" border="0" />' : '';
					break;
				case USER_AVATAR_REMOTE:
					$poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $row['user_avatar'] . '" alt="" border="0" />' : '';
					break;
				case USER_AVATAR_GALLERY:
					$poster_avatar = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $row['user_avatar'] . '" alt="" border="0" />' : '';
					break;
			}
		}

		$gender_image = '';

		if ( $board_config['gender'] )
		{
			switch ($row['user_gender'])
			{
				case 1 :
					$gender_image = '<img src="' . $images['icon_minigender_male'] . '" alt="' . $lang['Gender']. ':' . $lang['Male'] . '" title="' . $lang['Male'] . '" border="0" />';
				break;
				case 2 :
					$gender_image = '<img src="' . $images['icon_minigender_female'] . '" alt="' . $lang['Gender']. ':' . $lang['Female'] . '" title="' . $lang['Female'] . '" border="0" />';
				break;
				default :
					$gender_image = '';
			}
			$gender_image = ($gender_image != '') ? '&nbsp;' . $gender_image : '';			
		}

		$poster_custom_color = $row['user_custom_color'];
		$show_custom_color = '';
		$custom_color_mod = ''; 

		$colored_username = color_username($row['user_level'], $row['user_jr'], $row['user_id'], $username);
		$username = $colored_username[0];

		$username .= $gender_image;

		if ( !empty($row['user_viewemail']) || $userdata['user_level'] == ADMIN )
		{
			$email_uri = ( $board_config['board_email_form'] ) ? append_sid("profile.$phpEx?mode=email&amp;" . POST_USERS_URL .'=' . $user_id) : 'mailto:' . $row['user_email'];

			$email_img = '<a href="' . $email_uri . '"><img src="' . $images['icon_email'] . '" alt="" border="0" /></a>';
			$email = '<a href="' . $email_uri . '">' . $lang['Send_email'] . '</a>';
		}
		else
		{
			$email_img = '&nbsp;';
			$email = '&nbsp;';
		}

		$temp_url = append_sid("privmsg.$phpEx?mode=post&amp;" . POST_USERS_URL . "=$user_id");
		$pm_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_pm'] . '" alt="" border="0" /></a>';
		$pm = '<a href="' . $temp_url . '">' . $lang['Send_private_message'] . '</a>';

		$www_img = ( $row['user_website'] ) ? '<a href="' . $row['user_website'] . '" target="_userwww" rel="nofollow"><img src="' . $images['icon_www'] . '" alt="" border="0" /></a>' : '';
		$www = ( $row['user_website'] ) ? '<a href="' . $row['user_website'] . '" target="_userwww" rel="nofollow">' . $lang['Visit_website'] . '</a>' : '';

		if ( !empty($row['user_icq']) )
		{
			$icq_status_img = '<a href="http://wwp.icq.com/' . $row['user_icq'] . '#pager"><img src="http://web.icq.com/whitepages/online?icq=' . $row['user_icq'] . '&img=5" alt="" width="18" height="18" border="0" /></a>';
			$icq_img = '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $row['user_icq'] . '"><img src="' . $images['icon_icq'] . '" alt="" border="0" /></a>';
			$icq = '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $row['user_icq'] . '">' . $lang['ICQ'] . '</a>';
		}
		else
		{
			$icq_status_img = '';
			$icq_img = '';
			$icq = '';
		}

		if ( !empty($row['user_aim']) && $row['user_viewaim'] )
 		{
			$gg_url = append_sid("gg.$phpEx?mode=gadu&amp;" . POST_USERS_URL . '=' . $user_id);
			$aim_status_img = '<a href="' . $gg_url . '"><img alt="" src="http://status.gadu-gadu.pl/users/status.asp?id=' . $row['user_aim'] . '&amp;styl=1" width="16" height="16" border="0" /></a>';
		}
		else
		{
			$aim_status_img = '';
		}
		$temp_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$user_id");
		$msn_img = ( $row['user_msnm'] ) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_msnm'] . '" alt="" border="0" /></a>' : '';
		$msn = ( $row['user_msnm'] ) ? '<a href="' . $temp_url . '">' . $lang['MSNM'] . '</a>' : '';

		$yim_img = ( $row['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $row['user_yim'] . '&amp;.src=pg"><img src="' . $images['icon_yim'] . '" alt="" border="0" /></a>' : '';
		$yim = ( $row['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $row['user_yim'] . '&amp;.src=pg">' . $lang['YIM'] . '</a>' : '';

		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		if ( $mode == 'special_rank' )
		{
			$from = $row['special_rank'];
		}
		else if ( $mode == 'user_visit' )
		{
			$from = $row['user_visit'];
		}
		else if ( $mode == 'user_spend_time' )
		{
			if ( $row['user_spend_time'] >= 3600 )
			{
				$from = $lang['Hours'] . ': ' . round(($row['user_spend_time'] / 60 / 60), 1);
			}
			else
			{
				$from = $lang['Minutes'] . ': ' . round(($row['user_spend_time'] / 60));
			}
		}
		else if ( $memberlist_cf )
		{
			if ( $row[$memberlist_cf] )
			{
				if ( $cf_makelinks )
				{
					require_once($phpbb_root_path . 'includes/bbcode.'.$phpEx);
					$from = make_clickable($row[$memberlist_cf]);
				}
				else
				{
					$from = $row[$memberlist_cf];
				}
				if ( strpos($from, '.gif') || strpos($from, '.jpg') )
				{
					$field_name = str_replace(array('_', '.gif', '.jpg'), array(' ', '', ''), $from);
					$from = (file_exists($images['images'] . '/custom_fields/' . $from)) ? '<img src="' . $images['images'] . '/custom_fields/' . $from . '" border="0" alt="' . $field_name . '" title="' . $field_name . '" align="top" /><br />' : $from;
				}
				if ( $prefix || $suffix )
				{
					if ( (strpos($prefix, '<a href="') !== false) && (strpos($suffix, '</a>') !== false) && $from )
					{
						$from = replace_vars($prefix, $from) . $from . '">' . ((strpos($cf_real_desc, '-#') !== false) ? '' : $from) . replace_vars($suffix, $from);
					}
					else
					{
						$from = replace_vars($prefix, $from) . $from . replace_vars($suffix, $from);
					}
				}
			}
			else
			{
				$from = '';
			}
		}

		$template->assign_block_vars('memberrow', array(
			'ROW_NUMBER' => $i + ( $start + 1 ),
			'ROW_COLOR' => '#' . $row_color,
			'ROW_CLASS' => $row_class,
			'USERNAME' => $username,
			'USERNAME_COLOR' => $colored_username[1],
			'FROM' => $from,
			'JOINED' => $joined,
			'LAST_VISIT' => ($board_config['cllogin']) ? $last_visit : '',
			'POSTS' => $posts,
			'AVATAR_IMG' => $poster_avatar,
			'PROFILE_IMG' => $profile_img,
			'PM_IMG' => $pm_img,
			'PM' => $pm,
			'EMAIL_IMG' => $email_img,
			'EMAIL' => $email,
			'WWW_IMG' => $www_img,
			'WWW' => $www,
			'ICQ_STATUS_IMG' => $icq_status_img,
			'ICQ_IMG' => $icq_img,
			'ICQ' => $icq,
			'AIM_STATUS_IMG' => ($board_config['cgg']) ? $aim_status_img : '',
			'MSN_IMG' => $msn_img,
			'MSN' => $msn,
			'YIM_IMG' => $yim_img,
			'YIM' => $yim,
			'U_VIEWPROFILE' => append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$user_id"))
		);

		if ( $board_config['cllogin'] )
		{
			$template->assign_block_vars('memberrow.llogin_row', array());
		}
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
	$sql = "SELECT count(u.user_id) AS total
		FROM " . USERS_TABLE . " u
		WHERE u.user_id <> " . ANONYMOUS . $letter_sql;

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Error getting total users', '', __LINE__, __FILE__, $sql);
	}

	if ( $total = $db->sql_fetchrow($result) )
	{
		$total_members = $total['total'];

		generate_pagination("memberlist.$phpEx?mode=$mode&amp;order=$sort_order&amp;letter=$by_letter", $total_members, $user_topics_per_page, $start). '&nbsp;';
	}
	$db->sql_freeresult($result);
}

groups_color_explain('staff_explain');

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>