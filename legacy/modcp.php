<?php
/***************************************************************************
 *                                 modcp.php
 *                            -------------------
 *   begin                : July 4, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   modification         : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   date modification    : ver. 1.12.5 2005/10/10 02:49
 *
 *   $Id: modcp.php,v 1.71.2.27 2005/09/14 18:14:30 acydburn Exp $
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

/**
 * Moderator Control Panel
 *
 * From this 'Control Panel' the moderator of a forum will be able to do
 * mass topic operations (locking/unlocking/moving/deleteing), and it will
 * provide an interface to do quick locking/unlocking/moving/deleting of
 * topics via the moderator operations buttons on all of the viewtopic pages.
 */

define('IN_PHPBB', true);
define('IN_MODCP', true);
define('ATTACH', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'includes/functions_add.'.$phpEx);
include($phpbb_root_path . 'includes/functions_admin.'.$phpEx);
include($phpbb_root_path . 'includes/functions_log.'.$phpEx);
include($phpbb_root_path . 'includes/functions_remove.'.$phpEx);

//
// Obtain initial var settings
//
if ( isset($HTTP_GET_VARS[POST_FORUM_URL]) || isset($HTTP_POST_VARS[POST_FORUM_URL]) )
{
	$forum_id = (isset($HTTP_POST_VARS[POST_FORUM_URL])) ? intval($HTTP_POST_VARS[POST_FORUM_URL]) : intval($HTTP_GET_VARS[POST_FORUM_URL]);
}
else
{
	$forum_id = '';
}

if ( isset($HTTP_GET_VARS[POST_POST_URL]) || isset($HTTP_POST_VARS[POST_POST_URL]) )
{
	$post_id = (isset($HTTP_POST_VARS[POST_POST_URL])) ? intval($HTTP_POST_VARS[POST_POST_URL]) : intval($HTTP_GET_VARS[POST_POST_URL]);
}
else
{
	$post_id = '';
}

if ( isset($HTTP_GET_VARS[POST_TOPIC_URL]) || isset($HTTP_POST_VARS[POST_TOPIC_URL]) )
{
	$topic_id = (isset($HTTP_POST_VARS[POST_TOPIC_URL])) ? intval($HTTP_POST_VARS[POST_TOPIC_URL]) : intval($HTTP_GET_VARS[POST_TOPIC_URL]);
}
else
{
	$topic_id = '';
}

$confirm = ( $HTTP_POST_VARS['confirm'] ) ? TRUE : 0;

if (isset($HTTP_GET_VARS['selected_id']) || isset($HTTP_POST_VARS['selected_id']))
{
	$selected_id = isset($HTTP_POST_VARS['selected_id']) ? $HTTP_POST_VARS['selected_id'] : $HTTP_GET_VARS['selected_id'];
	$type	= substr($selected_id, 0, 1);
	$id		= intval(substr($selected_id, 1));
	if ( $type == POST_FORUM_URL )
	{
		$forum_id = $id;
	}
	else if ( ($type == POST_CAT_URL) || ($selected_id == 'Root') )
	{
		$parm = ($id != 0) ? "?" . POST_CAT_URL . "=$id" : '';
		redirect(append_sid("./index.$phpEx" . $parm));
		exit;
	}
}

//
// Continue var definitions
//
$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;
if ( isset($HTTP_POST_VARS['start']) )
{
	$start = intval($HTTP_POST_VARS['start']);
}

$delete = ( isset($HTTP_POST_VARS['delete']) ) ? TRUE : FALSE;
$move = ( isset($HTTP_POST_VARS['move']) ) ? TRUE : FALSE;
$lock = ( isset($HTTP_POST_VARS['lock']) ) ? TRUE : FALSE;
$unlock = ( isset($HTTP_POST_VARS['unlock']) ) ? TRUE : FALSE;
$mergetopic = ( isset($HTTP_POST_VARS['mergetopic']) ) ? TRUE : FALSE;
$mergepost = ( isset($HTTP_POST_VARS['mergepost']) ) ? TRUE : FALSE;
$sticky = ( isset($HTTP_POST_VARS['sticky']) ) ? TRUE : FALSE;
$announce = ( isset($HTTP_POST_VARS['announce']) ) ? TRUE : FALSE;
$normalise = ( isset($HTTP_POST_VARS['normalise']) ) ? TRUE : FALSE;

if ( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
	$mode = xhtmlspecialchars($mode);
}
else
{
	if ( $delete )
	{
		$mode = 'delete';
	}
	else if ( $move )
	{
		$mode = 'move';
	}
	else if ( $mergetopic )
	{
		$mode = 'mergetopic';
	}
	else if ( $mergepost )
	{
		$mode = 'mergepost';
	}
	else if ( $lock )
	{
		$mode = 'lock';
	}
	else if ( $unlock )
	{
		$mode = 'unlock';
	}
	else if ( $sticky )
	{
		$mode = 'sticky';
	}
	else if ( $announce )
	{
		$mode = 'announce';
	}
	else if ( $normalise )
	{
		$mode = 'normalise';
	}
	else
	{
		$mode = '';
	}
}

// session id check
if (!empty($HTTP_POST_VARS['sid']) || !empty($HTTP_GET_VARS['sid']))
{
	$sid = (!empty($HTTP_POST_VARS['sid'])) ? $HTTP_POST_VARS['sid'] : $HTTP_GET_VARS['sid'];
}
else
{
	$sid = '';
}

//
// Obtain relevant data
//
if ( !empty($topic_id) )
{
	$sql = "SELECT f.forum_id, f.forum_name, f.forum_topics, f.forum_sort, locked_bottom, t.topic_first_post_id
		FROM (" . TOPICS_TABLE . " t, " . FORUMS_TABLE . " f)
		WHERE t.topic_id = " . $topic_id . "
			AND f.forum_id = t.forum_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_MESSAGE, 'No_such_post');
	}
	$topic_row = $db->sql_fetchrow($result);

	if (!$topic_row)
	{
		message_die(GENERAL_MESSAGE, 'No_such_post');
	}

	$forum_topics = ( $topic_row['forum_topics'] == 0 ) ? 1 : $topic_row['forum_topics'];
	$forum_id = $topic_row['forum_id'];
	$topic_first_post_id = $topic_row['topic_first_post_id'];
	$forum_name = get_object_lang(POST_FORUM_URL . $topic_row['forum_id'], 'name');
}
else if ( !empty($forum_id) )
{
	$sql = "SELECT forum_name, forum_topics, forum_sort, locked_bottom
		FROM " . FORUMS_TABLE . "
		WHERE forum_id = " . $forum_id;
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_MESSAGE, 'Forum_not_exist');
	}
	$topic_row = $db->sql_fetchrow($result);

	if (!$topic_row)
	{
		message_die(GENERAL_MESSAGE, 'Forum_not_exist');
	}

	$forum_topics = ( $topic_row['forum_topics'] == 0 ) ? 1 : $topic_row['forum_topics'];
	$forum_name = get_object_lang(POST_FORUM_URL . $topic_row['forum_id'], 'name');
}
else
{
	message_die(GENERAL_MESSAGE, 'Forum_not_exist');
}

$forum_sort = $topic_row['forum_sort'];
$locked_bottom = $topic_row['locked_bottom'];

if ( isset($HTTP_GET_VARS['new_forum_id']) || isset($HTTP_POST_VARS['new_forum_id']) )
{
	$sort_new_forum = (isset($HTTP_GET_VARS['new_forum_id'])) ? $HTTP_GET_VARS['new_forum_id'] : $HTTP_POST_VARS['new_forum_id'];
}
else if ( isset($HTTP_GET_VARS['new_forum']) || isset($HTTP_POST_VARS['new_forum']) )
{
	$sort_new_forum = (isset($HTTP_GET_VARS['new_forum'])) ? $HTTP_GET_VARS['new_forum'] : $HTTP_POST_VARS['new_forum'];
}
else
{
	$sort_new_forum = '';
}

$merge_type_all = ( isset($HTTP_POST_VARS['merge_type_all']) ) ? $HTTP_POST_VARS['merge_type_all'] : $HTTP_GET_VARS['merge_type_all'];
$merge_type_beyond = ( isset($HTTP_POST_VARS['merge_type_beyond']) ) ? $HTTP_POST_VARS['merge_type_beyond'] : $HTTP_GET_VARS['merge_type_beyond'];
$merge2 = ( isset($HTTP_POST_VARS['merge2']) ) ? $HTTP_POST_VARS['merge2'] : $HTTP_GET_VARS['merge2'];

if ( $sort_new_forum )
{
	$sort_new_forum = str_replace(POST_FORUM_URL, '', $sort_new_forum);

	$sql = "SELECT forum_sort, locked_bottom
		FROM " . FORUMS_TABLE . "
		WHERE forum_id = " . intval($sort_new_forum);
	$result = $db->sql_query($sql);
	$new_topic_row = $db->sql_fetchrow($result);

	$forum_sort = $new_topic_row['forum_sort'];
	$locked_bottom = $new_topic_row['locked_bottom'];
}

switch( $forum_sort )
{
	case 'SORT_FPDATE':
		$topic_order = 'p.post_time DESC';
		break;
	case 'SORT_TTIME':
		$topic_order = 't.topic_time DESC';
		break;
	case 'SORT_ALPHA':
		$topic_order = 't.topic_title ASC, t.topic_time DESC';
		break;
	case 'SORT_AUTHOR':
		$topic_order = 'u.user_id < 0, u.username ASC';
		break;
	default:
		$topic_order = 'p.post_time DESC';
		break;
}

$sotr_methods = ($locked_bottom) ? "ORDER BY t.topic_type DESC, t.topic_status ASC, $topic_order" : "ORDER BY t.topic_type DESC, $topic_order";

//
// Start session management
//
$userdata = session_pagestart($user_ip, $forum_id);
init_userprefs($userdata);
//
// End session management
//

$user_topics_per_page = ($userdata['user_topics_per_page'] > $board_config['topics_per_page']) ? $board_config['topics_per_page'] : $userdata['user_topics_per_page'];
$user_posts_per_page = ($userdata['user_posts_per_page'] > $board_config['posts_per_page']) ? $board_config['posts_per_page'] : $userdata['user_posts_per_page'];

if ( !check_sid($sid) )
{
	message_die(GENERAL_ERROR, 'Invalid_session');
}

if ( !(defined('LANG_MODCP')) )
{
	include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_modcp.' . $phpEx);
}

//
// Check if user did or did not confirm
// If they did not, forward them to the last page they were on
//
if ( isset($HTTP_POST_VARS['cancel']) )
{
	if ( $topic_id )
	{
		$redirect = "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id";
	}
	else if ( $forum_id )
	{
		$redirect = "viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id";
	}
	else
	{
		$redirect = "index.$phpEx";
	}

	redirect(append_sid($redirect, true));
}

//
// Start auth check
//
$is_auth = $tree['auth'][POST_FORUM_URL . $forum_id];

if ( !$is_auth['auth_mod'] )
{
	message_die(GENERAL_MESSAGE, $lang['Not_Moderator'], $lang['Not_Authorised']);
}
//
// End Auth Check
//

if ($mode == 'ip' && $userdata['user_level'] != ADMIN && !$board_config['ipview'])
{
	$mode = '';
}

if ( stristr($mode, 'expire') && !$confirm )
{
	confirm($lang['confirm_expire_topic'], append_sid("modcp.$phpEx?mode=$mode&amp;" . POST_TOPIC_URL . "=" . $topic_id), $sid);
}

