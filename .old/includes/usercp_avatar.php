<?php
/***************************************************************************
 *                             usercp_avatar.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *	 modification         : (C) 2005 Przemo www.przemo.org/phpBB2/
 *	 date modification    : ver. 1.12.0 2005/09/22 16:36
 *
 *   $Id: usercp_avatar.php,v 1.8.2.22 2005/10/30 15:17:14 acydburn Exp $
 *
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

function check_image_type(&$type, &$error, &$error_msg)
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

function user_avatar_delete($avatar_type, $avatar_file)
{
	global $board_config, $userdata;

	$avatar_file = basename($avatar_file);
	if ( $avatar_type == USER_AVATAR_UPLOAD && $avatar_file != '' )
	{
		if ( @file_exists(@phpbb_realpath('./' . $board_config['avatar_path'] . '/' . $avatar_file)) )
		{
			@unlink('./' . $board_config['avatar_path'] . '/' . $avatar_file);
		}
	}

	return ", user_avatar = '', user_avatar_type = " . USER_AVATAR_NONE;
}

function user_avatar_gallery($mode, &$error, &$error_msg, $avatar_filename, $avatar_category)
{
	global $board_config;

	$avatar_filename = phpbb_ltrim(basename($avatar_filename), "'");
	$avatar_category = phpbb_ltrim(basename($avatar_category), "'");
	
	if(!preg_match('/(\.gif$|\.png$|\.jpg|\.jpeg)$/is', $avatar_filename))
	{
		return '';
	}

	if ($avatar_filename == "" || $avatar_category == "")
	{
		return '';
	} 

	if ( file_exists(@phpbb_realpath($board_config['avatar_gallery_path'] . '/' . $avatar_category . '/' . $avatar_filename)) && ($mode == 'editprofile') )
	{
		$return = ", user_avatar = '" . str_replace("\'", "''", $avatar_category . '/' . $avatar_filename) . "', user_avatar_type = " . USER_AVATAR_GALLERY;
	}
	else
	{
		$return = '';
	}
	return $return;
}

function user_avatar_url($mode, &$error, &$error_msg, $avatar_filename)
{
	global $board_config, $lang;
	
	if ( !preg_match('#^(http)|(ftp):\/\/#i', $avatar_filename) )
	{
		$avatar_filename = 'http://' . $avatar_filename;
	}

	if ( !preg_match("#^((ht|f)tp://)([^ \?&=\#\"\n\r\t<]*?(\.(jpg|jpeg|gif|png))$)#is", $avatar_filename) )
	{
		$error = true;
		$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $lang['Wrong_remote_avatar_format'] : $lang['Wrong_remote_avatar_format'];
		return;
	}
	
	list($width, $height) = @getimagesize($avatar_filename);
	
	if ( ($width > $board_config['avatar_max_width']) || ($height > $board_config['avatar_max_height']) )
	{
		$l_avatar_size = sprintf($lang['Avatar_imagesize'], $board_config['avatar_max_width'], $board_config['avatar_max_height']);
		$error = true;
		$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $l_avatar_size : $l_avatar_size;
		return;
	}
	
	// Ensures the image doesn't exceed the max width and height specified in the board's configuration
	$user_avatar_dimensions = @GetImageSize($avatar_filename);

	if ($user_avatar_dimensions == NULL)
	{
//		$user_avatar_xsize = 0; // Remote avatar not found, zero
//		$user_avatar_ysize = 0;
		$error = true;
		$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $lang['Wrong_remote_avatar_format'] : $lang['Wrong_remote_avatar_format'];
		return;

	}
	else
	{  // Check avatar dimensions, adjust if necessary
		
		// Extract the image's width and height
		$firstquote = strpos($user_avatar_dimensions[3],'"');
		$strwidth = substr($user_avatar_dimensions[3],$firstquote+1);
		$lastquote = strpos($strwidth,'"');
		$user_avatar_xsize = substr($strwidth,0,$lastquote);

		$strheight = substr($strwidth,$lastquote+1);
		
		$firstquote = strpos($strheight,'"');
		
		$strheight = substr($strheight,$firstquote+1);
	
		$lastquote = strpos($strheight,'"');
		$user_avatar_ysize = substr($strheight,0,$lastquote);
		
		if ($user_avatar_xsize > $board_config['avatar_max_width']) // width exceeds max
		{
			$user_avatar_ratio = $board_config['avatar_max_width'] / $user_avatar_xsize;

			$user_avatar_xsize = $user_avatar_xsize * $user_avatar_ratio;
			$user_avatar_ysize = $user_avatar_ysize * $user_avatar_ratio;
		}
		
		if ($user_avatar_ysize > $board_config['avatar_max_height']) // height exceeds max
		{
			$user_avatar_ratio = $board_config['avatar_max_height'] / $user_avatar_ysize;

			$user_avatar_xsize = $user_avatar_xsize * $user_avatar_ratio;
			$user_avatar_ysize = $user_avatar_ysize * $user_avatar_ratio;
		}
	}
	return ( $mode == 'editprofile' ) ? ", user_avatar = '" . str_replace("\'", "''", $avatar_filename) . "', user_avatar_type = " . USER_AVATAR_REMOTE . ", user_avatar_width = " . $user_avatar_xsize . ", user_avatar_height = " . $user_avatar_ysize : '';
}


function user_avatar_upload($mode, $avatar_mode, &$current_avatar, &$current_type, &$error, &$error_msg, $avatar_filename, $avatar_realname, $avatar_filesize, $avatar_filetype)
{
	global $board_config, $db, $lang;

	$ini_val = ( @phpversion() >= '4.0.0' ) ? 'ini_get' : 'get_cfg_var';

	$width = $height = 0;
	$type = '';

	if ( $avatar_mode == 'remote' && preg_match('/^(http:\/\/)?([\w\-\.]+)\:?([0-9]*)\/(.*)$/', $avatar_filename, $url_ary) )
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

		unset($avatar_data);
		while( !@feof($fsock) )
		{
			$avatar_data .= @fread($fsock, $board_config['avatar_filesize']);
		}
		@fclose($fsock);

		if (!preg_match('#Content-Length\: ([0-9]+)[^ /][\s]+#i', $avatar_data, $file_data1) || !preg_match('#Content-Type\: image/[x\-]*([a-z]+)[\s]+#i', $avatar_data, $file_data2))
		{
			$error = true;
			$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $lang['File_no_data'] : $lang['File_no_data'];
			return;
		}

		$avatar_filesize = $file_data1[1]; 
		$avatar_filetype = $file_data2[1]; 

		if ( !$error && $avatar_filesize > 0 && $avatar_filesize < $board_config['avatar_filesize'] )
		{
			$avatar_data = substr($avatar_data, strlen($avatar_data) - $avatar_filesize, $avatar_filesize);

			$tmp_path = ( !@$ini_val('safe_mode') && !@$ini_val('open_basedir') ) ? '/tmp' : './' . $board_config['avatar_path'] . '/tmp';
			$tmp_filename = tempnam($tmp_path, uniqid(rand()) . '-');

			$fptr = @fopen($tmp_filename, 'wb');
			$bytes_written = @fwrite($fptr, $avatar_data, $avatar_filesize);
			@fclose($fptr);

			if ( $bytes_written != $avatar_filesize )
			{
				@unlink($tmp_filename);
				message_die(GENERAL_ERROR, 'Could not write avatar file to local storage. Please contact the board administrator with this message', '', __LINE__, __FILE__);
			}

			list($width, $height, $type) = @getimagesize($tmp_filename);
		}
		else
		{
			$l_avatar_size = sprintf($lang['Avatar_filesize'], round($board_config['avatar_filesize'] / 1024));

			$error = true;
			$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $l_avatar_size : $l_avatar_size;
		}
	}
	else if ( ( file_exists(@phpbb_realpath($avatar_filename)) ) && preg_match('/\.(jpg|jpeg|gif|png)$/i', $avatar_realname) )
	{
		if ( $avatar_filesize <= $board_config['avatar_filesize'] && $avatar_filesize > 0 )
		{
			preg_match('#image\/[x\-]*([a-z]+)#', $avatar_filetype, $avatar_filetype);
			$avatar_filetype = $avatar_filetype[1];
		}
		else
		{
			$l_avatar_size = sprintf($lang['Avatar_filesize'], round($board_config['avatar_filesize'] / 1024));

			$error = true;
			$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $l_avatar_size : $l_avatar_size;
			return;
		}

		list($width, $height, $type) = @getimagesize($avatar_filename);
	}

	if ( !($imgtype = check_image_type($avatar_filetype, $error, $error_msg)) )
	{
		return;
	}

	switch ($type)
	{
		// GIF
		case 1:
			if ($imgtype != '.gif')
			{
				@unlink($tmp_filename);
				message_die(GENERAL_ERROR, $lang['Avatar_filetype']);
			}
		break;

		// JPG, JPC, JP2, JPX, JB2
		case 2:
		case 9:
		case 10:
		case 11:
		case 12:
			if ($imgtype != '.jpg' && $imgtype != '.jpeg')
			{
				@unlink($tmp_filename);
				message_die(GENERAL_ERROR, $lang['Avatar_filetype']);
			}
		break;

		// PNG
		case 3:
			if ($imgtype != '.png')
			{
				@unlink($tmp_filename);
				message_die(GENERAL_ERROR, $lang['Avatar_filetype']);
			}
		break;

		default:
			@unlink($tmp_filename);
			if ( !$error_msg )
			{
				message_die(GENERAL_ERROR, 'Unable to upload file', '', __LINE__, __FILE__);
			}
	}

	if ( $width > 0 && $height > 0 && $width <= $board_config['avatar_max_width'] && $height <= $board_config['avatar_max_height'] )
	{
		$new_filename = uniqid(rand()) . $imgtype;

		if ( $mode == 'editprofile' && $current_type == USER_AVATAR_UPLOAD && $current_avatar != '' )
		{
			user_avatar_delete($current_type, $current_avatar);
		}

		if( $avatar_mode == 'remote' )
		{
			@copy($tmp_filename, './' . $board_config['avatar_path'] . "/$new_filename");
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

			if (!is_uploaded_file($avatar_filename))
			{
				message_die(GENERAL_ERROR, 'Unable to upload file', '', __LINE__, __FILE__);
			}
			$move_file($avatar_filename, './' . $board_config['avatar_path'] . "/$new_filename");
		}

		@chmod('./' . $board_config['avatar_path'] . "/$new_filename", 0777);

		$avatar_sql = ( $mode == 'editprofile' ) ? ", user_avatar = '$new_filename', user_avatar_type = " . USER_AVATAR_UPLOAD : "'$new_filename', " . USER_AVATAR_UPLOAD;
	}
	else
	{
		$l_avatar_size = sprintf($lang['Avatar_imagesize'], $board_config['avatar_max_width'], $board_config['avatar_max_height']);

		$error = true;
		$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $l_avatar_size : $l_avatar_size;
	}

	return $avatar_sql;
}

function display_avatar_gallery($mode, &$category, &$user_id, $email1, &$current_email, &$coppa, &$username, &$email, &$new_password, &$cur_password, &$password_confirm, &$icq, &$aim, &$msn, &$yim, &$website, &$location, &$optional_fields, &$optional_values, &$occupation, &$interests, &$gender, &$allowpm, &$user_ip_login_check, &$b_day, &$b_md, &$b_year, &$signature, &$user_sig_image, &$viewemail, &$viewaim, &$notifypm, &$user_notify_gg, &$popup_pm, &$icq2, &$notifyreply, &$attachsig, &$allowhtml, &$allowbbcode, &$allowsmilies, &$hideonline, &$style, &$language, &$timezone, &$custom_color, &$custom_rank, &$session_id, $verify_user)
{
	global $board_config, $db, $template, $lang, $images, $theme;
	global $phpbb_root_path, $phpEx;

	$my_counter = 0;
	$my_checker = 0;
	$sql = "SELECT user_avatar
		FROM " . USERS_TABLE . "
		WHERE user_avatar_type = 3";

	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query users', '', __LINE__, __FILE__, $sql);
	}

	while( $row = $db->sql_fetchrow($result) )
	{
		$my_counter++;
		$my_used_list[$my_counter] = $row['user_avatar'];
	}

	$db->sql_freeresult($result);

	$dir = @opendir($board_config['avatar_gallery_path']);

	$avatar_images = array();
	while( $file = @readdir($dir) )
	{
		if( $file != '.' && $file != '..' && !is_file($board_config['avatar_gallery_path'] . '/' . $file) && !is_link($board_config['avatar_gallery_path'] . '/' . $file) )
		{
			$sub_dir = @opendir($board_config['avatar_gallery_path'] . '/' . $file);

			$avatar_row_count = 0;
			$avatar_col_count = 0;
			while( $sub_file = @readdir($sub_dir) )
			{
				$my_checker = 0;
				for ($i = 1; $i<= $my_counter; $i++ )
				{
					$my_temp = $file . '/' . $sub_file;
					if ($my_temp == $my_used_list[$i]) $my_checker = 1;
					if ($my_checker == 1) break;
				}
				if ($my_checker == 0)
				{
					if( preg_match('/(\.gif$|\.png$|\.jpg|\.jpeg)$/is', $sub_file) )
					{
						$avatar_images[$file][$avatar_row_count][$avatar_col_count] = $sub_file; 
						$avatar_name[$file][$avatar_row_count][$avatar_col_count] = ucfirst(str_replace("_", " ", preg_replace('/^(.*)\..*$/', '\1', $sub_file)));

						$avatar_col_count++;
						if( $avatar_col_count == 5 )
						{
							$avatar_row_count++;
							$avatar_col_count = 0;
						}
					}
				}
			}
		}
	}

	@closedir($dir);

	@ksort($avatar_images);
	@reset($avatar_images);

	if( empty($category) )
	{
		list($category, ) = each($avatar_images);
	}
	@reset($avatar_images);

	$s_categories = '<select name="avatarcategory">';
	while( list($key) = each($avatar_images) )
	{
		$selected = ( $key == $category ) ? ' selected="selected"' : '';
		if( count($avatar_images[$key]) )
		{
			$s_categories .= '<option value="' . $key . '"' . $selected . '>' . ucfirst($key) . '</option>';
		}
	}
	$s_categories .= '</select>';

	$s_colspan = 0;
	for($i = 0; $i < count($avatar_images[$category]); $i++)
	{
		$template->assign_block_vars('avatar_row', array());

		$s_colspan = max($s_colspan, count($avatar_images[$category][$i]));

		for($j = 0; $j < count($avatar_images[$category][$i]); $j++)
		{
			$template->assign_block_vars('avatar_row.avatar_column', array(
				'AVATAR_IMAGE' => '<img src="' . $board_config['avatar_gallery_path'] . '/' . $category . '/' . $avatar_images[$category][$i][$j] . '" alt="' . $avatar_name[$category][$i][$j] . '" title="' . $avatar_name[$category][$i][$j] . '" />')
			);

			$template->assign_block_vars('avatar_row.avatar_option_column', array(
				'S_OPTIONS_AVATAR' => $avatar_images[$category][$i][$j])
			);
		}
	}

	$params = array('coppa', 'user_id', 'username', 'email1', 'current_email', 'cur_password', 'new_password', 'password_confirm', 'icq', 'aim', 'msn', 'yim', 'website', 'location', 'occupation', 'interests', 'gender', 'allowpm', 'user_ip_login_check', 'b_day', 'b_md', 'b_year', 'signature', 'user_sig_image', 'viewemail', 'viewaim', 'notifypm', 'user_notify_gg', 'popup_pm', 'user_icq', 'notifyreply', 'attachsig', 'allowhtml', 'allowbbcode', 'allowsmilies', 'hideonline', 'style', 'language', 'timezone', 'custom_color', 'custom_rank');

	$s_hidden_vars = '<input type="hidden" name="sid" value="' . $session_id . '" /><input type="hidden" name="agreed" value="true" /><input type="hidden" name="avatarcatname" value="' . $category . '" /><input type="hidden" name="verify_user" value="' . $verify_user . '" />';

	for($i = 0; $i < count($params); $i++)
	{
		$s_hidden_vars .= '<input type="hidden" name="' . $params[$i] . '" value="' . str_replace('"', '&quot;', $$params[$i]) . '" />';
	}
	for($i = 0; $i < count($optional_fields); $i++)
	{
		$s_hidden_vars .= '<input type="hidden" name="' . $optional_fields[$i] . '" value="' . str_replace('"', '&quot;', $optional_values[$i]) . '" />';
	}
	
	$template->assign_vars(array(
		'L_AVATAR_GALLERY' => $lang['Avatar_gallery'], 
		'L_SELECT_AVATAR' => $lang['Select_avatar'], 
		'L_RETURN_PROFILE' => $lang['Return_profile'], 
		'L_CATEGORY' => $lang['Select_category'], 

		'S_CATEGORY_SELECT' => $s_categories, 
		'S_COLSPAN' => $s_colspan, 
		'S_PROFILE_ACTION' => append_sid("profile.$phpEx?mode=$mode"), 
		'S_HIDDEN_FIELDS' => $s_hidden_vars)
	);

	return;
}

?>