<?php
/***************************************************************************
 *                                index.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   modification         : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   date modification    : ver. 1.12.4 2005/10/10 19:45
 *
 *   $Id: index.php,v 1.99.2.6 2005/10/30 15:17:13 acydburn Exp $
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
 ***************************************************************************/
define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/functions_selects.'.$phpEx); 

/*
// FORUMS HIERARCHY v2
$callback = function ($entity) {
	printf ('%s %s <br />', str_repeat('&nbsp; ', $entity->getNesting()), $entity->getName());
};

$tree = PhpBB\Core\Context::getService('tree');

// full nested tree
$tree->iterate($callback);

print '<hr />';

// category #1 nested tree
(new PhpBB\Model\CategoriesCollection)->get(1)->iterate($callback);
print '<hr />';

$forum = (new PhpBB\Model\ForumsCollection)->get(6);

// navigation
foreach($tree->trace($forum) as $el) {
	printf (' &bull; <a href="%s">%s</a>', $el->getUrl(), $el->getName());
}
print '<hr />';
print $forum->getLatestTopic()->getTitle();
print '<hr />';

$req = PhpBB\Core\Context::getService('request');
var_dump($req->headers->accept_encoding);
var_dump($req->post->c);
var_dump($req->get->c);
exit;
/**/
if ( $board_config['check_address'] )
{
	if ( !empty($HTTP_SERVER_VARS['SERVER_NAME']) || !empty($HTTP_ENV_VARS['SERVER_NAME']) )
	{
		$hostname = ( !empty($HTTP_SERVER_VARS['SERVER_NAME']) ) ? $HTTP_SERVER_VARS['SERVER_NAME'] : $HTTP_ENV_VARS['SERVER_NAME'];
	}
	else if ( !empty($HTTP_SERVER_VARS['HTTP_HOST']) || !empty($HTTP_ENV_VARS['HTTP_HOST']) )
	{
		$hostname = ( !empty($HTTP_SERVER_VARS['HTTP_HOST']) ) ? $HTTP_SERVER_VARS['HTTP_HOST'] : $HTTP_ENV_VARS['HTTP_HOST'];
	}
	else
	{
		$hostname = '';
	}
}

if ( $board_config['check_address'] && $hostname != $board_config['server_name'] && $hostname && $board_config['server_name'] && $board_config['script_path'] && !isset($HTTP_GET_VARS['redir']) )
{
	$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
	$server_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['server_name']));
	$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) : '';
	$script_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['script_path']));
	$script_name = ($script_name == '') ? $script_name : '/' . $script_name;

	$check_path_setup = @fopen($server_protocol . $server_name . $server_port . $script_name . '/extension.inc', 'r');
	if ( $check_path_setup )
	{
		@fclose($check_path_setup);
		$check_path_ok = true;
	}

	if ( $check_path_ok )
	{
		if ( @preg_match('/Microsoft|WebSTAR|Xitami/', getenv('SERVER_SOFTWARE')) )
		{
			header('Refresh: 0; URL=' . $server_protocol . $server_name . $server_port . $script_name. '/index.'.$phpEx . '?redir=1');
			echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><meta http-equiv="refresh" content="0; url=' . $server_protocol . $server_name . $server_port . $script_name. '/index.'.$phpEx . '?redir=1"><title>Redirect</title></head><body><div align="center">If your browser does not support meta redirection please click <a href="' . $server_protocol . $server_name . $server_port . $script_name. '/index.'.$phpEx . '?redir=1">HERE</a> to be redirected</div></body></html>';
			exit;
		}

		// Behave as per HTTP/1.1 spec for others
		header('Location: ' . $server_protocol . $server_name . $server_port . $script_name. '/index.'.$phpEx . '?redir=1');
		exit;
	}
}

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
//
// End session management
//

