var imageTag = false;
var theSelection = false;
var clientPC = navigator.userAgent.toLowerCase();
var clientVer = parseInt(navigator.appVersion);
var is_ie = ((clientPC.indexOf("msie") != -1) && (clientPC.indexOf("opera") == -1));
var is_nav = ((clientPC.indexOf('mozilla')!=-1) && (clientPC.indexOf('spoofer')==-1)
		&& (clientPC.indexOf('compatible') == -1) && (clientPC.indexOf('opera')==-1)
		&& (clientPC.indexOf('webtv')==-1) && (clientPC.indexOf('hotjava')==-1));
var is_moz = 0;
var is_win = ((clientPC.indexOf("win")!=-1) || (clientPC.indexOf("16bit") != -1));
var is_mac = (clientPC.indexOf("mac")!=-1);

bbcode = new Array();
bbtags = new Array('[b]','[/b]','[i]','[/i]','[u]','[/u]','[quote]','[/quote]','[code]','[/code]','[list]','[/list]','[list=]','[/list]','[img]','[/img]','[url]','[/url]','[stream]','[/stream]','[fade]','[/fade]','[scroll]','[/scroll]','[swf width= height=]','[/swf]','[center]','[/center]','[hide]','[/hide]');
imageTag = false;

function helpline(help)
{
	document.post.helpbox.value = eval(help + "_help");
}

function getarraysize(thearray)
{
	for (i = 0; i < thearray.length; i++)
	{
		if ((thearray[i] == "undefined") || (thearray[i] == "") || (thearray[i] == null))
			return i;
	}
	return thearray.length;
}

function arraypush(thearray,value)
{
	thearray[ getarraysize(thearray) ] = value;
}

function arraypop(thearray)
{
	thearraysize = getarraysize(thearray);
	retval = thearray[thearraysize - 1];
	delete thearray[thearraysize - 1];
	return retval;
}

function bbfontstyle(bbopen, bbclose)
{
	var txtarea = document.post.message;
	if ((clientVer >= 4) && is_ie && is_win)
	{
		theSelection = document.selection.createRange().text;
		if (!theSelection)
		{
			txtarea.value += bbopen + bbclose;
			txtarea.focus();
			return;
		}
		document.selection.createRange().text = bbopen + theSelection + bbclose;
		txtarea.focus();
		return;
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, bbopen, bbclose);
		return;
	}
	else
	{
		txtarea.value += bbopen + bbclose;
		txtarea.focus();
	}
	storeCaret(txtarea);
	document.post.message.scrollTop = prevTop;
}

function bbstyle(bbnumber)
{
	var txtarea = document.post.message;

	txtarea.focus();
	donotinsert = false;
	theSelection = false;
	bblast = 0;

	if (bbnumber == -1)
	{
		while (bbcode[0])
		{
			butnumber = arraypop(bbcode) - 1;
			txtarea.value += bbtags[butnumber + 1];
			buttext = eval('document.post.addbbcode' + butnumber + '.value');
			eval('document.post.addbbcode' + butnumber + '.value ="' + buttext.substr(0,(buttext.length - 1)) + '"');
		}
		imageTag = false;
		txtarea.focus();
		return;
	}

	if ((clientVer >= 4) && is_ie && is_win)
	{
		theSelection = document.selection.createRange().text;
		if (theSelection)
		{
			document.selection.createRange().text = bbtags[bbnumber] + theSelection + bbtags[bbnumber+1];
			txtarea.focus();
			theSelection = '';
			return;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, bbtags[bbnumber], bbtags[bbnumber+1]);
		return;
	}
	
	for (i = 0; i < bbcode.length; i++)
	{
		if (bbcode[i] == bbnumber+1)
		{
			bblast = i;
			donotinsert = true;
		}
	}

	if (donotinsert)
	{
		while (bbcode[bblast])
		{
				butnumber = arraypop(bbcode) - 1;
				txtarea.value += bbtags[butnumber + 1];
				buttext = eval('document.post.addbbcode' + butnumber + '.value');
				eval('document.post.addbbcode' + butnumber + '.value ="' + buttext.substr(0,(buttext.length - 1)) + '"');
				imageTag = false;
			}
			txtarea.focus();
			return;
	}
	else
	{
		if (imageTag && (bbnumber != 14))
		{
			txtarea.value += bbtags[15];
			lastValue = arraypop(bbcode) - 1;
			document.post.addbbcode14.value = "Img";
			imageTag = false;
		}
		
		txtarea.value += bbtags[bbnumber];
		if ((bbnumber == 14) && (imageTag == false)) imageTag = 1;
		arraypush(bbcode,bbnumber+1);
		eval('document.post.addbbcode'+bbnumber+'.value += "*"');
		txtarea.focus();
		return;
	}
	storeCaret(txtarea);
	document.post.message.scrollTop = prevTop;
}

