<?php
/***************************************************************************
 *		 		   admin_logging.php
 *			        -------------------
 *     begin			: Jan 24 2003
 *     copyright			: Morpheus
 *     email			: morpheus@2037.biz
 *
 *     $Id: admin_logging.php,v 1.85.2.9 2003/01/24 18:31:54 Moprheus Exp $
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
define('MODULE_ID', 46);
define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Logs']['LogsActions'] = $file;
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

$template->set_filenames(array(
	"body" => "admin/logs_body.tpl")
);

$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;
if ( isset($HTTP_POST_VARS['start']) )
{
	$start = intval($HTTP_POST_VARS['start']);
}

if ( isset($HTTP_POST_VARS['order']) )
	{
		$sort_order = ($HTTP_POST_VARS['order'] == 'ASC') ? 'ASC' : 'DESC';
	}
else if ( isset($HTTP_GET_VARS['order']) )
	{
		$sort_order = ($HTTP_GET_VARS['order'] == 'ASC') ? 'ASC' : 'DESC';
	}
else
	{
		$sort_order = 'ASC';
	}

if ( file_exists(@phpbb_realpath($phpbb_root_path . 'install_tables.' . $phpEx)) )
{
	message_die(GENERAL_MESSAGE, 'You have not yet delete the file install_tables.php : do it before trying to see this page.');
}

if ( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
}

if ( $mode == 'rem_all' )
{
	if ( !isset($HTTP_POST_VARS['confirm']) )
	{
		confirm(sprintf($lang['Confirm_delete_all'], $lang['LogsActions']), append_sid("admin_logging.$phpEx?mode=rem_all"));
	}
	else if ( isset($HTTP_POST_VARS['cancel']) )
	{
		redirect(append_sid("admin/admin_logging.$phpEx"));
	}
	else if ( isset($HTTP_POST_VARS['confirm']) )
	{
		$sql = "TRUNCATE TABLE " . LOGS_TABLE;

		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not clear logs table', '', __LINE__, __FILE__, $sql);
		}

		$sql = "INSERT INTO " . LOGS_TABLE . " (mode, topic_id, user_id, username, user_ip, time)
			VALUES ('Delete_all', '0', '" . $userdata['user_id'] . "', '" . $userdata['username'] . "', '$user_ip', '" . CR_TIME . "')";

		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not insert data into logs table', '', __LINE__, __FILE__, $sql);
		}
		redirect(append_sid("admin/admin_logging.$phpEx"));
	}
}

//
// Logs sorting
//
$mode_types_text = array($lang['Time'], $lang['Username'], $lang['Action']);
$mode_types = array('time', 'username', 'mode', 'id');
$select_sort_mode = '<select name="mode">';
for($i = 0; $i < count($mode_types_text); $i++)
{
	$selected = ( $mode == $mode_types[$i] ) ? ' selected="selected"' : '';
	$select_sort_mode .= "<option value=\"" . $mode_types[$i] . "\"$selected>" . $mode_types_text[$i] . "</option>";
}
$select_sort_mode .= '</select>';

$select_sort_order = '<select name="order">';
if($sort_order == 'ASC')
{
	$select_sort_order .= '<option value="ASC" selected="selected">' . $lang['Sort_Ascending'] . '</option><option value="DESC">' . $lang['Sort_Descending'] . '</option>';
}
else
{
	$select_sort_order .= '<option value="ASC">' . $lang['Sort_Ascending'] . '</option><option value="DESC" selected="selected">' . $lang['Sort_Descending'] . '</option>';
}
$select_sort_order .= '</select>';

$template->assign_vars(array(
	'L_LOG_ACTIONS_TITLE' => $lang['Log_action_title'],
	'L_LOG_ACTION_EXPLAIN' => $lang['Log_action_explain'],
	'L_CHOOSE_SORT' => $lang['Choose_sort_method'],
	'L_GO' => $lang['Go'],
	'L_CANCEL' => $lang['Cancel'],
	'L_DELETE' => $lang['Delete'], 
	'L_DELETE_LOG' => $lang['Delete_log'],
	'L_ID_LOG' => $lang['Id_log'],
	'L_ACTION' => $lang['Action'],
	'L_TOPIC' => $lang['Object'],
	'L_DONE_BY' => $lang['Done_by'],
	'L_USER_IP' => $lang['User_ip'],
	'L_DATE' => $lang['Date'],
	'L_MARK_ALL' => $lang['Mark_all'],
	'L_UNMARK_ALL' => $lang['Unmark_all'],
	'L_DELETE_ALL' => $lang['Delete_all'],

	'S_MODE_SELECT' => $select_sort_mode,
	'S_ORDER_SELECT' => $select_sort_order,
	'S_DELETE_ALL' => append_sid("admin_logging.$phpEx?mode=rem_all"),
	'S_MODE_ACTION' => append_sid("admin_logging.$phpEx"),
	'S_CANCEL_ACTION' => append_sid("admin_logging.$phpEx"))
);

if ( isset($mode) )
{
	switch( $mode )
	{
		case 'mode' :
			$order_by = "mode $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
		case 'username' :
			$order_by = "username $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
		case 'time' :
			$order_by = "time $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
		default:
			$order_by = "time DESC LIMIT $start, " . $board_config['topics_per_page'];
			break;
	}
}
else
{
	$order_by = "time DESC LIMIT $start, " . $board_config['topics_per_page'];
}

	$sql = "SELECT *
		FROM " . LOGS_TABLE . "
		ORDER BY $order_by ";
		if(!$result = $db->sql_query($sql))
		{
			message_die(CRITICAL_ERROR, "Could not query log informations", "", __LINE__, __FILE__, $sql);
		}

		$c_rows=0;
        $rows = $c_name = $unique_uids = array();
        while( $row = $db->sql_fetchrow($result) )
        {
            if( !in_array($row['user_id'],$unique_uids) ) $unique_uids[]=$row['user_id'];

            $rows[] = $row;
			$c_rows++;
        }

        if( !empty($unique_uids) )
        {
            $sql = "SELECT user_id, username, user_level, user_jr FROM " . USERS_TABLE . " WHERE user_id IN (".implode(',', $unique_uids).")";
            if(!$result = $db->sql_query($sql)){
                message_die(CRITICAL_ERROR, "Could not retrieve information from users table", "", __LINE__, __FILE__, $sql);
            }
            while( $row = $db->sql_fetchrow($result) )
            {
                $colored_username = color_username($row['user_level'], $row['user_jr'], $row['user_id'], $row['username']);
                $c_name[$row['user_id']]['username'] = $colored_username[0];
                $c_name[$row['user_id']]['style']    = $colored_username[1];
                $colored_username = '';
            }
        }

		for ($i = 0; $i < $c_rows; $i++)
		{
			$id_log = $rows[$i]['id_log'];
			$action = ucfirst($rows[$i]['mode']);
			$topic = $rows[$i]['topic_id'];
			$user_id = $rows[$i]['user_id'];
			$username = ( !empty($c_name[$user_id]['username']) ) ? $c_name[$user_id]['username'] : $rows[$i]['username'];
			$style    = ( !empty($c_name[$user_id]['style']) )    ? $c_name[$user_id]['style']    : '';
			$user_ip = decode_ip($rows[$i]['user_ip']);
			$date = $rows[$i]['time'];


			if ( $action == 'Warning_delete' )
			{
				$log_url = append_sid($phpbb_root_path.'profile.'.$phpEx.'?mode=viewprofile&amp;u=' . $topic);
			}
			else if ( $action == 'Warning_edit' )
			{
				$log_url = append_sid($phpbb_root_path .'warnings.'.$phpEx.'?mode=detail&amp;userid=' . $topic);
			}
			else if ( $action == 'Edit' )
			{
				$log_url = append_sid($phpbb_root_path .'viewtopic.'.$phpEx.'?p=' . $topic) . '#' . $topic;
			}
			else
			{
				$log_url = append_sid($phpbb_root_path .'viewtopic.'.$phpEx.'?t=' . $topic);
			}

			$template->assign_block_vars('record_row', array(
			'ID_LOG' => $id_log,
			'ACTION' => $lang[$action],
			'TOPIC' => ($action != 'Admin' && $action != 'Delete_all') ? $topic : '',
			'TOPIC_IMG' => ($action != 'Admin' && $action != 'Delete_all') ? '<a href="' . $log_url . '" target="_blank"><img src = "' .$phpbb_root_path . $images['icon_latest_reply']. '" alt="" border="0"></a>' : '',
			'USER_ID' => $user_id,
			'USERNAME' => '<a href="' . append_sid($phpbb_root_path.'profile.'.$phpEx.'?mode=viewprofile&amp;u=' . $user_id) . '" target="_new"' . $style . '>' . $username . '</a>',
			'USER_IP' => $user_ip,
			'U_WHOIS_IP' => '' . $board_config['address_whois'] . '' . $user_ip . '',
			'DATE' => create_date($board_config['default_dateformat'], $date, $board_config['board_timezone'], true))
			);
		}
$db->sql_freeresult($result);

$log_list = ( isset($HTTP_POST_VARS['log_list']) ) ? $HTTP_POST_VARS['log_list'] : array();
$delete = ( isset($HTTP_POST_VARS['delete']) ) ? $HTTP_POST_VARS['delete'] : '';

$log_list_sql = implode(', ', $log_list);

if ( $log_list_sql != '' )
{
	if ( $delete )
	{
		$sql = "DELETE
		FROM " . LOGS_TABLE . "
		WHERE id_log IN (" . $log_list_sql . ")
			AND mode <> 'Delete_all'";

		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not delete Logs', '', __LINE__, __FILE__, $sql);
		}
		else
		{
			$redirect_page = append_sid("admin_logging.$phpEx");
			$l_redirect = sprintf($lang['Click_return_admin_log'], '<a href="' . $redirect_page . '">', '</a>');
			message_die(GENERAL_MESSAGE, $lang['Log_delete'] . '<br /><br />' . $l_redirect);
		}
	}
}

if ( $board_config['topics_per_page'] > 10 )
{
	$sql = "SELECT count(*) AS total
		FROM " . LOGS_TABLE;
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Error getting total informations for logs', '', __LINE__, __FILE__, $sql);
		}

		if ( $total = $db->sql_fetchrow($result) )
		{
			$total_records = $total['total'];
			generate_pagination("admin_logging.$phpEx?mode=$mode&amp;order=$sort_order", $total_records, $board_config['topics_per_page'], $start). '&nbsp;';
		}
}
else
{
	$total_records = 10;
}

$template->pparse("body");

include('./page_footer_admin.'.$phpEx);

?>