
    </td>
  </tr>
</table>
<style>
@import url('/modules/shouts/main.css')
</style>
<div class="shoutbox" id="shouts" style="width:800px; margin: auto">
	<h2>{L_SHOUTBOX}</h2>
	<div class="messages" style="height:250px; overflow:auto;"></div>
	<input type="text" name="message" placeholder="{L_GG_MES}" />
	<input type="button" name="submit" value="{L_SEND}" />
	<input type="hidden" name="token" value="" />
</div>
<script src="/modules/shouts/index.js"></script>
<script type="text/javascript">
	shouts.init({
		langs: {
            submit: '{L_SEND}',
            cancel: '{L_CANCEL}',
            delete: '{L_DELETE}'
		}
	})
</script>
<table width="100%" cellspacing="0" cellpadding="7" border="0" align="center">
   <tr>
      <td class="bodyline">