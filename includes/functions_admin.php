<?php
/***************************************************************************
 *                            functions_admin.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *	 modification         : (C) 2003 Przemo www.przemo.org/phpBB2/
 *	 date modification    : ver. 1.12.5 2005/08/30 13:11
 *
 *   $Id: functions_admin.php,v 1.5.2.5 2005/09/14 19:16:21 acydburn Exp $
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

//
// Synchronise functions for forums/topics
//
function sync($type, $id = false, $without_attach = false)
{
	global $db;

	switch($type)
	{
		case 'all forums':
			$sql = "SELECT forum_id
				FROM " . FORUMS_TABLE;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get forum IDs', '', __LINE__, __FILE__, $sql);
			}

			while( $row = $db->sql_fetchrow($result) )
			{
				sync('forum', $row['forum_id']);
			}
			break;

		case 'all topics':
			$sql = "SELECT topic_id
				FROM " . TOPICS_TABLE;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get topic ID', '', __LINE__, __FILE__, $sql);
			}

			while( $row = $db->sql_fetchrow($result) )
			{
				sync('topic', $row['topic_id']);
			}
			break;

			case 'forum':
			$sql = "SELECT MAX(post_id) AS last_post, COUNT(post_id) AS total 
				FROM " . POSTS_TABLE . "
				WHERE forum_id = $id";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get post ID', '', __LINE__, __FILE__, $sql);
			}

			if ( $row = $db->sql_fetchrow($result) )
			{
				$last_post = ( $row['last_post'] ) ? $row['last_post'] : 0;
				$total_posts = ($row['total']) ? $row['total'] : 0;
			}
			else
			{
				$last_post = 0;
				$total_posts = 0;
			}

			$sql = "SELECT COUNT(topic_id) AS total
				FROM " . TOPICS_TABLE . "
				WHERE forum_id = $id";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get topic count', '', __LINE__, __FILE__, $sql);
			}

			$total_topics = ( $row = $db->sql_fetchrow($result) ) ? ( ( $row['total'] ) ? $row['total'] : 0 ) : 0;

			$sql = "UPDATE " . FORUMS_TABLE . "
				SET forum_last_post_id = $last_post, forum_posts = $total_posts, forum_topics = $total_topics
				WHERE forum_id = $id";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not update forum', '', __LINE__, __FILE__, $sql);
			}
			sql_cache('clear', 'multisqlcache_forum');
			sql_cache('clear', 'forum_data');
			break;

		case 'topic':
			$sql = "SELECT MAX(post_id) AS last_post, MIN(post_id) AS first_post, COUNT(post_id) AS total_posts
				FROM " . POSTS_TABLE . "
				WHERE topic_id = $id";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get post ID', '', __LINE__, __FILE__, $sql);
			}

			if ( $row = $db->sql_fetchrow($result) )
			{
				if ($row['total_posts'])
				{
					// Correct the details of this topic
					$sql = 'UPDATE ' . TOPICS_TABLE . ' 
						SET topic_replies = ' . ($row['total_posts'] - 1) . ', topic_first_post_id = ' . $row['first_post'] . ', topic_last_post_id = ' . $row['last_post'] . "
						WHERE topic_id = $id";
						
					if ( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, 'Could not update topic', '', __LINE__, __FILE__, $sql);
					}
				}
				else
				{
					// There are no replies to this topic
					// Check if it is a move stub
					$sql = 'SELECT topic_moved_id 
						FROM ' . TOPICS_TABLE . " 
						WHERE topic_id = $id";

					if (!($result = $db->sql_query($sql)))
					{
						message_die(GENERAL_ERROR, 'Could not get topic ID', '', __LINE__, __FILE__, $sql);
					}

					if ($row = $db->sql_fetchrow($result))
					{
						if (!$row['topic_moved_id'])
						{
							$sql = 'DELETE FROM ' . TOPICS_TABLE . " WHERE topic_id = $id";
			
							if (!$db->sql_query($sql))
							{
								message_die(GENERAL_ERROR, 'Could not remove topic', '', __LINE__, __FILE__, $sql);
							}
							$sql = 'DELETE FROM ' . READ_HIST_TABLE . " WHERE topic_id = $id";
			
							if (!$db->sql_query($sql))
							{
								message_die(GENERAL_ERROR, 'Could not remove topic', '', __LINE__, __FILE__, $sql);
							}
						}
					}

					$db->sql_freeresult($result);
				}
				if ( defined('ATTACHMENTS_ON') && !$without_attach )
				{
					attachment_sync_topic($id);
				}
				break;
			}
	}
	
	return true;
}


function check_form($chars, $text)
{
	if ( empty($text) )
	{
		message_die(GENERAL_MESSAGE, 'Short Description is empty !');
	}

	if ( substr($chars, 0, 1) == ',' )
	{
		$chars = substr($chars, 1);
	}
	if ( substr($chars, -1) == ',' )
	{
		$chars = substr($chars, 0, -1);
	}
	return $chars;
}

function faq_slashes($value, $type)
{
	$value = ($type) ? str_replace('\\', ':_sl_;', $value) : str_replace(':_sl_;', '\\', $value);
	$value = ($type) ? str_replace('"', ':_qu_;', $value) : str_replace(':_qu_;', '"', $value);
	$value = ($type) ? str_replace("$", ".'$'.", $value) : str_replace(".'$'.", "$", $value);

	return $value;
}

/* this function takes the FAQ array generated as a result
 * of include'ing the lang_faq.php file and turns it into
 * a pair of arrays, $blocks and $quests.
 *    $blocks - just contains numerically indexed block titles
 *    $quests - is in the following format:
 *      $quests[$block_number][$question_number][Q] - is the question
 *      $quests[$block_number][$question_number][A] - is the answer
 */
