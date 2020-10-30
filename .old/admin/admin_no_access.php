<?php
/***************************************************************************
 *				  admin_mysql.php
 *				  -------------------
 *   begin			  : 23.06.2003
 *   copyright		  : (C) 2003 Przemo
 *   email			  : przemo@przemo.org
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

define('MODULE_ID', 'allow');
define('IN_PHPBB', true);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['SQL']['Permissions'] = $filename;
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = '../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);


$template->set_filenames(array(
	'body' => 'admin/admin_no_access.tpl')
);

$template->assign_vars(array(
	'L_ACCESS_TITLE' => sprintf($lang['access_title'], append_sid("admin_words.$phpEx")),
	'L_ACCESS_EXPLAIN' => sprintf($lang['access_explain'], '<a href="' . append_sid("main_admin.$phpEx") . '" class="gen">', '</a>'))
); 

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>