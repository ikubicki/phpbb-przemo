<table width="100%" cellpadding="1" cellspacing="1" border="0">
   <tr> 
      <td align="left">&nbsp;</td>
      <td align="right"><span class="nav">{U_INDEX_WARNING}</span></td>
   </tr>
</table>
<table width="100%" cellpadding="6" cellspacing="1" border="0" class="forumline">
   <tr>
      <th width="70%" class="thCornerL" height="25" nowrap="nowrap">{L_PAGE}</th>
   </tr>
<!-- BEGIN hide -->
   <tr>
      <td class="row1" height="28"><span class="gen">{hide.TITLE}</span></td>
   </tr>
<!-- END hide -->
   <tr>
      <td class="catbottom" height="28" align="left"><span class="gensmall">{HIDE}</span></td>
   </tr>
</table>
<br>
<form method="post" action="{S_ACTION}">
<table width="100%" cellpadding="1" cellspacing="1" border="0">
<tr>
   <td align="left" class="nav">{SUBTITLE}</td>
   <td align="right" nowrap="nowrap"><span class="genmed">{L_SELECT_SORT_METHOD}:&nbsp;{S_MODE_SELECT}&nbsp;{S_ORDER_SELECT}&nbsp;&nbsp;<input type="submit" name="submit" value="{L_SUBMIT}" class="liteoption"></span></td>
</tr>
</table>
</form>
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
<!-- BEGIN default -->
   <tr>
      <th height="25" class="thCornerL">{L_USERNAME}</th>
      <th height="25" class="thCornerL">{L_WARNINGS}</th>
      <th height="25" class="thCornerL">{L_VALUE}</th>
      <th height="25" class="thCornerL">{L_DETAIL}</th>
      <th height="25" class="thCornerL">{L_LASTPOST}</th>
      <th height="25" class="thCornerL">{L_POSTS}</th>
      <th height="25" class="thCornerL">&nbsp;</th>
   </tr>
<!-- END default -->
<!-- BEGIN default_list -->
   <tr>
      <td class="{default_list.ROW_CLASS}" nowrap="nowrap" width="19%" align="center"><span class="name">{default_list.U_VIEWPROFILE}</span></td>
      <td class="{default_list.ROW_CLASS}" align="center" width="3%"><span class="gen"><b>{default_list.WARNINGS}</b></span></td>
      <td class="{default_list.ROW_CLASS}" align="center" width="3%" nowrap="nowrap"><span class="gen">{default_list.VALUE}</span></td>
      <td class="{default_list.ROW_CLASS}" align="center" nowrap="nowrap" width="24%"><span class="gensmall">{default_list.DETAIL}</span></td>
      <td class="{default_list.ROW_CLASS}" align="center" nowrap="nowrap" width="24%"><span class="gensmall">{default_list.LASTPOST}</span></td>
      <td class="{default_list.ROW_CLASS}" align="center" width="3%"><span class="gensmall">{default_list.POSTS}</span></td>
      <td class="{default_list.ROW_CLASS}" align="center" nowrap="nowrap" width="24%"><span class="gensmall">{default_list.PERIOD}</span></td>
   </tr>
<!-- END default_list -->
<!-- BEGIN default -->
   <tr>
      <td class="catbottom" align="right" colspan="7" height="28">{default.ARCHIVE}</td>
   </tr>
<!-- END default -->
<!-- BEGIN detail -->
   <tr>
      <th height="25" class="thCornerL" nowrap="nowrap">{L_VALUE}</th>
      <th height="25" class="thCornerL" nowrap="nowrap">{L_MODID}</th>
      <th height="25" class="thCornerL" nowrap="nowrap">{L_DATE}</th>
      <th height="25" class="thCornerL" nowrap="nowrap">{L_REASON}</th>
      <th height="25" class="thCornerL" nowrap="nowrap">{L_ACTION}</th>
   </tr>
<!-- END detail -->
<!-- BEGIN detail_list -->
   <tr>
      <td class="{detail_list.ROW_CLASS}" align="center" width="5%"><span class="gen"><b>{detail_list.VALUE}</b></span></td>
      <td class="{detail_list.ROW_CLASS}" align="center" nowrap="nowrap" width="10%"><span class="gen"><b>{detail_list.MODID}</b></span></td>
      <td class="{detail_list.ROW_CLASS}" align="center" nowrap="nowrap" width="15%"><span class="gensmall">{detail_list.DATE}</span></td>
      <td class="{detail_list.ROW_CLASS}" align="center" width="60%"><span class="gensmall">{detail_list.REASON}</span></td>
      <td class="{detail_list.ROW_CLASS}" align="center" nowrap="nowrap" width="10%"><span class="gensmall">{detail_list.ACTION}</span></td>
   </tr>
<!-- END detail_list -->
<!-- BEGIN edit -->
   <tr>
      <th height="25" colspan="3" class="thCornerL" nowrap="nowrap">{L_EDIT}</th>
   </tr>
   <form action="{S_ACTION}" method="post">
   <tr>
      <td class="row1" width="20%"></td><td class="row1" align="left"><span class="gen">{L_VALUE}</span></td><td class="row1" align="left"><input type="text" class="post" maxlength="3" size="2" name="value" value="{edit.VALUE}" onFocus="Active(this)" onBlur="NotActive(this)"></td>
   </tr>
   <tr>
      <td class="row1" width="20%"></td><td class="row1" align="left"><span class="gen">{L_REASON}</span></td><td class="row1" align="left"><textarea name="reason" class="post" rows="6" cols="70">{edit.REASON}</textarea></td>
   </tr>
   <tr>
      <td class="catbottom" colspan="3" align="center" colspan="2"><input type="submit" name="submit" value="{L_ADD_WARNING}" class="liteoption"><input type="hidden" name="mode" value="update"><input type="hidden" name="id" value="{edit.ID}"><input type="hidden" name="userid" value="{edit.USERID}"></td>
   </tr>
   </form>
