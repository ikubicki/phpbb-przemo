{BOARD_INDEX}
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="left" valign="bottom" width="90"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}"></a>&nbsp;&nbsp;</td>
		<td align="left" valign="bottom"><span class="gensmall">{L_MODERATOR}: {MODERATORS}<br>{LOGGED_IN_USER_LIST}</span></td>
		<td align="right" valign="bottom" nowrap="nowrap"><span class="gensmall"><b>{PAGINATION}</b><a href="{U_MARK_READ}">{L_MARK_TOPICS_READ}</a>{U_SHOW_IGNORE}</span></td>
	</tr>
</table>

<!-- BEGIN ignore_form -->
<script language="JavaScript" type="text/javascript">
function setCheckboxes(the_form, do_check)
{
	var elts = (typeof(document.forms[the_form].elements['list_ignore[]']) != 'undefined') ? document.forms[the_form].elements['list_ignore[]'] : document.forms[the_form].elements = '';
	var elts_cnt = (typeof(elts.length) != 'undefined') ? elts.length : 0;
	if (elts_cnt)
	{
		for (var i = 0; i < elts_cnt; i++)
		{
			if (do_check == "invert")
			{
				elts[i].checked == true ? elts[i].checked = false : elts[i].checked = true;
			}
			else
			{
				elts[i].checked = do_check;
			}
		}
	}
	else
	{
		elts.checked = do_check;
	}
	return true; }
</script>
<form method="post" action="{ignore_form.U_IGNORE_TOPICS}" name="ignoreform">
<!-- END ignore_form -->
<!-- BEGIN switch_show_hide -->
<div id="imp_topics_{FORUM_ID}" style="display: ''; position: relative;">
<!-- END switch_show_hide -->
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<th colspan="{SPAN_I}" align="center" height="25" class="thCornerL" nowrap="nowrap"<!-- BEGIN switch_show_hide --> onclick="javascript:ShowHide('imp_topics_{FORUM_ID}','imp_topics2_{FORUM_ID}','imp_topics3_{FORUM_ID}');" style="cursor: pointer" title="{L_VHIDE}"<!-- END switch_show_hide -->>&nbsp;{L_TOPICS}&nbsp;</th>
		<th width="50" align="center" class="thTop" nowrap="nowrap">&nbsp;{L_REPLIES}&nbsp;</th>
		<th width="100" align="center" class="thTop" nowrap="nowrap">&nbsp;{L_AUTHOR}&nbsp;</th>
		<th width="50" align="center" class="thTop" nowrap="nowrap">&nbsp;{L_VIEWS}&nbsp;</th>
		<th width="150" align="center" class="thCornerR" nowrap="nowrap">&nbsp;{L_LASTPOST}&nbsp;</th>
	</tr>
	<!-- BEGIN important_topics -->
	<tr>
		<td class="catHead" colspan="{SPAN_J}"><span class="nav">&bull; {L_IMPORTANT_TOPICS}</span></td>
	</tr>
	<!-- END important_topics -->
	<!-- BEGIN topicrow -->
	<!-- BEGIN normal_topics_row -->
	<tr>
		<td class="catHead" colspan="{SPAN_J}"><span class="nav">&bull; {L_TOPICS}</span></td>
	</tr>
	<!-- END normal_topics_row -->
	<!-- BEGIN normal_topics -->
</table>
<br>
</div>
<div id="imp_topics2_{FORUM_ID}" style="display: none; position: relative;">
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<th align="center" height="25" class="thCornerL" nowrap="nowrap" onclick="javascript:ShowHide('imp_topics_{FORUM_ID}','imp_topics2_{FORUM_ID}','imp_topics3_{FORUM_ID}');" style="cursor: pointer">&nbsp;{L_TOPICS}&nbsp;</th>
	</tr>
</table>
<br>
</div>
<script language="javascript" type="text/javascript">
<!--
if(GetCookie('imp_topics3_{FORUM_ID}') == '2') ShowHide('imp_topics_{FORUM_ID}', 'imp_topics2_{FORUM_ID}', 'imp_topics3_{FORUM_ID}');
//-->
</script>

