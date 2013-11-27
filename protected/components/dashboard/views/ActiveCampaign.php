<?php 			

$ActiveCampaign = Campaign::model()->GetLatestActiveCampaigns();
									
if (count($ActiveCampaign)) 
{ 
					
?>				
<table class="table table-striped"> 
<thead> 
<tr> 
	<th><strong><?php echo getContent('user.dashboard.latestcampaign.column1',Yii::app()->session['language']); ?></strong></th> 
	<th><strong><?php echo getContent('user.dashboard.latestcampaign.column2',Yii::app()->session['language']); ?></strong></th> 
	<th><strong><?php echo getContent('user.dashboard.latestcampaign.column3',Yii::app()->session['language']); ?></strong></th> 
	<th><strong><?php echo getContent('user.dashboard.latestcampaign.column4',Yii::app()->session['language']); ?></strong></th> 
	<th><strong><?php echo getContent('user.dashboard.latestcampaign.column5',Yii::app()->session['language']); ?></strong></th> 
	<th><strong><?php echo getContent('user.dashboard.latestcampaign.column6',Yii::app()->session['language']); ?></strong></th> 
</tr> 
</thead> 
<tbody> 			
<?php 		
						
$s=1; 

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
										
	if(!empty($value['group_ids']))
	{
		$temp_groups = explode(',',$value['group_ids']);
	
		if(count($temp_groups))
		{
			foreach($temp_groups as $keys=>$values)
			{
				$pages_name = '';
													
				if(!empty($values))
				{
					$get_pages = Campaign::model()->GetGroupPages($values);
					$pages_name .= $get_pages[0]['name'].',';
				}
			}
		}
											
		$pages_name = substr($pages_name,0,-1);
											
	}
	else if(!empty($value['page_id']))
	{
		$PageInfo = Campaign::model()->GetPageInfo($value['page_id']);
		$pages_name = $PageInfo[0]['page_name'];
	}
	
	?>
	
<tr> 
    <td><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/campaign/view/see/id/<?php echo $value['campaign_id'] ?>"><?php echo $value['name']; ?></a></td> 
    <td align="center"><?php echo date('m/d/Y',$value['start_date']); ?> - <?php echo date('m/d/Y',$value['end_date']); ?></td> 
    <td align="center"><?php echo $value['kpi']; ?></td> 
    <td align="center"><?php echo $pages_name; ?></td> 
    <td align="center">-</td> 
    <td align="center"><?php echo $likes; ?></td>
</tr>
	
<?php 
	
	$s++; 
} 

?>

</tbody> 
</table>
							
<?php 

} 
else 
{ 
?>

<div class="alert alert-info">
	<center>
    	<?php echo getContent('user.dashboard.nocampaign',Yii::app()->session['language']); ?>
	</center>
</div>
									
<?php 

} 

?>