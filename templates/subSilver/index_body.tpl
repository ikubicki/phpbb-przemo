<!-- BEGIN switch_enable_board_msg_index --> 
<div id="hm" style="display: ''; position: relative;">
<table width="100%" class="forumline" cellspacing="1" cellpadding="3" border="0" align="center">
  <tr> 
   <th class="thCornerL" height="25" nowrap="nowrap" onclick="javascript:ShowHide('hm','hm2','hm3');" style="cursor: pointer" title="{L_VHIDE}">&nbsp;{L_BOARD_MSG}&nbsp;</th>
  </tr>
  <tr>
   <td class="row1"><span class="gen">{BOARD_MSG}</span></td>
  </tr>
</table>
</div>
<div id="hm2" style="display: none; position: relative;">
<table width="100%" class="forumline" cellspacing="1" cellpadding="3" border="0" align="center">
  <tr> 
   <th class="thCornerL" height="25" nowrap="nowrap" onclick="javascript:ShowHide('hm','hm2','hm3');" style="cursor: pointer">&nbsp;{L_BOARD_MSG}&nbsp;</th>
  </tr>
</table>
</div>
<script language="javascript" type="text/javascript">
<!--
if(GetCookie('hm3') == '2') ShowHide('hm', 'hm2', 'hm3');
//-->
</script>
<!-- END switch_enable_board_msg_index --> 

<!-- BEGIN custom_registration -->
<form method="post" action="{S_PROFILE_ACTION}">
<table width="100%" cellpadding="1" cellspacing="0" border="0" class="forumline">
	<tr>
		<td>
			<table width="100%" cellpadding="3" cellspacing="0" border="0" class="forumline">
				<tr>
					<td class="catHead" colspan="9" height="28"><span class="cattitle">&nbsp;{L_REGIST_TITLE}</span></td>
				</tr>
				<tr>
					<td class="row1" align="left" valign="middle" nowrap="nowrap"><span class="gensmall">{L_USERNAME}:</span></td>
					<td class="row1" align="left" valign="middle"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" style="width:120px" name="username" size="25" maxlength="20" value=""></td>
					<td class="row1">&nbsp;</td>
					<td class="row1" align="left" valign="middle" nowrap="nowrap"><span class="gensmall">{L_PASSWORD}:</span></td>
					<td class="row1" align="left" valign="middle"><input type="password" class="post" onFocus="Active(this)" onBlur="NotActive(this)" style="width:120px" name="new_password" size="25" maxlength="100" value=""></td>
					<td nowrap class="row1" align="left" valign="middle" colspan="3">
						<!-- BEGIN gender_box -->
						<span class="gensmall">&nbsp;{L_GENDER}: {L_FEMALE}<input type="radio" name="gender" value="2"> {L_MALE}<input type="radio" name="gender" value="1"></span>
						<!-- END gender_box -->
						<!-- BEGIN validation -->
						<img src="{VALIDATION_IMAGE}" width="95" height="20" border="0" alt="">&nbsp;
						<input type="text" class="post" onFocus="Active(this); this.value=''" onBlur="NotActive(this)" name="reg_key" maxlength="4" size="4" value="{L_CODE}">&nbsp;&nbsp;&nbsp&nbsp;
						<!-- END validation -->
					</td>
					<td class="row1" width="100%"></td>
				</tr>
				<tr>
					<td class="row1" align="left" valign="middle"><span class="gensmall">{L_CONFIRM_PASSWORD}:</span></td>
					<td class="row1" align="left" valign="middle"><input type="password" class="post" onFocus="Active(this)" onBlur="NotActive(this)" style="width:120px" name="password_confirm" size="25" maxlength="100" value=""></td>
					<td class="row1">&nbsp;</td>
					<td class="row1" align="left" valign="middle" nowrap="nowrap"><span class="gensmall">{L_EMAIL}:</span></td>
					<td class="row1"><input type="text" class="post" style="width:120px" name="email1" size="25" maxlength="200" value="" /></td>
					<td class="row1"><span class="genmed">@</span></td>
					<td class="row1"><input type="text" class="post" style="width:120px" name="email2" size="25" maxlength="200" value="" /></td>
					<td class="row1" align="left" valign="middle" nowrap="nowrap"><span class="gensmall">{CUSTOM_FIELDS}{S_HIDDEN_FIELDS}
					<input type="submit" name="submit" value="{L_RSSUBMIT}" class="liteoption"></span></td>
					<td class="row1" width="100%"></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
<!-- END custom_registration -->

