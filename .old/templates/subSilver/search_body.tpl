
<form action="{S_SEARCH_ACTION}" method="POST">
<table class="forumline posting">
	<tr> 
		<th colspan="5">
			{L_SEARCH_QUERY}
			<span class="gensmall description">{L_SEARCH_KEYWORDS_EXPLAIN}</span>
		</th>
	</tr>
	<!-- BEGIN enable_search -->
	<tr> 
		<td class="row1" colspan="2" width="50%">
			<span class="gen">{L_SEARCH_KEYWORDS}:</span><br />
		</td>
		<td class="row1" colspan="3" valign="top">
			<input type="text" id="focus" name="search_keywords" size="30" /><br />
			<label><input type="radio" name="search_terms" value="any" checked="checked"> {L_SEARCH_ANY_TERMS}</label><br />
			<label><input type="radio" name="search_terms" value="all"> {L_SEARCH_ALL_TERMS}</label>
		</td>
	</tr>
	<!-- END enable_search -->
	<tr> 
		<td class="row1" colspan="2">
			<span class="gen">{L_SEARCH_AUTHOR}:</span><br />
		</td>
		<td class="row1" colspan="3" valign="middle">
			<input type="text" name="search_author" size="30" />
			<span class="gensmall">{U_SEARCH_USERS}</span>
		</td>
	</tr>
	<tr> 
		<td width="10%" class="submit">&nbsp;</td>
		<td width="30%" class="submit">&nbsp;</td>
		<td width="10%" class="submit">&nbsp;</td>
		<td width="20%" class="submit">&nbsp;</td>
		<td width="30%" class="submit">&nbsp;</td>
	</tr>
	<tr> 
		<th colspan="5">{L_SEARCH_OPTIONS}</th>
	</tr>
	<tr> 
		<td class="row1">
			<span class="gen">{L_FORUM}</span>
		</td>
		<td class="row1">
			<select name="search_where" size="7">{S_FORUM_OPTIONS}</select>
		</td>

		<td class="row1" valign="middle">
			<span class="gen">{L_SEARCH_PREVIOUS}:</span>
		</td>
		<td class="row1" valign="middle">
			<select name="search_time">{S_TIME_OPTIONS1}</select>
		</td>
		<td class="row1" valign="middle">
			<label><input type="radio" name="search_fields" value="all" checked="checked"> {L_SEARCH_MESSAGE_TITLE}</label><br />
			<label><input type="radio" name="search_fields" value="msgonly"> {L_SEARCH_MESSAGE_ONLY}</label><br />
			<label><input type="radio" name="search_fields" value="titleonly"> {L_SEARCH_TITLE_ONLY}</label><br />
			<label><input type="radio" name="search_fields" value="title_e_only"> {L_SEARCH_TITLE_E_ONLY}</label>
		</td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_DISPLAY_RESULTS}:&nbsp;</span></td>
		<td class="row1"><input type="radio" name="show_results" value="posts"><span class="genmed">{L_POSTS}<input type="radio" name="show_results" value="topics" checked="checked">{L_TOPICS}</span></td>
		<td class="row1" valign="middle" rowspan="2" valign="top"><span class="gen">{L_SORT_BY}:&nbsp;</span></td>
		<td class="row1" valign="middle" rowspan="2">
			<select name="sort_by" size="4">{S_SORT_OPTIONS}</select>
		</td>
		<td class="row1" valign="middle" rowspan="2">
			<label><input type="radio" name="sort_dir" value="ASC"> {L_SORT_ASCENDING}</label><br />
			<label><input type="radio" name="sort_dir" value="DESC" checked="checked"> {L_SORT_DESCENDING}</label>
		</td>
	</tr>
	<tr>
		<td class="row1">
			<span class="gen">{L_RETURN_FIRST}</span>
		</td>
		<td class="row1">
			<select name="return_chars">{S_CHARACTER_OPTIONS}</select>
			{L_CHARACTERS}
		</td>
	</tr>
	<tr> 
		<td class="submit" colspan="5">
			{S_HIDDEN_FIELDS}
			<input type="submit" value="{L_SEARCH}">
		</td>
	</tr>
</table>
</form>
<br>
<form action="{S_SEARCH_ACTION_LAST}" method="POST">
<table class="forumline posting">
	<tr> 
		<th colspan="5">
			{L_SEARCH_PREVIOUS}
			<span class="gensmall description">{L_SEARCH_POST_TIME_E}</span>
		</th>
	</tr>
	<tr> 
		<td class="row1" width="10%" valign="middle">
			<span class="gen">{L_SEARCH_POST_TIME}</span>
		</td>
		<td class="row1" width="30%" valign="middle">
			<select name="search_time">{S_TIME_OPTIONS2}</select>
		</td>
		<td class="row1" width="10%" valign="middle">
			<span class="gen">{L_DISPLAY_RESULTS}</span>
		</td>
		<td class="row1" width="20%" valign="middle">
			<label><input type="radio" name="show_results" value="posts">{L_POSTS}</label><br />
			<label><input type="radio" name="show_results" value="topics" checked="checked">{L_TOPICS}</label>
		</td>
		<td class="row1" width="30%" valign="middle">
			&nbsp;
		</td>
	</tr>
	<tr>
		<td class="submit" colspan="5">
			<input type="hidden" name="return_chars" value="-1" />
			<input type="hidden" name="sort_by" value="0" />
			<input type="hidden" name="sort_dir" value="DESC" />
			<input type="submit" value="{L_SEARCH}" />
		</td>
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
