<?php
/***************************************************************************
 *              admin_users_list.php
 *              -------------------
 *  begin       : Tuesday, Jul 03, 2006
 *  copyright   : (C) 2003 Przemo ( http://www.przemo.org/phpBB2/ )
 *  email       : przemo@przemo.org
 *  version     : 1.12.0
 *
 ***************************************************************************/

define('MODULE_ID', 12);
define('IN_PHPBB', true);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Users']['Users'] = $filename;
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = '../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

//
// Set variables
//
$users_per_page = ($userdata['user_topics_per_page'] > 0) ? $userdata['user_topics_per_page'] : '25';
$start = (isset($HTTP_GET_VARS['start'])) ? intval($HTTP_GET_VARS['start']) : 0;
if ( isset($HTTP_POST_VARS['start']) )
{
	$start = intval($HTTP_POST_VARS['start']);
}
$sort_method = (isset($HTTP_POST_VARS['sort'])) ? $HTTP_POST_VARS['sort'] : 'user_id';
if ( isset($HTTP_POST_VARS['order']) )
{
	$sort_order = ($HTTP_POST_VARS['order'] == 'ASC') ? 'ASC' : 'DESC';
}
else if ( isset($HTTP_GET_VARS['order']) )
{
	$sort_order = ($HTTP_GET_VARS['order'] == 'ASC') ? 'ASC' : 'DESC';
}
else
{
	$sort_order = 'ASC';
}

if ( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? xhtmlspecialchars($HTTP_POST_VARS['mode']) : xhtmlspecialchars($HTTP_GET_VARS['mode']);
}
else
{
	$mode = 'username';
}

$mode_types_text = array($lang['Sort_Joined'], $lang['Last_visit'], $lang['Username'], $lang['Location'], $lang['Posts'], $lang['Email'], $lang['Website'], $lang['helped'], $lang['Active'], $lang['Visits'], $lang['Spend time'], $lang['IP_Address'], $lang['Junior'], $lang['Staff']);
$mode_types = array('joined', 'lastvisit', 'username', 'location', 'posts', 'email', 'website', 'special_rank', 'active', 'user_visit', 'user_spend_time', 'ip', 'junior', 'staff');

$custom_fields = custom_fields();
for($i = 0; $i < count($custom_fields[0]); $i++)
{
	if ( !$custom_fields[0][$i] )
	{
		break;
	}
	$show_this_field = custom_fields('viewable', $custom_fields[12][$i], false);
	if ( $show_this_field )
	{
		$split_field = 'user_field_' . $custom_fields[0][$i];
		$fields_array[] = $split_field; 
		$cf_real_desc = $custom_fields[1][$i];
		$custom_fields[1][$i] = str_replace(array('-#', '<br>'), array('',''), $custom_fields[1][$i]);
		$cf_lang = (isset($lang[$custom_fields[1][$i]])) ? $lang[$custom_fields[1][$i]] : $custom_fields[1][$i];
		$mode_types_text[] =  $cf_lang;
		$mode_types[] = $split_field;
		if ( $mode == $split_field )
		{
			$memberlist_lang_cf = $cf_lang;
			$memberlist_cf = 'user_field_' . $custom_fields[0][$i];
			$prefix = replace_vars($custom_fields[9][$i]);
			$suffix = replace_vars($custom_fields[10][$i]);
		}
		$custom_fields_exists = true;
	}
}

$select_sort_mode = '<select name="mode">';
for($i = 0; $i < count($mode_types_text); $i++)
{
	$selected = ( $mode == $mode_types[$i] ) ? ' selected="selected"' : '';
	$select_sort_mode .= '<option value="' . $mode_types[$i] . '"' . $selected . '>' . $mode_types_text[$i] . '</option>';
}
$select_sort_mode .= '</select>';

$select_sort_order = '<select name="order">';
if ( $sort_order == 'ASC' )
{
	$select_sort_order .= '<option value="ASC" selected="selected">' . $lang['Sort_Ascending'] . '</option><option value="DESC">' . $lang['Sort_Descending'] . '</option>';
}
else
{
	$select_sort_order .= '<option value="ASC">' . $lang['Sort_Ascending'] . '</option><option value="DESC" selected="selected">' . $lang['Sort_Descending'] . '</option>';
}
$select_sort_order .= '</select>';

$template->set_filenames(array(
	'body' => 'admin/admin_users_list_body.tpl')
);

if ( $userdata['user_level'] == ADMIN )
{
	$template->assign_block_vars('is_admin', array());
}

