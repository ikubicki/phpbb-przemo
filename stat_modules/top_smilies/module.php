<?php

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

$statistics_module = true;

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

// Result Cache used here

//
// Top Smilies
//

//
// Start user modifiable variables
//

//
// Set smile_pref to 0, if you want that smilies are only counted once per post.
// This means that, if the same smilie is entered ten times in a message, only one is counted in that message.
//
$smile_pref = 1;

$bars = array(
	'left' => 'images/vote_lcap.gif',
	'right' => 'images/vote_rcap.gif',
	'bar' => 'images/voting_bar.gif'
);

//
// End user modifiable variables
//

$statistics->init_bars($bars);

//
// Functions
//

//
// sort multi-dimensional array - from File Attachment Mod
//
function smilies_sort_multi_array_attachment ($sort_array, $key, $sort_order) 
{
	$last_element = count($sort_array) - 1;

	$string_sort = ( is_string($sort_array[$last_element-1][$key]) ) ? TRUE : FALSE;

	for ($i = 0; $i < $last_element; $i++) 
	{
		$num_iterations = $last_element - $i;

		for ($j = 0; $j < $num_iterations; $j++) 
		{
			$next = 0;

			//
			// do checks based on key
			//
			$switch = FALSE;
			if ( !($string_sort) )
			{
				if ( ( ($sort_order == 'DESC') && (intval($sort_array[$j][$key]) < intval($sort_array[$j + 1][$key])) ) || ( ($sort_order == 'ASC') &&    (intval($sort_array[$j][$key]) > intval($sort_array[$j + 1][$key])) ) )
				{
					$switch = TRUE;
				}
			}
			else
			{
				if ( ( ($sort_order == 'DESC') && (strcasecmp($sort_array[$j][$key], $sort_array[$j + 1][$key]) < 0) ) || ( ($sort_order ==   'ASC') && (strcasecmp($sort_array[$j][$key], $sort_array[$j + 1][$key]) > 0) ) )
				{
					$switch = TRUE;
				}
			}

			if ($switch)
			{
				$temp = $sort_array[$j];
				$sort_array[$j] = $sort_array[$j + 1];
				$sort_array[$j + 1] = $temp;
			}
		}
	}

	return ($sort_array);
}

//
// END Functions
//

$template->assign_vars(array(
	'L_TOP_SMILIES' => $lang['module_name'],

	'L_USES' => $lang['Uses'],
	'L_RANK' => $lang['Rank'],
	'L_PERCENTAGE' => $lang['Percent'],
	'L_GRAPH' => $lang['Graph'],
	'L_IMAGE' => $lang['smiley_url'],
	'L_CODE' => $lang['smiley_code'])
);

//
// Most used smilies
//

