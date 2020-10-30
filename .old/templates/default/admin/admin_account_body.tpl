<br><br>

<form method="post" action="{S_MODE_ACTION}">
	<!-- BEGIN there_are_users -->
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
  <tr> 
        <td><span class="genmed"><b>{INFO_MESSAGE}</b></span></td>
        <td align="right" nowrap="nowrap"><span class="genmed">{L_SELECT_SORT_METHOD}:&nbsp;{S_MODE_SELECT}&nbsp;&nbsp;
                                                             {L_ORDER}&nbsp;{S_ORDER_SELECT}&nbsp;&nbsp; <input type="submit" name="submit" value="{L_SUBMIT}" 
                                                              class="liteoption"></span></td>
  </tr>
</table>
	<!-- END there_are_users -->

<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
  <tr> 
        <th height="25" nowrap="nowrap">#</th>
        <th nowrap="nowrap">{L_USERNAME}</th>
        <th nowrap="nowrap">{L_EMAIL}</th>
        <th nowrap="nowrap">{L_JOINED}</th>
        <th width="33%" colspan="2" align="center">{L_ACTIONS}</th>
  </tr>
  <tr> 
        <td colspan="5" class="row2"><span class="gensmall">{L_ACTIVATION}</span></td>
        <td align="right" class="row2"><span class="gensmall">{TOTAL}</span></td>
  </tr>
<!-- BEGIN admin_account -->
  <tr> 
        <td class="{admin_account.ROW_CLASS}" align="center"><span class="gensmall">&nbsp;{admin_account.ROW_NUMBER}&nbsp;</span></td>
        <td class="{admin_account.ROW_CLASS}" align="center"><span class="gen"><a href="{admin_account.U_PROFILE}" class="gen">{admin_account.USERNAME}</a></span></td>
        <td class="{admin_account.ROW_CLASS}" align="center" valign="middle">&nbsp;{admin_account.EMAIL}&nbsp;</td>
        <td class="{admin_account.ROW_CLASS}" align="center" valign="middle"><span class="genmed">{admin_account.REG_DATE}</span><br>
                                                                                                                      <span class="gensmall">{admin_account.WAITING}</span></td>
        <td class="{admin_account.ROW_CLASS}" align="center" valign="middle"><a href="{admin_account.U_DELETE}" class="gensmall">{L_DELETE}</a></td>
        <td class="{admin_account.ROW_CLASS}" align="center" valign="middle"><a href="{admin_account.U_ACTKEY}" class="gensmall">{L_ACTIVATE}</a></td>
  </tr>
<!-- END admin_account -->
<!-- BEGIN there_are_no_users -->
  <tr> 
        <td class="row2" colspan="6" height="28" align="center"><span class="genmed"><b>{L_NO_USERS}</b></span></td>
  </tr>
<!-- END there_are_no_users -->
  <tr> 
        <td class="catbottom" colspan="6" height="28">&nbsp;</td>
  </tr>
</table>

<!-- BEGIN there_are_users -->
<table width="100%" cellspacing="2" cellpadding="2" border="0">
  <tr> 
        <td><span class="nav">{PAGE_NUMBER}</span></td>
        <td align="right"><span class="nav">{PAGINATION}</span></td>
  </tr>
</table>
<!-- END there_are_users -->
</form>
<br>