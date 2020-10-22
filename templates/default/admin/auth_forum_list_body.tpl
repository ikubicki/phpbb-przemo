<h1>{L_AUTH_TITLE}</h1>

<p>{L_AUTH_EXPLAIN}</p>

<form method="post" action="{S_FORUM_ACTION}">

<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
<tr>
	<th colspan="{INC_SPAN}" width="75%">{L_FORUM}</th>
		<!-- BEGIN forum_auth_titles -->
		<th>{forum_auth_titles.CELL_TITLE}</th>
		<!-- END forum_auth_titles -->

</tr>
<!-- BEGIN catrow -->
<!-- BEGIN cathead -->
<tr>
	<!-- BEGIN inc -->
	<td class="row2" rowspan="{catrow.cathead.inc.ROWSPAN}" width="46"><img src="{SPACER}" width="46" height="0" /></td>
	<!-- END inc -->
	<td class="{catrow.cathead.CLASS_CATLEFT}"   colspan="{catrow.cathead.INC_SPAN}" {catrow.cathead.WIDTH}><span class="cattitle"><b><a href="{catrow.cathead.U_VIEWCAT}" class="cattitle">{catrow.cathead.CAT_TITLE}</a></b></span></td>
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
	<td class="row2" width="46"><img src="{SPACER}" width="46" height="0" /></td>
	<!-- END inc -->
	<td class="row2" colspan="{catrow.forumrow.INC_SPAN}" {catrow.forumrow.WIDTH}><table cellpadding="0" cellspacing="0" width="100%"><tr><td>{catrow.forumrow.LINK_IMG}</td><td width="100%"><span class="gen"><a href="{catrow.forumrow.U_VIEWFORUM}"{catrow.forumrow.FORUM_COLOR}>{catrow.forumrow.FORUM_NAME}</a></span><br /><span class="gensmall">{catrow.forumrow.FORUM_DESC}</span></td></tr></table></td>
		<!-- BEGIN forum_auth_data -->
		<td class="row2" align="center"><span class="genmed" title="{catrow.forumrow.forum_auth_data.AUTH_EXPLAIN}">{catrow.forumrow.forum_auth_data.CELL_VALUE}</span></td>
		<!-- END forum_auth_data -->

</tr>
<!-- END forumrow -->
<!-- END catrow -->
    <tr>
        <td class="submit" align="center" colspan="{INC_SPAN_ALL}">
            <!-- BEGIN buttons_edit -->
                <input type="submit" value="{buttons_edit.SAVE}" class="liteoption" name="save">
                &nbsp; &nbsp;
                <input type="submit" value="{buttons_edit.CANCEL}" class="liteoption" name="cancel">
            <!-- END buttons_edit -->
            <!-- BEGIN buttons_custom -->
                <input type="submit" value="{buttons_custom.EDIT}" class="liteoption" name="edit">
            <!-- END buttons_custom -->
        </td></tr>
</table>
<!-- BEGIN forums_shadow -->
<br />
<table width="100%" cellpadding="7" cellspacing="1" border="0" class="forumline" align="center">
  <tr>
    <th width="75%" colspan="7">{forums_shadow.L_FORUMS_SHADOW}</th>
  </tr>
  <tr>
    <td class="row3"><span class="nav">{forums_shadow.L_NAME}</span></td>
    <td class="row3" width="10%"><span class="nav">{forums_shadow.L_FORUM_ID}</span></td>
    <td class="row3" width="10%"><span class="nav">{forums_shadow.L_CAT_ID}</span></td>
  </tr>
  <!-- BEGIN forums_shadow_list -->
  <tr>
    <td class="row{forums_shadow.forums_shadow_list.CLASS}"><span class="nav"><a href="{forums_shadow.forums_shadow_list.U_FORUMS}">{forums_shadow.forums_shadow_list.FORUMS_NAME}</a></span></td>
    <td class="row{forums_shadow.forums_shadow_list.CLASS}">{forums_shadow.forums_shadow_list.FORUM_ID}</td>
    <td class="row{forums_shadow.forums_shadow_list.CLASS}">{forums_shadow.forums_shadow_list.CAT_ID}</td>
  </tr>
  <!-- END forums_shadow_list -->
</table>
<!-- END forums_shadow -->
</form><br>