<!-- BEGIN switch_user_logged_out -->
<form method="post" action="{S_LOGIN_ACTION}">
<!-- END switch_user_logged_out -->

<table width="100%" cellspacing="1" cellpadding="3" border="0" align="center">
   <tr>
      <td align="left" valign="bottom"><span class="gensmall">
         <!-- BEGIN switch_user_logged_in -->
         {LAST_VISIT_DATE}<br>
         <!-- END switch_user_logged_in -->
         {CURRENT_TIME}<br></span></td>
         <td align="right" valign="bottom" class="gensmall">
         <!-- BEGIN switch_user_logged_in -->
         <a href="{U_SEARCH_SELF}" class="gensmall">{L_SEARCH_SELF}</a><br>
         <!-- END switch_user_logged_in -->
         <a href="{U_SEARCH_UNANSWERED}" class="gensmall">{L_SEARCH_UNANSWERED}</a>
		<br>
		<!-- BEGIN switch_unread -->
		<a href="{U_SEARCH_NEW}" class="gensmall">{L_SEARCH_NEW} [{COUNT_NEW_POSTS}]</a> &laquo;&raquo;
		<!-- END switch_unread -->
		<!-- BEGIN switch_user_logged_in -->
		<a href="{U_SEARCH_LASTVISIT}" class="gensmall">{L_SEARCH_LASTVISIT}</a>
		<!-- END switch_user_logged_in -->
		<!-- BEGIN switch_user_logged_out -->
		<span class="gensmall"><input class="post" onFocus="Active(this); this.value=''" onBlur="NotActive(this)" type="text" name="username" size="8" value="nick"/>&nbsp;<input class="post" onFocus="Active(this); this.value=''" onBlur="NotActive(this)" type="password" name="password" value="1111111" size="8">
		<!-- BEGIN switch_allow_autologin -->
		<input class="text" type="checkbox" name="autologin">
		<!-- END switch_allow_autologin -->
		<input type="submit" class="liteoption" name="login" value="{L_LOGIN}"></span>
		<!-- END switch_user_logged_out -->
      </td>
   </tr>
</table>

<!-- BEGIN switch_user_logged_out -->
</form>
<!-- END switch_user_logged_out -->

{BOARD_INDEX}

<form method="post" action="{T_SELECT_ACTION}" name="quickchange">
<table width="100%" cellspacing="1" border="0" align="center" cellpadding="3">
   <tr>
		<td align="left"><span class="gensmall">
			<!-- BEGIN switch_user_logged_in -->
			<a href="{U_MARK_READ}" class="gensmall">{L_MARK_FORUMS_READ}</a>
			<!-- END switch_user_logged_in -->
		</span></td>
		<td align="right"><span class="gensmall">[ <a href="javascript:void(0);" OnClick="window.open('{U_PREFERENCES}', 'WindowOpen', 'HEIGHT=500,resizable=yes,scrollbars=yes,WIDTH=380');" style="text-decoration: none;">{L_PREFERENCES}</a> ]&nbsp;
			<!-- BEGIN change_style -->
			{change_style.L_CHANGE_STYLE}: 
			{change_style.TEMPLATE_SELECT}
			<!-- END change_style -->
		</span></td>
   </tr>
</table>
</form>

