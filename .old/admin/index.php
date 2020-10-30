<?php
/***************************************************************************
 *                             (admin) index.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   modification         : (C) 2003 Przemo http://www.przemo.org/phpBB2/
 *   date modification    : ver. 1.12.5 2005/10/9 23:18
 *
 *   $Id: index.php,v 1.40.2.8 2005/09/18 16:17:20 acydburn Exp $
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
define('MODULE_ID', 'allow');

define('IN_PHPBB', 1);

//
// Load default header
//
$no_page_header = TRUE;
$tags_url = 'https://api.github.com/repos/ikubicki/phpbb-przemo/tags';
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

// ---------------
// Begin functions
//
if ( !(function_exists('inarray')) )
{
	function inarray($needle, $haystack)
	{
		for($i = 0; $i < sizeof($haystack); $i++ )
		{
			if( $haystack[$i] == $needle )
			{
				return true;
			}
		}
		return false;
	}
}
//
// End functions
// -------------

//Check for exist anonmymous user in database. For some lame admins who delete it!
$sql = "SELECT username FROM " . USERS_TABLE . "
	WHERE user_id = " . ANONYMOUS . " LIMIT 1";
$result = $db->sql_query($sql);
$row = $db->sql_fetchrow($result);
if ($row['username'] != 'Anonymous')
{
	message_die(GENERAL_ERROR, 'Anonymous user not exist in database or not ID -1 or not username Anonymous<br />Check your mysql_basic.sql file and add correctly anonymous user');
}

function symverToNumber($symver)
{
	list($major, $minor, $patch) = explode('.', $symver);
	return intval(sprintf('%04d%04d%04d', $major ?: 0, $minor ?: 0, $patch ?: 0));
}

if ( !(function_exists('get_ri')) )
{
	function get_ri()
	{
		global $db, $board_config, $public_description, $lang, $phpEx, $tags_url;

		$anonymous = 0;
		// Set to 1 if you want be anonymous. I collect adress forums data for statistics and it still private of course.
		// If set to 1 checking update verson will be available for you.


		if(array_key_exists('checkupdates', $_GET) || intval($board_config['ri_time']) < CR_TIME - 172800 || intval($board_config['ri_time']) > CR_TIME) {
			
			update_config('ri_time', $board_config['ri_time'] = CR_TIME);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $tags_url);
			curl_setopt($ch, CURLOPT_USERAGENT, 'User-Agent: przemo,' . $board_config['version']);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$json = curl_exec($ch);
			curl_close($ch);
			$tags = json_decode($json, true);

			$myVersion = symverToNumber($board_config['version']);
			$latestVersion = 0;
			$latestTag = null;
			$newerVersions = 0;
			foreach($tags as $tag) {
				$version = symverToNumber($tag['name']);
				if($version > $myVersion) {
					$newerVersions++;
				}
				if ($latestVersion < $version) {
					$latestTag = $tag['name'];
					$latestVersion = $version;
				}
			}
			update_config('ri_data', $latestTag);
		}
		
		$time_elapsed = time() - $board_config['ri_time'];
		$time_ago = sprintf($lang['Forum_last_update_check_minutes_ago'], floor($time_elapsed / 60));
		
		if($time_elapsed > 3600) {
			
			$time_ago = sprintf($lang['Forum_last_update_check_hours_ago'], floor($time_elapsed / 3600));
		}
		
		if($time_elapsed > 86400) {
			
			$time_ago = sprintf($lang['Forum_last_update_check_days_ago'], floor($time_elapsed / 86400));
		}
		
		if($board_config['ri_data']) {
			
			return sprintf(
				'<div style="padding:20px 0 22px;background:#ffa34f;border-bottom:3px solid #fff;text-align:center;font-size:13px;font-weight:bold;font-family:Verdana,Arial,Helvetica,sans-serif">%s</div>',
				sprintf($lang['Forum_out_of_date'], 'https://github.com/ikubicki/phpbb-przemo/releases/tag/'.$board_config['ri_data'])
			);
		}
				
		return sprintf(
			'<div style="padding:12px 0 15px;background:#efefef;border-bottom:3px solid #d1d7dc;text-align:center;font-size:13px;font-family:Verdana,Arial,Helvetica,sans-serif">%s<div style="font-size:10px;padding-top:2px">%s</div></div>',
			$lang['Forum_up_to_date'],
			sprintf(
				'%s <a href="%s">%s</a>',
				sprintf(
					$lang['Forum_last_update_check'],
					$time_ago
				), 
				append_sid("index.$phpEx?pane=right&amp;checkupdates=1"),
				$lang['Forum_search_for_updates']
			)
		);
	}
}

//
// Generate relevant output
//
if( isset($HTTP_GET_VARS['pane']) && $HTTP_GET_VARS['pane'] == 'left' )
{
	include('./page_header_admin.'.$phpEx);

	$template->set_filenames(array(
		'body' => 'admin/index_navigate.tpl')
	);

	$template->assign_vars(array(
		'U_FORUM_INDEX' => append_sid("../index.$phpEx"),
		'U_ADMIN_INDEX' => append_sid("index.$phpEx?pane=right"),
		'U_CHECKFILES' => append_sid("../check_files.$phpEx"),
		'L_FORUM_INDEX' => $lang['Main_index'],
		'L_CHECK_FILES' => $lang['Check-files'],
		'L_ADMIN_INDEX' => $lang['Admin_Index'],
		'L_PREVIEW_FORUM' => $lang['Preview_forum'],
	));

	$show_cur_header = array();
	$cat_id = 1;
	foreach ($modules_data as $cat => $module_array)
	{
		if ( $jr_admin )
		{
			foreach ($module_array as $key => $val)
			{
				$show_cur_header[] = ( (in_array($val[1], $userdata['jr_data']) && $val[1]) ) ? $cat : false;
			}
		}
		if ( !$jr_admin || in_array($cat, $show_cur_header) )
		{
			$template->assign_block_vars("catrow", array(
				'CAT_ID' => $cat_id,
				'ADMIN_CATEGORY' => (isset($lang[$cat])) ? $lang[$cat] : preg_replace("/_/", ' ', $cat))
			);
			$cat_id++;
		}
		$i = 0;
		foreach ($module_array as $key => $val)
		{
			if ( !$jr_admin || (in_array($val[1], $userdata['jr_data']) && $val[1]) )
			{
				$url = $val[0];
				$url .= (preg_match("/^.*\.$phpEx\?/", $url)) ? '&amp;' : '?';
				$url .= 'sid=' . $userdata['session_id'];
				$test_str = str_replace (' ', '', $key);
				if (!empty($test_str))
				{
					$template->assign_block_vars("catrow.modulerow", array(
						'ROW_CLASS' => (($i+1) % 2) ? 'row1' : 'row2',
						'ADMIN_MODULE' => (isset($lang[$key])) ? $lang[$key] : preg_replace("/_/", ' ', $key),
						'U_ADMIN_MODULE' => $url)
					);
					$i++;
				}
			}
		}
	}

	$template->pparse('body');

	include('./page_footer_admin.'.$phpEx);
}
elseif( isset($HTTP_GET_VARS['pane']) && $HTTP_GET_VARS['pane'] == 'right' )
{

	$get_new_version_info = (intval($board_config['ri_time']) < CR_TIME - (24 * 3600 * 2) || intval($board_config['ri_time']) > CR_TIME) ? true : false;

	if ( $get_new_version_info && !isset($HTTP_GET_VARS['new_info']) )
	{
		$url = append_sid("index.$phpEx?pane=right&new_info=1", true);
		print'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><meta http-equiv="Content-Type" content="text/html; charset=' . $lang['ENCODING'] . '"><meta http-equiv="refresh" content="0; url=' . $url . '"><title>Redirect</title></head><body bgcolor="#E5E5E5" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px;"><br /><br /><br /><br /><div align="center"><b>' . $lang['New_info'] . '</b><br /><br /><img src="../images/loading.gif" border="0"></div></body></html>';
		exit;
	}

	include('./page_header_admin.'.$phpEx);

	$template->set_filenames(array(
		"body" => "admin/index_body.tpl")
	);

	print get_ri();

	define('NOTES_TABLE', $table_prefix . 'admin_notes');

	$sql = "SELECT text
		FROM " . NOTES_TABLE;

	if ( isset($HTTP_POST_VARS['save'] ) )
	{
		$text = trim($HTTP_POST_VARS['admin_notes']);

		if ( !($result = $db->sql_query($sql)) )
		{
			$sql_create = "CREATE TABLE " . NOTES_TABLE . " (text text) DEFAULT CHARSET latin2 COLLATE latin2_general_ci";

			if ( !($result_create = $db->sql_query($sql_create)) )
			{
				message_die(GENERAL_ERROR, 'Failed to create admin notes table', '', __LINE__, __FILE__, $sql_create);
			}
		}

		if ($row = $db->sql_fetchrow($result) && $text != '')
		{
			$sql_notes = "UPDATE " . NOTES_TABLE . "
				SET text = '" . str_replace("\'", "''", $text) . "'";
		}
		else if ($text != '')
		{
			$sql_notes = "INSERT INTO " . NOTES_TABLE . "
				(text) VALUES ('" . str_replace("\'", "''", $text) . "')";
		}
		else
		{
			$sql_notes = "DROP TABLE " . NOTES_TABLE;
		}

		if( !$db->sql_query($sql_notes) )
		{
			message_die(GENERAL_ERROR, 'Failed to update admin notes table', '', __LINE__, __FILE__, $sql);
		}
		$admin_notes = stripslashes($text);
	}
	else
	{
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$admin_notes = $row['text'];
	}

	$template->assign_vars(array(
		"L_WELCOME" => $lang['Welcome_phpBB'],
		"L_ADMIN_INTRO" => $lang['Admin_intro'],
		"L_FORUM_STATS" => $lang['Forum_stats'],
		"L_WHO_IS_ONLINE" => $lang['Who_is_Online'],
		"L_USERNAME" => $lang['Username'],
		"L_LOCATION" => $lang['Location'],
		"L_LAST_UPDATE" => $lang['Last_updated'],
		"L_IP_ADDRESS" => $lang['IP_Address'],
		"L_STATISTIC" => $lang['Statistic'],
		"L_VALUE" => $lang['Value'],
		"L_NUMBER_POSTS" => $lang['Number_posts'],
		"L_POSTS_PER_DAY" => $lang['Posts_per_day'],
		"L_NUMBER_TOPICS" => $lang['Number_topics'],
		"L_TOPICS_PER_DAY" => $lang['Topics_per_day'],
		"L_NUMBER_USERS" => $lang['Number_users'],
		"L_USERS_PER_DAY" => $lang['Users_per_day'],
		"L_BOARD_STARTED" => $lang['Board_started'],
		"L_AVATAR_DIR_SIZE" => $lang['Avatar_dir_size'],
		"L_DB_SIZE" => $lang['Database_size'],
		"L_FORUM_LOCATION" => $lang['Forum_Location'],
		"L_STARTED" => $lang['Login'],
		"L_TIME" => $lang['Time'],
		"L_GZIP_COMPRESSION" => $lang['Gzip_compression'],
		"ADMIN_NOTES" => xhtmlspecialchars($admin_notes),
		'U_CLEAR_CACHE' => append_sid("xs_cache.$phpEx?clear="),
		'L_CLEAR_CACHE' => $lang['Reset'] . ' Cache: SQL &amp; templates',
		"L_SAVE" => $lang['Save_message'],
		"L_ADMIN_NOTES" => $lang['Admin_notepad'],
		"L_DETAILS_TITLE" => (isset($HTTP_GET_VARS['sql_details'])) ? $lang['Database_size'] : $lang['Avatar_dir_size'],
		"L_COUNT" => (isset($HTTP_GET_VARS['sql_details'])) ? $lang['Rows_count'] : $lang['Files_count'],
		"L_SIZE" => $lang['Optimize_Size'],
		"L_NAME" => $lang['xs_update_name'])
	);

	function get_folder_size($target)
	{
		$sourcedir = @opendir($target);
		while(false !== ($filename = @readdir($sourcedir)))
		{
			if($filename != "." && $filename != "..")
			{
				if(@is_dir($target."/".$filename))
				{
					// recurse subdirectory; call of function recursive
					$totalsize += get_folder_size($target."/".$filename);
				}
				else if(@is_file($target."/".$filename))
				{
					$totalsize += @filesize($target."/".$filename);
				}
			}
		}
		@closedir($sourcedir);
		return $totalsize;
	}

	function get_folder_count($target)
	{
		$sourcedir = @opendir($target);
		while(false !== ($filename = @readdir($sourcedir)))
		{
			if($filename != "." && $filename != "..")
			{
				if(@is_dir($target."/".$filename))
				{
					// recurse subdirectory; call of function recursive
					$totalcount += get_folder_count($target."/".$filename);
				}
				else if(@is_file($target."/".$filename))
				{
					$totalcount += 1;
				}
			}
		}
		@closedir($sourcedir);
		return $totalcount;
	}

	//
	// Get forum statistics
	//
	$total_posts = get_db_stat('postcount');
	$total_users = get_db_stat('usercount');
	$total_topics = get_db_stat('topiccount');

	$start_date = create_date($board_config['default_dateformat'], $board_config['board_startdate'], $board_config['board_timezone']);

	$boarddays = ( CR_TIME - $board_config['board_startdate'] ) / 86400;

	$posts_per_day = sprintf("%.2f", $total_posts / $boarddays);
	$topics_per_day = sprintf("%.2f", $total_topics / $boarddays);
	$users_per_day = sprintf("%.2f", $total_users / $boarddays);

	$root_dir_size = 0;

	if ( isset($HTTP_GET_VARS['dir_details']) )
	{
		if ($avatar_dir = @opendir($phpbb_root_path))
		{
			closedir($avatar_dir);

			$root_dir_size = get_folder_size($phpbb_root_path);

			//
			// This bit of code translates the avatar directory size into human readable format
			// Borrowed the code from the PHP.net annoted manual, origanally written by:
			// Jesse (jesse@jess.on.ca)
			//
			if($root_dir_size >= 1024000)
			{
				$root_dir_size = round($root_dir_size / 1024000 * 100, -1) / 100 . ' MB';
			}
			else if($root_dir_size >= 1024)
			{
				$root_dir_size = round($root_dir_size / 1024 * 100, -1) / 100 . ' KB';
			}
			else
			{
				$root_dir_size = $root_dir_size . ' B';
			}

		}
		else
		{
			$root_dir_size = $lang['Avatar_dir_size'];
		}
	}
	else
	{
			$root_dir_size = '<a href="' . append_sid("index.$phpEx?pane=right&amp;dir_details=1") . '">' . $lang['View_Information'] . '</a>';
	}

	if(floatval ($posts_per_day) > $total_posts)
    {       
        $posts_per_day = $total_posts;
    }

    if(floatval ($topics_per_day) > $total_topics)
    {
        $topics_per_day = $total_topics;
    }

    if(floatval ($users_per_day) > $total_users)
    {
        $users_per_day = $total_users;
    }

	//
	// DB size ... MySQL only
	//
	// This code is heavily influenced by a similar routine
	// in phpMyAdmin 2.2.0
	//
	if( preg_match("/^mysql/", SQL_LAYER) && isset($HTTP_GET_VARS['sql_details']))
	{
		$sql = "SELECT VERSION() AS mysql_version";
		if($result = $db->sql_query($sql))
		{
			$row = $db->sql_fetchrow($result);
			$version = $row['mysql_version'];

			if( preg_match("/^(3\.23|4\.|5\.)/", $version) )
			{
				$db_name = ( preg_match("/^(3\.23\.[6-9])|(3\.23\.[1-9][1-9])|(4\.)|(5\.)/", $version) ) ? "`$dbname`" : $dbname;

				$sql = "SHOW TABLE STATUS
					FROM " . $db_name;
				if($result = $db->sql_query($sql))
				{
					$tabledata_ary = $db->sql_fetchrowset($result);

					$dbsize = 0;
					for($i = 0; $i < count($tabledata_ary); $i++)
					{
						if( $tabledata_ary[$i]['Type'] != "MRG_MyISAM" )
						{
							if( $table_prefix != "" )
							{
								if( strstr($tabledata_ary[$i]['Name'], $table_prefix) )
								{
									$dbsize += $tabledata_ary[$i]['Data_length'] + $tabledata_ary[$i]['Index_length'];
								}
							}
							else
							{
								$dbsize += $tabledata_ary[$i]['Data_length'] + $tabledata_ary[$i]['Index_length'];
							}
						}
					}

					if ( isset($HTTP_GET_VARS['sql_details']) )
					{
						$template->assign_block_vars('details', array());

						$sql = "SHOW TABLE STATUS
							FROM " . $db_name;
						if ( !($result = $db->sql_query($sql)) )
						{
							message_die(CRITICAL_ERROR, 'Could not Show Tables', '', __LINE__, __FILE__, $sql);
						}
						$i = 0;
						while ( $row = $db->sql_fetchrow($result) )
						{
							$size = $row['Data_length'] + $row['Index_length'];
							if($size >= 1000000)
							{
								$size = '<b>' . round($size / 1048576 * 100, -1) / 100 . ' MB</b>';
							}
							else if($size >= 1024)
							{
								$size = round($size / 1024 * 100, -1) / 100 . ' KB';
							}
							else
							{
								$size = $size . ' B';
							}
							$template->assign_block_vars('details.details_list', array(
								'ROW' => ($i % 2) ? 1 : 2,
								'SIZE' => $size,
								'COUNT' => $row['Rows'],
								'NAME' => $row['Name'])
							);
							$i++;
						}
					}
				} // Else we couldn't get the table status.
			}
			else
			{
				$dbsize = $lang['Not_available'];
			}
		}
		else
		{
			$dbsize = $lang['Not_available'];
		}
	}
	else
	{
		$dbsize = (!isset($HTTP_GET_VARS['sql_details'])) ? '<a href="' . append_sid("index.$phpEx?pane=right&amp;sql_details=1") . '">' . $lang['View_Information'] . '</a>' : $lang['Not_available'];
	}

	if ( is_integer($dbsize) )
	{
		if( $dbsize >= 1048576 )
		{
			$dbsize = sprintf("%.2f MB", ( $dbsize / 1048576 ));
		}
		else if( $dbsize >= 1024 )
		{
			$dbsize = sprintf("%.2f KB", ( $dbsize / 1024 ));
		}
		else
		{
			$dbsize = sprintf("%.2f B", $dbsize);
		}
	}

	if ( isset($HTTP_GET_VARS['dir_details']) )
	{
		$template->assign_block_vars('details', array());
		$target = '../';
		$sourcedir = @opendir($target);
		while(false !== ($filename = @readdir($sourcedir)))
		{
			$files_count = $size = 0;
			if($filename != ".." && @is_dir($target."/".$filename) )
			{
				if ( $filename != "." )
				{
					$size += get_folder_size($target."/".$filename);
					$files_count = get_folder_count($target."/".$filename);
				}
				else
				{
					$sourcedir2 = @opendir($target."/".$filename);
					while(false !== ($filename2 = @readdir($sourcedir2)))
					{
						if($filename2 != "." && $filename2 != "..")
						{
							if(@is_file($target."/".$filename2))
							{
								$size += @filesize($target."/".$filename2);
								$files_count++;
							}
						}
					}
					@closedir($sourcedir2);
					$filename = '~/';
				}
				if($size >= 1024000)
				{
					$size = '<b>' . round($size / 1024000 * 100, -1) / 100 . ' MB</b>';
				}
				else if($size >= 1024)
				{
					$size = round($size / 1024 * 100, -1) / 100 . ' KB';
				}
				else
				{
					$size = $size . ' B';
				}
				$template->assign_block_vars('details.details_list', array(
					'ROW' => ($i % 2) ? 1 : 2,
					'SIZE' => $size,
					'COUNT' => $files_count,
					'NAME' => $filename)
				);
				$i++;
			}
		}
	}
	@closedir($sourcedir);

	$script_server_side = '';

	if ( $board_config['gzip_compress'] )
	{
		$l_gzip_compress = $lang['Yes'] . ' (' . $lang['forum_compress'] . ')';
	}
	else
	{
		$l_gzip_compress = $lang['No'];
	}
	$is_ob_gzhandler_started = false;
	if ( (@ini_get('zlib.output_compression') && (int)@ini_get('zlib.output_compression') != 0 && strtolower(@ini_get('zlib.output_compression')) != 'off') || @ini_get('output_handler') && strtolower(@ini_get('output_handler'))=='ob_gzhandler' )
	{
		$l_gzip_compress = $lang['Yes'] . ' (' . $lang['server_compress'] . ')';
	}

	$template->assign_vars(array(
		"NUMBER_OF_POSTS" => $total_posts,
		"NUMBER_OF_TOPICS" => $total_topics,
		"NUMBER_OF_USERS" => $total_users,
		"START_DATE" => $start_date,
		"POSTS_PER_DAY" => $posts_per_day,
		"TOPICS_PER_DAY" => $topics_per_day,
		"USERS_PER_DAY" => $users_per_day,
		"AVATAR_DIR_SIZE" => $root_dir_size,
		"DB_SIZE" => $dbsize,
		"GZIP_COMPRESSION" => $l_gzip_compress)
	);
	//
	// End forum statistics
	//

	//
	// Get users online information.
	//
	$sql = "SELECT u.user_id, u.username, u.user_session_time, u.user_session_start, u.user_session_time, u.user_session_page, u.user_level, u.user_jr, s.session_logged_in, s.session_ip, s.session_start
		FROM (" . USERS_TABLE . " u, " . SESSIONS_TABLE . " s)
		WHERE s.session_logged_in = " . TRUE . "
			AND u.user_id = s.session_user_id
			AND u.user_id <> " . ANONYMOUS . "
			AND s.session_time >= " . ( CR_TIME - 300 ) . "
		ORDER BY u.user_session_time DESC";
	if(!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Couldn't obtain regd user/online information.", "", __LINE__, __FILE__, $sql);
	}
	$onlinerow_reg = $db->sql_fetchrowset($result);

	$sql = "SELECT session_page, session_logged_in, session_time, session_ip, session_start
		FROM " . SESSIONS_TABLE . "
		WHERE session_logged_in = 0
			AND session_time >= " . ( CR_TIME - 300 ) . "
		ORDER BY session_ip ASC";
	if(!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Couldn't obtain guest user/online information.", "", __LINE__, __FILE__, $sql);
	}
	$onlinerow_guest = $db->sql_fetchrowset($result);

	$sql = "SELECT forum_name, forum_id
		FROM " . FORUMS_TABLE;
	if($forums_result = $db->sql_query($sql))
	{
		while($forumsrow = $db->sql_fetchrow($forums_result))
		{
			$forum_data[$forumsrow['forum_id']] = $forumsrow['forum_name'];
		}
	}
	else
	{
		message_die(GENERAL_ERROR, "Couldn't obtain user/online forums information.", "", __LINE__, __FILE__, $sql);
	}

	$reg_userid_ary = array();

	if( count($onlinerow_reg) )
	{
		$registered_users = 0;

		for($i = 0; $i < count($onlinerow_reg); $i++)
		{
			if( !inarray($onlinerow_reg[$i]['user_id'], $reg_userid_ary) )
			{
				$reg_userid_ary[] = $onlinerow_reg[$i]['user_id'];

				$username = $onlinerow_reg[$i]['username'];

				$colored_username = color_username($onlinerow_reg[$i]['user_level'], $onlinerow_reg[$i]['user_jr'], $onlinerow_reg[$i]['user_id'], $username);
				$username = $colored_username[0];

				if( $onlinerow_reg[$i]['user_allow_viewonline'] || $userdata['user_level'] == ADMIN )
				{
					$registered_users++;
					$hidden = FALSE;
				}
				else
				{
					$hidden_users++;
					$hidden = TRUE;
				}

				if( $onlinerow_reg[$i]['user_session_page'] < 1 )
				{
					$location_url = "#";
					switch($onlinerow_reg[$i]['user_session_page'])
					{
						case PAGE_INDEX:
							$location = $lang['Forum_index'];
							break;
						case PAGE_POSTING:
							$location = $lang['Posting_message'];
							break;
						case PAGE_LOGIN:
							$location = $lang['Logging_on'];
							break;
						case PAGE_SEARCH:
							$location = $lang['Searching_forums'];
							break;
						case PAGE_PROFILE:
							$location = $lang['Viewing_profile'];
							break;
						case PAGE_VIEWONLINE:
							$location = $lang['Viewing_online'];
							break;
						case PAGE_VIEWMEMBERS:
							$location = $lang['Viewing_member_list'];
							break;
						case PAGE_TOPIC_VIEW:
							$location = $lang['Viewing_topic'];
							break;
						case PAGE_PRIVMSGS:
							$location = $lang['Viewing_priv_msgs'];
							break;
						case PAGE_FAQ:
							$location = $lang['Viewing_FAQ'];
							break;
						case PAGE_STAFF:
							$location = $lang['Staff'];
							break;
						case PAGE_GROUPCP:
							$location = $lang['Usergroups'];
							break;
						case PAGE_STATISTICS:
							$location = $lang['Statistics'];
							break;
						case PAGE_SHOUTBOX:
							$location = 'ShoutBox';
							break;
						case PAGE_ADMIN_PANEL:
							$location = $lang['Admin_panel'];
							break;
						default:
							$location = $lang['Forum_index'];
					}
				}
				else
				{
					$location_url = append_sid("admin_forums.$phpEx?mode=editforum&amp;" . POST_FORUM_URL . "=" . $onlinerow_reg[$i]['user_session_page']);
					$location = $forum_data[$onlinerow_reg[$i]['user_session_page']];
				}

				$row_color = ( $registered_users % 2 ) ? $theme['td_color1'] : $theme['td_color2'];
				$row_class = ( $registered_users % 2 ) ? $theme['td_class1'] : $theme['td_class2'];

				$reg_ip = decode_ip($onlinerow_reg[$i]['session_ip']);

				$user_time_online = ($onlinerow_reg[$i]['user_session_start']) ? $onlinerow_reg[$i]['user_session_time'] - $onlinerow_reg[$i]['user_session_start'] : CR_TIME - $onlinerow_reg[$i]['session_start'];
				$time_online = (($user_time_online) < 3600) ? round( ($user_time_online) / 60, 0 ) : round( ($user_time_online) / 60 / 60, 1 );

				$lang_online = (($user_time_online) < 3600) ? $lang['online_minutes'] : $lang['online_hours'];

				$template->assign_block_vars("reg_user_row", array(
					"ROW_COLOR" => "#" . $row_color,
					"ROW_CLASS" => $row_class,
					"USERNAME" => $username,
					"USERNAME_COLOR" => $colored_username[1],
					"TIME" => sprintf($lang_online, $time_online),
					"STARTED" => create_date($board_config['default_dateformat'], $onlinerow_reg[$i]['session_start'], $board_config['board_timezone']),
					"LASTUPDATE" => create_date($board_config['default_dateformat'], $onlinerow_reg[$i]['user_session_time'], $board_config['board_timezone']),
					"FORUM_LOCATION" => $location,
					"IP_ADDRESS" => $reg_ip,
					"HOST" => (isset($HTTP_GET_VARS['hosts']) && $reg_host = @gethostbyaddr($reg_ip)) ? ' (' . $reg_host . ')' : '',

					"U_WHOIS_IP" => $board_config['address_whois'] . $reg_ip,
					"U_USER_PROFILE" => append_sid("../profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $onlinerow_reg[$i]['user_id']),
					"U_FORUM_LOCATION" => append_sid($location_url))
				);
			}
		}

	}
	else
	{
		$template->assign_vars(array(
			"L_NO_REGISTERED_USERS_BROWSING"=> $lang['No_users_browsing'])
		);
	}

	//
	// Guest users
	//
	if( count($onlinerow_guest) )
	{
		$guest_users = 0;

		for($i = 0; $i < count($onlinerow_guest); $i++)
		{
			$guest_userip_ary[] = $onlinerow_guest[$i]['session_ip'];
			$guest_users++;

			if( $onlinerow_guest[$i]['session_page'] < 1 )
			{
				switch( $onlinerow_guest[$i]['session_page'] )
				{
						case PAGE_INDEX:
							$location = $lang['Forum_index'];
							break;
						case PAGE_POSTING:
							$location = $lang['Posting_message'];
							break;
						case PAGE_LOGIN:
							$location = $lang['Logging_on'];
							break;
						case PAGE_SEARCH:
							$location = $lang['Searching_forums'];
							break;
						case PAGE_PROFILE:
							$location = $lang['Viewing_profile'];
							break;
						case PAGE_VIEWONLINE:
							$location = $lang['Viewing_online'];
							break;
						case PAGE_VIEWMEMBERS:
							$location = $lang['Viewing_member_list'];
							break;
						case PAGE_TOPIC_VIEW:
							$location = $lang['Viewing_topic'];
							break;
						case PAGE_FAQ:
							$location = $lang['Viewing_FAQ'];
							break;
						case PAGE_STAFF:
							$location = $lang['Staff'];
							break;
						case PAGE_GROUPCP:
							$location = $lang['Usergroups'];
							break;
						case PAGE_STATISTICS:
							$location = $lang['Statistics'];
							break;
						case PAGE_SHOUTBOX:
							$location = 'ShoutBox';
							break;
						default:
							$location = $lang['Forum_index'];
				}
			}
			else
			{
				$location_url = append_sid("admin_forums.$phpEx?mode=editforum&amp;" . POST_FORUM_URL . "=" . $onlinerow_guest[$i]['session_page']);
				$location = $forum_data[$onlinerow_guest[$i]['session_page']];
			}

			$row_color = ( $guest_users % 2 ) ? $theme['td_color1'] : $theme['td_color2'];
			$row_class = ( $guest_users % 2 ) ? $theme['td_class1'] : $theme['td_class2'];

			$guest_ip = decode_ip($onlinerow_guest[$i]['session_ip']);

			$time_online = ((CR_TIME - $onlinerow_guest[$i]['session_start']) < 3600) ? round( (CR_TIME - $onlinerow_guest[$i]['session_start']) / 60, 0 ) : round( (CR_TIME - $onlinerow_guest[$i]['session_start']) / 60 / 60, 1 );
			$lang_online = ((CR_TIME - $onlinerow_guest[$i]['session_start']) < 3600) ? $lang['online_minutes'] : $lang['online_hours'];

			$template->assign_block_vars('guest_user_row', array(
				"ROW_COLOR" => "#" . $row_color,
				"ROW_CLASS" => $row_class,
				"USERNAME" => $lang['Guest'],
				"TIME" => sprintf($lang_online, $time_online),
				"STARTED" => create_date($board_config['default_dateformat'], $onlinerow_guest[$i]['session_start'], $board_config['board_timezone']),
				"LASTUPDATE" => create_date($board_config['default_dateformat'], $onlinerow_guest[$i]['session_time'], $board_config['board_timezone']),
				"FORUM_LOCATION" => $location,
				"IP_ADDRESS" => $guest_ip,
				"HOST" => (isset($HTTP_GET_VARS['hosts']) && $guest_host = @gethostbyaddr($guest_ip)) ? ' (' . $guest_host . ')' : '',

				"U_WHOIS_IP" => $board_config['address_whois'] . $guest_ip,
				"U_FORUM_LOCATION" => append_sid($location_url))
			);
		}

	}
	else
	{
		$template->assign_vars(array(
			"L_NO_GUESTS_BROWSING" => $lang['No_users_browsing'])
		);
	}

	$template->assign_vars(array(
		"LINK_SHOW_HOSTS" => (isset($HTTP_GET_VARS['hosts'])) ? '<br />' : '<a href="' . append_sid("index.$phpEx?pane=right&amp;hosts=1") . '">' . $lang['Show_hosts'] . '</a>')
	);

	include($phpbb_root_path . 'includes/functions_log.'.$phpEx);
	log_action('admin', '', $userdata['user_id'], $userdata['username']);

	$template->pparse('body');

	include('./page_footer_admin.'.$phpEx);
}
else
{
	//
	// Generate frameset
	//
	$template->set_filenames(array(
		"body" => "admin/index_frameset.tpl")
	);

	$template->assign_vars(array(
		"S_FRAME_NAV" => append_sid("index.$phpEx?pane=left"),
		"S_FRAME_MAIN" => append_sid("index.$phpEx?pane=right"))
	);

	header ("Expires: " . gmdate("D, d M Y H:i:s", CR_TIME) . " GMT");
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

	$template->pparse("body");

	$db->sql_close();
	exit;

}

?>