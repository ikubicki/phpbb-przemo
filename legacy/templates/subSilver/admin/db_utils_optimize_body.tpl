{SELECT_SCRIPT}

<h1>{L_DATABASE_OPTIMIZE}</h1>

<P>{L_OPTIMIZE_EXPLAIN}</p>

<form method="post" action="{S_DBUTILS_ACTION}" name="tablesForm">

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	
<tr>
	<th class="thCornerL"> &nbsp; &nbsp; </th>
	<th class="thTop">{L_OPTIMIZE_TABLE}</th>
	<th class="thTop">{L_OPTIMIZE_RECORD}</th>
	<th class="thTop">{L_OPTIMIZE_TYPE}</th>
	<th class="thTop">{L_OPTIMIZE_SIZE}</th>
	<th class="thCornerR">{L_OPTIMIZE_STATUS}</th>
</tr>	

<!-- BEGIN optimize -->
<tr>
	<td class="{optimize.ROW_CLASS}">{optimize.S_SELECT_TABLE}</td>
	<td class="{optimize.ROW_CLASS}">{optimize.TABLE}</td>
	<td class="{optimize.ROW_CLASS}" align="right">{optimize.RECORD}</td>
	<td class="{optimize.ROW_CLASS}" align="center">{optimize.TYPE}</td>
	<td class="{optimize.ROW_CLASS}" align="right">{optimize.SIZE}</td>
	<td class="{optimize.ROW_CLASS}" align="center">{optimize.STATUS}</td>
</tr>
<!-- END optimize -->

<tr>
	<td class="row3">&nbsp;</td>
	<td class="row3"><b>{TOT_TABLE}</b></td>
	<td class="row3" align="right"><b>{TOT_RECORD}</b></td>
	<td class="row3" align="center"><b>- -</b></td>
	<td class="row3" align="right"><b>{TOT_SIZE}</b></td>
	<td class="row3" align="center"><b>{TOT_STATUS}</b></td>
</tr>

<tr>
	<td class="row3" colspan="6" align="center">	
		<a href="#" onclick="setCheckboxes('tablesForm', true); return false;">{L_OPTIMIZE_CHECKALL}</a>&nbsp;/&nbsp;<a href="#" onclick="setCheckboxes('tablesForm', false); return false;">{L_OPTIMIZE_UNCHECKALL}</a>&nbsp;/&nbsp;<a href="#" onclick="setCheckboxes('tablesForm', 'invert'); return false;">{L_OPTIMIZE_INVERTCHECKED}</a>	
	</td>
</tr>

<tr>
	<td class="cat" colspan="6" align="center">
	{S_HIDDEN_FIELDS}
	<input type="submit" name="ottimizza" value="{L_START_OPTIMIZE}" class="mainoption">
	</td>
</tr>
</table>

</form>
<br>