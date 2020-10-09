<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td><span class="gensmall">
		<!-- BEGIN staff_explain -->
		<a href="{staff_explain.U_GROUP_URL}" class="gensmall" style="color: #{staff_explain.GROUP_COLOR}{staff_explain.GROUP_STYLE}">{staff_explain.GROUP_PREFIX}{staff_explain.GROUP_NAME}</a>
		<!-- BEGIN se_separator -->
		&bull;
		<!-- END se_separator -->
		<!-- END staff_explain -->		
		</span></td>
	</tr>
</table>
<br>

<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0" align="center">
	<tr> 
		<th class="thHead" colspan="2" height="25" nowrap="nowrap">{SEE_SEEKER}</th>
	</tr>
	<tr>
		<td class="row1">
	    	<form action="{SEE_L_SEARCH}" method="POST"><br>
				<table border="0">
					<tr>
						<td>
							<span class="gen"><b>{SEE_SEARCH}</b></span><br>
							<select name="lookfor" size="1">
							<!-- BEGIN see_lookfor_option -->
								<option value="{see_lookfor_option.VALUE}" {see_lookfor_option.SELECTED}>{see_lookfor_option.TEXT}</option>
							<!-- END see_lookfor_option -->
							</select>
						</td>
						<td width="10">
						</td>
						<td>
							<span class="gen"><b>{SEE_METHOD}</b></span><br>
							<select name="method" size="1">
								<option value="LIKE" {SEE_LIKE_CHK}>{SEE_EQUAL}</option>
								<option value=">" {SEE_GT_CHK}>{SEE_GT}</option>
								<option value="<" {SEE_ST_CHK}>{SEE_ST}</option>
							</select>
						</td>
						<td width="10">
						</td>
						<td>
							<span class="gen"><b>{SEE_SORT_METHOD}</b></span><br>
							<select name="sortby" {SEE_SORT_DISABLE} size="1">
							<!-- BEGIN see_lookfor2_option -->
								<option value="{see_lookfor2_option.VALUE}" {see_lookfor2_option.SORT_SELECTED}>{see_lookfor2_option.TEXT}</option>
							<!-- END see_lookfor2_option -->
							<!-- BEGIN see_sortby_spacer -->
								<option value="selected_field" disabled="disabled">- - - - - - - - - - - - -</option>
							<!-- END see_sortby_spacer -->
							<!-- BEGIN see_sortby_option -->
								<option value="{see_sortby_option.VALUE}" {see_sortby_option.SORT_SELECTED}>{see_sortby_option.TEXT}</option>
							<!-- END see_sortby_option -->
							</select>
						</td>
						<td width="10">
						</td>
						<td>
							<span class="gen"><b>{SEE_SORT_ORDER}</b></span><br>
							<select name="order" {SEE_ORDER_DISABLE} size="1">
								<option value="ASC" {SEE_ASC_SELECTED}>{SEE_ASC}</option>
								<option value="DESC" {SEE_DESC_SELECTED}>{SEE_DESC}</option>
							</select>
						</td>
					</tr>
				</table>
				<br>
				<input type="text" class="post" name="query" value="{SEE_QUERY}" id="focus">
				<input type="submit" class="mainoption" value="{SEE_SUBMIT}"><br>
				<span class="gen"><i>{SEE_TIP}</i></span>
			</form>
			<span class="gen">{SEE_R}{SEE_FOUND}{SEE_NOT_FOUND}{SEE_RESTRICTED}{SEE_LIMITED}</span><br><br>
	    	<!-- BEGIN see_result -->
			<span class="gen">{PAGINATION}</span><br>
			<div style="text-align:center; width:100%"><table border="0" cellpadding="4" cellspacing="1" class="forumline" width="96%">
				<tr>
					<td class="catHead" align="center" width="5">
						<span class="gen"><b>#</b></span>
					</td>
					<td class="catHead" width="180">
						<span class="gen"><b>{SEE_USER}</b></span>
					</td>
					<td class="catHead">
						<span class="gen"><b>{SEE_LOOKFOR_FIELD}</b></span>
					</td>
					<!-- BEGIN sort_field -->
					<td class="catHead">
						<span class="gen"><b>{see_result.sort_field.NAME}</b></span>
					</td>
					<!-- END sort_field -->
					<td class="catHead" width="150" nowrap="nowrap">
						<span class="gen"><b>{SEE_JOINED}</b></span>
					</td>
				</tr>
				<!-- BEGIN user -->
				<tr>
					<td class="{see_result.user.ROW_CLASS}" align="center" width="5">
						<span class="gen">{see_result.user.NUM}</span>
					</td>
					<td class="{see_result.user.ROW_CLASS}">
						<span class="gen">{see_result.user.USERNAME}</span>
					</td>
					<td class="{see_result.user.ROW_CLASS}">
						<span class="gen">{see_result.user.FIELD_VALUE}</span>
					</td>
					<!-- BEGIN sort_field -->
					<td class="{see_result.user.ROW_CLASS}">
						<span class="gen">{see_result.user.sort_field.FIELD_VALUE}</span>
					</td>
					<!-- END sort_field -->
					<td class="{see_result.user.ROW_CLASS}">
						<span class="gen">{see_result.user.JOINED}</span>
					</td>
				</tr>
				<!-- END user -->
			</table></div>
			<table width="100%" cellspacing="2" cellpadding="2" border="0">
				<tr>
					<td><span class="nav">{PAGE_NUMBER}</span></td>
					<td align="right"><span class="nav">{PAGINATION}</span></td>
				</tr>
			</table>
			<!-- END see_result -->
			<br>
			<div style="text-align:right"><span class="gensmall">Mod by Widmo &amp; Crack</span></div>
		</td>
	</tr>
</table>