// Determine if Caching is used
if (!$statistics->result_cache_used)
{
	// Init Cache -- tells the Stats Mod that we want to use the result cache
	$result_cache->init_result_cache();

	// With every new sql_query insult, the Statistics Mod will end the previous Control. ;)
	$sql = 'SELECT smile_url
	FROM ' . SMILIES_TABLE . '
	GROUP BY smile_url';

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Couldn\'t retrieve smilies data', '', __LINE__, get_module_fd_name(__FILE__), $sql);
	}

	$all_smilies = array();
	$total_smilies = 0;
	$limit = 0;

	if ($db->sql_numrows($result) > 0)
	{
		$smilies = $db->sql_fetchrowset($result);

		for ($i = 0; $i < count($smilies); $i++)
		{
			$sql = "SELECT *
			FROM " . SMILIES_TABLE . "
			WHERE smile_url = '" . $smilies[$i]['smile_url'] . "'";

			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Couldn\'t retrieve smilies data', '', __LINE__, get_module_fd_name(__FILE__), $sql);
			}

			$smile_codes = $db->sql_fetchrowset($result);
	
			$count = 0;

			for ($j = 0; $j < count($smile_codes); $j++)
			{
				$smile_codes[$j]['code'] = str_replace("'", "\'", $smile_codes[$j]['code']);
				$sql = "SELECT post_id, post_text
				FROM " . POSTS_TEXT_TABLE . "
				WHERE post_text LIKE '%" . $smile_codes[$j]['code'] . "%'";

				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Couldn\'t retrieve smilies data', '', __LINE__, get_module_fd_name(__FILE__), $sql);
				}

				if ($smile_pref == 0)
				{
					$count = $count + $db->sql_numrows($result);
				}
				else
				{
					while ($post = $db->sql_fetchrow($result))
					{
						$count = $count + substr_count($post['post_text'], $smile_codes[$j]['code']);
					}
				}
			}

			$all_smilies[$i]['count'] = $count;
			$all_smilies[$i]['code'] = $smile_codes[0]['code'];
		    $all_smilies[$i]['smile_url'] = $smile_codes[0]['smile_url'];
		    $total_smilies = $total_smilies + $count;
			if ($count > 0)
			{
				$limit++;
			}

			if ($limit == $return_limit)
			{
				break;
			}
		}
	}

	// Sort array
	$all_smilies = smilies_sort_multi_array_attachment($all_smilies, 'count', 'DESC');

	$limit = ( $return_limit > count($all_smilies) ) ? count($all_smilies) : $return_limit;

	for ($i = 0; $i < $limit; $i++)
	{
		if ($all_smilies[$i]['count'] != 0)
		{
			$class = ( !($i+1 % 2) ) ? $theme['td_class2'] : $theme['td_class1'];

			$statistics->do_math($all_smilies[0]['count'], $all_smilies[$i]['count'], $total_smilies);
/*
			// Method 1: We are assigning block variables to the cache, it's the same like we do it with the template
			$result_cache->assign_block_vars('topsmilies', array(
				'RANK' => $i+1,
				'CLASS' => $class,
				'CODE' => $all_smilies[$i]['code'],
				'USES' => $all_smilies[$i]['count'],
				'PERCENTAGE' => $statistics->percentage,
				'BAR' => $statistics->bar_percent,
				'URL' => '<img src="'. $board_config['smilies_path'] . '/' . $all_smilies[$i]['smile_url'] . '" alt="' . $all_smilies[$i]['smile_url'] . '" border="0">')
			);
*/
			$template->assign_block_vars('topsmilies', array(
				'RANK' => $i+1,
				'CLASS' => $class,
				'CODE' => $all_smilies[$i]['code'],
				'USES' => $all_smilies[$i]['count'],
				'PERCENTAGE' => $statistics->percentage,
				'BAR' => $statistics->bar_percent,
				'URL' => '<img src="'. $board_config['smilies_path'] . '/' . $all_smilies[$i]['smile_url'] . '" alt="' . $all_smilies[$i]['smile_url'] . '" border="0">')
			);

			// Method 2: We are just using the assigned Variables from the last block iteration, have to be called after $template->assign_block_vars
			$result_cache->assign_template_block_vars('topsmilies');
		
		}
	}
}
else
{
	// Now use the result cache, with block_num_vars we are getting the number of variables within the block
	for ($i = 0; $i < $result_cache->block_num_vars('topsmilies'); $i++)
	{
		// Method 1: We are assigning the block variables from the result cache to the template. ;)
		$template->assign_block_vars('topsmilies', $result_cache->get_block_array('topsmilies', $i));

/*		
		// Method 2: We are getting every block variable from the block iteration
		$template->assign_block_vars('topsmilies', array(
			'RANK' => $result_cache->get_block_var('topsmilies', 'RANK', $i),
			'CLASS' => $result_cache->get_block_var('topsmilies', 'CLASS', $i),
			'CODE' => $result_cache->get_block_var('topsmilies', 'CODE', $i),
			'USES' => $result_cache->get_block_var('topsmilies', 'USES', $i),
			'PERCENTAGE' => $result_cache->get_block_var('topsmilies', 'PERCENTAGE', $i),
			'BAR' => $result_cache->get_block_var('topsmilies', 'BAR', $i),
			'URL' => $result_cache->get_block_var('topsmilies', 'URL', $i))
		);
*/
	}

}

?>