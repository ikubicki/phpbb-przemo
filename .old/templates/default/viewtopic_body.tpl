{{ include('overall_header.tpl') }}

<script type="text/javascript">
var img_addr = '{{ IMG_ADDR }}';
</script>

<script src="/js/lightbox/lightbox.js"></script>
<style>@import url('/js/lightbox/lightbox.css')</style>
<script src="/modules/votes/index.js"></script>
<style>@import url('modules/votes/style.css')</style>
<script src="/modules/avatars/index.js"></script>

<br>
<table>
   <tr> 
      <td class="right">
         {{ PAGINATION | raw }}
         <a href="{{ U_VIEW_OLDER_TOPIC }}" class="nav">{{ L_VIEW_PREVIOUS_TOPIC }}</a>
         &laquo;&raquo; 
         <a href="{{ U_VIEW_NEWER_TOPIC }}" class="nav">{{ L_VIEW_NEXT_TOPIC }}</a>
      </td>
   </tr>
</table>

<h1 {{ TOPIC_COLOR }}>{{ TOPIC_TITLE }} {{ U_IGNORE_STATUS | raw }}</h1>
<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0">
	{% for _topic_action in topic_action  %}
	<tr align="right">
	<th align="left" colspan="2" nowrap="nowrap">
      <span class="gensmall">
         {{ _topic_action.TOPIC_ACTION }}
         {{ _topic_action.L_WHO }}: <a href="{{ _topic_action.PROFILE_URL }}"><b>{{ _topic_action.USERNAME }}</b></a><br />
         {{ _topic_action.DATE }}
	{% for _topic_action_delete in _topic_action.topic_action_delete %}   
	      <b><a href="{{ _topic_action_delete.U_DELETE_ACTION }}" title="{{ _topic_action_delete.DELETE_TITLE }}">X</a></b>
	{% endfor %}
	   </span>
   </th>
   </tr>
	{% endfor %}
   {{ POLL_DISPLAY | raw }} 
   <tr>
      <th class="label">{{ L_AUTHOR }}</th>
      <th class="label">{{ L_MESSAGE }}</th>
   </tr>
   {% for _moderate in moderate %}
   <tr>
      <td colspan="2"><form action="{{ _moderate.S_MODERATE_ACTION }}" method="post"></td>
   </tr>
   {% endfor %}
   {% for _postrow in postrow %}
   {% for _post_tree in _postrow.post_tree %}
	<tr>
		<td valign="top" colspan="2" {% if _postrow.signature %}rowspan="2"{% endif %}>
			<table width="100%">
				<tr>
					<td class="{{ _postrow.ROW_CLASS }}" width="{{ _post_tree.TREE_WIDTH }}"></td>
					<td>
						<table class="forumline">
   {% endfor %}
   <tr>
      <td align="left" valign="top" class="{{ _postrow.ROW_CLASS }}" nowrap="nowrap" width="150" {% if _postrow.signature %}rowspan="2"{% endif %}>
         <a name="{{ _postrow.U_POST_ID }}"></a>
         <div style="text-align: center">
            <script>avatars.show({user: {{ _postrow.POSTER_ID }}, class: '{{ _postrow.GENDER_CLASS }}', style: 'border-color: {{ _postrow.POSTER_COLOR }}'})</script>
            <b style="color: {{ _postrow.POSTER_COLOR }}">{{ _postrow.POSTER_NAME_RAW }}</b><br />
            {{ _postrow.POSTER_RANK }}{{ _postrow.CUSTOM_RANK }}
            <span class="posts">{{ _postrow.POSTER_POSTS_COUNT }}</span>
         </div>
		 <br>
         <span class="postdetails">
            
         {% for _custom_fields_avatar in _postrow.custom_fields_avatar %}
         {{ _custom_fields_avatar.DESC }}{{ _custom_fields_avatar.FIELD }}<br />
         {% endfor %}
         </span>
         {% for _warnings in _postrow.warnings %}
         <table cellspacing="0" cellpadding="0" border="0">
            <tr>
               <td align="left"><span class="postdetails">{{ _warnings.WARNINGS }}:</span></td>
            </tr>
            <tr> 
               <td>
                  <table cellspacing="0" cellpadding="0" border="0">
                     <tr>
                        <td><img src="images/level_mod/exp_bar_left.gif" alt="" width="2" height="9"></td>
                        <td><img src="images/level_mod/exp_bar_fil.gif" alt="" width="{{ _warnings.POSTER_W_WIDTH }}" height="9"></td>
                        <td><img src="images/level_mod/exp_bar_fil_end.gif" alt="" width="1" height="9"></td>
                        <td><img src="images/level_mod/level_bar_emp.gif" alt="" width="{{ _warnings.POSTER_W_EMPTY }}" height="9"></td>
                        <td nowrap="nowrap">
                           <img src="images/level_mod/level_bar_right.gif" alt="" width="1" height="9" align="middle"/>
                           {{ _warnings.HOW }}/{{ _warnings.WRITE }}/{{ _warnings.MAX }}
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
         </table>
         {% endfor %}
      </td>
      <td class="{{ _postrow.ROW_CLASS }}" width="100%" height="100%" valign="top">
         <table width="100%" style="height: 100%;" border="0" cellspacing="0" cellpadding="0">
            <tr>
               <td valign="top" align="left">
                  <a href="{{ _postrow.U_MINI_POST }}" class="icon post">&nbsp;</a>
                  {{ L_POSTED }}: {{ _postrow.POST_DATE }}
                  {% for _custom_fields_post in _postrow.custom_fields_post %}
                  <br /><small>{{ _custom_fields_post.DESC }}{{ _custom_fields_post.FIELD }}</small>
                  {% endfor %}
               </td>
               <td class="top right" id="voting_{{ _postrow.U_POST_ID }}">
                  <script>votes.show({selector: '#voting_{{ _postrow.U_POST_ID }}', post: '{{ _postrow.U_POST_ID }}'})</script>
               </td>
            </tr>
            <tr>
               <td colspan="2"><br /></td>
            </tr>
            <tr>
               <td class="top" colspan="2">
                  <span class="postbody" author="{{ _postrow.POSTER_NAME_ESCAPED }}">
                     {{ _postrow.MESSAGE | raw }}
                     {{ _postrow.ATTACHMENTS }}
                  </span>
               </td>
            </tr>
			{% for _post_edited in _postrow.post_edited %}
			<tr>
				<td colspan="2" align="right">
               <small>{{ _postrow.EDITED_MESSAGE | raw }} {{ _post_edited.VIEW_POST_HISTORY }}</small>
            </td>
			</tr>
			{% endfor %}
         </table>
      </td>
   </tr>
   {% if _postrow.signature %}
   <tr>
      <td class="{{ _postrow.ROW_CLASS }} signature" height="1%">
         <span class="postbody">{{ _postrow.SIGNATURE }}{{ _postrow.SIG_IMAGE }}</span>
      </td>
   </tr>
   {% endif %}
	<tr>
		<td class="{{ _postrow.ROW_CLASS }} left postactions">
			{% for _top in _postrow.top %}
			{{ _top.U_TOP | raw }}
			{% endfor %}
		</td>
		<td class="{{ _postrow.ROW_CLASS }}" width="100%" valign="top" nowrap="nowrap">
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
				<tr>
					<td class="postactions">
                  {{ _postrow.U_PROFILE | raw }}
                  {{ _postrow.U_MESSAGE | raw }}
                  {{ _postrow.U_EMAIL | raw }}
                  {{ _postrow.U_WEBSITE | raw }}
                  {{ _postrow.U_IGNORE | raw }}
                  {{ _postrow.U_QUOTE | raw }}
                  {{ _postrow.U_EDIT | raw }}
                  {{ _postrow.U_DELETE | raw }}
                  {{ _postrow.U_IP | raw }}
                  {{ _postrow.U_REPORT | raw }}
                  {% if _postrow.POST_EXPIRE %}
                  <br /><small>{{ _postrow.POST_EXPIRE }}</small>
                  {% endif %}
               </td>
					<td valign="top" align="left" width="177">
						<table>
							<tr>
								<td>&nbsp;</td>
								<td nowrap="nowrap">
									{% for _custom_fields_upost in _postrow.custom_fields_upost %}
									{{ _custom_fields_upost.DESC }}{{ _custom_fields_upost.FIELD }}
									{% endfor %}								
								</td>
							</tr>
						</table>
					</td>
					<td width="100%" align="right">
                  <span class="nav">
                     {% if _postrow.post_moderate %}
                     {{ L_ACCEPT }} <input type="checkbox" name="accept_post[]" value="{{ _postrow.U_POST_ID }}">
                     {{ L_REJECT }} <input type="checkbox" name="reject_post[]" value="{{ _postrow.U_POST_ID }}">
                     {% endif %}
                     {{ _postrow.NEW_POST }}
                     {{ _postrow.POST_REPLY_IMG }}
                     {% for I_USER_AGENT in _postrow.I_USER_AGENTS %}
                        {{ I_USER_AGENT | raw }}
                     {% endfor %}
                  </span>
					</td>
				</tr>
			</table>
      </td>
   </tr>

	  {% for _post_tree in _postrow.post_tree %}

						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	  {% endfor %}


   {% endfor %}
   {% for _moderate in moderate %}
   <tr>
      <td class="submit" align="right" colspan="2"><input type="submit" class="liteoption" value="{{ _moderate.L_ACCEPT_REJECT_POST }}"></form></td>
   </tr>
   {% endfor %}
   <tr align="center">
      <td class="submit" colspan="2">
         <form method="post" action="{{ S_POST_DAYS_ACTION }}">
         <table cellspacing="0" cellpadding="0" align="center" border="0">
            <tr>
               <td class="center">
                  {{ L_DISPLAY_POSTS }}: {{ S_SELECT_POST_DAYS | raw }}
                  {{ S_SELECT_POST_ORDER | raw }}
                  <input type="submit" value="{{ L_GO }}" name="submit" />
               </td>
            </tr>
         </table>
	      </form>
      </td>
   </tr>
