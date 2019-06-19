
	<!-- BEGIN switch_photo_block -->
	<tr> 
	  <td class="cat" colspan="2" height="28">&nbsp;</td>
	</tr>
	<tr> 
	  <th class="thSides" colspan="2" height="12" valign="middle">{L_PHOTO_PANEL}</th>
	</tr>
	<tr> 
		<td class="row1" colspan="2"><table width="70%" cellspacing="2" cellpadding="0" border="0" align="center">
			<tr> 
				<td width="65%"><span class="gensmall">{L_PHOTO_EXPLAIN}</span></td>
				<td align="center"><span class="gensmall">{L_CURRENT_IMAGE}</span><br>{PHOTO}<br><input type="checkbox" name="photodel">&nbsp;<span class="gensmall">{L_DELETE_PHOTO}</span></td>
			</tr>
		</table></td>
	</tr>
	<!-- BEGIN switch_photo_local_upload -->
	<tr> 
		<td class="row1"><span class="gen">{L_UPLOAD_PHOTO_FILE}:</span></td>
		<td class="row2"><!--<input type="hidden" name="MAX_PHOTO_FILE_SIZE" value="{PHOTO_SIZE}">--><input type="file" name="photo" class="post" onFocus="Active(this)" onBlur="NotActive(this)" style="width:200px"></td>
	</tr>
	<!-- END switch_photo_local_upload -->
	<!-- BEGIN switch_photo_remote_upload -->
	<tr> 
		<td class="row1"><span class="gen">{L_UPLOAD_PHOTO_URL}:</span><br><span class="gensmall">{L_UPLOAD_PHOTO_URL_EXPLAIN}</span></td>
		<td class="row2"><input type="text" name="photourl" size="40" class="post" onFocus="Active(this)" onBlur="NotActive(this)" style="width:200px"></td>
	</tr>
	<!-- END switch_photo_remote_upload -->
	<!-- BEGIN switch_photo_remote_link -->
	<tr> 
		<td class="row1"><span class="gen">{L_LINK_REMOTE_PHOTO}:</span><br><span class="gensmall">{L_LINK_REMOTE_PHOTO_EXPLAIN}</span></td>
		<td class="row2"><input type="text" name="photoremoteurl" size="40" class="post" onFocus="Active(this)" onBlur="NotActive(this)" style="width:200px"></td>
	</tr>
	<!-- END switch_photo_remote_link -->
	{S_PHOTO_HIDDEN_FIELDS}
	<!-- END switch_photo_block -->