if ( $board_config['login_require'] && !$userdata['session_logged_in'] )
{
	$message = $lang['login_require'] . '<br /><br />' . sprintf($lang['login_require_register'], '<a href="' . append_sid("profile.$phpEx?mode=register") . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

if ( $board_config['ccount'] )
{
	$visit_counter = $board_config['visitors'];

	if (empty($HTTP_COOKIE_VARS[$unique_cookie_name . '_counter']))
	{
		@setcookie($unique_cookie_name . '_counter', '1', (CR_TIME + 3600), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);

		update_config('visitors', ($visit_counter + 1));
	}
}

if ( isset($HTTP_GET_VARS['ap']) && !$userdata['session_logged_in'] && !$HTTP_COOKIE_VARS[$unique_cookie_name . '_adp_lock'] )
{
	@setcookie($unique_cookie_name . '_adp', intval($HTTP_GET_VARS['ap']), (CR_TIME + 31536000), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
}

//Count unread posts
if ( $userdata['user_id'] != ANONYMOUS )
{
	include($phpbb_root_path . 'includes/read_history.'.$phpEx);
	$userdata = user_unread_posts();
	$count_unread_posts = unread_forums_posts('count');

	$template->assign_vars(array(
		'L_SEARCH_NEW' => $lang['Search_new_unread'],
		'L_SEARCH_LASTVISIT' => $lang['Search_new'],
		'U_SEARCH_LASTVISIT' => append_sid('search.'.$phpEx.'?search_id=lastvisit'),
		'U_SEARCH_NEW' => append_sid('search.'.$phpEx.'?search_id=newposts'),
		'COUNT_NEW_POSTS' => $count_unread_posts)
	);

	if ( $count_unread_posts )
	{
		$template->assign_block_vars('switch_unread', array());
	}
}
//end count unread posts

$viewcat = ( !empty($HTTP_GET_VARS[POST_CAT_URL]) ) ? intval($HTTP_GET_VARS[POST_CAT_URL]) : -1;
if ( $viewcat <= 0 )
{
	$viewcat = -1;
}
$viewcatkey = ($viewcat < 0) ? 'Root' : POST_CAT_URL . $viewcat;

if( isset($HTTP_GET_VARS['mark']) || isset($HTTP_POST_VARS['mark']) )
{
	$mark_read = ( isset($HTTP_POST_VARS['mark']) ) ? $HTTP_POST_VARS['mark'] : $HTTP_GET_VARS['mark'];
}
else
{
	$mark_read = '';
}

if ( isset($HTTP_POST_VARS['fpage_theme']) && $userdata['session_logged_in'] )
{
	$fpage_theme = intval($HTTP_POST_VARS['fpage_theme']);
	$fp_sql = "UPDATE " . USERS_TABLE . "
		SET user_style = '$fpage_theme'
		WHERE user_id = '" . $userdata['user_id'] . "'";
	if ( !($fp_result = $db->sql_query($fp_sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not update users table ' . $user_id . $fpage_theme, '', __LINE__, __FILE__, $sql);
	}
	redirect(append_sid("index.$phpEx", true));
}
else if ( isset($HTTP_POST_VARS['template']) )
{
	redirect(append_sid("index.$phpEx", true));
}

//
// Handle marking posts
//
if ( $mark_read == 'forums' )
{
	$page_title = $lang['Mark_all_forums'];
	if ( !check_sid($HTTP_GET_VARS['sid']) )
	{
		message_die(GENERAL_ERROR, 'Invalid_session');
	}
	if ( $viewcat < 0 )
	{
		if ( $userdata['session_logged_in'] )
		{
			$sql = "DELETE FROM " . READ_HIST_TABLE . "
				WHERE user_id = " . $userdata['user_id'];

			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Error in marking all as read', '', __LINE__, __FILE__, $sql);
			}
		}

		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="' . $board_config['refresh'] . ';url=' .append_sid("index.$phpEx") . '">')
		);
	}
	else
	{
		if ( $userdata['session_logged_in'] )
		{
			// get the list of object authorized
			$keys = array();
			$keys = get_auth_keys($viewcatkey);
			$post_ids = $forum_ids = '';

			// mark each forums
			for ($i=0; $i < count($keys['id']); $i++) if ($tree['type'][ $keys['idx'][$i] ] == POST_FORUM_URL)
			{
				$forum_ids .= (($forum_ids) ? ', ' : '') . $tree['id'][$keys['idx'][$i]];
			}

			if ( $forum_ids )
			{
				$sql = "DELETE FROM " . READ_HIST_TABLE . "
					WHERE user_id = " . $userdata['user_id'] . "
						AND forum_id IN($forum_ids)";
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Error in marking all as read', '', __LINE__, __FILE__, $sql);
				}
			}
		}

		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url='	.append_sid("index.$phpEx?" . POST_CAT_URL . "=$viewcat") . '">')
		);
	}

	$message = $lang['Forums_marked_read'] . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx?" . POST_CAT_URL . "=$viewcat") . '">', '</a> ');
	message_die(GENERAL_MESSAGE, $message);
}
//
// End handle marking posts
//

//
// Start output of page
//
$page_title = $lang['Forum_index'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'body' => 'index_body.tpl')
);

