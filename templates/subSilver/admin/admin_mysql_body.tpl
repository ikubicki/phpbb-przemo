<table width="100%" cellpadding="8" cellspacing="1" border="0" class="forumline">
	<tr>
		<th class="thHead" height="25" colspan="4">MySQL</th>
	</tr>
	<tr>
		<td class="row1"><span class="gensmall">{MYSQL_E}</span>
		</td>
	</tr>
</table>
<br>
<center>
<form action="{MYSQL_ACTION}" method="post">
<table width="100%" cellpadding="8" cellspacing="1" border="0" class="forumline">
	<tr>
		<td class="catBottom" align="center" height="28" colspan="6"><span class="gen"><b>{L_DO_QUERY}</b></span></td>
	</tr>
	<tr>
		<td align="center" class="row1" colspan="6"><span class="gensmall">{L_QUERY_E}<br></span><textarea name="this_query" rows="10" cols="80" style="width:650px" tabindex="3" class="post">{THIS_QUERY}</textarea><br><br><input type="submit" value="{L_SUBMIT}" name="query_submit" class="liteoption"><br></td>
	</tr>
</table>
</form>

<br>

<!-- BEGIN result -->
<table width="100%" cellpadding="8" cellspacing="1" border="0" class="forumline">
	<tr>
		<th>{result.L_RESULT}</th>
	</tr>
	<tr>
		<td class="row1" align="center"><span class="genmed">{result.INFO}</span></td>
	</tr>
</table>

<table width="100%" cellpadding="8" cellspacing="1" border="0" class="forumline">
{result.BODY}
</table>
<br>

<br>
<!-- END result -->

</center>
<br>