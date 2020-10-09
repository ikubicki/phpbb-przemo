<script src="/js/ckeditor/ckeditor.js"></script>
<!-- BEGIN privmsg_extensions -->
<table border="0" cellspacing="0" cellpadding="0" align="center" width="100%">
	<tr>
		<td valign="top" align="center" width="100%">
			<table height="40" cellspacing="2" cellpadding="2" border="0">
				<tr valign="middle">
					<td>{INBOX_IMG}</td>
					<td><span class="cattitle">{INBOX_LINK}&nbsp;&nbsp;</span></td>
					<td>{SENTBOX_IMG}</td>
					<td><span class="cattitle">{SENTBOX_LINK}&nbsp;&nbsp;</span></td>
					<td>{OUTBOX_IMG}</td>
					<td><span class="cattitle">{OUTBOX_LINK}&nbsp;&nbsp;</span></td>
					<td>{SAVEBOX_IMG}</td>
					<td><span class="cattitle">{SAVEBOX_LINK}&nbsp;&nbsp;</span></td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<br clear="all">
<!-- END privmsg_extensions -->

<form action="{S_POST_ACTION}" method="post" name="post" onsubmit="return checkForm(this)" {S_FORM_ENCTYPE}>

{POST_PREVIEW_BOX}
{ERROR_BOX}

