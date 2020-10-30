<script language="javascript" type="text/javascript">
<!--
function update_rank(newimage)
{
	document.rank_image.src = '{PATH_RANKS}'+newimage;
}
//-->
</script>
<h1>{L_RANKS_TITLE}</h1>

<p>{L_RANKS_TEXT}</p>
<body onload="update_rank('{RANK_ONLOAD}');">
<form action="{S_RANK_ACTION}" method="post">
<table width="100%" class="forumline" cellpadding="4" cellspacing="1" border="0" align="center">
	<tr>
		<th colspan="2">{L_RANKS_TITLE}</th>
	</tr>
	<tr>
		<td class="row1" width="38%"><span class="gen">{L_RANK_TITLE}</span><span class="gensmall"><br>{L_RANK_TITLE_E}</span></td>
		<td class="row2"><input type="text" name="title" size="35" maxlength="40" value="{RANK}"></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_RANK_SPECIAL}</span></td>
		<td class="row2"><input type="radio" name="special_rank" value="1" {SPECIAL_RANK}>{L_YES} &nbsp;&nbsp;<input type="radio" name="special_rank" value="0" {NOT_SPECIAL_RANK}> {L_NO}</td>
	</tr>
<!-- BEGIN switch_group_rank -->
	<tr>
		<td class="row1"><span class="gen">{switch_group_rank.L_GROUP_RANK}:</span><br>
		<span class="gensmall">{switch_group_rank.L_GROUP_RANK_EXPLAIN}</span></td>
		<td class="row2">{switch_group_rank.GROUP_RANK_SELECT}</td>
	</tr>
<!-- END switch_group_rank -->
	<tr>
		<td class="row1" width="38%"><span class="gen">{L_RANK_MINIMUM}:</span></td>
		<td class="row2"><input type="text" name="min_posts" size="5" maxlength="10" value="{MINIMUM}"></td>
	</tr>
	<tr>
		<td class="row1" width="38%"><span class="gen">{L_RANK_IMAGE}:</span><br><span class="gensmall">{L_RANK_IMAGE_EXPLAIN}</span></td>
		<td class="row2"><select name="rank_image" onchange="update_rank(this.options[selectedIndex].value);">{RANK_LIST}</select> &nbsp; <img name="rank_image" src="../images/spacer.gif" border="0" alt=""> &nbsp;</td>
	</tr>
	<tr>
		<td class="submit" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption">&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption"></td>
	</tr>
</table>
{S_HIDDEN_FIELDS}</form>
<br>