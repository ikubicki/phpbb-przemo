<!DOCTYPE HTML>
<html dir="{S_CONTENT_DIRECTION}">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}">
  <meta http-equiv="Content-Style-Type" content="text/css">
  {META_DESC}
  {META}
  <title>{SITENAME} :: {PAGE_TITLE}</title>
  <link rel="stylesheet" href="templates/subSilver/{T_HEAD_STYLESHEET}" type="text/css">
	<script language="Javascript" type="text/javascript">
	<!--
	var factive_color = '{T_ACTIVE_COLOR}';
	var faonmouse_color = '{T_ONMOUSE_COLOR}';
	var faonmouse2_color = '{T_ONMOUSE2_COLOR}';
	var l_empty_message = '{L_EMPTY_MESSAGE}';
	var no_text_selected = '{L_NO_TEXT_SELECTED}';
	var cname = '{UNIQUE_COOKIE_NAME}';
	var cpath = '{COOKIE_PATH}';
	var cdomain = '{COOKIE_DOMAIN}';
	var csecure = '{COOKIE_SECURE}';
	<!-- BEGIN switch_enable_pm_popup -->
	if ( {PRIVATE_MESSAGE_NEW_FLAG} )
	{
		window.open('{U_PRIVATEMSGS_POPUP}', '_phpbbprivmsg', 'HEIGHT=225, resizable=yes, WIDTH=400');
	}
	<!-- END switch_enable_pm_popup -->
	<!-- BEGIN switch_report_popup -->
	report = window.open('{switch_report_popup.U_REPORT_POPUP}', '_phpbbreport', 'HEIGHT={switch_report_popup.S_HEIGHT}, resizable=yes, scrollbars=yes, WIDTH={switch_report_popup.S_WIDTH}');
	report.focus();
	<!-- END switch_report_popup -->
	var rmw_max_width = 400;
	var rmw_border_1 = '0px solid {T_BODY_LINK}';
	var rmw_border_2 = '0px dotted {T_BODY_LINK}';
	var rmw_image_title = '';
	var img_addr = '{IMG_ADDR}';
	//-->
	</script>
	<script language="JavaScript" type="text/javascript" src="images/jsscripts.js"></script>
	<script type="text/javascript" src="images/jQuery.js"></script>
	<!-- BEGIN overlib -->
	<script language="JavaScript" type="text/javascript" src="templates/{STYLE_NAME}/overlib.js"><!-- overLIB (c) Erik Bosrup --></script>
	<!-- END overlib -->
	<script language="JavaScript" type="text/javascript" src="images/rmw_jslib.js"></script>
</head>
<body bgcolor="{T_BODY_BGCOLOR}" text="{T_BODY_TEXT}" link="{T_BODY_LINK}" vlink="{T_BODY_VLINK}" onload="focus_field('focus');">
<!-- BEGIN body_with_loading -->
<script language="Javascript" type="text/javascript">
<!--
	document.write('<div id="hidepage" style="position: absolute; left:0px; top:0px; height: 100%; width: 100%; background-color: {T_BODY_BGCOLOR}; layer-background-color: {T_BODY_BGCOLOR};"><table width="100%" style="height: 100%"><tr><td align="center" valign="middle"><table width="50%" align="center" style="border: 1px solid {T_BODY_LINK}, solid"><tr><td align="center" class="row1"><span class="genmed"><br><b>{L_PAGE_LOAD_PLEASE_WAIT}<br><br><img src="images/loading.gif" alt=""><br><br>{PAGE_LOADING_STOP}<br>&nbsp;<\/span><\/td><\/tr><\/table><\/td><\/tr><\/table><\/div>');
//-->
</script>
<!-- END body_with_loading -->
<!-- BEGIN body_without_loading -->
<!-- END body_without_loading -->
<!-- BEGIN overlib -->
<div id="overDiv" style="position:absolute; visibility:hidden; filter: alpha(opacity=85); -moz-opacity: 0.85; opacity: 0.85; z-index: 10"></div>
<!-- END overlib -->
<!-- BEGIN advert -->
<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
	<tr>
		<td valign="top">
<!-- END advert -->