//
// Do major work ...
//
switch( $mode )
{
	case 'delete':
		if ( $userdata['user_level'] != ADMIN && $board_config['not_edit_admin'] )
		{
			$topics_sql = ( isset($HTTP_POST_VARS['topic_id_list']) ) ? implode(',', $HTTP_POST_VARS['topic_id_list']) : $topic_id;
			$sql = "SELECT t.topic_id
					FROM (" . TOPICS_TABLE . " t, " . USERS_TABLE . " u)
					WHERE u.user_id = t.topic_poster
						AND u.user_level = " . ADMIN . "
						AND t.topic_id IN ($topics_sql)";
			if ( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not retrieve topics list', '', __LINE__, __FILE__, $sql);
			}

			if ( $db->sql_numrows($result) > 0 )
			{
				message_die(GENERAL_MESSAGE, $lang['Not_auth_edit_delete_admin']);
			}
		}

		if (!$is_auth['auth_delete'])
		{
			message_die(GENERAL_MESSAGE, sprintf($lang['Sorry_auth_delete'], $is_auth['auth_delete_type']));
		}

		$page_title = $lang['Mod_CP'];
		include($phpbb_root_path . 'includes/page_header.'.$phpEx);

		if ( $confirm )
		{
			$topics = ( isset($HTTP_POST_VARS['topic_id_list']) ) ? $HTTP_POST_VARS['topic_id_list'] : array($topic_id);

			$topic_id_sql = '';
			for($i = 0; $i < count($topics); $i++)
			{
				$topic_id_sql .= ( ( $topic_id_sql != '' ) ? ', ' : '' ) . intval($topics[$i]);
				log_action('delete', intval($topics[$i]), $userdata['user_id'], $userdata['username']);
			}

			if ( count($topics) == 1 && $topics[0] && $board_config['del_notify_enable'] && (isset($HTTP_POST_VARS['reason']) || isset($HTTP_POST_VARS['reasons'])) && (isset($HTTP_GET_VARS[POST_TOPIC_URL]) || isset($HTTP_POST_VARS[POST_TOPIC_URL])) && (!($HTTP_POST_VARS['no_notify'] && $board_config['del_notify_choice'])))
			{
				$reason = (!empty($HTTP_POST_VARS['reason'])) ? $HTTP_POST_VARS['reason'] : $HTTP_POST_VARS['reasons'];	

				notify_delete(0, intval($topics[0]), $userdata['user_id'], intval($HTTP_POST_VARS['notify_user']), trim($reason), true);
			}

			delete_topic($topic_id_sql, $forum_id, true);

			if ( !empty($topic_id) )
			{
				$redirect_page = "viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'];
				$l_redirect = sprintf($lang['Click_return_forum'], '<a href="' . $redirect_page . '">', '</a>');
			}
			else
			{
				$redirect_page = "modcp.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'];
				$l_redirect = sprintf($lang['Click_return_modcp'], '<a href="' . $redirect_page . '">', '</a>');
			}

			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="' . $board_config['refresh'] . ';url=' . $redirect_page . '">')
			);

			message_die(GENERAL_MESSAGE, $lang['Topics_Removed'] . '<br /><br />' . $l_redirect);
		}
		else
		{
			// Not confirmed, show confirmation message
			if ( empty($HTTP_POST_VARS['topic_id_list']) && empty($topic_id) )
			{
				message_die(GENERAL_MESSAGE, $lang['None_selected']);
			}

			$hidden_fields = '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" /><input type="hidden" name="mode" value="' . $mode . '" /><input type="hidden" name="' . POST_FORUM_URL . '" value="' . $forum_id . '" />';

			if ( isset($HTTP_POST_VARS['topic_id_list']) )
			{
				$topics = $HTTP_POST_VARS['topic_id_list'];
				for($i = 0; $i < count($topics); $i++)
				{
					$hidden_fields .= '<input type="hidden" name="topic_id_list[]" value="' . intval($topics[$i]) . '" />';
				}
			}
			else
			{
				$hidden_fields .= '<input type="hidden" name="' . POST_TOPIC_URL . '" value="' . $topic_id . '" />';
			}

			if ( !isset($HTTP_POST_VARS['topic_id_list']) )
			{
				$sql = "SELECT forum_id
					FROM " . FORUMS_TABLE . "
					WHERE forum_trash = 1
						LIMIT 1";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not get username from users table', '', __LINE__, __FILE__, $sql);
				}
				if ( $row = $db->sql_fetchrow($result) )
				{
					if ( $row['forum_id'] != $forum_id )
					{
						$template->assign_block_vars('forum_trash', array(
							'L_TRASH' => $lang['Delete_to_trash'],
							'SESSION_ID' => $userdata['session_id'],
							'FORUM_TRASH_ID' => POST_FORUM_URL . $row['forum_id'],
							'OLD_FORUM_ID' => $forum_id,
							'TOPIC_ID' => $topic_id)
						);
					}
				}

				$sql = "SELECT topic_poster
					FROM " . TOPICS_TABLE . "
					WHERE topic_id = $topic_id";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not get username from users table', '', __LINE__, __FILE__, $sql);
				}
				$rowtopic = $db->sql_fetchrow($result);

				if ( $rowtopic['topic_poster'] != $userdata['user_id'] && $rowtopic['topic_poster'] != ANONYMOUS && $board_config['del_notify_enable'] )
				{
					$reason_jumpbox = '<select name="reasons">';
					for($i = 0; $i < count($lang['del_notify_reasons']); $i++)
					{
						$reason_jumpbox .= '<option value="' . $i . '" ' . (($i == 0) ?'selected="selected"' : '') . '>' . $lang['del_notify_reasons'][$i] . '</option>';
					}
					$reason_jumpbox .= '</select>';

					$hidden_fields .= '<input type="hidden" name="notify_user" value="' . $rowtopic['topic_poster'] . '" />';

					$del_choice = ($board_config['del_notify_choice']) ? '<input type="checkbox" name="no_notify"> ' . $lang['del_notify_choice'] . '<br /><br />' : '';

					$sql = "SELECT username
						FROM " . USERS_TABLE . "
						WHERE user_id = " . $rowtopic['topic_poster'];
					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not get username from users table', '', __LINE__, __FILE__, $sql);
					}
					$rowname = $db->sql_fetchrow($result);

					$template->set_filenames(array(
						'confirm' => 'confirm_body_notify.tpl')
					);

					$template->assign_vars(array(
						'MESSAGE_TITLE' => sprintf($lang['del_notify'], $rowname['username']),
						'REASON_JUMPBOX' => $reason_jumpbox,

						'L_DEL_NOTIFY_REASON' => $lang['del_notify_reason'],
						'L_DEL_NOTIFY_REASON_E' => $lang['del_notify_reason_e'],
						'L_DEL_NOTIFY_REASON2' => $lang['del_notify_reason2'],
						'L_DEL_NOTIFY_REASON2_E' => $lang['del_notify_reason2_e'],
						'L_DEL_NOTIFY' => $lang['del_notify'],
						'L_CONFIRM_DELETE' => $del_choice . $lang['Confirm_delete_topic'],
						'L_YES' => $lang['Yes'],
						'L_NO' => $lang['No'],

						'S_CONFIRM_ACTION' => append_sid("modcp.$phpEx"),
						'S_HIDDEN_FIELDS' => $hidden_fields)
					);
				} else $no_notify = true;
			} else $no_notify = true;

			if ( $no_notify )
			{
				// Set template files
				$template->set_filenames(array(
					'confirm' => 'confirm_body.tpl')
				);

				$template->assign_vars(array(
					'MESSAGE_TITLE' => $lang['Confirm'],
					'MESSAGE_TEXT' => $lang['Confirm_delete_topic'],

					'L_YES' => $lang['Yes'],
					'L_NO' => $lang['No'],
					'L_TRASH' => $lang['Delete_to_trash'],

					'S_CONFIRM_ACTION' => append_sid("modcp.$phpEx"),
					'S_HIDDEN_FIELDS' => $hidden_fields)
				);
			}

			$template->pparse('confirm');

			include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
		}
		break;

	case 'move':
		$page_title = $lang['Mod_CP'];
		include($phpbb_root_path . 'includes/page_header.'.$phpEx);

		$do_notify = false;
		if ( $topic_id && $board_config['del_notify_enable'] )
		{
			$do_notify = false;
			$sql = "SELECT t.topic_poster, t.topic_title, f.forum_name, u.username, u.user_email, u.user_lang
				FROM (" . TOPICS_TABLE . " t, " . FORUMS_TABLE . " f, " . USERS_TABLE . " u)
				WHERE t.topic_id = $topic_id
					AND t.forum_id = f.forum_id
					AND t.topic_poster = u.user_id";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get notify data', '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			$notify_username = $row['username'];
			$notify_user = $row['topic_poster'];
			$notify_user_email = $row['user_email'];
			$notify_user_lang = $row['user_lang'];
			$notify_topic_title = $row['topic_title'];
			$notify_forum_name = $row['forum_name'];

			if ( $notify_user != ANONYMOUS && $notify_user != $userdata['user_id'] && $notify_user && $notify_user_email && $notify_user_lang )
			{
				$do_notify = true;
			}
		}

		if ( $confirm )
		{
			if ( empty($HTTP_POST_VARS['topic_id_list']) && empty($topic_id) )
			{
				message_die(GENERAL_MESSAGE, $lang['None_selected']);
			}

			$fid = $HTTP_POST_VARS['new_forum'];
			if ( $fid == 'Root' )
			{
				$type = POST_CAT_URL;
				$new_forum_id = 0;
			}
			else
			{
				$type = substr($fid, 0, 1);
				$new_forum_id = ($type == POST_FORUM_URL) ? intval(substr($fid, 1)) : 0;
			}
			if ( $new_forum_id <= 0 )
			{
				message_die(GENERAL_MESSAGE, $lang['Forum_not_exist']);
			}
			$old_forum_id = $forum_id;

			$sql = 'SELECT forum_id FROM ' . FORUMS_TABLE . '
				WHERE forum_id = ' . $new_forum_id;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not select from forums table', '', __LINE__, __FILE__, $sql);
			}
			
			if (!$db->sql_fetchrow($result))
			{
				message_die(GENERAL_MESSAGE, 'New forum does not exist');
			}

			$db->sql_freeresult($result);

			if ( $new_forum_id != $old_forum_id )
			{
				$topics = ( isset($HTTP_POST_VARS['topic_id_list']) ) ? $HTTP_POST_VARS['topic_id_list'] : array($topic_id);

				$topic_list = '';
				for($i = 0; $i < count($topics); $i++)
				{
					$topic_list .= ( ( $topic_list != '' ) ? ', ' : '' ) . intval($topics[$i]);
				}

				$sql = "SELECT * 
					FROM " . TOPICS_TABLE . " 
					WHERE topic_id IN ($topic_list)
						AND forum_id = $old_forum_id
						AND topic_status <> " . TOPIC_MOVED;
				if ( !($result = $db->sql_query($sql, BEGIN_TRANSACTION)) )
				{
					message_die(GENERAL_ERROR, 'Could not select from topic table', '', __LINE__, __FILE__, $sql);
				}

				$row = $db->sql_fetchrowset($result);
				$db->sql_freeresult($result);

				$moved_topics_ids = array();

				for($i = 0; $i < count($row); $i++)
				{
					$topic_id = $row[$i]['topic_id'];
					
					if ( isset($HTTP_POST_VARS['move_leave_shadow']) )
					{
						// Insert topic in the old forum that indicates that the forum has moved.
						$sql = "INSERT INTO " . TOPICS_TABLE . " (forum_id, topic_title, topic_poster, topic_time, topic_status, topic_type, topic_vote, topic_views, topic_replies, topic_first_post_id, topic_last_post_id, topic_moved_id)
							VALUES ($old_forum_id, '" . addslashes(str_replace("\'", "''", $row[$i]['topic_title'])) . "', '" . str_replace("\'", "''", $row[$i]['topic_poster']) . "', " . $row[$i]['topic_time'] . ", " . TOPIC_MOVED . ", " . POST_NORMAL . ", " . $row[$i]['topic_vote'] . ", " . $row[$i]['topic_views'] . ", " . $row[$i]['topic_replies'] . ", " . $row[$i]['topic_first_post_id'] . ", " . $row[$i]['topic_last_post_id'] . ", $topic_id)";
						if ( !$db->sql_query($sql) )
						{
							message_die(GENERAL_ERROR, 'Could not insert shadow topic', '', __LINE__, __FILE__, $sql);
						}
					}
					$moved_topics_ids[] = $topic_id;
					log_action('move', $topic_id, $userdata['user_id'], $userdata['username']);
					set_action($topic_id, MOVED);
				}
				if ( count($moved_topics_ids) )
				{
					$moved_topics_ids_imp = implode(', ', $moved_topics_ids);
					$sql = "UPDATE " . TOPICS_TABLE . "
						SET forum_id = $new_forum_id
						WHERE topic_id IN($moved_topics_ids_imp)";
					if ( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, 'Could not update old topic', '', __LINE__, __FILE__, $sql);
					}

					$sql = "UPDATE " . POSTS_TABLE . " 
						SET forum_id = $new_forum_id 
						WHERE topic_id IN($moved_topics_ids_imp)";
					if ( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, 'Could not update post topic ids', '', __LINE__, __FILE__, $sql);
					}
					$sql = "UPDATE " . READ_HIST_TABLE . " 
						SET forum_id = $new_forum_id 
						WHERE topic_id IN($moved_topics_ids_imp)";
					if ( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, 'Could not update post topic ids', '', __LINE__, __FILE__, $sql);
					}
					recalculate_user_posts($old_forum_id, $new_forum_id, $moved_topics_ids, 'topic');
				}

				// Sync the forum indexes
				sync('forum', $new_forum_id);
				sync('forum', $old_forum_id);

				if ( $board_config['del_notify_choice'] && $HTTP_POST_VARS['no_notify'] )
				{
					$do_notify = false;
				}
				if ( $do_notify )
				{
					$sql = "SELECT forum_name
						FROM " . FORUMS_TABLE . "
						WHERE forum_id = $new_forum_id";
					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not get forum_name from forums table', '', __LINE__, __FILE__, $sql);
					}
					$row = $db->sql_fetchrow($result);
					$notify_new_forum_name = $row['forum_name'];


					if ( $notify_user_lang != $userdata['user_lang'] )
					{
						$userdata_lang = $lang;
						unset($lang);
						if ( !file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_' . $notify_user_lang . '/lang_main.'.$phpEx)) )
						{
							$notify_user_lang = 'english';
						}
						include($phpbb_root_path . 'language/lang_' . $notify_user_lang . '/lang_main.' . $phpEx);
						$user_lang = $lang;
						unset($lang);
						$lang = $userdata_lang;
						unset($userdata_lang);
					}
					else
					{
						$user_lang = $lang;
					}

					$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
					$server_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['server_name']));
					$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) : '';
					$script_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['script_path']));
					$script_name = ($script_name == '') ? $script_name . '/viewtopic.'.$phpEx : '/' . $script_name . '/viewtopic.'.$phpEx;

					$url_absolute = $server_protocol . $server_name . $server_port . $script_name;

					$u_topic = $url_absolute . '?' . POST_TOPIC_URL . '=' . $topic_id;

					$notify_reason = ($HTTP_POST_VARS['reason']) ? "\n\r\n\r" . $user_lang['Reason'] . ': ' . $HTTP_POST_VARS['reason'] : ' ';

					if ( $board_config['del_notify_method'] )
					{
						include($phpbb_root_path . 'includes/emailer.'.$phpEx);
						$emailer = new emailer($board_config['smtp_delivery']);

						$emailer->from($board_config['email_from']);
						$emailer->replyto($board_config['email_return_path']);

						$emailer->use_template('notify_delete', $notify_user_lang);
						$emailer->email_address($notify_user_email);
						$emailer->set_subject(sprintf($user_lang['Your_topic_moved'], '"' . $board_config['sitename'] . '"'));

						$emailer->assign_vars(array(
							'SITENAME' => $board_config['sitename'],
							'TO_USERNAME' => $notify_username,
							'MESSAGE' => sprintf($user_lang['Your_topic_moved_message'], $notify_topic_title, $notify_forum_name, $notify_new_forum_name, $u_topic, stripslashes($notify_reason)),
							'EMAIL_SIG' => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '')
						);
						$emailer->send();
						$emailer->reset();
					}
					else
					{
						send_forum_pm($notify_user, sprintf($user_lang['Your_topic_moved'], 'forum'), sprintf($user_lang['Your_topic_moved_message'], $notify_topic_title, $notify_forum_name, $notify_new_forum_name, $u_topic, $notify_reason));
					}
				}

				$message = $lang['Topics_Moved'] . '<br /><br />';
			}
			else
			{
				$message = $lang['No_Topics_Moved'] . '<br /><br />';
			}

			if ( !empty($topic_id) )
			{
				$redirect_page = "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;sid=" . $userdata['session_id'];
				$message .= sprintf($lang['Click_return_topic'], '<a href="' . $redirect_page . '">', '</a>');
			}
			else
			{
				$redirect_page = "modcp.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'];
				$message .= sprintf($lang['Click_return_modcp'], '<a href="' . $redirect_page . '">', '</a>');
			}

			$message = $message . '<br \><br \>' . sprintf($lang['Click_return_forum'], '<a href="' . "viewforum.$phpEx?" . POST_FORUM_URL . "=$old_forum_id&amp;sid=" . $userdata['session_id'] . '">', '</a>');

			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="' . $board_config['refresh'] . ';url=' . $redirect_page . '">')
			);

			message_die(GENERAL_MESSAGE, $message);
		}
		else
		{
			if ( empty($HTTP_POST_VARS['topic_id_list']) && empty($topic_id) )
			{
				message_die(GENERAL_MESSAGE, $lang['None_selected']);
			}

			$hidden_fields = '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" /><input type="hidden" name="mode" value="' . $mode . '" /><input type="hidden" name="' . POST_FORUM_URL . '" value="' . $forum_id . '" />';

			if ( isset($HTTP_POST_VARS['topic_id_list']) )
			{
				$topics = $HTTP_POST_VARS['topic_id_list'];

				for($i = 0; $i < count($topics); $i++)
				{
					$hidden_fields .= '<input type="hidden" name="topic_id_list[]" value="' . intval($topics[$i]) . '" />';
				}
			}
			else
			{
				$hidden_fields .= '<input type="hidden" name="' . POST_TOPIC_URL . '" value="' . $topic_id . '" />';
			}

			// Set template files
			$template->set_filenames(array(
				'movetopic' => 'modcp_move.tpl')
			);

			$template->assign_vars(array(
				'MESSAGE_TITLE' => $lang['Confirm'],
				'MESSAGE_TEXT' => $lang['Confirm_move_topic'],

				'L_MOVE_TO_FORUM' => $lang['Move_to_forum'], 
				'L_LEAVESHADOW' => $lang['Leave_shadow_topic'], 
				'L_YES' => $lang['Yes'],
				'L_NO' => $lang['No'],
				'L_REASON' => $lang['Move_reason'],
				'L_REASON_E' => $lang['Move_reason_e'],
				'L_NO_NOTIFY' => $lang['del_notify_choice'],

				'S_FORUM_SELECT' => selectbox('new_forum', $forum_id), 
				'S_MODCP_ACTION' => append_sid("modcp.$phpEx"),
				'S_HIDDEN_FIELDS' => $hidden_fields)
			);

			if ( $do_notify )
			{
				$template->assign_block_vars('notify', array());
				if ( $board_config['del_notify_choice'] )
				{
					$template->assign_block_vars('notify.no_notify', array());
				}
			}

			$template->pparse('movetopic');

			include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
		}
		break;

	// Merge Topic MOD - Begin 
	case 'mergetopic': 

	$page_title = $lang['Mod_CP'];
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);

		// this starts after you selected the forum to which the topic will be moved/merged
	if ( $merge2 )
	{
		$fid = ( isset($HTTP_POST_VARS['new_forum']) ) ? $HTTP_POST_VARS['new_forum'] : $HTTP_GET_VARS['new_forum'] ;
		$nold_forum_id = $fid;
		if ( $fid == 'Root' )
		{
			$type = POST_CAT_URL;
			$new_forum_id = 0;
		}
		else
		{
			$type = substr($fid, 0, 1);
			$new_forum_id = ($type == POST_FORUM_URL) ? intval(substr($fid, 1)) : 0;
		}
		if ( $new_forum_id <= 0 )
		{
			message_die(GENERAL_MESSAGE, $lang['Forum_not_exist']);
		}

		$topics = ( isset($HTTP_POST_VARS['topic_id_list']) ) ? $HTTP_POST_VARS['topic_id_list'] : explode(',', $HTTP_GET_VARS['topic_id_list']);

		if ( $topics )
		{
			$topic_list = '';

			for($i = 0; $i < count($topics); $i++)
			{
				$topic_list .= ( ( $topic_list != '' ) ? ',' : '' ) . $topics[$i];
				$hidden_fields .= '<input type="hidden" name="topic_id_list[]" value="' . intval($topics[$i]) . '" />';
			}
		}
		else
		{
			$topic_list = $topic_id;
			$hidden_fields .= '<input type="hidden" name="' . POST_TOPIC_URL . '" value="' . $topic_id . '" />';
		}

		// added for fix to use with phpbb v2.04
		$hidden_fields .= '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
		$hidden_fields .= '<input type="hidden" name="' . POST_FORUM_URL . '" value="' . $forum_id . '" />';
		$hidden_fields .= '<input type="hidden" name="mode" value="' . $mode . '" />';
		$hidden_fields .= '<input type="hidden" name="new_forum" value="' . $new_forum_id . '" />';

		$template->assign_vars(array(
			'FORUM_NAME' => $forum_name,
			'L_MOD_CP' => $lang['Mod_CP'],
			'L_MOD_CP_EXPLAIN' => $lang['Mod_CP_merge_explain'],
			'L_SELECT' => $lang['Select'],
			'L_MERGE' => $lang['Merge'],
			'L_TOPICS' => $lang['Topics'],
			'L_REPLIES' => $lang['Replies'],
			'L_LASTPOST' => $lang['Last_Post'],
			'L_LEAVESHADOW' => $lang['Leave_shadow_topic'],
			'U_VIEW_FORUM' => append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id"),
			'S_HIDDEN_FIELDS' => $hidden_fields,
			'S_MODCP_ACTION' => append_sid("modcp.$phpEx"))
		);

		$template->set_filenames(array(
			'body' => 'modcp_merge_topicpost.tpl')
		);

		// Define censored word matches
		$orig_word = array();
		$replacement_word = array();
		$replacement_word_html = array();
		obtain_word_list($orig_word, $replacement_word, $replacement_word_html);
		
		$sql = "SELECT count(*) AS total
				FROM (" . TOPICS_TABLE . " t, " . USERS_TABLE . " u, " . POSTS_TABLE . " p)
				WHERE t.forum_id = $new_forum_id
					AND t.topic_poster = u.user_id
					AND p.post_id = t.topic_last_post_id
					AND t.topic_moved_id = 0
					AND t.topic_id NOT IN ($topic_list)";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain count topics information', '', __LINE__, __FILE__, $sql);
		}
		$count_topics_rows = $db->sql_fetchrow($result);
		$count_topics = $count_topics_rows['total'];

		$sql = "SELECT t.*, u.username, u.user_id, p.post_time
			FROM (" . TOPICS_TABLE . " t, " . USERS_TABLE . " u, " . POSTS_TABLE . " p)
			WHERE t.forum_id = $new_forum_id
				AND t.topic_poster = u.user_id
				AND p.post_id = t.topic_last_post_id
				AND t.topic_moved_id = 0
				AND t.topic_id NOT IN ($topic_list)
			$sotr_methods LIMIT $start, $user_topics_per_page";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain topic information', '', __LINE__, __FILE__, $sql);
		}

		while ( $row = $db->sql_fetchrow($result) )
		{
			$topic_title = '';
			if ( $row['topic_status'] == TOPIC_LOCKED )
			{
				$folder_img = $images['folder_locked'];
				$folder_alt = $lang['Topic_locked'];
			}
			else
			{
				if ( $row['topic_type'] == POST_ANNOUNCE )
				{
					$folder_img = $images['folder_announce'];
					$folder_alt = $lang['Announcement'];
				}
				else if ( $row['topic_type'] == POST_STICKY )
				{
					$folder_img = $images['folder_sticky'];
					$folder_alt = $lang['Sticky'];
				}
				else
				{
					$folder_img = $images['folder'];
					$folder_alt = $lang['No_new_posts'];
				}
			}

			$topic_id = $row['topic_id'];
			$topic_type = $row['topic_type'];
			$topic_status = $row['topic_status'];

			if ( $topic_type == POST_ANNOUNCE )
			{
				$topic_type = $lang['Topic_Announcement'] . ' ';
			}
			else if ( $topic_type == POST_STICKY )
			{
				$topic_type = $lang['Topic_Sticky'] . ' ';
			}
			else if ( $topic_status == TOPIC_MOVED )
			{
				$topic_type = $lang['Topic_Moved'] . ' ';
			}
			else
			{
				$topic_type = '';
			}

			if ( $row['topic_vote'] )
			{
				$topic_type .= $lang['Topic_Poll'] . ' ';
			}

			$topic_title = $row['topic_title'];
			if ( count($orig_word) )
			{
				$topic_title = preg_replace($orig_word, $replacement_word, $topic_title);
			}

			$topic_replies = $row['topic_replies'];

			$template->assign_block_vars('topicrow', array(
				'U_VIEW_TOPIC' => append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id"),
				'TOPIC_FOLDER_IMG' => $folder_img,
				'TOPIC_TYPE' => $topic_type,
				'TOPIC_TITLE' => $topic_title,
				'REPLIES' => $topic_replies,
				'LAST_POST_TIME' => create_date($board_config['default_dateformat'], $row['post_time'], $board_config['board_timezone']),
				'TOPIC_ID' => $topic_id,

				'L_TOPIC_FOLDER_ALT' => $folder_alt)
				);
			}
			$base_url = "modcp.$phpEx?mode=mergetopic&amp;merge2=$merge2&amp;" . POST_FORUM_URL . "=$forum_id&amp;new_forum=$nold_forum_id&amp;topic_id_list=$topic_list&amp;sid=" . $userdata['session_id'] . "";
			generate_pagination($base_url, $count_topics, $user_topics_per_page, $start);

			$template->pparse('body');
		}
		// After you selected the topic to merge with
		else if ( $confirm )
		{
			// $leave_shadow = ( $HTTP_POST_VARS['merge_leave_shadow'] ) ? TRUE : 0;
			if ( empty($HTTP_POST_VARS['topic_id_to']) )
			{
				message_die(GENERAL_MESSAGE, $lang['None_selected']);
			}

			$topic_id_to = intval($HTTP_POST_VARS['topic_id_to']);
			$new_forum_id = intval($HTTP_POST_VARS['new_forum']);
			$old_forum_id = $forum_id;

			$sql = 'SELECT forum_id FROM ' . FORUMS_TABLE . '
				WHERE forum_id = ' . $new_forum_id;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not select from forums table', '', __LINE__, __FILE__, $sql);
			}

			if (!$db->sql_fetchrow($result))
			{
				message_die(GENERAL_MESSAGE, 'New forum does not exist');
			}

			$db->sql_freeresult($result);

			if ( $topic_id != $topic_id_to )
			{
				$topics = ( isset($HTTP_POST_VARS['topic_id_list']) ) ? $HTTP_POST_VARS['topic_id_list'] : array($topic_id);

				$topic_list = '';
				for($i = 0; $i < count($topics); $i++)
				{
					$topic_list .= ( ( $topic_list != '' ) ? ',' : '' ) . $topics[$i];
				}

				$sql = "SELECT *
					FROM " . TOPICS_TABLE . "
					WHERE topic_id IN ($topic_list)
						AND topic_status <> " . TOPIC_MOVED;
				if ( !($result = $db->sql_query($sql, BEGIN_TRANSACTION)) )
				{
					message_die(GENERAL_ERROR, 'Could not select from topic table', '', __LINE__, __FILE__, $sql);
				}

				$row = $db->sql_fetchrowset($result);
				$db->sql_freeresult($result);

				$moved_topics_ids = array();

				for($i = 0; $i < count($row); $i++)
				{
					$topic_id = $row[$i]['topic_id'];

					if ( isset($HTTP_POST_VARS['merge_leave_shadow']) )
					{
						// Insert topic in the old forum that indicates that the forum has moved.
						$sql = "INSERT INTO " . TOPICS_TABLE . " (forum_id, topic_title, topic_poster, topic_time, topic_status, topic_type, topic_vote, topic_views, topic_replies, topic_first_post_id, topic_last_post_id, topic_moved_id)
							VALUES ($old_forum_id, '" . addslashes(str_replace("\'", "''", $row[$i]['topic_title'])) . "', '" . str_replace("\'", "''", $row[$i]['topic_poster']) . "', " . $row[$i]['topic_time'] . ", " . TOPIC_MOVED . ", " . POST_NORMAL . ", " . $row[$i]['topic_vote'] . ", " . $row[$i]['topic_views'] . ", " . $row[$i]['topic_replies'] . ", " . $row[$i]['topic_first_post_id'] . ", " . $row[$i]['topic_last_post_id'] . ", $topic_id_to)";
						if ( !$db->sql_query($sql) )
						{
							message_die(GENERAL_ERROR, 'Could not insert shadow topic', '', __LINE__, __FILE__, $sql);
						}
					}
					$moved_topics_ids[] = $topic_id;
				}
				if ( count($moved_topics_ids) )
				{
					$moved_topics_ids_imp = implode(', ', $moved_topics_ids);
					$sql = "DELETE
						FROM " . TOPICS_TABLE . "
						WHERE topic_id IN($moved_topics_ids_imp)";
					if ( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, 'Could not delete old topic', '', __LINE__, __FILE__, $sql);
					}

					$sql = "UPDATE " . POSTS_TABLE . "
						SET forum_id = $new_forum_id, topic_id = $topic_id_to
						WHERE topic_id IN($moved_topics_ids_imp)";
					if ( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, 'Could not update post topic ids', '', __LINE__, __FILE__, $sql);
					}

					$sql = "SELECT post_id
						FROM " . POSTS_TABLE . "
						WHERE topic_id = $topic_id_to
						ORDER BY post_time";
					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Error getting post list', '', __LINE__, __FILE__, $sql);
					}
					$i = 0;
					while ( $row = $db->sql_fetchrow($result) )
					{
						$sql2 = "UPDATE " . POSTS_TABLE . "
							SET post_order = $i
							WHERE post_id = " . $row['post_id'];
						if ( !($result2 = $db->sql_query($sql2)) )
						{
							message_die(GENERAL_ERROR, 'Error in updating posts order', '', __LINE__, __FILE__, $sql2);
						}
						$i++;
					}

					$sql = "UPDATE " . READ_HIST_TABLE . "
						SET forum_id = $new_forum_id, topic_id = $topic_id_to
						WHERE topic_id IN($moved_topics_ids_imp)";
					if ( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, 'Could not update post topic ids', '', __LINE__, __FILE__, $sql);
					}

					log_action('merge', $topic_id_to, $userdata['user_id'], $userdata['username']);
					recalculate_user_posts($old_forum_id, $new_forum_id, $moved_topics_ids, 'topic');
				}

				// Sync the forum indexes
				sync('forum', $new_forum_id);
				sync('forum', $old_forum_id);
				sync('topic', $topic_id_to);

				$message = $lang['Topics_Merged'] . '<br /><br />';
			}
			else
			{
				$message = $lang['No_Topics_Merged'] . '<br /><br />';
			}

			if ( !empty($topic_id) )
			{
				$redirect_page = "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id_to&amp;sid=" . $userdata['session_id'];
				$message .= sprintf($lang['Click_return_topic'], '<a href="' . $redirect_page . '">', '</a>');
			}
			else
			{
				$redirect_page = "modcp.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'];
				$message .= sprintf($lang['Click_return_modcp'], '<a href="' . $redirect_page . '">', '</a>');
			}

			$message = $message . '<br \><br \>' . sprintf($lang['Click_return_forum'], '<a href="' . "viewforum.$phpEx?" . POST_FORUM_URL . "=$old_forum_id&amp;sid=" . $userdata['session_id'] . '">', '</a>');

			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . $redirect_page . '">')
			);

			message_die(GENERAL_MESSAGE, $message);
		}
	// Here you select the forum is has to merge to
	else
	{
		if ( empty($HTTP_POST_VARS['topic_id_list']) && empty($topic_id) )
		{
			message_die(GENERAL_MESSAGE, $lang['None_selected']);
		}

		$hidden_fields = '<input type="hidden" name="mode" value="' . $mode . '" /><input type="hidden" name="' . POST_FORUM_URL . '" value="' . $forum_id . '" />';

		// added for fix to use with phpbb v2.04
		$hidden_fields .= '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';

		if ( isset($HTTP_POST_VARS['topic_id_list']) )
		{
			$topics = $HTTP_POST_VARS['topic_id_list'];

			for($i = 0; $i < count($topics); $i++)
			{
				$hidden_fields .= '<input type="hidden" name="topic_id_list[]" value="' . intval($topics[$i]) . '" />';
			}
		}
		else
		{
			$hidden_fields .= '<input type="hidden" name="' . POST_TOPIC_URL . '" value="' . $topic_id . '" />';
		}

		// Set template files 
		$template->set_filenames(array(
			'movetopic' => 'modcp_merge_topic.tpl')
		);

		$template->assign_vars(array(
			'MESSAGE_TITLE' => $lang['Confirm'],
			'MESSAGE_TEXT' => $lang['Confirm_merge_topic'],

			'L_MERGE_TO_FORUM' => $lang['Merge_to_forum'],
			'L_YES' => $lang['Yes'],
			'L_NO' => $lang['No'],

			'S_FORUM_SELECT' => selectbox('new_forum', $forum_id),
			'S_MODCP_ACTION' => append_sid("modcp.$phpEx"),
			'S_HIDDEN_FIELDS' => $hidden_fields)
		);

		$template->pparse('movetopic');

		include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
	}
	break;
	case 'mergepost':

	$page_title = $lang['Mod_CP'];
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);
	if ( $confirm )
	{
		if ( empty($HTTP_POST_VARS['topic_id_to']) )
		{
			message_die(GENERAL_MESSAGE, $lang['None_selected']);
		}

		$topic_id_to = intval($HTTP_POST_VARS['topic_id_to']);
		$new_forum_id = ( isset($HTTP_POST_VARS['new_forum_id']) ) ? intval($HTTP_POST_VARS['new_forum_id']) : intval($HTTP_GET_VARS['new_forum_id']);
		$old_forum_id = $forum_id;
		if( !empty($HTTP_POST_VARS['post_id_list']) )
		{
			$posts = $HTTP_POST_VARS['post_id_list'];
		}
		elseif( !empty($HTTP_GET_VARS['post_id_list']) )
		{
			$posts = explode(',', $HTTP_GET_VARS['post_id_list']);
		}

		if(!$posts)
		{
			message_die(GENERAL_MESSAGE, $lang['None_selected']);
		}

		$sql = "SELECT poster_id, topic_id, post_time
			FROM " . POSTS_TABLE . "
			WHERE post_id = " . intval($posts[0]);
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not get post information', '', __LINE__, __FILE__, $sql);
		}

		$post_rowset = $db->sql_fetchrow($result);
		$post_time = $post_rowset['post_time'];

		if ( !empty($merge_type_beyond) )
		{
			$sql = "SELECT post_id FROM " . POSTS_TABLE . "
				WHERE post_time >= $post_time
					AND topic_id = $topic_id";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get post list', '', __LINE__, __FILE__, $sql);
			}
			unset($posts);
			$posts = array();
			while ( $row = $db->sql_fetchrow($result) )
			{
				$posts[] = $row['post_id'];
			}
		}
		$post_id_sql = '';
		for($i = 0; $i < count($posts); $i++)
		{
			$post_id_sql .= ( ( $post_id_sql != '' ) ? ', ' : '' ) . intval($posts[$i]);
		}

		$sql = "UPDATE " . POSTS_TABLE . "
			SET topic_id = $topic_id_to, forum_id = $new_forum_id
			WHERE post_id IN ($post_id_sql)";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not update posts table', '', __LINE__, __FILE__, $sql);
		}

		$sql = "UPDATE " . READ_HIST_TABLE . "
			SET topic_id = $topic_id_to, forum_id = $new_forum_id
			WHERE post_id IN ($post_id_sql)";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not update read hist table', '', __LINE__, __FILE__, $sql);
		}

		$sql = "SELECT post_id
			FROM " . POSTS_TABLE . "
			WHERE topic_id = $topic_id_to
			ORDER BY post_time";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Error getting post list', '', __LINE__, __FILE__, $sql);
		}
		$i = 0;
		while ( $row = $db->sql_fetchrow($result) )
		{
			$sql2 = "UPDATE " . POSTS_TABLE . "
				SET post_order = $i
				WHERE post_id = " . $row['post_id'];
			if ( !($result2 = $db->sql_query($sql2)) )
			{
				message_die(GENERAL_ERROR, 'Error in updating posts order', '', __LINE__, __FILE__, $sql2);
			}
			$i++;
		}

		log_action('merge', $topic_id_to, $userdata['user_id'], $userdata['username']);

		sync('topic', $topic_id_to);
		sync('topic', $topic_id);
		sync('forum', $new_forum_id);
		sync('forum', $old_forum_id);

		recalculate_user_posts($old_forum_id, $new_forum_id, $posts);

		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id") . '">')
		);

		$message = $lang['Posts_Merged'] . '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;sid=" . $userdata['session_id'] . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	}
	// Step 1 - Pic topic to merge to
	else if ( $merge_type_all || $merge_type_beyond )
	{		
		$topic_id_old = $topic_id;
		$fid = ( isset($HTTP_POST_VARS['new_forum_id']) ) ? $HTTP_POST_VARS['new_forum_id'] : $HTTP_GET_VARS['new_forum_id'];
		$nold_forum_id = $fid;
		if ( $fid == 'Root' )
		{
			$type = POST_CAT_URL;
			$new_forum_id = 0;
		}
		else
		{
			$type = substr($fid, 0, 1);
			$new_forum_id = ($type == POST_FORUM_URL) ? intval(substr($fid, 1)) : 0;
		}
		if ( $new_forum_id <= 0 )
		{
			message_die(GENERAL_MESSAGE, $lang['Forum_not_exist']);
		}

		if( !empty($HTTP_POST_VARS['post_id_list']) )
		{
			$posts = $HTTP_POST_VARS['post_id_list'];
		}
		elseif( !empty($HTTP_GET_VARS['post_id_list']) )
		{
			$posts = explode(',', $HTTP_GET_VARS['post_id_list']);
		}

		if ( $posts )
		{
			$posts_list = '';

			for($i = 0; $i < count($posts); $i++)
			{
				$posts_list .= ( ( $posts_list != '' ) ? ',' : '' ) . $posts[$i];
				$hidden_fields .= '<input type="hidden" name="post_id_list[]" value="' . intval($posts[$i]) . '" />';
			}
		}
		else
		{
			// added to fix sql error
			if ( empty($post_id) )
			{
				message_die(GENERAL_MESSAGE, $lang['None_selected']);
			}

			$posts_list = $post_id;
			$hidden_fields .= '<input type="hidden" name="' . POST_POST_URL . '" value="' . $post_id . '" />';
		}
		// added for fix to use with phpbb v2.04
		$hidden_fields .= '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
		$hidden_fields .= '<input type="hidden" name="' . POST_TOPIC_URL . '" value="' . $topic_id . '" />';
		$hidden_fields .= '<input type="hidden" name="' . POST_FORUM_URL . '" value="' . $forum_id . '" />';
		$hidden_fields .= '<input type="hidden" name="mode" value="' . $mode . '" />';
		$hidden_fields .= '<input type="hidden" name="new_forum_id" value="' . $new_forum_id . '" />';
		$hidden_fields .= '<input type="hidden" name="merge_type_all" value="' . $merge_type_all . '" />';
		$hidden_fields .= '<input type="hidden" name="merge_type_beyond" value="' . $merge_type_beyond . '" />';

		$template->assign_vars(array(
			'FORUM_NAME' => $forum_name,

			'L_MOD_CP' => $lang['Mod_CP'],
			'L_MOD_CP_EXPLAIN' => $lang['Mod_CP_explain'],
			'L_SELECT' => $lang['Select'],
			'L_MERGE' => $lang['Merge'],
			'L_TOPICS' => $lang['Topics'],
			'L_REPLIES' => $lang['Replies'],
			'L_LASTPOST' => $lang['Last_Post'],

			'U_VIEW_FORUM' => append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id"),
			'S_HIDDEN_FIELDS' => $hidden_fields,
			'S_MODCP_ACTION' => append_sid("modcp.$phpEx"))
		);

		$template->set_filenames(array(
			'body' => 'modcp_merge_topicpost.tpl')
		);

		// Define censored word matches
		$orig_word = array();
		$replacement_word = array();
		$replacement_word_html = array();
		obtain_word_list($orig_word, $replacement_word, $replacement_word_html);

		$sql = "SELECT count(*) AS total
			FROM (" . TOPICS_TABLE . " t, " . USERS_TABLE . " u, " . POSTS_TABLE . " p)
			WHERE t.forum_id = $new_forum_id
				AND t.topic_poster = u.user_id
				AND p.post_id = t.topic_last_post_id
				AND t.topic_moved_id = 0
				AND t.topic_id != $topic_id
			$sotr_methods";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not get count posts information', '', __LINE__, __FILE__, $sql);
		}
		$count_topics_row = $db->sql_fetchrow($result);
		$count_topics = $count_topics_row['total'];

		if($count_topics)
		{
			//AND t.topic_id NOT IN ($topic_list)
			$sql = "SELECT t.*, u.username, u.user_id, p.post_time
				FROM (" . TOPICS_TABLE . " t, " . USERS_TABLE . " u, " . POSTS_TABLE . " p)
				WHERE t.forum_id = $new_forum_id
					AND t.topic_poster = u.user_id
					AND p.post_id = t.topic_last_post_id
					AND t.topic_moved_id = 0
					AND t.topic_id != $topic_id
				$sotr_methods LIMIT $start, $user_topics_per_page";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain topic information', '', __LINE__, __FILE__, $sql);
			}
		}

		while ( $row = $db->sql_fetchrow($result) )
		{
			$topic_title = '';

			if ( $row['topic_status'] == TOPIC_LOCKED )
			{
				$folder_img = $images['folder_locked'];
				$folder_alt = $lang['Topic_locked'];
			}
			else
			{
				if ( $row['topic_type'] == POST_ANNOUNCE )
				{
					$folder_img = $images['folder_announce'];
					$folder_alt = $lang['Announcement'];
				}
				else if ( $row['topic_type'] == POST_STICKY )
				{
					$folder_img = $images['folder_sticky'];
					$folder_alt = $lang['Sticky'];
				}
				else
				{
					$folder_img = $images['folder'];
					$folder_alt = $lang['No_new_posts'];
				}
			}

			$topic_id = $row['topic_id'];
			$topic_type = $row['topic_type'];
			$topic_status = $row['topic_status'];

			if ( $topic_type == POST_ANNOUNCE )
			{
				$topic_type = $lang['Topic_Announcement'] . ' ';
			}
			else if ( $topic_type == POST_STICKY )
			{
				$topic_type = $lang['Topic_Sticky'] . ' ';
			}
			else if ( $topic_status == TOPIC_MOVED )
			{
				$topic_type = $lang['Topic_Moved'] . ' ';
			}
			else
			{
				$topic_type = '';
			}

			if ( $row['topic_vote'] )
			{
				$topic_type .= $lang['Topic_Poll'] . ' ';
			}

			$topic_title = $row['topic_title'];
			if ( count($orig_word) )
			{
				$topic_title = preg_replace($orig_word, $replacement_word, $topic_title);
			}

			$topic_replies = $row['topic_replies'];

			$template->assign_block_vars('topicrow', array(
				'U_VIEW_TOPIC' => append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id"),

				'TOPIC_FOLDER_IMG' => $folder_img,
				'TOPIC_TYPE' => $topic_type,
				'TOPIC_TITLE' => $topic_title,
				'REPLIES' => $topic_replies,
				'LAST_POST_TIME' => create_date($board_config['default_dateformat'], $row['post_time'], $board_config['board_timezone']),
				'TOPIC_ID' => $topic_id,

				'L_TOPIC_FOLDER_ALT' => $folder_alt)
			);
		}
		$base_url = "modcp.$phpEx?mode=mergepost&amp;" . POST_FORUM_URL . "=$forum_id&amp;".POST_TOPIC_URL."=$topic_id_old&amp;merge_type_all=$merge_type_all&amp;merge_type_beyond=$merge_type_beyond&amp;new_forum_id=$nold_forum_id&amp;post_id_list=$posts_list&amp;sid=" . $userdata['session_id'] . "";
		generate_pagination($base_url, $count_topics, $user_topics_per_page, $start);

		$template->pparse('body');
	}
	else
	{
		// Step 0 - select the post you want to merge
		// Set template files
		$template->set_filenames(array(
			'merge_post_body' => 'modcp_merge_post.tpl')
		);

		$sql_count = "SELECT count(*) AS total
			FROM (" . POSTS_TABLE . " p, " . USERS_TABLE . " u, " . POSTS_TEXT_TABLE . " pt)
			WHERE p.topic_id = $topic_id
				AND p.poster_id = u.user_id
				AND p.post_id = pt.post_id";
		if ( !($result_count = $db->sql_query($sql_count)) )
		{
			message_die(GENERAL_ERROR, 'Could not get count posts information', '', __LINE__, __FILE__, $sql_count);
		}
		$count_posts_row = $db->sql_fetchrow($result_count);
		$count_posts = $count_posts_row['total'];

		if($count_posts)
		{
			$sql = "SELECT u.username, p.*, pt.post_text, pt.bbcode_uid, pt.post_subject, p.post_username
				FROM (" . POSTS_TABLE . " p, " . USERS_TABLE . " u, " . POSTS_TEXT_TABLE . " pt)
				WHERE p.topic_id = $topic_id
					AND p.poster_id = u.user_id
					AND p.post_id = pt.post_id
				ORDER BY p.post_order, p.post_time ASC
				LIMIT $start, $user_posts_per_page";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get topic/post information', '', __LINE__, __FILE__, $sql);
			}

			// added for fix to use with phpbb v2.04
			$s_hidden_fields .= '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
			$s_hidden_fields .= '<input type="hidden" name="' . POST_FORUM_URL . '" value="' . $forum_id . '" /><input type="hidden" name="mode" value="mergepost" />';
			$s_hidden_fields .= '<input type="hidden" name="' . POST_TOPIC_URL . '" value="' . $topic_id . '" />';
		}
		else
		{
			message_die(GENERAL_ERROR, 'Could not get count posts information', '', __LINE__, __FILE__, $sql_count);
		}
		if ( ( $total_posts = $db->sql_numrows($result) ) > 0 )
		{
			$postrow = $db->sql_fetchrowset($result);

			$template->assign_vars(array(
				'L_MERGE_TOPIC' => $lang['Merge_Topic'],
				'L_MERGE_TOPIC_EXPLAIN' => $lang['Merge_Topic_explain'],
				'L_AUTHOR' => $lang['Author'],
				'L_MESSAGE' => $lang['Message'],
				'L_SELECT' => $lang['Select'],
				'L_MERGE_TO_FORUM' => $lang['Merge_to_forum'],
				'L_MERGE_POST_TOPIC' => $lang['Merge_post_topic'],
				'L_POSTED' => $lang['Posted'],
				'L_MERGE_POSTS' => $lang['Merge_posts'],
				'L_SUBMIT' => $lang['Submit'],
				'L_MERGE_AFTER' => $lang['Merge_after'],
				'L_MARK_ALL' => $lang['Mark_all'],
				'L_UNMARK_ALL' => $lang['Unmark_all'],
				'L_POST' => $lang['Post'],

				'FORUM_NAME' => $forum_name,
				'IMG_POST' => $images['icon_minipost'],

				'U_VIEW_FORUM' => append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id"),

				'S_MERGE_ACTION' => append_sid("modcp.$phpEx"),
				'S_HIDDEN_FIELDS' => $s_hidden_fields,
				'S_FORUM_SELECT' => selectbox("new_forum_id", true))
			);

			// Define censored word matches
			$orig_word = array();
			$replacement_word = array();
			$replacement_word_html = array();
			obtain_word_list($orig_word, $replacement_word, $replacement_word_html);

			for($i = 0; $i < $total_posts; $i++)
			{
				$post_id = $postrow[$i]['post_id'];
				$poster_id = $postrow[$i]['poster_id'];
				$poster = $postrow[$i]['username'];

				$post_date = create_date($board_config['default_dateformat'], $postrow[$i]['post_time'], $board_config['board_timezone']);

				$bbcode_uid = $postrow[$i]['bbcode_uid'];
				$message = $postrow[$i]['post_text'];
				$post_subject = ( $postrow[$i]['post_subject'] != '' ) ? $postrow[$i]['post_subject'] : $topic_title;

				// If the board has HTML off but the post has HTML
				// on then we process it, else leave it alone
				if ( !$board_config['allow_html'] )
				{
					if ( $postrow[$i]['enable_html'] )
					{
						$message = preg_replace('#(<)([\/]?.*?)(>)#is', '&\\2&', $message);
					}
				}

				if ( $bbcode_uid != '' )
				{
					$message = ( $board_config['allow_bbcode'] ) ? bbencode_second_pass($message, $bbcode_uid, $userdata['username']) : preg_replace('/\:[0-9a-z\:]+\]/si', ']', $message);
				}

				if ( count($orig_word) )
				{
					$post_subject = preg_replace($orig_word, $replacement_word, $post_subject);
					$message = preg_replace($orig_word, $replacement_word, $message);
				}

				$message = make_clickable($message);

				if ( $board_config['allow_smilies'] && $postrow[$i]['enable_smilies'] && $userdata['show_smiles'] )
				{
					$message = smilies_pass($message);
				}

				$message = str_replace(array("\n", "\r"), array("<br />", ''), $message);

				$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
				$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

				$checkbox = ( $post_id != $topic_first_post_id ) ? '<input type="checkbox" name="post_id_list[]" value="' . $post_id . '" />' : '&nbsp;';

				$template->assign_block_vars('postrow', array(
					'ROW_COLOR' => '#' . $row_color,
					'ROW_CLASS' => $row_class,
					'POSTER_NAME' => $poster,
					'POST_DATE' => $post_date,
					'POST_SUBJECT' => $post_subject,
					'MESSAGE' => $message,
					'POST_ID' => $post_id,

					'S_MERGE_CHECKBOX' => $checkbox)
				);
			}

			$base_url = "modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=mergepost&amp;sid=" . $userdata['session_id'] . "";
			generate_pagination($base_url, $count_posts, $user_posts_per_page, $start);
			
			$template->pparse('merge_post_body');
		}
	}
	break;
	// Merge Topic MOD - End

	case 'lock':
		if ( empty($HTTP_POST_VARS['topic_id_list']) && empty($topic_id) )
		{
			message_die(GENERAL_MESSAGE, $lang['None_selected']);
		}

		$topics = ( isset($HTTP_POST_VARS['topic_id_list']) ) ? $HTTP_POST_VARS['topic_id_list'] : array($topic_id);

		$topic_id_sql = '';
		for($i = 0; $i < count($topics); $i++)
		{
			$topic_id_sql .= ( ( $topic_id_sql != '' ) ? ', ' : '' ) . intval($topics[$i]);
		}

		$sql = "UPDATE " . TOPICS_TABLE . " 
			SET topic_status = " . TOPIC_LOCKED . " 
			WHERE topic_id IN ($topic_id_sql) 
				AND forum_id = $forum_id
				AND topic_moved_id = 0";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update topics table', '', __LINE__, __FILE__, $sql);
		}

		log_action('lock', $topic_id_sql, $userdata['user_id'], $userdata['username']);
		set_action($topic_id_sql, LOCKED);

		if ( !empty($topic_id) )
		{
			$redirect_page = "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;sid=" . $userdata['session_id'];
			$message = sprintf($lang['Click_return_topic'], '<a href="' . $redirect_page . '">', '</a>');
		}
		else
		{
			$redirect_page = "modcp.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'];
			$message = sprintf($lang['Click_return_modcp'], '<a href="' . $redirect_page . '">', '</a>');
		}

		$message = $message . '<br \><br \>' . sprintf($lang['Click_return_forum'], '<a href="' . "viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'] . '">', '</a>');

		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="' . $board_config['refresh'] . ';url=' . $redirect_page . '">')
		);

		message_die(GENERAL_MESSAGE, $lang['Topics_Locked'] . '<br /><br />' . $message);

		break;

	case 'unlock':
		if ( empty($HTTP_POST_VARS['topic_id_list']) && empty($topic_id) )
		{
			message_die(GENERAL_MESSAGE, $lang['None_selected']);
		}

		$topics = ( isset($HTTP_POST_VARS['topic_id_list']) ) ? $HTTP_POST_VARS['topic_id_list'] : array($topic_id);

		$topic_id_sql = '';
		for($i = 0; $i < count($topics); $i++)
		{
			$topic_id_sql .= ( ( $topic_id_sql != '') ? ', ' : '' ) . $topics[$i];
		}

		$sql = "UPDATE " . TOPICS_TABLE . " 
			SET topic_status = " . TOPIC_UNLOCKED . " 
			WHERE topic_id IN ($topic_id_sql) 
				AND forum_id = $forum_id
				AND topic_moved_id = 0";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update topics table', '', __LINE__, __FILE__, $sql);
		}

		log_action('unlock', $topic_id_sql, $userdata['user_id'], $userdata['username']);
		set_action($topic_id_sql, UNLOCKED);

		if ( !empty($topic_id) )
		{
			$redirect_page = "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;sid=" . $userdata['session_id'];
			$message = sprintf($lang['Click_return_topic'], '<a href="' . $redirect_page . '">', '</a>');
		}
		else
		{
			$redirect_page = "modcp.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'];
			$message = sprintf($lang['Click_return_modcp'], '<a href="' . $redirect_page . '">', '</a>');
		}

		$message = $message . '<br \><br \>' . sprintf($lang['Click_return_forum'], '<a href="' . "viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'] . '">', '</a>');

		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="' . $board_config['refresh'] . ';url=' . $redirect_page . '">')
		);

		message_die(GENERAL_MESSAGE, $lang['Topics_Unlocked'] . '<br /><br />' . $message);

		break;

	case 'expire1':
	case 'expire2':
	case 'expire7':
	case 'expire14':
		if ( empty($topic_id) )
		{
			message_die(GENERAL_MESSAGE, $lang['None_selected']);
		}

		if ( $userdata['user_level'] != ADMIN && $board_config['not_edit_admin'] )
		{
			$sql = "SELECT t.topic_id
				FROM (" . TOPICS_TABLE . " t, " . USERS_TABLE . " u)
				WHERE u.user_id = t.topic_poster
					AND u.user_level = " . ADMIN . "
					AND t.topic_id = " . $topic_id;
			if ( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not retrieve topics list', '', __LINE__, __FILE__, $sql);
			}

			if ( $db->sql_numrows($result) > 0 )
			{
				message_die(GENERAL_MESSAGE, $lang['Not_auth_edit_delete_admin']);
			}
		}

		$sql = "SELECT topic_time
				FROM " . TOPICS_TABLE . "
				WHERE topic_id = $topic_id";
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not get topic time', '', __LINE__, __FILE__, $sql);
		}
		if ( !($row = $db->sql_fetchrow($result)) )
		{
			message_die(GENERAL_ERROR, 'Could not get topic time', '', __LINE__, __FILE__, $sql);
		}

		$expire_time = (str_replace('expire', '', $mode) * 86400 + (CR_TIME - $row['topic_time']) );
		if ( intval($expire_time) > 86000 )
		{
			$sql = "UPDATE " . TOPICS_TABLE . " 
				SET topic_expire = $expire_time 
				WHERE topic_id = $topic_id 
					AND topic_moved_id = 0";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not update topics table', '', __LINE__, __FILE__, $sql);
			}

			log_action('expire', $topic_id, $userdata['user_id'], $userdata['username']);
			set_action($topic_id, EXPIRED);
		}
		else
		{
			message_die(GENERAL_MESSAGE, 'Wrong expire time: <b>' . $expire_time . '</b> seconds');
		}

		$redirect_page = "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;sid=" . $userdata['session_id'];
		$message = sprintf($lang['Click_return_topic'], '<a href="' . $redirect_page . '">', '</a>');

		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="' . $board_config['refresh'] . ';url=' . $redirect_page . '">')
		);

		message_die(GENERAL_MESSAGE, $lang['Topics_Expired'] . '<br /><br />' . $message);

		break;

		case 'sticky':
		case 'announce':
		case 'normalise':
		if ( $mode == 'sticky' && !$is_auth['auth_sticky'] )
		{
			$message = sprintf($lang['Sorry_auth_sticky'], $is_auth['auth_sticky_type']);
			message_die(GENERAL_MESSAGE, $message);
		}
		if ( $mode == 'announce' && !$is_auth['auth_announce'] )
		{
			$message = sprintf($lang['Sorry_auth_announce'], $is_auth['auth_announce_type']);
			message_die(GENERAL_MESSAGE, $message);
		}
		if ( empty($HTTP_POST_VARS['topic_id_list']) && empty($topic_id) )
		{
			message_die(GENERAL_MESSAGE, $lang['None_selected']);
		}

		$topics = ( isset($HTTP_POST_VARS['topic_id_list']) ) ? $HTTP_POST_VARS['topic_id_list'] : array($topic_id);

		$topic_id_sql = '';
		for($i = 0; $i < count($topics); $i++)
		{
			$topic_id_sql .= ( ( $topic_id_sql != '') ? ', ' : '' ) . $topics[$i];
		}

		$topic_type = ($mode == 'sticky') ? POST_STICKY : (($mode == 'announce') ? POST_ANNOUNCE : POST_NORMAL);
		$sql = "UPDATE " . TOPICS_TABLE . " 
			SET topic_type = $topic_type
			WHERE topic_id IN ($topic_id_sql) 
				AND topic_moved_id = 0";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update topics table', '', __LINE__, __FILE__, $sql);
		}

		if ( $mode == 'normalise' )
		{
			log_action('Normal_topic', $topic_id_sql, $userdata['user_id'], $userdata['username']);
		}
		else
		{
			log_action('announce-stick', $topic_id_sql, $userdata['user_id'], $userdata['username']);
		}

		if ( !empty($topic_id) )
		{
			$redirect_page = "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;sid=" . $userdata['session_id'];
			$message = sprintf($lang['Click_return_topic'], '<a href="' . $redirect_page . '">', '</a>');
		}
		else
		{
			$redirect_page = "modcp.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'];
			$message = sprintf($lang['Click_return_modcp'], '<a href="' . $redirect_page . '">', '</a>');
		}

		$message = $message . '<br \><br \>' . sprintf($lang['Click_return_forum'], '<a href="' . "viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'] . '">', '</a>');

		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . $redirect_page . '">')
		);

		if ( $mode == 'sticky' )
		{
			$message = $lang['Topics_Stickyd'] . '<br /><br />' . $message;
		}
		else if ( $mode == 'announce' )
		{
			$message = $lang['Topics_Announced'] . '<br /><br />' . $message;
		}
		else if ( $mode == 'normalise' )
		{
			$message = $lang['Topics_Normalised'] . '<br /><br />' . $message;
		}

		message_die(GENERAL_MESSAGE, $message);
		break;

	case 'split':
		$page_title = $lang['Mod_CP'];
		include($phpbb_root_path . 'includes/page_header.'.$phpEx);

		$post_id_sql = '';

		if (isset($HTTP_POST_VARS['split_type_all']) || isset($HTTP_POST_VARS['split_type_beyond']))
		{
			$posts = $HTTP_POST_VARS['post_id_list'];

			for ($i = 0; $i < count($posts); $i++)
			{
				$post_id_sql .= (($post_id_sql != '') ? ', ' : '') . intval($posts[$i]);
			}
		}

		if ($post_id_sql != '')
		{
			$sql = "SELECT post_id 
				FROM " . POSTS_TABLE . "
				WHERE post_id IN ($post_id_sql)
					AND forum_id = $forum_id";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get post id information', '', __LINE__, __FILE__, $sql);
			}
			
			$post_id_sql = '';
			while ($row = $db->sql_fetchrow($result))
			{
				$post_id_sql .= (($post_id_sql != '') ? ', ' : '') . intval($row['post_id']);
			}
			$db->sql_freeresult($result);

			$sql = "SELECT post_id, poster_id, topic_id, post_time
				FROM " . POSTS_TABLE . "
				WHERE post_id IN ($post_id_sql) 
				ORDER BY post_time ASC";
			if (!($result = $db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, 'Could not get post information', '', __LINE__, __FILE__, $sql);
			}

			if ($row = $db->sql_fetchrow($result))
			{
				$first_poster = $row['poster_id'];
				$topic_id = $row['topic_id'];
				$post_time = $row['post_time'];

				$user_id_sql = '';
				$post_id_sql = '';
				do
				{
					$user_id_sql .= (($user_id_sql != '') ? ', ' : '') . intval($row['poster_id']);
					$post_id_sql .= (($post_id_sql != '') ? ', ' : '') . intval($row['post_id']);;
				}
				while ($row = $db->sql_fetchrow($result));

				$post_subject = trim(xhtmlspecialchars($HTTP_POST_VARS['subject']));
				if (empty($post_subject))
				{
					message_die(GENERAL_MESSAGE, $lang['Empty_subject']);
				}

				$fid = $HTTP_POST_VARS['new_forum_id'];
				if ( $fid == 'Root' )
				{
					$type = POST_CAT_URL;
					$new_forum_id = 0;
				}
				else
				{
					$type = substr($fid, 0, 1);
					$new_forum_id = ($type == POST_FORUM_URL) ? intval(substr($fid, 1)) : 0;
				}
				if ( $new_forum_id <= 0 )
				{
					message_die(GENERAL_MESSAGE, 'Forum_not_exist');
				}

				$sql = 'SELECT forum_id FROM ' . FORUMS_TABLE . '
					WHERE forum_id = ' . $new_forum_id;
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not select from forums table', '', __LINE__, __FILE__, $sql);
				}
				
				if (!$db->sql_fetchrow($result))
				{
					message_die(GENERAL_MESSAGE, 'New forum does not exist');
				}

				$db->sql_freeresult($result);

				$sql  = "INSERT INTO " . TOPICS_TABLE . " (topic_title, topic_poster, topic_time, forum_id, topic_status, topic_type)
					VALUES ('" . str_replace("\'", "''", $post_subject) . "', $first_poster, " . CR_TIME . ", $new_forum_id, " . TOPIC_UNLOCKED . ", " . POST_NORMAL . ")";
				if (!($db->sql_query($sql, BEGIN_TRANSACTION)))
				{
					message_die(GENERAL_ERROR, 'Could not insert new topic', '', __LINE__, __FILE__, $sql);
				}

				$new_topic_id = $db->sql_nextid();

				// Update topic watch table, switch users whose posts
				// have moved, over to watching the new topic
				$sql = "UPDATE " . TOPICS_WATCH_TABLE . " 
					SET topic_id = $new_topic_id 
					WHERE topic_id = $topic_id 
						AND user_id IN ($user_id_sql)";
				if (!$db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, 'Could not update topics watch table', '', __LINE__, __FILE__, $sql);
				}

				$sql_where = (!empty($HTTP_POST_VARS['split_type_beyond'])) ? " post_time >= $post_time AND topic_id = $topic_id" : "post_id IN ($post_id_sql)";

				$sql = 	"UPDATE " . POSTS_TABLE . "
					SET topic_id = $new_topic_id, forum_id = $new_forum_id 
					WHERE $sql_where";
				if (!$db->sql_query($sql, END_TRANSACTION))
				{
					message_die(GENERAL_ERROR, 'Could not update posts table', '', __LINE__, __FILE__, $sql);
				}

				log_action('split', $topic_id, $userdata['user_id'], $userdata['username']);

				$sql = "SELECT post_id 
					FROM " . POSTS_TABLE . "
					WHERE $sql_where";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not get post id information', '', __LINE__, __FILE__, $sql);
				}
				
				$post_id_sql = '';
				while ($row = $db->sql_fetchrow($result))
				{
					$post_id_sql .= (($post_id_sql != '') ? ', ' : '') . $row['post_id'];
				}
				if ( $post_id_sql )
				{
					$sql = 	"UPDATE " . READ_HIST_TABLE . "
						SET topic_id = $new_topic_id, forum_id = $new_forum_id 
						WHERE post_id IN($post_id_sql)";
					if (!$db->sql_query($sql))
					{
						message_die(GENERAL_ERROR, 'Could not update read hist table', '', __LINE__, __FILE__, $sql);
					}
				}

				sync('topic', $new_topic_id);
				sync('topic', $topic_id);
				sync('forum', $new_forum_id);
				sync('forum', $forum_id);

				recalculate_user_posts($forum_id, $new_forum_id, $posts);

				$template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="' . $board_config['refresh'] . ';url=' . "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;sid=" . $userdata['session_id'] . '">')
				);

				$message = $lang['Topic_split'] . '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;sid=" . $userdata['session_id'] . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);
			}
		}
		else
		{
			//
			// Set template files
			//
			$template->set_filenames(array(
				'split_body' => 'modcp_split.tpl')
			);

			$sql_count = "SELECT count(*) AS total
				FROM (" . POSTS_TABLE . " p, " . USERS_TABLE . " u, " . POSTS_TEXT_TABLE . " pt)
				WHERE p.topic_id = $topic_id
					AND p.poster_id = u.user_id
					AND p.post_id = pt.post_id";
			if ( !($result_count = $db->sql_query($sql_count)) )
			{
				message_die(GENERAL_ERROR, 'Could not get count posts information', '', __LINE__, __FILE__, $sql_count);
			}
			$count_posts_row = $db->sql_fetchrow($result_count);
			$count_posts = $count_posts_row['total'];

			if($count_posts)
			{
				$sql = "SELECT u.username, p.*, pt.post_text, pt.bbcode_uid, pt.post_subject, p.post_username
					FROM (" . POSTS_TABLE . " p, " . USERS_TABLE . " u, " . POSTS_TEXT_TABLE . " pt)
					WHERE p.topic_id = $topic_id
						AND p.poster_id = u.user_id
						AND p.post_id = pt.post_id
					ORDER BY p.post_order, p.post_time ASC
					LIMIT $start, $user_posts_per_page";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not get topic/post information', '', __LINE__, __FILE__, $sql);
				}

				$s_hidden_fields = '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" /><input type="hidden" name="' . POST_FORUM_URL . '" value="' . $forum_id . '" /><input type="hidden" name="' . POST_TOPIC_URL . '" value="' . $topic_id . '" /><input type="hidden" name="mode" value="split" />';
			}
			else
			{
				message_die(GENERAL_ERROR, 'Could not get count posts information', '', __LINE__, __FILE__, $sql_count);
			}

			if( ( $total_posts = $db->sql_numrows($result) ) > 0 )
			{
				$postrow = $db->sql_fetchrowset($result);

				$template->assign_vars(array(
					'L_SPLIT_TOPIC' => $lang['Split_Topic'],
					'L_SPLIT_TOPIC_EXPLAIN' => $lang['Split_Topic_explain'],
					'L_AUTHOR' => $lang['Author'],
					'L_MESSAGE' => $lang['Message'],
					'L_SELECT' => $lang['Select'],
					'L_SPLIT_SUBJECT' => $lang['Split_title'],
					'L_SPLIT_FORUM' => $lang['Split_forum'],
					'L_POSTED' => $lang['Posted'],
					'L_SPLIT_POSTS' => $lang['Split_posts'],
					'L_SUBMIT' => $lang['Submit'],
					'L_SPLIT_AFTER' => $lang['Split_after'], 
					'L_POST_SUBJECT' => $lang['Post_subject'], 
					'L_MARK_ALL' => $lang['Mark_all'], 
					'L_UNMARK_ALL' => $lang['Unmark_all'], 
					'L_POST' => $lang['Post'], 

					'FORUM_NAME' => $forum_name,
					'IMG_POST' => $images['icon_minipost'],

					'U_VIEW_FORUM' => append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id"), 

					'S_SPLIT_ACTION' => append_sid("modcp.$phpEx"),
					'S_HIDDEN_FIELDS' => $s_hidden_fields,
					'S_FORUM_SELECT' => selectbox("new_forum_id", false, $forum_id))
				);

				$orig_word = array();
				$replacement_word = array();
				$replacement_word_html = array();
				obtain_word_list($orig_word, $replacement_word, $replacement_word_html);

				for($i = 0; $i < $total_posts; $i++)
				{
					$post_id = $postrow[$i]['post_id'];
					$poster_id = $postrow[$i]['poster_id'];
					$poster = $postrow[$i]['username'];

					$post_date = create_date($board_config['default_dateformat'], $postrow[$i]['post_time'], $board_config['board_timezone']);

					$bbcode_uid = $postrow[$i]['bbcode_uid'];
					$message = $postrow[$i]['post_text'];
					$post_subject = ( $postrow[$i]['post_subject'] != '' ) ? $postrow[$i]['post_subject'] : $topic_title;

					// If the board has HTML off but the post has HTML
					// on then we process it, else leave it alone
					if ( !$board_config['allow_html'] )
					{
						if ( $postrow[$i]['enable_html'] )
						{
							$message = preg_replace('#(<)([\/]?.*?)(>)#is', '&lt;\\2&gt;', $message);
						}
					}

					if ( $bbcode_uid != '' )
					{
						$message = ( $board_config['allow_bbcode'] ) ? bbencode_second_pass($message, $bbcode_uid, $userdata['username']) : preg_replace('/\:[0-9a-z\:]+\]/si', ']', $message);
					}

					if ( count($orig_word) )
					{
						$post_subject = preg_replace($orig_word, $replacement_word, $post_subject);
						$message = preg_replace($orig_word, $replacement_word, $message);
					}

					$message = make_clickable($message);

					if ( $board_config['allow_smilies'] && $postrow[$i]['enable_smilies'] && $userdata['show_smiles'] )
					{
						$message = smilies_pass($message);
					}

					$message = str_replace(array("\n", "\r"), array("<br />", ''), $message);
					
					$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
					$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

					$checkbox = ( $post_id != $topic_first_post_id ) ? '<input type="checkbox" name="post_id_list[]" value="' . $post_id . '" />' : '&nbsp;';
					
					$template->assign_block_vars('postrow', array(
						'ROW_COLOR' => '#' . $row_color,
						'ROW_CLASS' => $row_class,
						'POSTER_NAME' => $poster,
						'POST_DATE' => $post_date,
						'POST_SUBJECT' => $post_subject,
						'MESSAGE' => $message,
						'POST_ID' => $post_id,
						
						'S_SPLIT_CHECKBOX' => $checkbox)
					);
				}

				$base_url = "modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=split&amp;sid=" . $userdata['session_id'] . "";
				generate_pagination($base_url, $count_posts, $user_posts_per_page, $start);				
				
				$template->pparse('split_body');
			}
		}
		break;

	case 'ip':
		$page_title = $lang['Mod_CP'];
		include($phpbb_root_path . 'includes/page_header.'.$phpEx);

		$rdns_ip_num = ( isset($HTTP_GET_VARS['rdns']) ) ? $HTTP_GET_VARS['rdns'] : '';

		if ( !$post_id )
		{
			message_die(GENERAL_MESSAGE, $lang['No_such_post']);
		}

		// Set template files
		$template->set_filenames(array(
			'viewip' => 'modcp_viewip.tpl')
		);

		// Look up relevent data for this post
		$sql = "SELECT poster_ip, poster_id 
			FROM " . POSTS_TABLE . " 
			WHERE post_id = $post_id
				AND forum_id = $forum_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not get poster IP information', '', __LINE__, __FILE__, $sql);
		}
		
		if ( !($post_row = $db->sql_fetchrow($result)) )
		{
			message_die(GENERAL_MESSAGE, $lang['No_such_post']);
		}

		$ip_this_post = decode_ip($post_row['poster_ip']);
		$ip_this_post = ( $rdns_ip_num == $ip_this_post ) ? @gethostbyaddr($ip_this_post) : $ip_this_post;

		$poster_id = $post_row['poster_id'];

		$template->assign_vars(array(
			'L_IP_INFO' => $lang['IP_info'],
			'L_THIS_POST_IP' => $lang['This_posts_IP'],
			'L_OTHER_IPS' => $lang['Other_IP_this_user'],
			'L_OTHER_USERS' => $lang['Users_this_IP'],
			'L_LOOKUP_IP' => $lang['Lookup_IP'], 
			'L_SEARCH' => $lang['Search'],

			'SEARCH_IMG' => $images['icon_search'], 

			'IP' => $ip_this_post, 
			'U_LOOKUP_WHOIS' => '<a href="' . $board_config['address_whois'] . $ip_this_post . '" target="_blank">' . $lang['l_whois'] . '</a>',
			'U_LOOKUP_IP' => "modcp.$phpEx?mode=ip&amp;" . POST_POST_URL . "=$post_id&amp;" . POST_TOPIC_URL . "=$topic_id&amp;rdns=$ip_this_post&amp;sid=" . $userdata['session_id'])

		);

		// Get other IP's this user has posted under
		$sql = "SELECT poster_ip, COUNT(*) AS postings 
			FROM " . POSTS_TABLE . " 
			WHERE poster_id = $poster_id 
			GROUP BY poster_ip 
			ORDER BY " . (( SQL_LAYER == 'msaccess' ) ? 'COUNT(*)' : 'postings' ) . " DESC";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not get IP information for this user', '', __LINE__, __FILE__, $sql);
		}

		if ( $row = $db->sql_fetchrow($result) )
		{
			$i = 0;
			do
			{
				if ( $row['poster_ip'] == $post_row['poster_ip'] )
				{
					$template->assign_vars(array(
						'POSTS' => $row['postings'] . ' ' . ( ( $row['postings'] == 1 ) ? $lang['Post'] : $lang['Posts'] ))
					);
					continue;
				}

				$ip = decode_ip($row['poster_ip']);
				$ip = ( $rdns_ip_num == $ip || $rdns_ip_num == 'all' ) ? @gethostbyaddr($ip) : $ip;

				$row_color = (!($i % 2)) ? $theme['td_color1'] : $theme['td_color2'];
				$row_class = (!($i % 2)) ? $theme['td_class1'] : $theme['td_class2'];

				$template->assign_block_vars('iprow', array(
					'ROW_COLOR' => '#' . $row_color, 
					'ROW_CLASS' => $row_class, 
					'IP' => $ip,
					'POSTS' => $row['postings'] . ' ' . ( ( $row['postings'] == 1 ) ? $lang['Post'] : $lang['Posts'] ),
					'U_LOOKUP_IP' => "modcp.$phpEx?mode=ip&amp;" . POST_POST_URL . "=$post_id&amp;" . POST_TOPIC_URL . "=$topic_id&amp;rdns=" . $ip . "&amp;sid=" . $userdata['session_id'])
				);

				$i++; 
			}
			while ( $row = $db->sql_fetchrow($result) );
		}

		// Get other users who've posted under this IP
		$sql = "SELECT u.user_id, u.username, COUNT(*) as postings 
			FROM (" . USERS_TABLE ." u, " . POSTS_TABLE . " p)
			WHERE p.poster_id = u.user_id 
				AND p.poster_ip = '" . $post_row['poster_ip'] . "'
			GROUP BY u.user_id, u.username
			ORDER BY " . (( SQL_LAYER == 'msaccess' ) ? 'COUNT(*)' : 'postings' ) . " DESC";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not get posters information based on IP', '', __LINE__, __FILE__, $sql);
		}

		if ( $row = $db->sql_fetchrow($result) )
		{
			$i = 0;
			do
			{
				$id = $row['user_id'];
				$username = ( $id == ANONYMOUS ) ? $lang['Guest'] : $row['username'];

				$template->assign_block_vars('userrow', array(
					'ROW_COLOR' => '#' . (!($i % 2)) ? $theme['td_color1'] : $theme['td_color2'],
					'ROW_CLASS' => (!($i % 2)) ? $theme['td_class1'] : $theme['td_class2'], 
					'USERNAME' => $username,
					'POSTS' => $row['postings'] . ' ' . ( ( $row['postings'] == 1 ) ? $lang['Post'] : $lang['Posts'] ),
					'L_SEARCH_POSTS' => sprintf($lang['Search_user_posts'], $username), 

					'U_PROFILE' => ($id == ANONYMOUS) ? "modcp.$phpEx?mode=ip&amp;" . POST_POST_URL . "=" . $post_id . "&amp;" . POST_TOPIC_URL . "=" . $topic_id . "&amp;sid=" . $userdata['session_id'] : append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$id"),
					'U_SEARCHPOSTS' => append_sid("search.$phpEx?search_author=" . (($id == ANONYMOUS) ? 'Anonymous' : urlencode($username)) . "&amp;showresults=topics"))
				);

				$i++;
			}
			while ( $row = $db->sql_fetchrow($result) );
		}

		$template->pparse('viewip');

		break;

	default:
		$page_title = $lang['Mod_CP'];
		include($phpbb_root_path . 'includes/page_header.'.$phpEx);

		$template->assign_vars(array(
			'FORUM_NAME' => $forum_name,

			'L_MOD_CP' => $lang['Mod_CP'],
			'L_MOD_CP_EXPLAIN' => $lang['Mod_CP_explain'],
			'L_SELECT' => $lang['Select'],
			'L_DELETE' => $lang['Delete'],
			'L_MOVE' => $lang['Move'],
			'L_LOCK' => $lang['Lock'],
			'L_UNLOCK' => $lang['Unlock'],
			'L_STICKY' => $lang['Sticky'],
			'L_ANNOUNCE' => $lang['Announce'],
			'L_NORMALISE' => $lang['Normalise'],
			'L_CHECK_ALL' => $lang['Mark_all'], 
			'L_UNCHECK_ALL' => $lang['Unmark_all'], 
			'L_TOPICS' => $lang['Topics'], 
			'L_REPLIES' => $lang['Replies'], 
			'L_LASTPOST' => $lang['Last_Post'], 
			'L_MERGE' => $lang['Merge'],
			'L_RESYNC' => $lang['Resync_page_title'],

			'S_RESYNC' => append_sid("resync_forum_stats.$phpEx"), 
			'U_VIEW_FORUM' => append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id"), 
			'S_HIDDEN_FIELDS' => '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" /><input type="hidden" name="' . POST_FORUM_URL . '" value="' . $forum_id . '" />',
			'S_MODCP_ACTION' => append_sid("modcp.$phpEx"))
		);
		if ( $is_auth['auth_delete'] )
		{
			$template->assign_block_vars('switch_auth_delete', array());
		}
		if ( $is_auth['auth_sticky'] )
		{
			$template->assign_block_vars('switch_auth_sticky', array());
		}
		if ( $is_auth['auth_announce'] )
		{
			$template->assign_block_vars('switch_auth_announce', array());
		}

		$template->set_filenames(array(
			'body' => 'modcp_body.tpl')
		);

		// Define censored word matches
		$orig_word = array();
		$replacement_word = array();
		$replacement_word_html = array();
		obtain_word_list($orig_word, $replacement_word, $replacement_word_html);

		$sql = "SELECT t.*, u.username, u.user_id, p.post_time
			FROM (" . TOPICS_TABLE . " t, " . USERS_TABLE . " u, " . POSTS_TABLE . " p)
			WHERE t.forum_id = $forum_id
				AND t.topic_poster = u.user_id
				AND p.post_id = t.topic_last_post_id
			$sotr_methods
			" . (($mode != 'mergepost' && $mode != 'mergetopic' && !$mergepost && !$mergetopic) ? "LIMIT $start, $user_topics_per_page" : '');
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain topic information', '', __LINE__, __FILE__, $sql);
		}

		while ( $row = $db->sql_fetchrow($result) )
		{
			$topic_title = '';

			if ( $row['topic_status'] == TOPIC_LOCKED )
			{
				$folder_img = $images['folder_locked'];
				$folder_alt = $lang['Topic_locked'];
			}
			else
			{
				if ( $row['topic_type'] == POST_GLOBAL_ANNOUNCE ) 
				{
					$folder_img = $images['folder_global_announce'];
					$folder_alt = $lang['Global_announcement'];
				}
				else if ( $row['topic_type'] == POST_ANNOUNCE )
				{
					$folder_img = $images['folder_announce'];
					$folder_alt = $lang['Topic_Announcement'];
				}
				else if ( $row['topic_type'] == POST_STICKY )
				{
					$folder_img = $images['folder_sticky'];
					$folder_alt = $lang['Topic_Sticky'];
				}
				else 
				{
					$folder_img = $images['folder'];
					$folder_alt = $lang['No_new_posts'];
				}
			}

			$topic_id = $row['topic_id'];
			$topic_type = $row['topic_type'];
			$topic_status = $row['topic_status'];

			if ( $topic_type == POST_GLOBAL_ANNOUNCE )
			{
				$topic_type = $lang['Topic_global_announcement'] . ' ';
			}
			else if ( $topic_type == POST_ANNOUNCE )
			{
				$topic_type = $lang['Topic_Announcement'] . ' ';
			}
			else if ( $topic_type == POST_STICKY )
			{
				$topic_type = $lang['Topic_Sticky'] . ' ';
			}
			else if ( $topic_status == TOPIC_MOVED )
			{
				$topic_type = $lang['Topic_Moved'] . ' ';
			}
			else
			{
				$topic_type = '';
			}
	
			if ( $row['topic_vote'] )
			{
				$topic_type .= $lang['Topic_Poll'] . ' ';
			}
	
			$topic_title = $row['topic_title'];
			if ( count($orig_word) )
			{
				$topic_title = preg_replace($orig_word, $replacement_word, $topic_title);
			}

			$topic_replies = $row['topic_replies'];

			$template->assign_block_vars('topicrow', array(
				'U_VIEW_TOPIC' => "modcp.$phpEx?mode=split&amp;" . POST_TOPIC_URL . "=$topic_id&amp;sid=" . $userdata['session_id'],

				'TOPIC_FOLDER_IMG' => $folder_img, 
				'TOPIC_TYPE' => $topic_type, 
				'TOPIC_TITLE' => $topic_title,
				'REPLIES' => $topic_replies,
				'FIRST_POST_TIME' => create_date($board_config['default_dateformat'], $row['topic_time'], $board_config['board_timezone']),
				'L_TOPIC_STARTED' => $lang['Topic_started'],

				'LAST_POST_TIME' => create_date($board_config['default_dateformat'], $row['post_time'], $board_config['board_timezone']),
				'TOPIC_ID' => $topic_id,
				'TOPIC_ATTACHMENT_IMG' => ( defined('ATTACHMENTS_ON') ) ? topic_attachment_image($row['topic_attachment']) : '',
					
				'L_TOPIC_FOLDER_ALT' => $folder_alt)
			);
		}
		if ( $mode != 'mergepost' && $mode != 'mergetopic' && !$mergepost && !$mergetopic )
		{
			generate_pagination("modcp.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'] . "", $forum_topics, $user_topics_per_page, $start);
		}

		$template->pparse('body');

		break;
}

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>