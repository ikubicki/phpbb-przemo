<SCRIPT LANGUAGE="JavaScript">
<!--
function disableForm(theform)
{
	if (document.all || document.getElementById)
	{
		for (i = 0; i < theform.length; i++)
		{
			var tempobj = theform.elements[i];
			if (tempobj.type.toLowerCase() == "submit" && tempobj.name.toLowerCase() != "improve")
			{
				tempobj.disabled = true;
			}
		}
		return true;
	}
	else
	{
		alert("The form has been submitted.  Please do NOT resubmit. ");
		return false;
	}
}
function displayWindow(url, width, height)
{
	var Win = window.open(url,"displayWindow",'width=' + width + ',height=' + height + ',resizable=1,scrollbars=no,menubar=no' );
}

//  End -->
</script> 

<form action="{S_GROUPCP_ACTION}" method="post" onSubmit="return disableForm(this);">

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="left" class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></td>
	</tr>
</table>

<table cellspacing="1" cellpadding="4" border="0" align="center" width="100%" class="forumline">
	<tr> 
	  <th class="thHead" colspan="2">{L_COMPOSE}</th>
	</tr>
	<!-- BEGIN form -->
	<tr> 
	  <td class="row1" align="right"><b>{L_USERS_LANGUAGE}</b></td>
	  <td class="row2" align="left">{LANGUAGE_SELECT} <span class="gensmall">{L_USERS_LANGUAGE_E}</span></td>
	</tr>
	<tr> 
	  <td class="row1" align="right"><b>{L_PLAIN_HTML}</b></td>
	  <td class="row2"><span class="gen"><input type="radio" name="html" value="0"{HTML_NO}> text &nbsp;<input type="radio" name="html" value="1"{HTML_YES}> html</span></td>
	</tr>
	<tr> 
	  <td class="row1" align="right"><b>{L_EMAIL_SUBJECT}</b></td>
	  <td class="row2"><span class="gen"><input type="text" name="subject" style="width:550px;" maxlength="100" tabindex="2" class="post" value="{SUBJECT}"></span></td>
	</tr>
	<tr> 
	  <td class="row1" align="right" valign="top"> <span class="gen"><b>{L_EMAIL_MSG}</b></span> 
	  <td class="row2"><span class="gen"> <textarea name="message" rows="15" cols="35" style="width:550px; height: 260px;" tabindex="3" class="post">{MESSAGE}</textarea></span></td>
	</tr>
	<tr> 
	  <td class="catBottom" align="center" colspan="2"><input type="submit" value="{L_EMAIL}" name="submit" class="mainoption"></td>
	</tr>
	<!-- END form -->
	<!-- BEGIN preview -->
	<tr> 
	  <td class="row1" align="right">{L_USERS_LANGUAGE}</td>
	  <td class="row2" align="left"><b>{PREVIEW_LANGUAGE}</b></td>
	</tr>
	<tr> 
	  <td class="row1" align="right">{L_PLAIN_HTML}</td>
	  <td class="row2"><b>{PREVIEW_HTML}</b></td>
	</tr>
	<tr> 
	  <td class="row1" align="right">{L_EMAIL_SUBJECT}</td>
	  <td class="row2"><b>{SUBJECT}</b></td>
	</tr>
	<!-- BEGIN emails -->
	<tr> 
	  <td class="row1" align="center" colspan="2">{preview.emails.EMAILS}</td>
	</tr>
	<!-- END emails -->
	<!-- BEGIN message -->
	<tr> 
	  <td class="row3" align="center" colspan="2">{L_EMAIL_MSG}</span></td>
	</tr>
	<tr>
	  <td class="row1" align="left" colspan="2">{MESSAGE_PREVIEW}</td>
	</tr>
	<!-- END message -->
	<tr> 
	  <td class="catBottom" align="center" colspan="2"><input type="hidden" name="send" value="1">
	  {S_PREVIEW_FIELDS}
	  <input type="submit" value="{L_IMPROVE}" name="improve" class="liteoption"> 
	  <input type="submit" value="{L_SEND}" name="submit" class="mainoption"></td>
	</tr>
	<!-- END preview -->
</table>
</form>
