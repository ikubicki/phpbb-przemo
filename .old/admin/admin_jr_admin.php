<?php
/***************************************************************************
 *              admin_jr_admin.php
 *              -------------------
 *  begin       : Monday, Jul 02, 2006
 *  copyright   : (C) 2003 Przemo ( http://www.przemo.org/phpBB2/ )
 *  email       : przemo@przemo.org
 *  version     : 1.12.1
 *
 ***************************************************************************/
define('MODULE_ID', 0);
define('IN_PHPBB', 1);

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_jr_admin.' . $phpEx);

if ( isset($HTTP_GET_VARS['user_id']) || isset($HTTP_POST_VARS['user_id']) )
{
	$user_id = (isset($HTTP_GET_VARS['user_id'])) ? intval($HTTP_GET_VARS['user_id']) : intval($HTTP_POST_VARS['user_id']);
}
else
{
	message_die(GENERAL_ERROR, $lang['No_user_specified']);
}

$sql = "SELECT u.*, jr.user_jr_admin FROM " . USERS_TABLE . " u
	LEFT JOIN " . JR_ADMIN_TABLE . " jr ON (u.user_id = jr.user_id)
	WHERE u.user_id = $user_id";
if ( !$result = $db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, "Could not query user information", "", __LINE__, __FILE__, $sql);
}
if ( !($row = $db->sql_fetchrow($result)) )
{
	message_die(GENERAL_ERROR, $lang['No_user_id_specified']);
}

$template->set_filenames(array(
	'body' => 'admin/junior_admins_body.tpl')
);

$user_is_jr = (isset($row['user_jr_admin'])) ? true : false;

$i = $j = 0;
$new_list = '';
$jr_modules_array = ($row['user_jr_admin']) ? explode(',', $row['user_jr_admin']) : array();
foreach ($modules_data as $cat => $module_array)
{
	$i++;
	$template->assign_block_vars("catrow", array(
		'CAT' => (isset($lang[$cat])) ? $lang[$cat] : preg_replace("/_/", ' ', $cat),
		'NUM' => $i)
	);

	foreach ($module_array as $key => $val)
	{
		$file_id = $val[1];
		if ( $file_id > 0 )
		{
			$post_name = 'a' . $i . '_name' . $j;
			if ( $HTTP_POST_VARS[$post_name] && $HTTP_POST_VARS[$post_name] == $file_id )
			{
				$new_list .= (($new_list) ? ',' : '') . $file_id;
			}

			$access = (in_array($file_id, $jr_modules_array)) ? true : false;

			$template->assign_block_vars("catrow.modulerow", array(
				'ROW' => ($j % 2) ? '1' : '2',
				'CAT_NUM' => $j,
				'FILE' => $file_id,
				'CHECKED' => ($access) ? ' checked="checked"' : '',
				'STYLE' => ($access) ? ' style="color: #00CC00"' : '',
				'U_ADMIN_MODULE' => $url,
				'NAME' => (isset($lang[$key])) ? $lang[$key] : preg_replace("/_/", ' ', $key))
			);
			$j++;
		}
	}
}

if ( isset($HTTP_POST_VARS['submit']) )
{
	if ( !$user_is_jr && $new_list )
	{
		$sql = "INSERT INTO " . JR_ADMIN_TABLE . " (user_id, user_jr_admin)
			VALUES ($user_id, '$new_list')";
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Could not insert into user JR table", "", __LINE__, __FILE__, $sql);
		}			
	}
	else if ( $user_is_jr )
	{
		$sql = "UPDATE " . JR_ADMIN_TABLE . "
			SET user_jr_admin = '$new_list'
			WHERE user_id = $user_id";
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, "Could not update user JR table", "", __LINE__, __FILE__, $sql);
		}
	}
	if ( $new_list )
	{
		$sql = "UPDATE " . USERS_TABLE . "
			SET user_jr = 1, user_ip_login_check = 1
			WHERE user_id = $user_id";
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, "Could not update users table", "", __LINE__, __FILE__, $sql);
		}
	}
	else
	{
		$sql = "UPDATE " . USERS_TABLE . "
			SET user_jr = 0
			WHERE user_id = $user_id";
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, "Could not update users table", "", __LINE__, __FILE__, $sql);
		}
		$sql = "DELETE FROM " . JR_ADMIN_TABLE . "
			WHERE user_id = $user_id";
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, "Could not delete from JR users table", "", __LINE__, __FILE__, $sql);
		}
	}

	message_die(GENERAL_MESSAGE, sprintf($lang['Click_return_admin_jr'], '<a href="' . append_sid("admin_users_list.$phpEx") . '">', '</a>', '<a href="' . append_sid("admin_jr_admin.$phpEx?user_id=$user_id") . '">', '</a>'));
}

$template->assign_vars(array(
	'L_TITLE' => $lang['JR_title'],
	'L_DESC' => $lang['JR_description'],
	'L_MODULES' => $lang['Modules'],
	'L_MARK_ALL' => $lang['Mark_all'],

	'USER_ID' => $user_id,
	'USERNAME' => $row['username'],
	'MODULES' => ($row['user_jr_admin']) ? @count(@explode(',', $row['user_jr_admin'])) : 0,
	'S_ACTION' => append_sid("admin_jr_admin.$phpEx")
));

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>