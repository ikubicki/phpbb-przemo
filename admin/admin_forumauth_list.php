<?php

/*
 * @file              : admin_forumauth_list.php
 * @begin             : Thursday, Jul 12, 2001
 * @copyright         : (C) 2001 The phpBB Group
 * @email             : support@phpbb.com
 * @modification      : (C) 2005 Przemo www.przemo.org/phpBB2/
 * @date modification : ver. 1.12.4 2005/10/09 22:48
 * @information       : Forum permission list by Centurion with new correction
 *
 *  $Id: admin_forumauth_list.php,v 1.40.2.12 2005/05/07 22:18:10 acydburn Exp $
 */
define('MODULE_ID', 120);
define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Forums']['Permissions_List'] = $filename;
	return;
}

// Load default header
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include($phpbb_root_path . 'includes/functions_admin.'.$phpEx);
include($phpbb_root_path . 'includes/functions_selects.'.$phpEx);

$edit = isset($HTTP_POST_VARS['edit']) ? 1 : 0;
$save = isset($HTTP_POST_VARS['save']) ? 1 : 0;

if(isset($HTTP_POST_VARS['cancel'])){
    redirect(append_sid("admin/admin_forumauth_list.$phpEx"));
}

$forum_auth_ary = array(
	"auth_view"           => AUTH_ALL,
	"auth_read"           => AUTH_ALL,
	"auth_post"           => AUTH_REG,
	"auth_reply"          => AUTH_ALL,
	"auth_edit"           => AUTH_REG,
	"auth_delete"         => AUTH_REG,
	"auth_sticky"         => AUTH_MOD,
	"auth_announce"       => AUTH_MOD,
	"auth_globalannounce" => AUTH_ADMIN,
	"auth_vote"           => AUTH_REG,
	"auth_pollcreate"     => AUTH_REG
);

if ( defined('ATTACHMENTS_ON') ) $forum_auth_ary['auth_attachments'] = AUTH_REG;
if ( defined('ATTACHMENTS_ON') ) $forum_auth_ary['auth_download'] = AUTH_ALL;

$simple_auth_types = array($lang['Public'], $lang['Registered'], $lang['Registered'] . ' [' . $lang['Hidden'] . ']', $lang['Private'], $lang['Private'] . ' [' . $lang['Hidden'] . ']', $lang['Moderators'], $lang['Moderators'] . ' [' . $lang['Hidden'] . ']');

$forum_auth_fields = array('auth_view', 'auth_read', 'auth_post', 'auth_reply', 'auth_edit', 'auth_delete', 'auth_sticky', 'auth_announce', 'auth_vote', 'auth_pollcreate');

$field_names = array(
	'auth_view'       => $lang['View'],
	'auth_read'       => $lang['Read'],
	'auth_post'       => $lang['Post'],
	'auth_reply'      => $lang['Reply'],
	'auth_edit'       => $lang['Edit'],
	'auth_delete'     => $lang['Delete'],
	'auth_sticky'     => $lang['Sticky'],
	'auth_announce'   => $lang['Announce'],
	'auth_vote'       => $lang['Vote'],
	'auth_pollcreate' => $lang['Pollcreate']);

if ( defined('ATTACHMENTS_ON') ) attach_setup_forum_auth($simple_auth_ary, $forum_auth_fields, $field_names);

$forum_auth_levels = array('ALL', 'REG', 'PRIVATE', 'MOD', 'NOONE', 'ADMIN');
$forum_auth_const  = array(AUTH_ALL, AUTH_REG, AUTH_ACL, AUTH_MOD, 'NOONE', AUTH_ADMIN);

$post_moderate = ($HTTP_POST_VARS['moderate'])      ? 1 : 0;
$post_no_count = ($HTTP_POST_VARS['no_count'])      ? 1 : 0;
$forum_trash   = ($HTTP_POST_VARS['forum_trash'])   ? 1 : 0;
$locked_bottom = ($HTTP_POST_VARS['locked_bottom']) ? 1 : 0;

// check the presence of the attachment of the forum
$sql = "SELECT main_type FROM " . FORUMS_TABLE;
if( !$db->sql_query($sql) ){
    message_die(GENERAL_ERROR, 'Could not retrieve main_type', '', __LINE__, __FILE__, $sql);
}
else {
    define('SUB_FORUM_ATTACH', true);
}

// get the ids
$cat_id = 0;
if (isset($HTTP_POST_VARS[POST_CAT_URL]) || isset($HTTP_GET_VARS[POST_CAT_URL]))
{
	$cat_id = isset($HTTP_POST_VARS[POST_CAT_URL]) ? intval($HTTP_POST_VARS[POST_CAT_URL]) : intval($HTTP_GET_VARS[POST_CAT_URL]);
}

