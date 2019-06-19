 
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
  <tr> 
	<td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
  </tr>
</table>

<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
  <!-- BEGIN switch_groups_remaining -->
  <tr> 
	<th colspan="2" align="center" class="thHead" height="25">{L_JOIN_A_GROUP}</th>
  </tr>
  <!-- BEGIN group_list -->
  <tr>
	<td class="row1" width="20%" nowrap="nowrap" align="center"><span class="gen"><b><a href="{switch_groups_remaining.group_list.U_GROUP}"{switch_groups_remaining.group_list.GROUP_COLOR}{switch_groups_remaining.group_list.GROUP_STYLE} class="cattitle">{switch_groups_remaining.group_list.GROUP_NAME}</a></b></span></td>
	<td class="row2" width="80%"><span class="gensmall">{switch_groups_remaining.group_list.GROUP_DESC}</span></td>
  </tr>
  <!-- END group_list -->
  <!-- END switch_groups_remaining -->
  <!-- BEGIN switch_groups_joined -->
  <tr> 
	<th colspan="2" align="center" class="thHead" height="25">{L_GROUP_MEMBERSHIP_DETAILS}</th>
  </tr>
  <!-- BEGIN group_member -->
  <tr> 
	<td class="row1" width="20%" nowrap="nowrap" align="center"><span class="gen"><b><a href="{switch_groups_joined.group_member.U_GROUP}"{switch_groups_joined.group_member.GROUP_COLOR}{switch_groups_joined.group_member.GROUP_STYLE} class="cattitle">{switch_groups_joined.group_member.GROUP_NAME}</a></b>{switch_groups_joined.group_member.L_PENDING}</span></td>
	<td class="row2" width="80%"><span class="gensmall">{switch_groups_joined.group_member.GROUP_DESC}</span></td>
  </tr>
  <!-- END group_member -->
  <!-- END switch_groups_joined -->
  <tr>
	<td class="catBottom" colspan="2">&nbsp;</td>
  </tr>
</table>

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
  <tr> 
	<td align="right" valign="top"><span class="gensmall">{S_TIMEZONE}</span></td>
  </tr>
</table>

<br clear="all">

<table width="100%" cellspacing="2" border="0" align="center">
  <tr> 
	<td valign="top" align="right">{JUMPBOX}</td>
  </tr>
</table>
