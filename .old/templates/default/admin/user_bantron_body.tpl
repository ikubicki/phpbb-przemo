<h1>{L_BM_TITLE}</h1> 
<p>{L_BM_EXPLAIN}</p>
	<form action="{S_BANCENTER_ACTION}" method="post">
		<table width="100%" cellpadding="1" cellspacing="0" border="0">
			<tr>
				<td width="60%" align="left">
					<span class="genmed">{L_SHOW_BANS_BY}:&nbsp;
					<select name="show">
						<option value="all"{ALL_SELECTED}>{L_ALL}</option>
						<option value="username"{USERNAME_SELECTED}>{L_USERNAME}</option>
						<option value="ip"{IP_SELECTED}>IP</option>
						<option value="host"{HOST_SELECTED}>Host</option>
						<option value="email"{EMAIL_SELECTED}>{L_EMAIL}</option>
					</select>
					&nbsp;<input type="submit" class="liteoption" name="show_submit" value="{L_SHOW}">
					&nbsp;{L_ORDER}:
					&nbsp;<select name="order"> 
						<option value="ASC"{ASC_SELECTED}>{L_ASCENDING}</option>
						<option value="DESC"{DESC_SELECTED}>{L_DESCENDING}</option>
					</select>
					&nbsp;<input type="submit" class="liteoption" name="sort_submit" value="{L_SORT}">
					</span>
				</td>
			</tr>
		</table>
	</form>
	<form action="{S_BANCENTER_ACTION}" method="post">
	<table width="100%" cellpadding="3" cellspacing="1" border="0" align="center" class="forumline">
		<tr>
			<!-- BEGIN username_header -->
			<th height="25" nowrap="nowrap">{username_header.L_USERNAME}</th>
			<!-- END username_header -->
			<!-- BEGIN ip_header -->
			<th height="25" nowrap="nowrap">IP</th>
			<!-- END ip_header -->
			<!-- BEGIN host_header -->
			<th height="25" nowrap="nowrap">Host</th>
			<!-- END host_header -->
			<!-- BEGIN email_header -->
			<th height="25" nowrap="nowrap">{email_header.L_EMAIL}</th>
			<!-- END email_header -->
			<th nowrap="nowrap">{L_BANNED}</th>
			<th nowrap="nowrap">{L_EXPIRES}</th>
			<th nowrap="nowrap">{L_BY}</th>
			<th nowrap="nowrap">{L_REASONS}</th>
			<th nowrap="nowrap">{L_EDIT}</th>
			<th nowrap="nowrap">{L_DELETE}</th>
		<tr>
		<!-- BEGIN switch_nobans -->
		<tr>
			<td class="row1" colspan="11" align="left">
				{NO_BANS} 
			</td>
		</tr>
		<!-- END switch_nobans -->
		<!-- BEGIN rowlist -->
		<tr>
			<!-- BEGIN username_content -->
			<td class="{rowlist.ROW_CLASS}" align="center">{rowlist.username_content.USERNAME}</td>
			<!-- END username_content -->
			<!-- BEGIN ip_content -->
			<td class="{rowlist.ROW_CLASS}" align="center">{rowlist.ip_content.IP}</td>
			<!-- END ip_content -->
			<!-- BEGIN host_content -->
			<td class="{rowlist.ROW_CLASS}" align="center">{rowlist.host_content.HOST}</td>
			<!-- END host_content -->
			<!-- BEGIN email_content -->
			<td class="{rowlist.ROW_CLASS}" align="center">{rowlist.email_content.EMAIL}</td>
			<!-- END email_content -->
			<td class="{rowlist.ROW_CLASS}" align="center">{rowlist.BAN_TIME}</td>
			<td class="{rowlist.ROW_CLASS}" align="center">{rowlist.BAN_EXPIRE_TIME}</td>
			<td class="{rowlist.ROW_CLASS}" align="center">{rowlist.BAN_BY}</td>
			<td class="{rowlist.ROW_CLASS}" align="center">{rowlist.BAN_REASON}</td>
			<td class="{rowlist.ROW_CLASS}" align="center"><a href="{rowlist.U_BAN_EDIT}">{L_EDIT}</a></td>
			<td class="{rowlist.ROW_CLASS}" align="center"><input type="checkbox" name="ban_delete[]" value="{rowlist.BAN_ID}"></td>
		</tr>
		<!-- END rowlist -->
		<tr>
			<td class="submit" align="left" colspan="5">
				<input type="submit" name="add" value="{L_ADD_A_NEW_BAN}" class="liteoption">
			</td>
			<td class="submit" align="right" colspan="5">
				<input type="submit" name="delete_submit" value="{L_DELETE_SELECTED_BANS}" class="liteoption">
			</td>
		</tr>
	</table>
	<table width="100%" cellspacing="2" cellpadding="2" border="0">
		<tr>
			<td><span class="nav">{PAGE_NUMBER}</span></td>
			<td align="right"><span class="nav">{PAGINATION}</span></td>
		</tr>
	</table>
</form>
<br>