if ( $mode == 'special_rank' )
{
	$l_email = $lang['helped'];
}
else if ( $mode == 'location' )
{
	$l_email = $lang['Location'];
}
else if ( $mode == 'website' )
{
	$l_email = $lang['Website'];
}
else if ( $memberlist_lang_cf )
{
	$l_email = $memberlist_lang_cf;
}
else if ( $mode == 'user_visit' )
{
	$l_email = $lang['Visits'];
}
else if ( $mode == 'user_spend_time' )
{
	$l_email = $lang['Spend time'];
}
else if ( $mode == 'ip' )
{
	$l_email = $lang['IP_Address'];
}
else
{
	$l_email = $lang['Email'];
}

$template->assign_vars(array(
	'L_FIND_USERNAME' => $lang['Find_username'],
	'L_SELECT_SORT_METHOD' => $lang['Select_sort_method'],
	'U_LIST_ACTION' => append_sid("admin_users_list.$phpEx"),
	'L_SORT' => $lang['Sort'],
	'L_SORT_DESCENDING' => $lang['Sort_Descending'],
	'L_SORT_ASCENDING' => $lang['Sort_Ascending'],
	'L_USERNAME' => $lang['Username'],
	'L_EMAIL' => $l_email,
	'L_EDIT' => $lang['edit_mini'],
	'L_PERMISSION' => $lang['Permissions'],
	'L_JOINED' => $lang['Joined'],
	'L_LAST_VISIT' => $lang['Last_visit'],
	'L_POSTS' => $lang['Posts'],
	'L_ACTIVE' => $lang['Active'],
	'L_USER_TITLE' => $lang['User_admin'],
	'L_USER_EXPLAIN' => $lang['User_admin_explain'],
	'L_USER_SELECT' => $lang['Select_a_User'],
	'L_LOOK_UP' => $lang['Edit'],
	'L_AUTH' => $lang['Permissions'],
	'L_WEBSITE' => $lang['Website'],
	'L_SEARCH_USERS' => $lang['Seeker'],
	'U_SEARCH_USERS' => '<a href="' . append_sid("../seeker.$phpEx") . '" class="nav">' . $lang['Seeker'] . '</a>',
	'U_SEARCH_USER' => append_sid("./../search.$phpEx?mode=searchuser"),
	'S_USER_ACTION' => append_sid("admin_users.$phpEx"),
	'S_JR_ACTION' => append_sid("admin_jr_admin.$phpEx"),
	'S_ORDER_SELECT' => $select_sort_order,
	'S_USER_SELECT' => $select_sort_mode)
);

switch( $mode )
{
	case 'joined':
		$order_by = "u.user_regdate $sort_order LIMIT $start, " . $users_per_page;
		break;
	case 'lastvisit':
		$order_by = "u.user_session_time $sort_order LIMIT $start, " . $users_per_page;
		break;
	case 'username':
		$order_by = "u.username $sort_order LIMIT $start, " . $users_per_page;
		break;
	case 'location':
		$order_by = "u.user_from $sort_order LIMIT $start, " . $users_per_page;
		break;
	case 'posts':
		$order_by = "u.user_posts $sort_order LIMIT $start, " . $users_per_page;
		break;
	case 'email':
		$order_by = "u.user_email $sort_order LIMIT $start, " . $users_per_page;
		break;
	case 'website':
		$order_by = "u.user_website $sort_order LIMIT $start, " . $users_per_page;
		break;
	case 'special_rank':
		$order_by = "u.special_rank $sort_order LIMIT $start, " . $users_per_page;
		break;
	case 'user_visit':
		$order_by = "u.user_visit $sort_order LIMIT $start, " . $users_per_page;
		break;
	case 'user_spend_time':
		$order_by = "u.user_spend_time $sort_order LIMIT $start, " . $users_per_page;
		break;
	case 'active':
		$order_by = "u.user_active $sort_order LIMIT $start, " . $users_per_page;
		break;
	case 'ip':
		$order_by = "u.user_ip $sort_order LIMIT $start, " . $users_per_page;
		break;
	case 'junior':
		$order_by = "IF(u.user_jr = 1, 2, 3), jr.user_jr_admin DESC LIMIT $start, " . $users_per_page;
		break;
	case 'staff':
		$order_by = "IF(user_level = 1, 1, IF(user_jr = 1, 2, 3))ASC, u.user_level DESC LIMIT $start, " . $users_per_page;
		break;
	default:
		$order_by = "u.user_regdate $sort_order LIMIT $start, " . $users_per_page;
		break;
}

