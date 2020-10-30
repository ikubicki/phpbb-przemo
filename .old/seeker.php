<?php
/***************************************************************************
 *                      seeker.php
 *                      -------------------
 *   begin              : 10 June 2004
 *   copyright          : Widmo, Crack
 *   email              : widmo@pf.pl, piotrac@poczta.onet.pl
 *   modification       : Przemo www.przemo.org/phpBB2/
 *   version            : 1.12.5
 *
 *  $Id: seeker.php,v 1.2 2004/07/29 12:01 Crack Exp $
 *
 ***************************************************************************/

 /***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 ***************************************************************************/

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/functions_selects.'.$phpEx); 
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);

$userdata = session_pagestart($user_ip, PAGE_VIEWMEMBERS);
init_userprefs($userdata);
include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_seeker.' . $phpEx);

// If this mod is unavaible for currect user, show him appropriate message
if ( $userdata['user_level'] != ADMIN && $userdata['user_level'] != MOD)
{
//	message_die(GENERAL_MESSAGE, $lang['seeker_no_auth']);
}

if ( $board_config['login_require'] && !$userdata['session_logged_in'] )
{
	$message = $lang['login_require'] . '<br /><br />' . sprintf($lang['login_require_register'], '<a href="' . append_sid("profile.$phpEx?mode=register") . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

// Read POST and GET variables
$query   = trim(xhtmlspecialchars(get_vars('query', '', 'POST,GET')));
$start   = get_vars('start',    0, 'GET,POST', true);
$lookfor = get_vars('lookfor', '', 'POST,GET');
$method  = get_vars('method',  '', 'POST,GET');
$sortby  = get_vars('sortby',  '', 'POST,GET');
$order   = get_vars('order',   '', 'POST,GET');

// Define fields to look over
$lookfor_vars = array(
	'username' => array('lang' =>	$lang['Sort_Username'],			'field' =>	'u.username'),
	'gadu' => array(	'lang' =>	$lang['AIM'],			'field' =>	'u.user_aim'),
	'posts' => array(	'lang' =>	$lang['Posts'],			'field' =>	'u.user_posts'),
	'from' => array(	'lang' =>	$lang['Location'],		'field' =>	'u.user_from'),
	'title' => array(	'lang' =>	$lang['Custom_Rank'],	'field' =>	'u.user_custom_rank'),
	'www' => array(		'lang' =>	$lang['Website'],		'field' =>	'u.user_website'),
	'interests' => array('lang' =>	$lang['Interests'],		'field' =>	'u.user_interests'),
	'icq' => array(		'lang' =>	$lang['ICQ'],			'field' =>	'u.user_icq'),
	'msnm' => array(	'lang' =>	$lang['MSNM'],			'field' =>	'u.user_msnm'),
	'yim' => array(		'lang' =>	$lang['YIM'],			'field' =>	'u.user_yim')
);

if ( $board_config['helped'] )
{
	$lookfor_vars['helped']['lang'] = $lang['helped'];
	$lookfor_vars['helped']['field'] = 'u.special_rank';
}

if ( $userdata['user_level'] == ADMIN )
{
	$lookfor_vars['email']['lang'] = $lang['Email_address'];
	$lookfor_vars['email']['field'] = 'u.user_email';
	$lookfor_vars['ip']['lang'] = 'IP';
	$lookfor_vars['ip']['field'] = 'p.poster_ip';
}

// Load custom fields settings
$custom_fields_exists = (custom_fields('check', '')) ? true : false;
$additional_fields = array();
if ( $custom_fields_exists )
{
	$custom_fields = custom_fields();
	for ($i = 0; $i < count($custom_fields[0]); $i++)
	{
		$show_this_field = custom_fields('viewable', $custom_fields[12][$i], false);
		if ( $show_this_field )
		{
			$split_field = 'user_field_' . $custom_fields[0][$i];
			$additional_fields[] = $split_field;
			$lookfor_vars[$split_field]['lang'] = $custom_fields[1][$i] = str_replace(array('-#', '<br>'), array('',''), $custom_fields[1][$i]);
			$lookfor_vars[$split_field]['lang'] = (isset($lang[$lookfor_vars[$split_field]['lang']])) ? $lang[$lookfor_vars[$split_field]['lang']] : $lookfor_vars[$split_field]['lang'];
			$lookfor_vars[$split_field]['field'] = 'u.' . $split_field;
			$lookfor_vars[$split_field]['allow_field'] = 'user_allow_field_' . $custom_fields[0][$i];
		}
	}
}

// Define fields to sort by
$sortby_add['joined'] = array('lang' =>	$lang['Sort_Joined'], 'field' => 'u.user_regdate');
$sortby_add['username'] = array('lang' => $lang['Username'], 'field' =>	'u.username');
$sortby_add['selected_field'] = array('lang' =>	$lang['see_chosen_field'], 'field' => 'selected_field');
$sortby_vars = array_merge($lookfor_vars, $sortby_add);

// Check correctness of some variables
// $sortby
$sortby = ($sortby == '' || $sortby_vars[$sortby]['field'] == '') ? 'selected_field' : $sortby;

switch( $method )
{
	case '<':
		$sql_method = '<';
		break;
	case '>':
		$sql_method = '>';
		break;
	case 'LIKE':
		$sql_method = 'LIKE';
	default:
		$sql_method = 'LIKE';
		break;
}

// $order
$order = ($order == 'ASC') ? 'ASC' : 'DESC';

$page_title = 'Seeker';
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'body' => 'seeker.tpl')
);

