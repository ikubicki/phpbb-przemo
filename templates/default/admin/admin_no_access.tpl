	<h1>{L_ACCESS_TITLE}</h1>

<p>{L_ACCESS_EXPLAIN}</p>
<table width="100%" cellpadding="6" cellspacing="1" border="0" align="center" class="forumline">
<!-- BEGIN main_admin_list -->
<tr>
	<th colspan="2">{main_admin_list.LIST_ADMIN}</th>
</tr>
<tr>
	<td width="50%" class="row1"><span class="gen">{main_admin_list.ADMINS_LIST_E}</span></td><td width="50%" class="row2"><span class="gen"><b>{main_admin_list.ADMIN}</b></span></td>
</tr>
<form method="post" action="{S_LIST_ACTION}">
<tr>
	<td width="50%" class="row1"><span class="gen">{main_admin_list.CHANGE_LIST}</span></td><td width="50%" class="row2"><input type="text" name="list" size="30">
</td>
</tr>
</tr>
<tr>
	<td class="row1" align="center"colspan="2"><input type="submit" class="mainoption" value="{main_admin_list.SUBMIT}"></td>
</tr>
</form>
</table>
<!-- END main_admin_list -->
<br>
<br>