function faq_to_array($faq)
{
	$blocks = array();
	$quests = array();

	$block_no = -1;
	$quest_no = 0;

	for($i = 0; $i < count($faq); $i++)
	{
		if($faq[$i][0] == '--')
		{
			$block_no++;
			$blocks[$block_no] = faq_slashes($faq[$i][1],0);
			$quests[$block_no] = array();
			$quest_no = 0;
		}
		else
		{
			$quests[$block_no][$quest_no][Q] = faq_slashes($faq[$i][0],0);
			$quests[$block_no][$quest_no][A] = faq_slashes($faq[$i][1],0);
			$quest_no++;
		}
	}

	return array($blocks, $quests);
}
/* END function faq_to_array */

/* this function takes the array generated by faq_to_array and changes
 * it back into lines suitable for dumping to a lang_faq.php file. It
 * returns a numerically-indexed array of said lines.
 */
function array_to_faq($blocks, $quests)
{
	$lines = array();

	for($i = 0; $i < count($blocks); $i++)
	{
		$lines[] = '$faq[] = array("--", "'.faq_slashes($blocks[$i], 1).'");'."\n";

		for($j = 0; $j < count($quests[$i]); $j++)
		{
			if( !empty($quests[$i][$j][Q]) && !empty($quests[$i][$j][A]) )
			{
				$lines[] = '$faq[] = array("'.faq_slashes($quests[$i][$j][Q], 1).'", "'.faq_slashes($quests[$i][$j][A], 1).'");'."\n";
			}
		}

		$lines[] = "\n";
	}

	return $lines;
}
/* END function array_to_faq */

function check_auth($type, $key, $u_access, $is_admin)
{
	$auth_user = 0;

	if( count($u_access) )
	{
		for($j = 0; $j < count($u_access); $j++)
		{
			$result = 0;
			switch($type)
			{
				case AUTH_ACL:
					$result = $u_access[$j][$key];

				case AUTH_MOD:
					$result = $result || $u_access[$j]['auth_mod'];

				case AUTH_ADMIN:
					$result = $result || $is_admin;
					break;
			}

			$auth_user = $auth_user || $result;
		}
	}
	else
	{
		$auth_user = $is_admin;
	}

	return $auth_user;
}

function recalculate_user_posts($old_forum_id, $new_forum_id, $ids, $mode = 'post')
{
	global $db;

	$new_forum_id_count = (no_post_count($new_forum_id)) ? true : false;
	$old_forum_id_count = (no_post_count($old_forum_id)) ? true : false;

	$count_sql = array();

	if ( ((!$new_forum_id_count && $old_forum_id_count) || ($new_forum_id_count && !$old_forum_id_count)) && !is_array($ids) )
	{
		$delim = (!$new_forum_id_count && $old_forum_id_count) ? '-' : '+';
		$sql = "SELECT poster_id, COUNT(post_id) AS posts 
			FROM " . POSTS_TABLE . " 
			WHERE topic_id = $ids 
			GROUP BY poster_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not get poster id information', '', __LINE__, __FILE__, $sql);
		}
		while ( $row = $db->sql_fetchrow($result) )
		{
			$count_sql[] = "UPDATE " . USERS_TABLE . " 
				SET user_posts = user_posts $delim " . $row['posts'] . "
				WHERE user_id = " . $row['poster_id'];
		}
		$db->sql_freeresult($result);
	}
	else if ( ((!$new_forum_id_count && $old_forum_id_count) || ($new_forum_id_count && !$old_forum_id_count)) && is_array($ids))
	{
		$delim = (!$new_forum_id_count && $old_forum_id_count) ? '-' : '+';
		$imp_ids = (is_array($ids)) ? implode(', ', $ids) : $ids;
		$sql = "SELECT poster_id, COUNT(post_id) AS posts 
			FROM " . POSTS_TABLE . " 
			WHERE " . (($mode == 'topic') ? "topic_id" : "post_id") . " IN($imp_ids)
			GROUP BY poster_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not get poster id information', '', __LINE__, __FILE__, $sql);
		}
		while ( $row = $db->sql_fetchrow($result) )
		{
			$count_sql[] = "UPDATE " . USERS_TABLE . " 
				SET user_posts = user_posts $delim " . $row['posts'] . "
				WHERE user_id = " . $row['poster_id'];
		}
		$db->sql_freeresult($result);
	}
	if ( sizeof($count_sql) )
	{
		for($i = 0; $i < sizeof($count_sql); $i++)
		{
			if ( !$db->sql_query($count_sql[$i]) )
			{
				message_die(GENERAL_ERROR, 'Could not update user post count information', '', __LINE__, __FILE__, $sql);
			}
		}
	}

	return;
}

