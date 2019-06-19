<!-- BEGIN xs_file_version -->
/***************************************************************************
 *                                styles.tpl
 *                                ----------
 *   copyright            : (C) 2003 - 2005 CyberAlien
 *   support              : http://www.phpbbstyles.com
 *
 *   version              : 2.2.0
 *
 *   file revision        : 55
 *   project revision     : 66
 *   last modified        : 09 Mar 2005  14:49:49
 *
 ***************************************************************************/
<!-- END xs_file_version -->

<h1>{L_XS_DEF_TITLE}</h1>

<p>{L_XS_DEF_EXPLAIN}</p>

<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
	<tr>
		<th class="thCornerL" align="center" nowrap="nowrap">{L_XS_ID}</th>
		<th class="thTop" align="center" nowrap="nowrap">{L_XS_STYLE}</th>
		<th class="thTop" align="center" nowrap="nowrap">{L_XS_TEMPLATE}</th>
		<th class="thTop" align="center" nowrap="nowrap">{L_XS_USERS}</th>
		<th class="thCornerR" colspan="2" align="center" nowrap="nowrap">{L_XS_OPTIONS}</th>
	</tr>
	<!-- BEGIN styles -->
	<tr>
		<td class="{styles.ROW_CLASS}" align="center"><span class="gen"><!-- BEGIN default --><b><!-- END default -->{styles.ID}<!-- BEGIN default --></b><!-- END default --></span></td>
		<td class="{styles.ROW_CLASS}" align="left" nowrap="nowrap"><span class="gen"><!-- BEGIN default --><b><!-- END default -->{styles.STYLE}<!-- BEGIN default --></b><!-- END default --></span></td>
		<td class="{styles.ROW_CLASS}" align="left" nowrap="nowrap"><span class="gen"><!-- BEGIN default --><b><!-- END default -->{styles.TEMPLATE}<!-- BEGIN default --></b><!-- END default --></span></td>
		<td class="{styles.ROW_CLASS}" align="center"><!-- BEGIN default --><b><!-- END default -->{styles.TOTAL}<!-- BEGIN default --></b><!-- END default --></td>
		<td class="{styles.ROW_CLASS}" align="center" valign="middle" nowrap="nowrap">
		<span class="gensmall">
			<!-- BEGIN default -->
				<!-- BEGIN override -->
					[<a href="{styles.U_OVERRIDE}">{L_XS_STYLES_NO_OVERRIDE}</a>]
				<!-- END override -->
				<!-- BEGIN nooverride -->
					[<a href="{styles.U_OVERRIDE}">{L_XS_STYLES_DO_OVERRIDE}</a>]
				<!-- END nooverride -->
			<!-- END default -->
			<!-- BEGIN nodefault -->
				[<a href="{styles.U_DEFAULT}">{L_XS_STYLES_SET_DEFAULT}</a>]
				<!-- BEGIN admin_only -->
				[<a href="{styles.nodefault.admin_only.U_CHANGE}">{L_XS_STYLES_MAKE_PUBLIC}</a>]
				<!-- END admin_only -->
				<!-- BEGIN public -->
				[<a href="{styles.nodefault.public.U_CHANGE}">{L_XS_STYLES_MAKE_ADMIN}</a>]
				<!-- END public -->
			<!-- END nodefault -->
			<br />
			[<a href="{styles.U_SWITCHALL}">{L_XS_STYLES_SWITCH_ALL}</a>]
		</span></td>
		<td class="{styles.ROW_CLASS}" align="center" valign="middle" nowrap="nowrap"><span class="gensmall">
			<!-- BEGIN total -->
			<form action="{U_SCRIPT}" method="get" name="select_{styles.ID}" onsubmit="if(document.select_{styles.ID}.style.value == -1){return false;}" style="display: inline;">{S_HIDDEN_FIELDS}<input type="hidden" name="moveaway" value="{styles.ID}" />
			<select name="movestyle" onchange="document.select_{styles.ID}.submit();">
			<option value="">{L_XS_STYLES_SWITCH_ALL2}</option>
			<option value="{styles.DEF_STYLE}">{L_XS_STYLES_DEFSTYLE}</option>
			<optgroup label="{L_XS_STYLES_AVAILABLE}">
			<?php
				for($i=0; $i<$styles_count; $i++)
				if($i != $styles_i)
				{
					$item = &$this->_tpldata['styles.'][$i];
					echo '<option value="', $item['ID'], '">', $item['STYLE'], '</option>';
				}
			?>
			</optgroup>
			</select>
			</form>
		<!-- END total -->
		<!-- BEGIN none -->
		&nbsp;
		<!-- END none -->
		</span></td>
	</tr>
	<!-- END styles -->
</table>

<br />
