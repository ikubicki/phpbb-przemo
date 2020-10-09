
<h1>{L_FORUM_TITLE}</h1>

<p>{L_FORUM_EXPLAIN}</p>
<form method="post" action="{S_FORUM_ACTION}">

<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
<tr>
	<th class="thLeft" colspan="{INC_SPAN}" width="75%">{L_FORUM_TITLE}</th>
	<th class="thRight" colspan="4" width="25%">{L_ACTION}</th>
</tr>
<!-- BEGIN catrow -->
<!-- BEGIN cathead -->
<tr>
	<!-- BEGIN inc -->
	<td class="row2" rowspan="{catrow.cathead.inc.ROWSPAN}" width="46"><img src="{SPACER}" width="46" height="0"></td>
	<!-- END inc -->
	<td class="{catrow.cathead.CLASS_CATLEFT}"   colspan="{catrow.cathead.INC_SPAN}" {catrow.cathead.WIDTH}><span class="cattitle"><b><a href="{catrow.cathead.U_VIEWCAT}" class="cattitle">{catrow.cathead.CAT_TITLE}</a></b></span></td>
	<td class="{catrow.cathead.CLASS_CATMIDDLE}" align="center" valign="middle"><span class="gen"><a href="{catrow.cathead.U_CAT_EDIT}" class="gen">{L_EDIT}</a></span></td>
	<td class="{catrow.cathead.CLASS_CATMIDDLE}" align="center" valign="middle"><span class="gen"><a href="{catrow.cathead.U_CAT_DELETE}" class="gen">{L_DELETE}</a></span></td>
	<td class="{catrow.cathead.CLASS_CATMIDDLE}" align="center" valign="middle" nowrap="nowrap"><span class="gen"><a href="{catrow.cathead.U_CAT_MOVE_UP}" class="gen">{L_MOVE_UP}</a> <a href="{catrow.cathead.U_CAT_MOVE_DOWN}" class="gen">{L_MOVE_DOWN}</a></span></td>
	<td class="{catrow.cathead.CLASS_CATRIGHT}"  align="center" valign="middle"><span class="gen">&nbsp;</span></td>
</tr>
<!-- END cathead -->
<!-- BEGIN cattitle -->
<tr>
	<td class="row3" colspan="{catrow.cattitle.INC_SPAN_ALL}"><span class="gensmall">{catrow.cattitle.CAT_DESCRIPTION}</span></td>
</tr>
<!-- END cattitle -->
<!-- BEGIN forumrow -->
<tr> 
	<!-- BEGIN inc -->
	<td class="row2" width="46"><img src="{SPACER}" width="46" height="0"></td>
	<!-- END inc -->
	<td class="row2" colspan="{catrow.forumrow.INC_SPAN}" {catrow.forumrow.WIDTH}><table cellpadding="0" cellspacing="0" width="100%"><tr><td>{catrow.forumrow.LINK_IMG}</td><td width="100%"><span class="gen"><a href="{catrow.forumrow.U_VIEWFORUM}"{catrow.forumrow.FORUM_COLOR}>{catrow.forumrow.FORUM_NAME}</a></span><br><span class="gensmall">{catrow.forumrow.FORUM_DESC}</span></td></tr></table></td>
	<td class="row1" align="center" valign="middle"><span class="gen">{catrow.forumrow.NUM_TOPICS}</span></td>
	<td class="row2" align="center" valign="middle"><span class="gen">{catrow.forumrow.NUM_POSTS}</span></td>
	<td class="row1" align="center" valign="middle"><span class="gen"><a href="{catrow.forumrow.U_FORUM_EDIT}">{L_EDIT}</a></span></td>
	<td class="row2" align="center" valign="middle"><span class="gen"><a href="{catrow.forumrow.U_FORUM_DELETE}">{L_DELETE}</a></span></td>
	<td class="row1" align="center" valign="middle"><span class="gen"><a href="{catrow.forumrow.U_FORUM_MOVE_UP}">{L_MOVE_UP}</a> <br> <a href="{catrow.forumrow.U_FORUM_MOVE_DOWN}">{L_MOVE_DOWN}</a></span></td>
	<td class="row2" align="center" valign="middle"><span class="gen"><a href="{catrow.forumrow.U_FORUM_RESYNC}">{L_RESYNC}</a></span></td>
</tr>
<!-- END forumrow -->
<!-- BEGIN catfoot -->
<tr>
	<!-- BEGIN inc -->
	<td class="row2" width="46"><img src="{SPACER}" width="46" height="0"></td>
	<!-- END inc -->
	<td colspan="{catrow.catfoot.INC_SPAN_ALL}" class="row2" nowrap="nowrap">
		<img src="{SPACER}" width="46" height="0">
		<input class="post" type="text" name="{catrow.catfoot.S_ADD_NAME}">&nbsp;
		<input type="submit" class="liteoption"  name="{catrow.catfoot.S_ADD_FORUM_SUBMIT}" value="{L_CREATE_FORUM}">
		<input type="submit" class="liteoption"  name="{catrow.catfoot.S_ADD_CAT_SUBMIT}" value="{L_CREATE_CATEGORY}">
	</td>