<!-- BEGIN custom_registration_bottom -->
<form method="post" action="{S_PROFILE_ACTION}">
<table width="100%" cellpadding="1" cellspacing="0" border="0" class="forumline">
	<tr>
		<td>
			<table width="100%" cellpadding="3" cellspacing="0" border="0" class="forumline">
				<tr>
					<td class="catHead" colspan="9" height="28"><span class="cattitle">&nbsp;{L_REGIST_TITLE}</span></td>
				</tr>
				<tr>
					<td class="row1" align="left" valign="middle" nowrap="nowrap"><span class="gensmall">{L_USERNAME}:</span></td>
					<td class="row1" align="left" valign="middle"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" style="width:120px" name="username" size="25" maxlength="20" value=""></td>
					<td class="row1">&nbsp;</td>
					<td class="row1" align="left" valign="middle" nowrap="nowrap"><span class="gensmall">{L_PASSWORD}:</span></td>
					<td class="row1" align="left" valign="middle"><input type="password" class="post" onFocus="Active(this)" onBlur="NotActive(this)" style="width:120px" name="new_password" size="25" maxlength="100" value=""></td>
					<td nowrap class="row1" align="left" valign="middle" colspan="3">
						<!-- BEGIN gender_box -->
						<span class="gensmall">&nbsp;{L_GENDER}: {L_FEMALE}<input type="radio" name="gender" value="2"> {L_MALE}<input type="radio" name="gender" value="1"></span>
						<!-- END gender_box -->
						<!-- BEGIN validation -->
						<img src="{VALIDATION_IMAGE}" width="95" height="20" border="0">&nbsp;
						<input type="text" class="post" onFocus="Active(this); this.value=''" onBlur="NotActive(this)" name="reg_key" maxlength="4" size="4" value="{L_CODE}">&nbsp;&nbsp;&nbsp&nbsp;
						<!-- END validation -->
					</td>
					<td class="row1" width="100%"></td>
				</tr>
				<tr>
					<td class="row1" align="left" valign="middle"><span class="gensmall">{L_CONFIRM_PASSWORD}:</span></td>
					<td class="row1" align="left" valign="middle"><input type="password" class="post" onFocus="Active(this)" onBlur="NotActive(this)" style="width:120px" name="password_confirm" size="25" maxlength="100" value=""></td>
					<td class="row1">&nbsp;</td>
					<td class="row1" align="left" valign="middle" nowrap="nowrap"><span class="gensmall">{L_EMAIL}:</span></td>
					<td class="row1"><input type="text" class="post" style="width:120px" name="email1" size="25" maxlength="200" value="" /></td>
					<td class="row1"><span class="genmed">@</span></td>
					<td class="row1"><input type="text" class="post" style="width:120px" name="email2" size="25" maxlength="200" value="" /></td>
					<td class="row1" align="left" valign="middle" nowrap="nowrap"><span class="gensmall">{CUSTOM_FIELDS}{S_HIDDEN_FIELDS}
					<input type="submit" name="submit" value="{L_RSSUBMIT}" class="liteoption"></span></td>
					<td class="row1" width="100%"></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
<br>
<!-- END custom_registration_bottom -->

   <!-- BEGIN disable_viewonline -->
   <table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
      <tr>
         <th colspan="2"><span class="cattitle"><a href="{U_VIEWONLINE}" class="cattitle" title="{L_VIEW_DETAILED}">{L_WHO_IS_ONLINE}</a></span></th>
      </tr>
      <tr>
         <td class="row1" {ONMOUSE_COLORS}align="center" valign="middle" rowspan="2">
            <img src="templates/subSilver/images/whosonline.gif" width="46" height="25" alt=""></td>
         <td class="row1" {ONMOUSE_COLORS}align="left" width="100%">
            <span class="gensmall">{TOTAL_POSTS}<br>{TOTAL_USERS}<br>{NEWEST_USER}{COUNTER}</span></td>
      </tr>
      <tr>
         <td class="row1" {ONMOUSE_COLORS}align="left">
            <span class="gensmall">{TOTAL_USERS_ONLINE}<br>{LOGGED_IN_USER_LIST}<br>{RECORD_USERS}
			<!-- BEGIN staff_explain -->
			<a href="{disable_viewonline.staff_explain.U_GROUP_URL}" class="gensmall" style="color: #{disable_viewonline.staff_explain.GROUP_COLOR}{disable_viewonline.staff_explain.GROUP_STYLE}">{disable_viewonline.staff_explain.GROUP_PREFIX}{disable_viewonline.staff_explain.GROUP_NAME}</a>
			<!-- BEGIN se_separator -->
			&bull;
			<!-- END se_separator -->
			<!-- END staff_explain -->
			<br>{USERS_OF_THE_DAY_LIST}</span></td>
      </tr>
   </table>

   <table width="100%" cellpadding="1" cellspacing="1" border="0">
      <tr>
         <td align="left" valign="top"><span class="gensmall">{L_ONLINE_EXPLAIN}</span></td>
      </tr>
   </table>

   <!-- END disable_viewonline -->
   <br clear="all">
   <table cellspacing="3" border="0" align="center" cellpadding="0">
      <tr>
         <td width="20" align="center"><img src="{FOLDER_NEW_IMG}" alt=""/></td>
         <td><span class="gensmall">{L_NEW_POSTS}</span></td>
         <td>&nbsp;&nbsp;</td>
         <td width="20" align="center"><img src="{FOLDER_IMG}" alt=""></td>
         <td><span class="gensmall">{L_NO_NEW_POSTS}</span></td>
         <td>&nbsp;&nbsp;</td>
         <td width="20" align="center"><img src="{FOLDER_LOCKED_IMG}" alt=""></td>
         <td><span class="gensmall">{L_FORUM_LOCKED}</span></td>
      </tr>
   </table>
   <br clear="all">
	{SHOUTBOX_DISPLAY}
