<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="left" class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></td>
	</tr>
</table>

<form action="{S_SUBMIT_ACTION}" method="post">
<table cellpadding="6" cellspacing="1"  width="100%" border="0">
	<tr>
		<th class="thHead" colspan="2" height="25" nowrap="nowrap">{L_GG}</th>
	</tr>
	<!-- BEGIN status -->
	<tr>
		<td class="row1" width="50%" align="right" height=33><span class="gen">{L_AIM}:</span></td>
		<td class="row1" width="50%" align="left" height=33><span class="gen"><b>{GG_NUMBER}</b></span></td>
	</tr>
	<tr>
		<td class="row1" width="50%" align="right" height=33><span class="gen">{L_STAT_GG}:</span></td>
		<td class="row1" width="50%" align="left" height=33><span class="gen">{AIM_STATUS}</span></td>
	</tr>
	<!-- END status -->
	<tr>
		<td width=50% colspan="2" class="row1" align="center" align="center" height="33"><textarea name="tresc" class="post2" onFocus="Active(this)" onBlur="NotActive(this)" rows="8" cols="70"></textarea>
	</tr>
	<tr> 
		<td height="25" colspan="2" nowrap="nowrap" width=100% class="catBottom" align="center"><input type="hidden" name="mode" value="post"><input type="hidden" name="u" value="{RECIPIENT_ID}"><input type="submit" class="mainoption" name="submit" value="{L_SUBMIT}"></th>
	</tr>
</table>
</form>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td align="right"><span class="nav"><br>{JUMPBOX}</span></td>
	</tr>
</table>
