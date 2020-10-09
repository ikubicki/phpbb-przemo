

<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0" align="center">
	<tr>
		<th class="thHead" colspan="2" height="25" nowrap="nowrap">{L_VIEWING_PROFILE}</th>
	</tr>
	<tr>
		<td class="catLeft" width="40%" height="28" align="center"><b><span class="gen">{L_AVATAR}</span></b></td>
		<td class="catRight" width="60%"><span class="gensmall"><b>
		<!-- BEGIN admin -->
		<a href="{U_ADMIN_EDIT}" target="_blank">{L_EDIT}</a>&nbsp;
		<a href="{U_ADMIN_PERMISSION}" target="_blank">{L_PERMISSIONS}</a>&nbsp;
		<!-- END admin -->
		<!-- BEGIN add_warning -->
		<a href="{U_ADD_WARNING}">{L_ADD_WARNING}</a>&nbsp;
		<!-- END add_warning -->
		<!-- BEGIN topic_spy -->
		<a href="{U_TOPIC_SPY}">{L_TOPIC_SPY}</a>&nbsp;
		<!-- END topic_spy -->
		</b></span></td>
	</tr>
	<tr>
		<td class="row1" height="6" valign="top" align="center">{AVATAR_IMG}<br><span class="postdetails">{POSTER_RANK}{CUSTOM_RANK}{RANK_IMAGE}</span>
			<!-- BEGIN signature -->
			<br>
			<table width="100%" border="0" cellspacing="1" cellpadding="1">
				<tr>
					<td align="center"><span class="nav">{signature.L_SIGNATURE}</span><hr></td>
				</tr>
				<tr>
					<td align="left">{signature.SIGNATURE}{signature.SIG_IMAGE}</td>
				</tr>
			</table>
			<!-- END signature -->
		</td>
		<td class="row1" rowspan="2" valign="top">
			<table width="100%" border="0" cellspacing="1" cellpadding="3">
				<tr>
					<td valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_JOINED}:&nbsp;</span></td>
					<td width="100%"><b><span class="gen">{JOINED}</span></b></td>
				</tr>
				<!-- BEGIN last_login -->
				<tr>
					<td valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_LAST_VISIT}:&nbsp;</span></td>
					<td width="100%"><span class="gen">{LAST_VISIT}</span><span class="gensmall">{LAST_ACTIVITY_TIME}</span><span class="gen">{USER_ONLINE}</span>
					<!-- BEGIN host -->
					<br><span class="gensmall">({USER_HOST} {USER_HOST_LINK})</span>
					<!-- END host -->
					<br><span class="gensmall">{L_USER_VISITS}: <b>{USER_VISITS}</b> &nbsp;{L_SPEND_TIME} <b>{USER_SPEND_TIME}</b></span>
					</td>
				</tr>
				<!-- END last_login -->
				<tr>
					<td valign="top" align="right" nowrap="nowrap"><span class="gen">{L_TOTAL_POSTS}:&nbsp;</span></td>
					<td valign="top"><span class="genmed"><b>{POSTS}</b>, &nbsp;{L_TOPICS}: <b>{TOPICS}</b>,
					 &nbsp;{L_ATTACHMENTS}: <b>{ATTACHMENTS_TOTAL}</b>, &nbsp;{L_POLLS}: <b>{POLLS}</b></span>
					<!-- BEGIN posts -->
					<br><span class="genmed">[{POST_PERCENT_STATS} / {POST_DAY_STATS}]
					<br><a href="{U_LAST_POST}"
					<!-- BEGIN title_overlib -->
					onMouseOver="return overlib('<left>{posts.title_overlib.POST_TEXT}</left>', ol_width=400, ol_offsetx=10, ol_offsety=10, CAPTION, '<center>{posts.title_overlib.L_POST_TEXT}</center>')" onMouseOut="nd();"
					<!-- END title_overlib -->
					class="genmed">{L_LAST_POST}</a> {LAST_POST_TIME}
					<br><a href="{U_SEARCH_USER}" class="genmed">{L_SEARCH_USER_POSTS}</a>
					<!-- END posts -->
					<!-- BEGIN ignore_topics -->
					<br><a href="{U_IGNORE_TOPICS}" class="genmed">{L_IGNORE_TOPICS}</a>
					<!-- END ignore_topics -->
					</span></td>
				</tr>
				<!-- BEGIN custom_fields -->
				<tr>
					<td valign="top" align="right" nowrap="nowrap"><span class="gen">{custom_fields.DESC}:&nbsp;</span></td>
					<td valign="top"><b><span class="gen">{custom_fields.FIELD}</span></b></td>
				</tr>
				<!-- END custom_fields -->
				<!-- BEGIN location -->
				<tr>
					<td valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_LOCATION}:&nbsp;</span></td>
					<td><b><span class="gen">{LOCATION}</span></b></td>
				</tr>
				<!-- END location -->
				<!-- BEGIN website -->
				<tr>
					<td valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_WEBSITE}:&nbsp;</span></td>
					<td><span class="gen"><b>{WWW}</b></span></td>
				</tr>
				<!-- END website -->
				<!-- BEGIN helped -->
				<tr>
					<td valign="middle" align="right" nowrap="nowrap"><span class="gen">{helped.L_SPECIAL_RANK}&nbsp;</span></td>
					<td><span class="gen"><b>{helped.SPECIAL_RANK}</b></span></td>
				</tr>
				<!-- END helped -->
				<!-- BEGIN job -->
				<tr>
					<td valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_OCCUPATION}:&nbsp;</span></td>
					<td><b><span class="gen">{OCCUPATION}</span></b></td>
				</tr>
				<!-- END job -->
				<!-- BEGIN interests -->
				<tr>
					<td valign="top" align="right" nowrap="nowrap"><span class="gen">{L_INTERESTS}:&nbsp;</span></td>
					<td><b><span class="gen">{INTERESTS}</span></b></td>
				</tr>
				<!-- END interests -->
				<!-- BEGIN gender -->
				<tr>
					<td valign="top" align="right" nowrap="nowrap"><span class="gen">{L_GENDER}:&nbsp;</span></td>
					<td><b><span class="gen">{GENDER}</span></b></td>
				</tr>
				<!-- END gender -->
				<!-- BEGIN warnings -->
				<tr>
					<td valign="top" align="right" nowrap="nowrap"><span class="gen">{warnings.WARNINGS}:&nbsp;</span></td>
					<td><b><span class="gen">
						<table cellspacing="0" cellpadding="0" border="0">
							<tr>
								<td><img src="images/level_mod/exp_bar_left.gif" alt="" width="2" height="9"></td>
								<td><img src="images/level_mod/exp_bar_fil.gif" alt="" width="{warnings.POSTER_W_WIDTH}" height="9"></td>
								<td><img src="images/level_mod/exp_bar_fil_end.gif" alt="" width="1" height="9"></td>
								<td><img src="images/level_mod/level_bar_emp.gif" alt="" width="{warnings.POSTER_W_EMPTY}" height="9"></td>
								<td nowrap="nowrap"><img src="images/level_mod/level_bar_right.gif" alt="" width="1" height="9" align="middle"/>&nbsp;<span class="postdetails">{warnings.HOW}/{warnings.WRITE}/{warnings.MAX}</span></td>
							</tr>
						</table>
					</span></b></td>
				</tr>
				<!-- END warnings -->
				<!-- BEGIN switch_upload_limits -->
				<tr> 
					<td valign="top" align="right" nowrap="nowrap"><span class="gen">{L_UPLOAD_QUOTA}:&nbsp;</span></td>
					<td> 
					<table width="175" cellspacing="1" cellpadding="2" border="0" class="bodyline">
					<tr> 
						<td colspan="3" width="100%" class="row2">
							<table cellspacing="0" cellpadding="1" border="0">
							<tr> 
								<td bgcolor="{T_TD_COLOR2}"><img src="templates/subSilver/images/spacer.gif" width="{UPLOAD_LIMIT_IMG_WIDTH}" height="8" alt="{UPLOAD_LIMIT_PERCENT}"></td>
							</tr>
							</table>
						</td>
					</tr>
					<tr> 
						<td width="33%" class="row1"><span class="gensmall">0%</span></td>
						<td width="34%" align="center" class="row1"><span class="gensmall">50%</span></td>
						<td width="33%" align="right" class="row1"><span class="gensmall">100%</span></td>
					</tr>
					</table>
					<b><span class="genmed">[{UPLOADED} / {QUOTA} / {PERCENT_FULL}]</span> </b><br>
					<span class="genmed"><a href="{U_UACP}" class="genmed">{L_UACP}</a></span></td>
					</td>
				</tr>
				<!-- END switch_upload_limits -->
				<!-- BEGIN advert_person -->
				<tr>
					<td valign="top" align="center" colspan="2"><span class="gensmall">{advert_person.LINK}</span></td>
				</tr>
				<!-- END advert_person -->
			</table>
		</td>
	</tr>
	<tr> 
		<td class="row1" valign="top">
			<table width="100%" border="0" cellspacing="1" cellpadding="3">
				<tr>
					<td colspan="2" class="catLeft" align="center" height="28"><b><span class="gen">{L_CONTACT} {USERNAME} </span></b></td>
				</tr>
				<tr> 
					<td valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_EMAIL_ADDRESS}:</span></td>
					<td class="row1" valign="middle" width="100%"><b><span class="gen">{EMAIL_IMG}</span></b></td>
				</tr>
				<tr> 
					<td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_PM}:</span></td>
					<td class="row1" valign="middle"><b><span class="gen">{PM_IMG}</span></b></td>
				</tr>
				<!-- BEGIN msn -->
				<tr> 
					<td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_MESSENGER}:</span></td>
					<td class="row1" valign="middle"><span class="gen">{MSN}</span></td>
				</tr>
				<!-- END msn -->
				<!-- BEGIN yahoo -->
				<tr> 
					<td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_YAHOO}:</span></td>
					<td class="row1" valign="middle"><span class="gen">{YIM_IMG}</span></td>
				</tr>
				<!-- END yahoo -->
				<!-- BEGIN aim -->
				<tr>
					<td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_AIM}:</span></td>
					<td class="row1"><table cellspacing="0" cellpadding="0" border="0"><tr><td nowrap="nowrap"><div style="position:relative;height:18px"><div style="position:absolute">{AIM_IMG}</div><div style="position:absolute;left:3px;top:-1px">{AIM_STATUS_IMG}</div></div></td></tr></table></td>
				</tr>
				<!-- END aim -->
				<!-- BEGIN icq -->
				<tr> 
					<td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_ICQ_NUMBER}:</span></td>
					<td class="row1"><table cellspacing="0" cellpadding="0" border="0"><tr><td nowrap="nowrap"><div style="position:relative;height:18px"><div style="position:absolute">{ICQ_IMG}</div><div style="position:absolute;left:3px;top:-1px">{ICQ_STATUS_IMG}</div></div></td></tr></table></td>
				</tr>
				<!-- END icq -->
				<!-- BEGIN list -->
				<tr>
					<td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_USERGROUPS}:</span></td>
					<td class="row1" valign="middle"><span class="gen">
					<!-- BEGIN groups -->
					{list.groups.SEPARATOR}<a href="{list.groups.U_GROUP_NAME}" class="nav"{list.groups.GROUP_COLOR}{list.groups.GROUP_STYLE}><b>{list.groups.L_GROUP_NAME}</b></a>
					<!-- END groups -->
					</span></td>
				</tr>
				<!-- END list -->
				<!-- BEGIN level -->
				<tr>
					<td valign="top" align="right"><span class="gen">{L_LEVEL}:</span></td>
					<td><b><span class="gen">{LEVEL}</span></b></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td align="left">
						<table cellspacing="0" cellpadding="0" border="0">
							<tr>
								<td align="left"><span class="postdetails">HP:</span></td>
								<td align="right"><span class="postdetails"><b>{HP}</b></span></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2">
									<table cellspacing="0" cellpadding="0" border="0">
										<tr>
											<td><img src="images/level_mod/hp_bar_left.gif" alt="" width="2" height="12"></td>
											<td><img src="images/level_mod/hp_bar_fil.gif" alt="" width="{HP_WIDTH}" height="12"></td>
											<td><img src="images/level_mod/hp_bar_fil_end.gif" alt="" width="1" height="12"></td>
											<td><img src="images/level_mod/level_bar_emp.gif" alt="" width="{HP_EMPTY}" height="12"></td>
											<td><img src="images/level_mod/level_bar_right.gif" alt="" width="1" height="12"></td>
										</tr>
									</table>
								</td>
								<td align="left"><span class="gen">&nbsp;{HP_WIDTH}%</span></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td align="left">
						<table cellspacing="0" cellpadding="0" border="0">
							<tr>
								<td align="left"><span class="postdetails">MP:</span></td>
								<td align="right"><span class="postdetails"><b>{MP}</b></span></td>
								<td>&nbsp;</td>
							</tr>
							<tr> 
								<td colspan="2">
									<table cellspacing="0" cellpadding="0" border="0">
										<tr>
											<td><img src="images/level_mod/mp_bar_left.gif" alt="" width="2" height="12"></td>
											<td><img src="images/level_mod/mp_bar_fil.gif" alt="" width="{MP_WIDTH}" height="12"></td>
											<td><img src="images/level_mod/mp_bar_fil_end.gif" alt="" width="1" height="12"></td>
											<td><img src="images/level_mod/level_bar_emp.gif" alt="" width="{MP_EMPTY}" height="12"></td>
											<td><img src="images/level_mod/level_bar_right.gif" alt="" width="1" height="12"></td>
										</tr>
									</table>
								</td>
								<td align="left"><span class="gen">&nbsp;{MP_WIDTH}%</span></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td align="left">
						<table cellspacing="0" cellpadding="0" border="0">
							<tr>
								<td align="left"><span class="postdetails">EXP:</span></td>
								<td align="right"><span class="postdetails"><b>{EXP}</b></span></td>
								<td>&nbsp;</td>
							</tr>
							<tr> 
								<td colspan="2">
									<table cellspacing="0" cellpadding="0" border="0">
										<tr>
											<td><img src="images/level_mod/exp_bar_left.gif" alt="" width="2" height="12"></td>
											<td><img src="images/level_mod/exp_bar_fil.gif" alt="" width="{EXP_WIDTH}" height="12"></td>
											<td><img src="images/level_mod/exp_bar_fil_end.gif" alt="" width="1" height="12"></td>
											<td><img src="images/level_mod/level_bar_emp.gif" alt="" width="{EXP_EMPTY}" height="12"></td>
											<td><img src="images/level_mod/level_bar_right.gif" alt="" width="1" height="12"></td>
										</tr>
									</table>
								</td>
								<td align="left"><span class="gen">&nbsp;{EXP_WIDTH}%</span></td>
							</tr>
						</table>
					</td>
				</tr>
				<!-- END level -->

			</table>
		</td>
	</tr>
	<!-- BEGIN signature_image -->
	<tr> 
		<td class="catLeft" align="left" width="40%" height="28" colspan="2"><b><span class="gen">{signature_image.L_SIGNATURE}</span></b></td>
	</tr>
	<tr>
		<td align="left" colspan="2" class="row1">{signature_image.SIGNATURE}{signature_image.SIG_IMAGE}</td>
	</tr>
	<!-- END signature_image -->
	<!-- BEGIN photo -->
	<tr> 
		<td class="catLeft" align="center" width="40%" height="28" colspan="2"><b><span class="gen">{photo.L_PHOTO}</span></b></td>
	</tr>
	<tr>
		<td align="center" colspan="2" class="row1">{photo.PHOTO_IMG}</td>
	</tr>
	<!-- END photo -->
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr> 
		<td align="right"><span class="nav"><br></span>{JUMPBOX}</td>
	</tr>
</table>