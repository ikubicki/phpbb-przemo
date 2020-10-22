
<h1>{L_DATABASE_BACKUP}</h1>

<P>{L_BACKUP_EXPLAIN}</p>

<form method="post" action="{S_DBUTILS_ACTION}">
<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th colspan="2">{L_BACKUP_OPTIONS}</th>
	</tr>
	<tr>
		<td class="row1">{L_ENABLE}</td>
		<td class="row2"><input type="radio" name="db_backup_enable" value="1" {ENABLE_YES_CHECKED}>{L_YES}&nbsp;<input type="radio" name="db_backup_enable" value="0" {ENABLE_NO_CHECKED}>{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_TABLES_SEARCH}</td>
		<td class="row2"><input type="radio" name="db_backup_search" value="1" {SEARCH_YES_CHECKED}>{L_YES}&nbsp;<input type="radio" name="db_backup_search" value="0" {SEARCH_NO_CHECKED}>{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_TABLES_RH}</td>
		<td class="row2"><input type="radio" name="db_backup_rh" value="1" {RH_YES_CHECKED}>{L_YES}&nbsp;<input type="radio" name="db_backup_rh" value="0" {RH_NO_CHECKED}>{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_COPIES}</td>
		<td class="row2"><input type="text" name="db_backup_copies" value="{COPIES}" size="3"></td>
	</tr>
	<tr>
		<td class="submit" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="update_config" value="{L_SUBMIT}" class="mainoption"></td>
	</tr>
</table></form>
<br>
<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<td class="row1" align="center">{LAST_BACKUP}</td>
	</tr>
	<tr>
		<td class="row2" colspan="2" align="center"><a href="{S_DBUTILS_ACTION}&amp;perform=backup_now" class="nav">{L_LINK}</a></td>
	</tr>
</table>
<br>
