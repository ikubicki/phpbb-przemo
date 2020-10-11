				<br />
				<!-- BEGIN catrow -->
				<!-- BEGIN tablehead -->
				<!-- BEGIN br -->
				<div id="hc_{catrow.tablehead.br.CAT_ID}" class="visible">
				<script>forum.setCategoryClass('#hc_{catrow.tablehead.br.CAT_ID}')</script>
				<!-- END br -->
				<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
				<tr>
					<th colspan="{catrow.tablehead.INC_SPAN}" width="100%" nowrap="nowrap">
<!-- BEGIN br --> 
						<a href="javascript:void(0)" onclick="forum.toggleCategory('#hc_{catrow.tablehead.CAT_ID}', this)" class="toggleCategory">&nbsp;</a>
<!-- END br -->
						<a href="{catrow.tablehead.U_FORUM}" class="cattitle">{catrow.tablehead.L_FORUM}</a>
<!-- IF catrow.tablehead.CAT_DESCRIPTION -->
						<span class="gensmall description">{catrow.tablehead.CAT_DESCRIPTION}</span>
<!-- ENDIF -->
					</th>
					<th width="50" class="label">&nbsp;{L_TOPICS}&nbsp;</td>
					<th width="50" class="label">&nbsp;{L_POSTS}&nbsp;</td>
					<th width="150" class="label">&nbsp;{L_LASTPOST}&nbsp;</td>
				</tr>
				<!-- END tablehead -->
				<!-- BEGIN cathead -->
				<tr class="row">
					<!-- BEGIN inc -->
					<td width="46" class="{catrow.cathead.inc.INC_CLASS}"><img src="{SPACER}" width="46" height="0"></td>
					<!-- END inc -->
					<td class="{catrow.cathead.CLASS_CAT}" width="100%" colspan="{catrow.cathead.INC_SPAN}">
						<a href="{catrow.cathead.U_VIEWCAT}" class="cattitle">{catrow.cathead.CAT_TITLE}</a>
<!-- IF catrow.cathead.CAT_DESCRIPTION -->
						<span class="gensmall description">{catrow.cathead.CAT_DESCRIPTION}</span>
<!-- ENDIF -->
					</td>
					<td class="{catrow.cathead.CLASS_CAT} label" width="50">&nbsp;{L_TOPICS}&nbsp;</td>
					<td class="{catrow.cathead.CLASS_CAT} label" width="50">&nbsp;{L_POSTS}&nbsp;</td>
					<td class="{catrow.cathead.CLASS_CAT} label" width="150">&nbsp;{L_LASTPOST}&nbsp;</td>
				</tr>
				<!-- END cathead -->
				<!-- BEGIN forumrow -->
				<tr class="row">
					<!-- BEGIN inc -->
					<td width="46" class="{catrow.forumrow.inc.INC_CLASS}"><img src="{SPACER}" width="46" height="0"></td>
					<!-- END inc -->
					<td class="{catrow.forumrow.INC_CLASS}" align="center" valign="middle" height="50"><img src="{catrow.forumrow.FORUM_FOLDER_IMG}" alt="" title="{catrow.forumrow.L_FORUM_FOLDER_ALT}"></td>
					<td class="row1" width="100%" height="50" colspan="{catrow.forumrow.INC_SPAN}">
						<span class="forumlink"><a href="{catrow.forumrow.U_VIEWFORUM}" class="forumlink"{catrow.forumrow.FORUM_COLOR}>{catrow.forumrow.FORUM_NAME}</a></span><span class="gensmall">&nbsp;&nbsp;{catrow.forumrow.LAST_POSTMSG}<br></span>
						<span class="genmed">{catrow.forumrow.FORUM_DESC}<br></span>
						<span class="gensmall">
							{catrow.forumrow.L_MODERATOR} {catrow.forumrow.MODERATORS}
							<!-- BEGIN links -->
							{catrow.forumrow.links.L_LINKS} {catrow.forumrow.links.LINKS}
							<!-- END links -->
						</span></td>
					<!-- BEGIN forum_link_no -->
					<td class="row1" align="center" valign="middle" height="50"><span class="gensmall">{catrow.forumrow.TOPICS}</span></td>
					<td class="row1" align="center" valign="middle" height="50"><span class="gensmall">{catrow.forumrow.POSTS}</span></td>
					<td class="row1" align="center" valign="middle" height="50" nowrap="nowrap"><span class="gensmall">{catrow.forumrow.LAST_POST}{catrow.forumrow.NUM_NEW_TOPICS}{catrow.forumrow.NUM_NEW_POSTS}</span></td>
					<!-- END forum_link_no -->
					<!-- BEGIN forum_link -->
					<td class="row1" align="center" valign="middle" height="50" colspan="3"><span class="gensmall">{catrow.forumrow.forum_link.HIT_COUNT}</span></td>
					<!-- END forum_link -->
				</tr>
				<!-- END forumrow -->
				<!-- BEGIN catfoot -->
				<!-- BEGIN inc -->
				<!-- END inc -->
				<!-- END catfoot -->
				<!-- BEGIN tablefoot -->
				</table>
				<!-- BEGIN br_bottom -->
				</div>
				<script language="javascript" type="text/javascript">
				<!--
				if(GetCookie('hc3_{catrow.tablefoot.br_bottom.CAT_ID}') == '2') ShowHide('hc_{catrow.tablefoot.br_bottom.CAT_ID}', 'hc2_{catrow.tablefoot.br_bottom.CAT_ID}', 'hc3_{catrow.tablefoot.br_bottom.CAT_ID}');
				//-->
				</script>
				{catrow.tablefoot.br_bottom.BR}
				<!-- END br_bottom -->
				<!-- END tablefoot -->
				<!-- END catrow -->
