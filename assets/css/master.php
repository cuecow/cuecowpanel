<?php 
header("Content-type: text/css"); 
$color = $_GET['color'];
//echo "::" . $color . "::";
$color = "2CA2EA";
$color = "2BA2E9";

?>

@import 'reset.css';
@import 'text.css';



/* Basic HTML
----------------------------------------------------------------------------------------------------*/

.container_4 { background:#fff; }
h2,h3,h4,h5,h6 { line-height: 1.4; }
/*a { text-decoration:none; cursor:pointer; color: #e83d0f; }*/
a { text-decoration:none; cursor:pointer; color: #3B79AA; }
a.blue { color:#2a68a2; }
a.yellow { color:#e8aa13; }
a.green { color:#57a50b; }
a:hover { color: #555; }
small { font-size: 11px; }
button, input[type="button"], input[type="reset"], input[type="submit"] { cursor: pointer; -webkit-appearance: button; }


/* Misc Classes
----------------------------------------------------------------------------------------------------*/

.align_center { text-align: center; }
.align_right { text-align: right; }
.float_right { float:right; margin:0 !important; }


/* Code
----------------------------------------------------------------------------------------------------*/

pre,code { font-size: 12px; font-family: Menlo, Courier, monospace; padding: 9px 13px 8px; margin: 0 0 15px; display: block; }
pre,.notice { margin:0 0 15px; background: #ffe; border: 1px solid; border-color: #eed #ccb #bba #ddc; overflow: auto; padding: 10px 0 10px 10px; }
* html pre {overflow: hidden; width: 97%; }
code { background: #ff9; }



/* Admin Pro Styling
----------------------------------------------------------------------------------------------------*/

<?php if (isset($_GET['login']) && $_GET['login']){ ?>

	body { background:#<?php echo $color; ?> url('../images/body_bg.png') repeat; color: #555; }
	#login-wrapper { padding:20px 0; width:415px; margin:0 auto; }
	#logo { width:100%; height:62px; margin:0 0 15px; }
	#logo h1 { margin:0; text-indent:-9999px; height:157px; background: url(../images/cuecow-logo.png) no-repeat center center; }
	
	#login-form { margin:110px 0px 0px 0px; width:375px; padding:20px; background:#fff; -moz-border-radius:5px; -webkit-border-radius:5px; border-radius:5px; -moz-box-shadow:1px 1px 3px rgba(0,0,0,0.4); -webkit-box-shadow:1px 1px 3px rgba(0,0,0,0.4); box-shadow:1px 1px 3px rgba(0,0,0,0.4); }
	
    #signup-form { margin:110px 0px 0px 0px; width:450px; padding:20px; background:#fff; -moz-border-radius:5px; -webkit-border-radius:5px; border-radius:5px; -moz-box-shadow:1px 1px 3px rgba(0,0,0,0.4); -webkit-box-shadow:1px 1px 3px rgba(0,0,0,0.4); box-shadow:1px 1px 3px rgba(0,0,0,0.4); }
    
    .signup-form-label-cntnr { padding-bottom:5px; float:left; }
    
    .signup-form-label{float:left; width:120px;}
    .signup-form-field{float:left; width:320px;}
    
	.under-form { text-align:center; width:100%; padding:15px 0; font-size:11px; color:rgba(255,255,255,0.5); }

<?php } else { ?>

	body { background: #EBEBEB; color: #555; }
	#logo { margin:0 0 0 3%; width:72%; }
	#logo h1 { margin:0; text-indent:-9999px; height:62px; background: url(../images/cuecow-logo_small.png) no-repeat left center; }
	
<?php } ?>

.push-down { padding-bottom:20px !important; }

.header-wrap { background:#<?php echo $color; ?>/* url('../images/header_bg.png') repeat-x top center; */}
#header { background:#<?php echo $color; ?>/* url('../images/header_bg.png') repeat-x top center;*/ height:131px; }

#main-navigation { clear:both; background:url('../images/navigation_bg.png') repeat-x; height:50px; }
#main-navigation .nav-wrap { border:0px solid rgba(255,255,255,0.2); border-bottom:0; height:63px; box-shadow:0 0px 0px rgba(0,0,0,0); }
#main-navigation ul, #main-navigation li { margin:0; padding:0; list-style:none; }
#main-navigation ul { padding:26px 0 0 160px; /*padding:10px 0 0 60px;*/ }
#main-navigation li { display:inline-block; padding:0 1px 0 0; }
#main-navigation li a { position:relative; color:#111; text-decoration:none; font-size:13px; padding-top:12px; padding-bottom:6px; display:block; margin-left:auto; margin-right:auto;}

/*
#main-navigation li a.dashboard { background:url('../images/icon_dashboard.png') no-repeat top center; }
#main-navigation li a.grid { background:url('../images/icon_grid.png') no-repeat top center; }
#main-navigation li a.page { background:url('../images/icon_page.png') no-repeat top center; }
#main-navigation li a.buzz { background:url('../images/icon_buzz.png') no-repeat top center; 
width:120px}
#main-navigation li a.stats { background:url('../images/icon_stats.png') no-repeat top center; }
#main-navigation li a.calendar { background:url('../images/icon_calendar.png') no-repeat top center; }
#main-navigation li a.forms { background:url('../images/icon_forms.png') no-repeat top center; }
#main-navigation li a.gallery { background:url('../images/icon_gallery.png') no-repeat top center; }
#main-navigation li a.users { background:url('../images/icon_users.png') no-repeat top center; }
#main-navigation li a.messages { background:url('../images/icon_messages.png') no-repeat top center; }
*/

#main-navigation li a.dashboard { background:url('../images/icon_buzz.png') no-repeat top center;
width:120px; opacity:0.9;}
#main-navigation li a.grid { background:url('../images/icon_buzz.png') no-repeat top center; 
width:120px; opacity:0.9;}
#main-navigation li a.page { background:url('../images/icon_buzz.png') no-repeat top center; 
width:120px; opacity:0.9;}
#main-navigation li a.buzz { background:url('../images/icon_buzz.png') no-repeat top center; 
width:120px; opacity:0.9;}
#main-navigation li a.buzz:hoover,#main-navigation li a.buzz.active  { background:url('../images/icon_messages.png') no-repeat top center; 
width:120px; opacity:0.9;}
#main-navigation li a.stats { background:url('../images/icon_buzz.png') no-repeat top center; 
width:120px; opacity:0.9;}
#main-navigation li a.calendar { background:url('../images/icon_buzz.png') no-repeat top center; 
width:120px; opacity:0.9;}
#main-navigation li a.forms { background:url('../images/icon_buzz.png') no-repeat top center;
width:120px; opacity:0.9;}
#main-navigation li a.gallery { background:url('../images/icon_buzz.png') no-repeat top center;
width:120px; opacity:0.9;}
#main-navigation li a.users { background:url('../images/icon_buzz.png') no-repeat top center;
width:120px; opacity:0.9;}
#main-navigation li a.messages { background:url('../images/icon_buzz.png') no-repeat top center; 
width:120px; opacity:0.9;}