<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<th colspan="{SPAN_I}" align="center" class="thCornerL" style="height: 24px;" nowrap="nowrap">&nbsp;{L_NORMAL_TOPICS}&nbsp;</th>
		<th width="50" align="center" class="thTop" style="height: 24px;" nowrap="nowrap">&nbsp;{L_REPLIES}&nbsp;</th>
		<th width="100" align="center" class="thTop" style="height: 24px;" nowrap="nowrap">&nbsp;{L_AUTHOR}&nbsp;</th>
		<th width="50" align="center" class="thTop" style="height: 24px;" nowrap="nowrap">&nbsp;{L_VIEWS}&nbsp;</th>
		<th width="150" align="center" class="thCornerR" style="height: 24px;" nowrap="nowrap">&nbsp;{L_LASTPOST}&nbsp;</th>
	</tr>
	<!-- END normal_topics -->
	<tr>
		<td class="row1" align="center" valign="middle" width="20"><img src="{topicrow.TOPIC_FOLDER_IMG}" alt=""></td>
		<!-- BEGIN icons -->
		<td class="row1" align="center" valign="middle" width="16">{topicrow.ICON}</td>
		<!-- END icons -->
		<td class="{topicrow.ROW}" width="100%" {ONMOUSE_COLORS}><span class="topictitle">{topicrow.NEWEST_POST_IMG}{topicrow.TOPIC_ATTACHMENT_IMG}{topicrow.TOPIC_TYPE}
		<a href="{topicrow.U_VIEW_TOPIC}" class="topictitle"{topicrow.TOPIC_COLOR}
		<!-- BEGIN title_overlib -->
		 onMouseOver="return overlib('<left>{topicrow.title_overlib.UNREAD_POSTS}<fieldset><legend><b>{topicrow.title_overlib.L_FIRST_POST}</b></legend>{topicrow.title_overlib.O_TEXT1}</fieldset><!-- BEGIN last --><fieldset><legend><b>{topicrow.title_overlib.L_LAST_POST}</b></legend>{topicrow.title_overlib.last.O_TEXT2}</fieldset><!-- END last --></left>', ol_width=400, ol_offsetx=10, ol_offsety=10, CAPTION, '<center>{topicrow.title_overlib.O_TITLE}</center>')" onMouseOut="nd();"<!-- END title_overlib -->>{topicrow.TOPIC_TITLE}</a></span><span class="gensmall">{topicrow.TOPIC_TITLE_E}<!-- BEGIN style -->{topicrow.style.TOPIC_STYLE}<!-- END style --></span><span class="gensmall">{topicrow.TOPIC_EXPIRE}</span><span class="gensmall"><br>{topicrow.GOTO_PAGE}</span></td>
		<!-- BEGIN ignore_checkbox -->
		<td class="row1" align="right"><input type="checkbox" name="list_ignore[]" value="{topicrow.TOPIC_ID}"></td>
		<!-- END ignore_checkbox -->
		<td class="row2" {ONMOUSE2_COLORS}align="center" valign="middle"><span class="postdetails">{topicrow.REPLIES}</span></td>
		<td class="row1" {ONMOUSE_COLORS}align="center" valign="middle"><span class="name">{topicrow.TOPIC_AUTHOR}</span></td>
		<td class="row2" {ONMOUSE2_COLORS}align="center" valign="middle"><span class="postdetails">{topicrow.VIEWS}</span></td>
		<td class="row1" {ONMOUSE_COLORS}align="center" valign="middle" nowrap="nowrap"><span class="postdetails">{topicrow.LAST_POST_TIME}<br>{topicrow.LAST_POST_AUTHOR} {topicrow.LAST_POST_IMG}</span></td>
	</tr>
	<!-- END topicrow -->

	<!-- BEGIN switch_no_topics -->
	<tr>
		<td class="row1" colspan="{SPAN_J}" height="30" align="center" valign="middle"><span class="gen">{L_NO_TOPICS}</span></td>
	</tr>
	<!-- END switch_no_topics -->

	<!-- BEGIN ignore_form -->
	<tr>
		<td class="row1" colspan="{SPAN_J}" align="center" height="28"><span class="gensmall">
			<input type="submit" name="ignore" class="liteoption" value="{ignore_form.L_IGNORE_MARK}"<!-- BEGIN overlib --> onMouseOver="return overlib('<left>{ignore_form.overlib.L_IGNORE_EXPLAIN}</left>', ol_offsetx=-203, ol_offsety=8, CAPTION, '<center>{ignore_form.L_IGNORE_MARK}</center>')" onMouseOut="nd();"<!-- END overlib -->>
			&nbsp;<a href="#" onclick="setCheckboxes('ignoreform', true); return false;">{ignore_form.L_MARK_ALL}</a>
		</span></td>
	</tr>
	<!-- END ignore_form -->

