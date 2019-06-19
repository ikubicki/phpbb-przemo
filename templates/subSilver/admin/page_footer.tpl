
<!-- 

	Please note that the following copyright notice
	MUST be displayed on each and every page output
	by phpBB. You may alter the font, colour etc. but 
	you CANNOT remove it, nor change it so that it be, 
	to all intents and purposes, invisible. You may ADD 
	your own notice to it should you have altered the 
	code but you may not replace it. The hyperlink must 
	also remain intact. These conditions are part of the 
	licence this software is released under. See the 
	LICENCE and README files for more information.

	The phpBB Group : 2001

//-->

<table width="100%">
	<tr>
		<td align="center">
			<span class="copyright">Powered by <a href="http://www.phpbb.com" target="_blank" class="copyright">phpBB</a> modified v{PHPBB_VERSION} by <a href="http://www.przemo.org/phpBB2/" class="copyright" target="_blank">Przemo</a> &copy; 2003 phpBB Group<br>{TRANSLATION_INFO}</span>
		</td>
	</tr>
</table>
<!-- BEGIN pagina_pages -->
<div id="s_pagina" style="display: none; background: {T_TR_COLOR1}; border: solid {T_TR_COLOR3} 1px; width: 50px; height: 37px; position: absolute; filter: alpha(opacity=90); -moz-opacity: 0.90;" >
	<table align="center" cellspacing="0">
		<tr>
			<td align="right" valign="top">
				<div style="display: inline; font-size: 8px; width: 10px; height: 6px; cursor: pointer; margin: 0px;" align="right" onclick="document.getElementById('s_pagina').style.display='none';"><b>X</b></div>
			</td>
		</tr>
		<tr>
			<td align="center">
				<form action="{BASE_URL}" method="post"><select name="start" onchange="this.form.submit();">{pagina_pages.OPTIONS}</select></form>
			</td>
		</tr>
	</table>
</div>
<!-- END pagina_pages -->
</body>
</html>