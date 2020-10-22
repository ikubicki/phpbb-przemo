<h1>{L_SEARCH_MATCHES}</h1>

<!-- BEGIN ignore_topics -->
<script language="JavaScript" type="text/javascript">
<!--
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
	return true;
}
//-->
</script>
<form method="post" action="{ignore_topics.U_IGNORE_TOPICS}" name="ignoreform">
<!-- END ignore_topics -->

<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline" align="center">
  <tr> 
	<th width="4%" class="label"></th>
	<th class="label">{L_FORUM}</th>
	<th colspan="{COLSPAN}" class="label">{L_TOPICS}</th>
	<th class="label center">{L_AUTHOR}</th>
	<th class="label center">{L_REPLIES}</th>
	<th class="label center">{L_VIEWS}</th>
	<th class="label center">{L_LASTPOST}</th>
  </tr>
  <!-- BEGIN searchresults -->
  <tr> 
	<td class="row1" align="center" valign="middle"><img src="{searchresults.TOPIC_FOLDER_IMG}" alt="{searchresults.L_TOPIC_FOLDER_ALT}" title="{searchresults.L_TOPIC_FOLDER_ALT}"></td>
	<td class="row1"><span class="forumlink"><a href="{searchresults.U_VIEW_FORUM}" class="forumlink"{searchresults.FORUM_COLOR}>{searchresults.FORUM_NAME}</a></span></td>
	<td class="row1"><span class="topictitle">{searchresults.NEWEST_POST_IMG}{searchresults.TOPIC_TYPE}<a href="{searchresults.U_VIEW_TOPIC}" class="topictitle"{searchresults.TOPIC_COLOR}
	<!-- BEGIN title_overlib -->
	 onMouseOver="return overlib('<left>{searchresults.title_overlib.UNREAD_POSTS}<fieldset><legend><b>{searchresults.title_overlib.L_FIRST_POST}</b></legend>{searchresults.title_overlib.O_TEXT1}</fieldset><!-- BEGIN last --><fieldset><legend><b>{searchresults.title_overlib.L_LAST_POST}</b></legend>{searchresults.title_overlib.last.O_TEXT2}</fieldset><!-- END last --></left>', ol_width=400, ol_offsetx=10, ol_offsety=10, CAPTION, '<center>{searchresults.title_overlib.O_TITLE}</center>')" onMouseOut="nd();"
	<!-- END title_overlib -->
	{searchresults.TOPIC_COLOR}>{searchresults.TOPIC_TITLE}</a></span><span class="gensmall">{searchresults.TOPIC_TITLE_E}</span><br /><span class="gensmall">{searchresults.GOTO_PAGE}</span></td>
	<!-- BEGIN it -->
	<td class="row1" align="center" width="1%"><input type="checkbox" name="list_ignore[]" value="{searchresults.it.TOPIC_ID}"></td>
	<!-- END it -->
	<td class="row1" align="center" valign="middle">{searchresults.TOPIC_AUTHOR}</td>
	<td class="row1" align="center" valign="middle">{searchresults.REPLIES}</td>
	<td class="row1" align="center" valign="middle">{searchresults.VIEWS}</td>
	<td class="row1" align="center" valign="middle" nowrap="nowrap">{searchresults.LAST_POST_TIME}<br />{searchresults.LAST_POST_AUTHOR} {searchresults.LAST_POST_IMG}</td>
  </tr>
  <!-- END searchresults -->
  <tr> 
	<td class="submit left" colspan="2">
		<a href="{U_MARK_READ}">{L_MARK_FORUMS_READ}</a>
	</td>
	<td colspan="{COLSPAN}" class="submit right">
<!-- BEGIN ignore_topics -->
		<input type="submit" name="ignore" class="liteoption" value="{ignore_topics.L_IGNORE_MARK}" />
		<a href="javascript:void(0);" onclick="setCheckboxes('ignoreform', true); return false;">{ignore_topics.L_MARK_ALL}</a>
<!-- END ignore_topics -->
	</td>
	<td class="submit" colspan="4">
		<span class="nav">{PAGINATION}</span>
	</td>
  </tr>
</table>