$sesid = $userdata['session_id'];

if ( !$userdata['session_logged_in'] && $board_config['cregist'] )
{
	$custom_field_box = '';
	$custom_fields_exists = (custom_fields('quick_regist', '')) ? true : false;

	if ( $custom_fields_exists )
	{
		$custom_fields = custom_fields('', 'quick_regist');
		for($i = 0; $i < count($custom_fields[0]); $i++)
		{
			$split_field = 'user_field_' . $custom_fields[0][$i];
			$desc = (isset($lang[$custom_fields[1][$i]])) ? $lang[$custom_fields[1][$i]] : $custom_fields[1][$i];
			$desc = str_replace(array('-#', '<br>'), array('',''), $desc);

			if ( $custom_fields[3][$i] )
			{
				$options = explode(',', $custom_fields[3][$i]);
				if ( count($options) > 0 )
				{
					if (stristr($options[count($options) -1 ],'.gif') || stristr($options[count($options) -1 ],'.jpg'))
					{
						$jumpbox = '<script language="javascript" type="text/javascript">
						<!--
							function update_rank(newimage){document.' . $split_field . '.src = \'' . $images['images'] . '/custom_fields/\'+newimage;}
						//-->
						</script>';
						$jumpbox .= '<select name="' . $split_field . '" onchange="update_rank(this.options[selectedIndex].value);"><option value="no_image.gif">' . $lang['None'] . '</option>';
						for ($j = 0; $j+1 <= count($options); $j++) 
						{
							$field_name = str_replace(array('_', '.gif', '.jpg'), array(' ', '', ''), $options[$j]);
							$cf_selected = ($options[$j] == $$split_field) ? 'selected="selected"' : '';
							$jumpbox .= '<option value="' . $options[$j] . '" ' . $cf_selected . '>' . $field_name . '</option>';
						}
						$jumpbox .= '</select>&nbsp;<img name="' . $split_field . '" src="' . $images['images'] . '/custom_fields/no_image.gif" border="0" alt="" align="top" />';
					}
					else
					{
						$jumpbox = '<select name="' . $split_field . '"><option value="" ' . $cf_selected . '>' . $lang['None'] . '</option>';
						for ($j = 0; $j+1 <= count($options); $j++) 
						{
							$cf_selected = ($options[$j] == $$split_field) ? 'selected="selected"' : '';
							$jumpbox .= '<option value="' . $options[$j] . '" ' . $cf_selected . '>' . $options[$j] . '</option>';
						}
						$jumpbox .= '</select>';
					}
					$custom_field_box .= $desc . ': ' . $jumpbox . '&nbsp;&nbsp;';
				}
			}
			else
			{
				$field_size = ($custom_fields[2][$i] < 20) ? ($custom_fields[2][$i] + 1) : '20';
				$custom_field_box .= $desc . ': <input type="text" name="' . $split_field . '" class="post" maxlength="' . $custom_fields[2][$i] . '" size="' . $field_size . '" onFocus="Active(this)" onBlur="NotActive(this)" />&nbsp;&nbsp;';
			}
		}
	}

	if ( $board_config['cregist_b'] )
	{
		$template->assign_block_vars('custom_registration_bottom', array());
	}
	else
	{
		$template->assign_block_vars('custom_registration', array());
	}

	$template->assign_vars(array(
		'L_REGIST_TITLE' => $lang['rname'],
		'L_CONFIRM_PASSWORD' => $lang['Confirm_password'],
		'L_EMAIL' => $lang['Email'],

		'S_HIDDEN_FIELDS' => '<input type="hidden" name="viewemail" value="1" checked="checked" /><input type="hidden" name="hideonline" value="0" checked="checked" /><input type="hidden" name="notifyreply" value="0" checked="checked" /><input type="hidden" name="notifypm" value="1" checked="checked" /><input type="hidden" name="popup_pm" value="1" checked="checked" /><input type="hidden" name="attachsig" value="1" checked="checked" /><input type="hidden" name="allowbbcode" value="1" checked="checked" /><input type="hidden" name="allowhtml" value="1" checked="checked" /><input type="hidden" name="allowsmilies" value="1" checked="checked" /><input type="hidden" name="dateformat" value="' . $board_config['default_dateformat'] . '" /><input type="hidden" name="mode" value="register" /><input type="hidden" name="agreed" value="true" /><input type="hidden" name="sid" value="' . $userdata['session_id'] . '"><input type="hidden" name="coppa" value="0" /><input type="hidden" name="przemo_hash" value="'.przemo_create_hash().'" />',
		'CUSTOM_FIELDS' => $custom_field_box,
		'S_PROFILE_ACTION' => append_sid("profile.$phpEx"))
	);

	if ( $board_config['gender'] && $board_config['require_gender'] )
	{
		if ( $board_config['cregist_b'] )
		{
			$template->assign_block_vars('custom_registration_bottom.gender_box', array());
		}
		else
		{
			$template->assign_block_vars('custom_registration.gender_box', array());
		}
		$template->assign_vars(array(
			'L_GENDER' => $lang['Gender'],
			'L_FEMALE' => $lang['Female'],
			'L_MALE' => $lang['Male'])
		);
	}

	if ( $board_config['validate'] && @extension_loaded('zlib') )
	{
		$key = '';
		$max_length_reg_key = 4;
		$chars = array('1','2','3','4','5','6','7','8','9');

		$count = count($chars) - 1;
		srand((double)microtime()*1000000);

		for($i = 0; $i < $max_length_reg_key; $i++)
		{
			$key .= $chars[rand(0, $count)];
		}

		$sql = "DELETE FROM " . ANTI_ROBOT_TABLE . "
			WHERE timestamp < '" . (CR_TIME - 3600) . "'
			OR session_id = '" . $userdata['session_id'] . "'";
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain registration information', '', __LINE__, __FILE__, $sql);
		}

		$sql = "INSERT INTO ". ANTI_ROBOT_TABLE . "
			VALUES ('" . $userdata['session_id'] . "', '" . $key . "', '" . CR_TIME . "')";
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not check registration information', '', __LINE__, __FILE__, $sql);
		}

		if ( $board_config['cregist_b'] )
		{
			$template->assign_block_vars('custom_registration_bottom.validation', array());
		}
		else
		{
			$template->assign_block_vars('custom_registration.validation', array());
		}
		
		$template->assign_vars(array(
			'VALIDATION_IMAGE' => append_sid("includes/confirm_register.$phpEx"),
			'L_CODE' => $lang['Code'])
		);
	}
}

