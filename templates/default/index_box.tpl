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
			<th width="50" class="label center">{{ L_TOPICS }}</td>
			<th width="50" class="label center">{{ L_POSTS }}</td>
			<th width="150" class="label center">{{ L_LASTPOST }}</td>
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
			<td class="label center" width="50">{{ L_TOPICS }}</td>
			<td class="label center" width="50">{{ L_POSTS }}</td>
			<td class="label center" width="150">{{ L_LASTPOST }}</td>
		</tr>
	{% endfor %}

	{% for _forumrow in _catrow.forumrow %}
		<tr class="forum row forum-{{ _forumrow.FORUM_ID }}">
		{% if forumrow.inc %}
			<td class="spacer">&nbsp;</td>
		{% endif %}
			<td>
				<img src="{{ _forumrow.FORUM_FOLDER_IMG }}" alt="" title="{{ _forumrow.L_FORUM_FOLDER_ALT }}">
			</td>
			<td class="left" width="100%" height="50" colspan="{{ _forumrow.INC_SPAN }}">
				<a href="{{ _forumrow.U_VIEWFORUM }}" class="forumlink"{{ _forumrow.FORUM_COLOR }}>{{ _forumrow.FORUM_NAME }}</a>
				{% if _forumrow.FORUM_DESC %}
				<br /><small>{{ _forumrow.FORUM_DESC }}</small>
				{% endif %}
				{% if _forumrow.U_LAST_POSTMSG %}
				<br /><small><b>{{ _forumrow.L_LAST_POSTMSG }}:</b> {{ _forumrow.U_LAST_POSTMSG | raw }}</small>
				{% endif %}
				{% if _forumrow.MODERATORS %}
				<br /><small>{{ _forumrow.L_MODERATOR }} {{ _forumrow.MODERATORS }}</small>
				{% endif %}
				{% for _links in _forumrow.links %}
				<br /><small>{{ _links.LINKS | raw }}</small>
				{% endfor %}
			</td>
		{% if _forumrow.forum_link_no %}
			<td height="50">{{ _forumrow.TOPICS }}</td>
			<td height="50">{{ _forumrow.POSTS }}</td>
			<td height="50" class="nowrap"><small>
			{% if _forumrow.LAST_POST_TIME %}
				{{ _forumrow.U_LAST_POST | raw }} {{ _forumrow.LAST_POST_TIME }}<br />
				{{ _forumrow.LAST_POST_AUTHOR | raw }}
				{% if _forumrow.NUM_NEW_TOPICS %}
				<br /><small>{{ _forumrow.NUM_NEW_TOPICS }}</small>
				{% endif %}
				{% if _forumrow.NUM_NEW_POSTS %}
				<br /><small>{{ _forumrow.NUM_NEW_POSTS }}</small>
				{% endif %}
			{% else %}
				--
			{% endif %}
			</small></td>
		{% endif %}
		{% if _forumrow.forum_link %}
			<td height="50" colspan="3">
				{{ _forumrow.forum_link.HIT_COUNT }}
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
