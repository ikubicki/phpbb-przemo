<?php
/***************************************************************************
 *                  admin_advert_person.php
 *                  -------------------
 *   begin          : 12, 20, 2005
 *   copyright      : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   email          : przemo@przemo.org
 *   version        : ver. 1.12.0 2005/12/20 22:52
 *
 ***************************************************************************/
define('MODULE_ID', 16);
define('IN_PHPBB', 1);

if ( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Users']['adv_person'] = $file;
	return;
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

if ( isset($HTTP_GET_VARS['sid']) || isset($HTTP_POST_VARS['sid']) )
{
	include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin_advert.' . $phpEx);
}

$user_id = ( isset($HTTP_GET_VARS['user_id']) ) ? intval($HTTP_GET_VARS['user_id']) : intval($HTTP_POST_VARS['user_id']);

$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;
if ( isset($HTTP_POST_VARS['start']) )
{
	$start = intval($HTTP_POST_VARS['start']);
}

$user_topics_per_page = ($userdata['user_topics_per_page'] > 0) ? $userdata['user_topics_per_page'] : '25';

$template->set_filenames(array(
	'body' => 'admin/admin_advert_person.tpl')
);

if ( isset($HTTP_POST_VARS['submit']) )
{
	update_config('adv_person_time', intval($HTTP_POST_VARS['adv_person_time']));

	message_die(GENERAL_MESSAGE, $lang['Config_ad_updated'] . "<br /><br />" . sprintf($lang['Click_return_config'], "<a href=\"" . append_sid("admin_advert_person.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>"));
}

$adv_person_field = '';
$custom_fields = custom_fields();
for($i = 0; $i < count($custom_fields[0]); $i++)
{
	$split_field = 'user_field_' . $custom_fields[0][$i];
	if ( $custom_fields[1][$i] == 'adv_person' )
	{
		$adv_person_field = $split_field;
	}
}

$users = array();
$sql = "SELECT u.username, u.user_posts, u.user_visit, u.user_regdate, u.user_lastvisit, a.*
	FROM " . USERS_TABLE . " u, " . ADV_PERSON_TABLE . " a
	WHERE a.person_id = u.user_id
	ORDER by a.user_id";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not get entries list', '', __LINE__, __FILE__, $sql); 
}
while( $row = $db->sql_fetchrow($result) )
{
	$users[$row['user_id']][] = array(
		$row['person_id'],
		$row['username'],
		$row['user_posts'],
		$row['user_visit'],
		create_date($board_config['default_dateformat'], $row['user_regdate'], $board_config['board_timezone']),
		((($row['user_lastvisit'] ? create_date($board_config['default_dateformat'], $row['user_lastvisit'], $board_config['board_timezone']) : $lang['Never']))),
		decode_ip($row['person_ip'])
	);
}

$sql_adv = ($adv_person_field) ? ', u.' . $adv_person_field : '';
$i = 1;

$sql = "SELECT u.username, u.user_regdate, u.user_posts, u.user_id $sql_adv
	FROM (" . ADV_PERSON_TABLE . " a, " . USERS_TABLE . " u)
	WHERE u.user_id = a.user_id
	GROUP by u.user_id
	ORDER by u.username LIMIT $start, $user_topics_per_page";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not get entries list', '', __LINE__, __FILE__, $sql); 
}
while( $row = $db->sql_fetchrow($result) )
{
	$i++;
	$list_users = '';
	for($j = 0; $j < count($users[$row['user_id']]); $j++)
	{
		$cr_user = $users[$row['user_id']][$j];
		$list_users .= '<tr><td><a href="' . append_sid("../profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL .'=' . $cr_user[0]) . '" target="_blank" class="name">' . $cr_user[1] . '</a> - </td><td>' . $cr_user[2] . ' ,</td><td>' . $cr_user[3] . ' ,</td><td>' . $cr_user[4] . ' ,</td><td>' . $cr_user[5] . ' ,</td><td>' . $cr_user[6] . '</td></tr>';
	}
	$template->assign_block_vars('list',array(
		'ROW' => ($i % 2) ? '1' : '2',
		'USERNAME' => '<a href="' . append_sid("../profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL .'=' . $row['user_id']) . '" target="_blank" class="name">' . $row['username'] . '</a>',
		'JOINED' => create_date($board_config['default_dateformat'], $row['user_regdate'], $board_config['board_timezone']),
		'COUNTER' => $row[$adv_person_field],
		'ADV_USERS' => $list_users,
		'POSTS' => $row['user_posts'])
	);
}

$template->assign_vars(array(
	'L_ADV_TITLE' => $lang['adv_person'],
	'L_ADV_EXPLAIN' => $lang['Adv_explain'],
	'L_SETUP' => $lang['Configuration'],
	'L_ADV_HOURS' => $lang['Adv_time'],
	'L_USERS' => $lang['Memberlist'],
	'L_USERNAME' => $lang['Username'],
	'L_POSTS' => $lang['Total_posts'],
	'L_JOINED' => $lang['Joined'],
	'L_COUNTER' => $lang['Adv_counter'],
	'L_VISIT' => $lang['Ad_visit'],
	'L_LAST_VISIT' => $lang['Ad_last_visit'],

	'ADV_TIME' => intval($board_config['adv_person_time']),

	'S_ACTION' => append_sid("admin_advert_person.$phpEx"),
	)
);

$sql = "SELECT COUNT(DISTINCT user_id) as total
	FROM " . ADV_PERSON_TABLE;
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Error getting total users', '', __LINE__, __FILE__, $sql);
}
$total = $db->sql_fetchrow($result);

generate_pagination("admin_advert_person.$phpEx", $total['total'], $user_topics_per_page, $start). '&nbsp;';

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>