$counter = ( $board_config['ccount'] ) ? '<br />' . $lang['visitors_txt'] . ' <b>' . $visit_counter . '</b> ' . $lang['visitors_txt2'] : '';
if ( $board_config['cstyles'] )
{
	$template->assign_block_vars('change_style', array(
		'L_CHANGE_STYLE' => $lang['Board_style'],
		'TEMPLATE_SELECT' => ($userdata['session_logged_in']) ? style_select($userdata['user_style'], 'fpage_theme') : style_select($board_config['default_style'], 'template'))
	);
}

$shoutbox_config = sql_cache('check', 'shoutbox_config');
if (empty($shoutbox_config))
{
	$shoutbox_config = array();
	$sql = "SELECT *
		FROM " . SHOUTBOX_CONFIG_TABLE;
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query shoutbox config information', '', __LINE__, __FILE__, $sql);
	}

	while ( $row = $db->sql_fetchrow($result) )
	{
		$shoutbox_config[$row['config_name']] = $row['config_value'];
	}
	sql_cache('write', 'shoutbox_config', $shoutbox_config);
}

if ( $shoutbox_config['shoutbox_on'] && $userdata['shoutbox'] )
{
	$shoutbox_config['banned_user_id_view'] = $GLOBALS['shoutbox_config']['banned_user_id_view'];
	if ( strstr($shoutbox_config['banned_user_id_view'], ',') )
	{
		$fids = explode(',', $shoutbox_config['banned_user_id_view']);
		while( list($foo, $id) = each($fids) )
		{
			$fid[] = intval( trim($id) );
		}
	}
	else
	{
		$fid[] = intval( trim($shoutbox_config['banned_user_id_view']) );
	}
	reset($fid);
	if ( $shoutbox_config['sb_group_sel'] != 'all')
	{
		$sql = 'SELECT ug.group_id
			FROM (' . USER_GROUP_TABLE . ' ug, ' . GROUPS_TABLE . ' g)
			WHERE ug.user_id = ' . $userdata['user_id'] . '
				AND g.group_id = ug.group_id
				AND g.group_single_user = 0
				AND ug.user_pending <> 1
			ORDER BY g.group_order ASC';
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_MESSAGE, 'Can not find username');
		}
		
		while ( $row2 = $db->sql_fetchrow($result) )
		{
			$grupy[] = $row2['group_id'];
		}

		$fid = explode(',', $shoutbox_config['sb_group_sel']);

		if ( sizeof($grupy) )
		{
			foreach ( $grupy as $k => $v )
			if ( in_array($v, $fid) ) 
			{
				$shoutbox_view_group = true;
				break;
			}
		}
	}
	else
	{
		$shoutbox_view_group = true;
	}
	if ( ($shoutbox_config['allow_users_view'] || $userdata['session_logged_in']) && ($shoutbox_config['allow_users'] || $shoutbox_config['allow_users_view'] || $userdata['user_level'] == ADMIN || $userdata['user_level'] == MOD || $shoutbox_view_group))
	{
		include($phpbb_root_path . 'includes/shoutbox.'.$phpEx);
	}
}

