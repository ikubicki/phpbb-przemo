<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th align="center">{L_USER_SELECT}</th>
	</tr>
	<tr>
		<td class="row1" align="center">
		<form method="post" name="post" action="{S_USER_ACTION}">
		<input type="text" class="post" name="username" maxlength="50" size="20"> 
		<input type="hidden" name="mode" value="edit"><input type="hidden" name="userlist" value="1">
		<input type="submit" name="submituser" value="{L_LOOK_UP}" class="mainoption">
		<input type="submit" name="authuser" value="{L_AUTH}" class="mainoption">
		<!-- BEGIN is_admin -->
		<input type="submit" name="jr" value="JR" class="mainoption">
		<!-- END is_admin -->
		</form>
		<input type="submit" name="usersubmit" value="{L_FIND_USERNAME}" class="liteoption" onClick="window.open('{U_SEARCH_USER}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false;"></td>
	</tr>
	<tr>
		<td class="row2" align="center">{U_SEARCH_USERS}</td>
	</tr>
	<tr>
		<td class="row1" align="center">{L_SORT_PER_LETTER}&nbsp;{S_LETTER_SELECT}</td>
	</tr>
</table>

<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
	<tr>
		<th height="25" valign="middle" nowrap="nowrap">{L_ACTION}</th>
		<th height="25" valign="middle" nowrap="nowrap">{L_USERNAME}</th>
		<th height="25" valign="middle" nowrap="nowrap">{L_EMAIL}</th>
		<th height="25" valign="middle" nowrap="nowrap">{L_POSTS}</th>
		<th height="25" valign="middle" nowrap="nowrap">{L_JOINED}</th>
		<th height="25" valign="middle" nowrap="nowrap">{L_LAST_VISIT}</th>
		<th height="25" valign="middle" nowrap="nowrap">{L_ACTIVE}</th>
	</tr>
	<tr>
		<td class="row2" colspan="8" align="center">
			<form action="{U_LIST_ACTION}" method="post">
			{S_LETTER_HIDDEN}
			<p>{L_SELECT_SORT_METHOD}&nbsp;{S_USER_SELECT}
			&nbsp;{S_ORDER_SELECT}&nbsp;&nbsp;<input type="submit" value="{L_SORT}" class="liteoption">
			</form>
		</td>
	</tr>
	<!-- BEGIN userrow -->
	<tr>
		<td class="{userrow.COLOR}" align="center" valign="middle" height="28" width="68" nowrap="nowrap">
			<form action="{S_JR_ACTION}" method="post"><input type="hidden" name="user_id" value="{userrow.USER_ID}">
			<table>
				<tr>
					<td class="{userrow.COLOR}" align="center"><span class="gensmall"><a href="{userrow.U_ADMIN_USER}">{L_EDIT}</a><br><a href="{userrow.U_ADMIN_USER_AUTH}">{L_PERMISSION}</a></span></td>
					<td class="{userrow.COLOR}" align="center" valign="middle"><span class="gensmall">
					<!-- BEGIN is_admin -->
					<input type="submit" name="jr" value="JR" class="{userrow.JR_CLASS}">
					<!-- END is_admin -->
					</span></td>
				</tr>
			</table>
			</form>
		</td>
		<td class="{userrow.COLOR}" align="center" valign="middle" height="28" nowrap="nowrap"><span class="genmed">{userrow.USERNAME}</span></td>
		<td class="{userrow.COLOR}" align="center" valign="middle" height="28" nowrap="nowrap"><span class="genmed">{userrow.EMAIL}</span></td>
		<td class="{userrow.COLOR}" align="center" valign="middle" height="28" width="40" nowrap="nowrap"><span class="genmed">{userrow.POSTS}</span></td>
		<td class="{userrow.COLOR}" align="center" valign="middle" height="28" width="130" nowrap="nowrap"><span class="genmed">{userrow.JOINED}</span></td>
		<td class="{userrow.COLOR}" align="center" valign="middle" height="28" width="130" nowrap="nowrap"><span class="genmed">{userrow.LAST_VISIT}</span></td>
		<td class="{userrow.COLOR}" align="center" valign="middle" height="28" width="50" nowrap="nowrap"><span class="genmed">{userrow.ACTIVE}</span></td>
	</tr>
	<!-- END userrow -->
	<tr>
		<td class="submit" height="28" align="center" valign="middle" colspan="8">
		</td>
	</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="left" valign="middle" nowrap="nowrap"><span class="nav">{PAGE_NUMBER}</span></td>
		<td align="right" valign="middle"><span class="nav">{PAGINATION}</span></td>
	</tr>
</table>

<br>
