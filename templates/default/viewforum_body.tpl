{{ include('overall_header.tpl') }}

{{ BOARD_INDEX | raw }}

<h1>{{ FORUM_NAME }}
	{% if FORUM_DESC %}
	<small class="desc">{{ FORUM_DESC }}</small>
	{% endif %}
</h1>

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td class="left nowrap" width="90">
			{{ U_NEW_TOPIC | raw }}
		</td>
		<td align="left" valign="bottom"><span class="gensmall">{{ L_MODERATOR }}: {{ MODERATORS }}<br>{{ LOGGED_IN_USER_LIST }}</span></td>
		<td align="right" valign="bottom" nowrap="nowrap">
			<b>{{ PAGINATION | raw }}</b>
			<a href="{{ U_MARK_READ }}">{{ L_MARK_TOPICS_READ }}</a>
{% if U_SHOW_IGNORE %}
			<br />{{ U_SHOW_IGNORE | raw }}
{% endif %}
		</td>
	</tr>
</table>

{% for _ignore_form in ignore_form %}
<script language="JavaScript" type="text/javascript">
function setCheckboxes(the_form, do_check)
{
	var elts = (typeof(document.forms[the_form].elements['list_ignore[]']) != 'undefined') ? document.forms[the_form].elements['list_ignore[]'] : document.forms[the_form].elements = '';
	var elts_cnt = (typeof(elts.length) != 'undefined') ? elts.length : 0;
	if (elts_cnt)
	{
		for (var i = 0; i < elts_cnt; i++)
		{
			if (do_check == "invert")
			{
				elts[i].checked == true ? elts[i].checked = false : elts[i].checked = true;
			}
			else
			{
				elts[i].checked = do_check;
			}
		}
	}
	else
	{
		elts.checked = do_check;
	}
	return true; }
</script>
<form method="post" action="{{ _ignore_form.U_IGNORE_TOPICS }}" name="ignoreform">
{% endfor %}
{% if switch_show_hide %}
<div id="imp_topics_{{ FORUM_ID }}" style="display: ''; position: relative;">
{% endif %}
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<th colspan="{{ SPAN_I }}" class="label center" {% if switch_show_hide %} onclick="javascript:ShowHide('imp_topics_{{ FORUM_ID }}','imp_topics2_{{ FORUM_ID }}','imp_topics3_{{ FORUM_ID }}');" style="cursor: pointer" title="{{ L_VHIDE }}"{% endif %}>{{ L_TOPICS }}</th>
		<th width="50" class="label center">{{ L_VOTES }}</th>		
		<th width="50" class="label center">{{ L_REPLIES }}</th>
		<th width="100" class="label center">{{ L_AUTHOR }}</th>
		<th width="50" class="label center">{{ L_VIEWS }}</th>
		<th width="150" class="label center">{{ L_LASTPOST }}</th>
	</tr>
	{% if important_topics %}
	<tr>
		<td colspan="{{ SPAN_J }}"><span class="nav">&bull; {{ L_IMPORTANT_TOPICS }}</span></td>
	</tr>
	{% endif %}
	{% for _topicrow in topicrow %}
	{% if _topicrow.normal_topics_row %}
	<tr>
		<td colspan="{{ SPAN_J }}"><span class="nav">&bull; {{ L_TOPICS }}</span></td>
	</tr>
	{% endif %}
	{% if normal_topics %}
</table>
<br>
</div>
<div id="imp_topics2_{{ FORUM_ID }}" style="display: none; position: relative;">
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
		<th align="center" height="25" nowrap="nowrap" onclick="javascript:ShowHide('imp_topics_{{ FORUM_ID }}','imp_topics2_{{ FORUM_ID }}','imp_topics3_{{ FORUM_ID }}');" style="cursor: pointer">&nbsp;{{ L_TOPICS }}&nbsp;</th>
	</tr>
</table>
<br>
</div>
<script language="javascript" type="text/javascript">
if(GetCookie('imp_topics3_{{ FORUM_ID }}') == '2') ShowHide('imp_topics_{{ FORUM_ID }}', 'imp_topics2_{{ FORUM_ID }}', 'imp_topics3_{{ FORUM_ID }}');
</script>