#main-navigation li a.settings {width:90px; opacity:0.9; height:22px; color:#FFF; background:#1F79B5; -moz-border-top-left-radius: 7px; -webkit-border-top-left-radius: 7px; border-top-left-radius: 7px; -moz-border-top-right-radius: 7px; -webkit-border-top-right-radius: 7px; border-top-right-radius: 7px; font-weight:bold;}

#main-navigation li a.logout {width:90px; opacity:0.9; height:22px; color:#FFF; background:#1F79B5; -moz-border-top-left-radius: 7px; -webkit-border-top-left-radius: 7px; border-top-left-radius: 7px; -moz-border-top-right-radius: 7px; -webkit-border-top-right-radius: 7px; border-top-right-radius: 7px; font-weight:bold;}

/*#main-navigation li a:hover, #main-navigation li a.active { -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=65)"; filter: alpha(opacity=65); -moz-opacity:0.65; -khtml-opacity: 0.65; opacity: 0.65; }*/
#main-navigation li a:hover, #main-navigation li a.active { -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=100)"; filter: alpha(opacity=100); -moz-opacity:1; -khtml-opacity: 1; opacity: 1; }


#main-navigation li .counter { display:block; width:25px; height:25px; text-align:center; overflow:hidden; position:absolute; top:-5px; right:0; color:#fff; font-size:9px; line-height:25px; background: url(../images/dot.png) no-repeat 0 0; }

