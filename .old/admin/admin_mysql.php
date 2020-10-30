<?php
/***************************************************************************
 *                      admin_mysql.php
 *                      -------------------
 * begin                : Thursday, Jul 12, 2001
 * copyright            : (C) 2003 Przemo http://www.przemo.org
 * email                : przemo@przemo.org
 * version              : 1.12.0
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
define('MODULE_ID', 49);
define('IN_PHPBB', true);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['SQL']['MySQL'] = $filename;
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = '../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

$sql = '';

if ( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
{
	$mode = ( isset($HTTP_GET_VARS['mode']) ) ? $HTTP_GET_VARS['mode'] : $HTTP_POST_VARS['mode'];
}
if( strstr($board_config['main_admin_id'], ',') )
{
	$fids = explode(',', $board_config['main_admin_id']);
	while( list($foo, $id) = each($fids) )
	{
		$fid[] = intval( trim($id) );
	}
}
else
{
	$fid[] = intval( trim($board_config['main_admin_id']) );
}
reset($fid);

if ( in_array($userdata['user_id'], $fid) == false )
{
	$message = sprintf($lang['SQL_Admin_No_Access'], '<a href="' . append_sid("admin_no_access.$phpEx") . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

$template->set_filenames(array(
	'body' => 'admin/admin_mysql_body.tpl')
);


if ( $HTTP_POST_VARS['this_query'] )
{
	$this_query = trim($HTTP_POST_VARS['this_query']);

	$queries = explode(';', $this_query);

	for ($i = 0; $i < count($queries); $i++)
	{
		$body = '';
		$cr_query = stripslashes($queries[$i]);

		if ( !$cr_query ) continue;

		if (!($db->sql_query($cr_query)))
		{
			$error   = $db->sql_error();
			$message = sprintf($lang['cannot_execute'], xhtmlspecialchars($cr_query).'<br><br>'.$error['message'], '<a href="' . append_sid("admin_mysql.$phpEx") . '">', '</a>');
			message_die(GENERAL_ERROR, $message);
		}

		if ( isset($keys) )
		{
			unset($keys);
		}

		$j = 0;

			while( $row = $db->sql_fetchrow($result) )
			{
				if ( !isset($keys) )
				{
					$body .= '<tr>';
					$keys = array();
					foreach($row as $key => $val)
					{
						$body .= '<td class="row3" align="center"><b>' . $key . '</b></td>';
						$keys[] = $key;
					}
					$body .= '</tr>';
				}

				$class = ($j % 2) ? 'row2' : 'row1';
				$body .= '<tr>';
				for ($k = 0; $k < count($keys); $k++)
				{
					$body .= '<td class="' . $class . '" align="center">' . xhtmlspecialchars($row[$keys[$k]]) . '</td>';
				}
				$body .= '</tr>';
				$j++;

			}

			$l_number = ($i) ? ' ' . ($i+1) : '';
			$template->assign_block_vars('result', array(
				'L_RESULT' => $lang['Hide_vote'] . $l_number,
				'INFO' => sprintf($lang['execute_done'], $db->sql_affectedrows(), $cr_query, '<a href="' . append_sid("admin_mysql.$phpEx") . '">', '</a>'),
				'BODY' => $body)
			);
	}
}


$template->assign_vars(array(
	'THIS_QUERY' => stripslashes(trim(xhtmlspecialchars($HTTP_POST_VARS['this_query']))),
	'L_DO_QUERY' => $lang['do_query'],
	'L_SUBMIT' => $lang['Do_Prune'],
	'CANCEL' => $lang['Delete'],
	'EXECUTE' => $lang['execute'],
	'TABLE' => $lang['Optimize_Table'],
	'MYSQL_E' => sprintf($lang['mysql_e'], $table_prefix),
	'MYSQL_ACTION' => append_sid("admin_mysql.$phpEx"))
); 


$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>