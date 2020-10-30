<!-- BEGIN quick_reply -->
<script src="/js/ckeditor/ckeditor.js"></script>
<br />
<form action="{quick_reply.POST_ACTION}" method="post" name="post">
<table border="0" cellpadding="5" cellspacing="1" width="100%" class="forumline posting">
   <tr>
      <th><span class="cattitle">{L_QUICK_REPLY}</span></th>
   </tr>
   <!-- BEGIN user_logged_out -->
   <tr>
      <td class="row2" width="100%"><span class="genmed"><b>{L_USERNAME}:</b>&nbsp;<input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" tabindex="1" name="username" size="25" maxlength="25" value=""></span></td>
   </tr>
   <!-- END user_logged_out -->
   <tr>
      <td class="row1">
				<textarea id="message" name="message" rows="10" cols="84" tabindex="3" class="post" onFocus="Active(this)" onBlur="NotActive(this)" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);"></textarea><br>
				<script type="text/javascript">
					CKEDITOR.replace('message');
				</script>
				<!-- BEGIN expire_box -->
				 {L_EXPIRE_Q} <select class="post" name="msg_expire">
					<option value="0" class="genmed">0</option>
					<option value="1" class="genmed">1</option>
					<option value="2" class="genmed"{EXPIRE_2_SELECTED}>2</option>
					<option value="3" class="genmed">3</option>
					<option value="4" class="genmed">4</option>
					<option value="5" class="genmed">5</option>
					<option value="6" class="genmed">6</option>
					<option value="7" class="genmed">7</option>
					<option value="14" class="genmed">14</option>
					<option value="30" class="genmed">30</option>
					<option value="90" class="genmed">90</option>
					</select> {L_DAYS}
				<!-- END expire_box -->
      <br />
      <hr />
      <span class="gen">
      <!-- BEGIN user_logged_in -->
	   <h3>{L_OPTIONS}</h3>
      <label><input type="checkbox" name="attach_sig" {quick_reply.user_logged_in.ATTACH_SIGNATURE}>{L_ATTACH_SIGNATURE}</label><br />
      <label><input type="checkbox" name="notify" {quick_reply.user_logged_in.NOTIFY_ON_REPLY}>{L_NOTIFY_ON_REPLY}</label>
      <!-- END user_logged_in -->
      <!-- BEGIN switch_lock_topic -->
      <br /><label><input type="checkbox" name="lock">{L_LOCK_TOPIC}</label>
      <!-- END switch_lock_topic -->
      <!-- BEGIN switch_unlock_topic -->
      <br /><label><input type="checkbox" name="unlock">{L_UNLOCK_TOPIC}</label>
      <!-- END switch_unlock_topic -->
      <!-- BEGIN switch_no_split_post -->
      <br /><label><input type="checkbox" name="nosplit">{L_NO_SPLIT_POST}</label>
      <!-- END switch_no_split_post -->
      </td>
   </tr>
   <tr>
      <td class="submit" colspan="2">{S_HIDDEN_FIELDS}<input type="hidden" name="mode" value="reply"><input type="hidden" name="disable_html" value="1"><input type="hidden" name="t" value="{quick_reply.TOPIC_ID}"><input type="hidden" name="last_msg" value="{quick_reply.LAST_MESSAGE}"><input type="submit" name="preview" class="mainoption" value="{L_PREVIEW}">&nbsp;<input type="submit" name="post" class="mainoption" value="{L_SUBMIT}"></td>
   </tr>
</table>
</form>
<!-- END quick_reply -->