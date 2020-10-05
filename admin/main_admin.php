<?php
define('MODULE_ID', 0);

define('IN_PHPBB', true);

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = '../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

if ( $userdata['user_level'] != ADMIN )
{
	message_die(GENERAL_MESSAGE, 'Only admin can set main admins');
}

if ( isset($HTTP_POST_VARS['list']) )
{
	update_config('main_admin_id', str_replace("\'", "''", $HTTP_POST_VARS['list']));
	
	$message = $lang['Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_config'], "<a href=\"" . append_sid("admin_no_access.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

	message_die(GENERAL_MESSAGE, $message);
}

$template->set_filenames(array(
	'body' => 'admin/main_admin.tpl')
);

$template->assign_vars(array(
	'ID_LIST' => ($board_config['main_admin_id']) ? $board_config['main_admin_id'] : '',
	'S_LIST_ACTION' => append_sid("main_admin.$phpEx"),
	'L_ACCESS_TITLE' => $lang['access_title'],
	'SUBMIT' => $lang['Submit'],
	'CHANGE_LIST' => $lang['change_main_admin'])
); 

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>