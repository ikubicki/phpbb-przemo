<style>
@import url('{PATH}/modules/bbcode/main.css');
@import url('{PATH}/modules/shouts/main.css');
</style>
<div class="shoutbox" id="shouts" style="width:800px; margin: auto">
	<h2>{L_SHOUTBOX}</h2>
	<div class="messages" style="height:250px; overflow:auto;"></div>
	<input type="text" name="message" placeholder="{L_GG_MES}" />
	<input type="button" name="submit" value="{L_SEND}" />
	<input type="hidden" name="token" value="" />
</div>
<script src="{PATH}/modules/bbcode/index.js"></script>
<script src="{PATH}/modules/markdown/index.js"></script>
<script src="{PATH}/modules/shouts/index.js"></script>
<script type="text/javascript">
	shouts.init({
		langs: {
            submit: '{L_SEND}',
            cancel: '{L_CANCEL}',
            delete: '{L_DELETE}',
			confirm: '{L_CONFIRM_DELETE}'
		},
		onmessage: (message) => {
			message.text = bbcode.parse(message.text)
			//message.text = markdown.parse(message.text)
			return message
		}
	})
</script>