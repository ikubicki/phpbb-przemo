<!-- BEGIN xs_file_version -->
/***************************************************************************
 *                              edit_data.tpl
 *                              -------------
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

<h1>{L_XS_EDIT_STYLES_DATA}</h1>

<p>{L_XS_EDITDATA_EXPLAIN}</p>
<script language=JavaScript src="../images/picker.js"></script>
<script language="JavaScript" type="text/javascript" src="../images/jsscripts.js"></script>
<form action="{U_ACTION}" method="post" name="pick_form">{S_HIDDEN_FIELDS}<input type="hidden" name="edit" value="{ID}" />
<table cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
<tr>
	<th colspan="3">{L_XS_EDIT_STYLES_DATA}</th>
</tr>
<tr>
		<td align="center"><span class="gen">{L_XS_EDITDATA_VAR}</span></td>
	<td class="cat" align="center"><span class="gen">{L_XS_EDITDATA_VALUE}</span></td>
	<td align="center"><span class="gen">{L_XS_EDITDATA_COMMENT}</span></td>
</tr>
<!-- BEGIN not_writable -->
<tr>
	<td class="row2" colspan="3" align="center"><span class="gen" style="color: #FF0000">{not_writable.L_NOT_WRITABLE}</span></td>
</tr>
<!-- END not_writable -->
<!-- BEGIN row -->
<tr> 
	<td class="{row.ROW_CLASS}" align="left" width="40%"><span class="gen">{row.TEXT}:</span><!-- IF row.EXPLAIN --><span class="gensmall"><br />{row.EXPLAIN}</span><!-- ENDIF --></td>
	<td class="{row.ROW_CLASS}" align="left"><input type="text" class="post" name="edit_{row.VAR}"{row.STYLE} maxlength="{row.LEN}" size="{row.SIZE}" value="{row.VALUE}" />{row.PICKER}</td>
	<!-- BEGIN name -->
	<td class="{row.ROW_CLASS}" align="left"><input type="text" class="post" name="name_{row.VAR}" maxlength="50" value="{row.name.DATA}" size="50" title="{row.name.DATA}" /></td>
	<!-- END name -->
	<!-- BEGIN noname -->
	<td class="{row.ROW_CLASS}"><span class="gen">&nbsp;</span></td>
	<!-- END noname -->
</tr>
<!-- END row -->
<tr>
	<td class="submit" colspan="3" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption"{DISABLED} /> <input type="reset" name="reset" value="{L_RESET}" class="liteoption" /></td>
</tr>
</table>
</form>
<br />