<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}">
 <meta http-equiv="Content-Style-Type" content="text/css">
 <title>ShoutBox</title>
 <link rel="stylesheet" href="templates/subSilver/{T_HEAD_STYLESHEET}" type="text/css">
</head>
<body bgcolor="#E5E5E5" text="#000000" link="#006699" vlink="#5493B4" onload="window.scrollTo(0,99999);" style="padding: 0px; margin: 0px;">
<!-- BEGIN shoutrow -->
<table cellpadding="2" cellspacing="0" border="0" class="table0" width="100%">
	<tr>
		<td class="{shoutrow.ROW_CLASS}" width="100%"><span class="gensmall" style="font-size:9px; font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif">{shoutrow.DELMSG} {shoutrow.EDITMSG} {shoutrow.DATE}</span><span class="gensmall"> {shoutrow.NAME}: {shoutrow.MSG}</span></td>
	</tr>
</table>
<!-- END shoutrow -->
<script language="JavaScript" type="text/javascript"> 
<!-- 
    if (window.parent && window.parent.document && window.parent.document.post) 
        window.parent.document.post.message.value = ''; 
//--> 
</script> 
</body>
</html>