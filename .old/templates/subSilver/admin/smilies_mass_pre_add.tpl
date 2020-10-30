<h1>{L_SMILEY_TITLE}</h1>

<P>{L_SMILEY_EXPLAIN}</p>
<form method="post" action="{S_SMILEY_ACTION}">
<table align="center" cellspacing="1" cellpadding="3" class="forumline">
				<tr> 
					<th colspan="3">{L_SMILEY_CONFIG}</th>
				</tr>
	<!-- BEGIN mass_pre_add --> 
				<tr> 
					<td class="row2">{L_SMILEY_CODE}: <input type="text" name="smile_code[]" class="post" size="10"/></td>
					<td class="row2"><input type="hidden" name="smile_url[]" value="{mass_pre_add.IMG}">&nbsp; <img name="smiley_image" src="{mass_pre_add.SMILEY_IMG}" border="0" alt=""></td>
				</tr>
	<!-- END mass_pre_add -->
	<tr> 
		<td class="cat" colspan="3" align="center">{S_HIDDEN_FIELDS} <input class="mainoption" type="submit" value="{L_SUBMIT}"></td>
	</tr>
</table>
</form>
<br>