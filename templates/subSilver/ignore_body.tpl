
<form action="{S_ACTION}" {S_FORM_ENCTYPE} method="post" name="post">
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
  <tr> 
	<th height="25">{L_IGNORE_LIST}</th>
  </tr>
  <tr> 
	<td height="28"><span class="cattitle"><b>{L_IGNORE_ADD}</b></span></td>
  </tr>
  <tr> 
	<td class="row1"> 
	  <table width="100%" height="30" cellspacing="0" cellpadding="0" border="0">
		<tr> 
		  <td class="row1"><span class="gen">{L_USERNAME}:</span></td>
		  <td class="row2">
		  	<!--<input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" style="width: 150px" name="ignore_username" size="20" maxlength="100">-->
			<span class="genmed"><input type="text" onFocus="Active(this)" onBlur="NotActive(this)" class="post" name="username" maxlength="25" size="25" tabindex="1" value="{USERNAME}">&nbsp;<input type="submit" name="usersubmit" value="{L_FIND_USERNAME}" class="liteoption" onClick="window.open('{U_SEARCH_USER}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false;"></span>&nbsp;&nbsp;</td>
			<td class="row2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption"></td>
		</tr>
	  </table>
	</td>
  </tr>
  <tr> 
	<td height="28"><span class="cattitle"><b>{L_IGNORED_USERS}</b></span></td>
  </tr>
  <!-- BEGIN userrow -->
  <tr> 
	<td class="{userrow.ROW_CLASS}"> 
	  <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr> 
		  <td>&nbsp;<span class="gen"><a href="{userrow.U_PROFILE}">{userrow.USERNAME}</a></span></td>
		  <td align="right">{userrow.DELETE_IMAGE}</a> 
			&nbsp;</td>
		</tr>
	  </table>
	</td>
  </tr>
  <!-- END userrow -->
</table>
</form>

<br clear="all">