#eyebrow-navigation { padding-top:20px; text-align:right; width:22%; margin:0 3% 0 0; font-size:14px; }
#eyebrow-navigation a { text-decoration:none; color:#fff; color:rgba(255,255,255,0.8); line-height:14px; padding: 0 0 0 28px; display:inline-block; }
#eyebrow-navigation a.settings { background:url('../images/icon_settings.png') no-repeat 10px 0; }
#eyebrow-navigation a.signout { background:url('../images/icon_signout.png') no-repeat 10px 0; }

#search form { position:relative; float:right; }
#search input.search {
	padding:5px 10px;
	border:none;
	width:140px;
	height:20px;
	background:#<?php echo $color; ?>;
	background-image: -webkit-gradient(
	    linear,
	    left bottom,
	    left top,
	    color-stop(0, #<?php echo $color; ?>),
	    color-stop(1, #<?php echo $color; ?>)
	);
	background-image: -moz-linear-gradient(
	    center bottom,
	    #<?php echo $color; ?> 0%,
	    #<?php echo $color; ?> 100%
	);
	box-shadow:inset 1px 1px 3px rgba(0,0,0,0.1), 1px 1px 0 rgba(255,255,255,0.2);
	-moz-box-shadow:inset 1px 1px 3px rgba(0,0,0,0.1), 1px 1px 0 rgba(255,255,255,0.2);
	-webkit-box-shadow:inset 1px 1px 3px rgba(0,0,0,0.1), 1px 1px 0 rgba(255,255,255,0.2);
	color:#fff;
	color:rgba(255,255,255,0.75);
	-moz-border-radius:5px;
	-webkit-border-radius:5px;
	border-radius:5px;
}
#search input.go {
	background:url('../images/search_go.png') no-repeat 0 0;
	width:32px; height:26px;
	border:none; text-indent:-9999px;
	position:absolute; top:19px; right:19px;
}

#subpages { background:#ebebeb url('../images/subpages.png') repeat top left; min-height:40px; }
/*#subpages { background:#ebebeb; min-height:40px; }*/


#subpages .subpage-wrap { margin:0 2%; }
#subpages ul, #subpages li { margin:0; padding:0; list-style:none; }
#subpages ul { margin:0 20px; padding:10px 0; }
#subpages li { display:inline-block; padding:0 15px 0 0; }
#subpages li a { color:#535353; text-decoration:none; font-size:13px; display:block; }

