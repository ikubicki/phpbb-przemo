
<!-- BEGIN show_apcp -->
	<tr>
		<th colspan="2">
			{L_ATTACH_POSTING_CP}
			<span class="description gensmall">{L_ATTACH_POSTING_CP_EXPLAIN}</span>
		</th>
	</tr>
	<tr>
		<td class="row1" colspan="2"></td>
	</tr>

	<tr> 
		<td class="row1"><span class="gen"><b>{L_OPTIONS}</b></span></td> 
	    <td class="row1" nowrap="nowrap"><input type="submit" name="add_attachment_box" value="{L_ADD_ATTACHMENT_TITLE}" class="liteoption">
<!-- END show_apcp -->
	<!-- BEGIN switch_posted_attachments -->
		&nbsp; <input type="submit" name="posted_attachments_box" value="{L_POSTED_ATTACHMENTS}" class="liteoption">
	<!-- END switch_posted_attachments -->
<!-- BEGIN show_apcp -->
	</td></tr> 
<!-- END show_apcp -->
	<tr style="display: none;"><td>{S_HIDDEN}</td></tr>
	<!-- BEGIN hidden_row -->
	{hidden_row.S_HIDDEN}
	<!-- END hidden_row -->

	{ADD_ATTACHMENT_BODY}

	{POSTED_ATTACHMENTS_BODY}
