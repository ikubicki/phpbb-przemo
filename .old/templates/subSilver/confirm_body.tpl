<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0">
	<tr>
		<th height="25" valign="middle"><span class="tableTitle">{MESSAGE_TITLE}</span></th>
	</tr>
	<tr>
		<td class="row1" align="center"><form action="{S_CONFIRM_ACTION}" method="post"><span class="gen"><br>{MESSAGE_TEXT}<br><br>{S_HIDDEN_FIELDS}<input type="submit" name="confirm" value="{L_YES}" class="mainoption">&nbsp;&nbsp;<input type="submit" name="cancel" value="{L_NO}" class="liteoption"></span></form>
			<!-- BEGIN forum_trash -->
			<br><br>
			<form action="{S_CONFIRM_ACTION}" method="post">
			<input type="submit" name="confirm" value="{forum_trash.L_TRASH}" class="liteoption">
			<input type="hidden" name="new_forum" value="{forum_trash.FORUM_TRASH_ID}">
			<input type="hidden" name="f" value="{forum_trash.OLD_FORUM_ID}">
			<input type="hidden" name="t" value="{forum_trash.TOPIC_ID}">
			<input type="hidden" name="sid" value="{forum_trash.SESSION_ID}">
			<input type="hidden" name="mode" value="move">
			</form>
			<br>
			<!-- END forum_trash -->		
		</td>
	</tr>
</table>

<br clear="all">
