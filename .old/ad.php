<?php
/***************************************************************************
 *                                ad.php
 *                            -------------------
 *   begin                : Sunday, Dec 11, 2005
 *   copyright            : (C) Przemo (http://www.przemo.org/phpBB2/)
 *   email                : przemo@przemo.org
 *
 ***************************************************************************/

$ad_admin = 0;

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

$id = intval($HTTP_GET_VARS['id']);
if ( $id )
{
	$sql = "SELECT html
		FROM " . ADV_TABLE . "
		WHERE id = $id
			AND type = 1
		LIMIT 1";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not get entrie data', '', __LINE__, __FILE__, $sql); 
	}
	if ( $row = $db->sql_fetchrow($result) )
	{
		$url = preg_match("#<a(.*?)href=\"(.*?)\"([^>]*?)>(.*?)</a>#si", $row['html'], $match);
		$url = $match[2];
		if ( $url )
		{
			if ( !$HTTP_COOKIE_VARS[$unique_cookie_name . '_ad_' . $id] )
			{
				@setcookie($unique_cookie_name . '_ad_' . $id, '1', (time() + 3600), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);

				$sql = "UPDATE " . ADV_TABLE . "
					SET clicks = clicks + 1
					WHERE id = $id";
				$result = $db->sql_query($sql);
				sql_cache('clear', 'advertising');
			}

			if ( @preg_match('/Microsoft|WebSTAR|Xitami/', getenv('SERVER_SOFTWARE')) )
			{
				header('Refresh: 0; URL=' . $url);
				echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><meta http-equiv="refresh" content="0; url=' . $url . '"><title>Redirect</title></head><body><div align="center">If your browser does not support meta redirection please click <a href="' . $url . '">HERE</a> to be redirected</div></body></html>';
				exit;
			}

			// Behave as per HTTP/1.1 spec for others
			$url = str_replace('&amp;', '&', $url);
			header('Location: ' . $url);
			exit;
		}
		else
		{
			message_die(GENERAL_ERROR, 'Wrong url');
		}
	}
	else
	{
		message_die(GENERAL_ERROR, 'ID: ' . $id . ' not exist');
	}
}

$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);

$template->set_filenames(array(
	'body' => 'advertising.tpl')
);

if ( !$id )
{
	if ( $ad_admin && $userdata['user_level'] != ADMIN )
	{
		message_die(GENERAL_ERROR, 'Empty ID');
	}

	include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin_advert.' . $phpEx);

	$sql = "SELECT *
		FROM " . ADV_TABLE . "
		WHERE type = 1
			AND clicks > 0
		ORDER by porder";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not get entries list', '', __LINE__, __FILE__, $sql); 
	}
	while( $row = $db->sql_fetchrow($result) )
	{
		$url = preg_match("#<a(.*?)href=\"(.*?)\"([^>]*?)>(.*?)</a>#si", $row['html'], $match);

		$template->assign_block_vars('list', array(
			'NAME' => '<a href="ad.php?id=' . $row['id'] . '">' . $match[4] . '</a>',
			'CLICKS' => $row['clicks'],
			'FROM' => create_date($board_config['default_dateformat'], $row['added'], $board_config['board_timezone']),
			'PER_DAY' => (((CR_TIME - $row['added']) > 86400) ? round($row['clicks'] / ((CR_TIME - $row['added']) / 86400)) : '--'))
		);
	}

	$template->assign_vars(array(
		'L_POPULARITY' => $lang['Ad_clicks_list'],
		'L_VISIT' => $lang['Ad_clicks_visit'],
		'L_FROM' => $lang['From'],
		'L_PER_DAY' => $lang['Ad_clicks_day'])
	);
}

include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>