<?php
/***************************************************************************
 *							index.php
 *							-------------------
 *	begin					: Saturday, Feb 13, 2001
 *	copyright			: (C) 2001 The phpBB Group
 *	email					: support@phpbb.com
 *
 *	modification		: (C) 2005 Przemo http://www.przemo.org
 *	date modification	: ver. 1.9 2005/04/03 16:30
 *
 ***************************************************************************/

/***************************************************************************
 *	This program is free software; you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation; either version 2 of the License, or
 *	(at your option) any later version.
 ***************************************************************************/

define('IN_PHPBB', true);
define('SHOUTBOX', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
$real_board_config = $board_config;
include($phpbb_root_path . 'includes/functions_selects.'.$phpEx); 

$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);

require($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_customize.' . $phpEx);

$show_quickreply = (!$board_config['cquick'] || (!$userdata['session_logged_in'] && $board_config['not_anonymous_quickreply'])) ? false : true;
$checked = ' checked="checked"';

$advert_hide = ( ($board_config['view_ad_by'] == 1 && $userdata['session_logged_in']) || ($board_config['view_ad_by'] == 2 && ($userdata['user_level'] > 0 || $userdata['user_jr'])) ) ? true : false;

$config_data = array(
	//name => array(default_value, language, show_if, post_selected
	'simple_head' => array(0, '', true, $checked),
	'user_allow_signature' => array(1, '', $board_config['allow_sig'], $checked),

	'user_allow_sig_image' => array(1, '', (($board_config['allow_sig'] && $board_config['allow_sig_image'] && $board_config['allow_sig_image_img']) ? true : false), $checked),

	'user_showavatars' => array(1, '', (($board_config['allow_avatar_local'] || $board_config['allow_avatar_remote'] || $board_config['allow_avatar_upload']) ? true : false), $checked),

	'page_avatar' => array(1, $lang['page_avatar'] . ' &bull;', (($board_config['allow_avatar_local'] || $board_config['allow_avatar_remote'] || $board_config['allow_avatar_upload']) ? true : false), $checked),

	'view_ignore_topics' => array(1, $lang['view_ignore_topics'] . ' &bull;', $board_config['ignore_topics'], $checked),
	'user_topics_per_page' => array($board_config['topics_per_page'], '', true, $board_config['topics_per_page']),
	'user_posts_per_page' => array($board_config['posts_per_page'], '', true, $board_config['posts_per_page']),
	'user_hot_threshold' => array($board_config['hot_threshold'], '', true, $board_config['hot_threshold']),
	'user_sub_forum' => array($board_config['sub_forum'], '', ((!$board_config['sub_forum_over']) ? true : false), 'disable'),
	'user_split_cat' => array($board_config['split_cat'], '', ((!$board_config['split_cat_over']) ? true : false), 'disable'),

	'user_last_topic_title' => array($board_config['last_topic_title'], '', ((!$board_config['last_topic_title_over']) ? true : false), 'disable'),

	'user_sub_level_links' => array($board_config['sub_level_links'], '', ((!$board_config['sub_level_links_over']) ? true : false), 'disable'),

	'user_display_viewonline' => array($board_config['display_viewonline'], '', ((!$board_config['display_viewonline_over']) ? true : false), 'disable'),

	'overlib' => array(1, $lang['overlib'] . (($board_config['anonymous_simple']) ? ' &bull;' : ''), $real_board_config['post_overlib'], $checked),

	'topic_start_date' => array(1, '', $board_config['topic_start_date'], $checked),
	'ctop' => array(1, $lang['ctop'] . ' &bull;', $board_config['ctop'], $checked),
	'onmouse' => array(1, $lang['onmouse'] . (($board_config['anonymous_simple']) ? ' &bull;' : ''), $real_board_config['onmouse'], $checked),
	'custom_color_use' => array(1, '', $board_config['custom_color_use'], $checked),
	'custom_rank' => array(1, '', (($board_config['allow_custom_rank'] < 9999) ? true : false), $checked),
	'cload' => array(1, $lang['cloading'] . (($board_config['anonymous_simple']) ? ' &bull;' : ''), $real_board_config['cload'], $checked),
	'u_o_t_d' => array(1, $lang['u_o_t_d'] . (($board_config['anonymous_simple']) ? ' &bull;' : ''), $real_board_config['u_o_t_d'], $checked),
	'cagent' => array(1, $lang['cagent'] . (($board_config['anonymous_simple']) ? ' &bull;' : ''), $real_board_config['cagent'], $checked),
	'level' => array(1, $lang['level'] . (($board_config['anonymous_simple']) ? ' &bull;' : ''), (($real_board_config['clevell'] || $board_config['cleveld']) ? true : false), $checked),
	'cignore' => array(1, $lang['cignore'] . ' &bull;', $board_config['cignore'], $checked),
	'cquick' => array(1, $lang['Quick_Reply'], $show_quickreply, $checked),
	'show_smiles' => array(1, '', $board_config['allow_smilies'], $checked),
	'shoutbox' => array(1, '', $shoutbox_config['shoutbox_on'], $checked),
	'advertising' => array(0, $lang['Advert_hide'], $advert_hide, $checked),
	'post_icon' => array(1, '', $board_config['post_icon'], $checked)
);

$cookie_config = array();

$_cookie_config = md5('_cookie_config' . $userdata['user_id']);
$cookie_read_config = unserialize(stripslashes($HTTP_COOKIE_VARS[$unique_cookie_name . $_cookie_config]));

foreach($config_data as $key => $val)
{
	$cur_checked = '';
	if ( $val[2] )
	{
		$template->assign_block_vars('s_' . $key, array());

		if ( isset($HTTP_POST_VARS['submit']) )
		{
			if ( $key == 'user_topics_per_page' || $key == 'user_posts_per_page' || $key == 'user_hot_threshold' )
			{
				$$key = ($HTTP_POST_VARS[$key]) ? intval($HTTP_POST_VARS[$key]) : 0;
			}
			else
			{
				$$key = ($HTTP_POST_VARS[$key]) ? $HTTP_POST_VARS[$key] : 0;
			}
			$cookie_config[$key] = ($$key) ? $$key : 0;
			$cookie_read_config[$key] = ($$key) ? $$key : 0;
		}
	}
	if ( isset($cookie_read_config[$key]) )
	{
		$cur_checked = ($cookie_read_config[$key]) ? (($val[3] == $checked) ? $val[3] : $cookie_read_config[$key]) : '';
		$$key = (isset($cookie_read_config[$key])) ? $cookie_read_config[$key] : 0;
	}
	else
	{
		$cur_checked = ($val[0]) ? $val[3] : '';
		$$key = $val[0];
	}

	$template->assign_vars(array(
		'L_' . strtoupper($key) => ($val[1]) ? $val[1] : $lang[$key],
		'c_' . $key => $cur_checked,
	));
}

if ( $HTTP_POST_VARS['dateformat'] )
{
	$cookie_config['user_dateformat'] = $HTTP_POST_VARS['dateformat'];
	$cookie_read_config['user_dateformat'] = $HTTP_POST_VARS['dateformat'];
}

$user_dateformat = ($cookie_read_config['user_dateformat']) ? $cookie_read_config['user_dateformat'] : $board_config['default_dateformat'];

if ( isset($HTTP_POST_VARS['submit']) )
{
	setcookie($unique_cookie_name . $_cookie_config, serialize($cookie_config), (CR_TIME + 31536000), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
}

$gen_simple_header = true;
$page_title = $lang['Preferences'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'body' => 'customize_body.tpl')
);

if ( !$board_config['sub_forum_over'] || !$board_config['split_cat_over'] || !$board_config['last_topic_title_over'] || !$board_config['sub_level_links_over'] || !$board_config['display_viewonline_over'] )
{
	$template->assign_block_vars('s_switch_subforums', array());
}

$template->assign_vars(array(
	'L_NONES' => $lang['NoneS'],
	'L_MEDIUM' => $lang['Medium'],
	'L_FULL' => $lang['Full'],
	'L_WITH_PICS' => $lang['With_pics'],
	'L_ROOT_INDEX' => $lang['Root_index_only'],
	'L_DATE_FORMAT' => $lang['Date_format'],
	'L_PREFERENCES' => $lang['Preferences'],
	'L_PREFERENCES_E' => $lang['Preferences_e'],
	'L_YES' => $lang['Yes'],
	'L_NO' => $lang['No'],
	'L_SUBMIT' => $lang['Submit'],
	'L_RESET' => $lang['Reset'],

	'SUB_FORUM_0' => ($user_sub_forum == '0') ? 'checked="checked"' : '',
	'SUB_FORUM_1' => ($user_sub_forum == '1') ? 'checked="checked"' : '',
	'SUB_FORUM_2' => ($user_sub_forum == '2') ? 'checked="checked"' : '',
	'SPLIT_CAT_YES' => ($user_split_cat) ? 'checked="checked"' : '',
	'SPLIT_CAT_NO' => (!$user_split_cat) ? 'checked="checked"' : '',
	'LAST_TOPIC_TITLE_YES' => ($user_last_topic_title) ? 'checked="checked"' : '',
	'SUB_LEVEL_LINKS_0' => ($user_sub_level_links == '0') ? 'checked="checked"' : '',
	'SUB_LEVEL_LINKS_1' => ($user_sub_level_links == '1') ? 'checked="checked"' : '',
	'SUB_LEVEL_LINKS_2' => ($user_sub_level_links == '2') ? 'checked="checked"' : '',
	'DISPLAY_VIEWONLINE_0' => ($user_display_viewonline == '0') ? 'checked="checked"' : '',
	'DISPLAY_VIEWONLINE_1' => ($user_display_viewonline == '1') ? 'checked="checked"' : '',
	'DISPLAY_VIEWONLINE_2' => ($user_display_viewonline == '2') ? 'checked="checked"' : '',
	'LAST_TOPIC_TITLE_NO' => (!$user_last_topic_title) ? 'checked="checked"' : '',
	'DATE_FORMAT_SELECT' => date_format_select($user_dateformat, $board_config['board_timezone']),
	'U_CUSTOMIZE' => append_sid("customize.$phpEx"))
);

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>