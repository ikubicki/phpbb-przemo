<?php
/***************************************************************************
 *                  admin_advert.php
 *                  -------------------
 *   begin          : 12, 10, 2005
 *   copyright      : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   email          : przemo@przemo.org
 *   version        : ver. 1.12.3 2005/12/10 21:18
 *
 ***************************************************************************/
define('MODULE_ID', 11);
define('IN_PHPBB', 1);

if ( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['General']['Advert_title'] = $file;
	return;
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

if ( isset($HTTP_GET_VARS['sid']) || isset($HTTP_POST_VARS['sid']) )
{
	include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin_advert.' . $phpEx);
}

$mode = ( isset($HTTP_GET_VARS['mode']) ) ? $HTTP_GET_VARS['mode'] : $HTTP_POST_VARS['mode'];
$edit = ( isset($HTTP_GET_VARS['edit']) ) ? $HTTP_GET_VARS['edit'] : $HTTP_POST_VARS['edit'];
$id = ( isset($HTTP_GET_VARS['id']) ) ? intval($HTTP_GET_VARS['id']) : intval($HTTP_POST_VARS['id']);

if ( !function_exists('update_adv_order') )
{
	function update_adv_order()
	{
		global $db;

		$sql = "SELECT id
			FROM " . ADV_TABLE . " ORDER by porder";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Could not get entry list", "", __LINE__, __FILE__, $sql);
		}
		$i = 0;
		while( $row = $db->sql_fetchrow($result) )
		{
			$i++;
			$sql = "UPDATE " . ADV_TABLE . "
				SET porder = $i
				WHERE id = " . $row['id'];
			if ( !($set_result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Couldn't update advertising table", "", __LINE__, __FILE__, $sql);
			}
		}
		sql_cache('clear', 'advertising');
	}
}
if ( !function_exists('get_max_adv_order') )
{
	function get_max_adv_order()
	{
		global $db;
		$sql = "SELECT MAX(porder) as max_order
			FROM " . ADV_TABLE;
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Couldn't get advertising order", "", __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);
		return $row['max_order'];
	}
}

