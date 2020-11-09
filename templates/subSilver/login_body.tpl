<style>
@import url('{PATH}/modules/auth-facebook/main.css');
</style>
<form action="{S_LOGIN_ACTION}" method="post" target="_top">
<table class="forumline posting nolength">
	<tr>
		<th colspan="3">{L_ENTER_PASSWORD}</th>
	</tr>
	<tr>
		<td class="row1" align="right"><span class="gen">{L_USERNAME}:</span></td>
		<td class="row1">
			<input type="text" name="username" maxlength="40" value="{USERNAME}" />
		</td>
		<td class="row1" align="right">&nbsp;</td>
	</tr>
	<tr>
		<td class="row1" align="right"><span class="gen">{L_PASSWORD}:</span></td>
		<td class="row1">
			<input type="password" name="password" maxlength="40" />
		</td>
		<td class="row1" align="right">&nbsp;</td>
	</tr>
	<!-- BEGIN switch_allow_autologin -->
	<tr align="center">
		<td class="row1 right">
			<input type="checkbox" name="autologin" id="autologincheck" />
		</td>
		<td class="row1 left" colspan="2">
			<label for="autologincheck"><span class="gen">{L_AUTO_LOGIN}</span></label>
		</td>
	</tr>
	<!-- END switch_allow_autologin -->
	<tr>
		<td width="50%" class="submit">&nbsp;</td>
		<td width="25%" class="submit left">
			{S_HIDDEN_FIELDS}
			<input type="submit" name="login" value="{L_LOGIN}" />
			<input id="facebook_login_btn" type="button" class="facebook" value="Zaloguj z Facebook" />
		</td>
		<td width="25%" class="submit right">
			<a href="{U_SEND_PASSWORD}">{L_SEND_PASSWORD}</a>
		</td>
	</tr>
</table>
</form>
<script src="{PATH}/modules/auth-facebook/index.js"></script>
<script>
	auth.facebook.init({
		appid: '257433195682871'
	})
	auth.facebook.onclick('#facebook_login_btn')
</script>