if ( isset($HTTP_POST_VARS['letter']) )
{
	$by_letter = ($HTTP_POST_VARS['letter']) ? xhtmlspecialchars($HTTP_POST_VARS['letter']) : 'all';
}
else if ( isset($HTTP_GET_VARS['letter']) )
{
	$by_letter = ($HTTP_GET_VARS['letter']) ? xhtmlspecialchars($HTTP_GET_VARS['letter']) : 'all';
}
else
{
	$by_letter = 'all';
}

if ( $custom_fields_exists )
{
	for($i = 0; $i < count($custom_fields[0]); $i++)
	{
		$show_this_field = custom_fields('viewable', $custom_fields[12][$i], false);
		if ( $show_this_field )
		{
			$split_field = 'u.user_field_' . $custom_fields[0][$i];
			if ( $mode == $split_field )
			{
				$order_by = "$split_field $sort_order LIMIT $start, " . $users_per_page;
			}
		}
	}
}

// Set per-letter selection
$others_sql = $select_letter = '';
$mode_letter = (!isset($HTTP_GET_VARS['mode']) && !isset($HTTP_POST_VARS['mode'])) ? '' : '&amp;mode=' . $mode;
for ($i = 97; $i <= 122; $i++)
{
	$others_sql .= " AND u.username NOT LIKE '" . chr($i) . "%' ";
	$select_letter .= ( $by_letter == chr($i) ) ? chr($i) . '&nbsp;' : '<a href="' . append_sid("admin_users_list.$phpEx?letter=" . chr($i) . $mode_letter . "&amp;order=$sort_order") . '">' . chr($i) . '</a>&nbsp;';
}
$select_letter .= ( $by_letter == 'others' ) ? $lang['Others'] . '&nbsp;' : '<a href="' . append_sid("admin_users_list.$phpEx?letter=others" . $mode_letter . "&amp;order=$sort_order") . '">' . $lang['Others'] . '</a>&nbsp;';
$select_letter .= ( $by_letter == 'all' ) ? $lang['All'] : '<a href="' . append_sid("admin_users_list.$phpEx?letter=all" . $mode_letter . "&amp;order=$sort_order") . '">' . $lang['All'] . '</a>';

$template->assign_vars(array(
	'L_SORT_PER_LETTER' => $lang['Sort_per_letter'],
	'S_LETTER_SELECT' => $select_letter,
	'S_LETTER_HIDDEN' => '<input type="hidden" name="letter" value="' . $by_letter . '" />')
);

if ( $by_letter == 'all' )
{
	$letter_sql = '';
}
else if ( $by_letter == 'others' )
{
	$letter_sql = $others_sql;
}
else
{
	$letter_sql = " AND u.username LIKE '" . substr($by_letter, 0, 1) . "%' ";
}

$order_by = (isset($HTTP_GET_VARS['letter']) && !isset($HTTP_GET_VARS['mode']) && !isset($HTTP_POST_VARS['mode']) ) ? "username $sort_order LIMIT $start, " . $users_per_page : $order_by;

include_once($phpbb_root_path . 'includes/bbcode.'.$phpEx);

// Count users
$sql = "SELECT COUNT(*) as total FROM " . USERS_TABLE . " u
	WHERE u.user_id > 0
	$letter_sql";

if(!$result = $db->sql_query($sql))
{
	message_die(GENERAL_ERROR, 'Could not count Users', '', __LINE__, __FILE__, $sql);
}
$total_users = $db->sql_fetchrow($result);
$total_users = $total_users['total'];

if ( $mode == 'ip' )
{
	$sql = "SELECT user_ip FROM " . USERS_TABLE . "
		WHERE user_id <> " . ANONYMOUS . "
		AND user_ip <> ''
		ORDER by user_ip";
	if(!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not query Users information", "", __LINE__, __FILE__, $sql);
	}
	$ips = array();
	while( $row = $db->sql_fetchrow($result) )
	{
		if ( $row['user_ip'] == $cr_ip )
		{
			$ips[] = $row['user_ip'];
		}
		$cr_ip = $row['user_ip'];
	}
}

$sql = "SELECT u.*, jr.user_jr_admin FROM " . USERS_TABLE . " u
	LEFT JOIN " . JR_ADMIN_TABLE . " jr ON (u.user_id = jr.user_id)
	WHERE u.user_id <> " . ANONYMOUS . "
	$letter_sql
	ORDER BY $order_by";

