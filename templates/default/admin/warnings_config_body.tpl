<!-- BEGIN warnings -->
<h1>{warnings.L_WARNINGS}</h1>
<p>{warnings.L_WARNINGS_E}</p>
<form action="{warnings.S_CONFIG_ACTION}" method="post">
<table width="100%" cellpadding="2" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
		<th colspan="2">{warnings.L_WARNINGS}</th>
	</tr>
	<tr>
		<td class="row1" width="62%">{warnings.L_WARNINGS_ENABLE}</td>
		<td class="row2"><input type="radio" name="warnings_enable" value="1" {warnings.WARNING_ENABLE_YES}> {warnings.L_YES} <input type="radio" name="warnings_enable" value="0" {warnings.WARNING_ENABLE_NO}>{warnings.L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{warnings.L_WRITE_WARNINGS}<br><span class="gensmall">{warnings.L_WRITE_WARNINGS_E}</span></td>
		<td class="row3"><input type="text" class="post2" onFocus="Active(this)" onBlur="NotActive(this)" size="4" maxlength="100" name="write_warnings" value="{warnings.WRITE_WARNINGS}"></td>
	</tr>
	<tr>
		<td class="row1">{warnings.L_BAN_WARNINGS}<br><span class="gensmall">{warnings.L_BAN_WARNINGS_E}</span></td>
		<td class="row3"><input type="text" class="post2" onFocus="Active(this)" onBlur="NotActive(this)" size="4" maxlength="100" name="ban_warnings" value="{warnings.BAN_WARNINGS}"></td>
	</tr>
	<tr>
		<td class="row1">{warnings.L_MOD_VALUE_WARNING}<br><span class="gensmall">{warnings.L_MOD_VALUE_WARNING_E}</span></td>
		<td class="row3"><input type="text" class="post2" onFocus="Active(this)" onBlur="NotActive(this)" size="4" maxlength="100" name="mod_value_warning" value="{warnings.MOD_VALUE_WARNING}"></td>
	</tr>
	<tr>
		<td class="row1">{warnings.L_EXPIRE_WARNINGS}<br><span class="gensmall">{warnings.L_EXPIRE_WARNINGS_E}</span></td>
		<td class="row3"><input type="text" class="post2" onFocus="Active(this)" onBlur="NotActive(this)" size="4" maxlength="100" name="expire_warnings" value="{warnings.EXPIRE_WARNINGS}"></td>
	</tr>
	<tr>
		<td class="row1">{warnings.L_MOD_WARNINGS}</td>
		<td class="row2"><input type="radio" name="mod_warnings" value="1" {warnings.MOD_WARNINGS_YES}> {warnings.L_YES} <input type="radio" name="mod_warnings" value="0" {warnings.MOD_WARNINGS_NO}>{warnings.L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{warnings.L_MOD_EDIT_WARNINGS}<br><span class="gensmall">{warnings.L_MOD_EDIT_WARNINGS_E}</span></td>
		<td class="row2"><input type="radio" name="mod_edit_warnings" value="1" {warnings.MOD_EDIT_WARNINGS_YES}> {warnings.L_YES} <input type="radio" name="mod_edit_warnings" value="0" {warnings.MOD_EDIT_WARNINGS_NO}>{warnings.L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{warnings.L_WARNINGS_MODS_PUBLIC}<br><span class="gensmall">{warnings.L_WARNINGS_MODS_PUBLIC_E}</span></td>
		<td class="row2"><input type="radio" name="warnings_mods_public" value="1" {warnings.WARNINGS_MODS_PUBLIC_YES}> {warnings.L_YES} <input type="radio" name="warnings_mods_public" value="0" {warnings.WARNINGS_MODS_PUBLIC_NO}>{warnings.L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{warnings.L_VIEWTOPIC_WARNINGS}</td>
		<td class="row2"><input type="radio" name="viewtopic_warnings" value="1" {warnings.VIEWTOPIC_WARNINGS_YES}> {warnings.L_YES} <input type="radio" name="viewtopic_warnings" value="0" {warnings.VIEWTOPIC_WARNINGS_NO}>{warnings.L_NO}</td>
	</tr>
	<tr>
		<td class="submit" colspan="2" align="center"><input type="hidden" name="mode" value="warnings"><input type="submit" name="submit_warnings" value="{warnings.L_SUBMIT}" class="mainoption">&nbsp;&nbsp;<input type="reset" value="{warnings.L_RESET}" class="liteoption">
		</td>
	</tr>
</table>
</form>
<br clear="all">
<!-- END warnings -->