<table class="forumline">
	<tr>
		<th colspan="{{ SPAN_I }}" class="label center">{{ L_NORMAL_TOPICS }}</th>
		<th width="50" class="label center">{{ L_VOTES }}</th>
		<th width="50" class="label center">{{ L_REPLIES }}</th>
		<th width="100" class="label center">{{ L_AUTHOR }}</th>
		<th width="50" class="label center">{{ L_VIEWS }}</th>
		<th width="150" class="label center">{{ L_LASTPOST }}</th>
	</tr>
	{% endif %}
	<tr class="topic row topic-{{ _topicrow.TOPIC_ID }} {{ _topicrow.CLASS }}">
		<td width="20"><img src="{{ _topicrow.TOPIC_FOLDER_IMG }}" alt=""></td>
		{% if _topicrow.icons %}
		<td width="16">{{ _topicrow.ICON }}</td>
		{% endif %}
		<td width="100%" class="left">
			{{ _topicrow.NEWEST_POST_IMG }}
			{{ _topicrow.TOPIC_ATTACHMENT_IMG }}
			{{ _topicrow.TOPIC_TYPE }}
			<span class="participated">💬</span>
			<a href="{{ _topicrow.U_VIEW_TOPIC }}" class="title" style="color:{{ _topicrow.TOPIC_COLOR }}">{{ _topicrow.TOPIC_TITLE }}</a>
			{% if _topicrow.TOPIC_TITLE_E %}
		 	<br /><small>{{ _topicrow.TOPIC_TITLE_E }}</small>
			 {% endif %}
			 {% if _topicrow.TOPIC_EXPIRE %}
			<br /><small>{{ _topicrow.TOPIC_EXPIRE }}</small>
			{% endif %}
			{% if _topicrow.GOTO_PAGE %}
		 	<br /><small{{ _topicrow.GOTO_PAGE }}</small>
			{% endif %}
		</td>
		{% if _topicrow.ignore_checkbox %}
		<td class="right">
			<input type="checkbox" name="list_ignore[]" value="{{ _topicrow.TOPIC_ID }}" />
		</td>
		{% endif %}
		<td>{{ _topicrow.TOPIC_VOTES }}</td>
		<td>{{ _topicrow.REPLIES }}</td>
		<td>
			{{ _topicrow.TOPIC_TIME }}<br />
			{{ _topicrow.TOPIC_AUTHOR | raw }}
		</td>
		<td>{{ _topicrow.VIEWS }}</td>
		<td class="nowrap">
			{{ _topicrow.U_LAST_POST | raw }}
			{{ _topicrow.LAST_POST_TIME }}<br />
			{{ _topicrow.LAST_POST_AUTHOR | raw }}
		</td>
	</tr>
	{% endfor %}

	{% if switch_no_topics %}
	<tr>
		<td class="row1" colspan="{{ SPAN_J }}" height="30" align="center" valign="middle"><span class="gen">{{ L_NO_TOPICS }}</span></td>
	</tr>
	{% endif %}

</table>


<table class="forumline">
	<tr>
		<td class="submit left">
			<form method="post" action="{{ S_POST_DAYS_ACTION }}">
				{{ L_DISPLAY_TOPICS }}:
				{{ S_SELECT_TOPIC_DAYS | raw }}
				<input type="submit" class="liteoption" value="{{ L_GO }}" name="submit" />
			</form>
		</td>
		<td class="submit right">
{% for _ignore_form in ignore_form %}
			<a href="#" onclick="setCheckboxes('ignoreform', true); return false;">{{ _ignore_form.L_MARK_ALL }}</a>
			<input type="submit" name="ignore" class="liteoption" value="{{ _ignore_form.L_IGNORE_MARK }}"{% for _overlib in overlib %} onMouseOver="return overlib('<left>{{ _overlib.L_IGNORE_EXPLAIN }}</left>', ol_offsetx=-203, ol_offsety=8, CAPTION, '<center>{{ _ignore_form.L_IGNORE_MARK }}</center>')" onMouseOut="nd();"{% endfor %}>
			</form>
{% endfor %}
		</td>
	</tr>