function mozWrap(txtarea, open, close)
{
        prevTop = document.post.message.scrollTop;
    var selLength = txtarea.textLength;
    var selStart = txtarea.selectionStart;
    var selEnd = txtarea.selectionEnd;

    var s1 = (txtarea.value).substring(0,selStart);
    var s2 = (txtarea.value).substring(selStart, selEnd)
    var s3 = (txtarea.value).substring(selEnd, selLength);
    txtarea.value = s1 + open + s2 + close + s3;
    txtarea.selectionStart = selStart;
    txtarea.selectionEnd = selEnd + open.length + close.length;
        document.post.message.scrollTop = prevTop;
    return;
}

function mpFoto(img)
{
	foto1= new Image();
	foto1.src=(img);
	mpControl(img);
}

function mpControl(img)
{
	if ( (foto1.width != 0) && (foto1.height != 0) )
	{
		viewFoto(img);
	}
	else
	{
		mpFunc = "mpControl('"+img+"')";
		intervallo = setTimeout(mpFunc,20);
	}
}

function viewFoto(img)
{
	largh = foto1.width + 20;
	altez = foto1.height + 20;
	string = "width="+largh+",height="+altez;
	finestra = window.open(img, "", string);
}

function setCheckboxes(theForm, elementName, isChecked)
{
	var chkboxes = document.forms[theForm].elements[elementName];
	var count = chkboxes.length;
	if ( count )
	{
		for (var i = 0; i < count; i++)
		{
			chkboxes[i].checked = isChecked;
		}
	}
	else
	{
		chkboxes.checked = isChecked;
	}
	return true;
}

function displayWindow(url, width, height)
{
	var Win = window.open(url,"displayWindow",'width=' + width + ',height=' + height + ',resizable=1,scrollbars=no,menubar=no' );
}

function hideLoadingPage()
{
	if (document.getElementById)
	{
		 document.getElementById('hidepage').style.visibility = 'hidden';
	}
	else
	{
		if (document.layers)
		{
			document.hidepage.visibility = 'hidden';
		}
		else
		{
			document.all.hidepage.style.visibility = 'hidden';
		}
	}
}

function Active(what)
{
	what.style.backgroundColor=factive_color;
}

function NotActive(what)
{
	what.style.backgroundColor='';
}

function storeCaret(textEl)
{
	if (textEl.createTextRange) textEl.caretPos = document.selection.createRange().duplicate();
}

function emoticon(text, theTarget) {
    if(!theTarget) theTarget = document.post.message;
    if(theTarget.createTextRange && theTarget.caretPos) {
        var caretPos = theTarget.caretPos;
        caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text + ' ' : text;
        theTarget.focus();
    }
    else if(theTarget.selectionStart != undefined) {
        theTarget.value = theTarget.value.substring(0, theTarget.selectionStart) + text + theTarget.value.substring(theTarget.selectionStart);
        theTarget.focus();
    }
    else {
        theTarget.value += text;
        theTarget.focus();
    }
}

