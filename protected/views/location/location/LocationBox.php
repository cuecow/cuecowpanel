<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

<h5><?php echo getContent('user.onelocation.welcome',Yii::app()->session['language']); ?></h5>

<?php

if(!empty($_REQUEST['dataof']))
	$date_duration = strtotime(now)-($_REQUEST['dataof']*24*60*60);
else
	$date_duration = strtotime(now)-(7*24*60*60);
								
$all_locations = $model->getallurl();

//get address of location
$location_address = $model->LocationAddress($oneurl[0]['fburl'],$oneurl[0]['fsurl'],$oneurl[0]['googleurl'],$_REQUEST['id']);

//get lat. and long. of location
$location_dim_temp = $model->LocationDim($oneurl[0]['fburl'],$oneurl[0]['fsurl'],$oneurl[0]['googleurl'],$_REQUEST['id']);

if(!empty($location_dim_temp))
	$location_dim=explode('#',$location_dim_temp);
	
$google_dim_temp = $model->LocationGoogleDim($oneurl[0]['googleurl'],$_REQUEST['id']);

if(!empty($google_dim_temp))
{
	$google_dim = explode('#',$google_dim_temp);
	
	$search_gurl = 'https://maps.googleapis.com/maps/api/place/search/json?location='.$google_dim[0].','.$google_dim[1].'&radius=500&name='.$all_locations[0]['name'].'&sensor=true&key=AIzaSyCjZdj2qvK8-_Dc5VKvzQtAN_7rIsJWZVM';
	
	$result_search = json_decode(@file_get_contents($search_gurl));
	
	$rating_url = $result_search->results[0]->rating;

	if(!empty($rating_url) && $rating_url>0)
		$rating_url = ceil($rating_url);
	else
		$rating_url = 0;
}
			
