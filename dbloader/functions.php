<?php
// ----------------------------
// Funkcje zaczerpniête z phpBB
//
function make_download($dbms, $dbhost, $dbname, $dbuser, $dbpasswd, $table_prefix)
{
	$config_file = '<?php' . "\n\n";
	$config_file .= '//' . "\n";
	$config_file .= '// phpBB 2.x auto-generated config file' . "\n";
	$config_file .= '// Do not change anything in this file!' . "\n";
	$config_file .= '//' . "\n\n";
	$config_file .= '$dbms = \'' . $dbms . '\';' . "\n\n";
	$config_file .= '$dbhost = \'' . $dbhost . '\';' . "\n";
	$config_file .= '$dbname = \'' . $dbname . '\';' . "\n";
	$config_file .= '$dbuser = \'' . $dbuser . '\';' . "\n";
	$config_file .= '$dbpasswd = \'' . $dbpasswd . '\';' . "\n\n";
	$config_file .= '$table_prefix = \'' . $table_prefix . '\';' . "\n\n";
	$config_file .= 'define(\'PHPBB_INSTALLED\', true);' . "\n\n";
	$config_file .= '?>';//<?

	return $config_file;
}

function make_config($dbms, $dbhost, $dbname, $dbuser, $dbpasswd, $table_prefix)
{
	$config_file = '&lt;?php<br />' . "\n";
	$config_file .= '<br />' . "\n";
	$config_file .= '//<br />' . "\n";
	$config_file .= '// phpBB 2.x auto-generated config file<br />' . "\n";
	$config_file .= '// Do not change anything in this file!<br />' . "\n";
	$config_file .= '//<br />' . "\n";
	$config_file .= '<br />' . "\n";
	$config_file .= '$dbms = \'' . $dbms . '\';<br /><br />' . "\n\n";
	$config_file .= '$dbhost = \'' . $dbhost . '\';<br />' . "\n";
	$config_file .= '$dbname = \'' . $dbname . '\';<br />' . "\n";
	$config_file .= '$dbuser = \'' . $dbuser . '\';<br />' . "\n";
	$config_file .= '$dbpasswd = \'' . $dbpasswd . '\';<br /><br />' . "\n\n";
	$config_file .= '$table_prefix = \'' . $table_prefix . '\';<br /><br />' . "\n\n";
	$config_file .= 'define(\'PHPBB_INSTALLED\', true);<br /><br />' . "\n\n";
	$config_file .= '?>';//<?

	return $config_file;
}

if( !@function_exists('phpbb_realpath') )
{
	function phpbb_realpath($path)
	{
		global $phpbb_root_path, $phpEx;
		return (!@function_exists('realpath') || !@realpath($phpbb_root_path . 'includes/functions.'.$phpEx)) ? $path : @realpath($path);
	}
}

if( !function_exists('xhtmlspecialchars') ){
	function xhtmlspecialchars($s) {
		return htmlspecialchars($s, ENT_COMPAT | ENT_HTML401, "ISO-8859-1");
	}
}

//
// Funkcje zaczerpniête z phpBB
// ----------------------------

// --------------
// W³asne funkcje
//

// Zwraca true je¶li $fname jest plikiem SQL
function is_sql_file($fname)
{
	$allowed_exs = array();
	$allowed_exs[] = 'sql';
	$ext = strtolower(substr(strrchr($fname, '.'), 1));
	if( function_exists('gzopen') )
	{
		$allowed_exs[] = 'gz';
	}
	if( function_exists('bzdecompress') )
	{
		$allowed_exs[] = 'bz2';
	}

	return in_array($ext, $allowed_exs);
}

// Zwraca pliki SQL w katalogu $dir (zag³êbianie do $levels poziomów)
function scan_dir($dir, $levels = 1)
{
	$levels--;
	$dir = (strrchr($dir, '/') != strlen($dir)) ? $dir.'/' : $dir;
	if( !is_dir($dir) )
	{
		return array();
	}
	$files = array();
	$dh = @opendir($dir);
	while (false !== ($fname = @readdir($dh)))
	{
		if( !stristr($fname,'update_phpBB_to') && $fname != '.' && $fname != '..' && is_file($dir.$fname) && is_sql_file($fname) )
		{
			$files[] = $fname;
		}
	} 
	@closedir($dh);
	sort($files);
	if( $levels >= 0 )
	{
		$subdirs = array();
		$dh = @opendir($dir);
		while (false !== ($fname = @readdir($dh)))
		{
			if( $fname != '.' && $fname != '..' && is_dir($dir.$fname) )
			{
				$subdirs[] = $fname;
			}
		}
		@closedir($dh);
		if( count($subdirs) > 0 )
		{
			sort($subdirs);
			foreach( $subdirs as $dirname )
			{
		 		$subfiles = scan_dir($dir.$dirname, $levels);
		 		for($i = 0; $i < count($subfiles); $i++)
				{
					$subfiles[$i] = $dirname.'/'.$subfiles[$i];
				}
		 		$files = array_merge($subfiles, $files);
			}
		}
	}

	return $files;
}

