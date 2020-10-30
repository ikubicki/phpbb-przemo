   {{ ROTATE_BANNER_4 }}
   
   <center>{{ BANNER_BOTTOM }}</center>
   <br clear="all" />
   <span class="copyright">
      <a href="http://www.phpbb.com" target="_blank"><b>phpBB</b></a> by 
      <a href="http://www.przemo.org/phpBB2/" target="_blank"><b>przemo</b></a>
   </span>
   <span class="links">
	  <a href="{{ U_STAT }}" class="stats">{{ L_STATISTICS }}</a>
	  <a href="{{ U_MEMBERLIST }}" class="users">{{ L_MEMBERLIST }}</a>
	  <a href="{{ U_GROUP_CP }}" class="groups">{{ L_USERGROUPS }}</a>

{% for _disable_viewonline in disable_viewonline %}
{% if _disable_viewonline.staff %}
      <a href="{{ U_STAFF }}">{{ L_STAFF }}</a>
{% endif %}
{% if _disable_viewonline.warnings %}
      {{ U_WARNINGS }}
{% endif %}
{% endfor %}
	  <a href="javascript:void(0);" onclick="forum.iframe('{{ U_PREFERENCES }}')" onclick2="window.open('{{ U_PREFERENCES }}', 'WindowOpen', 'HEIGHT=500,resizable=yes,scrollbars=yes,WIDTH=380');">{{ L_PREFERENCES }}</a>
      {{ CLICK_HERE_TO_VIEW }}
   </span>
   <div style="float:right">
      <span class="copyright">{{ GENERATE_TIME }}</span>
   </div><br />&nbsp;</td></tr></table>{{ LOADING_FOOTER }}
   
{% if forum_thin %}
</td>
</tr>
</table>
</td>
</tr>
</table>
{% endif %}
{{ ROTATE_BANNER_5 }}
{% for _advert in advert %}
	</td>
		<td><img src="images/spacer.gif" border="0" height="1" width="2" alt=""></td>
		<td valign="top" width="{{ _advert.ADVERT_WIDTH }}" nowrap="nowrap" height="100%" class="bodyline">
			<table width="100%" cellspacing="0" cellpadding="2" border="0" style="height: 100%;">
				<tr>
					<td valign="top" width="100%" height="100%">{{ _advert.ADVERT }}</td>
				</tr>
			</table>
		</td>
		{% if _advert.advert_forum_thin %}
		<td width="100%"><img src="images/spacer.gif" border="0" height="1" width="100%" alt=""></td>
		{% endif %}
	</tr>
</table>
{% endfor %}
{% for _pagina_pages in pagina_pages %}
<div id="s_pagina" style="display: none; background: {{ T_TR_COLOR1 }}; border: solid {{ T_TR_COLOR3 }} 1px; width: 50px; height: 37px; position: absolute; filter: alpha(opacity=90); -moz-opacity: 0.90;" >
	<table align="center" cellspacing="0">
		<tr>
			<td align="right" valign="top">
				<div style="display: inline; font-size: 8px; width: 10px; height: 6px; cursor: pointer; margin: 0px;" align="right" onclick="document.getElementById('s_pagina').style.display='none';"><b>X</b></div>
			</td>
		</tr>
		<tr>
			<td align="center">
				<form action="{{ BASE_URL }}" method="post"><select name="start" onchange="this.form.submit();">{{ _pagina_pages.OPTIONS }}</select></form>
			</td>
		</tr>
	</table>
</div>
{% endfor %}
</body>
</html>
