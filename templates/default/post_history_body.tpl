<h1>{L_POST_HISTORY_TITLE}</h1>
<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0">
	<tr>
		<th width="25%" class="label">{L_TOPIC}: <a href="{U_TOPIC_URL}">{TOPIC_TITLE}</a></th>
		<th width="15%" class="label">{L_AUTHOR}: {POST_POSTER}</th>
		<th width="25%" class="label">{L_POST_TIME}: {POST_TIME}</th>
		<th width="3%" class="label">ID: {POST_ID}</th>
		<th width="10%" class="label center">{L_EDITED_BY}</th>
		<th width="10%" class="label center">{L_EDITED_TIME}</th>
	</tr>

	<!-- BEGIN postrow -->
	<tr>
		<td class="{postrow.ROW_CLASS}" colspan="4"><span class="postbody">{postrow.MESSAGE}</span></td>
		<td class="{postrow.ROW_CLASS}" align="center" valign="top"><a href="{postrow.EDITED_BY_URL}">{postrow.EDITED_BY_USERNAME}</a></td>
		<td class="{postrow.ROW_CLASS}" align="center" valign="top"><span class="gensmall">{postrow.EDITED_TIME}</span></td>
	</tr>
	<!-- END postrow -->
	<tr>
		<td colspan="4" align="left"><span class="nav"><a href="{U_BACK_TO_POST}">{L_BACK_TO_POST}</a></span></td>
		<td colspan="2" align="right">{DELETE_IMG}</td>
	<tr>
</table>
