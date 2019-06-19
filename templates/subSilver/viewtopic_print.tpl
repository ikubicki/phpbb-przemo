<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html dir="{S_CONTENT_DIRECTION}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}">
<style type="text/css">
<!--
/* General page style. The scroll bar colours only visible in IE5.5+ */
body { background-color:		#FFFFFF; }

/* General font families for common tags */
font,th,td,p			{ font-family: Verdana, Arial, Helvetica, sans-serif }
a:link,a:active,a:visited	{ color : #006699; }
p, td			{ font-size : 11px; color : #000000; }
a:hover			{ text-decoration: underline; color : #DD6900; }
hr				{ height: 0px; border: solid #D1D7DC 0px; border-top-width: 1px; }


/* Main table cell colours and backgrounds */
td.row1 { background-color: #FFFFFF; }
td.row2 { background-color: #FFFFFF; }
td.row3 { background-color: #FFFFFF; }


/* General text */
.gen						{ font-size : 12px; }
.genmed					{ font-size : 11px; }
.gensmall					{ font-size : 10px; }
.gen,.genmed,.gensmall			{ color : #000000; }
a.gen,a.genmed,a.gensmall			{ color: ##000000; text-decoration: none; }
a.gen:hover,a.genmed:hover,a.gensmall:hover	{ color: ##000000; text-decoration: underline; }

/* The register, login, search etc links at the top of the page */
.mainmenu		{ font-size : 11px; color : #000000 }
a.mainmenu		{ text-decoration: none; color : ##000000; }
a.mainmenu:hover	{ text-decoration: underline; color : ##000000; }

/* Forum category titles */
.cattitle		{ font-weight: bold; font-size: 12px ; letter-spacing: 1px; color : ##000000}
a.cattitle		{ text-decoration: none; color : ##000000; }
a.cattitle:hover	{ text-decoration: underline; }

/* Forum title: Text and link to the forums used in: index.php */
.forumlink		{ font-weight: bold; font-size: 12px; color : ##000000; }
a.forumlink		{ text-decoration: none; color : ##000000; }
a.forumlink:hover	{ text-decoration: underline; color : ##000000; }

/* Used for the navigation text, (Page 1,2,3 etc) and the navigation bar when in a forum */
.nav		{ font-weight: bold; font-size: 11px; color : #000000;}
a.nav	{ text-decoration: none; color : ##000000; }
a.nav:hover	{ text-decoration: underline; }

/* titles for the topics: could specify viewed link colour too */
.topictitle,h1,h2	{ font-weight: bold; font-size: 11px; color : #000000; }
a.topictitle:link	{ text-decoration: none; color : ##000000; }
a.topictitle:visited	{ text-decoration: none; color : ##000000; }
a.topictitle:hover	{ text-decoration: underline; color : ##000000; }

/* Name of poster in viewmsg.php and viewtopic.php and other places */
.name { font-size : 11px; color : #000000; text-decoration: none}

/* Location, number of posts, post date etc */
.postdetails		{ font-size : 10px; color : #000000; }

/* The content of the posts (body of text) */
.postbody		{ font-size : 11px; line-height: 18px }
a.postlink:link	{ text-decoration: none; color : ##000000 }
a.postlink:visited	{ text-decoration: none; color : ##000000; }
a.postlink:hover	{ text-decoration: underline; color : ##000000 }

/* Quote & Code blocks */
.code {
font-family:		'Courier New', sans-serif; font-size: 11px; color: #000000;
background-color:	#FAFAFA; border: #D1D7DC; border-style: solid;
border-left-width:	1px; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px;
}

.quote {
font-family:		Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: ##000000; line-height: 125%;
background-color:	#FAFAFA; border: #D1D7DC; border-style: solid;
border-left-width:	1px; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px;
}

/* Copyright and bottom info */
.copyright		{ font-size : 10px; color: ##000000; font-family: Verdana, Arial, Helvetica, sans-serif; }
a.copyright		{ text-decoration: none; color : ##000000; }
a.copyright:hover	{ text-decoration: underline; color : ##000000; }

-->
</style>
<title>{PAGE_TITLE}</title>
</head>
<body bgcolor="#FFFFFF">
<table width="100%" bgcolor="#FFFFFF">
	<tr>
		<td>
			<table width="607" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<table width="100%" border="0">
							<tr>
								<td align="center" colspan="3"><!-- BEGIN forum_row -->{forum_row.TOPIC_ID}<!-- END forum_row --></td>
							</tr>
							<tr>
								<td align="right" width="40"> </td>
								<td align="left"><center><b><font size="3">{SITENAME}</font></b><br>{SITE_DESCRIPTION}</center></td>
								<td align="right" width="40"><img src="images/print.gif" border="0" onClick="window.print();" style="cursor: pointer;"></td>
							</tr>
						</table>
						<hr>
						<center>
						<b>{FORUM_NAME} - {TOPIC_TITLE}</b><br>
						</center>

						<!-- BEGIN postrow -->
						<hr><b>{postrow.POSTER_NAME}</b> - {postrow.POST_DATE}<br>{postrow.POST_SUBJECT}<hr><span class="postbody">{postrow.MESSAGE}</span>
						<!-- END postrow -->
						<hr>
					</td>
				</tr>
				<tr><td align="right"><br>{PAGINATION}</td></tr>
			</table>
		</td>
	</tr>
</table>
<br>
<table width="100%">
	<tr>
		<td align="center"><span class="gensmall">Powered by <a href="http://www.phpbb.com" target="_blank" class="copyright">phpBB</a> modified by <a href="http://www.przemo.org/phpBB2/" class="copyright" target="_blank">Przemo</a> &copy; 2003 phpBB Group</span></td>
	</tr>
</table>
</body>
</html>