$template->assign_vars(array(
	'FORUM_IMG' => $images['forum'],
	'FORUM_NEW_IMG' => $images['forum_new'],
	'FORUM_LOCKED_IMG' => $images['forum_locked'],
	'FOLDER_NEW_IMG' => $images['folder_new'],
	'FOLDER_IMG' => $images['folder'],
	'FOLDER_LOCKED_IMG' => $images['folder_locked'],
	'L_FORUM' => $lang['Forum'],
	'L_TOPICS' => $lang['Topics'],
	'L_REPLIES' => $lang['Replies'],
	'L_VIEWS' => $lang['Views'],
	'L_POSTS' => $lang['Posts'],
	'L_LASTPOST' => $lang['Last_Post'],
	'L_NO_NEW_POSTS' => $lang['No_new_posts'],
	'L_NEW_POSTS' => $lang['New_posts'],
	'L_NO_NEW_POSTS_LOCKED' => $lang['No_new_posts_locked'],
	'L_NEW_POSTS_LOCKED' => $lang['New_posts_locked'],
	'L_MODERATOR' => $lang['Moderators'],
	'L_FORUM_LOCKED' => $lang['Forum_is_locked'],
	'L_MARK_FORUMS_READ' => $lang['Mark_all_forums'],
	'L_PREFERENCES' => $lang['Preferences'],
	'L_ONLINE_EXPLAIN' => $lang['Online_explain'],
	'U_SEARCH_UNANSWERED' => append_sid('search.'.$phpEx.'?search_id=unanswered'),
	'U_SEARCH_SELF' => append_sid('search.'.$phpEx.'?search_id=egosearch'),
	'COUNTER' => $counter,
	'T_SELECT_ACTION' => append_sid("index.$phpEx"),
	'CURRENT_TIME' => sprintf($lang['Current_time'], create_date($board_config['default_dateformat'], CR_TIME, $board_config['board_timezone'], true)),
	'LAST_VISIT_DATE' => sprintf($lang['You_last_visit'], ($userdata['session_logged_in']) ? create_date($board_config['default_dateformat'], $userdata['user_lastvisit'], $board_config['board_timezone']) : ''),
	'U_VIEWONLINE' => append_sid('viewonline.'.$phpEx),

	'U_PREFERENCES' => append_sid('customize.'.$phpEx),
	'U_MARK_READ' => "index.$phpEx?mark=forums&amp;" . POST_CAT_URL . "=$viewcat&amp;sid=" . $userdata['session_id'])
);

