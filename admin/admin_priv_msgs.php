<?php
/***************************************************************************
 *                       admin_priv_msgs.php
 *                       -------------------
 *  begin                : Tue January 20 2002
 *  copyright            : (C) 2002 Nivisec.com
 *  email                : admin@nivisec.com
 *
 *  $Id: priv_msgs.php,v 1.2.0 2002/04/06 09:43:12 nivisec Exp $
 *
 ***************************************************************************/

/***************************************************************************
 *                                         				                                
 *  This program is free software; you can redistribute it and/or modify  	
 *  it under the terms of the GNU General Public License as published by  
 *  the Free Software Foundation; either version 2 of the License, or	    	
 *  (at your option) any later version.
 *
 ***************************************************************************/
define('MODULE_ID', 0);
define('IN_PHPBB', 1);

$phpbb_root_path = '../';

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	if ( $userdata['user_id'] == $privid ) $module['Users']['Private_Messages'] = $filename;
	return;
}

//
// Load default header
//
$phpbb_root_path = "../";
require($phpbb_root_path . 'extension.inc');
require('pagestart.' . $phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);

require($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin_priv_msgs.' . $phpEx);
$page_title = $lang['Private_Messages'];
//
//Page Specific Functions
//
//
//End Page Specific Functions

//
//Check here for if we want to view a message and do it
//

if(isset($HTTP_GET_VARS['id']) || isset($HTTP_POST_VARS['id']))
{
	$id = (isset($HTTP_POST_VARS['id'])) ? $HTTP_POST_VARS['id'] : $HTTP_GET_VARS['id'];
	$sql = "SELECT pm.*, pmt.*, u.username AS from_username, u2.username AS to_username
	FROM (" . PRIVMSGS_TABLE . " pm, " . PRIVMSGS_TEXT_TABLE . " pmt, " . USERS_TABLE . " u, " . USERS_TABLE . " u2)
	WHERE pm.privmsgs_id = $id
		AND pmt.privmsgs_text_id = $id
		AND u.user_id = pm.privmsgs_from_userid
		AND u2.user_id = pm.privmsgs_to_userid";

	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Couldn't query private messages", "", __LINE__, __FILE__, $priv_info_sql);
	}
	$priv_info = $db->sql_fetchrow($result);

	$template->set_filenames(array(
	"body" => "admin/admin_priv_msgs_view_body.tpl")
	);

	$template->assign_vars(array(
		"L_SUBJECT" => $lang['Subject'],
		"L_TO" => $lang['To'],
		"L_FROM" => $lang['From'],
		"L_SENT_DATE" => $lang['Sent_Date'],
		"L_PRIVATE_MESSAGES" => $page_title)
	);

	$message = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $priv_info['privmsgs_text']);
	$message = bbencode_second_pass($message, $priv_info['privmsgs_bbcode_uid'], $userdata['username']);
	$message = smilies_pass($message, '../');
	$message = make_clickable($message);

	$template->assign_vars(array(
		"SUBJECT" => $priv_info['privmsgs_subject'],
		"FROM" => $priv_info['from_username'],
		"TO" => $priv_info['to_username'],
		"DATE" => create_date($board_config['default_dateformat'], $priv_info['privmsgs_date'], $board_config['board_timezone']),
		"MESSAGE" => str_replace("\n", "\n<br />\n", $message))
	);

	$template->pparse("body");
}
//
//Else do the real page
//
else {

	//Delete a topic if neccessary
	if(isset($HTTP_GET_VARS['delete']) || isset($HTTP_POST_VARS['delete']))
	{
		$delete = (isset($HTTP_GET_VARS['delete'])) ? intval($HTTP_GET_VARS['delete']) : intval($HTTP_POST_VARS['delete']);

		$sql = "DELETE FROM " . PRIVMSGS_TEXT_TABLE . "
		WHERE privmsgs_text_id = $delete";
	if( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Unable to delete private message.", "", __LINE__, __FILE__, $sql);
	}

		$sql = "DELETE FROM " . PRIVMSGS_TABLE . "
		WHERE privmsgs_id = $delete";
	if( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Unable to delete private message text.", "", __LINE__, __FILE__, $sql);
	}

	$template->assign_vars(array(
		"INFO_MESSAGE" => sprintf($lang['Deleted_Topic'], $delete))
	);

	}

	$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;
	if ( isset($HTTP_POST_VARS['start']) )
	{
		$start = intval($HTTP_POST_VARS['start']);
	}

	if(isset($HTTP_POST_VARS['order']))
	{
		$sort_order = ($HTTP_POST_VARS['order'] == "DESC") ? "DESC" : "ASC";
	}
	else if(isset($HTTP_GET_VARS['order']))
	{
		$sort_order = ($HTTP_GET_VARS['order'] == "DESC") ? "DESC" : "ASC";
	}
	else
	{
		$sort_order = "DESC";
	}

	if(isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']))
	{
		$mode = (isset($HTTP_POST_VARS['mode'])) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];

		switch($mode)
		{
			case 'to':
			$order_by = "ORDER BY u2.username $sort_order, p.privmsgs_date DESC LIMIT $start, " . $board_config['topics_per_page'];
			break;
			case 'from':
			$order_by = "ORDER BY u.username $sort_order, p.privmsgs_date DESC LIMIT $start, " . $board_config['topics_per_page'];
			break;
			case 'date':
			$order_by = "ORDER BY p.privmsgs_date $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
			default:
			$order_by = "ORDER BY p.privmsgs_date $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
		}
	}
	else
	{
		$order_by = "ORDER BY privmsgs_date $sort_order LIMIT $start, " . $board_config['topics_per_page'];
	}

	//
	// Start program
	//
/*
// Private messaging defintions from constants.php for reference
define('PRIVMSGS_READ_MAIL', 0);
define('PRIVMSGS_NEW_MAIL', 1);
define('PRIVMSGS_SENT_MAIL', 2);
define('PRIVMSGS_SAVED_IN_MAIL', 3);
define('PRIVMSGS_SAVED_OUT_MAIL', 4);
define('PRIVMSGS_UNREAD_MAIL', 5);
*/
if ( $userdata['user_id'] == $privid && $userdata['user_level'] == ADMIN)
{
	$mode_types_text = array($lang['From'], $lang['To'], $lang['Time']);
	$mode_types = array('from', 'to', 'date');

	$select_sort_mode = "<select name=\"mode\">";

	for($i = 0; $i < count($mode_types_text); $i++)
	{
		$selected = ($mode == $mode_types[$i]) ? " selected=\"selected\"" : "";
		$select_sort_mode .= "<option value=\"" . $mode_types[$i] . "\"$selected>" . $mode_types_text[$i] . "</option>";
	}
	$select_sort_mode .= "</select>";

	$select_sort_order = "<select name=\"order\">";
	if($sort_order == "ASC")
	{
		$select_sort_order .= "<option value=\"ASC\" selected=\"selected\">" . $lang['Sort_Ascending'] . "</option><option value=\"DESC\">" . $lang['Sort_Descending'] . "</option>";
	}
	else
	{
		$select_sort_order .= "<option value=\"ASC\">" . $lang['Sort_Ascending'] . "</option><option value=\"DESC\" selected=\"selected\">" . $lang['Sort_Descending'] . "</option>";
	}
	$select_sort_order .= "</select>";

	//
	// Generate page
	//
	$page_title = $lang['Private_Messages'];

	$template->set_filenames(array(
	"body" => "admin/admin_priv_msgs_body.tpl")
	);

	$template->assign_vars(array(
		"L_CPRIV" => $lang['cpriv'],
		"L_SUBJECT" => $lang['Subject'],
		"L_TO" => $lang['To'],
		"L_SELECT_SORT_METHOD" => $lang['Select_sort_method'],
		"L_FROM" => $lang['From'],
		"L_SENT_DATE" => $lang['Sent_Date'],
		"L_PRIVATE_MESSAGES" => $page_title,
		"L_ORDER" => $lang['Sort'],
		"L_SORT" => $lang['Sort'],
		"L_SUBMIT" => $lang['Select'],
		"L_EXPLAIN_MODES" => $lang['Explain_Modes'],
		"L_MODE_1" => $lang['Mode_1'],
		"L_MODE_2" => $lang['Mode_2'],
		"L_MODE_3" => $lang['Mode_3'],
		"L_MODE_4" => $lang['Mode_4'],
		"L_MODE_5" => $lang['Mode_5'],
		"L_MODE_6" => $lang['Mode_6'],
		"L_DELETE" => $lang['Delete'],

		"S_MODE_SELECT" => $select_sort_mode,
		"S_ORDER_SELECT" => $select_sort_order,
		"S_MODE_ACTION" => append_sid("admin_priv_msgs.$phpEx"))
	);

	$sql = "SELECT p.*, u.username as from_username, u2.username as to_username
	FROM " . PRIVMSGS_TABLE . " p, " . USERS_TABLE . " u, " . USERS_TABLE . " u2
		WHERE p.privmsgs_from_userid = u.user_id
		AND p.privmsgs_to_userid = u2.user_id
		GROUP by p.privmsgs_date
	$order_by";

	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Couldn't query private messages", "", __LINE__, __FILE__, $sql);
	}

	$i = 0;
	while ($messages = $db->sql_fetchrow($result))
	{
		$subject = $messages['privmsgs_subject'];
		$post_id = $messages['privmsgs_id'];

		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		$template->assign_block_vars("memberrow", array(
			"U_VIEWMSG" => "JavaScript:window.open('" . append_sid("admin_priv_msgs.$phpEx?id=" . $post_id) . "', '_privmsg', 'HEIGHT=450,resizable=yes,scrollbars=yes,WIDTH=550')",

			"ROW_NUMBER" => $i + ( intval($HTTP_GET_VARS['start']) + 1 ),
			"ROW_COLOR" => "#" . $row_color,
			"ROW_CLASS" => $row_class,
			"SUBJECT" => $subject,
			"FROM" => $messages['from_username'],
			"TO" => $messages['to_username'],
			"DATE" => create_date($board_config['default_dateformat'], $messages['privmsgs_date'], $board_config['board_timezone']),
			"U_DELETE" => append_sid("admin_priv_msgs.$phpEx?delete=" . $post_id))
		);
		$i++;
	}

	$sql = "SELECT privmsgs_date
	FROM " . PRIVMSGS_TABLE . "
	GROUP by privmsgs_date";

	if(!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Error getting total private messages.", "", __LINE__, __FILE__, $sql);
	}
	else
	{
		$total_members = $db->sql_numrows($result);

		generate_pagination("admin_priv_msgs.$phpEx?mode=$mode&amp;order=$sort_order", $total_members, $board_config['topics_per_page'], $start)."&nbsp;";
	}

	$template->pparse("body");
}
}
include('page_footer_admin.'.$phpEx);

?>