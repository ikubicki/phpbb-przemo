<?php
/***************************************************************************
 *                                common.php
 *                            -------------------
 *   begin                : Saturday, Feb 23, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   modification         : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   date modification    : ver. 1.12.5 2005/09/20 12:34
 *
 *   $Id: common.php,v 1.74.2.21 2005/10/31 07:31:06 acydburn Exp $
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

$sql_cache_enable = 1;
$show_queries = 0;

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

$time_start = microtime(true);

//
error_reporting  (E_ERROR | E_PARSE); // This will NOT report uninitialized variables
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors' , true);

// The following code (unsetting globals)
// Thanks to Matt Kavanagh and Stefan Esser for providing feedback as well as patch files

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

// Protect against GLOBALS tricks
if (isset($HTTP_POST_VARS['GLOBALS']) || isset($HTTP_POST_FILES['GLOBALS']) || isset($HTTP_GET_VARS['GLOBALS']) || isset($HTTP_COOKIE_VARS['GLOBALS']))
{
	die("Hacking attempt");
}

// Protect against HTTP_SESSION_VARS tricks
if (isset($HTTP_SESSION_VARS) && !is_array($HTTP_SESSION_VARS))
{
	die("Hacking attempt");
}

if (@ini_get('register_globals') == '1' || strtolower(@ini_get('register_globals')) == 'on')
{
	// PHP4+ path
	$not_unset = array('HTTP_GET_VARS', 'HTTP_POST_VARS', 'HTTP_COOKIE_VARS', 'HTTP_SERVER_VARS', 'HTTP_SESSION_VARS', 'HTTP_ENV_VARS', 'HTTP_POST_FILES', 'phpEx', 'phpbb_root_path');

	// Not only will array_merge give a warning if a parameter
	// is not an array, it will actually fail. So we check if
	// HTTP_SESSION_VARS has been initialised.
	if (!isset($HTTP_SESSION_VARS) || !is_array($HTTP_SESSION_VARS))
	{
		$HTTP_SESSION_VARS = array();
	}

	// Merge all into one extremely huge array; unset
	// this later
	$input = array_merge($HTTP_GET_VARS, $HTTP_POST_VARS, $HTTP_COOKIE_VARS, $HTTP_SERVER_VARS, $HTTP_SESSION_VARS, $HTTP_ENV_VARS, $HTTP_POST_FILES);

	unset($input['input']);
	unset($input['not_unset']);

	while (list($var,) = @each($input))
	{
		if (!in_array($var, $not_unset))
		{
			unset($$var);
		}
	}

	unset($input);
}

if (isset($HTTP_GET_VARS['sid']) && !preg_match('/^[A-Za-z0-9]*$/', $HTTP_GET_VARS['sid'])) 
{
	$HTTP_GET_VARS['sid'] = '';
}
if (isset($HTTP_POST_VARS['sid']) && !preg_match('/^[A-Za-z0-9]*$/', $HTTP_POST_VARS['sid'])) 
{
	$HTTP_POST_VARS['sid'] = '';
}

$PHP_SELF = ($HTTP_SERVER_VARS['PHP_SELF']) ? $HTTP_SERVER_VARS['PHP_SELF'] : $HTTP_ENV_VARS['PHP_SELF'];

//
// Define some basic configuration arrays this also prevents
// malicious rewriting of language and otherarray values via
// URI params
//
$board_config = array();
$shoutbox_config = array();
$attach_config = array();
$userdata = array();
$theme = array();
$images = array();
$lang = array();
$nav_links = array();
$gen_simple_header = FALSE;

include($phpbb_root_path . 'config.'.$phpEx);

if( !defined("PHPBB_INSTALLED") )
{
	header('Location: ' . $phpbb_root_path . 'install.' . $phpEx);
	exit;
}

include($phpbb_root_path . 'includes/constants.'.$phpEx);
include($phpbb_root_path . 'includes/template.'.$phpEx);
include($phpbb_root_path . 'includes/sessions.'.$phpEx);
include($phpbb_root_path . 'includes/auth.'.$phpEx);
include($phpbb_root_path . 'includes/functions.'.$phpEx);
include($phpbb_root_path . 'includes/db.'.$phpEx);


if (!defined('IN_PHPBB')) {
	var_adds($HTTP_GET_VARS, false);
	var_adds($HTTP_POST_VARS, true, true);
	var_adds($HTTP_COOKIE_VARS, false);
}
// We do not need this any longer, unset for safety purposes
unset($dbpasswd);

$subdirectory = '';

// let's check if we run in docker
if (!file_exists('/.dockerenv')) {
	// let's see if we still got CI directory
	if (file_exists($phpbb_root_path . '/ci')) {
		message_die(CRITICAL_ERROR, 'You have to delete /ci directory to run the script outside docker container!');
	}
}

//
// Obtain and encode users IP
//
// I'm removing HTTP_X_FORWARDED_FOR ... this may well cause other problems such as
// private range IP's appearing instead of the guilty routable IP, tough, don't
// even bother complaining ... go scream and shout at the idiots out there who feel
// "clever" is doing harm rather than good ... karma is a great thing ... :)
//
$client_ip = ( !empty($HTTP_SERVER_VARS['REMOTE_ADDR']) ) ? $HTTP_SERVER_VARS['REMOTE_ADDR'] : ( ( !empty($HTTP_ENV_VARS['REMOTE_ADDR']) ) ? $HTTP_ENV_VARS['REMOTE_ADDR'] : getenv('REMOTE_ADDR') );
$user_ip = encode_ip($client_ip);

//
// Setup forum wide options, if this fails
// then we output a CRITICAL_ERROR since
// basic forum information is not available
//
$sql_work = true;
$board_config = sql_cache('check', 'board_config');
if (empty($board_config))
{
    $sql = "SELECT *
		FROM " . CONFIG_TABLE;
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(CRITICAL_ERROR, 'Nie można pobrać danych z tabeli konfiguracyjnej forum !<br /><br /><b>Prawdopodobnie forum nie jest zainstalowane do bazy danych, lub tabele w bazie danych maja inny prefix (standardowo phpbb_ ).<br />Sprawdz czy tabele w bazie danych maja prefix podany w pliku config.php<br /><br /><br />Jeżeli chcesz wgrać kopię bazy danych i wysłałeś ja do katalogu forum użyj <a href="' . $phpbb_root_path . 'dbloader/dbloader.'.$phpEx . '">DumpLoader\'a</a></b><br />');
	}
	while ( $row = $db->sql_fetchrow($result) )
	{
		$board_config[$row['config_name']] = $row['config_value'];
	}

	$sql_work = sql_cache('write', 'board_config', $board_config);
}

if ( $board_config['protection_get'] && isset($HTTP_GET_VARS) )
{
	foreach($HTTP_GET_VARS as $key => $val)
	{
		if ( strlen($val) > 18 && !preg_match('#^[a-z0-9_ /+]*={0,2}$#i', $val) && !in_array($key, array('rdns', 'highlight', 'redirect', 'tag', 'search_author'))  )
		{
			die('Hacking attempt');
		}
	}
}

$phpbb_root_dir = $board_config['script_path'] ?? '/';
$nav_links = [];


if ($board_config['cookie_secure']) {
	$ssl = $_SERVER['HTTPS'] ?? false || $_SERVER['X-FORWARDED-PROTO'] ?? '' == 'https' || $_SERVER['X-FORWARDER-SSL'] ?? '' == 'on';
	if(!$ssl)
	{
		$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
		$server_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['server_name']));
		$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) : '';
		$script_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['script_path']));
		$script_name = ($script_name == '') ? $script_name . '/index.'.$phpEx : '/' . $script_name . '/index.'.$phpEx;
		$url_absolute = $server_protocol . $server_name . $server_port . $script_name;
		header('Location: ' . $url_absolute);
		exit;
	}
}

// gzip compression
$mod_deflate_check = true;
if ($board_config['gzip_compress'] && @extension_loaded('zlib') && !headers_sent() && ob_get_length() <= 1 && ob_get_length() == 0)
{
    if(@strtolower(@ini_get('zlib.output_compression')) != 'on' && @strtolower(@ini_get('output_handler')) != 'ob_gzhandler' && (int)@ini_get('zlib.output_compression') != 1)
    {
        if($mod_deflate_check) {
            $apache_modules = (function_exists('apache_get_modules')) ? apache_get_modules() : false;
            if(($apache_modules && !in_array('mod_deflate', $apache_modules)) || !$apache_modules) {
                ob_start("ob_gzhandler");
            }
        } else {
            ob_start("ob_gzhandler");
        }
    }
}

header('Content-type: text/html; charset='.$content_encoding);

$board_config['topics_per_page'] = ($board_config['topics_per_page'] < 1) ? '25' : $board_config['topics_per_page'];
$board_config['posts_per_page'] = ($board_config['posts_per_page'] < 1) ? '25' : $board_config['posts_per_page'];
$board_config['hot_threshold'] = ($board_config['hot_threshold'] < 1) ? '25' : $board_config['hot_threshold'];
$board_config['session_length'] = ($board_config['session_length'] < 5) ? '3600' : $board_config['session_length'];

// if system administrator does not set correct timezone information, fix it to avoid warnings
if (ini_get('date.timezone')=='')
{
    // List of supported timezones could be found at http://www.php.net/manual/en/timezones.php
    //
    if ($board_config['default_lang'] == 'polish')
    {
        @ini_set('date.timezone', 'Europe/Warsaw');
    }
    elseif ($board_config['default_lang'] == 'english')
    {
        @ini_set('date.timezone', 'Europe/London'); // timezone +0:00
    }
    else
    {
        @ini_set('date.timezone', 'UTC');
    }
}

if ( empty($board_config['server_name']) )
{
	if ( !empty($HTTP_SERVER_VARS['SERVER_NAME']) || !empty($HTTP_ENV_VARS['SERVER_NAME']) )
	{
		$hostname = ( !empty($HTTP_SERVER_VARS['SERVER_NAME']) ) ? $HTTP_SERVER_VARS['SERVER_NAME'] : $HTTP_ENV_VARS['SERVER_NAME'];
	}
	else if ( !empty($HTTP_SERVER_VARS['HTTP_HOST']) || !empty($HTTP_ENV_VARS['HTTP_HOST']) )
	{
		$hostname = ( !empty($HTTP_SERVER_VARS['HTTP_HOST']) ) ? $HTTP_SERVER_VARS['HTTP_HOST'] : $HTTP_ENV_VARS['HTTP_HOST'];
	}
	else
	{
		$hostname = '';
	}
	$board_config['server_name'] = $hostname;
}

$board_config['cookie_domain'] = $board_config['server_name'] = trim($board_config['server_name']);

if ( defined('SHOUTBOX') || defined('IN_ADMIN') )
{
	$shoutbox_config = sql_cache('check', 'shoutbox_config');
	if (empty($shoutbox_config))
	{
		$sql = "SELECT *
			FROM " . SHOUTBOX_CONFIG_TABLE;
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(CRITICAL_ERROR, 'Could not query shoutbox config information', '', __LINE__, __FILE__, $sql);
		}

		while ( $row = $db->sql_fetchrow($result) )
		{
			$shoutbox_config[$row['config_name']] = $row['config_value'];
		}
		sql_cache('write', 'shoutbox_config', $shoutbox_config);
	}
}

$unique_cookie_name = 'bb' . substr(md5($board_config['cookie_name'] . $board_config['script_path']), 5, 8);

if ( defined('ATTACH') || defined('IN_ADMIN') )
{
	$attach_config = sql_cache('check', 'attach_config');
	if (empty($attach_config))
	{
		$sql = "SELECT * FROM " . ATTACH_CONFIG_TABLE;
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(CRITICAL_ERROR, 'Could not query attachments config information', '', __LINE__, __FILE__, $sql);
		}
		while ( $row = $db->sql_fetchrow($result) )
		{
			$attach_config[$row['config_name']] = $row['config_value'];
		}
		sql_cache('write', 'attach_config', $attach_config);
	}
	if ( !$attach_config['disable_mod'] || defined('IN_ADMIN'))
	{
		define('ATTACHMENTS_ON', true);
		include($phpbb_root_path . 'attach_mod/attachment_mod.'.$phpEx);
	}
}

if ( isset($board_config['db_backup_enable']) && $board_config['db_backup_enable']>0 && isset($board_config['db_backup_time']) && $board_config['db_backup_time'] < (CR_TIME - (24 * 3600)) && !defined('IN_ADMIN') )
{
	include($phpbb_root_path . 'includes/functions_admin.'.$phpEx);
	db_backup();
}

if (!empty($HTTP_COOKIE_VARS[$unique_cookie_name . '_b']))
{
	message_die(GENERAL_MESSAGE, 'You_been_banned');
}

if(isset($result)) $db->sql_freeresult($result);
