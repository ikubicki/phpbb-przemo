<h1>{L_CONFIGURATION_TITLE}</h1>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td nowrap="nowrap" align="center" width="13%" style="border-bottom : 1px solid Black;">
		<table cellpadding="2" cellspacing="0" border="0" width="100%" class="bodyline">
		<tr><td nowrap="nowrap" class="row3" align="center">
		&nbsp;&nbsp;<a href="{S_CONFIG_ACTION}&amp;mode=config" class="nav">{L_CONFIG}</a>&nbsp;&nbsp;</td></tr></table></td>
		<td class="row1" nowrap="nowrap" align="center" width="13%" style="border-left : 1px solid Black; border-top : 1px solid Black; border-right : 1px solid Black; "><span class="nav"><b>&nbsp;&nbsp;{L_ADDONS}&nbsp;&nbsp;</b></span></td>
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
					<th colspan="2">{L_ADDON_MAIN}</th>
				</tr>
				<tr>
					<td class="row1">{L_READ_TRACKING_C}<br><span class="gensmall">{L_READ_TRACKING_C_E}</span></td>
					<td class="row2">{READ_TRACKING_CLEAR}</td>
				</tr>
				<tr>
					<td class="row1">{L_READ_TRACKING_DAYS}<br><span class="gensmall">{L_READ_TRACKING_DAYS_E}</span></td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="4" maxlength="3" name="day_to_prune" value="{DAY_TO_PRUNE}"></td>
				</tr>
				<tr>
					<td class="row1">{L_READ_TRACKING_MAX_POSTS}<br><span class="gensmall">{L_READ_TRACKING_MAX_POSTS_E}</span></td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="4" maxlength="4" name="rh_max_posts" value="{MAX_POSTS}"></td>
				</tr>
				<tr>
					<td class="row1">{L_READ_TRACKING_W_DAYS}<br><span class="gensmall">{L_READ_TRACKING_W_DAYS_E}</span></td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="4" maxlength="2" name="rh_without_days" value="{WITHOUT_DAYS}"></td>
				</tr>
				<tr>
					<td class="row1">{L_PROTECTION_GET}<br><span class="gensmall">{L_PROTECTION_GET_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="protection_get" value="1" {PROTECTION_GET_YES}> {L_YES} <input type="radio" name="protection_get" value="0" {PROTECTION_GET_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_AUTOREPAIR_TABLES}<br><span class="gensmall">{L_AUTOREPAIR_TABLES_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="autorepair_tables" value="1" {AUTOREPAIR_TABLES_YES}> {L_YES} <input type="radio" name="autorepair_tables" value="0" {AUTOREPAIR_TABLES_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_SEARCH_ENABLE}<br><span class="gensmall">{L_SEARCH_ENABLE_E}</span></td>
					<td class="row2"><input type="radio" name="search_enable" value="1" {SEARCH_ENABLE_YES}> {L_YES} <input type="radio" name="search_enable" value="0" {SEARCH_ENABLE_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_OPEN_IN_WINDOWS}<br><span class="gensmall">{L_OPEN_IN_WINDOWS_E}</span></td>
					<td class="row2"><input type="radio" name="open_in_windows" value="1" {OPEN_IN_WINDOWS_YES}> {L_YES} <input type="radio" name="open_in_windows" value="0" {OPEN_IN_WINDOWS_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_MAX_POLL_OPTIONS}</td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" name="max_poll_options" size="4" maxlength="4" value="{MAX_POLL_OPTIONS}"></td>
				</tr>
				<tr>
					<td class="row1">{L_HELPED}<br><span class="gensmall">{L_HELPED_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="helped" value="1" {HELPED_YES}> {L_YES} <input type="radio" name="helped" value="0" {HELPED_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_CRESTRICT}<br><span class="gensmall">{L_CRESTRICT_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="crestrict" value="1" {CRESTRICT_YES}> {L_YES} <input type="radio" name="crestrict" value="0" {CRESTRICT_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_LOGIN_REQUIRE}<br><span class="gensmall">{L_LOGIN_REQUIRE_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="login_require" value="1" {LOGIN_REQUIRE_YES}> {L_YES} <input type="radio" name="login_require" value="0" {LOGIN_REQUIRE_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_ALLOW_NAME_CHANGE}</td>
					<td class="row2" width="50%"><input type="radio" name="allow_namechange" value="1" {NAMECHANGE_YES}> {L_YES}&nbsp;&nbsp;<input type="radio" name="allow_namechange" value="0" {NAMECHANGE_NO}> {L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_OVERLIB}</td>
					<td class="row2" width="50%"><input type="radio" name="overlib" value="1" {OVERLIB_YES}> {L_YES}&nbsp;&nbsp;<input type="radio" name="overlib" value="0" {OVERLIB_NO}> {L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_ONMOUSE}</td>
					<td class="row2" width="50%"><input type="radio" name="onmouse" value="1" {ONMOUSE_YES}> {L_YES}&nbsp;&nbsp;<input type="radio" name="onmouse" value="0" {ONMOUSE_NO}> {L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_ANONYMOUS_SIMPLE}<br><span class="gensmall">{L_ANONYMOUS_SIMPLE_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="anonymous_simple" value="1" {ANONYMOUS_SIMPLE_YES}> {L_YES}&nbsp;&nbsp;<input type="radio" name="anonymous_simple" value="0" {ANONYMOUS_SIMPLE_NO}> {L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_GG_NR}, {L_GG_PASS}</td>
					<td class="row3" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" name="numer_gg" value="{GG_NR}" size="10" maxlength="255">&nbsp;&nbsp;
					<input type="password" class="post" onFocus="Active(this)" onBlur="NotActive(this)" name="haslo_gg" value="{GG_PASS}" size="10" maxlength="255"></td>
				</tr>
				<tr>
					<td class="row1">{L_NOTIFY_GG}<br><span class="gensmall">{L_NOTIFY_GG_E}</span></td>
					<td class="row3" width="50%"><input type="radio" name="notify_gg" value="1" {NOTIFY_GG_YES}> {L_YES}&nbsp;&nbsp;<input type="radio" name="notify_gg" value="0" {NOTIFY_GG_NO}> {L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_ADMIN_NOTIFY_GG}<br><span class="gensmall">{L_ADMIN_NOTIFY_GG_E}</span></td>
					<td class="row3" width="50%"><textarea name="admin_notify_gg" class="post" onFocus="Active(this)" onBlur="NotActive(this)" rows="2" cols="30">{ADMIN_NOTIFY_GG}</textarea></td>
				</tr>
				<tr>
					<td class="row1">{L_ADMIN_NOTIFY_REPLY}<br><span class="gensmall">{L_ADMIN_NOTIFY_REPLY_E}</span></td>
					<td class="row3" width="50%"><input type="radio" name="admin_notify_reply" value="1" {ADMIN_NOTIFY_REPLY_YES}> {L_YES}&nbsp;&nbsp;<input type="radio" name="admin_notify_reply" value="0" {ADMIN_NOTIFY_REPLY_NO}> {L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_ADMIN_NOTIFY_MESSAGE}<br><span class="gensmall">{L_ADMIN_NOTIFY_MESSAGE_E}</span></td>
					<td class="row3" width="50%"><input type="radio" name="admin_notify_message" value="1" {ADMIN_NOTIFY_MESSAGE_YES}> {L_YES}&nbsp;&nbsp;<input type="radio" name="admin_notify_message" value="0" {ADMIN_NOTIFY_MESSAGE_NO}> {L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_DEL_NOT_ENABLE}</td>
					<td class="row2" width="50%"><input type="radio" name="del_notify_enable" value="1" {DEL_NOT_ENABLE_YES}> {L_YES}&nbsp;&nbsp;<input type="radio" name="del_notify_enable" value="0" {DEL_NOT_ENABLE_NO}> {L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_DEL_NOT_METHOD}</td>
					<td class="row2" width="50%"><input type="radio" name="del_notify_method" value="1" {DEL_NOT_METHOD_YES}> E-mail&nbsp;&nbsp;<input type="radio" name="del_notify_method" value="0" {DEL_NOT_METHOD_NO}> PM</td>
				</tr>
				<tr>
					<td class="row1"><span class="gensmall">{L_DEL_NOT_CHOICE}</span></td>
					<td class="row2" width="50%"><input type="radio" name="del_notify_choice" value="1" {DEL_NOT_CHOICE_YES}> {L_YES}&nbsp;&nbsp;<input type="radio" name="del_notify_choice" value="0" {DEL_NOT_CHOICE_NO}> {L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_ALLOW_CUSTOM_COLOR}<br><span class="gensmall">{L_ALLOW_CUSTOM_COLOR_EXPLAIN}</span></td>
					<td class="row2" width="50%"><input type="radio" name="custom_color_use" value="1" {CUSTOM_COLOR_USE_YES}> {L_YES}&nbsp;&nbsp;<input type="radio" name="custom_color_use" value="0" {CUSTOM_COLOR_USE_NO}> {L_NO}&nbsp;&nbsp;&nbsp;<input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="4" maxlength="4" name="allow_custom_color" value="{CUSTOM_COLOR}"></td>
				</tr>
				<tr>
					<td class="row1">{L_ALLOW_CUSTOM_COLOR_VIEW}<br><span class="gensmall">{L_ALLOW_CUSTOM_COLOR_VIEW_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="custom_color_view" value="1" {CUSTOM_COLOR_VIEW_YES}> {L_YES}&nbsp;&nbsp;<input type="radio" name="custom_color_view" value="0" {CUSTOM_COLOR_VIEW_NO}> {L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_ALLOW_CUSTOM_COLOR_MOD}<br><span class="gensmall">{L_ALLOW_CUSTOM_COLOR_MOD_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="custom_color_mod" value="1" {CUSTOM_COLOR_MOD_YES}> {L_YES}&nbsp;&nbsp;<input type="radio" name="custom_color_mod" value="0" {CUSTOM_COLOR_MOD_NO}> {L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_ALLOW_CUSTOM_RANK}<br><span class="gensmall">{L_ALLOW_CUSTOM_RANK_EXPLAIN}</span></td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="4" maxlength="4" name="allow_custom_rank" value="{CUSTOM_RANK}"></td>
				</tr>
				<tr>
					<td class="row1">{L_ALLOW_CUSTOM_RANK_MOD}<br><span class="gensmall">{L_ALLOW_CUSTOM_RANK_MOD_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="custom_rank_mod" value="1" {CUSTOM_RANK_MOD_YES}> {L_YES}&nbsp;&nbsp;<input type="radio" name="custom_rank_mod" value="0" {CUSTOM_RANK_MOD_NO}> {L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_MAX_SIG_CUSTOM_RANK}</td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="4" maxlength="4" name="max_sig_custom_rank" value="{MAX_SIG_CUSTOM_RANK}"></td>
				</tr>
				<tr>
					<td class="row1">{L_DEL_EMAIL_NOT}<br><span class="gensmall">{L_DEL_EMAIL_NOT_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="del_user_notify" value="1" {DEL_EMAIL_NOT_YES}> {L_YES} <input type="radio" name="del_user_notify" value="0" {DEL_EMAIL_NOT_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_META_REFRESH}<br><span class="gensmall">{L_META_REFRESH_E}</span></td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="4" maxlength="255" name="refresh" value="{SREFRESH}"></td>
				</tr>
				<tr> 
					<td class="row1">{L_META_KEYWORDS}<br><span class="gensmall">{L_META_KEYWORDS_EXPLAIN}</span></td> 
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="50" maxlength="255" name="meta_keywords" value="{META_KEYWORDS}"></td> 
				</tr> 
				<tr> 
					<td class="row1">{L_META_DESCRIPTION}<br><span class="gensmall">{L_META_DESCRIPTION_EXPLAIN}</span></td> 
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="50" maxlength="255" name="meta_description" value="{META_DESCRIPTION}"></td> 
				</tr>
				<tr>
					<td class="row1">{L_SQL}<br><span class="gensmall">{L_SQL_E}</span></td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="50" maxlength="255" name="sql" value="{SQL}">
				</tr>
				<tr>
					<td class="row1">{L_ADDRESS_WHOIS}<br><span class="gensmall">{L_ADDRESS_WHOIS_E}</span></td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" name="address_whois" size="50" maxlength="200" value="{ADDRESS_WHOIS}"></td>
				</tr>
				<tr>
					<td class="row1">{L_CLOG}<br><span class="gensmall">{L_CLOG_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="clog" value="0" {CLOG_NO}>{L_NO} <input type="radio" name="clog" value="1" {CLOG_YES}> {L_YES}  <input type="radio" name="clog" value="2" {CLOG_POST}> {L_LOG_POST}</td>
				</tr>
				<tr>
					<td class="row1">{L_CLOAD}<br><span class="gensmall">{L_LLOAD}</span></td>
					<td class="row2" width="50%"><input type="radio" name="cload" value="1" {CLOAD_YES}> {L_YES} <input type="radio" name="cload" value="0" {CLOAD_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_NOT_EDIT_ADMIN}<br><span class="gensmall">{L_NOT_EDIT_ADMIN_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="not_edit_admin" value="1" {NOT_EDIT_ADMIN_YES}> {L_YES} <input type="radio" name="not_edit_admin" value="0" {NOT_EDIT_ADMIN_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_SHOW_BADWORDS}</td>
					<td class="row2" width="50%"><input type="radio" name="show_badwords" value="1" {SHOW_BADWORDS_YES}> {L_YES} <input type="radio" name="show_badwords" value="0" {SHOW_BADWORDS_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_IPVIEW}</td>
					<td class="row2" width="50%"><input type="radio" name="ipview" value="1" {IPVIEW_YES}> {L_YES} <input type="radio" name="ipview" value="0" {IPVIEW_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_GENERATE_TIME}</td>
					<td class="row2" width="50%"><input type="radio" name="generate_time" value="1" {GENERATE_TIME_YES}> {L_YES} <input type="radio" name="generate_time" value="0" {GENERATE_TIME_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_GENTIME_ADMIN}<br>
					<td class="row2" width="50%"><input type="radio" name="generate_time_admin" value="1" {GENTIMEADMIN_YES}> {L_YES} <input type="radio" name="generate_time_admin" value="0" {GENTIMEADMIN_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_SHOW_RULES}<br><span class="gensmall">{L_SHOW_RULES_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="show_rules" value="1" {SHOW_RULES_YES}> {L_YES} <input type="radio" name="show_rules" value="0" {SHOW_RULES_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_MAX_SIG_CHARS_ADMIN_E}</td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" name="max_sig_chars_admin" value="{MAX_SIG_CHARS_ADMIN}" size="4" maxlength="99"></td>
				</tr>
				<tr>
					<td class="row1">{L_MAX_SIG_CHARS_MOD_E}</td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" name="max_sig_chars_mod" value="{MAX_SIG_CHARS_MOD}" size="4" maxlength="99"></td>
				</tr>
				<tr>
					<th colspan="2">{L_USER_PASSWORD_SETTINGS}</th>
				</tr>
				<tr> 
					<td class="row1">{L_MAX_LOGIN_ERROR}<br><span class="gensmall">{L_MAX_LOGIN_ERROR_EXPLAIN}</span></td> 
					<td class="row2" width="50%"><input class="post" onFocus="Active(this)" onBlur="NotActive(this)" type="text" size="4" maxlength="2" name="max_login_error" value="{MAX_LOGIN_ERROR}"></td> 
				</tr> 
				<tr> 
					<td class="row1">{L_BLOCK_TIME}<br><span class="gensmall">{L_BLOCK_TIME_EXPLAIN}</span></td> 
					<td class="row2" width="50%"><input class="post" onFocus="Active(this)" onBlur="NotActive(this)" type="text" size="4" maxlength="4" name="block_time" value="{BLOCK_TIME}"></td> 
				</tr>
				<tr>
					<td class="row1">{L_PASSWORD_COMPLEX}<br><span class="gensmall">{L_PASSWORD_COMPLEX_EXPLAIN}</span></td>
					<td class="row2" width="50%"><input type="radio" name="force_complex_password" value="1" {S_PASSWORD_COMPLEX_ENABLED}>{L_ENABLED}&nbsp; &nbsp;<input type="radio" name="force_complex_password" value="0" {S_PASSWORD_COMPLEX_DISABLED}>{L_DISABLED}</td>
				</tr>
				<tr>
					<td class="row1">{L_PASSWORD_NOT_LOGIN}<br><span class="gensmall">{L_PASSWORD_NOT_LOGIN_EXPLAIN}</span></td>
					<td class="row2" width="50%"><input type="radio" name="password_not_login" value="1" {S_PASSWORD_NOT_LOGIN_ENABLED}>{L_ENABLED}&nbsp; &nbsp;<input type="radio" name="password_not_login" value="0" {S_PASSWORD_NOT_LOGIN_DISABLED}>{L_DISABLED}</td>
				</tr>
				<tr> 
					<td class="row1">{L_PASSWORD_LEN}<br><span class="gensmall">{L_PASSWORD_LEN_EXPLAIN}</span></td> 
					<td class="row2" width="50%"><input class="post" onFocus="Active(this)" onBlur="NotActive(this)" type="text" size="4" maxlength="4" name="min_password_len" value="{MIN_PASSWORD_LEN}"></td> 
				</tr>
				<tr>
					<td class="submit" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption">&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption"></td>
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