if ( $query != '' && !empty($lookfor_vars[$lookfor]['field']) )
{
	// Results shown per page
	$per_page = ($userdata['user_posts_per_page'] > $board_config['posts_per_page']) ? $board_config['posts_per_page'] : $userdata['user_posts_per_page'];

	// Prepare some variables to use
	$q = str_replace('?', '_', $query);
	$q = str_replace('*', '%', $q);
	$q = str_replace("\'", "''", $q);

	$sql_field = $lookfor_vars[$lookfor]['field'];
	$is_adfield = isset($lookfor_vars[$lookfor]['allow_field']);

	$sortby_vars['selected_field']['lang'] = $lookfor_vars[$lookfor]['lang'];
	$sortby_vars['selected_field']['field'] = $sql_field;

	$field = substr($sql_field, strpos($sql_field, '.') + 1);

	$sql_order_by = $sortby_vars[$sortby]['field'];
	$order_by = substr($sql_order_by, strpos($sql_order_by, '.') + 1);

	$tpl_sort_column = ($field != $order_by && $sortby != 'joined' && $sortby != 'username');

	$sql = '';
	// Build a query
	if ( $sql_field != 'p.poster_ip' && $sql_field )
	{
		$sql = "SELECT u.*
			FROM " . USERS_TABLE . " u
			WHERE $sql_field $sql_method '$q'
				AND u.user_id <> " . ANONYMOUS . "
				" . (($sql_field == 'u.user_aim') ? 'AND u.user_viewaim = 1' : '') . "
				" . ( $q != '0' ? "AND $field <> ''" : "" );
	}
	else if ( $userdata['user_level'] == ADMIN && $sql_field)
	{
		$search_ip = str_replace("\'", "''", $query);
		if( preg_match('/(([0-9]{1,3})(\.)?){1,4}/', $search_ip) )
		{
			$host = @gethostbyaddr($search_ip);
		}
		else
		{
			$host = $search_ip;
			$search_ip = @gethostbyname($host);
		}
		$encoded_ip = encode_ip($search_ip);

		$sql = "SELECT u.*, COUNT(*) as postings 
			FROM " . USERS_TABLE . " u, " . POSTS_TABLE . " p
			WHERE p.poster_id = u.user_id
				AND u.user_id <> " . ANONYMOUS . "
				AND p.poster_ip = '" . $encoded_ip . "'
				GROUP BY u.user_id, u.username";
	}
	else
	{
		message_die(GENERAL_MESSAGE, $lang['Not_Authorised']);
	}
	$sql .= " ORDER BY $order_by $order";
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not query users', '', __LINE__, __FILE__, $sql);
	}

	$found = $db->sql_affectedrows($result);

	// Pagination
	generate_pagination(append_sid("seeker.$phpEx?lookfor=$lookfor&amp;method=$sql_method&amp;sortby=$sortby&amp;order=$order&amp;query=" . urlencode($query)), $db->sql_affectedrows($result), $per_page, $start, false);
	$sql .= " LIMIT $start, $per_page";	

	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not query users', '', __LINE__, __FILE__, $sql);
	}

	// Prepare list of found users
	if ( $db->sql_affectedrows($result) > 0 )
	{
		$template->assign_block_vars('see_result', array());
		if ( $tpl_sort_column )
		{
			$template->assign_block_vars('see_result.sort_field', array(
				'NAME' => $sortby_vars[$sortby]['lang'])
			);
		}

		$pos_id = $start;
		while ( $row = $db->sql_fetchrow($result) )
		{
			$pos_id++;

			$colored_username = color_username($row['user_level'], $row['user_jr'], $row['user_id'], $row['username']);
			$username = $colored_username[0];


			// Send results to the template
			$adf_allow_field = (isset($lookfor_vars[$lookfor]['allow_field'])) ? $lookfor_vars[$lookfor]['allow_field'] : '';
			$allow_adfield = (isset($row[$adf_allow_field])) ? $row[$adf_allow_field] : true;
			$italic = (($lookfor == 'email' && !$row['user_viewemail']) || ($is_adfield && !$allow_adfield));
			$field_val = ($lookfor == 'email' || $lookfor == 'www') ? make_clickable($row[$field]) : $row[$field];
			$field_val = ($sql_field == 'p.poster_ip') ? $lang['Total_posts'] . ': ' . $row['postings'] : $field_val;
			$field_val = ($italic) ? '<i>' . $field_val . '</i>' : $field_val;

			$template->assign_block_vars('see_result.user', array(
				'NUM' => $pos_id,
				'USERNAME' => '<b><a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;u=" . $row['user_id']) . '"' . $colored_username[1] . ' class="gen">' . $username . '</a></b>',
				'JOINED' => create_date($board_config['default_dateformat'], $row['user_regdate'], $board_config['board_timezone']),
				'FIELD_VALUE' => ($lookfor == 'gadu') ? '<a href="GG:' . $field_val . '">' . $field_val . '</a>' : $field_val,
				'ROW_CLASS' => $pos_id % 2 ? 'row2' : 'row3')
			);

			if ( $tpl_sort_column )
			{
				// Sort column
				$is_adfield = isset( $lookfor_vars[$order_by]['allow_field'] );
				$allow_adfield = ($is_adfield && $row[$lookfor_vars[$order_by]['allow_field']]);
				if ( $order_by == 'user_email' )
				{
					$show_field = $full_view || $row['user_viewemail'];
				}
				else
				{
					$show_field = true;
				}
				$italic = (($order_by == 'user_email' && !$row['user_viewemail']) || ($is_adfield && !$allow_adfield));
				$field_val = ($order_by == 'user_email' || $order_by == 'user_website') ? make_clickable($row[$order_by]) : $row[$order_by];

				$template->assign_block_vars('see_result.user.sort_field', array(
					'FIELD_VALUE' => $show_field ? ($italic ? '<i>' . $field_val . '</i>' : $field_val) : '')
				);
			}
		}
		$template->assign_var('SEE_FOUND', '<br />' . $lang['see_found'] . " <b>$found</b>");
	}
	else
	{ 
		$template->assign_var('SEE_NOT_FOUND', '<br /><b>' . $lang['see_not_found'] . '</b>');
	}
}

