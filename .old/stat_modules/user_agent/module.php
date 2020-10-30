<?php

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

$statistics_module = true;

$statistics->init_bars($bars);
if (!$statistics->result_cache_used)
{
	// Init Cache -- tells the Stats Mod that we want to use the result cache
	$result_cache->init_result_cache();
	$sql = "SELECT user_agent
		FROM " . POSTS_TABLE . "
		GROUP by poster_id, user_agent";

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Couldn\'t retrieve user data', '', __LINE__, get_module_fd_name(__FILE__), $sql);
	}

	$agents = $systems = $browsers = $systems_t = $browsers_t = array();
	$total_systems = $total_browsers = 0;

	while( $row = $db->sql_fetchrow($result) )
	{
		if ( $row['user_agent'] )
		{
			$agent = @unserialize($row['user_agent']);
			if ( is_array($agent) )
			{
				if ( !strpos($agent[0], 'unknown') )
				{
					if ( @in_array($agent[0], $systems_t) )
					{
						$systems[$agent[0]] = $systems[$agent[0]] + 1;
					}
					else
					{
						$systems_t[] = $agent[0];
						$systems[$agent[0]] = 1;
					}
					$total_systems++;
				}
				if ( !strpos($agent[1], 'unknown') )
				{
					if ( @in_array($agent[1], $browsers_t) )
					{
						$browsers[$agent[1]] = $browsers[$agent[1]] + 1;
					}
					else
					{
						$browsers_t[] = $agent[1];
						$browsers[$agent[1]] = 1;
					}
					$total_browsers++;
				}
			}
		}
	}

	$i = 0;

	arsort($systems);
	reset($systems);
	arsort($browsers);
	reset($browsers);

	foreach($systems as $key => $val)
	{
		$class = ($i % 2) ? $theme['td_class2'] : $theme['td_class1'];

		$statistics->do_math(max($systems), $val, array_sum($systems));

		$title = ucwords(str_replace(array('icon_', '.gif', '_'), array('', '', ' | '), $key));
		$template->assign_block_vars('s_loop', array(
			'CLASS' => $class,
			'SYSTEM' => $images['images'] . '/user_agent/' . $key . '" title="' . $title . '" alt="' . $title ,
			'VALUE' => $val,
			'BAR' => $statistics->bar_percent)
		);
		$i++;
		$result_cache->assign_template_block_vars('s_loop');
	}

	foreach($browsers as $key => $val)
	{
		$class = ($i % 2) ? $theme['td_class2'] : $theme['td_class1'];

		$statistics->do_math(max($browsers), $val, array_sum($browsers));

		$title = ucwords(str_replace(array('icon_', '.gif', '_'), array('', '', ' | '), $key));
		if ( strpos($title, 'Ie"') === 0 ) $title = 'Internet Explorer';

		$template->assign_block_vars('b_loop', array(
			'CLASS' => $class,
			'BROWSER' => $images['images'] . '/user_agent/' . $key . '" title="' . $title . '" alt="' . $title ,
			'VALUE' => $val,
			'BAR' => $statistics->bar_percent)
		);
		$i++;
		$result_cache->assign_template_block_vars('b_loop');
	}
}
else
{
	for ($i = 0; $i < $result_cache->block_num_vars('s_loop'); $i++)
	{
		// Method 1: We are assigning the block variables from the result cache to the template. ;)
		$template->assign_block_vars('s_loop', $result_cache->get_block_array('s_loop', $i));

	}
	for ($i = 0; $i < $result_cache->block_num_vars('b_loop'); $i++)
	{
		// Method 1: We are assigning the block variables from the result cache to the template. ;)
		$template->assign_block_vars('b_loop', $result_cache->get_block_array('b_loop', $i));

	}

}
$template->assign_vars(array(
	'L_S_AGENT_TITLE' => $lang['Most_systems'],
	'L_B_AGENT_TITLE' => $lang['Most_browsers'])
);

?>