function write_db_backup(&$file_handle, &$str)
{
	$bytes = @fwrite($file_handle, $str);
	if ($bytes === false)
	{
		if ( $board_config['board_disable'] == 'db_backup_progress' )
		{
			update_config('board_disable', '');
			update_config('disable_type', '');
		}
		message_die(GENERAL_ERROR, 'Unable to write backup file. Check you have enough free space.<br />Nie mogê utworzyæ kopii. Sprawd¼, czy na serwerze jest wystarczaj±ca ilo¶æ wolnego miejsca.', 'Could not write backup file', __LINE__, __FILE__);
	}

}

function db_backup_stop()
{
	global $board_config;

	if ( $board_config['board_disable'] == 'db_backup_progress' )
	{
		update_config('board_disable', '');
		update_config('disable_type', '');
	}
}

function db_backup($do_now = false)
{
	global $db, $dbname, $table_prefix, $board_config, $phpbb_root_path;

	update_config('db_backup_time', CR_TIME);

	if ( !$board_config['board_disable'] && !$board_config['disable_type'] )
	{
		update_config('board_disable', 'db_backup_progress');
		update_config('disable_type', '1');
		$board_config['board_disable'] = 'db_backup_progress';
	}

	$chars = array( 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0');

	$max_chars = count($chars) - 1;
	srand( (double) microtime()*1000000);

	$rand_str = '';
	for($i = 0; $i < 24; $i++)
	{
		$rand_str = ( $i == 0 ) ? $chars[rand(0, $max_chars)] : $rand_str . $chars[rand(0, $max_chars)];
	}

	if ( @function_exists('gzopen') )
	{
		$backup_open = gzopen;
		$backup_write = gzwrite;
		$backup_read = gzread;
		$backup_close = gzclose;
		$backup_suffix = '.sql.gz';
	}
	else
	{
		$backup_open = fopen;
		$backup_write = fwrite;
		$backup_read = fread;
		$backup_close = fclose;
		$backup_suffix = '.sql';
	}

	@set_time_limit('300');
	$filename = date('Y-m-d', CR_TIME) . '_db_backup_' . $table_prefix . $rand_str . $backup_suffix;

	$file_handle = $backup_open($phpbb_root_path . '/db/db_backup/' . $filename, 'wb');
	if (!$file_handle)
	{
		db_backup_stop();
		return;
	}

	$sql = "SHOW TABLES LIKE '" . $table_prefix . "%'";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query tables', '', __LINE__, __FILE__, $sql);
	}
	$row_tables = $db->sql_fetchrowset($result);

	$crlf = "\r\n";
	@$backup_write($file_handle,'SET NAMES latin2;'.$crlf.$crlf);
	foreach($row_tables as $name)
	{
		$table = $name['Tables_in_' . $dbname . ' (' . $table_prefix . '%)'];
		$schema_create = $index = '';
		$field_query = "SHOW FIELDS FROM $table";
		$key_query = "SHOW KEYS FROM $table";

		$schema_create .= "CREATE TABLE $table($crlf";

		$result = $db->sql_query($field_query);
		if(!$result)
		{
			message_die(GENERAL_ERROR, "Failed in get_table_def (show fields)", "", __LINE__, __FILE__, $field_query);
		}

		while ($row = $db->sql_fetchrow($result))
		{
			$schema_create .= ' ' . $row['Field'] . ' ' . $row['Type'];

			if(!empty($row['Default']))
			{
				$schema_create .= ' DEFAULT \'' . $row['Default'] . '\'';
			}

			if($row['Null'] != "YES")
			{
				$schema_create .= ' NOT NULL';
			}

			if($row['Extra'] != "")
			{
				$schema_create .= ' ' . $row['Extra'];
			}

			$schema_create .= ",$crlf";
		}
		$schema_create = preg_replace('/,' . $crlf . '$/s', '', $schema_create);

		$result = $db->sql_query($key_query);
		if(!$result)
		{
			message_die(GENERAL_ERROR, "FAILED IN get_table_def (show keys)", "", __LINE__, __FILE__, $key_query);
		}

		while($row = $db->sql_fetchrow($result))
		{
			$kname = $row['Key_name'];

			if(($kname != 'PRIMARY') && ($row['Non_unique'] == 0))
			{
				$kname = "UNIQUE|$kname";
			}

			if(!is_array($index[$kname]))
			{
				$index[$kname] = array();
			}

			$index[$kname][] = $row['Column_name'];
		}

		while(list($x, $columns) = @each($index))
		{
			$schema_create .= ", $crlf";

			if($x == 'PRIMARY')
			{
				$schema_create .= ' PRIMARY KEY (' . implode($columns, ', ') . ')';
			}
			elseif (substr($x,0,6) == 'UNIQUE')
			{
				$schema_create .= ' UNIQUE ' . substr($x,7) . ' (' . implode($columns, ', ') . ')';
			}
			else
			{
				$schema_create .= " KEY $x (" . implode($columns, ', ') . ')';
			}
		}

		$schema_create .= "$crlf) ENGINE = MYISAM DEFAULT CHARACTER SET = latin2 DEFAULT COLLATE = latin2_general_ci;";

		if ( get_magic_quotes_runtime() )
		{
			$schema_create = stripslashes($schema_create);
		}

		@$backup_write($file_handle, $schema_create . $crlf . $crlf);

		// Schema Insert - Grab the data from the table.
		$data_ignores = array($table_prefix . 'sessions');
		if ( !$board_config['db_backup_search'] )
		{
			$data_ignores[] = $table_prefix . 'search_results';
			$data_ignores[] = $table_prefix . 'search_wordlist';
			$data_ignores[] = $table_prefix . 'search_wordmatch';
		}
		if ( !$board_config['db_backup_rh'] )
		{
			$data_ignores[] = $table_prefix . 'read_history';
		}

		if ( !(in_array($table, $data_ignores)) )
		{
			if (!($result = $db->sql_query("SELECT * FROM $table")))
			{
				message_die(GENERAL_ERROR, "Failed in get_table_content (select *)", "", __LINE__, __FILE__, "SELECT * FROM $table");
			}

			// Loop through the resulting rows and build the sql statement.
			if ($row = $db->sql_fetchrow($result))
			{
				$num_fields = $db->sql_numfields($result);
				$field_names = array();
				for ($j = 0; $j < $num_fields; $j++)
				{
					$field_names[$j] = $db->sql_fieldname($j, $result);
				}
				do
				{
					$schema_insert = "INSERT INTO $table VALUES(";

					// Loop through the rows and fill in data for each column
					for ($j = 0; $j < $num_fields; $j++)
					{
						$schema_insert .= ($j > 0) ? ', ' : '';

						if(!isset($row[$field_names[$j]]))
						{
							$schema_insert .= 'NULL';
						}
						elseif ($row[$field_names[$j]] != '')
						{
							$schema_insert .= '\'' . addslashes($row[$field_names[$j]]) . '\'';
						}
						else
						{
							$schema_insert .= '\'\'';
						}
					}

					$schema_insert = preg_replace('/;' . $crlf . '/s', '; ' . $crlf, $schema_insert) . ');';

					@$backup_write($file_handle, $schema_insert . $crlf);

				}
				while ($row = $db->sql_fetchrow($result));
			}
		}
	}

	@$backup_close($file_handle);

	if ( true )
	{
		$rep = $phpbb_root_path . '/db/db_backup/';
		$countadmin = ($do_now) ? 1 : 0;		// if function executed from PA, add 1 additional backup in db_backup dir
		$dir = opendir($rep);
		$files = array();
		while($file = readdir($dir))
		{
			if ( is_file($rep . $file) && ( substr($file, -3) == '.gz' || substr($file, -4) == '.sql' ) )
			{
				$files[$file] = fileatime($rep . $file);
			}
		}
		closedir($dir);

		arsort($files);
		reset($files);

		

		if ( count($files) > ($board_config['db_backup_copies'] + $countadmin) )
		{
			$i = 0;
			while (list($key, $val) = each($files))
			{
				$i++;
				if ( $i > ($board_config['db_backup_copies'] + $countadmin) )
				{
					@unlink($rep . $key);
				}
			}
		}
	}

	db_backup_stop();
	return;
}

?>