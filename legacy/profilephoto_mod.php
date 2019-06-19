<?php
/***************************************************************************
 *                      profilephoto_mod.php
 *                      -------------------
 *   begin              : Sunday, Mar 07, 2002
 *   copyright          : (C) 2002 Meik Sievertsen
 *   email              : acyd.burn@gmx.de
 *   modification       : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   date modification  : ver. 1.12.3 2003/10/10 03:05
 *
 *   $Id: profilephoto_mod.php,v 2.0.2 2002/06/02 meik Exp $
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
	exit;
}

//
// Functions
//
function user_photo_delete($photo_type, $photo_file)
{
	global $board_config, $userdata;

	if ( $photo_type == USER_AVATAR_UPLOAD && $photo_file != '' )
	{
		if ( @file_exists('./' . $board_config['photo_path'] . '/' . $photo_file) )
		{
			@unlink('./' . $board_config['photo_path'] . '/' . $photo_file);
		}
	}

	return " user_photo = '', user_photo_type = " . USER_AVATAR_NONE;
}

function check_photoimage_type(&$type, &$error, &$error_msg)
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
		case 'png':
		case 'image/x-png':
			return '.png';
			break;

		default:
			$error = true;
			$error_msg = (!empty($error_msg)) ? $error_msg . '<br />' . $lang['Avatar_filetype'] : $lang['Avatar_filetype'];
			break;
	}

	return false;
}

function user_photo_url($mode, &$error, &$error_msg, $photo_filename)
{
	global $board_config, $lang;

	if ( !preg_match('#^(http)|(ftp):\/\/#i', $photo_filename) )
	{
		$photo_filename = 'http://' . $photo_filename;
	}

//	if ( !preg_match('#^(http:\/\/[a-z0-9\-]+?\.([a-z0-9\-]+\.)*[a-z]+(:[0-9]+)*\/[^\"]*?\.(gif|jpg|jpeg|png)$)#is', $photo_filename) )

	if ( !preg_match('(gif|jpg|jpeg|png)', end(explode('.',$photo_filename))) )
	{
		$error = true;
		$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $lang['Wrong_remote_avatar_format'] : $lang['Wrong_remote_avatar_format'];
		return;
	}
	if (preg_match('/(&|\?|\.php)/i',$photo_filename))
	{
		$error = true;
		$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $lang['Wrong_remote_avatar_format'] : $lang['Wrong_remote_avatar_format'];
		return;
	}

	list($width, $height) = @getimagesize($photo_filename);
	
	if ( ($width > $board_config['photo_max_width']) || ($height > $board_config['photo_max_height']) )
	{
		$l_photo_size = sprintf($lang['Avatar_imagesize'], $board_config['photo_max_width'], $board_config['photo_max_height']);

		$error = true;
		$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $l_photo_size : $l_photo_size;
		return;
	}

	return ( $mode == 'editprofile' ) ? " user_photo = '" . str_replace("\'", "''", $photo_filename) . "', user_photo_type = " . USER_AVATAR_REMOTE : '';
}

function user_photo_upload($mode, $photo_mode, &$current_photo, &$current_type, &$error, &$error_msg, $photo_filename, $photo_realname, $photo_filesize, $photo_filetype)
{
	global $board_config, $user_ip, $db, $lang;

	$ini_val = ( @phpversion() >= '4.0.0' ) ? 'ini_get' : 'get_cfg_var';

	if ( $photo_mode == 'remote' && preg_match('/^(http:\/\/)?([\w\-\.]+)\:?([0-9]*)\/(.*)$/', $photo_filename, $url_ary) )
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

		unset($photo_data);
		while( !@feof($fsock) )
		{
			$photo_data .= @fread($fsock, $board_config['photo_filesize']);
		}
		@fclose($fsock);

		if ( !preg_match('/Content-Length\: ([0-9]+)[^\/ ][\s]+/i', $photo_data, $file_data1) || !preg_match('/Content-Type\: image\/[x\-]*([a-z]+)[\s]+/i', $photo_data, $file_data2) )
		{
			$error = true;
			$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $lang['File_no_data'] : $lang['File_no_data'];
			return;
		}

		$photo_filesize = $file_data1[1];
		$photo_filetype = $file_data2[1];

		if ( !$error && $photo_filesize > 0 && $photo_filesize < $board_config['photo_filesize'] )
		{
			$photo_data = substr($photo_data, strlen($photo_data) - $photo_filesize, $photo_filesize);

			$tmp_path = ( !@$ini_val('safe_mode') && !@$ini_val('open_basedir') ) ? '/tmp' : './' . $board_config['photo_path'] . '/tmp';
			$tmp_filename = tempnam($tmp_path, uniqid($user_ip) . '-');

			$fptr = @fopen($tmp_filename, 'wb');
			$bytes_written = @fwrite($fptr, $photo_data, $photo_filesize);
			@fclose($fptr);

			if ( $bytes_written != $photo_filesize )
			{
				@unlink($tmp_filename);
				message_die(GENERAL_ERROR, 'Could not write photo file to local storage. Please contact the board administrator with this message', '', __LINE__, __FILE__);
			}

			list($width, $height) = @getimagesize($tmp_filename);
		}
		else
		{
			$l_photo_size = sprintf($lang['Avatar_filesize'], round($board_config['photo_filesize'] / 1024));

			$error = true;
			$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $l_photo_size : $l_photo_size;
		}
	}
	else if ( $photo_mode == 'local' && file_exists($photo_filename) && preg_match('/\.(jpg|jpeg|gif|png)$/i', $photo_realname) )
	{
		if ( $photo_filesize <= $board_config['photo_filesize'] && $photo_filesize > 0 )
		{
			preg_match('#image\/[x\-]*([a-z]+)#', $photo_filetype, $photo_filetype);
			$photo_filetype = $photo_filetype[1];
		}
		else
		{
			$l_photo_size = sprintf($lang['Avatar_filesize'], round($board_config['photo_filesize'] / 1024));

			$error = true;
			$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $l_photo_size : $l_photo_size;
			return;
		}

		list($width, $height) = @getimagesize($photo_filename);
	}

	if ( !($imgtype = check_photoimage_type($photo_filetype, $error, $error_msg)) )
	{
		return;
	}

	if ( $width <= $board_config['photo_max_width'] && $height <= $board_config['photo_max_height'] )
	{
		$new_filename = uniqid($user_ip) . $imgtype;

		if ( $mode == 'editprofile' && $current_type == USER_AVATAR_UPLOAD && $current_photo != '' )
		{
			if ( file_exists('./' . $board_config['photo_path'] . '/' . $current_photo) )
			{
				@unlink('./' . $board_config['photo_path'] . '/' . $current_photo);
			}
		}

		if( $photo_mode == 'remote' )
		{
			@copy($tmp_filename, './' . $board_config['photo_path'] . "/$new_filename");
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

			$move_file($photo_filename, './' . $board_config['photo_path'] . "/$new_filename");
		}

		@chmod('./' . $board_config['photo_path'] . "/$new_filename", 0777);

		$photo_sql = " user_photo = '$new_filename', user_photo_type = " . USER_AVATAR_UPLOAD;
	}
	else
	{
		$l_photo_size = sprintf($lang['Avatar_imagesize'], $board_config['photo_max_width'], $board_config['photo_max_height']);

		$error = true;
		$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $l_photo_size : $l_photo_size;
	}

	return $photo_sql;
}


class profilephoto
{

	var $photo_sql = '';

	function execute_mod()
	{
		global $HTTP_POST_VARS, $HTTP_GET_VARS, $mode, $userdata;

		if ( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
		{
			$mode = ( isset($HTTP_GET_VARS['mode']) ) ? $HTTP_GET_VARS['mode'] : $HTTP_POST_VARS['mode'];

			if ( $mode == 'viewprofile' )
			{
				$this->perform_viewprofile();
				return;
			}
			else if ( $mode == 'editprofile' || $mode == 'register' )
			{
				if ( !$userdata['session_logged_in'] && $mode == 'editprofile' )
				{
					return;
				}

				$this->perform_register();
				return;
			}
		}
		else
		{
			return;
		}
	}

	function perform_viewprofile()
	{
		global $HTTP_GET_VARS, $lang, $board_config, $phpbb_root_path, $phpEx, $template;
		
		if ( empty($HTTP_GET_VARS[POST_USERS_URL]) || $HTTP_GET_VARS[POST_USERS_URL] == ANONYMOUS )
		{
			message_die(GENERAL_MESSAGE, $lang['No_user_id_specified']);
		}
		$profiledata = get_userdata(intval($HTTP_GET_VARS[POST_USERS_URL]));

		$photo_img = '';
		if ( $profiledata['user_photo_type'] )
		{
			switch( $profiledata['user_photo_type'] )
			{
				case USER_AVATAR_UPLOAD:
					$photo_img = ( $board_config['allow_photo_upload'] ) ? '<img src="' . $board_config['photo_path'] . '/' . $profiledata['user_photo'] . '" alt="" border="0" />' : '';
					break;
				case USER_AVATAR_REMOTE:
					$photo_img = ( $board_config['allow_photo_remote'] ) ? '<img src="' . $profiledata['user_photo'] . '" alt="" border="0" />' : '';
					break;
			}
		}
		if (!empty($photo_img))
		{
			$template->assign_block_vars('photo', array(
				'L_PHOTO' => $lang['Profile_photo'],
				'PHOTO_IMG' => $photo_img)
			);
		}
	
	}

	function perform_register()
	{
		global $phpbb_root_path, $board_config, $phpEx, $mode, $HTTP_POST_VARS, $userdata, $error, $error_msg, $lang, $new_user_id, $id, $user_id, $template, $db, $HTTP_POST_FILES;

		if ( isset($HTTP_POST_VARS['submit']) || $mode == 'register' )
		{
			if ( $mode == 'editprofile' )
			{
				$user_id = intval($HTTP_POST_VARS['user_id']);
			}

			$user_photo_upload = ( !empty($HTTP_POST_VARS['photourl']) ) ? trim($HTTP_POST_VARS['photourl']) : ( ( $HTTP_POST_FILES['photo']['tmp_name'] != 'none') ? $HTTP_POST_FILES['photo']['tmp_name'] : '' );

			$user_photo_remoteurl = ( !empty($HTTP_POST_VARS['photoremoteurl']) ) ? trim($HTTP_POST_VARS['photoremoteurl']) : '';

			$user_photo_name = ( !empty($HTTP_POST_FILES['photo']['name']) ) ? $HTTP_POST_FILES['photo']['name'] : '';
			$user_photo_size = ( !empty($HTTP_POST_FILES['photo']['size']) ) ? $HTTP_POST_FILES['photo']['size'] : 0;
			$user_photo_filetype = ( !empty($HTTP_POST_FILES['photo']['type']) ) ? $HTTP_POST_FILES['photo']['type'] : '';
			$user_photo_url = ( !empty($HTTP_POST_VARS['photourl']) ) ? trim($HTTP_POST_VARS['photourl']) : '';

			$user_photo = ( empty($user_photo_loc) && $mode == 'editprofile' ) ? $userdata['user_photo'] : '';
			$user_photo_type = ( empty($user_photo_loc) && $mode == 'editprofile' ) ? $userdata['user_photo_type'] : '';
		}

		if ( isset($HTTP_POST_VARS['submit']) )
		{

			$error = FALSE;

			if ( isset($HTTP_POST_VARS['photodel']) && $mode == 'editprofile' )
			{
				$this->photo_sql = user_photo_delete($userdata['user_photo_type'], $userdata['user_photo']);
			}
			else if ( ( !empty($user_photo_upload) || !empty($user_photo_name) ) && $board_config['allow_photo_upload'] )
			{
		
				if ( !empty($user_photo_upload) )
				{
					$photo_mode = ( !empty($user_photo_name) ) ? 'local' : 'remote';
					$userdata_user_photo = $userdata['user_photo'];
					$userdata_user_photo_type = $userdata['user_photo_type'];
					$this->photo_sql = user_photo_upload($mode, $photo_mode, $userdata_user_photo, $userdata_user_photo_type, $error, $error_msg, $user_photo_upload, $user_photo_name, $user_photo_size, $user_photo_filetype);
				}
				else if ( !empty($user_photo_name) )
				{
					$l_photo_size = sprintf($lang['Avatar_filesize'], round($board_config['photo_filesize'] / 1024));

					$error = true;
					$error_msg .= ( ( !empty($error_msg) ) ? '<br />' : '' ) . $l_photo_size;
				}
			}
			else if ( $user_photo_remoteurl != '' && $board_config['allow_photo_remote'] )
			{
				$this->photo_sql = user_photo_url($mode, $error, $error_msg, $user_photo_remoteurl);
			}

			if ( !$error )
			{
				if ( $this->photo_sql == '' )
				{
					$this->photo_sql = ( $mode == 'editprofile' ) ? '' : " user_photo = '', user_photo_type = " . USER_AVATAR_NONE;
				}

				if ($this->photo_sql != '')
				{
					if ( $mode == 'editprofile' )
					{
						$sql = "UPDATE " . USERS_TABLE . "
						SET " . $this->photo_sql . "
						WHERE user_id = " . intval($user_id);
						
						if ( !($result = $db->sql_query($sql)) )
						{
							message_die(GENERAL_ERROR, 'Could not update users table', '', __LINE__, __FILE__, $sql);
						}
					}
				}
			}
		}

		if ( $mode == 'editprofile' )
		{
			$user_photo = $userdata['user_photo'];
			$user_photo_type = $userdata['user_photo_type'];
		}

		$s_hidden_fields = '';

		$photo_img = '';
		if ( $user_photo_type )
		{
			switch( $user_photo_type )
			{
				case USER_AVATAR_UPLOAD:
					$photo_img = ( $board_config['allow_photo_upload'] ) ? '<img src="' . $board_config['photo_path'] . '/' . $user_photo . '" alt="" />' : '';
					break;
				case USER_AVATAR_REMOTE:
					$photo_img = ( $board_config['allow_photo_remote'] ) ? '<img src="' . $user_photo . '" alt="" />' : '';
					break;
			}
		}

		if ( !empty($user_photo_local) )
		{
			$s_hidden_fields .= '<input type="hidden" name="photolocal" value="' . $user_photo_local . '" />';
		}

		$template->set_filenames(array(
			'photobox' => 'profile_photo_box.tpl')
		);

		//
		// Let's do an overall check for settings/versions which would prevent
		// us from doing file uploads....
		//
		$ini_val = ( phpversion() >= '4.0.0' ) ? 'ini_get' : 'get_cfg_var';
		$form_enctype = ( @$ini_val('file_uploads') == '0' || strtolower(@$ini_val('file_uploads') == 'off') || phpversion() == '4.0.4pl1' || !$board_config['allow_photo_upload'] || ( phpversion() < '4.0.3' && @$ini_val('open_basedir') != '' ) ) ? '' : 'enctype="multipart/form-data"';

		$template->assign_vars(array(
			'ALLOW_PHOTO' => $board_config['allow_photo_upload'],
			'PHOTO' => $photo_img,
			'PHOTO_SIZE' => $board_config['photo_filesize'],
				
			'L_PHOTO_PANEL' => $lang['Photo_panel'],
			'L_PHOTO_EXPLAIN' => sprintf($lang['Photo_explain'], $board_config['photo_max_width'], $board_config['photo_max_height'], (round($board_config['photo_filesize'] / 1024))),
			'L_UPLOAD_PHOTO_FILE' => $lang['Upload_Avatar_file'],
			'L_UPLOAD_PHOTO_URL' => $lang['Upload_Avatar_URL'],
			'L_UPLOAD_PHOTO_URL_EXPLAIN' => $lang['Upload_Avatar_URL_explain'],
			'L_LINK_REMOTE_PHOTO' => $lang['Link_remote_Avatar'],
			'L_LINK_REMOTE_PHOTO_EXPLAIN' => $lang['Link_remote_Avatar_explain'],
			'L_DELETE_PHOTO' => $lang['Delete_Image'],
			'L_CURRENT_IMAGE' => $lang['Current_Image'],

			'S_ALLOW_PHOTO_UPLOAD' => $board_config['allow_photo_upload'],
			'S_ALLOW_PHOTO_REMOTE' => $board_config['allow_photo_remote'],
			'S_PHOTO_HIDDEN_FIELDS' => $s_hidden_fields)
		);

		//
		// This is another cheat using the block_var capability
		// of the templates to 'fake' an IF...ELSE...ENDIF solution
		// it works well :)
		//
		if ( $board_config['allow_photo_upload'] || $board_config['allow_photo_remote'] ) 
		{
			$template->assign_block_vars('switch_photo_block', array() );

			if ( $board_config['allow_photo_upload'] && file_exists('./' . $board_config['photo_path']) )
			{
				if ( $form_enctype != '' )
				{
					$template->assign_block_vars('switch_photo_block.switch_photo_local_upload', array() );
				}
				$template->assign_block_vars('switch_photo_block.switch_photo_remote_upload', array() );
			}

			if ( $board_config['allow_photo_remote'] )
			{
				$template->assign_block_vars('switch_photo_block.switch_photo_remote_link', array() );
			}

		}

		$template->assign_var_from_handle('PHOTO_BOX', 'photobox');
	}

	function photo_insert($mode)
	{
		global $error, $error_msg, $HTTP_POST_VARS, $userdata, $board_config, $lang, $user_id, $db;

		if ( ( $mode != 'editprofile' ) && ($this->photo_sql != '') )
		{
			$sql = "UPDATE " . USERS_TABLE . "
				SET " . $this->photo_sql . "
				WHERE user_id = " . intval($user_id);

			//
			// WE ARE IN A TRANSACTION HERE
			//
			if (!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, "Couldn't insert data into users table", "", __LINE__, __FILE__, $sql);
			}
		}
	}

}

$profilephoto_mod = new profilephoto();

?>