
	<tr>
		<th class="thHead" colspan="2">{L_ADD_ATTACH_TITLE}</th>
	</tr>
	<tr>
		<td class="row1" colspan="2"><span class="gensmall">{L_ADD_ATTACH_EXPLAIN}<br>{RULES}</span></td>
	</tr>

	<tr> 
		<td class="row1"><span class="gen"><b>{L_FILE_NAME}</b></span></td> 
	    <td class="row1"><span class="genmed"><input type="file" name="fileupload" size="40" maxlength="{FILESIZE}" value="" class="post" onFocus="Active(this)" onBlur="NotActive(this)"></span></td> 
	</tr> 
	<tr> 
		<td class="row1"><span class="gen"><b>{L_FILE_COMMENT}</b></span></td> 
	    <td class="row1"><span class="genmed"><textarea name="filecomment" rows="3" cols="35" class="post" onFocus="Active(this)" onBlur="NotActive(this)">{FILE_COMMENT}</textarea>
		<input type="submit" name="add_attachment" value="{L_ADD_ATTACHMENT}" class="liteoption"></span></td> 
	</tr> 

