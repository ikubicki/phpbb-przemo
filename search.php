<?php
/***************************************************************************
 *                                search.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   modification         : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   date modification    : ver. 1.12.4 2005/11/09 16:57
 *
 *   $Id: search.php,v 1.72.2.17 2005/09/14 18:14:30 acydburn Exp $
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
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'includes/functions_search.'.$phpEx);
include($phpbb_root_path . 'includes/functions_add.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_SEARCH);
init_userprefs($userdata);
//
// End session management
//

$user_topics_per_page = ($userdata['user_topics_per_page'] > $board_config['topics_per_page']) ? $board_config['topics_per_page'] : $userdata['user_topics_per_page'];
$user_posts_per_page = ($userdata['user_posts_per_page'] > $board_config['posts_per_page']) ? $board_config['posts_per_page'] : $userdata['user_posts_per_page'];

$no_password_forum = ($userdata['user_level'] != ADMIN) ? "AND f.password = ''" : '';
$page_title = $lang['Search'];

if ( $board_config['login_require'] && !$userdata['session_logged_in'] )
{
	$message = $lang['login_require'] . '<br /><br />' . sprintf($lang['login_require_register'], '<a href="' . append_sid("profile.$phpEx?mode=register") . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

//
// Define initial vars
//
$mode = get_vars('mode', '', 'POST,GET');
$per_page = $from_sql = $where_sql = '';
$search_keywords = get_vars('search_keywords', '', 'POST,GET');
$search_author   = get_vars('search_author',   '', 'POST,GET');

if(!empty($search_author))
{
	$search_author = phpbb_clean_username($search_author);
	$search_author = str_replace(array('%', '_'), array('\%', '\_'), $search_author);
}

$search_id = get_vars('search_id', '', 'GET');
$show_results = get_vars('show_results', '', 'POST');
$show_results = ($show_results == 'topics') ? 'topics' : 'posts';

$sort_by       = get_vars('sort_by', 0, 'POST', true);
$search_terms  = (get_vars('search_terms', 0, 'POST') == 'all') ? 1 : 0;
$search_fields = get_vars('search_fields', '', 'POST');
$return_chars  = get_vars('return_chars', -1, 'POST', true);
$search_where  = get_vars('search_where', 'Root', 'POST');
$sort_dir      = get_vars('sort_dir', '', 'POST');
$sort_dir      = ($sort_dir == 'ASC') ? 'ASC' : 'DESC';

if ( !empty($HTTP_POST_VARS['search_time']) || !empty($HTTP_GET_VARS['search_time']))
{
	$search_time_value = ( ( ( !empty($HTTP_POST_VARS['search_time']) ) ? intval($HTTP_POST_VARS['search_time']) : intval($HTTP_GET_VARS['search_time']) ) );
	$search_time = CR_TIME - ( $search_time_value * 60 );
	$topic_days = (!empty($HTTP_POST_VARS['search_time'])) ? intval($HTTP_POST_VARS['search_time']) : intval($HTTP_GET_VARS['search_time']);
}
else
{
	$search_time_value = 0;
	$search_time = 0;
	$topic_days = 0;
}
if($search_keywords == '*' || $search_author == '*')
{
	message_die(GENERAL_MESSAGE, $lang['No_search_match']);
}
$search_author = ( isset($HTTP_GET_VARS['search_author_all']) && $HTTP_GET_VARS['search_author_all'] == '*' ) ? '*' : $search_author;

// Search time
$previous_days = array(0, 15, 30, 60, 120, 360, 720, 1440, 2880, 4320, 5760, 7200, 8640, 10080, 20160, 43200, 129600, 259200, 524160);
$previous_days_text = array($lang['All_Posts'], $lang['15_min'], $lang['30_min'], $lang['1_Hour'], $lang['2_Hour'], $lang['6_Hour'], $lang['12_Hour'], $lang['1_Day'], $lang['2_Days'], $lang['3_Days'], $lang['4_Days'], $lang['5_Days'], $lang['6_Days'], $lang['7_Days'], $lang['2_Weeks'], $lang['1_Month'], $lang['3_Months'], $lang['6_Months'], $lang['1_Year']);

if($search_author == '*' && ( !$search_time_value || !in_array($search_time_value, $previous_days) ) )
{
	message_die(GENERAL_MESSAGE, $lang['No_search_match']);	
}
$start = (isset($HTTP_GET_VARS['start'])) ? intval($HTTP_GET_VARS['start']) : 0;
if ( isset($HTTP_POST_VARS['start']) )
{
	$start = intval($HTTP_POST_VARS['start']);
}

$sort_by_types = array($lang['Sort_Time'], $lang['Topic_important'], $lang['Post_subject'], $lang['Sort_Topic_Title'], $lang['Author'], $lang['Forum']);

// encoding match for workaround
//$multibyte_charset = 'utf-8, big5, shift_jis, euc-kr, gb2312';

// Begin core code
if ( $mode == 'searchuser' )
{
	// This handles the simple windowed user search functions called from various other scripts
	if ( isset($HTTP_POST_VARS['search_username']) )
	{
		username_search($HTTP_POST_VARS['search_username']);
	}
	else
	{
		username_search('');
	}

	exit;
}
else if ( $search_keywords != '' || $search_author != '' || $search_id )
{
	$store_vars = array('search_results', 'total_match_count', 'split_search', 'sort_by', 'sort_dir', 'show_results', 'return_chars');
	$search_results = '';

	//
	// Search ID Limiter, decrease this value if you experience further timeout problems with searching forums
	$limiter = 5000;

	$unread_topics_ids = array();
	if ( $userdata['user_id'] != ANONYMOUS )
	{
		include($phpbb_root_path . 'includes/read_history.'.$phpEx);
		$userdata = user_unread_posts();
		foreach($userdata['unread_data'] as $forum_id => $topics)
		{
			$unread_topics_ids = array_merge($unread_topics_ids, array_keys($topics));
		}
	}

	// Cycle through options ...
	if ( $search_id == 'newposts' || $search_id == 'lastvisit' || $search_id == 'egosearch' || $search_id == 'unanswered' || $search_keywords != '' || $search_author != '' )
	{
		// Anty flood
		if($userdata['user_level'] != ADMIN && !$userdata['user_jr'] && $userdata['user_level'] != MOD) 
		{ 
			$where_sql = ($userdata['user_id'] == ANONYMOUS) ? "se.session_ip = '$user_ip'" : 'se.session_user_id = ' . $userdata['user_id']; 
			$sql = 'SELECT MAX(sr.search_time) AS last_search_time 
				FROM ' . SEARCH_TABLE . ' sr, ' . SESSIONS_TABLE . " se 
				WHERE sr.session_id = se.session_id 
					AND $where_sql"; 
			if ($result = $db->sql_query($sql)) 
			{ 
				if ($row = $db->sql_fetchrow($result)) 
				{ 
				$interval = ($userdata['user_id'] == ANONYMOUS) ? 20 : 10;
				if ($row['last_search_time'] > 0 && (CR_TIME - $row['last_search_time'] < $interval)) 
					{ 
						message_die(GENERAL_MESSAGE, $lang['Flood_Search']); 
					} 
				} 
			} 
		}	
		if ( $search_id == 'newposts' || $search_id == 'lastvisit' || $search_id == 'egosearch' || ( $search_author != '' && $search_keywords == '' ) )
		{
			if ( ($search_id == 'newposts' || $search_id == 'lastvisit') && $userdata['user_id'] != ANONYMOUS )
			{
				if ( $userdata['user_id'] != ANONYMOUS )
				{
					if ( $search_id == 'lastvisit' )
					{
						$sql = "SELECT post_id 
							FROM " . POSTS_TABLE . " 
							WHERE post_time >= " . $userdata['user_lastvisit'] . "
								AND poster_id <> " . $userdata['user_id'];
					}
					else
					{
						$sql = "SELECT post_id 
							FROM " . READ_HIST_TABLE . " 
							WHERE user_id = " . $userdata['user_id'];
					}

					$show_results = 'topics';
					$sort_by = 0;
					$sort_dir = 'DESC';
				}
				else
				{
					redirect(append_sid("login.$phpEx?redirect=search.$phpEx&search_id=newposts", true));
				}

				$show_results = 'topics';
				$sort_by = 0;
				$sort_dir = 'DESC';
			}
			else if ( $search_id == 'egosearch' )
			{
				if ( $userdata['user_id'] != ANONYMOUS )
				{
					$sql = "SELECT post_id 
						FROM " . POSTS_TABLE . " 
						WHERE poster_id = " . $userdata['user_id'];
				}
				else
				{
					redirect(append_sid("login.$phpEx?redirect=search.$phpEx&search_id=egosearch", true));
				}

				$show_results = 'topics';
				$sort_by = 0;
				$sort_dir = 'DESC';
			}
			else
			{
				if ( $search_author != '*' && (preg_match('#^[\*%]+$#', trim($search_author)) || preg_match('#^[^\*]{1}$#', str_replace(array('*', '%'), '', trim($search_author)))) )
				{
					$search_author = '';
				}
				$search_author = str_replace('*', '%', trim($search_author));
				
				$sql = "SELECT user_id
					FROM " . USERS_TABLE . "
					WHERE username LIKE '" . str_replace("\'", "''", $search_author) . "'";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Couldn\'t obtain list of matching users, searching for: ' . $search_author, '', __LINE__, __FILE__, $sql);
				}

				$matching_userids = '';
				if ( $row = $db->sql_fetchrow($result) )
				{
					do
					{
						$matching_userids .= (($matching_userids != '') ? ', ' : '') . $row['user_id'];
					}
					while( $row = $db->sql_fetchrow($result) );
				}
				else
				{
					message_die(GENERAL_MESSAGE, $lang['No_search_match']);
				}

				if ( $HTTP_GET_VARS['gh'] == 'helped' )
				{
					$sql = "SELECT post_id 
						FROM " . POSTS_TABLE . "
						WHERE poster_id IN ($matching_userids)
							AND post_marked = 'y'";
				}
				else
				{
					$sql = "SELECT post_id 
						FROM " . POSTS_TABLE . " 
						WHERE poster_id IN ($matching_userids)";
				}
				if ($search_time)
				{
					$sql .= " AND post_time >= " . $search_time;
				}
			}

			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain matched posts list', '', __LINE__, __FILE__, $sql);
			}

			$search_ids = array();
			while( $row = $db->sql_fetchrow($result) )
			{
				$search_ids[] = $row['post_id'];
			}
			$db->sql_freeresult($result);

			$total_match_count = count($search_ids);
		}
		else if ( $search_keywords != '' )
		{
			$search_keywords = substr($search_keywords, 0, 32);		
			$key_title = trim($search_keywords);
			$title_key = preg_replace( '/([[:space:]]){1,}/is', ' ', $key_title );
			$count_keywords = substr_count($title_key, ' ');
			$sum_keywords = ($count_keywords < 1) ? 1 : $count_keywords+1;
			if ( $sum_keywords > $board_config['search_keywords_max'] )
			{
				message_die(GENERAL_ERROR, sprintf($lang['search_keywords_error'], $board_config['search_keywords_max']));
			}
			$stopword_array = @file($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/search_stopwords.txt');
			$synonym_array = @file($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/search_synonyms.txt');

			$split_search = array();
			$stripped_keywords = stripslashes($search_keywords);
//			$split_search = ( !strstr($multibyte_charset, $lang['ENCODING']) ) ?  split_words(clean_words('search', $stripped_keywords, $stopword_array, $synonym_array), 'search') : split(' ', $search_keywords);	
			$split_search = split_words(clean_words('search', $stripped_keywords, $stopword_array, $synonym_array), 'search');
			unset($stripped_keywords);

			$word_count = 0;
			$current_match_type = 'or';

			$word_match = array();
			$result_list = array();

			for($i = 0; $i < count($split_search); $i++)
			{
				if (preg_match('#^[\*%]+$#', trim($split_search[$i])) || preg_match('#^[^\*]{1,2}$#', str_replace(array('*', '%'), '', trim($split_search[$i]))))
				{
					$split_search[$i] = '';
					continue;
				}

				switch ( $split_search[$i] )
				{
					case 'and':
						$current_match_type = 'and';
						break;

					case 'or':
						$current_match_type = 'or';
						break;

					case 'not':
						$current_match_type = 'not';
						break;

					default:
						if ( !empty($search_terms) )
						{
							$current_match_type = 'and';
						}

						// Searching by phrase but from posts text table it can load server
						$search_phrase = str_replace('\\', '', $search_keywords);
						if ( substr($search_phrase, -1) == '"' && substr($search_phrase, 0, 1) == '"' )
						{
							$phrase = stripslashes($search_keywords);

							switch ( $search_fields )
							{
								case 'msgonly':
									$search_match = "WHERE p.post_text LIKE '%" . str_replace('"', '', str_replace("\'", "''", $phrase)) . "%'";
									break;
								case 'titleonly':
									$search_match = "WHERE p.post_subject LIKE '%" . str_replace('"', '', str_replace("\'", "''", $phrase)) . "%'";
									break;
								case 'title_e_only':
									$search_match = ", " . TOPICS_TABLE . " t WHERE t.topic_title_e LIKE '%" . str_replace('"', '', str_replace("\'", "''", $phrase)) . "%' AND t.topic_first_post_id = p.post_id";
									break;
								default: // Disable search in post_subject and topic explain to no kill the MySQL server
									$search_match = "WHERE p.post_text LIKE '%" . str_replace('"', '', str_replace("\'", "''", $phrase)) . "%'";
									break;
							}

							$sql = "SELECT p.post_id
								FROM " . POSTS_TEXT_TABLE . " p
								$search_match";
						}
//						else if ( !strstr($multibyte_charset, $lang['ENCODING']) )
						else
						{
							$match_word = str_replace('*', '%', $split_search[$i]);

							switch ( $search_fields )
							{
								case 'msgonly':
									$search_match = "AND m.title_match = 0";
									break;
								case 'titleonly':
									$search_match = "AND m.title_match = 1";
									break;
								case 'title_e_only':
									$search_match = "AND m.title_match = 2";
									break;
								default:
									$search_match = "";
									break;
							}

							$sql = "SELECT m.post_id
								FROM (" . SEARCH_WORD_TABLE . " w, " . SEARCH_MATCH_TABLE . " m)
								WHERE w.word_text LIKE '$match_word'
									AND m.word_id = w.word_id
									AND w.word_common <> 1
									$search_match";
						}
/*
						else
						{
							$match_word = addslashes('%' . str_replace('*', '', $split_search[$i]) . '%');

							switch ( $search_fields )
							{
								case 'msgonly':
									$search_match = "post_text LIKE '$match_word'";
									break;
								case 'titleonly':
									$search_match = "post_subject LIKE '$match_word'";
									break;
//								case 'title_e_only':
//									$search_match = "AND m.title_match = 2";
//									break;
								default:
									$search_match = "post_text LIKE '$match_word' OR post_subject LIKE '$match_word'";
									break;
							}

							$sql = "SELECT post_id
								FROM " . POSTS_TEXT_TABLE . "
								WHERE " . $search_match;
						}
*/
						if ( !($result = $db->sql_query($sql)) )
						{
							message_die(GENERAL_MESSAGE, $lang['No_search_match']);
						}

						$row = array();
						while( $temp_row = $db->sql_fetchrow($result) )
						{
							$row[$temp_row['post_id']] = 1;

							if ( !$word_count )
							{
								$result_list[$temp_row['post_id']] = 1;
							}
							else if ( $current_match_type == 'or' )
							{
								$result_list[$temp_row['post_id']] = 1;
							}
							else if ( $current_match_type == 'not' )
							{
								$result_list[$temp_row['post_id']] = 0;
							}
						}

						if ( $current_match_type == 'and' && $word_count )
						{
							@reset($result_list);
							while( list($post_id, $match_count) = @each($result_list) )
							{
								if ( !$row[$post_id] )
								{
									$result_list[$post_id] = 0;
								}
							}
						}

						$word_count++;

						$db->sql_freeresult($result);
				}
			}

			@reset($result_list);

			$search_ids = array();
			while( list($post_id, $matches) = each($result_list) )
			{
				if ( $matches )
				{
					$search_ids[] = $post_id;
				}
			}
			
			unset($result_list);
			$total_match_count = count($search_ids);
		}

		// If user is logged in then we'll check to see which (if any) private
		// forums they are allowed to view and include them in the search.
		//
		// If not logged in we explicitly prevent searching of private forums
		$auth_sql = '';

		// get the object list
		$keys = array();
		$keys = get_auth_keys($search_where, true, -1, -1, 'auth_read');
		$s_flist = '';
		for ($i = 0; $i < count($keys['id']); $i++)
		{
			if ( ($tree['type'][ $keys['idx'][$i] ] == POST_FORUM_URL) && $tree['auth'][ $keys['id'][$i] ]['auth_read'] )
			{
				$s_flist .= (($s_flist != '') ? ', ' : '') . $tree['id'][ $keys['idx'][$i] ];
			}
		}
		/* Read topics bug which allow to preview private forums with allow to view only when choose only this forum!
		if ($s_flist != '')
		{
			$auth_sql .= (( $auth_sql != '' ) ? " AND" : '') . " f.forum_id IN ($s_flist) ";
		}
		*/
		// Replacing:
		if ($s_flist == '')
		{
			$s_flist = '0';
		}
		$auth_sql .= (( $auth_sql != '' ) ? " AND" : '') . " f.forum_id IN ($s_flist) ";
		// End replacing

		// Author name search 
		if ( $search_author != '' )
		{
 			if ( $search_author != '*' && (preg_match('#^[\*%]+$#', trim($search_author)) || preg_match('#^[^\*]{1}$#', str_replace(array('*', '%'), '', trim($search_author)))) )
			{
				$search_author = '';
			}
			$search_author = str_replace('*', '%', trim(str_replace("\'", "''", $search_author)));
		}

		if ( $total_match_count )
		{
			if ( $show_results == 'topics' )
			{
				$where_sql = '';

				if ( $search_time )
				{
					$where_sql .= ($search_author == '' && $auth_sql == '') ? " AND post_time >= $search_time " : " AND p.post_time >= $search_time ";
				}

				if ( $search_author == '' && $auth_sql == '' )
				{
					$sql = "SELECT topic_id 
						FROM " . POSTS_TABLE . "
						WHERE post_id IN (" . implode(", ", $search_ids) . ") 
							$where_sql 
						GROUP BY topic_id";
				}
				else
				{
					$from_sql = POSTS_TABLE . " p";

					if ( $search_author != '' )
					{
						$from_sql .= ", " . USERS_TABLE . " u";
						$where_sql .= " AND u.user_id = p.poster_id AND u.username LIKE '$search_author' ";
					}

					if ( $auth_sql != '' )
					{
						$from_sql .= ", " . FORUMS_TABLE . " f";
						$where_sql .= " AND f.forum_id = p.forum_id AND $auth_sql $no_password_forum";
					}

					$sql = "SELECT p.topic_id 
						FROM ($from_sql)
						WHERE p.post_id IN (" . implode(", ", $search_ids) . ") 
							$where_sql
						GROUP BY p.topic_id";
				}

				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not obtain topic ids', '', __LINE__, __FILE__, $sql);
				}

				$search_ids = array();
				while( $row = $db->sql_fetchrow($result) )
				{
					$search_ids[] = $row['topic_id'];
				}
				$db->sql_freeresult($result);

				$total_match_count = sizeof($search_ids);
			}
			else if ( $search_author != '' || $search_time || $auth_sql != '' )
			{
				$where_sql = ($search_author == '' && $auth_sql == '') ? 'post_id IN (' . implode(', ', $search_ids) . ')' : 'p.post_id IN (' . implode(', ', $search_ids) . ')';
				$from_sql = ($search_author == '' && $auth_sql == '') ? POSTS_TABLE : POSTS_TABLE . ' p';

				if ( $search_time )
				{
					$where_sql .= ($search_author == '' && $auth_sql == '') ? " AND post_time >= $search_time " : " AND p.post_time >= $search_time";
				}

				if ( $auth_sql != '' )
				{
					$from_sql .= ", " . FORUMS_TABLE . " f";
					$where_sql .= " AND f.forum_id = p.forum_id AND $auth_sql $no_password_forum";
				}

				if ( $search_author != '' )
				{
					$from_sql .= ", " . USERS_TABLE . " u";
					$where_sql .= " AND u.user_id = p.poster_id AND u.username LIKE '$search_author'";
				}

					$sql = "SELECT p.post_id 
						FROM ($from_sql)
						WHERE $where_sql";
					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not obtain post ids', '', __LINE__, __FILE__, $sql);
					}

					$search_ids = array();
					while( $row = $db->sql_fetchrow($result) )
					{
						$search_ids[] = $row['post_id'];
					}

					$db->sql_freeresult($result);

					$total_match_count = count($search_ids);
			}
		}
		else if ( $search_id == 'unanswered' )
		{
			if ( $auth_sql != '' )
			{
				$sql = "SELECT t.topic_id, f.forum_id
					FROM (" . TOPICS_TABLE . " t, " . FORUMS_TABLE . " f)
					WHERE t.topic_replies = 0 
						AND t.forum_id = f.forum_id
						AND t.topic_moved_id = 0
						AND $auth_sql $no_password_forum";
			}
			else
			{
				$sql = "SELECT topic_id 
					FROM " . TOPICS_TABLE . "
					WHERE topic_replies = 0 
						AND topic_moved_id = 0";
			}
				
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain post ids', '', __LINE__, __FILE__, $sql);
			}

			$search_ids = array();
			while( $row = $db->sql_fetchrow($result) )
			{
				$search_ids[] = $row['topic_id'];
			}
			$db->sql_freeresult($result);

			$total_match_count = count($search_ids);

			// Basic requirements
			$show_results = 'topics';
			$sort_by = 0;
			$sort_dir = 'DESC';
		}
		else
		{
			message_die(GENERAL_MESSAGE, $lang['No_search_match']);
		}

		// Finish building query (for all combinations)
		// and run it ...
		$sql = "SELECT session_id 
			FROM " . SESSIONS_TABLE;
		if ( $result = $db->sql_query($sql) )
		{
			$delete_search_ids = array();
			while( $row = $db->sql_fetchrow($result) )
			{
				$delete_search_ids[] = "'" . $row['session_id'] . "'";
			}

			if ( count($delete_search_ids) )
			{
				$sql = "DELETE FROM " . SEARCH_TABLE . " 
					WHERE session_id NOT IN (" . implode(", ", $delete_search_ids) . ")";
				if ( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not delete old search id sessions', '', __LINE__, __FILE__, $sql);
				}
			}
		}

		// Store new result data
		$search_results = implode(', ', $search_ids);
		$per_page = ( $show_results == 'posts' ) ? $user_posts_per_page : $user_topics_per_page;

		// Combine both results and search data (apart from original query)
		// so we can serialize it and place it in the DB
		$store_search_data = array();
		for($i = 0; $i < count($store_vars); $i++)
		{
			$store_search_data[$store_vars[$i]] = $$store_vars[$i];
		}

		$result_array = serialize($store_search_data);
		unset($store_search_data);

		mt_srand ((double) microtime() * 1000000);
		$search_id = mt_rand();

        $current_time = CR_TIME; 

        $sql = "UPDATE " . SEARCH_TABLE . " 
            SET search_id = $search_id, search_time = $current_time, search_array = '" . str_replace("\'", "''", $result_array) . "' 
            WHERE session_id = '" . $userdata['session_id'] . "'"; 
        if ( !($result = $db->sql_query($sql)) || !$db->sql_affectedrows() ) 
        { 
            $sql = "INSERT IGNORE INTO " . SEARCH_TABLE . " (search_id, session_id, search_time, search_array) 
                VALUES($search_id, '" . $userdata['session_id'] . "', $current_time, '" . str_replace("\'", "''", $result_array) . "')"; 
            if ( !($result = $db->sql_query($sql)) ) 
            { 
                message_die(GENERAL_ERROR, 'Could not insert search results', '', __LINE__, __FILE__, $sql); 
            } 
        }
	}
	else
	{
		$search_id = intval($search_id);
		if ( $search_id )
		{
			$sql_sid = ($HTTP_GET_VARS['sid'] && $HTTP_GET_VARS['sid'] != $userdata['session_id']) ? " OR session_id = '" . str_replace("\'", "''", $HTTP_GET_VARS['sid']) . "'" : '';

			$sql = "SELECT search_array
			FROM " . SEARCH_TABLE . "
			WHERE search_id = $search_id
				AND (session_id = '". $userdata['session_id'] . "' $sql_sid)";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain search results', '', __LINE__, __FILE__, $sql);
			}

			if ( $row = $db->sql_fetchrow($result) )
			{
				$search_data = unserialize($row['search_array']);
				for($i = 0; $i < count($store_vars); $i++)
				{
					$$store_vars[$i] = $search_data[$store_vars[$i]];
				}
			}
		}
	}

	// Look up data ...
	if ( $search_results != '' )
	{
		$colspan = '1';
		$colspan2 = '7';
		if ( $board_config['ignore_topics'] && $userdata['session_logged_in'] && isset($HTTP_GET_VARS['search_id']) == 'newposts' && $userdata['view_ignore_topics'] )
		{
			$template->assign_block_vars('ignore_topics', array(
				'U_IGNORE_TOPICS' => append_sid("ignore_topics.$phpEx"),
				'L_IGNORE_MARK' => $lang['ignore_mark'],
				'L_MARK_ALL' => $lang['Mark_all'])
			);

			$colspan++; $colspan2++;
		}

		if ( $show_results == 'posts' )
		{
			$sql = "SELECT pt.post_text, pt.bbcode_uid, pt.post_subject, p.*, f.forum_id, f.forum_name, f.forum_color, f.forum_moderate, t.*, u.username, u.user_id, u.user_sig, u.user_sig_bbcode_uid, u.user_level, u.user_jr, u.user_allowhtml
				FROM (" . FORUMS_TABLE . " f, " . TOPICS_TABLE . " t, " . USERS_TABLE . " u, " . POSTS_TABLE . " p, " . POSTS_TEXT_TABLE . " pt)
				WHERE p.post_id IN ($search_results)
					AND pt.post_id = p.post_id
					AND f.forum_id = p.forum_id
					AND p.topic_id = t.topic_id
					AND p.poster_id = u.user_id
					$no_password_forum";
		}
		else
		{
			if ( $board_config['post_overlib'] && $board_config['overlib'] && $userdata['overlib'] )
			{
				$post_text_select = ", pt.post_text, pt2.post_text as last_post_text";
				$post_text_where = "AND pt.post_id = t.topic_first_post_id AND pt2.post_id = t.topic_last_post_id";
				$posts_tables = ", " . POSTS_TEXT_TABLE . " pt, " . POSTS_TEXT_TABLE . " pt2";
			}
			else
			{
				$post_text_select = $post_text_where = $posts_tables = '';
			}
			$sql = "SELECT t.* $post_text_select, f.forum_id, f.forum_name, f.forum_color, f.forum_moderate, u.username, u.user_id, u.user_level, u.user_jr, u2.username as user2, u2.user_id as id2, u2.user_level as user_level2, u2.user_jr as user_jr2, p.post_username, p2.post_username AS post_username2, p2.post_time, ph.post_id as post_helped, p.post_approve, p2.post_approve as post_approve2
				FROM (" . TOPICS_TABLE . " t, " . FORUMS_TABLE . " f, " . USERS_TABLE . " u, " . POSTS_TABLE . " p, " . POSTS_TABLE . " p2, " . USERS_TABLE . " u2 $posts_tables)
				LEFT JOIN " . POSTS_TABLE . " ph ON (t.topic_id = ph.topic_id AND ph.post_marked = 'y')
				WHERE t.topic_id IN ($search_results) 
					AND t.topic_poster = u.user_id
					AND f.forum_id = t.forum_id 
					AND p.post_id = t.topic_first_post_id
					AND p2.post_id = t.topic_last_post_id
					AND u2.user_id = p2.poster_id
					$post_text_where
					$no_password_forum
				GROUP by t.topic_id";
		}

		$per_page = ($show_results == 'posts') ? $user_posts_per_page : $user_topics_per_page;

		$sql .= " ORDER BY ";

		switch ( $sort_by )
		{
			case 1:
				if ( $board_config['topic_color'] && !$board_config['topic_color_all'] )
				{
					$sql .= "t.topic_color $sort_dir, ";
				}
				if ( $show_results == 'posts' )
				{
					$sql .= "p.post_marked $sort_dir, ";
				}
				$sql .= "topic_type $sort_dir, u.special_rank $sort_dir, u.user_level $sort_dir, u.user_posts $sort_dir, topic_views $sort_dir, topic_replies";
				break;
			case 2:
				$sql .= ($show_results == 'posts') ? 'pt.post_subject' : 't.topic_title';
				break;
			case 3:
				$sql .= 't.topic_title';
				break;
			case 4:
				$sql .= 'u.username';
				break;
			case 5:
				$sql .= 'f.forum_id';
				break;
			case 6:
				break;
			default:
				$sql .= ($show_results == 'posts') ? 'p.post_time' : 'p2.post_time';
				break;
		}
		$sql .= " $sort_dir LIMIT $start, " . $per_page;

		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain search results', '', __LINE__, __FILE__, $sql);
		}

		$searchset = array();
		while( $row = $db->sql_fetchrow($result) )
		{
            if($row['post_start_time']>0) $row['post_time'] = $row['post_start_time'];
			$searchset[] = $row;
		}

		$db->sql_freeresult($result);

		// Define censored word matches
		$orig_word = array();
		$replacement_word = array();
		$replacement_word_html = array();
		obtain_word_list($orig_word, $replacement_word, $replacement_word_html);
		$count_orig_word = count($orig_word);

		// Output header
		include($phpbb_root_path . 'includes/page_header.'.$phpEx);

		if ( $show_results == 'posts' )
		{
			$template->set_filenames(array(
				'body' => 'search_results_posts.tpl')
			);
		}
		else
		{
			$template->set_filenames(array(
				'body' => 'search_results_topics.tpl')
			);
		}

		make_jumpbox('viewforum.'.$phpEx);

		$l_search_matches = ($total_match_count == 1) ? sprintf($lang['Found_search_match'], $total_match_count) : sprintf($lang['Found_search_matches'], $total_match_count);

		$template->assign_vars(array(
			'L_SEARCH_MATCHES' => $l_search_matches, 
			'L_TOPIC' => $lang['Topic'])
		);

		$highlight_active = '';
		$highlight_match = array();
		for($j = 0; $j < count($split_search); $j++ )
		{
			$split_word = $split_search[$j];

			if ( $split_word != 'and' && $split_word != 'or' && $split_word != 'not' )
			{
				$highlight_match[] = '#\b(' . str_replace("*", "([\w]+)?", $split_word) . ')\b#is';
				$highlight_active .= " " . $split_word;

				for ($k = 0; $k < count($synonym_array); $k++)
				{ 
					list($replace_synonym, $match_synonym) = explode(' ', trim(strtolower($synonym_array[$k])));

					if ( $replace_synonym == $split_word )
					{
						$highlight_match[] = '#\b(' . str_replace("*", "([\w]+)?", $replace_synonym) . ')\b#is';
						$highlight_active .= ' ' . $match_synonym;
					}
				} 
			}
		}

		$highlight_active = urlencode(trim($highlight_active));

		$take_part_topics = array();

		if ( $userdata['session_logged_in'] )
		{
			$sql = "SELECT topic_id FROM " . POSTS_TABLE . "
				WHERE poster_id = " . $userdata['user_id'] . "
				GROUP BY topic_id";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Couldn\'t obtain list of unread topics', '', __LINE__, __FILE__, $sql);
			}
			if ( $row = $db->sql_fetchrow($result) )
			{
				do
				{
					$take_part_topics[] = $row['topic_id'];
				}
				while( $row = $db->sql_fetchrow($result) );
			}
		}

		if( $userdata['session_logged_in'] && $board_config['overlib'] )
		{
			$gp_ids = array();
			foreach($searchset as $key => $val)
			{
				$gp_ids[] = $val['topic_id'];
			}
			get_poster_topic_posts($gp_ids, $userdata['user_id']);
		}
		for($i = 0; $i < count($searchset); $i++)
		{
			$forum_url = append_sid("viewforum.$phpEx?" . POST_FORUM_URL . '=' . $searchset[$i]['forum_id']);

			$set_highlight = ($highlight_active != '') ? '&amp;highlight=' . $highlight_active : '';

			$topic_url = (@in_array($searchset[$i]['topic_id'], $unread_topics_ids)) ? append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . '=' . $searchset[$i]['topic_id'] . "$set_highlight&amp;view=newest") : append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . '=' . $searchset[$i]['topic_id'] . "$set_highlight");

			$topic_urls[] = $topic_url;
			$post_url = append_sid("viewtopic.$phpEx?" . POST_POST_URL . '=' . $searchset[$i]['post_id'] . "&amp;highlight=$highlight_active") . '#' . $searchset[$i]['post_id'];

			$post_date = create_date($board_config['default_dateformat'], $searchset[$i]['post_time'], $board_config['board_timezone']);

			$forum_id = $searchset[$i]['forum_id'];
			$topic_id = $searchset[$i]['topic_id'];

			$message = $searchset[$i]['post_text'];
			$topic_title = $searchset[$i]['topic_title'];
			$topic_title_e = $searchset[$i]['topic_title_e'];

			$forum_moderate = ($searchset[$i]['forum_moderate']) ? true : false;
			$forum_view_moderate = ($forum_moderate && !$is_auth['auth_mod']) ? true : false;

			if ( $forum_moderate )
			{
				$is_auth = array();
				$is_auth = $tree['auth'][POST_FORUM_URL . $forum_id];
			}

			if ( $show_results == 'posts' )
			{
				if ( isset($return_chars) )
				{
					$bbcode_uid = $searchset[$i]['bbcode_uid'];

					if ( !$forum_moderate )
					{
						$is_auth = array();
						$is_auth = $tree['auth'][POST_FORUM_URL . $forum_id];
					}

					$show_post_html = ($board_config['allow_html'] && $searchset[$i]['user_allowhtml']) ? true : false;
					if ( (($searchset[$i]['user_level'] == MOD && $board_config['mod_html']) || ($board_config['admin_html'] && $searchset[$i]['user_level'] == ADMIN) || ($board_config['jr_admin_html'] && $searchset[$i]['user_jr'])) && $searchset[$i]['user_allowhtml'] )
					{
						$show_post_html = true;
					}						

					$strip_br = ($show_post_html && (strpos($message, '<td>') !== false || strpos($message, '<tr>') !== false || strpos($message, '<table>') !== false)) ? true : false;

					if ( $userdata['user_level'] == ADMIN || $userdata['user_jr'] || $is_auth['auth_mod'] )
					{
						$message = preg_replace("#\[mod\](.*?)\[/mod\]#si", "<br><u><b>Mod Info:</u><br>[</b>\\1<b>]</b><br>", $message);
					}
					else if ( strpos($message, "[mod]") !== false )
					{
						$message = preg_replace("#\[mod\](.*?)\[/mod\]#si", "", $message);
					}

					// If the board has HTML off but the post has HTML
					// on then we process it, else leave it alone

					if ( $return_chars != -1 )
					{
						$message = strip_tags($message);
						$message = preg_replace("/\[.*?:$bbcode_uid:?.*?\]/si", '', $message);
						$message = preg_replace('/\[url\]|\[\/url\]/si', '', $message);
						$message = (strlen($message) > $return_chars) ? substr($message, 0, $return_chars) . ' ...' : $message;
					}
					else
					{
						if ( !$show_post_html )
						{
							if ( $searchset[$i]['enable_html'] )
							{
								$message = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $message);
							}
						}

						if ( $bbcode_uid != '' )
						{
							$message = ($board_config['allow_bbcode']) ? bbencode_second_pass($message, $bbcode_uid, $userdata['username']) : preg_replace('/\:[0-9a-z\:]+\]/si', ']', $message);
							$message = bbencode_third_pass($message, $bbcode_uid, FALSE);
						}

						$message = make_clickable($message);

						if ( !$strip_br )
						{
							$message = str_replace("\n", "\n<br />\n", $message);
						}

						$highlight_active = false;
						if ( $highlight_active )
						{
							if ( preg_match('/<.*>/', $message) )
							{
								$message = preg_replace($highlight_match, '<!-- #sh -->\1<!-- #eh -->', $message);

								$end_html = 0;
								$start_html = 1;
								$temp_message = '';
								$message = ' ' . $message . ' ';

								while( $start_html = strpos($message, '<', $start_html) )
								{
									$grab_length = $start_html - $end_html - 1;
									$temp_message .= substr($message, $end_html + 1, $grab_length);

									if ( $end_html = strpos($message, '>', $start_html) )
									{
										$length = $end_html - $start_html + 1;
										$hold_string = substr($message, $start_html, $length);

										if ( strrpos(' ' . $hold_string, '<') != 1 )
										{
											$end_html = $start_html + 1;
											$end_counter = 1;

											while ( $end_counter && $end_html < strlen($message) )
											{
												if ( substr($message, $end_html, 1) == '>' )
												{
													$end_counter--;
												}
												else if ( substr($message, $end_html, 1) == '<' )
												{
													$end_counter++;
												}

												$end_html++;
											}

											$length = $end_html - $start_html + 1;
											$hold_string = substr($message, $start_html, $length);
											$hold_string = str_replace('<!-- #sh -->', '', $hold_string);
											$hold_string = str_replace('<!-- #eh -->', '', $hold_string);
										}
										else if ( $hold_string == '<!-- #sh -->' )
										{
											$hold_string = str_replace('<!-- #sh -->', '<span style="color:#' . $theme['fontcolor3'] . '"><b>', $hold_string);
										}
										else if ( $hold_string == '<!-- #eh -->' )
										{
											$hold_string = str_replace('<!-- #eh -->', '</b></span>', $hold_string);
										}

										$temp_message .= $hold_string;

										$start_html += $length;
									}
									else
									{
										$start_html = strlen($message);
									}
								}

								$grab_length = strlen($message) - $end_html - 1;
								$temp_message .= substr($message, $end_html + 1, $grab_length);

								$message = trim($temp_message);
							}
							else
							{
								$message = preg_replace($highlight_match, '<span style="color:#' . $theme['fontcolor3'] . '"><b>\1</b></span>', $message);
							}
						}
					}

					if ( $count_orig_word )
					{
						$topic_title = preg_replace($orig_word, $replacement_word, $topic_title);
						$post_subject = ($searchset[$i]['post_subject'] != '') ? preg_replace($orig_word, $replacement_word, $searchset[$i]['post_subject']) : $topic_title;

						$message = preg_replace($orig_word, $replacement_word_html, $message);
					}
					else
					{
						$post_subject = ( $searchset[$i]['post_subject'] != '' ) ? $searchset[$i]['post_subject'] : $topic_title;
					}

					if ($board_config['allow_smilies'] && $searchset[$i]['enable_smilies'] && $userdata['show_smiles'])
					{
						$message = smilies_pass($message);
					}
				}

				$colored_username = color_username($searchset[$i]['user_level'], $searchset[$i]['user_jr'], $searchset[$i]['user_id'], $searchset[$i]['username']);
				$searchset[$i]['username'] = $colored_username[0];

				$poster = ($searchset[$i]['user_id'] != ANONYMOUS) ? '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $searchset[$i]['user_id']) . '" class="name"' . $colored_username[1] . '>' : '';
				$poster .= ($searchset[$i]['user_id'] != ANONYMOUS) ? $searchset[$i]['username'] : ( ( $searchset[$i]['post_username'] != "" ) ? $searchset[$i]['post_username'] : $lang['Guest'] );
				$poster .= ($searchset[$i]['user_id'] != ANONYMOUS) ? '</a>' : '';

				if ( $userdata['session_logged_in'] && $searchset[$i]['post_time'] > $userdata['user_lastvisit'] )
				{
					if ( @in_array($searchset[$i]['post_id'], unread_forums_posts('list')) )
					{
						$mini_post_img = $images['icon_minipost_new'];
						$mini_post_alt = $lang['New_post'];
					}
					else
					{
						$mini_post_img = $images['icon_minipost'];
						$mini_post_alt = $lang['Post'];
					}
				}
				else
				{
					$mini_post_img = $images['icon_minipost'];
					$mini_post_alt = $lang['Post'];
				}
				$forum_name = get_object_lang(POST_FORUM_URL . $searchset[$i]['forum_id'], 'name');

				if ( $forum_moderate && !$searchset[$i]['post_approve'] )
				{
					if ( ($is_auth['auth_mod'] || $userdata['user_id'] == $searchset[$i]['poster_id']) && $userdata['user_id'] != ANONYMOUS )
					{
						$post_subject = '[<i>' . $lang['Post_no_approved'] . '</i>]';
					}
					else
					{
						$message = $poster = '';
						$post_subject = '[<i>' . $lang['Post_no_approved'] . '</i>]';
						if ( $searchset[$i]['post_id'] == $searchset[$i]['topic_first_post_id'] )
						{
							$topic_title = '';
						}
					}
				}

				$template->assign_block_vars("searchresults", array( 
					'TOPIC_TITLE' => $topic_title,
					'TOPIC_COLOR' => ($board_config['topic_color'] && $searchset[$i]['topic_color']) ? ' style="color: ' . $searchset[$i]['topic_color'] . '"' : '',
					'FORUM_NAME' => $forum_name,
					'FORUM_COLOR' => ($searchset[$i]['forum_color'] != '') ? ' style="color: #' . $searchset[$i]['forum_color'] . '"' : '',
					'POST_SUBJECT' => $post_subject,
					'POST_DATE' => $post_date,
					'POSTER_NAME' => $poster,
					'TOPIC_REPLIES' => $searchset[$i]['topic_replies'],
					'TOPIC_VIEWS' => $searchset[$i]['topic_views'],
					'MESSAGE' => $message,
					'MINI_POST_IMG' => $mini_post_img, 

					'L_MINI_POST_ALT' => $mini_post_alt, 

					'ROW' => ($searchset[$i]['post_marked'] == 'y') ? 'row_helped' : 'row1',
					'U_POST' => $post_url,
					'U_TOPIC' => $topic_url,
					'U_FORUM' => $forum_url)
				);
			}
			else
			{
				$message = '';

				if ( $count_orig_word )
				{
					$topic_title = preg_replace($orig_word, $replacement_word, $searchset[$i]['topic_title']);
					$topic_title_e = preg_replace($orig_word, $replacement_word, $searchset[$i]['topic_title_e']);
				}

				$topic_type = $searchset[$i]['topic_type'];

				if($topic_type == POST_GLOBAL_ANNOUNCE )
				{
					$topic_type = $lang['Topic_global_announcement'] . " ";
				}
				else if ($topic_type == POST_ANNOUNCE)
				{
					$topic_type = $lang['Topic_Announcement'] . ' ';
				}
				else if ($topic_type == POST_STICKY)
				{
					$topic_type = $lang['Topic_Sticky'] . ' ';
				}
				else
				{
					$topic_type = '';
				}

				if ( $searchset[$i]['topic_vote'] )
				{
					$topic_type .= $lang['Topic_Poll'] . ' ';
				}

				$views = $searchset[$i]['topic_views'];
				$replies = $searchset[$i]['topic_replies'];

				if ( ( $replies + 1 ) > $user_posts_per_page )
				{
					$total_pages = ceil( ($replies + 1) / $user_posts_per_page );
					$goto_page = ' [ <img src="' . $images['icon_gotopost'] . '" alt="' . $lang['Goto_page'] . '" title="' . $lang['Goto_page'] . '" />' . $lang['Goto_page'] . ': ';

					$times = 1;
					for($j = 0; $j < $replies + 1; $j += $user_posts_per_page)
					{
						$goto_page .= '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=" . $topic_id . "&amp;start=$j") . '">' . $times . '</a>';
						if ( $times == 1 && $total_pages > 4 )
						{
							$goto_page .= ' ... ';
							$times = $total_pages - 3;
							$j += ($total_pages - 4) * $user_posts_per_page;
						}
						else if ( $times < $total_pages )
						{
							$goto_page .= ', ';
						}
						$times++;
					}
					$goto_page .= ' ] ';
				}
				else
				{
					$goto_page = '';
				}

				if ( $searchset[$i]['topic_status'] == TOPIC_MOVED )
				{
					$topic_type = $lang['Topic_Moved'] . ' ';
					$topic_id = $searchset[$i]['topic_moved_id'];

					$folder_image = '<img src="' . $images['folder'] . '" alt="' . $lang['No_new_posts'] . '" />';
					$newest_post_img = '';
				}
				else
				{
					if ( $searchset[$i]['topic_status'] == TOPIC_LOCKED )
					{
						$folder = $images['folder_locked'];
						$folder_new = $images['folder_locked_new'];
					}
					else if ( $searchset[$i]['topic_type'] == POST_ANNOUNCE || $searchset[$i]['topic_type'] == POST_GLOBAL_ANNOUNCE )
					{
						$folder = $images['folder_announce'];
						$folder_new = $images['folder_announce_new'];
					}
					else if ( $searchset[$i]['topic_type'] == POST_STICKY )
					{
						$folder = $images['folder_sticky'];
						$folder_new = $images['folder_sticky_new'];
					}
					else
					{
						if ( $replies >= $board_config['hot_threshold'] )
						{
							$folder = $images['folder_hot'];
							$folder_new = $images['folder_hot_new'];
						}
						else
						{
							$folder = $images['folder'];
							$folder_new = $images['folder_new'];
						}
					}

					if ( $userdata['session_logged_in'] )
					{
						if ( @in_array($topic_id, $unread_topics_ids) )
						{
							$folder_image = $folder_new;
							$folder_alt = $lang['New_posts'];

							$newest_post_img = '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;view=newest") . '"><img src="' . $images['icon_newest_reply'] . '" alt="' . $lang['View_newest_post'] . '" title="' . $lang['View_newest_post'] . '" border="0" /></a> ';
						}
						else
						{
							$folder_alt = ($searchset[$i]['topic_status'] == TOPIC_LOCKED) ? $lang['Topic_locked'] : $lang['No_new_posts'];

							$folder_image = $folder;
							$folder_alt = $folder_alt;
							$newest_post_img = '';
						}
					}
					else
					{
						$folder_image = $folder;
						$folder_alt = ($searchset[$i]['topic_status'] == TOPIC_LOCKED) ? $lang['Topic_locked'] : $lang['No_new_posts'];
						$newest_post_img = '';
					}
				}

				$colored_username = color_username($searchset[$i]['user_level'], $searchset[$i]['user_jr'], $searchset[$i]['user_id'], $searchset[$i]['username']);
				$searchset[$i]['username'] = $colored_username[0];

				$colored_username2 = color_username($searchset[$i]['user_level2'], $searchset[$i]['user_jr2'], $searchset[$i]['id2'], $searchset[$i]['user2']);
				$searchset[$i]['user2'] = $colored_username2[0];

				$topic_author = ($searchset[$i]['user_id'] != ANONYMOUS) ? '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '=' . $searchset[$i]['user_id']) . '" class="name"' . $colored_username[1] . '>' : '';
				$topic_author .= ($searchset[$i]['user_id'] != ANONYMOUS) ? $searchset[$i]['username'] : ( ( $searchset[$i]['post_username'] != '' ) ? $searchset[$i]['post_username'] : $lang['Guest'] );

				$topic_author .= ($searchset[$i]['user_id'] != ANONYMOUS) ? '</a>' : '';

				$first_post_time = create_date($board_config['default_dateformat'], $searchset[$i]['topic_time'], $board_config['board_timezone']);

				$last_post_time = create_date($board_config['default_dateformat'], $searchset[$i]['post_time'], $board_config['board_timezone']);

				$last_post_author = ($searchset[$i]['id2'] == ANONYMOUS) ? ( ($searchset[$i]['post_username2'] != '' ) ? $searchset[$i]['post_username2'] . ' ' : $lang['Guest'] . ' ' ) : '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '=' . $searchset[$i]['id2']) . '" class="name"' . $colored_username2[1] . '>' . $searchset[$i]['user2'] . '</a>';

				$last_post_url = '<a href="' . append_sid("viewtopic.$phpEx?" . POST_POST_URL . '=' . $searchset[$i]['topic_last_post_id']) . '#' . $searchset[$i]['topic_last_post_id'] . '"><img src="' . $images['icon_latest_reply'] . '" alt="' . $lang['Last_Post'] . '" title="' . $lang['Last_Post'] . '" border="0" /></a>';
	
				$forum_name = get_object_lang(POST_FORUM_URL . $searchset[$i]['forum_id'], 'name');

				if ( !empty($HTTP_SERVER_VARS['SERVER_NAME']) || !empty($HTTP_ENV_VARS['SERVER_NAME']) )
				{
					$server_name = ( !empty($HTTP_SERVER_VARS['SERVER_NAME']) ) ? $HTTP_SERVER_VARS['SERVER_NAME'] : $HTTP_ENV_VARS['SERVER_NAME'];
				}
				else if ( !empty($HTTP_SERVER_VARS['HTTP_HOST']) || !empty($HTTP_ENV_VARS['HTTP_HOST']) )
				{
					$server_name = ( !empty($HTTP_SERVER_VARS['HTTP_HOST']) ) ? $HTTP_SERVER_VARS['HTTP_HOST'] : $HTTP_ENV_VARS['HTTP_HOST'];
				}
				else
				{
					$server_name = '';
				}

				$overlib_last_post_text = $first_and_last_post = $topic_add_title = $if_poster_posts = $overlib_title = $overlib_post_text = $overlib_unread_posts = '';
				if ( $board_config['overlib'] && $userdata['overlib'] )
				{
					if ( $board_config['post_overlib'] )
					{
						if ( $forum_view_moderate && (!$searchset[$i]['post_approve'] || !$searchset[$i]['post_approve2']) )
						{
							if ( !$searchset[$i]['post_approve'] )
							{
								$searchset[$i]['post_text'] = $lang['Post_no_approved'];
							}
							if ( !$searchset[$i]['post_approve2'] )
							{
								$searchset[$i]['last_post_text'] = $lang['Post_no_approved'];
							}
						}
						$first_and_last_post = ($searchset[$i]['post_text'] == $searchset[$i]['last_post_text']) ? false : true;

						$prepared_overlib_text = prepare_overlib_text($searchset[$i]['post_text'], $searchset[$i]['last_post_text']);
						$overlib_post_text = $prepared_overlib_text[0];
						$overlib_last_post_text = $prepared_overlib_text[1];
					}
					else
					{
						$overlib_post_text = $overlib_last_post_text = $first_and_last_post = '';
					}

					if ( $userdata['session_logged_in'] )
					{
						$poster_posts = get_poster_topic_posts($topic_id, $userdata['user_id']);
						if ( $poster_posts )
						{
							$overlib_title = $lang['poster_posts'];
							$topic_add_title = ($board_config['poster_posts']) ? '&#164; ' : '';
							$if_poster_posts = '&raquo; ' . $lang['your_posts'] . ': <b>' . $poster_posts . '</b><br />';
						}
						else
						{
							$overlib_title = $lang['not_poster_post'];
						}

						$count_unread_posts = count($userdata['unread_data'][$searchset[$i]['forum_id']][$topic_id]);
						$overlib_unread_posts = (($count_unread_posts) ? '&raquo; ' . $lang['unread_posts'] . ': <b>' . $count_unread_posts . '</b><br />' : '');

						$topic_title = $topic_add_title . $topic_title;
					}
					else if ( $overlib_post_text )
					{
						$overlib_title = ($first_and_last_post) ? $lang['First_post'] . ' :: ' . $lang['Last_Post'] : $lang['First_post'];
					}
				}

				if ( $forum_moderate )
				{
					if ( !$searchset[$i]['post_approve'] )
					{
						if ( ($searchset[$i]['topic_poster'] == $userdata['user_id'] && $userdata['user_id'] != ANONYMOUS) || $is_auth['auth_mod'] )
						{
							$topic_title = $topic_title . '<br /><i><b>' . $lang['Post_no_approved'] . '</b></i>';
							$topic_title_e = '';
						}
						else
						{
							$topic_title = '<i><b>' . $lang['Post_no_approved'] . '</b></i>';
							$topic_author  = $topic_title_e = '';
						}
					}
					if ( !$searchset[$i]['post_approve2'] )
					{
						if ( (($searchset[$i]['id2'] == $userdata['user_id'] && $userdata['user_id'] != ANONYMOUS) || $is_auth['auth_mod']) && $searchset[$i]['topic_first_post_id'] != $searchset[$i]['topic_last_post_id'] )
						{
							$last_post_author = '<i>' . $lang['Post_no_approved'] . '</i><br />' . $last_post_author;
						}
						else
						{
							$last_post_author = '';
						}
					}
				}

				$template->assign_block_vars('searchresults', array( 
					'FORUM_NAME' => $forum_name,
					'FORUM_COLOR' => ($searchset[$i]['forum_color'] != '') ? ' style="color: #' . $searchset[$i]['forum_color'] . '"' : '',
					'FORUM_ID' => $forum_id,
					'TOPIC_ID' => $topic_id,
					'FOLDER' => $folder_image,
					'NEWEST_POST_IMG' => $newest_post_img, 
					'TOPIC_FOLDER_IMG' => $folder_image, 
					'GOTO_PAGE' => $goto_page,
					'REPLIES' => $replies,
					'TOPIC_TITLE' => $topic_title,
					'TOPIC_COLOR' => ($board_config['topic_color'] && $searchset[$i]['topic_color']) ? ' style="color: ' . $searchset[$i]['topic_color'] . '"' : '',
					'TOPIC_TITLE_E' => ($topic_title_e && $board_config['title_explain']) ? '<br />' . $topic_title_e : '',
					'TOPIC_TYPE' => $topic_type,
					'VIEWS' => $views,
					'TOPIC_AUTHOR' => $topic_author, 
					'FIRST_POST_TIME' => $first_post_time, 
					'LAST_POST_TIME' => $last_post_time,
					'LAST_POST_AUTHOR' => $last_post_author,
					'LAST_POST_IMG' => $last_post_url,
					'L_TOPIC_FOLDER_ALT' => $folder_alt,

					'ROW' => ($searchset[$i]['post_helped']) ? 'row_helped' : 'row2',
					'U_VIEW_FORUM' => $forum_url, 
					'U_VIEW_TOPIC' => $topic_url)
				);

				if ( $board_config['ignore_topics'] && $userdata['session_logged_in'] && $userdata['view_ignore_topics'] && isset($HTTP_GET_VARS['search_id']) == 'newposts' )
				{
					$template->assign_block_vars('searchresults.it', array('TOPIC_ID' => $topic_id));
				}

				if ( $overlib_post_text )
				{
					$template->assign_block_vars('searchresults.title_overlib', array(
						'L_FIRST_POST' => $lang['First_post'],
						'L_LAST_POST' => $lang['Last_Post'],
						'UNREAD_POSTS' => $overlib_unread_posts,
						'O_TITLE' => $overlib_title,
						'O_TEXT1' => $overlib_post_text)
					);

					if ( $first_and_last_post )
					{
						$template->assign_block_vars('searchresults.title_overlib.last', array(
							'O_TEXT2' => $overlib_last_post_text)
						);
					}
				}
			}
		}

		if ( $show_results != 'posts' && $board_config['open_in_windows'] && $_SERVER['REQUEST_URI'] && $server_name )
		{
			$topic_urls = array_reverse($topic_urls);
			$count_topic_urls = $ctu = count($topic_urls);
			$template->assign_block_vars('new_windows', array());
			for($i = 0; $i < $count_topic_urls; $i++)
			{
				$amp = (strpos($topic_urls[$i], '?')) ? '&amp;' : '?';
				$ctu--;
				$template->assign_block_vars('new_windows.list', array( 
					'OPEN_ALL_NEW_WINDOW' => $topic_urls[$i] . $amp . 'sleep=' . ($ctu * 5))
				);
			}
		}

		$base_url = "search.$phpEx?search_id=$search_id&amp;sid=" . (($HTTP_GET_VARS['sid']) ? $HTTP_GET_VARS['sid'] : $userdata['session_id']);

		$page_number = sprintf($lang['Page_of'], ( floor( $start / $per_page ) + 1 ), ceil( $total_match_count / $per_page ));
		if ( ceil( $total_match_count / $per_page ) == 1 )
		{
			$page_number = '';
		}

		generate_pagination($base_url, $total_match_count, $per_page, $start);

		$template->assign_vars(array(
			'L_MARK_FORUMS_READ' => $lang['Mark_all_forums'],
			'U_MARK_READ' => "index.$phpEx?mark=forums&amp;sid=" . $userdata['session_id'],

			'L_AUTHOR' => $lang['Author'],
			'L_MESSAGE' => $lang['Message'],
			'L_FORUM' => $lang['Forum'],
			'L_TOPICS' => $lang['Topics'],
			'L_REPLIES' => $lang['Replies'],
			'L_VIEWS' => $lang['Views'],
			'L_POSTS' => $lang['Posts'],
			'L_LASTPOST' => $lang['Last_Post'], 
			'L_POSTED' => $lang['Posted'], 
			'L_SUBJECT' => $lang['Subject'],
			'L_OPEN_ALL' => $lang['open_all_new_window'],
			'COLSPAN' => $colspan,
			'COLSPAN2' => $colspan2,
			'FOLDER_IMG' => $images['folder'])
		);

		$template->pparse('body');

		include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
	}
	else
	{
		message_die(GENERAL_MESSAGE, $lang['No_search_match']);
	}
}

