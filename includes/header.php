<?php

session_start();

// Set the timezone for localizing your app (optional)
date_default_timezone_set('America/New_York');

// Set your custom background color here:
$color = '454e51';

// For the demo, check for a custom color request
// Just optionally remove this to disable it.
include('includes/demo_color_check.php');

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<!--<meta http-equiv="x-ua-compatible" content="ie=edge" />-->

<!-- Apple iOS Web App Settings -->
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link rel="apple-touch-icon" href="assets/images/apple-touch-logo.png"/>
<script type="text/javascript"> 
	(function () {
		var filename = navigator.platform === 'iPad' ?
	   		'splash-screen-768x1004.png' : 'splash-screen-640x920.png';
	  	document.write(
	    	'<link rel="apple-touch-startup-image" ' +
	          'href="assets/images/' + filename + '" />' );
	})();
</script>
<!-- END Apple iOS Web App Settings -->

<title>AdminPro</title>

<!--	Load the master stylesheet
		Note: This is a PHP file that loads like a CSS file. This way, we can include
		a custom color very quickly and easily. -->
<link rel="stylesheet" href="assets/css/master.php?color=<?php echo $color; ?><?php if (isset($login) && $login) { echo '&login=true'; } ?>" type="text/css" media="screen" />

<?php if (!isset($login)) { ?>

<!--	Load the "Chosen" stylesheet. You can remove this if your
		select boxes aren't going to make use of the awesome Chosen script. -->
<link rel="stylesheet" href="assets/js/chosen/chosen.css" type="text/css" media="screen" />

<!--	Load the Fancybox stylesheet. You can remove this if you
		are not going to be lightboxing any images. -->
<link rel="stylesheet" href="assets/js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />

<!--	Load the jQuery Library - We're loading in the header because there are quite a few dependencies that require
		The library while the rest of the page loads. These include Highcharts and the Tablesorter scripts. -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>

<!--	Load the Charting/Graph scripts. You can remove this if you will not be displaying any charts. -->
<script src="assets/js/flot.js" type="text/javascript"></script>
<script src="assets/js/graphtable.js" type="text/javascript"></script>

<!--	Load the Tablesorter script. You can remove this if you will not be displaying any sortable tables. -->
<script src="assets/js/jquery.tablesorter.min.js" type="text/javascript"></script>
<script src="assets/js/jquery.tablesorter.pager.js" type="text/javascript"></script>

<!--	Load the Chosen script. You can remove this if you will not be displaying any custom select boxes. -->
<script src="assets/js/chosen/chosen.jquery.js" type="text/javascript"></script>

<!--	Load the Fancybox script. You can remove this if you will not be displaying any image lightboxes. -->
<script src="assets/js/fancybox/jquery.fancybox-1.3.4.pack.js" type="text/javascript"></script>

<!--	Load the AdminPro custom script. THIS IS REQUIRED, but elements within can be removed if unnecessary. -->
<script src="assets/js/custom.js"></script>

<!--	Set up the responsive design sizes. You probably don't want to mess with these AT ALL. -->
<script type="text/javascript">
	var ADAPT_CONFIG = {
	  	path: 'assets/css/',
	  	dynamic: true,
		callback: resizeGalleries,
	 	range: [
	    	'0px    to 420px  /// mobile.php?color=<?php echo $color; ?>&orientation=portrait',
	    	'420px  to 760px  /// mobile.php?color=<?php echo $color; ?>&orientation=landscape',
	    	'760px  to 980px  /// 720.php?color=<?php echo $color; ?>',
	    	'980px  to 1480px /// 960.css',
	    	'1480px			  /// 1400.css'
	  	]
	};
</script>

<!--	Load the Adapt script. This is what changes and resizes elements as you shrink the browser or
		view the AdminPro template on mobile devices. Try it out! -->
<script src="assets/js/adapt.min.js"></script>

<?php } ?>

</head>
<body>

<?php if (!isset($login)) { ?>

<!--	AdminPro uses a version of the 960 Grid System that was customized for this template. It includes just 4 columns that
		are fluid width and change automatically as you scale down the browser size. -->

<!--

	container_4			The main container for each row. Each one needs this, so don't forget it.
					
						OPTIONS:
						no-space		Remove all margins/padding from the container and its columns.
						header-wrap		Just the style for the header.
					
	grid_1, grid_2,
	grid_3, grid_4		Each one of these is a column style, and you need to add them to the container
						to add up to 4. So if you add a grid_3, you'll need a grid_1. A grid_2 needs
						another grid_2, etc.

-->
	
	
	
<!-- BEGIN HEADER - A lot of the top stuff is custom, so if you want to change it you'll need to edit this file as well
		 as the master.php and other sized stylesheets. -->
		 		
<div class="container_4 no-space header-wrap">

	<div id="header">
	
		<!-- LOGO -->
		<div id="logo" class="grid_3"><h1>Admin Pro</h1></div>
		
		<!-- EYEBROW NAVIGATION -->
		<div id="eyebrow-navigation" class="grid_1">
			<a href="#" class="settings">Settings</a>
			<a href="index.php" class="signout">Sign Out</a>
		</div>
		
		<?php include('includes/main_navigation.php'); ?>
		
	</div>
	<!-- END HEADER -->
	
</div>
<!-- END CONTAINER_4 - HEADER -->

<?php } ?>