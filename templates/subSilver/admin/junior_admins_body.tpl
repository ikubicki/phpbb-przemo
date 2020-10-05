<h1>{L_TITLE}</h1>
<p>{L_DESC}</p>

<script language="JavaScript" type="text/javascript">
function toggle_check_all(main, sub_num)
{
	for (var i=0; i < document.form.elements.length; i++)
	{
		var checkbox_element = document.form.elements[i];
		if ((main.name.search("check_all_page") != -1) && (checkbox_element.type == 'checkbox'))
		{
			checkbox_element.checked = main.checked;
		}		
		else if ((checkbox_element.name.search("check_all") == -1) && (checkbox_element.name.search("a"+sub_num+"_name") != -1) && (checkbox_element.type == 'checkbox'))
		{
			checkbox_element.checked = main.checked;
		}
	}
}
</script>

<form action="{S_ACTION}" name="form" method="post">
<table  border="0" cellpadding="1" cellspacing="1" class="forumline" align="center" width="400">
	<tr>
		<td class="catBottom" width="30%" nowrap="nowrap"><input type="checkbox" name="check_all_page" onClick="toggle_check_all(check_all_page, 1);" id="all"> <label for="all" style="cursor: pointer;"><span class="gensmall">{L_MARK_ALL}</span></label>&nbsp;</td>
		<td class="catBottom" align="right"><span class="nav">{USERNAME}</span>, {L_MODULES}: <b>{MODULES}</b></td>
	</tr>
	<!-- BEGIN catrow -->
	<tr>
		<th align="left" colspan="2"><input type="checkbox" name="check_all_{catrow.NUM}" onClick="toggle_check_all(check_all_{catrow.NUM}, {catrow.NUM});" id="check_all_{catrow.NUM}"> <label for="check_all_{catrow.NUM}" style="cursor: pointer;">{catrow.CAT}</label></th>
	</tr>
	<!-- BEGIN modulerow -->
	<tr>
		<td class="row{catrow.modulerow.ROW}" align="left" colspan="2"><span class="genmed"{catrow.modulerow.STYLE}>
			<input type="checkbox" {catrow.modulerow.CHECKED} name="a{catrow.NUM}_name{catrow.modulerow.CAT_NUM}" value="{catrow.modulerow.FILE}" id="{catrow.modulerow.CAT_NUM}"{catrow.modulerow.CHECKED}>
			<label for="{catrow.modulerow.CAT_NUM}" style="cursor: pointer;"><b>{catrow.modulerow.NAME}</b></label></span>
		</td>
	</tr>
	<!-- END modulerow -->
	<!-- END catrow -->
	<tr>
		<td colspan="2" align="center" class="catBottom"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption"> <input type="reset" name="reset" value="{L_RESET}" class="liteoption"></td>
	</tr>
</table>
<input type="hidden" name="user_id" value="{USER_ID}">
</form>
<br>