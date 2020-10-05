<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="left" valign="middle" class="nav" width="100%"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
	</tr>
</table>
<form method="post" action="{FORM_ACTION}" name="ignoreform">
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<th align="center" colspan="3" class="thTop">{L_LIST_IGNORE}</th>
	</tr>
	<tr>
		<td align="center" colspan="3" class="row1"><span class="genmed">{L_LIST_IGNORE_E}</span></th>
	</tr>
	<tr>
		<td align="center" class="catBottom" nowrap="nowrap"><span class="nav">{L_DELETE}</span></td>
		<td align="center" class="catBottom" nowrap="nowrap"><span class="nav">{L_TOPICS}</span></td>
		<td align="center" class="catBottom" nowrap="nowrap"><span class="nav">{L_FORUM}</span></td>
	</tr>
	<script language="JavaScript" type="text/javascript">
	<!--
	function setCheckboxes(the_form, do_check)
	{ var elts = (typeof(document.forms[the_form].elements['list_ignore[]']) != 'undefined') ? document.forms[the_form].elements['list_ignore[]'] : document.forms[the_form].elements = ''; var elts_cnt  = (typeof(elts.length) != 'undefined') ? elts.length : 0; if (elts_cnt) { for (var i = 0; i < elts_cnt; i++) { if (do_check == "invert"){ elts[i].checked == true ? elts[i].checked = false : elts[i].checked = true; } else { elts[i].checked = do_check; }}} else { elts.checked = do_check; }
	return true; }
	//-->
	</script>
	<!-- BEGIN view -->
	<tr>
		<td align="center" width="1%" class="row2"><input type="checkbox" name="list_ignore[]" value="{view.TOPIC_ID}"></td>
		<td align="left" nowrap="nowrap" class="row1"<span class="topictitle"><a href="{view.U_VIEW_TOPIC}" class="topictitle">{view.TOPIC_TITLE}</a></span></td>
		<td align="left" nowrap="nowrap" class="row1"<span class="topictitle"><a href="{view.U_VIEW_FORUM}" class="topictitle">{view.FORUM_NAME}</a></span></td>
	</tr>
	<!-- END view -->
	<tr>
		<td colspan="2" class="catBottom" align="left"><span class="gensmall"><input type="submit" name="unignore_mark" class="liteoption" value="{L_DELETE_MARK}">&nbsp;<a href="#" onclick="setCheckboxes('ignoreform', true); return false;">{L_MARK_ALL}</a></span></td>
		<td class="catBottom" align="right"><span class="gensmall"><a href="{VIEW_IGNORE}">{L_LIST_IGNORE}</a></span></td>
	</tr>
</table>
</form>
<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr>
		<td align="left">{JUMPBOX}</td>
		<td align="right"><span class="nav">{PAGE_NUMBER} {PAGINATION}</span></td>
	</tr>
</table>
<br>
