<?php

$PageTitle 	= GetPageTitle($_SERVER['PATH_INFO'],$_REQUEST['view']);

Yii::app()->session['language'] = 2;

$url = $_SERVER['REQUEST_URI'];
$temp_url = explode('index.php/',$url);
$file = $temp_url[1];
$show_content = true;

$again_exp = explode('/',$file);
$file_name = $again_exp[1];

if($file_name == 'onelocation')
{
	$LocationInfo = Location::model()->LocationInfo($_REQUEST['id']);
	$PageTitle = $LocationInfo[0]['name'];
}

Yii::app()->session['language'] = 2;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html lang="en" class="csstransforms no-csstransforms3d csstransitions js cssanimations csstransitions">

<head>
    <title><?php if(!empty($PageTitle)) echo $PageTitle.' - '; ?>Cuecow - the social media engagement platform</title>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo Yii::app()->charset ?>" />
    <link href="http://cuecow.com/favicon.ico" type="image/x-icon" rel="icon" />
    <link href="http://cuecow.com/favicon.ico" type="image/x-icon" rel="shortcut icon" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <!--link rel="stylesheet" media="all" type="text/css" href="css/smoothness-jquery-ui.css" />
    <link rel="stylesheet" href="css/jquery-ui.css" /-->
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" rel="stylesheet" type="text/css" />
    
    <?php if( $file_name == 'profile' && $_REQUEST['view'] == 'medias' ) { ?>

    <link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/social-buttons.css" rel="stylesheet" type="text/css" />
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.0/css/font-awesome.min.css" rel="stylesheet">
    
    <?php } ?>
    
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui-bootstrap-theme/jquery.ui.1.10.0.ie.css" />
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui-bootstrap-theme/jquery-ui-1.10.0.custom.css" />
    <link rel="stylesheet" media="all" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui-timepicker-addon.css" />
    <link rel="stylesheet" media="all" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/extra.css" />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Droid+Sans:400,700">
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Droid+Serif">
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Boogaloo">
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Economica:700,400italic">
</head>
<?php

if(isset(Yii::app()->user->user_id))
	$intro_tour = User::model()->GetOffRecord(Yii::app()->user->user_id); 

?>



<body <?php if($intro_tour[0]['show_intro_tour'] == 1){  ?>onload="$('#myTour').modal('show')" <?php } ?>>