<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
	<tr>
		<th class="thHead" colspan="2" height="25"><b>{L_POST_A}</b></th>
	</tr>
	<!-- BEGIN switch_username_select -->
	<tr>
		<td class="row1"><span class="gen"><b>{L_USERNAME}</b></span></td>
		<td class="row2"><span class="genmed"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" tabindex="1" name="username" size="25" maxlength="25" value="{USERNAME}"></span></td>
	</tr>
	<!-- END switch_username_select -->
	<!-- BEGIN switch_privmsg -->
	<tr>
		<td class="row1"><span class="gen"><b>{L_USERNAME}</b></span></td>
		<td class="row2"><span class="genmed"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" name="username" maxlength="25" size="25" tabindex="1" value="{USERNAME}">&nbsp;<input type="submit" name="usersubmit" value="{L_FIND_USERNAME}" class="liteoption" onClick="window.open('{U_SEARCH_USER}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false;"></span></td>
	</tr>
	<!-- END switch_privmsg -->
	<tr>
	<td class="row1" width="22%">
		<table width="100%" border="0">
			<tr>
				<td align="left"><span class="gen"><b>{L_SUBJECT}</b></span></td>
				<td align="right">&nbsp;
					<!-- BEGIN topic_tags -->
					<select name="topic_tag">
					{TOPIC_TAGS_OPTIONS}
					</select>
					<!-- END topic_tags -->	
				</td>
			</tr>
		</table>
	</td>
	<td class="row2" width="78%">
		<span class="gen">
			<input type="text" name="subject" size="45" maxlength="60" style="width:550px" tabindex="2" class="post" onFocus="Active(this)" onBlur="NotActive(this)" value="{SUBJECT}">
		</span>
	</td>
	</tr>
	<!-- BEGIN topic_explain -->
	<tr>
		<td class="row1" width="22%"><span class="gen"><b>{L_SUBJECT_E}</b></span> <span class="gensmall">({L_SUBJECT_E_INFO})</span></td>
		<td class="row2" width="78%">
			<span class="gen">
				<input type="text" name="subject_e" size="45" maxlength="100" style="width:550px;height:17px;font-size:9px;" tabindex="2" class="post" onFocus="Active(this)" onBlur="NotActive(this)" value="{SUBJECT_E}">
			</span>
		</td>
	</tr>
	<!-- END topic_explain -->
	<!-- BEGIN switch_msgicon_checkbox -->
	<tr>
		<td valign="middle" class="row1"><span class="gen"><b>{MESSAGEICON}</b></span></td>
		<td class="row2">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><span class="{CLASS_MORE_ICONS}">
						<input type="radio" name="msg_icon" value="1" {MSG_ICON_CHECKED1}><img src="{ICON_PATH}icon/icon1.gif" alt="">
						<input type="radio" name="msg_icon" value="2" {MSG_ICON_CHECKED2}><img src="{ICON_PATH}icon/icon2.gif" alt="">
						<input type="radio" name="msg_icon" value="3" {MSG_ICON_CHECKED3}><img src="{ICON_PATH}icon/icon3.gif" alt="">
						<input type="radio" name="msg_icon" value="4" {MSG_ICON_CHECKED4}><img src="{ICON_PATH}icon/icon4.gif" alt="">
						<input type="radio" name="msg_icon" value="5" {MSG_ICON_CHECKED5}><img src="{ICON_PATH}icon/icon5.gif" alt="">
						<input type="radio" name="msg_icon" value="6" {MSG_ICON_CHECKED6}><img src="{ICON_PATH}icon/icon6.gif" alt="">
						<input type="radio" name="msg_icon" value="7" {MSG_ICON_CHECKED7}><img src="{ICON_PATH}icon/icon7.gif" alt="">
						<input type="radio" name="msg_icon" value="8" {MSG_ICON_CHECKED8}><img src="{ICON_PATH}icon/icon8.gif" alt="">
						<input type="radio" name="msg_icon" value="9" {MSG_ICON_CHECKED9}><img src="{ICON_PATH}icon/icon9.gif" alt="">
						<input type="radio" name="msg_icon" value="10" {MSG_ICON_CHECKED10}><img src="{ICON_PATH}icon/icon10.gif" alt="">
						<input type="radio" name="msg_icon" value="11" {MSG_ICON_CHECKED11}><img src="{ICON_PATH}icon/icon11.gif" alt="">
						<input type="radio" name="msg_icon" value="12" {MSG_ICON_CHECKED12}><img src="{ICON_PATH}icon/icon12.gif" alt="">
						<input type="radio" name="msg_icon" value="0" {MSG_ICON_CHECKED0}>
						<!-- BEGIN more_icons -->
						<input type="text" size="1" maxlength="3" name="more_icon" value="{MORE_ICON_CHECK}" class="post" onClick="window.open('{U_MORE_ICONS}', '_phpbbsmilies', 'HEIGHT=300, resizable=yes, scrollbars=yes, WIDTH=450');return false;" onMouseOver="return overlib('<left>{L_MORE_TOPICICONS}</left>', CAPTION, '<center>{L_MORE_SMILIES}</center>')" onMouseOut="nd();">
						<!-- END more_icons -->
						</span></td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- END switch_msgicon_checkbox --> 
	<tr>
	<td class="row1" valign="top">
		<span class="gen"><b>{L_MESSAGE_BODY}</b></span>
	</td>
	<td class="row2" valign="top">
		<table width="550" border="0" cellspacing="0" cellpadding="2">
			<tr>
				<td><span class="gen"><textarea name="message" id="message" rows="15" cols="35" style="width:550px" tabindex="3" class="post" onFocus="Active(this)" onBlur="NotActive(this)" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);">{MESSAGE}</textarea></span></td>
			</tr>
		</table>

		<script type="text/javascript">
			CKEDITOR.replace('message');
		</script>

	</td>
	</tr>

	<!-- BEGIN expire_box -->
	<tr>
		<td class="row1" valign="top"><span class="gen"><b>{expire_box.L_EXPIRE_P}</b></span>
			<br><span class="gensmall">{expire_box.L_EXPIRE_PE}</span>
		</td>
		<td class="row2">
			<select class="post" name="msg_expire">
				<option value="0" class="genmed" {expire_box.CHECK_0}>{expire_box.L_EXPIRE_UNLIMIT}</option>
				<option value="1" class="genmed" {expire_box.CHECK_1}>{expire_box.L_1_DAY}</option>
				<option value="2" class="genmed" {expire_box.CHECK_2}>{expire_box.L_2_DAYS}</option>
				<option value="3" class="genmed" {expire_box.CHECK_3}>{expire_box.L_3_DAYS}</option>
				<option value="4" class="genmed" {expire_box.CHECK_4}>{expire_box.L_4_DAYS}</option>
				<option value="5" class="genmed" {expire_box.CHECK_5}>{expire_box.L_5_DAYS}</option>
				<option value="6" class="genmed" {expire_box.CHECK_6}>{expire_box.L_6_DAYS}</option>
				<option value="7" class="genmed" {expire_box.CHECK_7}>{expire_box.L_7_DAYS}</option>
				<option value="14" class="genmed" {expire_box.CHECK_14}>{expire_box.L_2_WEEKS}</option>
				<option value="30" class="genmed" {expire_box.CHECK_30}>{expire_box.L_1_MONTH}</option>
				<option value="90" class="genmed" {expire_box.CHECK_90}>{expire_box.L_3_MONTHS}</option>
			</select>
		</td>
	</tr>
	<!-- END expire_box -->
	<!-- BEGIN tree_width -->
	<tr>
		<td class="row1" valign="top"><span class="gen"><b>{tree_width.L_TREE_WIDTH}</b></span></td>
		<td class="row2"><input type="text" name="tree_width" value="{tree_width.TREE_WIDTH}" size="2" maxlength="2" class="post" onFocus="Active(this)" onBlur="NotActive(this)"></td>
	</tr>
	<!-- END tree_width -->

		<tr>
			<td class="row1" valign="top"><span class="gen"><b>{L_OPTIONS}</b></span><br><span class="gensmall">{HTML_STATUS}<br>{BBCODE_STATUS}<br>{SMILIES_STATUS}</span></td>
			<td class="row2">
				<table cellspacing="0" cellpadding="1" border="0">
				<!-- BEGIN switch_html_checkbox -->
				<tr>
					<td><input type="checkbox" name="disable_html" {S_HTML_CHECKED}></td>
					<td><span class="gen">{L_DISABLE_HTML}</span></td>
				</tr>
				<!-- END switch_html_checkbox -->
				<!-- BEGIN switch_bbcode_checkbox -->
				<tr>
					<td><input type="checkbox" name="disable_bbcode" {S_BBCODE_CHECKED}></td>
					<td><span class="gen">{L_DISABLE_BBCODE}</span></td>
				</tr>
				<!-- END switch_bbcode_checkbox -->
				<!-- BEGIN switch_smilies_checkbox -->
				<tr>
					<td><input type="checkbox" name="disable_smilies" {S_SMILIES_CHECKED}></td>
					<td><span class="gen">{L_DISABLE_SMILIES}</span></td>
				</tr>
				<!-- END switch_smilies_checkbox -->
				<!-- BEGIN switch_signature_checkbox -->
				<tr>
					<td><input type="checkbox" name="attach_sig" {S_SIGNATURE_CHECKED}></td>
					<td><span class="gen">{L_ATTACH_SIGNATURE}</span></td>
				</tr>
				<!-- END switch_signature_checkbox -->
				<!-- BEGIN switch_notify_checkbox -->
				<tr>
					<td><input type="checkbox" name="notify" {S_NOTIFY_CHECKED}></td>
					<td><span class="gen">{L_NOTIFY_ON_REPLY}</span></td>
				</tr>
				<!-- END switch_notify_checkbox -->
				<!-- BEGIN switch_delete_checkbox -->
				<tr>
					<td><input type="checkbox" name="delete"></td>
					<td><span class="gen">{L_DELETE_POST}</span></td>
				</tr>
				<!-- END switch_delete_checkbox -->
				<!-- BEGIN switch_lock_topic -->
				<tr>
					<td><input type="checkbox" name="lock" {S_LOCK_CHECKED}></td>
					<td><span class="gen">{L_LOCK_TOPIC}</span></td>
				</tr>
				<!-- END switch_lock_topic -->
				<!-- BEGIN switch_unlock_topic -->
				<tr>
					<td><input type="checkbox" name="unlock" {S_UNLOCK_CHECKED}></td>
					<td><span class="gen">{L_UNLOCK_TOPIC}</span></td>
				</tr>
				<!-- END switch_unlock_topic -->
				<!-- BEGIN switch_no_split_post -->
				<tr>
					<td><input type="checkbox" name="nosplit" {S_SPLIT_CHECKED}></td>
					<td><span class="gen">{L_NO_SPLIT_POST}</span></td>
				</tr>
				<!-- END switch_no_split_post -->
				<!-- BEGIN switch_type_toggle -->
				<tr>
					<td></td>
					<td><span class="gen">{S_TYPE_TOGGLE}</span></td>
				</tr>
				<!-- END switch_type_toggle -->
			</table>
		</td>
	</tr>
	{ATTACHBOX}
	{POLLBOX} 
	<tr>
		<td class="catBottom" colspan="2" align="center" height="28">{S_HIDDEN_FORM_FIELDS}<input type="submit" tabindex="5" name="preview" class="mainoption" value="{L_PREVIEW}">&nbsp;<input type="submit" accesskey="s" tabindex="6" name="post" class="mainoption" value="{L_SUBMIT}"></td>
	</tr>
</table>

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr>
		<td align="right" valign="top"><span class="gensmall">{S_TIMEZONE}</span></td>
	</tr>
</table>
</form>

<table width="100%" cellspacing="2" border="0" align="center">
<tr>
	<td valign="top" align="right">{JUMPBOX}</td>
</tr>
</table>

<script language="Javascript" type="text/javascript">
<!--
	change_size(document.forms.post.message);
//-->
</script>


{TOPIC_REVIEW_BOX}
