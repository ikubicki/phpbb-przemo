<?php
// tw�j adres IP
$twoje_ip = 'TU WPISZ SWOJE IP';
// wy��cz sprawdzanie IP
$disable_ip_check = 0;
// maksymalny czas wykonywania skryptu w sekundach, 0 je�li nieograniczony
$execution_time = 300;
// hash md5 has�a, wy��czone je�li puste
$pass_hash = ''; 

error_reporting  (E_ERROR | E_WARNING | E_PARSE);

define('IN_PHPBB', true);
$version = '1.0';
@ini_set('arg_separator.output', '&amp;');
session_start();
if( $pass_hash != '' )
{
	if( isset($_POST['password']) )
	{
		$_SESSION['hash'] = md5($_POST['password']);
	}
}
$has_access = ($disable_ip_check || $_SERVER['REMOTE_ADDR'] == $twoje_ip) && ($pass_hash == '' || $pass_hash == $_SESSION['hash']);
$phpbb_root_path = ( file_exists('extension.inc') ) ? './' : '../';

$img_path = $phpbb_root_path . 'dbloader/templates/images/';
include $phpbb_root_path.'extension.inc';
include_once 'functions.'.$phpEx;
include_once 'Timer.class.'.$phpEx;
include_once 'FileReader.class.'.$phpEx;
include_once 'SQLReader.class.'.$phpEx;

$is_limited = @ini_get('safe_mode') || preg_match('/lycos/', get_servername()) || !@ini_set('max_execution_time', 30);

$page_time = new Timer;
//
// Sprawd� config.php i po��czenie z baz�
//
if( file_exists($phpbb_root_path . 'config.' . $phpEx) )
{
	$config_size_ok = ( filesize($phpbb_root_path . 'config.' . $phpEx) >= 177 ) ? true : false;
	$is_config = true;
}
else
{
	$config_size_ok = false;
	$is_config = false;
}
if( $config_size_ok ) // config w porz�dku, po��cz z baz� danych
{
	include $phpbb_root_path . 'config.' . $phpEx;
    define('BEGIN_TRANSACTION', 1);
    define('END_TRANSACTION',   2);
    define('KEEP_TRANSACTION',  3);

    switch($dbms)
    {
        case 'mysql':
            include($phpbb_root_path . 'db/mysql.'.$phpEx);
            break;

        case 'mysql4':
            include($phpbb_root_path . 'db/mysql4.'.$phpEx);
            break;

        case 'mysqli':
            include($phpbb_root_path . 'db/mysqli.'.$phpEx);
            break;
    }
	
    $db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);
    $err = $db->sql_error(true);
    if($err['code']){
        $connect       = true;
        $db_error      = true;
        $not_supported = true;
    }else{
        $connect       = false;
    }
}
else
{
	$db_error = true;
}
include $phpbb_root_path.'includes/template_old.'.$phpEx;
//
// Koniec sprawdzania
//

