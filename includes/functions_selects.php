<?php
/***************************************************************************
 *                            function_selects.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   modification         : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   date modification    : ver. 1.12.0 2005/10/04 11:07
 *
 *   $Id: functions_selects.php,v 1.3.2.5 2005/05/06 20:50:11 acydburn Exp $
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
 *
 ***************************************************************************/

//
// Pick a language, any language ...
//
function language_select($default, $select_name = "language", $dirname="language", $empty_field = '')
{
	global $phpEx, $phpbb_root_path, $faq_editor_key;

	$dir = opendir($phpbb_root_path . $dirname);

	$lang = array();
	while ( $file = readdir($dir) )
	{
		if (preg_match('#^lang_#i', $file) && !is_file(@phpbb_realpath($phpbb_root_path . $dirname . '/' . $file)) && !is_link(@phpbb_realpath($phpbb_root_path . $dirname . '/' . $file)))
		{
			$filename = trim(str_replace("lang_", "", $file));
			$displayname = preg_replace("/^(.*?)_(.*)$/", "\\1 [ \\2 ]", $filename);
			$displayname = preg_replace("/\[(.*?)_(.*)\]/", "[ \\1 - \\2 ]", $displayname);
			$lang[$displayname] = $filename;
		}
	}

	closedir($dir);

	@asort($lang);
	@reset($lang);

	$lang_select = '<select name="' . $select_name . '">' . ((is_array($empty_field)) ? '<option value="' . $empty_field[0] . '"' . (($default == $empty_field[0]) ? ' selected="selected"' : '') . '>' . $empty_field[1] . '</option>' : '');
	while ( list($displayname, $filename) = @each($lang) )
	{
		$selected = ( strtolower($default) == strtolower($filename) ) ? ' selected="selected"' : '';
		$lang_select .= '<option value="' . $filename . '"' . $selected . '>' . ucwords($displayname) . '</option>';
		
		if($faq_editor_key)
		{
			$lang_list[] = $filename;
		}
		
	}
	$lang_select .= '</select>';

	return (!$faq_editor_key) ? $lang_select : $lang_list;
}

//
// Pick a template/theme combo, 
//
function style_select($default_style, $select_name = "style", $dirname = "templates")
{
	global $db;

	$quick = ($select_name == 'template' || $select_name == 'fpage_theme') ? ' onchange="this.form.submit()"' : '';

	$style_select = '<select name="' . $select_name . '"' . $quick . '>';

	$themes_list = sql_cache('check', 'themes_list');
	if (!empty($themes_list))
	{
		for($i=0; $i < count($themes_list); $i++)
		{
			$row = $themes_list[$i];
			$selected = ( $row['themes_id'] == $default_style ) ? ' selected="selected"' : '';
			$style_select .= '<option value="' . $row['themes_id'] . '"' . $selected . '>' . $row['style_name'] . '</option>';
		}
	}
	else
	{
		$themes_list = array();
		$sql = "SELECT themes_id, style_name
			FROM " . THEMES_TABLE . "
			ORDER BY template_name, themes_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Couldn't query themes table", "", __LINE__, __FILE__, $sql);
		}
		while ( $row = $db->sql_fetchrow($result) )
		{
			$themes_list[] = $row;
			$selected = ( $row['themes_id'] == $default_style ) ? ' selected="selected"' : '';
			$style_select .= '<option value="' . $row['themes_id'] . '"' . $selected . '>' . $row['style_name'] . '</option>';
		}
		sql_cache('write', 'themes_list', $themes_list);
	}

	$style_select .= "</select>";

	return $style_select;
}

//
// Pick a timezone
//
function tz_select($default, $select_name = 'timezone')
{
	global $sys_timezone, $lang;

	$default == ( !isset($default) ) ? $sys_timezone : $default;
	$tz_select = '<select name="' . $select_name . '">';

	while( list($offset, $zone) = @each($lang['tz']) )
	{
		$selected = ( $offset == $default ) ? ' selected="selected"' : '';
		$tz_select .= '<option value="' . $offset . '"' . $selected . '>' . $zone . '</option>';
	}
	$tz_select .= '</select>';

	return $tz_select;
}