// Send to the template list of fields to look over and methods of sorting
$sort_selected = false;
foreach( $sortby_add as $type => $var )
{
	$template->assign_block_vars('see_sortby_option', array(
		'VALUE' => $type,
		'TEXT' => $var['lang'],
		'SORT_SELECTED' => ($sortby == $type ) ? 'selected="selected"' : '' )
	);

	$sort_selected = ($sortby == $type) ? true : $sort_selected;
}

foreach( $lookfor_vars as $type => $var )
{
	$template->assign_block_vars('see_lookfor_option', array(
		'VALUE' => $type,
		'TEXT' => $var['lang'],
		'SELECTED' => ($lookfor == $type ? 'selected="selected"' : '' ),
		'SORT_SELECTED' => (!$sort_selected && $sortby == $type) ? 'selected="selected"' : '' )
	);
}

$methods_vars = array('LIKE' => 'LIKE', '>' => 'GT', '<' => 'ST');

$template->assign_vars(array(
	'SEE_L_SEARCH' => append_sid('seeker.php', true),
	'SEE_SEARCH' => $lang['see_search'],
	'SEE_METHOD' => $lang['see_method'],
	'SEE_SEEKER' => $lang['see_users'],
	'SEE_SORT_METHOD' => $lang['Select_sort_method'],
	'SEE_SORT_ORDER' => $lang['Sort'],
	'SEE_QUERY' => xhtmlspecialchars(stripslashes($query)),
	'SEE_EQUAL' => $lang['see_equal'],
	'SEE_GT' => $lang['see_greater'],
	'SEE_ST' => $lang['see_smaller'],
	'SEE_' . $methods_vars[$sql_method] . '_CHK' => ' selected="selected"',
	'SEE_ASC' => $lang['Sort_Ascending'],
	'SEE_DESC' => $lang['Sort_Descending'],
	'SEE_' . $order . '_SELECTED' => 'selected="selected"',
	'SEE_SUBMIT' => $lang['Search'],
	'SEE_TIP' => $lang['see_tip'] . (($userdata['user_level'] == ADMIN) ? $lang['except_ip'] : ''),

	'SEE_USER' => $lang['Username'],
	'SEE_JOINED' => $lang['Sort_Joined'],
	'SEE_LOOKFOR_FIELD' => $lookfor_vars[$lookfor]['lang'])
);

groups_color_explain('staff_explain');

// Show page
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
?>