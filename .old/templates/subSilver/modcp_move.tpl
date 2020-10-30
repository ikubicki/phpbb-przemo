
<form action="{S_MODCP_ACTION}" method="post">
  <table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
	<tr> 
	  <th height="25"><b>{MESSAGE_TITLE}</b></th>
	</tr>
	<tr> 
	  <td class="row1"> 
		<table width="100%" border="0" cellspacing="0" cellpadding="1">
		  <tr> 
			<td>&nbsp;</td>
		  </tr>
		  <tr> 
			<td align="center"><span class="gen">{L_MOVE_TO_FORUM} &nbsp; {S_FORUM_SELECT}<br><br>
			  <input type="checkbox" name="move_leave_shadow">{L_LEAVESHADOW}<br>
			  <br>
			  <!-- BEGIN notify -->
			  <hr>
			  {L_REASON}<br><span class="gensmall">{L_REASON_E}</span><br>
			  <!-- BEGIN no_notify -->
			  <br>
			  <input type="checkbox" name="no_notify">{L_NO_NOTIFY}<br>
			  <!-- END no_notify -->
			  <br>
			  <textarea name="reason" class="post2" cols="60" rows="3"></textarea>
			  <hr>
			  <br>
			  <!-- END notify -->
			  {MESSAGE_TEXT}</span><br>
			  <br>
			  {S_HIDDEN_FIELDS} 
			  <input class="mainoption" type="submit" name="confirm" value="{L_YES}">
			  &nbsp;&nbsp; 
			  <input class="liteoption" type="submit" name="cancel" value="{L_NO}">
			</td>
		  </tr>
		  <tr> 
			<td>&nbsp;</td>
		  </tr>
		</table>
	  </td>
	</tr>
  </table>
</form>
