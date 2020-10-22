<h1>{CF_TITLE}</h1>

<p>{CF_EXPLAIN}</p>
<br>
<p>{CF_DESCRIPTION}</p>

<table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
<tr>
	<th colspan="2">{L_TITLE}</th>
</tr>

<!-- BEGIN add_field -->
	<form method="post" action="{S_ACTION}">
	<tr>
		<td class="row1" width="45%">{L_DESC_SHORT}</td>
		<td class="row2" width="55%"><input type="text" class="post" name="desc_short" size="50" maxlength="40" value="{DESC_SHORT}"></td>
	</tr>
	<tr>
		<td class="row1" width="45%">{L_DESC_LONG}</td>
		<td class="row2" width="55%"><textarea class="post" name="desc_long" cols="50" rows="3">{DESC_LONG}</textarea></td>
	</tr>
	<tr>
		<td class="row1" width="45%">{L_MAX_VALUE}</td>
		<td class="row2" width="55%"><input type="text" class="post" name="max_value" size="5" maxlength="8" value="{MAX_VALUE}"></td>
	</tr>
	<tr>
		<td class="row1" width="45%">{L_MIN_VALUE}</td>
		<td class="row2" width="55%"><input type="text" class="post" name="min_value" size="5" maxlength="8" value="{MIN_VALUE}"></td>
	</tr>
	<tr>
		<td class="row1" width="45%">{L_MAKELINKS}</td>
		<td class="row2" width="55%"><input type="radio" name="makelinks" value="1" {MAKELINKS_YES}> {L_YES} <input type="radio" name="makelinks" value="0" {MAKELINKS_NO}>{L_NO}</td>
	</tr>
	<tr>
		<td class="row1" width="45%">{L_NUMERICS}</td>
		<td class="row2" width="55%"><input type="radio" name="numerics" value="1" {NUMERICS_YES}> {L_YES} <input type="radio" name="numerics" value="0" {NUMERICS_NO}>{L_NO}</td>
	</tr>
	<tr>
		<td class="row1" width="45%">{L_REQUIRE}</td>
		<td class="row2" width="55%"><input type="radio" name="requires" value="1" {REQUIRE_YES}> {L_YES} <input type="radio" name="requires" value="0" {REQUIRE_NO}>{L_NO}</td>
	</tr>
	<tr>
		<td class="row1" width="45%">{L_EDITABLE}</td>
		<td class="row2" width="55%"><input type="radio" name="editable" value="1" {EDITABLE_YES}> {L_YES} <input type="radio" name="editable" value="0" {EDITABLE_NO}>{L_NO}</td>
	</tr>
	<tr>
		<td class="row1" width="45%">{L_VIEW_PROFILE}</td>
		<td class="row2" width="55%"><input type="radio" name="view_profile" value="1" {PROFILE_YES}> {L_YES} <input type="radio" name="view_profile" value="0" {PROFILE_NO}>{L_NO}</td>
	</tr>
	<tr>
		<td class="row1" width="45%">{L_VIEW_BY}</td>
		<td class="row2" width="55%"><select name="view_by"><option value="0" {VIEW_ALL}>{L_VIEW_ALL} </option>
		<option value="1" {VIEW_REGISTERED}>{L_VIEW_REGISTERED}</option>
		<option value="2" {VIEW_MOD}>{L_VIEW_MOD}</option>
		<option value="3" {VIEW_ADMIN}>{L_VIEW_ADMIN}</option>
		<option value="4" {VIEW_USER_MOD}>{L_VIEW_MOD}&nbsp;{L_AND_USER} </option>
		<option value="5" {VIEW_USER_ADMIN}>{L_VIEW_ADMIN}&nbsp;{L_AND_USER} </option>
		</select>
		</td>
	</tr>
	<tr>
		<td class="row1" width="45%">{L_VIEW_POST}</td>
		<td class="row2" width="55%"><select name="view_post"><option value="0" {SELECTED_NO}>{L_NONE}</option><option value="1" {SELECTED_POST}>{L_POST}</option><option value="3" {SELECTED_UPOST}>{L_UPOST}</option><option value="2" {SELECTED_AVATAR}>{L_AVATAR}</option></select></td>
	</tr>
	<tr>
		<td class="row1" width="45%">{L_SET_FORM}</td>
		<td class="row2" width="55%"><select name="set_form"><option value="0" {SELECTED_TEXT}>{L_TEXT}</option><option value="1" {SELECTED_TEXTAREA}>{L_TEXTAREA}</option></select></td>
	</tr>
	<tr>
		<td class="row1" width="45%">{L_NO_FORUM}<br><span class="gensmall">{L_NO_FORUM_E}</span></td>
		<td class="row2" width="55%"><select name="no_forum[]" size="7" multiple>{NO_FORUM}<option value="">--</option></select></td>
	</tr>
	<tr>
		<td class="row1" colspan="2">{L_JUMPBOX}<br><span class="gensmall">{L_JUMPBOX_E}</span></td>
	</tr>
	<tr>
		<td class="row2" colspan="2" align="center"><textarea class="post" name="jumpbox" cols="80" rows="3">{JUMPBOX}</textarea>{JUMPBOX_EDIT}</td>
	</tr>
	<tr>
		<td class="row1" colspan="2">Prefix & Suffix<br><span class="gensmall">{L_PREFIX_E}</span></td>
	</tr>
	<tr>
		<td class="row2" colspan="2" align="center">Prefix:<br><input type="text" class="post" name="prefix" size="80" value="{PREFIX}"><br>Suffix:<br><input type="text" class="post" name="suffix" size="80" value="{SUFFIX}"></td>
	</tr>
	<!-- BEGIN delete -->
	<tr>
		<td class="row1" width="45%">{add_field.delete.L_DELETE}</td>
		<td class="row2" width="55%" align="right"><input type="checkbox" name="delete" value="{ID}"></td>
	</tr>
	<!-- END delete -->
	<tr>
		<td class="submit" colspan="2" align="center"><input type="submit" value="{L_ADD_FIELD}" class="mainoption"></td>
	</tr>
	</form>
<!-- END add_field -->

<!-- BEGIN field_list_loop -->
	<tr>
		<td class="{field_list_loop.CLASS}">
			<table width="100%">
				<form method="post" action="{field_list_loop.S_ACTION_EDIT}">
				<tr>
					<td width="50%" class="nav">{field_list_loop.DESC_SHORT}</td><td width="50%"><input type="submit" class="mainoption" value="{L_EDIT}"></td>
				</tr>
				</form>
			</table>
		</td>
	</tr>
<!-- END field_list_loop -->
<!-- BEGIN field_list -->
	<form method="post" action="{S_ACTION_ADD}">
	<tr>
		<td class="submit" align="left"><input type="submit" value="{L_ADD}" class="mainoption"></td>
	</tr>
	</form>
<!-- END field_list -->



</table>
<br>
