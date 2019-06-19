<?php
define('MODULE_ID', 5);
define('IN_PHPBB', 1);

//
// First we do the setmodules stuff for the admin cp.
//
if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['General']['Uaktualnienia'] = $filename;

	return;
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

$url = 'http://www.przemo.org/phpBB2';

echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><meta http-equiv="refresh" content="5; url=' . $url . '"><title>Redirect to update page</title></head><body><div align="center">Za chwilê zostaniesz przeniesiony na stronê: <a href="' . $url . '"><b>www.przemo.org/phpBB2/</b></a></div></body></html>';

?>