<?php
/***************************************************************************
 *                                install.php
 *                            -------------------
 *   begin                : Tuesday, Sept 11, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: install.php,v 1.6.2.13 2005/03/15 18:33:16 acydburn Exp $
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

header('Content-type: text/html; charset=utf-8');
 @set_time_limit(0);
// ---------
// FUNCTIONS
//
function page_header($text, $form_action = false)
{
	global $phpEx, $lang;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $lang['ENCODING']; ?>">
<meta http-equiv="Content-Style-Type" content="text/css">
<title><?php echo $lang['Welcome_install'];?></title>
<link rel="stylesheet" href="templates/subSilver/subSilver.css" type="text/css">
<style type="text/css">
<!--
th			{ background-image: url('templates/subSilver/images/cellpic3.gif') }
td.cat		{ background-image: url('templates/subSilver/images/cellpic1.gif') }
td.rowpic	{ background-image: url('templates/subSilver/images/cellpic2.jpg'); background-repeat: repeat-y }
td.catHead,td.catSides,td.catLeft,td.catRight,td.catBottom { background-image: url('templates/subSilver/images/cellpic1.gif') }

//-->
</style>

<script language="Javascript" type="text/javascript">
<!-- 
function Active(what)
{
	what.style.backgroundColor='#FFFFFF';
}
function NotActive(what)
{
	what.style.backgroundColor='';
}
//-->
</script>

</head>
<body bgcolor="#E5E5E5" text="#000000" link="#006699" vlink="#5584AA">

<table width="100%" border="0" cellspacing="0" cellpadding="10" align="center"> 
	<tr>
		<td class="bodyline" width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><img src="templates/subSilver/images/logo_phpBB.gif" border="0" alt="Forum Home" vspace="1" /></td>
								<td align="center" width="100%" valign="middle"><span class="maintitle"><?php echo $lang['Welcome_install'];?></span></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td><br /><br /></td>
				</tr>
				<tr>
					<td colspan="2">
						<table width="90%" border="0" align="center" cellspacing="0" cellpadding="0">
							<tr>
								<td><span class="gen"><?php echo $text; ?></span></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td><br /><br /></td>
				</tr>
				<tr>
					<td width="100%">
						<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
						<form action="<?php echo ($form_action) ? $form_action : 'install.'.$phpEx; ?>" name="install" method="post">
<?php

}

function page_footer()
{

?>
				</table></form></td>
			</tr>
		</table></td>
	</tr>
</table>

</body>
</html>
<?php

}

function md5_checksum($file)
{
	if ( file_exists($file) )
	{
		$fd = @fopen($file, 'r');
		$fileContents = @fread($fd, @filesize($file));
		@fclose($fd);
		return md5($fileContents);
	}
	else
	{
		return false;
	}
}

function page_common_form($hidden, $submit)
{

?>
					<tr> 
					  <td class="catBottom" align="center" colspan="2"><?php echo $hidden; ?><input class="mainoption" type="submit" value="<?php echo $submit; ?>" /></td>
					</tr>
<?php

}

function page_error($error_title, $error)
{

?>
					<tr>
						<th><?php echo $error_title; ?></th>
					</tr>
					<tr>
						<td class="row1" align="center"><span class="gen"><?php echo $error; ?></span></td>
					</tr>
<?php

}

// Guess an initial language ... borrowed from phpBB 2.2 it's not perfect, 
// really it should do a straight match first pass and then try a "fuzzy"
// match on a second pass instead of a straight "fuzzy" match.
function guess_lang()
{
	global $phpbb_root_path, $HTTP_SERVER_VARS;

	// The order here _is_ important, at least for major_minor
	// matches. Don't go moving these around without checking with
	// me first - psoTFX
	$match_lang = array(
		'polish'					=> 'pl',
		'english'					=> 'en([_-][a-z]+)?', 
	);

	if (isset($HTTP_SERVER_VARS['HTTP_ACCEPT_LANGUAGE']))
	{
		$accept_lang_ary = explode(',', $HTTP_SERVER_VARS['HTTP_ACCEPT_LANGUAGE']);
		for ($i = 0; $i < sizeof($accept_lang_ary); $i++)
		{
			@reset($match_lang);
			while (list($lang, $match) = each($match_lang))
			{
				if (preg_match('#' . $match . '#i', trim($accept_lang_ary[$i])))
				{
					if (file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_' . $lang)))
					{
						return $lang;
					}
				}
			}
		}
	}

	return 'english';
	
}

function check_sql_error($mode, $lang_txt = '')
{
	global $db, $lang, $table_prefix, $dbname, $HTTP_POST_VARS, $dbms_basic, $dbms_schema;

	if ( !isset($db) || !isset($table_prefix) || !isset($dbname) )
	{
		return;
	}

	$sql = "SHOW TABLES LIKE '$table_prefix%'";
	if ( !($result = $db->sql_query($sql)) )
	{
		return;
	}
	$tables = array();
	while( $row = $db->sql_fetchrow($result) )
	{
		$row = array_values($row);
		$tables[] = $row[0];
		if ( $mode == 'remove_tables' )
		{
			$sql2 = "DROP TABLE " . $row[0];
			if ( !($result2 = $db->sql_query($sql2)) )
			{
				die('SQL: ' . $sql2 . '<br />Could not delete table ' . $row[0]);
			}
		}
	}

	if ( $mode == 'check' )
	{
		$hidden_fields = '';
		foreach( $HTTP_POST_VARS as $name => $value )
		{
			if ( $name != "decission" && $name != "new_prefix" )
			{
				$hidden_fields .= '<input type="hidden" name="' . $name . '" value="' . stripslashes($value) . '" />';
			}
		}

		if ( count($tables) )
		{
			switch($lang_txt)
			{
				case '2':
					$lang_install_error = sprintf($lang['Install_duplicate_tables_info2'], $dbms_basic);
					break;
				case '3':
					$lang_install_error = sprintf($lang['Install_duplicate_tables_info2'], $dbms_basic);
					break;
				default:
					$lang_install_error = sprintf($lang['Install_duplicate_tables_info'], $dbms_schema, $dbname, $table_prefix);
			}
		}
		else
		{
			$lang_install_error = sprintf($lang['Install_duplicate_tables_info3'], $dbms_basic);
		}

		echo '<tr><td class="row2" align="center">' . $lang_install_error . '</td></tr><tr><td class="row1">
		' . $hidden_fields . '
		<table width="100%" border="0" align="center">';
		if ( count($tables) )
		{
			echo'<tr>
			<td align="right" width="50%" class="row2">' . sprintf($lang['Remove_tables'], $table_prefix) . '</td>
			<td align="left" class="row2"><input type="checkbox" name="decission" value="remove_tables" /></td>
			</tr>
			<td align="right" class="row2">' . $lang['Change_prefix'] . ':</td>
			<td align="left" class="row2"><input type="text" name="prefix" value="' . $table_prefix . '"></td>
			</tr>';
		}
		echo '<tr>
			<td colspan="2" class="row1" align="center"><input type="submit" name="continue" value="' . $lang['Continue'] . '" class="liteoption" /></td>
			</tr>';
	}
	return;
}

//
// FUNCTIONS
// ---------

// Begin
error_reporting  (E_ERROR | E_WARNING | E_PARSE); // This will NOT report uninitialized variables

// Disable magic_quotes_runtime
if(get_magic_quotes_runtime()) { @ini_set('magic_quotes_runtime', 0); }

// PHP5 with register_long_arrays off?
if (!isset($HTTP_POST_VARS) && isset($_POST))
{
	$HTTP_POST_VARS = $_POST;
	$HTTP_GET_VARS = $_GET;
	$HTTP_SERVER_VARS = $_SERVER;
	$HTTP_COOKIE_VARS = $_COOKIE;
	$HTTP_ENV_VARS = $_ENV;
	$HTTP_POST_FILES = $_FILES;

	// _SESSION is the only superglobal which is conditionally set
	if (isset($_SESSION))
	{
		$HTTP_SESSION_VARS = $_SESSION;
	}
}

// Slash data if it isn't slashed
if (!get_magic_quotes_gpc())
{
	if (is_array($HTTP_GET_VARS))
	{
		while (list($k, $v) = each($HTTP_GET_VARS))
		{
			if (is_array($HTTP_GET_VARS[$k]))
			{
				while (list($k2, $v2) = each($HTTP_GET_VARS[$k]))
				{
					$HTTP_GET_VARS[$k][$k2] = addslashes($v2);
				}
				@reset($HTTP_GET_VARS[$k]);
			}
			else
			{
				$HTTP_GET_VARS[$k] = addslashes($v);
			}
		}
		@reset($HTTP_GET_VARS);
	}

	if (is_array($HTTP_POST_VARS))
	{
		while (list($k, $v) = each($HTTP_POST_VARS))
		{
			if (is_array($HTTP_POST_VARS[$k]))
			{
				while (list($k2, $v2) = each($HTTP_POST_VARS[$k]))
				{
					$HTTP_POST_VARS[$k][$k2] = addslashes($v2);
				}
				@reset($HTTP_POST_VARS[$k]);
			}
			else
			{
				$HTTP_POST_VARS[$k] = addslashes($v);
			}
		}
		@reset($HTTP_POST_VARS);
	}

	if (is_array($HTTP_COOKIE_VARS))
	{
		while (list($k, $v) = each($HTTP_COOKIE_VARS))
		{
			if (is_array($HTTP_COOKIE_VARS[$k]))
			{
				while (list($k2, $v2) = each($HTTP_COOKIE_VARS[$k]))
				{
					$HTTP_COOKIE_VARS[$k][$k2] = addslashes($v2);
				}
				@reset($HTTP_COOKIE_VARS[$k]);
			}
			else
			{
				$HTTP_COOKIE_VARS[$k] = addslashes($v);
			}
		}
		@reset($HTTP_COOKIE_VARS);
	}
}

// Begin main prog
define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path.'extension.inc');

// Initialise some basic arrays
$userdata = array();
$lang = array();
$error = false;

// Include some required functions
include($phpbb_root_path.'includes/constants.'.$phpEx);
include($phpbb_root_path.'includes/functions.'.$phpEx);
include($phpbb_root_path.'includes/sessions.'.$phpEx);

// Define schema info
$available_dbms = array(
	'mysql'=> array(
		'LABEL'			=> 'MySQL 3.x',
		'SCHEMA'		=> 'mysql', 
		'DELIM'			=> ';',
		'DELIM_BASIC'	=> ';',
		'COMMENTS'		=> 'remove_remarks'
	), 
	'mysql4' => array(
		'LABEL'			=> 'MySQL 4.x/5.x',
		'SCHEMA'		=> 'mysql', 
		'DELIM'			=> ';', 
		'DELIM_BASIC'		=> ';',
		'COMMENTS'		=> 'remove_remarks'
	),
	'mysqli' => array(
		'LABEL'			=> 'MySQLi',
		'SCHEMA'		=> 'mysql', 
		'DELIM'			=> ';', 
		'DELIM_BASIC'		=> ';',
		'COMMENTS'		=> 'remove_remarks'
	)
);
$dir = 'cache/';
$res = @opendir($dir);
if ($res)
{
	while(($file = readdir($res)) !== false)
	{
		if ( is_file($dir . $file) && $file != '.htaccess' )
		{
			@unlink($dir . $file);
		}
	}
	@closedir($res);
}

// Obtain various vars
$confirm = (isset($HTTP_POST_VARS['confirm'])) ? true : false;
$cancel = (isset($HTTP_POST_VARS['cancel'])) ? true : false;

if (isset($HTTP_POST_VARS['install_step']) || isset($HTTP_GET_VARS['install_step']))
{
	$install_step = (isset($HTTP_POST_VARS['install_step'])) ? $HTTP_POST_VARS['install_step'] : $HTTP_GET_VARS['install_step'];
}
else
{
	$install_step = '';
}

$dbms = 'mysqli';

$dbhost = (!empty($HTTP_POST_VARS['dbhost'])) ? $HTTP_POST_VARS['dbhost'] : (getenv('DBHOST') ?: 'localhost');
$dbuser = (!empty($HTTP_POST_VARS['dbuser'])) ? $HTTP_POST_VARS['dbuser'] : getenv('DBUSER');
$dbpasswd = (!empty($HTTP_POST_VARS['dbpasswd'])) ? $HTTP_POST_VARS['dbpasswd'] : getenv('DBPASS');
$dbname = (!empty($HTTP_POST_VARS['dbname'])) ? $HTTP_POST_VARS['dbname'] : getenv('DBNAME');

$table_prefix = (!empty($HTTP_POST_VARS['prefix'])) ? $HTTP_POST_VARS['prefix'] : '';

$admin_name = (!empty($HTTP_POST_VARS['admin_name'])) ? $HTTP_POST_VARS['admin_name'] : getenv('ADMIN_NAME');
$admin_pass1 = (!empty($HTTP_POST_VARS['admin_pass1'])) ? $HTTP_POST_VARS['admin_pass1'] : getenv('ADMIN_PASS');
$admin_pass2 = (!empty($HTTP_POST_VARS['admin_pass2'])) ? $HTTP_POST_VARS['admin_pass2'] : getenv('ADMIN_PASS');

if (isset($HTTP_POST_VARS['lang']) && preg_match('#^[a-z_]+$#', $HTTP_POST_VARS['lang']))
{
	$language = strip_tags($HTTP_POST_VARS['lang']);
}
else
{
	$language = guess_lang();
}
$PHP_SELF = ($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : $_ENV['PHP_SELF'];
$board_email = (!empty($HTTP_POST_VARS['board_email'])) ? $HTTP_POST_VARS['board_email'] : getenv('ADMIN_EMAIL');
$script_path = (!empty($HTTP_POST_VARS['script_path'])) ? $HTTP_POST_VARS['script_path'] : str_replace('install', '', dirname($PHP_SELF));

if (!empty($HTTP_POST_VARS['server_name']))
{
	$server_name = $HTTP_POST_VARS['server_name'];
}
else
{
	// Guess at some basic info used for install..
	if (!empty($HTTP_SERVER_VARS['SERVER_NAME']) || !empty($HTTP_ENV_VARS['SERVER_NAME']))
	{
		$server_name = (!empty($HTTP_SERVER_VARS['SERVER_NAME'])) ? $HTTP_SERVER_VARS['SERVER_NAME'] : $HTTP_ENV_VARS['SERVER_NAME'];
	}
	else if (!empty($HTTP_SERVER_VARS['HTTP_HOST']) || !empty($HTTP_ENV_VARS['HTTP_HOST']))
	{
		$server_name = (!empty($HTTP_SERVER_VARS['HTTP_HOST'])) ? $HTTP_SERVER_VARS['HTTP_HOST'] : $HTTP_ENV_VARS['HTTP_HOST'];
	}
	else
	{
		$server_name = '';
	}
}

if (!empty($HTTP_POST_VARS['server_port']))
{
	$server_port = $HTTP_POST_VARS['server_port'];
}
else
{
	if (!empty($HTTP_SERVER_VARS['SERVER_PORT']) || !empty($HTTP_ENV_VARS['SERVER_PORT']))
	{
		$server_port = (!empty($HTTP_SERVER_VARS['SERVER_PORT'])) ? $HTTP_SERVER_VARS['SERVER_PORT'] : $HTTP_ENV_VARS['SERVER_PORT'];
	}
	else
	{
		$server_port = '80';
	}
}

// Open config.php ... if it exists
if (@file_exists(@phpbb_realpath('config.'.$phpEx)))
{
	include($phpbb_root_path.'config.'.$phpEx);
}

// Is phpBB already installed? Yes? Redirect to the index
if (defined("PHPBB_INSTALLED"))
{
	die('phpBB arleady installed. If you really want fresh install, clear the config.php file.');
}

// Import language file, setup template ...
include($phpbb_root_path.'language/lang_' . $language . '/lang_main.'.$phpEx);
include($phpbb_root_path.'language/lang_' . $language . '/lang_admin.'.$phpEx);
include($phpbb_root_path.'language/lang_' . $language . '/lang_install.'.$phpEx);
include($phpbb_root_path.'language/lang_' . $language . '/lang_profile.'.$phpEx);

// Ok for the time being I'm commenting this out whilst I'm working on
// better integration of the install with upgrade as per Bart's request
// JLH

include('check_data.'.$phpEx);
$wrong_checksum = '';
if ( $HTTP_GET_VARS['mode'] != 'break' )
{
	for($i=0; count($file_list) > $i; $i++)
	{
		if ( md5_checksum($file_list[$i]) != $md5_sum[$file_list[$i]] )
		{
			$content = md5_checksum($file_list[$i]);
			$wrong_checksum .= (($content) ? '<font color="red"><b>' . $file_list[$i] . '</b></font> - ' . sprintf($lang['Wrong_file_checksum'], $content) . '<br />' : '<font color="red"><b>' . $file_list[$i] . '</b></font> - <b>' . $lang['Missing_file'] . '</b><br />');
		}
	}
}

// What do we need to do?
if (!empty($HTTP_POST_VARS['send_file']) && $HTTP_POST_VARS['send_file'] == 1)
{
	header('Content-Type: text/x-delimtext; name="config.' . $phpEx . '"');
	header('Content-disposition: attachment; filename="config.' . $phpEx . '"');

	// We need to stripslashes no matter what the setting of magic_quotes_gpc is
	// because we add slashes at the top if its off, and they are added automaticlly 
	// if it is on.
	echo stripslashes($HTTP_POST_VARS['config_data']);

	exit;
}
else if ((empty($install_step) || $admin_pass1 != $admin_pass2 || empty($admin_pass1) || empty($dbhost)) || !(preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*?[a-z]+$/is', $HTTP_POST_VARS['board_email'])))
{
	// Ok we haven't installed before so lets work our way through the various
	// steps of the install process.  This could turn out to be quite a lengty 
	// process.

	if ( $wrong_checksum && !isset($HTTP_POST_VARS['install_step']) )
	{
		page_header($lang['Wrong_checksum'] . '<hr /><br />' . $wrong_checksum);
		page_footer();
		exit;
	}

	// Step 0 gather the pertinant info for database setup...
	// Namely dbms, dbhost, dbname, dbuser, and dbpasswd.
	$instruction_text = $lang['Inst_Step_0'];

	if (!empty($install_step) && $HTTP_POST_VARS['cur_lang'] == $language)
	{
		if ( ($HTTP_POST_VARS['admin_pass1'] != $HTTP_POST_VARS['admin_pass2']) || empty($HTTP_POST_VARS['admin_pass1']) )
		{
			$error .= $lang['Password_mismatch'] . '<br />';
		}
		if ( !$HTTP_POST_VARS['server_name'] )
		{
			$error .= $lang['Empty_server_name'] . '<br />';
		}
		if ( !$HTTP_POST_VARS['server_port'] )
		{
			$error .= $lang['Empty_port'] . '<br />';
		}
		if ( !$HTTP_POST_VARS['script_path'] )
		{
			$error .= $lang['Empty_path'] . '<br />';
		}
		if ( !$HTTP_POST_VARS['dbhost'] )
		{
			$error .= $lang['Empty_dbhost'] . '<br />';
		}
		if ( !$HTTP_POST_VARS['dbname'] )
		{
			$error .= $lang['Empty_dbname'] . '<br />';
		}
		if ( !$HTTP_POST_VARS['dbuser'] )
		{
			$error .= $lang['Empty_dbuser'] . '<br />';
		}
		if ( !$HTTP_POST_VARS['dbpasswd'] )
		{
			$error .= $lang['Empty_dbpasswd'] . '<br />';
		}
		if ( !$HTTP_POST_VARS['board_email'] )
		{
			$error .= $lang['Empty_email'] . '<br />';
		}
		if ( !$HTTP_POST_VARS['admin_name'] )
		{
			$error .= $lang['Empty_username'] . '<br />';
		}
		if ( !(preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*?[a-z]+$/is', $HTTP_POST_VARS['board_email'])) )
		{
			$error .= $lang['Email_invalid'] . '<br />';
		}
	}

	$dirname = $phpbb_root_path . 'language';
	$dir = opendir($dirname);

	$lang_options = array();
	while ($file = readdir($dir))
	{
		if (preg_match('#^lang_#i', $file) && !is_file(@phpbb_realpath($dirname . '/' . $file)) && !is_link(@phpbb_realpath($dirname . '/' . $file)))
		{
			$filename = trim(str_replace('lang_', '', $file));
			$displayname = preg_replace('/^(.*?)_(.*)$/', '\1 [ \2 ]', $filename);
			$displayname = preg_replace('/\[(.*?)_(.*)\]/', '[ \1 - \2 ]', $displayname);
			$lang_options[$displayname] = $filename;
		}
	}

	closedir($dir);

	@asort($lang_options);
	@reset($lang_options);

	$lang_select = '<select name="lang" onchange="this.form.submit()">';
	while (list($displayname, $filename) = @each($lang_options))
	{
		$selected = ($language == $filename) ? ' selected="selected"' : '';
		$lang_select .= '<option value="' . $filename . '"' . $selected . '>' . ucwords($displayname) . '</option>';
	}
	$lang_select .= '</select>';

	$mysql_selected = (@extension_loaded('mysqli')) ? 'mysqli' : 'mysql4';

	$dbms_select = '<select name="dbms" onchange="if(this.form.upgrade.options[this.form.upgrade.selectedIndex].value == 1){ this.selectedIndex = 0;}">';
	while (list($dbms_name, $details) = @each($available_dbms))
	{
		$selected = ($dbms_name == $dbms) ? ' selected="selected"' : '';
		if ( !$dbms && $dbms_name == $mysql_selected )
		{
			$selected = ' selected="selected"';
		}
		$dbms_select .= '<option value="' . $dbms_name . '"' . $selected . '>' . $details['LABEL'] . '</option>';
	}

	$s_hidden_fields = '<input type="hidden" name="install_step" value="1" /><input type="hidden" name="cur_lang" value="' . $language . '" />';

	page_header($instruction_text);

	if ($error)
	{
?>
					<tr>
						<td class="row1" colspan="2" align="center"><span class="nav" style="color:red"><?php echo $error; ?></span></td>
					</tr>
<?php

	}
	?>

					<tr>
						<th colspan="2"><?php echo $lang['Initial_config']; ?></th>
					</tr>
					<tr>
						<td class="row1" align="right"><span class="gen"><?php echo $lang['Default_lang']; ?>: </span></td>
						<td class="row2"><?php echo $lang_select; ?></td>
					</tr>
					<tr>
						<td class="row1" align="right" width="50%"><span class="gen"><?php echo $lang['Server_name']; ?>: </span></td>
						<td class="row2"><input type="text" name="server_name" value="<?php echo $server_name; ?>" class="post" onFocus="Active(this)" onBlur="NotActive(this)" /></td>
					</tr> 
					<tr>
						<td class="row1" align="right"><span class="gen"><?php echo $lang['Server_port']; ?>: </span></td>
						<td class="row2"><input type="text" name="server_port" value="<?php echo $server_port; ?>" class="post" onFocus="Active(this)" onBlur="NotActive(this)" /></td>
					</tr>
					<tr>
						<td class="row1" align="right"><span class="gen"><?php echo $lang['Script_path']; ?>: </span></td>
						<td class="row2"><input type="text" name="script_path" value="<?php echo $script_path; ?>" class="post" onFocus="Active(this)" onBlur="NotActive(this)" /></td>
					</tr>

					<tr>
						<th colspan="2"><?php echo $lang['DB_config']; ?></th>
					</tr>
					<tr>
						<td class="row1" align="right"><span class="gen"><?php echo $lang['DB_Host']; ?>: </span></td>
						<td class="row2"><input type="text" name="dbhost" value="<?php echo ($dbhost != '') ? $dbhost : ''; ?>" class="post" onFocus="Active(this)" onBlur="NotActive(this)" /></td>
					</tr>
					<tr>
						<td class="row1" align="right"><span class="gen"><?php echo $lang['DB_Name']; ?>: </span><br /><span class="gensmall"><?php echo $lang['DB_name_e']; ?></span></td>
						<td class="row2"><input type="text" name="dbname" value="<?php echo ($dbname != '') ? xhtmlspecialchars(stripslashes($dbname)) : ''; ?>" class="post" onFocus="Active(this)" onBlur="NotActive(this)" /></td>
					</tr>
					<tr>
						<td class="row1" align="right"><span class="gen"><?php echo $lang['DB_Username']; ?>: </span><br /><span class="gensmall"><?php echo $lang['DB_username_e']; ?></span></td>
						<td class="row2"><input type="text" name="dbuser" value="<?php echo ($dbuser != '') ? xhtmlspecialchars(stripslashes($dbuser)) : ''; ?>" class="post" onFocus="Active(this)" onBlur="NotActive(this)" /></td>
					</tr>
					<tr>
						<td class="row1" align="right"><span class="gen"><?php echo $lang['DB_Password']; ?>: </span></td>
						<td class="row2"><input type="password" name="dbpasswd" value="<?php echo ($dbpasswd != '') ? xhtmlspecialchars(stripslashes($dbpasswd)) : ''; ?>" class="post" onFocus="Active(this)" onBlur="NotActive(this)" /></td>
					</tr>
					<tr>
						<td class="row1" align="right"><span class="gen"><?php echo $lang['Table_Prefix']; ?>: </span><br /><span class="gensmall"><?php echo $lang['Table_Prefix_e']; ?></span></td>
						<td class="row2"><input type="text" name="prefix" value="<?php echo (!empty($table_prefix)) ? xhtmlspecialchars(stripslashes($table_prefix)) : "phpbb_"; ?>" class="post" onFocus="Active(this)" onBlur="NotActive(this)" /></td>
					</tr>
					<tr>
						<th colspan="2"><?php echo $lang['Admin_config']; ?></th>
					</tr>
					<tr>
						<td class="row3" colspan="2" align="center"><span class="gensmall"><?php echo $lang['Admin_config_e']; ?> </span></td>
					</tr>
					<tr>
						<td class="row1" align="right"><span class="gen"><?php echo $lang['Admin_email']; ?>: </span></td>
						<td class="row2"><input type="text" name="board_email" value="<?php echo ($board_email != '') ? xhtmlspecialchars(stripslashes($board_email)) : ''; ?>" class="post" onFocus="Active(this)" onBlur="NotActive(this)" /></td>
					</tr> 
					<tr>
						<td class="row1" align="right"><span class="gen"><?php echo $lang['Admin_Username']; ?>: </span></td>
						<td class="row2"><input type="text" name="admin_name" value="<?php echo ($admin_name != '') ? xhtmlspecialchars(stripslashes($admin_name)) : ''; ?>" class="post" onFocus="Active(this)" onBlur="NotActive(this)" /></td>
					</tr>
					<tr>
						<td class="row1" align="right"><span class="gen"><?php echo $lang['Admin_Password']; ?>: </span></td>
						<td class="row2"><input type="password" name="admin_pass1" value="<?php echo ($admin_pass1 != '') ? xhtmlspecialchars(stripslashes($admin_pass1)) : ''; ?>" class="post" onFocus="Active(this)" onBlur="NotActive(this)" /></td>
					</tr>
					<tr>
						<td class="row1" align="right"><span class="gen"><?php echo $lang['Admin_Password_confirm']; ?>: </span></td>
						<td class="row2"><input type="password" name="admin_pass2" value="<?php echo ($admin_pass2 != '') ? xhtmlspecialchars(stripslashes($admin_pass2)) : ''; ?>" class="post" onFocus="Active(this)" onBlur="NotActive(this)" /></td>
					</tr>
					<?php
					$files_check = array('files', 'files/tmp', 'files/thumbs', 'images/avatars', 'images/avatars/tmp', 'images/avatars/upload', 'images/avatars/upload/tmp', 'images/photos/tmp', 'images/signatures', 'images/signatures/tmp', 'cache');
					$writable = true;
					for($i = 0; $i < count($files_check); $i++)
					{
						if ( !is_writable($phpbb_root_path . $files_check[$i]) )
						{
							$writable = false;
						}
					}
					if ( !$writable )
					{
						echo'<tr>
						<td class="row3" align="right" colspan="2"><span class="gen">' . sprintf($lang['Install_warning_1'], 'config.' . $phpEx) . '</span></td>
					</tr>';
					}

	page_common_form($s_hidden_fields, $lang['Start_Install']);
	page_footer();
	exit;
}
else
{
	
	// Go ahead and create the DB, then populate it
	//
	// MS Access is slightly different in that a pre-built, pre-
	// populated DB is supplied, all we need do here is update
	// the relevant entries
	if (isset($dbms))
	{
		switch($dbms)
		{
			case 'mysql':
			case 'mysql4':
				$check_exts  = 'mysql';
				$check_func = 'mysql_query';
				break;
		    case 'mysqli':
				$check_exts = 'mysqli';
				$check_func = 'mysqli_query';
				break;
		}

		if ( !extension_loaded($check_exts) || !function_exists($check_func) )
		{
			page_header($lang['Install'], '');
			page_error($lang['Installer_Error'], $lang['Install_No_Ext']);
			page_footer();
			exit;
		}
		include($phpbb_root_path.'includes/db.'.$phpEx);
	}

	$dbms_schema = 'db/schemas/' . $available_dbms[$dbms]['SCHEMA'] . '_schema.sql';
	$dbms_basic = 'db/schemas/' . $available_dbms[$dbms]['SCHEMA'] . '_basic.sql';

	if ( !@file_exists($dbms_schema) )
	{
		die('File <b>' . $dbms_schema . '</b> not exists.<br />');
	}
	if ( !@file_exists($dbms_basic) )
	{
		die('File <b>' . $dbms_basic . '</b> not exists.<br />');
	}

	$remove_remarks = $available_dbms[$dbms]['COMMENTS'];;
	$delimiter = $available_dbms[$dbms]['DELIM']; 
	$delimiter_basic = $available_dbms[$dbms]['DELIM_BASIC']; 

	if ($install_step == 1)
	{
		if ($upgrade != 1)
		{
			if ($dbms != 'msaccess')
			{

				// Load in the sql parser
				include($phpbb_root_path.'includes/sql_parse.'.$phpEx);

				// Ok we have the db info go ahead and read in the relevant schema
				// and work on building the table.. probably ought to provide some
				// kind of feedback to the user as we are working here in order
				// to let them know we are actually doing something.
				$sql_query = @fread(@fopen($dbms_schema, 'r'), @filesize($dbms_schema));
				$sql_query = preg_replace('/phpbb_/', $table_prefix, $sql_query);

				$sql_query = $remove_remarks($sql_query);
				$sql_query = split_sql_file($sql_query, $delimiter);

				if ( $HTTP_POST_VARS['decission'] == 'remove_tables' )
				{
					check_sql_error('remove_tables');
				}

				for ($i = 0; $i < sizeof($sql_query); $i++)
				{
					if (trim($sql_query[$i]) != '')
					{
						if (!($result = $db->sql_query($sql_query[$i])))
						{
							$error = $db->sql_error();
							page_header($lang['Install'], '');
							page_error($lang['Installer_Error'], $lang['Install_db_error'] . ':<br /><br /><span class="gensmall">' . $sql_query[$i] . '</span><br /><br /><b>' . $error['message'] . '<b><br /><br />');
							check_sql_error('check');
							page_footer();
							exit;
						}
					}
				}
		
				// Ok tables have been built, let's fill in the basic information
				$sql_query = @fread(@fopen($dbms_basic, 'r'), @filesize($dbms_basic));
				$sql_query = preg_replace('/phpbb_/', $table_prefix, $sql_query);

				$sql_query = $remove_remarks($sql_query);
				$sql_query = split_sql_file($sql_query, $delimiter_basic);

				for($i = 0; $i < sizeof($sql_query); $i++)
				{
					if (trim($sql_query[$i]) != '')
					{
						if (!($result = $db->sql_query($sql_query[$i])))
						{
							$error = $db->sql_error();
							page_header($lang['Install'], '');
							page_error($lang['Installer_Error'], $lang['Install_db_error'] . ':<br /><br /><span class="gensmall">' . $sql_query[$i] . '</span><br /><br /><b>' . $error['message'] . '<b><br /><br />');
							check_sql_error('check', 2);
							page_footer();
							exit;
						}
					}
				}
			}

			// Ok at this point they have entered their admin password, let's go 
			// ahead and create the admin account with some basic default information
			// that they can customize later, and write out the config file.  After
			// this we are going to pass them over to the admin_forum.php script
			// to set up their forum defaults.
			$error = '';

			// Update the default admin user with their information.
			$sql = "INSERT INTO " . $table_prefix . "config (config_name, config_value) 
				VALUES ('board_startdate', " . time() . ")";
			if (!$db->sql_query($sql))
			{
				$sql_error = $db->sql_error();

				if ( $sql_error['message'] != '' )
				{
					$debug_text = '';
					$debug_text .= '<br />SQL Error: ' . $sql_error['message'];
				}

				$error .= '<hr /><span class="gensmall">' . $sql . '</span><br /><b>' . $debug_text . '</b>';
			}

			$sql = "INSERT INTO " . $table_prefix . "config (config_name, config_value) 
				VALUES ('default_lang', '" . str_replace("\'", "''", $language) . "')";
			if (!$db->sql_query($sql))
			{
				$sql_error = $db->sql_error();

				if ( $sql_error['message'] != '' )
				{
					$debug_text = '';
					$debug_text .= '<br />SQL Error: ' . $sql_error['message'];
				}

				$error .= '<hr /><span class="gensmall">' . $sql . '</span><br /><b>' . $debug_text . '</b>';
			}

			$update_config = array(
				'board_email'	=> $board_email,
				'email_return_path'	=> $board_email,
				'email_from'	=> $board_email,
				'script_path'	=> $script_path,
				'server_port'	=> $server_port,
				'server_name'	=> $server_name,
				'cookie_domain'	=> $server_name,
			);

			while (list($config_name, $config_value) = each($update_config))
			{
				$sql = "UPDATE " . $table_prefix . "config
					SET config_value = '$config_value' 
					WHERE config_name = '$config_name'";
				if (!$db->sql_query($sql))
				{
					$sql_error = $db->sql_error();

					if ( $sql_error['message'] != '' )
					{
						$debug_text = '';
						$debug_text .= '<br />SQL Error: ' . $sql_error['message'];
					}

					$error .= '<hr /><span class="gensmall">' . $sql . '</span><br /><b>' . $debug_text . '</b>';
				}
			}
			
			$admin_pass_md5 = ($confirm && $userdata['user_level'] == ADMIN) ? $admin_pass1 : md5($admin_pass1);

			$sql = "UPDATE " . $table_prefix . "users 
				SET username = '" . str_replace("\'", "''", $admin_name) . "', user_password='" . str_replace("\'", "''", $admin_pass_md5) . "', user_lang = '" . str_replace("\'", "''", $language) . "', user_email='" . str_replace("\'", "''", $board_email) . "'
				WHERE username = 'Admin'";
			if (!$db->sql_query($sql))
			{
				$sql_error = $db->sql_error();

				if ( $sql_error['message'] != '' )
				{
					$debug_text = '';
					$debug_text .= '<br />SQL Error: ' . $sql_error['message'];
				}

				$error .= '<hr /><span class="gensmall">' . $sql . '</span><br /><b>' . $debug_text . '</b>';
			}

			$sql = "UPDATE " . $table_prefix . "users
				SET user_regdate = " . time();
			if (!$db->sql_query($sql))
			{
				$sql_error = $db->sql_error();

				if ( $sql_error['message'] != '' )
				{
					$debug_text = '';
					$debug_text .= '<br />SQL Error: ' . $sql_error['message'];
				}

				$error .= '<hr /><span class="gensmall">' . $sql . '</span><br /><b>' . $debug_text . '</b>';
			}

			$sql = "SELECT username, user_id
				FROM " . $table_prefix . "users
				WHERE user_id <> '-1'
				ORDER BY user_id DESC
				LIMIT 1";
			if ( $result = $db->sql_query($sql) )
			{
				$row = $db->sql_fetchrow($result);

				$sql = "UPDATE " . $table_prefix . "config
					SET config_value = '" . str_replace("'", "''", serialize($row)) . "'
					WHERE config_name = 'newestuser'";
				$db->sql_query($sql);
			}
			$sql = "SELECT COUNT(user_id) AS total
				FROM " . $table_prefix . "users
				WHERE user_id <> '-1'";
			if ( $result = $db->sql_query($sql) )
			{
				$row = $db->sql_fetchrow($result);

				$sql = "UPDATE " . $table_prefix . "config
					SET config_value = '" . $row['total'] . "'
					WHERE config_name = 'usercount'";
				$db->sql_query($sql);
			}

			$sql = "SELECT SUM(forum_topics) AS topic_total, SUM(forum_posts) AS post_total
				FROM " . $table_prefix . "forums";
			if ( $result = $db->sql_query($sql) )
			{
				$row = $db->sql_fetchrow($result);

				$sql = "UPDATE " . $table_prefix . "config
					SET config_value = '" . $row['topic_total'] . "'
					WHERE config_name = 'topiccount'";
				$db->sql_query($sql);

				$sql = "UPDATE " . $table_prefix . "config
					SET config_value = '" . $row['post_total'] . "'
					WHERE config_name = 'postcount'";
				$db->sql_query($sql);
			}

			if ($error != '')
			{
				page_header($lang['Install'], '');
				page_error($lang['Installer_Error'], $lang['Install_db_error'] . '<br /><br />' . $error);
				check_sql_error('check', 3);
				page_footer();
				exit;
			}
		}
		
		$encryption_key = md5(microtime());

		if (!$upgrade_now)
		{	
			// Write out the config file.
			$config_data = '<?php'."\n\n";
			$config_data .= "\n// phpBB 2.x auto-generated config file\n// Do not change anything in this file!\n\n";
			$config_data .= '$dbms = \'' . $dbms . '\';' . "\n\n";
			$config_data .= '$dbhost = \'' . $dbhost . '\';' . "\n";
			$config_data .= '$dbname = \'' . $dbname . '\';' . "\n";
			$config_data .= '$dbuser = \'' . $dbuser . '\';' . "\n";
			$config_data .= '$dbpasswd = \'' . $dbpasswd . '\';' . "\n\n";
			$config_data .= '$dbchars = \'utf8mb4\';' . "\n\n";
			$config_data .= '$table_prefix = \'' . $table_prefix . '\';' . "\n\n";
			$config_data .= '$content_encoding = \'utf-8\';' . "\n\n";
			$config_data .= '$encryption_key = \'' . $encryption_key . '\';' . "\n\n";
			$config_data .= 'define(\'PHPBB_INSTALLED\', true);'."\n\n";
			
			@umask(0111);
			$no_open = FALSE;

			// Unable to open the file writeable do something here as an attempt
			// to get around that...
			if (!($fp = @fopen($phpbb_root_path . 'config.'.$phpEx, 'w')))
			{
				$s_hidden_fields = '<input type="hidden" name="config_data" value="' . xhtmlspecialchars($config_data) . '" />';

				page_header($lang['Unwriteable_config']);
				$s_hidden_fields .= '<input type="hidden" name="send_file" value="1" />';

				$short_data = '<?php'."\n";
				$short_data .= '$dbms = \'' . $dbms . '\';' . "\n";
				$short_data .= '$dbhost = \'' . $dbhost . '\';' . "\n";
				$short_data .= '$dbname = \'' . $dbname . '\';' . "\n";
				$short_data .= '$dbuser = \'' . $dbuser . '\';' . "\n";
				$short_data .= '$dbpasswd = \'' . $dbpasswd . '\';' . "\n";
				$short_data .= '$dbchars = \'utf8mb4\';' . "\n\n";
				$short_data .= '$table_prefix = \'' . $table_prefix . '\';' . "\n";
				$short_data .= '$content_encoding = \'utf-8\';' . "\n\n";
				$short_data .= '$encryption_key = \'' . $encryption_key . '\';' . "\n\n";
				$short_data .= 'define(\'PHPBB_INSTALLED\', true);'."\n";	
				$short_data .= '?' . '>'; // Done this to prevent highlighting editors getting confused!

				page_common_form($s_hidden_fields, $lang['Download_config']);

				echo '</table>
				</form><br /><br />
				<table width="100%" align="center" class="forumline" cellspacing="1" cellpading="1">
					<tr>
						<td class="catHead" align="center"><span class="nav">' . $lang['After_downloading'] . '</td>
					</tr>
					<tr>
						<td align="center" class="row1">
						<br />
						<form action="login.' . $phpEx . '" method="post">
						<input type="hidden" name="username" value="' . stripslashes($HTTP_POST_VARS['admin_name']) . '" />
						<input type="hidden" name="password" value="' . stripslashes($HTTP_POST_VARS['admin_pass1']) . '" />
						<input type="hidden" name="redirect" value="admin/index.'.$phpEx.'" />
						<input type="hidden" name="login" value="true" />
						<input type="submit" name="submit" value="' . $lang['Go_to_admin_panel'] . '" class="liteoption" />
						</form>&nbsp;&nbsp;&nbsp;
						<form action="login.' . $phpEx . '" method="post">
						<input type="hidden" name="username" value="' . stripslashes($HTTP_POST_VARS['admin_name']) . '" />
						<input type="hidden" name="password" value="' . stripslashes($HTTP_POST_VARS['admin_pass1']) . '" />
						<input type="hidden" name="redirect" value="index.'.$phpEx.'" />
						<input type="hidden" name="login" value="true" />
						<input type="submit" name="submit" value="' . $lang['Go_to_forum'] . '" class="liteoption" />
						</form>
						<br /><br />
						</td>
					</tr>
				</table>
				<br /><br />
				<table width="100%" align="cnter" cellspacing="1" cellpading="1">
					<tr>
						<td align="center">' . sprintf($lang['File_download_trouble'], 'config.' . $phpEx) . '</td>
					</tr>
					<tr>
						<td align="center"><textarea name="cd" rows="10" cols="60">' . $short_data . '</textarea></td>
					</tr>
				</table>';

				page_footer();
				exit;
			}

			$result = @fputs($fp, $config_data, strlen($config_data));

			@fclose($fp);
		}

		// Ok we are basically done with the install process let's go on 
		// and let the user configure their board now. We are going to do
		// this by calling the admin_board.php from the normal board admin
		// section.
		$s_hidden_fields = '<input type="hidden" name="username" value="' . stripslashes($admin_name) . '" />';
		$s_hidden_fields .= '<input type="hidden" name="password" value="' . stripslashes($admin_pass1) . '" />';
		$s_hidden_fields .= '<input type="hidden" name="redirect" value="index.'.$phpEx.'" />';
		$s_hidden_fields .= '<input type="hidden" name="login" value="true" />';

		page_header($lang['Inst_Step_2'], 'login.'.$phpEx);
		page_common_form($s_hidden_fields, $lang['Finish_Install']);
		page_footer();
		exit;
	}
}

?>
