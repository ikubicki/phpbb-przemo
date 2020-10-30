<h1>{L_CONFIGURATION_TITLE}</h1>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td nowrap="nowrap" align="center" width="13%" style="border-bottom : 1px solid Black;">
		<table cellpadding="2" cellspacing="0" border="0" width="100%" class="bodyline">
		<tr><td nowrap="nowrap" class="row3" align="center">
		&nbsp;&nbsp;<a href="{S_CONFIG_ACTION}&amp;mode=config" class="nav">{L_CONFIG}</a>&nbsp;&nbsp;</td></tr></table></td>
	<td nowrap="nowrap" align="center" width="13%" style="border-bottom : 1px solid Black;">
		<table cellpadding="2" cellspacing="0" border="0" width="100%" class="bodyline">
		<tr><td nowrap="nowrap" class="row3" align="center">
		&nbsp;&nbsp;<a href="{S_CONFIG_ACTION}&amp;mode=addons" class="nav">{L_ADDONS}</a>&nbsp;&nbsp;</td></tr></table></td>
	<td nowrap="nowrap" align="center" width="13%" style="border-bottom : 1px solid Black;">
		<table cellpadding="2" cellspacing="0" border="0" width="100%" class="bodyline">
		<tr><td nowrap="nowrap" class="row3" align="center">
		&nbsp;&nbsp;<a href="{S_CONFIG_ACTION}&amp;mode=main_page" class="nav">{L_MAIN_PAGE}</a>&nbsp;&nbsp;</td></tr></table></td>
	<td nowrap="nowrap" align="center" width="13%" style="border-bottom : 1px solid Black;">
		<table cellpadding="2" cellspacing="0" border="0" width="100%" class="bodyline">
		<tr><td nowrap="nowrap" class="row3" align="center">
		&nbsp;&nbsp;<a href="{S_CONFIG_ACTION}&amp;mode=viewtopic" class="nav">{L_VIEWTOPIC}</a>&nbsp;&nbsp;</td></tr></table></td>
	<td class="row1" nowrap="nowrap" align="center" width="13%" style="border-left : 1px solid Black; border-top : 1px solid Black; border-right : 1px solid Black; "><span class="nav"><b>&nbsp;&nbsp;{L_PROFILE}&nbsp;&nbsp;</b></span></td>
	<td nowrap="nowrap" align="center" width="13%" style="border-bottom : 1px solid Black;">
		<table cellpadding="2" cellspacing="0" border="0" width="100%" class="bodyline">
		<tr><td nowrap="nowrap" class="row3" align="center">
		&nbsp;&nbsp;<a href="{S_CONFIG_ACTION}&amp;mode=posting" class="nav">{L_POSTING}</a>&nbsp;&nbsp;</td></tr></table></td>
	<td nowrap="nowrap" align="center" width="22%" style="border-bottom : 1px solid Black;">&nbsp;</td>
