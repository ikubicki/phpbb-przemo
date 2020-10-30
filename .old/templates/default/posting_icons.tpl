
<script language="javascript" type="text/javascript">
<!--
function icon(text) {
	text = ''+text+'';
	if (opener.document.forms['post'].more_icon.createTextRange && opener.document.forms['post'].more_icon.caretPos) {
		var caretPos = opener.document.forms['post'].more_icon.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text + ' ' : text;
		opener.document.forms['post'].more_icon.focus();
	} else {
	opener.document.forms['post'].more_icon.value  += text;
	opener.document.forms['post'].more_icon.focus();
	window.close();
	}
}
//-->
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="10">
	<tr>
		<td><table width="100%" border="0" cellspacing="1" cellpadding="4" class="forumline">
			<tr>
				<th  width="100%" height="25">{L_ICONS}</th>
			</tr>
			<tr>
				<td height="100%">
					<!-- BEGIN icons -->
					<a href="javascript:icon('{icons.ICON_CODE}')"><img src="{icons.URL}" border="0"></a>&nbsp; &nbsp;
					<!-- END icons -->
				</td>
			</tr>
	
		</table></td>
	</tr>
</table>
