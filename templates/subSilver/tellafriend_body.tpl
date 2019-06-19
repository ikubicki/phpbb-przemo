
<table width="100%" cellspacing="2" cellpadding="2" border="0">
	<tr>
		<td align="left" valign="bottom" nowrap><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
	</tr>
</table>
<table class="forumline" border="0" cellpadding="3" cellspacing="1" width="100%" align="center">
	<tr>
		<th class="thHead">{L_TELLFRIEND_TITLE}</th>
	</tr>
	<tr>
		<td class="row1"><br><br><form action="{SUBMIT_ACTION}" method="post">
			<table width="70%" align="center">
				<tr>
					<td><span class="nav">{L_TELLFRIEND_NAME}</span></td>
					<td><input type="text" name="friendname" size="25" maxlength="100" class="post" onFocus="Active(this)" onBlur="NotActive(this)" ></td>
				</tr>
				<tr>
					<td><span class="nav">{L_TELLFRIEND_EMAIL}</span></td>
					<td><input type="text" name="friendemail" size="25" maxlength="100" class="post" onFocus="Active(this)" onBlur="NotActive(this)" ></td>
				</tr>
				<tr>
					<td valign=top><span class="nav">{L_TELLFRIEND_MESSAGE}</span></td>
					<td><textarea name="message" rows="10" cols="50" class="post" onFocus="Active(this)" onBlur="NotActive(this)">{TELLFRIEND_MESSAGE}</textarea></td>
				</tr>
					<input type="hidden" name="topic_id" value="{TOPIC_ID}">
			</table>
			<br>
			<center>
			<input type="submit" name="submit" class="mainoption" value="{L_TELLFRIEND_SEND}">
			</center>
			</form>
			<br></td>
	</tr>
	<tr>
		<td height="28" class="catBottom">&nbsp;</td>
	</tr>
</table>

