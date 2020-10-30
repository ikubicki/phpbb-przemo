{{ include('overall_header.tpl') }}

{% if custom_registration %}
<form method="post" action="{{ S_PROFILE_ACTION }}">
	<table class="forumline posting nolength">
		<tr>
			<th colspan="6"><span class="cattitle">{{ L_REGIST_TITLE }}</span></th>
		</tr>
		<tr>
			<td class="row1" valign="middle">{{ L_USERNAME }}</td>
			<td class="row1" valign="middle">
				<input type="text" name="username" maxlength="20" />
			</td>

			<td width="10%" class="row1" valign="middle">{{ L_EMAIL }}</td>
			<td width="10%" class="row1">
				<input type="text" name="email1" maxlength="200" />
			</td>
			<td width="1%" class="row1">
				<span class="genmed">@</span>
			</td>
			<td width="59%" class="row1">
				<input type="text" name="email2" maxlength="200" />
			</td>
		</tr>
		<tr>
			
			<td class="row1" valign="middle">{{ L_PASSWORD }}</td>
			<td class="row1" valign="middle">
				<input type="password" name="new_password" maxlength="100" />
			</td>
			<td width="10%" class="row1" valign="middle">{{ L_CONFIRM_PASSWORD }}</td>
			<td width="10%" class="row1" valign="middle">
				<input type="password" name="password_confirm" maxlength="100" />
			</td>
			<td nowrap class="row1" colspan="3">&nbsp;</td>
			
		</tr>
{% if CUSTOM_FIELDS %}
		<tr>
			<td class="row1" valign="middle" colspan="6">
				{{ CUSTOM_FIELDS | raw }}
			</td>
		</tr>
{% endif %}
{% if gender_box %}
		<tr>
			<td class="row1" valign="middle" colspan="6">
				{{ L_GENDER }}
				<label>{{ L_FEMALE }}<input type="radio" name="gender" value="2" /></label>
				<label>{{ L_MALE }}<input type="radio" name="gender" value="1" /></label>
			</td>
		</tr>
{% endif %}
{% if validation %}
		<tr>
			<td class="row1" valign="middle" colspan="6">
				<img src="{{ VALIDATION_IMAGE }}" width="95" height="20" border="0" alt="">
				<input type="text" class="post" name="reg_key" maxlength="4" value="{{ L_CODE }}" />
			</td>
		</tr>
{% endif %}
		<tr>
			<td colspan="6" class="submit">
				{{ S_HIDDEN_FIELDS | raw }}
				<input type="submit" name="submit" value="{{ L_RSSUBMIT }}" />
			</td>
		</tr>
	</table>
</form>
{% endif %}

{% if switch_enable_board_msg_index %}
<div id="hm" style="display: ''; position: relative;">
<table class="forumline" align="center">
  <tr> 
   <th height="25" onclick="javascript:ShowHide('hm','hm2','hm3');" style="cursor: pointer" title="{{ L_VHIDE }}">&nbsp;{{ L_BOARD_MSG }}&nbsp;</th>
  </tr>
  <tr>
   <td class="row1"><span class="gen">{{ BOARD_MSG }}</span></td>
  </tr>
</table>
</div>
<div id="hm2" style="display: none; position: relative;">
<table width="100%" class="forumline" cellspacing="1" cellpadding="3" border="0" align="center">
  <tr> 
   <th height="25" onclick="javascript:ShowHide('hm','hm2','hm3');" style="cursor: pointer">&nbsp;{{ L_BOARD_MSG }}&nbsp;</th>
  </tr>
</table>
</div>
<script language="javascript" type="text/javascript">
<!--
if(GetCookie('hm3') == '2') ShowHide('hm', 'hm2', 'hm3');
//-->
</script>
{% endif %}


{% if switch_user_logged_out %}
<form method="post" action="{{ S_LOGIN_ACTION }}" name="quicklogin">
{% endif %}

<table class="block">
   <tr>
      <td valign="bottom"><span class="gensmall">
         {% if switch_user_logged_in %}
         {{ LAST_VISIT_DATE }}<br />
		 {{ CURRENT_TIME }}<br />
         {% endif %}
         </span></td>
         <td align="right" valign="bottom" class="gensmall">
		 {% if switch_user_logged_in %}
         <a href="{{ U_SEARCH_SELF }}" class="gensmall">{{ L_SEARCH_SELF }}</a><br />
         <a href="{{ U_SEARCH_UNANSWERED }}" class="gensmall">{{ L_SEARCH_UNANSWERED }}</a>
		 {% endif %}
		<br />
		{% if switch_unread %}
		<a href="{{ U_SEARCH_NEW }}" class="gensmall">{{ L_SEARCH_NEW }} [{{ COUNT_NEW_POSTS }}]</a> &laquo;&raquo;
		{% endif %}
		{% if switch_user_logged_in %}
		<a href="{{ U_SEARCH_LASTVISIT }}" class="gensmall">{{ L_SEARCH_LASTVISIT }}</a>
		{% endif %}
		{% if switch_user_logged_out %}
		
			<input type="text" name="username" value="nick" />
			<input type="password" name="password" value="password" size="8" />
		{% if switch_allow_autologin %}
			<input type="checkbox" name="autologin" />
		{% endif %}
			<input type="submit" name="login" value="{{ L_LOGIN }}" />
		
		{% endif %}
      </td>
   </tr>
</table>

{% if switch_user_logged_out %}
</form>
{% endif %}