$forum_id = 0;
if (isset($HTTP_POST_VARS[POST_FORUM_URL]) || isset($HTTP_GET_VARS[POST_FORUM_URL]))
{
	$forum_id = isset($HTTP_POST_VARS[POST_FORUM_URL]) ? intval($HTTP_POST_VARS[POST_FORUM_URL]) : intval($HTTP_GET_VARS[POST_FORUM_URL]);
}

// check and fix parm
if ( !(function_exists('admin_check_cat')) )
{
	function admin_check_cat()
	{
		global $db;

		$res = false;
		// build the cat list
		$mains = array();
		$old_values = array();

		// from cats
		$sql = "SELECT * FROM " . CATEGORIES_TABLE . " ORDER BY cat_id";
		if ( !$result = $db->sql_query($sql) ) message_die(GENERAL_ERROR, "Couldn't access list of Categories", "", __LINE__, __FILE__, $sql);
		while ( $row = $db->sql_fetchrow($result) ) 
		{
			$old_values['cat'][$row['cat_id']] = array('cat_main_type'=>$row['cat_main_type'], 'cat_main'=>$row['cat_main']);
			
			// fix cat_main value
			if (empty($row['cat_main_type'])) 
			{
				$row['cat_main_type'] = POST_CAT_URL;
			}
			if ( $row['cat_main'] == $row['cat_id'] )
			{
				$row['cat_main_type'] = POST_CAT_URL;
				$row['cat_main']      = 0;
			}
			// fill hierarchy array
			$mains[ POST_CAT_URL . $row['cat_id'] ] = $row['cat_main_type'] . $row['cat_main'];
		}// end while ( $row = $db->sql_fetchrow($result) )

		// from forums
		$sql = "SELECT * FROM " . FORUMS_TABLE . " ORDER BY forum_id";
		if ( !$result = $db->sql_query($sql) ) message_die(GENERAL_ERROR, "Couldn't access list of Forums", "", __LINE__, __FILE__, $sql);
		while ( $row = $db->sql_fetchrow($result) ) 
		{
			$old_values['forum'][$row['forum_id']] = array('main_type' => $row['main_type'], 'cat_id' => $row['cat_id']);
			// fill hierarchy array
			if (empty($row['main_type'])) $row['main_type'] = POST_CAT_URL;
			$mains[POST_FORUM_URL . $row['forum_id'] ] = $row['main_type'] . $row['cat_id'];
		}// end while ( $row = $db->sql_fetchrow($result) )

		// no forums nor cats
		if (empty($mains)) return false;

		// push each cat
		reset($mains);
        $cache = false;
		while (list($id, $main) = each($mains) )
		{
			$root		= false;
			$cur		= $id;

			$stack		= array();
			$stack[]	= $cur;
			while ( !$root )
			{
				// parent catagory doesn't exists
				if ( ($mains[$cur] != 'c0' ) && !isset($mains[ $mains[$cur] ]) )
				{
					$mains[$cur] = 'c0';
				}

				// the parent category is already in the stack (recursive attachement)
				if ( in_array($mains[$cur], $stack) )
				{
					$mains[$cur] = 'c0';
				}

				// push parent category id
				$stack[] = $mains[$cur];

				// climb up a level
				$root = ($mains[$cur] == 'c0');
				$cur  = $mains[$cur];

			}// while ( !$root )
			// update database
			$type		= substr($id, 0, 1);
			$i			= intval(substr($id, 1));
			$main_type	= substr($mains[$id], 0, 1);
			$main_id	= intval(substr($mains[$id], 1));
			if ( $i != 0 )
			{
				switch( $type )
				{
					case POST_CAT_URL:
						if($old_values['cat'][$i]['cat_main_type'] != $main_type || $old_values['cat'][$i]['cat_main'] != $main_id)
						{
							$sql = "UPDATE " . CATEGORIES_TABLE . " SET cat_main_type='$main_type', cat_main=$main_id WHERE cat_id=$i";
							if ( !$db->sql_query($sql) ) message_die(GENERAL_ERROR, "Couldn't update list of Categories", "", __LINE__, __FILE__, $sql);
							$cache = true;
						}
						break;
					case POST_FORUM_URL:
						if($old_values['forum'][$i]['cat_id'] != $main_id || $old_values['forum'][$i]['main_type'] != $main_type )
						{
							$sql = "UPDATE " . FORUMS_TABLE . " SET cat_id=$main_id WHERE forum_id=$i";
							if (defined('SUB_FORUM_ATTACH'))
							{
								$sql = "UPDATE " . FORUMS_TABLE . " SET main_type='$main_type', cat_id=$main_id WHERE forum_id=$i";
							}
							if ( !$db->sql_query($sql) ) message_die(GENERAL_ERROR, "Couldn't update list of Forums", "", __LINE__, __FILE__, $sql);
							$cache = true;
						}
						break;
					default:
						$sql = '';
						break;
				}
			}
		}
        if($cache)
        {
            sql_cache('clear', 'multisqlcache_forum');
            sql_cache('clear', 'forum_data');
            sql_cache('clear', 'cat_list');
            sql_cache('clear', 'moderators_list');
			sql_cache('clear', 'f_access');
        }
		return '';
	}// end
}

