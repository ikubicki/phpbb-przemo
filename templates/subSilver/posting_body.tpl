<script language="Javascript" type="text/javascript">
<!--
var b_help = '{L_BBCODE_B_HELP}';var i_help = '{L_BBCODE_I_HELP}';
var u_help = '{L_BBCODE_U_HELP}';var q_help = '{L_BBCODE_Q_HELP}';var c_help = '{L_BBCODE_C_HELP}';
var l_help = '{L_BBCODE_L_HELP}';var o_help = '{L_BBCODE_O_HELP}';var p_help = '{L_BBCODE_P_HELP}';
var w_help = '{L_BBCODE_W_HELP}';var a_help = '{L_BBCODE_A_HELP}';var s_help = '{L_BBCODE_S_HELP}';
var f_help = '{L_BBCODE_F_HELP}';var st_help = '{L_BBCODE_ST_HELP}';var e_help = '{L_BBCODE_E_HELP}';
var k_help = '{L_BBCODE_K_HELP}';var y_help = '{L_BBCODE_Y_HELP}';var s2_help = '{L_BBCODE_S2_HELP}';
var g_help = '{L_BBCODE_G_HELP}';var h_help = '{L_BBCODE_H_HELP}'; var ct_help = '{L_BBCODE_CT_HELP}';
var img_addr = '{IMG_ADDR}';var link_text_prompt = '{L_WRITE_LINK_TEXT}';var link_url_prompt = '{L_WRITE_ADDRESS}';
var new_size2 = 0;
//-->
</script>
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

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="left"><span	class="nav" style="color: #FF6600;"><a href="{U_INDEX}" class="nav">{L_INDEX}</a>
		<!-- BEGIN switch_not_privmsg -->
		{NAV_CAT_DESC}
		<!-- END switch_not_privmsg -->
		</span></td>
	</tr>