<?php if(!Yii::app()->user->isGuest) { ?>
<!--start: Header -->
<div class="header-content-fix">
	<header>	
		<!--start: Container -->
		<div class="container">
			<a class="brand" href="<?php echo Yii::app()->request->baseUrl; ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/cuecow-logo_small.png" width="166" height="88" style="z-index:100;" /></a>
			<!--start: Navbar -->
			<div class="navbar navbar-inverse" style="font-family: 'Droid Sans'; font-size: 12px; color: #666;">
	    		<div class="navbar-inner">
	          		<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	            		<span class="icon-bar"></span>
	            		<span class="icon-bar"></span>
	            		<span class="icon-bar"></span>
	          		</a>
                    
	          		<div class="nav-collapse collapse">
	            		<ul class="nav">
							<li <?php if($file_name == 'dashboard') echo 'class="active"'; ?>>
	                			<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/dashboard">Dashboard</a>
	              			</li>
                            
                            <?php if(Yii::app()->user->role=='admin') { ?>
                            <li class="dropdown">
                            	<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/usermanagement/view/List" class="dropdown-toggle" data-toggle="dropdown">Site Manager<b class="caret"></b></a>
                            	<ul class="dropdown-menu">
									<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/usermanagement/view/List"><?php echo PageTitles::model()->SinglePageTitle('/user/usermanagement','List'); ?></a></li>
	                  				<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/usermanagement/view/Add"><?php echo PageTitles::model()->SinglePageTitle('/user/usermanagement','Add'); ?></a></li>
									<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/usermanagement/view/invoices"><?php echo PageTitles::model()->SinglePageTitle('/user/usermanagement','invoices'); ?></a></li>
									<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/content/index"><?php echo PageTitles::model()->SinglePageTitle('/content/index',''); ?></a></li>
                                    
                                    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/panel/index"><?php echo PageTitles::model()->SinglePageTitle('/panel/index',''); ?></a></li>
                                    
                                    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/marketingOffer/index/key/Aew12KjyGG"><?php echo PageTitles::model()->SinglePageTitle('/marketingoffer/index',''); ?></a></li>
                                    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/marketingOffer/listing"><?php echo PageTitles::model()->SinglePageTitle('/marketingoffer/listing',''); ?></a></li>
	                			</ul>
                            </li>
                            <?php } ?>
                            
                            <li class="dropdown <?php if($file_name == 'location' || $file_name == 'editlocation' || $file_name == 'onelocation') echo ' active'; ?>">
                            	<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/location/location/view/List" class="dropdown-toggle" data-toggle="dropdown">Venues<b class="caret"></b></a>
                            	<ul class="dropdown-menu">
                                
									<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/location/location/view/List"><?php echo PageTitles::model()->SinglePageTitle('/location/location','List'); ?></a></li>
	                  				<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/location/location/view/Map"><?php echo PageTitles::model()->SinglePageTitle('/location/location','Map'); ?></a></li>
									<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/location/location/view/Groups"><?php echo PageTitles::model()->SinglePageTitle('/location/location','Groups'); ?></a></li>
                                    
                                    <li><a href="<?php echo Yii::app()->request->baseUrl?>/index.php/location/location/view/AddGroups"><?php echo getContent('user.location.groups.add',Yii::app()->session['language']); ?></a></li>
                                    
									<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/location/location/view/Add"><?php echo PageTitles::model()->SinglePageTitle('/location/location','Add'); ?></a></li>
	                			</ul>
                            </li>
                            
							<li class="dropdown <?php if($file_name == 'campaign' || $file_name == 'newcampaign') echo ' active'; ?>">
	                			<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/campaign">Campaigns</a>
	              			</li>	
                            
                            <li class="dropdown <?php if($file_name == 'facebook' || $file_name == 'fbposts' || $file_name == 'viewfbposts') echo ' active'; ?>">
	                			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Postings<b class="caret"></b></a>
	                			<ul class="dropdown-menu">
	                  				<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/facebook/view/post"><?php echo PageTitles::model()->SinglePageTitle('/user/facebook','post'); ?></a></li>
                                    
									<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/facebook/view/Manage"><?php echo PageTitles::model()->SinglePageTitle('/user/facebook','Manage'); ?></a></li>
                                    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/twitter"><?php echo PageTitles::model()->SinglePageTitle('/user/twitter',''); ?></a></li>
	                			</ul>
	              			</li>
                            
                            <?php
                        
							$user_id = Yii::app()->user->user_id;
							$userid_len = strlen($user_id);
				
							$rand = rand(10,100000);
							$put_rand = rand(1,5);
							
							$part_string = $userid_len.'_'.$rand.$user_id.'_'.$put_rand;
							
							$yussig = $rand * ($put_rand + $put_rand);
							
							
							?>
							
                            <li><a href="http://apps2.cuecow.com?pin=<?php echo $part_string; ?>&yussig=<?php echo $yussig.$user_id; ?>">Apps</a></li>								
                            
							<li <?php if($file_name == 'buzz') echo 'class="active"'; ?>><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/buzz">Buzz</a></li>
                            
							<li class="dropdown <?php if($file_name == 'profile' || $file_name == 'changecard') echo ' active'; ?>">
	                			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Account<b class="caret"></b></a>
	                			<ul class="dropdown-menu">
	                  				<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/site/logout">Log Out</a></li>
                                    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/profile/view/password">Settings</a></li>
	                			</ul>
	              			</li>
                            
	            		</ul>
	          		</div>
	        	</div>
	      	</div>
			<!--end: Navbar -->
			
            
            
		</div>
		<!--end: Container-->			
			
	</header>
</div>
<!--end: Header-->

<div class="clearfix"></div>

<?php

if(isset(Yii::app()->user->user_id) && Yii::app()->user->role=='admin') 
{
?>
<div id="overlay_content"></div>
<div id="content_floatingdiv">
	<h4>Edit Content text</h4>
    
    <table cellpadding="0" cellspacing="1" style="width:100%;" class="table table-striped"> 
    <thead> 
    <tr> 
        <th width="18%" align="left"><strong>Content Id</strong></th> 
        <th width="2%">&nbsp;</th>
        <th width="8%" align="left"><strong>Language</strong></th>
        <th width="2%">&nbsp;</th>
        <th width="70%" align="left"><strong>Text</strong></th>
    </tr> 
    </thead> 
    <tbody>
	<?php 
				
	$h=1;
	$cur_page_display = newfindpage($_SERVER['PATH_INFO']);
	
	$AllRec = Contents::model()->GetPageRecord($cur_page_display);
	
	$rh = 1;
	
	foreach($AllRec as $record)
	{
		/*if(Yii::app()->cache->get($record['content_id'].$record['lang_id']) != '')
		{*/
	?>
    
        <tr> 
            <td><a href="javascript:void(0);" onclick="javascript:EditSpecContent('<?php echo $record['content_id'];?>','<?php echo $rh; ?>',<?php echo Yii::app()->session['language']; ?>);"><?php echo $record['content_id'];?></a></td> 
            <td></td>
            <td><?php echo Languages::model()->GetLanguage($record['lang_id']);?></td> 
            <td></td>
            <td id="contenttext_<?php echo $rh;?>"><?php echo $record['content_text'];?></td> 
        </tr>
    		
	<?php 
		
		$h++;	
		$rh++;
		/*}*/
	}
			
	?>
    </tbody>
    </table>
</div>

<?php 
}


$PageTitle = GetPageSubTitle($_SERVER['PATH_INFO'],$_REQUEST['view']); 

if($file_name == 'onelocation')
{
	$LocationInfo = Location::model()->LocationInfo($_REQUEST['id']);
	$PageTitle = $LocationInfo[0]['name'];
}

?>

<div id="page-title">
	<div id="page-title-inner">
		<!-- start: Container -->
		<div class="container">
			<div class="container">
				<h2><i class="ico-embed-close ico-white"></i><?php echo $PageTitle; ?></h2>
			</div>
		</div>
		<!-- end: Container  -->
	</div>	
</div>
<input type="hidden" name="mypagename" id="mypagename" value="<?php echo $PageTitle; ?>" />
<div class="clear"></div>

<?php }