</table>
<!-- BEGIN ignore_form -->
</form>
<!-- END ignore_form -->

<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<td class="catBottom" align="center" valign="middle" height="28"><form method="post" action="{S_POST_DAYS_ACTION}"><span class="genmed">{L_DISPLAY_TOPICS}:&nbsp;{S_SELECT_TOPIC_DAYS}&nbsp;<input type="submit" class="liteoption" value="{L_GO}" name="submit"/></span></form></td>
	</tr>
</table>

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr>
		<td align="right" colspan="2" valign="middle" nowrap="nowrap"><span class="nav">{PAGE_NUMBER}&nbsp;&nbsp;{PAGINATION}</span></td>
	</tr>
	<tr>
		<td align="left" valign="middle"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}"></a></td>
		<td align="right" nowrap="nowrap">&nbsp;
		<!-- BEGIN switch_search_for -->
		<form method="post" action="{SEARCH_ACTION}"><input type="hidden" name="search_where" value="f{FORUM_ID}"><input type="hidden" name="show_results" value="topics"><input type="hidden" name="search_terms" value="any"><input type="hidden" name="search_fields" value="all"><span class="gensmall">{L_SEARCH_FOR}:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br></span><input class="post" onFocus="Active(this)" onBlur="NotActive(this)" type="text" name="search_keywords" value="" size="20" maxlength="150">&nbsp;<input type="submit" name="submit" value="{L_GO}" class="liteoption"></form>
		<!-- END switch_search_for -->
		</td>
	</tr>
</table>

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr>
		<td align="right">{JUMPBOX}</td>
	</tr>
</table>

<table width="100%" cellspacing="0" border="0" cellpadding="0">
	<tr>
		<td valign="top">
			<table cellspacing="3" cellpadding="0" border="0">
				<tr>
					<td style="padding-right:4px"><img src="{FOLDER_NEW_IMG}" alt=""></td>
					<td class="gensmall">{L_NEW_POSTS}</td>
					<td>&nbsp;&nbsp;</td>
					<td style="padding-right:4px"><img src="{FOLDER_IMG}" alt=""></td>
					<td class="gensmall">{L_NO_NEW_POSTS}</td>
					<td>&nbsp;&nbsp;</td>
					<td style="padding-right:4px"><img src="{FOLDER_GLOBAL_ANNOUNCE_IMG}" alt=""></td>
					<td class="gensmall">{L_GLOBAL_ANNOUNCEMENT}</td>
				</tr>
				<tr>
					<td style="padding-right:4px"><img src="{FOLDER_HOT_NEW_IMG}" alt=""></td>
					<td class="gensmall">{L_NEW_POSTS_HOT}</td>
					<td>&nbsp;&nbsp;</td>
					<td style="padding-right:4px"><img src="{FOLDER_HOT_IMG}" alt=""></td>
					<td class="gensmall">{L_NO_NEW_POSTS_HOT}</td>
					<td>&nbsp;&nbsp;</td>
					<td style="padding-right:4px"><img src="{FOLDER_ANNOUNCE_IMG}" alt=""></td>
					<td class="gensmall">{L_ANNOUNCEMENT}</td>
				</tr>
				<tr>
					<td class="gensmall"><img src="{FOLDER_LOCKED_NEW_IMG}" alt=""></td>
					<td class="gensmall">{L_NEW_POSTS_LOCKED}</td>
					<td>&nbsp;&nbsp;</td>
					<td style="padding-right:4px"><img src="{FOLDER_LOCKED_IMG}" alt=""></td>
					<td class="gensmall">{L_NO_NEW_POSTS_LOCKED}</td>
					<td>&nbsp;&nbsp;</td>
					<td style="padding-right:4px"><img src="{FOLDER_STICKY_IMG}" alt=""></td>
					<td class="gensmall">{L_STICKY}</td>
				</tr>
			</table>
		</td>
		<td align="right" nowrap="nowrap"><span class="gensmall">{S_AUTH_LIST}</span></td>
	</tr>
</table>
