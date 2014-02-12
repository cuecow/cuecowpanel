<h5><?php echo getContent('user.campaign.overview',Yii::app()->session['language']); ?><div style="float:right;" class="compgn-btn"><a href="<?php echo Yii::app()->request->baseUrl?>/index.php/user/newcampaign" class="button large green"><button class="btn btn-info btn-large" type="button"><?php echo getContent('user.campaign.startcamp',Yii::app()->session['language']); ?></button></a></div></h5>
            	
<?php if($_REQUEST['msg'] == 'maxerr') { ?>
<div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <?php echo getContent('user.campaign.maxcampaign',Yii::app()->session['language']); ?>
</div>
                            
<?php } ?>

<?php
				
$ActiveCampaign = $model->GetActiveCampaigns();
$FutureCampaign = $model->GetPlanedCampaigns();
$PastCampaign 	= $model->GetArchivedCampaigns();
							
?>
						
<ul class="nav nav-tabs" id="myTab">
    
    <li class="active"><a href="#tab1" data-toggle="tab"><?php echo getContent('user.campaign.activecampaign',Yii::app()->session['language']); ?> (<?php echo count($ActiveCampaign) ?>)</a></li>
    
    <li><a href="#tab2" data-toggle="tab"><?php echo getContent('user.campaign.plannedcampaign',Yii::app()->session['language']); ?> (<?php echo count($FutureCampaign) ?>)</a></li>
    
    <li><a href="#tab3" data-toggle="tab"><?php echo getContent('user.campaign.archivedcampaigns',Yii::app()->session['language']); ?> (<?php echo count($PastCampaign) ?>)</a></li>
    
</ul>
					
