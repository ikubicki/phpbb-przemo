
<h1>{L_EDIT_CATEGORY}</h1>

<p>{L_EDIT_CATEGORY_EXPLAIN}</p>

<form action="{S_FORUM_ACTION}" method="post">
  <table cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	<tr> 
	  <th colspan="2">{L_EDIT_CATEGORY}</th>
	</tr>
	<tr> 
	  <td class="row1">{L_CATEGORY}</td>
	  <td class="row2"><input type="text" size="25" name="cat_title" value="{CAT_TITLE}"></td>
	</tr>
	<tr>
	  <td class="row1">{L_CAT_DESCRIPTION}</td>
	  <td class="row2"><textarea rows="5" cols="45" name="cat_desc" class="post">{CAT_DESCRIPTION}</textarea></td>
	</tr>
	<tr>
	  <td class="row1">{L_CATEGORY_ATTACHMENT}</td>
	  <td class="row2"><select name="cat_main">{S_CAT_LIST}</select></td>
	</tr>
	<tr> 
	  <td class="submit" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{S_SUBMIT_VALUE}" class="mainoption"></td>
	</tr>
  </table>
</form>
		
<br clear="all">
