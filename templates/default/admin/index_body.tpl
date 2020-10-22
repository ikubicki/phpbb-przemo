
<h1>{L_WELCOME}</h1>
<p>{L_ADMIN_INTRO}</p>

<form action="{S_ACTION}" method="post" class="mainoption">
<table cellpadding="4" cellspacing="1" align="center" border="0" class="forumline"> 
   <tr> 
      <th nowrap="nowrap" align="center">{L_ADMIN_NOTES}</th>
   </tr>
   <tr>
      <td class="row2" align="center">&nbsp;<textarea name="admin_notes" cols="90" rows="6" class="post">{ADMIN_NOTES}</textarea><input type="hidden" name="save" value="1">
      &nbsp;<center><br><input class="mainoption" type="submit" name="submit" value="{L_SAVE}"></center></td>
   </tr>
</table>
</form>
<br>
<table width="99%" align="center" cellpadding="4" cellspacing="1" border="0" class="forumline">
   <tr>
      <th width="15%" height="25" colspan="4">&nbsp;{L_FORUM_STATS}&nbsp;</th>
  </tr>
  <tr>
      <td width="25%" nowrap="nowrap" height="25"><span class="cattitle">{L_STATISTIC}</span></td>
      <td width="25%" height="25"><span class="cattitle">{L_VALUE}</span></td>
      <td width="25%" nowrap="nowrap" height="25"><span class="cattitle">{L_STATISTIC}</span></td>
      <td width="25%" height="25"><span class="cattitle">{L_VALUE}</span></td>
  </tr>
  <tr>
      <td class="row1" nowrap="nowrap">{L_NUMBER_POSTS}:</td>
      <td class="row2"><b>{NUMBER_OF_POSTS}</b></td>
      <td class="row1" nowrap="nowrap">{L_POSTS_PER_DAY}:</td>
      <td class="row2"><b>{POSTS_PER_DAY}</b></td>
  </tr>
  <tr>
      <td class="row1" nowrap="nowrap">{L_NUMBER_TOPICS}:</td>
      <td class="row2"><b>{NUMBER_OF_TOPICS}</b></td>
      <td class="row1" nowrap="nowrap">{L_TOPICS_PER_DAY}:</td>
      <td class="row2"><b>{TOPICS_PER_DAY}</b></td>
  </tr>
  <tr>
      <td class="row1" nowrap="nowrap">{L_NUMBER_USERS}:</td>
      <td class="row2"><b>{NUMBER_OF_USERS}</b></td>
      <td class="row1" nowrap="nowrap">{L_USERS_PER_DAY}:</td>
      <td class="row2"><b>{USERS_PER_DAY}</b></td>
  </tr>
  <tr>
      <td class="row1" nowrap="nowrap">{L_BOARD_STARTED}:</td>
      <td class="row2"><b>{START_DATE}</b></td>
      <td class="row1" nowrap="nowrap">{L_GZIP_COMPRESSION}:</td>
      <td class="row2"><b>{GZIP_COMPRESSION}</b></td>
  </tr>
  <tr>
      <td class="row1" nowrap="nowrap">{L_DB_SIZE}:</td>
      <td class="row2"><b>{DB_SIZE}</b></td>
      <td class="row1" nowrap="nowrap">{L_AVATAR_DIR_SIZE}:</td>
      <td class="row2"><b>{AVATAR_DIR_SIZE}</b></td>
  </tr>
  <!-- BEGIN details -->
  <tr>
      <td colspan="4" align="center"><span class="nav">{L_DETAILS_TITLE}</span></td>
  </tr>
  <tr>
      <td class="row1" nowrap="nowrap" colspan="2" align="center"><b>{L_NAME}</b></td>
      <td class="row1" nowrap="nowrap" align="center"><b>{L_SIZE}</b></td>
      <td class="row1" nowrap="nowrap" align="center"><b>{L_COUNT}</b></td>
  </tr>
  <!-- BEGIN details_list -->
  <tr>
      <td class="row{details.details_list.ROW}" nowrap="nowrap" colspan="2" align="center">{details.details_list.NAME}</td>
      <td class="row{details.details_list.ROW}" nowrap="nowrap" align="center">{details.details_list.SIZE}</td>
      <td class="row{details.details_list.ROW}" nowrap="nowrap" align="center">{details.details_list.COUNT}</td>
  </tr>
  <!-- END details_list -->
  <!-- END details -->
</table>

<table width="99%" align="center" cellpadding="4" cellspacing="1" border="0">
	<tr> 
		<td align="right">{LINK_SHOW_HOSTS}</td>
	</tr>
