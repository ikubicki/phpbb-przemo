{ERROR_BOX}
<form action="{S_PROFILE_ACTION}" {S_FORM_ENCTYPE} method="post">
<!-- BEGIN switch_namechange_disallowed -->
<input type="hidden" name="username" value="{USERNAME}">
<!-- END switch_namechange_disallowed -->


<table border="0" cellpadding="2" cellspacing="1" width="100%" class="forumline posting">
	<tr> 
		<th colspan="2" valign="middle">
			{L_REGISTRATION_INFO}
			<span class="gensmall description">{L_ITEMS_REQUIRED}</span>
		</th>
	</tr>
	<!-- BEGIN switch_namechange_allowed -->
	<tr> 
		<td class="row1" width="38%"><span class="gen">{L_USERNAME}: *</span></td>
		<td class="row1"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" style="width:200px" name="username" size="25" maxlength="15" value="{USERNAME}"></td>
	</tr>
	<!-- END switch_namechange_allowed -->
	<!-- BEGIN switch_register --> 
	<tr> 
        <td class="row1"><span class="gen">{L_EMAIL_ADDRESS}: *</span><br /> 
        <span class="gensmall">{L_EMAIL_EXPLAIN}</td> 
        <td class="row1"> 
        <input type="text" class="post" style="width:100px" name="email1" size="25" maxlength="200" value="" /> 
        <span class="genmed">@</span> 
        <input type="text" class="post" style="width:100px" name="email2" size="25" maxlength="200" value="" /> 
        </td> 
	</tr> 
	<!-- END switch_register --> 
	<!-- BEGIN switch_edit_profile -->
    <tr> 
        <td class="row1"><span class="gen">{L_EMAIL_ADDRESS}: *</span></td> 
        <td class="row1"><input type="text" class="post" style="width:200px" name="email1" size="25" maxlength="255" value="{EMAIL}" /></td> 
    </tr> 	
	<tr> 
	  <td class="row1"><span class="gen">{L_CURRENT_PASSWORD}: *</span><br><span class="gensmall">{L_CONFIRM_PASSWORD_EXPLAIN}</span></td>
		<td class="row1"> <input type="password" class="post" onFocus="Active(this)" onBlur="NotActive(this)" style="width: 200px" name="cur_password" size="25" maxlength="100" value="{CUR_PASSWORD}"></td>
	</tr>
	<!-- END switch_edit_profile -->
	<tr> 
	  <td class="row1" width="38%"><span class="gen">{L_NEW_PASSWORD}: *</span><br><span class="gensmall">{L_PASSWORD_IF_CHANGED}</span></td>
	  <td class="row1"><input type="password" class="post" onFocus="Active(this)" onBlur="NotActive(this)" style="width: 200px" name="new_password" size="25" maxlength="100" value="{NEW_PASSWORD}"></td>
	</tr>
	<tr>
	  <td class="row1"><span class="gen">{L_CONFIRM_PASSWORD}: * </span><br><span class="gensmall">{L_PASSWORD_CONFIRM_IF_CHANGED}</span></td>
	  <td class="row1"><input type="password" class="post" onFocus="Active(this)" onBlur="NotActive(this)" style="width: 200px" name="password_confirm" size="25" maxlength="100" value="{PASSWORD_CONFIRM}"></td>
	</tr>
	<!-- BEGIN validation -->
	<tr>
	  <td class="row1" valign="top"><span class="gen">{validation.L_VALIDATION}:<br></span><span class="gensmall">{validation.L_VALIDATION_EXPLAIN}</span></td>
	  <td class="row1" align="left"><span class="gen">{validation.VALIDATION}<br><input type="text" name="reg_key" class="post" onFocus="Active(this)" onBlur="NotActive(this)" maxlength="4" size="24"></span></td>
	</tr>
	<!-- END validation -->
	<tr>
	  <td class="submit" align="center" colspan="2">&nbsp;<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption">&nbsp;&nbsp;<input type="reset" value="{L_RESET}" name="reset" class="liteoption"></td>
	</tr>
	<tr> 
		<th colspan="2" valign="middle">
	  		{L_PROFILE_INFO}
			<span class="gensmall description">{L_PROFILE_INFO_NOTICE}</span>
		</th>
	</tr>
	<!-- BEGIN custom_fields -->
	<tr>
		<td class="row1"><span class="gen">{custom_fields.CF_DESCRIPTION}</span></td>
		<td class="row1">
		<!-- BEGIN input_text -->
		<input type="text" size="35" style="width: 200px" name="{custom_fields.input_text.INPUT_NAME}" maxlength="{custom_fields.input_text.INPUT_MAXVALUE}" value="{custom_fields.input_text.INPUT_VALUE}" class="post" onFocus="Active(this)" onBlur="NotActive(this)">
		<!-- END input_text -->
		<!-- BEGIN input_textarea -->
		<textarea cols="30" rows="2" name="{custom_fields.input_textarea.INPUT_NAME}" class="post" onFocus="Active(this)" onBlur="NotActive(this)">{custom_fields.input_textarea.INPUT_VALUE}</textarea>
		<!-- END input_textarea -->
		<!-- BEGIN jumpbox -->
		{custom_fields.jumpbox.INPUT}
		<!-- END jumpbox -->
		</td>
	</tr>
	<!-- END custom_fields -->
	<!-- BEGIN custom_color -->
	<tr>
	<td class="row1"><span class="gen">{custom_color.L_CUSTOM_color}:</span><br><span class="gensmall">{custom_color.L_CUSTOM_color_EXPLAIN}<br></span></td>
	<td class="row1">
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
			<option style="color:black" value="000000" class="genmed" {BLACK_SELECT}>{L_COLOR_BLACK}</option></select>
	</td>
	</tr>
	<!-- END custom_color -->
	<!-- BEGIN custom_rank -->
    <tr> 
	<td class="row1"><span class="gen">{custom_rank.L_CUSTOM_RANK}:</span><br><span class="gensmall">{custom_rank.L_CUSTOM_RANK_EXPLAIN}<br></span></td>
	<td class="row1"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" style="width: 200px" name="custom_rank" size="35" maxlength="50" value="{custom_rank.CUSTOM_RANK}"></td>
    </tr>
	<!-- END custom_rank -->
	<tr>
	  <td class="row1"><span class="gen">{L_WEBSITE}:</span></td>
	  <td class="row1"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" style="width: 200px" name="website" size="25" maxlength="255" value="{WEBSITE}"></td>
	</tr>
	<tr>
	  <td class="row1"><span class="gen">{L_LOCATION}:</span></td>
	  <td class="row1"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" style="width: 200px" name="location" size="25" maxlength="100" value="{LOCATION}"></td>
	</tr>
	<!-- BEGIN job -->
	<tr>
	  <td class="row1"><span class="gen">{L_OCCUPATION}:</span></td>
	  <td class="row1"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" style="width: 200px" name="occupation" size="25" maxlength="100" value="{OCCUPATION}"></td>
	</tr>
	<!-- END job -->
	<!-- BEGIN interests -->
	<tr>
	  <td class="row1"><span class="gen">{L_INTERESTS}:</span></td>
	  <td class="row1"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" style="width: 200px" name="interests" size="35" maxlength="150" value="{INTERESTS}"></td>
	</tr>
	<!-- END interests -->
	<!-- BEGIN switch_gender -->
	<tr>
		<td class="row1"><span class="gen">{L_GENDER}:</span></td>
		<td class="row1">
		<!--<input type="radio" {LOCK_GENDER} name="gender" value="0" {GENDER_NO_SPECIFY_CHECKED}/>
		<span class="gen">{L_GENDER_NOT_SPECIFY}</span>&nbsp;&nbsp;-->
		<input type="radio" name="gender" value="1" {GENDER_MALE_CHECKED}/>
		<span class="gen">{L_GENDER_MALE}</span>&nbsp;&nbsp;
		<input type="radio" name="gender" value="2" {GENDER_FEMALE_CHECKED}/><span class="gen">{L_GENDER_FEMALE}</span></td>
	</tr>
	<!-- END switch_gender -->
	<tr> 
	  <td class="submit" colspan="2">&nbsp;</td>
	</tr>
	<tr> 
	  <th colspan="2" valign="middle">{L_PREFERENCES}</th>
	</tr>
	<!-- BEGIN email -->
	<tr> 
	  <td class="row1"><span class="gen">{L_PUBLIC_VIEW_EMAIL}:</span></td>
	  <td class="row1"> 
		<input type="radio" name="viewemail" value="1" {VIEW_EMAIL_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="viewemail" value="0" {VIEW_EMAIL_NO}><span class="gen">{L_NO}</span></td>
	</tr>
	<!-- END email -->
	<tr> 
	  <td class="row1"><span class="gen">{L_HIDE_USER}:</span></td>
	  <td class="row1"> 
		<input type="radio" name="hideonline" value="1" {HIDE_USER_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="hideonline" value="0" {HIDE_USER_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr>
	  <td class="row1"><span class="gen">{L_NOTIFY_ON_REPLY}:</span><br>
		<span class="gensmall">{L_NOTIFY_ON_REPLY_EXPLAIN}</span></td>
	  <td class="row1"> 
		<input type="radio" name="notifyreply" value="1" {NOTIFY_REPLY_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="notifyreply" value="0" {NOTIFY_REPLY_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<!-- BEGIN switch_report -->
	<tr> 
	  <td class="row1"><span class="gen">{switch_report.L_NO_REPORT_POPUP}:</span></td>
	  <td class="row1"> 
		<input type="radio" name="no_report_popup" value="0" {switch_report.NO_REPORT_POPUP_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="no_report_popup" value="1" {switch_report.NO_REPORT_POPUP_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{switch_report.L_NO_REPORT_MAIL}:</span></td>
	  <td class="row1"> 
		<input type="radio" name="no_report_mail" value="0" {switch_report.NO_REPORT_MAIL_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="no_report_mail" value="1" {switch_report.NO_REPORT_MAIL_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<!-- END switch_report -->
	<tr> 
	  <td class="row1"><span class="gen">{L_NOTIFY_ON_PRIVMSG}:</span></td>
	  <td class="row1"> 
		<input type="radio" name="notifypm" value="1" {NOTIFY_PM_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="notifypm" value="0" {NOTIFY_PM_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_POPUP_ON_PRIVMSG}:</span><br><span class="gensmall">{L_POPUP_ON_PRIVMSG_EXPLAIN}</span></td>
	  <td class="row1"> 
		<input type="radio" name="popup_pm" value="1" {POPUP_PM_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="popup_pm" value="0" {POPUP_PM_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_ALLOWPM}:</span><br><span class="gensmall">{L_ALLOWPM_E}</span></td>
	  <td class="row1"> 
		<input type="radio" name="allowpm" value="1" {ALLOWPM_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="allowpm" value="0" {ALLOWPM_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<!-- BEGIN switch_ip_login_check -->
	<tr> 
	  <td class="row1"><span class="gen">{L_LOG_IN_CHECK}:</span><br><span class="gensmall">{L_LOG_IN_CHECK_E}</span></td>
	  <td class="row1"> 
		<input type="radio" name="user_ip_login_check" value="1" {LOG_IN_CHECK_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="user_ip_login_check" value="0" {LOG_IN_CHECK_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<!-- END switch_ip_login_check -->
	<!-- BEGIN bbcode -->
	<tr> 
	  <td class="row1"><span class="gen">{L_ALWAYS_ALLOW_BBCODE}:</span></td>
	  <td class="row1"> 
		<input type="radio" name="allowbbcode" value="1" {ALWAYS_ALLOW_BBCODE_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp;
		<input type="radio" name="allowbbcode" value="0" {ALWAYS_ALLOW_BBCODE_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<!-- END bbcode -->
	<!-- BEGIN html -->
	<tr> 
	  <td class="row1"><span class="gen">{L_ALWAYS_ALLOW_HTML}:</span></td>
	  <td class="row1"> 
		<input type="radio" name="allowhtml" value="1" {ALWAYS_ALLOW_HTML_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="allowhtml" value="0" {ALWAYS_ALLOW_HTML_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<!-- END html -->
	<!-- BEGIN smiles -->
	<tr> 
	  <td class="row1"><span class="gen">{L_ALWAYS_ALLOW_SMILIES}:</span></td>
	  <td class="row1"> 
		<input type="radio" name="allowsmilies" value="1" {ALWAYS_ALLOW_SMILIES_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="allowsmilies" value="0" {ALWAYS_ALLOW_SMILIES_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<!-- END smiles -->
	<!-- BEGIN lang -->
	<tr> 
		<td class="row1"><span class="gen">{L_BOARD_LANGUAGE}:</span></td>
		<td class="row1"><span class="gensmall">{LANGUAGE_SELECT}</span></td>
	</tr>
	<!-- END lang -->
	<!-- BEGIN style -->
	<tr> 
		<td class="row1"><span class="gen">{L_BOARD_STYLE}:</span></td>
		<td class="row1"><span class="gensmall">{STYLE_SELECT}</span></td>
	</tr>
	<!-- END style -->
	<!-- BEGIN timezone -->
	<tr> 
	  <td class="row1"><span class="gen">{L_TIMEZONE}:</span></td>
	  <td class="row1"><span class="gensmall">{TIMEZONE_SELECT}</span></td>
	</tr>
	<!-- END timezone -->
	<!-- BEGIN switch_signature_block -->
	<tr>
	  <td class="submit" colspan="2">&nbsp;</td>
	</tr>
	<tr>
	  	<th colspan="2" valign="middle">
	  		{L_SIGNATURE_PANEL}
			<span class="gensmall description">{L_SIGNATURE_EXPLAIN}</span>
		</th>
	</tr>
	<!-- BEGIN switch_signature_allowimage -->
	<tr>
		<td class="row1"><span class="gen">{L_CURRENT_IMAGE}</span></td>
		<td class="row1">
			<div align="center">{switch_signature_block.SIGNATURE_IMAGE}</div>
			<input type="checkbox" name="sig_image_del">
			<span class="gensmall">{L_DELETE_SIGNATURE_IMAGE}</span>
		</td>
	</tr>
	<!-- END switch_signature_allowimage -->
	<!-- BEGIN switch_signature_local -->
	<tr>
		<td class="row1"><span class="gen">{L_UPLOAD_SIGNATURE_FILE}:</span></td>
		<td class="row1"><input type="hidden" name="MAX_FILE_SIZE" value="{SIG_IMAGE_SIZE}"><input type="file" name="sig_image" class="post" onFocus="Active(this)" onBlur="NotActive(this)" style="width:200px"></td>
	</tr>
	<!-- END switch_signature_local -->
	<!-- BEGIN switch_signature_remote -->
	<tr> 
		<td class="row1"><span class="gen">{L_UPLOAD_SIGNATURE_URL}:</span><br><span class="gensmall">{L_UPLOAD_SIGNATURE_URL_EXPLAIN}</span></td>
		<td class="row1"><input type="text" name="sig_image_url" size="40" class="post" onFocus="Active(this)" onBlur="NotActive(this)" style="width:200px"></td>
	</tr>
	<!-- END switch_signature_remote -->
	<tr>
	  <td class="row1"><span class="gen">{L_SIGNATURE_TEXT}:</span><br><span class="gensmall">{L_SIGNATURE_TEXT_EXPLAIN}<br><br>{HTML_STATUS}<br>{BBCODE_STATUS}<br>{SMILIES_STATUS}</span></td>
	  <td class="row1"> 
		<textarea name="signature" style="width: 300px" rows="6" cols="30" class="post" onFocus="Active(this)" onBlur="NotActive(this)">{switch_signature_block.SIGNATURE}</textarea></td>
	</tr>
	<tr>
	  <td class="row1"><span class="gen">{L_ALWAYS_ADD_SIGNATURE}:</span></td>
	  <td class="row1">
		<input type="radio" name="attachsig" value="1" {switch_signature_block.ALWAYS_ADD_SIGNATURE_YES}>
		<span class="gen">{L_YES}</span>&nbsp;&nbsp;
		<input type="radio" name="attachsig" value="0" {switch_signature_block.ALWAYS_ADD_SIGNATURE_NO}>
		<span class="gen">{L_NO}</span></td>
	</tr>
	<!-- END switch_signature_block -->
	<!-- BEGIN switch_avatar_block -->
	<tr> 
	  <td class="submit" colspan="2">&nbsp;</td>
	</tr>
	<tr> 
	  	<th colspan="2" valign="middle">
	  		{L_AVATAR_PANEL}
			<span class="gensmall description">{L_AVATAR_EXPLAIN}</span>
		</th>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_CURRENT_IMAGE}</span></td>
		<td class="row1">
			{AVATAR}<br>
			<input type="checkbox" name="avatardel">
			<span class="gensmall">{L_DELETE_AVATAR}</span>
		</td>
	</tr>
	<!-- BEGIN switch_avatar_local_upload -->
	<tr> 
		<td class="row1"><span class="gen">{L_UPLOAD_AVATAR_FILE}:</span></td>
		<td class="row1"><!--<input type="hidden" name="MAX_FILE_SIZE" value="{AVATAR_SIZE}">-->
		<input type="file" name="avatar" class="post" onFocus="Active(this)" onBlur="NotActive(this)" style="width:200px"></td>
	</tr>
	<!-- END switch_avatar_local_upload -->
	<!-- BEGIN switch_avatar_remote_upload -->
	<tr> 
		<td class="row1"><span class="gen">{L_UPLOAD_AVATAR_URL}:</span><br><span class="gensmall">{L_UPLOAD_AVATAR_URL_EXPLAIN}</span></td>
		<td class="row1"><input type="text" name="avatarurl" size="40" class="post" onFocus="Active(this)" onBlur="NotActive(this)" style="width:200px"></td>
	</tr>
	<!-- END switch_avatar_remote_upload -->
	<!-- BEGIN switch_avatar_remote_link -->
	<tr> 
		<td class="row1"><span class="gen">{L_LINK_REMOTE_AVATAR}:</span><br><span class="gensmall">{L_LINK_REMOTE_AVATAR_EXPLAIN}</span></td>
		<td class="row1"><input type="text" name="avatarremoteurl" size="40" class="post" onFocus="Active(this)" onBlur="NotActive(this)" style="width:200px"></td>
	</tr>
	<!-- END switch_avatar_remote_link -->
	<!-- BEGIN switch_avatar_local_gallery -->
	<tr> 
		<td class="row1"><span class="gen">{L_AVATAR_GALLERY}:</span></td>
		<td class="row1"><input type="submit" name="avatargallery" value="{L_SHOW_GALLERY}" class="liteoption"></td>
	</tr>
	<!-- END switch_avatar_local_gallery -->
	<!-- END switch_avatar_block -->
	{PHOTO_BOX}
	<tr>
		<td class="submit" colspan="2">
			{S_HIDDEN_FIELDS}
			<input type="submit" name="submit" value="{L_SUBMIT}">
			<input type="reset" value="{L_RESET}" name="reset">
		</td>
	</tr>
</table>
</form>