<!-- BEGIN forum_thin -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="{forum_thin.WIDTH_COLOR_1}">
<tr>
<td align="center">
<table width="{forum_thin.WIDTH_TABLE}" border="0" bgcolor="{forum_thin.WIDTH_COLOR_2}" cellpadding="0" cellspacing="{forum_thin.TABLE_BORDER}">
<tr>
<td align="center">
<!-- END forum_thin -->
<a name="top"></a>{ROTATE_BANNER_1}
<!-- BEGIN header -->
<table width="100%" border="0" align="center">
	<tr>
		<td width="10%" valign="middle">
			<a href="{U_INDEX}"><img src="templates/subSilver/images/przemo.png" border="0" alt="{L_INDEX}" vspace="1" height="100"></a>
		</td>
		<td width="80%" valign="middle" align="center">
			<span class="maintitle">{SITENAME_COLOR}</span>
			<br>
			<span class="gen">{SITE_DESCRIPTION}<br><br></span>
		</td>
		<td align="center" width="10%">
			<!-- BEGIN switch_page_avatar -->
			{MY_AVATAR_IMG}
			<!-- END switch_page_avatar -->
		</td>
	</tr>
	<tr>
		<td align="center" colspan="3">
			<span class="mainmenu">
				<a href="{U_FAQ}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_faq.gif" width="12" height="13" border="0" alt="{L_FAQ}" hspace="3">{L_FAQ}</a>
				&nbsp;<a href="{U_SEARCH}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_search.gif" width="12" height="13" border="0" alt="{L_SEARCH}" hspace="3">{L_SEARCH}</a>
				&nbsp;<a href="{U_MEMBERLIST}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_members.gif" width="12" height="13" border="0" alt="{L_MEMBERLIST}" hspace="3">{L_MEMBERLIST}</a>
				&nbsp;<a href="{U_GROUP_CP}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_groups.gif" width="12" height="13" border="0" alt="{L_USERGROUPS}" hspace="3">{L_USERGROUPS}</a>

				<!-- BEGIN switch_user_logged_in -->
				<!-- BEGIN statistics -->
				&nbsp;<a href="{U_STAT}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_statistics.gif" width="12" height="13" border="0" alt="{L_STATISTICS}" hspace="3">{L_STATISTICS}</a>
				<!-- END statistics -->
			</span>
			<span class="mainmenu">
				<a href="{U_PROFILE}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_profile.gif" width="12" height="13" border="0" alt="{L_PROFILE}" hspace="3">{L_PROFILE}</a>
				&nbsp;<a href="{U_PRIVATEMSGS}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_message.gif" width="12" height="13" border="0" alt="{PRIVATE_MESSAGE_INFO}" hspace="3">{PRIVATE_MESSAGE_INFO}</a>
				&nbsp;<a href="{U_LOGIN_LOGOUT}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_login.gif" width="12" height="13" border="0" alt="{L_LOGIN_LOGOUT}" hspace="3">{L_LOGIN_LOGOUT}</a>
				<!-- END switch_user_logged_in -->

				<!-- BEGIN switch_user_logged_out -->
				<!-- BEGIN statistics -->
				&nbsp;<a href="{U_STAT}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_statistics.gif" width="12" height="13" border="0" alt="{L_STATISTICS}" hspace="3">{L_STATISTICS}</a>
				<!-- END statistics -->
			</span>
			<span class="mainmenu">
				<a href="{U_REGISTER}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_register.gif" width="12" height="13" border="0" alt="{L_REGISTER}" hspace="3">{L_REGISTER}</a>
				&nbsp;<a href="{U_LOGIN_LOGOUT}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_login.gif" width="12" height="13" border="0" alt="{L_LOGIN_LOGOUT}" hspace="3">{L_LOGIN_LOGOUT}</a>
				<!-- END switch_user_logged_out -->
				<!-- BEGIN switch_report_list -->
				&nbsp;<a href="{switch_report_list.U_REPORT_LIST}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_report_list.gif" width="12" height="13" border="0" alt="{switch_report_list.L_REPORT_LIST}" hspace="3">{switch_report_list.L_REPORT_LIST}</a></span>&nbsp;
				<!-- END switch_report_list -->
			</span>
		</td>
	</tr>