// Do³±cza prefiks do tablicy z tabelami
function append_prefix($prefix, $tables)
{
	if( !is_array($tables) )
	{
		return array();
	}
	for($i = 0; $i < count($tables); $i++)
	{
		$tables[$i]['table'] = $prefix.$tables[$i]['table'];
		if( isset($tables[$i]['create']) )
		{
			$tables[$i]['create'] = str_replace('{PREFIX}', $prefix, $tables[$i]['create']);
		}
	}
	return $tables;
}

// Pobiera tablicê $rowset
//  { [0] => array(...) { [$config_name] => "...", [$config_value] => "...", ... }
// Zwraca tablicê
//  { [$config_name] => [$config_value] }   
function config_assoc($rowset, $config_name, $config_value)
{
	$result = array();
	for($i = 0; $i < count($rowset); $i++)
	{
		$key = $rowset[$i][$config_name];
		$result[$key] = $rowset[$i][$config_value];
	}
	return $result;
}

// Koñczy wykonywanie skryptu z komunikatem o b³êdzie
function message_die($message = '', $config_check = false, $db_check = false)
{
	global $template, $page_time, $config_size_ok, $phpEx, $db_error;

	$msg = '';
	if( $config_check && !$config_size_ok )
	{
		$msg = 'Ten modu³ dzia³a tylko z poprawnie wype³nionym plikiem config.'.$phpEx;
	}
	elseif( $db_check && $db_error )
	{
		$msg = 'Ten modu³ wymaga aktywnego po³±czenia z baz± danych.';
	}
	if( $message != '' )
	{
		$msg .= '<br /><hr />'.$message;
	}
	$template->assign_vars(array(
		'PAGE_GENTIME' => $page_time->elapsed(),
		'CONTENT' => $msg)
	);
	$template->pparse('body');
	die();
}

// Zwraca warto¶æ z tablicy sesji i j± czy¶ci
function session_load_once($varname)
{
	if( isset($_SESSION[$varname]) )
	{	
		$ret = $_SESSION[$varname];
		$_SESSION[$varname] = NULL;
	}
	else
	{
		$ret = '';
	}
	return $ret;
}

// Zwraca nazwê serwera
function get_servername()
{
	if ( !empty($_SERVER['SERVER_NAME']) || !empty($_ENV['SERVER_NAME']) )
	{
		$server_name = ( !empty($_SERVER['SERVER_NAME']) ) ? $_SERVER['SERVER_NAME'] : $_ENV['SERVER_NAME'];
	}
	elseif ( !empty($_SERVER['HTTP_HOST']) || !empty($_ENV['HTTP_HOST']) )
	{
		$server_name = ( !empty($_SERVER['HTTP_HOST']) ) ? $_SERVER['HTTP_HOST'] : $_ENV['HTTP_HOST'];
	}
	else
	{
		$server_name = '';
	}
	return $server_name;
}

function human_time($time)
{
	return ( $time < 60 )
		? round($time, 1) . ' s.'
		: round(($time / 60), 1) . ' m.';
}

function escape_str($str)
{
    global $db;

	if( strlen($str) > 2 && substr($str, 0, 1) == '`' && substr($str, -1) == '`' )
	{
		$str = substr($str, 1, -1);
	}
	return $db->sql_escape($str);
}

function not_script_dir($var)
{
	return (substr($alist[$i], 0, 8) != 'scripts/');
}

function tables_in_db($like = null)
{
	global $db;

    $query = 'SHOW TABLES'
    	. ( $like != null ? " LIKE '" . escape_str($like) . "'" : '');
	$db->sql_query($query);
	$tables = array();
	while($row = $db->sql_fetchrow())
	{
		$row = array_values($row);
		$tables[] = $row[0];
	}
	return $tables;
}

