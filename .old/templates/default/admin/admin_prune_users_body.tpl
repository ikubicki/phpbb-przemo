<h1>{L_PRUNE_TITLE}</h1>

<P>{L_PRUNE_DESC}</p>

<form name="post" method="post" action="{S_PRUNE_ACTION}">
	<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	    <tr>
			<th align="center">{L_PRUNE_TITLE}</th>
	  	</tr>
		<tr>
		    <td class="row1" align="center">
    {L_USER_NAME}: 
<input type="text" class="post" name="username" maxlength="50" size="20">�<input type="submit" name="usersubmit" value="{L_FIND_USERNAME}" class="liteoption" onclick="window.open('{U_SEARCH_USER}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false;">
 			</td>
		</tr>
		<tr>
		    <td class="row2" align="center">		
    {L_FORUM_NAME}: 
      <select name="forum_id">
	  	<option value="all">{L_ALL_FORUMS}</option>
	<!-- BEGIN forums -->
		<option value="{forums.FORUM_ID}">{forums.FORUM_NAME}</option>
	<!-- END forums -->
      </select>
 			</td>
		</tr>
	<tr>
	  <td class="submit" align="center">
	  <input type="hidden" name="doprune" value="yes">
      <input type="submit" name="Submit" value="{L_BUTTON}" class="mainoption">
	  <input type="reset" value="{L_RESET}" class="liteoption" name="reset">
</td></tr>
</table>
</form>
<br>