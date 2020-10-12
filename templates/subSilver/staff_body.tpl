

<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
  <tr>
        <th>{L_USERNAME}</th>
        <th>{L_FORUMS}</th>
        <th>{L_POSTS}</th>
        <th>{L_JOINED}</th>
        <th>{L_EMAIL}</th>
        <th>PM</th>
        <!-- BEGIN aim -->
	<th>GG</th>
	<!-- END aim -->
        <th>WWW</th>
  </tr>
<!-- BEGIN staff -->
  <tr> 
        <td valign="top" class="row1" nowrap="nowrap"><a href="{staff.U_NAME}" class="genmed"{staff.USERNAME_COLOR}><b>{staff.NAME}</b></a><span class="postdetails">{staff.LEVEL}{staff.RANK}{staff.RANK_IMAGE}{staff.AVATAR}</span></td>
        <td valign="top" class="row2" nowrap="nowrap"><span class="genmed">{staff.FORUMS}</span>&nbsp;</td>
        <td valign="top" align="right" class="row1" nowrap="nowrap"><span class="gensmall">{staff.POSTS} &nbsp;<br>{staff.POST_PERCENT} &nbsp;<br>{staff.POST_DAY}</span>&nbsp;</td>
        <td valign="top" class="row2" align="right" nowrap="nowrap"><span class="gensmall">{staff.JOINED}<br>[{staff.PERIOD}]</span></td>
        <td align="center" class="row1">{staff.MAIL}{CICQ_OFF1}<div style="position:relative">{staff.ICQ}<div style="position:absolute;left:3px;top:-1px">{staff.ICQ_STATUS}</div></div></td>
		<td align="center" class="row2">{staff.PM}</td>
		<!-- BEGIN aim_row -->
		<td align="center" class="row1">
			<div style="display:inline;position:absolute;margin-left:3px;margin-top:-1px;">{staff.AIM_STATUS_IMG}</div>
			<div style="display:inline;">{staff.AIM}</div>
		</td>
		<!-- END aim_row -->
        <td align="center" class="row2">{staff.WWW}</td>
  </tr>
<!-- END staff -->
</table>
