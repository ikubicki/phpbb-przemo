<br />
{% for _catrow in catrow %}
	{% for _tablehead in _catrow.tablehead %}
		
		{% for _br in _tablehead.br %}
			<div id="hc_{{ _br.CAT_ID }}" class="visible">
			<script>forum.setCategoryClass('#hc_{{ _br.CAT_ID }}')</script>
		{% endfor %}
		<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
		<tr>
			<th colspan="{{ _tablehead.INC_SPAN }}" width="100%" nowrap="nowrap">
			{% for _br in _tablehead.br %}
				<a href="javascript:void(0)" onclick="forum.toggleCategory('#hc_{{ _tablehead.CAT_ID }}', this)" class="toggleCategory">&nbsp;</a>
			{% endfor %}
			<a href="{{ _tablehead.U_FORUM }}" class="cattitle">{{ _tablehead.L_FORUM }}</a>
			{% if _tablehead.CAT_DESCRIPTION %}
				<span class="gensmall description">{{ _tablehead.CAT_DESCRIPTION }}</span>
			{% endif %}
			</th>
			<th width="50" class="label">{{ L_TOPICS }}</td>
			<th width="50" class="label">{{ L_POSTS }}</td>
			<th width="150" class="label">{{ L_LASTPOST }}</td>
		</tr>
	{% endfor %}
	{% for _cathead in _catrow.cathead %}
		<tr class="row">
		{% if _cathead.inc %}
			<td class="spacer">&nbsp;</td>
		{% endif %}
			<td class="{{ _cathead.CLASS_CAT }}" width="100%" colspan="{{ _cathead.INC_SPAN }}">
				<a href="{{ _cathead.U_VIEWCAT }}" class="cattitle">{{ _cathead.CAT_TITLE }}</a>
		{% if _cathead.CAT_DESCRIPTION %}
				<span class="gensmall description">{{ _cathead.CAT_DESCRIPTION }}</span>
		{% endif %}
			</td>
			<td class="{{ _cathead.CLASS_CAT }} label" width="50">{{ L_TOPICS }}</td>
			<td class="{{ _cathead.CLASS_CAT }} label" width="50">{{ L_POSTS }}</td>
			<td class="{{ _cathead.CLASS_CAT }} label" width="150">{{ L_LASTPOST }}</td>
		</tr>
	{% endfor %}

	{% for _forumrow in _catrow.forumrow %}
		<tr class="row">
		{% if forumrow.inc %}
			<td class="spacer">&nbsp;</td>
		{% endif %}
			<td class="row1" align="center" valign="middle"><img src="{{ _forumrow.FORUM_FOLDER_IMG }}" alt="" title="{{ _forumrow.L_FORUM_FOLDER_ALT }}"></td>
			<td class="row1" width="100%" height="50" colspan="{{ _forumrow.INC_SPAN }}">
				<span class="forumlink"><a href="{{ _forumrow.U_VIEWFORUM }}" class="forumlink"{{ _forumrow.FORUM_COLOR }}>{{ _forumrow.FORUM_NAME }}</a></span>
				<span class="gensmall">&nbsp;&nbsp;{{ _forumrow.LAST_POSTMSG }}<br /></span>
				<span class="genmed">{{ _forumrow.FORUM_DESC }}<br /></span>
				<span class="gensmall">
				{{ _forumrow.L_MODERATOR }} {{ _forumrow.MODERATORS }}
				{% if _forumrow.links %}
				{{ _forumrow.links.L_LINKS }} {{ _forumrow.links.LINKS }}
				{% endif %}
				</span>
			</td>
		{% if _forumrow.forum_link_no %}
			<td class="row1" align="center" valign="middle" height="50"><span class="gensmall">{{ _forumrow.TOPICS }}</span></td>
			<td class="row1" align="center" valign="middle" height="50"><span class="gensmall">{{ _forumrow.POSTS }}</span></td>
			<td class="row1" align="center" valign="middle" height="50" nowrap="nowrap">
				<span class="gensmall">{{ _forumrow.LAST_POST }}{{ _forumrow.NUM_NEW_TOPICS }}{{ _forumrow.NUM_NEW_POSTS }}</span>
			</td>
		{% endif %}
		{% if _forumrow.forum_link %}
			<td class="row1" align="center" valign="middle" height="50" colspan="3">
				<span class="gensmall">{{ _forumrow.forum_link.HIT_COUNT }}</span>
			</td>
		{% endif %}
		</tr>
	{% endfor %}

	{% if _catrow.tablefoot %}
	</table>
	{% for _br_bottom in _catrow.br_bottom %}
	</div>
	<script>
	<!--
	if(GetCookie('hc3_{{ _br_bottom.CAT_ID }}') == '2') ShowHide('hc_{{ _br_bottom.CAT_ID }}', 'hc2_{{ _br_bottom.CAT_ID }}', 'hc3_{{ _br_bottom.CAT_ID }}');
	//-->
	</script>
	{{ catrow.tablefoot.br_bottom.BR }}
	{% endfor %}
	{% endif %}
{% endfor %}
