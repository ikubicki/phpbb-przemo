<body onunload="parent.forum.closeIframe()">
<form action="{S_PROFILE_ACTION}" method="post" name="prefs">
<table class="forumline posting nolength">
	<tr>
		<th colspan="2">
			{L_PREFERENCES}
			<span class="gensmall description">{L_PREFERENCES_E}</span>
		</th>
	</tr>
	<tr>
		<td class="row1" align="center" width="2%"><input type="checkbox" id="c1" name="simple_head" value="1"{c_simple_head}>&nbsp;</td>
		<td class="row1"><span class="gen"><label for="c1" style="cursor: pointer;">{L_SIMPLE_HEAD}</label></span></td>
	</tr>
	<!-- BEGIN s_page_avatar -->
	<tr>
		<td class="row1" align="center" width="2%"><input type="checkbox" id="c2" name="page_avatar"{c_page_avatar} value="1">&nbsp;</td>
		<td class="row1"><span class="gen"><label for="c2" style="cursor: pointer;">{L_PAGE_AVATAR}</label></span><br><span class="gensmall">{L_PAGE_AVATAR_E}</span></td>
	</tr>
	<!-- END s_page_avatar -->
	<!-- BEGIN s_overlib -->
	<tr>
		<td class="row1" align="center" width="2%"><input type="checkbox" id="c3" name="overlib"{c_overlib} value="1">&nbsp;</td>
		<td class="row1"><span class="gen"><label for="c3" style="cursor: pointer;">{L_OVERLIB}</label></span></td>
	</tr>
	<!-- END s_overlib -->
	<!-- BEGIN s_onmouse -->
	<tr>
		<td class="row1" align="center" width="2%"><input type="checkbox" id="c4" name="onmouse"{c_onmouse} value="1">&nbsp;</td>
		<td class="row1"><span class="gen"><label for="c4" style="cursor: pointer;">{L_ONMOUSE}</label></span></td>
	</tr>
	<!-- END s_onmouse -->
	<!-- BEGIN s_u_o_t_d -->
	<tr>
		<td class="row1" align="center" width="2%"><input type="checkbox" id="c6" name="u_o_t_d"{c_u_o_t_d} value="1">&nbsp;</td>
		<td class="row1"><span class="gen"><label for="c6" style="cursor: pointer;">{L_U_O_T_D}</label></span></td>
	</tr>
	<!-- END s_u_o_t_d -->
	<!-- BEGIN s_cload -->
	<tr>
		<td class="row1" align="center" width="2%"><input type="checkbox" id="c7" name="cload"{c_cload} value="1">&nbsp;</td>
		<td class="row1"><span class="gen"><label for="c7" style="cursor: pointer;">{L_CLOAD}</label></span></td>
	</tr>
	<!-- END s_cload -->
	<!-- BEGIN s_shoutbox -->
	<tr>
		<td class="row1" align="center" width="2%"><input type="checkbox" id="c8" name="shoutbox"{c_shoutbox} value="1">&nbsp;</td>
		<td class="row1"><span class="gen"><label for="c8" style="cursor: pointer;">{L_SHOUTBOX}</label></span></td>
	</tr>
	<!-- END s_shoutbox -->
	<!-- BEGIN s_user_allow_signature -->
	<tr>
		<td class="row1" align="center" width="2%"><input type="checkbox" id="c9" name="user_allow_signature"{c_user_allow_signature} value="1">&nbsp;</td>
		<td class="row1"><span class="gen"><label for="c9" style="cursor: pointer;">{L_USER_ALLOW_SIGNATURE}</label></span></td>
	</tr>
	<!-- END s_user_allow_signature -->
	<!-- BEGIN s_user_allow_sig_image -->
	<tr>
		<td class="row1" align="center" width="2%"><input type="checkbox" id="c10" name="user_allow_sig_image"{c_user_allow_sig_image} value="1">&nbsp;</td>
		<td class="row1"><span class="gen"><label for="c10" style="cursor: pointer;">{L_USER_ALLOW_SIG_IMAGE}</label></span></td>
	</tr>
	<!-- END s_user_allow_sig_image -->
	<!-- BEGIN s_user_showavatars -->
	<tr>
		<td class="row1" align="center" width="2%"><input type="checkbox" id="c11" name="user_showavatars"{c_user_showavatars} value="1">&nbsp;</td>
		<td class="row1"><span class="gen"><label for="c11" style="cursor: pointer;">{L_USER_SHOWAVATARS}</label></span></td>
	</tr>
	<!-- END s_user_showavatars -->
	<!-- BEGIN s_view_ignore_topics -->
	<tr>
		<td class="row1" align="center" width="2%"><input type="checkbox" id="c12" name="view_ignore_topics"{c_view_ignore_topics} value="1">&nbsp;</td>
		<td class="row1"><span class="gen"><label for="c12" style="cursor: pointer;">{L_VIEW_IGNORE_TOPICS}</label></span></td>
	</tr>
	<!-- END s_view_ignore_topics -->
	<!-- BEGIN s_topic_start_date -->
	<tr>
		<td class="row1" align="center" width="2%"><input type="checkbox" id="c13" name="topic_start_date"{c_topic_start_date} value="1">&nbsp;</td>
		<td class="row1"><span class="gen"><label for="c13" style="cursor: pointer;">{L_TOPIC_START_DATE}</label></span></td>
	</tr>
	<!-- END s_topic_start_date -->
	<!-- BEGIN s_ctop -->
	<tr>
		<td class="row1" align="center" width="2%"><input type="checkbox" id="c14" name="ctop"{c_ctop} value="1">&nbsp;</td>
		<td class="row1"><span class="gen"><label for="c14" style="cursor: pointer;">{L_CTOP}</label></span></td>
	</tr>
	<!-- END s_ctop -->
	<!-- BEGIN s_custom_color_use -->
	<tr>
		<td class="row1" align="center" width="2%"><input type="checkbox" id="c15" name="custom_color_use"{c_custom_color_use} value="1">&nbsp;</td>
		<td class="row1"><span class="gen"><label for="c15" style="cursor: pointer;">{L_CUSTOM_COLOR_USE}</label></span></td>
	</tr>
	<!-- END s_custom_color_use -->
	<!-- BEGIN s_custom_rank -->
	<tr>
		<td class="row1" align="center" width="2%"><input type="checkbox" id="c16" name="custom_rank"{c_custom_rank} value="1">&nbsp;</td>
		<td class="row1"><span class="gen"><label for="c16" style="cursor: pointer;">{L_CUSTOM_RANK}</label></span></td>
	</tr>
	<!-- END s_custom_rank -->
	<!-- BEGIN s_cagent -->
	<tr>
		<td class="row1" align="center" width="2%"><input type="checkbox" id="c17" name="cagent"{c_cagent} value="1">&nbsp;</td>
		<td class="row1"><span class="gen"><label for="c17" style="cursor: pointer;">{L_CAGENT}</label></span></td>
	</tr>
	<!-- END s_cagent -->
	<!-- BEGIN s_level -->
	<tr>
		<td class="row1" align="center" width="2%"><input type="checkbox" id="c18" name="level"{c_level} value="1">&nbsp;</td>
		<td class="row1"><span class="gen"><label for="c18" style="cursor: pointer;">{L_LEVEL}</label></span></td>
	</tr>
	<!-- END s_level -->
	<!-- BEGIN s_cignore -->
	<tr>
		<td class="row1" align="center" width="2%"><input type="checkbox" id="c19" name="cignore"{c_cignore} value="1">&nbsp;</td>
		<td class="row1"><span class="gen"><label for="c19" style="cursor: pointer;">{L_CIGNORE}</label></span></td>
	</tr>
	<!-- END s_cignore -->
	<!-- BEGIN s_cquick -->
	<tr>
		<td class="row1" align="center" width="2%"><input type="checkbox" id="c20" name="cquick"{c_cquick} value="1">&nbsp;</td>
		<td class="row1"><span class="gen"><label for="c20" style="cursor: pointer;">{L_CQUICK}</label></span></td>
	</tr>
	<!-- END s_cquick -->
	<!-- BEGIN s_show_smiles -->
	<tr>
		<td class="row1" align="center" width="2%"><input type="checkbox" id="c21" name="show_smiles"{c_show_smiles} value="1">&nbsp;</td>
		<td class="row1"><span class="gen"><label for="c21" style="cursor: pointer;">{L_SHOW_SMILES}</label></span></td>
	</tr>
	<!-- END s_show_smiles -->
	<!-- BEGIN s_post_icon -->
	<tr>
		<td class="row1" align="center" width="2%"><input type="checkbox" id="c22" name="post_icon"{c_post_icon} value="1">&nbsp;</td>
		<td class="row1"><span class="gen"><label for="c22" style="cursor: pointer;">{L_POST_ICON}</label></span></td>
	</tr>
	<!-- END s_post_icon -->
	<!-- BEGIN s_advertising -->
	<tr>
		<td class="row1" align="center" width="2%"><input type="checkbox" id="c23" name="advertising"{c_advertising} value="1">&nbsp;</td>
		<td class="row1"><span class="gen"><label for="c23" style="cursor: pointer;">{L_ADVERTISING}</label></span></td>
	</tr>
	<!-- END s_advertising -->
	<!-- BEGIN s_user_topics_per_page -->
	<tr>
		<td class="row1" align="center" width="2%"><input type="text" name="user_topics_per_page" size="3" maxlength="4" value="{c_user_topics_per_page}" class="post">&nbsp;</td>
		<td class="row1"><span class="gen">{L_USER_TOPICS_PER_PAGE}</span></td>
	</tr>
	<!-- END s_user_topics_per_page -->
	<!-- BEGIN s_user_posts_per_page -->
	<tr>
		<td class="row1" align="center" width="2%"><input type="text" name="user_posts_per_page" size="3" maxlength="4" value="{c_user_posts_per_page}" class="post">&nbsp;</td>
		<td class="row1"><span class="gen">{L_USER_POSTS_PER_PAGE}</span></td>
	</tr>
	<!-- END s_user_posts_per_page -->
	<!-- BEGIN s_user_hot_threshold -->
	<tr>
		<td class="row1" align="center" width="2%"><input type="text" name="user_hot_threshold" size="3" maxlength="4" value="{c_user_hot_threshold}" class="post">&nbsp;</td>
		<td class="row1"><span class="gen">{L_USER_HOT_THRESHOLD}</span></td>
	</tr>
	<!-- END s_user_hot_threshold -->
	<tr> 
		<th colspan="2">{L_DATE_FORMAT}</td>
	</tr>
	<tr>
		<td class="row1" colspan="2">{DATE_FORMAT_SELECT}</td>
	</tr>
	<!-- BEGIN s_user_sub_forum -->
	<tr> 
		<th colspan="2">{L_USER_SUB_FORUM}</th>
	</tr>
	<tr>
		<td class="row1" colspan="2">
			<span class="gensmall">
				<input type="radio" name="user_sub_forum" value="0" {SUB_FORUM_0}> {L_NONES}
				<input type="radio" name="user_sub_forum" value="1" {SUB_FORUM_1}> {L_MEDIUM}
				<input type="radio" name="user_sub_forum" value="2" {SUB_FORUM_2}> {L_FULL}
			</span>
		</td>
	</tr>
	<!-- END s_user_sub_forum -->
	<!-- BEGIN s_user_split_cat -->
	<tr> 
		<th colspan="2">{L_USER_SPLIT_CAT}</span></th>
	</tr>
	<tr>
		<td class="row1" colspan="2">
		<span class="gensmall">
		<input type="radio" name="user_split_cat" value="1" {SPLIT_CAT_YES}> {L_YES} 
		<input type="radio" name="user_split_cat" value="0" {SPLIT_CAT_NO}> {L_NO}
		</span>
		</td>
	</tr>
	<!-- END s_user_split_cat -->
	<!-- BEGIN s_user_last_topic_title -->
	<tr> 
		<th colspan="2">{L_USER_LAST_TOPIC_TITLE}</th>
	</tr>
	<tr>
		<td class="row1" colspan="2">
		<span class="gensmall">
		<input type="radio" name="user_last_topic_title" value="1" {LAST_TOPIC_TITLE_YES}> {L_YES}
		<input type="radio" name="user_last_topic_title" value="0" {LAST_TOPIC_TITLE_NO}> {L_NO}
		</span></td>
	</tr>
	<!-- END s_user_last_topic_title -->
	<!-- BEGIN s_user_sub_level_links -->

	<tr> 
		<th class="row1" colspan="2">{L_USER_SUB_LEVEL_LINKS}</th>
	</tr>
	<tr>
		<td class="row1" colspan="2">
		<span class="gensmall">
		<input type="radio" name="user_sub_level_links" value="1" {SUB_LEVEL_LINKS_1}> {L_YES}
		<input type="radio" name="user_sub_level_links" value="0" {SUB_LEVEL_LINKS_0}> {L_NO}
		<input type="radio" name="user_sub_level_links" value="2" {SUB_LEVEL_LINKS_2}> {L_WITH_PICS}
		</span></td>
	</tr>
	<!-- END s_user_sub_level_links -->
	<!-- BEGIN s_user_display_viewonline -->
	<tr> 
		<th class="row1" colspan="2">{L_USER_DISPLAY_VIEWONLINE}</th>
	</tr>
	<tr>
		<td class="row1" colspan="2">
		<span class="gensmall">
		<input type="radio" name="user_display_viewonline" value="2" {DISPLAY_VIEWONLINE_2}> {L_YES}
		<input type="radio" name="user_display_viewonline" value="0" {DISPLAY_VIEWONLINE_0}> {L_NO}
		<input type="radio" name="user_display_viewonline" value="1" {DISPLAY_VIEWONLINE_1}> {L_ROOT_INDEX}
		</span></td>
	</tr>
	<!-- END s_user_display_viewonline -->
	<tr>
		<td class="submit" colspan="2">
			<input type="submit" name="submit" value="{L_SUBMIT}" onClick="document.prefs.submit.title='save';" />
			<input type="reset" value="{L_RESET}" name="reset" />
		</td>
	</tr>
</table>
</form>