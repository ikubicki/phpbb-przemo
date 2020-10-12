<?php
/***************************************************************************
 *                  update.php
 *                  -------------------
 *   begin          : 11, 12, 2005
 *   copyright      : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   email          : przemo@przemo.org
 *   version        : ver. 1.12.8 2012/08/26 21:44
 *
 ***************************************************************************/

define('FILE_CHECKSUM', 'e0584ce4ced2922ea3c881c2fb1b9754');

define('IN_PHPBB', true);
$phpbb_root_path = '../';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);

@set_time_limit('300');

include($phpbb_root_path . 'scripts/lang_' . $board_config['default_lang'] . '/lang_update.' . $phpEx);

if( !function_exists('xhtmlspecialchars') ){
	function xhtmlspecialchars($s) {
		return htmlspecialchars($s, ENT_COMPAT | ENT_HTML401, "ISO-8859-1");
	}
}

$gen_simple_header = true;

$file = ($HTTP_POST_VARS['file'] == 1) ? true : false;

if ( $dbms && strpos($dbms, 'mysql') === false )
{
	message_die(GENERAL_MESSAGE, $lang['No_available_db']);
}

function show_keys($table, $error = true)
{
	global $db, $table_prefix;

	$keys = array();

	$sql = "SHOW COLUMNS FROM " . $table_prefix . $table;
	if ( !($result = $db->sql_query($sql)) )
	{
		if ( !$error )
		{
			return;
		}
	}
	while ( $row = $db->sql_fetchrow($result) )
	{
		if ( $row['Key'] )
		{
			$keys[] = $row['Field'];
		}
	}
	return $keys;
}

function md5_checksum($file)
{
	if ( @file_exists($file) )
	{
		$fd = @fopen($file, 'r');
		$fileContents = @fread($fd, @filesize($file));
		@fclose($fd);
		return md5($fileContents);
	}
	else
	{
		return false;
	}
}
function check_security()
{
	global $phpbb_root_path, $lang;
	$dir_check = array('tmp', 'files', 'files/tmp', 'files/thumbs', 'images/avatars', 'images/avatars/tmp', 'images/avatars/upload', 'images/avatars/upload/tmp', 'images/photos/tmp', 'images/signatures', 'images/signatures/tmp');
	if (@phpversion() >= '4.3.0')
	{
		$dangerous_files = array();
		$path_len = strlen($phpbb_root_path);
		for($i = 0; $i < count($dir_check); $i++)
		{
			if (!is_dir($phpbb_root_path . $dir_check[$i]))
			{
				continue;
			}
			$_g = @glob($phpbb_root_path . $dir_check[$i] . "/*.php");
			if (! is_array($_g)) continue;
//			foreach( glob($phpbb_root_path . $dir_check[$i] . "/*.php") as $filename ) // can generate foreach error messages
			foreach( $_g as $filename )
			{
				if (@basename($filename) == 'index.php')
				{
					if (@filesize($filename) < 300)
					{
						continue;
					}
				}
				$dangerous_files[] = substr($filename, $path_len);
			}
		}
		if (count($dangerous_files) > 0)
		{
			return '<font style="color:#ff0000; font-weight: bold;">' . $lang['dangerous_files'] . '</font>: <br /><pre>' . implode("\n", $dangerous_files) . '</pre>';
		}
	}
	return '';
}

if ( $userdata['user_level'] != ADMIN )
{
	message_die(GENERAL_ERROR, $lang['no_admin']);
}

include($phpbb_root_path . 'includes/functions_selects.'.$phpEx);

$message = '';