if(!Yii::app()->user->isGuest && Yii::app()->user->role!='admin')
{
	$subscription_info = User::model()->UserDefaultSubscription();
	
	$split_info = explode('#',$subscription_info);
	
	if(count($split_info))
	{
		if(!empty($split_info[0]) && Yii::app()->user->role!='admin')
		{
		
		?>
	
			<div class="alert alert-error">
	  			<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php echo $split_info[0]; ?>
			</div>
	
	
		<?php 
		
		}
		
		if($split_info[1] == 1)
			$show_content = false;
	}
}
	
if($file == 'subscription')
	$show_content = true;

?>

<?php  if($show_content) echo $content; ?>

<!--- Kim inserted live chat -->
<!-- begin olark code --><script type='text/javascript'>/*{literal}<![CDATA[*/window.olark||(function(i){var e=window,h=document,a=e.location.protocol=="https:"?"https:":"http:",g=i.name,b="load";(function(){e[g]=function(){(c.s=c.s||[]).push(arguments)};var c=e[g]._={},f=i.methods.length; while(f--){(function(j){e[g][j]=function(){e[g]("call",j,arguments)}})(i.methods[f])} c.l=i.loader;c.i=arguments.callee;c.f=setTimeout(function(){if(c.f){(new Image).src=a+"//"+c.l.replace(".js",".png")+"&"+escape(e.location.href)}c.f=null},20000);c.p={0:+new Date};c.P=function(j){c.p[j]=new Date-c.p[0]};function d(){c.P(b);e[g](b)}e.addEventListener?e.addEventListener(b,d,false):e.attachEvent("on"+b,d); (function(){function l(j){j="head";return["<",j,"></",j,"><",z,' onl'+'oad="var d=',B,";d.getElementsByTagName('head')[0].",y,"(d.",A,"('script')).",u,"='",a,"//",c.l,"'",'"',"></",z,">"].join("")}var z="body",s=h[z];if(!s){return setTimeout(arguments.callee,100)}c.P(1);var y="appendChild",A="createElement",u="src",r=h[A]("div"),G=r[y](h[A](g)),D=h[A]("iframe"),B="document",C="domain",q;r.style.display="none";s.insertBefore(r,s.firstChild).id=g;D.frameBorder="0";D.id=g+"-loader";if(/MSIE[ ]+6/.test(navigator.userAgent)){D.src="javascript:false"} D.allowTransparency="true";G[y](D);try{D.contentWindow[B].open()}catch(F){i[C]=h[C];q="javascript:var d="+B+".open();d.domain='"+h.domain+"';";D[u]=q+"void(0);"}try{var H=D.contentWindow[B];H.write(l());H.close()}catch(E){D[u]=q+'d.write("'+l().replace(/"/g,String.fromCharCode(92)+'"')+'");d.close();'}c.P(2)})()})()})({loader:(function(a){return "static.olark.com/jsclient/loader0.js?ts="+(a?a[1]:(+new Date))})(document.cookie.match(/olarkld=([0-9]+)/)),name:"olark",methods:["configure","extend","declare","identify"]});
/* custom configuration goes here (www.olark.com/documentation) */
olark.identify('6977-216-10-1541');/*]]>{/literal}*/</script>
<!-- end olark code -->

<!-- start: Java Script -->
<!-- Placed at the end of the document so the pages load faster -->

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.9.1.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/isotope.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.imagesloaded.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/flexslider.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/carousel.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.cslider.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/slider.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/fancybox.js"></script>
<script defer="defer" src="<?php echo Yii::app()->request->baseUrl; ?>/js/custom.js"></script>
<!-- end: Java Script -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui-1.10.1.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/main.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui-sliderAccess.js"></script>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/extra.js"></script>

<script>
    $('.mydialog').dialog({
        autoOpen: false,
        width: 600,
        buttons: {
            "Ok": function () {
                $(this).dialog("close");
            },
            "Cancel": function () {
                $(this).dialog("close");
            }
        }});
    $('.mydialog').dialog('open');

</script>

<script type="text/javascript">

var isCtrl = false;

$("body").keyup(function (e) 
{
	if(e.keyCode == 27)
	{
		$('#content_floatingdiv').hide();
		$('#overlay_content').hide();
	}
	
	if(e.keyCode == 17) 
		isCtrl=false;
}).keydown(function (e) 
{
	if(e.keyCode == 17) 
		isCtrl=true;
	
	if(e.keyCode == 69 && isCtrl == true) 
	{
		$("body").scrollTop(150);
		$('#content_floatingdiv').show();
		$('#overlay_content').show();
		return false;
	}
});

</script>

<?php if($file_name == 'buzz' || ($file_name == 'usermanagement' && $_REQUEST['view'] == 'List')) { ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/fancybox/jquery.fancybox-1.3.4.pack.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/style.css" type="text/css" media="screen" />

<style type="text/css">
.loading {display: block; z-index: 90; width: 128px; height: 128px; background: url(<?php echo Yii::app()->request->baseUrl; ?>/assets/buzz/loading.gif) no-repeat; position: absolute; display: block; top: 45%; right: 45%; font-size: 0; text-indent: -999; line-height: 0; border: #000 0px solid;}
</style>
<!--	Load the Tablesorter script. You can remove this if you will not be displaying any sortable tables. -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/jquery.tablesorter.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/jquery.tablesorter.pager.js" type="text/javascript"></script>


<script type="text/javascript">

$(document).ready(function() 
{ 
	$("#googleresults").tablesorter({sortList: [[4,1]], headers: { 0:{sorter: false}, 5:{sorter: false}}});
	$("table#user_list").tablesorter({ sortList: [[1,0]] });
	$(":checkbox.cat").click(function() {
		  $("#filter").submit();
	});
	$('#lang').change(function() {
	  $("#filter").submit();
	});
	$('#source').live("change",function() {
	  $("#filter").submit();
	});
		
	$('#filter').submit(function() 
	{
	  	$('span.loading').fadeIn('slow');
	  	if ($('#cat0').is(':checked')) { var cat0 = $('#cat0').attr('value'); var data0 = 'category='+cat0+'&'}
	  	else {var data0 = ''}
	  	if ($('#cat1').is(':checked')) { var cat1 = $('#cat1').attr('value'); var data1 = 'category1='+cat1+'&'}
	  	else {var data1 = ''}
	  	if ($('#cat2').is(':checked')) { var cat2 = $('#cat2').attr('value'); var data2 = 'category2='+cat2+'&'}
	  	else {var data2 = ''}
	  	if ($('#cat3').is(':checked')) { var cat3 = $('#cat3').attr('value'); var data3 = 'category3='+cat3+'&'}
	  	else {var data3 = ''}
	  	if ($('#cat4').is(':checked')) { var cat4 = $('#cat4').attr('value'); var data4 = 'category4='+cat4+'&'}
	  	else {var data4 = ''}
	  	if ($('#cat5').is(':checked')) { var cat5 = $('#cat5').attr('value'); var data5 = 'category5='+cat5+'&'}
	  	else {var data5 = ''}
	  	var source = $('#source').attr('value');
	  	var language = $('#lang').attr('value');
	  	var dataString = data0 + data1 + data2 + data3 + data4 + data5 + 'source=' + source + '&language=' + language;  
	  	
		///save user choosen categories
		SaveCategories(data0 + data1 + data2 + data3 + data4 + data5 ,<?php echo Yii::app()->user->user_id; ?>);
		
		//alert (data0 + data1 + data2 + data3 + data4 + data5);return false;  
		
		var userid = $('#userid').val();
		// alert(userid);
		
		$.ajax(
		{
			type: "POST",  
		  	url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/postage/id/"+userid,  
		  	data: dataString,  
		  	success: function(data) { 
			$('td#results').empty().hide();
			$('td#results').html(data).fadeIn('slow');
			$("#postresults").tablesorter({sortList: [[4,1]], headers: { 0:{sorter: false}, 5:{sorter: false}}});
			$('span.loading').fadeOut('slow');
		}
	});  
	return false;
	});
	
	$("#newalert").live('click', function() 
	{
  		if ($('#cat0').is(':checked')) 
		{ 
			var cat0 = $('#cat0').attr('value'); var data0 = 'category='+cat0+'&'
		}
		else 
		{
			var data0 = ''
		}
		
		if ($('#cat1').is(':checked')) 
		{ 
			var cat1 = $('#cat1').attr('value'); var data1 = 'category1='+cat1+'&'
		}
		else 
		{	
			var data1 = ''
		}
		
		if ($('#cat2').is(':checked')) 
		{ 
			var cat2 = $('#cat2').attr('value'); var data2 = 'category2='+cat2+'&'
		}
		else 
		{
			var data2 = ''
		}
		
		if ($('#cat3').is(':checked')) 
		{ 
			var cat3 = $('#cat3').attr('value'); var data3 = 'category3='+cat3+'&'
		}
		else 
		{	
			var data3 = ''
		}
		
		if ($('#cat4').is(':checked')) 
		{ 
			var cat4 = $('#cat4').attr('value'); var data4 = 'category4='+cat4+'&'
		}
		else 
		{
			var data4 = ''
		}
		
		if ($('#cat5').is(':checked')) 
		{ 
			var cat5 = $('#cat5').attr('value'); var data5 = 'category5='+cat5+'&'
		}
		else 
		{
			var data5 = ''
		}
		
	var source = $('#source').attr('value');
	var language = $('#lang').attr('value');
	var userid = $('#userid').val();
	var dataString = data0 + data1 + data2 + data3 + data4 + data5 + 'source=' + source + '&language=' + language + '&id=' + userid;  
	
	//alert (dataString);return false;  
	//$(this).attr('href', '<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/alert/'+dataString);
	
	return false;
	});
	
	$('.mailit').click(function(){
		var needed = $(this).attr('rel');
		var url = $('tr#'+needed+' input.url').val();
		//alert(needed+url);
		var body = $('tr#'+needed+' input.body').val();
			$('#missinglink input[name=url]').val(url);
			$('#missinglink input[name=body]').val(body);
			$('div.datainsert').empty();
			$('div.datainsert').append('<a href="'+url+'"><strong>'+url+'</strong></a>');
			$('div.datainsert').append('<br />'+body);
		});
		
		$(".sure").click(function() {
			if (confirm('Are you sure you want to replace the keywords?')) {
				$.fancybox.close();
			return true;
			} else {
			return false;
		}
	}); 
}); 

function SaveCategories(categories,userid)
{
	$.ajax(
		{
			type: "POST",  
		  	url: "<?php echo Yii::app()->request->baseUrl; ?>/ajax/SavebuzzCategory.php",  
		  	data: "userid="+userid+"&"+categories,  
		  	success: function(data) { 
			//alert(data);
		}
	});  
}

</script>
<?php } ?>


<?php if(isset(Yii::app()->user->user_id)) { ?>
<!-- FOOTER -->
<?php

$UserInfoMain = User::model()->GetRecord();
	
if(!empty($UserInfoMain[0]['username']))
	$UserNameMain = $UserInfoMain[0]['username'];
else
	$UserNameMain = $UserInfoMain[0]['email'];
		
if(!empty($UserInfoMain[0]['role']))
	$UserRoleMain = ucfirst($UserInfoMain[0]['role']);
else
	$UserRoleMain = 'None';


$myFile = "version.txt";
$fh = fopen($myFile, 'r');
$version = fread($fh, filesize($myFile));
fclose($fh);

?>
<input type="hidden" id="website_url" value="<?php echo Yii::app()->request->baseUrl; ?>" />
<div id="footer" class="container_4" style="background:#FFF; width:100%;">
	<div class="grid_4" align="center">Copyright &copy;<?php echo date('Y'); ?> Cuecow, <?php echo $version; ?>, User: <?php echo $UserNameMain; ?>, Role: <?php echo $UserRoleMain; ?></div>
    
    <?php if(isset(Yii::app()->user->prev_user_id) && Yii::app()->user->prev_user_id != '') { ?>
    <div class="grid_4" align="center">
    	<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/simulateuser/user_id/<?=Yii::app()->user->prev_user_id?>">Stop Simulation</a>
    </div>
    <?php } ?>
    
</div>
<!-- END FOOTER -->
<?php } ?>

</body>
</html>
<?php if(isset(Yii::app()->user->user_id)) { ?>
<script>
function DisableTour(){
	$.post('<?php echo Yii::app()->request->baseUrl; ?>'+'/index.php/user/setintroflag', {'user_id':<?php echo Yii::app()->user->user_id; ?>})
}

</script>
<?php 
}
if(isset(Yii::app()->user->user_id))		
	$intro_tour = User::model()->GetOffRecord(Yii::app()->user->user_id); 

if($intro_tour[0]['show_intro_tour'] == 1)
{
	$findpage = newfindpage($_SERVER['PATH_INFO']);

	if($findpage)
	{
		$getContent = getContent($findpage,'2');
	}

	if(!empty($getContent))
	{
		$show = true;
					
		if($_SERVER['PATH_INFO'] == '/user/profile/view/medias' && isset(Yii::app()->user->user_id))
		{
			$social_check = AccessToken::model()->CheckAuth();

			if(count($social_check)>0) 
				$show = false;
		}
					
		if($show)
		{
?>
            		
		<div id="myTour" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel"><?php if($PageTitle) echo $PageTitle; else echo 'Dashboard'; ?></h3>
			</div>
                        
            <div class="modal-body">
            	<p><?php echo $getContent; ?></p>
			</div>
            
            <div class="modal-footer">
            	<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                <button class="btn btn-info" data-dismiss="modal" aria-hidden="true" onclick="DisableTour();">Disable introduction-tour</button>
                 
            </div>
		</div>

		<?php

		}
	}
} 
			
?>