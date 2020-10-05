<h1>{L_CONFIGURATION_TITLE}</h1>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class="row1" nowrap="nowrap" align="center" width="13%" style="border-left : 1px solid Black; border-top : 1px solid Black; border-right : 1px solid Black; "><span class="nav"><b>&nbsp;&nbsp;{L_CONFIG}&nbsp;&nbsp;</b></span></td>
	<td nowrap="nowrap" align="center" width="13%" style="border-bottom : 1px solid Black;">
		<table cellpadding="2" cellspacing="0" border="0" width="100%" class="bodyline">
		<tr><td nowrap="nowrap" class="row3" align="center">
		&nbsp;&nbsp;<a href="{S_CONFIG_ACTION}&amp;mode=addons" class="nav">{L_ADDONS}</a>&nbsp;&nbsp;</td></tr></table></td>
	<td nowrap="nowrap" align="center" width="13%" style="border-bottom : 1px solid Black;">
		<table cellpadding="2" cellspacing="0" border="0" width="100%" class="bodyline">
		<tr><td nowrap="nowrap" class="row3" align="center">
		&nbsp;&nbsp;<a href="{S_CONFIG_ACTION}&amp;mode=main_page" class="nav">{L_MAIN_PAGE}</a>&nbsp;&nbsp;</td></tr></table></td>
	<td nowrap="nowrap" align="center" width="13%" style="border-bottom : 1px solid Black;">
		<table cellpadding="2" cellspacing="0" border="0" width="100%" class="bodyline">
		<tr><td nowrap="nowrap" class="row3" align="center">
		&nbsp;&nbsp;<a href="{S_CONFIG_ACTION}&amp;mode=viewtopic" class="nav">{L_VIEWTOPIC}</a>&nbsp;&nbsp;</td></tr></table></td>
	<td nowrap="nowrap" align="center" width="13%" style="border-bottom : 1px solid Black;">
		<table cellpadding="2" cellspacing="0" border="0" width="100%" class="bodyline">
		<tr><td nowrap="nowrap" class="row3" align="center">
		&nbsp;&nbsp;<a href="{S_CONFIG_ACTION}&amp;mode=profile" class="nav">{L_PROFILE}</a>&nbsp;&nbsp;</td></tr></table></td>
	<td nowrap="nowrap" align="center" width="13%" style="border-bottom : 1px solid Black;">
		<table cellpadding="2" cellspacing="0" border="0" width="100%" class="bodyline">
		<tr><td nowrap="nowrap" class="row3" align="center">
		&nbsp;&nbsp;<a href="{S_CONFIG_ACTION}&amp;mode=posting" class="nav">{L_POSTING}</a>&nbsp;&nbsp;</td></tr></table></td>
	<td nowrap="nowrap" align="center" width="22%" style="border-bottom : 1px solid Black;">&nbsp;</td>