?>

	<table class="table table-striped">
	<tbody> 
	<tr> 
		<td>
			<select class="pagesize" name="location" style="width:500px;" onChange="window.location.href='<?php echo Yii::app()->request->baseUrl; ?>/index.php/location/onelocation/'+this.value+''">
			<?php
			
				foreach($all_locations as $key=>$values)
				{ 
			?>
				<option value="<?php echo $values['loc_id']; ?>" <?php if($_REQUEST['id']==$values['loc_id']) echo 'selected'; ?>>
					<?php echo ucfirst($values['name']); ?>
				</option>
			<? } ?>
			</select>
		</td> 
		<td width="25%"><?php echo getContent('user.onelocation.daterange',Yii::app()->session['language']); ?> &nbsp;&nbsp;&nbsp;
			<select class="pagesize" name="date_range" style="width:205px;" onChange="javascript:gotourl(this.value);">
				<option value="7d" <?php if($_REQUEST['val']=='7d' || empty($_REQUEST['val'])) echo 'selected'; ?>>Last 7 days</option>
				<option value="14d" <?php if($_REQUEST['val']=='14d') echo 'selected'; ?>>Last 14 days</option>
				<option value="1m" <?php if($_REQUEST['val']=='1m') echo 'selected'; ?>>Last 1 Month</option>
				<option value="3m" <?php if($_REQUEST['val']=='3m') echo 'selected'; ?>>Last 3 Months</option>
				<option value="6m" <?php if($_REQUEST['val']=='6m') echo 'selected'; ?>>Last 6 Months</option>
				<option value="1y" <?php if($_REQUEST['val']=='1y') echo 'selected'; ?>>Last 1 Year</option>
				<option value="3y" <?php if($_REQUEST['val']=='3y') echo 'selected'; ?>>Last 3 Years</option>
				<option value="6y" <?php if($_REQUEST['val']=='6y') echo 'selected'; ?>>Last 6 Years</option>
			</select>
		</td> 
	</tr>
	<tr> 	
		<td>
		
		<?php

		$gurl='';

		if($oneurl[0]['googleurl']!='')
		{
			$gurl = $oneurl[0]['googleurl'];
			/*$html = file_get_html($gurl);

			$rating = $html->find('[class*=rsw-unstarred]');
					
			$totalrev = $html->find('[class*=rsw-pp rsw-pp-link]');
													
			foreach($totalrev as $key=>$value) 
				$reviewcount=strip_tags($totalrev[0]);
													
			$review_hold=explode(" ",$reviewcount);

			if(count($review_hold))
			{
				for($i=1;$i<=5;$i++)
				{
					if($i<=$rating_url)
						echo '<img src="'.Yii::app()->request->baseUrl.'/images/1319878693_star.png" />';
					else
						echo '<img src="'.Yii::app()->request->baseUrl.'/images/1319878846_star_empty.png" />';
				} 
				
			?>
				&nbsp;<b><?=$rating_url?> <?php echo getContent('user.onelocation.gogoleratings',Yii::app()->session['language']); ?></b>
			
		<? 
			}*/
		} 
			
		?>
			
		<?php $address = explode("*",$oneurl[0]['address']); ?>
		
        <?php if($location_address) { ?>
        <br /><br /><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/1319868524_marker.png" />
			
		<?php echo $location_address; ?><br /><br />
													
		<?php } if(!empty($oneurl[0]['fburl'])){ ?>
		
        	<b><?php echo getContent('user.onelocation.fb',Yii::app()->session['language']); ?>:</b> <a href="<? echo urldecode($oneurl[0]['fburl']);?>"><? echo urldecode($oneurl[0]['fburl']);?></a><br /> 
		
		<?php } ?>
													
		<?php if(!empty($oneurl[0]['fsurl'])){ ?>
		
        	<b><?php echo getContent('user.onelocation.fs',Yii::app()->session['language']); ?>:</b> <a href="<? echo urldecode($oneurl[0]['fsurl']);?>"><? echo urldecode($oneurl[0]['fsurl']);?></a><br />
		
		<?php } ?>
													
		<?php if(!empty($oneurl[0]['googleurl'])){ ?>
		
        	<b><?php echo getContent('user.onelocation.google',Yii::app()->session['language']); ?>:</b> <a href="<? echo urldecode($oneurl[0]['googleurl']);?>"><? echo urldecode($oneurl[0]['googleurl']);?></a>
		
		<?php } ?>
        
	</td> 
	<td width="35%">
	
		<script>
    	function initialize() 
		{
        	var mapOptions = {
          		zoom: 4,
          		center: new google.maps.LatLng(<?=$location_dim[0];?>, <?=$location_dim[1];?>),
          		mapTypeId: google.maps.MapTypeId.ROADMAP
        	};

        	var map = new google.maps.Map(document.getElementById('map'),mapOptions);

        	var marker = new google.maps.Marker({
          		position: map.getCenter(),
          		map: map,
          		title: 'Click to zoom'
        	});

        	google.maps.event.addListener(map, 'center_changed', function() {
          		// 3 seconds after the center of the map has changed, pan back to the
          		// marker.
          		window.setTimeout(function() {
            		map.panTo(marker.getPosition());
          		}, 3000);
        	});

        	google.maps.event.addListener(marker, 'click', function() {
          		map.setZoom(8);
          		map.setCenter(marker.getPosition());
        	});
      	}

     	google.maps.event.addDomListener(window, 'load', initialize);
    	
        </script>
    		
		<div id="map" style="height:200px;width:"></div>
	</td> 
</tr>
</tbody> 
</table>

<div class="benchmark">
	
    <div class="benchmark_txt">
		<?php echo getContent('user.onelocation.fb.benchmark',Yii::app()->session['language']); ?> &nbsp; 
	</div>
    
    <form action="" method="post" id="benchmark">
    <div class="float_left">
		<input type="text" name="another_fburl" id="another_fburl" style="width:300px;" value="<?php echo $_POST['another_fburl']; ?>" placeholder="https://www.facebook.com/<pagename>" /> &nbsp; 
    </div>
    
    <div class="float_left">
    	<input type="button" name="check" value="Compare" class="btn" onclick="CompareURL();" />
        <input type="hidden" name="cur_url" value="<?php echo $oneurl[0]['fburl']; ?>" />
	</div>
    </form>
    
</div>

<div class="clear"></div>
<div class="clearfix"></div>