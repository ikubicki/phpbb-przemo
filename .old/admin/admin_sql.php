<?php
/***************************************************************************
 *              admin_sql.php
 *              -------------------
 *	begin       : 11, 10, 2005
 *	copyright   : (C) 2003 Przemo (http://www.przemo.org)
 *	email       : przemo@przemo.org
 *	version     : ver. 1.10.0 2005/10/11 01:54
 *
 ***************************************************************************/

/***************************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 ***************************************************************************/
define('MODULE_ID', 51);
define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['SQL']['MySqlAdmin'] = $filename;

	return;
}

$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

if( strstr($board_config['main_admin_id'], ',') )
{
	$fids = explode(',', $board_config['main_admin_id']);
	while( list($foo, $id) = each($fids) )
	{
		$fid[] = intval( trim($id) );
	}
}
else
{
	$fid[] = intval( trim($board_config['main_admin_id']) );
}
reset($fid);
if ( in_array($userdata['user_id'], $fid) == false )
{
	$message = sprintf($lang['SQL_Admin_No_Access'], '<a href="' . append_sid("admin_no_access.$phpEx") . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

$board_config['sql'] = trim($board_config['sql']);

if ( !$board_config['sql'] || strlen($board_config['sql']) < 8 )
{
	message_die(GENERAL_MESSAGE, 'MySQL address empty in the main configuration');
}

echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><meta http-equiv="refresh" content="0; url=' . $board_config['sql'] . '"><title>Redirect</title></head><body><div align="center">If your browser does not support meta redirection please click <a href="' . $board_config['sql'] . '">HERE</a> to be redirected</div></body></html>';

exit;

?>