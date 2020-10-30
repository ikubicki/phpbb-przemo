
<!-- BEGIN attach -->
	<br>
	<hr>
	<!-- BEGIN denyrow -->
	<table width="95%" border="0" cellpadding="2" cellspacing="0">
	<tr>
		<td width="100%" align="left"><i><span class="gen">{postrow.attach.denyrow.L_DENIED}</span></i></td>
	</tr>
	</table>
	<br>
	<!-- END denyrow -->

	<!-- BEGIN cat_stream -->
	<table width="95%" border="0" cellpadding="2" cellspacing="0">
	<tr>
		<td align="left"><span class="gensmall">{postrow.attach.cat_stream.DOWNLOAD_NAME}{postrow.attach.cat_stream.COMMENT}</span></td>
	</tr>
	<tr>
		<td align="left">
		<object id="wmp" classid="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,0,0,0" standby="Loading Microsoft Windows Media Player components..." type="application/x-oleobject">
		<param name="FileName" value="{postrow.attach.cat_stream.U_DOWNLOAD_LINK}">
		<param name="ShowControls" value="1">
		<param name="ShowDisplay" value="0">
		<param name="ShowStatusBar" value="1">
		<param name="AutoSize" value="1">
		<param name="AutoStart" value="0">
		<param name="Visible" value="1">
		<param name="AnimationStart" value="0">
		<param name="Loop" value="0">
		<embed type="application/x-mplayer2" pluginspage="http://www.microsoft.com/windows95/downloads/contents/wurecommended/s_wufeatured/mediaplayer/default.asp" src="{postrow.attach.cat_stream.U_DOWNLOAD_LINK}" name=MediaPlayer2 showcontrols=1 showdisplay=0 showstatusbar=1 autosize=1 autostart=0 visible=1 animationatstart=0 loop=0></embed>
		</object>
		</td>
	</tr>
	<tr>
		<td align="left"><span class="gensmall">{postrow.attach.cat_stream.L_DOWNLOAD_COUNT} {postrow.attach.cat_stream.FILESIZE} {postrow.attach.cat_stream.SIZE_VAR}</span></td>
	</tr>
	</table>
	<br>
	<!-- END cat_stream -->

	<!-- BEGIN cat_swf -->
	<table width="95%" border="0" cellpadding="2" cellspacing="0">
	<tr>
		<td align="left"><span class="gensmall">{postrow.attach.cat_swf.DOWNLOAD_NAME}{postrow.attach.cat_swf.COMMENT}</span></td>
	</tr>
	<tr>
		<td align="left">
		<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" width="{postrow.attach.cat_swf.WIDTH}" height="{postrow.attach.cat_swf.HEIGHT}"> 
		<param name=movie value="{postrow.attach.cat_swf.U_DOWNLOAD_LINK}"> 
		<param name=loop value=1> 
		<param name=quality value=high> 
		<param name=scale value=noborder> 
		<param name=wmode value=transparent> 
		<param name=bgcolor value=#000000> 
		<embed src="{postrow.attach.cat_swf.U_DOWNLOAD_LINK}" loop=1 quality=high scale=noborder wmode=transparent bgcolor=#000000 width="{postrow.attach.cat_swf.WIDTH}" height="{postrow.attach.cat_swf.HEIGHT}" type="application/x-shockwave-flash" pluginspace="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"></embed> 
		</object>
		</td>
	</tr>
	<tr>
		<td align="left"><span class="gensmall">{postrow.attach.cat_swf.L_DOWNLOAD_COUNT} {postrow.attach.cat_swf.FILESIZE} {postrow.attach.cat_swf.SIZE_VAR}</span></td>
	</tr>
	</table>
	<br>
	<!-- END cat_swf -->

	<!-- BEGIN cat_images -->
	<table width="95%" border="0" cellpadding="2" cellspacing="0">
	<tr>
		<td align="left"><span class="gensmall">{postrow.attach.cat_images.DOWNLOAD_NAME}{postrow.attach.cat_images.COMMENT}</span></td>
	</tr>
	<tr>
		<td align="left"><img src="{postrow.attach.cat_images.IMG_SRC}" alt="" border="0"></td>
	</tr>
	<tr>
		<td align="left"><span class="gensmall">{postrow.attach.cat_images.L_DOWNLOAD_COUNT} {postrow.attach.cat_images.FILESIZE} {postrow.attach.cat_images.SIZE_VAR}</span></td>
	</tr>
	</table>
	<br>
	<!-- END cat_images -->

	<!-- BEGIN cat_thumb_images -->
	<table width="95%" border="0" cellpadding="2" cellspacing="0">
	<tr>
		<td align="left"><span class="gensmall">{postrow.attach.cat_thumb_images.DOWNLOAD_NAME}{postrow.attach.cat_thumb_images.COMMENT}</span></td>
	</tr>
	<tr>
		<td align="left"><a href="{postrow.attach.cat_thumb_images.IMG_SRC}"><img src="{postrow.attach.cat_thumb_images.IMG_THUMB_SRC}" alt="" border="0"></a></td>
	</tr>
	<tr>
		<td align="left"><span class="gensmall">{postrow.attach.cat_thumb_images.L_DOWNLOAD_COUNT} {postrow.attach.cat_thumb_images.FILESIZE} {postrow.attach.cat_thumb_images.SIZE_VAR}</span></td>
	</tr>
	</table>
	<br>
	<!-- END cat_thumb_images -->

	<!-- BEGIN attachrow -->
	<table width="95%" border="0" cellpadding="2" cellspacing="0">
	<tr>
		<td align="left"><span class="gensmall">{postrow.attach.attachrow.DOWNLOAD_NAME}{postrow.attach.attachrow.COMMENT}</span></td>
	</tr>
	<tr>
		<td align="left"><span class="gensmall">{postrow.attach.attachrow.S_UPLOAD_IMAGE}<a href="{postrow.attach.attachrow.U_DOWNLOAD_LINK}" {postrow.attach.attachrow.TARGET_BLANK} class="genmed"><b>{L_DOWNLOAD}</b></a> {postrow.attach.attachrow.L_DOWNLOAD_COUNT} {postrow.attach.attachrow.FILESIZE} {postrow.attach.attachrow.SIZE_VAR}</span></td>
	</tr>
	</table>
	<br>
	<!-- END attachrow -->	
<!-- END attach -->
