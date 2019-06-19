<?php
/***************************************************************************
 *							   attachment_mod.php
 *                            -------------------
 *   begin                : Monday, Jan 07, 2002
 *   copyright            : (C) 2002 Meik Sievertsen
 *   email                : acyd.burn@gmx.de
 *
 *   $Id: attachment_mod.php,v 1.20 2004/07/31 15:15:53 acydburn Exp $
 *
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

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
	exit;
}

if ( !defined('ATTACH') )
{	
	define('ATTACH', true);
}

include($phpbb_root_path . 'attach_mod/includes/constants.'.$phpEx);
include($phpbb_root_path . 'attach_mod/includes/functions_includes.'.$phpEx);
include($phpbb_root_path . 'attach_mod/includes/functions_attach.'.$phpEx);
include($phpbb_root_path . 'attach_mod/includes/functions_delete.'.$phpEx);
include($phpbb_root_path . 'attach_mod/includes/functions_thumbs.'.$phpEx);
include($phpbb_root_path . 'attach_mod/includes/functions_filetypes.'.$phpEx);

// Please do not change the include-order, it is valuable for proper execution.
// Functions for displaying Attachment Things
include($phpbb_root_path . 'attach_mod/displaying.'.$phpEx);
// Posting Attachments Class (HAVE TO BE BEFORE PM)
include($phpbb_root_path . 'attach_mod/posting_attachments.'.$phpEx);
// PM Attachments Class
include($phpbb_root_path . 'attach_mod/pm_attachments.'.$phpEx);

if (!intval($attach_config['allow_ftp_upload']))
{
	$upload_dir = $attach_config['upload_dir'];
}
else
{
	$upload_dir = $attach_config['download_path'];
}

?>