<form method="post" action="{S_MODE_ACTION}">
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="left"><span class="gensmall">
			<!-- BEGIN staff_explain -->
			<a href="{staff_explain.U_GROUP_URL}" class="gensmall" style="color: #{staff_explain.GROUP_COLOR}{staff_explain.GROUP_STYLE}">{staff_explain.GROUP_PREFIX}{staff_explain.GROUP_NAME}</a>
			<!-- BEGIN se_separator -->
			&bull;
			<!-- END se_separator -->
			<!-- END staff_explain -->
		</span></td>
		<td align="right" nowrap="nowrap"><span class="genmed">{L_SELECT_SORT_METHOD}:&nbsp;{S_MODE_SELECT}&nbsp;{S_ORDER_SELECT}&nbsp;&nbsp; 
		<input type="submit" name="submit" value="{L_SUBMIT}" class="liteoption"></span></td>
	</tr>
	<tr>
	<td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
	<td colspan="2" align="right" nowrap="nowrap"><span class="genmed">{L_SORT_PER_LETTER}&nbsp;{S_LETTER_SELECT}{S_LETTER_HIDDEN}</span></td>
	</tr>
</table>

<table width="100%" cellpadding="1" cellspacing="1" border="0" class="forumline">
	<tr>
		<th class="thTop" nowrap="nowrap">{L_USERNAME}</th>
		<th class="thTop" nowrap="nowrap">{L_EMAIL}</th>
		<th class="thTop" nowrap="nowrap">PM</th>
		<th class="thTop" nowrap="nowrap">{L_FROM}</th>
		<th class="thTop" nowrap="nowrap">{L_JOINED}</th>
		<!-- BEGIN llogin -->
		<th class="thTop" nowrap="nowrap">{L_LAST_VISIT}</th>
		<!-- END llogin -->
		<th class="thTop" nowrap="nowrap">{L_POSTS}</th>
		<!-- BEGIN aim -->
		<th class="thTop" nowrap="nowrap">GG</th>
		<!-- END aim -->
		<th class="thCornerR" nowrap="nowrap">{L_WEBSITE}</th>
	</tr>
	<!-- BEGIN memberrow -->
	<tr>
		<td class="{memberrow.ROW_CLASS}" width="15%" nowrap="nowrap" align="center"><span class="name"><a href="{memberrow.U_VIEWPROFILE}" class="name"{memberrow.USERNAME_COLOR}>{memberrow.USERNAME}</a></span></td>
		<td class="{memberrow.ROW_CLASS}" width="5%" align="center" valign="middle">&nbsp;{memberrow.EMAIL_IMG}&nbsp;</td>
		<td class="{memberrow.ROW_CLASS}" width="5%" align="center">&nbsp;{memberrow.PM_IMG}&nbsp;</td>
		<td class="{memberrow.ROW_CLASS}" width="15%" align="center" valign="middle"><span class="gen">{memberrow.FROM}</span></td>
		<td class="{memberrow.ROW_CLASS}" width="15%" nowrap="nowrap" align="center" valign="middle"><span class="gensmall">{memberrow.JOINED}</span></td>
		<!-- BEGIN llogin_row -->
		<td class="{memberrow.ROW_CLASS}" width="15%" align="center" nowrap="nowrap" valign="middle"><span class="gensmall">{memberrow.LAST_VISIT}</span></td>
		<!-- END llogin_row -->
		<td class="{memberrow.ROW_CLASS}" width="3%" align="center" valign="middle"><span class="gen">{memberrow.POSTS}</span></td>
		<!-- BEGIN aim_row -->
		<td class="{memberrow.ROW_CLASS}" width="3%" align="center" valign="middle"><span class="gen">{memberrow.AIM_STATUS_IMG}</span></td>
		<!-- END aim_row -->
		<td class="{memberrow.ROW_CLASS}" width="5%" align="center">&nbsp;{memberrow.WWW_IMG}&nbsp;</td>
	</tr>
	<!-- END memberrow -->
	<tr>
		<td class="catbottom" colspan="4" height="28" align="left">{U_STAFF}</td><td class="catbottom" colspan="{COLSPAN}" height="28" align="right">{U_SEARCH_USERS}</td>
	</tr>
</table>

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr>
		<td align="right" valign="top"></td>
	</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="2" border="0">
	<tr>
		<td><span class="nav">{PAGE_NUMBER}</span></td>
		<td align="right"><span class="nav">{PAGINATION}</span></td>
	</tr>
</table>
</form>

<table width="100%" cellspacing="2" border="0" align="center">
	<tr>
		<td valign="top" align="right">{JUMPBOX}</td>
	</tr>
</table>
