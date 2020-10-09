<!-- BEGIN links_target_0 -->
<base target="report_window">
<!-- END links_target_0 -->
<!-- BEGIN links_target_1 -->
<base target="_blank">
<!-- END links_target_1 -->
<!-- BEGIN links_target_2 -->
<base target="_self">
<!-- END links_target_2 -->
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
  <tr> 
	<td align="left">&nbsp;</td>
	<td align="right"><span class="genmed">
<script type="text/javascript">
<!--
document.write('<a href="javascript:open_popup()" class="genmed">{L_OPEN_POPUP}</a>');

function open_popup()
{
	report = window.open('{U_REPORT_POPUP}', '_phpbbreport', 'HEIGHT={S_HEIGHT},resizable=yes,scrollbars=yes,WIDTH={S_WIDTH}');;
	report.focus();
}
//-->
</script>
	</span></td>
  </tr>
</table>
<p class="postbody">{TEXT}</p>
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
  <tr> 
	<th class="thCornerL" nowrap="nowrap">&nbsp;{L_POST}&nbsp;</th>
	<th class="thTop" nowrap="nowrap">&nbsp;{L_AUTHOR}&nbsp;</th>
	<th class="thTop" nowrap="nowrap">&nbsp;{L_TOPIC}&nbsp;</th>
	<th class="thTop" nowrap="nowrap">&nbsp;{L_FORUM}&nbsp;</th>
	<th class="thCornerR" nowrap="nowrap">&nbsp;{L_REPORTER}&nbsp;</th>
  </tr>
<!-- BEGIN postrow -->
  <tr> 
	<td class="row1" align="left" valign="middle">
	<a href="{postrow.U_POST}" class="gen"><img src="{S_POST_IMG}" border="0"></a> <a href="{postrow.U_POST}" class="gen">{postrow.POST}</a></td>
	<td class="row2" align="center" valign="middle">
	<!-- BEGIN u_author -->
	<a href="{postrow.U_AUTHOR}" class="gen">{postrow.AUTHOR}</a></td>
	<!-- END u_author -->
	<!-- BEGIN no_u_author -->
	<span class="gen">{postrow.AUTHOR}</span></td>
	<!-- END no_u_author -->
	<td class="row3" align="center" valign="middle">
	<a href="{postrow.U_TOPIC}" class="gen">{postrow.TOPIC}</a></td>
	<td class="row2" align="center" valign="middle">
	<a href="{postrow.U_FORUM}" class="gen">{postrow.FORUM}</a></td>
	<td class="row3" align="center" valign="middle">
	<!-- BEGIN u_reporter -->
	<a href="{postrow.U_REPORTER}" class="gen">{postrow.REPORTER}</a></td>
	<!-- END u_reporter -->
	<!-- BEGIN no_u_reporter -->
	<span class="gen">{postrow.REPORTER}</span></td>
	<!-- END no_u_reporter -->
  </tr>
<!-- END postrow -->
</table>






