 
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
  <tr> 
	<td align="left" valign="bottom"><span class="maintitle">{L_SEARCH_MATCHES}</span><br></td>
  </tr>
</table>

<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline" align="center">
  <tr> 
	<th width="150" height="25" nowrap="nowrap">{L_AUTHOR}</th>
	<th width="100%" nowrap="nowrap">{L_MESSAGE}</th>
  </tr>
  <!-- BEGIN searchresults -->
  <tr> 
	<td colspan="2" height="28"><span class="topictitle"><img src="{FOLDER_IMG}" alt="" align="middle">&nbsp; {L_TOPIC}:&nbsp;<a href="{searchresults.U_TOPIC}" class="topictitle"{searchresults.TOPIC_COLOR}>{searchresults.TOPIC_TITLE}</a></span></td>
  </tr>
  <tr> 
	<td width="150" align="left" valign="top" class="row1" rowspan="2"><span class="name"><b>{searchresults.POSTER_NAME}</b></span><br>
	  <br>
	  <span class="postdetails">{L_REPLIES}: <b>{searchresults.TOPIC_REPLIES}</b><br>
	  {L_VIEWS}: <b>{searchresults.TOPIC_VIEWS}</b></span><br>
	</td>
	<td width="100%" valign="top" class="row1"><img src="{searchresults.MINI_POST_IMG}" alt="{searchresults.L_MINI_POST_ALT}" title="{searchresults.L_MINI_POST_ALT}" border="0"><span class="postdetails">{L_FORUM}:&nbsp;<b><a href="{searchresults.U_FORUM}" class="gensmall"{searchresults.FORUM_COLOR}>{searchresults.FORUM_NAME}</a></b>&nbsp; &nbsp;{L_POSTED}: {searchresults.POST_DATE}&nbsp; &nbsp;{L_SUBJECT}: <b><a href="{searchresults.U_POST}">{searchresults.POST_SUBJECT}</a></b></span></td>
  </tr>
  <tr>
	<td valign="top" class="{searchresults.ROW}"><span class="postbody">{searchresults.MESSAGE}</span></td>
  </tr>
  <!-- END searchresults -->
  <tr> 
	<td class="submit" colspan="2" height="28" align="center">&nbsp; </td>
  </tr>
</table>

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
  <tr> 
	<td align="left" valign="top"><span class="nav">{PAGE_NUMBER}</span></td>
	<td align="right" valign="top" nowrap="nowrap"><span class="nav">{PAGINATION}</span></td>
  </tr>
</table>

<table width="100%" cellspacing="2" border="0" align="center">
  <tr> 
	<td valign="top" align="right">{JUMPBOX}</td>
  </tr>
</table>
