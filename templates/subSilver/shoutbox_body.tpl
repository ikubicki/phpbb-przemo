<script type="text/javascript" src="images/shoutbox.js"></script>
<script type="text/javascript"><!--
onload = requestNewMessages;
var updateInterval = {REFRESH_SB};
-->
</script> 
<table id="SB_content" border="0" align="center" cellpadding="0" cellspacing="1" class="forumline">
	<tr>
		<th class="thHead">{L_SHOUTBOX} <img src="templates/{STYLE_NAME}/images/act_indicator.gif" id="act_indicator" alt="indicator"></th>
	</tr>
	<tr>
		<td>
			<div id="SB_box" style="width:{SHOUTBOX_WIDTH}px; height:{SHOUTBOX_HEIGHT}px; overflow:auto;">
				<div id="SB_inner">
				
				</div>
			</div>
		</td>
	</tr>
	<tr>
		<td class="row2" style="text-align: center;">
			<span id="message12">{L_GG_MES}:</span>
			<input type="text" class="post" id="messageBox" value="" maxlength="{MAXLENGHT}" size="60" onkeydown="handleKey(event);">
			<input type="button" class="post" id="wyslij" value="{L_SEND}" onclick="sendMessage();" style="margin-right:2px;">
			<!-- BEGIN smilies_emotki -->
			<input type="button" class="post" id="emotki" value="{L_EMOTKI}" onclick="emotki();">
			<!-- END smilies_emotki -->
			<input type="button" class="post" style="display: none;" id="zmien" value="{L_EDIT_SB}" onclick="sendEditShout();">
			<input type="button" class="post" style="display: none;" id="anuluj1" value="{L_CANCEL_SB}" onclick="anuluj1();">
			<input type="button" class="post" style="display: none; width: 560px;" id="refresh12" value="{L_REFRESH_SB}" onclick="refreshSB12();">
			<input type="hidden" id="userName" value="{USER_ID}" disabled="disabled">
			<input type="hidden" id="userId" value="" disabled="disabled">
		</td>
	</tr>
	<!-- BEGIN smilies_emotki -->
	<tr id="ramka" style="display: none;">
		<td class="row1" style="text-align: center;">
	<!-- END smilies_emotki -->
			<!-- BEGIN smilies_row -->
			<!-- BEGIN smilies_col -->
			<img src="{smilies_row.smilies_col.SMILEY_IMG}" style="cursor:pointer;margin:2px;border:0;" onclick="wstawianieSB('{smilies_row.smilies_col.SMILEY_CODE}',1);" title="{smilies_row.smilies_col.SMILEY_CODE}">
			<!-- END smilies_col -->
			<!-- END smilies_row -->
	<!-- BEGIN smilies_emotki -->
		</td>
	</tr>
	<!-- END smilies_emotki -->
</table>