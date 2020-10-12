<br>
<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0">
	<tr>
		<th align="center" colspan="6">{L_POST_HISTORY_TITLE}</th>
	<tr>
		<td align="center" width="25%"><span class="nav">{L_TOPIC}: <a href="{U_TOPIC_URL}">{TOPIC_TITLE}</a></span></td>
		<td align="center" width="15%" nowrap="nowrap"><span class="nav">{L_AUTHOR}: {POST_POSTER}</span></td>
		<td align="center" width="25%"><span class="genmed"> {L_POST_TIME}: {POST_TIME}</span></td>
		<td align="center" width="3%" nowrap="nowrap"><span class="nav">ID: {POST_ID}</span></td>
		<td align="center" width="10%" nowrap="nowrap"><span class="nav">{L_EDITED_BY}</span></td>
		<td align="center" width="10%" nowrap="nowrap"><span class="nav">{L_EDITED_TIME}</span></td>
	</tr>

	<!-- BEGIN postrow -->
	<tr>
		<td class="{postrow.ROW_CLASS}" colspan="4">{postrow.MESSAGE}</td>
		<td class="{postrow.ROW_CLASS}" align="center" valign="top"><a href="{postrow.EDITED_BY_URL}">{postrow.EDITED_BY_USERNAME}</a></td>
		<td class="{postrow.ROW_CLASS}" align="center" valign="top"><span class="gensmall">{postrow.EDITED_TIME}</span></td>
	</tr>
	<!-- END postrow -->
	<tr>
		<td colspan="4" align="left"><span class="nav"><a href="{U_BACK_TO_POST}">{L_BACK_TO_POST}</a></span></td>
		<td colspan="2" align="right">{DELETE_IMG}</td>
	<tr>
</table>