</table>

<script>votes.load({topic: '{{ TOPIC_ID }}'})</script>

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
   <tr>
      <td colspan="2" align="right" valign="middle" nowrap="nowrap">
         <span class="nav">
            {{ PAGINATION | raw }}
	  {% for _next_unread_posts in next_unread_posts %}
	         <a href="{{ _next_unread_posts.U_TOPIC_NEXT_UNREAD_POSTS }}">{{ _next_unread_posts.L_TOPIC_NEXT_UNREAD_POSTS }}</a>
	  {% endfor %}
	      </span>
      </td>
   </tr>
   <tr> 
      <td align="left" valign="middle" nowrap>
         <span class="nav">
            <a href="{{ U_POST_REPLY_TOPIC }}"><img src="{{ REPLY_IMG }}" border="0" alt="{{ L_POST_REPLY_TOPIC }}" title="{{ L_POST_REPLY_TOPIC }}" /></a>
         </span>
      </td>
      <td align="right" valign="top" nowrap>
         <span class="nav">{{ S_TOPIC_ADMIN | raw }}</span>
      </td>
   </tr>
</table>

<table>
   <tr> 
      <td class="left">
         {{ S_AUTH_LIST | raw }}
      </td>
      <td class="right">
         {{ TELLFRIEND_BOX | raw }}
         <a href="{{ U_PRINT }}">{{ L_PRINT }}</a>
         {{ TOPIC_VIEW_IMG | raw }}
         {{ S_WATCH_TOPIC | raw }}
         {{ U_MARK_TOPIC_UNREAD | raw }}
         {{ U_MARK_TOPIC_READ | raw }}
         <br />
         <br />
         {{ JUMPBOX | raw }}
      </td>
   </tr>
</table>
<div style="display:none" id="resizemod"></div>
{{ QUICKREPLY_OUTPUT | raw }}

<script>forum.selection('.postbody')</script>
<style>
@import url('/modules/bbcode/style.css');
</style>
<script src="/modules/bbcode/index.js"></script>
<script src="/modules/markdown/index.js"></script>
<script type="text/javascript">
   $('span.postbody').each((i, el) => {

      $(el).html(bbcode.parse($(el).html()))
      //message.text = markdown.parse(message.text)
   })
</script>

{{ include('overall_footer.tpl') }}