if(!$result = $db->sql_query($sql))
{
	message_die(GENERAL_ERROR, "Could not query Users information", "", __LINE__, __FILE__, $sql);
}

while( $row = $db->sql_fetchrow($result) )
{
	$userrow[] = $row;
}

for ($i = 0; $i < $users_per_page; $i++)
{
	if (empty($userrow[$i]))
	{
		break;
	}

	$row_color = (($i % 2) == 0) ? "row1" : "row2";

	if ( $mode == 'special_rank' )
	{
		$user_email = $userrow[$i]['special_rank'];
	}
	else if ( $mode == 'location' )
	{
		$user_email = $userrow[$i]['user_from'];
	}
	else if ( $mode == 'website' )
	{
		$user_email = make_clickable($userrow[$i]['user_website']);
	}
	else if ( $mode == 'user_visit' )
	{
		$user_email = $userrow[$i]['user_visit'];
	}
	else if ( $mode == 'ip' )
	{
		$user_email = ($userrow[$i]['user_ip']) ? decode_ip($userrow[$i]['user_ip']) : $lang['None'];
	}
	else if ( $mode == 'user_spend_time' )
	{
		if ( $userrow[$i]['user_spend_time'] >= 3600 )
		{
			$user_email = $lang['Hours'] . ': ' . round(($userrow[$i]['user_spend_time'] / 60 / 60), 1);
		}
		else
		{
			$user_email = $lang['Minutes'] . ': ' . round(($userrow[$i]['user_spend_time'] / 60));
		}
	}
	else if ( $memberlist_cf )
	{
		if ( $userrow[$i][$memberlist_cf] )
		{
			$user_email = make_clickable($userrow[$i][$memberlist_cf]);
		}
		else
		{
			$user_email = '';
		}
	}
	else
	{
		$user_email = $userrow[$i]['user_email'];
	}

	$last_active = ($userrow[$i]['user_lastvisit'] > $userrow[$i]['user_session_time']) ? $userrow[$i]['user_lastvisit'] : $userrow[$i]['user_session_time'];

	$colored_username = color_username($userrow[$i]['user_level'], $userrow[$i]['user_jr'], $userrow[$i]['user_id'], $userrow[$i]['username']);
	$username = $colored_username[0];

	$same_ip = '';
	if ( $mode == 'ip' )
	{
		if ( $userrow[$i]['user_ip'] && @in_array($userrow[$i]['user_ip'], $ips) )
		{
			$same_ip = ' style="color: #FF0000; font-weight: bold; text-decoration: overline"';
		}
	}

	$template->assign_block_vars('userrow', array(
		'COLOR' => $row_color,
		'NUMBER' => ($start + $i + 1),
		'USER_ID' => $userrow[$i]['user_id'],
		'USERNAME' => '<a href="' . append_sid("../profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $userrow[$i]['user_id']) . '"' . $colored_username[1] . ' class="genmed"' . $same_ip . '>' . $username . '</a>',
		'U_ADMIN_USER' => append_sid("admin_users.$phpEx?mode=edit&amp;userlist=1&amp;" . POST_USERS_URL . "=" . $userrow[$i]['user_id']),
		'U_ADMIN_USER_AUTH' => append_sid("admin_ug_auth.$phpEx?mode=user&amp;userlist=1&amp;" . POST_USERS_URL . "=" . $userrow[$i]['user_id']),
		'EMAIL' => $user_email,
		'JOINED' => create_date($board_config['default_dateformat'], $userrow[$i]['user_regdate'], $board_config['board_timezone']),
		'LAST_VISIT' => (!$last_active) ? $lang['Never'] : create_date($board_config['default_dateformat'], $last_active, $board_config['board_timezone']),
		'POSTS' => '<a href="' . append_sid("../search.$phpEx?search_author=" . urlencode($userrow[$i]['username']) . "&amp;showresults=posts") . '">' . $userrow[$i]['user_posts'] . '</a>',
		'JR_CLASS' => ($userrow[$i]['user_jr_admin'] || $userrow[$i]['user_jr']) ? 'mainoption' : 'liteoption',
		'ACTIVE' => ( $userrow[$i]['user_active'] ) ? $lang['Yes'] : '<b>' . $lang['No'] . '</b>')
	);
	if ( $userdata['user_level'] == ADMIN )
	{
		$template->assign_block_vars('userrow.is_admin', array());
	}
}

generate_pagination(append_sid("admin_users_list.$phpEx?mode=$mode&amp;order=$sort_order&amp;letter=$by_letter"), $total_users, $users_per_page, $start);

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>