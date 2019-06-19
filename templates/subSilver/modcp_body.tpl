<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<form name="modcpForm" id="modcpForm" method="post" action="{S_MODCP_ACTION}">
	<tr>
		<td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a>{NAV_CAT_DESC}</span></td>
	</tr>
</table>

<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
	<tr>
		<td class="catHead" colspan="5" align="center" height="28"><span class="cattitle">{L_MOD_CP}</span></td>
	</tr>
	<tr>
		<td class="spaceRow" colspan="5" align="center"><span class="gensmall">{L_MOD_CP_EXPLAIN}</span></td>
	</tr>
	<tr>
		<th width="4%" class="thLeft" nowrap="nowrap">&nbsp;</th>
		<th nowrap="nowrap">&nbsp;{L_TOPICS}&nbsp;</th>
		<th width="8%" nowrap="nowrap">&nbsp;{L_REPLIES}&nbsp;</th>
		<th width="17%" nowrap="nowrap">&nbsp;{L_LASTPOST}&nbsp;</th>
		<th width="5%" class="thRight" nowrap="nowrap">&nbsp;{L_SELECT}&nbsp;</th>
	</tr>
	<!-- BEGIN topicrow -->
	<tr>
		<td class="row1" align="center" valign="middle"><img src="{topicrow.TOPIC_FOLDER_IMG}" alt="{topicrow.L_TOPIC_FOLDER_ALT}" title="{topicrow.L_TOPIC_FOLDER_ALT}"></td>
		<td class="row1">&nbsp;<span class="topictitle">{topicrow.TOPIC_TYPE}{topicrow.TOPIC_ATTACHMENT_IMG}<a href="{topicrow.U_VIEW_TOPIC}" title="{topicrow.L_TOPIC_STARTED}: {topicrow.FIRST_POST_TIME}" class="topictitle">{topicrow.TOPIC_TITLE}</a></span></td>
		<td class="row2" align="center" valign="middle"><span class="postdetails">{topicrow.REPLIES}</span></td>
		<td class="row1" align="center" valign="middle"><span class="postdetails">{topicrow.LAST_POST_TIME}</span></td>
		<td class="row2" align="center" valign="middle"><input type="checkbox" name="topic_id_list[]" value="{topicrow.TOPIC_ID}"></td>
	</tr>
	<!-- END topicrow -->
	<tr align="right">
		<td class="catBottom" colspan="5" height="29">{S_HIDDEN_FIELDS} 
		<!-- BEGIN switch_auth_delete -->
		<input type="submit" name="delete" class="liteoption" value="{L_DELETE}">&nbsp;
		<!-- END switch_auth_delete -->
		<input type="submit" name="move" class="liteoption" value="{L_MOVE}">&nbsp;
		<input type="submit" name="mergetopic" class="liteoption" value="{L_MERGE}">&nbsp;
		<input type="submit" name="lock" class="liteoption" value="{L_LOCK}">&nbsp;
		<input type="submit" name="unlock" class="liteoption" value="{L_UNLOCK}">
		<!-- BEGIN switch_auth_sticky -->
		&nbsp;&nbsp;<input type="submit" name="sticky" class="liteoption" value="{L_STICKY}">&nbsp;
		<!-- END switch_auth_sticky -->
		<!-- BEGIN switch_auth_announce -->
		<input type="submit" name="announce" class="liteoption" value="{L_ANNOUNCE}">&nbsp;
		<!-- END switch_auth_announce -->
		<input type="submit" name="normalise" class="liteoption" value="{L_NORMALISE}">&nbsp;&nbsp;
		<span class="gensmall"><a href="#" onclick="setCheckboxes('modcpForm', 'topic_id_list[]', true); return false;">{L_CHECK_ALL}</a>&nbsp;<a href="#" onclick="setCheckboxes('modcpForm', 'topic_id_list[]', false); return false;">{L_UNCHECK_ALL}</a></span></td>
	</tr>
</table>

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr>
		<td align="left" valign="middle"><span class="nav"><a href="{S_RESYNC}">{L_RESYNC}</a><br>{PAGE_NUMBER}</b></span></td>
		<td align="right" valign="top" nowrap="nowrap"><span class="gensmall">{S_TIMEZONE}</span><br><span class="nav">{PAGINATION}</span></td>
	</tr>
	</form>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="right">{JUMPBOX}</td>
	</tr>
</table>