{{ BOARD_INDEX|raw }}
<br />
<form method="post" action="{{ T_SELECT_ACTION }}" name="quickchange">
<table class="block legend">
   <tr>
		<td style="width:30%">
			{% if switch_user_logged_in %}
			<a href="{{ U_MARK_READ }}" class="gensmall">{{ L_MARK_FORUMS_READ }}</a>
			{% endif %}
		</td>
		<td style="width:40%">
			<img src="{{ FOLDER_NEW_IMG }}" alt="" /> {{ L_NEW_POSTS }}
			<img src="{{ FOLDER_IMG }}" alt="" /> {{ L_NO_NEW_POSTS }}
			<img src="{{ FOLDER_LOCKED_IMG }}" alt="" /> {{ L_FORUM_LOCKED }}
		</td>
		<td style="width:30%">
			{% for _change_style in change_style %}
			{{ _change_style.L_CHANGE_STYLE }}: 
			{{ _change_style.TEMPLATE_SELECT | raw }}
			{% endfor %}
		</td>
   </tr>
</table>
</form>
<br />
{% if custom_registration_bottom %}
<form method="post" action="{{ S_PROFILE_ACTION }}">
<table width="100%" cellpadding="1" cellspacing="0" border="0" class="forumline">
	<tr>
		<td>
			<table width="100%" cellpadding="3" cellspacing="0" border="0" class="forumline">
				<tr>
					<td colspan="9" height="28"><span class="cattitle">&nbsp;{{ L_REGIST_TITLE }}</span></td>
				</tr>
				<tr>
					<td class="row1" valign="middle"><span class="gensmall">{{ L_USERNAME }}:</span></td>
					<td class="row1" valign="middle"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" style="width:120px" name="username" size="25" maxlength="20" value=""></td>
					<td class="row1">&nbsp;</td>
					<td class="row1" valign="middle"><span class="gensmall">{{ L_PASSWORD }}:</span></td>
					<td class="row1" valign="middle"><input type="password" class="post" onFocus="Active(this)" onBlur="NotActive(this)" style="width:120px" name="new_password" size="25" maxlength="100" value=""></td>
					<td nowrap class="row1" valign="middle" colspan="3">
						<!-- BEGIN gender_box -->
						<span class="gensmall">&nbsp;{{ L_GENDER }}: {{ L_FEMALE }}<input type="radio" name="gender" value="2"> {{ L_MALE }}<input type="radio" name="gender" value="1"></span>
						<!-- END gender_box -->
						<!-- BEGIN validation -->
						<img src="{{ VALIDATION_IMAGE }}" width="95" height="20" border="0">&nbsp;
						<input type="text" class="post" onFocus="Active(this); this.value=''" onBlur="NotActive(this)" name="reg_key" maxlength="4" size="4" value="{{ L_CODE }}">&nbsp;&nbsp;&nbsp&nbsp;
						<!-- END validation -->
					</td>
					<td class="row1" width="100%"></td>
				</tr>
				<tr>
					<td class="row1" valign="middle"><span class="gensmall">{{ L_CONFIRM_PASSWORD }}:</span></td>
					<td class="row1" valign="middle"><input type="password" class="post" onFocus="Active(this)" onBlur="NotActive(this)" style="width:120px" name="password_confirm" size="25" maxlength="100" value=""></td>
					<td class="row1">&nbsp;</td>
					<td class="row1" valign="middle"><span class="gensmall">{{ L_EMAIL }}:</span></td>
					<td class="row1"><input type="text" class="post" style="width:120px" name="email1" size="25" maxlength="200" value="" /></td>
					<td class="row1"><span class="genmed">@</span></td>
					<td class="row1"><input type="text" class="post" style="width:120px" name="email2" size="25" maxlength="200" value="" /></td>
					<td class="row1" valign="middle"><span class="gensmall">{{ CUSTOM_FIELDS }}{{ S_HIDDEN_FIELDS }}
					<input type="submit" name="submit" value="{{ L_RSSUBMIT }}" class="liteoption"></span></td>
					<td class="row1" width="100%"></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
<br>
{% endif %}

	{{ SHOUTBOX_DISPLAY | raw }}

   <!-- BEGIN disable_viewonline -->
   <table class="forumline online">
      <tr>
        <th colspan="3">
		 	<a href="{{ U_VIEWONLINE }}" class="cattitle">{{ L_WHO_IS_ONLINE }}</a>
		</th>
      </tr>
      <tr>
        <td class="icon">
            <img src="templates/subSilver/images/whosonline.gif" alt="" />
		</td>
		<td class="col1">
            {{ TOTAL_POSTS }}<br />
			{{ TOTAL_USERS }}<br />
			{{ NEWEST_USER }}
			{{ COUNTER }}
		</td>
        <td class="col2">
            {{ TOTAL_USERS_ONLINE }}<br />
			{{ LOGGED_IN_USER_LIST }}<br />
			{{ RECORD_USERS }}
			<!-- BEGIN staff_explain -->
			<a href="{{ disable_viewonline.staff_explain.U_GROUP_URL }}" style="color: #{{ disable_viewonline.staff_explain.GROUP_COLOR }}{{ disable_viewonline.staff_explain.GROUP_STYLE }}">
				{{ disable_viewonline.staff_explain.GROUP_PREFIX }}{{ disable_viewonline.staff_explain.GROUP_NAME }}
			</a>
			<!-- BEGIN se_separator -->
			&bull;
			<!-- END se_separator -->
			<!-- END staff_explain -->
			<br />
			{{ USERS_OF_THE_DAY_LIST }}
		</td>
      </tr>
   </table>

   <table width="100%" cellpadding="1" cellspacing="1" border="0">
      <tr>
         <td valign="top"><span class="gensmall">{{ L_ONLINE_EXPLAIN }}</span></td>
      </tr>
   </table>

   <!-- END disable_viewonline -->
   <br clear="all">

{{ include('overall_footer.tpl') }}