</table>
<!-- END header -->
<br />
<table width="100%" cellspacing="0" cellpadding="7" border="0" align="center">
   <tr>
      <td class="bodyline">
	  {FORUM_WARNINGS}
         {ROTATE_BANNER_2}{BANNER_TOP}
		<!-- BEGIN simple_header -->
		<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
			<tr>
				<th>{SITENAME}</th>
			</tr>
			<tr>
				<td class="cat" align="center">
					<!-- BEGIN switch_user_logged_in -->
					&bull; <a href="{U_FAQ}" class="mainmenu">{L_FAQ}</a> &bull; <a href="{U_SEARCH}" class="mainmenu">{L_SEARCH}</a> &bull; <a href="{U_MEMBERLIST}" class="mainmenu">{L_MEMBERLIST}</a> &bull; <a href="{U_GROUP_CP}" class="mainmenu">{L_USERGROUPS}</a>
					<!-- BEGIN statistics -->
					&bull; <a href="{U_STAT}" class="mainmenu">{L_STATISTICS}</a>
					<!-- END statistics -->
					&bull; <a href="{U_PROFILE}" class="mainmenu">{L_PROFILE}</a> &bull; <a href="{U_PRIVATEMSGS}" class="mainmenu">{PRIVATE_MESSAGE_INFO}</a> &bull; <a href="{U_LOGIN_LOGOUT}" class="mainmenu">{L_LOGIN_LOGOUT}</a>
					<!-- END switch_user_logged_in -->
					<!-- BEGIN switch_user_logged_out -->
					&bull; <a href="{U_FAQ}" class="mainmenu">{L_FAQ}</a>
					&bull; <a href="{U_SEARCH}" class="mainmenu">{L_SEARCH}</a> &bull; <a href="{U_MEMBERLIST}" class="mainmenu">{L_MEMBERLIST}</a> &bull; <a href="{U_GROUP_CP}" class="mainmenu">{L_USERGROUPS}</a>
					<!-- BEGIN statistics -->
					&bull; <a href="{U_STAT}" class="mainmenu">{L_STATISTICS}</a>
					<!-- END statistics -->
					&bull; <a href="{U_REGISTER}" class="mainmenu">{L_REGISTER}</a> &bull; <a href="{U_LOGIN_LOGOUT}" class="mainmenu">{L_LOGIN_LOGOUT}</a>
					<!-- END switch_user_logged_out -->
					<!-- BEGIN switch_report_list -->
					&bull; <a href="{switch_report_list.U_REPORT_LIST}" class="mainmenu">{switch_report_list.L_REPORT_LIST}</a>
					<!-- END switch_report_list -->
					&bull;
				</span></td>
            </tr>
         </table>
         <!-- END simple_header -->
      {ROTATE_BANNER_3}
      <!-- BEGIN switch_enable_board_msg --> 
	  <div id="hm" style="display: ''; position: relative;">
      <table width="100%" class="forumline" cellspacing="1" cellpadding="3" border="0" align="center">
        <tr> 
         <th class="thCornerL" height="25" nowrap="nowrap" onclick="javascript:ShowHide('hm','hm2','hm3');" style="cursor: pointer" title="{L_VHIDE}">&nbsp;{L_BOARD_MSG}&nbsp;</th>
        </tr>
        <tr>
         <td class="row1"><span class="gen">{BOARD_MSG}</span></td>
        </tr>
      </table>
	</div>
	<div id="hm2" style="display: none; position: relative;">
	<table width="100%" class="forumline" cellspacing="1" cellpadding="3" border="0" align="center">
	  <tr> 
	   <th class="thCornerL" height="25" nowrap="nowrap" onclick="javascript:ShowHide('hm','hm2','hm3');" style="cursor: pointer">&nbsp;{L_BOARD_MSG}&nbsp;</th>
	  </tr>
	</table>
	</div>
	<script language="javascript" type="text/javascript">
	<!--
	if(GetCookie('hm3') == '2') ShowHide('hm', 'hm2', 'hm3');
	//-->
	</script>
	<!-- END switch_enable_board_msg -->