function em(text)
{
	return emoticon(text);
}

function checkForm()
{
	formErrors = false;
	if (document.post.message.value.length < 2)
	{
		formErrors = l_empty_message;
	}

	if (formErrors)
	{
		alert(formErrors);
		return false;
	}
	else
	{
		bbstyle(-1);
		//formObj.preview.disabled = true;
		//formObj.submit.disabled = true;
		return true;
	}
}

function wrapSelection(h, strFore, strAft)
{
	h.focus();
	if (h.setSelectionRange)
	{
		var selStart = h.selectionStart, selEnd = h.selectionEnd;
		h.value = h.value.substring(0, selStart) + strFore + h.value.substring(selStart, selEnd) + strAft + h.value.substring(selEnd);
		h.setSelectionRange(selStart + strFore.length, selEnd + strFore.length);
	}
	else if (document.selection)
	{
		var oRange = document.selection.createRange();
		var numLen = oRange.text.length;
		oRange.text = strFore + oRange.text + strAft;
		//moveSelectionRange(oRange, -numLen, -strAft.length);
	}
	else
	{
		h.value += strFore + strAft;
	}
}

function imgcode(theform,imgcode,prompttext)
{
	tag_prompt = img_addr;
	inserttext = prompt(tag_prompt+"\n["+imgcode+"]xxx[/"+imgcode+"]",prompttext);
	if ((inserttext != null) && (inserttext != ""))
	theform.message.value += "["+imgcode+"]"+inserttext+"[/"+imgcode+"] ";
	theform.message.focus();
}

function onv(element)
{
	element.style.backgroundColor=faonmouse_color;
}

function onv2(element)
{
	element.style.backgroundColor=faonmouse2_color;
}

function ont(element)
{
	element.style.backgroundColor='';
}

function focus_field(def_field)
{
	if (document.getElementById(def_field))
	{
		document.getElementById(def_field).focus();
	}
}

function show_pagina(e)
{
	var sTop = document.body.scrollTop;
	var sLeft = document.body.scrollLeft;
	document.getElementById('s_pagina').style.display='block';
	document.getElementById('s_pagina').style.left=e.clientX-35+sLeft;
	document.getElementById('s_pagina').style.top=e.clientY+sTop-20;
	return;
}

function qc()
{
	if (document.post && document.post.message)
	{
		quoteSelection();
		return false;
	}
	else if (parent.document.post && parent.document.post.message)
	{
		quoteSelection(parent.document.post.message);
		return false;
	}
}

function qo()
{
	selectedText = document.selection? document.selection.createRange().text : document.getSelection();
}

var PreloadFlag = false;
var expDays = 90;
var exp = new Date(); 
var tmp = '';
var tmp_counter = 0;
var tmp_open = 0;

exp.setTime(exp.getTime() + (expDays*24*60*60*1000));

function SetCookie(name, value) 
{
	var argv = SetCookie.arguments;
	var argc = SetCookie.arguments.length;
	var expires = (argc > 2) ? argv[2] : null;
	document.cookie = cname + name + "=" + escape(value) +
		((expires == null) ? "" : ("; expires=" + expires.toGMTString())) +
		((cpath == null) ? "" : ("; path=" + cpath)) +
		((cdomain == null) ? "" : ("; domain=" + cdomain)) +
		((csecure == 1) ? "; secure" : "");
}

function getCookieVal(offset) 
{
	var endstr = document.cookie.indexOf(";",offset);
	if (endstr == -1)
	{
		endstr = document.cookie.length;
	}
	return unescape(document.cookie.substring(offset, endstr));
}

function GetCookie(name) 
{
	var arg = cname + name + "=";
	var alen = arg.length;
	var clen = document.cookie.length;
	var i = 0;
	while (i < clen) 
	{
		var j = i + alen;
		if (document.cookie.substring(i, j) == arg)
			return getCookieVal(j);
		i = document.cookie.indexOf(" ", i) + 1;
		if (i == 0)
			break;
	} 
	return null;
}