</table>

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr>
		<td align="right" colspan="2" valign="middle" nowrap="nowrap"><span class="nav">{{ PAGE_NUMBER }}&nbsp;&nbsp;{{ PAGINATION | raw }}</span></td>
	</tr>
	<tr>
	
		<td align="left" valign="middle">{{ U_NEW_TOPIC | raw }}</td>
		<td align="right" nowrap="nowrap">&nbsp;
		{% if switch_search_for %}
		<form method="post" action="{{ SEARCH_ACTION }}" name="quicksearch">
			<input type="hidden" name="search_where" value="f{{ FORUM_ID }}">
			<input type="hidden" name="show_results" value="topics">
			<input type="hidden" name="search_terms" value="any">
			<input type="hidden" name="search_fields" value="all">
			<span class="gensmall">{{ L_SEARCH_FOR }}:</span> 
			<input class="post" onFocus="Active(this)" onBlur="NotActive(this)" type="text" name="search_keywords" value="" size="20" maxlength="150">&nbsp;<input type="submit" name="submit" value="{{ L_GO }}" class="liteoption">
		</form>
		{% endif %}
		</td>
	</tr>
</table>

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr>
		<td align="right">{{ JUMPBOX | raw }}</td>
	</tr>
</table>

<table width="100%" cellspacing="0" border="0" cellpadding="0">
	<tr>
		<td valign="top">
			<table cellspacing="3" cellpadding="0" border="0">
				<tr>
					<td style="padding-right:4px"><img src="{{ FOLDER_NEW_IMG }}" alt=""></td>
					<td class="gensmall">{{ L_NEW_POSTS }}</td>
					<td>&nbsp;&nbsp;</td>
					<td style="padding-right:4px"><img src="{{ FOLDER_IMG }}" alt=""></td>
					<td class="gensmall">{{ L_NO_NEW_POSTS }}</td>
					<td>&nbsp;&nbsp;</td>
					<td style="padding-right:4px"><img src="{{ FOLDER_GLOBAL_ANNOUNCE_IMG }}" alt=""></td>
					<td class="gensmall">{{ L_GLOBAL_ANNOUNCEMENT }}</td>
				</tr>
				<tr>
					<td style="padding-right:4px"><img src="{{ FOLDER_HOT_NEW_IMG }}" alt=""></td>
					<td class="gensmall">{{ L_NEW_POSTS_HOT }}</td>
					<td>&nbsp;&nbsp;</td>
					<td style="padding-right:4px"><img src="{{ FOLDER_HOT_IMG }}" alt=""></td>
					<td class="gensmall">{{ L_NO_NEW_POSTS_HOT }}</td>
					<td>&nbsp;&nbsp;</td>
					<td style="padding-right:4px"><img src="{{ FOLDER_ANNOUNCE_IMG }}" alt=""></td>
					<td class="gensmall">{{ L_ANNOUNCEMENT }}</td>
				</tr>
				<tr>
					<td class="gensmall"><img src="{{ FOLDER_LOCKED_NEW_IMG }}" alt=""></td>
					<td class="gensmall">{{ L_NEW_POSTS_LOCKED }}</td>
					<td>&nbsp;&nbsp;</td>
					<td style="padding-right:4px"><img src="{{ FOLDER_LOCKED_IMG }}" alt=""></td>
					<td class="gensmall">{{ L_NO_NEW_POSTS_LOCKED }}</td>
					<td>&nbsp;&nbsp;</td>
					<td style="padding-right:4px"><img src="{{ FOLDER_STICKY_IMG }}" alt=""></td>
					<td class="gensmall">{{ L_STICKY }}</td>
				</tr>
			</table>
		</td>
		<td align="right" nowrap="nowrap"><span class="gensmall">{{ S_AUTH_LIST | raw }}</span></td>
	</tr>
</table>

{{ include('overall_footer.tpl') }}