var g_lastMessageID = 0;
var g_disaBled123 = 0;
var g_reqCount = 0;
var g_maxReqCount = 200;
var g_mTimer;

function sendMessage()
{
	if ($.trim( $('#messageBox').val() ) != '')
	{
		var message = $('#messageBox').attr('value');
		var uid = $('#userName').attr('value');
		indicator_switch(1);
		$.ajax({
			cache: false,
			type: 'POST',
			dataType: 'json',
			url: 'shoutbox_view.php',
			data: 'last='+g_lastMessageID+'&mode=add&uid='+encodeURIComponent(uid)+'&message='+encodeURIComponent(message),		
			beforeSend: function(xhr) {xhr.setRequestHeader('Shoutbox','shoutbox_js');},
			success: handleReceivingMessages,
			complete: function() {indicator_switch(0);}
		});
		$('#messageBox').attr('value', '').focus();
		if ($('#zmien').css('display') == 'inline')
		{
			$('#userId').attr('value', '');
			$('#zmien').css('display', 'none');
			$('#anuluj1').css('display', 'none');
		}
		clearInterval(g_mTimer);
		g_mTimer = setTimeout('requestNewMessages();', updateInterval);
	}
}
function anuluj1() 
{
	$('#messageBox').attr('value', '').focus();
	$('#userId').attr('value', '');
	$('#zmien').css('display', 'none');
	$('#anuluj1').css('display', 'none');
	$('#wyslij').css('display', 'inline');
}
function removeShout(id)
{
	var el = $('#sb_msg_'+id);
	if (el){el.remove()}	
	$.ajax({
		type: 'POST',
		cache: false,
		dataType: 'json',
		url: 'shoutbox_view.php',
		data: 'last='+g_lastMessageID+'&mode=delete&del='+id,	
		beforeSend: function(xhr) {xhr.setRequestHeader('Shoutbox','shoutbox_js');},
		success: handleReceivingMessages
	});
	anuluj1();
}
function editShout(id) 
{
	var text = new String($('#edit_' + id).html());
	text = text.replace(/<(u|U|b|B|i|I)\>/g, "[$1]");
	text = text.replace(/<(\/u|\/U|\/b|\/B|\/i|\/I)\>/g, "[$1]");
	text = text.replace(/<\/(span|SPAN)\>/g, "[/color]");
	text = text.replace(/<(a|A)(.*?)href=\"(.*?)\"(.*?)\>(.*?)\<\/(a|A)\>/g, "$3");
    text = text.replace(/<(img|IMG)(.*?) title=\"(.*?)\"(.*?)>/g, "<$1$2$4>");
    text = text.replace(/<(img|IMG)(.*?)alt=\"(.*?)\"(.*?)> /g, "$3");
	text = text.replace(/<(img|IMG)(.*?)alt=(.*?)(.*?)>/g, "$3");
	text = text.replace(/<(span|SPAN)(.*?)style=\"(color|COLOR):(.*?)(\#[0-9A-F]{6}|[a-z]+)(.*?)\">/g, "[color=$5]"); 
	text = text.replace(/&lt;/g, "<");
	text = text.replace(/&gt;/g, ">");
	text = text.replace(/&amp;/g, "&");
	$('#messageBox').attr('value', text).focus();
	$('#userId').attr('value', id);
	$('#zmien').css('display', 'inline');
	$('#anuluj1').css('display', 'inline');
	$('#wyslij').css('display', 'none');
}
function delInfo(id)
{
	var el = $('#sb_msg_'+id);
	if (el){el.remove()}
	$('#wyslij').removeAttr('disabled');
	$('#messageBox').removeAttr('disabled');
}
function sendEditShout() 
{
	var msg = new String( $('#messageBox').attr('value') );
	msg = msg.replace(/\[B\]/g, "[b]");
	msg = msg.replace(/\[\/B\]/g, "[/b]");
	msg = msg.replace(/\[U\]/g, "[u]");
	msg = msg.replace(/\[\/U\]/g, "[/u]");
	msg = msg.replace(/\[I\]/g, "[i]");
	msg = msg.replace(/\[\/I\]/g, "[/i]");
	msg = msg.replace(/\[COLOR\=(\#[0-9A-F]{6}|[a-z]+)\]/g, "[color=$1]");
	msg = msg.replace(/\[\/COLOR\]/g, "[/color]");
	msg = msg.replace(/&lt;/g, "<");
	msg = msg.replace(/&gt;/g, ">");
	msg = msg.replace(/&amp;/g, "&");
	if ( $.trim(msg) != '' )
	{
		var id = $('#userId').attr('value');
		$.ajax({
			type: 'POST',
			cache: false,
			dataType: 'json',
			url: 'shoutbox_view.php',
			data: 'last='+g_lastMessageID+'&mode=edit'+'&id='+$('#userName').attr('value')+'&edit_id='+id +'&message='+msg,
			beforeSend: function(xhr) {xhr.setRequestHeader('Shoutbox','shoutbox_js');},
			success: handleReceivingMessages
		});
		msg = msg.replace(/\[(u|U|b|B|i|I)\]/g, "<$1>");
		msg = msg.replace(/\[(\/u|\/U|\/b|\/B|\/i|\/I)\]/g, "<$1>");
		msg = msg.replace(/\[\/color\]/g, "</span>");
		msg = msg.replace(/\[color\=(\#[0-9A-F]{6}|[a-z]+)\]/g, "<span style=\"color: $1;\">");
		msg = msg.replace(/(http:\/\/[a-z.][^\n\s]*)/g, "<a href=\"$1\">$1</a>");
		msg = msg.replace(/&lt;/g, "<");
		msg = msg.replace(/&gt;/g, ">");
		msg = msg.replace(/&amp;/g, "&");
		$('#edit_' + id).html(msg);
	}
	anuluj1();
}
function displayButton12()
{
	$('#wyslij').css('display', 'none');
	$('#messageBox').css('display', 'none');
	$('#message12').css('display', 'none');
	$('#zmien').css('display', 'none');
	$('#anuluj1').css('display', 'none');
	$('#emotki').css('display', 'none');
}
function refreshSB12()
{
	g_reqCount = 0;
	requestNewMessages();
	$('#messageBox').css('display', 'inline');
	$('#wyslij').css('display', 'inline');
	$('#refresh12').css('display', 'none');
	$('#emotki').css('display', 'inline');
}
function requestNewMessages()
{
	if (g_disaBled123 == 0)
	{
		if (g_reqCount <= g_maxReqCount)
		{
			indicator_switch(1);
			$.ajax({
				type: 'POST',
				cache: false,
				dataType: 'json',
				url: 'shoutbox_view.php',
				data: 'last='+g_lastMessageID,
				beforeSend: function(xhr) {xhr.setRequestHeader('Shoutbox','shoutbox_js');},
				success: handleReceivingMessages,
				complete: function()
				{
					indicator_switch(0);
					clearInterval(g_mTimer);
					g_mTimer = setTimeout('requestNewMessages();', updateInterval);
				}
			});
		}
		else
		{
			displayButton12();
			$('#refresh12').css('display', 'inline');
		}
	}
	else
	{
		displayButton12();
		$('#refresh12').css('display', 'none');
		indicator_switch(0);
	}
}
function handleReceivingMessages(data, textStatus, XMLHttpRequest)
{
	if ( data )
	{
		var mydiv = $('#SB_inner');
		var htmlMessage = '';
		for( x = 0; x < data.d.length; x++ ) 
		{
			if($("#sb_msg_" + data.d[x].i).length != 1)
			{
				var color = ( data.d[x].c ) ? 'style="' + data.d[x].c + '"' : '';
				var row = ( data.d[x].i % 2 ) ? 'sb1' : 'sb2';
				htmlMessage += '<div id="sb_msg_' + data.d[x].i + '" class="' + row + ' table0"> ';
				if ( data.d[x].x == 1 ) {
				htmlMessage += '<a onclick="removeShout(' + data.d[x].i + ')" class="gensmall" style="cursor: pointer; font-weight: bold;">x</a> ';}
				if (data.d[x].e == 1) {
				htmlMessage += '<a onclick="editShout(' + data.d[x].i + ')" class="gensmall" style="cursor: pointer; font-weight: bold;">e</a> ';}
				if ( data.d[x].p == 1 ) {
				htmlMessage += '<a href="' + data.d[x].u + '" class="gensmall" style="cursor: pointer; font-weight: bold;">i</a> ';}
				htmlMessage += data.d[x].t;
				if ( data.d[x].l == 1 && data.d[x].p == 0) {
				htmlMessage += ' <a href="' + data.d[x].u + '" class="gensmall" ' + color + '>' + data.d[x].n + '</a>: ';}
				else {
				htmlMessage += ' <a onclick="wstawianieSB(\'' + data.d[x].n + '\',0)" class="gensmall" style="cursor: pointer;' + data.d[x].c + '">' + data.d[x].n + '</a>: ';}
				htmlMessage += '<span id="edit_' + data.d[x].i + '">' + data.d[x].m + '</span></div>';
				g_disaBled123 = data.d[x].h;
				if ( data.d[x].n == 'Info' )
				{
					setTimeout('delInfo('+ data.d[x].i +');', data.d[x].w);
					wstawianieSB(data.d[x].z,3);
					$('#wyslij').attr('disabled', 'disabled');
					$('#messageBox').attr('disabled', 'disabled');
				}
				else
				{
					g_lastMessageID = data.d[x].i;
				}
			}
		}
		mydiv.html(mydiv.html() + htmlMessage);
		setTimeout('skroll();', 200);
		g_reqCount = 0;
	}
	else
	{
		g_reqCount++;
	}
}
function skroll() 
{
	$('#SB_box').animate({scrollTop: $('#SB_box > #SB_inner').outerHeight()}, 300);
}
function indicator_switch( state )
{
	if ( $('#act_indicator') )
	{
		$('#act_indicator').css('visibility', ( state == 1 ) ? 'visible' : 'hidden' );	
	}
}
function wstawianieSB(text, mode)
{
	var msg = $('#messageBox').attr('value');
	var text = new String(text);
	text = text.replace(/<(u|U|b|B|i|I)\>/g, "[$1]");
	text = text.replace(/<(\/u|\/U|\/b|\/B|\/i|\/I)\>/g, "[$1]");
	text = text.replace(/<\/(span|SPAN)\>/g, "[/color]");
	text = text.replace(/<(a|A)(.*?)href=\"(.*?)\"(.*?)\>(.*?)\<\/(a|A)\>/g, "$3");
    text = text.replace(/<(img|IMG)(.*?) title=\"(.*?)\"(.*?)>/g, "<$1$2$4>");
    text = text.replace(/<(img|IMG)(.*?)alt=\"(.*?)\"(.*?)> /g, "$3");
	text = text.replace(/<(img|IMG)(.*?)alt=(.*?)(.*?)>/g, "$3");
	text = text.replace(/<(span|SPAN)(.*?)style=\"(color|COLOR):(.*?)(\#[0-9A-F]{6}|[a-z]+)(.*?)\">/g, "[color=$5]"); 
	text = text.replace(/&lt;/g, "<");
	text = text.replace(/&gt;/g, ">");
	text = text.replace(/&amp;/g, "&");
	
    if (mode==1)
    {
       	$('#messageBox').focus().attr('value',msg + text);
    }
    else if (mode==0)
    {
        $('#messageBox').focus().attr('value',msg + ' ' + text + ', ');
    }
    else if (mode==3)
    {
        $('#messageBox').focus().attr('value', text);
    }
}
function emotki()
{
	$("#ramka").toggle("slow");
}
function handleKey(event) 
{
	$("#messageBox").keypress(function(event){
	var keycode = (event.keyCode ? event.keyCode : event.which);
	if ( keycode == '13' ) 
		if ( $('#anuluj1').css('display') == 'none' )
		{
			sendMessage();
		}
		else
		{
			sendEditShout();
		}
	});
}