</tr>
<tr>
	<td colspan="7" class="row1" style="border-left : 1px solid Black; border-bottom : 1px solid Black; border-right : 1px solid Black;">
		<table cellpadding="0" cellspacing="6" width="100%" border="1">
		<tr>
			<td class="row1">
				<form action="{S_CONFIG_ACTION}" method="post"><table width="100%" cellpadding="2" cellspacing="1" border="0" align="center" class="forumline">
				<tr>
					<th colspan="2">{L_ADDON_PROFILE}</th>
				</tr>
				<tr>
					<td class="row1">{L_VALIDATION}<br><span class="gensmall">{L_CVALIDATEE}</span></td>
					<td class="row2" width="50%"><input type="radio" name="validate" value="1" {CVALIDATE_YES}> {L_YES} <input type="radio" name="validate" value="0" {CVALIDATE_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_REQUIRE_AIM}<br><span class="gensmall">{L_REQUIRE_AIM_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="require_aim" value="1" {REQUIRE_AIM_YES}> {L_YES} <input type="radio" name="require_aim" value="0" {REQUIRE_AIM_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_REQUIRE_WEBSITE}<br><span class="gensmall">{L_REQUIRE_WEBSITE_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="require_website" value="1" {REQUIRE_WEBSITE_YES}> {L_YES} <input type="radio" name="require_website" value="0" {REQUIRE_WEBSITE_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_REQUIRE_LOCATION}<br><span class="gensmall">{L_REQUIRE_LOCATION_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="require_location" value="1" {REQUIRE_LOCATION_YES}> {L_YES} <input type="radio" name="require_location" value="0" {REQUIRE_LOCATION_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_MAX_SIG_LOCATION}</td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="3" maxlength="4" name="max_sig_location" value="{MAX_SIG_LOCATION}"></td>
				</tr>
				<tr>
					<td class="row1">{L_GENDER}<br><span class="gensmall">{L_GENDER_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="gender" value="1" {GENDER_YES}> {L_YES} <input type="radio" name="gender" value="0" {GENDER_NO}>{L_NO}
					<br>&nbsp;<input type="radio" name="require_gender" value="1" {REQUIRE_GENDER_YES}> {L_YES} <input type="radio" name="require_gender" value="0" {REQUIRE_GENDER_NO}>{L_NO}&nbsp;&nbsp;{L_REQUIRE_GENDER}</td>
				</tr>
				<tr>
					<td class="row1">{L_CICQ}<br><span class="gensmall">{L_LICQ}</span></td>
					<td class="row2" width="50%"><input type="radio" name="cicq" value="1" {CICQ_YES}> {L_YES} <input type="radio" name="cicq" value="0" {CICQ_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_CLLOGIN}<br><span class="gensmall">{L_LLLOGIN}</span></td>
					<td class="row2" width="50%"><input type="radio" name="cllogin" value="1" {CLLOGIN_YES}> {L_YES} <input type="radio" name="cllogin" value="0" {CLLOGIN_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_CLEVELP}<br><span class="gensmall">{L_LLEVELP}</span></td>
					<td class="row2" width="50%"><input type="radio" name="clevelp" value="1" {CLEVELP_YES}> {L_YES} <input type="radio" name="clevelp" value="0" {CLEVELP_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_CYAHOO}<br><span class="gensmall">{L_LYAHOO}</span></td>
					<td class="row2" width="50%"><input type="radio" name="cyahoo" value="1" {CYAHOO_YES}> {L_YES} <input type="radio" name="cyahoo" value="0" {CYAHOO_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_CMSN}<br><span class="gensmall">{L_LMSN}</span></td>
					<td class="row2" width="50%"><input type="radio" name="cmsn" value="1" {CMSN_YES}> {L_YES} <input type="radio" name="cmsn" value="0" {CMSN_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_CJOB}<br><span class="gensmall">{L_LJOB}</span></td>
					<td class="row2" width="50%"><input type="radio" name="cjob" value="1" {CJOB_YES}> {L_YES} <input type="radio" name="cjob" value="0" {CJOB_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_CINTER}<br><span class="gensmall">{L_LINTER}</span></td>
					<td class="row2" width="50%"><input type="radio" name="cinter" value="1" {CINTER_YES}> {L_YES} <input type="radio" name="cinter" value="0" {CINTER_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_CEMAIL}<br><span class="gensmall">{L_LEMAIL}</span></td>
					<td class="row2" width="50%"><input type="radio" name="cemail" value="1" {CEMAIL_YES}> {L_YES} <input type="radio" name="cemail" value="0" {CEMAIL_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_CBBCODE}<br><span class="gensmall">{L_LBBCODE}</span></td>
					<td class="row2" width="50%"><input type="radio" name="cbbcode" value="1" {CBBCODE_YES}> {L_YES} <input type="radio" name="cbbcode" value="0" {CBBCODE_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_CHTML}<br><span class="gensmall">{L_LHTML}</span></td>
					<td class="row2" width="50%"><input type="radio" name="chtml" value="1" {CHTML_YES}> {L_YES} <input type="radio" name="chtml" value="0" {CHTML_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_CSMILES}<br><span class="gensmall">{L_LSMILES}</span></td>
					<td class="row2" width="50%"><input type="radio" name="csmiles" value="1" {CSMILES_YES}> {L_YES} <input type="radio" name="csmiles" value="0" {CSMILES_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_CLANG}<br><span class="gensmall">{L_LLANG}</span></td>
					<td class="row2" width="50%"><input type="radio" name="clang" value="1" {CLANG_YES}> {L_YES} <input type="radio" name="clang" value="0" {CLANG_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_CTIMEZONE}<br><span class="gensmall">{L_LTIMEZONE}</span></td>
					<td class="row2" width="50%"><input type="radio" name="ctimezone" value="1" {CTIMEZONE_YES}> {L_YES} <input type="radio" name="ctimezone" value="0" {CTIMEZONE_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_CBSTYLE}<br><span class="gensmall">{L_LBSTYLE}</span></td>
					<td class="row2" width="50%"><input type="radio" name="cbstyle" value="1" {CBSTYLE_YES}> {L_YES} <input type="radio" name="cbstyle" value="0" {CBSTYLE_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1"><span class="gensmall">{L_VIEWONLINE}</span></td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="1" maxlength="1" name="viewonline" value="{VIEWONLINE}"></td>
				</tr>
				<tr>
					<th colspan="2">{L_AVATAR_SETTINGS}</th>
				</tr>
				<tr>
					<td class="row1">{L_ALLOW_LOCAL}</td>
					<td class="row2" width="50%"><input type="radio" name="allow_avatar_local" value="1" {AVATARS_LOCAL_YES}> {L_YES}&nbsp;&nbsp;<input type="radio" name="allow_avatar_local" value="0" {AVATARS_LOCAL_NO}> {L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_ALLOW_REMOTE} <br><span class="gensmall">{L_ALLOW_REMOTE_EXPLAIN}</span></td>
					<td class="row2" width="50%"><input type="radio" name="allow_avatar_remote" value="1" {AVATARS_REMOTE_YES}> {L_YES}&nbsp;&nbsp;<input type="radio" name="allow_avatar_remote" value="0" {AVATARS_REMOTE_NO}> {L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_ALLOW_UPLOAD}</td>
					<td class="row2" width="50%"><input type="radio" name="allow_avatar_upload" value="1" {AVATARS_UPLOAD_YES}> {L_YES}&nbsp;&nbsp;<input type="radio" name="allow_avatar_upload" value="0" {AVATARS_UPLOAD_NO}> {L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_ALLOW_AVATAR}<br><span class="gensmall">{L_ALLOW_AVATAR_EXPLAIN}</span></td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="5" maxlength="4" name="allow_avatar" value="{ALLOW_AVATAR}"></td>
				</tr>
				<tr>
					<td class="row1">{L_MAX_FILESIZE}<br><span class="gensmall">{L_MAX_FILESIZE_EXPLAIN}</span></td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="6" maxlength="10" name="avatar_filesize" value="{AVATAR_FILESIZE}"></td>
				</tr>
				<tr>
					<td class="row1">{L_MAX_AVATAR_SIZE} <br>
					<span class="gensmall">{L_MAX_AVATAR_SIZE_EXPLAIN}</span></td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="3" maxlength="4" name="avatar_max_height" value="{AVATAR_MAX_HEIGHT}"> x <input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="3" maxlength="4" name="avatar_max_width" value="{AVATAR_MAX_WIDTH}"></td>
				</tr>
				<tr>
					<td class="row1">{L_AVATAR_STORAGE_PATH} <br><span class="gensmall">{L_AVATAR_STORAGE_PATH_EXPLAIN}</span></td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="20" maxlength="255" name="avatar_path" value="{AVATAR_PATH}"></td>
				</tr>
				<tr>
					<td class="row1">{L_AVATAR_GALLERY_PATH} <br><span class="gensmall">{L_AVATAR_GALLERY_PATH_EXPLAIN}</span></td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="20" maxlength="255" name="avatar_gallery_path" value="{AVATAR_GALLERY_PATH}"></td>
				</tr>
				<tr>
					<th colspan="2">{L_PROFLE_PHOTO_SETTINGS}</th>
				</tr>
				<tr>
					<td class="row1">{L_ALLOW_PHOTO_REMOTE} <br><span class="gensmall">{L_ALLOW_PHOTO_REMOTE_EXPLAIN}</span></td>
					<td class="row2" width="50%"><input type="radio" name="allow_photo_remote" value="1" {PHOTO_REMOTE_YES}> {L_YES}&nbsp;&nbsp;<input type="radio" name="allow_photo_remote" value="0" {PHOTO_REMOTE_NO}> {L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_ALLOW_PHOTO_UPLOAD}</td>
					<td class="row2" width="50%"><input type="radio" name="allow_photo_upload" value="1" {PHOTO_UPLOAD_YES}> {L_YES}&nbsp;&nbsp;<input type="radio" name="allow_photo_upload" value="0" {PHOTO_UPLOAD_NO}> {L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_PHOTO_MAX_FILESIZE}<br><span class="gensmall">{L_PHOTO_MAX_FILESIZE_EXPLAIN}</span></td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="6" maxlength="10" name="photo_filesize" value="{PHOTO_FILESIZE}"> Bytes</td>
				</tr>
				<tr>
					<td class="row1">{L_MAX_PHOTO_SIZE}<br>
					<span class="gensmall">{L_MAX_AVATAR_SIZE_EXPLAIN}</span></td><td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="3" maxlength="4" name="photo_max_height" value="{PHOTO_MAX_HEIGHT}"> x <input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="3" maxlength="4" name="photo_max_width" value="{PHOTO_MAX_WIDTH}"></td>
				</tr>
				<tr>
					<td class="row1">{L_PHOTO_STORAGE_PATH} <br><span class="gensmall">{L_PHOTO_STORAGE_PATH_EXPLAIN}</span></td>
					<td class="row2" width="50%"><input type="text" class="post" onFocus="Active(this)" onBlur="NotActive(this)" size="20" maxlength="255" name="photo_path" value="{PHOTO_PATH}"></td>
				</tr>
				<tr>
					<th colspan="2">{L_SIGNATURE_SETTINGS}</th>
				</tr>
				<tr>
					<td class="row1">{L_ALLOW_SIG}</td>
					<td class="row2" width="50%"><input type="radio" name="allow_sig" value="1" {SIG_YES}> {L_YES}&nbsp;&nbsp;<input type="radio" name="allow_sig" value="0" {SIG_NO}> {L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_ALLOW_SIG_IMAGE}</td>
					<td class="row2" width="50%"><input type="radio" name="allow_sig_image" value="1" {SIG_IMAGE_YES}> {L_YES}&nbsp;&nbsp;<input type="radio" name="allow_sig_image" value="0" {SIG_IMAGE_NO}> {L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_ALLOW_IMG_BBCODE}<br><span class="gensmall">{L_ALLOW_IMG_BBCODE_E}</span></td>
					<td class="row2" width="50%"><input type="radio" name="allow_sig_image_img" value="1" {SIG_IMAGE_IMG_YES}> {L_YES} <input type="radio" name="allow_sig_image_img" value="0" {SIG_IMAGE_IMG_NO}>{L_NO}</td>
				</tr>
				<tr>
					<td class="row1">{L_MAX_SIG_LENGTH}</td>
					<td class="row2" width="50%"><input class="post" onFocus="Active(this)" onBlur="NotActive(this)" type="text" size="5" maxlength="4" name="max_sig_chars" value="{SIG_SIZE}"></td>
				</tr>
				<tr>
					<td class="row1">{L_MAX_SIG_FILESIZE}</td>
					<td class="row2" width="50%"><input class="post" onFocus="Active(this)" onBlur="NotActive(this)" type="text" size="6" maxlength="10" name="sig_image_filesize" value="{SIG_IMAGE_FILESIZE}"></td>
				</tr>
				<tr>
					<td class="row1">{L_MAX_SIG_IMAGE_SIZE}</td>
					<td class="row2" width="50%"><input class="post" onFocus="Active(this)" onBlur="NotActive(this)" type="text" size="3" maxlength="4" name="sig_image_max_height" value="{SIG_IMAGE_MAX_HEIGHT}"> x <input class="post" onFocus="Active(this)" onBlur="NotActive(this)" type="text" size="3" maxlength="4" name="sig_image_max_width" value="{SIG_IMAGE_MAX_WIDTH}"></td>
				</tr>
				<tr>
					<td class="row1">{L_SIG_IMAGES_STORAGE_PATH} <br><span class="gensmall">{L_SIG_IMAGES_STORAGE_PATH_EXPLAIN}</span></td>
					<td class="row2" width="50%"><input class="post" onFocus="Active(this)" onBlur="NotActive(this)" type="text" size="20" maxlength="255" name="sig_images_path" value="{SIG_IMAGES_PATH}"></td>
				</tr>

				<tr>
					<td class="submit" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption">&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption"></td>
				</tr>
				</form>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>
</table>

<br clear="all">
