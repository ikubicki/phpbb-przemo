<form method="post" action="{S_MODE_ACTION}">
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="left">&nbsp;</td>
		<td align="right">{L_USERNAME}: <b>{SEARCHED_USERNAME}</b> {L_SEARCH_MATCHES}</td>
	</tr>
</table>

<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
	<tr>
		<th class="thTop" nowrap="nowrap">{L_FORUM}</th>
		<th class="thTop" nowrap="nowrap">{L_TOPIC_TITLE}</th>
		<th class="thTop" nowrap="nowrap">{L_TOPIC_COUNT}</th>
		<th class="thTop" nowrap="nowrap">{L_TOPIC_LAST}</th>
		<th class="thTop" nowrap="nowrap">{L_AUTHOR}</th>
	</tr>
	<!-- BEGIN spy_row -->
	<tr>
		<td class="{spy_row.ROW_CLASS}" width="20%" nowrap="nowrap"><span class="gen"><a href="{spy_row.U_VIEW_FORUM}" class="forumlink">{spy_row.FORUM_NAME}</a></span></td>
		<td class="{spy_row.ROW_CLASS}" width="30%" nowrap="nowrap"><span class="gen"><a href="{spy_row.U_VIEW_TOPIC}" class="topictitle">{spy_row.TOPIC_TITLE}</a></span></td>
		<td class="{spy_row.ROW_CLASS}" width="7%" nowrap="nowrap" align="center"><span class="gen">{spy_row.VIEW_COUNT}</span></td>
		<td class="{spy_row.ROW_CLASS}" width="11%" nowrap="nowrap" align="center"><span class="postdetails">{spy_row.LAST_VIEW}</span></td>
		<td class="{spy_row.ROW_CLASS}" width="11%" nowrap="nowrap" align="center"><span class="gen">{spy_row.TOPIC_AUTHOR}</span></td>
	</tr>
	<!-- END spy_row -->
	<tr>
		<td class="catHead" colspan="2" align="left"><span class="genmed"><input type="text" name="username" value="{SEARCHED_USERNAME}" class="post" size="12" style="font-weight: bold;"> <input type="submit" name="submit" value="{L_SEARCH}" class="mainoption"></span></td>
		<td class="catHead" colspan="3" align="right">&nbsp;</td>
	</tr>
</table>
<table width="100%" cellspacing="2" cellpadding="2" border="0">
	<tr>
		<td><span class="nav">{PAGE_NUMBER}</span></td>
		<td align="right"><span class="nav">{PAGINATION}</span></td>
	</tr>
</table>
</form>
