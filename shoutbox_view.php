<?php
/***************************************************************************
 *              shoutbox_view.php
 *              -----------------
 *   begin				: Friday, May 02, 2004
 *   copyright			: (C) 2004 Przemo
 *   website			: http://www.przemo.org
 *   email				: przemo@przemo.org
 *   modification		: (C) 2010 lui754 <lui754@gmail.com>
 *	 date modification	: Saturday, Feb 20, 2010
 *   version			: 1.12.7
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
define('SHOUTBOX', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include_once($phpbb_root_path . 'includes/bbcode.'.$phpEx);

$mode = xhtmlspecialchars( get_vars('mode', '', 'POST') );
$userdata = ($mode == 'add' || $mode == 'delete' || $mode == 'edit') ? session_pagestart($user_ip, PAGE_SHOUTBOX) : session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);

if ( $shoutbox_config['sb_group_sel'] != 'all')
{
	$sql = 'SELECT ug.group_id
		FROM (' . USER_GROUP_TABLE . ' ug, ' . GROUPS_TABLE . ' g)
		WHERE ug.user_id = ' . $userdata['user_id'] . '
			AND g.group_id = ug.group_id
			AND g.group_single_user = 0
			AND ug.user_pending <> 1';
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_MESSAGE, 'Can not find username');
	}
	while ( $row2 = $db->sql_fetchrow($result) )
	{
		$grupy[] = $row2['group_id'];
	}

	$fid = explode(',', $shoutbox_config['sb_group_sel']);
	$shoutbox_view_group = false;
	if ( sizeof($grupy) )
	{
		foreach ( $grupy as $k => $v )
		if ( in_array($v, $fid) ) 
		{
			$shoutbox_view_group = true;
			break; // znalaz³o id, i stopujemy pêtle
		}
	}
}
else
{
	$shoutbox_view_group = true;
}

$is_jr_admin = ($userdata['user_jr']) ? true : false;
$is_mod = ($userdata['user_level'] == MOD) ? true : false;
$is_auth_e_own = ( $shoutbox_config['allow_edit_all'] && $userdata['user_id'] != ANONYMOUS ) ? true : false;
$is_auth_d_own = ( $shoutbox_config['allow_delete_all'] && $userdata['user_id'] != ANONYMOUS ) ? true : false;
$is_auth_e = ( $shoutbox_config['allow_edit'] && ((($is_jr_admin || $is_mod) && $shoutbox_config['allow_edit_m']) || $userdata['user_level'] == ADMIN) ) ? true : false;
$is_auth_d = ( $shoutbox_config['allow_delete'] && ((($is_jr_admin || $is_mod) && $shoutbox_config['allow_delete_m']) || $userdata['user_level'] == ADMIN) ) ? true : false;
$is_auth_send = ((!$shoutbox_config['allow_guest'] && !$userdata['session_logged_in']) || (!$shoutbox_config['allow_users'] && !$shoutbox_view_group && ($userdata['user_level'] != ADMIN && !$is_mod && !$is_jr_admin))) ? false : true;

$message = (!empty($HTTP_POST_VARS['message'])) ? charset_utf_fix( addslashes( xhtmlspecialchars($_POST['message']) ), true ) : '';
if( isset($HTTP_POST_VARS['message']) && empty($message) ) exit;

$id         = intval($HTTP_POST_VARS['id']);
$id_del     = intval($HTTP_POST_VARS['del']);
$id_edit    = intval($HTTP_POST_VARS['edit_id']);
$id_last    = intval($HTTP_POST_VARS['last']);
$sb_user_id = $userdata['user_id'];
$request = ( addslashes(xhtmlspecialchars($_SERVER['HTTP_SHOUTBOX']) ) == 'shoutbox_js' ) ? true : false;

if ( !function_exists('json_encode' ) )
{
	function json_encode( $a = false )
	{
		if ( is_null($a) ) return 'null';
		if ( $a === false ) return 'false';
		if ( $a === true ) return 'true';
		
		if ( is_scalar($a) )
		{
			if ( is_float($a) )
			{
				return floatval( str_replace(",", ".", strval($a)) );
			}
			elseif ( is_string($a) )
			{
				static $jsonReplaces = array( array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"') );
				return '"' . str_replace( $jsonReplaces[0], $jsonReplaces[1], $a ) . '"';
			}
			else
			return $a;
		}	
		$isList = true;
		for ( $i = 0, reset($a); $i < count($a); $i++, next($a) )
		{
			if ( key($a) !== $i )
			{
				$isList = false;
				break;
			}
		}
		$result = array();
		if ( $isList )
		{
			foreach ( $a as $v ) $result[] = json_encode($v);
			return '[' . join(',', $result) . ']';
		}
		else
		{
			foreach ( $a as $k => $v ) $result[] = json_encode($k) . ':' . json_encode($v);
			return '{' . join(',', $result) . '}';
		}
	}
}

function charset_utf_fix($string, $utfToIso = false )
{
	$arrayText = array(
		"\xb1" => "\xc4\x85", 
		"\xa1" => "\xc4\x84", 
		"\xe6" => "\xc4\x87", 
		"\xc6" => "\xc4\x86",
		"\xea" => "\xc4\x99", 
		"\xca" => "\xc4\x98", 
		"\xb3" => "\xc5\x82", 
		"\xa3" => "\xc5\x81",
		"\xf3" => "\xc3\xb3", 
		"\xd3" => "\xc3\x93", 
		"\xb6" => "\xc5\x9b", 
		"\xa6" => "\xc5\x9a",
		"\xbc" => "\xc5\xba", 
		"\xac" => "\xc5\xb9", 
		"\xbf" => "\xc5\xbc", 
		"\xaf" => "\xc5\xbb",
		"\xf1" => "\xc5\x84", 
		"\xd1" => "\xc5\x83",
		
		"%u0104" => "\xA1",
		"%u0106" => "\xC6",
		"%u0118" => "\xCA",
		"%u0141" => "\xA3",
		"%u0143" => "\xD1",
		"%u00D3" => "\xD3",
		"%u015A" => "\xA6",
		"%u0179" => "\xAC",
		"%u017B" => "\xAF",
		"%u0105" => "\xB1",
		"%u0107" => "\xE6",
		"%u0119" => "\xEA",
		"%u0142" => "\xB3",
		"%u0144" => "\xF1",
		"%u00D4" => "\xF3",
		"%u015B" => "\xB6",
		"%u017A" => "\xBC",
		"%u017C" => "\xBF"
	);
	return strtr( $string, ( $utfToIso ? array_flip($arrayText) : $arrayText ) );
}

function shoutbox_alert($alert, $czas, $disabled = false)
{
	global $id_last, $message;
	
	$message = charset_utf_fix($message);
	$alert = charset_utf_fix($alert);
	
	$output[] = array(
			'i' => $id_last+1,
			't' => '',
			'u' => '',
			'c' => 'color:#CD2626;',
			'n' => 'Info',
			'm' => $alert,
			'z' => str_replace("\'", "''", $message),
			'x' => '0',
			'e' => '0',
			'l' => '0',
			'p' => '0',
			'w' => intval($czas),
			'h' => ( $disabled ) ? '1' : '0'
		);
	$output = array('d' => $output);
	die (json_encode($output));
}

if( ob_get_length() ) ob_clean();
header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' ); 
header( 'Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT' ); 
header( 'Cache-Control: no-cache, must-revalidate' ); 
header( 'Pragma: no-cache' );
header( 'Content-Type: ' . ( $request ? 'application/json' : 'text/plain') . '; charset=iso-8859-2' );

if( $mode == 'add' )
{
	if ( !$is_auth_send )
	{
		$alert = shoutbox_alert($lang['login_to_shoutcast'], 5000);
	}
	$sql = 'SELECT MAX(timestamp) AS last_msg_time
		FROM ' . SHOUTBOX_TABLE . '
		WHERE sb_user_id ='. $sb_user_id;
		
	if ( $result = $db->sql_query($sql) )
	{
		if ( $row = $db->sql_fetchrow($result) )
		{
			if ( $row['last_msg_time'] > 0 && ( CR_TIME - $row['last_msg_time'] ) < $board_config['flood_interval'] && $userdata['user_level'] == USER && !$userdata['user_jr'] )
			{
				$flood_msg = true;
				$czas = CR_TIME - $row['last_msg_time'];
				$czas = $board_config['flood_interval'] - $czas;
				$czas = $czas * 1000;
				shoutbox_alert($lang['Flood_Error'], $czas);
			}
		}
	}
	
	$shoutbox_config['banned_user_id'] = $GLOBALS['shoutbox_config']['banned_user_id'];
	if ( strstr($shoutbox_config['banned_user_id'], ',') )
	{
		$fids = explode(',', $shoutbox_config['banned_user_id']);

		while( list($foo, $id) = each($fids) )
		{
			$fid[] = intval( trim($id) );
		}
	}
	else
	{
		$fid[] = intval( trim($shoutbox_config['banned_user_id']) );
	}
	reset($fid);
	
	if ( in_array($sb_user_id, $fid) != false )
	{
		shoutbox_alert( $lang['sb_banned_send' ], 50000, true );
		
		$shoutbox_banned = true;
	}
	
	if ( !$flood_msg && !$shoutbox_banned && $is_auth_send )
	{
		$sql = "INSERT INTO " . SHOUTBOX_TABLE . " (sb_user_id, msg, timestamp)
			VALUES($sb_user_id, '" . str_replace("\'", "''", $message) . "', '" . CR_TIME . "')";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not insert shoutbox message', '', __LINE__, __FILE__, $sql);
		}
		
		$start = CR_TIME - $shoutbox_config['delete_days'] * 86400;
		$sql = "DELETE FROM " . SHOUTBOX_TABLE . "
			WHERE timestamp < $start";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not delete shoutbox messages', '', __LINE__, __FILE__, $sql);
		}
	}
}
elseif ( $mode == 'delete' )
{
	$del_from_sb = false;
	if ( $is_auth_d )
	{
		$del_from_sb = true;
	}
	else if ( $is_auth_d_own )
	{
		$sql = 'SELECT sb_user_id FROM ' . SHOUTBOX_TABLE . '
			WHERE id = '. $id_del;
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not get shoutbox id/user_id information', '', __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);

		if ( $row['sb_user_id'] == $userdata['user_id'] )
		{
			$del_from_sb = true;
		}
		else
		{
			shoutbox_alert( $lang['Not_Authorised'], 5000 );
		}
	}
	else
	{
		shoutbox_alert( $lang['Not_Authorised'], 5000 );
	}
	
	if ( $del_from_sb )
	{
		$sql = 'DELETE FROM ' . SHOUTBOX_TABLE . '
			WHERE id ='. $id_del;
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not delete shoutbox message', '', __LINE__, __FILE__, $sql);
		}
	}  
}
elseif ( $mode == 'edit' )
{
	$edit_from_sb = false;
	if ( $is_auth_e )
	{
		$edit_from_sb = true;
	}
	else if ( $is_auth_e_own )
	{
		if ( $id == $userdata['user_id'] )
		{
			$edit_from_sb = true;
		}
	}
	else
	{
		shoutbox_alert( $lang['Not_Authorised'], 5000 );
	}

	if ( $edit_from_sb )
	{
		if ( !$is_auth_send )
		{
			shoutbox_alert( $lang['login_to_shoutcast'], 5000 );
		}
		
		$sql = "UPDATE " . SHOUTBOX_TABLE . " SET msg = '" . str_replace("\'", "''", $message) . "' WHERE id = $id_edit";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not replace shoutbox message', '', __LINE__, __FILE__, $sql);
		}
	}
}

if ( $request )
{
	$shoutbox_config['banned_user_id_view'] = $GLOBALS['shoutbox_config']['banned_user_id_view'];
	if( strstr($shoutbox_config['banned_user_id_view'], ',') )
	{
		$fids = explode(',', $shoutbox_config['banned_user_id_view']);

		while( list($foo, $id) = each($fids) )
		{
			$fid[] = intval( trim($id) );
		}
	}
	else
	{
		$fid[] = intval( trim($shoutbox_config['banned_user_id_view']) );
	}
	reset($fid);
	if ( in_array($sb_user_id, $fid) != false )
	{
		$shoutbox_banned_view = true;
	}
	if ( $shoutbox_config['shoutbox_on'] && $shoutbox != 'off' && !$shoutbox_banned_view && ( $shoutbox_config['allow_guest'] || $shoutbox_config['allow_guest_view'] || $userdata['session_logged_in'] ) && ($shoutbox_config['allow_users'] || $shoutbox_config['allow_users_view'] || $userdata['user_level'] == ADMIN || $is_mod || $is_jr_admin || $shoutbox_view_group) )
	{
        $limit = '';
		if ( $id_last == 0 )
		{
			$sql = 'SELECT COUNT(id) AS total
				FROM ' . SHOUTBOX_TABLE;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query shoutbox count messages', '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			$msg_count = $row['total'];

			$number = $shoutbox_config['count_msg'];
			$start = $msg_count - $number;

			if ( $msg_count < $number )
			{
				$start = 0;
			}
			$limit = 'LIMIT ' . $start . ', ' . $number;
		}

		$sql = 'SELECT s.timestamp, s.sb_user_id, s.id, s.msg, u.username, u.user_level, u.user_id, u.user_jr 
			FROM ' . SHOUTBOX_TABLE . ' s, ' . USERS_TABLE . ' u 
			WHERE u.user_id = s.sb_user_id
				AND s.id > '.$id_last.'
			ORDER BY s.id ASC 
			' . $limit;
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not shoutbox table', '', __LINE__, __FILE__, $sql);
		}
		$nums = $db->sql_numrows($result);
		if ( $nums > 0 )
		{
			$output = array();
			$orig_word = array();
			$replacement_word = array();
			$replacement_word_html = array();
			obtain_word_list($orig_word, $replacement_word, $replacement_word_html);
			$sf_installed = isset($sfc);
			while ( $row = $db->sql_fetchrow($result) )
			{
				$name_id = $row['sb_user_id'];
				$name = $row['username'];
				$id = $row['id'];
				$message = $row['msg'];
				if ( $sf_installed ) {$sfc['users'][$name_id] = $name;}
				$user_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$name_id");
				$colored_username = color_username( $row['user_level'], $row['user_jr'], $name_id, $name );
				$name = $colored_username[0];
				$name = ( $name_id == ANONYMOUS ) ? $lang['Guest'] : $name;
				$name = charset_utf_fix($name);
				if ( $shoutbox_config['allow_smilies'] && $userdata['show_smiles'] )
				{
					$message = smilies_pass($message);
				}
				if ( $shoutbox_config['allow_bbcode'] )
				{
					$message = preg_replace("#\[b\](.*?)\[\/b\]#si", "<b>\\1</b>", $message);
					$message = preg_replace("#\[i\](.*?)\[\/i\]#si", "<i>\\1</i>", $message);
					$message = preg_replace("#\[u\](.*?)\[\/u\]#si", "<u>\\1</u>", $message);
					$message = preg_replace( "/\[color=(\#[0-9A-F]{6}|[a-z]+)\](.*?)\[\/color]/si", '<span style="color:\\1">\\2</span>', $message );
				}
				else
				{
					$message = str_replace( array('[u]', '[b]', '[i]', '[/i]', '[/b]', '[/u]', '[/color]'), array('', '', '', '', '', '',''), $message );
				}
				$message = ($shoutbox_config['make_links']) ? make_clickable($message) : $message;
				$message = stripslashes($message);
				replace_bad_words($orig_word, $replacement_word, $message);
				$message = word_wrap_pass( replace_encoded($message) );
				$message = charset_utf_fix($message);
				$time = ( $shoutbox_config['date_on'] ) ? '['. create_date($shoutbox_config['date_format'], $row['timestamp'], $board_config['board_timezone']) .']' : '';
				$time = charset_utf_fix($time);
				$color = str_replace(' ', '', $colored_username[1]);
				$color = substr($color, 7, (strlen($color) - 8));
				$color = ($colored_username[1]) ? $color : '';
				$delete = ($is_auth_d_own && $name_id == $userdata['user_id'] || $is_auth_d) ? 1 : 0;
				$edit = ($is_auth_e_own && $name_id == $userdata['user_id'] || $is_auth_e) ? 1 : 0;
				$link_names = ( $shoutbox_config['links_names'] && $name_id != ANONYMOUS ) ? 1 : 0;
				$usercall = ( $shoutbox_config['usercall'] ) ? 1 : 0;
				$output[] = array(
					'i' => $id,
					't' => $time,
					'u' => $user_url,
					'c' => $color,
					'n' => $name,
					'm' => $message,
					'x' => $delete,
					'e' => $edit,
					'l' => $link_names,
					'p' => $usercall,
					'h' => '0'
				);
			}
			$output = array('d' => $output);
			die(json_encode($output));
		}
	}
	else
	{
		shoutbox_alert($lang['sb_restriction'], 50000, true);
	}
}
else
{
	die("Hacking attempt");
}
?>