// Start page proper
if($save)
{
$cache = false;
$sql = "SELECT * FROM " . FORUMS_TABLE . " ORDER BY forum_id ASC";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query forums list', '', __LINE__, __FILE__, $sql);
	}
    while($row = $db->sql_fetchrow($result))
    {
        $updstr = array();
        for ($k=0; $k<count($forum_auth_fields); $k++)
        {
            if(isset($HTTP_POST_VARS[$forum_auth_fields[$k]][$row['forum_id']]) && $HTTP_POST_VARS[$forum_auth_fields[$k]][$row['forum_id']] != $row[$forum_auth_fields[$k]])
            {
                $updstr[] = $forum_auth_fields[$k] . '=' . $HTTP_POST_VARS[$forum_auth_fields[$k]][$row['forum_id']];
            }
        }

        if(!empty($updstr))
        {
			$cache = true;
            $fsql = "UPDATE " . FORUMS_TABLE . " SET " . implode(',',$updstr)  . " WHERE forum_id = " . $row['forum_id'];
            if( !$db->sql_query($fsql) )
            {
                message_die(GENERAL_ERROR, 'Could not update', '', __LINE__, __FILE__, $fsql);
            }
        }
    }
	
    if($cache) sql_cache('clear', 'f_access');

	$message = $lang['Forum_auth_updated'] . '<br /><br />' . sprintf($lang['Click_return_forumauth'],  '<a href="' . append_sid("admin_forumauth_list.$phpEx") . '">', "</a>");
	message_die(GENERAL_MESSAGE, $message);
}


$template->set_filenames(array(
	"body" => "admin/auth_forum_list_body.tpl")
);

$template->assign_block_vars((($edit)?'buttons_edit':'buttons_custom'), array(
    'CANCEL' => $lang['Cancel'],
    'SAVE'   => $lang['Save_Settings'],
    'EDIT'   =>  $lang['Edit_permissions']
));

$template->assign_vars(array(
	'L_ACTION'       => $lang['Action'],
	'S_FORUM_ACTION' => append_sid("admin_forumauth_list.$phpEx"),
	'L_FORUM'        => $lang['Forum'],
    'L_AUTH_TITLE'   => $lang['Auth_Control_Forum'],
	'L_AUTH_EXPLAIN' => $lang['Forum_auth_list_explain'])
);

