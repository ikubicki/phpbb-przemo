	
<h1>{L_FORUM_TITLE}</h1>

<p>{L_FORUM_EXPLAIN}</p>

<script language=JavaScript src="../images/picker.js"></script>
<form action="{S_FORUM_ACTION}" method="post" name="pick_form">
  <table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	<tr> 
	  <th colspan="2">{L_FORUM_SETTINGS}</th>
	</tr>
	<tr> 
	  <td class="row1">{L_FORUM_NAME}</td>
	  <td class="row2"><input type="text" size="45" name="forumname" value="{FORUM_NAME}" class="post"></td>
	</tr>
	<tr> 
	  <td class="row1">{L_FORUM_DESCRIPTION}</td>
	  <td class="row2"><textarea rows="5" cols="45" name="forumdesc" class="post">{DESCRIPTION}</textarea></td>
	</tr>
	<tr> 
	  <td class="row1">{L_CATEGORY}</td>
	  <td class="row2"><select name="c">{S_CAT_LIST}</select></td>
	</tr>
	<tr> 
	  <td class="row1">{L_FORUM_STATUS}</td>
	  <td class="row2"><select name="forumstatus">{S_STATUS_LIST}</select></td>
	</tr>
	<tr> 
	  <td class="row1">{L_SORT}<br>{L_LOCKED_BOTTOM}</td>
	  <td class="row2"><select name="forumsort">{S_SORT_ORDER}</select><br>
	  <input type="checkbox" name="locked_bottom" value="1" {LOCKED_CHECKED}></td>
	</tr>
	<tr>
	  <td class="row1">{L_COLOR}</td>
	  <td class="row2"><input type="text" class="post" size="7" maxlength="6" name="forum_color" onKeyup="chng(this);" style="font-weight: bold; color: #{COLOR_SELECT}" value="{COLOR_SELECT}">
	  &nbsp;<a href="javascript:TCP.popup(document.forms['pick_form'].elements['forum_color'])"><img src="../images/sel.gif" border="0"></a></td>
	</tr>
	<tr>
	  <td class="row1">{L_SEPARATE_TOPICS}</td>
	  <td class="row2"><input type="radio" name="forum_separate" value="0"{SEPARATE_0_CHECKED}>{L_NO} &nbsp; <input type="radio" name="forum_separate" value="1"{SEPARATE_1_CHECKED}>{L_SEPARATE_MED} &nbsp; <input type="radio" name="forum_separate" value="2"{SEPARATE_2_CHECKED}>{L_SEPARATE_TOTAL}</td>
	</tr>
	<tr>
		<td class="row1">{L_SHOW_GLOBAL_ANN}&nbsp;</td>
		<td class="row2"><input type="checkbox" name="forum_show_ga" value="1" {SHOW_GA_CHECKED}></td>
	</tr>
	<tr>
	  <td class="row1">{L_MODERATE}<br><span class="gensmall">{L_MODERATE_E}</span></td>
	  <td class="row2"><input type="checkbox" name="moderate" value="1"{MODERATE_CHECKED}></td>
	</tr>
	<tr>
	  <td class="row1">{L_NO_COUNT}</td>
	  <td class="row2"><input type="checkbox" name="no_count" value="1"{NO_COUNT_CHECKED}></td>
	</tr>
	<!-- BEGIN forum_trash -->
	<tr>
	  <td class="row1">{L_FORUM_TRASH}<br><span class="gensmall">{L_FORUM_TRASH_E}</span></td>
	  <td class="row2"><input type="checkbox" name="forum_trash" value="1"{TRASH_CHECKED}></td>
	</tr>
	<!-- END forum_trash -->

	<!-- BEGIN helped -->
	<tr>
	  <td class="row1">{L_NO_HELPED}</td>
	  <td class="row2"><input type="checkbox" name="forum_no_helped" value="1"{NO_HELPED}></td>
	</tr>
	<!-- END helped -->
	<!-- BEGIN split -->
	<tr>
	  <td class="row1">{L_NO_SPLIT}</td>
	  <td class="row2"><input type="checkbox" name="forum_no_split" value="1"{NO_SPLIT}></td>
	</tr>
	<!-- END split -->
	<tr>
	  <td class="row1">{L_TREE_REQ}</td>
	  <td class="row2"><input type="checkbox" name="forum_tree_req" value="1"{TREE_CHECKED}></td>
	</tr>
	<tr>
	  <td class="row1">{L_TREE_GRADE}</td>
	  <td class="row2"><input type="text" name="forum_tree_grade" value="{TREE_GRADE}" size="1" maxlength="1" class="post"></td>
	</tr>
	<tr> 
	  <td class="row1">{L_PASSWORD}</td>
	  <td class="row2"><input type="text" class="post" name="password" value="{FORUM_PASSWORD}" size="30"></td>
	</tr>
	<tr> 
	  <td class="row1">{L_TOPIC_TAGS}</td>
	  <td class="row2"><textarea class="post" name="topic_tags" cols="30" rows="2">{TOPIC_TAGS}</textarea></td>
	</tr>
	<tr> 
	  <td class="row1">{L_AUTO_PRUNE}<br><span class="gensmall">{L_PRUNE_EXPLAIN}</span></td>
	  <td class="row2"><table cellspacing="0" cellpadding="1" border="0">
		  <tr> 
			<td align="right" valign="middle">{L_ENABLED}</td>
			<td align="left" valign="middle"><input type="checkbox" name="prune_enable" value="1" {S_PRUNE_ENABLED}></td>
		  </tr>
		  <tr> 
			<td align="right" valign="middle">{L_PRUNE_DAYS}</td>
			<td align="left" valign="middle">&nbsp;<input type="text" name="prune_days" value="{PRUNE_DAYS}" size="5" class="post">&nbsp;{L_DAYS}</td>
		  </tr>
		  <tr> 
			<td align="right" valign="middle">{L_PRUNE_FREQ}</td>
			<td align="left" valign="middle">&nbsp;<input type="text" name="prune_freq" value="{PRUNE_FREQ}" size="5" class="post">&nbsp;{L_DAYS}</td>
		  </tr>
	  </table></td>
	</tr>
	<tr>
		<td class="row1">{L_LINK}&nbsp;</td>
		<td class="row2" align="center">
			<table cellspacing="0" cellpadding="3" border="0">
			<tr>
				<td align="right">{L_FORUM_LINK}&nbsp;</td>
				<td>
					<input type="text" name="forum_link" value="{FORUM_LINK}" size="40" class="post"><br>
					<span class="gensmall">{L_FORUM_LINK_EXPLAIN}</span>
				</td>
			</tr>
			<tr>
				<td align="right">{L_FORUM_LINK_INTERNAL}&nbsp;</td>
				<td>
					<input type="radio" name="forum_link_internal" value="1" {FORUM_LINK_INTERNAL_YES}>&nbsp;{L_YES}&nbsp;&nbsp;<input type="radio" name="forum_link_internal" value="0" {FORUM_LINK_INTERNAL_NO}>&nbsp;{L_NO}<br>
					<span class="gensmall">{L_FORUM_LINK_INTERNAL_EXPLAIN}</span>
				</td>
			</tr>
			<tr>
				<td align="right">{L_FORUM_LINK_HIT_COUNT}&nbsp;</td>
				<td>
					<input type="radio" name="forum_link_hit_count" value="1" {FORUM_LINK_HIT_COUNT_YES}>&nbsp;{L_YES}&nbsp;&nbsp;<input type="radio" name="forum_link_hit_count" value="0" {FORUM_LINK_HIT_COUNT_NO}>&nbsp;{L_NO}<br>
					<span class="gensmall">&nbsp;{L_FORUM_LINK_HIT_COUNT_EXPLAIN}</span>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	<tr> 
	  <td class="submit" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{S_SUBMIT_VALUE}" class="mainoption"></td>
	</tr>
  </table>
</form>
		
<br clear="all">
