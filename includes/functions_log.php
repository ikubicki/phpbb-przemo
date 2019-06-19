<?php
/***************************************************************************
 *                        functions_log.php
 *                        -------------------
 *   begin                : Jan 24 2003
 *   copyright            : Morpheus
 *   email                : morpheus@2037.biz
 *   modification         : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   date modification    : ver. 1.12.0 2005/10/09 14:18
 *
 *   $Id: function_log.php,v 1.85.2.9 2003/01/24 18:31:54 Moprheus Exp $
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

if (!defined('IN_PHPBB'))
{
	die('Hacking attempt');
}

function log_action($action, $topic_id, $user_id, $username, $poster_id = '')
{
	global $db, $user_ip;

	if ( $action == 'edit' && $poster_id && $poster_id == $user_id )
	{
		return;
	}

	$username = addslashes($username);
	$time = CR_TIME;

	switch( $action )
	{
		case 'delete' :
		case 'move' :
		case 'lock' :
		case 'unlock' :
		case 'split' :
		case 'edit' :
		case 'merge' :
		case 'announce-stick' :
		case 'expire' :
		case 'warning_delete' :
		case 'warning_edit' :
		case 'Normal_topic' :

			$sql = "INSERT INTO " . LOGS_TABLE . " (mode, topic_id, user_id, username, user_ip, time)
				VALUES ('$action', '$topic_id', '$user_id', '$username', '$user_ip', '$time')";

			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not insert data into logs table', '', __LINE__, __FILE__, $sql);
			}
			break;

		case 'admin' :

			$sql = "INSERT INTO " . LOGS_TABLE . " (mode, topic_id, user_id, username, user_ip, time)
				VALUES ('$action', '0', '$user_id', '$username', '$user_ip', '$time')";
			
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not insert data into logs table', '', __LINE__, __FILE__, $sql);
			}
			break;

		default :
		break;
	}
}

?>