if ( !(function_exists('display_admin_index')) )
{
	include($phpbb_root_path . 'includes/functions_hierarchy.'.$phpEx);
	function display_admin_index($cur='Root', $level=0, $max_level=-1)
	{
		global $template, $phpEx, $lang, $images;
		global $tree, $forum_auth_fields, $forum_auth_const, $forum_auth_levels, $edit;

		// display the level
		$athis = isset($tree['keys'][$cur]) ? $tree['keys'][$cur] : -1;

		// root level
		if ($max_level==-1)
		{
			// get max inc level
			$keys = array();
			$max_level = get_max_depth($cur, true, -1, $keys);
			if ($cur != 'Root') $max_level++;
			$template->assign_vars(array(
				'INC_SPAN'		=> ($max_level+1),
				'INC_SPAN_ALL'	=> ($max_level+1+count($forum_auth_fields)),
				)
			);
		}

		// if forum index, omit one level
		if ($cur == 'Root') $level=-1;

		// sub-levels
		if ($athis >= -1)
		{
			// cat header row
			if ($tree['type'][$athis] == POST_CAT_URL)
			{
				// display a cat row
				$cat    = $tree['data'][$athis];
				$cat_id = $tree['id'][$athis];

				// get the class colors
				$class_catLeft	 = "cat";
				$class_catMiddle = "cat";
				$class_catRight  = "cat";

				$cat_title = $cat['cat_title'];
				$cat_title_trad = get_object_lang(POST_CAT_URL . $cat_id, 'name');
				if ($cat_title != $cat_title_trad) $cat_title = '(' . $cat_title . ') ' . $cat_title_trad;

				// send to template
				$template->assign_block_vars('catrow', array());
				$template->assign_block_vars('catrow.cathead', array(
					'CAT_ID'			=> $cat_id,
					'CAT_TITLE'			=> strip_tags($cat_title),

					'CLASS_CATLEFT' 	=> $class_catLeft,
					'CLASS_CATMIDDLE'	=> $class_catMiddle,
					'CLASS_CATRIGHT'	=> $class_catRight,
					'INC_SPAN'			=> $max_level - $level+1+count($forum_auth_fields),
					'WIDTH' 			=> ($max_level == $level) ? 'width="50%"' : '',

					'U_VIEWCAT'			=> append_sid("admin_forums.$phpEx?" . POST_CAT_URL . "=$cat_id"))
				);
				// add indentation to the display
				$rowspan = empty($cat['cat_desc']) ? 1 : 2;
				for ($k=1; $k <= $level; $k++) $template->assign_block_vars('catrow.cathead.inc', array('ROWSPAN' => $rowspan));

				if (!empty($cat['cat_desc']))
				{
					$cat_desc      = $cat['cat_desc'];
					$cat_desc_trad = get_object_lang(POST_CAT_URL . $cat_id, 'desc');
					if ($cat_desc != $cat_desc_trad) $cat_desc = '(' . $cat_desc . ') ' . $cat_desc_trad;

					$template->assign_block_vars('catrow', array());
					$template->assign_block_vars('catrow.cattitle', array(
						'CAT_DESCRIPTION'	=> strip_tags($cat_desc),
						'INC_SPAN_ALL'		=> $max_level - $level+count($forum_auth_fields)+1,
						)
					);
				}
			}

			// forum header row
			if ($tree['type'][$athis] == POST_FORUM_URL)
			{
				$forum          = $tree['data'][$athis];
				$forum_id       = $tree['id'][$athis];
				$forum_link_img = '';
				if (!empty($tree['data'][$athis]['forum_link']))
				{
					$forum_link_img = '<img src="../' . $images['link'] . '" border="0" />';
				}
				else
				{
					$sub  = (isset($tree['sub'][POST_FORUM_URL . $forum_id]));
					$forum_link_img = '<img src="../' . (($sub) ? $images['category'] : $images['forum']) . '" border="0" />';
					if ($tree['data'][$athis]['forum_status'] == FORUM_LOCKED)
					{
						$forum_link_img = '<img src="../' . (($sub) ? $images['category_locked'] : $images['forum_locked']) . '" border="0" />';
					}
				}

				$forum_name      = $forum['forum_name'];
				$forum_name_trad = get_object_lang(POST_FORUM_URL . $forum_id, 'name');
				if ($forum_name != $forum_name_trad) $forum_name = '(' . $forum_name . ') ' . $forum_name_trad;

				$forum_desc      = $forum['forum_desc'];
				$forum_desc_trad = get_object_lang(POST_FORUM_URL . $forum_id, 'desc');
				if ( $forum_desc != $forum_desc_trad )
				{
					$forum_desc = '(' . $forum_desc . ') ' . $forum_desc_trad;
				}


				$template->assign_block_vars('catrow', array());
				$template->assign_block_vars('catrow.forumrow', array(
					'LINK_IMG'    => $forum_link_img,
					'FORUM_NAME'  => strip_tags($forum_name),
					'FORUM_ID'    => $forum_id,
					'FORUM_DESC'  => strip_tags($forum_desc),
					'NUM_TOPICS'  => $forum['forum_topics'],
					'NUM_POSTS'	  => $forum['forum_posts'],
					'FORUM_COLOR' => ($forum['forum_color'] != '') ? ' style="color: #' . $forum['forum_color'] . '"' : '',
					'INC_SPAN'    => $max_level - $level+1,
					'WIDTH'       => ($max_level == $level) ? 'width="50%"' : '',

					'U_VIEWFORUM' => append_sid("admin_forums.$phpEx?" . POST_FORUM_URL . "=$forum_id"))
				);
				for ($k=0; $k<count($forum_auth_fields); $k++)
				{
					$item_auth_value = $forum[$forum_auth_fields[$k]];

					$a_select = '<select name="' . $forum_auth_fields[$k] .'[' . $forum['forum_id'] . ']">';

					for ($l=0; $l<count($forum_auth_const); $l++)
					{
						if($l != 4) // skipping because unused, MOD is 3, ADMIN is 5
						{
						if ($item_auth_value == $l)
						{
							$item_auth_level = $forum_auth_levels[$l];
							$a_select .= '<option value="' . (($l==4) ? '5' : $l) . '" selected>' . $lang['Forum_' . $forum_auth_levels[$l]] . '</option>';
						}
						else
							$a_select .= '<option value="' . (($l==4) ? '5' : $l) . '">' . $lang['Forum_' . $forum_auth_levels[$l]] . '</option>';
						}
					}
					$a_select .= '</select>';
					$cell_value = ($edit) ? $a_select : $lang['Forum_' . $item_auth_level];
					$template->assign_block_vars('catrow.forumrow.forum_auth_data', array(
						'CELL_VALUE' => $cell_value,
						'AUTH_EXPLAIN' => sprintf($lang['Forum_auth_list_explain_' . $forum_auth_fields[$k]], $lang['Forum_auth_list_explain_' . $item_auth_level]))
					);
				}

				// add indentation to the display
				for ($k=1; $k <= $level; $k++) $template->assign_block_vars('catrow.forumrow.inc', array());
			}

			// display the sub-level
			for ($i=0; $i < count($tree['sub'][$cur]); $i++)
			{
				display_admin_index($tree['sub'][$cur][$i], $level+1, $max_level);
			}

			// forum footer

			// cat footer
			if ($tree['type'][$athis] == POST_CAT_URL)
			{
				// add the footer
				$template->assign_block_vars('catrow', array());
				$template->assign_block_vars('catrow.catfoot', array(
					'S_ADD_FORUM_SUBMIT'	=> "addforum[$cat_id]",
					'S_ADD_CAT_SUBMIT'		=> "addcategory[$cat_id]",
					'S_ADD_NAME'			=> "name[$cat_id]",
					'INC_SPAN'				=> $max_level - $level+1,
					'INC_SPAN_ALL'			=> $max_level - $level+1+count($forum_auth_fields),
					)
				);
				// add indentation to the display
				for ($k=1; $k <= $level; $k++) $template->assign_block_vars('catrow.catfoot.inc', array());
			}

			// board index footer
			if ($cur == 'Root')
			{
				$template->assign_block_vars('switch_board_footer', array());
				if (defined('SUB_FORUM_ATTACH'))
				{
					$template->assign_block_vars('switch_board_footer.sub_forum_attach', array());
				}
			}
		}
	}
}

