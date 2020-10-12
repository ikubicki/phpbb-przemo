
<h1>{L_EDIT} : {MODULE_NAME}</h1>

<table width="100%" class="forumline">
	<tr>
		<th>{L_PREVIEW}</th>
	</tr>
	<tr>
		<td class="row3">
{PREVIEW_MODULE}
		</td>
	</tr>
</table>

<br>

<table class="forumline" align="center" width="80%">
	<tr>
		<td class="row3" align="center"><span class="gen">{L_PREVIEW_DEBUG_INFO}<br>{L_UPDATE_TIME_RECOMMEND}</td>
	</tr>
</table>

<br>

<table class="forumline" align="center" width="45%">
	<tr>
		<th>{L_MESSAGES}</th>
	</tr>
	<tr>
		<td class="row3"><span class="gen">{MESSAGE}</td>
	</tr>
</table>

<br>

<form action="{S_ACTION}" method="post">
<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
	  <th colspan="2">{L_EDIT}</th>
	</tr>
	<tr>
		<td class="row1" align="left" width="50%"><span class="gen">{L_ACTIVE}</span><br><span class="gensmall">{L_ACTIVE_DESC}</span></td>
		<td class="row2" align="left" width="50%"><span class="gen"><input type="radio" name="active" value="1" {ACTIVE_CHECKED_YES}>&nbsp;{L_YES}&nbsp;&nbsp;<input type="radio" name="active" value="0" {ACTIVE_CHECKED_NO}>&nbsp;{L_NO}</span></td>
	</tr>		
	<tr>
		<td class="row1" align="left" width="50%"><span class="gen">{L_UPDATE_TIME}</span><br><span class="gensmall">{L_UPDATE_TIME_DESC}</span></td>
		<td class="row2" align="left" width="50%"><span class="gen"><input type="text" name="updatetime" value="{UPDATE_TIME}"></td>
	</tr>		
	<tr>
		<td class="row1" align="left" width="50%"><span class="gen">{L_UNINSTALL}</span><br><span class="gensmall">{L_UNINSTALL_DESC}</span></td>
		<td class="row2" align="left" width="50%"><span class="gen"><input type="checkbox" name="uninstall" value="0"></td>
	</tr>
	<tr>
		<td class="row1" align="left" width="50%"><span class="gen">{L_AUTH_SETTINGS}</span></td>
		<td class="row2" align="left" width="50%"><span class="gen">{S_AUTH_SELECT}</td>
	</tr>
	<tr>
		<td class="row1" colspan="2" align="center"><span class="gen"><a href="{U_MANAGEMENT}" class="gen">{L_BACK_TO_MANAGEMENT}</a></span></td>
	</tr>
	<tr>
		<td class="submit" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption">&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption"></td>
	</tr>
</table>
</form>

<br><center><span class="copyright">{VERSION_INFO}<br>{INSTALL_INFO}</span></center>

<br>