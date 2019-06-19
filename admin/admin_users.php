<?php
/***************************************************************************
 *                              admin_users.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   modification         : (C) 2003 Przemo http://www.przemo.org
 *   date modification    : ver. 1.12.3 2004/05/30 21:50
 *
 *   $Id: admin_users.php,v 1.57.2.29 2005/10/30 15:17:13 acydburn Exp $
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
 ***************************************************************************/
define('MODULE_ID', 12);
define('IN_PHPBB', 1);

if ( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Users']['    '] = $filename; //Space for JuniorAdmins

	return;
}

if ( isset($HTTP_POST_VARS['mode']) && $HTTP_POST_VARS['mode'] == 'lookup')
{
	$no_page_header = true;
}

$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
require($phpbb_root_path . 'includes/bbcode.'.$phpEx);
require($phpbb_root_path . 'includes/functions_post.'.$phpEx);
require($phpbb_root_path . 'includes/functions_selects.'.$phpEx);
require($phpbb_root_path . 'includes/functions_validate.'.$phpEx);

if ( isset($HTTP_GET_VARS['sid']) || isset($HTTP_POST_VARS['sid']) )
{
	include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_customize.' . $phpEx);
	include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_profile.' . $phpEx);
}

$html_entities_match = array('#<#', '#>#');
$html_entities_replace = array('&lt;', '&gt;');
$checked = ' checked="checked"';

// Set mode
if ( isset( $HTTP_POST_VARS['mode'] ) || isset( $HTTP_GET_VARS['mode'] ) )
{
	$mode = ( isset( $HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
	$mode = xhtmlspecialchars($mode);
}
else
{
	$mode = '';
}


// Begin program

$custom_fields_exists = (custom_fields('check', '')) ? true : false;
if ( $custom_fields_exists )
{
	$custom_fields = custom_fields();
}

if ( $custom_fields_exists )
{
	for($i = 0; $i < count($custom_fields[0]); $i++)
	{
		$split_field[] = 'user_field_' . $custom_fields[0][$i];
		$split_allow_field[] = 'user_allow_field_' . $custom_fields[0][$i];
	}
}

if ( isset($HTTP_POST_VARS['jr']) )
{
	$sql = "SELECT user_id
		FROM " . USERS_TABLE . "
		WHERE username = '" . str_replace("\'", "''", $HTTP_POST_VARS['username']) . "'";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not query user information", "", __LINE__, __FILE__, $sql);
	}
	if ( !($row = $db->sql_fetchrow($result)) )
	{
		message_die(GENERAL_ERROR, $lang['No_user_id_specified']);
	}
	$user_id = $row['user_id'];

	print '<meta http-equiv="refresh" content="0;url=' . append_sid("admin_jr_admin.$phpEx?user_id=$user_id", true) . '">';
	exit;
}
if ( isset($HTTP_POST_VARS['authuser']) )
{
	$username = $HTTP_POST_VARS['username'];
	print '<meta http-equiv="refresh" content="0;url=' . append_sid("admin_ug_auth.$phpEx?mode=user&amp;username=$username", true) . '">';
	exit;
}

