<?php 

$oneurl = $model->getonelocurl();

$nrows=7;

if($_REQUEST['val']=='7d') 
	$nrows=7;
else if($_REQUEST['val']=='14d') 
	$nrows=14;
else if($_REQUEST['val']=='1m') 
	$nrows=30;
else if($_REQUEST['val']=='3m') 
	$nrows=90;
else if($_REQUEST['val']=='6m') 
	$nrows=180;
else if($_REQUEST['val']=='1y') 
	$nrows=365;
else if($_REQUEST['val']=='3y') 
	$nrows=1095;
else if($_REQUEST['val']=='6y') 
	$nrows=2190;

require_once('location/LocationScripts.php');

if(!empty($oneurl[0]['fburl']))
	$fburl_data = $model->GetURLid('fburlinfo',$_REQUEST['id']);
if(!empty($oneurl[0]['fsurl']))
	$fsurl_data = $model->GetURLid('fsurlinfo',$_REQUEST['id']);
if(!empty($oneurl[0]['googleurl']))
	$gurl_data = $model->GetURLid('gurlinfo',$_REQUEST['id']);

?>

<!-- BEGIN SUBNAVIGATION -->
<div class="container_4 no-space">
	<div id="subpages" class="clearfix">
		<div class="grid_4">
			<div class="subpage-wrap">
				<ul>
					<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/location/view/List"><?php echo PageTitles::model()->SinglePageTitle('/user/location','List'); ?></a></li>
					<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/location/view/Map"><?php echo PageTitles::model()->SinglePageTitle('/user/location','Map'); ?></a></li>
					<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/location/view/Groups"><?php echo PageTitles::model()->SinglePageTitle('/user/location','Groups'); ?></a></li>
                    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/location/view/Add"><?php echo PageTitles::model()->SinglePageTitle('/user/location','Add'); ?></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<!-- END SUBNAVIGATION -->

<div class="container_4 no-space">
	<div id="page-heading" class="clearfix">		
		<div class="grid_2 title-crumbs">
			<div class="page-wrap">
				<h2><?=ucwords($oneurl[0]['name']);?></h2>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/hcharts/js/themes/grid.js" type="text/javascript" language="javascript"></script>

<div class="container_4" style="padding-top:20px; background:#FFF;">
	<div class="panel" style="border:none; background:#FFF;">
		<div class="content">
			
            <div id="tab1" class="tab_content">
				<?php require_once('location/LocationBox.php'); ?>
			</div>
							
			<?php require_once('location/LocationSnapshot.php'); ?>
							
			<?php 
								
			require_once('location/DemographicSummary.php');
								
			if($oneurl[0]['fburl']!='') 
				require_once('location/FacebookURL.php');
									
			$gurl='';
								
			if($oneurl[0]['googleurl']!='')
			{
				$gurl=$oneurl[0]['googleurl'];
									
				require_once('location/GoogleURL.php');
			} 
							
			if($oneurl[0]['fsurl']!='')
				require_once('location/FourSquareURL.php');
										
			?>
								
		</div>	
	</div>
</div>