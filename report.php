<?php
/***************************************************************************
 *                        report.php
 *                        -------------------
 *   begin                : Saturday, Mar 30, 2002
 *   copyright            : (C) 2002 Saerdnaer
 *   email                : saerdnaer@web.de
 *   version              : 1.0.4
 *   modification		  : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   date modification	  : ver. 1.12.0 2005/10/08 17:13
 *
 ***************************************************************************/


define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/reportpost.'.$phpEx);

// Start session management
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
// End session management

if ( isset($HTTP_POST_VARS['mode']) )
{
	$mode = $HTTP_POST_VARS['mode'];
}
else if ( isset($HTTP_GET_VARS['mode']) )
{
	$mode = $HTTP_GET_VARS['mode'];
}
else
{
	$mode = '';
}

$forums_sql = '';

switch($mode)
{
	case 'report':
		if ( !$rp->report_auth($userdata['user_id']) )
		{
			message_die(GENERAL_MESSAGE, 'Report_no_auth');
		}
		if ( isset($HTTP_GET_VARS[POST_POST_URL]) )
		{
			$post_id = intval($HTTP_GET_VARS[POST_POST_URL]);
		}
		else
		{
			message_die(GENERAL_MESSAGE, 'No_such_post');
		}

		$sql = "SELECT p.post_id, p.forum_id, p.poster_id, u.username AS postername, p.post_username, p.reporter_id
			FROM (" . POSTS_TABLE . " p, " . USERS_TABLE . " u)
			WHERE p.post_id = " . intval($post_id) . "
				AND u.user_id = p.poster_id";
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Couldn\'t obtain posts information.', '', __LINE__, __FILE__, $sql);
		}
		if ( !$data = $db->sql_fetchrow($result) )
		{
			message_die(GENERAL_MESSAGE, 'No_such_post');
		}
		if ( $rp->report_disabled($data['poster_id']) )
		{
			message_die(GENERAL_MESSAGE, 'Report_disabled');
		}
		if ( !empty($data['reporter_id']) )
		{
			message_die(GENERAL_MESSAGE, 'Report_post_already_reported');
		}
		if ( $userdata['session_logged_in'] && $data['poster_id'] == $userdata['user_id'] )
		{
			message_die(GENERAL_MESSAGE, 'Report_post_self');
		}

		if ( !isset($HTTP_POST_VARS['confirm']) )
		{
			confirm($lang['confirm_report_post'], append_sid("report.$phpEx?mode=report&amp;" . POST_POST_URL . "=" . $post_id));
		}
		else if ( isset($HTTP_POST_VARS['cancel']) )
		{
			redirect(append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=" . $post_id . "#" . $post_id, true));
		}

		$sql = "UPDATE " . POSTS_TABLE . "
			SET reporter_id = " . $userdata['user_id'] ."
			WHERE post_id = " . $data['post_id'];
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Couldn\'t report the post.', '', __LINE__, __FILE__, $sql);
		}

		$rp->open_refresh_report_popup($data['forum_id']);
		$data['reportername'] = $userdata['username'];
		$rp->do_notification($data['forum_id'], $data);

		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=" . $data['post_id']) . '#' . $data['post_id'] . '">')
		);

		message_die(GENERAL_MESSAGE, $lang['Report_post_reported'] . '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=" . $data['post_id']) . '#' . $data['post_id'] . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_forum'], '<a href="' . append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=" . $data['forum_id']) . '">', '</a>'));
		break;

	case 'del_report':
		if ( !$userdata['session_logged_in'] )
		{
			message_die(GENERAL_MESSAGE, 'Report_no_access');
		}

		if ( isset($HTTP_GET_VARS[POST_POST_URL]) )
		{
			$post_id = intval($HTTP_GET_VARS[POST_POST_URL]);
		}
		else
		{
			message_die(GENERAL_MESSAGE, 'No_such_post');
		}

		$sql = "SELECT post_id, topic_id, forum_id, reporter_id
			FROM " . POSTS_TABLE . "
			WHERE post_id = " . intval($post_id);

		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Couldn\'t obtain posts information.', '', __LINE__, __FILE__, $sql);
		}
		if ( !($data = $db->sql_fetchrow($result)) )
		{
			message_die(GENERAL_MESSAGE, 'No_such_post');
		}
		if ( $data['reporter_id'] == 0 )
		{
			message_die(GENERAL_MESSAGE, 'Report_already_removed');
		}
		if ( $userdata['user_level'] > USER || ( $userdata['session_logged_in'] && $data['reporter_id'] == $userdata['user_id'] ) )
		{
			if ( $userdata['user_level'] != ADMIN && $data['reporter_id'] != $userdata['user_id'] )
			{
				$is_auth = auth(AUTH_MOD, $data['forum_id'], $userdata);

				if ( !$is_auth['auth_mod'] )
				{
					message_die(GENERAL_MESSAGE, 'Report_no_access');
				}
			}

			$sql = "UPDATE " . POSTS_TABLE . " SET
				reporter_id = 0
				WHERE post_id = " . $data['post_id'];

			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Couldn\'t delete the report.', '', __LINE__, __FILE__, $sql);
			}

			$rp->update_refresh_report_popup($data['forum_id']);

			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=" . $data['post_id']) . '#' . $data['post_id'] . '">')
			);

			message_die(GENERAL_MESSAGE, $lang['Report_deleted'] . '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=" . $data['post_id']) . '#' . $data['post_id'] . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_forum'], '<a href="' . append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=" . $data['forum_id']) . '">', '</a>'));
		}
		message_die(GENERAL_MESSAGE, 'Report_no_access');
		break;

	case 'popup':
		$gen_simple_header = true;
		$no_report_popup = true;

		$rp->check_access("report.$phpEx?mode=popup", true);

		// Start output of page
		$page_title = $lang['Report_posts'];

		include($phpbb_root_path . 'includes/page_header.'.$phpEx);

		$forums_sql = $rp->get_forum_auth_sql($userdata, 'f.');

		$sql = "SELECT f.forum_name, f.forum_id, t.topic_title, t.topic_id, p.post_id, pt.post_subject, p.post_username, u.username, u.user_id, u2.username as reportername, u2.user_id as reporter_id
			FROM (" . FORUMS_TABLE . " f, " . TOPICS_TABLE . " t, " . POSTS_TABLE . " p, " . POSTS_TEXT_TABLE . " pt)
				LEFT JOIN " . USERS_TABLE . " u ON (u.user_id = p.poster_id)
				LEFT JOIN " . USERS_TABLE . " u2 ON (u2.user_id = p.reporter_id)
			WHERE p.reporter_id <> 0
				$forums_sql
				AND f.forum_id = p.forum_id
				AND t.topic_id = p.topic_id
				AND pt.post_id = p.post_id
				ORDER BY p.post_id ASC";

		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Error by getting reported posts.', '', __LINE__, __FILE__, $sql);
		}

		$rp->reset_refresh_report_popup($userdata['user_id']);

		if ( $db->sql_numrows($result) > 0 )
		{
			$template->set_filenames(array('body' => 'report_popup_body.tpl'));
			if ( $board_config['report_popup_links_target'] == 1 )
			{
				$template->assign_block_vars('links_target_1', array());
			}
			else
			{
				$template->assign_block_vars('links_target_0', array());
			}

			$template->assign_vars(array(
				'TEXT' => $lang['Report_popup_text'],
				'L_FORUM' => $lang['Forum'],
				'L_TOPIC' => $lang['Topic'],
				'L_POST' => $lang['Post'],
				'L_AUTHOR' => $lang['Author'],
				'L_REPORTER' => $lang['Reporter'],
				'L_CLOSE_WINDOW' => $lang['Close_window'],
				'L_RELOAD_WINDOW' => $lang['Report_reload_window'],
				'S_POST_IMG' => $images['icon_minipost'])
			);

			while ( $row = $db->sql_fetchrow($result) )
			{
				$u_forum = append_sid($phpbb_root_path . "viewforum.$phpEx?" . POST_FORUM_URL . "=" . $row['forum_id']);
				$u_topic = append_sid($phpbb_root_path . "viewtopic.$phpEx?" . POST_TOPIC_URL . "=" . $row['topic_id']);
				$u_post = append_sid($phpbb_root_path . "viewtopic.$phpEx?" . POST_POST_URL . "=" . $row['post_id']) . "#" . $row['post_id'];
				$u_author = append_sid($phpbb_root_path . "profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']);
				$u_reporter = append_sid($phpbb_root_path . "profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['reporter_id']);

				$template->assign_block_vars("postrow", array(
					'FORUM' => $row['forum_name'],
					'TOPIC' => $row['topic_title'],
					'POST' => $row['post_subject'] ? $row['post_subject'] : $lang['Report_no_title'],
					'AUTHOR' => ($row['user_id'] == -1 ? ( empty($row['post_username']) ? $lang['Guest'] : $row['post_username'] ) : $row['username']),
					'REPORTER' => ($row['reporter_id'] == -1 ? $lang['Guest'] : $row['reportername']),

					'U_FORUM' => $u_forum,
					'U_FORUM_ONCLICK' => ($board_config['report_popup_links_target'] == 2 ? 'onClick="open2(\'' . $u_forum . '\');return false;"' : ''),
					'U_TOPIC' => $u_topic,
					'U_TOPIC_ONCLICK' => ($board_config['report_popup_links_target'] == 2 ? 'onClick="open2(\'' . $u_topic . '\');return false;"' : ''),
					'U_POST' => $u_post,
					'U_POST_ONCLICK' => ($board_config['report_popup_links_target'] == 2 ? 'onClick="open2(\'' . $u_post . '\');return false;"' : ''),
					'U_AUTHOR' => $u_author,
					'U_AUTHOR_ONCLICK' => ($board_config['report_popup_links_target'] == 2 ? 'onClick="open2(\'' . $u_author . '\');return false;"' : ''),
					'U_REPORTER' => $u_reporter,
					'U_REPORTER_ONCLICK' => ($board_config['report_popup_links_target'] == 2 ? 'onClick="open2(\'' . $u_reporter . '\');return false;"' : ''))
				);

				$template->assign_block_vars('postrow.' . ($row['user_id'] == -1 ? 'no_' : '') . 'u_author', array());
				$template->assign_block_vars('postrow.' . ($row['reporter_id'] == -1 ? 'no_' : '') . 'u_reporter', array());
			}
			$template->pparse('body');

			include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
		}
		else
		{
			$js = '<script language="Javascript" type="text/javascript">
			<!--
				' . "\n" . 'window.setTimeout("window.close()", 3000);' . "\n" . '
			//-->
			</script>';
			message_die(GENERAL_MESSAGE, $lang['Report_no_posts'] . $js);
		}
		break;
	default:
		$no_report_popup = true;
		$rp->check_access("report.$phpEx", true);

		// Start output of page
		$page_title = $lang['Report_posts'];

		include($phpbb_root_path . 'includes/page_header.'.$phpEx);

		$forums_sql = $rp->get_forum_auth_sql($userdata, 'f.');

		$sql = "SELECT f.forum_name, f.forum_id, t.topic_title, t.topic_id, p.post_id, pt.post_subject, p.post_username, u.username, u.user_id, u2.username as reportername, u2.user_id as reporter_id
			FROM (" . FORUMS_TABLE . " f, " . TOPICS_TABLE . " t, " . POSTS_TABLE . " p, " . POSTS_TEXT_TABLE . " pt)
				LEFT JOIN " . USERS_TABLE . " u ON (u.user_id = p.poster_id)
				LEFT JOIN " . USERS_TABLE . " u2 ON (u2.user_id = p.reporter_id)
			WHERE p.reporter_id <> 0
				$forums_sql
				AND f.forum_id = p.forum_id
				AND t.topic_id = p.topic_id
				AND pt.post_id = p.post_id
				ORDER BY p.post_id ASC";

		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Error by getting reported posts.', '', __LINE__, __FILE__, $sql);
		}
		$rp->reset_refresh_report_popup($userdata['user_id']);

		if ( $db->sql_numrows($result) > 0 )
		{
			$template->set_filenames(array('body' => 'report_list_body.tpl'));
			$template->assign_block_vars('links_target_' . $board_config['report_popup_links_target'], array());

			$template->assign_vars(array(
				'TEXT' => $lang['Report_popup_text'],

				'L_FORUM' => $lang['Forum'],
				'L_TOPIC' => $lang['Topic'],
				'L_POST' => $lang['Post'],
				'L_AUTHOR' => $lang['Author'],
				'L_REPORTER' => $lang['Reporter'],
				'L_CLOSE_WINDOW' => $lang['Close_window'],
				'L_RELOAD_WINDOW' => $lang['Report_reload_window'],
				'L_OPEN_POPUP' => $lang['Report_open_popup'],

				'S_POST_IMG' => $images['icon_minipost'],
				'S_WIDTH' => $board_config['report_popup_width'],
				'S_HEIGHT' => $board_config['report_popup_height'],

				'U_REPORT_POPUP' => append_sid('report.'.$phpEx.'?mode=popup'))
			);

			while ( $row = $db->sql_fetchrow($result) )
			{
				$template->assign_block_vars("postrow", array(
					'FORUM' => $row['forum_name'],
					'TOPIC' => $row['topic_title'],
					'POST' => $row['post_subject'] ? $row['post_subject'] : $lang['Report_no_title'],
					'AUTHOR' => ($row['user_id'] == -1 ? ( empty($row['post_username']) ? $lang['Guest'] : $row['post_username'] ) : $row['username']),
					'REPORTER' => ($row['reporter_id'] == -1 ? $lang['Guest'] : $row['reportername']),

					'U_FORUM' => append_sid($phpbb_root_path . "viewforum.$phpEx?" . POST_FORUM_URL . "=" . $row['forum_id']),
					'U_TOPIC' => append_sid($phpbb_root_path . "viewtopic.$phpEx?" . POST_TOPIC_URL . "=" . $row['topic_id']),
					'U_POST' => append_sid($phpbb_root_path . "viewtopic.$phpEx?" . POST_POST_URL . "=" . $row['post_id']) . "#" . $row['post_id'],
					'U_AUTHOR' => append_sid($phpbb_root_path . "profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']),
					'U_REPORTER' => append_sid($phpbb_root_path . "profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['reporter_id']))
				);

				$template->assign_block_vars('postrow.' . ($row['user_id'] == -1 ? 'no_' : '') . 'u_author', array());
				$template->assign_block_vars('postrow.' . ($row['reporter_id'] == -1 ? 'no_' : '') . 'u_reporter', array());
			}

			$template->pparse('body');

			include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
		}
		else
		{
			message_die(GENERAL_MESSAGE, $lang['Report_no_posts']);
		}
		break;
}
?>