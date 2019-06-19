<!-- BEGIN xs_file_version -->
/***************************************************************************
 *                                clone2.tpl
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

<h1>{L_XS_CLONE_STYLE}</h1>

<p>{L_XS_CLONE_STYLE_EXPLAIN}</p>


<table width="100%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
		<th class="thHead" colspan="2">{L_XS_CLONE_STYLE}</th>
	</tr>
	<tr>
		<td class="explain" colspan="2" align="left">{L_XS_CLONE_STYLE_EXPLAIN4}</td>
	</tr>
	<form action="{FORM_ACTION}" name="clone" method="post"><input type="hidden" name="clone_tpl" value="{CLONE_TEMPLATE}" />{S_HIDDEN_FIELDS}
	<tr>
		<td class="row1">{L_XS_CLONE_NEWDIR_NAME}</td>
		<td class="row2"><input type="text" class="post" name="clone_style_name" value="{CLONE_TEMPLATE}" size="30" <!-- BEGIN switch_onchange --> onkeyup="document.clone.clone_style_name_0.value=document.clone.clone_style_name.value" <!-- END switch_onchange --> /></td>
	</tr>
	<!-- BEGIN switch_select_style -->
	<tr>
		<td class="row1">{L_XS_CLONE_SELECT}<br /><span class="gensmall">{L_XS_CLONE_SELECT_EXPLAIN}</span></td>
		<td class="row2" nowrap="nowrap">
			<!-- BEGIN style -->
			<input type="hidden" name="clone_style_id_{switch_select_style.style.NUM}" value="{switch_select_style.style.ID}" />
			<input type="checkbox" name="clone_style_{switch_select_style.style.NUM}" checked="checked" />
			<input type="text" class="post" name="clone_style_name_{switch_select_style.style.NUM}" value="{switch_select_style.style.NAME}" title="{switch_select_style.style.NAME}" size="30" /><br />
			<!-- END style -->
		</td>
	</tr>
	<!-- END switch_select_style -->
	<!-- BEGIN switch_select_nostyle -->
	<tr>
		<td class="row1">{L_XS_CLONE_NEWNAME}</td>
		<td class="row2" nowrap="nowrap">
			<input type="hidden" name="clone_style_id_0" value="{STYLE_ID}" />
			<input type="hidden" name="clone_style_0" value="checked" />
			<input type="text" class="post" name="clone_style_name_0" value="{STYLE_NAME}" title="{STYLE_NAME}" size="30" />
		</td>
	</tr>
	<!-- END switch_select_nostyle -->
	<input type="hidden" name="total" value="{TOTAL}" />
	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" /></td>
	</tr>
	</form>
</table>