// fix the cat_main value
admin_check_cat();

// read the cats/forums tree
get_user_tree($userdata);

// get the values of level selected
$main = 'Root';
if (!empty($cat_id))
{
	$main = POST_CAT_URL . $cat_id;
}
else if (!empty($forum_id))
{
	$main = $tree['main'][$forum_id];
	$main = $tree['main'][ $tree['keys'][POST_FORUM_URL . $forum_id] ];
}
if (!isset($tree['keys'][$main])) $main = 'Root';

// display the tree
display_admin_index($main);

$sql = "SELECT f.*
	FROM " . FORUMS_TABLE . " f
	LEFT JOIN " . CATEGORIES_TABLE . " c ON (f.cat_id = c.cat_id)
	WHERE c.cat_id IS NULL
	AND f.forum_id = f.cat_id";
if( !$result = $db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, 'Couldn\'t verify existence of categories', '', __LINE__, __FILE__, $sql);
}
$i = 0;
while( $row = $db->sql_fetchrow($result) )
{
	$i++;
	if ( $i == 1 )
	{
		$template->assign_block_vars('forums_shadow', array(
			'L_FORUMS_SHADOW' => $lang['Forums_shadow'],
			'L_NAME'          => $lang['Forum_name'],
			'L_FORUM_ID'      => 'Forum ID',
			'L_CAT_ID'        => 'Cat ID')
		);
	}
	$template->assign_block_vars('forums_shadow.forums_shadow_list', array(
		'CLASS'       => (!($i % 2)) ? '1' : '2',
		'FORUMS_NAME' => strip_tags($row['forum_name']),
		'FORUM_ID'    => $row['forum_id'],
		'CAT_ID'      => $row['cat_id'],
		'U_FORUMS'    => append_sid("../viewforum.$phpEx?" . POST_FORUM_URL . "=" . $row['forum_id']))
	);
}

	for ($i=0; $i<count($forum_auth_fields); $i++)
	{
		$template->assign_block_vars('forum_auth_titles', array(
			'CELL_TITLE' => $field_names[$forum_auth_fields[$i]])
		);
	}


$template->pparse("body");

include('./page_footer_admin.'.$phpEx);

?>