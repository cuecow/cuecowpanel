<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/mapiconmaker.js" type="text/javascript"></script>
<script src="http://maps.google.com/maps?file=api&v=2&key=AIzaSyCjZdj2qvK8-_Dc5VKvzQtAN_7rIsJWZVM"></script>
<script>
function initialize()
{
	if (GBrowserIsCompatible())
	{	
		var latict;
		var longict;
		var countloc = <?php echo count($all_locations); ?>;
		
		if(countloc!=0)
		{
			var locationpt = "<?php echo $var; ?>";
			var splitstringct1 = locationpt.split("*");
  
   			var splitstringct2 = splitstringct1[0].split(",");
   			latict = parseFloat(splitstringct2[0]);
		
	   		longict = parseFloat(splitstringct2[1]);
		}
		else
		{
			latict = 56;
			longict = 10;
		}
		
        var map = new GMap2(document.getElementById("map"));
		var point = new GLatLng(latict ,longict);
		
		map.setCenter(point,8);
       
		map.enableDoubleClickZoom();
		map.enableScrollWheelZoom();
		map.addControl(new GMapTypeControl());
		map.addControl(new GScaleControl());
		map.addControl(new GLargeMapControl());
		map.enableContinuousZoom();
     	
		var baseIcon = new GIcon();
    	var baseIcondoc = new GIcon();

		baseIcon.iconSize = new GSize(16,16);
		baseIcon.iconAnchor = new GPoint(8,8);
		baseIcon.infoWindowAnchor = new GPoint(50,50);
		baseIcondoc.iconSize = new GSize(32,32);
		baseIcondoc.iconAnchor = new GPoint(8,8);
		baseIcondoc.infoWindowAnchor = new GPoint(10,0);
		
		//	var marker = new GMarker(point);
		//	map.addOverlay(marker);
		
		<?php 
		
		foreach($all_locations as $loc)
		{ 
			if(!empty($loc['fburl']))
			{
				$lat_lng_data	= $model->GetFbLikes($loc['loc_id']);
			}
			else if(!empty($loc['fsurl']))
			{
				$lat_lng_data = $model->GetFSData($loc['loc_id']);
			}
			else if(!empty($loc['googleurl']))
			{
				$lat_lng_data  = $model->GetGoogData($loc['loc_id']);
			}
			
		?>
		
			var latictn<?php echo $loc["loc_id"] ?>="<?php echo $lat_lng_data[0]["latitude"];  ?>";
			var longictn<?php echo $loc["loc_id"] ?>="<?php echo $lat_lng_data[0]["lognitude"];  ?>";
			
			var centerPointn<?php echo $loc["loc_id"]; ?> = new GLatLng(latictn<?php echo $loc["loc_id"] ;?> ,longictn<?php echo $loc["loc_id"]; ?>);
			var coorsFieldMarkerCOM<?php echo $loc["loc_id"]; ?>=new GMarker(centerPointn<?php echo $loc["loc_id"] ?>); 

			GEvent.addListener(coorsFieldMarkerCOM<?php echo $loc["loc_id"]; ?>, 'click',function() 
			{	
				coorsFieldMarkerCOM<?php echo $loc["loc_id"] ;?>.openInfoWindowHtml("<a href='<?php echo Yii::app()->request->baseUrl; ?>/index.php/location/onelocation/id/<?php echo $loc["loc_id"] ;?>/val/1m'><?php echo $lat_lng_data[0]["name"];  ?></a>");
			}
		);

		map.addOverlay(coorsFieldMarkerCOM<?php echo $loc["loc_id"]; ?>);
		
		<?php } ?>	
	}
	
}
	
window.onload = initialize;
window.onunload = GUnload;

</script>

<h5><?php echo getContent('user.location.map',Yii::app()->session['language']); ?></h5>

<div class="clear"></div>
<div class="clearfix"></div>            

<div class="container container-top">
	<div class="row-fluid">
		<div id="map" style="height:400px"></div>
	</div>
</div>