$PHP_SELF = ($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : $_ENV['PHP_SELF']; 

$template = new Template('templates');
$template->set_filenames(array(
	'body' => 'dbloader_body.tpl')
);
$template->assign_vars(array(
	'VERSION' => $version,
	'PHP_EX' => $phpEx,
	'STYLE_IMAGES' => $img_path,
	'PHP_SELF' => $PHP_SELF)
);

if( !$has_access && $pass_hash != '' )
{
	$template->assign_block_vars('login', array());
	$template->assign_vars(array(
		'TITLE' => 'Logowanie',
		'PAGE_GENTIME' => $page_time->elapsed())
	);
	$template->pparse('body');
	exit;
}
elseif( !$is_config )
{
	$template->assign_block_vars('info', array(
		'TITLE' => 'Brak pliku config.'.$phpEx,
		'CONTENT' => 'Brak pliku config.'.$phpEx.' w g��wnym katalogu forum. Aby kontynuowa� prac� ze skryptem musisz go utworzy�.')
	);
}
elseif( !$config_size_ok )
{
	$template->assign_block_vars('info', array(
		'TITLE' => 'Niepoprawny plik config.'.$phpEx,
		'CONTENT' => 'Plik config.'.$phpEx.' ma zbyt ma�y rozmiar by m�g� zosta� uznany za poprawny. Aby kontynuowa� prac� ze skryptem musisz go poprawi�.')
	);
}
elseif( $db_error )
{
	$msg = 'Podczas pr�by po��czenia z baz� danych nast�pi� b��d.<br />';
	$sql_error = $db->sql_error($connect);
	$msg .= ' &nbsp; Error code: ' . $sql_error['code'] . '<br />';
	$msg .= ' &nbsp; Error message: ' . $sql_error['message'];
	$template->assign_block_vars('info', array(
		'TITLE' => 'B��d bazy danych',
		'CONTENT' => $msg)
	);
}

if( $is_config && !$db_error )
{
	$result = $db->sql_query("SHOW TABLES LIKE '" . escape_str($table_prefix) . "config'");
	$cfg_table_ex = ( $db->sql_numrows($result) == 1 ) ? true : false;
	$tpl_sect = ($cfg_table_ex ? '' : 'no_') . 'forum_config_link';
	$template->assign_block_vars($tpl_sect, array());
	$template->assign_block_vars('db_actions', array());
}

$mode_get = isset($_GET['mode']) ? $_GET['mode'] : '';
$mode = ( $has_access ) ? $mode_get : '';
if ( $mode == 'makeconfig' )
{
	if( isset($_POST['submit']) || isset($_POST['download_config']) )
	{
		$dbms = $_POST['dbms'];
		$dbhost = $_POST['dbhost'];
		$dbname = $_POST['dbname'];
		$dbuser = $_POST['dbuser'];
		$dbpasswd = $_POST['dbpasswd'];
		$table_prefix = $_POST['table_prefix'];
	}

	$config_save = false;
	$save_result = '';
	if( isset($_POST['download_config']) && $_POST['download_config'] == true && isset($_POST['submit_download_config']) && $_POST['submit_download_config'] == '�ci�gnij plik' )
	{
		header('Pragma: no-cache');
		header('Content-Type: text/x-delimtext; name="config.php"');
		header('Content-disposition: attachment; filename=config.php');
		echo make_download($dbms, $dbhost, $dbname, $dbuser, $dbpasswd, $table_prefix);
		return;
	}
	elseif( isset($_POST['download_config']) && $_POST['download_config'] == true && isset($_POST['submit_save_config']) && $_POST['submit_save_config'] == 'Spr�buj zapisa�' )
	{
		$config_save = true;
		$config_fname = $phpbb_root_path . 'config.' . $phpEx;
		if( $fh = fopen($config_fname, 'w+') )
		{
			fwrite($fh, make_download($dbms, $dbhost, $dbname, $dbuser, $dbpasswd, $table_prefix));
			fclose($fh);
			$save_result = '<br /><br /><span style="color:green"><b>Zapisano plik '.$config_fname.'</b></span>. Aby nowa konfiguracja zacz�a dzia�a� od�wie� stron�.';
		}
		else
		{
			$save_result = '<br /><br /><span style="color:red">Nie zapisano pliku '.$config_fname.'! Powodem mog� by� niewystarczaj�ce prawa dost�pu do pliku. Wymagany chmod to 666.</span>';
		}
	}
	$available_dbms = array(
		'mysql' => 'MySQL 3.x',
		'mysql4' => 'MySQL 4.x',
		'mysqli' => 'MySQLi',
	);

	$dbms_options = '';
	while (list($var, $param) = each($available_dbms))
	{
		$selected = ($dbms == $var) ? ' selected="selected"' : '';
		$dbms_options .= '<option value="' . $var . '"' . $selected . '>' . $param . '</option>';
	}

	$template->assign_vars(array(
		'TITLE' => 'Tworzenie / edycja pliku config.'.$phpEx)
	);

	$template->assign_block_vars('config', array(
		'DBMS_OPTIONS' => $dbms_options,
		'DBMS' => @$dbms,
		'DBHOST' => @$dbhost,
		'DBNAME' => @$dbname,
		'DBUSER' => @$dbuser,
		'DBPASSWORD' => @$dbpasswd,
		'TABLE_PREFIX' => @$table_prefix)
	);
	if( (isset($_POST['generate_config']) && $_POST['generate_config'] == true) || $config_save )
	{
		$ccode = make_download($dbms, $dbhost, $dbname, $dbuser, $dbpasswd, $table_prefix);
		$ccode = highlight_string($ccode, true);
		$template->assign_block_vars('config.code', array(
			'CODE' => $ccode,
			'SAVE_RESULT' => $save_result)
		);
	}
	$template->assign_var('PAGE_GENTIME', $page_time->elapsed());
	$template->pparse('body');
}
elseif( $mode == 'forumconfig' )
{
	$template->assign_vars(array(
		'TITLE' => 'Konfiguracja forum')
	);
	if( !$config_size_ok || $db_error)
	{
		message_die('', true, true);
	}
	// Odgadnij dane (install.php)...
	$server_name = get_servername();
	$script_path = preg_replace('/(|dbloader\/)dbloader\.php/i', '', $PHP_SELF);
	if ( !empty($HTTP_SERVER_VARS['SERVER_PORT']) || !empty($HTTP_ENV_VARS['SERVER_PORT']) )
	{
		$server_port = ( !empty($HTTP_SERVER_VARS['SERVER_PORT']) ) ? $HTTP_SERVER_VARS['SERVER_PORT'] : $HTTP_ENV_VARS['SERVER_PORT'];
	}
	else
	{
		$server_port = '80';
	}
	$check_address = true;
	$cookie_domain = $server_name;
	$cookie_path = '/';
	$cookie_secure = false;
	// Je�li wys�ano forumularz, zapisz konfiguracj� do bazy
	if( isset($_POST['save_config']) && $_POST['save_config'] == 'true' )
	{
		$new_cfg = array(
			'server_name' => $_POST['server_name'],
			'server_port' => $_POST['server_port'],
			'script_path' => $_POST['script_path'],
			'check_address' => $_POST['check_address'],
			'cookie_domain' => $_POST['cookie_domain'],
			'cookie_name' => $_POST['cookie_name'],
			'cookie_path' => $_POST['cookie_path'],
			'cookie_secure' => $_POST['cookie_secure']			
		);
		$q_error = '';
		foreach( $new_cfg as $cfg_name => $cfg_value )
		{
			$sql = "UPDATE `" . $table_prefix . "config` SET config_value = '$cfg_value' WHERE config_name = '$cfg_name' LIMIT 1";
			if( !$db->sql_query($sql) )
			{
				$err = $db->sql_error();
				$q_error .= '<span class="color:red">SQL: ' . $sql . 'Code: ' . $err['code'] . '<br />Message: ' . $err['message'] . '<br /><br />';
			}
		}
		@unlink($phpbb_root_path . 'cache/board_config.'.$phpEx);
	}
	// Wczytaj dane z bazy
	$db->sql_query("SELECT * FROM " . $table_prefix . "config");
	$bb_cfg = $db->sql_fetchrowset();
	$bb_cfg = config_assoc($bb_cfg, 'config_name', 'config_value');

	$template->assign_block_vars('forumconfig', array(
		'SERVER_NAME' => $server_name,
		'SERVER_PORT' => $server_port,
		'SCRIPT_PATH' => $script_path,
		'CHECK_ADDRESS_0' => ($check_address ? '' : 'checked="checked"'),
		'CHECK_ADDRESS_1' => ($check_address ? 'checked="checked"' : ''),
		'COOKIE_DOMAIN' => $cookie_domain,
		'COOKIE_NAME' => $bb_cfg['cookie_name'],
		'COOKIE_PATH' => $cookie_path,
		'COOKIE_SECURE_0' => ($cookie_secure ? '' : 'checked="checked"'),
		'COOKIE_SECURE_1' => ($cookie_secure ? 'checked="checked"' : ''),
		'SERVER_NAME_DB' => $bb_cfg['server_name'],
		'SERVER_PORT_DB' => $bb_cfg['server_port'],
		'SCRIPT_PATH_DB' => $bb_cfg['script_path'],
		'CHECK_ADDRESS_DB' => ($bb_cfg['check_address'] ? 'Tak' : 'Nie'),
		'COOKIE_DOMAIN_DB' => $bb_cfg['cookie_domain'],
		'COOKIE_NAME_DB' => $bb_cfg['cookie_name'],
		'COOKIE_PATH_DB' => $bb_cfg['cookie_path'],
		'COOKIE_SECURE_DB' => ($bb_cfg['cookie_secure'] ? 'Tak' : 'Nie'))
	);
	if( isset($q_error) )
	{
		$template->assign_block_vars('forumconfig.result', array(
			'RESULT' => ($q_error != '' ? $q_error : '<span style="color:green">Zapisano konfiguracj�</span>'))
		);
	}
	$template->assign_var('PAGE_GENTIME', $page_time->elapsed());
	$template->pparse('body');
}
elseif( $mode == 'checkdb' )
{
	$template->assign_vars(array(
		'TITLE' => 'Sprawdzanie zgodno�ci bazy danych z phpBB modified by Przemo')
	);
	if( !$config_size_ok || $db_error)
	{
		message_die('', true, true);
	}
	include 'dbdata.inc.php'; // $dbs, $dbs_for
	$dbs = append_prefix($table_prefix, $dbs);
	if( isset($_GET['create']) )
	{
		foreach($dbs as $dbs_item)
		{
			if( $dbs_item['table'] == $_GET['create'] )
			{
				$cr_query = nl2br($dbs_item['create']);
				if( $db->sql_query($dbs_item['create']) )
				{
					$cr_res = '<span style="color:green">Utworzono tabel� ' . $dbs_item['table'] . '</span>';
				}
				else
				{
					$cr_res = '<span style="color:red">Nie utworzono tabeli ' . $dbs_item['table'] . '<br />';
					$error = $db->sql_error();
					$cr_res .= 'Code: ' . $error['code'] . '<br />Message: ' . $error['message'] . '</span>';
				}
			}
		}
	}
	if ( isset($_GET['config_update']) && $_GET['config_update'] == 'text' )
	{
		$db->sql_query("ALTER TABLE `" . $table_prefix . "config`
			CHANGE config_value config_value TEXT NOT NULL");
	}
	$tables_check = '';
	$tbls_in_db = tables_in_db();
	foreach($dbs as $dbs_item)
	{
		$table_name = !is_array($dbs_item) ? $dbs_item : $dbs_item['table'];
		$verbose = isset($dbs_item['verbose']) ? $dbs_item['verbose'] : true;
		$table_exists = in_array($table_name, $tbls_in_db);
		if( $verbose && !$table_exists )
		{
			$tables_check .= '<span style="color:red"><b>brak tabeli</b> ' . $table_name . '</span> <img src="'.$img_path.'icon_mini_ignore.gif" alt="B��d">';
			if( isset($dbs_item['create']) )
			{
				$tables_check .= ' <a class="nav" href="?mode=checkdb&amp;create=' . $table_name . '"><i>Utw�rz</i></a>';
			}
			$tables_check .= '<br />';
		}
		if( $table_exists && $table_name != $table_prefix.'sessions' )
		{
			$db->sql_query("CHECK TABLE `$table_name`");
			$ret = $db->sql_fetchrow();
			$error = $ret['Msg_text'] != 'OK';
			$tables_check .= ( $error ) ? '<span style="color:red"><b>tabela uszkodzona</b> ' . $table_name . '</span> <img src="'.$img_path.'icon_mini_ignore.gif" alt="B��d"><br />' : '';
			if( !$error && isset($dbs_item['fields']) )
			{
				$db->sql_query("SHOW COLUMNS FROM `$table_name`");
				$numrows = $db->sql_numrows();
				if( $numrows < $dbs_item['fields'] )
				{
					$tables_check .= '<span style="color:red"><b>tabela </b> ' . $table_name . ' zawiera za ma�o p�l ('.$numrows.' zamiast '.$dbs_item['fields'].')</span> <img src="'.$img_path.'icon_mini_ignore.gif" alt="B��d"><br />';
				}
			}
			if( !$error && $table_name == $table_prefix . 'config' )
			{
				$db->sql_query("DESCRIBE `$table_name` config_value");
				$ret = $db->sql_fetchrow();
				if ( $ret['Type'] != 'text' )
				{
					$tables_check .= '<span style="color:red"><b>tabela </b> ' . $table_name . ' ma niepoprawny typ kolumny config_value</span> <img src="'.$img_path.'icon_mini_ignore.gif" alt="B��d">';
					$tables_check .= ' <a class="nav" href="?mode=checkdb&amp;config_update=text"><i>Napraw</i></a><br />';
				}
			}
		}
	}
	$tables_check = ( $tables_check == '' ) ? '<span style="color:green">Wszystkie tabele (' . count($dbs) . ') istniej� i nie zawieraj� b��d�w</span> <img src="'.$img_path.'icon_mini_register.gif" alt="Ok"><br />' : $tables_check ;
	$template->assign_block_vars('db_check', array(
		'DB' => $dbuser.'.'.$dbname.' @ '.$dbhost,
		'TABES_CHECK' => $tables_check,
		'TABLES_DEF_FOR' => $dbs_for)
	);
	if( isset($_GET['create']) )
	{
		$template->assign_block_vars('db_check.create', array(
			'SQL' => $cr_query,
			'RESULT' => $cr_res)
		);
	}

	$template->assign_var('PAGE_GENTIME', $page_time->elapsed());
	$template->pparse('body');
}
elseif( $mode == 'sqllist' )
{
	$template->assign_var('TITLE', 'Wczytywanie zrzutu bazy danych: wybierz plik');
	if( !$config_size_ok || $db_error)
	{
		message_die('', true, true);
	}

	$db->sql_query("DROP TABLE IF EXISTS _dbloader");
	$db->sql_query("DROP TABLE IF EXISTS _dbloader_err");

	$tmp_list = scan_dir($phpbb_root_path, 1);
	$alist = array();
	for( $i = 0; $i < count($tmp_list); $i++ )
	{
		if( substr($tmp_list[$i], 0, 8) != 'scripts/' && !stristr($tmp_list[$i],'admin_logs') )
		{
			$alist[] = $tmp_list[$i];
		}
	}
	$template->assign_block_vars('sqllist', array());
	if( count($alist) > 0 )
	{
		for($i = 0; $i < count($alist); $i++)
		{
			$template->assign_block_vars('sqllist.item', array(
				'ROW_STYLE' => ($i % 2 ? '2' : '3'),
				'LINK' => '?mode=dbread&amp;step=prepare&amp;file='.urlencode(str_replace("..", "kat_wyzej", $phpbb_root_path).$alist[$i]),
				'TEXT' => $alist[$i],
				'SIZE' => round(filesize($phpbb_root_path.$alist[$i]) / 1024, 2))
			);
		}
	}
	else
	{
		$template->assign_block_vars('sqllist.no_items', array(
			'MSG' => 'Brak plik�w w przeszukanych katalogach')
		);
	}
	$template->assign_var('PAGE_GENTIME', $page_time->elapsed());
	$template->pparse('body');
}
elseif( $mode == 'dbread' )
{
	// $step = ('prepare', 'go', 'completed', 'error_notify',
	//     'error_notify_continue', 'break', 'show_errors')
	if( !$config_size_ok || $db_error)
	{
		$template->assign_vars(array(
			'TITLE' => 'Wczytywanie zrzutu bazy danych...')
		);
		message_die('', true, true);
	}
	$db->sql_query("SELECT * FROM _dbloader");
	$tbl_exists = ($db->sql_affectedrows() > 0 ) ? true : false;
	if( $tbl_exists && !isset($_POST['max_queries']) )
	{
		$rt_data = $db->sql_fetchrowset();
		$rt_data = config_assoc($rt_data, 'config', 'value');
	}
	else
	{
		$rt_data['max_queries'] = intval($_POST['max_queries']);
		$rt_data['file_name'] = ( isset($_GET['file']) ) ? str_replace("kat_wyzej", "..", $_GET['file']) : '';
	}
	if( $rt_data['file_name'] == '' || !file_exists($rt_data['file_name']) )
	{
		$msg = 'Plik \''.$rt_data['file_name'].'\' nie istnieje.';
		$template->assign_vars(array(
			'TITLE' => 'Wczytywanie zrzutu bazy danych...',
			'CONTENT' => $msg,
			'PAGE_GENTIME' => $page_time->elapsed())
		);
		$template->pparse('body');
		exit;
	}
	$step = ( isset($_GET['step']) ) ? $_GET['step'] : '';
	$allowed_steps = array('prepare', 'go', 'completed', 'error_notify',
		'error_notify_continue', 'break', 'show_errors');
	if( !in_array($step, $allowed_steps) )
	{
		$msg = "Z�e wywo�anie skryptu.";
		$template->assign_vars(array(
			'TITLE' => 'Wczytywanie zrzutu bazy danych...',
			'CONTENT' => $msg,
			'PAGE_GENTIME' => $page_time->elapsed())
		);
		$template->pparse('body');
		exit;
	}
	//
	// prepare
	//
	if( $step == 'prepare' )
	{
		$template->assign_block_vars('dbread', array(
			'DB' => $dbuser.'.'.$dbname.' @ '.$dbhost,
			'SQL_FILE' => $rt_data['file_name'])
		);
		if( $rt_data['max_queries'] > 0 )
		{
			$fr = new FileReader($rt_data['file_name']);
			$file_size = $fr->realsize();
			$fr->close();

			$tables = tables_in_db();
			$tables[] = '_dbloader';
			$tables[] = '_dbloader_err';
			$tables = escape_str(serialize($tables));
			$db->sql_freeresult($result);
			// Wpisz zmienne do bazy danych, b�d� �adowane do tablicy $rt_cfg
			$queries = array(
"CREATE TABLE IF NOT EXISTS `_dbloader` (
`config` VARCHAR( 255 ) NOT NULL ,
`value` TEXT NOT NULL ) DEFAULT CHARSET latin2 COLLATE latin2_general_ci",
"TRUNCATE TABLE `_dbloader`",
"CREATE TABLE `_dbloader_err` (
`id` SMALLINT NOT NULL AUTO_INCREMENT ,
`pos` INT NOT NULL ,
`code` SMALLINT NOT NULL ,
`message` TEXT NOT NULL ,
PRIMARY KEY ( `id` ) ) DEFAULT CHARSET latin2 COLLATE latin2_general_ci",
"TRUNCATE TABLE `_dbloader_err`",
"INSERT INTO `_dbloader` VALUES ('max_queries', '".$rt_data['max_queries']."')",
"INSERT INTO `_dbloader` VALUES ('omit_search', '".($_POST['omit_search'] == 'on' ? 1 : 0)."')",
"INSERT INTO `_dbloader` VALUES ('loaded_queries', '0')",
"INSERT INTO `_dbloader` VALUES ('omitted_queries', '0')",
"INSERT INTO `_dbloader` VALUES ('file_name', '".escape_str(str_replace("kat_wyzej", "..", $_GET['file']))."')",
"INSERT INTO `_dbloader` VALUES ('file_size', '$file_size')",
"INSERT INTO `_dbloader` VALUES ('offset', '0')",
"INSERT INTO `_dbloader` VALUES ('php_time', '0')",
"INSERT INTO `_dbloader` VALUES ('sql_time', '0')",
"INSERT INTO `_dbloader` VALUES ('errors', '0')",
"INSERT INTO `_dbloader` VALUES ('max_errors', '1')",
"INSERT INTO `_dbloader` VALUES ('alt_engine', '".($_POST['alt_engine'] == 'on' ? 1 : 0)."')",
"INSERT INTO `_dbloader` VALUES ('lock_tables', '".($_POST['lock_tables'] == 'on' ? 1 : 0)."')",
"INSERT INTO `_dbloader` VALUES ('last_lock', '')",
"INSERT INTO `_dbloader` VALUES ('tables', '$tables')",
"INSERT INTO `_dbloader` VALUES ('completed', '0')");
			foreach($queries as $query)
			{
				$db->sql_query($query);
			}
			$rt_data['file_size'] = $file_size;
			echo generate_progress($rt_data, 'Rozpoczynanie wczytywania...');
			echo '<meta http-equiv="refresh" content="0;url=' . $PHP_SELF . '?mode=dbread&step=go"></body></html>';
			exit;
		}
		else
		{
			$template->assign_block_vars('dbread.form', array(
				'FORM_ACTION' => $PHP_SELF.'?mode=dbread&step=prepare&file='.urlencode(str_replace("..", "kat_wyzej", $rt_data['file_name'])),
				'MAX_QUERIES_DEF' => ($is_limited ? 100 : 1000) )
			);
		}
		$template->assign_vars(array(
			'TITLE' => 'Wczytywanie zrzutu bazy danych...',
			'PAGE_GENTIME' => $page_time->elapsed())
		);
		$template->pparse('body');
	}
	//
	// go
	//
	elseif( $step == 'go')
	{
		// ustaw limit czasu wykonywania skryptu, nie dzia�a w Safe Mode
		@set_time_limit($execution_time);

		$fr = new FileReader($rt_data['file_name'], $rt_data['file_size']);
		$fr->seek($rt_data['offset']);
		$reader_engine = ( $rt_data['alt_engine'] ) ? SQL_READER_FAST : SQL_READER_PMA;
		$sqlreader = new SQLReader($fr, $reader_engine);

		$gentime = array();
		$gentime['php'] = new Timer(true);
		$gentime['sql'] = new Timer(false);
		$errors = array();
		$locked = array();
		$i = 0;
		$time0 = time() + 30;
		$error_try = ($reader_engine == SQL_READER_FAST);
		if( $rt_data['lock_tables'] && $rt_data['last_lock'] != '' )
		{
			$db->sql_query("LOCK TABLES `" . escape_str($rt_data['last_lock']) . "` WRITE");
			$locked[] = $rt_data['last_lock'];
		}
		while( $i <= $rt_data['max_queries'] && is_array($query = $sqlreader->get_query()) )
		{
			$i++;
			// rozbij kawa�ek zapytania
			$tokens = explode(' ', str_replace(array("\n", "\r"), array(' ', ''), substr($query['query'], 0, 64)));
			// je�li INSERT i co� pomijamy lub blokujemy...
			if( ($rt_data['omit_search'] || $rt_data['lock_tables'])
				&& $tokens[0] == 'INSERT' )
			{
				// pomijanie search
				if( $rt_data['omit_search'] )
				{
					$matches = preg_match('/(search_(results|wordlist|wordmatch))/i', $tokens[2]);
					if($matches > 0)
					{
						$rt_data['omitted_queries']++;
						continue;
					}
				}
				// blokowanie tabel
				if( $rt_data['lock_tables'] )
				{
					if( !in_array($tokens[2], $locked) )
					{
						$locked[] = $tokens[2];
						$db->sql_query("LOCK TABLES `" . escape_str($tokens[2]) . "` WRITE");
					}
				}
			}
			// sprawd� czy zapytanie to LOCK TABLES
			if( $rt_data['lock_tables'] && $tokens[0] == 'LOCK'
				&& !in_array($tokens[2], $locked) )
			{
					$locked[] = $tokens[2];
			}
			$rt_data['loaded_queries']++;
			$gentime['php']->stop();
			$gentime['sql']->start();
			// wykonaj zapytanie
			if( !$db->sql_query($query['query']) )
			{
				// b��d...
				$is_error = true;
				$err = $db->sql_error();

				if( $err['code'] == 1100 ) //Table ? was not locked with LOCK TABLES
				{
					$db->sql_query('UNLOCK TABLES');
					$is_error = $db->sql_query($query['query']) ? false : true;
				}
				elseif( $error_try )
				{
					$fr->seek($query['pos']);
					$sqlreader->set_method(SQL_READER_PMA);
					$query = $sqlreader->get_query();
					$sqlreader->set_method(SQL_READER_FAST);
					if( is_array($query) && $db->sql_query($query['query']) )
					{
						$is_error = false;
					}
				}
				if( $is_error )
				{
					$gentime['sql']->stop();
					$rt_data['errors']++;
					$err = $db->sql_error();
					$c = count($errors);
					$errors[$c]['pos'] = $query['pos'];
					$errors[$c]['code'] = $err['code'];
					$errors[$c]['msg'] = $err['message'];
					if( $c + 1 == $rt_data['max_errors'] )
					{
						break;
					}
				}
			}
			$gentime['sql']->stop();
			$time1 = time();
			if( $time1 >= $time0 )
			{
				$time0 = $time1 + 30;
				header('X-dblPing: Pong');
			}
			$gentime['php']->start();
		}
		// je�li jakie� tabele zablokowane, odblokuj
		if( count($locked) > 0 )
		{
			$db->sql_query('UNLOCK TABLES');
		}
		$gentime['php']->stop();
		$rt_data['offset'] = $fr->tell();
		$fr->close();
		$do_redir = ( $query != false );

		echo generate_progress($rt_data,
			($do_redir
			? substr($query['query'], 0, 300)
			: 'Zako�czono wczytywanie' )
			);
		flush();

		$rt_data['php_time'] += $gentime['php']->elapsed();
		$rt_data['sql_time'] += $gentime['sql']->elapsed();

		$queries = array(
"UPDATE _dbloader SET value = '" . $rt_data['offset'] . "' WHERE config = 'offset' LIMIT 1",
"UPDATE _dbloader SET value = '" . $rt_data['loaded_queries'] . "' WHERE config = 'loaded_queries' LIMIT 1",
"UPDATE _dbloader SET value = '" . $rt_data['omitted_queries'] . "' WHERE config = 'omitted_queries' LIMIT 1",
"UPDATE _dbloader SET value = '" . $rt_data['php_time'] . "' WHERE config = 'php_time' LIMIT 1",
"UPDATE _dbloader SET value = '" . $rt_data['sql_time'] . "' WHERE config = 'sql_time' LIMIT 1",
"UPDATE _dbloader SET value = '" . $rt_data['errors'] . "' WHERE config = 'errors' LIMIT 1",
"UPDATE _dbloader SET value = '" . ($rt_data['lock_tables'] ? escape_str(strval(array_pop($locked))) : '') . "' WHERE config = 'last_lock' LIMIT 1");
		if( !$do_redir )
		{
			$queries[] = "UPDATE _dbloader SET value = '1' WHERE config = 'completed' LIMIT 1";
		}
		for($i = 0; $i < count($errors); $i++)
		{
			$queries[] = "
INSERT INTO `_dbloader_err` ( pos , code , message ) 
VALUES ( '".$errors[$i]['pos']."', '".$errors[$i]['code']."', '".escape_str($errors[$i]['msg'])."')";
		}
		$save_error = false;
		foreach($queries as $query)
		{
			if( !$db->sql_query($query) )
			{
				$err = $db->sql_error();
				echo 'B��d zapisu konfiguracji ('.$err['code'].': '.xhtmlspecialchars($err['message']).')<br />'.xhtmlspecialchars($query).'<hr />';
				$save_error = true;
			}
		}
		if( $rt_data['errors'] >= $rt_data['max_errors'] )
		{
			$redir = $PHP_SELF.'?mode=dbread&step=error_notify';
		}
		elseif( $do_redir )
		{
			$redir = $PHP_SELF.'?mode=dbread&step=go';
		}
		else
		{
			$redir = $PHP_SELF.'?mode=dbread&step=completed';
		}
		if( $save_error )
		{
			echo '<br /><br /><a href="' . $redir . '">Kontynuuj</a>';
			exit;
		}
		echo '<meta http-equiv="refresh" content="0;url=' . $redir . '"></body></html>';
	}
	//
	// error_notify
	//
	elseif( $step == 'error_notify' )
	{
		echo generate_error_notify($rt_data, true);
	}
	//
	// error_notify_continue
	//
	elseif( $step == 'error_notify_continue' )
	{
		$redir = $PHP_SELF;
		if( isset($_POST['continue']) )
		{
			$db->sql_query("UPDATE _dbloader SET value = '" . ($rt_data['max_errors'] + $rt_data['max_queries']) . "' WHERE config = 'max_errors' LIMIT 1");
			$alt_engine = ($_POST['new_engine'] == 'std') ? 0 : 1;
			$db->sql_query("UPDATE _dbloader SET value = "
				. $alt_engine . " WHERE config = 'alt_engine' LIMIT 1");
			$max_queries = intval($_POST['new_max_queries']);
			$max_queries = ( $max_queries < 2 ) ? 2 : $max_queries;
			$db->sql_query("UPDATE _dbloader SET value = "
				. $max_queries . " WHERE config = 'alt_engine' LIMIT 1");
			$redir = "$PHP_SELF?mode=dbread&step=go";
		}
		elseif( isset($_POST['break']) )
		{
			if( $rt_data['tables'] != '' && $_POST['delete_new_tables'] == 'on' )
			{
				$del_tables = array_diff(tables_in_db(), unserialize($rt_data['tables']));
				foreach( $del_tables as $table )
				{
					$db->sql_query("DROP TABLE IF EXISTS `" . escape_str($table) . "`");
				}
			}
			$redir = "$PHP_SELF?mode=main&droptables=1";
		}
		header('HTTP/1.1 301');
		header("Location: $redir");
		exit;
	}
	//
	// completed
	//
	elseif( $step == 'completed' )
	{
		$template->assign_block_vars('dbread', array(
			'DB' => $dbuser.'.'.$dbname.' @ '.$dbhost,
			'SQL_FILE' => $rt_data['file_name'])
		);

		$php_time = $rt_data['php_time'];
		$sql_time = $rt_data['sql_time'];
		$time_total = $rt_data['php_time'] + $rt_data['sql_time'];

		$template->assign_block_vars('dbread.completed', array(
			'QUERIES_LOADED' => $rt_data['loaded_queries'],
			'QUERIES_OMITTED' => $rt_data['omitted_queries'],
			'QUERIES_MAX' => $rt_data['max_queries'],
			'ERRORS_MAX' => $rt_data['max_errors'],
			'LOCK_TABLES' => $rt_data['lock_tables'] ? 'tak' : 'nie',
			'TIME_PHP' => human_time($php_time),
			'TIME_SQL' => human_time($sql_time),
			'TIME_TOTAL' => human_time($time_total) )
		);
		if( $rt_data['errors'] > 0 )
		{
			$template->assign_block_vars('dbread.completed.errors', array(
				'ERRORS' => $rt_data['errors'])
			); 
		}
		$template->assign_vars(array(
			'TITLE' => 'Wczytywanie zrzutu bazy danych - podsumowanie',
			'PAGE_GENTIME' => $page_time->elapsed())
		);
		$template->pparse('body');
	}
	//
	// show_errors
	//
	elseif( $step == 'show_errors' )
	{
		// ustaw limit czasu wykonywania skryptu, nie dzia�a w Safe Mode
		@set_time_limit($execution_time);

		$template->assign_block_vars('dbread', array(
			'DB' => $dbuser.'.'.$dbname.' @ '.$dbhost,
			'SQL_FILE' => $rt_data['file_name'])
		);

		$db->sql_query("SELECT * FROM _dbloader_err");

		$fr = new FileReader($rt_data['file_name'], $rt_data['file_size']);
		$reader_engine = ( $rt_data['alt_engine'] ) ? SQL_READER_FAST : SQL_READER_PMA;
		$sqlreader = new SQLReader($fr, $reader_engine);

		for($i = 0; $i < $rt_data['errors']; $i++)
		{
			$row = $db->sql_fetchrow();
			$fr->seek($row['pos']);
			$query = $sqlreader->get_query();
			$template->assign_block_vars('dbread.error', array(
				'ID' => $i + 1,
				'POS' => $row['pos'],
				'CODE' => $row['code'],
				'MESSAGE' => xhtmlspecialchars($row['message']),
				'QUERY' => nl2br(xhtmlspecialchars($query['query'])))
			);
		}
		$template->assign_vars(array(
			'TITLE' => 'Wczytywanie zrzutu bazy danych - raport o b��dach',
			'PAGE_GENTIME' => $page_time->elapsed())
		);
		$template->pparse('body');
	}
}
elseif( $mode == 'misc' )
{
	$template->assign_vars(array(
		'TITLE' => 'Inne funkcje')
	);
	if( !$config_size_ok || $db_error)
	{
		message_die('', true, true);
	}
	// Wykonaj zadany kod
	$func = ( isset($_GET['func']) ) ? $_GET['func'] : '';
	if( $func == 'dbcreate' )
	{
		$res = '';
		$query = (isset($_POST['dbcreate_create']) ? 'CREATE' : 'DROP') . " DATABASE `" . escape_str($_POST['dbcreate_dbname']) . '`';
		if( !$db->sql_query($query) )
		{
			$err = $db->sql_error();
			$res = '<div class="code">' . $query . '</div><br /><span style="color:red">Error code: ' . $err['code'] . '<br />Message: ' . $err['message'] . '</span>';
		}
		else
		{
			$res = '<div class="code">' . $query . '</div><br /><span style="color:green">Baza <b>' . $_POST['dbcreate_dbname'] . '</b> zosta�a ' . ( isset($_POST['dbcreate_create']) ? 'utworzona' : 'usuni�ta' ) . '.</span>';
		}
	 	$_SESSION['dbcreate_res'] = $res;
	}
	elseif( $func == 'bbdrop' )
	{
		$res = '';
		include 'dbdata.inc.php'; //$dbs, $dbs_for
		$dbs = append_prefix($table_prefix, $dbs);
		if( isset($_POST['bbdrop_check']) && strtolower($_POST['bbdrop_check']) == 'skasuj' )
		{
			foreach( $dbs as $dbs_item )
			{
				$table_name = ( !is_array($dbs_item) ) ? $dbs_item : $dbs_item['table'];
				if( !$db->sql_query("DROP TABLE IF EXISTS `$table_name`") )
				{
					$err = $db->sql_error();
					$res = ( $res != '' ) ? '<hr />'.$res : $res;
					$res = '<span style="color:red">Error code: ' . $err['code'] . '<br />Message: ' . $err['message'] . '</span>';
				}
				if( $res == '' )
				{
					$res = '<span style="color:green">Tabele zosta�y usuni�te.</span>';
				}
			}
		}
		else
		{
			$res = 'Wpierw wype�nij pole tekstowe.';
		}
		$_SESSION['bbdrop_res'] = $res . '<br />';
	}
	if( $func != '' )
	{
		header('HTTP/1.1 301');
		header("Location: $PHP_SELF?mode=misc");
		exit;
	}
	// Przygotuj szablon
	$db->sql_query("SHOW DATABASES");
	$result = $db->sql_fetchrowset();
	$db_list = array();
	foreach( $result as $db_name )
	{
		$db_list[] = $db_name['Database'];
	}
	if( count($db_list) == 0 )
	{
		$db_list[] = '<i>brak baz</i>';
	}
	$template->assign_block_vars('misc', array(
		'DBLIST' => implode('<br />', $db_list),
		'DBCREATE_RESULT' => session_load_once('dbcreate_res'),
		'BBDROP_RESULT' => session_load_once('bbdrop_res'))
	);
	$template->assign_var('PAGE_GENTIME', $page_time->elapsed());
	$template->pparse('body');
}
else
{
	if( !$db_error )
	{
		$db->sql_query("SELECT * FROM _dbloader");
		$tbl_exists = ($db->sql_affectedrows() > 0 ) ? true : false;
		$tables_deleted = false;
		if( $tbl_exists )
		{
			$check_data = $db->sql_fetchrowset();
			$check_data = config_assoc($check_data, 'config', 'value');

			if ( $check_data['max_queries'] > 0
				&& !(isset($_GET['droptables']) || $check_data['completed']) )
			{
				echo generate_error_notify($check_data, false);
				exit;
			}
			else
			{
				$db->sql_query("DROP TABLE IF EXISTS _dbloader");
				$db->sql_query("DROP TABLE IF EXISTS _dbloader_err");
				$tables_deleted = true;
			}
		}
	}
	$content = '<b>config.'.$phpEx.'</b><br />';
	if( $is_config )
	{
		$content .= '<span style="color:green">istnieje</span> <img src="'.$img_path.'icon_mini_register.gif" alt="Ok"><br />';
		if( $config_size_ok )
		{
			$content .= '<span style="color:green">rozmiar poprawny</span> <img src="'.$img_path.'icon_mini_register.gif" alt="Ok"><br />';
		}
		else
		{
			$content .= '<span style="color:red">prawdopodobnie pusty (ma�y rozmiar)</span> <img src="'.$img_path.'icon_mini_ignore.gif" alt="B��d"><br />';  
		}
	}
	else
	{
		$content .= '<span style="color:red">brak pliku</span> <img src="'.$img_path.'icon_mini_ignore.gif" alt="B��d"><br />';
	}

	$content .= '<br /><b>baza danych</b><br />';
	if( !$db_error )
	{
		$content .= '<span style="color:green">nawi�zano po��czenie ('.$dbuser.'.'.$dbname.' @ '.$dbhost.')</span> <img src="'.$img_path.'icon_mini_register.gif" alt="Ok"><br />';
		$content .= ( $tables_deleted ) ? '<span style="color:green">usuni�to tymczasowe tabele _dloader i _dbloader_err</span> <img src="'.$img_path.'icon_mini_register.gif" alt="Ok"><br />' : '';
		$content .= ( $not_supported ) ? '<span style="color:red">nieobs�ugiwany typ bazy danych: <b>'.$dbms.'</b>, skrypt mo�e nie dzia�a� poprawnie</span> <img src="'.$img_path.'icon_mini_ignore.gif" alt="B��d"><br />' : '';
		if( $cfg_table_ex )
		{
			$content .= '<span style="color:green">znaleziono tabel� '.$table_prefix.'config</span> <img src="'.$img_path.'icon_mini_register.gif" alt="Ok"><br />';
		}
		else
		{
			$content .= '<span style="color:red">nie znaleziono tabeli '.$table_prefix.'config</span> <img src="'.$img_path.'icon_mini_ignore.gif" alt="B��d"><br />';
		}
	}
	else
	{
		$content .= '<span style="color:red">nie nawi�zano po��czenia</span> <img src="'.$img_path.'icon_mini_ignore.gif" alt="B��d"><br />';
		if( $config_size_ok )
		{
			$sql_error = $db->sql_error($connect);
			$content .= '<span style="color:red"> &nbsp; Error code: ' . $sql_error['code'] . '<br />';
			$content .= ' &nbsp; Error message: ' . $sql_error['message'] . '</span><br />';
		}
	}
	$content .= '<br /><b>serwer</b><br />';
	$gz = function_exists('gzopen');
	$bz2 = function_exists('bzdecompress');
	$content .= ( $is_limited ) ? '<span style="color:red">Safe Mode lub serwer Lycos</span><br />' : '';
	$content .= '<span style="color:'.($gz ? 'green' : 'red').'">obs�uga gzip (.gz)</span> <img src="'.$img_path.'icon_mini_'.($gz ? 'register' : 'ignore').'.gif" alt="'.($gz ? 'Ok' : 'B��d').'"><br />';
	$content .= '<span style="color:'.($bz2 ? 'green' : 'red').'">obs�uga <a href="http://sources.redhat.com/bzip2/" target="_blank">&raquo; Bzip2</a> (.bz2)</span> <img src="'.$img_path.'icon_mini_'.($bz2 ? 'register' : 'ignore').'.gif" alt="'.($bz2 ? 'Ok' : 'B��d').'"><br />';
	
	$pg_title = 'phpBB DumpLoader ' . $version;
	$pg_title .= ( $has_access ) ? '' : ' &nbsp; <span style="color:red">wy��czony</span>';
	$conf_current = '<?php
// tw�j adres IP
$twoje_ip = \''.$twoje_ip.'\';
... ';
	$conf_proper = '<?php
// tw�j adres IP
$twoje_ip = \''.$_SERVER['REMOTE_ADDR'].'\';'.($_SERVER['REMOTE_ADDR'] != $twoje_ip ? ' // zmie� tu' : '').'
... ';
	$conf_current = str_replace("\r\n", "\n", $conf_current);
	$conf_current = highlight_string($conf_current, true);
	$conf_current = explode("\n", $conf_current);
	$conf_current = $conf_current[1];
	$conf_proper = str_replace("\r\n", "\n", $conf_proper);
	$conf_proper = highlight_string($conf_proper, true);
	$conf_proper = explode("\n", $conf_proper);
	$conf_proper = $conf_proper[1];
	$template->assign_vars(array(
		'TITLE' => $pg_title)
	);
	$template->assign_block_vars('index', array(
		'FAST_CHECK' => $content,
		'CONF_CURRENT' => nl2br($conf_current),
		'CONF_PROPER' => nl2br($conf_proper))
	);
	$template->assign_var('PAGE_GENTIME', $page_time->elapsed());
	$template->pparse('body');
}
if (!empty($db))
{
	$db->sql_close();
}
?>