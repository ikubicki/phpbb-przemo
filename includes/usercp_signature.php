<?php
/***************************************************************************
 *				usercp_signature.php
 *				------------------------
 * copyright		: ©2003 Freakin' Booty ;-P
 * built for		: Signature panel 0.1.6
 * version			: 0.1.1
 ***************************************************************************/

/***************************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 ***************************************************************************/

if( !defined ('IN_PHPBB'))
{
	die ('Hacking attempt');
}

function check_sig_image_type(&$type, &$error, &$error_msg)
{
	global $lang;

	switch( $type )
	{
		case 'image/jpeg':
		case 'image/jpg':
		case 'jpeg':
		case 'pjpeg':
		case 'jpg':
			return '.jpg';
			break;

		case 'image/gif':
		case 'gif':
			return '.gif';
			break;

		case 'image/png':
		case 'image/x-png':
		case 'png':
			return '.png';
			break;

		default:
			$error = true;
			$error_msg = (!empty($error_msg)) ? $error_msg . '<br />' . $lang['Avatar_filetype'] : $lang['Avatar_filetype'];
			break;
	}

	return false;
}

function user_signature_delete($signature_file)
{
	global $board_config, $userdata;
	if ( @file_exists(@phpbb_realpath('./' . $board_config['sig_images_path'] . '/' . $signature_file)) )
	{
		@unlink('./' . $board_config['sig_images_path'] . '/' . $signature_file);
	}

	return ", user_sig_image = ''";
}

function user_signature_upload($mode, $signature_mode, &$current_signature, &$error, &$error_msg, $signature_filename, $signature_realname, $signature_filesize, $signature_filetype)
{
	global $board_config, $db, $lang;

	$ini_val = ( @phpversion() >= '4.0.0' ) ? 'ini_get' : 'get_cfg_var';

	if ( $signature_mode == 'remote' && preg_match('/^(http:\/\/)?([\w\-\.]+)\:?([0-9]*)\/(.*)$/', $signature_filename, $url_ary) )
	{
		if ( empty($url_ary[4]) )
		{
			$error = true;
			$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $lang['Incomplete_URL'] : $lang['Incomplete_URL'];
			return;
		}

		$base_get = '/' . $url_ary[4];
		$port = ( !empty($url_ary[3]) ) ? $url_ary[3] : 80;

		if ( !($fsock = @fsockopen($url_ary[2], $port, $errno, $errstr)) )
		{
			$error = true;
			$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $lang['No_connection_URL'] : $lang['No_connection_URL'];
			return;
		}

		@fputs($fsock, "GET $base_get HTTP/1.1\r\n");
		@fputs($fsock, "HOST: " . $url_ary[2] . "\r\n");
		@fputs($fsock, "Connection: close\r\n\r\n");

		unset($signature_data);
		while( !@feof($fsock) )
		{
			$signature_data .= @fread($fsock, $board_config['sig_image_filesize']);
		}
		@fclose($fsock);

		if (!preg_match('#Content-Length\: ([0-9]+)[^ /][\s]+#i', $signature_data, $file_data1) || !preg_match('#Content-Type\: image/[x\-]*([a-z]+)[\s]+#i', $signature_data, $file_data2))
		{
			$error = true;
			$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $lang['File_no_data'] : $lang['File_no_data'];
			return;
		}

		$signature_filesize = $file_data1[1]; 
		$signature_filetype = $file_data2[1];

		if ( !$error && $signature_filesize > 0 && $signature_filesize < $board_config['sig_image_filesize'] )
		{
			$signature_data = substr($signature_data, strlen($signature_data) - $signature_filesize, $signature_filesize);

			$tmp_path = ( !@$ini_val('safe_mode') && !@$ini_val('open_basedir') ) ? '/tmp' : './' . $board_config['sig_images_path'] . '/tmp';
			$tmp_filename = tempnam($tmp_path, uniqid(rand()) . '-');

			$fptr = @fopen($tmp_filename, 'wb');
			$bytes_written = @fwrite($fptr, $signature_data, $signature_filesize);
			@fclose($fptr);

			if ( $bytes_written != $signature_filesize )
			{
				@unlink($tmp_filename);
				message_die(GENERAL_ERROR, 'Could not write signature image file to local storage. Please contact the board administrator with this message', '', __LINE__, __FILE__);
			}

			list($width, $height) = @getimagesize($tmp_filename);
		}
		else
		{
			$l_signature_size = sprintf($lang['Avatar_filesize'], round($board_config['sig_image_filesize'] / 1024));

			$error = true;
			$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $l_signature_size : $l_signature_size;
		}
	}
	else if ( ( file_exists(@phpbb_realpath($signature_filename)) ) && preg_match('/\.(jpg|jpeg|gif|png)$/i', $signature_realname) )
	{
		if ( $signature_filesize <= $board_config['sig_image_filesize'] && $signature_filesize > 0 )
		{
			preg_match('#image\/[x\-]*([a-z]+)#', $signature_filetype, $signature_filetype);
			$signature_filetype = $signature_filetype[1];
		}
		else
		{
			$l_signature_size = sprintf($lang['Avatar_filesize'], round($board_config['sig_image_filesize'] / 1024));

			$error = true;
			$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $l_signature_size : $l_signature_size;
			return;
		}

		list($width, $height) = @getimagesize($signature_filename);
	}

	if ( !($imgtype = check_sig_image_type($signature_filetype, $error, $error_msg)) )
	{
		return;
	}

	if ( $width <= $board_config['sig_image_max_width'] && $height <= $board_config['sig_image_max_height'] )
	{
		$new_filename = uniqid(rand()) . $imgtype;

		if ( $mode == 'editprofile' && $current_signature != '' )
		{
			if ( file_exists(@phpbb_realpath('./' . $board_config['sig_images_path'] . '/' . $current_signature)) )
			{
				@unlink('./' . $board_config['sig_images_path'] . '/' . $current_signature);
			}
		}

		if( $signature_mode == 'remote' )
		{
			@copy($tmp_filename, './' . $board_config['sig_images_path'] . "/$new_filename");
			@unlink($tmp_filename);
		}
		else
		{
			if ( @$ini_val('open_basedir') != '' )
			{
				if ( @phpversion() < '4.0.3' )
				{
					message_die(GENERAL_ERROR, 'open_basedir is set and your PHP version does not allow move_uploaded_file', '', __LINE__, __FILE__);
				}

				$move_file = 'move_uploaded_file';
			}
			else
			{
				$move_file = 'copy';
			}

			$move_file($signature_filename, './' . $board_config['sig_images_path'] . "/$new_filename");
		}

		@chmod('./' . $board_config['sig_images_path'] . "/$new_filename", 0777);

		$signature_sql = ( $mode == 'editprofile' ) ? ", user_sig_image = '$new_filename'" : "'$new_filename'";
	}
	else
	{
		$l_signature_size = sprintf($lang['Avatar_imagesize'], $board_config['sig_image_max_width'], $board_config['sig_image_max_height']);

		$error = true;
		$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $l_signature_size : $l_signature_size;
	}

	return $signature_sql;
}

?>