function ShowHide(id1, id2, id3) 
{
	// System to show/hide page elements, cookie based
	// Take from Morpheus style Created by Vjacheslav Trushkin (aka CyberAlien)
	var res = expMenu(id1);
	if (id2 != '') expMenu(id2);
	if (id3 != '') SetCookie(id3, res, exp);
}
	
function expMenu(id) 
{
	var itm = null;
	if (document.getElementById) 
	{
		itm = document.getElementById(id);
	}
	else if (document.all)
	{
		itm = document.all[id];
	} 
	else if (document.layers)
	{
		itm = document.layers[id];
	}
	if (!itm) 
	{
		// do nothing
	}
	else if (itm.style) 
	{
		if (itm.style.display == "none")
		{ 
			itm.style.display = "inline"; 
			return 1;
		}
		else
		{
			itm.style.display = "none"; 
			return 2;
		}
	}
	else 
	{
		itm.visibility = "show"; 
		return 1;
	}
}

function chng(val)
{
    var nval = '#' + val.value;
    val.style.color = nval;
}

forum = {
	setCookie: (name, data, exp) => {
		SetCookie(name, data)
	},
	getCookie: (name, data, exp) => {
		return GetCookie(name)
	},
	selection: (selector) => {
		$(selector).on('copy', (e) => {
			var author = $(e.currentTarget).attr('author')
			var text = document.getSelection().toString()
			if (CKEDITOR) { 
				if (author) {
					author = '<b>'+author+':</b>'
				}
				CKEDITOR.instances.quickreply.insertHtml(
					'<blockquote>'+author+'<br /><br />'+text+'</blockquote><p></p>'
				);
			}
			else {
				text = '[quote]' + text + '[/quote]'
			}
			e.originalEvent.clipboardData.setData('text/plain', text)
			e.preventDefault()
		})
	},
	setCategoryClass: (selector) => {
		var selectorClass = forum.getCookie(selector)
		if (forum.getCookie(selector)) {
			$(selector).removeClass().addClass(selectorClass)

		}
	},
	toggleCategory: (selector, link) => {
		var element = $(selector)
		if (element.hasClass('visible')) {
			element.addClass('hidden')
			element.removeClass('visible')
			forum.setCookie(selector, 'hidden')
		}
		else {
			element.addClass('visible')
			element.removeClass('hidden')
			forum.setCookie(selector, 'visible')
		}
	},
	closeIframe: null,
	iframe: (url) => {
		var overlay = $('<div class="overlay iframe"></div>')
		var container = $('<div class="container"></div>')
		var close = $('<a href="javascript:void(0)">X</a>')
		var iframe = $('<iframe src="'+url+'" />')
		iframe.css({
			height: ($(window).height() - 200) + 'px',
		})
		close.on('click', function(e) {
			overlay.remove()
		})
		overlay.append(container)
		container.append(close)
		container.append(iframe)

		forum.closeIframe = () => {
			overlay.remove()
		}
		
		$('body').append(overlay)
	},
	stickyItems: {},
	stickyMenu: (selector) => {
		if (!forum.stickyItems[selector]) {
			var stickyBar = $(selector)
			forum.stickyItems[selector] = {
				element: stickyBar,
				top: stickyBar.position().top,
			}
		}
		$(window).scroll(function(ev){
			if ($(window).scrollTop() > forum.stickyItems[selector].top) {
				forum.stickyItems[selector].element.addClass('sticky');
			}
			else {
				forum.stickyItems[selector].element.removeClass('sticky');
			}
		})
	}
}

// ShowHide('hc_{catrow.tablehead.CAT_ID}','hc2_{catrow.tablehead.CAT_ID}','hc3_{catrow.tablehead.CAT_ID}');