#page-heading { color:#535353; padding:20px 0; border-bottom:1px solid #d4d4d4; margin-bottom:1px; }
.title-crumbs { display:block; font-size:11px; }
.title-crumbs a { text-decoration:none; font-weight:bold; }
.title-crumbs h2 { font-size:19px; margin:0; padding:0; color:#535353; }
.page-wrap { margin:0 25px; font-size:12px;}



/* ALERTS																		*/
/* ---------------------------------------------------------------------------- */

.alert-wrapper { font-weight:bold; font-size:16px; width:100%; padding:17px 0 18px; margin-bottom:5px; }
.alert-wrapper.push-down { margin-bottom:20px; }
.alert-wrapper .alert-text { position:relative; line-height:26px; min-height: 26px; padding:0 30px; margin:0 2%; background:url('../images/alert_icon_error.png') no-repeat top left; }
.alert-wrapper .alert-text .close { position:absolute; top:0; right:0; width:26px; height:26px; display:block; background:url('../images/alert_icon_close.png') no-repeat; text-indent:-9999px; }

.push-down .alert-wrapper .grid_4 { margin-bottom:0 !important; }

.alert-wrapper.error { color:#E83D0E; background:#ffeeee url('../images/alert_pattern.png') repeat top left; }
.alert-wrapper.error .alert-text { background:url('../images/alert_icon_error.png') no-repeat top left; }
.alert-wrapper.warning { color:#e8a911; background:#ffffd7 url('../images/alert_pattern.png') repeat top left; }
.alert-wrapper.warning .alert-text { background:url('../images/alert_icon_warning.png') no-repeat top left; }
.alert-wrapper.confirm { color:#54a306; background:#deffbd url('../images/alert_pattern.png') repeat top left; }
.alert-wrapper.confirm .alert-text { background:url('../images/alert_icon_confirm.png') no-repeat top left; }
.alert-wrapper.info { color:#2766a1; background:#dbeeff url('../images/alert_pattern.png') repeat top left; }
.alert-wrapper.info .alert-text { background:url('../images/alert_icon_info.png') no-repeat top left; }

#login-form .alert-wrapper { margin:0 0 15px; padding:8px 0; }
#login-form .alert-wrapper .alert-text { font-size:11px; margin:0 10px; }



/* PANELS																		*/
/* ---------------------------------------------------------------------------- */

.panel { background:#ebebeb; border:1px solid #<?php echo $color; ?>; }
.panel h2.cap { line-height:1; cursor:pointer; -moz-border-radius:3px 3px 0 0; -webkit-border-radius:3px 3px 0 0; border-radius:3px 3px 0 0; box-shadow:inset 0 1px 0 rgba(255,255,255,0.2); margin:0; text-shadow:1px 1px 0 rgba(0,0,0,0.4); height:27px; color:#fff; font-size:16px; background:#<?php echo $color; ?>/* url('../images/cap_bg.png') repeat*/; padding:14px 0 0 15px; position:relative; }
.panel .content { margin:5px; background:#fff; padding:20px 20px 1px 20px; }
.panel { -moz-border-radius:4px; -webkit-border-radius:4px; border-radius:4px; }


/* FLOT GRAPH																	*/
/* ---------------------------------------------------------------------------- */

.flot-graph { margin:25px 0; }
.flot-graph .legendLabel { line-height:11px; padding:0 15px 0 5px; }


/* TABLES																		*/
/* ---------------------------------------------------------------------------- */

.panel table.styled {
	border:1px solid #d5dcdf;
	margin:0 0 10px;
	width: 100%;
}

.panel table.styled th, .panel table.styled td { padding: 6px 11px; }

.panel table.styled thead tr th, .panel table.styled tfoot tr th {
	border-bottom: 1px solid #d5dcdf;
	/*font-size: 12px;*/
	color:#5d676a;
}
.panel table.styled thead tr th {
	background-image: -webkit-gradient(linear,left bottom,left top,color-stop(0, #E3E9EB),color-stop(1, #F0F3F4));
	background-image: -moz-linear-gradient(center bottom,#E3E9EB 0%,#F0F3F4 100%);
	-moz-box-shadow:inset 2px 0 0 #fff;
	-webkit-box-shadow:inset  2px 0 0 #fff;
	box-shadow:inset inset 2px 0 0 #fff;
	border-right:1px solid #d5dcdf;
}
.panel table.styled thead tr .header { padding-right:23px; cursor: pointer; }
.panel table.styled tbody td {
	-moz-box-shadow:inset 0 1px 0 #fff, inset 2px 0 0 #fff;
	-webkit-box-shadow:inset 0 1px 0 #fff, inset 2px 0 0 #fff;
	box-shadow:inset 0 2px 0 #fff, inset 2px 0 0 #fff;
	border-bottom:1px solid #d5dcdf;
	border-right:1px solid #d5dcdf;
	color: #5d676a;
	background-color: #fff;
	vertical-align: top;
}
.panel table.styled tbody tr.odd td {
	background-color:#f7f9f9;
}
.panel table.styled thead tr .headerSortUp {
	background-image: url(../images/desc.png);
	background-image: url(../images/desc.png), -webkit-gradient(linear,left bottom,left top,color-stop(0, #d5dcdf),color-stop(1, #E3E9EB));
	background-image: url(../images/desc.png), -moz-linear-gradient(center bottom,#d5dcdf 0%,#E3E9EB 100%);
	background-position:top right;
}
.panel table.styled thead tr .headerSortDown {
	background-image: url(../images/asc.png);
	background-image: url(../images/asc.png), -webkit-gradient(linear,left bottom,left top,color-stop(0, #d5dcdf),color-stop(1, #E3E9EB));
	background-image: url(../images/asc.png), -moz-linear-gradient(center bottom,#d5dcdf 0%,#E3E9EB 100%);
	background-position:top right;
}

table.styled .checkbox-row { text-align:center; width:10px; }
table.styled .options-row { text-align:center; width:117px; }
table.styled .center { text-align:center; }

div.pager {
	position:relative;
	text-align: right;
	margin:10px 0 20px;
}
div.pager span {
	padding: 0 5px;
}
div.pager input.prev {
	width: auto;
	margin-right: 10px;
}
div.pager input.next {
	width: auto;
	margin-left: 10px;
}
div.pager input {
	font-size: 8px;
	width: 50px;
	border: 1px solid #330000;
	text-align: center;
}
div.pager .pagesize { width:60px; }
div.pager .chzn-container { margin:0 7px 0 0; min-width: 58px; vertical-align: top; }
div.pager .pagedisplay { width:35px; margin:0 7px 0 0; font-size:13px; border:none; cursor:default; vertical-align: super; }
div.pager .button.next,
div.pager .button.prev,
div.pager .button.first,
div.pager .button.last { position:relative; top:0; margin:0 3px 0 0; }
div.pager .button img { display:block; margin:0; padding:2px; }
div.pager .table-options { position:absolute; top: 0; left:0; }
/*simmtronics o5d114101325*/
.panel table .icon-button { margin:0 5px; width:21px; height:21px; display:inline-block; text-indent:9999px; overflow:hidden; }
.panel table .icon-button.edit { background:url('../images/table_icon_edit.png') no-repeat center center; }
.panel table .icon-button.delete { background:url('../images/table_icon_delete.png') no-repeat center center; }
.panel table .icon-button.manage_page { background:url('../images/table_icon_setting.png') no-repeat center center; }


/* TABS																			*/
/* ---------------------------------------------------------------------------- */

ul.tabs {
	margin: 5px 5px 0 0px;
	padding: 0;
	list-style: none;
	height: 42px; /*--Set height of tabs--*/
	width: 100%;
}
ul.tabs:after { clear:both; }
ul.tabs li {
	float: left;
	margin: 0;
	padding: 0;
	height: 42px;
	line-height: 42px;
	overflow: hidden;
	position: relative;
	background: #656565;
    border-top-left-radius: 6px;
    border-top-right-radius: 6px;
    margin-right: 5px;
}
ul.tabs li a {
	text-decoration: none;
	color: #FFF;
	display: block;
	font-size: 14px;
	font-weight:bold;
	padding: 0 20px;
	outline: none;
    border-top-left-radius: 6px;
    border-top-right-radius: 6px;
}
ul.tabs li a:hover {
	background: #ccc;
    border-top-left-radius: 6px;
    border-top-right-radius: 6px;
}
html ul.tabs li.active, html ul.tabs li.active a:hover  { /*--Makes sure that the active tab does not listen to the hover properties--*/
	background: #A6A6A6;
	/*border-bottom: 1px solid #fff; --Makes the active tab look like it's connected with its content--*/
}

.tab_container {
	overflow: hidden;
	clear: both;
	width: 100%;
	background: #fff;
}

.content.tabbed { margin:0 5px 5px 5px; }



/* GALLERY																		*/
/* ---------------------------------------------------------------------------- */

.content.gallery { padding-right:10px !important; }
.gallery-wrap { position:relative; width:100%; height:310px; overflow:hidden; padding:0; margin:0 0 20px; }
.gallery-wrap:after { content:' '; clear:both; display:block; }
.gallery-pager { position:absolute; top:0; left:0; width:100%; height:10000px; }
.gallery-item { position:relative; float:left; margin:0 10px 10px 0; width:150px; height:150px; }
.gallery-item img { display:block; width:100%; height:100%; }
.gallery-item .item-options { bottom:0; right:0; position:absolute; background:url('../images/gallery_hover_bg.png') repeat; padding:5px 3px 5px 8px; }
.gallery-item .icon-button { margin:0 5px 0 0; width:21px; height:21px; display:inline-block; text-indent:-9999px; overflow:hidden; }
.gallery-item .icon-button.edit { background:url('../images/gallery_icon_edit.png') no-repeat center center; }
.gallery-item .icon-button.delete { background:url('../images/gallery_icon_delete.png') no-repeat center center; }
.gallery-item .checkbox-block { top:0; left:0; position:absolute; background:#fff; padding:5px 7px; line-height:5px; }
.gallery-item .checked-layer {
	position:absolute; top:0; left:0;
	-moz-box-shadow:inset 5px 5px 0 #60a918, inset -5px -5px 0 #60a918;
	-webkit-box-shadow:inset 5px 5px 0 #60a918, inset -5px -5px 0 #60a918;
	box-shadow:inset 5px 5px 0 #60a918, inset -5px -5px 0 #60a918;
	width:100%; height:100%; display:none; background:url('../images/gallery_checked_bg.png') repeat;
}
.gallery .pager {
	position:relative;
	text-align: right;
	margin:-5px 10px 20px 0;
}
.gallery .gallery-options { position:absolute; top: 0; left:0; }



/* FORMS																		*/
/* ---------------------------------------------------------------------------- */

<?php if (isset($_GET['login']) && $_GET['login']){ ?>

	form.styled label, form.styled .non-label-section { display:block; margin:0 0 15px; padding:0; border-left:none; }
	form.styled label .field_title, form.styled .non-label-section .field_title { font-weight:bold; position:relative; top:0; left:0; display:block; margin:0 0 5px; }
	
<?php } else { ?>

form.styled label, form.styled .non-label-section { display:block; margin-left:155px; padding:0 0 20px 20px; border-left:1px solid #ddd; position:relative; }
form.styled label .field_title, form.styled .non-label-section .field_title { width:138px; font-weight:bold; font-size:12px; color:#666; position:absolute; top:0; left:-155px; }

	
<?php } ?>

form.styled label:after, form.styled .non-label-section:after { content:" "; clear:both; }
form.styled label span.browse { font-size:13px; line-height:17px; height: 17px; padding:2%; margin:0; left:auto; top:0; right:-1px; position:absolute; }
form.styled input,
form.styled textarea {
	border:1px solid #aaa;
	background:#eee;
	/*display:block;*/
	font-size:13px;
	line-height:17px;
	font-family:sans-serif;
	padding:2%;
	margin:0;
	width:96%;
	color:#666;
	-moz-border-radius:5px; -webkit-border-radius:5px; border-radius:5px;
	background-image: -webkit-gradient(linear,left bottom,left top,color-stop(0.03, #F0F0F0),color-stop(1, #FFFFFF));
	background-image: -moz-linear-gradient(center bottom,#F0F0F0 3%,#FFFFFF 100%);
	-moz-box-shadow:inset 1px 1px 4px #ddd;
	-webkit-box-shadow:inset 1px 1px 4px #ddd;
	box-shadow:inset 1px 1px 4px #ddd;
}

form.styled input.small { width:50%; }
form.styled textarea.small { width:50%; }
form.styled input.verysmall { width:8%; height:20px; clear:both;}

form.styled textarea { height:100px; }
form.styled label input.file { cursor:pointer; position:absolute; top:5px; right:0; }
form.styled select { width:100%; }
form.styled .chzn-single span { position:relative; font-weight:normal; left:0; }

form.styled .non-label-section label { display:inline; margin:0; padding:0; border:none; }
form.styled .checkbox, form.styled .radio { display:inline; width:auto; }
form.styled small { display:block; font-size:11px; line-height:15px; padding-top:5px; }
form.styled legend {font-size:19px; line-height:24px; font-weight:bold; display:block; padding:0 0 25px; }

.progress-bar {
	display:block;
	position:relative; margin:0 0 10px;
	-moz-border-radius:10px; -webkit-border-radius:10px; border-radius:10px;
	border:1px solid #aaa;
	height:8px;
	background-image: -webkit-gradient(linear,left bottom,left top,color-stop(0, #D8D8D8),color-stop(1, #C7C7C7));
	background-image: -moz-linear-gradient(center bottom,#D8D8D8 0%,#C7C7C7 100%);
	line-height:1px;
}

.progress-bar .bar {
	display:block;
	-moz-box-shadow:inset 0 1px 0 rgba(255,255,255,0.4); -webkit-box-shadow:inset 0 1px 0 rgba(255,255,255,0.4); box-shadow:inset 0 1px 0 rgba(255,255,255,0.4);
	position:absolute; top:-1px; left:-1px;
	-moz-border-radius:10px; -webkit-border-radius:10px; border-radius:10px;
	border:1px solid #666;
	text-indent:-9999px;
	height:8px;
	background:#666 url('../images/progress_bar_bg.png') repeat-x;
}

.progress-bar .bar.red {
	border:1px solid #e83d0f;
	background:#e83d0f url('../images/progress_bar_bg.png') repeat-x;
}

.progress-bar .bar.blue {
	border:1px solid #2766a1;
	background:#2766a1 url('../images/progress_bar_bg.png') repeat-x;
}

.progress-bar .bar.green {
	border:1px solid #54a306;
	background:#54a306 url('../images/progress_bar_bg.png') repeat-x;
}

.progress-bar .bar.yellow {
	border:1px solid #e8a911;
	background:#e8a911 url('../images/progress_bar_bg.png') repeat-x;
}

.progress-bar .bar.white {
	border:1px solid #aaa;
	background:#fff url('../images/progress_bar_bg.png') repeat-x;
}



/* ACCORDIONS																	*/
/* ---------------------------------------------------------------------------- */

.accordion-wrapper { padding-bottom:5px; }
.accordion-block { padding:5px 5px 0; }

.accordion-block h3 { opacity:1; cursor:pointer; margin:0; background:#fff url('../images/accordion_closed.png') no-repeat 98% 10px; line-height:19px; font-size:14px; font-weight:bold; padding:13px 45px 13px 13px; }
.accordion-block h3:hover { opacity:0.75; }
.accordion-block.open h3 { background:#fff url('../images/alert_icon_close.png') no-repeat 98% 10px; }
.accordion-block.edit h3 { background:#fff url('../images/table_icon_edit.png') no-repeat 98% 10px; }

.accordion-block h4 { opacity:1; cursor:pointer; margin:0; background:#fff 98% 10px; line-height:19px; font-size:14px; font-weight:bold; padding:13px 45px 13px 13px; }
.accordion-block h4:hover { opacity:0.75; }
.accordion-block.open h4 { background:#fff url('../images/alert_icon_close.png') no-repeat 98% 10px; }
.accordion-block.edit h4 { background:#fff url('../images/table_icon_edit.png') no-repeat 98% 10px; }


.accordion-block .accordion-content { display:none; padding:15px 15px 0 15px; }



/* BUTTONS																		*/
/* ---------------------------------------------------------------------------- */
.button { text-decoration:none; margin:0 6px 0 0; font-weight:bold; display:inline-block; -moz-border-radius:3px; -webkit-border-radius:3px; border-radius:3px; color:#fff; }
.button:hover { color:#fff; box-shadow:none; }
.button.small { font-size:14px; line-height:11px; padding:8px 9px 7px; }
.button.medium { font-size:14px; line-height:12px;padding:10px 10px 8px; }
.button.large { font-size:16px; line-height:16px; padding:13px 15px 11px; }

.button {
	background:#606a6d;
	background-image: -webkit-gradient( linear, left bottom, left top, color-stop(0, #606a6d), color-stop(1, #909799) );
	background-image: -moz-linear-gradient( center bottom, #606a6d 0%, #909799 100% );
	border:1px solid #606a6d;
	box-shadow:inset 0 1px 0 rgba(255,255,255,0.6) !important;
	color:#fff !important;
	width:auto !important;
} .button:hover, .button.hover { background:#606a6d; }

.button.red { 
	background:#E83D0E;
	background-image: -webkit-gradient( linear, left bottom, left top, color-stop(0, #E83D0E), color-stop(1, #F07C5B) );
	background-image: -moz-linear-gradient( center bottom, #E83D0E 0%, #F07C5B 100% );
	border:1px solid #E83D0E;
} .button.red:hover, .button.hover.red { background:#E83D0E; }

.button.blue {
	background:#2a68a2;
	background-image: -webkit-gradient( linear, left bottom, left top, color-stop(0, #2a68a2), color-stop(1, #6e98c0) );
	background-image: -moz-linear-gradient( center bottom, #2a68a2 0%, #6e98c0 100% );
	border:1px solid #2a68a2;
} .button.blue:hover, .button.hover.blue { background:#2a68a2; }

.button.yellow {
	background:#e8aa13;
	background-image: -webkit-gradient( linear, left bottom, left top, color-stop(0, #e8aa13), color-stop(1, #f0c55f) );
	background-image: -moz-linear-gradient( center bottom, #e8aa13 0%, #f0c55f 100% );
	border:1px solid #e8aa13;
} .button.yellow:hover, .button.hover.yellow { background:#e8aa13; }

.button.green {
	background:#57a50b;
	background-image: -webkit-gradient( linear, left bottom, left top, color-stop(0, #57a50b), color-stop(1, #8dc159) );
	background-image: -moz-linear-gradient( center bottom, #57a50b 0%, #8dc159 100% );
	border:1px solid #57a50b;
} .button.green:hover, .button.hover.green { background:#57a50b; }



/* FOOTER																		*/
/* ---------------------------------------------------------------------------- */

#footer { background:#eee; padding:15px 0; font-size:11px; color:#888; }
#footer a { text-decoration:none; }


#app-loading { display:none; opacity:0.7; position:fixed; top:0; left:0; width:100%; height:100%; background:#000 url('../images/loading_app.gif') no-repeat center center; }


/* CSS3 ANIMATED TRANSITIONS													*/
/* ---------------------------------------------------------------------------- */

.gallery-pager {
	-webkit-transition: all 0.25s ease-in-out;
	-moz-transition: all 0.25s ease-in-out;
	-o-transition: all 0.25s ease-in-out;
	-ms-transition: all 0.25s ease-in-out;
	transition: all 0.25s ease-in-out;
}


.fb_preview{ background:url(../images/dummy_bg_repeat.gif) center top repeat-y; height:auto; width:1000px; overflow:auto; margin:0 auto; display:block;}
.dummy_container{ background:url(../images/dummy_bg.gif) center top no-repeat; height:auto; width:510px; overflow:auto; padding:115px 280px 0 210px; margin:0 auto; display:block; }
.fb_container{ background:#f8f8f8; height:auto; width:510px; display:block;}

.accordion-block .small_txtbx{width:50px; height:20px; border:#CCCCCC 1px solid; padding:0px; margin:0px;}

.small_txtarea{width:400px; height:100px; border:#CCCCCC 1px solid}

#floatingdiv
{
	position:fixed;
    width:500px;
    border:#53A9FF 6px solid;
    z-index:5000;
    left:25%;
    top:22%;
    min-height:150px;
    background:#FFF;
    -moz-border-radius: 1em 4em 1em 4em;
    border-radius: 1em 4em 1em 4em;
    padding:15px;
}

#floatingdiv p
{
	font-size:15px;
}

.quick_post_submit
{
	float:left; width:93%;
}

#content_floatingdiv
{
	position:absolute;
    width:800px;
    border:#53A9FF 6px solid;
    z-index:5000;
    left:18%;
    top:30%;
    height:400px;
    background:#FFF;
    -moz-border-radius: 1em 1em 1em 1em;
    border-radius: 1em 1em 1em 1em;
    padding:15px;
    display:none;
    overflow:scroll;
    overflow-x:hidden;
}

#add_post_form
{
	position:absolute;
    left:8%;
    top:40%;
    width:80%;
    min-height:200px;
    border:#53A9FF 6px solid;
    display:none;
    background:#FFFFFF;
    -moz-border-radius: 1em 1em 1em 1em;
    border-radius: 1em 1em 1em 1em;
    z-index:8000;
    padding:0px 30px 0px 30px;
}

#overlay {
    position: fixed;
    top: 0;
    left: 0;
    background-color: #fff;
    width: 100%;
    height: 100%;
    display: none;
}

.form_popup
{
	color:#F00;
    background:#F5F5F5;
    padding:10px;
    display:none;
}

.trading_conditions
{
	float:left;
    text-align:left;
    margin-left:10px;
    padding-bottom:20px;
}