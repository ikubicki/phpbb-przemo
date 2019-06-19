<table width="100%" cellpadding="1" cellspacing="1" border="0">
	<tr> 
		<td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
	</tr>
</table>
<form action="{S_SEARCH_ACTION}" method="POST">
<table class="forumline" width="100%" cellpadding="4" cellspacing="1" border="0">
	<tr> 
		<th class="thHead" colspan="4" height="25">{L_SEARCH_QUERY}</th>
	</tr>
	<!-- BEGIN enable_search -->
	<tr> 
		<td class="row1" colspan="2" width="50%"><span class="gen">{L_SEARCH_KEYWORDS}:</span><br><span class="gensmall">{L_SEARCH_KEYWORDS_EXPLAIN}</span></td>
		<td class="row2" colspan="2" valign="top"><span class="genmed"><input type="text" style="width: 300px" class="post" id="focus" onFocus="Active(this)" onBlur="NotActive(this)" name="search_keywords" size="30"><br><input type="radio" name="search_terms" value="any" checked="checked"> {L_SEARCH_ANY_TERMS}<br><input type="radio" name="search_terms" value="all"> {L_SEARCH_ALL_TERMS}</span></td>
	</tr>
	<!-- END enable_search -->
	<tr> 
		<td class="row1" colspan="2"><span class="gen">{L_SEARCH_AUTHOR}:</span><br><span class="gensmall">{L_SEARCH_AUTHOR_EXPLAIN}<br>{U_SEARCH_USERS}</span></td>
		<td class="row2" colspan="2" valign="middle"><span class="genmed"><input type="text" style="width: 300px" class="post" onFocus="Active(this)" onBlur="NotActive(this)" name="search_author" size="30"></span></td>
	</tr>
	<tr> 
		<th class="thHead" colspan="4" height="25">{L_SEARCH_OPTIONS}</th>
	</tr>
	<tr> 
		<td class="row1" align="right"><span class="gen">{L_FORUM}:&nbsp;</span></td>
		<td class="row2"><span class="genmed"><select class="post" name="search_where" size="7">{S_FORUM_OPTIONS}</select></span></td>
		<td class="row1" align="right" nowrap="nowrap" valign="top"><span class="gen">{L_SEARCH_PREVIOUS}:&nbsp;</span></td>
		<td class="row2" valign="middle"><span class="genmed"><select class="post" name="search_time">{S_TIME_OPTIONS1}</select>
		<br><input type="radio" name="search_fields" value="all" checked="checked"> {L_SEARCH_MESSAGE_TITLE}<br>
		<input type="radio" name="search_fields" value="msgonly"> {L_SEARCH_MESSAGE_ONLY}<br>
		<input type="radio" name="search_fields" value="titleonly"> {L_SEARCH_TITLE_ONLY}<br>
		<input type="radio" name="search_fields" value="title_e_only"> {L_SEARCH_TITLE_E_ONLY}</span></td>
	</tr>
	<tr> 
		<td class="row1" align="right" nowrap="nowrap"><span class="gen">{L_DISPLAY_RESULTS}:&nbsp;</span></td>
		<td class="row2" nowrap="nowrap"><input type="radio" name="show_results" value="posts"><span class="genmed">{L_POSTS}<input type="radio" name="show_results" value="topics" checked="checked">{L_TOPICS}</span></td>
		<td class="row1" align="right" rowspan="2" valign="top"><span class="gen">{L_SORT_BY}:&nbsp;</span></td>
		<td class="row2" valign="middle" nowrap="nowrap" rowspan="2">
			<table cellpadding="2" cellspacing="2">
				<tr>
					<td>
						<select class="post" name="sort_by" size="4">{S_SORT_OPTIONS}</select>
					</td>
					<td>
						<span class="genmed"><input type="radio" name="sort_dir" value="ASC"> {L_SORT_ASCENDING}<br><input type="radio" name="sort_dir" value="DESC" checked="checked"> {L_SORT_DESCENDING}</span>&nbsp;
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="row1" align="right"><span class="gen">{L_RETURN_FIRST}</span></td>
		<td class="row2"><span class="genmed"><select class="post" name="return_chars">{S_CHARACTER_OPTIONS}</select> {L_CHARACTERS}</span></td>
	</tr>
	<tr> 
		<td class="catBottom" colspan="4" align="center" height="28">{S_HIDDEN_FIELDS}<input class="liteoption" type="submit" value="{L_SEARCH}"></td>
	</tr>
</table>
</form>
<br>
<form action="{S_SEARCH_ACTION_LAST}" method="POST">
<table class="forumline" width="100%" cellpadding="4" cellspacing="1" border="0">
	<tr> 
		<th class="thHead" colspan="4" height="25">{L_SEARCH_PREVIOUS}</th>
	</tr>

	<tr> 
		<td class="row1" colspan="2" width="50%"><span class="gen">{L_SEARCH_POST_TIME}</span></td>
		<td class="row2" colspan="2" valign="top"><span class="genmed"><select class="gensmall" name="search_time">{S_TIME_OPTIONS2}</select><br>
		{L_DISPLAY_RESULTS}:&nbsp;<input type="radio" name="show_results" value="posts">{L_POSTS}<input type="radio" name="show_results" value="topics" checked="checked">{L_TOPICS}</span></td>
	</tr>
	<tr> 
		<td class="catBottom" colspan="4" align="center" height="28"><input type="hidden" name="return_chars" value="-1"><input type="hidden" name="sort_by" value="0"><input type="hidden" name="sort_dir" value="DESC"><input class="liteoption" type="submit" value="{L_SEARCH}"></td>
	</tr>
</table>
</form>

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="right" valign="middle"><span class="gensmall">{S_TIMEZONE}</span></td>
	</tr>
</table>

<table width="100%" border="0">
	<tr>
		<td align="right" valign="top">{JUMPBOX}</td>
	</tr>
</table>
