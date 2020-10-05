<?php
/***************************************************************************
 *                             confirm_register.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   modification         : (C) 2007 Widmo http://widmo.biz
 *   date modification    : ver. 2.0 2007/10/11 02:04
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *
 ***************************************************************************/
 
define('IN_PHPBB', true);

$phpbb_root_path = './../';

include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

$userdata = session_pagestart($user_ip, PAGE_PROFILE);
init_userprefs($userdata);

$sql = "SELECT reg_key
	FROM " . ANTI_ROBOT_TABLE . "
	WHERE session_id = '" . $userdata['session_id'] . "'";
if ( !($result = $db->sql_query($sql)) )
{
		message_die(GENERAL_ERROR, 'Could not get code from anti robot table', '', __LINE__, __FILE__, $sql);
}
$row = $db->sql_fetchrow($result);

$gen_reg_key = $row['reg_key'] ;

if ( !$gen_reg_key )
{
	exit;
}

$img = array();

for($i = 0; $i < strlen($gen_reg_key); $i++)
{
		$img[$i] = imagecreatefrompng($phpbb_root_path . 'images/anti_robotic_reg/kapczh/anti_robotic_reg_' . $gen_reg_key[$i] . '.png');
		$img_x[$i] = imagesx($img[$i]);
		$img_y[$i] = imagesy($img[$i]);

		if( $i == 0)
		{
			  	$out = imagecreatetruecolor( $img_x[0] * strlen($gen_reg_key), $img_y[0] );
			  	$white = imagecolorallocate( $out, 255, 255, 255 );
				imagefill( $out, 0, 0, $white );
				
				$move = 0;
		}

		imagecopy($out, $img[$i], $move, 0, 0, 0, $img_x[$i], $img_y[$i]);
		$move += $img_x[$i];
}

// Output image
header('Content-Type: image/png');
header('Cache-control: no-cache, no-store');

imagepng($out);

?>