<h1>{L_GROUP_TITLE}</h1>
<script language=JavaScript src="../images/picker.js"></script>
<form action="{S_GROUP_ACTION}" method="post" name="pick_form"><table border="0" cellpadding="3" cellspacing="1" class="forumline" align="center">
	<tr> 
	  <th class="thHead" colspan="2">{L_GROUP_EDIT_DELETE}</th>
	</tr>
	<tr>
	  <td class="row1" colspan="2"><span class="gensmall">{L_ITEMS_REQUIRED}</span></td>
	</tr>
	<tr> 
	  <td class="row1" width="38%"><span class="gen">{L_GROUP_NAME}:</span></td>
	  <td class="row2" width="62%"> 
		<input type="text" name="group_name" class="post" size="35" maxlength="40" value="{GROUP_NAME}">
	  </td>
	</tr>
	<tr> 
	  <td class="row1" width="38%"><span class="gen">{L_GROUP_DESCRIPTION}:</span></td>
	  <td class="row2" width="62%"> 
		<textarea name="group_description" class="post" rows="5" cols="51">{GROUP_DESCRIPTION}</textarea>
	  </td>
	</tr>
	<tr> 
	  <td class="row1" width="38%"><span class="gen">{L_GROUP_MODERATOR}:</span></td>
	  <td class="row2" width="62%"><input type="text" class="post" name="username" maxlength="50" size="20" value="{GROUP_MODERATOR}"> &nbsp; <input type="submit" name="usersubmit" value="{L_FIND_USERNAME}" class="liteoption" onClick="window.open('{U_SEARCH_USER}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false;"></td>
	</tr>

	<tr> 
	  <td class="row1" width="38%"><span class="gen">{L_GROUP_STATUS}:</span></td>
	  <td class="row2" width="62%"> 
		<input type="radio" name="group_type" value="{S_GROUP_OPEN_TYPE}" {S_GROUP_OPEN_CHECKED}> {L_GROUP_OPEN} &nbsp;&nbsp;<input type="radio" name="group_type" value="{S_GROUP_CLOSED_TYPE}" {S_GROUP_CLOSED_CHECKED}>	{L_GROUP_CLOSED} &nbsp;&nbsp;<input type="radio" name="group_type" value="{S_GROUP_HIDDEN_TYPE}" {S_GROUP_HIDDEN_CHECKED}>	{L_GROUP_HIDDEN}</td> 
	</tr>
	<tr>
	  <td class="row1" width="38%"><span class="gen">{L_GROUP_COUNT}:</span><br/>
	  <span class="gensmall">{L_GROUP_COUNT_EXPLAIN}</span></td>
	  <td class="row2" width="62%"><input type="text" class="post" name="group_count" maxlength="12" size="12" value="{GROUP_COUNT}">
		<br><span class="gen"></span><input type="checkbox" name="group_count_enable" {GROUP_COUNT_ENABLE_CHECKED} >&nbsp;{L_GROUP_COUNT_ENABLE}
	  </td>
	</tr>
	<tr>
	  <td class="row1" width="38%"><span class="gen">{L_GROUP_COUNT_DELETE}:</span></td>
	  <td class="row2" width="62%"><input type="checkbox" name="group_count_delete" value="0"/></td>
	</tr>
	<tr>
	  <td class="row1" width="38%"><span class="gen">{L_GROUP_COUNT_UPDATE}:</span></td>
	  <td class="row2" width="62%"><input type="checkbox" name="group_count_update" value="0"/> <input type="text" class="post" name="group_add_posts" maxlength="12" size="8"></td>
	</tr>
	<tr>
	  <td class="row3" colspan="2"><span class="gensmall">{L_GROUP_COLOR_E}</span></td>
	</tr>
	<tr>
	  <td class="row1" width="38%"><span class="gen">{L_GROUP_COLOR}:</span></td>
	  <td class="row2" width="62%"><input type="text" class="post" name="group_color" maxlength="6" size="9" onKeyup="chng(this);" style="font-weight: bold; color: #{GROUP_COLOR}" value="{GROUP_COLOR}">
	  &nbsp;<a href="javascript:TCP.popup(document.forms['pick_form'].elements['group_color'])"><img src="../images/sel.gif" border="0"></a>
	  </td>
	</tr>
	<tr>
	  <td class="row1" width="38%"><span class="gen">{L_GROUP_PREFIX}:</span></td>
	  <td class="row2" width="62%"><input type="text" class="post" name="group_prefix" maxlength="8" size="9" value="{GROUP_PREFIX}">
	  </td>
	</tr>
	<tr>
	  <td class="row1" width="38%"><span class="gen">{L_GROUP_STYLE}:</span></td>
  	  <td class="row2" width="62%"><textarea name="group_style" cols="51" class="post">{GROUP_STYLE}</textarea>
	  <br><a href="javascript:displayWindow('../images/styles.html', 550, 450)">{L_EXAMPLES}</td>
	  </td>
	</tr>
	<tr>
	  <td class="row1" width="38%"><span class="gen">{L_GROUP_MAIL_ENABLE}</span></td>
	  <td class="row2" width="62%"><input type="checkbox" name="group_mail_enable" {GROUP_MAIL_ENABLE_CHECKED} > {L_YES}</td>
	</tr>
	<tr>
	  <td class="row1" width="38%"><span class="gen">{L_GROUP_NO_UNSUB}</span></td>
	  <td class="row2" width="62%"><input type="checkbox" name="group_no_unsub" {GROUP_NO_UNSUB_CHECKED} > {L_YES}</td>
	</tr>
	<!-- BEGIN group_edit -->
	<tr> 
	  <td class="row1" width="38%"><span class="gen">{L_DELETE_MODERATOR}</span>
	  <br>
	  <span class="gensmall">{L_DELETE_MODERATOR_EXPLAIN}</span></td>
	  <td class="row2" width="62%"> 
		<input type="checkbox" name="delete_old_moderator" value="1">
		{L_YES}</td>
	</tr>
	<tr> 
	  <td class="row1" width="38%"><span class="gen">{L_GROUP_DELETE}:</span></td>
	  <td class="row2" width="62%"> 
		<input type="checkbox" name="group_delete" value="1">
		{L_GROUP_DELETE_CHECK}</td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_UPLOAD_QUOTA}</span></td>
	  <td class="row2">{S_SELECT_UPLOAD_QUOTA}</td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_PM_QUOTA}</span></td>
	  <td class="row2">{S_SELECT_PM_QUOTA}</td>
	</tr>
	<!-- END group_edit -->
	<tr> 
	  <td class="catBottom" colspan="2" align="center"><span class="cattitle"> 
		<input type="submit" name="group_update" value="{L_SUBMIT}" class="mainoption">
		&nbsp;&nbsp; 
		<input type="reset" value="{L_RESET}" name="reset" class="liteoption">
		</span></td>
	</tr>
</table>{S_HIDDEN_FIELDS}</form>
<br>