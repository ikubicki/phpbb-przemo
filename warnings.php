<?php
/***************************************************************************
 *                  warnings.php
 *                  -------------------
 *   begin          : 11, 09, 2003
 *   copyright      : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   email          : przemo@przemo.org
 *   version        : ver. 1.12.0 2005/09/28 16:56
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
include_once($phpbb_root_path . 'includes/bbcode.'.$phpEx);
require($phpbb_root_path . 'includes/functions_search.'.$phpEx);

$userdata = session_pagestart($user_ip, PAGE_VIEWMEMBERS);
init_userprefs($userdata);

function prep_reason($reason)
{
	global $userdata, $board_config;
	
	if ( $userdata['user_level'] == ADMIN || $userdata['user_jr'] || $userdata['user_level'] == MOD )
	{
		$reason = preg_replace("#\[mod\](.*?)\[/mod\]#si", "<br><u><b>Mod Info:</u><br>[</b>\\1<b>]</b><br>", $reason);
	}
	else
	{
		$reason = preg_replace("#\[mod\](.*?)\[/mod\]#si", "", $reason);
	}
	
	$reason = make_clickable($reason);
	$reason = preg_replace("#\[b\](.*?)\[\/b\]#si", "<b>\\1</b>", $reason);
	$reason = preg_replace("#\[i\](.*?)\[\/i\]#si", "<i>\\1</i>", $reason);
	$reason = preg_replace("#\[u\](.*?)\[\/u\]#si", "<u>\\1</u>", $reason);
	$reason = str_replace(array("\n"), array("\n<br />\n"), $reason);
	$reason = preg_replace( "/\[color=(\#[0-9A-F]{6}|[a-z]+)\](.*?)\[\/color]/si", '<span style="color:\\1">\\2</span>', $reason );
	return ($board_config['allow_smilies'] && $userdata['show_smiles']) ? smilies_pass($reason) : $reason;
}


include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_warnings.' . $phpEx);

$page_title = $lang['warnings'];

$user_topics_per_page = ($userdata['user_topics_per_page'] > $board_config['topics_per_page']) ? $board_config['topics_per_page'] : $userdata['user_topics_per_page'];

if ( !$board_config['warnings_enable'] )
{
	redirect(append_sid("index.$phpEx", true));
}

$action = get_vars('action', '', 'GET,POST');

if ( $action == 'hide' || $action == 'show')
{
	if ( $action == 'show' )
	{
		@setcookie($unique_cookie_name . '_warnings_view',on , (CR_TIME + 31536000), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
	}
	else
	{
		@setcookie($unique_cookie_name . '_warnings_view',off , (CR_TIME + 31536000), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
	}
	redirect(append_sid("warnings.$phpEx", true));
}

include($phpbb_root_path . 'includes/page_header.'.$phpEx);

function get_username($user_id)
{
	global $db;
	$sql = "SELECT username
		FROM " . USERS_TABLE . "
		WHERE user_id = $user_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not get username from users table', '', __LINE__, __FILE__, $sql);
	}
	$rowname = $db->sql_fetchrow($result);
	return $rowname['username'];
}

function get_user_id($username)
{
	global $db, $lang;
	$sql = "SELECT user_id, user_level
		FROM " . USERS_TABLE . "
		WHERE username = '" . str_replace("\'", "''", $username) . "'";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, $lang['wrong_user']);
	}

	$rowname = $db->sql_fetchrow($result);
	if ( $rowname['user_id'] < 1 )
	{
		message_die(GENERAL_ERROR, $lang['wrong_user']);
	}

	return $rowname;
}

$subtitle = '';
$admin = ($userdata['user_level'] == ADMIN) ? true : false;
$mod = ($userdata['user_level'] == MOD) ? true : false;
$can_edit = ($admin || ($mod && $board_config['mod_warnings'] && $board_config['mod_edit_warnings'])) ? true : false;
$can_add = ($admin || ($mod && $board_config['mod_warnings'])) ? true : false;
$can_view_modid = ((!$board_config['warnings_mods_public'] && ($admin || $mod)) || $board_config['warnings_mods_public']) ? true : false;

$template->set_filenames(array('warning_body' => 'warnings_body.tpl'));

$sql = "SELECT COUNT(*) AS total
	FROM " . WARNINGS_TABLE;
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not Query warnings table', '', __LINE__, __FILE__, $sql);
}

if ( $row = $db->sql_fetchrow($result) )
{
	if ( $board_config['expire_warnings'] )
	{
		$time_to_prune = CR_TIME - ($board_config['expire_warnings'] * 86400);

		$sql = "UPDATE " . WARNINGS_TABLE . "
			SET archive = 1
			WHERE date < $time_to_prune";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update warnings table', '', __LINE__, __FILE__, $sql);
		}
	}
}
$list_empty = ($row['total'] < 1) ? $lang['list_empty'] : '';

$value = get_vars('value', 0, 'POST', true);
$reason = str_replace("\'", "''", xhtmlspecialchars(get_vars('reason', '', 'POST')));

$id      = get_vars('id',      0,  'GET,POST', true);
$mode    = get_vars('mode',    '', 'GET,POST');
$userid  = get_vars('userid',   0, 'GET,POST', true);
$archive = get_vars('archive', '', 'GET,POST');
$modid   = get_vars('modid',    0, 'GET,POST', true);
$start   = get_vars('start',    0, 'GET,POST', true);

$sort_order = get_vars('order', '', 'POST,GET');
$sort_order = ($sort_order == 'ASC') ? 'ASC' : 'DESC';
$username   = trim(strip_tags(xhtmlspecialchars( get_vars('username', '', 'GET,POST') )));

$mode_types_text = array($lang['Sort_Joined'], $lang['Sort_Last_visit'], $lang['Sort_Username'], $lang['Location'], $lang['Total_posts'], $lang['Email'], $lang['Website']);
$mode_types = array('joindate', 'lastvisit', 'username', 'location', 'posts', 'email', 'website');

$select_sort_mode = '<select name="sort">';

for($i = 0; $i < count($mode_types_text); $i++)
{
	$selected = ($sort == $mode_types[$i]) ? ' selected="selected"' : '';
	$select_sort_mode .= '<option value="' . $mode_types[$i] . '"' . $selected . '>' . $mode_types_text[$i] . '</option>';
}
$select_sort_mode .= '</select>';

$select_sort_order = '<select name="order">';

if ( $sort_order == 'ASC' )
{
	$select_sort_order .= '<option value="ASC" selected="selected">' . $lang['Sort_Ascending'] . '</option><option value="DESC">' . $lang['Sort_Descending'] . '</option>';
}
else
{
	$select_sort_order .= '<option value="ASC">' . $lang['Sort_Ascending'] . '</option><option value="DESC" selected="selected">' . $lang['Sort_Descending'] . '</option>';
}
$select_sort_order .= '</select>';

$sort = get_vars('sort', '', 'POST,GET');
if($sort)
{
	switch( $sort )
	{
		case 'joindate':
			$order_by = "u.user_regdate $sort_order LIMIT $start, $user_topics_per_page";
			break;
		case 'lastvisit':
			$order_by = "u.user_session_time $sort_order LIMIT $start, $user_topics_per_page";
			break;
		case 'username':
			$order_by = "u.username $sort_order LIMIT $start, $user_topics_per_page";
			break;
		case 'location':
			$order_by = "u.user_from $sort_order LIMIT $start, $user_topics_per_page";
			break;
		case 'posts':
			$order_by = "u.user_posts $sort_order LIMIT $start, $user_topics_per_page";
			break;
		case 'email':
			$order_by = "u.user_email $sort_order LIMIT $start, $user_topics_per_page";
			break;
		case 'website':
			$order_by = "u.user_website $sort_order LIMIT $start, $user_topics_per_page";
			break;
		default:
			$order_by = "u.username $sort_order LIMIT $start, $user_topics_per_page";
			break;
	}
}
else
{
	$order_by = "u.username $sort_order LIMIT $start, $user_topics_per_page";
}

if ( !$mode )
{
	$sql = "SELECT COUNT(id) AS total
		FROM " . WARNINGS_TABLE . "
		WHERE archive = '1'
		LIMIT 1";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not count warnings', '', __LINE__, __FILE__, $sql);
	}

	$check = $db->sql_fetchrow($result);

	$template->assign_block_vars('default', array(
		'ARCHIVE' => ($check['total'] >= 1) ? '<a href="' . append_sid("warnings.$phpEx?mode=archive") . '" class="mainmenu">' . $lang['warning_archive'] . '</a>' : '')
	);

	$subtitle = $lang['list_users'];
	if ( $list_empty != '' )
	{
		$subtitle = $list_empty;
	}

	$sql = "SELECT w.*, u.username, u.user_gender, u.user_regdate, u.user_posts, u.user_from, u.user_email, u.user_website, u.user_jr, u.user_level, u.user_session_start, COUNT(w.id) as total, SUM(w.value) as value
		FROM (" . WARNINGS_TABLE . " w, " . USERS_TABLE . " u)
		WHERE w.userid = u.user_id
			AND archive = '0'
		GROUP by w.userid
		ORDER BY $order_by"; 

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not Query warnings table', '', __LINE__, __FILE__, $sql);
	}

	if ( $row = $db->sql_fetchrow($result) )
	{
		$i = 0;
		do
		{
			$view_username = $row['username'];
			$userid = $row['userid']; 

			$colored_username = $colored_username = color_username($row['user_level'], $row['user_jr'], $userid, $view_username);

			$view_username = $colored_username[0];
			$username_color = $colored_username[1];

			if ( $row['value'] >= $board_config['ban_warnings'] )
			{
				$row['value'] = '<b>' . $row['value'] . '</b><br /><span class="gensmall">' . $lang['banned'] . '</span>';
			}
			else
			{
				$row['value'] = ($row['value'] >= $board_config['write_warnings']) ? '<b>' . $row['value'] . '</b><br /><span class="gensmall">' . $lang['write_denied'] . '</span>' : '<b>' . $row['value'] . '</b>';
			}

			$gender_image = '';
			if ( $board_config['gender'] )
			{
				switch ($row['user_gender'])
				{
					case 1 :
						$gender_image = '&nbsp;<img src="' . $images['icon_minigender_male'] . '" alt="' . $lang['Gender']. ' : ' . $lang['Male'] . '" title="' . $lang['Male'] . '" border="0" />';
					break;
					case 2 :
						$gender_image = '&nbsp;<img src="' . $images['icon_minigender_female'] . '" alt="' . $lang['Gender']. ' : ' . $lang['Female'] . '" title="' . $lang['Female'] . '" border="0" />';
					break;
					default : $gender_image = '';
				}
			}
			$memberdays = max(1, round( ( CR_TIME - $row['user_regdate'] ) / 86400 ));

			if ( $row['user_posts'] != 0 )
			{
				$total_posts = get_db_stat('postcount');
				$percentage = ($total_posts) ? min(100, ($row['user_posts'] / $total_posts) * 100) : 0;
			}
			else
			{
				$percentage = 0; $total_posts = '';
			}

			$template->assign_block_vars('default_list', array(
				'ROW_CLASS' => (!($i % 2)) ? $theme['td_class1'] : $theme['td_class2'],
				'WARNINGS' => $row['total'],
				'VALUE' => $row['value'],
				'U_VIEWPROFILE' => '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $userid) . '" title="' . $lang['Profile'] . '"' . $username_color . ' class="name"><b>' . $view_username . '</b></a>' . $gender_image,
				'DETAIL' => '<a href="' . append_sid("warnings.$phpEx?mode=detail&amp;userid=$userid") . '" class="gensmall">' . $lang['l_whoisonline'] . '</a>',
				'LASTPOST' => ($row['user_session_start']) ? create_date($board_config['default_dateformat'], $row['user_session_start'], $board_config['board_timezone']) : $lang['Never'],
				'POSTS' => $row['user_posts'],
				'PERIOD' => sprintf($lang['Period'], $memberdays))
			);
			$i++;
		}
		while ( $row = $db->sql_fetchrow($result) );
	}
}

if ( $mode == 'detail' )
{
	$template->assign_block_vars('detail', array());

	$sql = "SELECT w.*, u.username, u2.username as modname, u2.user_level as mod_level, u2.user_jr as mod_jr
		FROM (" . WARNINGS_TABLE . " w, " . USERS_TABLE . " u, " . USERS_TABLE . " u2)
		WHERE w.userid = $userid
			AND w.archive = '0'
			AND w.userid = u.user_id
			AND w.modid = u2.user_id
		ORDER BY w.date DESC";

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query warnings table', '', __LINE__, __FILE__, $sql);
	}

	if ( $row = $db->sql_fetchrow($result) )
	{
		$i = 0;
		do
		{
			$view_username = $row['username'];
			$subtitle = $lang['view_warning_detail'] . ': <a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['userid']) . '" title="' . $lang['Profile'] . '" class="name">' . $view_username . '</a>'; 
			$id = $row['id'];
			$modname = $row['modname'];
			$mod_id = $row['modid'];

			$colored_username = $colored_username = color_username( $row['mod_level'],  $row['mod_jr'], $mod_id,  $row['modname']);

			$modname = $colored_username[0];
			$username_color = $colored_username[1];

			if ( $userdata['user_id'] == $row['modid'] && $can_add || $can_edit )
			{
				$delete_img = ($admin) ? '&nbsp;<a href="' . append_sid("warnings.$phpEx?mode=delete&amp;id=$id&amp;userid=$userid&amp;sid=" . $userdata['session_id']) . '"><img src="' . $images['icon_delpost'] . '" alt="' . $lang['Delete'] . '" title="' . $lang['Delete'] . '" border="0" /></a>' : '';
				$l_action = $lang['action'];
				$action_url = '<a href="' . append_sid("warnings.$phpEx?mode=edit&amp;id=$id") . '"><img src="' . $images['icon_edit'] . '" alt="' . $lang['edit_mini'] . '" title="' . $lang['edit_mini'] . '" border="0" /></a>' . $delete_img . '';
			}
			else
			{
				$l_action = '';
				$action_url = '';
			}

			if ( $row['warning_viewed'] == 0 && $userdata['user_id'] == $row['userid'] )
			{
				$sql = "UPDATE " . WARNINGS_TABLE . "
					SET warning_viewed = 1
					WHERE id = $id";
				if ( !($result = $db->sql_query($sql)) ) 
				{
					message_die(GENERAL_ERROR, 'Error in updating warnings table', '', __LINE__, __FILE__, $sql);
				}
			}

			$template->assign_block_vars('detail_list', array(
				'ROW_CLASS' => ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'],
				'VALUE' => $row['value'],
				'ACTION' => $action_url,
				'MODID' => ($can_view_modid) ? '<a href="' . append_sid("warnings.$phpEx?mode=view_modid&amp;modid=$mod_id") . '" title="' . $lang['view_warning_modid'] . ' ' . $row['modname'] . '" class="name"' . $username_color . '>' . $modname . '</a>' : '',
				'REASON' => prep_reason($row['reason']),
				'DATE' => create_date($board_config['default_dateformat'], $row['date'], $board_config['board_timezone']))
			);
			$i++;
		}
		while ( $row = $db->sql_fetchrow($result) );
	}
}

if ( $mode == 'edit' && ( $admin || $mod ))
{
	$sql = "SELECT * FROM " . WARNINGS_TABLE . "
		WHERE id = $id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query warnings table', '', __LINE__, __FILE__, $sql);
	}
	$rowedit = $db->sql_fetchrow($result);

	$template->assign_block_vars('edit', array(
		'USERID' => $rowedit['userid'],
		'ID' => $rowedit['id'],
		'VALUE' => $rowedit['value'],
		'REASON' => $rowedit['reason'])
	);
}

if ( $mode == 'archive' )
{
	$warnings_per_page = 50;

	$sql = "SELECT COUNT(id) AS total 
		FROM " . WARNINGS_TABLE . "
		WHERE archive = 1";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not list warnings', '', __LINE__, __FILE__, $sql_tot);
	}

	$row = $db->sql_fetchrow($result);

	$page_number = sprintf($lang['Page_of'], ( floor( $start / $warnings_per_page ) + 1 ), ceil( $row['total'] / $warnings_per_page ));
	$go_to_page = $lang['Goto_page'];
	if ( ceil( $row['total'] / $warnings_per_page ) == 1 )
	{
		$page_number = '';
		$go_to_page = '';
	}

	$sort = ($sort) ? $sort : 'username'; 
	generate_pagination("warnings.$phpEx?mode=archive&amp;sort=$sort&amp;order=$sort_order", $row['total'], $warnings_per_page, $start);

	$subtitle = $lang['warning_archive'];
	$template->assign_block_vars('archive', array());
	$order_by_archive = str_replace($user_topics_per_page, $warnings_per_page, $order_by);

	$sql = "SELECT w.*, u.username, u2.username as mod_username
		FROM " . USERS_TABLE . " u
		LEFT JOIN " . WARNINGS_TABLE . " w ON (w.archive = '1' AND w.userid = u.user_id)
		LEFT JOIN " . USERS_TABLE . " u2 ON (u2.user_id = w.modid)
		WHERE w.userid IS NOT NULL
		ORDER BY $order_by_archive";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query archive warnings', '', __LINE__, __FILE__, $sql);
	}

	if ( $row = $db->sql_fetchrow($result) )
	{
		$i = 0;
		do
		{
			$user_id = $row['userid'];
			$id = $row['id'];
			$l_action = $action = '';

			if ( $admin )
			{
				$l_action = $lang['action'];
				$action_url = '<a href="' . append_sid("warnings.$phpEx?mode=edit&amp;id=$id") . '"><img src="' . $images['icon_edit'] . '" alt="' . $lang['edit_mini'] . '" title="' . $lang['edit_mini'] . '" border="0" /></a>&nbsp;<a href="' . append_sid("warnings.$phpEx?mode=delete&amp;id=$id&amp;userid=$userid&amp;sid=" . $userdata['session_id'] . "") . '"><img src="' . $images['icon_delpost'] . '" alt="' . $lang['Delete'] . '" title="' . $lang['Delete'] . '" border="0" /></a>';
			}

			$template->assign_block_vars('archive_list', array(
				'ROW_CLASS' => (!($i % 2)) ? $theme['td_class1'] : $theme['td_class2'],
				'USERNAME' => $row['username'],
				'VALUE' => $row['value'],
				'ACTION' => $action_url,
				'MODID' => ($can_view_modid) ? '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['modid']) . '" class="name">' . $row['mod_username'] . '</a>' : '',
				'REASON' => prep_reason($row['reason']),
				'DATE' => create_date($board_config['default_dateformat'], $row['date'], $board_config['board_timezone']))
			);
			$i++;
		}
		while ( $row = $db->sql_fetchrow($result) );
	}
	if ( $userdata['user_level'] == ADMIN )
	{
		if ( isset($HTTP_GET_VARS['rem_all']) )
		{
			$sql = "DELETE FROM " . WARNINGS_TABLE . "
				WHERE archive = 1";
			if ( !($result = $db->sql_query($sql)) ) 
			{
				message_die(GENERAL_ERROR, 'Could not delete from warnings table', '', __LINE__, __FILE__, $sql);
			}
			else 
			{
				$message = '<meta http-equiv="refresh" content="' . $board_config['refresh'] . ';url=' . append_sid("warnings.$phpEx?mode=archive") . '">' . sprintf($lang['Click_view_deleted_warning'], '<a href="' . append_sid("warnings.$phpEx?mode=archive") . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);
			}
		}
		$template->assign_vars(array(
			'REM_ALL' => '<a href="' . append_sid("warnings.$phpEx?mode=archive&amp;rem_all=1") . '">' . $lang['Delete_all'] . '</a><br /><br />')
		);
	}
}

if ( $mode == 'update' )
{
	if (( $value < 1 ) || ( !$admin && $value > $board_config['mod_value_warning']	))
	{
		$message = $lang['wrong_value'] . '<br /><br />' . sprintf($lang['Click_to_back'], '<a href="' . append_sid("warnings.$phpEx?mode=edit&amp;id=$id") . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	}
	if ( $reason == '' )
	{
		$message = $lang['reason_empty'] . '<br /><br />' . sprintf($lang['Click_to_back'], '<a href="' . append_sid("warnings.$phpEx?mode=edit&amp;id=$id") . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	}
	if ( $value > 0 && $reason != '' )
	{
		$sql = "SELECT modid, userid
			FROM " . WARNINGS_TABLE . "
			WHERE id = $id";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR);
		}

		$rowname = $db->sql_fetchrow($result);

		if ( $rowname['modid'] == $userdata['user_id'] || $can_edit )
		{
			$sql = "UPDATE " . WARNINGS_TABLE . "
				SET value = $value, reason = '$reason'
				WHERE id = $id";
			if ( !($result = $db->sql_query($sql)) ) 
			{
				message_die(GENERAL_ERROR, 'Error in updating warnings table', '', __LINE__, __FILE__, $sql);
			}
			else 
			{
				include($phpbb_root_path . 'includes/functions_log.'.$phpEx);

				log_action('warning_edit', $userid, $userdata['user_id'], $userdata['username']);
				$message = '<meta http-equiv="refresh" content="' . $board_config['refresh'] . ';url=' . append_sid("warnings.$phpEx?mode=detail&amp;userid=$userid") . '">' . sprintf($lang['Click_view_edited_warning'], '<a href="' . append_sid("warnings.$phpEx?mode=detail&amp;userid=$userid") . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);
			}
		}
	}
}

if ( $mode == 'delete' && $admin )
{
	if ( !check_sid($HTTP_GET_VARS['sid']) )
	{
		message_die(GENERAL_ERROR, 'Invalid_session');
	}

	$sql = "SELECT userid
		FROM " . WARNINGS_TABLE . "
		WHERE id = " . intval($id) . "
		LIMIT 1";

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query warnings table', '', __LINE__, __FILE__, $sql);
	}

	$row = $db->sql_fetchrow($result);


	$sql = "DELETE FROM " . WARNINGS_TABLE . "
		WHERE id = " . intval($id) . "";
	if ( !($result = $db->sql_query($sql)) ) 
	{
		message_die(GENERAL_ERROR, 'Could not delete from warnings table', '', __LINE__, __FILE__, $sql);
	}
	else 
	{
		include($phpbb_root_path . 'includes/functions_log.'.$phpEx);
		log_action('warning_delete', $row['userid'], $userdata['user_id'], $userdata['username']);
		$message = '<meta http-equiv="refresh" content="' . $board_config['refresh'] . ';url=' . append_sid("warnings.$phpEx") . '">' . sprintf($lang['Click_view_deleted_warning'], '<a href="' . append_sid("warnings.$phpEx") . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	}
}

if ( $mode == 'add' && $can_add )
{
	if ( $userid && !$username )
	{
		$username = get_username($userid);
	}

	$template->assign_block_vars('add', array(
		'L_EXPLAIN' => $lang['add_warning_e'],
		'L_USERNAME' => $lang['Username'],
		'USERNAME' => $username)
	);

	if ( $mode == 'add' && $action == 'warning' )
	{
        $userid     = get_user_id($username);
        $user_level = $userid['user_level'];
        $userid     = $userid['user_id'];
        if($user_level == ADMIN && $userdata['user_level'] != ADMIN) {
            message_die(GENERAL_MESSAGE, $lang['no_warning']);
        }
		if ( $value < 1 || ( !$admin && $value > $board_config['mod_value_warning'] ))
		{
			$message = $lang['wrong_value'] . '<br /><br />' . sprintf($lang['Click_to_back'], '<a href="' . append_sid("warnings.$phpEx?mode=add&amp;userid=$userid") . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}
		if ( $reason == '' )
		{
			$message = $lang['reason_empty'] . '<br /><br />' . sprintf($lang['Click_to_back'], '<a href="' . append_sid("warnings.$phpEx?mode=add&amp;userid=$userid") . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}

		$sql = "INSERT INTO " . WARNINGS_TABLE . " (userid, modid, date, value, reason, warning_viewed)
			VALUES ($userid, " . $userdata['user_id'] . ", " . CR_TIME . ", $value, '$reason', 0)";
		if ( !($result = $db->sql_query($sql)) ) 
		{
			message_die(GENERAL_ERROR, 'Could not insert into warnings table', '', __LINE__, __FILE__, $sql);
		}

		$sql = "DELETE FROM " . SESSIONS_TABLE . "
			WHERE session_user_id = $userid";
		if ( !$db->sql_query($sql) )
		{
			message_die(CRITICAL_ERROR, 'Error removing sessions', '', __LINE__, __FILE__, $sql);
		}

		$message = '<meta http-equiv="refresh" content="' . $board_config['refresh'] . ';url=' . append_sid("warnings.$phpEx?mode=detail&amp;userid=$userid") . '">' . sprintf($lang['Click_view_added'], '<a href="' . append_sid("warnings.$phpEx?mode=detail&amp;userid=$userid") . '">', '</a>');

		message_die(GENERAL_MESSAGE, $message);
	}
}

if ( $mode == 'view_modid' && $can_view_modid )
{
	$template->assign_block_vars('view_modid_main', array());

	$subtitle = $lang['view_warning_modid'] . ': <a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $modid) . '" title="' . $lang['Profile'] . ' class="name">' . get_username($modid) . '</a>'; 

	$sql = "SELECT w.*, u.username
		FROM (" . WARNINGS_TABLE . " w, " . USERS_TABLE . " u)
		WHERE w.modid = $modid
			AND w.userid = u.user_id
		ORDER BY w.archive ASC, u.username, w.date DESC";

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query warnings table', '', __LINE__, __FILE__, $sql);
	}

	if ( $row = $db->sql_fetchrow($result) )
	{
		$i = 0;
		do
		{
			$id = $row['id'];
			$userid = $row['userid'];

			if ( $userdata['user_id'] == $row['modid'] && $can_add || $can_edit )
			{
				$delete_img = ($admin) ? '&nbsp;<a href="' . append_sid("warnings.$phpEx?mode=delete&amp;id=$id&amp;userid=$userid&amp;sid=" . $userdata['session_id']) . '"><img src="' . $images['icon_delpost'] . '" alt="' . $lang['Delete'] . '" title="' . $lang['Delete'] . '" border="0" /></a>' : '';
				$l_action = $lang['action'];
				$action_url = '<a href="' . append_sid("warnings.$phpEx?mode=edit&amp;id=$id") . '"><img src="' . $images['icon_edit'] . '" alt="' . $lang['edit_mini'] . '" title="' . $lang['edit_mini'] . '" border="0" /></a>' . $delete_img . '';
			}
			else
			{
				$l_action = '';
				$action_url = '';

			}
			$date = create_date($board_config['default_dateformat'], $row['date'], $board_config['board_timezone']);

			$template->assign_block_vars('view_modid', array(
				'ROW_CLASS' => (!($i % 2)) ? $theme['td_class1'] : $theme['td_class2'],
				'VALUE' => $row['value'],
				'ACTION' => $action_url,
				'MODID' => '<a href="' . append_sid("warnings.$phpEx?mode=detail&amp;userid=$userid") . '" title="' . $lang['detail'] . '" class="name">' . $row['username'] . '</a>',
				'REASON' => prep_reason($row['reason']),
				'DATE' => ($row['archive']) ? '' . $date . ' <i><b>arch.</b></i>' : $date)
			);
			$i++;
		}
		while ( $row = $db->sql_fetchrow($result) );
	}
}

if ( $HTTP_COOKIE_VARS[$unique_cookie_name . '_warnings_view'] != 'off' )
{
	$hide = '<a href="' . append_sid("warnings.$phpEx?action=hide") . '" class="mainmenu">' . $lang['hide_config'] . '</a>';

	$template->assign_block_vars('hide', array(
		'TITLE' => $lang['warnings_e'])
	);
}
else
{
	$hide = '<a href="' . append_sid("warnings.$phpEx?action=show") . '" class="mainmenu">' . $lang['show_config'] . '</a>';
}

if ( $subtitle )
{
	$subtitle .= '<br /><br />';
}

if ( $HTTP_GET_VARS['userid'] )
{
	$add_username = '&amp;userid=' . intval($HTTP_GET_VARS['userid']);
}

$template->assign_vars(array(
	'L_JOINED' => $lang['Joined'], 
	'L_LAST_VISIT' => $lang['Last_visit'],
	'L_POSTS' => $lang['Posts'], 
	'L_POST_TIME' => $lang['Last_Post'],
	'L_SELECT_SORT_METHOD' => $lang['Select_sort_method'],
	'L_EMAIL' => $lang['Email'],
	'L_WEBSITE' => $lang['Website'],
	'L_FROM' => $lang['Location'],
	'L_SORT' => $lang['Sort'],
	'L_SUBMIT' => $lang['Sort'],
	'L_ADD_WARNING' => $lang['Submit'],
	'L_USERNAME' => $lang['Username'],
	'L_MODID' => $lang['added_by'],
	'L_ACTION' => $l_action,
	'L_DATE' => $lang['Date'],
	'L_VALUE' => $lang['value'],
	'L_REASON' => $lang['Reason'],
	'L_EDIT' => $lang['edit_mini'],
	'L_WARNINGS' => $lang['how_many_warnings'],
	'L_PAGE' => $lang['warnings'],
	'L_PAGE_E' => $lang['warnings_e'],
	'L_DETAIL' => $lang['detail'],
	'L_LASTPOST' => $lang['Last_visit'],
	'L_POSTS' => $lang['Total_posts'],

	'HIDE' => $hide,
	'S_MODE_SELECT' => $select_sort_mode,
	'S_ORDER_SELECT' => $select_sort_order,
	'SUBTITLE' => $subtitle,
	'S_ACTION' => ($mode != 'archive') ? append_sid("warnings.$phpEx") : append_sid("warnings.$phpEx?mode=archive"),
	'S_ACTION_ADD' => append_sid("warnings.$phpEx?mode=add"),
	'U_INDEX_WARNING' => '<a href="' . append_sid("warnings.$phpEx") . '" class="nav">' . $lang['index_warning'] . '</a>',
	'U_ADD_WARNING' => ($can_add) ? '<a href="' . append_sid("warnings.$phpEx?mode=add$add_username") . '" class="nav">' . $lang['add_warning'] . '</a>' : '')
);

if ( !$mode )
{
	$sql = "SELECT id FROM " . WARNINGS_TABLE . "
		WHERE archive = '0'
		GROUP by userid"; 
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not Query warnings table', '', __LINE__, __FILE__, $sql);
	}
	if ( $row = $db->sql_fetchrow($result) )
	{
		$i = 0;
		do
		{
			$i++;
			$total_members = $i;
		}
		while ( $row = $db->sql_fetchrow($result) );
	}
	$sort = ($sort) ? $sort : 'username';
	generate_pagination(append_sid("warnings.$phpEx?sort=$sort&amp;order=$sort_order"), $total_members, $user_topics_per_page, $start). '&nbsp;';
}

$template->pparse('warning_body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>