// Search forum

$s_forums = get_tree_option();

// Number of chars returned
$s_characters = '<option value="-1" selected="selected">' . $lang['All_available'] . '</option>';
$s_characters .= '<option value="0">0</option>';
$s_characters .= '<option value="25">25</option>';
$s_characters .= '<option value="50">50</option>';
$s_characters .= '<option value="100">100</option>';
$s_characters .= '<option value="300">300</option>';
$s_characters .= '<option value="600">600</option>';
$s_characters .= '<option value="1000">1000</option>';

// Sorting
$s_sort_by = "";
for($i = 0; $i < count($sort_by_types); $i++)
{
	$s_sort_by .= '<option value="' . $i . '">' . $sort_by_types[$i] . '</option>';
}



$s_time1 = '';
$s_time2 = '';
for($i = 0; $i < count($previous_days); $i++)
{
	$selected = ($topic_days == $previous_days[$i]) ? ' selected="selected"' : '';
	$s_time1 .= '<option value="' . $previous_days[$i] . '"' . $selected . '>' . $previous_days_text[$i] . '</option>';

	if(intval($previous_days[$i]) > 0)
	{
		$s_time2 .= '<option value="' . $previous_days[$i] . '"' . $selected . '>' . $previous_days_text[$i] . '</option>';
	}
}

