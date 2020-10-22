<?php
/***************************************************************************
 *                      functions_hierarchy.php
 *                      -------------------
 *  begin               : Saturday, Feb 13, 2001
 *  copyright           : (C) 2003 Ptirhiik (Pierre) http://www.rpgnet-fr.com
 *  email               : admin@rpgnet-fr.com
 *  modification        : (C) 2003 Przemo http://www.przemo.org/phpBB2/
 *  date modification   : ver. 1.12.0 2005/11/11 13:28
 *
 ***************************************************************************/

/***************************************************************************
 *	This program is free software; you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation; either version 2 of the License, or
 *	(at your option) any later version.
 ***************************************************************************/

function get_max_depth($cur = 'Root', $all = false, $level = -1, &$keys, $max = -1)
{
	global $tree;
	if ( empty($keys['id']) )
	{
		$keys = [];
		$keys = get_auth_keys($cur, $all);
	}

	$max_level = 0;
	for($i = 0; $i < count($keys['id']); $i++)
	{
		if ( $keys['level'][$i] > $max_level )
		{
			$max_level = $keys['level'][$i];
		}
	}
	return $max_level;
}

function build_index($cur = 'Root', $cat_break = false, &$forum_moderators, $real_level = -1, $max_level = -1, &$keys, $br = false)
{
	global $userdata, $db, $lang, $template, $phpEx, $board_config, $lang, $images, $theme;
	global $tree, $phpEx, $idx_buffer, $readhist_buffer, $userdata, $HTTP_COOKIE_VARS, $unique_cookie_name;

	static $handled = [];

	// init
	$display = false;

	$board_config['split_cat'] = (!$board_config['split_cat_over']) ? $userdata['user_split_cat'] : $board_config['split_cat'];

	// get the sub_forum switch value
	$board_config['sub_forum'] = (!$board_config['sub_forum_over']) ? $userdata['user_sub_forum'] : $board_config['sub_forum'];
	$sub_forum = intval($board_config['sub_forum']);
	if ( ($sub_forum == 2) && defined('IN_VIEWFORUM') )
	{
		$sub_forum = 1;
	}
	$pack_first_level = ($sub_forum == 2);

	// verify the cat_break parm
	if ( ($cur != 'Root') && ($real_level == -1) )
	{
		$cat_break = false;
	}

	// display the level
	$athis = isset($tree['keys'][$cur]) ? $tree['keys'][$cur] : -1;

	// display each kind of row

	// root level head
	if ( $real_level == -1 )
	{
		// get max inc level
		$max = -1;
		if ( $sub_forum == 2 )
		{
			$max = 0;
		}
		if ( $sub_forum == 1 )
		{
			$max = 1;
		}
		$keys = [];
		$keys = get_auth_keys($cur, false, -1, $max);
		$max_level = get_max_depth($cur, false, -1, $keys, $max);
	}

	// table header
	if ( ($board_config['split_cat'] && $cat_break && ($real_level == 0)) || ((!$board_config['split_cat'] || !$cat_break) && ($real_level == -1)) )
	{
		// if break, get the local max level
		if ( $board_config['split_cat'] && $cat_break && ($real_level == 0) )
		{
			$max_level = 0;
			// the array is sorted
			$start = false;
			$stop = false;
			for($i=0; ($i < count($keys['id']) && !$stop); $i++)
			{
				if ( $start && ($tree['main'][$keys['idx'][$i]] == $tree['main'][$athis]) )
				{
					$stop = true;
					$break;
				}
				if ( $keys['id'][$i] == $cur )
				{
					$start = true;
				}
				if ( $start && !$stop && ($keys['level'][$i] > $max_level) )
				{
					$max_level = $keys['level'][$i];
				}
			}
		}
		$template->block('catrow', []);
		$template->block('catrow.tablehead', array(
			'CAT_ID' => $cur,
			'L_FORUM' => ($athis < 0) ? $lang['Forum'] : get_object_lang($cur, 'name'),
			'U_FORUM' => append_sid("index.$phpEx?" . POST_CAT_URL . "=" . substr($cur, 1)),
			'CAT_DESCRIPTION' => get_object_lang($cur, 'desc'),
			'INC_SPAN' => $max_level + 2)
		);

		$handled[] = $cur;
		if ( $cur != 'Root' )
		{
			$template->block('catrow.tablehead.br', array('CAT_ID' => $cur));
		}
	}

	// get the level
	$level = $keys['level'][$keys['keys'][$cur]];

	// sub-forum view management
	$pull_down = true;
	if ( $sub_forum > 0 )
	{
		$pull_down = false;
		if ( ($real_level == 0) && ($sub_forum == 1) )
		{
			$pull_down = true;
		}
	}

	if ( $level >= 0 )
	{
		// cat header row
		if ( ($tree['type'][$athis] == POST_CAT_URL) && $pull_down )
		{
			// display a cat row
			$cat = $tree['data'][$athis];
			$cat_id = $tree['id'][$athis];
			
			if (!in_array(POST_CAT_URL . $cat_id, $handled)) {

				// get the class colors
				$class_catLeft = 'catLeft';
				$class_cat = 'cat';
				$class_rowpic = 'rowpic';

				// send to template
				$template->block('catrow', []);
				$template->block('catrow.cathead', array(
					'CAT_ID' => $cat_id,
					'CAT_TITLE'	=> get_object_lang($cur, 'name'),
					'CAT_DESCRIPTION' => get_object_lang(POST_CAT_URL . $cat_id, 'desc'),
					'CLASS_CATLEFT'	=> $class_catLeft,
					'CLASS_CAT'	=> $class_cat,
					'CLASS_ROWPIC'	=> $class_rowpic,
					'INC_SPAN'	=> $max_level - $level + 2,
					'U_VIEWCAT'	=> append_sid("index.$phpEx?" . POST_CAT_URL . "=$cat_id"))
				);
				$handled[] = POST_CAT_URL . $cat_id;
				// add indentation to the display
				for($k = 1; $k <= $level; $k++)
				{
					$template->block('catrow.cathead.inc', array(
						'INC_CLASS' => ($k % 2) ? 'row1' : 'row2')
					);
				}
				if (!empty($cat['cat_desc']))
				{
					$template->block('catrow', []);
					$template->block('catrow.cattitle', array(
						'CAT_DESCRIPTION' => get_object_lang(POST_CAT_URL . $cat_id, 'desc'),
						'INC_SPAN_ALL' => $max_level - $level + 5)
					);
					// add indentation to the display
					for($k = 1; $k <= $level; $k++)
					{
						$template->block('catrow.cattitle.inc', array(
							'INC_CLASS' => ($k % 2) ? 'row1' : 'row2')
						);
					}
				}
			}
			// something displayed
			$display = true;
		}
	}

	// forum header row
	if ( $level >= 0 )
	{
		if ( ($tree['type'][$athis] == POST_FORUM_URL) || (($tree['type'][$athis] == POST_CAT_URL) && !$pull_down) )
		{
			// get the data
			$data	= $tree['data'][$athis];
			$id = $tree['id'][$athis];
			$type = $tree['type'][$athis];
			$sub = (!empty($tree['sub'][$cur]) && $tree['auth'][$cur]['tree.auth_view']);

			// specific to the data type
			$title = get_object_lang($cur, 'name');
			$desc = get_object_lang($cur, 'desc');

			// specific to something attached
			if ( $sub )
			{
				$i_new		= $images['category_new'];
				$a_new		= $lang['New_posts'];
				$i_norm		= $images['category'];
				$a_norm		= $lang['No_new_posts'];
				$i_locked	= $images['category_locked'];
				$a_locked	= $lang['Forum_locked'];
			}
			else
			{
				$i_new		= $images['forum_new'];
				$a_new		= $lang['New_posts'];
				$i_norm		= $images['forum'];
				$a_norm		= $lang['No_new_posts'];
				$i_locked	= $images['forum_locked'];
				$a_locked	= $lang['Forum_locked'];
			}

			// forum link type
			if ( ($tree['type'][$athis] == POST_FORUM_URL) && !empty($tree['data'][$athis]['forum_link']) )
			{
				$i_new		= $images['link'];
				$a_new		= $lang['Forum_link'];
				$i_norm		= $images['link'];
				$a_norm		= $lang['Forum_link'];
				$i_locked	= $images['link'];
				$a_locked	= $lang['Forum_link'];
			}

			if ( defined('IN_VIEWFORUM') && !defined('UNREAD_POSTS') && $userdata['user_id'] != ANONYMOUS )
			{
				define('UNREAD_POSTS', true);
				$userdata = user_unread_posts();
			}

			$forum_id = $tree['id'][$athis];

			// front icon
			$smart_new = false;
			if ( $userdata['session_logged_in'] && $forum_id && $type == POST_FORUM_URL )
			{
				if ( isset($userdata['unread_data'][$forum_id]) )
				{
					$smart_new = true;
				}
			}

			$folder_image = ( $smart_new ) ? $i_new : $i_norm;
			$folder_alt = ( $smart_new ) ? $a_new : $a_norm;

			if ( $data['tree.locked'] )
			{
				$folder_image = $i_locked;
				$folder_alt	= $a_locked;
			}

			// moderators list
			$l_moderators	= '&nbsp;';
			$moderator_list = '&nbsp;';
			if ( $type == POST_FORUM_URL )
			{
				$forum_moderators = moderarots_list($id, 'groups');
				$count_moderators = count($forum_moderators);

				if ( $count_moderators > 0 )
				{
					$moderator_list = implode(', ', $forum_moderators);
					$l_moderators = ( $count_moderators == 1 ) ? $lang['Moderator'] : $lang['Moderators'];
				}
			}

			// last post
			$last_post = '--';

			if ( $data['tree.topic_last_post_id'] )
			{
				$topic_title = $data['tree.topic_title'];
				if ( strlen($topic_title) > (intval($board_config['last_topic_title_length']) -3 ) )
				{
					$topic_title = htmlentities(substr(html_entity_decode($topic_title), 0, intval($board_config['last_topic_title_length']))) . '...';
				}

				if ( !$data['tree.topic_accept'] )
				{
					$is_auth = [];
					$is_auth = $tree['auth'][POST_FORUM_URL . $forum_id];

					if ( ($data['tree.topic_poster'] == $userdata['user_id'] && $userdata['user_id'] != ANONYMOUS) || $is_auth['auth_mod'] )
					{
						$topic_title_href = $data['tree.topic_title'].' ('.$lang['Post_no_approved'].')';
						$topic_title = $topic_title . ' (<i><b>' . $lang['Post_no_approved'] . '</b></i>)';
						
					}
					else
					{
						$topic_title = '<i><b>' . $lang['Post_no_approved'] . '</b></i>';
						$topic_title_href = $lang['Post_no_approved'];
					}							
				}
				else
				{	
					$topic_title_href = $data['tree.topic_title'];
				}
				$topic_title = '<a href="' . append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=" . $data['tree.topic_last_post_id']) . '#' . $data['tree.topic_last_post_id'] . '" title="' . $topic_title_href . '" class="gensmall">' . $topic_title . '</a>';
				
				$board_config['last_topic_title'] = (!$board_config['last_topic_title_over']) ? $userdata['user_last_topic_title'] : $board_config['last_topic_title'];
				$last_postmsg = (($board_config['last_topic_title']) ? $topic_title : '');
				$last_postmsg = ($board_config['last_topic_title']) ? '' . $lang['Last_Post'] . ': ' . $last_postmsg . '' : '';

				$colored_username = color_username($data['tree.user_level'], $data['tree.user_jr'], $data['tree.post_user_id'], $data['tree.post_username']);
				$color_username = $colored_username[0];

				$last_post_time = create_date($board_config['default_dateformat'], $data['tree.post_time'], $board_config['board_timezone']);
				$last_post = $last_post_time . '<br />';
				if ( (isset($data['post_approve']) && $data['post_approve'] == 1) || empty($data['forum_moderate']) )
				{
					$last_post .= ( $data['tree.post_user_id'] == ANONYMOUS ) ? $data['tree.post_username'] . ' ' : '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '=' . $data['tree.post_user_id']) . '"' . $colored_username[1] . ' class="gensmall">' . $color_username . '</a> ';
				}

				$last_post .= '<a href="' . append_sid("viewtopic.$phpEx?" . POST_POST_URL . '=' . $data['tree.topic_last_post_id']) . '#' . $data['tree.topic_last_post_id'] . '"><img src="' . $images['icon_latest_reply'] . '" border="0" alt="' . $lang['Last_Post'] . '" title="' . $lang['Last_Post'] . '" /></a>';
			}

			// links to sub-levels
			$links = '';
			$board_config['sub_level_links'] = (!$board_config['sub_level_links_over']) ? $userdata['user_sub_level_links'] : $board_config['sub_level_links'];
			if ( $sub && !$pull_down && (intval($board_config['sub_level_links']) > 0) && ((($real_level == 0) && ($sub_forum == 1)) || ($real_level == 1) || ($sub_forum == 2)) )
			{
				for($j=0; $j < count($tree['sub'][$cur]); $j++) if ( $tree['auth'][ $tree['sub'][$cur][$j] ]['auth_view'] )
				{
					$wcur	= $tree['sub'][$cur][$j];
					$wthis	= $tree['keys'][$wcur];
					$wdata	= $tree['data'][$wthis];
					$wname	= get_object_lang($wcur, 'name');
					$wdesc	= get_object_lang($wcur, 'desc');
					switch($tree['type'][$wthis])
					{
						case POST_FORUM_URL:
							$wpgm = append_sid("./viewforum.$phpEx?" . POST_FORUM_URL . '=' . $tree['id'][$wthis]);
							break;
						case POST_CAT_URL:
							$wpgm = append_sid("./index.$phpEx?" . POST_CAT_URL . '=' . $tree['id'][$wthis]);
							break;
						default:
							$wpgm = append_sid("./index.$phpEx");
							break;
					}
					$link = '';
					if ( $wname != '' )
					{
						$style_color = (!empty($tree['data'][$wthis]['forum_color'])) ? ' style="color: #' . $tree['data'][$wthis]['forum_color'] . '"' : '';
						$link = '<a href="' . $wpgm . '" title="' . xhtmlspecialchars(strip_tags($wdesc)) . '" class="gensmall"' . $style_color . '>' . $wname . '</a>';
					}

					if ( intval($board_config['sub_level_links']) == 2 )
					{
						$wsub = (!empty($tree['sub'][$wcur]) && $tree['auth'][$wcur]['tree.auth_view']);

						// specific to something attached
//						if ( $wsub )
//						{
							$wi_new		= $images['icon_minicat_new'];
							$wa_new		= $lang['New_posts'];
							$wi_norm	= $images['icon_minicat'];
							$wa_norm	= $lang['No_new_posts'];
							$wi_locked	= $images['icon_minicat_locked'];
							$wa_locked	= $lang['Forum_locked'];
/*						}
						else
						{
							$wi_new		= $images['icon_minipost_new'];
							$wa_new		= $lang['New_posts'];
							$wi_norm	= $images['icon_minipost'];
							$wa_norm	= $lang['No_new_posts'];
							$wi_locked	= $images['icon_minipost_lock'];
							$wa_locked	= $lang['Forum_locked'];
						}
*/
						// forum link type
						if ( ($tree['type'][$wthis] == POST_FORUM_URL) && !empty($wdata['forum_link']) )
						{
							$wi_new		= $images['icon_minilink'];
							$wa_new		= $lang['Forum_link'];
							$wi_norm	= $images['icon_minilink'];
							$wa_norm	= $lang['Forum_link'];
							$wi_locked	= $images['icon_minilink'];
							$wa_locked	= $lang['Forum_link'];
						}

						// front icon

						$u_id = $tree['id'][$wthis];
						$wdata['tree.unread_topics'] = (!empty($userdata['unread_data'][$u_id])) ? true : false;

						$wfolder_image	= ( $wdata['tree.unread_topics'] ) ? $wi_new : $wi_norm;
						$wfolder_alt	= ( $wdata['tree.unread_topics'] ) ? $wa_new : $wa_norm;
						if ( $wdata['tree.locked'] )
						{
							$wfolder_image	= $wi_locked;
							$wfolder_alt	= $wa_locked;
						}
						$wlast_post = '<a href="' . append_sid("./viewtopic.$phpEx?" . POST_POST_URL . '=' . $wdata['tree.topic_last_post_id']) . '#' . $wdata['tree.topic_last_post_id'] . '">';
						$wlast_post .= '<img src="' . $wfolder_image . '" style="border: none" alt="' . $wfolder_alt . '" title="' . $wfolder_alt.'"/></a>';
					}
					if ( $link != '' )
					{
						$links .= (($links != '') ? ', ' : '') . $wlast_post . $link;
					}
				}
			}
			if (empty($wthis)) {
				$wthis = null;
			}
			if ( $userdata['session_logged_in'] && empty($tree['type'][$wthis]) && $board_config['ctop'] && $userdata['ctop'])
			{
				$count_unread_posts = unread_forums_posts('count', $id);
				$count_unread_topics = (isset($userdata['unread_data'][$id]) && is_array($userdata['unread_data'][$id])) ? count($userdata['unread_data'][$id]) : 0;

				$num_new_topics = ($count_unread_topics) ? '<br />' . $lang['unread_topicsss'] . ' <b>' . $count_unread_topics . '</b>' : '';
				$num_new_posts  = ($count_unread_posts) ? '<br />' . $lang['unread_postsss'] . ' <b>' . $count_unread_posts . '</b>' : '';
			}else{
				$num_new_topics = $num_new_posts = '';
			}

			// send to template
			$template->block('catrow', []);
			$template->block('catrow.forumrow', array(
				'FORUM_ID' => $id,
//				'CAT_ID' => str_replace(POST_CAT_URL, '', $tree['main'][$athis]),
				'FORUM_FOLDER_IMG' => $folder_image,
				'FORUM_NAME' => replace_encoded($title),
				'FORUM_DESC' => replace_encoded($desc),
				'POSTS' => $data['tree.forum_posts'],
				'TOPICS' => $data['tree.forum_topics'],
				'LAST_POST'	=> $last_post,
				'LAST_POSTMSG'	=> replace_encoded($last_postmsg),
                'MODERATORS'  => $moderator_list,
                'L_MODERATOR' => $l_moderators,
				'L_FORUM_FOLDER_ALT' => $folder_alt, 
				'U_VIEWFORUM' => ($type == POST_FORUM_URL) ? append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$id") : append_sid("index.$phpEx?" . POST_CAT_URL . "=$id"),
				'FORUM_COLOR' => (!empty($tree['data'][$athis]['forum_color']) && $tree['type'][$athis] != POST_CAT_URL) ? ' style="color: #' . $tree['data'][$athis]['forum_color'] . '"' : '',
				'NUM_NEW_TOPICS' => $num_new_topics,
				'NUM_NEW_POSTS' => $num_new_posts,
				'INC_SPAN' => $max_level- $level+1,
				'INC_CLASS'	=> ( !($level % 2) ) ? 'row1' : 'row2')
			);
			$handled[] = 'f' . $id;

			// add indentation to the display
			for($k=1; $k <= $level; $k++)
			{
				$template->block('catrow.forumrow.inc', array(
					'INC_CLASS' => ($k % 2) ? 'row1' : 'row2')
				);
			}

			// add the links row
			if ( !empty($links) )
			{
				$template->block('catrow.forumrow.links', array(
					'L_LINKS' => (empty($moderator_list) ? '' : '<br />'),
					'LINKS'	=> $links)
				);
			}

			// forum link type
			if ( ($tree['type'][$athis] == POST_FORUM_URL) && !empty($tree['data'][$athis]['forum_link']) )
			{
				$s_hit_count = '';
				if ( $tree['data'][$athis]['forum_link_hit_count'] )
				{
					$s_hit_count = sprintf($lang['Forum_link_visited'], $tree['data'][$athis]['forum_link_hit']);
				}
				$template->block('catrow.forumrow.forum_link', array(
					'HIT_COUNT' => $s_hit_count)
				);
			}
			else
			{
				$template->block('catrow.forumrow.forum_link_no', []);
			}
			// something displayed
			$display = true;
		}
	}

	// display sub-levels
	$ctsc = (!empty($tree['sub'][$cur])) ? count($tree['sub'][$cur]) : 0;
	for($i = 0; $i < $ctsc; $i++) if ( !empty($keys['keys'][$tree['sub'][$cur][$i]]) )
	{
		$last = ($i == ($ctsc-1)) ? true : false;
		$wdisplay = build_index($tree['sub'][$cur][$i], $cat_break, $forum_moderators, $level+1, $max_level, $keys, $last);
		if ( $wdisplay )
		{
			$display = true;
		}
	}

	if ( $level >=0 )
	{
		// forum footer row
		if ( $tree['type'][$athis] == POST_FORUM_URL )
		{
		}
	}

	if ( $level >= 0 )
	{
		// cat footer
		if ( ($tree['type'][$athis] == POST_CAT_URL) && $pull_down )
		{
			$template->block('catrow', []);
			$template->block('catrow.catfoot', array(
				'INC_SPAN' => $max_level - $level+5)
			);

			// add indentation to the display
			for($k = 1; $k <= $level; $k++)
			{
				$template->block('catrow.catfoot.inc', array(
					'INC_SPAN' => $max_level - $level+5,
					'INC_CLASS' => ($k % 2) ? 'row1' : 'row2')
				);
			}
		}
	}

	// root level footer
	if ( ($board_config['split_cat'] && $cat_break && $real_level == 0) || ((!$board_config['split_cat'] || !$cat_break) && $real_level == -1) )
	{
		$template->block('catrow', []);
		$template->block('catrow.tablefoot', []);
		if ( $cur != 'Root' )
		{
			$template->block('catrow.tablefoot.br_bottom', array(
				'CAT_ID' => $cur,'CAT_TITLE' => get_object_lang($cur, 'name'),
				'BR' => ($br) ? '' : '<br />',
			));
		}
	}

	return $display;
}


function display_index($cur='Root')
{
	global $board_config, $template, $userdata, $lang, $db, $nav_links, $phpEx;
	global $images, $nav_separator, $nav_cat_desc;

	$template->set_filenames(array(
		'index' => 'index_box.tpl')
	);

	$forum_moderators = [];

	$board_config['split_cat'] = (!$board_config['split_cat_over']) ? $userdata['user_split_cat'] : $board_config['split_cat'];

	// let's dump all of this on the template
	$keys = [];
	$display = build_index($cur, $board_config['split_cat'], $forum_moderators, -1, -1, $keys);

	// constants
	$template->vars([
		'L_FORUM' => $lang['Forum'],
		'L_TOPICS' => $lang['Topics'],
		'L_POSTS' => $lang['Posts'],
		'L_LASTPOST' => $lang['Last_Post'],
	]);
	$template->vars([
		'SPACER' => $images['spacer'],
		'NAV_SEPARATOR' => $nav_separator,
		'NAV_CAT_DESC' => $nav_cat_desc,
	]);
	if ( $display )
	{
		$template->var('BOARD_INDEX', $template->render('index_box.tpl'));
	}
	return $display;
}

?>