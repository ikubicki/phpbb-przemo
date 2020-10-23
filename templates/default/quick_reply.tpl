{% for _quick_reply in quick_reply %}
<script src="/js/ckeditor/ckeditor.js"></script>
<br />
<form action="{{ _quick_reply.POST_ACTION }}" method="post" name="post">
<table border="0" cellpadding="5" cellspacing="1" width="100%" class="forumline posting">
   <tr>
      <th><span class="cattitle">{{ L_QUICK_REPLY }}</span></th>
   </tr>
   {% if _quick_reply.user_logged_out %}
   <tr>
      <td class="row1" width="100%">
         {{ L_USERNAME }}:
         <input type="text" tabindex="1" name="username" maxlength="25" />
      </td>
   </tr>
   {% endif %}
   <tr>
      <td class="row1">
				<textarea id="message" name="message" tabindex="3"></textarea>
				<script type="text/javascript">
					CKEDITOR.replace('message');
				</script>
            <br />
				{% if expire_box %}
				 {{ L_EXPIRE_Q }} <select class="post" name="msg_expire">
					<option value="0" class="genmed">0</option>
					<option value="1" class="genmed">1</option>
					<option value="2" class="genmed"{{ EXPIRE_2_SELECTED }}>2</option>
					<option value="3" class="genmed">3</option>
					<option value="4" class="genmed">4</option>
					<option value="5" class="genmed">5</option>
					<option value="6" class="genmed">6</option>
					<option value="7" class="genmed">7</option>
					<option value="14" class="genmed">14</option>
					<option value="30" class="genmed">30</option>
					<option value="90" class="genmed">90</option>
					</select> {{ L_DAYS }}
				{% endif %}
      <br />
      <hr />
      <span class="gen">
      {% for _user_logged_in in _quick_reply.user_logged_in %}
	   <h3>{{ L_OPTIONS }}</h3>
      <label><input type="checkbox" name="attach_sig" {{ _user_logged_in.ATTACH_SIGNATURE }}>{{ L_ATTACH_SIGNATURE }}</label><br />
      <label><input type="checkbox" name="notify" {{ _user_logged_in.NOTIFY_ON_REPLY }}>{{ L_NOTIFY_ON_REPLY }}</label>
      {% endfor %}
      {% if _quick_reply.switch_lock_topic %}
      <br /><label><input type="checkbox" name="lock">{{ L_LOCK_TOPIC }}</label>
      {% endif %}
      {% if _quick_reply.switch_unlock_topic %}
      <br /><label><input type="checkbox" name="unlock">{{ L_UNLOCK_TOPIC }}</label>
      {% endif %}
      {% if _quick_reply.switch_no_split_post %}
      <br /><label><input type="checkbox" name="nosplit">{{ L_NO_SPLIT_POST }}</label>
      {% endif %}
      </td>
   </tr>
   <tr>
      <td class="submit" colspan="2">
         {{ S_HIDDEN_FIELDS }}
         <input type="hidden" name="mode" value="reply" />
         <input type="hidden" name="disable_html" value="1" />
         <input type="hidden" name="t" value="{{ _quick_reply.TOPIC_ID }}" />
         <input type="hidden" name="last_msg" value="{{ _quick_reply.LAST_MESSAGE }}" />
         <input type="submit" name="preview" class="mainoption" value="{{ L_PREVIEW }}" />
         <input type="submit" name="post" class="mainoption" value="{{ L_SUBMIT }}" />
      </td>
   </tr>
</table>
</form>
{% endfor %}