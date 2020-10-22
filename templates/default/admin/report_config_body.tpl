<h1>{L_CONFIGURATION_TITLE}</h1>

<p>{L_CONFIGURATION_EXPLAIN}</p>

<form action="{S_ACTION}" method="post" name="post">
<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
	  <th colspan="2">{L_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row1">{L_RP_DISABLE}</span></td>
		<td class="row2"><input type="radio" name="report_disable" value="1" {RP_DISABLE_YES}> {L_YES}&nbsp;&nbsp;<input type="radio" name="report_disable" value="0" {RP_DISABLE_NO}> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_POPUP_SIZE} <br><span class="gensmall">{L_POPUP_SIZE_EXPLAIN}</span></td>
		<td class="row2"><input type="text" size="3" maxlength="4" name="report_popup_height" value="{POPUP_HEIGHT}"> x <input type="text" size="3" maxlength="4" name="report_popup_width" value="{POPUP_WIDTH}"></td>
	</tr>
	<tr>
		<td class="row1">{L_POPUP_LINKS_TARGET}<br><span class="gensmall">{L_POPUP_LINKS_TARGET_EXPLAIN}</span></td>
		<td class="row2">{POPUP_LINKS_TARGET_SELECT}</td>
	</tr>
	<tr>
		<td class="row1">{L_ONLY_ADMIN}<br><span class="gensmall">{L_ONLY_ADMIN_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="report_only_admin" value="1" {S_ONLY_ADMIN_YES}> {L_YES}&nbsp;&nbsp;<input type="radio" name="report_only_admin" value="0" {S_ONLY_ADMIN_NO}> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_NO_GUESTS}<br><span class="gensmall">{L_NO_GUESTS_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="report_no_guestes" value="1" {S_NO_GUESTS_YES}> {L_YES}&nbsp;&nbsp;<input type="radio" name="report_no_guestes" value="0" {S_NO_GUESTS_NO}> {L_NO}</td>
	</tr>
	<tr>
		<td class="submit" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption">&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption">
		</td>
	</tr>
</table></form>

<br clear="all">

