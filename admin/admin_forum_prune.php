<?php
/***************************************************************************
*                             admin_forum_prune.php
*                              -------------------
*     begin                : Mon Jul 31, 2001
*     copyright            : (C) 2001 The phpBB Group
*     email                : support@phpbb.com
*     modification         : (C) 2003 Przemo www.przemo.org/phpBB2/
*     date modification    : ver. 1.12.0 2005/11/11 14:46
*
*     $Id: admin_forum_prune.php,v 1.22.2.3 2002/12/18 14:14:07 psotfx Exp $
*
****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/
define('MODULE_ID', 26);
define('IN_PHPBB', true);

if ( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Forums']['Prune'] = $filename;

	return;
}

//
// Load default header
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
require($phpbb_root_path . 'includes/functions_remove.'.$phpEx);
require($phpbb_root_path . 'includes/functions_admin.'.$phpEx);

//
// Get the forum ID for pruning
//
if( isset($HTTP_GET_VARS[POST_FORUM_URL]) || isset($HTTP_POST_VARS[POST_FORUM_URL]) )
{
	$fid = ( isset($HTTP_POST_VARS[POST_FORUM_URL]) ) ? $HTTP_POST_VARS[POST_FORUM_URL] : $HTTP_GET_VARS[POST_FORUM_URL];
	$type = substr($fid, 0, 1);
	$id = intval(substr($fid, 1));
	$cat_id = -1;
	$forum_id = -1;
	if ($fid == 'Root') $type = POST_CAT_URL;
	if ($type == POST_CAT_URL)
	{
		$cat_id = $id;
	}
	else
	{
		$forum_id = $id;
	}

	// set the sql request
	$tkeys = array();
	$tkeys = get_auth_keys($fid, true);
	$forum_rows = array();
	for ($i=0; $i < count($tkeys['id']); $i++)
	{
		if ($tree['type'][$tkeys['idx'][$i]] == POST_FORUM_URL)
		{
			$forum_rows[] = $tree['data'][$tkeys['idx'][$i]];
		}
	}
}
else
{
	$forum_rows = array();
	$forum_id = '';
	$forum_sql = '';
}

//
// Check for submit to be equal to Prune. If so then proceed with the pruning.
//
if( isset($HTTP_POST_VARS['doprune']) )
{
	$prunedays = ( isset($HTTP_POST_VARS['prunedays']) ) ? intval($HTTP_POST_VARS['prunedays']) : 0;

	// Convert days to seconds for timestamp functions...
	$prunedate = CR_TIME - ( $prunedays * 86400 );

	$template->set_filenames(array(
		'body' => 'admin/forum_prune_result_body.tpl')
	);

	for($i = 0; $i < count($forum_rows); $i++)
	{
		$deleted_topics = prune($forum_rows[$i]['forum_id'], $prunedate);
		sync('forum', $forum_rows[$i]['forum_id']);

		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		$template->assign_block_vars('prune_results', array(
			'ROW_COLOR' => '#' . $row_color,
			'ROW_CLASS' => $row_class,
			'FORUM_NAME' => get_object_lang(POST_FORUM_URL . $forum_rows[$i]['forum_id'], 'name'),
			'FORUM_TOPICS' => $deleted_topics)
		);
	}

	$template->assign_vars(array(
		'L_FORUM_PRUNE' => $lang['Forum_Prune'],
		'L_FORUM' => $lang['Forum'],
		'L_TOPICS_PRUNED' => $lang['Topics_pruned'],
		'L_PRUNE_RESULT' => $lang['Prune_success'])
	);
}
else
{
	//
	// If they haven't selected a forum for pruning yet then
	// display a select box to use for pruning.
	//
	if( empty($HTTP_POST_VARS[POST_FORUM_URL]) )
	{
		//
		// Output a selection table if no forum id has been specified.
		//
		$template->set_filenames(array(
			'body' => 'admin/forum_prune_select_body.tpl')
		);

		$select_list = selectbox(POST_FORUM_URL, false, '', true);

		//
		// Assign the template variables.
		//
		$template->assign_vars(array(
			'L_FORUM_PRUNE' => $lang['Forum_Prune'],
			'L_SELECT_FORUM' => $lang['Select_a_Forum'],
			'L_LOOK_UP' => $lang['Look_up_Forum'],

			'S_FORUMPRUNE_ACTION' => append_sid("admin_forum_prune.$phpEx"),
			'S_FORUMS_SELECT' => $select_list)
		);
	}
	else
	{
		//
		// Output the form to retrieve Prune information.
		//
		$template->set_filenames(array(
			'body' => 'admin/forum_prune_body.tpl')
		);

		$forum_name = ($fid == 'Root') ? $lang['All_Forums'] : get_object_lang($fid, 'name');

		$prune_data = $lang['Prune_topics_not_posted'] . " ";
		$prune_data .= '<input type="text" name="prunedays" size="4"> ' . $lang['Days'];

		$hidden_input = '<input type="hidden" name="' . POST_FORUM_URL . '" value="' . $fid . '" />';

		//
		// Assign the template variables.
		//
		$template->assign_vars(array(
			'FORUM_NAME' => $forum_name,
			'L_FORUM' => ( $cat_id > 0 ) ? $lang['Category'] : $lang['Forum'],
			'L_FORUM_PRUNE' => $lang['Forum_Prune'],
			'L_FORUM_PRUNE_EXPLAIN' => $lang['Forum_Prune_explain'],
			'L_DO_PRUNE' => $lang['Do_Prune'],

			'S_FORUMPRUNE_ACTION' => append_sid("admin_forum_prune.$phpEx"),
			'S_PRUNE_DATA' => $prune_data,
			'S_HIDDEN_VARS' => $hidden_input)
		);
	}
}
//
// Actually output the page here.
//
$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>