//
// Pick a (canned) date format
//
function date_format_select($default, $timezone, $select_name = 'dateformat')
{
	global $board_config, $lang;

	// Include any valid PHP date format strings here, in your preferred order
	$date_formats = array(
		'D d M, Y',
		'D d M, Y g:i a',
		'D d M, Y H:i',
		'D d M, y',
		'D d M, y g:i a',
		'D d M, y H:i',
		'D M d, Y',
		'D M d, Y g:i a',
		'D M d, Y H:i',
		'D M d, y',
		'D M d, y g:i a',
		'D M d, y H:i',
		'd M Y h:i a',
		'd M Y h:i',
		'd M y h:i',
		'j F Y',
		'j F Y, g:i a',
		'j F Y, H:i',
		'j F y',
		'j F y, g:i a',
		'j F y, H:i',
		'Y-m-d',
		'Y-m-d, g:i a',
		'Y-m-d, H:i',
		'd-m-Y',
		'd-m-Y, g:i ',
		'd-m-Y, H:i',
		'y-m-d',
		'y-m-d, g:i a',
		'y-m-d, H:i',
		'd-m-y',
		'd-m-y, g:i a',
		'd-m-y, H:i'
	);
	@reset($lang['datetime']);
	while ( list($match, $replace) = @each($lang['datetime']) )
	{
		$translate[$match] = $replace;
	}

	$timezone == ( !isset($timezone) ) ? $board_config['board_timezone'] : $timezone;
	$df_select = '<select name="' . $select_name . '">';
	for ($i = 0; $i < sizeof($date_formats); $i++)
	{

		$format = $date_formats[$i];
        $display    = create_date($format, CR_TIME, $timezone, true);
		$selected   = (isset($default) && ($default == $format)) ? ' selected' : '';
        $df_select .= '<option value="'.$format.'"'.$selected.'>'.strtr($display, $translate).'</option>';
	}
	$df_select .= '</select>';

	return $df_select;
}

function admin_date_format_select($default, $timezone, $select_name = 'default_dateformat')
{
	global $board_config, $lang;

	// Include any valid PHP date format strings here, in your preferred order
	$date_formats = array(
		'D d M, Y',
		'D d M, Y g:i a',
		'D d M, Y H:i',
		'D d M, y',
		'D d M, y g:i a',
		'D d M, y H:i',
		'D M d, Y',
		'D M d, Y g:i a',
		'D M d, Y H:i',
		'D M d, y',
		'D M d, y g:i a',
		'D M d, y H:i',
		'd M Y h:i a',
		'd M Y h:i',
		'd M y h:i',
		'j F Y',
		'j F Y, g:i a',
		'j F Y, H:i',
		'j F y',
		'j F y, g:i a',
		'j F y, H:i',
		'Y-m-d',
		'Y-m-d, g:i a',
		'Y-m-d, H:i',
		'd-m-Y',
		'd-m-Y, g:i ',
		'd-m-Y, H:i',
		'y-m-d',
		'y-m-d, g:i a',
		'y-m-d, H:i',
		'd-m-y',
		'd-m-y, g:i a',
		'd-m-y, H:i'
	);

	@reset($lang['datetime']);
	while ( list($match, $replace) = @each($lang['datetime']) )
	{
		$translate[$match] = $replace;
	}

    $timezone  = ( !isset($timezone) ) ? $board_config['board_timezone'] : $timezone;
    $df_select = '<select name="' . $select_name . '">';
	for ($i = 0; $i < sizeof($date_formats); $i++)
	{
		$format = $date_formats[$i];
		$display    = create_date($format, CR_TIME, $timezone, true);
		$selected   = (isset($default) && ($default == $format)) ? ' selected' : '';
        $df_select .= '<option value="'.$format.'"'.$selected.'>'.strtr($display, $translate).'</option>';
	}
	$df_select .= '</select>';

	return $df_select;
}

?>