</table>
<table width="99%" align="center" cellpadding="4" cellspacing="1" border="0" class="forumline">
  <tr>
      <th width="15%" height="25" colspan="6">&nbsp;{L_WHO_IS_ONLINE}&nbsp;</th>
  </tr>
  <tr>
      <td width="15%" height="25"><span class="cattitle">&nbsp;{L_USERNAME}&nbsp;</a></span></td>
      <td width="15%" height="25" align="center"><span class="cattitle">&nbsp;{L_STARTED}&nbsp;</span></td>
      <td width="10%" align="center"><span class="cattitle">&nbsp;{L_LAST_UPDATE}&nbsp;</span></td>
      <td width="10%" align="center"><span class="cattitle">&nbsp;{L_TIME}&nbsp;</span></td>
      <td width="25%"><span class="cattitle">&nbsp;{L_FORUM_LOCATION}&nbsp;</span></td>
      <td width="25%" height="25"><span class="cattitle">&nbsp;{L_IP_ADDRESS}&nbsp;</span></td>
  </tr>
  <!-- BEGIN reg_user_row -->
  <tr>
      <td width="15%" class="{reg_user_row.ROW_CLASS}">&nbsp;<span class="gen"><a href="{reg_user_row.U_USER_PROFILE}" class="gen" target="_blank"{reg_user_row.USERNAME_COLOR}>{reg_user_row.USERNAME}</a></span>&nbsp;</td>
      <td width="15%" align="center" class="{reg_user_row.ROW_CLASS}" nowrap="nowrap">&nbsp;<span class="gen">{reg_user_row.STARTED}</span>&nbsp;</td>
      <td width="10%" align="center" nowrap="nowrap" class="{reg_user_row.ROW_CLASS}">&nbsp;<span class="gen">{reg_user_row.LASTUPDATE}</span>&nbsp;</td>
      <td width="10%" align="center" nowrap="nowrap" class="{reg_user_row.ROW_CLASS}">&nbsp;<span class="gensmall">{reg_user_row.TIME}</span>&nbsp;</td>
      <td width="25%" class="{reg_user_row.ROW_CLASS}">&nbsp;<span class="gensmall">{reg_user_row.FORUM_LOCATION}</span>&nbsp;</td>
      <td width="25%" class="{reg_user_row.ROW_CLASS}">&nbsp;<span class="gen"><a href="{reg_user_row.U_WHOIS_IP}" class="gen" target="_phpbbwhois">{reg_user_row.IP_ADDRESS}</a></span><br><span class="gensmall">{reg_user_row.HOST}</span></td>
  </tr>
  <!-- END reg_user_row -->
  <tr>
      <td colspan="6" height="1" class="row3"><img src="../templates/subSilver/images/spacer.gif" width="1" height="1" alt="."></td>
  </tr>
  <!-- BEGIN guest_user_row -->
  <tr>
      <td width="15%" class="{guest_user_row.ROW_CLASS}">&nbsp;<span class="gen">{guest_user_row.USERNAME}</span>&nbsp;</td>
      <td width="15%" align="center" class="{guest_user_row.ROW_CLASS}">&nbsp;<span class="gen">{guest_user_row.STARTED}</span>&nbsp;</td>
      <td width="10%" align="center" nowrap="nowrap" class="{guest_user_row.ROW_CLASS}">&nbsp;<span class="gen">{guest_user_row.LASTUPDATE}</span>&nbsp;</td>
      <td width="10%" align="center" nowrap="nowrap" class="{guest_user_row.ROW_CLASS}">&nbsp;<span class="gensmall">{guest_user_row.TIME}</span>&nbsp;</td>
      <td width="25%" class="{guest_user_row.ROW_CLASS}">&nbsp;<span class="gensmall">{guest_user_row.FORUM_LOCATION}</span>&nbsp;</td>
      <td width="25%" class="{guest_user_row.ROW_CLASS}">&nbsp;<span class="gen"><a href="{guest_user_row.U_WHOIS_IP}" class="gen" target="_phpbbwhois">{guest_user_row.IP_ADDRESS}</a></span><br><span class="gensmall">{guest_user_row.HOST}</span></td>
  </tr>
  <!-- END guest_user_row -->
</table>
{JR_ADMIN_INFO_TABLE}
<br>
<table width="100%" cellpadding="1" cellspacing="1" border="0">
  <tr> 
     <td><a href="{U_CLEAR_CACHE}" class="gensmall">{L_CLEAR_CACHE}</a></td>
  </tr>
</table>
<br>