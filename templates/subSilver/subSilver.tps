/* General page style. The scroll bar colours only visible in IE5.5+ */
body { 
background-color:		{T_BODY_BGCOLOR};
scrollbar-face-color:		{T_TR_COLOR2};
scrollbar-highlight-color:	{T_TD_COLOR2};
scrollbar-shadow-color:		{T_TR_COLOR2};
scrollbar-3dlight-color:	{T_TR_COLOR3};
scrollbar-arrow-color:		{T_BODY_LINK};
scrollbar-track-color:		{T_TR_COLOR1};
scrollbar-darkshadow-color:	{T_TH_COLOR1};
background-image: url({T_BODY_BACKGROUND});
margin: 4px;
}

/* General font families for common tags */
font,th,td,p			{ font-family: {T_FONTFACE1} }
a:link,a:active,a:visited	{ color : {T_BODY_LINK}; }
p, td			{ font-size : 11px; color : {T_BODY_TEXT}; }
a:hover			{ text-decoration: underline; color : {T_BODY_HLINK}; }
hr				{ height: 0px; border: solid #D1D7DC 0px; border-top-width: 1px; }

/* This is the border line & background colour round the entire page */
.bodyline { background-color: {T_TD_COLOR2}; border: 1px #98AAB1 solid; }

/* This is the outline round the main forum tables */
.forumline { background-color: #A9B8C2; border: solid #D1D7DC 0px; border-top-width: 1px; }

/* Main table cell colours and backgrounds */
td.row1 { background-color: {T_TR_COLOR1}; }
td.row2 { background-color: {T_TR_COLOR2}; }
td.row3 { background-color: {T_TR_COLOR3}; }
td.row_helped { background-color: {T_TR_COLOR_HELPED}; }

/*
	This is for the table cell above the Topics, Post & Last posts on the index.php page
	By default this is the fading out gradiated silver background.
	However, you could replace this with a bitmap specific for each forum
*/
td.rowpic {
background-color: {T_TD_COLOR2};
background-image: url('images/cellpic2.jpg');
background-repeat: repeat-y; height: 22px;
}

/* Header cells - the blue and silver gradient backgrounds */
th {
color:			{T_FONTCOLOR3}; font-size: {T_FONTSIZE2}px; font-weight: bold;
background-color:	{T_BODY_LINK}; height: 25px;
background-image:	url(images/{T_TH_CLASS2});
}

td.catHead,td.catSides,td.catLeft,td.catRight,td.catBottom {
background-image: url(images/{T_TH_CLASS1});
background-color:{T_TR_COLOR3}; border: {T_TH_COLOR3}; border-style: solid; height: 28px;
}

/*
	Setting additional nice inner borders for the main table cells.
	The names indicate which sides the border will be on.
	Don't worry if you don't understand this, just ignore it :-)
*/
td.cat,td.catHead,td.catBottom { background-color: #C7D0D7; background-image: url('images/cellpic1.gif'); height: 22px; }
th.thHead,th.thSides,th.thLeft,th.thRight,th.thBottom {
font-weight: bold; border: {T_TD_COLOR2}; height: 28px;
}

th.thCornerL,th.thTop,th.thCornerR {color: #FFA34F; font-size: 70%; font-weight: bold; background-color: #006699; background-image: url('images/cellpic3.gif'); height: 28px; }

td.row3Right,td.spaceRow { background-color: {T_TR_COLOR3}; border: {T_TH_COLOR3}; border-style: solid; }

th.thHead,td.catHead			{ font-size: {T_FONTSIZE3}px; border-width: 0px; }
th.thSides,td.catSides,td.spaceRow	{ border-width: 0px; }
th.thRight,td.catRight,td.row3Right	{ border-width: 0px; }
th.thLeft,td.catLeft			{ border-width: 0px; }
th.thBottom,td.catBottom		{ border-width: 0px; }
th.thTop				{ border-width: 0px; }
th.thCornerL				{ border-width: 0px; }
th.thCornerR				{ border-width: 0px; }

/* The largest text used in the index page title and toptic title etc. */
.maintitle {
font-weight: bold; font-size: 22px; font-family: "{T_FONTFACE2}",{T_FONTFACE1};
text-decoration: none; line-height : 120%; color : {T_BODY_TEXT};
}

/* General text */
.gen						{ font-size : {T_FONTSIZE3}px; }
.genmed					{ font-size : {T_FONTSIZE2}px; }
.gensmall					{ font-size : {T_FONTSIZE1}px; }
.gen,.genmed,.gensmall			{ color : {T_BODY_TEXT}; }
a.gen,a.genmed,a.gensmall			{ color: {T_BODY_LINK}; text-decoration: none; }
a.gen:hover,a.genmed:hover,a.gensmall:hover	{ color: {T_BODY_HLINK}; text-decoration: underline; }

/* The register, login, search etc links at the top of the page */
.mainmenu		{ font-size : {T_FONTSIZE2}px; color : {T_BODY_TEXT} }
a.mainmenu		{ text-decoration: none; color : {T_BODY_LINK}; }
a.mainmenu:hover	{ text-decoration: underline; color : {T_BODY_HLINK}; }

/* Forum category titles */
.cattitle		{ font-weight: bold; font-size: {T_FONTSIZE3}px ; letter-spacing: 1px; color : {T_BODY_LINK}}
a.cattitle		{ text-decoration: none; color : {T_BODY_LINK}; }
a.cattitle:hover	{ text-decoration: underline; }

/* Forum title: Text and link to the forums used in: index.php */
.forumlink		{ font-weight: bold; font-size: {T_FONTSIZE3}px; color : {T_BODY_LINK}; }
a.forumlink		{ text-decoration: none; color : {T_BODY_LINK}; }
a.forumlink:hover	{ text-decoration: underline; color : {T_BODY_HLINK}; }

/* Used for the navigation text, (Page 1,2,3 etc) and the navigation bar when in a forum */
.nav		{ font-weight: bold; font-size: {T_FONTSIZE2}px; color : {T_BODY_TEXT};}
a.nav	{ text-decoration: none; color : {T_BODY_LINK}; }
a.nav:hover	{ text-decoration: underline; }

/* titles for the topics: could specify viewed link colour too */
.topictitle,h1,h2	{ font-weight: bold; font-size: {T_FONTSIZE2}px; color : {T_BODY_TEXT}; }
a.topictitle:link	{ text-decoration: none; color : {T_BODY_LINK}; }
a.topictitle:visited	{ text-decoration: none; color : {T_BODY_VLINK}; }
a.topictitle:hover	{ text-decoration: underline; color : {T_BODY_HLINK}; }

/* Name of poster in viewmsg.php and viewtopic.php and other places */
.name { font-size : {T_FONTSIZE2}px; color : {T_BODY_TEXT}; text-decoration: none}

/* Location, number of posts, post date etc */
.postdetails		{ font-size : {T_FONTSIZE1}px; color : {T_BODY_TEXT}; }

/* The content of the posts (body of text) */
.postbody		{ font-size : {T_FONTSIZE3}px; line-height: 18px }
a.postlink:link	{ text-decoration: none; color : {T_BODY_LINK} }
a.postlink:visited	{ text-decoration: none; color : {T_BODY_VLINK}; }
a.postlink:hover	{ text-decoration: underline; color : {T_BODY_HLINK} }

/* Quote & Code blocks */
.code {
font-family:		{T_FONTFACE3}; font-size: {T_FONTSIZE2}px; color: {T_FONTCOLOR2};
background-color:	{T_TD_COLOR1}; border: {T_TR_COLOR3}; border-style: solid;
border-left-width:	1px; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px;
}

.quote {
font-family:		{T_FONTFACE1}; font-size: {T_FONTSIZE2}px; color: {T_FONTCOLOR1}; line-height: 125%;
background-color:	{T_TD_COLOR1}; border: {T_TR_COLOR3}; border-style: solid;
border-left-width:	1px; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px;
}

/* Copyright and bottom info */
.copyright		{ font-size : {T_FONTSIZE1}px; color: {T_FONTCOLOR1}; font-family: {T_FONTFACE1}; }
a.copyright		{ text-decoration: none; color : #006699; }
a.copyright:hover	{ text-decoration: underline; color : {T_BODY_HLINK}; }

/* Form elements */

form { margin: 0; }
form { display: inline; }

input,textarea, select {
color : {T_BODY_TEXT};
font: normal {T_FONTSIZE2}px {T_FONTFACE1};
}

/* The text input fields background colour */
input.post, textarea.post, select			{ background-color : {T_TR_COLOR1}; }
input.post2, textarea.post2, select	{ background-color : {T_TR_COLOR2}; }
input						{ text-indent : 2px; }

/* The buttons used for bbCode styling in message post */
input.button {
background-color :	{T_TR_COLOR1};
color :			{T_BODY_TEXT};
font-size:		{T_FONTSIZE2}px; font-family: {T_FONTFACE1};
cursor:			pointer;
}

/* The main submit button option */
input.mainoption {
background-color:	{T_TD_COLOR1};
font-weight:		bold;
cursor:			pointer;
}

/* None-bold submit button */
input.liteoption {
background-color:	{T_TD_COLOR1};
font-weight:		normal;
cursor:			pointer;
}

/* This is the line in the posting page which shows the rollover
	help line. This is actually a text box, but if set to be the same
	colour as the background no one will know ;)
*/
.helpline { background-color: {T_TR_COLOR2}; border-style: none; }

/* Highlight bad words for moderators instead of censoring them */
span.badwordhighlight { background-color: #FFFF00; }

.topbkg { background: #dbe3ee url(images/cellpic_bkg.jpg) repeat-x }
.topnav { font-size:10px;background: #e5ebf3 url(images/cellpic_nav.gif) repeat-x;color:#dd6900; height: 21px; white-space: nowrap; text-align: center; border: 0px solid #91a0ae; border-width: 1px 0 1px 0 }

.pm { font-size: 11px; text-decoration: none; color: #FF0000 } 

.table0
{
	padding: 4px;
	border-bottom: 1px solid #dedede;
	border-left: 1px solid #fefefe;
	color : #000000;
	font-size : 10px;
}

.sb1 { background-color: #EFEFEF; }
.sb2 { background-color: #DEE3E7; }

.pagination {
	color: #666;
	font-size: 10px;
	font-weight: bold;
	padding: 3px;
	padding-bottom: 4px;
	cursor: pointer;
	text-decoration: none;
}
.pagination a, .pagination a:visited, .pagination a:active {
	background-color: #EAEBEB;
	color: #000;
	border-color: #D4D7DA;
	border: #D4D7DA 1px solid;
	padding: 1px;
	text-decoration: none;
}
.pagination a:hover {
	background-color: #FFF;
	color: #666;
	border-color: #EAECEF;
	border: #EAECEF 1px solid;
	text-decoration: none;
	padding: 1px;
}

/* Import the fancy styles for IE only (NS4.x doesn't use the @import function) */
@import url("formIE.css");