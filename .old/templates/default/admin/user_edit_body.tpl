
<h1>{L_USER_TITLE}</h1>

<p>{L_USER_EXPLAIN}</p>

{ERROR_BOX}

<form action="{S_PROFILE_ACTION}" {S_FORM_ENCTYPE} method="post"><table width="98%" cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr> 
	  <th colspan="2">{L_REGISTRATION_INFO}</th>
	</tr>
	<tr> 
	  <td class="row2" colspan="2"><span class="gensmall">{L_ITEMS_REQUIRED}</span></td>
	</tr>
	<tr> 
	  <td class="row1" width="48%"><span class="gen">{L_USERNAME}: *</span></td>
	  <td class="row2"> 
		<input type="text" class="post" name="username" size="35" maxlength="40" value="{USERNAME}">
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_EMAIL_ADDRESS}: *</span></td>
	  <td class="row2"> 
		<input type="text" class="post" name="email" size="35" maxlength="255" value="{EMAIL}">
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_NEW_PASSWORD}: *</span><br>
		<span class="gensmall">{L_PASSWORD_IF_CHANGED}</span></td>
	  <td class="row2"> 
		<input type="password" class="post" name="password" size="35" maxlength="100" value="">
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_CONFIRM_PASSWORD}: * </span><br>
		<span class="gensmall">{L_PASSWORD_CONFIRM_IF_CHANGED}</span></td>
	  <td class="row2"> 
		<input type="password" class="post" name="password_confirm" size="35" maxlength="100" value="">
	  </td>
	</tr>
	<tr> 
	  <td class="catsides" colspan="2">&nbsp;</td>
	</tr>
	<tr> 
	  <th class="thSides" colspan="2">{L_PROFILE_INFO}</th>
	</tr>
	<tr> 
	  <td class="row2" colspan="2"><span class="gensmall">{L_PROFILE_INFO_NOTICE}</span></td>
	</tr>
	<!-- BEGIN custom_fields -->
	<tr> 
		<td class="row1"><span class="gen">{custom_fields.L_CUSTOM_FIELD}</span></td>
		<td class="row2"><textarea name="{custom_fields.FIELD_NAME}" style="width: 300px" rows="2" cols="30" class="post">{custom_fields.FIELD}</textarea></td>
	</tr>
	<!-- END custom_fields -->
        <tr> 
          <td class="row1"><span class="gen">{L_CUSTOM_COLOR}</span></td> 
          <td class="row2"> 
		<select class="post" name="custom_color">
		<option class="post" style="color:black" value="" class="genmed" {DEFAULT_SELECT}>{L_COLOR_DEFAULT}</option>
		<option style="color:darkred" value="CC0000" class="genmed" {DARK_RED_SELECT}>{L_COLOR_DARK_RED}</option>
		<option style="color:red" value="FF3300" class="genmed" {RED_SELECT}>{L_COLOR_RED}</option>
		<option style="color:orange" value="FF9900" class="genmed" {ORANGE_SELECT}>{L_COLOR_ORANGE}</option>
		<option style="color:brown" value="800000" class="genmed" {BROWN_SELECT}>{L_COLOR_BROWN}</option>
		<option style="color:yellow" value="FFFF00" class="genmed" {YELLOW_SELECT}>{L_COLOR_YELLOW}</option>
		<option style="color:green" value="008000" class="genmed" {GREEN_SELECT}>{L_COLOR_GREEN}</option>
		<option style="color:olive" value="808000" class="genmed" {OLIVE_SELECT}>{L_COLOR_OLIVE}</option>
		<option style="color:cyan" value="33FFFF" class="genmed" {CYAN_SELECT}>{L_COLOR_CYAN}</option>
		<option style="color:blue" value="3366FF" class="genmed" {BLUE_SELECT}>{L_COLOR_BLUE}</option>
		<option style="color:darkblue" value="000080" class="genmed" {DARK_BLUE_SELECT}>{L_COLOR_DARK_BLUE}</option>
		<option style="color:indigo" value="990099" class="genmed" {INDIGO_SELECT}>{L_COLOR_INDIGO}</option>
		<option style="color:violet" value="CC66CC" class="genmed" {VIOLET_SELECT}>{L_COLOR_VIOLET}</option>
		<option style="color:white" value="F5FFFA" class="genmed" {WHITE_SELECT}>{L_COLOR_WHITE}</option>
		<option style="color:black" value="000000" class="genmed" {BLACK_SELECT}>{L_COLOR_BLACK}</option></select>         </td> 
        </tr>
        <tr> 
		<td class="row1"><span class="gen">{L_CUSTOM_RANK}</span></td> 
		<td class="row2"> 
                <input type="text" class="post" name="custom_rank" size="20" maxlength="50" value="{CUSTOM_RANK}"> 
        </td> 
        </tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_ICQ_NUMBER}</span></td>
	  <td class="row2"> 
		<input type="text" class="post" name="icq" size="20" maxlength="15" value="{ICQ}">
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_AIM}</span></td>
	  <td class="row2"> 
		<input type="text" class="post" name="aim" size="20" maxlength="255" value="{AIM}">
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_MESSENGER}</span></td>
	  <td class="row2"> 
		<input type="text" class="post" name="msn" size="20" maxlength="255" value="{MSN}">
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_YAHOO}</span></td>
	  <td class="row2"> 
		<input type="text" class="post" name="yim" size="20" maxlength="255" value="{YIM}">
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_WEBSITE}</span></td>
	  <td class="row2"> 
		<input type="text" class="post" name="website" size="35" maxlength="255" value="{WEBSITE}">
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_LOCATION}</span></td>
	  <td class="row2"> 
		<input type="text" class="post" name="location" size="35" maxlength="100" value="{LOCATION}">
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_OCCUPATION}</span></td>
	  <td class="row2"> 
		<input type="text" class="post" name="occupation" size="35" maxlength="100" value="{OCCUPATION}">
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_INTERESTS}</span></td>
	  <td class="row2"> 
		<input type="text" class="post" name="interests" size="35" maxlength="150" value="{INTERESTS}">
	  </td>
	</tr>
	<tr>
	      <td class="row1"><span class="gen">{L_GENDER}:</span></td>
	      <td class="row2">
	      <input type="radio" name="gender" value="0" {GENDER_NO_SPECIFY_CHECKED}/>
	      <span class="gen">{L_GENDER_NOT_SPECIFY}</span>&nbsp;&nbsp;
	      <input type="radio" name="gender" value="1" {GENDER_MALE_CHECKED}/>
	      <span class="gen">{L_GENDER_MALE}</span>&nbsp;&nbsp;
	      <input type="radio" name="gender" value="2" {GENDER_FEMALE_CHECKED}/>
	      <span class="gen">{L_GENDER_FEMALE}</span></td>
	</tr>
	<tr> 
	  <td class="catsides" colspan="2"><span class="cattitle">&nbsp;</span></td>
	</tr>
	<tr> 
	  <th class="thSides" colspan="2">{L_PREFERENCES}</th>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_LOG_IN_CHECK}</span><br><span class="gensmall">{L_LOG_IN_CHECK_E}</span></td>
	  <td class="row2"> 
		<input type="radio" name="user_ip_login_check" value="1" {LOG_IN_CHECK_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="user_ip_login_check" value="0" {LOG_IN_CHECK_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_PUBLIC_VIEW_EMAIL}</span></td>
	  <td class="row2"> 
		<input type="radio" name="viewemail" value="1" {VIEW_EMAIL_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="viewemail" value="0" {VIEW_EMAIL_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_PUBLIC_VIEW_AIM}</span></td>
	  <td class="row2"> 
		<input type="radio" name="viewaim" value="1" {VIEW_AIM_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="viewaim" value="0" {VIEW_AIM_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_HIDE_USER}</span></td>
	  <td class="row2"> 
		<input type="radio" name="hideonline" value="1" {HIDE_USER_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="hideonline" value="0" {HIDE_USER_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_NOTIFY_ON_REPLY}</span></td>
	  <td class="row2"> 
		<input type="radio" name="notifyreply" value="1" {NOTIFY_REPLY_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="notifyreply" value="0" {NOTIFY_REPLY_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_NOTIFY_ON_PRIVMSG}</span></td>
	  <td class="row2"> 
		<input type="radio" name="notifypm" value="1" {NOTIFY_PM_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="notifypm" value="0" {NOTIFY_PM_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_POPUP_ON_PRIVMSG}</span></td>
	  <td class="row2"> 
		<input type="radio" name="popup_pm" value="1" {POPUP_PM_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="popup_pm" value="0" {POPUP_PM_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_ALLOWPM}:</span></td>
	  <td class="row2"> 
		<input type="radio" name="allowpm" value="1" {ALLOWPM_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="allowpm" value="0" {ALLOWPM_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_NOTIFY_GG}:</span></td>
	  <td class="row2"> 
		<input type="radio" name="user_notify_gg" value="1" {NOTIFY_GG_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="user_notify_gg" value="0" {NOTIFY_GG_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_ALWAYS_ALLOW_BBCODE}</span></td>
	  <td class="row2"> 
		<input type="radio" name="allowbbcode" value="1" {ALWAYS_ALLOW_BBCODE_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="allowbbcode" value="0" {ALWAYS_ALLOW_BBCODE_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_ALWAYS_ALLOW_HTML}</span></td>
	  <td class="row2"> 
		<input type="radio" name="allowhtml" value="1" {ALWAYS_ALLOW_HTML_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="allowhtml" value="0" {ALWAYS_ALLOW_HTML_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_ALWAYS_ALLOW_SMILIES}</span></td>
	  <td class="row2"> 
		<input type="radio" name="allowsmilies" value="1" {ALWAYS_ALLOW_SMILIES_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="allowsmilies" value="0" {ALWAYS_ALLOW_SMILIES_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_BOARD_LANGUAGE}</span></td>
	  <td class="row2">{LANGUAGE_SELECT}</td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_BOARD_STYLE}</span></td>
	  <td class="row2">{STYLE_SELECT}</td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_TIMEZONE}</span></td>
	  <td class="row2">{TIMEZONE_SELECT}</td>
	</tr>
	<tr> 
	  <td class="catSides" colspan="2"><span class="cattitle">&nbsp;</span></td>
	</tr>
	<tr>
	  <th class="thSides" colspan="2" height="12" valign="middle">{L_SIGNATURE_PANEL}</th>
	</tr>
	<tr>
		<td class="row1" colspan="2"><table width="100%" cellspacing="2" cellpadding="0" border="0" align="center">
			<tr>
				<td width="65%"><span class="gensmall">{L_SIGNATURE_EXPLAIN}</span></td>
				<td align="center"><span class="gensmall">{L_CURRENT_IMAGE}</span><br><div align="right">{SIGNATURE_IMAGE}</div><br><input type="checkbox" name="sig_image_del">&nbsp;<span class="gensmall">{L_DELETE_SIGNATURE_IMAGE}</span></td>
			</tr>
		</table></td>
	</tr>
	<!-- BEGIN switch_signature_local -->
	<tr>
		<td class="row1"><span class="gen">{L_UPLOAD_SIGNATURE_FILE}</span></td>
		<td class="row2"><input type="hidden" name="MAX_FILE_SIZE" value="{SIG_IMAGE_SIZE}"><input type="file" name="sig_image" class="post" style="width:200px"></td>
	</tr>
	<!-- END switch_signature_local -->
	<!-- BEGIN switch_signature_remote -->
	<tr> 
		<td class="row1"><span class="gen">{L_UPLOAD_SIGNATURE_URL}</span><br><span class="gensmall">{L_UPLOAD_SIGNATURE_URL_EXPLAIN}</span></td>
		<td class="row2"><input type="text" name="sig_image_url" size="40" class="post" style="width:200px"></td>
	</tr>
	<!-- END switch_signature_remote -->
	<tr>
	  <td class="row1"><span class="gen">{L_SIGNATURE_TEXT}</span><br><span class="gensmall">{L_SIGNATURE_TEXT_EXPLAIN}<br><br>{HTML_STATUS}<br>{BBCODE_STATUS}<br>{SMILIES_STATUS}</span></td>
	  <td class="row2"> 
		<textarea name="signature" style="width: 300px" rows="6" cols="30" class="post">{SIGNATURE}</textarea>
	  </td>
	</tr>
	<tr>
	  <td class="row1"><span class="gen">{L_ALWAYS_ADD_SIGNATURE}</span></td>
	  <td class="row2">
		<input type="radio" name="attachsig" value="1" {ALWAYS_ADD_SIGNATURE_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp;
		<input type="radio" name="attachsig" value="0" {ALWAYS_ADD_SIGNATURE_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="catSides" colspan="2"><span class="cattitle">&nbsp;</span></td>
	</tr>
	<tr> 
	  <th class="thSides" colspan="2" height="12" valign="middle">{L_AVATAR_PANEL}</th>
	</tr>
	<tr align="center"> 
	  <td class="row1" colspan="2"> 
		<table width="70%" cellspacing="2" cellpadding="0" border="0">
		  <tr> 
			<td width="65%"><span class="gensmall">{L_AVATAR_EXPLAIN}</span></td>
			<td align="center"><span class="gensmall">{L_CURRENT_IMAGE}</span><br>
			  {AVATAR}<br>
			  <input type="checkbox" name="avatardel">
			  &nbsp;<span class="gensmall">{L_DELETE_AVATAR}</span></td>
		  </tr>
		</table>
	  </td>
	</tr>
	<!-- BEGIN avatar_local_upload -->
	<tr> 
	  <td class="row1"><span class="gen">{L_UPLOAD_AVATAR_FILE}</span></td>
	  <td class="row2"> 
		<input type="hidden" name="MAX_FILE_SIZE" value="{AVATAR_SIZE}">
		<input type="file" name="avatar" class="post" style="width: 200px" >
	  </td>
	</tr>
	<!-- END avatar_local_upload -->
	<!-- BEGIN avatar_remote_upload -->
	<tr> 
	  <td class="row1"><span class="gen">{L_UPLOAD_AVATAR_URL}</span></td>
	  <td class="row2"> 
		<input type="text" name="avatarurl" size="40" class="post" style="width: 200px" >
	  </td>
	</tr>
	<!-- END avatar_remote_upload -->
	<!-- BEGIN avatar_remote_link -->
	<tr> 
	  <td class="row1"><span class="gen">{L_LINK_REMOTE_AVATAR}</span></td>
	  <td class="row2"> 
		<input type="text" name="avatarremoteurl" size="40" class="post" style="width: 200px" >
	  </td>
	</tr>
	<!-- END avatar_remote_link -->
	<!-- BEGIN avatar_local_gallery -->
	<tr> 
	  <td class="row1"><span class="gen">{L_AVATAR_GALLERY}</span></td>
	  <td class="row2"> 
		<input type="submit" name="avatargallery" value="{L_SHOW_GALLERY}" class="liteoption">
	  </td>
	</tr>
	<!-- END avatar_local_gallery -->

	<tr> 
	  <td class="catSides" colspan="2">&nbsp;</td>
	</tr>
	<tr>
	  <th class="thSides" colspan="2">{L_SPECIAL}</th>
	</tr>
	<tr>
	  <td class="row1" colspan="2"><span class="gensmall">{L_SPECIAL_EXPLAIN}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_UPLOAD_QUOTA}</span></td>
	  <td class="row2">{S_SELECT_UPLOAD_QUOTA}</td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_PM_QUOTA}</span></td>
	  <td class="row2">{S_SELECT_PM_QUOTA}</td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_ALLOW_PM}</span></td>
	  <td class="row2"> 
		<input type="radio" name="user_allowpm" value="1" {ALLOW_PM_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="user_allowpm" value="0" {ALLOW_PM_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_ALLOW_AVATAR}</span></td>
	  <td class="row2"> 
		<input type="radio" name="user_allowavatar" value="1" {ALLOW_AVATAR_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="user_allowavatar" value="0" {ALLOW_AVATAR_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_ALLOW_SIG}</span></td>
	  <td class="row2"> 
		<input type="radio" name="user_allowsig" value="1" {ALLOW_SIG_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="user_allowsig" value="0" {ALLOW_SIG_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{CAN_CUSTOM_RANKS}</span></td>
	  <td class="row2"> 
		<input type="radio" name="can_custom_ranks" value="1" {CAN_CUSTOM_RANKS_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="can_custom_ranks" value="0" {CAN_CUSTOM_RANKS_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{CAN_CUSTOM_COLOR}</span></td>
	  <td class="row2"> 
		<input type="radio" name="can_custom_color" value="1" {CAN_CUSTOM_COLOR_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="can_custom_color" value="0" {CAN_CUSTOM_COLOR_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{CAN_TOPIC_COLOR}</span></td>
	  <td class="row2"> 
		<input type="radio" name="can_topic_color" value="1" {CAN_TOPIC_COLOR_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="can_topic_color" value="0" {CAN_TOPIC_COLOR_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_ALLOW_HELPED}</span><br><span class="gensmall">{L_ALLOW_HELPED_E}</span></td>
	  <td class="row2"> 
		<input type="radio" name="user_allow_helped" value="1" {ALLOW_HELPED_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="user_allow_helped" value="0" {ALLOW_HELPED_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<!-- BEGIN custom_fields -->
	<tr>
		<td class="row1"><span class="gen">{custom_fields.L_CUSTOM_ALLOW_FIELD}</span></td>
		<td class="row2"> 
		<input type="radio" name="{custom_fields.ALLOW_FIELD_NAME}" value="1" {custom_fields.ALLOW_FIELD_NAME_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="{custom_fields.ALLOW_FIELD_NAME}" value="0" {custom_fields.ALLOW_FIELD_NAME_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<!-- END custom_fields -->
	<tr>
		<td class="row1"><span class="gen">{L_SELECT_RANK}</span></td>
		<td class="row2"><select name="user_rank">{RANK_SELECT_BOX}</select></td>
	</tr>
	<tr> 
	<td class="row1"><span class="gen">{L_DISALLOW_FORUMS}</span><br><span class="gensmall">{L_DISALLOW_FORUMS_E}</span></td> 
	<td class="row2"><select class="post" name="disallow_forums[]" size="7" multiple>{S_DISALLOW_OPTIONS}<option value="">--</option></select></td> 
	</tr>
	<tr> 
	   <td class="row1"><span class="gen">{L_ACCOUNT_BLOCK}:</span><br><span class="gensmall">{L_ACCOUNT_BLOCK_EXPLAIN}<br></td> 
	   <td class="row2">
		{L_BAD_LOGIN_COUNT}: {BAD_LOGIN_COUNT}<br/>
		{BLOCK_UNTIL}{BLOCK_BY}
		{BLOCK}</td> 
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_USER_ACTIVE}</span></td>
	  <td class="row2"> 
		<input type="radio" name="user_status" value="1" {USER_ACTIVE_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="user_status" value="0" {USER_ACTIVE_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_DELETE_USER}</span><br><span class="gensmall">{L_DELETE_USER_EXPLAIN}</span></td>
	  <td class="row2" align="right"> 
		<input type="checkbox" name="deleteuser"></td>
	</tr>
	<tr> 
	  <td class="submit" colspan="2" align="center">{S_HIDDEN_FIELDS} 
		<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption">
		&nbsp;&nbsp; 
		<input type="reset" value="{L_RESET}" class="liteoption">
	  </td>
	</tr>
</table></form>
<br>