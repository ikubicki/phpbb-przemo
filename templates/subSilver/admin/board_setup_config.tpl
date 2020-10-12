<h1>{L_CONFIGURATION_TITLE}</h1>
<p>{L_CONFIGURATION_E}</p>

<form action="{S_CONFIG_ACTION}" method="post">
<input type="hidden" name="action" value="1">
<table width="100%" cellpadding="8" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
		<th>{L_CONFIGURATION_TITLE}</th>
	</tr>
	<tr>
		<td class="row1" align="center"><input type="submit" name="save" value="{L_SAVE_CONFIG}" class="mainoption"></td>
	</tr>
	<tr>
		<td class="row2" align="center"><input type="submit" name="default" value="{L_DEFAULT_CONFIG}" class="mainoption"></td>
	</tr>
	<tr>
		<td class="row1" align="center"><input type="submit" name="simple" value="{L_SIMPLE_CONFIG}" class="mainoption"></td>
	</tr>
	<tr>
		<td class="row2" align="center"><input type="submit" name="full" value="{L_FULL_CONFIG}" class="mainoption"></td>
	</tr>
	<!-- BEGIN saved -->
	<tr>
		<td class="row1" align="center"><input type="submit" name="saved" value="{saved.L_SAVED_CONFIG}" class="mainoption"></td>
	</tr>
	<!-- END saved -->
</table>
</form>
<br clear="all">
