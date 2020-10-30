<h1>{L_TITLE}</h1>

<p>{L_EXPLAIN}</p>

<p> <- <a href="{U_BACK}">{L_BACK}</a></p>
<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<form action="{S_ACTION}" name="post" method="post">
	<tr>
	  <th colspan="3">{L_ACTION_1}</th>
	</tr>
	<tr>
		<td class="row1">{L_UG}:</td>
		<td class="row2">
		<!-- BEGIN switch_user -->
		<input type="text" maxlength="50" size="20" name="username">&nbsp;<input type="button" value="{L_FIND_USERNAME}" class="liteoption" onClick="window.open('{U_SEARCH_USER}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false;">
		<!-- END switch_user -->
		<!-- BEGIN switch_group -->
		{GROUP_SELECT}
		<!-- END switch_group -->
		</td>
	</tr>
	<tr>
		<td class="submit" colspan="2" align="center">
		{S_HIDDEN_FIELDS}
		<input type="hidden" name="action" value="1"> 
		<input type="submit" name="submit" value="{L_ADD}" class="mainoption"></td>
	</tr>
	</form>

	<form action="{S_ACTION}" method="post">
	<tr>
	  <th colspan="3">{L_ACTION_0}</th>
	</tr>
	<tr>
		<td class="row1">{L_UG}:<br><span class="gensmall">{L_UG_SELECT_EXPLAIN}</span></td>
		<td class="row2">{UG_SELECT}</td>
	</tr>
	<tr>
		<td class="submit" colspan="2" align="center">
		{S_HIDDEN_FIELDS}
		<input type="hidden" name="action" value="0"> 
		<input type="submit" name="submit" value="{L_REMOVE}" class="mainoption"></td>
	</tr>
	</form>
</table>
<br clear="all">
