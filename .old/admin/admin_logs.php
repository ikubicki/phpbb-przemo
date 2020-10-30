<?php
define('MODULE_ID', 47);
define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Logs']['logs'] = $filename;

	return;
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

$logfile = './admin_logs.'.$phpEx;
$filesize = filesize($logfile);
$real_size = round(($filesize / 1000000), 1);

@set_time_limit('300');

if ( $real_size > 2 )
{
	$this_rand = rand(100000, 999999);
	$dest = $phpbb_root_path . 'files/admin_logs._' . $this_rand . '_' . $phpEx.'.gz';
	$mode = 'wb'.$level;
	$error = false;

	if ( $fp_out = gzopen($dest, $mode) )
	{
		if ( $fp_in = fopen($logfile, 'rb') )
		{
			while(!feof($fp_in))
			{
				gzputs($fp_out, fread($fp_in,1024*512));
			}
			fclose($fp_in);
		}
		else
		{
			message_die(GENERAL_ERROR, sprintf($lang['log_file_limit_error1'], $logfile));
		}
		gzclose($fp_out);
	}
	else
	{
		message_die(GENERAL_ERROR, sprintf($lang['log_file_limit_error2'], $dest));
	}
	$file_dest = 'files/admin_logs._' . $this_rand . '_' . $phpEx.'.gz';
	message_die(GENERAL_MESSAGE, sprintf($lang['log_file_limit_info'], $real_size, '/files/admin_logs._' . $this_rand . '_' . $phpEx.'.gz', '<a href="../' . $file_dest . '">', '</a>'));
}

echo'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=' . $lang['ENCODING'] . '" />
<title>Logs</title>
</head>
<table width="100%" cellpadding="6" cellspacing="1" border="0" class="forumline">
<tr>
<th width="25%" height="25">' . $lang['l_logsip'] . '</th>
</tr>
<tr>
<td class="row1">' . $lang['l_logsip_e'] . '
</td>
</tr>
</table>
<body bgcolor="#E5E5E5" text="#000000" link="#006699" vlink="#5493B4">
<br>
<font face="Arial, Helvetica, sans-serif" size="1">
/admin/admin_logs.php size: <b>' . $real_size . '</b> Mb.<br /><br />';
?>