</tr>
<tr>
	<!-- BEGIN inc -->
	<td class="row2" width="46"><img src="{SPACER}" width="46" height="0"></td>
	<!-- END inc -->
	<td colspan="{catrow.catfoot.INC_SPAN_ALL}" height="1" class="spaceRow"><img src="{SPACER}" width="46" height="0"></td>
</tr>
<!-- END catfoot -->
<!-- END catrow -->
<tr>
	<td colspan="{INC_SPAN_ALL}" class="catBottom">
		<!-- BEGIN switch_board_footer -->
		<input class="post" type="text" name="name[0]">&nbsp;
		<!-- BEGIN sub_forum_attach -->
		<input type="submit" class="liteoption"  name="addforum[0]" value="{L_CREATE_FORUM}">
		<!-- END sub_forum_attach -->
		<input type="submit" class="liteoption"  name="addcategory[0]" value="{L_CREATE_CATEGORY}">
		<!-- END switch_board_footer -->
	</td>
</tr>
</table>
<!-- BEGIN forums_shadow -->
<br>
<table width="100%" cellpadding="7" cellspacing="1" border="0" class="forumline" align="center">
  <tr>
    <th class="thLeft" width="75%" colspan="7">{forums_shadow.L_FORUMS_SHADOW}</th>
  </tr>
  <tr>
    <td class="row3"><span class="nav">{forums_shadow.L_NAME}</span></td>
    <td class="row3" width="10%"><span class="nav">{forums_shadow.L_FORUM_ID}</span></td>
    <td class="row3" width="10%"><span class="nav">{forums_shadow.L_CAT_ID}</span></td>
    <td class="row3" width="10%"><span class="nav">{forums_shadow.L_TOPICS}</span></td>
    <td class="row3" width="10%"><span class="nav">{forums_shadow.L_POSTS}</span></td>
    <td class="row3" width="10%" colspan="2" align="center"><span class="nav">{forums_shadow.L_ACTION}</span></td>
  </tr>
  <!-- BEGIN forums_shadow_list -->
  <tr>
    <td class="row{forums_shadow.forums_shadow_list.CLASS}"><span class="nav"><a href="{forums_shadow.forums_shadow_list.U_FORUMS}">{forums_shadow.forums_shadow_list.FORUMS_NAME}</a></span></td>
    <td class="row{forums_shadow.forums_shadow_list.CLASS}">{forums_shadow.forums_shadow_list.FORUM_ID}</td>
    <td class="row{forums_shadow.forums_shadow_list.CLASS}">{forums_shadow.forums_shadow_list.CAT_ID}</td>
    <td class="row{forums_shadow.forums_shadow_list.CLASS}">{forums_shadow.forums_shadow_list.TOPICS}</td>
    <td class="row{forums_shadow.forums_shadow_list.CLASS}">{forums_shadow.forums_shadow_list.POSTS}</td>
    <td class="row{forums_shadow.forums_shadow_list.CLASS}"><a href="{forums_shadow.forums_shadow_list.U_EDIT}">{forums_shadow.L_EDIT}</a></td>
    <td class="row{forums_shadow.forums_shadow_list.CLASS}"><a href="{forums_shadow.forums_shadow_list.U_DELETE}">{forums_shadow.L_DELETE}</a></td>
  </tr>
  <!-- END forums_shadow_list -->
</table>
<!-- END forums_shadow -->

<!-- BEGIN all -->
<br>
<table width="100%" cellpadding="7" cellspacing="1" border="0" class="forumline" align="center">
  <tr>
    <th class="thLeft" width="75%" colspan="7">{all.L_ALL_FORUMS}</th>
  </tr>
  <tr>
    <td class="row3"><span class="nav">{all.L_NAME}</span></td>
    <td class="row3" width="10%"><span class="nav">{all.L_FORUM_ID}</span></td>
    <td class="row3" width="10%"><span class="nav">{all.L_CAT_ID}</span></td>
    <td class="row3" width="10%"><span class="nav">{all.L_TOPICS}</span></td>
    <td class="row3" width="10%"><span class="nav">{all.L_POSTS}</span></td>
    <td class="row3" width="10%" colspan="2" align="center"><span class="nav">{all.L_ACTION}</span></td>
  </tr>
  <!-- BEGIN list_all -->
  <tr>
    <td class="row{all.list_all.CLASS}"><span class="nav"><a href="{all.list_all.U_FORUMS}">{all.list_all.FORUMS_NAME}</a></span></td>
    <td class="row{all.list_all.CLASS}">{all.list_all.FORUM_ID}</td>
    <td class="row{all.list_all.CLASS}">{all.list_all.CAT_ID}</td>
    <td class="row{all.list_all.CLASS}">{all.list_all.TOPICS}</td>
    <td class="row{all.list_all.CLASS}">{all.list_all.POSTS}</td>
    <td class="row{all.list_all.CLASS}"><a href="{all.list_all.U_EDIT}">{all.L_EDIT}</a></td>
    <td class="row{all.list_all.CLASS}"><a href="{all.list_all.U_DELETE}">{all.L_DELETE}</a></td>
  </tr>
  <!-- END list_all -->
</table>
<!-- END all -->

<table width="100%" cellpadding="4" cellspacing="1" border="0">
<tr>
	<td><span class="nav"><a href="{U_SHOW_ALL}" class="nav">{L_SHOW_ALL}</a></span></td>
</tr>
</table>

</form>

<br>