// Okay, let's build the index

$board_config['display_viewonline'] = (!$board_config['display_viewonline_over']) ? $userdata['user_display_viewonline'] : $board_config['display_viewonline'];

if ( ($board_config['display_viewonline'] == 2) || (($viewcat < 0) && ($board_config['display_viewonline'] == 1)) )
{
	$template->assign_block_vars('disable_viewonline', array());

	if ( $board_config['display_viewonline'] && (($board_config['display_viewonline'] == 2 && $viewcat > 0) || $viewcat < 0) )
	{
		if ( !(@function_exists('users_online')) )
		{
			include($phpbb_root_path . 'includes/functions_add.'.$phpEx);
		}

		$generate_online = users_online('index');
		$online_userlist = $generate_online[0];
		$l_online_users = $generate_online[1];

		$total_posts = get_db_stat('postcount');
		$total_users = get_db_stat('usercount');
		$newest_userdata = get_db_stat('newestuser');
		$newest_user = $newest_userdata['username'];
		$newest_uid = $newest_userdata['user_id'];
		$topiccount = get_db_stat('topiccount');

		if ( $total_posts == 0 )
		{
			$l_total_post_s = $lang['Posted_articles_zero_total'];
		}
		else if ( $total_posts == 1 )
		{
			$l_total_post_s = $lang['Posted_article_total'];
		}
		else
		{
			$l_total_post_s = $lang['Posted_articles_total'];
		}

		if ( $total_users == 0 )
		{
			$l_total_user_s = $lang['Registered_users_zero_total'];
		}
		else if ( $total_users == 1 )
		{
			$l_total_user_s = $lang['Registered_user_total'];
		}
		else
		{
			$l_total_user_s = $lang['Registered_users_total'];
		}

		if ( $board_config['u_o_t_d'] && $userdata['u_o_t_d'] )
		{			
			$time_to_show = ( CR_TIME - ( $board_config['last_visitors_time'] * 3600 ) );
			$last_visitors = ( isset($HTTP_GET_VARS['last_visitors']) ) ? xhtmlspecialchars($HTTP_GET_VARS['last_visitors']) : '';
			$sql_fields = ($userdata['user_level'] != ADMIN) ? ' AND user_allow_viewonline = 1' : '';	
			if($board_config['last_visitors_time_count'] && $last_visitors != 'all')
			{
				$sql = "SELECT count(*) AS total FROM " . USERS_TABLE . " WHERE user_id > 0 AND user_session_time >= $time_to_show" . $sql_fields;
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not obtain count user/day information', '', __LINE__, __FILE__, $sql);
				}
				$last_visitors_count_row = $db->sql_fetchrow($result);
				$last_visitors_count = 	$last_visitors_count_row['total'];
				$last_visitors_limit= ($last_visitors_count>$board_config['last_visitors_time_count'] && $last_visitors != 'all') ? ' LIMIT '.$board_config['last_visitors_time_count']: '';
			}
			else
			{
				$last_visitors_count = true;
				$last_visitors_limit = '';
			}

			$day_userlist = '';

			if($last_visitors_count)
			{
			$sql = "SELECT user_id, username, user_level, user_jr, user_session_time, user_allow_viewonline
				FROM " . USERS_TABLE . "
				WHERE user_id > 0
					AND user_session_time >= $time_to_show " . $sql_fields . "
				ORDER BY user_level = 1 DESC, user_jr DESC, user_level = 2 DESC, user_level = 0 DESC, username" . $last_visitors_limit;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain user/day information', '', __LINE__, __FILE__, $sql);
			}

			while( $row = $db->sql_fetchrow($result) )
			{

				$colored_username = color_username($row['user_level'], $row['user_jr'], $row['user_id'], $row['username']);
				$row['username'] = $colored_username[0];

				if ( $row['user_allow_viewonline'] )
				{
					$user_day_link = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '"' . $colored_username[1] .' class="gensmall">' . $row['username'] . '</a>';
				}
				else
				{
					$user_day_link = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '"' . $colored_username[1] .' class="gensmall"><i>' . $row['username'] . '</i></a>';
				}

				if ( $row['user_allow_viewonline'] || $userdata['user_level'] == ADMIN )
				{
					$day_userlist .= ( $day_userlist != '' ) ? ', ' . $user_day_link : $user_day_link;
				}
			}

			}
	
			if ( empty($day_userlist) )
			{
				$day_userlist = $lang['None'];
			}
			else if ($board_config['last_visitors_time_count'] && $last_visitors_count>$board_config['last_visitors_time_count'] && $last_visitors != 'all')
			{
				$day_userlist = $day_userlist.' - <a href="'.append_sid("index.$phpEx?last_visitors=all").'">'.$lang['last_visitors_more'].'</a>';
			}
		}

		$db->sql_freeresult($result);
	}

	groups_color_explain('disable_viewonline.staff_explain');

	if ( $board_config['staff_enable'] )
	{
		$template->assign_block_vars('disable_viewonline.staff', array());
		$template->assign_vars(array(
			'L_STAFF' => $lang['Staff'],
			'U_STAFF' => append_sid("staff.$phpEx"))
		);
	}

	if ( $board_config['warnings_enable'] )
	{
		$template->assign_block_vars('disable_viewonline.warnings', array());
		$template->assign_vars(array(
			'U_WARNINGS' => '<a href="' . append_sid("warnings.$phpEx") . '">' . $lang['Warnings'] . '</a>',)
		);
	}

	$template->assign_vars(array(
		'TOTAL_POSTS' => sprintf($l_total_post_s, $total_posts) . ', ' . $lang['topics'] . ' <b>' . get_db_stat('topiccount') . '</b>',
		'TOTAL_USERS' => sprintf($l_total_user_s, $total_users),
		'NEWEST_USER' => sprintf($lang['Newest_user'], '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$newest_uid") . '" class="gensmall">', $newest_user, '</a>'),
		'USERS_OF_THE_DAY_LIST' => ($board_config['u_o_t_d'] && $userdata['u_o_t_d']) ? sprintf($lang['Day_users'], $board_config['last_visitors_time']) . ' ' . $day_userlist : '',
		'LOGGED_IN_USER_LIST' => $online_userlist,
		'TOTAL_USERS_ONLINE' => $l_online_users,
		'RECORD_USERS' => sprintf($lang['Record_online_users'], $board_config['record_online_users'], create_date($board_config['default_dateformat'], $board_config['record_online_date'], $board_config['board_timezone'])),
		'WHOONLINE_IMG' => $images['icon_online'],
		'L_WHO_IS_ONLINE' => $lang['Who_is_Online'],
		'L_VIEW_DETAILED' => $lang['l_whoisonline'])
	);
}

// display the index
include($phpbb_root_path . 'includes/functions_hierarchy.'.$phpEx);
$display = display_index($viewcatkey);

if (!$display)
{
	message_die(GENERAL_MESSAGE, $lang['No_forums']);
}

if ($board_config['board_msg_enable'] == '1')
{
	$template->assign_block_vars('switch_enable_board_msg_index', array()); 
}

//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>