// Output the basic page
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'body' => 'search_body.tpl')
);

make_jumpbox('viewforum.'.$phpEx);

$template->assign_vars(array(
	'L_SEARCH_QUERY' => $lang['Search_query'],
	'L_SEARCH_OPTIONS' => $lang['Search_options'],
	'L_SEARCH_KEYWORDS' => $lang['Search_keywords'],
	'L_SEARCH_KEYWORDS_EXPLAIN' => $lang['Search_keywords_explain'],
	'L_SEARCH_AUTHOR' => $lang['Search_author'],
	'L_SEARCH_AUTHOR_EXPLAIN' => $lang['Search_author_explain'],
	'L_SEARCH_ANY_TERMS' => $lang['Search_for_any'],
	'L_SEARCH_ALL_TERMS' => $lang['Search_for_all'],
	'L_SEARCH_MESSAGE_ONLY' => $lang['Search_msg_only'],
	'L_SEARCH_TITLE_ONLY' => $lang['Search_title_only'],
	'L_SEARCH_TITLE_E_ONLY' => $lang['Search_title_e_only'],
	'L_SEARCH_MESSAGE_TITLE' => $lang['Search_title_msg'],
	'L_CATEGORY' => $lang['Category'],
	'L_RETURN_FIRST' => $lang['Return_first'],
	'L_CHARACTERS' => $lang['characters_posts'],
	'L_SORT_BY' => $lang['Sort_by'],
	'L_SORT_ASCENDING' => $lang['Sort_Ascending'],
	'L_SORT_DESCENDING' => $lang['Sort_Descending'],
	'L_SEARCH_PREVIOUS' => $lang['Search_previous'],
	'L_DISPLAY_RESULTS' => $lang['Display_results'],
	'L_FORUM' => $lang['Forum'],
	'L_TOPICS' => $lang['Topics'],
	'L_POSTS' => $lang['Posts'],
	'L_SEARCH_POST_TIME' => $lang['Search_post_time'],
	'L_SEARCH_POST_TIME_E' => $lang['Search_post_time_e'],

	'U_SEARCH_USERS' => '<a href="' . append_sid("seeker.$phpEx") . '">' . $lang['Seeker'] . '</a>',
	'FOLDER_IMG' => $images['folder'],
	'S_SEARCH_ACTION_LAST' => append_sid("search.$phpEx?mode=results&amp;search_author_all=*"),
	'S_SEARCH_ACTION' => append_sid("search.$phpEx?mode=results"),
	'S_CHARACTER_OPTIONS' => $s_characters,
	'S_FORUM_OPTIONS' => $s_forums,
	'S_CATEGORY_OPTIONS' => $s_categories ?? '',
	'S_TIME_OPTIONS1' => $s_time1,
	'S_TIME_OPTIONS2' => $s_time2,
	'S_SORT_OPTIONS' => $s_sort_by,
	'S_HIDDEN_FIELDS' => $s_hidden_fields ?? '')
);

if ($board_config['search_enable'])
{
	$template->assign_block_vars('enable_search', array());
}

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>