if ( !function_exists('move_adv') )
{
	function move_adv($direction, $id)
	{
		global $db, $phpEx;

		$sql = "SELECT porder
			FROM " . ADV_TABLE . "
			WHERE id = " . $id . "
			LIMIT 1";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Couldn't get advertising order", "", __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);
		$current_order = $row['porder'];

		$max_order = get_max_adv_order();

		if ( ($direction == 'down' && $current_order != $max_order) || ($direction == 'up' && $current_order > 1) )
		{
			$first_delim = ($direction == 'down') ? '-' : '+';
			$second_delim = ($direction == 'down') ? '+' : '-';

			$sql = "UPDATE " . ADV_TABLE . "
				SET porder = porder $first_delim 1
					WHERE porder = $current_order $second_delim 1";
			if( !($set_result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Couldn't update advertising order", "", __LINE__, __FILE__, $sql);
			}
			$sql = "UPDATE " . ADV_TABLE . "
				SET porder = porder $second_delim 1
					WHERE id = " . intval($id);
			if( !($set_result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Couldn't update advertising order", "", __LINE__, __FILE__, $sql);
			}

			sql_cache('clear', 'advertising');
		}

		print '<meta http-equiv="refresh" content="0;url=' . append_sid("admin_advert.$phpEx") . '#' . $id . '">';
		exit;
	}
}

if ( $HTTP_GET_VARS['move'] && $id )
{
	move_adv($HTTP_GET_VARS['move'], $id);
}

$template->set_filenames(array(
	'body' => 'admin/admin_advert.tpl')
);

if ( isset($HTTP_POST_VARS['submit']) )
{
	if ( $HTTP_POST_VARS['add'] || $edit )
	{
		$html = $HTTP_POST_VARS['add_link'];
		$email = $HTTP_POST_VARS['email'];
		$days = $HTTP_POST_VARS['days'];
		$position = intval($HTTP_POST_VARS['position']);
		$type = ($HTTP_POST_VARS['type'] == '1') ? 1 : 0;

		$error_message = '';

		if ( !$html )
		{
			$error_message .= $lang['empty_html'] . '<br />';
		}
		if ( $email )
		{
			if ( !(preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*?[a-z]+$/is', $email)) )
			{
				$error_message .= $lang['Email_invalid'] . '<br />';
			}
		}
	}

	if ( $HTTP_POST_VARS['board_config'] )
	{
		update_config('advert', $HTTP_POST_VARS['advert']);
		update_config('advert_foot', $HTTP_POST_VARS['advert_foot']);
		update_config('view_ad_by', $HTTP_POST_VARS['view_ad_by']);
		update_config('advert_width', $HTTP_POST_VARS['advert_width']);
		update_config('advert_separator', $HTTP_POST_VARS['advert_separator']);
		update_config('advert_separator_l', $HTTP_POST_VARS['advert_separator_l']);

		message_die(GENERAL_MESSAGE, $lang['Config_ad_updated'] . "<br /><br />" . sprintf($lang['Click_return_config'], "<a href=\"" . append_sid("admin_advert.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>"));
	}
	else if ( $HTTP_POST_VARS['add'] )
	{
		if ( $error_message )
		{
			$template->assign_block_vars('add_error', array(
				'MESSAGE' => $error_message)
			);

			$template->assign_vars(array(
				'HIDE_SELECTED' => ($position == '0') ? ' selected="selected"' : '',
				'LEFT_SELECTED' => ($position == '2') ? ' selected="selected"' : '',
				'DOWN_SELECTED' => ($position == '1') ? ' selected="selected"' : '',
				'TYPE_CHECKED' => ($type == '1') ? ' checked="checked"' : '',
				'EMAIL' => stripslashes(xhtmlspecialchars($email)),
				'DAYS' => $days,
				'HTML' => stripslashes(xhtmlspecialchars($html)))
			);
		}
		else
		{
			$sql = "SELECT MAX(porder) AS total
				FROM " . ADV_TABLE;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain next order information', '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			$order = $row['total'] + 1;

			$expire_time = (intval($days)) ? CR_TIME + ($days * 86400) : 0;

			$sql = "INSERT INTO " . ADV_TABLE . " (html, email, position, porder, added, expire, type)
				VALUES('" . str_replace("\'", "''", $html) . "', '" . str_replace("\'", "''", $email) . "', $position, $order, " . CR_TIME . ", $expire_time, $type)";

			if ( !($db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Couldnt insert new entry into advertising table', '', __LINE__, __FILE__, $sql);
			}

			sql_cache('clear', 'advertising');
			message_die(GENERAL_MESSAGE, $lang['New_entry_added'] . "<br /><br />" . sprintf($lang['Click_return_config'], "<a href=\"" . append_sid("admin_advert.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>"));
		}
	}
}

$sql = "SELECT *
	FROM " . ADV_TABLE . "
	ORDER by porder";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not get entries list', '', __LINE__, __FILE__, $sql); 
}
while( $row = $db->sql_fetchrow($result) )
{
	$expire = ($row['expire']) ? round((($row['expire'] - CR_TIME) / 86400), 2) : '';
	$expire_short = ($row['expire']) ? round((($row['expire'] - CR_TIME) / 86400), 1) : '';
	$name = (strlen(str_replace(array(' ', '&nbsp;'), '', strip_tags($row['html']))) > 2) ? substr(strip_tags($row['html']), 0, 120) : substr(xhtmlspecialchars($row['html']), 0, 120);
	if ( $edit && $id == $row['id'] && $error_message )
	{
		$row['html'] = stripslashes($html);
		$row['email'] = stripslashes($email);
		$row['position'] = $position;
		$row['type'] = $type;
		$expire = $days;
	}

	$class = '1';
	if ( $expire < 0 )
	{
		$class = '3';
	}
	else if ( $row['position'] == '0' )
	{
		$class = '2';
	}

	$template->assign_block_vars('list',array(
		'ROW' => $class,
		'NAME' => $name,
		'HTML' => xhtmlspecialchars($row['html']),
		'EMAIL' => xhtmlspecialchars($row['email']),
		'HIDE_SELECTED' => ($row['position'] == '0') ? ' selected="selected"' : '',
		'LEFT_SELECTED' => ($row['position'] == '2') ? ' selected="selected"' : '',
		'DOWN_SELECTED' => ($row['position'] == '1') ? ' selected="selected"' : '',
		'TYPE_CHECKED' => ($row['type'] == '1') ? ' checked="checked"' : ' disabled="disabled"',
		'DAYS' => $expire,
		'DAYS_SHORT' => $expire_short,
		'ADDED' => create_date($board_config['default_dateformat'], $row['added'], $board_config['board_timezone']),
		'LAST_UPDATE' => ($row['last_update']) ? $lang['Last_update'] . ': ' .  create_date($board_config['default_dateformat'], $row['last_update'], $board_config['board_timezone']) : '',
		'EDIT_URL' => append_sid("admin_advert.$phpEx?id=" . $row['id'] . "&amp;edit=1"),
		'UP_URL' => append_sid("admin_advert.$phpEx?id=" . $row['id'] . "&amp;move=up"),
		'DOWN_URL' => append_sid("admin_advert.$phpEx?id=" . $row['id'] . "&amp;move=down"),
		'ID' => $row['id'])
	);
	if ( $edit && $id == $row['id'] )
	{
		$template->assign_block_vars('list.form',array());

		if ( $error_message )
		{
			$template->assign_block_vars('list.form.add_error', array(
				'MESSAGE' => $error_message)
			);
		}
		else if ( isset($HTTP_POST_VARS['submit']) && $HTTP_POST_VARS['edit'] )
		{
			$expire_time = (intval($days)) ? CR_TIME + ($days * 86400) : 0;

			if ( (($expire_time - $row['expire']) > 1000 || ($row['expire'] - $expire_time) > 1000) || stripslashes($html) != $row['html'] || stripslashes($email) != $row['email'] || $position != $row['position'] || $type != $row['type'] )
			{
				$sql2 = "UPDATE " . ADV_TABLE . "
					SET html = '" . str_replace("\'", "''", $html) . "', email = '" . str_replace("\'", "''", $email) . "', position = $position, expire = $expire_time, type = $type, last_update = " . CR_TIME . "
					WHERE id = $id";
				if ( !($db->sql_query($sql2)) )
				{
					message_die(GENERAL_ERROR, 'Couldnt insert new entry into advertising table', '', __LINE__, __FILE__, $sql2);
				}
				sql_cache('clear', 'advertising');
				message_die(GENERAL_MESSAGE, $lang['Config_ad_updated'] . "<br /><br />" . sprintf($lang['Click_return_config'], "<a href=\"" . append_sid("admin_advert.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>"));
			}
			else
			{
				if ( $HTTP_POST_VARS['delete'] == '1' )
				{
					$sql2 = "DELETE FROM " . ADV_TABLE . "
						WHERE id = $id";
					if ( !($db->sql_query($sql2)) )
					{
						message_die(GENERAL_ERROR, 'Couldnt idelete from advertising table', '', __LINE__, __FILE__, $sql2);
					}
					update_adv_order();
					sql_cache('clear', 'advertising');
					message_die(GENERAL_MESSAGE, $lang['Config_ad_updated'] . "<br /><br />" . sprintf($lang['Click_return_config'], "<a href=\"" . append_sid("admin_advert.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>"));
				}

				message_die(GENERAL_MESSAGE, $lang['Config_ad_not_updated'] . "<br /><br />" . sprintf($lang['Click_return_config'], "<a href=\"" . append_sid("admin_advert.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>"));
			}
		}
	}
}

$template->assign_vars(array(
	'L_ADVERT_TITLE' => $lang['Advert_title'],
	'L_ADVERT_EXPLAIN' => $lang['Advert_explain'],
	'L_RIGHT_COLUMN' => $lang['Advert'],
	'L_RIGHT_COLUMN_FOOT' => $lang['Advert_foot'],
	'L_ADVERT_VIEWS' => $lang['Adv_views'],
	'L_SETUP' => $lang['Configuration'],
	'L_VIEW_HIDE' => $lang['Ad_view_hide'],
	'L_REG_USERS' => $lang['Ad_registered_users'],
	'L_STAFF_USERS' => $lang['Ad_staff_users'],
	'L_DISABLE' => $lang['Disable'],
	'L_ADVERT_WIDTH' => $lang['Ad_width'],
	'L_LINK_SETUP' => $lang['Ad_link_setp'],
	'L_ADD_LINK' => $lang['Ad_add_link'],
	'L_EMAIL' => $lang['Email'],
	'L_DAYS' => $lang['Ad_days'],
	'L_POSITION' => $lang['Ad_Position'],
	'L_AD_LEFT' => $lang['Pos_left'],
	'L_AD_DOWN' => $lang['Pos_down'],
	'L_POS_HIDE' => $lang['Pos_no'],
	'L_AD_SEPARATOR' => $lang['Ad_separator'],
	'L_AD_SEPARATOR_L' => $lang['Ad_separator_l'],
	'L_ADD_LINK_E' => $lang['Add_link_e'],
	'L_ADD' => $lang['Add_new'],
	'L_SAVE' => $lang['Save'],
	'L_LIST' => $lang['Ad_list_entry'],
	'L_ORDER' => $lang['Ad_list_order'],
	'L_UP' => $lang['Ad_up'],
	'L_DOWN' => $lang['Ad_down'],
	'L_CLICKS' => $lang['Ad_clicks'],
	'L_ADDED' => $lang['Added'],
	'L_DELETE' => $lang['delete_entry'],
	'L_RESET' => $lang['Reset'],

	'ADVERT' => xhtmlspecialchars($board_config['advert']),
	'ADVERT_FOOT' => xhtmlspecialchars($board_config['advert_foot']),
	'ADVERT_WIDTH' => $board_config['advert_width'],
	'HIDE_DISABLE' => ($board_config['view_ad_by'] == '0') ? ' checked="checked"' : '',
	'HIDE_REG' => ($board_config['view_ad_by'] == '1') ? ' checked="checked"' : '',
	'HIDE_STAFF' => ($board_config['view_ad_by'] == '2') ? ' checked="checked"' : '',
	'SEPARATOR' => xhtmlspecialchars($board_config['advert_separator']),
	'SEPARATOR_L' => xhtmlspecialchars($board_config['advert_separator_l']),

	'S_ACTION' => append_sid("admin_advert.$phpEx"),
	)
);

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>