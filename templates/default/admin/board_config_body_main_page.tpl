<h1>{L_CONFIGURATION_TITLE}</h1>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td nowrap="nowrap" align="center" width="13%" style="border-bottom : 1px solid Black;">
		<table cellpadding="2" cellspacing="0" border="0" width="100%" class="bodyline">
		<tr><td nowrap="nowrap" class="row3" align="center">
		&nbsp;&nbsp;<a href="{S_CONFIG_ACTION}&amp;mode=config" class="nav">{L_CONFIG}</a>&nbsp;&nbsp;</td></tr></table></td>
	<td nowrap="nowrap" align="center" width="13%" style="border-bottom : 1px solid Black;">
		<table cellpadding="2" cellspacing="0" border="0" width="100%" class="bodyline">
		<tr><td nowrap="nowrap" class="row3" align="center">
		&nbsp;&nbsp;<a href="{S_CONFIG_ACTION}&amp;mode=addons" class="nav">{L_ADDONS}</a>&nbsp;&nbsp;</td></tr></table></td>
		<td class="row1" nowrap="nowrap" align="center" width="13%" style="border-left : 1px solid Black; border-top : 1px solid Black; border-right : 1px solid Black; "><span class="nav"><b>&nbsp;&nbsp;{L_MAIN_PAGE}&nbsp;&nbsp;</b></span></td>
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
					<th colspan="2">{L_ADDON_MAIN_PAGE}</th>
				</tr>
				<tr> 
					<td class="row1">{L_BANNER_TOP}<br><span class="gensmall">{L_BANNER_TOP_E}</span></td> 
					<td class="row2" width="50%">
					<input type="radio" name="banner_top_enable" value="1" {BANNER_TOP_ENABLE_YES}> {L_YES} <input type="radio" name="banner_top_enable" value="0" {BANNER_TOP_ENABLE_NO}>{L_NO}<br>
					<textarea name="banner_top" class="post" onFocus="Active(this)" onBlur="NotActive(this)" rows="9" cols="60">{BANNER_TOP}</textarea></td> 
				</tr>
				<tr> 
					<td class="row1">{L_BANNER_BOTTOM}<br><span class="gensmall">{L_BANNER_BOTTOM_E}</span></td> 
					<td class="row2" width="50%">
					<input type="radio" name="banner_bottom_enable" value="1" {BANNER_BOTTOM_ENABLE_YES}> {L_YES} <input type="radio" name="banner_bottom_enable" value="0" {BANNER_BOTTOM_ENABLE_NO}>{L_NO}<br>
					<textarea name="banner_bottom" class="post" onFocus="Active(this)" onBlur="NotActive(this)" rows="9" cols="60">{BANNER_BOTTOM}</textarea></td> 
				</tr>
				<tr>
					<td class="row1">{L_HEADER}<br><span class="gensmall">{L_HEADER_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="header_enable" value="1" {HEADER_ENABLE_YES}> {L_YES} <input type="radio" name="header_enable" value="0" {HEADER_ENABLE_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_ECHANGE_BANNER}<br><span class="gensmall">{L_ECHANGE_BANNER_E}</span></td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" name="echange_banner" value="{ECHANGE_BANNER}" size="1" maxlength="1"></td>
				</tr>
				<tr>
					<td class="row1"><span class="gensmall">{L_ECHANGE_BANNER_HTML}</span></td>
					<td class="row2" width="50%"><textarea name="banners_list" class="post" onFocus="Active(this)" onBlur="NotActive(this)" rows="9" cols="60">{ECHANGE_BANNER_HTML}</textarea></td>
				</tr>
				<tr>
					<td class="row1">{L_ENABLE_BOARD_MSG}</td>
					<td class="row2" width="50%"><input type="radio" name="board_msg_enable" value="0" {BOARD_MSG_NONE}>{L_BOARD_MSG_NONE}&nbsp; &nbsp;<input type="radio" name="board_msg_enable" value="1" {BOARD_MSG_INDEX}>{L_BOARD_MSG_INDEX}&nbsp; &nbsp;<input type="radio" name="board_msg_enable" value="2" {BOARD_MSG_ALL}>{L_BOARD_MSG_ALL}</td>
				</tr>
				<tr>
					<td class="row1">{L_BOARD_MSG}<br><span class="gensmall">{L_BOARD_MSG_EXPLAIN}</span></td>
					<td class="row2" width="50%"><textarea class="post" onFocus="Active(this)" onBlur="NotActive(this)" name="board_msg" rows="9" cols="60">{BOARD_MSG}</textarea></td>
				</tr>
				<tr>
					<td class="row1">{L_WIDTH_FORUM}<br><span class="gensmall">{L_WIDTH_FORUM_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="width_forum" value="1" {WIDTH_FORUM_YES}> {L_YES} <input type="radio" name="width_forum" value="0" {WIDTH_FORUM_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_WIDTH_TABLE}</td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" name="width_table" value="{WIDTH_TABLE}" size="4" maxlength="9"></td>
				</tr>
				<tr>
					<td class="row1">{L_WIDTH_COLOR}</td>
					<td class="row2" width="50%">
					<input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" name="width_color1" value="{WIDTH_COLOR1}" onKeyup="chng(this);" style="font-weight: bold; color:#{WIDTH_COLOR1}" size="7" maxlength="6">
					&nbsp;<a href="javascript:TCP.popup(document.forms['pick_form'].elements['width_color1'])"><img src="../images/sel.gif" border="0"></a>
					&nbsp;&nbsp;<input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" name="width_color2" value="{WIDTH_COLOR2}" onKeyup="chng(this);" style="font-weight: bold; color: #{WIDTH_COLOR2}" size="7" maxlength="6">
					&nbsp;<a href="javascript:TCP.popup(document.forms['pick_form'].elements['width_color2'])"><img src="../images/sel.gif" border="0"></a>
					&nbsp;&nbsp;<input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" name="table_border" value="{TABLE_BORDER}" size="2" maxlength="4"></td>
				</tr>
				<tr>
					<td class="row1">{L_CAVATAR}<br><span class="gensmall">{L_CAVATAR_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="cavatar" value="1" {CAVATAR_YES}> {L_YES} <input type="radio" name="cavatar" value="0" {CAVATAR_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_CDOWNLOAD}<br><span class="gensmall">{L_CDOWNLOAD_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="download" value="1" {CDOWNLOAD_YES}> {L_YES} <input type="radio" name="download" value="0" {CDOWNLOAD_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_CSTAT}<br><span class="gensmall">{L_LSTAT}</span></td>
					<td class="row2" width="50%"><input type="radio" name="cstat" value="1" {CSTAT_YES}> {L_YES} <input type="radio" name="cstat" value="0" {CSTAT_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_CREGIST}<br><span class="gensmall">{L_LREGIST}</span></td>
					<td class="row2" width="50%"><input type="radio" name="cregist" value="1" {CREGIST_YES}> {L_YES} <input type="radio" name="cregist" value="0" {CREGIST_NO}>{L_NO}&nbsp;&nbsp;{L_CLOGIN_B}: <input type="radio" name="cregist_b" value="1" {CREGIST_B_YES}> {L_YES} <input type="radio" name="cregist_b" value="0" {CREGIST_B_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_CSTYLES}<br><span class="gensmall">{L_LSTYLES}</span></td>
					<td class="row2" width="50%"><input type="radio" name="cstyles" value="1" {CSTYLES_YES}> {L_YES} <input type="radio" name="cstyles" value="0" {CSTYLES_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_CCOUNT}<br><span class="gensmall">{L_LCOUNT}</span></td>
					<td class="row2" width="50%"><input type="radio" name="ccount" value="1" {CCOUNT_YES}> {L_YES} <input type="radio" name="ccount" value="0" {CCOUNT_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_U_O_T_D}</td>
					<td class="row2" width="50%"><input type="radio" name="u_o_t_d" value="1" {U_O_T_D_YES}> {L_YES}&nbsp;&nbsp;<input type="radio" name="u_o_t_d" value="0" {U_O_T_D_NO}> {L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_DISPLAY_VIEWONLINE}</td>
					<td class="row2" width="50%"><input type="radio" name="display_viewonline" value="0"{DISPLAY_VO_0_CHECKED}>{L_NEVER}&nbsp;&nbsp;
					<input type="radio" name="display_viewonline" value="1" {DISPLAY_VO_1_CHECKED}>{L_ROOT_ONLY}&nbsp;&nbsp;
					<input type="radio" name="display_viewonline" value="2" {DISPLAY_VO_2_CHECKED}>{L_ALWAYS}&nbsp;&nbsp;
					<span class="gensmall"><hr>{L_IGNORE_USER_SETTINGS}:&nbsp;<input type="radio" name="display_viewonline_over" value="1" {DVO_YES}>{L_YES}&nbsp;&nbsp;
					<input type="radio" name="display_viewonline_over" value="0" {DVO_NO}>{L_NO}</span></td>
				</tr>
				<tr>
					<td class="row1"><span class="gensmall">{L_LAST_VISITORS_TIME_E}</span></td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" name="last_visitors_time" value="{LAST_VISITORS_TIME}" size="3" maxlength="4"></td>
				</tr>
				<tr>
					<td class="row1"><span class="gensmall">{L_LAST_VISITORS_TIME_COUNT}</span></td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" name="last_visitors_time_count" value="{LAST_VISITORS_TIME_COUNT}" size="3" maxlength="4"></td>
				</tr>
				<tr>
					<td class="row1">{L_STAFF_ENABLE}</td>
					<td class="row2" width="50%"><input type="radio" name="staff_enable" value="1" {STAFF_ENABLE_YES}> {L_YES} <input type="radio" name="staff_enable" value="0" {STAFF_ENABLE_NO}>{L_NO}&nbsp;&nbsp;{L_STAFF_FORUMS}: <input type="radio" name="staff_forums" value="1" {STAFF_FORUMS_YES}> {L_YES} <input type="radio" name="staff_forums" value="0" {STAFF_FORUMS_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_CTOP}<br><span class="gensmall">{L_LTOP}</span></td>
					<td class="row2" width="50%"><input type="radio" name="ctop" value="1" {CTOP_YES}> {L_YES} <input type="radio" name="ctop" value="0" {CTOP_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_USE_SUB_FORUM}<br><span class="gensmall">{L_INDEX_PACKING}</span></td>
					<td class="row2" width="50%">
					<input type="radio" name="sub_forum" value="1" {SUB_FORUMS_1_CHECKED}>{L_MEDIUM}&nbsp;&nbsp;
					<input type="radio" name="sub_forum" value="0" {SUB_FORUMS_0_CHECKED}>{L_NONES}&nbsp;&nbsp;
					<input type="radio" name="sub_forum" value="2" {SUB_FORUMS_2_CHECKED}>{L_FULL}
					<span class="gensmall"><hr>{L_IGNORE_USER_SETTINGS}:&nbsp;<input type="radio" name="sub_forum_over" value="1" {SF_OVER_YES}>{L_YES}&nbsp;&nbsp;
					<input type="radio" name="sub_forum_over" value="0" {SF_OVER_NO} >{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_SPLIT_CAT}</td>
					<td class="row2" width="50%">
					<input type="radio" name="split_cat" value="1" {SPLIT_CAT_YES}>{L_YES}&nbsp;&nbsp;
					<input type="radio" name="split_cat" value="0" {SPLIT_CAT_NO}>{L_NO}
					<span class="gensmall"><hr>{L_IGNORE_USER_SETTINGS}:&nbsp;<input type="radio" name="split_cat_over" value="1" {SC_OVER_YES}>{L_YES}&nbsp;&nbsp;
					<input type="radio" name="split_cat_over" value="0"{SC_OVER_NO} >{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_USE_LAST_TOPIC_TITLE}</td>
					<td class="row2" width="50%">
					<input type="radio" name="last_topic_title" value="1" {LTT_YES}>{L_YES}&nbsp;&nbsp;
					<input type="radio" name="last_topic_title" value="0" {LTT_NO}>{L_NO}
					<span class="gensmall"><hr>{L_IGNORE_USER_SETTINGS}:&nbsp;<input type="radio" name="last_topic_title_over" value="1" {LTT_OVER_YES}>{L_YES}&nbsp;&nbsp;
					<input type="radio" name="last_topic_title_over" value="0" {LTT_OVER_NO} >{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_LAST_TOPIC_TITLE_LEN}</td><td class="row2" width="50%"><input type="text" name="last_topic_title_length" maxlength="3" size="3" class="post" value="{LTT_LEN}"></td>
				</tr>
				<tr>
					<td class="row1">{L_SUB_LEVEL_LINKS}<br><span class="gensmall">{L_SUB_LEVEL_LINKS_E}</span></td>
					<td class="row2" width="50%">
					<input type="radio" name="sub_level_links" value="0" {SLL_FORUMS_0_CHECKED}>{L_NO}&nbsp;&nbsp;
					<input type="radio" name="sub_level_links" value="1" {SLL_FORUMS_1_CHECKED}>{L_YES}&nbsp;&nbsp;
					<input type="radio" name="sub_level_links" value="2" {SLL_FORUMS_2_CHECKED}>{L_WITH_PICS}
					<span class="gensmall"><hr>{L_IGNORE_USER_SETTINGS}:&nbsp;<input type="radio" name="sub_level_links_over" value="1" {SLL_OVER_YES}>{L_YES}&nbsp;&nbsp;
					<input type="radio" name="sub_level_links_over" value="0" {SLL_OVER_NO} >{L_NO}</td>
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
