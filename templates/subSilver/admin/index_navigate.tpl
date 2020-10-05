<body style="padding: 0px; margin: 0px;">
<table width="100%" cellpadding="1" cellspacing="0" border="0" align="center">
  <tr> 
	<td align="center" > 
	  <table width="100%" cellpadding="0" cellspacing="0" border="0" class="forumline">
		<tr>
			<td align="center">
				<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
					<tr> 
					  <th height="25" class="thHead"><b>{L_ADMIN}</b></th>
					</tr>
					<tr> 
					  <td class="row1""><span class="gemed"><a href="{U_ADMIN_INDEX}" target="main" class="genmed">{L_ADMIN_INDEX}</a></span></td>
					</tr>
					<tr> 
					  <td class="row2""><span class="genmed"><a href="{U_FORUM_INDEX}" target="_parent" class="genmed">{L_FORUM_INDEX}</a></span></td>
					</tr>
					<tr> 
					  <td class="row2"><span class="genmed"><a href="{U_FORUM_INDEX}" target="main" class="genmed">{L_PREVIEW_FORUM}</a></span></td>
					</tr>
					<tr> 
					  <td class="row2""><span class="genmed"><a href="{U_CHECKFILES}" target="main" class="genmed">{L_CHECK_FILES}</a></span></td>
					</tr>
				</table>
			</td>
		</tr>
		<!-- BEGIN catrow -->
		<tr>
			<td align="center">
			<div id="adm{catrow.CAT_ID}_" style="display: ''; position: relative;">
				<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
					<tr>
					  <th height="28" style="height: 18px; cursor: pointer;" class="thHead" onclick="javascript:ShowHide('adm{catrow.CAT_ID}_','adm{catrow.CAT_ID}_2','adm{catrow.CAT_ID}_3');"><b>{catrow.ADMIN_CATEGORY}</b></th>
					</tr>
					<!-- BEGIN modulerow -->
					<tr> 
					  <td class="{catrow.modulerow.ROW_CLASS}"><span class="genmed"><a href="{catrow.modulerow.U_ADMIN_MODULE}"  target="main" class="genmed">{catrow.modulerow.ADMIN_MODULE}</a></span> 
					  </td>
					</tr>
					<!-- END modulerow -->
				</table>
			</div>
			<div id="adm{catrow.CAT_ID}_2" style="display: none; position: relative;">
				<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
					<tr>
					  <th height="28" style="height: 18px; cursor: pointer;" class="thHead" onclick="javascript:ShowHide('adm{catrow.CAT_ID}_','adm{catrow.CAT_ID}_2','adm{catrow.CAT_ID}_3');"><b>{catrow.ADMIN_CATEGORY}</b></th>
					</tr>
				</table>
			</div>
			<script language="javascript" type="text/javascript">
			<!--
			if(GetCookie('adm{catrow.CAT_ID}_3') == '2') ShowHide('adm{catrow.CAT_ID}_', 'adm{catrow.CAT_ID}_2', 'adm{catrow.CAT_ID}_3');
			//-->
			</script>
			</td>
		</tr>
		<!-- END catrow -->
	  </table>
	</td>
  </tr>
</table>

<br>
