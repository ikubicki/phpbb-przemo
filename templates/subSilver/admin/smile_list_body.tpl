
<h1>{L_SMILEY_TITLE}</h1>

<P>{L_SMILEY_TEXT}</p>

<form method="post" action="{S_SMILEY_ACTION}"><table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th class="thCornerL">{L_CODE}</th>
		<th class="thTop">{L_SMILE}</th>
		<th colspan="3" class="thCornerR">{L_ACTION}</th>
	</tr>
	<!-- BEGIN smiles -->
	<tr>
		<td class="{smiles.ROW_CLASS}"><a name="{smiles.ID}"></a>{smiles.CODE}</td>
		<td class="{smiles.ROW_CLASS}"><img src="{smiles.SMILEY_IMG}" alt="{smiles.CODE}"></td>
		<td class="{smiles.ROW_CLASS}"><a href="{smiles.U_SMILEY_EDIT}">{L_EDIT}</a></td>
		<td class="{smiles.ROW_CLASS}"><a href="{smiles.U_SMILEY_DELETE}">{L_DELETE}</a></td>
		<td class="{smiles.ROW_CLASS}"><a href="{smiles.U_SMILEY_UP}">{L_UP}</a> | <a href="{smiles.U_SMILEY_DOWN}">{L_DOWN}</a></td>
	</tr>
	<!-- END smiles -->
	<tr>
		<td class="catBottom" colspan="6" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="add" value="{L_SMILEY_ADD}" class="liteoption">&nbsp;&nbsp;<input class="liteoption" type="submit" name="import_pack" value="{L_IMPORT_PACK}">&nbsp;&nbsp;<input class="liteoption" type="submit" name="export_pack" value="{L_EXPORT_PACK}"></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="6" align="center"><input class="liteoption" type="submit" name="mass_pre_add" value="{L_MASS_SMILIES_ADD}">&nbsp;&nbsp;<input type="hidden" name="mode" value="delete_all"><input class="liteoption" type="submit" name="delete_all" value="{DELL_ALL_SMILIES}"></td>
	</tr>
</table></form>
<br>