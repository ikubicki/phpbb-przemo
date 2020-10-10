<?php
/***************************************************************************
 *                            usercp_register.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   modification         : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   date modification    : ver. 1.12.5 2005/10/08 11:24
 *
 *   $Id: usercp_register.php,v 1.20.2.70 2005/12/29 11:51:11 acydburn Exp $
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

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
	exit;
}

$unhtml_specialchars_match = array('#&gt;#', '#&lt;#', '#&quot;#', '#&amp;#', '#&nbsp;#');
$unhtml_specialchars_replace = array('>', '<', '"', '&', '');

// ---------------------------------------
// Load agreement template since user has not yet
// agreed to registration conditions/coppa
//
function show_coppa()
{
	global $userdata, $template, $lang, $phpbb_root_path, $phpEx;

	$template->set_filenames(array(
		'body' => 'agreement.tpl')
	);

	$template->assign_vars(array(
		'REGISTRATION' => $lang['Registration'],
		'AGREEMENT' => $lang['Reg_agreement'],
		"AGREE_OVER_13" => $lang['Agree_over_13'],
		"AGREE_UNDER_13" => $lang['Agree_under_13'],
		'DO_NOT_AGREE' => $lang['Agree_not'],

		"U_AGREE_OVER13" => append_sid("profile.$phpEx?mode=register&amp;agreed=true"),
		"U_AGREE_UNDER13" => append_sid("profile.$phpEx?mode=register&amp;agreed=true&amp;coppa=true"))
	);

	$template->pparse('body');

}
//
// ---------------------------------------

$error = FALSE;
$error_msg = $signature_bbcode_uid = '';
$page_title = ( $mode == 'editprofile' ) ? $lang['Edit_profile'] : $lang['Register'];

if ( $mode == 'register' && !isset($HTTP_POST_VARS['agreed']) && !isset($HTTP_GET_VARS['agreed']) && $board_config['show_rules'] )
{
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);

	show_coppa();

	include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
}

$coppa = ( empty($HTTP_POST_VARS['coppa']) && empty($HTTP_GET_VARS['coppa']) ) ? 0 : TRUE;

//
// Check and initialize some variables if needed
//
$custom_fields_exists = (custom_fields('check', '')) ? true : false;
$adv_person_field = '';
if ( $custom_fields_exists )
{
	$custom_fields = custom_fields();
	for($i = 0; $i < count($custom_fields[0]); $i++)
	{
		$split_field = 'user_field_' . $custom_fields[0][$i];
		$fields_array[] = $split_field; 
		$custom_fields[1][$i] = str_replace(array('-#', '<br>'), array('',''), $custom_fields[1][$i]);
		if ( $custom_fields[1][$i] == 'adv_person' )
		{
			$adv_person_field = $split_field;
		}
	}
}

include($phpbb_root_path . 'includes/functions_add.'.$phpEx);

if ( $mode == 'register' )
{
	check_disable_function('REGISTERING');
}

elseif ( $mode == 'editprofile' )
{
    $SID1 = get_vars('sid', '', 'GET,POST');

    $verify_user  = przemo_create_hash();

	if (!check_sid($SID1))
	{
		$error     = true;
		$error_msg = $lang['Invalid_session'];
	}
}

if ( 
    isset($HTTP_POST_VARS['avatargallery']) || 
    isset($HTTP_POST_VARS['submitavatar']) || 
    isset($HTTP_POST_VARS['cancelavatar']) || 
    (isset($HTTP_POST_VARS['submit']) && $mode == 'editprofile') || 
    (isset($HTTP_POST_VARS['submit']) && $mode == 'register' && !empty($HTTP_POST_VARS['email1']) && !empty($HTTP_POST_VARS['email2'])) || 
    $mode == 'register' 
   )
{
	include($phpbb_root_path . 'includes/functions_validate.'.$phpEx);
	include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
	include($phpbb_root_path . 'includes/functions_post.'.$phpEx);

	if ( $mode == 'editprofile' )
	{
		$SID2 = get_vars('sid', '', 'POST');
		$user_id = get_vars('user_id', 0, 'POST', true);
		$current_email = trim(xhtmlspecialchars( get_vars('current_email', '', 'POST') ));
		$veryfy_user_value = get_vars('verify_user', '', 'POST');

        if ( !check_sid($SID2) || !przemo_check_hash($veryfy_user_value) )
        {
            $error     = true;
            $error_msg = $lang['Invalid_session'];
        }
	}

	$strip_var_list = array('email1' => 'email1', 'email2' => 'email2', 'icq' => 'icq', 'msn' => 'msn', 'yim' => 'yim', 'website' => 'website', 'location' => 'location', 'occupation' => 'occupation', 'interests' => 'interests', 'custom_color' => 'custom_color', 'custom_rank' => 'custom_rank', 'b_day' => 'b_day', 'b_md' => 'b_md', 'b_year' => 'b_year');

	// Strip all tags from data ... may p**s some people off, bah, strip_tags is
	// doing the job but can still break HTML output ... have no choice, have
	// to use xhtmlspecialchars ... be prepared to be moaned at.

	while( list($var, $param) = @each($strip_var_list) )
	{
		if ( !empty($HTTP_POST_VARS[$param]) )
		{
			$$var = (!is_array($HTTP_POST_VARS[$param]))? trim(xhtmlspecialchars($HTTP_POST_VARS[$param])) : '';
		}
	}

	$username = phpbb_clean_username(get_vars('username', '', 'POST'));

	$trim_var_list = array('cur_password' => 'cur_password', 'new_password' => 'new_password', 'password_confirm' => 'password_confirm', 'signature' => 'signature');

	while( list($var, $param) = @each($trim_var_list) )
	{
		if ( !empty($HTTP_POST_VARS[$param]) )
		{
			$$var = (!is_array($HTTP_POST_VARS[$param])) ? trim($HTTP_POST_VARS[$param]) : '';
		}
	}

	if ( $custom_fields_exists )
	{
		for($i = 0; $i < count($fields_array); $i++)
		{
			$$fields_array[$i] = ($HTTP_POST_VARS[$fields_array[$i]] == 'no_image.gif') ? '' : ( (!is_array($HTTP_POST_VARS[$fields_array[$i]])) ? trim(xhtmlspecialchars($HTTP_POST_VARS[$fields_array[$i]])) : '' );
		}
	}

	$email = ''; 

    if ((empty($email1) || empty($email2)) && $mode == 'register') 
    { 
        $email = ''; 
    } 
    elseif(!empty($email1) && !empty($email2) && $mode == 'register') 
    { 
        $email = $email1 . '@' . $email2; 
    } 
    elseif($mode != 'register') 
    { 
        $email = $HTTP_POST_VARS['email1']; 
    } 
	
	$signature = str_replace('<br />', "\n", $signature);
	$gender = ( isset($HTTP_POST_VARS['gender']) ) ? intval($HTTP_POST_VARS['gender']) : 0;
	$aim = ( isset($HTTP_POST_VARS['aim']) ) ? intval($HTTP_POST_VARS['aim']) : 0;
	$b_day = ( isset($HTTP_POST_VARS['b_day']) ) ? intval($HTTP_POST_VARS['b_day']) : 0;
	$b_md = ( isset($HTTP_POST_VARS['b_md']) ) ? intval($HTTP_POST_VARS['b_md']) : 0;
	$b_year = ( isset($HTTP_POST_VARS['b_year']) ) ? intval($HTTP_POST_VARS['b_year']) : 0;

	// Run some validation on the optional fields. These are pass-by-ref, so they'll be changed to
	// empty strings if they fail.

	validate_optional_fields($icq, $aim, $msn, $yim, $website, $location, $occupation, $interests, $custom_color, $signature);

	$viewemail = ( isset($HTTP_POST_VARS['viewemail']) ) ? ( ($HTTP_POST_VARS['viewemail']) ? TRUE : 0 ) : 1;
	$viewaim = ( isset($HTTP_POST_VARS['viewaim']) ) ? ( ($HTTP_POST_VARS['viewaim']) ? TRUE : 0 ) : 1;

	$allowviewonline = ( isset($HTTP_POST_VARS['hideonline']) ) ? ( ($HTTP_POST_VARS['hideonline']) ? 0 : TRUE ) : TRUE;
	if ( $board_config['viewonline'] == '1' && $userdata['user_level'] != ADMIN )
	{
		$allowviewonline = 1;
	}
	if ( $board_config['viewonline'] == '2' && $userdata['user_level'] != ADMIN )
	{
		$allowviewonline = 0;
	}
	$notifyreply = ( isset($HTTP_POST_VARS['notifyreply']) ) ? ( ($HTTP_POST_VARS['notifyreply']) ? TRUE : 0 ) : 0;
	$user_notify_gg = ( isset($HTTP_POST_VARS['user_notify_gg']) ) ? ( ($HTTP_POST_VARS['user_notify_gg']) ? TRUE : 0 ) : 0;
	$notifypm = ( isset($HTTP_POST_VARS['notifypm']) ) ? ( ($HTTP_POST_VARS['notifypm']) ? TRUE : 0 ) : TRUE;
	$popuppm = ( isset($HTTP_POST_VARS['popup_pm']) ) ? ( ($HTTP_POST_VARS['popup_pm']) ? TRUE : 0 ) : TRUE;
	$allowpm = ( isset($HTTP_POST_VARS['allowpm']) ) ? ( ($HTTP_POST_VARS['allowpm']) ? TRUE : 0 ) : 1;
	$user_ip_login_check = ( isset($HTTP_POST_VARS['user_ip_login_check']) ) ? ( ($HTTP_POST_VARS['user_ip_login_check']) ? 1 : 0 ) : $userdata['user_ip_login_check'];

	if ( $mode == 'register' )
	{
		$attachsig = ( isset($HTTP_POST_VARS['attachsig']) ) ? ( ($HTTP_POST_VARS['attachsig']) ? TRUE : 0 ) : $board_config['allow_sig'];
		$allowhtml = ( isset($HTTP_POST_VARS['allowhtml']) ) ? ( ($HTTP_POST_VARS['allowhtml']) ? TRUE : 0 ) : $board_config['allow_html'];
		$allowbbcode = ( isset($HTTP_POST_VARS['allowbbcode']) ) ? ( ($HTTP_POST_VARS['allowbbcode']) ? TRUE : 0 ) : $board_config['allow_bbcode'];
		$allowsmilies = ( isset($HTTP_POST_VARS['allowsmilies']) ) ? ( ($HTTP_POST_VARS['allowsmilies']) ? TRUE : 0 ) : $board_config['allow_smilies'];
	}
	else
	{
		$attachsig = ( isset($HTTP_POST_VARS['attachsig']) ) ? ( ($HTTP_POST_VARS['attachsig']) ? TRUE : 0 ) : $userdata['user_attachsig'];
		$allowhtml = ( isset($HTTP_POST_VARS['allowhtml']) ) ? ( ($HTTP_POST_VARS['allowhtml']) ? TRUE : 0 ) : $userdata['user_allowhtml'];
		$allowbbcode = ( isset($HTTP_POST_VARS['allowbbcode']) ) ? ( ($HTTP_POST_VARS['allowbbcode']) ? TRUE : 0 ) : $userdata['user_allowbbcode'];
		$allowsmilies = ( isset($HTTP_POST_VARS['allowsmilies']) ) ? ( ($HTTP_POST_VARS['allowsmilies']) ? TRUE : 0 ) : $userdata['user_allowsmile'];
		$custom_color = ( isset($HTTP_POST_VARS['custom_color']) ) ? xhtmlspecialchars($HTTP_POST_VARS['custom_color']) : $userdata['user_custom_color'];
	}

	$user_style = get_vars('style', $board_config['default_style'], 'POST');
	$language   = get_vars('language', '', 'POST');

	if ( !empty($language) )
	{
		if ( preg_match('/^[a-z_]+$/i', $language) )
		{
			$user_lang = xhtmlspecialchars($language);
		}
		else
		{
			$error = true;
			$error_msg = $lang['Fields_empty'];
		}
	}
	else
	{
		$user_lang = $board_config['default_lang'];
	}

	$user_timezone = ( isset($HTTP_POST_VARS['timezone']) ) ? doubleval($HTTP_POST_VARS['timezone']) : $board_config['board_timezone'];
	$user_sig_image_upload = ( !empty($HTTP_POST_VARS['sig_image_url']) && !is_array($HTTP_POST_VARS['sig_image_url']) ) ? trim($HTTP_POST_VARS['sig_image_url']) : ( ( $HTTP_POST_FILES['sig_image']['tmp_name'] != "none") ? $HTTP_POST_FILES['sig_image']['tmp_name'] : '' );
	$user_sig_image_name = ( !empty($HTTP_POST_FILES['sig_image']['name']) ) ? $HTTP_POST_FILES['sig_image']['name'] : '';
	$user_sig_image_size = ( !empty($HTTP_POST_FILES['sig_image']['size']) ) ? $HTTP_POST_FILES['sig_image']['size'] : 0;
	$user_sig_image_type = ( !empty($HTTP_POST_FILES['sig_image']['type']) ) ? $HTTP_POST_FILES['sig_image']['type'] : '';
	$user_sig_image = ( empty($user_sig_image_upload) && $mode == 'editprofile' ) ? $userdata['user_sig_image'] : '';
    $user_avatar_local = ( isset($HTTP_POST_VARS['avatarselect']) && !empty($HTTP_POST_VARS['submitavatar']) && $board_config['allow_avatar_local']  && !is_array($HTTP_POST_VARS['avatarselect']) ) ? xhtmlspecialchars($HTTP_POST_VARS['avatarselect']) : xhtmlspecialchars(get_vars('avatarlocal', '', 'POST'));
	$user_avatar_category = ($board_config['allow_avatar_local']) ? get_vars('avatarcatname', '', 'POST') : '';
	$user_avatar_remoteurl = trim(xhtmlspecialchars(get_vars('avatarremoteurl', '', 'POST')));
	$user_avatar_upload = ( !empty($HTTP_POST_VARS['avatarurl']) && !is_array($HTTP_POST_VARS['avatarurl']) ) ? trim($HTTP_POST_VARS['avatarurl']) : ( ( $HTTP_POST_FILES['avatar']['tmp_name'] != "none") ? $HTTP_POST_FILES['avatar']['tmp_name'] : '' );
	$user_avatar_name = ( !empty($HTTP_POST_FILES['avatar']['name']) ) ? $HTTP_POST_FILES['avatar']['name'] : '';
	$user_avatar_size = ( !empty($HTTP_POST_FILES['avatar']['size']) ) ? $HTTP_POST_FILES['avatar']['size'] : 0;
	$user_avatar_filetype = ( !empty($HTTP_POST_FILES['avatar']['type']) ) ? $HTTP_POST_FILES['avatar']['type'] : '';
	$user_avatar = ( empty($user_avatar_local) && $mode == 'editprofile' ) ? $userdata['user_avatar'] : '';
	$user_avatar_type = ( empty($user_avatar_local) && $mode == 'editprofile' ) ? $userdata['user_avatar_type'] : '';

	if ( (isset($HTTP_POST_VARS['avatargallery']) || isset($HTTP_POST_VARS['submitavatar']) || isset($HTTP_POST_VARS['cancelavatar'])) && (!isset($HTTP_POST_VARS['submit'])) )
	{
		$username = stripslashes($username);
		$email = stripslashes($email);
		$cur_password = xhtmlspecialchars(stripslashes($cur_password));
		$new_password = xhtmlspecialchars(stripslashes($new_password));
		$password_confirm = xhtmlspecialchars(stripslashes($password_confirm));

		$icq = stripslashes($icq);
		$aim = stripslashes($aim);
		$msn = stripslashes($msn);
		$yim = stripslashes($yim);
		$website = stripslashes($website);
		$location = stripslashes($location);
		$occupation = stripslashes($occupation);
		$interests = stripslashes($interests);
		$custom_color = stripslashes($custom_color);
		$custom_rank = stripslashes($custom_rank);
		$signature = xhtmlspecialchars(stripslashes($signature));
		$user_lang = stripslashes($user_lang);
		if ( $custom_fields_exists )
		{
			for($i = 0; $i < count($fields_array); $i++)
			{
				$$fields_array[$i] = stripslashes($$fields_array[$i]);
			}
		}

		if ( !isset($HTTP_POST_VARS['cancelavatar']) )
		{
			$user_avatar = $user_avatar_category . '/' . $user_avatar_local;
			$user_avatar_type = USER_AVATAR_GALLERY;
		}
	}
}

//
// Let's make sure the user isn't logged in while registering,
// and ensure that they were trying to register a second time
// (Prevents double registrations)
//
if ($mode == 'register' && ($userdata['session_logged_in'] || $username == $userdata['username']))
{
	message_die(GENERAL_MESSAGE, $lang['Username_taken'], '', __LINE__, __FILE__);
}

//
// Did the user submit? In this case build a query to update the users profile in the DB
//

$birth_format = 'd-m-Y';

$is_mod = false;
if ( $userdata['user_level'] == MOD && $userdata['user_level'] != ADMIN && !$userdata['user_jr'] )
{
	$is_mod = true;
}
$max_sig_chars = $board_config['max_sig_chars'];
$max_sig_chars_admin = ($board_config['max_sig_chars_admin'] > 1) ? $board_config['max_sig_chars_admin'] : 1;
$max_sig_chars_mod = ($board_config['max_sig_chars_mod'] > 1) ? $board_config['max_sig_chars_mod'] : 1;
if ( $userdata['user_level'] == ADMIN || $userdata['user_jr'] )
{
	$max_sig_chars = ( $board_config['max_sig_chars'] * $max_sig_chars_admin );
}
else if ( $is_mod || $userdata['user_jr'] )
{
	$max_sig_chars = ( $board_config['max_sig_chars'] * $max_sig_chars_admin );
}

if ( isset($HTTP_POST_VARS['submit']) )
{
	include($phpbb_root_path . 'includes/usercp_avatar.'.$phpEx);
	include($phpbb_root_path . 'includes/usercp_signature.'.$phpEx);

	$passwd_sql = '';

	if ( $mode == 'editprofile' || $mode == 'register' )
	{
		if ( $board_config['require_aim'] && $board_config['cgg']) $require_aim = empty($aim);
		if ( $board_config['require_gender'] && $board_config['gender']) $require_gender = empty($gender);
		if ( $board_config['require_website'] ) $require_website = empty($website);
		if ( $board_config['require_location'] ) $require_location = empty($location);
		if ( !empty($require_aim) || !empty($require_website) || !empty($require_location) || !empty($require_gender))
		{
			$error = TRUE;
			$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Fields_empty'];
		}

		if ( $custom_fields_exists )
		{
			include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_custom_fields.' . $phpEx);
			for($i = 0; $i < count($custom_fields[0]); $i++)
			{
				$split_field = 'user_field_' . $custom_fields[0][$i];
				$unhtml_specialchars_match = array('#&gt;#', '#&lt;#', '#&quot;#', '#&amp;#', '#&nbsp;#');
				$unhtml_specialchars_replace = array('>', '<', '"', '&', '');
				$split_field_test = preg_replace($unhtml_specialchars_match, $unhtml_specialchars_replace, $$split_field);

				if ( $custom_fields[5][$i] && empty($split_field_test) && ( $mode == 'register' || ($mode == 'editprofile' && $custom_fields[11][$i]) ))
				{
					$error = TRUE;
					$current_lang_field = (isset($lang[$custom_fields[1][$i]])) ? $lang[$custom_fields[1][$i]] : $custom_fields[1][$i];
					$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . sprintf($lang['CF_required'], $current_lang_field);
				}
				else if ( !empty($split_field_test) && !$custom_fields[6][$i] )
				{
					if ( $custom_fields[4][$i] && !is_numeric($split_field_test) )
					{
						$error = TRUE;
						$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . sprintf($lang['CF_no_numeric'], $custom_fields[1][$i]);
					}
					else if ( strlen($split_field_test) > $custom_fields[2][$i] )
					{
						$error = TRUE;
						$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . sprintf($lang['CF_too_long'], $custom_fields[1][$i], $custom_fields[2][$i]);
					}
					else if ( strlen($split_field_test) < $custom_fields[3][$i] )
					{
						$error = TRUE;
						$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . sprintf($lang['CF_too_short'], $custom_fields[1][$i], $custom_fields[3][$i]);
					}
				}
				else if ( $custom_fields[6][$i] )
				{
					$options = explode(',', $custom_fields[6][$i]);
					$remove = true;
					for ($j = 0; $j+1 <= count($options); $j++) 
					{
						$remove = ($$split_field == $options[$j]) ? false : $remove;
					}
					if ( $remove && $custom_fields[5][$i] )
					{
						$error = TRUE;
						$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . sprintf($lang['CF_no_jumpbox'], $custom_fields[1][$i]);
					}
				}
			}
		}
	}
	if ( $mode == 'editprofile' )
	{
		if ( $user_id != $userdata['user_id'] )
		{
			$error = TRUE;
			$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Wrong_Profile'];
		}
	}
	else if ( $mode == 'register' )
	{
		if ( empty($username) || empty($new_password) || empty($password_confirm) || empty($email) || $require_aim || $require_website || $require_location || $require_gender )
		{
			$error = TRUE;
			$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Fields_empty'];
		}
		if( !przemo_check_hash($HTTP_POST_VARS['przemo_hash']) )
		{
			$error      = TRUE;
			$error_msg .= ( ( !empty($error_msg) ) ? '<br />' : '' ) . $lang['Invalid_session'];
		}
		if ( $board_config['validate'] && @extension_loaded('zlib') )
		{
			// Anti Robotic Registration
			$sql = "SELECT * FROM " . ANTI_ROBOT_TABLE . "
				WHERE session_id = '" . $userdata['session_id'] . "'
				LIMIT 0, 1";
			if ( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain registration information', '', __LINE__, __FILE__, $sql);
			}

			$anti_robot_row = $db->sql_fetchrow($result);

			$sql = "DELETE FROM " . ANTI_ROBOT_TABLE . "
				WHERE session_id = '" . $userdata['session_id'] . "'";
			if ( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not check registration information', '', __LINE__, __FILE__, $sql);
			}

			if ( ( strtolower($HTTP_POST_VARS['reg_key']) != $anti_robot_row['reg_key'] ) || !$anti_robot_row['reg_key'] )
			{
				$error = TRUE;
				$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Wrong_reg_key'];
			}
		}
	}

	$passwd_sql = '';
	if ( !empty($new_password) && !empty($password_confirm) )
	{
		// validate that the password is complex
		$result = validate_complex_password($username, $new_password);
		if ( $result['error'] )
		{
			$error = TRUE;
			$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $result['error_msg'];
		}
		if ( $new_password != $password_confirm )
		{
			$error = TRUE;
			$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Password_mismatch'];
		}
		else if ( strlen($new_password) > 32 )
		{
			$error = TRUE;
			$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Password_long'];
		}
		else
		{
			if ( $mode == 'editprofile' )
			{
				if ( !phpbb_check_hash($cur_password, $userdata['user_password']) )
				{
					$error = TRUE;
					$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Current_password_mismatch'];
				}
				if ( !$error )
				{
					$new_password = phpbb_hash($new_password);
					$passwd_sql = "user_password = '$new_password', ";
				}
			}
		}
	}
	else if ( ( empty($new_password) && !empty($password_confirm) ) || ( !empty($new_password) && empty($password_confirm) ) )
	{
		$error = TRUE;
		$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Password_mismatch'];
	}

	// Do a ban check on this email address
	if ( $email != $userdata['user_email'] || $mode == 'register' )
	{
		$result = validate_email($email);
		if ( $result['error'] )
		{
			$email = $userdata['user_email'];
			$error = TRUE;
			$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $result['error_msg'];
		}

		if ( $mode == 'editprofile' )
		{
            if ( !phpbb_check_hash($cur_password, $userdata['user_password']) )
			{
				$email = $userdata['user_email'];

				$error = TRUE;
				$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Current_password_mismatch'];
			}
		}
	}
	$username_sql = '';
	if ( $board_config['allow_namechange'] || $mode == 'register' )
	{
		if ( empty($username) )
		{
			$error = TRUE;
			$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Fields_empty'];
		}
		else if ( $username != $userdata['username'] || $mode == 'register' )
		{
			if (strtolower($username) != strtolower($userdata['username']) || $mode == 'register')
			{
				$result = validate_username($username);
				if ( $result['error'] )
				{
					$error = TRUE;
					$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $result['error_msg'];
				}
			}

			if ( !$error )
			{
				$username_sql = "username = '" . str_replace("\'", "''", $username) . "', ";
			}
		}
	}

	if ( !empty($custom_rank) && strlen($custom_rank) > $board_config['max_sig_custom_rank'] )
	{
		$error = TRUE;
		$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['custom_rank_too_long'];
	}

	if ( strlen($location) > $board_config['max_sig_location'] )
	{
		$error = TRUE;
		$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['location_too_long'];
	}

	$signature_sql = '';
	if ( isset($HTTP_POST_VARS['sig_image_del']) && $mode == 'editprofile' )
	{
		$signature_sql = user_signature_delete($userdata['user_sig_image']);
	}

	if ( ( !empty($user_sig_image_upload) || !empty($user_sig_image_name) ) && $board_config['allow_sig'] && $board_config['allow_sig_image'] )
	{
		if ( !empty($user_sig_image_upload) )
		{
			$sig_image_mode = ( !empty($user_sig_image_name) ) ? 'local' : 'remote';
			$userdata_user_sig_image = $userdata['user_sig_image'];
			$signature_sql = user_signature_upload($mode, $sig_image_mode, $userdata_user_sig_image, $error, $error_msg, $user_sig_image_upload, $user_sig_image_name, $user_sig_image_size, $user_sig_image_type);
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
		if ( strlen($signature) > $max_sig_chars )
		{
			$error = TRUE;
			$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Signature_too_long'];
		}

		$signature = ($board_config['allow_sig_image_img']) ? preg_replace(array("#\[img\]#si", "#\[/img\]#i"), "", $signature) : $signature;

		if ( !isset($signature_bbcode_uid) || $signature_bbcode_uid == '' )
		{
			$signature_bbcode_uid = ( $allowbbcode ) ? make_bbcode_uid() : '';
		}
		$signature = prepare_message($signature, $allowhtml, $allowbbcode, $allowsmilies, $signature_bbcode_uid);
	}

	if ( $website != '' )
	{
		rawurlencode($website);
	}
	$avatar_sql = '';

	if ( isset($HTTP_POST_VARS['avatardel']) && $mode == 'editprofile' )
	{
		$avatar_sql = user_avatar_delete($userdata['user_avatar_type'], $userdata['user_avatar']);
	}
	else if ( ( !empty($user_avatar_upload) || !empty($user_avatar_name) ) && $board_config['allow_avatar_upload'] )
	{
		if ( !empty($user_avatar_upload) )
		{
			$avatar_mode = (empty($user_avatar_name)) ? 'remote' : 'local';
			$userdata_user_avatar = $userdata['user_avatar'];
			$userdata_user_avatar_type = $userdata['user_avatar_type'];
			$avatar_sql = user_avatar_upload($mode, $avatar_mode, $userdata_user_avatar, $userdata_user_avatar_type, $error, $error_msg, $user_avatar_upload, $user_avatar_name, $user_avatar_size, $user_avatar_filetype);
		}
		else if ( !empty($user_avatar_name) )
		{
			$l_avatar_size = sprintf($lang['Avatar_filesize'], round($board_config['avatar_filesize'] / 1024));

			$error = true;
			$error_msg .= ( ( !empty($error_msg) ) ? '<br />' : '' ) . $l_avatar_size;
		}
	}
	else if ( $user_avatar_remoteurl != '' && $board_config['allow_avatar_remote'] )
	{
		user_avatar_delete($userdata['user_avatar_type'], $userdata['user_avatar']);
		$avatar_sql = user_avatar_url($mode, $error, $error_msg, $user_avatar_remoteurl);
	}
	else if ( $user_avatar_local != '' && $board_config['allow_avatar_local'] )
	{
		user_avatar_delete($userdata['user_avatar_type'], $userdata['user_avatar']);
		$avatar_sql = user_avatar_gallery($mode, $error, $error_msg, $user_avatar_local, $user_avatar_category);
	}

	if ( !$error )
	{
		if ( $avatar_sql == '' )
		{
			$avatar_sql = ( $mode == 'editprofile' ) ? '' : "'', " . USER_AVATAR_NONE;
		}

		if ( $signature_sql == '' )
		{
			$signature_sql = ( $mode == 'editprofile' ) ? '' : "''";
		}

		if ( $mode == 'editprofile' )
		{
			if ( ($board_config['allow_autologin'] == 2 || $board_config['allow_autologin'] == 1) && ($userdata['user_level'] != USER || $userdata['user_jr']) )
			{
				$user_ip_login_check = $userdata['user_ip_login_check'];
			}

			if ( $email != $userdata['user_email'] && $board_config['require_activation'] != USER_ACTIVATION_NONE && $userdata['user_level'] != ADMIN )
			{
				$user_active = 0;

				$user_actkey = gen_rand_string(true);
				$key_len = 54 - ( strlen($server_url) );
				$key_len = ( $key_len > 6 ) ? $key_len : 6;
				$user_actkey = substr($user_actkey, 0, $key_len);

				if ( $userdata['session_logged_in'] )
				{
					session_end($userdata['session_id'], $userdata['user_id']);
				}
			}
			else
			{
				$user_active = 1;
				$user_actkey = '';
			}

			if ( $userdata['user_level'] > USER && !$board_config['report_disable'] )
			{
				$avatar_sql .= ( isset($HTTP_POST_VARS['no_report_popup']) ) ? ( ', no_report_popup = ' . ( ($HTTP_POST_VARS['no_report_popup']) ? 1 : 0 ) ) : '';
				$avatar_sql .= ( isset($HTTP_POST_VARS['no_report_mail']) ) ? ( ', no_report_mail = ' . ( ($HTTP_POST_VARS['no_report_mail']) ? 1 : 0 ) ) : '';
			}

			$sql_custom_fields = '';
			if ( $custom_fields_exists )
			{
				for($i = 0; $i < count($custom_fields[0]); $i++)
				{
					if ( $custom_fields[11][$i] )
					{
						$split_field = 'user_field_' . $custom_fields[0][$i];
						$sql_custom_fields .= $split_field . ' = \'' . str_replace("\'", "''", $$split_field) . '\',';
					}
				}
			}
			if (empty($custom_rank)) {
				$custom_rank = '';
			}
			$sql = "UPDATE " . USERS_TABLE . "
				SET " . $username_sql . $passwd_sql . "user_email = '" . str_replace("\'", "''", $email) ."', user_icq = '" . str_replace("\'", "''", $icq) . "', user_website = '" . str_replace("\'", "''", $website) . "', user_occ = '" . str_replace("\'", "''", $occupation) . "', user_interests = '" . str_replace("\'", "''", $interests) . "', user_from = '" . str_replace("\'", "''", $location) . "', $sql_custom_fields user_sig = '" . str_replace("\'", "''", $signature) . "', user_custom_color = '" . str_replace("\'", "''", $custom_color) . "', user_custom_rank = '" . str_replace("\'", "''", $custom_rank) . "', user_sig_bbcode_uid = '$signature_bbcode_uid', user_viewemail = $viewemail, user_viewaim = $viewaim, user_aim = '" . str_replace("\'", "''", str_replace(' ', '+', $aim)) . "', user_yim = '" . str_replace("\'", "''", $yim) . "', user_msnm = '" . str_replace("\'", "''", $msn) . "', user_attachsig = $attachsig, user_allowsmile = $allowsmilies, user_allowhtml = $allowhtml, user_allowbbcode = $allowbbcode, user_allow_viewonline = $allowviewonline, user_notify = $notifyreply, user_notify_gg = $user_notify_gg, user_notify_pm = $notifypm, user_popup_pm = $popuppm, user_timezone = $user_timezone, user_lang = '" . str_replace("\'", "''", $user_lang) . "', user_style = $user_style, user_active = $user_active, user_actkey = '" . str_replace("\'", "''", $user_actkey) . "'" . $avatar_sql . $signature_sql . ", user_gender = $gender, allowpm = $allowpm, user_ip_login_check = $user_ip_login_check
				WHERE user_id = $user_id";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not update users table', '', __LINE__, __FILE__, $sql);
			}

			if ( !$user_active )
			{
				// The users account has been deactivated, send them an email with a new activation key
				include($phpbb_root_path . 'includes/emailer.'.$phpEx);
				$emailer = new emailer($board_config['smtp_delivery']);

				if ( $board_config['require_activation'] != USER_ACTIVATION_ADMIN )
				{
					$emailer->from($board_config['email_from']);
					$emailer->replyto($board_config['email_return_path']);

					$emailer->use_template('user_activate', stripslashes($user_lang));
					$emailer->email_address($email);
					$emailer->set_subject($lang['Reactivate']);

					$emailer->assign_vars(array(
						'SITENAME' => $board_config['sitename'],
						'USERNAME' => preg_replace($unhtml_specialchars_match, $unhtml_specialchars_replace, substr(str_replace("\'", "'", $username), 0, 25)),
						'EMAIL_SIG' => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '',

						'U_ACTIVATE' => $server_url . '?mode=activate&' . POST_USERS_URL . '=' . $user_id . '&act_key=' . $user_actkey)
					);
					$emailer->send();
					$emailer->reset();
				}
				else if ( $board_config['require_activation'] == USER_ACTIVATION_ADMIN )
				{
					$sql = 'SELECT user_email, user_lang 
						FROM ' . USERS_TABLE . '
						WHERE user_level = ' . ADMIN;

					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not select Administrators', '', __LINE__, __FILE__, $sql);
					}

					while ($row = $db->sql_fetchrow($result))
					{
						$emailer->from($board_config['board_email']);
						$emailer->replyto($board_config['board_email']);

						$emailer->email_address(trim($row['user_email']));
						$emailer->use_template("admin_activate", $row['user_lang']);
						$emailer->set_subject($lang['Reactivate']);

						$emailer->assign_vars(array(
							'USERNAME' => preg_replace($unhtml_specialchars_match, $unhtml_specialchars_replace, substr(str_replace("\'", "'", $username), 0, 25)),
							'EMAIL_SIG' => str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']),
 
							'U_ACTIVATE' => $server_url . '?mode=activate&' . POST_USERS_URL . '=' . $user_id . '&act_key=' . $user_actkey)
						);
						$emailer->send();
						$emailer->reset();
					}
					$db->sql_freeresult($result);
				}

				$message = $lang['Profile_updated_inactive'] . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');
			}
			else
			{
				$message = $lang['Profile_updated'] . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');
			}

			message_die(GENERAL_MESSAGE, $message);
		}
		else
		{
			$new_password = phpbb_hash($new_password);

			if ( $custom_fields_exists )
			{
				$sql_custom_fields = '';
				$sql_custom_values = '';
				for($i = 0; $i < count($custom_fields[0]); $i++)
				{
					if ( $custom_fields[11][$i] || $mode == 'register' )
					{
						$split_field = 'user_field_' . $custom_fields[0][$i];
						$sql_custom_fields .= $split_field . ',';
						$sql_custom_values .= '\'' . str_replace("\'", "''", $$split_field) . '\', ';
					}
				}
			}

			if ( $adv_person_field && $HTTP_COOKIE_VARS[$unique_cookie_name . '_adp'] )
			{
				@setcookie($unique_cookie_name . '_adp_lock', 1, (CR_TIME + 31536000), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);

				$adv_person = intval($HTTP_COOKIE_VARS[$unique_cookie_name . '_adp']);

				$adv_user_data = get_userdata($adv_person);
				if ( $adv_user_data )
				{
					$sql = "SELECT user_ip
						FROM " . USERS_TABLE . "
						WHERE user_id = $adv_person";
					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not obtain user information', '', __LINE__, __FILE__, $sql);
					}
					$row = $db->sql_fetchrow($result);
					$adv_person_ip = $row['user_ip'];

					$sql = "SELECT MAX(u.user_regdate) as time
						FROM (" . USERS_TABLE . " u, " . ADV_PERSON_TABLE . " a)
						WHERE a.person_id = u.user_id
							AND a.user_id = $adv_person";
					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not obtain user information', '', __LINE__, __FILE__, $sql);
					}

					$row = $db->sql_fetchrow($result);
					$last_time = $row['time'];

					$sql = "SELECT COUNT(person_ip) as ip_total
						FROM " . ADV_PERSON_TABLE . "
						WHERE person_ip = '$user_ip'";
					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not obtain user adv information', '', __LINE__, __FILE__, $sql);
					}
					$row = $db->sql_fetchrow($result);

					if ( $row['ip_total'] < 1 && !$HTTP_COOKIE_VARS[$unique_cookie_name . '_adp_lock'] && (!$last_time || $last_time < CR_TIME - ($board_config['adv_person_time'] * 60)) && $adv_person_ip != $user_ip )
					{
						$sql = "SELECT $adv_person_field
							FROM " . USERS_TABLE . "
							WHERE user_id = $adv_person";
						if ( !($result = $db->sql_query($sql)) )
						{
							message_die(GENERAL_ERROR, 'Could not obtain user adv information', '', __LINE__, __FILE__, $sql);
						}
						$row = $db->sql_fetchrow($result);
						$new_val = $row[$adv_person_field] + 1;

						$sql = "UPDATE " . USERS_TABLE . "
							SET $adv_person_field = $new_val
							WHERE user_id = $adv_person";
						if ( !($result = $db->sql_query($sql)) )
						{
							message_die(GENERAL_ERROR, 'Could not update users table', '', __LINE__, __FILE__, $sql);
						}
					}
					$sql = "INSERT INTO " . ADV_PERSON_TABLE . " (user_id, person_id, person_ip)
						VALUES ($adv_person, $user_id, '$user_ip')";
					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not insert data into adv users table', '', __LINE__, __FILE__, $sql);
					}
				}
			}

			$sql = "INSERT INTO " . USERS_TABLE . " (username, user_regdate, user_password, user_email, user_icq, user_website, user_occ, user_interests, user_from, " . $sql_custom_fields . " user_sig, user_sig_bbcode_uid, user_sig_image, user_avatar, user_avatar_type, user_viewemail, user_viewaim, user_aim, user_yim, user_msnm, user_attachsig, user_allowsmile, user_allowhtml, user_allowbbcode, user_allow_viewonline, user_notify, user_notify_gg, user_notify_pm, user_popup_pm, user_timezone, user_lang, user_custom_color, user_custom_rank, user_style, user_gender, allowpm, user_level, user_allow_pm, user_ip, user_ip_login_check, user_active, user_actkey)
				VALUES ('" . str_replace("\'", "''", $username) . "', " . CR_TIME . ", '" . str_replace("\'", "''", $new_password) . "', '" . str_replace("\'", "''", $email) . "', '" . str_replace("\'", "''", $icq) . "', '" . str_replace("\'", "''", $website) . "', '" . str_replace("\'", "''", $occupation) . "', '" . str_replace("\'", "''", $interests) . "', '" . str_replace("\'", "''", $location) . "', " . $sql_custom_values . " '" . str_replace("\'", "''", $signature) . "', '$signature_bbcode_uid', $signature_sql, $avatar_sql, $viewemail, $viewaim, '" . str_replace("\'", "''", str_replace(' ', '+', $aim)) . "', '" . str_replace("\'", "''", $yim) . "', '" . str_replace("\'", "''", $msn) . "', $attachsig, $allowsmilies, $allowhtml, $allowbbcode, $allowviewonline, $notifyreply, $user_notify_gg, $notifypm, $popuppm, $user_timezone, '" . str_replace("\'", "''", $user_lang) . "', '" . str_replace("\'", "''", $custom_color) . "', '" . str_replace("\'", "''", $custom_rank) . "', $user_style, '$gender', $allowpm, 0, 1, '$user_ip', $user_ip_login_check, ";

			if ( $board_config['require_activation'] == USER_ACTIVATION_SELF || $board_config['require_activation'] == USER_ACTIVATION_ADMIN || $coppa )
			{
				$user_actkey = gen_rand_string(true);
				$key_len = 54 - (strlen($server_url));
				$key_len = ( $key_len > 6 ) ? $key_len : 6;
				$user_actkey = substr($user_actkey, 0, $key_len);
				$sql .= "0, '" . str_replace("\'", "''", $user_actkey) . "')";
			}
			else
			{
				$sql .= "1, '')";
			}

			if ( !($result = $db->sql_query($sql, BEGIN_TRANSACTION)) )
			{
				message_die(GENERAL_ERROR, 'Could not insert data into users table', '', __LINE__, __FILE__, $sql);
			}
			
			$user_id = $db->sql_nextid();
			if ( $board_config['allow_photo_upload'] && $mode != 'register' )
			{
				$profilephoto_mod->photo_insert($mode);
			}

			$sql = "INSERT INTO " . GROUPS_TABLE . " (group_name, group_description, group_single_user, group_moderator)
				VALUES ('', 'Personal User', 1, 0)";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not insert data into groups table', '', __LINE__, __FILE__, $sql);
			}

			$group_id = $db->sql_nextid();

			$sql = "INSERT INTO " . USER_GROUP_TABLE . " (user_id, group_id, user_pending)
				VALUES ($user_id, $group_id, 0)";
			if ( !($result = $db->sql_query($sql, END_TRANSACTION)) )
			{
				message_die(GENERAL_ERROR, 'Could not insert data into user_group table', '', __LINE__, __FILE__, $sql);
			}

			db_stat_update('newestuser');

			$log_me_automatically = false;

			if ( $coppa )
			{
				$message = $lang['COPPA'];
				$email_template = 'coppa_welcome_inactive';
			}
			else if ( $board_config['require_activation'] == USER_ACTIVATION_SELF )
			{
				$message = sprintf($lang['Account_inactive'], stripslashes($email));
				$email_template = 'user_welcome_inactive';
			}
			else if ( $board_config['require_activation'] == USER_ACTIVATION_ADMIN )
			{
				$message = $lang['Account_inactive_admin'];
				$email_template = 'admin_welcome_inactive';
			}
			else
			{
				$log_me_automatically = true;
				$email_template = 'user_welcome';
			}

			$sql = "SELECT ug.user_id, g.group_id as g_id, g.group_name , u.user_posts, g.group_count
				FROM (" . GROUPS_TABLE . " g, " . USERS_TABLE . " u)
				LEFT JOIN " . USER_GROUP_TABLE . " ug ON (g.group_id = ug.group_id
					AND ug.user_id = $user_id)
				WHERE u.user_id = $user_id
					AND ug.user_id is NULL
					AND g.group_count = 0
					AND g.group_single_user = 0
					AND g.group_moderator <> $user_id";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Error geting users post stat', '', __LINE__, __FILE__, $sql);
			}
			$clear_cache = false;
			while ($group_data = $db->sql_fetchrow($result))
			{
				//user join a autogroup
				$sql = "INSERT INTO " . USER_GROUP_TABLE . " (group_id, user_id, user_pending)
					VALUES (" . $group_data['g_id'] . ", $user_id, 0)";
				if ( !($db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Error inserting user group, group count', '', __LINE__, __FILE__, $sql);
				}
				$clear_cache = true;
			}

			if ( $clear_cache )
			{
				sql_cache('clear', 'user_groups');
				sql_cache('clear', 'groups_data');
				sql_cache('clear', 'moderators_list');
			}

			include($phpbb_root_path . 'includes/emailer.'.$phpEx);
			$emailer = new emailer($board_config['smtp_delivery']);

			$emailer->from($board_config['email_from']);
			$emailer->replyto($board_config['email_return_path']);

			$emailer->use_template($email_template, stripslashes($user_lang));
			$emailer->email_address($email);
			$emailer->set_subject(sprintf($lang['Welcome_subject'], $board_config['sitename']));

			if ( $coppa )
			{
				$emailer->assign_vars(array(
					'SITENAME' => $board_config['sitename'],
					'WELCOME_MSG' => sprintf($lang['Welcome_subject'], $board_config['sitename']),
					'USERNAME' => preg_replace($unhtml_specialchars_match, $unhtml_specialchars_replace, substr(str_replace("\'", "'", $username), 0, 25)),
					'PASSWORD' => $password_confirm,
					'EMAIL_SIG' => str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']),

					'FAX_INFO' => $board_config['coppa_fax'],
					'MAIL_INFO' => $board_config['coppa_mail'],
					'EMAIL_ADDRESS' => $email,
					'ICQ' => $icq,
					'AIM' => $aim,
					'YIM' => $yim,
					'MSN' => $msn,
					'WEB_SITE' => $website,
					'FROM' => $location,
					'OCC' => $occupation,
					'INTERESTS' => $interests,
					'SITENAME' => $board_config['sitename']));
			}
			else
			{
				$emailer->assign_vars(array(
					'SITENAME' => $board_config['sitename'],
					'WELCOME_MSG' => sprintf($lang['Welcome_subject'], $board_config['sitename']),
					'USERNAME' => preg_replace($unhtml_specialchars_match, $unhtml_specialchars_replace, substr(str_replace("\'", "'", $username), 0, 25)),
					'PASSWORD' => $password_confirm,
					'EMAIL_SIG' => str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']),

					'U_ACTIVATE' => $server_url . '?mode=activate&' . POST_USERS_URL . '=' . $user_id . '&act_key=' . $user_actkey)
				);
			}

			$emailer->send();
			$emailer->reset();

			if ( $board_config['require_activation'] == USER_ACTIVATION_ADMIN )
			{
				$sql = "SELECT user_email, user_lang 
					FROM " . USERS_TABLE . "
					WHERE user_level = " . ADMIN;
				
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not select Administrators', '', __LINE__, __FILE__, $sql);
				}
				
				while ($row = $db->sql_fetchrow($result))
				{
					$emailer->from($board_config['email_from']);
					$emailer->replyto($board_config['email_return_path']);

					$emailer->email_address(trim($row['user_email']));
					$emailer->use_template("admin_activate", $row['user_lang']);
					$emailer->set_subject($lang['New_account_subject']);

					$emailer->assign_vars(array(
						'USERNAME' => preg_replace($unhtml_specialchars_match, $unhtml_specialchars_replace, substr(str_replace("\'", "'", $username), 0, 25)),
						'EMAIL_SIG' => str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']),

						'U_ACTIVATE' => $server_url . '?mode=activate&' . POST_USERS_URL . '=' . $user_id . '&act_key=' . $user_actkey)
					);
					$emailer->send();
					$emailer->reset();
				}
				$db->sql_freeresult($result);
			}

			$message = $message . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');

			if ( $log_me_automatically )
			{
				$session_id = session_begin($user_id, $user_ip, PAGE_INDEX, FALSE, 0);
				$welcome_message = ($gender == 2) ? $lang['Account_added_she'] : $lang['Account_added'];
				message_die(GENERAL_MESSAGE, $welcome_message);
			}

			message_die(GENERAL_MESSAGE, $message);
		}
	}
}

if ( $error )
{
	// If an error occured we need to stripslashes on returned data
	$username = stripslashes($username);
	$email = stripslashes($email);
	$new_password = '';
	$password_confirm = '';

	$icq = stripslashes($icq);
	$aim = str_replace('+', ' ', stripslashes($aim));
	$msn = stripslashes($msn);
	$yim = stripslashes($yim);
	$website = stripslashes($website);
	$location = stripslashes($location);
	$occupation = stripslashes($occupation);
	$interests = stripslashes($interests);
	$custom_color = stripslashes($custom_color);
	$custom_rank = stripslashes($custom_rank);
	$signature = stripslashes($signature);
	$signature = ($signature_bbcode_uid != '') ? preg_replace("/:(([a-z0-9]+:)?)$signature_bbcode_uid(=|\])/si", '\\3', $signature) : $signature;
	if ( $custom_fields_exists )
	{
		for($i = 0; $i < count($fields_array); $i++)
		{
			$$fields_array[$i] = stripslashes($$fields_array[$i]);
		}
	}
	$user_lang = stripslashes($user_lang);
}
else if ( $mode == 'editprofile' && !isset($HTTP_POST_VARS['avatargallery']) && !isset($HTTP_POST_VARS['submitavatar']) && !isset($HTTP_POST_VARS['cancelavatar']) )
{
	$user_id = $userdata['user_id'];
	$username = $userdata['username'];
	$email = $userdata['user_email'];
	$new_password = '';
	$password_confirm = '';

	$icq = $userdata['user_icq'];
	$aim = str_replace('+', ' ', $userdata['user_aim']);
	$msn = $userdata['user_msnm'];
	$yim = $userdata['user_yim'];

	$website = $userdata['user_website'];
	$location = $userdata['user_from'];
	$occupation = $userdata['user_occ'];
	$interests = $userdata['user_interests'];
	$gender = $userdata['user_gender'];
	$custom_color = $userdata['user_custom_color'];
	$custom_rank = $userdata['user_custom_rank'];
	$signature_bbcode_uid = $userdata['user_sig_bbcode_uid'];
	$signature = ($signature_bbcode_uid != '') ? preg_replace("/:(([a-z0-9]+:)?)$signature_bbcode_uid(=|\])/si", '\\3', $userdata['user_sig']) : $userdata['user_sig'];
	$viewemail = $userdata['user_viewemail'];
	$viewaim = $userdata['user_viewaim'];
	$allowpm = $userdata['allowpm'];
	$user_ip_login_check = $userdata['user_ip_login_check'];
	$notifypm = $userdata['user_notify_pm'];
	$user_notify_gg = $userdata['user_notify_gg'];
	$popuppm = $userdata['user_popup_pm'];
	$notifyreply = $userdata['user_notify'];
	$attachsig = ( $userdata['user_allowsig'] ) ? $userdata['user_attachsig'] : '';
	$allowhtml = $userdata['user_allowhtml'];
	$allowbbcode = $userdata['user_allowbbcode'];
	$allowsmilies = $userdata['user_allowsmile'];
	$allowviewonline = $userdata['user_allow_viewonline'];
	if ( $board_config['viewonline'] == '1' && $userdata['user_level'] != ADMIN )
	{
		$allowviewonline = 1;
	}
	else if ( $board_config['viewonline'] == '2' && $userdata['user_level'] != ADMIN )
	{
		$allowviewonline = 0;
	}
	$user_sig_image = $userdata['user_sig_image'];
	$user_avatar = ( $userdata['user_allowavatar'] ) ? $userdata['user_avatar'] : '';
	$user_avatar_type = ( $userdata['user_allowavatar'] ) ? $userdata['user_avatar_type'] : USER_AVATAR_NONE;
	$user_style = $userdata['user_style'];
	$user_lang = $userdata['user_lang'];
	$user_timezone = $userdata['user_timezone'];

	if ( $custom_fields_exists )
	{
		for($i = 0; $i < count($fields_array); $i++)
		{
			$$fields_array[$i] = $userdata[stripslashes($fields_array[$i])];
		}
	}
}

// Default pages
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

make_jumpbox('viewforum.'.$phpEx);

if ( $mode == 'editprofile' )
{
	if ( $user_id != $userdata['user_id'] )
	{
		$error = TRUE;
		$error_msg = $lang['Wrong_Profile'];
	}
}

if ( isset($HTTP_POST_VARS['avatargallery']) && !$error )
{
	include($phpbb_root_path . 'includes/usercp_avatar.'.$phpEx);

	$avatar_category = ( !empty($HTTP_POST_VARS['avatarcategory']) ) ? xhtmlspecialchars($HTTP_POST_VARS['avatarcategory']) : '';

	$template->set_filenames(array(
		'body' => 'profile_avatar_gallery.tpl')
	);

	$allowviewonline = !$allowviewonline;

	if ( $custom_fields_exists )
	{
		for($i = 0; $i < count($fields_array); $i++)
		{
			$optional_fields[] = $fields_array[$i];
			$optional_values[] = $$fields_array[$i];
		}
	}
	else
	{
		$optional_values = '';
		$optional_fields = '';
	}

	$userdata_session_id = $userdata['session_id'];

	display_avatar_gallery($mode, $avatar_category, $user_id, $email, $current_email, $coppa, $username, $email, $new_password, $cur_password, $password_confirm, $icq, $aim, $msn, $yim, $website, $location, $optional_fields, $optional_values, $occupation, $interests, $gender, $allowpm, $user_ip_login_check, $b_day, $b_md, $b_year, $signature, $user_sig_image, $viewemail, $viewaim, $notifypm, $user_notify_gg, $popuppm, $icq, $notifyreply, $attachsig, $allowhtml, $allowbbcode, $allowsmilies, $allowviewonline, $user_style, $user_lang, $user_timezone, $custom_color, $custom_rank, $userdata_session_id, $verify_user);
}
else
{
	include($phpbb_root_path . 'includes/functions_selects.'.$phpEx);

	if ( !isset($coppa) )
	{
		$coppa = FALSE;
	}

	if ( !isset($user_style) )
	{
		$user_style = $board_config['default_style'];
	}

	$signature_image = ( $user_sig_image != '' ) ? '<img src="' . $board_config['sig_images_path'] . '/' . $user_sig_image . '" alt="" />' : '';
	$avatar_img = '';
	if ( $user_avatar_type )
	{
		switch( $user_avatar_type )
		{
	        case USER_AVATAR_UPLOAD:
	            $avatar_img = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $user_avatar . '" alt="" />' : '';
	            break;
	        case USER_AVATAR_REMOTE:
	            $avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $user_avatar . '" alt="" />' : '';
	            break;
	        case USER_AVATAR_GALLERY:
	            $avatar_img = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $user_avatar . '" alt="" />' : '';
	            break;
		}
	}

	$s_hidden_fields = '<input type="hidden" name="mode" value="' . $mode . '" /><input type="hidden" name="agreed" value="true" /><input type="hidden" name="coppa" value="' . $coppa . '" />';
	if ( $mode == 'editprofile' )
	{
		$s_hidden_fields .= '<input type="hidden" name="user_id" value="' . $userdata['user_id'] . '" />';
		$s_hidden_fields .= '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
		$s_hidden_fields .= '<input type="hidden" name="verify_user" value="' . $verify_user . '" />';
		// Send the users current email address. If they change it, and account activation is turned on
		// the user account will be disabled and the user will have to reactivate their account.
		$s_hidden_fields .= '<input type="hidden" name="current_email" value="' . $userdata['user_email'] . '" />';
	}else{
        $s_hidden_fields .= '<input type="hidden" name="przemo_hash" value="'.przemo_create_hash().'" />';
    }

	if ( !empty($user_avatar_local) )
	{
		$s_hidden_fields .= '<input type="hidden" name="avatarlocal" value="' . $user_avatar_local . '" /><input type="hidden" name="avatarcatname" value="' . $user_avatar_category . '" />';
	}

	$html_status =	( $userdata['user_allowhtml'] && $board_config['allow_html'] ) ? $lang['HTML_is_ON'] : $lang['HTML_is_OFF'];
	$bbcode_status = ( $userdata['user_allowbbcode'] && $board_config['allow_bbcode'] ) ? $lang['BBCode_is_ON'] : $lang['BBCode_is_OFF'];
	$smilies_status = ( $userdata['user_allowsmile'] && $board_config['allow_smilies'] ) ? $lang['Smilies_are_ON'] : $lang['Smilies_are_OFF'];

	switch ($gender)
	{
		case 1:
			$gender_male_checked = 'checked="checked"';
		break;
		case 2:
			$gender_female_checked = 'checked="checked"';
		break;
		default:
			$gender_no_specify_checked = 'checked="checked"';
	}

	if ( $error )
	{
		$template->set_filenames(array(
			'reg_header' => 'error_body.tpl')
		);
		$template->assign_vars(array(
			'ERROR_MESSAGE' => $error_msg)
		);
		$template->assign_var_from_handle('ERROR_BOX', 'reg_header');
	}

	$template->set_filenames(array(
		'body' => 'profile_add_body.tpl')
	);

	if ( $mode == 'editprofile' )
	{
		$template->assign_block_vars('switch_edit_profile', array());

		if ( $board_config['allow_autologin'] == 2 && $userdata['user_level'] == USER && !$userdata['user_jr'] )
		{
			$template->assign_block_vars('switch_ip_login_check', array());
		}

		if ( (!$board_config['report_disable']) && (( $userdata['user_level'] > USER && !$board_config['report_only_admin'] ) || $userdata['user_level'] == ADMIN) )
		{
			$template->assign_block_vars('switch_report', array(
				'L_NO_REPORT_POPUP' => $lang['Report_no_popup'],
				'NO_REPORT_POPUP_YES' => (!$userdata['no_report_popup'] ) ? 'checked="checked"' : '',
				'NO_REPORT_POPUP_NO' => ($userdata['no_report_popup'] ) ? 'checked="checked"' : '',

				'L_NO_REPORT_MAIL' => $lang['Report_no_mail'],
				'NO_REPORT_MAIL_YES' => (!$userdata['no_report_mail'] ) ? 'checked="checked"' : '',
				'NO_REPORT_MAIL_NO' => ($userdata['no_report_mail'] ) ? 'checked="checked"' : '')
			);
		}
	}

	if ( $mode == 'register') 
    { 
        $template->assign_block_vars('switch_register', array()); 
    }
	
	if ( ($mode == 'register') || ($board_config['allow_namechange']) )
	{
		$template->assign_block_vars('switch_namechange_allowed', array());
	}
	else
	{
		$template->assign_block_vars('switch_namechange_disallowed', array());
	}

	// Let's do an overall check for settings/versions which would prevent
	// us from doing file uploads....
	$ini_val = ( phpversion() >= '4.0.0' ) ? 'ini_get' : 'get_cfg_var';
	$form_enctype = ( @$ini_val('file_uploads') == '0' || strtolower(@$ini_val('file_uploads') == 'off') || phpversion() == '4.0.4pl1' || ( !$board_config['allow_avatar_upload'] && !$board_config['allow_sig_image'] ) || ( phpversion() < '4.0.3' && @$ini_val('open_basedir') != '' ) ) ? '' : 'enctype="multipart/form-data"';

	$default_select = ($custom_color == '' ) ? 'selected="selected"' : '';
	$dark_red_select = ($custom_color == 'CC0000' ) ? 'selected="selected"' : '';
	$red_select = ($custom_color == 'FF3300' ) ? 'selected="selected"' : '';
	$orange_select = ($custom_color == 'FF9900') ? 'selected="selected"' : '';
	$brown_select = ($custom_color == '800000') ? 'selected="selected"' : '';
	$yellow_select = ($custom_color == 'FFFF00') ? 'selected="selected"' : '';
	$green_select = ($custom_color == '008000') ? 'selected="selected"' : '';
	$olive_select = ($custom_color == '808000') ? 'selected="selected"' : '';
	$cyan_select = ($custom_color == '33FFFF') ? 'selected="selected"' : '';
	$blue_select = ($custom_color == '3366FF') ? 'selected="selected"' : '';
	$dark_blue_select = ($custom_color == '000080') ? 'selected="selected"' : '';
	$indigo_select = ($custom_color == '990099') ? 'selected="selected"' : '';
	$violet_select = ($custom_color == 'CC66CC') ? 'selected="selected"' : '';
	$white_select = ($custom_color == 'F5FFFA') ? 'selected="selected"' : '';
	$black_select = ($custom_color == '000000') ? 'selected="selected"' : '';

	if ( $board_config['validate'] && @extension_loaded('zlib') )
	{
		$key = '';
		$max_length_reg_key = 4;
		$chars = array('1','2','3','4','5','6','7','8','9');

		$count = count($chars) - 1;
		srand((double)microtime()*1000000);

		for($i = 0; $i < $max_length_reg_key; $i++)
		{
			$key .= $chars[rand(0, $count)];
		}

		if ( $mode == 'register' )
		{
			$sql = "DELETE FROM " . ANTI_ROBOT_TABLE . "
				WHERE timestamp < '" . (CR_TIME - 3600) . "'
				OR session_id = '" . $userdata['session_id'] . "'";
			if ( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain registration information', '', __LINE__, __FILE__, $sql);
			}

			$sql = "INSERT INTO ". ANTI_ROBOT_TABLE . "
				VALUES ('" . $userdata['session_id'] . "', '" . $key . "', '" . CR_TIME . "')";
			if ( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not check registration information', '', __LINE__, __FILE__, $sql);
			}
		}
	}

	$s_profile_action = ($mode == 'editprofile') ? append_sid("profile.$phpEx?mode=editprofile&amp;sid=".$userdata['session_id']) : append_sid("profile.$phpEx");
	
	$template->assign_vars(array(
		'USERNAME' => $username,
		'CUR_PASSWORD' => $cur_password ?? '',
		'NEW_PASSWORD' => $new_password ?? '',
		'PASSWORD_CONFIRM' => $password_confirm,
		'EMAIL' => $email,
		'YIM' => $yim,
		'ICQ' => $icq,
		'MSN' => $msn,
		'AIM' => $aim,
		'OCCUPATION' => $occupation,
		'INTERESTS' => $interests,
		'LOCK_GENDER' =>($mode!='register') ? 'DISABLED':'', 
		'GENDER' => $gender, 
		'GENDER_NO_SPECIFY_CHECKED' => $gender_no_specify_checked, 
		'GENDER_MALE_CHECKED' => $gender_male_checked ?? '', 
		'GENDER_FEMALE_CHECKED' => $gender_female_checked ?? '',
		'LOCATION' => $location,
		'WEBSITE' => $website,
		'VIEW_EMAIL_YES' => ($viewemail) ? 'checked="checked"' : '',
		'VIEW_EMAIL_NO' => (!$viewemail) ? 'checked="checked"' : '',
		'VIEW_AIM_YES' => ($viewaim) ? 'checked="checked"' : '',
		'VIEW_AIM_NO' => (!$viewaim) ? 'checked="checked"' : '',
		'ALLOWPM_YES' => ($allowpm) ? 'checked="checked"' : '',
		'ALLOWPM_NO' => (!$allowpm) ? 'checked="checked"' : '',
		'LOG_IN_CHECK_YES' => ( $user_ip_login_check ) ? 'checked="checked"' : '',
		'LOG_IN_CHECK_NO' => ( !$user_ip_login_check ) ? 'checked="checked"' : '',
		'HIDE_USER_YES' => (!$allowviewonline) ? 'checked="checked"' : '',
		'HIDE_USER_NO' => ($allowviewonline) ? 'checked="checked"' : '',
		'NOTIFY_PM_YES' => ($notifypm) ? 'checked="checked"' : '',
		'NOTIFY_PM_NO' => (!$notifypm) ? 'checked="checked"' : '',
		'POPUP_PM_YES' => ($popuppm) ? 'checked="checked"' : '',
		'POPUP_PM_NO' => (!$popuppm) ? 'checked="checked"' : '',
		'NOTIFY_REPLY_YES' => ($notifyreply) ? 'checked="checked"' : '',
		'NOTIFY_REPLY_NO' => (!$notifyreply) ? 'checked="checked"' : '',
		'NOTIFY_GG_YES' => ($user_notify_gg) ? 'checked="checked"' : '',
		'NOTIFY_GG_NO' => (!$user_notify_gg) ? 'checked="checked"' : '',
		'ALWAYS_ALLOW_BBCODE_YES' => ($allowbbcode) ? 'checked="checked"' : '',
		'ALWAYS_ALLOW_BBCODE_NO' => (!$allowbbcode) ? 'checked="checked"' : '',
		'ALWAYS_ALLOW_HTML_YES' => ($allowhtml) ? 'checked="checked"' : '',
		'ALWAYS_ALLOW_HTML_NO' => (!$allowhtml) ? 'checked="checked"' : '',
		'ALWAYS_ALLOW_SMILIES_YES' => ($allowsmilies) ? 'checked="checked"' : '',
		'ALWAYS_ALLOW_SMILIES_NO' => (!$allowsmilies) ? 'checked="checked"' : '',
		'ALLOW_AVATAR' => $board_config['allow_avatar_upload'],
		'AVATAR' => $avatar_img,
		'AVATAR_SIZE' => $board_config['avatar_filesize'],
		'LANGUAGE_SELECT' => language_select($user_lang, 'language'),
		'STYLE_SELECT' => style_select($user_style, 'style'),
		'TIMEZONE_SELECT' => tz_select($user_timezone, 'timezone'),
		'HTML_STATUS' => $html_status,
		'BBCODE_STATUS' => sprintf($bbcode_status, '<a href="' . append_sid("faq.$phpEx?mode=bbcode") . '" target="_phpbbcode">', '</a>'),
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

		'L_EMAIL_EXPLAIN' => $lang['Email_explain'],
		'L_CURRENT_PASSWORD' => $lang['Current_password'],
		'L_NEW_PASSWORD' => ($mode == 'register') ? $lang['Password'] : $lang['New_password'],
		'L_CONFIRM_PASSWORD' => $lang['Confirm_password'],
		'L_CONFIRM_PASSWORD_EXPLAIN' => ($mode == 'editprofile') ? $lang['Confirm_password_explain'] : '',
		'L_PASSWORD_IF_CHANGED' => ($mode == 'editprofile') ? $lang['password_if_changed'] : '',
		'L_PASSWORD_CONFIRM_IF_CHANGED' => ($mode == 'editprofile') ? $lang['password_confirm_if_changed'] : '',
		'L_SUBMIT' => $lang['Submit'],
		'L_RESET' => $lang['Reset'],
		'L_ICQ_NUMBER' => $lang['ICQ'],
		'L_MESSENGER' => $lang['MSNM'],
		'L_YAHOO' => $lang['YIM'],
		'L_WEBSITE' => ($board_config['require_website'])  ? $lang['Website'] . ' <span style="color: #FF0000"><b>*</b></span>' : $lang['Website'],
		'L_AIM' => ($board_config['require_aim']) ? $lang['AIM'] . ' <span style="color: #FF0000"><b>*</b></span>' : $lang['AIM'],
		'L_LOCATION' => ($board_config['require_location']) ? $lang['Location'] . ' <span style="color: #FF0000"><b>*</b></span>' : $lang['Location'],
		'L_OCCUPATION' => $lang['Occupation'],
		'L_BOARD_LANGUAGE' => $lang['Board_lang'],
		'L_BOARD_STYLE' => $lang['Board_style'],
		'L_TIMEZONE' => $lang['Timezone'],
		'L_YES' => $lang['Yes'],
		'L_NO' => $lang['No'],
		'L_INTERESTS' => $lang['Interests'],
		'L_GENDER' => ($board_config['require_gender']) ? $lang['Gender'] . ' <span style="color: #FF0000"><b>*</b></span>' : $lang['Gender'],
		'L_GENDER_MALE' =>$lang['Male'],
		'L_GENDER_FEMALE' =>$lang['Female'],
		'L_GENDER_NOT_SPECIFY' =>$lang['No_gender_specify'],
		'L_ALWAYS_ALLOW_SMILIES' => $lang['Always_smile'],
		'L_ALWAYS_ALLOW_BBCODE' => $lang['Always_bbcode'],
		'L_ALWAYS_ALLOW_HTML' => $lang['Always_html'],
		'L_HIDE_USER' => $lang['Hide_user'],
		'L_ALWAYS_ADD_SIGNATURE' => $lang['Always_add_sig'],

		'L_AVATAR_PANEL' => $lang['Avatar_panel'],
		'L_AVATAR_EXPLAIN' => sprintf($lang['Avatar_explain'], $board_config['avatar_max_width'], $board_config['avatar_max_height'], (round($board_config['avatar_filesize'] / 1024))),
		'L_UPLOAD_AVATAR_FILE' => $lang['Upload_Avatar_file'],
		'L_UPLOAD_AVATAR_URL' => $lang['Upload_Avatar_URL'],
		'L_UPLOAD_AVATAR_URL_EXPLAIN' => $lang['Upload_Avatar_URL_explain'],
		'L_AVATAR_GALLERY' => $lang['Select_from_gallery'],
		'L_SHOW_GALLERY' => $lang['View_avatar_gallery'],
		'L_LINK_REMOTE_AVATAR' => $lang['Link_remote_Avatar'],
		'L_LINK_REMOTE_AVATAR_EXPLAIN' => $lang['Link_remote_Avatar_explain'],
		'L_DELETE_AVATAR' => $lang['Delete_Image'],
		'L_SIGNATURE_PANEL' => $lang['Signature_panel'],
		'L_UPLOAD_SIGNATURE_FILE' => $lang['Upload_Avatar_file'],
		'L_UPLOAD_SIGNATURE_URL' => $lang['Upload_Avatar_URL'],
		'L_UPLOAD_SIGNATURE_URL_EXPLAIN' => $lang['Upload_Avatar_URL_explain'],
		'L_SIGNATURE_TEXT' => $lang['Signature_text'],
		'L_SIGNATURE_TEXT_EXPLAIN' => sprintf($lang['Signature_text_explain'], $max_sig_chars),
		'L_SIGNATURE_EXPLAIN' => sprintf($lang['Signature_explain'], $board_config['sig_image_max_width'], $board_config['sig_image_max_height'], (round($board_config['sig_image_filesize'] / 1024))),
		'L_CURRENT_IMAGE' => $lang['Current_Image'],
		'L_DELETE_SIGNATURE_IMAGE' => $lang['Delete_Image'],
		'L_NOTIFY_ON_REPLY' => $lang['Always_notify'],
		'L_NOTIFY_ON_REPLY_EXPLAIN' => $lang['Always_notify_explain'],
		'L_NOTIFY_GG' => $lang['l_notify_gg'],
		'L_NOTIFY_GG_E' => sprintf($lang['l_notify_gg_e'], $board_config['numer_gg']),
		'L_NOTIFY_ON_PRIVMSG' => $lang['Notify_on_privmsg'],
		'L_POPUP_ON_PRIVMSG' => $lang['Popup_on_privmsg'],
		'L_POPUP_ON_PRIVMSG_EXPLAIN' => $lang['Popup_on_privmsg_explain'],
		'L_PREFERENCES' => $lang['Preferences'],
		'L_PUBLIC_VIEW_EMAIL' => $lang['Public_view_email'],
		'L_PUBLIC_VIEW_AIM' => $lang['Public_view_aim'],
		'L_ITEMS_REQUIRED' => $lang['Items_required'],
		'L_REGISTRATION_INFO' => $lang['Registration_info'],
		'L_PROFILE_INFO' => $lang['Profile_info'],
		'L_PROFILE_INFO_NOTICE' => $lang['Profile_info_warn'],
		'L_EMAIL_ADDRESS' => $lang['Email_address'],
		'L_ALLOWPM' => $lang['allowpm'],
		'L_ALLOWPM_E' => $lang['allowpm_e'],
		'L_LOG_IN_CHECK' => $lang['login_ip_check'],
		'L_LOG_IN_CHECK_E' => $lang['login_ip_check_e'],

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

		'S_ALLOW_AVATAR_UPLOAD' => $board_config['allow_avatar_upload'],
		'S_ALLOW_AVATAR_LOCAL' => $board_config['allow_avatar_local'],
		'S_ALLOW_AVATAR_REMOTE' => $board_config['allow_avatar_remote'],
		'S_HIDDEN_FIELDS' => $s_hidden_fields,
		'S_FORM_ENCTYPE' => $form_enctype,
		'S_PROFILE_ACTION' => $s_profile_action)
	);

	if ( $board_config['cicq'] )
	{
		$template->assign_block_vars('icq', array());
	}
	if ( $board_config['cgg'] )
	{
		$template->assign_block_vars('aim', array());
	}
	if ( $board_config['cmsn'] )
	{
		$template->assign_block_vars('msn', array());
	}
	if ( $board_config['cyahoo'] )
	{
		$template->assign_block_vars('yahoo', array());
	}
	if ( $board_config['cjob'] )
	{
		$template->assign_block_vars('job', array());
	}
	if ( $board_config['cinter'] )
	{
		$template->assign_block_vars('interests', array());
	}
	if ( $board_config['cemail'] )
	{
		$template->assign_block_vars('email', array());
	}
	if ( $board_config['cbbcode'] )
	{
		$template->assign_block_vars('bbcode', array());
	}
	if ( $board_config['chtml'] )
	{
		$template->assign_block_vars('html', array());
	}
	if ( $board_config['csmiles'] )
	{
		$template->assign_block_vars('smiles', array());
	}
	if ( $board_config['clang'] )
	{
		$template->assign_block_vars('lang', array());
	}
	if ( $board_config['cbstyle'] )
	{
		$template->assign_block_vars('style', array());
	}
	if ( $board_config['ctimezone'] )
	{
		$template->assign_block_vars('timezone', array());
	}

	if ( $board_config['validate'] && !$userdata['session_logged_in'] && @extension_loaded('zlib') )
	{
		$template->assign_block_vars('validation', array(
			'L_VALIDATION' => $lang['Validation'],
			'L_VALIDATION_EXPLAIN' => $lang['Validation_explain'],

			'VALIDATION' => '<img src="' . append_sid("includes/confirm_register.$phpEx") . '" border="0">')
		);
	}

	if ( $custom_fields_exists )
	{
		for($i = 0; $i < count($custom_fields[0]); $i++)
		{
			if ( $custom_fields[11][$i] || ($mode == 'register' && $custom_fields[5][$i]) )
			{
				$split_field = 'user_field_' . $custom_fields[0][$i];
				$custom_fields[1][$i] = (isset($lang[$custom_fields[1][$i]])) ? $lang[$custom_fields[1][$i]] : $custom_fields[1][$i];
				$short_desc = ($custom_fields[5][$i]) ? $custom_fields[1][$i] . ' <span style="color: #FF0000"><b>*</b></span>': $custom_fields[1][$i];
				$custom_fields[7][$i] = (isset($lang[$custom_fields[7][$i]])) ? $lang[$custom_fields[7][$i]] : $custom_fields[7][$i];
				$long_desc = ($custom_fields[7][$i]) ? '</span><br /><span class="gensmall">' . $custom_fields[7][$i] . '</span>' : '';

				$template->assign_block_vars('custom_fields', array(
					'CF_DESCRIPTION' => $short_desc . ':' . $long_desc)
				);
				if ( $custom_fields[8][$i] && !$custom_fields[6][$i])
				{
					$template->assign_block_vars('custom_fields.input_textarea', array(
						'INPUT_NAME' => $split_field,
						'INPUT_MAXVALUE' => $custom_fields[2][$i],
						'INPUT_VALUE' => $$split_field)
					);
				}
				else if ( !$custom_fields[6][$i] )
				{
					$template->assign_block_vars('custom_fields.input_text', array(
						'INPUT_NAME' => $split_field,
						'INPUT_MAXVALUE' => $custom_fields[2][$i],
						'INPUT_VALUE' => $$split_field)
					);
				}
				else if ( $custom_fields[6][$i] )
				{
					$options = explode(',', $custom_fields[6][$i]);
					if ( count($options) > 0 )
					{
						if (stristr($options[count($options) -1 ],'.gif') || stristr($options[count($options) -1 ],'.jpg'))
						{
							$auth_field = false;
							$jumpbox = '<script language="javascript" type="text/javascript">function update_rank' . $split_field . '(newimage){document.' . $split_field . '.src = \'' . $images['images'] . '/custom_fields/\'+newimage;}</script>';
							$jumpbox .= '<select name="' . $split_field . '" onchange="update_rank' . $split_field . '(this.options[selectedIndex].value);"><option value="no_image.gif">' . $lang['None'] . '</option>';
							$selected_image = ($userdata[$split_field]) ? '' . $images['images'] . '/custom_fields/' . $userdata[$split_field] . '' : '' . $images['images'] . '/custom_fields/no_image.gif';
							for ($j = 0; $j+1 <= count($options); $j++) 
							{
								$auth_field = ($options[$j] == $$split_field) ? true : $auth_field;
								$field_name = str_replace(array('_', '.gif', '.jpg'), array(' ', '', ''), $options[$j]);
								$cf_selected = ($options[$j] == $$split_field) ? 'selected="selected"' : '';
								$jumpbox .= '<option value="' . $options[$j] . '" ' . $cf_selected . '>' . $field_name . '</option>';
							}
							$selected_image = ($auth_field) ? $selected_image : '' . $images['images'] . '/custom_fields/no_image.gif';
							$jumpbox .= '</select>&nbsp;<img name="' . $split_field . '" src="' . $selected_image . '" border="0" alt="" align="top" />';
						}
						else
						{
							$jumpbox = '<select name="' . $split_field . '"><option value="" ' . $cf_selected . '>' . $lang['None'] . '</option>';
							for ($j = 0; $j+1 <= count($options); $j++) 
							{
								$cf_selected = ($options[$j] == $$split_field) ? 'selected="selected"' : '';
								$jumpbox .= '<option value="' . $options[$j] . '" ' . $cf_selected . '>' . $options[$j] . '</option>';
							}
							$jumpbox .= '</select>';
						}
					}
						
					$template->assign_block_vars('custom_fields.jumpbox', array(
						'INPUT' => $jumpbox)
					);
				}
			}
		}
	}

	if ( $userdata['can_custom_color'] && ( (($board_config['custom_color_use'] || $board_config['custom_color_view']) && $userdata['user_posts'] >= $board_config['allow_custom_color'] && !$board_config['custom_color_view']))
	|| ( ($is_mod || $userdata['user_level'] == ADMIN || $userdata['user_jr']) && $board_config['custom_color_mod'] ))
	{
		$template->assign_block_vars('custom_color', array(
			'CUSTOM_COLOR' => $custom_color,
			'L_CUSTOM_color' => $lang['Custom_color'],
			'L_CUSTOM_color_EXPLAIN' => $lang['Custom_color_Explain'])
		);
	}

	if ( $board_config['notify_gg'] && $board_config['cgg'] && !empty($board_config['numer_gg']) && !empty($board_config['haslo_gg']) )
	{
		$template->assign_block_vars('switch_gg', array());
	}

	if ( $board_config['gender'] )
	{
		$template->assign_block_vars('switch_gender', array());
	}

	if ( $userdata['user_posts'] >= $board_config['allow_custom_rank'] && $userdata['can_custom_ranks'] )
	{
		$template->assign_block_vars('custom_rank', array(
			'CUSTOM_RANK' => $custom_rank,
			'L_CUSTOM_RANK' => $lang['Custom_Rank'],
			'L_CUSTOM_RANK_EXPLAIN' => $lang['Custom_Rank_Explain'])
		);
	}
	else if ( $board_config['custom_rank_mod'] )
	{
		if ( $is_mod || $userdata['user_level'] == ADMIN || $userdata['user_jr'] )
		{
			if ( $userdata['can_custom_ranks'] )
			{
				$template->assign_block_vars('custom_rank', array(
					'CUSTOM_RANK' => $custom_rank,
					'L_CUSTOM_RANK' => $lang['Custom_Rank'],
					'L_CUSTOM_RANK_EXPLAIN' => $lang['Custom_Rank_Explain'])
				);
			}
		}
	}

	// This is another cheat using the block_var capability
	// of the templates to 'fake' an IF...ELSE...ENDIF solution
	// it works well :)
	if ( $board_config['allow_sig'] && ($userdata['user_allowsig'] || $mode == 'register') )
	{
		$template->assign_block_vars('switch_signature_block', array(
			'SIGNATURE' => str_replace('<br />', "\n", $signature),
			'ALWAYS_ADD_SIGNATURE_YES' => ($attachsig) ? 'checked="checked"' : '',
			'ALWAYS_ADD_SIGNATURE_NO' => (!$attachsig) ? 'checked="checked"' : '',
			'SIGNATURE_IMAGE' => $signature_image)
		);

		if ( $board_config['allow_sig_image'] && $mode != 'register' )
		{
			$template->assign_block_vars('switch_signature_block.switch_signature_allowimage', array());

			$template->assign_block_vars('switch_signature_block.switch_signature_remote', array());
			if ( $form_enctype != '' )
			{
				$template->assign_block_vars('switch_signature_block.switch_signature_local', array());
			}
		}
	}

	if ( $mode != 'register' && ($userdata['user_level'] >= 1 || $userdata['user_posts'] >= $board_config['allow_avatar']) )
	{
		if ( $userdata['user_allowavatar'] && ( $board_config['allow_avatar_upload'] || $board_config['allow_avatar_local'] || $board_config['allow_avatar_remote'] ) )
		{
			$template->assign_block_vars('switch_avatar_block', array() );

			if ( $board_config['allow_avatar_upload'] && file_exists(@phpbb_realpath('./' . $board_config['avatar_path'])) )
			{
				if ( $form_enctype != '' )
				{
					$template->assign_block_vars('switch_avatar_block.switch_avatar_local_upload', array() );
				}
				$template->assign_block_vars('switch_avatar_block.switch_avatar_remote_upload', array() );
			}

			if ( $board_config['allow_avatar_remote'] )
			{
				$template->assign_block_vars('switch_avatar_block.switch_avatar_remote_link', array() );
			}

			if ( $board_config['allow_avatar_local'] && file_exists(@phpbb_realpath('./' . $board_config['avatar_gallery_path'])) )
			{
				$template->assign_block_vars('switch_avatar_block.switch_avatar_local_gallery', array() );
			}
		}
		if ( $userdata['user_allowsig'] )
		{
				$template->assign_block_vars('switch_sig_block', array() );
		}
	}
}

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>