// Zwraca kod strony postêpu
function generate_progress(&$rt_data, $last_query)
{
	$php_time = human_time($rt_data['php_time']);
	$sql_time = human_time($rt_data['sql_time']);
	$time_total = human_time($rt_data['php_time'] + $rt_data['sql_time']);
	$loaded_percent = round((($rt_data['offset'] / $rt_data['file_size']) * 100), 2);
	$loaded_percent = explode('.', $loaded_percent);
	$tmp = explode("\n", $last_query);
	$last_query = array();
	$i = 0;
	while( $i < count($tmp) && $i < 8 )
	{
		$tmp[$i] = xhtmlspecialchars($tmp[$i]);
		$last_query[] = (strlen($tmp[$i]) > 120)
			? substr($tmp[$i], 0, 120) . '<span style="color:#0329FD"><b>...</b></span>'
			: $tmp[$i];
		$i++;
	}
	if( isset($tmp[8]) )
	{
		$last_query[] = '<span style="color:#0329FD"><b>...</b></span>';
	}
	$last_query = implode("\n", $last_query);

return '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
<title>phpBB DumpLoader - wczytywanie zrzutu...</title>
<style type="text/css">
<!--
	body {background-color:#6E82FD; color:black}
	font,th,td,p	{font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif}
	hr {height:0px; border:0px; border-top: 1px #0329FD solid}
-->
</style>
</head>
<body>
<table border="0" style="height:100%; width:100%"><tr><td style="height:100%; vertical-align:middle"><div style="border:1px #0220CB solid; background-color:#D1D7DC; padding:5px">
<div style="text-align:center">Uwaga: nie wy³±czaj ani nie od¶wie¿aj teraz strony!<br /><br />
<hr style="width:70%" />
<b>Postêp wczytywania bazy SQL</b><br />
<span style="font-size:60pt"><b>' . $loaded_percent[0] . '</b></span>
' . (($loaded_percent[1])
	? '<span style="font-size:25pt"><b>.' . $loaded_percent[1] . '</b></span>'
	: '')
	. '
<span style="font-size:60pt">%</span></div>
<hr />
' . (($rt_data['php_time'] > 0 && $rt_data['sql_time'] > 0)
	? 'Wczytane zapytania: ' . $rt_data['loaded_queries'] . ', przetworzone w: ' . $php_time
		. ', wykonane do bazy w: ' . $sql_time . ' £±cznie: ~ '
		. $time_total . '<br />'
	: '' )
	. '
' . (($last_query)
	? '<br />
Ostatnie zapytanie:<br /><span style="font-size:8pt"><pre style="height:110px; max-height:110px">'
	. $last_query . '</pre></span>'
	: '')
	. '
</div></td></tr></table>';
}

// $mode = ('error' || 'info')
function generate_error_notify(&$rt_data, $error_mode)
{
	$engine = ( $rt_data['alt_engine'] ) ? SQL_READER_FAST : SQL_READER_PMA;
	$table_list = ( $rt_data['tables'] != '' )
		? implode(', ', array_diff(tables_in_db(), unserialize($rt_data['tables'])))
		: '';
	return '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
<title>phpBB DumpLoader - ' . ( $error_mode
	? 'powiadomienie o b³êdach'
	: 'niedokoñczone wczytywanie' )
	. '</title>
<style type="text/css">
<!--
body {background-color:#6E82FD; color:black}
body, span, input {font-size:12px; font-family: Verdana, Arial, Helvetica, sans-serif}
a:link,a:active,a:visited {color:#006699}
a:hover {color:#F38600}
label:hover {color:red}
</style>
</head>
<body>
<div style="border:1px #0220CB solid; background-color:#D1D7DC; padding:15px">
' . ( $error_mode
	? 'Podczas wykonywania zapytañ MySQL zwróci³ b³êdy: <b>
'		. $rt_data['errors'] . '</b> (limit: ' . $rt_data['max_errors']
		. '). Na pewno chcesz kontynuowaæ wgrywanie pliku?'
	: 'Poprzednie wczytywanie bazy SQL zosta³o przerwane. Mo¿esz zmieniæ ilo¶æ zapytañ lub algorytm wczytywania i je przywróciæ.' )
	. '<br /><br />
<form method="post" action="?mode=dbread&amp;step=error_notify_continue">
<b>Kontynuuj wczytywanie z algorytmem:</b><br />
<input type="radio" name="new_engine" value="std" id="engine_1" '
	. ( $engine == SQL_READER_PMA
	? 'checked="checked"'
	: '' )
	. ' /><label for="engine_1">standardowy, bazuj±cy na phpMyAdminie (wolny)</label><br />
<input type="radio" name="new_engine" value="alt" id="engine_2" '
	. ( $engine == SQL_READER_FAST
	? 'checked="checked"'
	: '' )
	. ' /><label for="engine_2">alternatywny (szybki, wymaga poprawnych plików)</label><br />
<br />
<b>Ilo¶æ zapytañ do jednorazowego wczytania:</b><br />
&nbsp;<input type="text" name="new_max_queries" value="' . ($rt_data['max_queries']?$rt_data['max_queries']:100) . '" style="width:50px" /><br />
'	. (($table_list != '')
	? '<br />
<b>Nowe tabele:</b><br />
<div style="margin-left:5px">Podczas wczytywania danych zosta³y utworzone nastêpuj±ce tabele:<br />'
		. '<span style="color:#666"><small>' . $table_list . '</small></span><br />Je¶li anulujesz wczytywanie skrypt mo¿e je usun±æ.<br />'
		. '<input type="checkbox" name="delete_new_tables" id="tbl_del" />'
		. '<label for="tbl_del">Usuñ nowe tabele</label></div>'
	: '' ) . '
<br />
<input type="submit" name="continue" value="Kontynuuj" />
 <input type="submit" name="break" value="Anuluj wczytywanie" />
</form>
' . ( $error_mode
	? '<br />[ <a href="?mode=dbread&amp;step=show_errors" target="_blank" title="Pokazuje w nowym oknie raport z b³êdami">Poka¿ raport</a> ]'
	: '' )
	. '
</span>
</div>
</body></html>';
}
?>