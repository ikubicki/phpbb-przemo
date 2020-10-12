
<h1>{L_CONFIGURATION_TITLE}</h1>

<p>{L_CONFIGURATION_EXPLAIN}</p>

<form action="{S_CONFIG_ACTION}" method="post"><table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
	  <th colspan="2">{L_SETUP_SHOUTBOX}</th>
	</tr>
	<tr>
		<td class="row1">{L_SHOUTBOX_ON}</td>
		<td class="row2"><input type="radio" name="shoutbox_on" value="1" {SHOUTBOX_ON_YES} /> {L_YES} <input type="radio" name="shoutbox_on" value="0" {SHOUTBOX_ON_NO} /> {L_NO}</td>
	</tr>
	<tr> 
		<td class="row1">{L_DATE_ON}</td> 
		<td class="row2"><input type="radio" name="date_on" value="1" {DATE_ON_YES} /> {L_YES} <input type="radio" name="date_on" value="0" {DATE_ON_NO} /> {L_NO}</td> 
	</tr> 
	<tr>
		<td class="row1">{L_MAKE_LINKS}</td>
		<td class="row2"><input type="radio" name="make_links" value="1" {MAKE_LINKS_YES} /> {L_YES} <input type="radio" name="make_links" value="0" {MAKE_LINKS_NO} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_LINKS_NAMES}</td>
		<td class="row2"><input type="radio" name="links_names" value="1" {LINKS_NAMES_YES} /> {L_YES} <input type="radio" name="links_names" value="0" {LINKS_NAMES_NO} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_ALLOW_SMILIES}</td>
		<td class="row2"><input type="radio" name="allow_smilies" value="1" {ALLOW_SMILIES_YES} /> {L_YES} <input type="radio" name="allow_smilies" value="0" {ALLOW_SMILIES_NO} />{L_NO}</td>
	</tr>
	<tr> 
		<td class="row1">{L_ALLOW_BBCODE}</td> 
		<td class="row2"><input type="radio" name="allow_bbcode" value="1" {ALLOW_BBCODE_YES} /> {L_YES} <input type="radio" name="allow_bbcode" value="0" {ALLOW_BBCODE_NO} />{L_NO}</td> 
	</tr> 
	<tr>
		<td class="row1">{L_ALLOW_EDIT}</td>
		<td class="row2"><input type="radio" name="allow_edit" value="1" {ALLOW_EDIT_YES} /> {L_YES} <input type="radio" name="allow_edit" value="0" {ALLOW_EDIT_NO} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_ALLOW_EDIT_M}</td>
		<td class="row2"><input type="radio" name="allow_edit_m" value="1" {ALLOW_EDIT_M_YES} /> {L_YES} <input type="radio" name="allow_edit_m" value="0" {ALLOW_EDIT_M_NO} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_ALLOW_EDIT_ALL}</td>
		<td class="row2"><input type="radio" name="allow_edit_all" value="1" {ALLOW_EDIT_ALL_YES} /> {L_YES} <input type="radio" name="allow_edit_all" value="0" {ALLOW_EDIT_ALL_NO} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_ALLOW_DELETE}</td>
		<td class="row2"><input type="radio" name="allow_delete" value="1" {ALLOW_DELETE_YES} /> {L_YES} <input type="radio" name="allow_delete" value="0" {ALLOW_DELETE_NO} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_ALLOW_DELETE_M}</td>
		<td class="row2"><input type="radio" name="allow_delete_m" value="1" {ALLOW_DELETE_M_YES} /> {L_YES} <input type="radio" name="allow_delete_m" value="0" {ALLOW_DELETE_M_NO} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_ALLOW_DELETE_ALL}</td>
		<td class="row2"><input type="radio" name="allow_delete_all" value="1" {ALLOW_DELETE_ALL_YES} /> {L_YES} <input type="radio" name="allow_delete_all" value="0" {ALLOW_DELETE_ALL_NO} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_ALLOW_GUEST}</td>
		<td class="row2"><input type="radio" name="allow_guest" value="1" {ALLOW_GUEST_YES} /> {L_YES} <input type="radio" name="allow_guest" value="0" {ALLOW_GUEST_NO} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_ALLOW_GUEST_VIEW}</td>
		<td class="row2"><input type="radio" name="allow_guest_view" value="1" {ALLOW_GUEST_VIEW_YES} /> {L_YES} <input type="radio" name="allow_guest_view" value="0" {ALLOW_GUEST_VIEW_NO} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_ALLOW_USERS_VIEW}</td>
		<td class="row2"><input type="radio" name="allow_users_view" value="1" {ALLOW_USERS_VIEW_YES} /> {L_YES} <input type="radio" name="allow_users_view" value="0" {ALLOW_USERS_VIEW_NO} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_ALLOW_USERS}</td>
		<td class="row2"><input type="radio" name="allow_users" value="1" {ALLOW_USERS_YES} /> {L_YES} <input type="radio" name="allow_users" value="0" {ALLOW_USERS_NO} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_USERCALL}</td>
		<td class="row2"><input type="radio" name="usercall" value="1" {USERCALL_YES} /> {L_YES} <input type="radio" name="usercall" value="0" {USERCALL_NO} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_SMILIES}</td>
		<td class="row2"><input type="radio" name="shoutbox_smilies" value="1" {SMILIES_YES} /> {L_YES} <input type="radio" name="shoutbox_smilies" value="0" {SMILIES_NO} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_COUNT_MSG}</td>
		<td class="row2"><input type="text" class="post" name="count_msg" value="{COUNT_MSG}" size="4" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row1">{SB_SHOUT_REFRESH}</td>
		<td class="row2"><input type="text" class="post" name="shout_refresh" value="{SHOUT_REFRESH}" size="4" maxlength="10" /></td>
	</tr>
	<tr>
		<td class="row1">{L_DELETE_DAYS}</td>
		<td class="row2"><input type="text" class="post" name="delete_days" value="{DELETE_DAYS}" size="4" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row1">{L_TEXT_LENGHT}</td>
		<td class="row2"><input type="text" class="post" name="text_lenght" value="{TEXT_LENGHT}" size="4" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row1">{L_WORD_LENGHT}</td>
		<td class="row2"><input type="text" class="post" name="word_lenght" value="{WORD_LENGHT}" size="4" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row1">{L_DATE_FORMAT}</td>
		<td class="row2"><input type="text" class="post" name="date_format" value="{DATE_FORMAT}" size="10" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row1">{L_SHOUT_SIZE}</td>
		<td class="row2"><input type="text" class="post" name="shout_width" value="{SHOUT_WIDTH}" size="4" maxlength="255" /> x <input type="text" class="post" name="shout_height" value="{SHOUT_HEIGHT}" size="4" maxlength="255" /></td>
	</tr>
	<tr>
		<td class="row1">{L_BANNED_USER_ID}<br /><span class="gensmall">{L_BANNED_USER_ID_E}</span></td>
		<td class="row2"><textarea class="post" name="banned_user_id" rows="3" cols="20">{BANNED_USER_ID}</textarea></td>
	</tr>
	<tr>
		<td class="row1">{L_BANNED_USER_ID_VIEW}<br /><span class="gensmall">{L_BANNED_USER_ID_VIEW_E}</span></td>
		<td class="row2"><textarea class="post" name="banned_user_id_view" rows="3" cols="20">{BANNED_USER_ID_VIEW}</textarea></td>
	</tr>
	<tr>
		<td class="row1">{L_GROUP_SELECT}<br /><span class="gensmall">{L_GROUP_SEL_O}</span></td>
		<td class="row2"><select class="post" name="sb_group_sel[]" size="7" style="min-width: 170px;" multiple>{S_GROUP_SELECT}</select></td>
	</tr>
	<tr>
		<td class="submit" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>
</table></form>
<br clear="all" />
