
<h1>{L_STATS_CONFIG}</h1>

<table class="forumline" align="center" width="45%">
	<tr>
		<th class="thHead">{L_MESSAGES}</th>
	</tr>
	<tr>
		<td class="row3"><span class="gen">{MESSAGE}</td>
	</tr>
</table>

<form action="{S_ACTION}" method="post">
<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
	  <th class="thHead" colspan="2">{L_STATS_CONFIG}</th>
	</tr>
	<tr>
		<td class="row1" align="left" valign="middle" width="75%"><span class="gen">{L_RETURN_LIMIT}</span><br><span class="gensmall">{L_RETURN_LIMIT_DESC}</span></td>
		<td class="row2"><input type="text" name="return_limit_set" value="{RETURN_LIMIT}"></td>
	</tr>
	<tr>
		<td class="row1" align="left" valign="middle" width="75%"><span class="gen">{L_CLEAR_CACHE}</span><br><span class="gensmall">{L_CLEAR_CACHE_DESC}</span></td>
		<td class="row2"><input type="checkbox" name="clear_cache_set"></td>
	</tr>

	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="hidden" name="submit_update" value="1"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption">&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption"></td>
	</tr>
</table>
</form>

<!--
	This copyright information must be displayed as per the liscence you agree to by using this modification!
-->
<br><center><span class="copyright">{VERSION_INFO}<br>{INSTALL_INFO}</span></center>
<br>