if ( $HTTP_POST_VARS['mode'] != 'go' )
{
	$message = '<form style="display: inline;" action="' . append_sid("update.$phpEx", false, true) . '" method="post" target="_top"><table align="center" width="100%"><tr><td class="row1" align="center"><span class="gen">' . $lang['update_body'] . '<br /><br /></span></td></tr><tr><td align="right" class="row1"><span class="gensmall">' . $lang['Generate_file'] . '<input type="checkbox" name="file" value="1" /></span></td></tr><tr><td align="center"><input type="hidden" name="mode" value="go" /><input type="hidden" name="sid" value="' . $userdata['session_id'] . '" /><input type="submit" name="submit" class="mainoption" value="' . $lang['start_update'] . '" /></td></tr></table></form>';
	$message .= '<br />' . check_security();

}
else
{
	include($phpbb_root_path.'includes/sql_parse.'.$phpEx);

	$dbms_basic = './update.sql';
	$dbms_basic_orig = './update_orig.sql';

	if ( !($fp = @fopen($dbms_basic, 'r')) )
	{
		message_die(GENERAL_MESSAGE, "Can't open " . $dbms_basic);
	}
	@fclose($fp);

	if ( md5_checksum($dbms_basic) != FILE_CHECKSUM )
	{
		message_die(GENERAL_MESSAGE, sprintf($lang['checksum_error'], $dbms_basic, md5_checksum($dbms_basic)) );
	}

	$sql_query = @fread(@fopen($dbms_basic, 'r'), @filesize($dbms_basic));
	$sql_query = preg_replace('/phpbb_/', $table_prefix, $sql_query);
	$sql_query = remove_remarks($sql_query);
	$sql_query = split_sql_file($sql_query, ';');

	// Undesirable queries when not necessarily.
	$sql = "SELECT * FROM " . $table_prefix . "config WHERE config_name = 'cagent'";
	$result = $db->sql_query($sql);
	$orig = ($row = $db->sql_fetchrow($result)) ? false : true;

	if ( $orig )
	{
		if ( !($fp = @fopen($dbms_basic_orig, 'r')) )
		{
			message_die(GENERAL_MESSAGE, "Can't open " . $dbms_basic_orig);
		}
		fclose($fp);

		$sql_query_orig = @fread(@fopen($dbms_basic_orig, 'r'), @filesize($dbms_basic_orig));
		$sql_query_orig = preg_replace('/phpbb_/', $table_prefix, $sql_query_orig);
		$sql_query_orig = remove_remarks($sql_query_orig);
		$sql_query_orig = split_sql_file($sql_query_orig, ';');
		$sql_query = array_merge($sql_query, $sql_query_orig);
	}

	$sql_query_n = array();
	$sql = "SELECT post_time FROM " . $table_prefix . "read_history LIMIT 1";
	if ( $result = $db->sql_query($sql) )
	{
		$sql_query_n[] = "DROP TABLE " . $table_prefix . "read_history";
	}

	$topic_view_keys = show_keys('topic_view', false);
	if ( $topic_view_keys[0] != 'topic_id' || $topic_view_keys[1] != 'user_id' )
	{
		$sql_query_n[] = "DROP TABLE " . $table_prefix . "topic_view";
	}

	$ignores_keys = show_keys('ignores', false);
	if ( $ignores_keys[0] != 'user_id' || $ignores_keys[1] != 'user_ignore' )
	{
		$sql_query_n[] = "DROP TABLE " . $table_prefix . "ignores";
	}

	$sql = "SELECT warning_viewed FROM " . $table_prefix . "users_warnings LIMIT 1";
	if ( !($result = $db->sql_query($sql)) )
	{
		$sql_query[] = "UPDATE " . $table_prefix . "users_warnings SET warning_viewed = '1'";
	}

	if ( count($sql_query_n) )
	{
		$sql_query = array_merge($sql_query_n, $sql_query);
	}

	$changed_fields = array(

		'anti_robotic_reg' => array(
			'reg_key' => array('Type' => 'char(4)', 'Default' => "''", 'params' => "NOT NULL")),

		'auth_access' => array(
			'auth_globalannounce' => array('Type' => 'tinyint(1)', 'Default' => "'0'", 'params' => "NOT NULL")),

		'banlist' => array(
			'ban_userid' => array('Type' => 'mediumint(8)', 'Default' => "'0'", 'params' => "NOT NULL"),
			'ban_ip' => array('Type' => 'char(8)', 'Default' => "''", 'params' => "NOT NULL"),
			'ban_email' => array('Type' => 'varchar(255)', 'Default' => "NULL")),

		'categories' => array(
			'cat_title' => array('Type' => 'varchar(254)', 'Default' => "NULL"),
			'cat_order' => array('Type' => 'mediumint(8)', 'Default' => "'0'", 'params' => "UNSIGNED NOT NULL")),

		'config' => array(
			'config_name' => array('Type' => 'varchar(255)', 'Default' => "''", 'params' => "NOT NULL"),
			'config_value' => array('Type' => 'text', 'params' => "NOT NULL")),

		'disallow' => array(
			'disallow_username' => array('Type' => 'varchar(25)', 'Default' => "''", 'params' => "NOT NULL")),

		'forums' => array(
			'forum_id' => array('Type' => 'smallint(5)', 'Default' => "'0'", 'params' => "UNSIGNED NOT NULL"),
			'cat_id' => array('Type' => 'mediumint(8)', 'Default' => "'0'", 'params' => "UNSIGNED NOT NULL"),
			'forum_name' => array('Type' => 'varchar(254)', 'Default' => "''"),
			'forum_status' => array('Type' => 'tinyint(1)', 'Default' => "'0'", 'params' => "NOT NULL"),
			'forum_color' => array('Type' => 'varchar(6)', 'Default' => "''", 'params' => "NOT NULL"),
			'prune_next' => array('Type' => 'int(11)', 'Default' => "NULL"),
			'forum_sort' => array('Type' => 'varchar(12)', 'params' => "NOT NULL"),
			'forum_link_internal' => array('Type' => 'tinyint(1)', 'Default' => "'0'", 'params' => "NOT NULL"),
			'forum_link_hit_count' => array('Type' => 'tinyint(1)', 'Default' => "'0'", 'params' => "NOT NULL"),
			'forum_link_hit' => array('Type' => 'bigint(20)', 'Default' => "'0'", 'params' => "UNSIGNED NOT NULL"),
			'main_type' => array('Type' => 'char(1)', 'Default' => "NULL")),

		'forum_prune' => array(
			'forum_id' => array('Type' => 'smallint(5)', 'Default' => "'0'", 'params' => "UNSIGNED NOT NULL"),
			'prune_days' => array('Type' => 'smallint(5)', 'Default' => "'0'", 'params' => "UNSIGNED NOT NULL"),
			'prune_freq' => array('Type' => 'smallint(5)', 'Default' => "'0'", 'params' => "UNSIGNED NOT NULL")),

		'groups' => array(
			'group_name' => array('Type' => 'varchar(120)', 'Default' => "''", 'params' => "NOT NULL")),

		'jr_admin_users' => array(
			'user_jr_admin' => array('Type' => 'varchar(254)', 'Default' => "''", 'params' => "NOT NULL")),

		'logs' => array(
			'id_log' => array('Type' => 'mediumint(10)', 'params' => "NOT NULL AUTO_INCREMENT")),

		'posts' => array(
			'poster_ip' => array('Type' => 'char(8)', 'Default' => "''", 'params' => "NOT NULL"),
			'post_username' => array('Type' => 'varchar(25)', 'Default' => "''", 'params' => "NOT NULL"),
			'post_edit_time' => array('Type' => 'int(11)', 'Default' => "'0'", 'params' => "NULL"),
			'user_agent' => array('Type' => 'varchar(255)', 'Default' => "''", 'params' => "NOT NULL"),
			'post_expire' => array('Type' => 'int(11)', 'Default' => "'0'", 'params' => "NOT NULL")),

		'posts_text' => array(
			'post_subject' => array('Type' => 'char(60)', 'Default' => "''", 'params' => "NOT NULL"),
			'bbcode_uid' => array('Type' => 'char(10)', 'Default' => "''", 'params' => "NOT NULL")),

		'profile_fields' => array(
			'min_value' => array('Type' => 'int(8)', 'Default' => "'1'", 'params' => "NOT NULL"),
			'max_value' => array('Type' => ' int(8)', 'Default' => "'45'", 'params' => "NOT NULL")),

		'privmsgs' => array(
			'privmsgs_ip' => array('Type' => 'char(8)', 'Default' => "''", 'params' => "NOT NULL")),

		'ranks' => array(
			'rank_title' => array('Type' => 'varchar(50)', 'Default' => "''", 'params' => "NOT NULL"),
			'rank_image' => array('Type' => 'varchar(255)', 'Default' => "''"),
			'rank_group' => array('Type' => 'mediumint(8)', 'Default' => "'0'", 'params' => "NOT NULL")),

		'smilies' => array(
			'code' => array('Type' => 'varchar(50)', 'Default' => "''"),
			'smile_url' => array('Type' => 'varchar(100)', 'Default' => "''")),

		'shoutbox' => array(
			'msg' => array('Type' => 'text', 'params' => "NOT NULL")),

		'search_results' => array(
			'search_array' => array('Type' => 'longtext', 'params' => "NOT NULL")),

		'topics' => array(
			'topic_title' => array('Type' => 'char(60)', 'Default' => "''", 'params' => "NOT NULL"),
			'topic_status' => array('Type' => 'tinyint(1)', 'Default' => "'0'", 'params' => "NOT NULL"),
			'topic_type' => array('Type' => 'tinyint(1)', 'Default' => "'0'", 'params' => "NOT NULL"),
			'topic_title_e' => array('Type' => 'char(100)', 'Default' => "''", 'params' => "NOT NULL"),
			'topic_action_user' => array('Type' => 'mediumint(8)', 'Default' => "'0'", 'params' => "NOT NULL"),
			'topic_expire' => array('Type' => 'int(11)', 'Default' => "'0'", 'params' => "NOT NULL"),
			'topic_accept' => array('Type' => 'tinyint(1)', 'Default' => "'1'", 'params' => "NOT NULL"),
			'topic_color' => array('Type' => 'varchar(8)', 'Default' => "NULL")),

		'users' => array(
			'user_timezone' => array('Type' => 'decimal(5,2)', 'Default' => "'0'", 'params' => "NOT NULL"),
			'user_notify_pm' => array('Type' => 'tinyint(1)', 'Default' => "'0'", 'params' => "NOT NULL"),
			'user_id' => array('Type' => 'mediumint(8)', 'Default' => "'0'", 'params' => "NOT NULL"),
			'username' => array('Type' => 'varchar(25)', 'Default' => "''", 'params' => "NOT NULL"),
			'user_password' => array('Type' => 'varchar(40)', 'Default' => "''", 'params' => "NOT NULL"),
			'user_level' => array('Type' => 'tinyint(1)', 'Default' => "'0'"),
			'user_posts' => array('Type' => 'mediumint(6)', 'Default' => "'0'", 'params' => "UNSIGNED NOT NULL"),
			'user_style' => array('Type' => 'tinyint(2)', 'Default' => "'1'", 'params' => "NULL"),
			'user_lang' => array('Type' => 'varchar(12)', 'Default' => "''", 'params' => "NOT NULL"),
			'user_emailtime' => array('Type' => 'int(11)', 'Default' => "'0'"),
			'user_viewemail' => array('Type' => 'tinyint(1)', 'Default' => "'1'"),
			'user_attachsig' => array('Type' => 'tinyint(1)', 'Default' => "'1'"),
			'user_avatar' => array('Type' => 'varchar(100)', 'Default' => "''"),
			'user_email' => array('Type' => 'varchar(255)', 'Default' => "''"),
			'user_icq' => array('Type' => 'varchar(15)', 'Default' => "''"),
			'user_website' => array('Type' => 'varchar(255)', 'Default' => "''"),
			'user_from' => array('Type' => 'varchar(64)', 'Default' => "''"),
			'user_aim' => array('Type' => 'varchar(255)', 'Default' => "''"),
			'user_yim' => array('Type' => 'varchar(255)', 'Default' => "''"),
			'user_msnm' => array('Type' => 'varchar(255)', 'Default' => "''"),
			'user_occ' => array('Type' => 'varchar(100)', 'Default' => "''"),
			'user_interests' => array('Type' => 'varchar(255)', 'Default' => "''"),
			'user_actkey' => array('Type' => 'varchar(32)', 'Default' => "''"),
			'user_newpasswd' => array('Type' => 'varchar(40)', 'Default' => "''"),
			'user_custom_rank' => array('Type' => 'varchar(100)', 'Default' => "''"),
			'user_photo' => array('Type' => 'varchar(100)', 'Default' => "''"),
			'user_photo_type' => array('Type' => 'tinyint(1)', 'Default' => "'0'", 'params' => "NOT NULL"),
			'user_badlogin' => array('Type' => 'smallint(2)', 'Default' => "'0'", 'params' => "NOT NULL"),
			'user_blocktime' => array('Type' => 'int(11)', 'Default' => "'0'", 'params' => "NOT NULL"),
			'user_block_by' => array('Type' => 'char(8)', 'Default' => "''"),
			'user_gender' => array('Type' => 'tinyint(1)', 'Default' => "'0'", 'params' => "NOT NULL"),
			'user_avatar_height' => array('Type' => 'smallint(3)', 'Default' => "NULL"),
			'user_avatar_width' => array('Type' => 'smallint(3)', 'Default' => "NULL")),

		'user_group' => array('user_pending' => array('Type' => 'tinyint(1)', 'Default' => "NULL")),

		'vote_voters' => array(
			'vote_user_ip' => array('Type' => 'char(8)', 'Default' => "''", 'params' => "NOT NULL")),

		'word' => array(
			'word' => array('Type' => 'char(100)', 'Default' => "''", 'params' => "NOT NULL"),
			'replacement' => array('Type' => 'text', 'Default' => "NULL", 'params' => "NOT NULL"))
	);

	function ru($str)
	{
		return str_replace(array(' ', 'unsigned', 'UNSIGNED', "'"), '', $str);
	}

	foreach($changed_fields as $table => $field)
	{
		$table_fields = array();
		$sql = "SHOW COLUMNS FROM " . $table_prefix . $table;
		if ( $result = $db->sql_query($sql) )
		{
			while ( $row = $db->sql_fetchrow($result) )
			{
				$table_fields[$row['Field']] = array('Type' => $row['Type'], 'Default' => $row['Default']);
			}

			foreach($field as $key => $val)
			{
				if ( ru($val['Type']) != ru($table_fields[$key]['Type']) || ru($val['Default']) != $table_fields[$key]['Default'] )
				{
					$sql_query[] = "ALTER TABLE " . $table_prefix . $table . " CHANGE $key $key " . $val['Type'] . ((isset($val['params'])) ? " " . $val['params'] : "") . ((isset($val['Default'])) ? " DEFAULT " . $val['Default'] : "");
				}
			}
		}
	}

	$j = 0;
	$ok = $no_ok = 0;

	$file_query = '';

	for($i = 0; $i < count($sql_query); $i++)
	{
		if ( $file )
		{
			$file_query .= xhtmlspecialchars($sql_query[$i]) . ";<br /><br />";
		}
		else
		{
			if ( !($result = $db->sql_query($sql_query[$i])) )
			{
				$error = $db->sql_error();
				$row = ($no_ok % 2) ? 2 : 1;
				$cur_query = (strlen($sql_query[$i]) > 150) ? substr($sql_query[$i], 0, 150) . '[...]' : $sql_query[$i];
				$message .= '<tr><td class="row' . $row . '"><span class="gensmall">' . xhtmlspecialchars($cur_query) . '<br /><u><b>' . $lang['failed'] . '</b></u> - <b>' . xhtmlspecialchars($error['message']) . '</b></span></td></tr>';
				$no_ok++;
			} else $ok++;
		}
	}

	$tables_keys = array(
		'attachments' => array('user_id_1', 'user_id_2'),
		'search_wordmatch' => array('post_id'),
		'user_group' => array('user_pending'),
		'forums' => array('no_count'),
		'posts' => array('reporter_id', 'post_parent', 'post_approve'),
		'privmsgs' => array('privmsgs_type'),
		'sessions' => array('session_time'),
		'topics' => array('topic_poster', 'topic_last_post_id', 'topic_first_post_id', 'topic_vote'),
		'groups' => array('group_type'),
		'pa_files' => array('file_catid'),
		'users_warnings' => array('archive', 'warning_viewed', 'date', 'userid', 'modid'),
		'users' => array('user_level', 'user_lastvisit', 'user_active')
	);

	foreach($tables_keys as $table => $keys)
	{
		$existing_keys = show_keys($table);
		for($i = 0; $i < count($keys); $i++)
		{
			if ( !is_array($existing_keys) || !@in_array($keys[$i], $existing_keys) )
			{
				$sql = "ALTER TABLE " . $table_prefix . $table . " ADD INDEX " . $keys[$i] . " (" . $keys[$i] . ")";
				if ( $file )
				{
					$file_query .= xhtmlspecialchars($sql) . ";<br /><br />";
				}
				else
				{
					if ( !($result = $db->sql_query($sql)) )
					{
						$error = $db->sql_error();
						$row = ($no_ok % 2) ? 2 : 1;
						$cur_query = (strlen($sql) > 150) ? substr($sql, 0, 150) . '[...]' : $sql;
						$message .= '<tr><td class="row' . $row . '"><span class="gensmall">' . xhtmlspecialchars($cur_query) . '<br /><u><b>' . $lang['failed'] . '</b></u> - <b>' . xhtmlspecialchars($error['message']) . '</b></span></td></tr>';
						$no_ok++;
					} else $ok++;
				}
			}
		}
	}

	if ( !$file )
	{
		$sql = "SELECT username, user_id
			FROM " . $table_prefix . "users
			WHERE user_id <> '-1'
			ORDER BY user_id DESC
			LIMIT 1";
		if ( $result = $db->sql_query($sql) )
		{
			$row = $db->sql_fetchrow($result);

			$sql = "UPDATE " . $table_prefix . "config
				SET config_value = '" . str_replace("'", "''", serialize($row)) . "'
				WHERE config_name = 'newestuser'";
			$db->sql_query($sql);
		}
		$sql = "SELECT COUNT(user_id) AS total
			FROM " . $table_prefix . "users
			WHERE user_id <> '-1'";
		if ( $result = $db->sql_query($sql) )
		{
			$row = $db->sql_fetchrow($result);

			$sql = "UPDATE " . $table_prefix . "config
				SET config_value = '" . $row['total'] . "'
				WHERE config_name = 'usercount'";
			$db->sql_query($sql);
		}

		$sql = "SELECT SUM(forum_topics) AS topic_total, SUM(forum_posts) AS post_total
			FROM " . $table_prefix . "forums";
		if ( $result = $db->sql_query($sql) )
		{
			$row = $db->sql_fetchrow($result);

			$sql = "UPDATE " . $table_prefix . "config
				SET config_value = '" . $row['topic_total'] . "'
				WHERE config_name = 'topiccount'";
			$db->sql_query($sql);

			$sql = "UPDATE " . $table_prefix . "config
				SET config_value = '" . $row['post_total'] . "'
				WHERE config_name = 'postcount'";
			$db->sql_query($sql);
		}
	}

	if ( $file )
	{
		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=' . $lang['ENCODING'] . '"  />
<link rel="stylesheet" href="../templates/' . $theme['template_name'] . '/' . $theme['head_stylesheet'] . '" type="text/css">
</head>
<body bgcolor="#' . $theme['body_bgcolor'] . '" text="#' . $theme['body_text'] . '" link="#' . $theme['body_link'] . '" vlink="#' .$theme['body_vlink'] . '">
<table class="bodyline" width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="left" class="gensmall">' . $file_query . '</td>
	</tr>
</table>
</body>
</html>';
		$db->sql_close();
		exit;
	}

	$message = '<br />' . sprintf($lang['result'], $ok, $no_ok) . '<br /><br /><table align="center" cellspacing="1" cellpadding="4" class="forumline" width="100%">' . $message;
}
echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=' . $lang['ENCODING'] . '"  />
<link rel="stylesheet" href="../templates/' . $theme['template_name'] . '/' . $theme['head_stylesheet'] . '" type="text/css">
</head>
<body bgcolor="#' . $theme['body_bgcolor'] . '" text="#' . $theme['body_text'] . '" link="#' . $theme['body_link'] . '" vlink="#' .$theme['body_vlink'] . '">
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="left" class="nav"><a href="' . append_sid("../index.$phpEx") . '" class="nav">' . sprintf($lang['Forum_Index'], $board_config['sitename']) . '</a></td>
	</tr>
</table>
<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0" style="background-color: #FFFFFF; border: solid 1px #212121">
	<tr>
		<th height="25"><b>' . $lang['Information'] . '</b></th>
	</tr>
	<tr>
		<td align="center" class="row1"><span class="gen">' . $message . '</td>
	</tr>
</table>
<br />
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="center" class="gensmall">Powered by <a href="http://www.phpbb.com" target="_blank" class="copyright">phpBB</a> modified by <a href="http://www.przemo.org/phpBB2/" class="copyright" target="_blank">Przemo</a> &copy; 2003 phpBB Group</td></tr></table>
</body>
</html>';

$db->sql_close();

if( $hand = @opendir($phpbb_root_path . 'cache') )
{
	while( false !== ($filename = @readdir($hand)) )
	{
		if( $filename != '.' && $filename != '..' && $filename != '.htaccess' )
		{
			@unlink($phpbb_root_path . 'cache/' . $filename);
		}
	}
}

exit;

?>