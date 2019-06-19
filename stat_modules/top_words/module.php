<?php

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

$statistics_module = true;

/***************************************************************************
 *                              module.php
 *                            -------------------
 *   begin                : Tuesday, Aug 20, 2002
 *   copyright            : RustyDragon 
 *   contact              : <dev@RustyDragon.com>, http://www.RustyDragon.com
 *   $Id: module.php,v 1.2 2002/09/28 22:17:32 RustyDragon Exp $
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

//
//All your code
//
//Vote Images based on the theme path, (i.e. templates/CURRNT_THEME/ is already inserted below)
$vote_left = "images/vote_lcap.gif";
$vote_right = "images/vote_rcap.gif";
$vote_bar = "images/voting_bar.gif";

$statistics->init_bars();

if (!$statistics->result_cache_used)
{
	// Init Cache -- tells the Stats Mod that we want to use the result cache
	$result_cache->init_result_cache();

	$rank = 0;
	//
	// Getting voting bar info from template
	//
	if( !$board_config['override_user_style'] )
	{
		if( $userdata['user_id'] != ANONYMOUS && isset($userdata['user_style']) )
		{
			$style = $userdata['user_style'];
			if( !$theme )
			$style =  $board_config['default_style'];
		}
		else
		$style =  $board_config['default_style'];
	}
	else
	$style =  $board_config['default_style'];

	$sql = "SELECT *
	FROM " . THEMES_TABLE . "
	WHERE themes_id = $style";

	if(!$result = $db->sql_query($sql))
	{
		message_die(CRITICAL_ERROR, "Couldn't query database for theme info.");
	}
	if( !$row = $db->sql_fetchrow($result) )
	{
		message_die(CRITICAL_ERROR, "Couldn't get theme data for themes_id=$style.");
	}

	$template_path = $phpbb_root_dir . 'templates/' ;
	$template_name = $row['template_name'] ;

	$current_template_path = $template_path . $template_name . '/';

	$template->assign_vars(array(
	"LEFT_GRAPH_IMAGE" => $current_template_path . $vote_left,
	"RIGHT_GRAPH_IMAGE" => $current_template_path . $vote_right,
	"GRAPH_IMAGE" => $current_template_path . $vote_bar)
	);

	// Total words
	$sql = "SELECT COUNT( word_id ) total_words FROM ".SEARCH_MATCH_TABLE;
	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Couldn't retrieve words data", "", __LINE__, get_module_fd_name(__FILE__), $sql);
	}
	$words_data = $db->sql_fetchrowset($result);
	$total_words = $words_data[0]['total_words'];

	//
	// Top words SQL
	//
	$sql = "SELECT COUNT( swm.word_id ) word_count, swm.word_id word_id, swl.word_text word_text
		FROM (" . SEARCH_MATCH_TABLE . " swm, " . SEARCH_WORD_TABLE . " swl)
		WHERE swm.word_id = swl.word_id
		GROUP BY swm.word_id
		ORDER BY word_count DESC LIMIT ".$return_limit*10;
	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Couldn't retrieve words data", "", __LINE__, get_module_fd_name(__FILE__), $sql);
	}

	$words_count = $db->sql_numrows($result);
	$words_data = $db->sql_fetchrowset($result);
	$percentage = 0;
	$bar_percent = 0;

	$stopwords_array = @file($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . "/search_stopwords.txt");
	@array_push($stopwords_array, 'quot');

	$j = 1;
	for ($i = 0; $i < $words_count && $j<=($return_limit); $i++)
	{
		$stopword_found = FALSE;
		for ($k = 0; $k < count($stopwords_array); $k++)
		{
			$stopword = trim($stopwords_array[$k]);
			if ($words_data[$i]['word_text'] == $stopword)
			{
				$stopword_found = TRUE;
				break;
			}
		}
		if ($stopword_found)
			continue;

		if ( $j == 1 )
		{
			$firstcount = $words_data[$i]['word_count'];
			$cst = ($firstcount > 0) ? 90 / $firstcount : 90;
		}

		if ( $words_data[$i]['word_count'] != 0  )
		{
			$percentage = ( $total_words ) ? round( min(100, ($words_data[$i]['word_count'] / $total_words) * 100), 2) : 0;
		}
		else
		{
			$percentage = 0;
		}
		$bar_percent = round($words_data[$i]['word_count'] * $cst);

		$template->assign_block_vars("words", array(
			"RANK" => $j,
			"CLASS" => ( !($j+1 % 2) ) ? $theme['td_class2'] : $theme['td_class1'],
			"WORD" => $words_data[$i]['word_text'],
			"PERCENTAGE" => $percentage,
			"BAR" => $bar_percent,
			"COUNT" => $words_data[$i]['word_count'])
		);
		$j++;
		$result_cache->assign_template_block_vars('words');
	}
}
else
{
	for ($i = 0; $i < $result_cache->block_num_vars('words'); $i++)
	{
		// Method 1: We are assigning the block variables from the result cache to the template. ;)
		$template->assign_block_vars('words', $result_cache->get_block_array('words', $i));

	}

}

$template->assign_vars(array(
	"L_RANK" => $lang['Rank'],
	"L_COUNT" => $lang['Uses'],
	"L_PERCENTAGE" => $lang['Percent'],
	"L_WORD" => $lang['Word'],
	"L_GRAPH" => $lang['Graph'],
	"MODULE_NAME" => $lang['module_name'])
);

?>