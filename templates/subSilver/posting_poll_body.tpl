
			<tr>
				<th class="thHead" colspan="2">{L_ADD_A_POLL}</th>
	        </tr>
			<tr>
				<td class="row1" colspan="2"><span class="gensmall">{L_ADD_POLL_EXPLAIN}</span></td>
	        </tr>
            <tr>
				<td class="row1"><span class="gen"><b>{L_POLL_QUESTION}</b></span></td>
				<td class="row2"><span class="genmed"><input type="text" name="poll_title" size="50" maxlength="255" class="post" onFocus="Active(this)" onBlur="NotActive(this)" value="{POLL_TITLE}"></span></td>
			</tr>
			<!-- BEGIN poll_option_rows -->
            <tr>
				<td class="row1"><span class="gen"><b>{L_POLL_OPTION}</b></span></td>
				<td class="row2"><span class="genmed"><input type="text" name="poll_option_text[{poll_option_rows.S_POLL_OPTION_NUM}]" size="50" class="post" onFocus="Active(this)" onBlur="NotActive(this)" maxlength="255" value="{poll_option_rows.POLL_OPTION}"></span> &nbsp;<input type="submit" name="edit_poll_option" value="{L_UPDATE_OPTION}" class="liteoption"> <input type="submit" name="del_poll_option[{poll_option_rows.S_POLL_OPTION_NUM}]" value="{L_DELETE_OPTION}" class="liteoption"></td>
	  </tr>
			<!-- END poll_option_rows -->
            <tr>
				<td class="row1"><span class="gen"><b>{L_POLL_OPTION}</b></span></td>
				<td class="row2"><span class="genmed"><input type="text" name="add_poll_option_text" size="50" maxlength="255" class="post" onFocus="Active(this)" onBlur="NotActive(this)" value="{ADD_POLL_OPTION}"></span> &nbsp;<input type="submit" name="add_poll_option" value="{L_ADD_OPTION}" class="liteoption"></td>
	   </tr>
            <tr>
				<td class="row1"><span class="gen"><b>{L_MAX_VOTE}</b></span></td>
				<td class="row2"><span class="genmed"><input type="text" name="max_vote" size="3" maxlength="3" class="post" value="{MAX_VOTE}" onFocus="Active(this)" onBlur="NotActive(this)"></span>&nbsp;<span class="gen"><b>{L_OPTIONS}</b></span> &nbsp; <span class="gensmall">{L_MAX_VOTE_EXPLAIN}</span></td>
	   </tr>
            <tr>
				<td class="row1"><span class="gen"><b>{L_POLL_LENGTH}</b></span></td>
				<td class="row2"><span class="genmed"><input type="text" name="poll_length" size="3" maxlength="3" class="post" value="{POLL_LENGTH}" class="post" onFocus="Active(this)" onBlur="NotActive(this)"></span>&nbsp;<span class="gen"><b>{L_DAYS}</b></span>
				<span class="genmed"><input type="text" name="poll_length_h" size="3" maxlength="3" class="post" value="{POLL_LENGTH_H}" onFocus="Active(this)" onBlur="NotActive(this)"></span>&nbsp;<span class="gen"><b>{L_HOURS}</b></span>&nbsp; <span class="gensmall">{L_POLL_LENGTH_EXPLAIN}</span></td>
	   </tr>
            <tr>
				<td class="row1"><span class="gen"><b>{L_VHIDE}</b></span></td>
				<td class="row2"><input type="checkbox" name="hide_vote" {HIDE_VOTE}> <span class="gen"><b>{L_HIDE_VOTE}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>(&nbsp;&nbsp;</span><input type="checkbox" name="tothide_vote" {TOTHIDE_VOTE}> <span class="gen"><b>{L_TOTHIDE_VOTE}</b>&nbsp;)</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="gensmall">{L_HIDE_VOTE_EXPLAIN}</span></td>
			</tr>

			<!-- BEGIN switch_poll_delete_toggle -->
            <tr>
				<td class="row1"><span class="gen"><b>{L_POLL_DELETE}</b></span></td>
				<td class="row2"><input type="checkbox" name="poll_delete"></td>
			</tr>
			<!-- END switch_poll_delete_toggle -->