<!-- The tabbed content area -->
<div class="tab-content">

	<!-- TAB ONE -->
    <div class="tab-pane active" id="tab1">
                    
    <?php if (count($ActiveCampaign)) { ?>
                    
    <div class="table table-striped checkdiv table-cmpn-one"> 
	<div class="row-fluid tab1-cmapign-listing"> 
		<div class="span1 cell01">
        	<strong><?php echo getContent('user.campaign.sn',Yii::app()->session['language']); ?></strong>
        </div>
        <div class="span1 cell02">
        	<strong><?php echo getContent('user.campaign.location',Yii::app()->session['language']); ?></strong>
        </div> 
        <div class="span2 cell03">
        	<strong><?php echo getContent('user.campaign.sdateenddate',Yii::app()->session['language']); ?></strong>
        </div> 
        <div class="span2 cell04">
        	<strong><?php echo getContent('user.campaign.kpi',Yii::app()->session['language']); ?></strong>
        </div> 
        <div class="span1 cell05">
        	<strong><?php echo getContent('user.campaign.timezone',Yii::app()->session['language']); ?></strong>
        </div> 
        <div class="span2 cell06">
        	<strong><?php echo getContent('user.campaign.selsocialchannel',Yii::app()->session['language']); ?></strong>
        </div>
        <div class="span2 cell07"><strong><?php echo getContent('user.campaign.options',Yii::app()->session['language']); ?></strong></div>
        <div class="span1"><strong>Media Status</strong></div>
    </div> 
        </div>
        
	<?php 
                    
    $s=1; 
    $flag=0;
	foreach($ActiveCampaign as $key=>$value)
    { 
    	if(!empty($value['fb_posts']))
        {
        	$fbinfo = Campaign::model()->GetPosts($value['campaign_id']);
            
			if(count($fbinfo))
			{
            	$data = @file_get_contents('https://graph.facebook.com/'.$fbinfo[0]['posted_id']);		
                $record = json_decode($data);
                $likes = (count($record->likes->data)) ? count($record->likes->data):0 ;
			}
		}
                    
		$selected_channels = array();
            
		if($value['facebook_deals']=='yes')
			array_push($selected_channels,'Facebook Deals');
		if($value['foursquare_specials']=='yes')
		{
			$fs_special_detail = Campaign::model()->GetFSSpecial($value['campaign_id']);
			array_push($selected_channels,'Foursquare Specials');
		}
		if($value['google_place']=='yes')
			array_push($selected_channels,'Google Place');
		if($value['fb_posts']=='yes')
		{
			$fb_post_detail = Cron::model()->CronGetFBCampaignPost($value['campaign_id']);
			array_push($selected_channels,'Facebook Posts');
		}
		if($value['twitter']=='yes')
			array_push($selected_channels,'Twitter');
		if($value['fb_ads']=='yes')
			array_push($selected_channels,'Facebook Ads');
		if($value['google_adwords']=='yes')
			array_push($selected_channels,'Google Ads');
                            
		$channels = implode(',',$selected_channels);
		
		if($value['timezone']>0)
		{
			$timezone = Campaign::model()->SpecZone($value['timezone']);
			$timezone_set = $timezone[0]['name'];
		}
		else
			$timezone_set = '--';
                            
                    
	?>
            <?php
            
                if($flag%2 == 0){ ?>
            
                    <div class="row-fluid bg-clr-gray" style="border-bottom:1px solid #ccc; padding: 10px 0;">
              <?php  }
              else{ ?>
                  <div class="row-fluid" style="border-bottom:1px solid #ccc; padding: 10px 0;">
              <?php }
?>
	
	<div class="span1"><?php echo $s; ?></div>
        <div class="span2"><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/campaign/view/see/id/<?php echo $value['campaign_id']; ?>"><?php echo $value['name']; ?></a></div> 
        <div class="span2"><?php echo date('m/d/Y',$value['start_date']); ?> <?php if($value['start_time']) echo '@ '.$value['start_time']; ?> - <?php echo date('m/d/Y',$value['end_date']); ?> <?php if($value['end_time']) echo '@ '.$value['end_time']; ?></div> 
        <div class="span1"><?php echo $value['kpi']; ?></div> 
        <div class="span2"><?php echo $timezone_set; ?></div> 
        <div class="span3"><?php echo $channels; ?></div>
        <div class="span1">                    
            <a class="icon-button edit" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/newcampaign/camp/<?php echo $value['campaign_id']; ?>" title="Edit Campaign"><i class="icon-edit"></i></a>
            <a class="icon-button delete" href="javascript:confirmSubmit('<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/campaign/id/<?php echo $value['campaign_id']; ?>/act/del');" title="Delete Campaign"><i class="icon-trash"></i></a>
		</div>
        <div class="span1">
            <?php if( $value['foursquare_specials']=='yes' ) { if($fs_special_detail['current_status'] == 'running') { ?>
            	<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/foursquare.png" title="running media" />
			<?php } else { ?>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/foursquare_gray.png" title="retired media" />
            <?php } } ?>
            
            <?php if( $value['fb_posts']=='yes' ) { if($fb_post_detail['current_status'] == 'running') { ?>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/facebook.png" title="running media" />
            <?php } else { ?>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/facebook_gray.png" title="retired media" />
            <?php } } ?>
            
		</div>
	</div>
	
	<?php 
                    
    	$s++; 
        $flag++;
	} 
                    
    ?>
                    
	</tbody> 
    </div>
                    
    <?php } else { ?>
            
		<div class="alert alert-error">
			<?php echo getContent('user.campaign.noactivecampaign',Yii::app()->session['language']); ?>
        </div>
            
    <?php } ?>
                
	
 </div>
        
	<!-- TAB TWO -->
    <div class="tab-pane" id="tab2">
                    
		<?php if (count($FutureCampaign)) { ?>
                    
		<div class="table table-striped checkdiv">
                    <div class="row-fluid tab1-cmapign-listing">
            <div class="span1 cell01"><strong><?php echo getContent('user.campaign.sn',Yii::app()->session['language']); ?></strong></div>
            <div class="span2 cell02"><strong><?php echo getContent('user.campaign.location',Yii::app()->session['language']); ?></strong></div> 
            <div class="span2 cell03"><strong><?php echo getContent('user.campaign.sdateenddate',Yii::app()->session['language']); ?></strong></div>
            <div class="span1 cell04"><strong><?php echo getContent('user.campaign.kpi',Yii::app()->session['language']); ?></strong></div>
            <div class="span2 cell05"><strong><?php echo getContent('user.campaign.timezone',Yii::app()->session['language']); ?></strong></div>
            <div class="span3 cell06"><strong><?php echo getContent('user.campaign.selsocialchannel',Yii::app()->session['language']); ?></strong></div>
            <div class="span1 cell07"><strong><?php echo getContent('user.campaign.options',Yii::app()->session['language']); ?></strong></div>
                    </div>   
		<?php 
        
		$value = '';
		$s = 1; 
                $flag = 0;
		
		foreach($FutureCampaign as $key=>$value)
        { 
        	if(!empty($value['fb_posts']))
			{
				$fbinfo = Campaign::model()->GetPosts($value['campaign_id']);
				if(count($fbinfo))
				{
					$data = @file_get_contents('https://graph.facebook.com/'.$fbinfo[0]['posted_id']);		
					$record = json_decode($data);
					$likes = (count($record->likes->data)) ? count($record->likes->data):0 ;
				}
			}
                        
			$selected_channels = array();
			
			if($value['facebook_deals']=='yes')
				array_push($selected_channels,'Facebook Deals');
			if($value['foursquare_specials']=='yes')
				array_push($selected_channels,'Foursquare Specials');
			if($value['google_place']=='yes')
				array_push($selected_channels,'Google Place');
			if($value['fb_posts']=='yes')
				array_push($selected_channels,'Facebook Posts');
			if($value['twitter']=='yes')
				array_push($selected_channels,'Twitter');
			if($value['fb_ads']=='yes')
				array_push($selected_channels,'Facebook Ads');
			if($value['google_adwords']=='yes')
				array_push($selected_channels,'Google Ads');
				
			$channels = implode(',',$selected_channels);
                        
			if($value['timezone']>0)
			{
				$timezone = Campaign::model()->SpecZone($value['timezone']);
				$timezone_set = $timezone[0]['name'];
			}
			else
				$timezone_set = '--';
		
		?>
                    <?php
            
                if($flag%2 == 0){ ?>
            
                    <div class="row-fluid bg-clr-gray tab1-cmapign-listing">
              <?php  }
              else{ ?>
                  <div class="row-fluid tab1-cmapign-listing">
              <?php }
?>

            <div class="span1"><?php echo $s; ?></div> 
            <div class="span2"><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/campaign/view/see/id/<?php echo $value['campaign_id']; ?>"><?php echo $value['name']; ?></a></div> 
            <div class="span2"><?php echo date('m/d/Y',$value['start_date']); ?> <?php if($value['start_time']) echo '@ '.$value['start_time']; ?> - <?php echo date('m/d/Y',$value['end_date']); ?> <?php if($value['end_time']) echo '@ '.$value['end_time']; ?> </div> 
            <div class="span1"><?php echo $value['kpi']; ?></div> 
            <div class="span2"><?php echo $timezone_set; ?></div>
            <div class="span3"><?php echo $channels; ?></div>
            <div class="span1">                    
            	<a class="icon-button edit" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/newcampaign/camp/<?php echo $value['campaign_id']; ?>" title="Edit Campaign"><i class="icon-edit"></i></a>
                <a class="icon-button delete" href="javascript:confirmSubmit('<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/campaign/id/<?php echo $value['campaign_id']; ?>/act/del');" title="Delete Campaign"><i class="icon-trash"></i></a>
			</div>
		</div>
        
		<?php 
                    
        	$s++;
                $flag++;
                    
		} 
                    
        ?>
         
		</div>
            
	<?php } else { ?>
        
        <div class="alert alert-error">
			<?php echo getContent('user.campaign.noplannedcampaign',Yii::app()->session['language']); ?>
        </div>
                
	<?php } ?>
                
	</div>
        
                
	<!-- TAB THREE -->
    <div class="tab-pane" id="tab3">
                    
		<?php if (count($PastCampaign)) { ?>
        
        <div class="table table-striped checkdiv">
            <div class="row-fluid tab1-cmapign-listing">
            <div class="span1 cell01"><strong><?php echo getContent('user.campaign.sn',Yii::app()->session['language']); ?></strong></div>
            <div class="span2 cell02"><strong><?php echo getContent('user.campaign.location',Yii::app()->session['language']); ?></strong></div> 
            <div class="span2 cell03"><strong><?php echo getContent('user.campaign.sdateenddate',Yii::app()->session['language']); ?></strong></div> 
            <div class="span1 cell04"><strong><?php echo getContent('user.campaign.kpi',Yii::app()->session['language']); ?></strong></div> 
            <div class="span2 cell05"><strong><?php echo getContent('user.campaign.timezone',Yii::app()->session['language']); ?></strong></div> 
            <div class="span3 cell06"><strong><?php echo getContent('user.campaign.selsocialchannel',Yii::app()->session['language']); ?></strong></div>
            <div class="span1 cell07"><strong><?php echo getContent('user.campaign.options',Yii::app()->session['language']); ?></strong></div>
	    </div>
        
          
		<?php 
          
        $value = '';
        $s = 1; 
        $flag = 0;
          
		foreach($PastCampaign as $key=>$value)
        { 
        	if(!empty($value['fb_posts']))
            {
            	$fbinfo = Campaign::model()->GetPosts($value['campaign_id']);
                
				if(count($fbinfo))
                {
                	$data = @file_get_contents('https://graph.facebook.com/'.$fbinfo[0]['posted_id']);		
                    $record = json_decode($data);
                    $likes = (count($record->likes->data)) ? count($record->likes->data):0 ;
				}
			}
              
			$selected_channels = array();
			
			if($value['facebook_deals']=='yes')
				array_push($selected_channels,'Facebook Deals');
			if($value['foursquare_specials']=='yes')
			{
				$fs_special_detail = Campaign::model()->GetFSSpecial($value['campaign_id']);
				array_push($selected_channels,'Foursquare Specials');
			}
			if($value['google_place']=='yes')
				array_push($selected_channels,'Google Place');
			if($value['fb_posts']=='yes')
			{
				$fb_post_detail = Cron::model()->CronGetFBCampaignPost($value['campaign_id']);
				array_push($selected_channels,'Facebook Posts');
			}
			if($value['twitter']=='yes')
				array_push($selected_channels,'Twitter');
			if($value['fb_ads']=='yes')
				array_push($selected_channels,'Facebook Ads');
			if($value['google_adwords']=='yes')
				array_push($selected_channels,'Google Ads');
				
			$channels = implode(',',$selected_channels);
              
			if($value['timezone']>0)
			{
				$timezone = Campaign::model()->SpecZone($value['timezone']);
				$timezone_set = $timezone[0]['name'];
			}
			else
				$timezone_set = '--';
              
		?>
            <?php
            
                if($flag%2 == 0){ ?>
            
                    <div class="row-fluid bg-clr-gray tab1-cmapign-listing">
              <?php  }
              else{ ?>
                  <div class="row-fluid tab1-cmapign-listing">
              <?php }
?>
            
	    <div class="span1 cell01"><?php echo $s; ?></div> 
            <div class="span2 cell02"><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/campaign/view/see/id/<?php echo $value['campaign_id']; ?>"><?php echo $value['name']; ?></a></div> 
            <div class="span2 cell03"><?php echo date('m/d/Y',$value['start_date']); ?> <?php if($value['start_time']) echo '@ '.$value['start_time']; ?> - <?php echo date('m/d/Y',$value['end_date']); ?> <?php if($value['end_time']) echo '@ '.$value['end_time']; ?></div> 
            <div class="span1 cell04"><?php echo $value['kpi']; ?></div> 
            <div class="span2 cell05"><?php echo $timezone_set; ?></div> 
            <div class="span3 cell06"><?php echo $channels; ?></div>
            <div class="span1 cell07">                    
                <a class="icon-button edit" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/newcampaign/camp/<?php echo $value['campaign_id']; ?>" title="Edit Campaign"><i class="icon-edit"></i></a>
                <a class="icon-button delete" href="javascript:confirmSubmit('<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/campaign/id/<?php echo $value['campaign_id']; ?>/act/del');" title="Delete Campaign"><i class="icon-trash"></i></a>
			</div>
		</div>
              
          <?php 
          $flag++;
          $s++; } ?>
          
          </div>
  
          <?php } else { ?>
          
          	<div class="alert alert-error">
            	<?php echo getContent('user.campaign.noarchivedcampaign',Yii::app()->session['language']); ?>
            </div>
              
          <?php } ?>
          
      </div>
                
</div>

<script>

$('#myTab a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
})

</script>
