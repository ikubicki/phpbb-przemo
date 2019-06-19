<h1>{L_ADV_TITLE}</h1>

<p>{L_ADV_EXPLAIN}</p>

<form method="post" name="post" action="{S_ACTION}">
<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th class="thHead" align="center" colspan="2">{L_SETUP}</th>
	</tr>
	<tr>
		<td class="row1" align="center"><span class="gen">{L_ADV_HOURS}</span></td>
	</tr>
	<tr>
		<td class="row2" align="center"><input type="text" name="adv_person_time" value="{ADV_TIME}" size="4" class="post"></td>
	</tr>
	<tr>
		<td class="catBottom" align="center" colspan="2"><input type="submit" name="submit" value="{L_SAVE}" class="mainoption"> <input type="reset" name="reset" value="{L_RESET}" class="liteoption"></td>
	</tr>
</table>
</form>
<br>
<a name="add"></a>
<table cellspacing="1" cellpadding="3" border="0" align="center" class="forumline" width="100%">
	<tr>
		<th class="thHead" align="center" width="10%">{L_USERNAME}</th>
		<th class="thHead" align="center" width="5%">{L_POSTS}</th>
		<th class="thHead" align="center" width="10%">{L_JOINED}</th>
		<th class="thHead" align="center" width="5%">{L_COUNTER}</th>
		<th class="thHead" align="center" width="70%">{L_ADV_TITLE}</th>
	</tr>
	<tr>
		<td class="row1">&nbsp;</td>
		<td class="row1">&nbsp;</td>
		<td class="row1">&nbsp;</td>
		<td class="row1">&nbsp;</td>
		<td class="row1">{L_USERNAME} - {L_POSTS} , {L_VISIT} , {L_JOINED} , {L_LAST_VISIT}, IP</td>
	</tr>

	
	<!-- BEGIN list -->
	<tr>
		<td class="row{list.ROW}"><span class="nav">{list.USERNAME}</span></td>
		<td class="row{list.ROW}" align="center">{list.POSTS}</td>
		<td class="row{list.ROW}" nowrap="nowrap" align="center">{list.JOINED}</td>
		<td class="row{list.ROW}" align="center">{list.COUNTER}</td>
		<td class="row{list.ROW}"><span class="genmed"><table>{list.ADV_USERS}</table></td>
	</tr>
	<!-- END list -->
</table>
<table width="100%" cellspacing="2" cellpadding="2" border="0">
	<tr>
		<td><span class="nav">{PAGE_NUMBER}</span></td>
		<td align="right"><span class="nav">{PAGINATION}</span></td>
	</tr>
</table>
<br>