</table>

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
	<td class="row2" width="78%"><span class="gen"><input type="text" name="subject" size="45" maxlength="60" style="width:550px" tabindex="2" class="post" onFocus="Active(this)" onBlur="NotActive(this)" value="{SUBJECT}"></span></td>
	</tr>
	<!-- BEGIN topic_explain -->
	<tr>
		<td class="row1" width="22%"><span class="gen"><b>{L_SUBJECT_E}</b></span> <span class="gensmall">({L_SUBJECT_E_INFO})</span></td>
		<td class="row2" width="78%"><span class="gen"><input type="text" name="subject_e" size="45" maxlength="100" style="width:550px;height:17px;font-size:9px;" tabindex="2" class="post" onFocus="Active(this)" onBlur="NotActive(this)" value="{SUBJECT_E}"></span></td>
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
		<table width="100%" border="0" cellspacing="0" cellpadding="1">
			<tr>
				<td><span class="gen"><b>{L_MESSAGE_BODY}</b></span></td>
			</tr>
			{CSMILES_OFF1}
			<tr>
				<td valign="middle" align="center"><br>
					<table width="100" border="0" cellspacing="0" cellpadding="5">
						<tr align="center">
							<td colspan="{S_SMILIES_COLSPAN}" class="gensmall"><b>{L_EMOTICONS}</b></td>
						</tr>
						<!-- BEGIN smilies_row -->
						<tr align="center" valign="middle">
							<!-- BEGIN smilies_col -->
							<td><img src="{smilies_row.smilies_col.SMILEY_IMG}" border="0" onmouseover="this.style.cursor='hand';" onclick="emoticon('{smilies_row.smilies_col.SMILEY_CODE}');" alt=""></td>
							<!-- END smilies_col -->
						</tr>
					<!-- END smilies_row -->
					<!-- BEGIN switch_smilies_extra -->
					<tr align="center">
						<td colspan="{S_SMILIES_COLSPAN}"><span class="nav"><a href="{U_MORE_SMILIES}" onclick="window.open('{U_MORE_SMILIES}', '_phpbbsmilies', 'HEIGHT=300,resizable=yes,scrollbars=yes,WIDTH=450');return false;" target="_phpbbsmilies" class="nav">{L_MORE_SMILIES}</a></span></td>
					</tr>
					<!-- END switch_smilies_extra -->
				</table>
				</td>
			</tr>
			{CSMILES_OFF2}

			<tr>
				<td align="center">
					<table align="center">
						<tr align="center" valign="middle">
							<!-- BEGIN symbols -->
							{symbols.TR_SYMBOL_BEGIN}
							<td>
								<a href="javascript:emoticon('{symbols.SYMBOL}')" class="genmed"><b>{symbols.SYMBOL}</b></a>
							</td>
							{symbols.TR_SYMBOL_END}
							<!-- END symbols -->
						</tr>
					</table>
				</td>
			</tr>

		</table>
	</td>
	<td class="row2" valign="top">
		<table width="550" border="0" cellspacing="0" cellpadding="2">
			{CBBCODE_OFF1}
			<tr align="left" valign="middle">
				<td><span class="genmed">{BUTTON_B}{BUTTON_I}{BUTTON_U}{BUTTON_Q}{BUTTON_C}{BUTTON_L}
					{BUTTON_IM}
					<!-- BEGIN button_ur -->
					<input type="button" class="button" accesskey="w" name="addbbcode18" value="URL" style="text-decoration: underline; width: 40px" onclick="namedlink(this.form,'URL')" onMouseOver="helpline('w')">
					<!-- END button_ur -->
					{BUTTON_CE}{BUTTON_F}{BUTTON_S}{BUTTON_ST}{BUTTON_HI}</span></td>
			</tr>
			<tr>
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td>
							<table border="0" style="width:550px">
							<tr>
							<td>
							<!-- BEGIN color_box -->
							{L_FONT_COLOR}:
							<!-- END color_box -->
							 </td>
							 <td>
 							<!-- BEGIN color_box -->
							 <select class="post" name="addbbcode30" onChange="bbfontstyle('[color=' + this.form.addbbcode30.options[this.form.addbbcode30.selectedIndex].value + ']', '[/color]'); this.form.addbbcode30.value='444444';" onMouseOver="helpline('s')">
								<option style="{FONTCOLOR_1};" value="{FONTCOLOR_1}" class="genmed">{L_COLOR_DEFAULT}</option>
								<option style="color:darkred;" value="darkred" class="genmed">{L_COLOR_DARK_RED}</option>
								<option style="color:red;" value="red" class="genmed">{L_COLOR_RED}</option>
								<option style="color:orange;" value="orange" class="genmed">{L_COLOR_ORANGE}</option>
								<option style="color:brown;" value="brown" class="genmed">{L_COLOR_BROWN}</option>
								<option style="color:yellow;" value="yellow" class="genmed">{L_COLOR_YELLOW}</option>
								<option style="color:green;" value="green" class="genmed">{L_COLOR_GREEN}</option>
								<option style="color:olive;" value="olive" class="genmed">{L_COLOR_OLIVE}</option>
								<option style="color:cyan;" value="cyan" class="genmed">{L_COLOR_CYAN}</option>
								<option style="color:blue;" value="blue" class="genmed">{L_COLOR_BLUE}</option>
								<option style="color:darkblue;" value="darkblue" class="genmed">{L_COLOR_DARK_BLUE}</option>
								<option style="color:indigo;" value="indigo" class="genmed">{L_COLOR_INDIGO}</option>
								<option style="color:violet;" value="violet" class="genmed">{L_COLOR_VIOLET}</option>
								<option style="color:white;" value="white" class="genmed">{L_COLOR_WHITE}</option>
								<option style="color:black;" value="black" class="genmed">{L_COLOR_BLACK}</option>
							</select>
							<!-- END color_box -->
							</td>
							<td align="right">&nbsp;
							<!-- BEGIN glow_box -->
							 <span style="filter: shadow(color=red); height:20">{glow_box.L_SHADOW_COLOR}:</span> 
							<!-- END glow_box -->
							</td>
							<td>
							<!-- BEGIN glow_box -->
							 <select name="addbbcode34" onChange="bbfontstyle('[shadow=' + this.form.addbbcode34.options[this.form.addbbcode34.selectedIndex].value + ']', '[/shadow]'); this.form.addbbcode34.value='444444';" onMouseOver="helpline('s2')">
								<option style="{FONTCOLOR_1};" value="{FONTCOLOR_1}" class="genmed">{L_COLOR_DEFAULT}</option>
								<option style="color:darkred;" value="darkred" class="genmed">{L_COLOR_DARK_RED}</option>
								<option style="color:red;" value="red" class="genmed">{L_COLOR_RED}</option>
								<option style="color:orange;" value="orange" class="genmed">{L_COLOR_ORANGE}</option>
								<option style="color:brown;" value="brown" class="genmed">{L_COLOR_BROWN}</option>
								<option style="color:yellow;" value="yellow" class="genmed">{L_COLOR_YELLOW}</option>
								<option style="color:green;" value="green" class="genmed">{L_COLOR_GREEN}</option>
								<option style="color:olive;" value="olive" class="genmed">{L_COLOR_OLIVE}</option>
								<option style="color:cyan;" value="cyan" class="genmed">{L_COLOR_CYAN}</option>
								<option style="color:blue;" value="blue" class="genmed">{L_COLOR_BLUE}</option>
								<option style="color:darkblue;" value="darkblue" class="genmed">{L_COLOR_DARK_BLUE}</option>
								<option style="color:indigo;" value="indigo" class="genmed">{L_COLOR_INDIGO}</option>
								<option style="color:violet;" value="violet" class="genmed">{L_COLOR_VIOLET}</option>
								<option style="color:white;" value="white" class="genmed">{L_COLOR_WHITE}</option>
								<option style="color:black;" value="black" class="genmed">{L_COLOR_BLACK}</option>
							</select> 
							<!-- END glow_box -->
							</td>
							<td align="right">&nbsp;
							<!-- BEGIN glow_box -->
							<span style="filter: glow(color=blue); height:20">{glow_box.L_GLOW_COLOR}:</span>
							<!-- END glow_box -->
							</td>
							<td align="right">
							<!-- BEGIN glow_box -->
							<select name="addbbcode29" onChange="bbfontstyle('[glow=' + this.form.addbbcode29.options[this.form.addbbcode29.selectedIndex].value + ']', '[/glow]'); this.form.addbbcode29.value='444444';" onMouseOver="helpline('g')">
								<option style="{FONTCOLOR_1};" value="{FONTCOLOR_1}" class="genmed">{L_COLOR_DEFAULT}</option>
								<option style="color:darkred;" value="darkred" class="genmed">{L_COLOR_DARK_RED}</option>
								<option style="color:red;" value="red" class="genmed">{L_COLOR_RED}</option>
								<option style="color:orange;" value="orange" class="genmed">{L_COLOR_ORANGE}</option>
								<option style="color:brown;" value="brown" class="genmed">{L_COLOR_BROWN}</option>
								<option style="color:yellow;" value="yellow" class="genmed">{L_COLOR_YELLOW}</option>
								<option style="color:green;" value="green" class="genmed">{L_COLOR_GREEN}</option>
								<option style="color:olive;" value="olive" class="genmed">{L_COLOR_OLIVE}</option>
								<option style="color:cyan;" value="cyan" class="genmed">{L_COLOR_CYAN}</option>
								<option style="color:blue;" value="blue" class="genmed">{L_COLOR_BLUE}</option>
								<option style="color:darkblue;" value="darkblue" class="genmed">{L_COLOR_DARK_BLUE}</option>
								<option style="color:indigo;" value="indigo" class="genmed">{L_COLOR_INDIGO}</option>
								<option style="color:violet;" value="violet" class="genmed">{L_COLOR_VIOLET}</option>
								<option style="color:white;" value="white" class="genmed">{L_COLOR_WHITE}</option>
								<option style="color:black;" value="black" class="genmed">{L_COLOR_BLACK}</option>
							</select>
							<!-- END glow_box -->
							</td>
							</tr>
							<tr>
							<td>
							<!-- BEGIN size_box -->
							{size_box.L_FONT_SIZE}:
							<!-- END size_box -->
							</td>
							<td>
							<!-- BEGIN size_box -->
							<select name="addbbcode32" onChange="bbfontstyle('[size=' + this.form.addbbcode32.options[this.form.addbbcode32.selectedIndex].value + ']', '[/size]'); this.form.addbbcode32.value='12';" onMouseOver="helpline('f')">
								<option value="7" class="genmed">{size_box.L_FONT_TINY}</option>
								<option value="9" class="genmed">{size_box.L_FONT_SMALL}</option>
								<option value="12" selected class="genmed">{size_box.L_FONT_NORMAL}</option>
								<option value="18" class="genmed">{size_box.L_FONT_LARGE}</option>
								<option value="24" class="genmed">{size_box.L_FONT_HUGE}</option>
							</select>
							<!-- END size_box -->
							</td>
							<td colspan="4" align="right">
							<!-- BEGIN topic_color -->
							&nbsp;{topic_color.L_TOPIC_COLOR}: 
							<select class="post" name="topic_color" onMouseOver="helpline('ct')">
								<option style="{FONTCOLOR_1};" value="" class="genmed"{topic_color.TCOL_EMPTY}>{L_COLOR_DEFAULT}</option>
								<option style="color:darkred;" value="darkred" class="genmed"{topic_color.TCOL_DARKRED}>{L_COLOR_DARK_RED}</option>
								<option style="color:red;" value="red" class="genmed"{topic_color.TCOL_RED}>{L_COLOR_RED}</option>
								<option style="color:orange;" value="orange" class="genmed"{topic_color.TCOL_ORANGE}>{L_COLOR_ORANGE}</option>
								<option style="color:brown;" value="brown" class="genmed"{topic_color.TCOL_BROWN}>{L_COLOR_BROWN}</option>
								<option style="color:yellow;" value="yellow" class="genmed"{topic_color.TCOL_YELLOW}>{L_COLOR_YELLOW}</option>
								<option style="color:green;" value="green" class="genmed"{topic_color.TCOL_GREEN}>{L_COLOR_GREEN}</option>
								<option style="color:olive;" value="olive" class="genmed"{topic_color.TCOL_OLIVE}>{L_COLOR_OLIVE}</option>
								<option style="color:cyan;" value="cyan" class="genmed"{topic_color.TCOL_CYAN}>{L_COLOR_CYAN}</option>
								<option style="color:blue;" value="blue" class="genmed"{topic_color.TCOL_BLUE}>{L_COLOR_BLUE}</option>
								<option style="color:darkblue;" value="darkblue" class="genmed"{topic_color.TCOL_DARKBLUE}>{L_COLOR_DARK_BLUE}</option>
								<option style="color:indigo;" value="indigo" class="genmed"{topic_color.TCOL_INDIGO}>{L_COLOR_INDIGO}</option>
								<option style="color:violet;" value="violet" class="genmed"{topic_color.TCOL_VIOLET}>{L_COLOR_VIOLET}</option>
								<option style="color:white;" value="white" class="genmed"{topic_color.TCOL_WHITE}>{L_COLOR_WHITE}</option>
								<option style="color:black;" value="black" class="genmed"{topic_color.TCOL_BLACK}>{L_COLOR_BLACK}</option>
							</select>
							<!-- END topic_color -->
							</td>
							</tr>
							</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			{CBBCODE_OFF2}
			<tr>
					<td>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><span class="genmed">
									{GLOW_BOX}
									</span>
									</td>
							</tr>
						</table>
					</td>
			</tr>
			{CBBCODE_OFF1}
			<tr>
				<td nowrap="nowrap">{CLOSE_ALL}<span class="gensmall"><input type="text" name="helpbox" size="45" maxlength="100" style="width:420px; font-size:10px" class="helpline" value="{L_STYLES_TIP}"></span>
				<input type="button" class="button" style="width: 18px; height: 18px; text-indent: -2px;" value="-" onClick="change_size(document.forms.post.message, -1);"> <input type="button" style="width: 18px; height: 18px; text-indent : 0px;" class="button" value="+" onClick="change_size(document.forms.post.message, 1);"></td>
			</tr>
			{CBBCODE_OFF2}
			<tr>
				<td><span class="gen"><textarea name="message" id="message" rows="15" cols="35" style="width:550px" tabindex="3" class="post" onFocus="Active(this)" onBlur="NotActive(this)" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);">{MESSAGE}</textarea></span></td>
			</tr>
		</table>
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
	<!-- BEGIN freak -->
	<tr>
		<td class="row1" valign="top">
		<span class="gen"><b>Freak & Letter styles</b></span>
		<br>
		<span class="gensmall">{freak.L_FREAK_UNDO}</span>
		</td>
		<td class="row2">
			<input type="button" class="button" name="freak" value="FrEaK" onClick="filter_freak()">
			&nbsp;<input type="button" class="button" name="freak" value="l33t" onClick="filter_l33t()">
		</td>
		</tr>
		<!-- END freak -->
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
