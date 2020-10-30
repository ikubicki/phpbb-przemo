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
	<td nowrap="nowrap" align="center" width="13%" style="border-bottom : 1px solid Black;">
		<table cellpadding="2" cellspacing="0" border="0" width="100%" class="bodyline">
		<tr><td nowrap="nowrap" class="row3" align="center">
		&nbsp;&nbsp;<a href="{S_CONFIG_ACTION}&amp;mode=main_page" class="nav">{L_MAIN_PAGE}</a>&nbsp;&nbsp;</td></tr></table></td>
	<td class="row1" nowrap="nowrap" align="center" width="13%" style="border-left : 1px solid Black; border-top : 1px solid Black; border-right : 1px solid Black; "><span class="nav"><b>&nbsp;&nbsp;{L_VIEWTOPIC}&nbsp;&nbsp;</b></span></td>
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
				<form action="{S_CONFIG_ACTION}" method="post"><table width="100%" cellpadding="2" cellspacing="1" border="0" align="center" class="forumline">
				<tr>
					<th colspan="2">{L_ADDON_VIEWTOPIC}</th>
				</tr>
				<tr>
					<td class="row1">{L_CAGENT}<br><span class="gensmall">{L_CAGENT_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="cagent" value="1" {CAGENT_YES}> {L_YES} <input type="radio" name="cagent" value="0" {CAGENT_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_CFRIEND}<br><span class="gensmall">{L_LFRIEND}</span></td>
					<td class="row2" width="50%"><input type="radio" name="cfriend" value="1" {CFRIEND_YES}> {L_YES} <input type="radio" name="cfriend" value="0" {CFRIEND_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_CJOIN}<br><span class="gensmall">{L_LJOIN}</span></td>
					<td class="row2" width="50%"><input type="radio" name="cjoin" value="1" {CJOIN_YES}> {L_YES} <input type="radio" name="cjoin" value="0" {CJOIN_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_CFROM}<br><span class="gensmall">{L_LFROM}</span></td>
					<td class="row2" width="50%"><input type="radio" name="cfrom" value="1" {CFROM_YES}> {L_YES} <input type="radio" name="cfrom" value="0" {CFROM_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_CPOSTS}<br><span class="gensmall">{L_LPOSTS}</span></td>
					<td class="row2" width="50%"><input type="radio" name="cposts" value="1" {CPOSTS_YES}> {L_YES} <input type="radio" name="cposts" value="0" {CPOSTS_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_ONLINE_STATUS}</span></td>
					<td class="row2" width="50%"><input type="radio" name="r_a_r_time" value="1" {ONLINE_STATUS_YES}> {L_YES} <input type="radio" name="r_a_r_time" value="0" {ONLINE_STATUS_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_CLEVELL}<br><span class="gensmall">{L_LLEVELL}</span></td>
					<td class="row2" width="50%"><input type="radio" name="clevell" value="1" {CLEVELL_YES}> {L_YES} <input type="radio" name="clevell" value="0" {CLEVELL_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_CGG}<br><span class="gensmall">{L_LGG}</span></td>
					<td class="row2" width="50%"><input type="radio" name="cgg" value="1" {CGG_YES}> {L_YES} <input type="radio" name="cgg" value="0" {CGG_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_CLEVELD}<br><span class="gensmall">{L_LLEVELD}</span></td>
					<td class="row2" width="50%"><input type="radio" name="cleveld" value="1" {CLEVELD_YES}> {L_YES} <input type="radio" name="cleveld" value="0" {CLEVELD_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_CIGNORE}<br><span class="gensmall">{L_LIGNORE}</span></td>
					<td class="row2" width="50%"><input type="radio" name="cignore" value="1" {CIGNORE_YES}> {L_YES} <input type="radio" name="cignore" value="0" {CIGNORE_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_CQUICK}<br><span class="gensmall">{L_LQUICK}</span></td>
					<td class="row2" width="50%"><input type="radio" name="cquick" value="1" {CQUICK_YES}> {L_YES} <input type="radio" name="cquick" value="0" {CQUICK_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_QUICK_REPLY_PAGES}</td>
					<td class="row2" width="50%"><input type="radio" name="group_rank_hack_version" value="0" {QUICK_REPLY_PAGES_NO}> {L_YES} <input type="radio" name="group_rank_hack_version" value="1" {QUICK_REPLY_PAGES_YES}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_NOT_ANONYMOUS_QUICKREPLY}</td>
					<td class="row2" width="50%"><input type="radio" name="not_anonymous_quickreply" value="1" {NOT_ANONYMOUS_QUICKREPLY_YES}> {L_YES} <input type="radio" name="not_anonymous_quickreply" value="0" {NOT_ANONYMOUS_QUICKREPLY_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_MAX_SMILIES}</td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="3" maxlength="3" name="max_smilies" value="{MAX_SMILIES}"></td>
				</tr>
				<tr>
					<td class="row1">{L_GRAPHIC}<br><span class="gensmall">{L_GRAPHIC_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="graphic" value="0" {GRAPHIC_NO}> {L_YES} <input type="radio" name="graphic" value="1" {GRAPHIC_YES}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_POST_FOOTER}<br><span class="gensmall">{L_POST_FOOTER_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="post_footer" value="0" {POST_FOOTER_NO}> {L_YES} <input type="radio" name="post_footer" value="1" {POST_FOOTER_YES}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_WV}</td>
					<td class="row2" width="50%"><input type="radio" name="who_viewed" value="1" {WV_YES}> {L_YES} <input type="radio" name="who_viewed" value="0" {WV_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_WV_ADMIN}<br><span class="gensmall">{L_WV_ADMIN_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="who_viewed_admin" value="1" {WV_ADMIN_YES}> {L_YES} <input type="radio" name="who_viewed_admin" value="0" {WV_ADMIN_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_HV_ADMIN}<br><span class="gensmall">{L_HV_ADMIN_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="hide_viewed_admin" value="1" {HV_ADMIN_YES}> {L_YES} <input type="radio" name="hide_viewed_admin" value="0" {HV_ADMIN_NO}>{L_NO}</td>
				</tr>

				<tr>
					<td class="row1">{L_TOPIC_SPY_MOD}<br><span class="gensmall">{L_TOPIC_SPY_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="mod_spy" value="1" {SPY_MOD_YES}> {L_YES} <input type="radio" name="mod_spy" value="0" {SPY_MOD_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_TOPIC_SPY_MOD_ADMIN}</td>
					<td class="row2" width="50%"><input type="radio" name="mod_spy_admin" value="1" {SPY_ADMIN_YES}> {L_YES} <input type="radio" name="mod_spy_admin" value="0" {SPY_ADMIN_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_SA_LOCKED}</td>
					<td class="row2" width="50%"><input type="radio" name="show_action_locked" value="1" {SA_LOCK_YES}> {L_YES} <input type="radio" name="show_action_locked" value="0" {SA_LOCK_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_SA_UNLOCKED}</td>
					<td class="row2" width="50%"><input type="radio" name="show_action_unlocked" value="1" {SA_UNLOCK_YES}> {L_YES} <input type="radio" name="show_action_unlocked" value="0" {SA_UNLOCK_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_SA_EXPIRED}</td>
					<td class="row2" width="50%"><input type="radio" name="show_action_expired" value="1" {SA_EXPIRE_YES}> {L_YES} <input type="radio" name="show_action_expired" value="0" {SA_EXPIRE_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_SA_MOVED}</td>
					<td class="row2" width="50%"><input type="radio" name="show_action_moved" value="1" {SA_MOVE_YES}> {L_YES} <input type="radio" name="show_action_moved" value="0" {SA_MOVE_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_SA_EDITED_BY_OTHERS}</td>
					<td class="row2" width="50%"><input type="radio" name="show_action_edited_by_others" value="1" {SA_EDITED_BY_OTHERS_YES}> {L_YES} <input type="radio" name="show_action_edited_by_others" value="0" {SA_EDITED_BY_OTHERS_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_SA_EDITED_SELF}</td>
					<td class="row2" width="50%"><input type="radio" name="show_action_edited_self" value="1" {SA_EDITED_SELF_YES}> {L_YES} <input type="radio" name="show_action_edited_self" value="0" {SA_EDITED_SELF_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_SA_EDITED_SELF_ALL}</td>
					<td class="row2" width="50%"><input type="radio" name="show_action_edited_self_all" value="1" {SA_EDITED_SELF_ALL_YES}> {L_YES} <input type="radio" name="show_action_edited_self_all" value="0" {SA_EDITED_SELF_ALL_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_EDIT_TIME}<br><span class="gensmall">{L_EDIT_TIME_EXPLAIN}</span></td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" name="edit_time" value="{EDIT_TIME}" size="4" maxlength="9"></td>
				</tr>
				<tr>
					<td class="row1">{L_SA_ALLOW_MOD_DELETE}</td>
					<td class="row2" width="50%"><input type="radio" name="allow_mod_delete_actions" value="1" {SA_MOD_DELETE_YES}> {L_YES} <input type="radio" name="allow_mod_delete_actions" value="0" {SA_MOD_DELETE_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_HE_ADMIN}<br><span class="gensmall">{L_HE_ADMIN_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="hide_edited_admin" value="1" {HE_ADMIN_YES}> {L_YES} <input type="radio" name="hide_edited_admin" value="0" {HE_ADMIN_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_PH_VALUE}<br><span class="gensmall">{L_PH_VALUE_E}</span></td>
					<td class="row2" width="50%"><input type="text" name="ph_days" value="{PH_VALUE}" size="4" class="post" onFocus="Active(this)" onBlur="NotActive(this)"></td>
				</tr>
				<tr>
					<td class="row1">{L_PH_LEN}<br><span class="gensmall">{L_PH_LEN_E}</span></td>
					<td class="row2" width="50%"><input type="text" name="ph_len" value="{PH_LEN}" size="4" class="post" onFocus="Active(this)" onBlur="NotActive(this)"></td>
				</tr>
				<tr>
					<td class="row1">{L_PH_MOD}</td>
					<td class="row2" width="50%"><input type="radio" name="ph_mod" value="1" {PH_MOD_YES}> {L_YES} <input type="radio" name="ph_mod" value="0" {PH_MOD_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_PH_MOD_DELETE}</td>
					<td class="row2" width="50%"><input type="radio" name="ph_mod_delete" value="1" {PH_MOD_DELETE_YES}> {L_YES} <input type="radio" name="ph_mod_delete" value="0" {PH_MOD_DELETE_NO}>{L_NO}</td>
				</tr>
				<tr>
					<th colspan="2">{L_ADDON_VIEWFORUM}</th>
				</tr>
				<tr>
					<td class="row1">{L_IGNORE_TOPICS}</td>
					<td class="row2" width="50%"><input type="radio" name="ignore_topics" value="1" {IGNORE_TOPICS_YES}> {L_YES} <input type="radio" name="ignore_topics" value="0" {IGNORE_TOPICS_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_POSTER_POSTS}<br><span class="gensmall">{L_POSTER_POSTS_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="poster_posts" value="1" {POSTER_POSTS_YES}> {L_YES} <input type="radio" name="poster_posts" value="0" {POSTER_POSTS_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_NEWEST}<br><span class="gensmall">{L_NEWEST_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="newest" value="1" {NEWEST_YES}> {L_YES} <input type="radio" name="newest" value="0" {NEWEST_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_TOPIC_START_DATE}</td>
					<td class="row2" width="50%"><input type="radio" name="topic_start_date" value="1" {TOPIC_START_DATE_YES}> {L_YES} <input type="radio" name="topic_start_date" value="0" {TOPIC_START_DATE_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_TOPIC_START_DATEFORMAT}<br><span class="gensmall">{L_TOPIC_START_DATEFORMAT_E}</span></td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="10" maxlength="255" name="topic_start_dateformat" value="{TOPIC_START_DATEFORMAT}"></td>
				</tr>
				<tr>
					<td class="row1">{L_CSEARCH}<br><span class="gensmall">{L_LSEARCH}</span></td>
					<td class="row2" width="50%"><input type="radio" name="csearch" value="1" {CSEARCH_YES}> {L_YES} <input type="radio" name="csearch" value="0" {CSEARCH_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_POST_OVERLIB}</td>
					<td class="row2" width="50%"><input type="radio" name="post_overlib" value="1" {POST_OVERLIB_YES}> {L_YES} <input type="radio" name="post_overlib" value="0" {POST_OVERLIB_NO}>{L_NO}</td>
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
