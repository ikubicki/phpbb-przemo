<?php

/***************************************************************************
 *                              xs_edit_data.php
 *                              ----------------
 *   copyright            : (C) 2003 - 2005 CyberAlien
 *   support              : http://www.phpbbstyles.com
 *
 *   version              : 2.2.0
 *
 *   file revision        : 65
 *   project revision     : 66
 *   last modified        : 09 Mar 2005  14:49:49
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
define('MODULE_ID', 6);
define('IN_PHPBB', 1);
$phpbb_root_path = "./../";
$no_page_header = true;
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

// check if mod is installed
if(empty($template->xs_version) || $template->xs_version !== 7)
{
	message_die(GENERAL_ERROR, 'eXtreme Styles mod is not installed. You forgot to upload includes/template.php');
}

define('IN_XS', true);
include_once('xs_include.' . $phpEx);

$template->assign_block_vars('nav_left',array('ITEM' => '&raquo; <a href="' . append_sid('xs_edit_data.'.$phpEx) . '">' . $lang['xs_edit_styles_data'] . '</a>'));

$lang['xs_edittpl_back_list'] = str_replace('{URL}', append_sid('xs_edit_data.'.$phpEx), $lang['xs_edittpl_back_list']);

if ( !(function_exists('xs_empty_name')) )
{
	function xs_empty_name()
	{
		global $db;
		$sql = "SELECT * FROM " . THEMES_NAME_TABLE . " LIMIT 0, 1";
		if(!$result = $db->sql_query($sql))
		{
			$data = array();
		}
		$data = $db->sql_fetchrow($result);
		if($data === false || !@count($data))
		{
			$data = array(
				'themes_id'	=> 0,
				'tr_color1_name'	=> '',
				'tr_color2_name'	=> '',
				'tr_color3_name'	=> '',
				'tr_color_helped_name'	=> '',
				'tr_class1_name'	=> '',
				'tr_class2_name'	=> '',
				'tr_class3_name'	=> '',
				'th_color1_name'	=> '',
				'th_color2_name'	=> '',
				'th_color3_name'	=> '',
				'th_class1_name'	=> '',
				'th_class2_name'	=> '',
				'th_class3_name'	=> '',
				'td_color1_name'	=> '',
				'td_color2_name'	=> '',
				'td_color3_name'	=> '',
				'td_class1_name'	=> '',
				'td_class2_name'	=> '',
				'td_class3_name'	=> '',
				'fontface1_name'	=> '',
				'fontface2_name'	=> '',
				'fontface3_name'	=> '',
				'fontsize1_name'	=> '',
				'fontsize2_name'	=> '',
				'fontsize3_name'	=> '',
				'fontcolor1_name'	=> '',
				'fontcolor2_name'	=> '',
				'fontcolor3_name'	=> '',
				'fontcolor_admin_name'	=> '',
				'fontcolor_jradmin_name'	=> '',
				'fontcolor_mod'	=> '',
				'span_class1_name'	=> '',
				'span_class2_name'	=> '',
				'span_class3_name'	=> ''
			);

		}
		$arr = array();
		foreach($data as $var => $value)
		{
			if($var !== 'themes_id')
			{
				$arr[$var] = '';
			}
		}
		return $arr;
	}
}

if ( !(function_exists('xs_get_vars')) )
{
	function xs_get_vars($theme)
	{
		$arr1 = array();
		$arr2 = array();
		$vars_100 = array('head_stylesheet', 'body_background');
		$vars_50 = array('fontface');
		$vars_30 = array('style_name');
		$vars_25 = array('tr_class', 'th_class', 'td_class', 'span_class');
		$vars_6 = array('body_bgcolor', 'body_text', 'body_link', 'body_vlink', 'body_alink', 'body_hlink', 'tr_color', 'th_color', 'td_color', 'fontcolor');
		$vars_5 = array('img_size_poll', 'img_size_privmsg');
		$vars_4 = array('fontsize', 'theme_public');
		foreach($theme as $var => $value)
		{
			if(!is_integer($var) && $var !== 'themes_id' && $var !== 'template_name')
			{
				// editable variable
				$len = 0;
				$sub = substr($var, 0, strlen($var) - 1);
				if(xs_in_array($var, $vars_100) || xs_in_array($sub, $vars_100))
				{
					$len = 100;
				}
				elseif(xs_in_array($var, $vars_50) || xs_in_array($sub, $vars_50))
				{
					$len = 50;
				}
				elseif(xs_in_array($var, $vars_30) || xs_in_array($sub, $vars_30))
				{
					$len = 30;
				}
				elseif(xs_in_array($var, $vars_25) || xs_in_array($sub, $vars_25))
				{
					$len = 25;
				}
				elseif(xs_in_array($var, $vars_6) || xs_in_array($sub, $vars_6))
				{
					$len = 6;
				}
				elseif(xs_in_array($var, $vars_5) || xs_in_array($sub, $vars_5))
				{
					$len = 5;
				}
				elseif(xs_in_array($var, $vrs_4) || xs_in_array($sub, $vars_4))
				{
					$len = 4;
				}
				elseif(strpos($var, 'class'))
				{
					$len = 25;
				}
				elseif(strpos($var, 'color'))
				{
					$len = 6;
				}
				if($len)
				{
					$item = array(
						'var'		=> $var,
						'len'		=> $len,
						'color'		=> $len == 6 ? true : false,
						'font'		=> $len == 25 ? true : false,
						);
					if($var === 'style_name' || $var === 'head_stylesheet' || $var === 'body_background')
					{
						$arr1[$var] = $item;
					}
					else
					{
						$arr2[$var] = $item;
					}
				}
			}
		}
		krsort($arr1);
		ksort($arr2);
		if(defined('XS_MODS_CATEGORY_HIERARCHY210'))
		{
			// force sort for the added fields
			$added = array(
				'style_name' => array(),
				'images_pack' => array('var' => $item['images_pack'], 'len' => 100, 'color' => false, 'font' => false),
				'custom_tpls' => array('var' => $item['custom_tpls'], 'len' => 100, 'color' => false, 'font' => false),
				'head_stylesheet' => array(),
			);
			$arr1 = array_merge($added, $arr1);
			// we need to add lang entries
			global $lang;
			$lang['xs_data_images_pack'] = $lang['Images_pack'];
			$lang['xs_data_images_pack_explain'] = $lang['Images_pack_explain'];
			$lang['xs_data_custom_tpls'] = $lang['Custom_tpls'];
			$lang['xs_data_custom_tpls_explain'] = $lang['Custom_tpls_explain'];
		}
		return array_merge($arr1, $arr2);
	}
}

//
// submit
//
if(!empty($HTTP_POST_VARS['edit']) && !defined('DEMO_MODE'))
{
	$id = intval($HTTP_POST_VARS['edit']);
	$lang['xs_edittpl_back_edit'] = str_replace('{URL}', append_sid('xs_edit_data.'.$phpEx.'?edit='.$id), $lang['xs_edittpl_back_edit']);
	$data_item = array();
	$data_item_update = array();
	$data_name = array();
	$data_name_insert_vars = array('themes_id');
	$data_name_insert_values = array($id);
	$data_name_update = $data_name_update_tpl = $data_value_update_tpl = array();
	$no_color_array = array('style_name', 'head_stylesheet', 'body_background', 'tr_class1', 'tr_class2', 'tr_class3', 'th_class1', 'th_class2', 'th_class3', 'td_class1', 'td_class2', 'td_class3', 'fontface1', 'fontface2', 'fontface3', 'fontsize1', 'fontsize2', 'fontsize3', 'span_class1', 'span_class2', 'span_class3', 'img_size_poll', 'img_size_privmsg');

	foreach($HTTP_POST_VARS as $var => $value)
	{
		if(substr($var, 0, 5) === 'edit_')
		{
			$var = substr($var, 5);
			$value = stripslashes($value);
			$data_item[$var] = $value;
			$data_item_update[] = $var . "='" . xs_sql($value) . "'";
		}
		elseif(substr($var, 0, 5) === 'name_')
		{
			$var = substr($var, 5).'_name';
			$value = stripslashes($value);
			$data_name[$var] = $value;
			$data_name_update[] = $var . "='" . xs_sql($value) . "'";
			$data_name_insert_vars[] = $var;
			$data_name_insert_values[] = xs_sql($value);
		}
		$tpl_var = '{T_' . strtoupper(str_replace('edit_', '', $var)) . '}';
		$data_name_update_tpl[] = $tpl_var;
		$data_value_update_tpl[] = (in_array($var, $no_color_array)) ? $value : '#' . $value;
	}

	$edit_head_stylesheet = trim($HTTP_POST_VARS['edit_head_stylesheet']);
	$edit_style_name = trim($HTTP_POST_VARS['edit_style_name']);
	if ( strpos($edit_style_name, ' ') )
	{
		$edit_style_name = substr($edit_style_name, 0, strpos($edit_style_name, ' '));
	}

	$file = $phpbb_root_path . 'templates/' . $edit_style_name . '/' . str_replace('.css', '', $edit_head_stylesheet) . '.tps';
	$css_file = $phpbb_root_path . 'templates/' . $edit_style_name . '/' . $edit_head_stylesheet;

	if ( !function_exists('file_get_contents') )
	{
		function file_get_contents($filename)
		{
			$file = @fopen($filename, 'rb');
			if ( $file )
			{
				if ( $fsize = @filesize($filename) )
				{
					$data = @fread($file, $fsize);
				}
				else
				{
					$data = '';
					while (!@feof($file))
					{
						$data .= @fread($file, 1024);
					}
				}
				@fclose($file);
			}
			return $data;
		}
	} 

	if ( !($css_content = file_get_contents($file)) )
	{
		xs_message($lang['Information'], sprintf($lang['xs_edittpl_failed_open_file'], str_replace('./../', '/', $file)) . '<br /><br />' . $lang['xs_edittpl_back_edit'] . '<br /><br />' . $lang['xs_edittpl_back_list']);
	}

	if ( !($fp = fopen($css_file, 'w')) )
	{
		xs_message($lang['Information'], sprintf($lang['xs_edittpl_failed_open_file'], str_replace('./../', '/', $css_file)) . '<br /><br />' . $lang['xs_edittpl_back_edit'] . '<br /><br />' . $lang['xs_edittpl_back_list']);
	}
	if ( !(fwrite($fp, str_replace($data_name_update_tpl, $data_value_update_tpl, $css_content))) )
	{
		xs_message($lang['Information'], sprintf($lang['xs_edittpl_failed_open_file_css'], str_replace('./../', '/', $css_file)) . '<br /><br />' . $lang['xs_edittpl_back_edit'] . '<br /><br />' . $lang['xs_edittpl_back_list']);
	}
	@fclose($fp);

	// update item
	$sql = "UPDATE " . THEMES_TABLE . " SET " . implode(',', $data_item_update) . " WHERE themes_id='{$id}'";
	if(!$result = $db->sql_query($sql))
	{
		xs_error($lang['xs_edittpl_error_updating'] . '<br /><br />' . $lang['xs_edittpl_back_edit'] . '<br /><br />' . $lang['xs_edittpl_back_list'], __LINE__, __FILE__);
	}

	sql_cache('clear', 'themes_list');
	sql_cache('clear', 'multisqlcache_themes');

	// check if there is name
	$sql = "SELECT themes_id FROM " . THEMES_NAME_TABLE . " WHERE themes_id='{$id}'";
	if(!$result = $db->sql_query($sql))
	{
		$sql = "INSERT INTO " . THEMES_NAME_TABLE . " (" . implode(',', $data_name_insert_vars) . ") VALUES ('" . implode("', '", $data_name_insert_values) . "')";
	}
	$item = $db->sql_fetchrow($result);
	if(!is_array($item))
	{
		$sql = "INSERT INTO " . THEMES_NAME_TABLE . " (" . implode(',', $data_name_insert_vars) . ") VALUES ('" . implode("', '", $data_name_insert_values) . "')";
	}
	else
	{
		$sql = "UPDATE " . THEMES_NAME_TABLE . " SET " . implode(',', $data_name_update) . " WHERE themes_id='{$id}'";
	}
	$db->sql_query($sql);

	// regen themes cache
	if(defined('XS_MODS_CATEGORY_HIERARCHY210'))
	{
		if ( empty($themes) )
		{
			$themes = new themes();
		}
		if ( !empty($themes) )
		{
			$themes->read(true);
		}
	}
	xs_message($lang['Information'], $lang['xs_edittpl_style_updated'] . '<br /><br />' . $lang['xs_edittpl_back_edit'] . '<br /><br />' . $lang['xs_edittpl_back_list']);
}

//
// edit style
//
if(!empty($HTTP_GET_VARS['edit']))
{
	$id = intval($HTTP_GET_VARS['edit']);
	$sql = "SELECT * FROM " . THEMES_TABLE . " WHERE themes_id='{$id}'";
	if(!$result = $db->sql_query($sql))
	{
		xs_error($lang['xs_no_style_info'], __LINE__, __FILE__);
	}
	$item = $db->sql_fetchrow($result);
	if(empty($item['themes_id']))
	{
		xs_error($lang['xs_invalid_style_id'] . '<br /><br />' . $lang['xs_edittpl_back_list']);
	}
	$sql = "SELECT * FROM " . THEMES_NAME_TABLE . " WHERE themes_id='{$id}'";
	if(!$result = $db->sql_query($sql))
	{
		$item_name = array();
	}
	$item_name = $db->sql_fetchrow($result);
	if($item_name === false || !@count($item_name))
	{
		$item_name = xs_empty_name();
	}
	$vars = xs_get_vars($item);

	if ( !is_writable($phpbb_root_path . 'templates/' . $item['template_name'] . '/' . $item['head_stylesheet']) )
	{
		$template->assign_vars(array(
			'DISABLED' => ' disabled="disabled"')
		);
		$template->assign_block_vars('not_writable', array(
			'L_NOT_WRITABLE' => sprintf($lang['xs_edittpl_failed_open_file_css'], 'templates/' . $item['template_name'] . '/' . $item['head_stylesheet']))
		);
	}
	// show variables
	$template->assign_vars(array(
		'U_ACTION'	=> append_sid('xs_edit_data.'.$phpEx),
		'TPL'		=> xhtmlspecialchars($item['template-name']),
		'STYLE'		=> xhtmlspecialchars($item['style_name']),
		'ID'		=> $id
		)
	);
	// all variables
	$i = 0;

	foreach($vars as $var => $value)
	{
		$row_class = $xs_row_class[$i % 2];
		$i++;
		if(isset($lang['xs_data_'.$var]))
		{
			$text = $lang['xs_data_'.$var];
		}
		else
		{
			$str = substr($var, 0, strlen($var) - 1);
			if(isset($lang['xs_data_'.$str]))
			{
				$str1 = substr($var, strlen($var) - 1);
				$text = sprintf($lang['xs_data_'.$str], $str1);
			}
			else
			{
				$text = sprintf($lang['xs_data_unknown'], $var);
			}
		}
		$picker = '&nbsp;<a href="javascript:TCP.popup(document.forms[\'pick_form\'].elements[\'edit_' . $var . '\'])"><img src="../images/sel.gif" border="0" />';

		$bgcol = ($item[$var] == 'FFFFFF') ? ' background-color: #000000;' : '';
		$template->assign_block_vars('row', array(
			'PICKER' => ($value['len'] == 6) ? $picker : '',
			'ROW_CLASS'	=> $row_class,
			'VAR'	=> $var,
			'STYLE' => ($value['len'] == 6) ? ' style="font-weight: bold; color: #' . $item[$var] . '; ' . $bgcol . '" onKeyup="chng(this);"' : '',
			'VALUE'	=> isset($item[$var]) ? xhtmlspecialchars($item[$var]) : '',
			'LEN'	=> $value['len']+1,
			'SIZE'	=> $value['len'] < 10 ? 10 : 30,
			'TEXT'	=> xhtmlspecialchars($text),
			'EXPLAIN' => isset($lang['xs_data_' . $var . '_explain']) ? $lang['xs_data_' . $var . '_explain'] : '',
			)
		);
		if($value['color'])
		{
			$template->assign_block_vars('row.color', array());
		}
		if($value['font'])
		{
			$template->assign_block_vars('row.font', array());
		}
		if(isset($item_name[$var.'_name']))
		{
			$template->assign_block_vars('row.name', array(
				'DATA'	=> $item_name[$var.'_name']
				)
			);
		}
		else
		{
			$template->assign_block_vars('row.noname', array());
		}
	}
	$template->set_filenames(array('body' => XS_TPL_PATH . 'edit_data.tpl'));
	$template->pparse('body');
	xs_exit();
}


//
// show list of installed styles
//
$sql = 'SELECT themes_id, template_name, style_name FROM ' . THEMES_TABLE . ' ORDER BY style_name';
if(!$result = $db->sql_query($sql))
{
	xs_error($lang['xs_no_style_info'], __LINE__, __FILE__);
}
$style_rowset = $db->sql_fetchrowset($result);

$template->set_filenames(array('body' => XS_TPL_PATH . 'edit_data_list.tpl'));
for($i=0; $i<count($style_rowset); $i++)
{
	$item = $style_rowset[$i];
	$row_class = $xs_row_class[$i % 2];
	$template->assign_block_vars('styles', array(
		'ROW_CLASS'		=> $row_class,
		'TPL'			=> xhtmlspecialchars($item['template_name']),
		'STYLE'			=> xhtmlspecialchars($item['style_name']),
		'U_EDIT'		=> append_sid('xs_edit_data.'.$phpEx.'?edit='.$item['themes_id'])
		)
	);
}

$template->pparse('body');
xs_exit();

?>