<!-- END edit -->
<!-- BEGIN add -->
   <tr>
      <th height="25" colspan="3" class="thCornerL" nowrap="nowrap">{add.L_EXPLAIN}</th>
   </tr>
   <form action="{S_ACTION_ADD}" method="post">
   <tr>
      <td class="row1" align="left" width="20%"><td class="row1" align="left"><span class="gen">{L_USERNAME}:</span><td class="row2" align="left"><input type="text" class="post" size="20" name="username" value="{add.USERNAME}" onFocus="Active(this)" onBlur="NotActive(this)"></td>
   </tr>
   <tr>
      <td class="row1" align="left" width="20%"><td class="row1" align="left"><span class="gen">{L_VALUE}:</span><td class="row2" align="left"><input type="text" class="post" maxlength="3" size="2" name="value" onFocus="Active(this)" onBlur="NotActive(this)"></td>
   </tr>
   <tr>
      <td class="row1" align="left" width="20%"><td class="row1" align="left"><span class="gen">{L_REASON}</span><td class="row2" align="left"><textarea name="reason" class="post" rows="6" cols="70">{edit.REASON}</textarea></td>
      <input type="hidden" name="action" value="warning">
   </tr>
   <tr>
      <td class="catbottom" colspan="3" align="center" colspan="2"><input type="submit" name="submit" value="{L_ADD_WARNING}" class="liteoption"></td>
   </tr>
   </form>
<!-- END add -->
<!-- BEGIN archive -->
   <tr>
      <th height="25" class="thCornerL" nowrap="nowrap">{L_USERNAME}</th>
      <th height="25" class="thCornerL" nowrap="nowrap">{L_VALUE}</th>
      <th height="25" class="thCornerL" nowrap="nowrap">{L_MODID}</th>
      <th height="25" class="thCornerL" nowrap="nowrap">{L_DATE}</th>
      <th height="25" class="thCornerL" nowrap="nowrap">{L_REASON}</th>
      <th height="25" class="thCornerL" nowrap="nowrap">{L_ACTION}</th>
   </tr>
<!-- END archive -->
<!-- BEGIN archive_list -->
   <tr>
      <td class="{archive_list.ROW_CLASS}" align="center" nowrap="nowrap" width="10%"><span class="name"><b>{archive_list.USERNAME}</b></span></td>
      <td class="{archive_list.ROW_CLASS}" align="center" width="5%"><span class="gen"><b>{archive_list.VALUE}</b></span></td>
      <td class="{archive_list.ROW_CLASS}" align="center" nowrap="nowrap" width="10%"><span class="gen"><b>{archive_list.MODID}</b></span></td>
      <td class="{archive_list.ROW_CLASS}" align="center" nowrap="nowrap" width="15%"><span class="gensmall">{archive_list.DATE}</span></td>
      <td class="{archive_list.ROW_CLASS}" align="center" width="50%"><span class="gensmall">{archive_list.REASON}</span></td>
      <td class="{archive_list.ROW_CLASS}" align="center" nowrap="nowrap" width="10%"><span class="gensmall">{archive_list.ACTION}</span></td>
   </tr>
<!-- END archive_list -->
<!-- BEGIN archive -->
   <tr>
      <td class="catbottom" colspan="6" height="28" align="left"></td>
   </tr>
<!-- END archive -->
<!-- BEGIN view_modid_main -->
   <tr>
      <th height="25" class="thCornerL" nowrap="nowrap">{L_VALUE}</th>
      <th height="25" class="thCornerL" nowrap="nowrap">{L_USERNAME}</th>
      <th height="25" class="thCornerL" nowrap="nowrap">{L_DATE}</th>
      <th height="25" class="thCornerL" nowrap="nowrap">{L_REASON}</th>
      <th height="25" class="thCornerL" nowrap="nowrap">{L_ACTION}</th>
   </tr>
<!-- END view_modid_main -->
<!-- BEGIN view_modid -->
   <tr>
      <td class="{view_modid.ROW_CLASS}" align="center" width="5%"><span class="gen"><b>{view_modid.VALUE}</b></span></td>
      <td class="{view_modid.ROW_CLASS}" align="center" nowrap="nowrap" width="10%"><span class="name"><b>{view_modid.MODID}</b></span></td>
      <td class="{view_modid.ROW_CLASS}" align="center" nowrap="nowrap" width="15%"><span class="gensmall">{view_modid.DATE}</span></td>
      <td class="{view_modid.ROW_CLASS}" align="center" width="60%"><span class="gensmall">{view_modid.REASON}</span></td>
      <td class="{view_modid.ROW_CLASS}" align="center" nowrap="nowrap" width="10%"><span class="gensmall">{view_modid.ACTION}</span></td>
   </tr>
<!-- END view_modid -->

</table>

<table width="100%" cellpadding="1" cellspacing="1" border="0">
   <tr>
      <td height="28" align="left"><span class="nav">{U_INDEX_WARNING}</span></td>
	  <td height="28" align="right"><span class="nav">{REM_ALL}{U_ADD_WARNING}</span></td>
   </tr>
</table>
<table width="100%" cellpadding="1" cellspacing="1" border="0">
   <tr>
      <td height="28" align="left"><span class="nav">{PAGE_NUMBER}</span></td>
      <td height="28" align="right"><span class="nav">{PAGINATION}</span></td>
   </tr>
</table>
<br>