</tr>
<tr>
	<td colspan="7" class="row1" style="border-left : 1px solid Black; border-bottom : 1px solid Black; border-right : 1px solid Black;">
		<table cellpadding="0" cellspacing="6" width="100%" border="1">
		<tr>
			<td class="row1">
			<script language=JavaScript src="../images/picker.js"></script>
				<form action="{S_CONFIG_ACTION}" method="post" name="pick_form"><table width="100%" cellpadding="2" cellspacing="1" border="0" align="center" class="forumline">
				<tr>
					<th class="thHead" colspan="2">{L_GENERAL_SETTINGS}</th>
				</tr>
				<tr>
					<td class="row1">{L_SITE_NAME}</td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="25" maxlength="100" name="sitename" value="{SITENAME}">&nbsp;{L_COLOR}&nbsp;<input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="6" maxlength="6" name="name_color" onKeyup="chng(this);" style="font-weight: bold; color: #{NAME_COLOR}" value="{NAME_COLOR}">&nbsp;<a href="javascript:TCP.popup(document.forms['pick_form'].elements['name_color'])"><img src="../images/sel.gif" border="0"></a></td>
				</tr>
				<tr>
					<td class="row1">{L_SITE_DESCRIPTION}</td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="40" maxlength="255" name="site_desc" value="{SITE_DESCRIPTION}">&nbsp;{L_COLOR}&nbsp;<input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="6" maxlength="6" name="desc_color" onKeyup="chng(this);" style="font-weight: bold; color: #{DESC_COLOR}" value="{DESC_COLOR}">&nbsp;<a href="javascript:TCP.popup(document.forms['pick_form'].elements['desc_color'])"><img src="../images/sel.gif" border="0"></a></td>
				</tr>
				<tr>
					<td class="row1">{L_DISABLE_BOARD}<br><span class="gensmall">{L_DISABLE_BOARD_EXPLAIN}</span></td>
					<td class="row2" width="50%"><textarea name="board_disable" class="post" onFocus="Active(this)" onBlur="NotActive(this)" rows="2" cols="40">{BOARD_DISABLE}</textarea><br>
					<input type="checkbox" name="disable_type[]" value="1"{DISABLE_TYPE_1}>{L_DISABLE_FORUM} &nbsp;<input type="checkbox" name="disable_type[]" value="2"{DISABLE_TYPE_2}>{L_DISABLE_POSTING} &nbsp;<input type="checkbox" name="disable_type[]" value="3"{DISABLE_TYPE_3}>{L_DISABLE_REGISTERING}
				</tr>
				<tr>
					<td class="row1">{L_ACCT_ACTIVATION}</td>
					<td class="row2" width="50%"><input type="radio" name="require_activation" value="{ACTIVATION_NONE}" {ACTIVATION_NONE_CHECKED}>{L_NONE}&nbsp; &nbsp;<input type="radio" name="require_activation" value="{ACTIVATION_USER}" {ACTIVATION_USER_CHECKED}>{L_EMAIL}&nbsp; &nbsp;<input type="radio" name="require_activation" value="{ACTIVATION_ADMIN}" {ACTIVATION_ADMIN_CHECKED}>{L_ADMIN}</td>
				</tr>
				<tr>
					<td class="row1">{L_SEARCH_KEYWORDS_MAX}</td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="3" maxlength="4" name="search_keywords_max" value="{SEARCH_KEYWORDS_MAX}"></td>
				</tr>
				<tr>
					<td class="row1">{L_FLOOD_INTERVAL} <br><span class="gensmall">{L_FLOOD_INTERVAL_EXPLAIN}</span></td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="3" maxlength="4" name="flood_interval" value="{FLOOD_INTERVAL}"></td>
				</tr>
				<tr>
					<td class="row1">{L_TOPICS_PER_PAGE}</td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" name="topics_per_page" size="3" maxlength="4" value="{TOPICS_PER_PAGE}"></td>
				</tr>
				<tr>
					<td class="row1">{L_POSTS_PER_PAGE}</td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" name="posts_per_page" size="3" maxlength="4" value="{POSTS_PER_PAGE}"></td>
				</tr>
				<tr>
					<td class="row1">{L_HOT_THRESHOLD}</td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" name="hot_threshold" size="3" maxlength="4" value="{HOT_TOPIC}"></td>
				</tr>
				<tr>
					<td class="row1">{L_DEFAULT_STYLE}</td>
					<td class="row2" width="50%">{STYLE_SELECT}</td>
				</tr>
				<tr>
					<td class="row1">{L_OVERRIDE_STYLE}<br><span class="gensmall">{L_OVERRIDE_STYLE_EXPLAIN}</span></td>
					<td class="row2" width="50%"><input type="radio" name="override_user_style" value="1" {OVERRIDE_STYLE_YES}> {L_YES}&nbsp;&nbsp;<input type="radio" name="override_user_style" value="0" {OVERRIDE_STYLE_NO}> {L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_DEFAULT_LANGUAGE}</td>
					<td class="row2" width="50%">{LANG_SELECT}</td>
				</tr>
				<tr>
					<td class="row1">{L_DATE_FORMAT}</td>
					<td class="row2" width="50%"><span class="gensmall">{DEFAULT_DATEFORMAT}</span></td>	</tr>
				<tr>
					<td class="row1">{L_SYSTEM_TIMEZONE}</td>
					<td class="row2" width="50%">{TIMEZONE_SELECT}</td>
				</tr>
			 	<tr>
					<td class="row1">{L_AUTO_DATE}</td>
					<td class="row2" width="50%"><input type="radio" name="auto_date" value="1" {AUTO_DATE_YES}> {L_YES} <input type="radio" name="auto_date" value="0" {AUTO_DATE_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_ENABLE_GZIP}</td>
					<td class="row2" width="50%"><input type="radio" name="gzip_compress" value="1" {GZIP_YES}> {L_YES}&nbsp;&nbsp;<input type="radio" name="gzip_compress" value="0" {GZIP_NO}> {L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_ALLOW_AUTOLOGIN}<br><span class="gensmall">{L_ALLOW_AUTOLOGIN_EXPLAIN}</span></td>
					<td class="row2"><select name="allow_autologin" size="4">
						<option value="3"{AA_CHECK_3}>{L_AA_NO_LIMIT}</option>
						<option value="1"{AA_CHECK_1}>{L_AA_WITH_STAFF_IP}</option>
						<option value="2"{AA_CHECK_2}>{L_AA_WITH_IP}</option>
						<option value="0"{AA_CHECK_0}>{L_NO}</option>
					</select></td>
				</tr>
				<tr>
					<td class="row1">{L_SESSION_LENGTH}<br><span class="gensmall">{L_SESSION_LENGTH_E}</span></td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" maxlength="5" size="5" name="session_length" value="{SESSION_LENGTH}"></td>
				</tr>
				<tr>
					<td class="row1"><span class="gensmall">{L_PUBLIC_DIRECTORY}</span></td>
					<td class="row2" width="50%"><select name="public_category" size="4">{PUBLIC_DIRECTORIES}</select></td>
				</tr>
				<tr>
					<th class="thHead" colspan="2">{L_COOKIE_SETTINGS}</th>
				</tr>
				<tr>
					<td class="row2" width="50%" colspan="2"><span class="gensmall">{L_COOKIE_SETTINGS_EXPLAIN}</span></td>
				</tr>
				<tr>
					<td class="row1">{L_SERVER_NAME}</td>
					<td class="row2"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" maxlength="255" size="40" name="server_name" value="{SERVER_NAME}"></td>
				</tr>
				<tr>
					<td class="row1">{L_CHECK_ADDRESS}<br><span class="gensmall">{L_CHECK_ADDRESS_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="check_address" value="1" {CHECK_ADDRESS_YES}> {L_YES}&nbsp;&nbsp;<input type="radio" name="check_address" value="0" {CHECK_ADDRESS_NO}> {L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_SERVER_PORT}<br><span class="gensmall">{L_SERVER_PORT_EXPLAIN}</span></td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" maxlength="5" size="5" name="server_port" value="{SERVER_PORT}"></td>
				</tr>
				<tr>
					<td class="row1">{L_SCRIPT_PATH}<br><span class="gensmall">{L_SCRIPT_PATH_EXPLAIN}</span></td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" maxlength="255" name="script_path" value="{SCRIPT_PATH}"></td>
				</tr>
				<tr>
					<td class="row1">{L_COOKIE_NAME}</td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" maxlength="16" name="cookie_name" value="{COOKIE_NAME}"></td>
				</tr>
				<tr>
					<td class="row1">{L_COOKIE_PATH}</td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" maxlength="255" name="cookie_path" value="{COOKIE_PATH}"></td>
				</tr>
				<tr>
					<td class="row1">{L_COOKIE_SECURE}<br><span class="gensmall">{L_COOKIE_SECURE_EXPLAIN}</span></td>
					<td class="row2" width="50%"><input type="radio" name="cookie_secure" value="0" {S_COOKIE_SECURE_DISABLED}>{L_DISABLED}&nbsp; &nbsp;<input type="radio" name="cookie_secure" value="1" {S_COOKIE_SECURE_ENABLED}>{L_ENABLED}</td>
				</tr>
				<tr>
					<th class="thHead" colspan="2">{L_PRIVATE_MESSAGING}</th>
				</tr>
				<tr>
					<td class="row1">{L_DISABLE_PRIVATE_MESSAGING}</td>
					<td class="row2" width="50%"><input type="radio" name="privmsg_disable" value="0" {S_PRIVMSG_ENABLED}>{L_ENABLED}&nbsp; &nbsp;<input type="radio" name="privmsg_disable" value="1" {S_PRIVMSG_DISABLED}>{L_DISABLED}</td>
				</tr>
				<tr>
					<td class="row1">{L_INBOX_LIMIT}</td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" maxlength="4" size="4" name="max_inbox_privmsgs" value="{INBOX_LIMIT}"></td>
				</tr>
				<tr>
					<td class="row1">{L_SENTBOX_LIMIT}</td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" maxlength="4" size="4" name="max_sentbox_privmsgs" value="{SENTBOX_LIMIT}"></td>
				</tr>
				<tr>
					<td class="row1">{L_SAVEBOX_LIMIT}</td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" maxlength="4" size="4" name="max_savebox_privmsgs" value="{SAVEBOX_LIMIT}"></td>
				</tr>
				<tr>
					<th class="thHead" colspan="2">{L_COPPA_SETTINGS}</th>
				</tr>
				<tr>
					<td class="row1">{L_COPPA_FAX}</td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="25" maxlength="100" name="coppa_fax" value="{COPPA_FAX}"></td>
				</tr>
				<tr>
					<td class="row1">{L_COPPA_MAIL}<br><span class="gensmall">{L_COPPA_MAIL_EXPLAIN}</span></td>
					<td class="row2" width="50%"><textarea name="coppa_mail" class="post" onFocus="Active(this)" onBlur="NotActive(this)" rows="5" cols="30">{COPPA_MAIL}</textarea></td>
				</tr>
				<tr>
					<th class="thHead" colspan="2">{L_EMAIL_SETTINGS}</th>
				</tr>
				<tr>
					<td class="row1">{L_BOARD_EMAIL_CHECK}</td>
					<td class="row2" width="50%">{L_EMAIL_RESULT}</td>
				</tr>
				<tr>
					<td class="row1">{L_BOARD_EMAIL_FORM}<br><span class="gensmall">{L_BOARD_EMAIL_FORM_EXPLAIN}</span></td>
					<td class="row2" width="50%"><input type="radio" name="board_email_form" value="1" {BOARD_EMAIL_FORM_ENABLE}> {L_ENABLED}&nbsp;&nbsp;<input type="radio" name="board_email_form" value="0" {BOARD_EMAIL_FORM_DISABLE}> {L_DISABLED}</td>
				</tr>
				<tr>
					<td class="row1">{L_ADMIN_EMAIL}</td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="25" maxlength="100" name="board_email" value="{BOARD_EMAIL}"></td>
				</tr>
				<tr>
					<td class="row1">{L_EMAIL_RETURN_PATH}</td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="25" maxlength="100" name="email_return_path" value="{EMAIL_RETURN_PATH}"></td>
				</tr>
				<tr>
					<td class="row1">{L_EMAIL_FROM}</td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="25" maxlength="100" name="email_from" value="{EMAIL_FROM}"></td>
				</tr>
				<tr>
					<td class="row1">{L_EMAIL_SIG}<br><span class="gensmall">{L_EMAIL_SIG_EXPLAIN}</span></td>
					<td class="row2" width="50%"><textarea name="board_email_sig" class="post" onFocus="Active(this)" onBlur="NotActive(this)" rows="5" cols="30">{EMAIL_SIG}</textarea></td>
				</tr>
				<tr>
					<td class="row1">{L_USE_SMTP}<br><span class="gensmall">{L_USE_SMTP_EXPLAIN}</span></td>
					<td class="row2" width="50%"><input type="radio" name="smtp_delivery" value="1" {SMTP_YES}> {L_YES}&nbsp;&nbsp;<input type="radio" name="smtp_delivery" value="0" {SMTP_NO}> {L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_SMTP_SERVER}</td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" name="smtp_host" value="{SMTP_HOST}" size="25" maxlength="50"></td>
				</tr>
				<tr>
					<td class="row1">{L_SMTP_USERNAME}<br><span class="gensmall">{L_SMTP_USERNAME_EXPLAIN}</span></td>
					<td class="row2" width="50%"><input type="text" autocomplete="off" class="post" onFocus="Active(this)" onBlur="NotActive(this)" name="smtp_username" value="{SMTP_USERNAME}" size="25" maxlength="255"></td>
				</tr>
				<tr>
					<td class="row1">{L_SMTP_PASSWORD}<br><span class="gensmall">{L_SMTP_PASSWORD_EXPLAIN}</span></td>
					<td class="row2" width="50%"><input type="password" autocomplete="off" class="post" onFocus="Active(this)" onBlur="NotActive(this)" name="smtp_password" value="{SMTP_PASSWORD}" size="25" maxlength="255"></td>
				</tr>
				<tr>
					<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption">&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption"></td>
				</tr>
				</form>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>
</table>
<br clear="all">