if ( empty($HTTP_POST_VARS['authuser']) && $mode == 'edit' || $mode == 'save' && ( isset($HTTP_POST_VARS['username']) || isset($HTTP_GET_VARS[POST_USERS_URL]) || isset( $HTTP_POST_VARS[POST_USERS_URL]) ) )
{
	if ( defined('ATTACHMENTS_ON') )
	{
		attachment_quota_settings('user', $HTTP_POST_VARS['submit'], $mode);
	}

	// Ok, the profile has been modified and submitted, let's update
	if ( ( $mode == 'save' && isset( $HTTP_POST_VARS['submit'] ) ) || isset( $HTTP_POST_VARS['avatargallery'] ) || isset( $HTTP_POST_VARS['submitavatar'] ) || isset( $HTTP_POST_VARS['cancelavatar'] ) )
	{
		$user_id = intval( $HTTP_POST_VARS['id'] );

		if (!($this_userdata = get_userdata($user_id)))
		{
			message_die(GENERAL_MESSAGE, $lang['No_user_id_specified'] );
		}

		$username = ( !empty($HTTP_POST_VARS['username']) ) ? phpbb_clean_username($HTTP_POST_VARS['username']) : '';
		$email = ( !empty($HTTP_POST_VARS['email']) ) ? trim(strip_tags(xhtmlspecialchars( $HTTP_POST_VARS['email'] ) )) : '';

		$password = ( !empty($HTTP_POST_VARS['password']) ) ? trim(strip_tags(xhtmlspecialchars( $HTTP_POST_VARS['password'] ) )) : '';
		$password_confirm = ( !empty($HTTP_POST_VARS['password_confirm']) ) ? trim(strip_tags(xhtmlspecialchars( $HTTP_POST_VARS['password_confirm'] ) )) : '';

		$icq = ( !empty($HTTP_POST_VARS['icq']) ) ? trim(strip_tags( $HTTP_POST_VARS['icq'] ) ) : '';
		$aim = ( !empty($HTTP_POST_VARS['aim']) ) ? trim(strip_tags( $HTTP_POST_VARS['aim'] ) ) : '';
		$msn = ( !empty($HTTP_POST_VARS['msn']) ) ? trim(strip_tags( $HTTP_POST_VARS['msn'] ) ) : '';
		$yim = ( !empty($HTTP_POST_VARS['yim']) ) ? trim(strip_tags( $HTTP_POST_VARS['yim'] ) ) : '';

		$website = ( !empty($HTTP_POST_VARS['website']) ) ? trim(strip_tags( $HTTP_POST_VARS['website'] ) ) : '';
		$location = ( !empty($HTTP_POST_VARS['location']) ) ? trim(strip_tags( $HTTP_POST_VARS['location'] ) ) : '';
		$occupation = ( !empty($HTTP_POST_VARS['occupation']) ) ? trim(strip_tags( $HTTP_POST_VARS['occupation'] ) ) : '';
		$interests = ( !empty($HTTP_POST_VARS['interests']) ) ? trim(strip_tags( $HTTP_POST_VARS['interests'] ) ) : '';
		$gender = ( isset($HTTP_POST_VARS['gender']) ) ? $HTTP_POST_VARS['gender'] : 0;
		$custom_color = ( !empty($HTTP_POST_VARS['custom_color']) ) ? trim(strip_tags( $HTTP_POST_VARS['custom_color'] ) ) : '';
		$custom_rank = ( !empty($HTTP_POST_VARS['custom_rank']) ) ? trim(strip_tags( $HTTP_POST_VARS['custom_rank'] ) ) : '';
		$signature = ( !empty($HTTP_POST_VARS['signature']) ) ? trim(str_replace('<br />', "\n", $HTTP_POST_VARS['signature'] ) ) : '';

		validate_optional_fields($icq, $aim, $msn, $yim, $website, $location, $occupation, $interests, $custom_color, $custom_rank, $signature);

		if ( $custom_fields_exists )
		{
			for($i = 0; $i < count($custom_fields[0]); $i++)
			{
				$$split_field[$i] = ( !empty($HTTP_POST_VARS[$split_field[$i]]) ) ? trim(strip_tags( $HTTP_POST_VARS[$split_field[$i]] ) ) : '';
				$$split_allow_field[$i] = ( isset( $HTTP_POST_VARS[$split_allow_field[$i]]) ) ? ( ( $HTTP_POST_VARS[$split_allow_field[$i]] ) ? TRUE : 0 ) : TRUE;
			}
		}

		$viewemail = ( isset( $HTTP_POST_VARS['viewemail']) ) ? ( ( $HTTP_POST_VARS['viewemail'] ) ? TRUE : 0 ) : 1;
		$viewaim = ( isset( $HTTP_POST_VARS['viewaim']) ) ? ( ( $HTTP_POST_VARS['viewaim'] ) ? TRUE : 0 ) : 1;
		$allowviewonline = ( isset( $HTTP_POST_VARS['hideonline']) ) ? ( ( $HTTP_POST_VARS['hideonline'] ) ? 0 : TRUE ) : TRUE;
		$notifyreply = ( isset( $HTTP_POST_VARS['notifyreply']) ) ? ( ( $HTTP_POST_VARS['notifyreply'] ) ? TRUE : 0 ) : 0;
		$user_ip_login_check = ( isset( $HTTP_POST_VARS['user_ip_login_check']) ) ? ( ( $HTTP_POST_VARS['user_ip_login_check'] ) ? 1 : 0 ) : 1;
		$notifypm = ( isset( $HTTP_POST_VARS['notifypm']) ) ? ( ( $HTTP_POST_VARS['notifypm'] ) ? TRUE : 0 ) : TRUE;
		$popuppm = ( isset( $HTTP_POST_VARS['popup_pm']) ) ? ( ( $HTTP_POST_VARS['popup_pm'] ) ? TRUE : 0 ) : TRUE;
		$allowpm = ( isset( $HTTP_POST_VARS['allowpm']) ) ? ( ( $HTTP_POST_VARS['allowpm'] ) ? TRUE : 0 ) : TRUE;
		$user_notify_gg = ( isset( $HTTP_POST_VARS['user_notify_gg']) ) ? ( ( $HTTP_POST_VARS['user_notify_gg'] ) ? TRUE : 0 ) : TRUE;
		$attachsig = ( isset( $HTTP_POST_VARS['attachsig']) ) ? ( ( $HTTP_POST_VARS['attachsig'] ) ? TRUE : 0 ) : 0;
		$allowhtml = ( isset( $HTTP_POST_VARS['allowhtml']) ) ? intval( $HTTP_POST_VARS['allowhtml'] ) : $board_config['allow_html'];
		$allowbbcode = ( isset( $HTTP_POST_VARS['allowbbcode']) ) ? intval( $HTTP_POST_VARS['allowbbcode'] ) : $board_config['allow_bbcode'];
		$allowsmilies = ( isset( $HTTP_POST_VARS['allowsmilies']) ) ? intval( $HTTP_POST_VARS['allowsmilies'] ) : $board_config['allow_smilies'];
		$user_style = ( $HTTP_POST_VARS['style'] ) ? intval( $HTTP_POST_VARS['style'] ) : $board_config['default_style'];
		$user_lang = ( $HTTP_POST_VARS['language'] ) ? $HTTP_POST_VARS['language'] : $board_config['default_lang'];
		$user_timezone = ( isset( $HTTP_POST_VARS['timezone']) ) ? doubleval( $HTTP_POST_VARS['timezone'] ) : $board_config['board_timezone'];
		$user_template = ( $HTTP_POST_VARS['template'] ) ? $HTTP_POST_VARS['template'] : $board_config['board_template'];
		$allow_sig = ( isset($HTTP_POST_VARS['allow_sig']) ) ? intval($HTTP_POST_VARS['allow_sig']) : 0;
		$allow_sig_image = ( isset($HTTP_POST_VARS['allow_sig_image']) ) ? intval($HTTP_POST_VARS['allow_sig_image']) : 0;
		$user_sig_image_upload = ( !empty($HTTP_POST_VARS['sig_image_url']) ) ? trim($HTTP_POST_VARS['sig_image_url']) : ( ( $HTTP_POST_FILES['sig_image']['tmp_name'] != 'none') ? $HTTP_POST_FILES['sig_image']['tmp_name'] : '' );
		$user_sig_image_name = ( !empty($HTTP_POST_FILES['sig_image']['name']) ) ? $HTTP_POST_FILES['sig_image']['name'] : '';
		$user_sig_image_size = ( !empty($HTTP_POST_FILES['sig_image']['size']) ) ? $HTTP_POST_FILES['sig_image']['size'] : 0;
		$user_sig_image_type = ( !empty($HTTP_POST_FILES['sig_image']['type']) ) ? $HTTP_POST_FILES['sig_image']['type'] : '';
		$user_sig_image = ( empty($user_sig_image_upload) ) ? $this_userdata['user_sig_image'] : '';
		$user_avatar_local = ( isset( $HTTP_POST_VARS['avatarselect'] ) && !empty($HTTP_POST_VARS['submitavatar'] ) && $board_config['allow_avatar_local'] ) ? $HTTP_POST_VARS['avatarselect'] : ( ( isset( $HTTP_POST_VARS['avatarlocal'] ) ) ? $HTTP_POST_VARS['avatarlocal'] : '' );
		$user_avatar_category = ( isset($HTTP_POST_VARS['avatarcatname']) && $board_config['allow_avatar_local'] ) ? xhtmlspecialchars($HTTP_POST_VARS['avatarcatname']) : '' ;
		$user_avatar_remoteurl = ( !empty($HTTP_POST_VARS['avatarremoteurl']) ) ? trim( $HTTP_POST_VARS['avatarremoteurl'] ) : '';
		$user_avatar_url = ( !empty($HTTP_POST_VARS['avatarurl']) ) ? trim( $HTTP_POST_VARS['avatarurl'] ) : '';
		$user_avatar_loc = ( $HTTP_POST_FILES['avatar']['tmp_name'] != 'none') ? $HTTP_POST_FILES['avatar']['tmp_name'] : '';
		$user_avatar_name = ( !empty($HTTP_POST_FILES['avatar']['name']) ) ? $HTTP_POST_FILES['avatar']['name'] : '';
		$user_avatar_size = ( !empty($HTTP_POST_FILES['avatar']['size']) ) ? $HTTP_POST_FILES['avatar']['size'] : 0;
		$user_avatar_filetype = ( !empty($HTTP_POST_FILES['avatar']['type']) ) ? $HTTP_POST_FILES['avatar']['type'] : '';
		$user_avatar = ( empty($user_avatar_loc) ) ? $this_userdata['user_avatar'] : '';
		$user_avatar_type = ( empty($user_avatar_loc) ) ? $this_userdata['user_avatar_type'] : '';
		$user_status = ( !empty($HTTP_POST_VARS['user_status']) ) ? intval( $HTTP_POST_VARS['user_status'] ) : 0;
		$user_allowpm = ( !empty($HTTP_POST_VARS['user_allowpm']) ) ? intval( $HTTP_POST_VARS['user_allowpm'] ) : 0;
		$user_rank = ( !empty($HTTP_POST_VARS['user_rank']) ) ? intval( $HTTP_POST_VARS['user_rank'] ) : 0;
		$user_allowavatar = ( !empty($HTTP_POST_VARS['user_allowavatar']) ) ? intval( $HTTP_POST_VARS['user_allowavatar'] ) : 0;
		$user_allowsig = ( !empty($HTTP_POST_VARS['user_allowsig']) ) ? intval( $HTTP_POST_VARS['user_allowsig'] ) : 0;
		$can_custom_ranks = ( !empty($HTTP_POST_VARS['can_custom_ranks']) ) ? intval( $HTTP_POST_VARS['can_custom_ranks'] ) : 0;
		$can_custom_color = ( !empty($HTTP_POST_VARS['can_custom_color']) ) ? intval( $HTTP_POST_VARS['can_custom_color'] ) : 0;
		$disallow_forums = ( !empty($HTTP_POST_VARS['disallow_forums']) ) ? $HTTP_POST_VARS['disallow_forums'] : '';
		$can_topic_color = ( !empty($HTTP_POST_VARS['can_topic_color']) ) ? intval( $HTTP_POST_VARS['can_topic_color'] ) : 0;
		$user_allow_helped = ( !empty($HTTP_POST_VARS['user_allow_helped']) ) ? intval( $HTTP_POST_VARS['user_allow_helped'] ) : 0;

		if ( isset( $HTTP_POST_VARS['avatargallery'] ) || isset( $HTTP_POST_VARS['submitavatar'] ) || isset( $HTTP_POST_VARS['cancelavatar'] ) )
		{
			$username = stripslashes($username);
			$email = stripslashes($email);
			$password = '';
			$password_confirm = '';
			$icq = stripslashes($icq);
			$aim = xhtmlspecialchars(stripslashes($aim));
			$msn = xhtmlspecialchars(stripslashes($msn));
			$yim = xhtmlspecialchars(stripslashes($yim));

			$website = xhtmlspecialchars(stripslashes($website));
			$location = xhtmlspecialchars(stripslashes($location));
			$occupation = xhtmlspecialchars(stripslashes($occupation));
			$interests = xhtmlspecialchars(stripslashes($interests));
			$signature = xhtmlspecialchars(stripslashes($signature));

			$custom_color = xhtmlspecialchars(stripslashes($custom_color));
			$custom_rank = xhtmlspecialchars(stripslashes($custom_rank));
			$user_lang = stripslashes($user_lang);

			if ( !isset($HTTP_POST_VARS['cancelavatar']) ) 
			{
				$user_avatar = $user_avatar_category . '/' . $user_avatar_local;
				$user_avatar_type = USER_AVATAR_GALLERY;
			}

			if ( $custom_fields_exists )
			{
				for($i = 0; $i < count($custom_fields[0]); $i++)
				{
					$$split_field[$i] = stripslashes($$split_field[$i]);
				}
			}
		}
	}

	if ( isset( $HTTP_POST_VARS['submit'] ) )
	{
		include($phpbb_root_path . 'includes/usercp_avatar.'.$phpEx);
		include($phpbb_root_path . 'includes/usercp_signature.'.$phpEx);

		$error = FALSE;

		if (stripslashes($username) != $this_userdata['username'])
		{
			unset($rename_user);

			if ( stripslashes(strtolower($username)) != strtolower($this_userdata['username']) ) 
			{
				$result = validate_username($username);
				if ( $result['error'] )
				{
					$error = TRUE;
					$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $result['error_msg'];
				}
				else if ( strtolower(str_replace("\\'", "''", $username)) == strtolower($userdata['username']) )
				{
					$error = TRUE;
					$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Username_taken'];
				}
			}

			if (!$error)
			{
				$username_sql = "username = '" . str_replace("\\'", "''", $username) . "', ";
				$rename_user = $username; // Used for renaming usergroup
			}
		}

		$passwd_sql = '';
		if ( !empty($password) && !empty($password_confirm) )
		{
			// Awww, the user wants to change their password, isn't that cute..
			if ( $password != $password_confirm )
			{
				$error = TRUE;
				$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Password_mismatch'];
			}
			else
			{
				$password = phpbb_hash($password);
				$passwd_sql = "user_password = '$password', ";
			}
		}
		else if ( $password && !$password_confirm )
		{
			$error = TRUE;
			$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Password_mismatch'];
		}
		else if ( !$password && $password_confirm )
		{
			$error = TRUE;
			$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Password_mismatch'];
		}

		// Signature stuff
		$signature_sql = '';
		if ( isset ($HTTP_POST_VARS['sig_image_del']) )
		{
			if ( @file_exists(@phpbb_realpath('./../' . $board_config['sig_images_path'] . '/' . $this_userdata['user_sig_image'])) )
			{
				@unlink('./../' . $board_config['sig_images_path'] . '/' . $this_userdata['user_sig_image']);
			}

			$signature_sql = ", user_sig_image = ''";
		}

		if ( ( !empty($user_sig_image_upload) || !empty($user_sig_image_name) ) && $board_config['allow_sig'] && $board_config['allow_sig_image'] )
		{
			if ( !empty($user_sig_image_upload) )
			{
				$sig_image_mode = ( !empty($user_sig_image_name) ) ? 'local' : 'remote';
				$ini_val = ( @phpversion() >= '4.0.0' ) ? 'ini_get' : 'get_cfg_var';

				if ( $sig_image_mode == 'remote' && preg_match('/^(http:\/\/)?([\w\-\.]+)\:?([0-9]*)\/(.*)$/', $user_sig_image_upload, $url_ary) )
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

						$tmp_path = ( !@$ini_val('safe_mode') && !@$ini_val('open_basedir') ) ? '/tmp' : './../' . $board_config['sig_images_path'] . '/tmp';
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
				else if ( ( file_exists(@phpbb_realpath($user_sig_image_upload)) ) && preg_match('/\.(jpg|jpeg|gif|png)$/i', $user_sig_image_name) )
				{
					if ( $user_sig_image_size <= $board_config['sig_image_filesize'] && $user_sig_image_size > 0 )
					{
						preg_match('#image\/[x\-]*([a-z]+)#', $user_sig_image_type, $user_sig_image_type);
						$user_sig_image_type = $user_sig_image_type[1];
					}
					else
					{
						$l_signature_size = sprintf($lang['Avatar_filesize'], round($board_config['sig_image_filesize'] / 1024));

						$error = true;
						$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $l_signature_size : $l_signature_size;
						return;
					}

					list($width, $height) = @getimagesize($user_sig_image_upload);
				}

				if ( $user_sig_image_type != '' )
				{
					switch( $user_sig_image_type )
					{
						case 'image/jpeg':
						case 'image/jpg':
						case 'jpeg':
						case 'pjpeg':
						case 'jpg':
							$imgtype = '.jpg';
							break;

						case 'image/gif':
						case 'gif':
							$imgtype = '.gif';
							break;

						case 'image/png':
						case 'image/x-png':
						case 'png':
							$imgtype = '.png';
							break;

						default:
							$error = true;
							$error_msg = (!empty($error_msg)) ? $error_msg . '<br />' . $lang['Avatar_filetype'] : $lang['Avatar_filetype'];
							break;
					}
				}
				else if ( $signature_filetype != '' )
				{
					switch( $signature_filetype )
					{
						case 'image/jpeg':
						case 'image/jpg':
						case 'jpeg':
						case 'pjpeg':
						case 'jpg':
							$imgtype = '.jpg';
							break;

						case 'image/gif':
						case 'gif':
							$imgtype = '.gif';
							break;

						case 'image/png':
						case 'image/x-png':
						case 'png':
							$imgtype = '.png';
							break;

						default:
							$error = true;
							$error_msg = (!empty($error_msg)) ? $error_msg . '<br />' . $lang['Avatar_filetype'] : $lang['Avatar_filetype'];
							break;
					}
				}

				if ( $width <= $board_config['sig_image_max_width'] && $height <= $board_config['sig_image_max_height'] )
				{
					$new_filename = uniqid(rand()) . $imgtype;

					if ( $this_userdata['user_sig_image'] != '' )
					{
						if ( file_exists(@phpbb_realpath('./../' . $board_config['sig_images_path'] . '/' . $this_userdata['user_sig_image'])) )
						{
							@unlink('./../' . $board_config['sig_images_path'] . '/' . $this_userdata['user_sig_image']);
						}
					}

					if ( $sig_image_mode == 'remote' )
					{
						@copy($tmp_filename, './../' . $board_config['sig_images_path'] . '/' . $new_filename);
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

						$move_file($user_sig_image_upload, './../' . $board_config['sig_images_path'] . '/' . $new_filename);
					}

					@chmod('./../' . $board_config['sig_images_path'] . '/' . $new_filename, 0777);

					$signature_sql = ", user_sig_image = '$new_filename'";
				}
				else
				{
					$l_signature_size = sprintf($lang['Avatar_imagesize'], $board_config['sig_image_max_width'], $board_config['sig_image_max_height']);

					$error = true;
					$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $l_signature_size : $l_signature_size;
				}
			}
			else if ( !empty($user_sig_image_name) )
			{
				$l_sig_image_size = sprintf($lang['Avatar_filesize'], round($board_config['sig_image_filesize'] / 1024));

				$error = true;
				$error_msg .= ( ( !empty($error_msg) ) ? '<br />' : '' ) . $l_sig_image_size;
			}
		}

		if ( $signature != '' )
		{
			$sig_length_check = preg_replace('/(\[.*?)(=.*?)\]/is', '\\1]', stripslashes($signature));
			if ( $allowhtml )
			{
				$sig_length_check = preg_replace('/(\<.*?)(=.*?)( .*?=.*?)?([ \/]?\>)/is', '\\1\\3\\4', $sig_length_check);
			}

			$signature = ($board_config['allow_sig_image_img']) ? preg_replace ("#\[img\](.*)\[/img\]#si", "\\1", $signature) : $signature;

			// Only create a new bbcode_uid when there was no uid yet.
			if ( $signature_bbcode_uid == '' )
			{
				$signature_bbcode_uid = ( $allowbbcode ) ? make_bbcode_uid() : '';
			}
			$signature = prepare_message($signature, $allowhtml, $allowbbcode, $allowsmilies, $signature_bbcode_uid);

			$max_sig_chars_admin = ($board_config['max_sig_chars_admin'] > 1) ? $board_config['max_sig_chars_admin'] : 1;
			if ( strlen($sig_length_check) > ( $board_config['max_sig_chars'] * $max_sig_chars_admin ) )
			{ 
				$error = TRUE;
				$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Signature_too_long'];
			}
		}

		// Avatar stuff
		$avatar_sql = '';
		if ( isset($HTTP_POST_VARS['avatardel']) )
		{
			if ( $this_userdata['user_avatar_type'] == USER_AVATAR_UPLOAD && $this_userdata['user_avatar'] != '' )
			{
				if( @file_exists(@phpbb_realpath('./../' . $board_config['avatar_path'] . "/" . $this_userdata['user_avatar'])) )
				{
					@unlink('./../' . $board_config['avatar_path'] . "/" . $this_userdata['user_avatar']);
				}
			}
			$avatar_sql = ", user_avatar = '', user_avatar_type = " . USER_AVATAR_NONE;
		}
		else if ( ( $user_avatar_loc != '' || !empty($user_avatar_url) ) && !$error )
		{
			// Only allow one type of upload, either a
			// filename or a URL
			if ( !empty($user_avatar_loc) && !empty($user_avatar_url) )
			{
				$error = TRUE;
				if ( isset($error_msg) )
				{
					$error_msg .= '<br />';
				}
				$error_msg .= $lang['Only_one_avatar'];
			}

			if ( $user_avatar_loc != '' )
			{
				if( file_exists(@phpbb_realpath($user_avatar_loc)) && preg_match('/(\.jpg|\.gif|\.png)$/', $user_avatar_name) )
				{
					if ( $user_avatar_size <= $board_config['avatar_filesize'] && $user_avatar_size > 0)
					{
						$error_type = false;

						// Opera appends the image name after the type, not big, not clever!
						preg_match("'image\/[x\-]*([a-z]+)'", $user_avatar_filetype, $user_avatar_filetype);
						$user_avatar_filetype = $user_avatar_filetype[1];

						switch( $user_avatar_filetype )
						{
							case 'image/jpeg':
							case 'image/jpg':
							case 'jpeg':
							case 'pjpeg':
							case 'jpg':
								$imgtype = '.jpg';
								break;

							case 'image/gif':
							case 'gif':
								$imgtype = '.gif';
								break;

							case 'image/png':
							case 'image/x-png':
							case 'png':
								$imgtype = '.png';
								break;

							default:
								$error = true;
								$error_msg = (!empty($error_msg)) ? $error_msg . '<br />' . $lang['Avatar_filetype'] : $lang['Avatar_filetype'];
								break;
						}

						if ( !$error )
						{
							list($width, $height) = @getimagesize($user_avatar_loc);

							if ( $width <= $board_config['avatar_max_width'] && $height <= $board_config['avatar_max_height'] )
							{
								$user_id = $this_userdata['user_id'];

								$avatar_filename = $user_id . $imgtype;

								if ( $this_userdata['user_avatar_type'] == USER_AVATAR_UPLOAD && $this_userdata['user_avatar'] != '' )
								{
									if( @file_exists(@phpbb_realpath("./../" . $board_config['avatar_path'] . "/" . $this_userdata['user_avatar'])) )
									{
										@unlink('./../' . $board_config['avatar_path'] . '/'. $this_userdata['user_avatar']);
									}
								}
								@copy($user_avatar_loc, './../' . $board_config['avatar_path'] . '/' . $avatar_filename);

								$avatar_sql = ", user_avatar = '$avatar_filename', user_avatar_type = " . USER_AVATAR_UPLOAD;
							}
							else
							{
								$l_avatar_size = sprintf($lang['Avatar_imagesize'], $board_config['avatar_max_width'], $board_config['avatar_max_height']);

								$error = true;
								$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $l_avatar_size : $l_avatar_size;
							}
						}
					}
					else
					{
						$l_avatar_size = sprintf($lang['Avatar_filesize'], round($board_config['avatar_filesize'] / 1024));

						$error = true;
						$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $l_avatar_size : $l_avatar_size;
					}
				}
				else
				{
					$error = true;
					$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $lang['Avatar_filetype'] : $lang['Avatar_filetype'];
				}
			}
			else if ( !empty($user_avatar_url) )
			{
				// First check what port we should connect
				// to, look for a :[xxxx]/ or, if that doesn't
				// exist assume port 80 (http)
				preg_match("/^(http:\/\/)?([\w\-\.]+)\:?([0-9]*)\/(.*)$/", $user_avatar_url, $url_ary);

				if ( !empty($url_ary[4]) )
				{
					$port = (!empty($url_ary[3])) ? $url_ary[3] : 80;

					$fsock = @fsockopen($url_ary[2], $port, $errno, $errstr);
					if ( $fsock )
					{
						$base_get = '/' . $url_ary[4];

						// Uses HTTP 1.1, could use HTTP 1.0 ...
						@fputs($fsock, "GET $base_get HTTP/1.1\r\n");
						@fputs($fsock, "HOST: " . $url_ary[2] . "\r\n");
						@fputs($fsock, "Connection: close\r\n\r\n");

						unset($avatar_data);
						while( !@feof($fsock) )
						{
							$avatar_data .= @fread($fsock, $board_config['avatar_filesize']);
						}
						@fclose($fsock);

						if ( preg_match("/Content-Length\: ([0-9]+)[^\/ ][\s]+/i", $avatar_data, $file_data1) && preg_match("/Content-Type\: image\/[x\-]*([a-z]+)[\s]+/i", $avatar_data, $file_data2) )
						{
							$file_size = $file_data1[1];
							$file_type = $file_data2[1];

							switch( $file_type )
							{
								case 'image/jpeg':
								case 'image/jpg':
								case 'jpeg':
								case 'pjpeg':
								case 'jpg':
									$imgtype = '.jpg';
									break;

								case 'image/gif':
								case 'gif':
									$imgtype = '.gif';
									break;

								case 'image/png':
								case 'image/x-png':
								case 'png':
									$imgtype = '.png';
									break;
								default:
									$error = true;
									$error_msg = (!empty($error_msg)) ? $error_msg . '<br />' . $lang['Avatar_filetype'] : $lang['Avatar_filetype'];
									break;
							}

							if ( !$error && $file_size > 0 && $file_size < $board_config['avatar_filesize'] )
							{
								$avatar_data = substr($avatar_data, strlen($avatar_data) - $file_size, $file_size);

								$tmp_filename = tempnam ('/tmp', $this_userdata['user_id'] . '-');
								$fptr = @fopen($tmp_filename, 'wb');
								$bytes_written = @fwrite($fptr, $avatar_data, $file_size);
								@fclose($fptr);

								if ( $bytes_written == $file_size )
								{
									list($width, $height) = @getimagesize($tmp_filename);

									if ( $width <= $board_config['avatar_max_width'] && $height <= $board_config['avatar_max_height'] )
									{
										$user_id = $this_userdata['user_id'];

										$avatar_filename = $user_id . $imgtype;

										if ( $this_userdata['user_avatar_type'] == USER_AVATAR_UPLOAD && $this_userdata['user_avatar'] != '')
										{
											if( file_exists(@phpbb_realpath("./../" . $board_config['avatar_path'] . "/" . $this_userdata['user_avatar'])) )
											{
												@unlink('./../' . $board_config['avatar_path'] . '/' . $this_userdata['user_avatar']);
											}
										}
										@copy($tmp_filename, './../' . $board_config['avatar_path'] . '/' . $avatar_filename);
										@unlink($tmp_filename);

										$avatar_sql = ", user_avatar = '$avatar_filename', user_avatar_type = " . USER_AVATAR_UPLOAD;
									}
									else
									{
										$l_avatar_size = sprintf($lang['Avatar_imagesize'], $board_config['avatar_max_width'], $board_config['avatar_max_height']);

										$error = true;
										$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $l_avatar_size : $l_avatar_size;
									}
								}
								else
								{
									// Error writing file
									@unlink($tmp_filename);
									message_die(GENERAL_ERROR, 'Could not write avatar file to local storage. Please contact the board administrator with this message', '', __LINE__, __FILE__);
								}
							}
						}
						else
						{
							// No data
							$error = true;
							$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $lang['File_no_data'] : $lang['File_no_data'];
						}
					}
					else
					{
						// No connection
						$error = true;
						$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $lang['No_connection_URL'] : $lang['No_connection_URL'];
					}
				}
				else
				{
					$error = true;
					$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $lang['Incomplete_URL'] : $lang['Incomplete_URL'];
				}
			}
			else if ( !empty($user_avatar_name) )
			{
				$l_avatar_size = sprintf($lang['Avatar_filesize'], round($board_config['avatar_filesize'] / 1024));

				$error = true;
				$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $l_avatar_size : $l_avatar_size;
			}
		}
		else if ( $user_avatar_remoteurl != '' && $avatar_sql == '' && !$error )
		{
			if ( !preg_match("#^http:\/\/#i", $user_avatar_remoteurl) )
			{
				$user_avatar_remoteurl = 'http://' . $user_avatar_remoteurl;
			}

			if ( preg_match("#^(http:\/\/[a-z0-9\-]+?\.([a-z0-9\-]+\.)*[a-z]+\/.*?\.(gif|jpg|png)$)#is", $user_avatar_remoteurl) )
			{
				$avatar_sql = ", user_avatar = '" . str_replace("\'", "''", $user_avatar_remoteurl) . "', user_avatar_type = " . USER_AVATAR_REMOTE;
			}
			else
			{
				$error = true;
				$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $lang['Wrong_remote_avatar_format'] : $lang['Wrong_remote_avatar_format'];
			}

			$user_avatar_dimensions = GetImageSize($user_avatar_remoteurl);
			if ( $user_avatar_dimensions == NULL )
			{
				$user_avatar_xsize = 0; // Remote avatar not found, zero
				$user_avatar_ysize = 0;
			}
			else
			{
				// Check avatar dimensions, adjust if necessary
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

				if ( $user_avatar_xsize > $board_config['avatar_max_width'] ) // width exceeds max
				{
					$user_avatar_ratio = $board_config['avatar_max_width'] / $user_avatar_xsize;
					$user_avatar_xsize = $user_avatar_xsize * $user_avatar_ratio;
					$user_avatar_ysize = $user_avatar_ysize * $user_avatar_ratio;
				}

				if ( $user_avatar_ysize > $board_config['avatar_max_height'] ) // height exceeds max
				{
					$user_avatar_ratio = $board_config['avatar_max_height'] / $user_avatar_ysize;
					$user_avatar_xsize = $user_avatar_xsize * $user_avatar_ratio;
					$user_avatar_ysize = $user_avatar_ysize * $user_avatar_ratio;
				}
			}
			$avatar_sql = ", user_avatar = '" . str_replace("\'", "''", $user_avatar_remoteurl) . "', user_avatar_type = " . USER_AVATAR_REMOTE . ", user_avatar_width = " . $user_avatar_xsize . ", user_avatar_height = " . $user_avatar_ysize;

		}
		else if( $user_avatar_local != "" && $avatar_sql == "" && !$error )
		{
			$avatar_sql = ", user_avatar = '" . str_replace("\'", "''", phpbb_ltrim(basename($user_avatar_category), "'") . '/' . phpbb_ltrim(basename($user_avatar_local), "'")) . "', user_avatar_type = " . USER_AVATAR_GALLERY;
		}
	
		if ( !$error )
		{
			if( $HTTP_POST_VARS['deleteuser'] )
			{
				if ( $userdata['user_id'] == $user_id || ($userdata['user_level'] != ADMIN && $this_userdata['user_level'] != USER) )
				{
					message_die(GENERAL_MESSAGE, $lang['Not_Authorised']);
				}

				require($phpbb_root_path . 'includes/functions_remove.'.$phpEx);
				delete_user($user_id);
				$message = $lang['User_deleted'];
			}
			else
			{
				if ( $HTTP_POST_VARS['block_account'] )
				{
					$sql = "UPDATE " . USERS_TABLE . " SET 
						user_blocktime = '" . (CR_TIME + $board_config['block_time'] * 60) . "', user_block_by = '$user_ip'
						WHERE user_id = $user_id";
					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not block user', '', __LINE__, __FILE__, $sql);
					}

					$sql = "UPDATE " . SESSIONS_TABLE . "
						SET session_logged_in = '0'
							WHERE session_user_id = $user_id";
					if ( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, 'Couldn\'t update blocked sessions from database', '', __LINE__, __FILE__, $sql);
					}
	
				}
				else if ( $HTTP_POST_VARS['unblock_account'] )
				{
					$sql = "UPDATE " . USERS_TABLE . "
						SET user_blocktime = '0', user_badlogin = '0'
						WHERE user_id = $user_id";
					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not unblock user', '', __LINE__, __FILE__, $sql);
					}
				}

				$sql_custom_fields = ', ';
				if ( $custom_fields_exists )
				{
					for($i = 0; $i < count($custom_fields[0]); $i++)
					{
						$sql_custom_fields .= $split_field[$i] . ' = \'' . str_replace("\'", "''", $$split_field[$i]) . '\', ' . $split_allow_field[$i] . ' = ' . $$split_allow_field[$i] . ', ';
					}
				}

				$reset_act_key = (!$this_userdata['user_active'] && $user_status) ? ", user_actkey = ''" : '';

				$disallow_forums_sql = '';
				if ( is_array($disallow_forums) )
				{
					for($i = 0; $i < count($disallow_forums); $i++)
					{
						if ( $disallow_forums[$i]{0} == POST_FORUM_URL )
						{
							$disallow_forums_sql .= (($disallow_forums_sql) ? ', ' : '') . substr($disallow_forums[$i], 1);
						}
					}
				}

				$sql = "UPDATE " . USERS_TABLE . "
					SET " . $username_sql . $passwd_sql . "user_email = '" . str_replace("\'", "''", $email) . "', user_icq = '" . str_replace("\'", "''", $icq) . "', user_website = '" . str_replace("\'", "''", $website) . "', user_occ = '" . str_replace("\'", "''", $occupation) . "', user_from = '" . str_replace("\'", "''", $location) . "' $sql_custom_fields user_interests = '" . str_replace("\'", "''", $interests) . "', user_custom_color = '" . str_replace("\'", "''", $custom_color) . "', user_custom_rank = '" . str_replace("\'", "''", $custom_rank) . "', user_sig = '" . str_replace("\'", "''", $signature) . "', user_viewemail = $viewemail, user_viewaim = $viewaim, user_aim = '" . str_replace("\'", "''", $aim) . "', user_yim = '" . str_replace("\'", "''", $yim) . "', user_msnm = '" . str_replace("\'", "''", $msn) . "', user_attachsig = $attachsig, user_sig_bbcode_uid = '$signature_bbcode_uid', user_allowsmile = $allowsmilies, user_allowhtml = $allowhtml, user_allowavatar = $user_allowavatar, user_allowsig = $user_allowsig, user_allowbbcode = $allowbbcode, user_allow_viewonline = $allowviewonline, user_notify = $notifyreply, user_allow_pm = $user_allowpm, user_notify_pm = $notifypm, user_popup_pm = $popuppm, allowpm = $allowpm, user_notify_gg = $user_notify_gg, user_lang = '" . str_replace("\'", "''", $user_lang) . "', user_style = $user_style, user_timezone = $user_timezone, user_active = $user_status $reset_act_key, user_rank = $user_rank, user_gender = '$gender' " . $avatar_sql . $signature_sql . ", disallow_forums = '" . str_replace("\'", "''", $disallow_forums_sql) . "', can_custom_ranks = $can_custom_ranks, can_custom_color = $can_custom_color, can_topic_color = $can_topic_color, user_allow_helped = $user_allow_helped, user_ip_login_check = $user_ip_login_check
					WHERE user_id = $user_id";
				if ( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not rename users group', '', __LINE__, __FILE__, $sql);
				}
				if ( $result = $db->sql_query($sql) )
				{
					if ( isset($rename_user) )
					{
						$sql = "UPDATE " . GROUPS_TABLE . "
							SET group_name = '".str_replace("\'", "''", $rename_user)."'
							WHERE group_name = '".str_replace("'", "''", $this_userdata['username'] )."'";
						if ( !$result = $db->sql_query($sql) )
						{
							message_die(GENERAL_ERROR, 'Could not rename users group', '', __LINE__, __FILE__, $sql);
						}
						sql_cache('clear', 'groups_desc');
						sql_cache('clear', 'user_groups');
						sql_cache('clear', 'groups_data');
						sql_cache('clear', 'moderators_list');
					}

					// Delete user session, to prevent the user navigating the forum (if logged in) when disabled
					if (!$user_status)
					{
						$sql = "DELETE FROM " . SESSIONS_TABLE . " 
							WHERE session_user_id = " . $user_id;

						if ( !$db->sql_query($sql) )
						{
							message_die(GENERAL_ERROR, 'Error removing user session', '', __LINE__, __FILE__, $sql);
						}
					}

					$message .= $lang['Admin_user_updated'];
				}
				else
				{
					$error = TRUE;
					$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Admin_user_fail'];
				}
			}

			$message .= (isset($_POST['userlist'])) ? '<br /><br />' . sprintf($lang['Click_return_useradmin'], '<a href="' . append_sid("admin_users_list.$phpEx") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid("index.$phpEx?pane=right") . '">', '</a>') : '<br /><br />' . sprintf($lang['Click_return_useradmin'], '<a href="' . append_sid("admin_users.$phpEx") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid("index.$phpEx?pane=right") . '">', '</a>');

			message_die(GENERAL_MESSAGE, $message);
		}
		else
		{
			$template->set_filenames(array(
				'reg_header' => 'error_body.tpl')
			);

			$template->assign_vars(array(
				'ERROR_MESSAGE' => $error_msg)
			);

			$template->assign_var_from_handle('ERROR_BOX', 'reg_header');

			$username =  xhtmlspecialchars(stripslashes($username));
			$email = stripslashes($email);
			$password = '';
			$password_confirm = '';

			$icq = stripslashes($icq);
			$aim =  xhtmlspecialchars(str_replace('+', ' ', stripslashes($aim)));
			$msn =  xhtmlspecialchars(stripslashes($msn));
			$yim =  xhtmlspecialchars(stripslashes($yim));

			$website = xhtmlspecialchars(stripslashes($website));
			$location = xhtmlspecialchars(stripslashes($location));
			$occupation = xhtmlspecialchars(stripslashes($occupation));
			$interests = xhtmlspecialchars(stripslashes($interests));
			$signature = xhtmlspecialchars(stripslashes($signature));

			$custom_color = xhtmlspecialchars(stripslashes($custom_color));
			$custom_rank = xhtmlspecialchars(stripslashes($custom_rank));
			$user_sig_image = $this_userdata['user_sig_image'];
			$user_lang = stripslashes($user_lang);

			if ( $custom_fields_exists )
			{
				for($i = 0; $i < count($custom_fields[0]); $i++)
				{
					$$split_field[$i] = stripslashes($$split_field[$i]);
				}
			}
		}
	}
	else if ( !isset( $HTTP_POST_VARS['submit'] ) && $mode != 'save' && !isset( $HTTP_POST_VARS['avatargallery'] ) && !isset( $HTTP_POST_VARS['submitavatar'] ) && !isset( $HTTP_POST_VARS['cancelavatar'] ) )
	{
		if ( isset( $HTTP_GET_VARS[POST_USERS_URL]) || isset( $HTTP_POST_VARS[POST_USERS_URL]) )
		{
			$user_id = ( isset( $HTTP_POST_VARS[POST_USERS_URL]) ) ? intval( $HTTP_POST_VARS[POST_USERS_URL]) : intval( $HTTP_GET_VARS[POST_USERS_URL]);
			$this_userdata = get_userdata($user_id);

			if ( !$this_userdata )
			{
				message_die(GENERAL_MESSAGE, $lang['No_user_id_specified'] );
			}
		}
		else
		{
			$this_userdata = get_userdata($HTTP_POST_VARS['username'], true);
			if ( !$this_userdata )
			{
				message_die(GENERAL_MESSAGE, $lang['No_user_id_specified'] );
			}
		}

		// Now parse and display it as a template
		$user_id = $this_userdata['user_id'];
		$username = $this_userdata['username'];
		$email = $this_userdata['user_email'];
		$password = '';
		$password_confirm = '';

		$icq = $this_userdata['user_icq'];
		$aim = xhtmlspecialchars(str_replace('+', ' ', $this_userdata['user_aim'] ));
		$msn = xhtmlspecialchars($this_userdata['user_msnm']);
		$yim = xhtmlspecialchars($this_userdata['user_yim']);

		$website = xhtmlspecialchars($this_userdata['user_website']);
		$location = xhtmlspecialchars($this_userdata['user_from']);
		$occupation = xhtmlspecialchars($this_userdata['user_occ']);
		$interests = xhtmlspecialchars($this_userdata['user_interests']);

		$signature = ($this_userdata['user_sig_bbcode_uid'] != '') ? preg_replace('#:' . $this_userdata['user_sig_bbcode_uid'] . '#si', '', $this_userdata['user_sig']) : $this_userdata['user_sig'];
		$signature = preg_replace($html_entities_match, $html_entities_replace, $signature);

		$gender = $this_userdata['user_gender'];
		$custom_color = xhtmlspecialchars($this_userdata['user_custom_color']);
		$custom_rank = xhtmlspecialchars($this_userdata['user_custom_rank']);
		$user_sig_image = $this_userdata['user_sig_image'];
		$viewemail = $this_userdata['user_viewemail'];
		$viewaim = $this_userdata['user_viewaim'];
		$notifypm = $this_userdata['user_notify_pm'];
		$popuppm = $this_userdata['user_popup_pm'];
		$allowpm = $this_userdata['allowpm'];
		$user_notify_gg = $this_userdata['user_notify_gg'];
		$notifyreply = $this_userdata['user_notify'];
		$user_ip_login_check = $this_userdata['user_ip_login_check'];
		$attachsig = $this_userdata['user_attachsig'];
		$allowhtml = $this_userdata['user_allowhtml'];
		$allowbbcode = $this_userdata['user_allowbbcode'];
		$allowsmilies = $this_userdata['user_allowsmile'];
		$allowviewonline = $this_userdata['user_allow_viewonline'];
		$user_avatar = $this_userdata['user_avatar'];
		$user_avatar_type = $this_userdata['user_avatar_type'];
		$user_style = $this_userdata['user_style'];
		$user_lang = $this_userdata['user_lang'];
		$user_timezone = $this_userdata['user_timezone'];
		$user_status = $this_userdata['user_active'];
		$user_allowavatar = $this_userdata['user_allowavatar'];
		$can_topic_color = $this_userdata['can_topic_color'];
		$user_allowsig = $this_userdata['user_allowsig'];
		$can_custom_color = $this_userdata['can_custom_color'];
		$can_custom_ranks = $this_userdata['can_custom_ranks'];
		$disallow_forums = $this_userdata['disallow_forums'];
		$user_allowpm = $this_userdata['user_allow_pm'];
		$COPPA = false;
		$html_status = ($this_userdata['user_allowhtml'] ) ? $lang['HTML_is_ON'] : $lang['HTML_is_OFF'];
		$bbcode_status = ($this_userdata['user_allowbbcode'] ) ? $lang['BBCode_is_ON'] : $lang['BBCode_is_OFF'];
		$smilies_status = ($this_userdata['user_allowsmile'] ) ? $lang['Smilies_are_ON'] : $lang['Smilies_are_OFF'];
		$user_allow_helped = $this_userdata['user_allow_helped'];

		if ( $custom_fields_exists )
		{
			for($i = 0; $i < count($custom_fields[0]); $i++)
			{
				$$split_field[$i] = $this_userdata[$split_field[$i]];
				$$split_allow_field[$i] = $this_userdata[$split_allow_field[$i]];
			}
		}
	}

	if ( isset($HTTP_POST_VARS['avatargallery']) && !$error )
	{
		if ( !$error )
		{
			$user_id = intval($HTTP_POST_VARS['id']);

			$template->set_filenames(array(
				'body' => 'admin/user_avatar_gallery.tpl')
			);

			$dir = @opendir('../' . $board_config['avatar_gallery_path']);

			$avatar_images = array();
			while( $file = @readdir($dir) )
			{
				if( $file != "." && $file != ".." && !is_file(phpbb_realpath("./../" . $board_config['avatar_gallery_path'] . "/" . $file)) && !is_link(phpbb_realpath("./../" . $board_config['avatar_gallery_path'] . "/" . $file)) )
				{
					$sub_dir = @opendir('../' . $board_config['avatar_gallery_path'] . '/' . $file);

					$avatar_row_count = 0;
					$avatar_col_count = 0;

					while( $sub_file = @readdir($sub_dir) )
					{
						if ( preg_match("/(\.gif$|\.png$|\.jpg)$/is", $sub_file) )
						{
							$avatar_images[$file][$avatar_row_count][$avatar_col_count] = $sub_file;

							$avatar_col_count++;
							if ( $avatar_col_count == 5 )
							{
								$avatar_row_count++;
								$avatar_col_count = 0;
							}
						}
					}
				}
			}
	
			@closedir($dir);

			if ( isset($HTTP_POST_VARS['avatarcategory']) )
			{
				$category = xhtmlspecialchars($HTTP_POST_VARS['avatarcategory']);
			}
			else
			{
				list($category, ) = each($avatar_images);
			}
			@reset($avatar_images);

			$s_categories = '';
			while( list($key) = each($avatar_images) )
			{
				$selected = ( $key == $category ) ? 'selected="selected"' : '';
				if ( count($avatar_images[$key]) )
				{
					$s_categories .= '<option value="' . $key . '"' . $selected . '>' . ucfirst($key) . '</option>';
				}
			}

			$s_colspan = 0;
			for($i = 0; $i < count($avatar_images[$category]); $i++)
			{
				$template->assign_block_vars('avatar_row', array());

				$s_colspan = max($s_colspan, count($avatar_images[$category][$i]));

				for($j = 0; $j < count($avatar_images[$category][$i]); $j++)
				{
					$template->assign_block_vars('avatar_row.avatar_column', array(
						"AVATAR_IMAGE" => "../" . $board_config['avatar_gallery_path'] . '/' . $category . '/' . $avatar_images[$category][$i][$j])
					);

					$template->assign_block_vars('avatar_row.avatar_option_column', array(
						'S_OPTIONS_AVATAR' => $avatar_images[$category][$i][$j])
					);
				}
			}

			$coppa = ( ( !$HTTP_POST_VARS['coppa'] && !$HTTP_GET_VARS['coppa'] ) || $mode == 'register') ? 0 : TRUE;

			$s_hidden_fields = '<input type="hidden" name="mode" value="edit" /><input type="hidden" name="agreed" value="true" /><input type="hidden" name="coppa" value="' . $coppa . '" /><input type="hidden" name="avatarcatname" value="' . $category . '" />';
			$s_hidden_fields .= '<input type="hidden" name="custom_color" value="' . str_replace("\"", "&quot;", $custom_color) . '" />';
			$s_hidden_fields .= '<input type="hidden" name="id" value="' . $user_id . '" />';
			$s_hidden_fields .= '<input type="hidden" name="username" value="' . str_replace("\"", "&quot;", $username) . '" />';
			$s_hidden_fields .= '<input type="hidden" name="email" value="' . str_replace("\"", "&quot;", $email) . '" />';
			$s_hidden_fields .= '<input type="hidden" name="icq" value="' . str_replace("\"", "&quot;", $icq) . '" />';
			$s_hidden_fields .= '<input type="hidden" name="aim" value="' . str_replace("\"", "&quot;", $aim) . '" />';
			$s_hidden_fields .= '<input type="hidden" name="msn" value="' . str_replace("\"", "&quot;", $msn) . '" />';
			$s_hidden_fields .= '<input type="hidden" name="yim" value="' . str_replace("\"", "&quot;", $yim) . '" />';
			$s_hidden_fields .= '<input type="hidden" name="website" value="' . str_replace("\"", "&quot;", $website) . '" />';
			$s_hidden_fields .= '<input type="hidden" name="location" value="' . str_replace("\"", "&quot;", $location) . '" />';
			$s_hidden_fields .= '<input type="hidden" name="occupation" value="' . str_replace("\"", "&quot;", $occupation) . '" />';
			$s_hidden_fields .= '<input type="hidden" name="interests" value="' . str_replace("\"", "&quot;", $interests) . '" />';
			$s_hidden_fields .= '<input type="hidden" name="custom_rank" value="' . str_replace("\"", "&quot;", $custom_rank) . '" />';
			$s_hidden_fields .= '<input type="hidden" name="signature" value="' . str_replace("\"", "&quot;", $signature) . '" />';
			$s_hidden_fields .= '<input type="hidden" name="user_sig_image" value="' . str_replace("\"", "&quot;", $user_sig_image) . '" />';
			$s_hidden_fields .= '<input type="hidden" name="viewemail" value="' . $viewemail . '" />';
			$s_hidden_fields .= '<input type="hidden" name="viewaim" value="' . $viewaim . '" />';
			$s_hidden_fields .= '<input type="hidden" name="gender" value="' . $gender . '" />';
			$s_hidden_fields .= '<input type="hidden" name="notifypm" value="' . $notifypm . '" />';
			$s_hidden_fields .= '<input type="hidden" name="popup_pm" value="' . $popuppm . '" />';
			$s_hidden_fields .= '<input type="hidden" name="allowpm" value="' . $allowpm . '" />';
			$s_hidden_fields .= '<input type="hidden" name="user_notify_gg" value="' . $user_notify_gg . '" />';
			$s_hidden_fields .= '<input type="hidden" name="notifyreply" value="' . $notifyreply . '" />';
			$s_hidden_fields .= '<input type="hidden" name="user_ip_login_check" value="' . $user_ip_login_check . '" />';
			$s_hidden_fields .= '<input type="hidden" name="attachsig" value="' . $attachsig . '" />';
			$s_hidden_fields .= '<input type="hidden" name="allowhtml" value="' . $allowhtml . '" />';
			$s_hidden_fields .= '<input type="hidden" name="allowbbcode" value="' . $allowbbcode . '" />';
			$s_hidden_fields .= '<input type="hidden" name="allowsmilies" value="' . $allowsmilies . '" />';
			$s_hidden_fields .= '<input type="hidden" name="hideonline" value="' . !$allowviewonline . '" />';
			$s_hidden_fields .= '<input type="hidden" name="style" value="' . $user_style . '" />';
			$s_hidden_fields .= '<input type="hidden" name="language" value="' . $user_lang . '" />';
			$s_hidden_fields .= '<input type="hidden" name="timezone" value="' . $user_timezone . '" />';
			$s_hidden_fields .= '<input type="hidden" name="user_status" value="' . $user_status . '" />';
			$s_hidden_fields .= '<input type="hidden" name="user_allowpm" value="' . $user_allowpm . '" />';
			$s_hidden_fields .= '<input type="hidden" name="user_allowavatar" value="' . $user_allowavatar . '" />';
			$s_hidden_fields .= '<input type="hidden" name="can_topic_color" value="' . $can_topic_color . '" />';
			$s_hidden_fields .= '<input type="hidden" name="user_allowsig" value="' . $user_allowsig . '" />';
			$s_hidden_fields .= '<input type="hidden" name="can_custom_ranks" value="' . $can_custom_ranks . '" />';
			$s_hidden_fields .= '<input type="hidden" name="can_custom_color" value="' . $can_custom_color . '" />';
			$s_hidden_fields .= '<input type="hidden" name="user_rank" value="' . $user_rank . '" />';
			$s_hidden_fields .= '<input type="hidden" name="user_allow_helped" value="' . $user_allow_helped . '" />';

			for($i = 0; $i < count($disallow_forums); $i++)
			{
				$s_hidden_fields .= '<input type="hidden" name="disallow_forums[]" value="' . $disallow_forums[$i] . '" />';
			}

			if ( $custom_fields_exists )
			{
				for($i = 0; $i < count($custom_fields[0]); $i++)
				{
					$s_hidden_fields .= '<input type="hidden" name="' . $split_field[$i] . '" value="' . str_replace("\"", "&quot;", $$split_field[$i]) . '" />';
					$s_hidden_fields .= '<input type="hidden" name="' . $split_allow_field[$i] . '" value="' . str_replace("\"", "&quot;", $$split_allow_field[$i]) . '" />';
				}
			}

			$template->assign_vars(array(
				'L_USER_TITLE' => $lang['User_admin'],
				'L_USER_EXPLAIN' => $lang['User_admin_explain'],
				'L_AVATAR_GALLERY' => $lang['Avatar_gallery'], 
				'L_SELECT_AVATAR' => $lang['Select_avatar'], 
				'L_RETURN_PROFILE' => $lang['Return_profile'], 
				'L_CATEGORY' => $lang['Select_category'], 
				'L_GO' => $lang['Go'],

				'S_OPTIONS_CATEGORIES' => $s_categories, 
				'S_COLSPAN' => $s_colspan, 
				'S_PROFILE_ACTION' => append_sid("admin_users.$phpEx?mode=$mode"), 
				'S_HIDDEN_FIELDS' => $s_hidden_fields)
			);
		}
	}
	else
	{
		$s_hidden_fields = '<input type="hidden" name="mode" value="save" /><input type="hidden" name="agreed" value="true" /><input type="hidden" name="coppa" value="' . $coppa . '" />';
		$s_hidden_fields .= '<input type="hidden" name="id" value="' . $this_userdata['user_id'] . '" />';

		if ( !empty($user_avatar_local) )
		{
			$s_hidden_fields .= '<input type="hidden" name="avatarlocal" value="' . $user_avatar_local . '" /><input type="hidden" name="avatarcatname" value="' . $user_avatar_category . '" />';
		}

		if ( $user_avatar_type )
		{
			switch( $user_avatar_type )
			{
				case USER_AVATAR_UPLOAD:
					$avatar = '<img src="../' . $board_config['avatar_path'] . '/' . $user_avatar . '" alt="" />';
					break;
				case USER_AVATAR_REMOTE:
					$avatar = '<img src="' . $user_avatar . '" alt="" />';
					break;
				case USER_AVATAR_GALLERY:
					$avatar = '<img src="../' . $board_config['avatar_gallery_path'] . '/' . $user_avatar . '" alt="" />';
					break;
			}
		}
		else
		{
			$avatar = '';
		}

		$sql = "SELECT * FROM " . RANKS_TABLE . "
			WHERE rank_special = 1
			ORDER BY rank_title";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain ranks data', '', __LINE__, __FILE__, $sql);
		}

		$rank_select_box = '<option value="0">' . $lang['No_assigned_rank'] . '</option>';
		while( $row = $db->sql_fetchrow($result) )
		{
			$rank = $row['rank_title'];
			$rank_id = $row['rank_id'];
			
			$selected = ( $this_userdata['user_rank'] == $rank_id ) ? ' selected="selected"' : '';
			$rank_select_box .= '<option value="' . $rank_id . '"' . $selected . '>' . $rank . '</option>';
		}

		$signature = preg_replace('/\:[0-9a-z\:]*?\]/si', ']', $signature);

		$signature_image = ( $user_sig_image != '' ) ? '<img src="../' . $board_config['sig_images_path'] . '/' . $user_sig_image . '" alt="" />' : '';

		$template->set_filenames(array(
			'body' => 'admin/user_edit_body.tpl')
		);
		
		if ( $this_userdata['user_blocktime'] < CR_TIME )
		{
			$template->assign_vars(array(
				'BLOCK_BY' => ($this_userdata['user_block_by']) ? sprintf($lang['Last_block_by'],decode_ip($this_userdata['user_block_by'])).'<br/>' : '',
				'BLOCK' => '<br/><input type="checkbox" name="block_account">'.sprintf ($lang['Block_user'],$board_config['block_time']))
			);
		}
		else
		{
			$template->assign_vars(array(
				'BLOCK_UNTIL' => sprintf($lang['Block_until'], create_date($board_config['default_dateformat'], $this_userdata['user_blocktime'], $board_config['board_timezone']) ).'<br/>',
				'BLOCK_BY' => ($this_userdata['user_block_by']) ? sprintf($lang['Block_by'],decode_ip($this_userdata['user_block_by'])).'<br/>' : '',
				'BLOCK' => '<br/><input type="checkbox" name="unblock_account">' . $lang['Unblock_user'] . '<br/>')
			);
		}

		switch ($gender)
		{
			case 1:
				$gender_male_checked = $checked;
			break;
			case 2:
				$gender_female_checked = $checked;
			break;
			default:
				$gender_no_specify_checked = $checked;
		}

		// Let's do an overall check for settings/versions which would prevent
		// us from doing file uploads....
		$ini_val = ( phpversion() >= '4.0.0' ) ? 'ini_get' : 'get_cfg_var';
		$form_enctype = ( !@$ini_val('file_uploads') || phpversion() == '4.0.4pl1' || !$board_config['allow_avatar_upload'] || ( phpversion() < '4.0.3' && @$ini_val('open_basedir') != '' ) ) ? '' : 'enctype="multipart/form-data"';

		$current_color = '<span style="color: ' . $custom_color . '">f<b>' . $lang['current_color'] . '</b></span>';

		$default_select = ( $custom_color == '' ) ? 'selected="selected"' : '';
		$dark_red_select = ( $custom_color == 'CC0000' ) ? 'selected="selected"' : '';
		$red_select = ( $custom_color == 'FF3300' ) ? 'selected="selected"' : '';
		$orange_select = ( $custom_color == 'FF9900' ) ? 'selected="selected"' : '';
		$brown_select = ( $custom_color == '800000' ) ? 'selected="selected"' : '';
		$yellow_select = ( $custom_color == 'FFFF00' ) ? 'selected="selected"' : '';
		$green_select = ( $custom_color == '008000' ) ? 'selected="selected"' : '';
		$olive_select = ( $custom_color == '808000' ) ? 'selected="selected"' : '';
		$cyan_select = ( $custom_color == '33FFFF' ) ? 'selected="selected"' : '';
		$blue_select = ( $custom_color == '3366FF' ) ? 'selected="selected"' : '';
		$dark_blue_select = ( $custom_color == '000080' ) ? 'selected="selected"' : '';
		$indigo_select = ( $custom_color == '990099' ) ? 'selected="selected"' : '';
		$violet_select = ( $custom_color == 'CC66CC' ) ? 'selected="selected"' : '';
		$white_select = ( $custom_color == 'F5FFFA' ) ? 'selected="selected"' : '';
		$black_select = ( $custom_color == '000000' ) ? 'selected="selected"' : '';
		$max_sig_chars_admin = ($board_config['max_sig_chars_admin'] > 1) ? $board_config['max_sig_chars_admin'] : 1;

		if ( is_array($disallow_forums) )
		{
			$disallow_forums_new = '';
			for($i = 0; $i < count($disallow_forums); $i++)
			{
				$disallow_forums_new .= (($disallow_forums_new) ? ', ' : '') . str_replace(POST_FORUM_URL, '', $disallow_forums[$i]);
			}
			$disallow_forums = $disallow_forums_new;
		}

		$template->assign_vars(array(
			'L_COLOR_DEFAULT' => $lang['color_default'],
			'L_COLOR_DARK_RED' => $lang['color_dark_red'],
			'L_COLOR_RED' => $lang['color_red'],
			'L_COLOR_ORANGE' => $lang['color_orange'],
			'L_COLOR_BROWN' => $lang['color_brown'],
			'L_COLOR_YELLOW' => $lang['color_yellow'],
			'L_COLOR_GREEN' => $lang['color_green'],
			'L_COLOR_OLIVE' => $lang['color_olive'],
			'L_COLOR_CYAN' => $lang['color_cyan'],
			'L_COLOR_BLUE' => $lang['color_blue'],
			'L_COLOR_DARK_BLUE' => $lang['color_dark_blue'],
			'L_COLOR_INDIGO' => $lang['color_indigo'],
			'L_COLOR_VIOLET' => $lang['color_violet'],
			'L_COLOR_WHITE' => $lang['color_white'],
			'L_COLOR_BLACK' => $lang['color_black'],
			'L_USERNAME' => $lang['Username'],
			'L_USER_TITLE' => $lang['User_admin'],
			'L_USER_EXPLAIN' => $lang['User_admin_explain'],
			'L_NEW_PASSWORD' => $lang['New_password'], 
			'L_PASSWORD_IF_CHANGED' => $lang['password_if_changed'],
			'L_CONFIRM_PASSWORD' => $lang['Confirm_password'],
			'L_PASSWORD_CONFIRM_IF_CHANGED' => $lang['password_confirm_if_changed'],
			'L_SUBMIT' => $lang['Submit'],
			'L_RESET' => $lang['Reset'],
			'L_ICQ_NUMBER' => $lang['ICQ'],
			'L_MESSENGER' => $lang['MSNM'],
			'L_YAHOO' => $lang['YIM'],
			'L_WEBSITE' => $lang['Website'],
			'L_AIM' => $lang['AIM'],
			'L_LOCATION' => $lang['Location'],
			'L_OCCUPATION' => $lang['Occupation'],
			'L_BOARD_LANGUAGE' => $lang['Board_lang'],
			'L_BOARD_STYLE' => $lang['Board_style'],
			'L_TIMEZONE' => $lang['Timezone'],
			'L_YES' => $lang['Yes'],
			'L_NO' => $lang['No'],
			'L_INTERESTS' => $lang['Interests'],
			'L_GENDER' =>$lang['Gender'],
			'L_GENDER_MALE' =>$lang['Male'],
			'L_GENDER_FEMALE' =>$lang['Female'],
			'L_GENDER_NOT_SPECIFY' =>$lang['No_gender_specify'],
			'L_ACCOUNT_BLOCK' => $lang['Account_block'],
			'L_ACCOUNT_BLOCK_EXPLAIN' => $lang['Account_block_explain'],
			'L_UNBLOCK' => $lang['Unblock_user'],
			'L_BAD_LOGIN_COUNT' => $lang['Badlogin_count'],
			'L_CUSTOM_COLOR' => $lang['Custom_color'],
			'L_CUSTOM_RANK' => $lang['Custom_Rank'],
			'L_ALWAYS_ALLOW_SMILIES' => $lang['Always_smile'],
			'L_ALWAYS_ALLOW_BBCODE' => $lang['Always_bbcode'],
			'L_ALWAYS_ALLOW_HTML' => $lang['Always_html'],
			'L_HIDE_USER' => $lang['Hide_user'],
			'L_ALWAYS_ADD_SIGNATURE' => $lang['Always_add_sig'],
			'CAN_CUSTOM_RANKS' => $lang['can_custom_ranks'],
			'CAN_CUSTOM_COLOR' => $lang['can_custom_color'],
			'CAN_TOPIC_COLOR' => $lang['can_topic_color'],
			'L_SPECIAL' => $lang['User_special'],
			'L_SPECIAL_EXPLAIN' => $lang['User_special_explain'],
			'L_USER_ACTIVE' => $lang['User_status'],
			'L_ALLOW_PM' => $lang['User_allowpm'],
			'L_ALLOW_HELPED' => $lang['User_allow_helped'],
			'L_ALLOW_HELPED_E' => $lang['User_allow_helped_e'],
			'L_ALLOW_AVATAR' => $lang['User_allowavatar'],
			'L_ALLOW_SIG' => $lang['User_allowsig'],
			'L_AVATAR_PANEL' => $lang['Avatar_panel'],
			'L_AVATAR_EXPLAIN' => $lang['Admin_avatar_explain'],
			'L_DELETE_AVATAR' => $lang['Delete_Image'],
			'L_CURRENT_IMAGE' => $lang['Current_Image'],
			'L_UPLOAD_AVATAR_FILE' => $lang['Upload_Avatar_file'],
			'L_UPLOAD_AVATAR_URL' => $lang['Upload_Avatar_URL'],
			'L_AVATAR_GALLERY' => $lang['Select_from_gallery'],
			'L_SHOW_GALLERY' => $lang['View_avatar_gallery'],
			'L_LINK_REMOTE_AVATAR' => $lang['Link_remote_Avatar'],
			'L_SIGNATURE_PANEL' => $lang['Signature_panel'],
			'L_SIGNATURE_EXPLAIN' => sprintf($lang['Signature_explain'], $board_config['sig_image_max_width'], $board_config['sig_image_max_height'], (round($board_config['sig_image_filesize'] / 1024))),
			'L_DELETE_SIGNATURE_IMAGE' => $lang['Delete_Image'],
			'L_UPLOAD_SIGNATURE_FILE' => $lang['Upload_Avatar_file'],
			'L_UPLOAD_SIGNATURE_URL' => $lang['Upload_Avatar_URL'],
			'L_UPLOAD_SIGNATURE_URL_EXPLAIN' => $lang['Upload_Avatar_URL_explain'],
			'L_SIGNATURE_TEXT' => $lang['Signature_text'],
			'L_SIGNATURE_TEXT_EXPLAIN' => sprintf($lang['Signature_text_explain'], ( $board_config['max_sig_chars'] * $max_sig_chars_admin )),
			'L_NOTIFY_ON_PRIVMSG' => $lang['Notify_on_privmsg'],
			'L_NOTIFY_ON_REPLY' => $lang['Always_notify'],
			'L_POPUP_ON_PRIVMSG' => $lang['Popup_on_privmsg'],
			'L_ALLOWPM' => $lang['allowpm'],
			'L_NOTIFY_GG' => $lang['l_notify_gg'],
			'L_PREFERENCES' => $lang['Preferences'],
			'L_PUBLIC_VIEW_EMAIL' => $lang['Public_view_email'],
			'L_PUBLIC_VIEW_AIM' => $lang['Public_view_aim'],
			'L_ITEMS_REQUIRED' => $lang['Items_required'],
			'L_REGISTRATION_INFO' => $lang['Registration_info'],
			'L_PROFILE_INFO' => $lang['Profile_info'],
			'L_PROFILE_INFO_NOTICE' => $lang['Profile_info_warn'],
			'L_EMAIL_ADDRESS' => $lang['Email_address'],
			'L_DISALLOW_FORUMS_E' => $lang['disallow_forums_e'],
			'L_DISALLOW_FORUMS' => $lang['disallow_forums'],
			'L_DELETE_USER' => $lang['User_delete'],
			'L_DELETE_USER_EXPLAIN' => $lang['User_delete_explain'],
			'L_SELECT_RANK' => $lang['Rank_title'],
			'L_LOG_IN_CHECK' => $lang['login_ip_check'],
			'L_LOG_IN_CHECK_E' => $lang['login_ip_check_e'],

			'USERNAME' => $username,
			'EMAIL' => $email,
			'YIM' => $yim,
			'ICQ' => $icq,
			'MSN' => $msn,
			'AIM' => $aim,
			'OCCUPATION' => $occupation,
			'INTERESTS' => $interests,
			'GENDER' => $gender,
			'GENDER_NO_SPECIFY_CHECKED' => $gender_no_specify_checked,
			'GENDER_MALE_CHECKED' => $gender_male_checked,
			'GENDER_FEMALE_CHECKED' => $gender_female_checked,
			'CUSTOM_color' => $custom_color,
			'CURRENT_COLOR' => $current_color,
			'CUSTOM_RANK' => $custom_rank,
			'LOCATION' => $location,
			'WEBSITE' => $website,
			'SIGNATURE' => str_replace('<br />', "\n", $signature),
			'SIGNATURE_IMAGE' => $signature_image,
			'ALLOW_SIGNATURE_YES' => ( $allow_sig ) ? ' checked="checked"' : '',
			'ALLOW_SIGNATURE_NO' => ( !$allow_sig ) ? ' checked="checked"' : '',
			'ALLOW_SIG_IMAGE_YES' => ( $allow_sig_image ) ? ' checked="checked"' : '',
			'ALLOW_SIG_IMAGE_NO' => ( !$allow_sig_image ) ? ' checked="checked"' : '',
			'VIEW_EMAIL_YES' => ($viewemail) ? $checked : '',
			'VIEW_EMAIL_NO' => (!$viewemail) ? $checked : '',
			'VIEW_AIM_YES' => ($viewaim) ? $checked : '',
			'VIEW_AIM_NO' => (!$viewaim) ? $checked : '',
			'HIDE_USER_YES' => (!$allowviewonline) ? $checked : '',
			'HIDE_USER_NO' => ($allowviewonline) ? $checked : '',
			'NOTIFY_PM_YES' => ($notifypm) ? $checked : '',
			'NOTIFY_PM_NO' => (!$notifypm) ? $checked : '',
			'POPUP_PM_YES' => ($popuppm) ? $checked : '',
			'POPUP_PM_NO' => (!$popuppm) ? $checked : '',
			'ALLOWPM_YES' => ($allowpm) ? $checked : '',
			'ALLOWPM_NO' => (!$allowpm) ? $checked : '',
			'NOTIFY_GG_YES' => ($user_notify_gg) ? $checked : '',
			'NOTIFY_GG_NO' => (!$user_notify_gg) ? $checked : '',
			'ALWAYS_ADD_SIGNATURE_YES' => ($attachsig) ? $checked : '',
			'ALWAYS_ADD_SIGNATURE_NO' => (!$attachsig) ? $checked : '',
			'NOTIFY_REPLY_YES' => ( $notifyreply ) ? $checked : '',
			'NOTIFY_REPLY_NO' => ( !$notifyreply ) ? $checked : '',
			'LOG_IN_CHECK_YES' => ( $user_ip_login_check ) ? $checked : '',
			'LOG_IN_CHECK_NO' => ( !$user_ip_login_check ) ? $checked : '',
			'ALWAYS_ALLOW_BBCODE_YES' => ($allowbbcode) ? $checked : '',
			'ALWAYS_ALLOW_BBCODE_NO' => (!$allowbbcode) ? $checked : '',
			'ALWAYS_ALLOW_HTML_YES' => ($allowhtml) ? $checked : '',
			'ALWAYS_ALLOW_HTML_NO' => (!$allowhtml) ? $checked : '',
			'ALWAYS_ALLOW_SMILIES_YES' => ($allowsmilies) ? $checked : '',
			'ALWAYS_ALLOW_SMILIES_NO' => (!$allowsmilies) ? $checked : '',
			'AVATAR' => $avatar,
			'LANGUAGE_SELECT' => language_select($user_lang, 'language'),
			'TIMEZONE_SELECT' => tz_select($user_timezone),
			'STYLE_SELECT' => style_select($user_style, 'style'),
			'ALLOW_PM_YES' => ($user_allowpm) ? $checked : '',
			'ALLOW_PM_NO' => (!$user_allowpm) ? $checked : '',
			'ALLOW_AVATAR_YES' => ($user_allowavatar) ? $checked : '',
			'ALLOW_AVATAR_NO' => (!$user_allowavatar) ? $checked : '',
			'ALLOW_SIG_YES' => ($user_allowsig) ? $checked : '',
			'ALLOW_SIG_NO' => (!$user_allowsig) ? $checked : '',
			'CAN_CUSTOM_RANKS_YES' => ($can_custom_ranks) ? $checked : '',
			'CAN_CUSTOM_RANKS_NO' => (!$can_custom_ranks) ? $checked : '',
			'CAN_TOPIC_COLOR_YES' => ($can_topic_color) ? $checked : '',
			'CAN_TOPIC_COLOR_NO' => (!$can_topic_color) ? $checked : '',
			'CAN_CUSTOM_COLOR_YES' => ($can_custom_color) ? $checked : '',
			'CAN_CUSTOM_COLOR_NO' => (!$can_custom_color) ? $checked : '',
			'ALLOW_HELPED_YES' => ($user_allow_helped) ? $checked : '',
			'ALLOW_HELPED_NO' => (!$user_allow_helped) ? $checked : '',
			'USER_ACTIVE_YES' => ($user_status) ? $checked : '',
			'USER_ACTIVE_NO' => (!$user_status) ? $checked : '', 
			'RANK_SELECT_BOX' => $rank_select_box,
			'BAD_LOGIN_COUNT' => $this_userdata['user_badlogin'],
			'S_DISALLOW_OPTIONS' => get_tree_option('', false, true, $disallow_forums),
			'S_FORM_ENCTYPE' => $form_enctype,
			'HTML_STATUS' => $html_status,
			'BBCODE_STATUS' => sprintf($bbcode_status, '<a href="../' . append_sid("faq.$phpEx?mode=bbcode") . '" target="_phpbbcode">', '</a>'), 
			'SMILIES_STATUS' => $smilies_status,
			'DEFAULT_SELECT' => $default_select,
			'DARK_RED_SELECT' => $dark_red_select,
			'RED_SELECT' => $red_select,
			'ORANGE_SELECT' => $orange_select,
			'BROWN_SELECT' => $brown_select,
			'YELLOW_SELECT' => $yellow_select,
			'GREEN_SELECT' => $green_select,
			'OLIVE_SELECT' => $olive_select,
			'CYAN_SELECT' => $cyan_select,
			'BLUE_SELECT' => $blue_select,
			'DARK_BLUE_SELECT' => $dark_blue_select,
			'INDIGO_SELECT' => $indigo_select,
			'VIOLET_SELECT' => $violet_select,
			'WHITE_SELECT' => $white_select,
			'BLACK_SELECT' => $black_select,

			'S_HIDDEN_FIELDS' =>	$s_hidden_fields . ((isset($HTTP_GET_VARS['userlist']) || isset($HTTP_POST_VARS['userlist'])) ? '<input type="hidden" name="userlist" value="1" />' : ''),
			'S_PROFILE_ACTION' => append_sid("admin_users.$phpEx"))
		);

		if ( $custom_fields_exists )
		{
			include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_custom_fields.' . $phpEx);
			for($i = 0; $i < count($custom_fields[0]); $i++)
			{			
				$template->assign_block_vars('custom_fields', array(
					'FIELD' => $$split_field[$i],
					'ALLOW_FIELD' => $$split_field[$i],
					'FIELD_NAME' => str_replace(array("-#", '<br>'), array('',''), $split_field[$i]),
					'ALLOW_FIELD_NAME' => $split_allow_field[$i],
					'ALLOW_FIELD_NAME_YES' => ($$split_allow_field[$i]) ? $checked : '',
					'ALLOW_FIELD_NAME_NO' => (!$$split_allow_field[$i]) ? $checked : '',
					'L_CUSTOM_FIELD' => $custom_fields[1][$i],
					'L_CUSTOM_ALLOW_FIELD' => sprintf($lang['CF_can_allow'], $custom_fields[1][$i]))
				);
			}
		}

		if ( file_exists(@phpbb_realpath('./../' . $board_config['sig_image_path'])) && ($board_config['allow_sig_image'] == TRUE) )
		{
			$template->assign_block_vars('switch_signature_remote', array());
			if ( $form_enctype != '' )
			{
				$template->assign_block_vars('switch_signature_local', array());
			}
		}

		if ( file_exists(@phpbb_realpath('./../' . $board_config['avatar_path'] )) && ($board_config['allow_avatar_upload'] == TRUE) )
		{
			if ( $form_enctype != '' )
			{
				$template->assign_block_vars('avatar_local_upload', array() );
			}
			$template->assign_block_vars('avatar_remote_upload', array() );
		}

		if( file_exists(@phpbb_realpath('./../' . $board_config['avatar_gallery_path'])) && ($board_config['allow_avatar_local'] == TRUE) )
		{
			$template->assign_block_vars('avatar_local_gallery', array() );
		}
		
		if ( $board_config['allow_avatar_remote'] == TRUE )
		{
			$template->assign_block_vars('avatar_remote_link', array() );
		}
	}

	$template->pparse('body');
}
else
{
	// Default user selection box
	$template->set_filenames(array(
		'body' => 'admin/user_select_body.tpl')
	);

	$template->assign_vars(array(
		'L_USER_TITLE' => $lang['User_admin'],
		'L_USER_EXPLAIN' => $lang['User_admin_explain'],
		'L_USER_SELECT' => $lang['Select_a_User'],
		'L_LOOK_UP' => $lang['Look_up_user'],
		'L_FIND_USERNAME' => $lang['Find_username'],

		'U_SEARCH_USER' => append_sid("./../search.$phpEx?mode=searchuser"), 

		'S_USER_ACTION' => append_sid("admin_users.$phpEx"),
		'S_USER_SELECT' => $select_list)
	);
	$template->pparse('body');

}

include('./page_footer_admin.'.$phpEx);

?>