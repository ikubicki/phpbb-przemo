<?php

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

$statistics_module = true;

if (!$statistics->result_cache_used)
{
	// Init Cache -- tells the Stats Mod that we want to use the result cache
	$result_cache->init_result_cache();
	$sql = "SELECT u.user_id, u.username, COUNT(a.user_id) as persons
		FROM " . USERS_TABLE . " u
		LEFT JOIN " . ADV_PERSON_TABLE . " a ON (a.user_id = u.user_id)
		WHERE u.user_id <> " . ANONYMOUS . "
			AND a.user_id IS NOT NULL
		GROUP BY u.user_id
		ORDER BY persons, u.username DESC
	LIMIT " . $return_limit;

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Couldn\'t retrieve user data', '', __LINE__, get_module_fd_name(__FILE__), $sql);
	}

	$i = 0;
	while( $row = $db->sql_fetchrow($result) )
	{
		$class = ($i % 2) ? $theme['td_class2'] : $theme['td_class1'];

		$template->assign_block_vars('adv', array(
			'CLASS' => $class,
			'ADV_PERSONS' => $row['persons'],
			'USERNAME' => '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '">' . $row['username'] . '</a>')
		);
		$i++;
		$result_cache->assign_template_block_vars('adv');
	}
}
else
{
	for ($i = 0; $i < $result_cache->block_num_vars('adv'); $i++)
	{
		// Method 1: We are assigning the block variables from the result cache to the template. ;)
		$template->assign_block_vars('adv', $result_cache->get_block_array('adv', $i));

	}

}
$template->assign_vars(array(
	'L_ADV_TITLE' => $lang['Most_adv_persons'],
	'L_USERNAME' => $lang['Username'],
	'L_ADV_PERSONS' => $lang['Persons_advert'])
);

?>