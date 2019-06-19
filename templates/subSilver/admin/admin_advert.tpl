<h1>{L_ADVERT_TITLE}</h1>

<p>{L_ADVERT_EXPLAIN}</p>

<form method="post" name="post" action="{S_ACTION}">
<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th class="thHead" align="center" colspan="2">{L_SETUP}</th>
	</tr>
	<tr>
		<td class="row1" align="center"><span class="nav">{L_RIGHT_COLUMN}</span></td>
	</tr>
	<tr>
		<td class="row2" align="center"><textarea name="advert" rows="7" cols="100" class="post" style="width: 100%;">{ADVERT}</textarea></td></td>
	</tr>
	<tr>
		<td class="row2" align="center">{L_RIGHT_COLUMN_FOOT}</td>
	</tr>
	<tr>
		<td class="row2" align="center"><textarea name="advert_foot" rows="2" cols="100" class="post" style="width: 100%;">{ADVERT_FOOT}</textarea></td></td>
	</tr>
	<tr><td class="Spacerow" height="5"></td></tr>
	<tr>
		<td class="row1" align="center" width="50%"><span class="nav">{L_VIEW_HIDE}</span></td>
	</tr>
	<tr>
		<td class="row2" align="center" nowrap="nowrap"><input type="radio" name="view_ad_by" value="0"{HIDE_DISABLE}>{L_DISABLE} &nbsp;
		<input type="radio" name="view_ad_by" value="1"{HIDE_REG}>{L_REG_USERS} &nbsp; 
		<input type="radio" name="view_ad_by" value="2"{HIDE_STAFF}>{L_STAFF_USERS}
	</td>
	<tr>
		<td class="row1">
			<table width="100%" cellspacing="1" cellpadding="4" border="0" class="forumline">
				<tr>
					<td class="row1" align="center" width="15%"><span class="nav">{L_ADVERT_WIDTH}</span></td>
					<td class="row1" align="center" width="15%"><span class="nav">{L_AD_SEPARATOR}</span></td>
					<td class="row1" align="center" width="15%"><span class="nav">{L_AD_SEPARATOR_L}</span></td>
				</tr>
				<tr>
					<td class="row2" align="center"><input type="text" name="advert_width" value="{ADVERT_WIDTH}" size="4" maxlength="4" class="post"></td>
					<td class="row2" align="center"><input type="text" name="advert_separator" value="{SEPARATOR}" size="6" class="post"></td>
					<td class="row2" align="center"><input type="text" name="advert_separator_l" value="{SEPARATOR_L}" size="12" class="post"></td>
				</tr>
			</table>
		</td>
	</tr>
	</tr>
	<tr>
		<td class="catBottom" align="center" colspan="2"><input type="hidden" name="board_config" value="1"><input type="submit" name="submit" value="{L_SAVE}" class="mainoption"> <input type="reset" name="reset" value="{L_RESET}" class="liteoption"></td>
	</tr>
</table>
</form>
<br>
<form method="post" name="post" action="{S_ACTION}#add">
<a name="add"></a>
<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th class="thHead" align="center" colspan="2">{L_ADD_LINK}</th>
	</tr>
	<tr>
		<td class="row2" align="center"><span class="gensmall">{L_ADD_LINK_E}</span></td>
	</tr>
	<!-- BEGIN add_error -->
	<tr>
		<td class="row2" align="center"><span class="nav" style="color: #FF0000">{add_error.MESSAGE}</span></td>
	</tr>
	<!-- END add_error -->
	<tr>
		<td class="row1" align="center">
			<textarea name="add_link" cols="100" rows="7" class="post" style="width: 100%;">{HTML}</textarea>
		</td>
	</tr>
	<tr>
		<td class="row2" align="center">
		{L_EMAIL}: <input type="text" name="email" size="30" class="post" value="{EMAIL}">&nbsp;
		{L_DAYS}: <input type="text" name="days" size="3" maxlength="3" class="post" value="{DAYS}">&nbsp;
		{L_POSITION}: <select name="position"><option value="1"{DOWN_SELECTED}>{L_AD_DOWN}</option><option value="2"{LEFT_SELECTED}>{L_AD_LEFT}</option><option value="0"{HIDE_SELECTED}>{L_POS_HIDE}</option></select>
		&nbsp;{L_CLICKS}: <input type="checkbox" name="type" value="1"TYPE_CHECKED>
		</td>
	</tr>
	<tr>
		<td class="catBottom" align="center" colspan="2"><input type="hidden" name="add" value="1"><input type="submit" name="submit" value="{L_ADD}" class="mainoption"> <input type="reset" name="reset" value="{L_RESET}" class="liteoption"></td>
	</tr>
</table>
</form>
<br>
<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th class="thHead" align="center" width="70" nowrap="nowrap">{L_DAYS}</th>
		<th class="thHead" align="center" nowrap="nowrap">{L_ORDER}</th>
		<th class="thHead" align="center" width="100%">{L_LIST}</th>
	</tr>
	<!-- BEGIN list -->
	<tr>
		<td class="row{list.ROW}" align="center"><a name="{list.ID}"></a>{list.DAYS_SHORT}</td>
		<td class="row{list.ROW}" align="center" nowrap="nowrap"><a href="{list.UP_URL}#{list.ID}" class="mainmenu">{L_UP}</a> | <a href="{list.DOWN_URL}#{list.ID}" class="mainmenu">{L_DOWN}</a></td>
		<td class="row{list.ROW}" align="left"><a href="{list.EDIT_URL}#{list.ID}" class="mainmenu">{list.NAME}</a>
			<!-- BEGIN form -->
			<br>{L_ADDED}: {list.ADDED} &nbsp;{list.LAST_UPDATE}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<form method="post" name="post" action="{S_ACTION}#{list.ID}">
			<input type="checkbox" name="delete" value="1">{L_DELETE}<br>
				<!-- BEGIN add_error -->
				<span class="nav" style="color: #FF0000">{list.form.add_error.MESSAGE}</span>
				<!-- END add_error -->
				<textarea name="add_link" cols="100" rows="7" class="post" style="width: 100%;">{list.HTML}</textarea>
				{L_EMAIL}: <input type="text" name="email" size="20" class="post2" value="{list.EMAIL}">&nbsp;
				{L_DAYS}: <input type="text" name="days" size="6" maxlength="6" class="post2" value="{list.DAYS}"><br>
				{L_POSITION}: <select name="position"><option value="1"{list.DOWN_SELECTED}>{L_AD_DOWN}</option><option value="2"{list.LEFT_SELECTED}>{L_AD_LEFT}</option><option value="0"{list.HIDE_SELECTED}>{L_POS_HIDE}</option></select>
				&nbsp;&nbsp;{L_CLICKS}: <input type="checkbox"{list.DISABLED} name="type" value="1"{list.TYPE_CHECKED}>
				&nbsp;&nbsp;<input type="hidden" name="edit" value="1"><input type="hidden" name="id" value="{list.ID}"><input type="submit" name="submit" value="{L_SAVE}" class="mainoption">
			</form>
			<!-- END form -->
		</td>
	</tr>
	<!-- END list -->
	<tr>
		<td class="catBottom" align="center" colspan="3"></td>
	</tr>
</table>
</form>
<br>