<?php

use PHPBB\Przemo\Core\Form;
use PHPBB\Przemo\Core\Form\Select;
use PHPBB\Przemo\Core\Form\Text;
use PHPBB\Przemo\Core\Routing;

/***************************************************************************
 *                                install.php
 *                            -------------------
 *   begin                : Tuesday, Sept 11, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.comse
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

$table_prefix = null;
$mode = null;
$request = $board->request;
$phpbb_root_path = $phpbbConfig->get('phpbb_dir') . '/legacy/';

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

// Begin main prog
define('IN_PHPBB', true);

include($phpbb_root_path.'extension.inc');

// Initialise some basic arrays
$userdata = array('user_gender' => 0);
$lang = array();
$error = false;



// Include some required functions
include($phpbb_root_path.'includes/constants.'.$phpEx);
include($phpbb_root_path.'includes/functions.'.$phpEx);
include($phpbb_root_path.'includes/sessions.'.$phpEx);




$application = (new Routing)->getApplication('install');
$response = $application->dispatch($request);
echo $response ? $response->getContent() : new \Exception("PAGE NOT FOUND");
exit;



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
$confirm = $request->request->has('confirm') ? true : false;
$cancel = $request->request->has('cancel') ? true : false;
$install_step = $request->get('install_step');

$dbms = $request->request->get('dbms', 'mysql');
$dbhost = $request->request->get('dbhost', 'localhost');
$dbuser = $request->request->get('dbuser');
$dbpasswd = $request->request->get('dbpasswd');
$dbname = $request->request->get('dbname');

$table_prefix = $request->request->get('prefix', 'phpbb_');

$admin_name = $request->request->get('admin_name');
$admin_pass1 = $request->request->get('admin_pass1');
$admin_pass2 = $request->request->get('admin_pass2');

if (preg_match('#^[a-z_]+$#', $request->request->get('lang')))
{
    $language = strip_tags($request->request->get('lang'));
}
else
{
	$language = guess_lang();
}
$PHP_SELF = $request->server->get('PHP_SELF');
$board_email = $request->request->get('board_email');
$script_path = $request->request->get('script_path') ?: str_replace('install', '', dirname($PHP_SELF));

if ($request->request->get('server_name'))
{
    $server_name = $request->request->get('server_name');
}
else
{
	// Guess at some basic info used for install..
    if ($request->server->get('SERVER_NAME'))
	{
	    $server_name = $request->server->get('SERVER_NAME');
	}
	else if ($request->server->get('HTTP_HOST'))
	{
	    $server_name = $request->server->get('HTTP_HOST');
	}
	else
	{
		$server_name = '';
	}
}

if ($request->request->get('server_port'))
{
    $server_port = $request->request->get('server_port');
}
else
{
    if ($request->server->get('SERVER_PORT'))
	{
	    $server_port = $request->server->get('SERVER_PORT');
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

// Import language file, setup template ...
include($phpbb_root_path.'language/lang_' . $language . '/lang_main.'.$phpEx);
include($phpbb_root_path.'language/lang_' . $language . '/lang_admin.'.$phpEx);
include($phpbb_root_path.'language/lang_' . $language . '/lang_install.'.$phpEx);
include($phpbb_root_path.'language/lang_' . $language . '/lang_profile.'.$phpEx);


// Ok for the time being I'm commenting this out whilst I'm working on
// better integration of the install with upgrade as per Bart's request
// JLH

include('check_data.'.$phpEx);
$modified_files = [];
$wrong_checksum = '';
if ( $request->get('mode') != 'break' )
{
	for($i=0; count($file_list) > $i; $i++)
	{
	    $checksum = md5_file($phpbb_root_path . $file_list[$i]);
	    if ( $checksum != $md5_sum[$file_list[$i]] )
		{
			$modified_files[] = [
			    'name' => $file_list[$i],
			    'summary' => strip_tags($checksum ? sprintf($lang['Wrong_file_checksum'], $checksum) : $lang['Missing_file']),
			];
		}
	}
}

$routing = (new Routing())->getApplication('index');

$crfTokenFieldName = md5(date('Y-m-d'));
$form = new Form($request);
$form->name = 'install';
$form->action = $routing->getRoute('install');
$form->setEncryptionKey('przemo-install');

if ((empty($install_step) || $admin_pass1 != $admin_pass2 || empty($admin_pass1) || empty($dbhost)) || !$form->verifyCrfToken() || !filter_var($request->request->get('board_email'), FILTER_VALIDATE_EMAIL))
{
	// Ok we haven't installed before so lets work our way through the various
	// steps of the install process.  This could turn out to be quite a lengty 
	// process.
    if (count($modified_files) > 0 && !$request->request->get('install_step'))
	{
	    echo $board->view->renderBody('install/modified_files.html', [
	        'messages' => [
    	        'welcome' => $lang['Welcome_install'],
	            'Welcome_install' => $lang['Welcome_install'],
    	        'Wrong_checksum' => sprintf(strip_tags($lang['Wrong_checksum'], '<a><b><br>'), $routing->getRoute('install', ['mode' => 'break'])),
            ],
	        'files' => $modified_files,
	    ]);
	    exit;
	}

	$errors = [];

	if (!empty($install_step) && $request->request->get('cur_lang') == $language)
	{
	    if ( !$form->verifyCrfToken() ) {
	        $errors[] = $lang['TA_Expired'];
	    }
	    if ( $request->request->get('admin_pass1') != $request->request->get('admin_pass2') || !$request->request->get('admin_pass1') )
		{
		    $errors['admin_pass1'] = $lang['Password_mismatch'];
		}
		if ( !$request->request->get('server_name') )
		{
		    $errors['server_name'] = $lang['Empty_server_name'];
		}
		if ( !$request->request->get('server_port') )
		{
		    $errors['server_port'] = $lang['Empty_port'];
		}
		if ( !$request->request->get('script_path') )
		{
		    $errors['script_path'] = $lang['Empty_path'];
		}
		if ( !$request->request->get('dbhost') )
		{
		    $errors['dbhost'] = $lang['Empty_dbhost'];
		}
		if ( !$request->request->get('dbname') )
		{
		    $errors['dbname'] = $lang['Empty_dbname'];
		}
		if ( !$request->request->get('dbuser') )
		{
		    $errors['dbuser'] = $lang['Empty_dbuser'];
		}
		if ( !$request->request->get('dbpasswd') )
		{
		    $errors['dbpasswd'] = $lang['Empty_dbpasswd'];
		}
		if ( !$request->request->get('board_email') )
		{
		    $errors['board_email'] = $lang['Empty_email'];
		}
		if ( !$request->request->get('admin_name') )
		{
		    $errors['admin_name'] = $lang['Empty_username'];
		}
		if ( !filter_var($request->request->get('board_email'), FILTER_VALIDATE_EMAIL) )
		{
		    $errors['board_email'] = $lang['Email_invalid'];
		}
	}
	
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
	    $errors[] = strip_tags(trim(sprintf($lang['Install_warning_1'], 'config.php'), ' -'));
	}
	
	$dirname = $phpbb_root_path . 'language';
	$dir = opendir($dirname);

	$langSelect = new Select($language);

	while ($file = readdir($dir))
	{
		if (preg_match('#^lang_#i', $file) && !is_file(@phpbb_realpath($dirname . '/' . $file)) && !is_link(@phpbb_realpath($dirname . '/' . $file)))
		{
			$filename = trim(str_replace('lang_', '', $file));
			$displayname = preg_replace('/^(.*?)_(.*)$/', '\1 [ \2 ]', $filename);
			$displayname = preg_replace('/\[(.*?)_(.*)\]/', '[ \1 - \2 ]', $displayname);
			$langSelect->addOption($filename, ucwords($displayname));
		}
	}

	closedir($dir);

	$messages = [
	    'Welcome_install',
        'Inst_Step_0',
        'Initial_config',
        'Default_lang',
        'Server_name',
	    'Server_port',
	    'Script_path',
	    'dbms',
	    'DB_config',
	    'DB_Host',
	    'DB_Name',
	    'DB_Username',
	    'DB_Password',
	    'Table_Prefix',
	    'Admin_config',
	    'Admin_config_e',
	    'Admin_email',
	    'Admin_Username',
	    'Admin_Password',
        'Admin_Password_confirm',
	    'Start_Install',
	];
	
	foreach ($messages as $message) {
	    $messages[$message] = $lang[$message];
	}
	
	$messages['welcome'] = $lang['Welcome_install'];
	
	$dbmsSelect = new Select($dbms);
	$dbmsSelect->addOption('mysql', 'MySQL');
	
	$form->addHiddenField('install_step', 1);
	$form->addHiddenField('cur_lang', $language);
	$form->addCrfHiddenField($crfTokenFieldName);
	$form->addField('lang', $langSelect);
	$form->addField('server_name', new Text($server_name));
	$form->addField('server_port', new Text($server_port));
	$form->addField('script_path', new Text($script_path));
	$form->addField('dbms', $dbmsSelect);
	$form->addField('dbhost', new Text($dbhost));
	$form->addField('dbname', new Text($dbname));
	$form->addField('dbuser', new Text($dbuser));
	$form->addField('dbpasswd', new Text());
	$form->addField('prefix', new Text($table_prefix));
	$form->addField('board_email', new Text($board_email));
	$form->addField('admin_name', new Text($admin_name));
	$form->addField('admin_pass1', new Text($admin_pass1));
	$form->addField('admin_pass2', new Text($admin_pass2));
	$form->setValidationErrors($errors);
	echo $board->view->renderBody('install/step1.html', [
	    'messages' => $messages,
	    'form' => $form,
	    'errors' => $errors,
	]);
	exit;
}
else
{
    
    /**
     *
     * @author ridgerunner
     * @see https://stackoverflow.com/questions/4747808/split-mysql-queries-in-array-each-queries-separated-by
     */
    function split_sql($sqlQuery)
    {
        $regex = '%\s*((?:\'[^\'\\\\]*(?:\\\\.[^\'\\\\]*)*\'|"[^"\\\\]*(?:\\\\.[^"\\\\]*)*"|/\*[^*]*\*+(?:[^*/][^*]*\*+)*/|\#.*|--.*|[^"\';#])+(?:;|$))%x';
        if (preg_match_all($regex, trim($sqlQuery), $queries)) {
            return $queries[1];
        }
        return [];
    }
    
    $migrationsDirectory = $phpbb_root_path . '/install/migrations/' . $dbms;
    $createDatabaseScript = $migrationsDirectory . '/create_database.sql';
    $createTablesScript = $migrationsDirectory . '/create_tables.sql';
    $importDataScript = $migrationsDirectory . '/import_data.sql';
    
    include($phpbb_root_path.'db/pdo.'.$phpEx);
	
	$sql = new sql_db([
	    'options' => [],
	    'user' => $dbuser,
	    'pass' => $dbpasswd,
	    'dsn' => 'mysql:host='.$dbhost.';charset=utf8',
	]);
    
	// create database
	
	$failed = [];
	$result = $sql->sql_query("SHOW DATABASES LIKE '$dbname'")->fetchColumn(0);

	if (!$result) {
	    $sqlQuery = file_get_contents($createDatabaseScript);
	    $sqlQuery = str_replace('`phpbb`', "`$dbname`", $sqlQuery);
	    $sql->sql_query($sqlQuery);
	    if ($sql->sql_error()['code']) {
	        $failed[] = [
	            'query' => $sqlQuery,
	            'error' => $sql->sql_error()['message'],
	        ];
	    }
	}
	
	
	// create tables
	
	$sql->sql_query("USE `$dbname`;");
	
	$result = $sql->sql_query("SHOW TABLES IN `$dbname`")->fetchAll(PDO::FETCH_COLUMN, 0);

	$sqlQueries = file_get_contents($createTablesScript);
	$sqlQueries = str_replace('`phpbb_', "`$table_prefix", $sqlQueries);
	
	foreach (split_sql($sqlQueries) as $sqlQuery) {
	    $sql->sql_query($sqlQuery);
	    if ($sql->sql_error()['code']) {
	        $failed[] = [
	            'query' => $sqlQuery,
	            'error' => $sql->sql_error()['message'],
	        ];
	    }
	}
	
	$result = $sql->sql_query("SHOW TABLES IN `$dbname`")->fetchAll(PDO::FETCH_COLUMN, 0);
	
	if (!count($result)) {
	    $failed[] = [
	        'query' => "SHOW TABLES IN `$dbname`",
	        'error' => 'No tables found',
	    ];
	}
	
	// add data
	
	$sqlQueries = file_get_contents($importDataScript);
	$sqlQueries = str_replace('`phpbb_', "`$table_prefix", $sqlQueries);
	
	foreach (split_sql($sqlQueries) as $sqlQuery) {
	    $sql->sql_query($sqlQuery);
	    if ($sql->sql_error()['code']) {
	        $failed[] = [
	            'query' => $sqlQuery,
	            'error' => $sql->sql_error()['message'],
	        ];
	    }
	}
	
	$configuration = [
	    'board_startdate' => time(),
	    'default_lang' => $language,
	    'board_email'	=> $board_email,
	    'email_return_path'	=> $board_email,
	    'email_from'	=> $board_email,
	    'script_path'	=> $script_path,
	    'server_port'	=> $server_port,
	    'server_name'	=> $server_name,
	    'cookie_domain'	=> $server_name,
	];
	
	$sqlQuery = "REPLACE INTO {$table_prefix}config (config_name, config_value) " .
	   "VALUES (?, ?)";
	$sql->sql_prepare($sqlQuery);
	foreach ($configuration as $name => $value) {
	    $sql->sql_execute([$name, $value]);
	    if ($sql->sql_error()['code']) {
	        $failed[] = [
	            'query' => $sqlQuery,
	            'error' => $sql->sql_error()['message'],
	        ];
	    }
	}
	
	$sqlQuery = "UPDATE {$table_prefix}users " .
        "SET username = ?, user_password = ?, user_lang = ?, user_email = ? " .
        "WHERE username = 'Admin'";
	
	$sql->sql_prepare($sqlQuery);
	$sql->sql_execute([$admin_name, md5($admin_pass1), $language, $board_email]);
	if ($sql->sql_error()['code']) {
	    $failed[] = [
	        'query' => $sqlQuery,
	        'error' => $sql->sql_error()['message'],
	    ];
	}
    
	$sqlQuery = "UPDATE " . $table_prefix . "users " . 
	   "SET user_regdate = " . time();

	$sql->sql_query($sqlQuery);
	if ($sql->sql_error()['code']) {
	    $failed[] = [
	        'query' => $sqlQuery,
	        'error' => $sql->sql_error()['message'],
	    ];
	}
	
	$sqlQuery = "UPDATE {$table_prefix}config " . 
	   "SET config_value = (" . 
	       "SELECT COUNT(1) FROM {$table_prefix}users WHERE user_id > 0" . 
       ") WHERE config_name = 'usercount'";
	
	$sql->sql_query($sqlQuery);
	if ($sql->sql_error()['code']) {
	    $failed[] = [
	        'query' => $sqlQuery,
	        'error' => $sql->sql_error()['message'],
	    ];
	}
	
	
	$sqlQuery = "UPDATE {$table_prefix}config " .
    	"SET config_value = (" .
    	   "SELECT SUM(forum_topics) FROM {$table_prefix}forums" .
    	") WHERE config_name = 'topiccount'";
	
	$sql->sql_query($sqlQuery);
	if ($sql->sql_error()['code']) {
	    $failed[] = [
	        'query' => $sqlQuery,
	        'error' => $sql->sql_error()['message'],
	    ];
	}
	
	$sqlQuery = "UPDATE {$table_prefix}config " .
    	"SET config_value = (" .
        	"SELECT SUM(forum_posts) FROM {$table_prefix}forums" .
    	") WHERE config_name = 'postcount'";
	
	$sql->sql_query($sqlQuery);
	if ($sql->sql_error()['code']) {
	    $failed[] = [
	        'query' => $sqlQuery,
	        'error' => $sql->sql_error()['message'],
	    ];
	}
	
	$sqlQuery = "SELECT username, user_id " .
        "FROM {$table_prefix}users " .
        "WHERE user_id > 0 " .
        "ORDER BY user_id DESC " .
	    "LIMIT 1";
	
	$sql->sql_query($sqlQuery);
	$result = $sql->sql_fetchrow();
	
	if ($result) {
	    $result = serialize($result);
	    
	    $sqlQuery = "UPDATE {$table_prefix}config " .
    	    "SET config_value = ? " . 
    	    "WHERE config_name = 'newestuser'";
	    
	    $sql->sql_prepare($sqlQuery)->execute([$result]);
	    if ($sql->sql_error()['code']) {
	        $failed[] = [
	            'query' => $sqlQuery,
	            'error' => $sql->sql_error()['message'],
	        ];
	    }
	}

	if ($failed) {
    	echo $board->view->renderBody('install/db_error.html', [
    	    'errors' => $failed,
    	    'messages' => [
    	        'Welcome_install' => $lang['Install'],
    	        'welcome' => $lang['Installer_Error'],
    	        'Install_db_error' => $lang['Install_db_error'],
    	    ]
    	]);
    	exit;
	}
	
	$payload = [
	    'dbms' => 'pdo',
	    'dbhost' => $dbhost,
	    'dbname' => $dbname,
	    'dbuser' => $dbuser,
	    'dbpasswd' => $dbpasswd,
	    'table_prefix' => $table_prefix,
	    'pdo' => [
	        'dsn' => "mysql:host={$dbhost};dbname={$dbname};charset=utf8",
	        'user' => $dbuser,
	        'pass' => $dbpasswd,
	    ],
	];
	
	$contents = "<?php " . PHP_EOL;
	$contents .= "extract(".var_export($payload, true).");" . PHP_EOL;
	$contents .= "define('PHPBB_INSTALLED', true);" . PHP_EOL;
	
	$filename = $phpbb_root_path . '/config.php';
	file_put_contents($filename, $contents);
	
	if (filesize($filename) < 1) {

	    $form->addCrfHiddenField();
	    $form->addHiddenField('send_file', 1);
	    $form->addHiddenField('context', base64_encode($contents));
	    
	    $routing2 = (new Routing())->getApplication('index');
	    
	    echo $board->view->renderBody('install/config_error.html', [
	        'messages' => [
	            'Welcome_install' => $lang['Welcome_install'],
	            'welcome' => $lang['Installer_Error'],
	            'Unwriteable_config' => $lang['Unwriteable_config'],
	            'Download_config' => $lang['Download_config'],
	            'Go_to_forum' =>  trim($lang['Forum_Index'], ' %s'),
	            'File_download_trouble' => sprintf($lang['File_download_trouble'], 'config.php'),
	        ],
	        'forum_url' => $routing2->getRoute('home'),
	        'contents' => $contents,
	        'form' => $form,
	    ]);
	    exit;
	}

	$form->action = 'index.php';
	$form->metod = $form::METHOD_GET;
	echo $board->view->renderBody('install/step2.html', [
	    'messages' => [
	        'Welcome_install' => $lang['Welcome_install'],
	        'welcome' => $lang['Finish_Install'],
	        'Inst_Step_2' =>  $lang['Inst_Step_2'],
	        'Finish_Install' => $lang['Finish_Install'],
	    ],
	    'form' => $form,
	]);
	exit;
}
