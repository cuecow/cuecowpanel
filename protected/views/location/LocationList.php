<h5><?php echo getContent('user.location.overview',Yii::app()->session['language']); ?></h5>

<div class="clear"></div>
<div class="clearfix"></div>            

<?php 
                    
if(!empty($_REQUEST['dataof']))
	$date_duration = strtotime(now)-($_REQUEST['dataof']*24*60*60);
else
	$date_duration = strtotime(now)-(7*24*60*60);
                    
if(count($all_locations)) 
{	

?>

<table class="table table-striped"> 
<tbody> 
<tr> 
    <td align="left" style="border:none;">
        <select class="pagesize" name="location" style="width:500px;" onchange="window.location.href='<?php echo Yii::app()->request->baseUrl; ?>/index.php/location/location/loc_id/'+this.value+'/dataof/<?php echo $_REQUEST['dataof']; ?>'">
        <?php
        
        foreach($all_locations as $key=>$values)
        { 
        
        ?>
            <option value="<?php echo $values['loc_id']; ?>" <?php if($_REQUEST['loc_id']==$values['loc_id']) echo 'selected'; ?>>
                <?php echo ucfirst($values['name']); ?>
            </option>
        <? 
        
        } 
        
        ?>
            <option value="0" <?php if($_REQUEST['loc_id']==0 || empty($_REQUEST['loc_id'])) echo 'selected'; ?>>All Venues</option>
        
        </select>
    </td> 
    
    <td width="25%" align="left" style="border:none;">
		<!--<?php echo getContent('user.location.list.daterange',Yii::app()->session['language']); ?> &nbsp;&nbsp;&nbsp;
        <select class="pagesize" name="date_range" style="width:160px;" onchange="window.location.href='<?php echo Yii::app()->request->baseUrl; ?>/index.php/location/location/loc_id/<?php echo $_REQUEST['loc_id']; ?>/dataof/'+this.value">
            <option selected="selected" value="">All Times</option>
            <option value="7" <?php if($_REQUEST['dataof']==7) echo 'selected'; ?>>Last 7 days</option>
            <option value="14" <?php if($_REQUEST['dataof']==14) echo 'selected'; ?>>Last 14 days</option>
            <option value="30" <?php if($_REQUEST['dataof']==30) echo 'selected'; ?>>Last 1 Month</option>
            <option value="90" <?php if($_REQUEST['dataof']==90) echo 'selected'; ?>>Last 3 Months</option>
            <option value="180" <?php if($_REQUEST['dataof']==180) echo 'selected'; ?>>Last 6 Months</option>
            <option value="365" <?php if($_REQUEST['dataof']==365) echo 'selected'; ?>>Last 1 Year</option>
            <option value="1095" <?php if($_REQUEST['dataof']==1095) echo 'selected'; ?>>Last 3 Years</option>
            <option value="2190" <?php if($_REQUEST['dataof']==2190) echo 'selected'; ?>>Last 6 Years</option>
        </select>-->
    </td> 
</tr>
</tbody> 
</table>
	
<div class="clear"></div>
<div class="clearfix"></div>

<?php
                    
if($_REQUEST['loc_id']==0 || empty($_REQUEST['loc_id']))
	$allurl=$model->getallurl($date_duration_allurl);
else
	$allurl=$model->GetSpecificUrl($_REQUEST['loc_id']);
                    
$g=1;
					
$temp_array = array();
					
foreach($allurl as $fbs)
{	
	if(!empty($fbs['fburl']))
    	$fbdata	= $model->GetFbLikes($fbs['loc_id'],$date_duration);
	else
		$fbdata = array();
							
	if(!empty($fbs['fsurl']))
    	$fsdata = $model->GetFSData($fbs['loc_id'],$date_duration);
	else
		$fsdata = array();
							
	if(!empty($fbs['googleurl']))
    	$gdata  = $model->GetGoogData($fbs['loc_id'],$date_duration);
	else
		$gdata = array();
							
	$tot_checkins = $fbdata[0]['checkins'] + $fsdata[0]['checkinsCount'];
						
	$temp_array[$fbs['loc_id']] = $tot_checkins;

}
					
arsort($temp_array);
					
?>

<table class="table table-striped"> 
<thead> 
<tr> 
	<th style="width:50px;">
    	<strong><?php echo getContent('user.location.list.column1',Yii::app()->session['language']); ?></strong>
	</th> 
    <th width="250px;">
    	<strong><?php echo getContent('user.location.list.column2',Yii::app()->session['language']); ?></strong>
	</th> 
    <th>
    	<strong><?php echo getContent('user.location.list.column3',Yii::app()->session['language']); ?></strong>
	</th> 
    <th>
    	<strong><?php echo getContent('user.location.list.column4',Yii::app()->session['language']); ?></strong>
	</th> 
    <th>
    	<strong><?php echo getContent('user.location.list.column5',Yii::app()->session['language']); ?></strong>
	</th> 
    <th>
    	<strong><?php echo getContent('user.location.list.column6',Yii::app()->session['language']); ?></strong>
	</th> 
    <th>
    	<strong><?php echo getContent('user.location.list.column7',Yii::app()->session['language']); ?></strong>
	</th>
    <th>
    	<strong><?php echo getContent('user.location.list.column8',Yii::app()->session['language']); ?></strong>
	</th>  
</tr> 
</thead> 
<tbody> 
                    
<?php 


foreach($temp_array as $key=>$value)
{	
	$fbs = $model->GetSpecificUrl($key);

    if(!empty($key))
    	$fbdata	= $model->GetFbLikes($key,$date_duration);
	else
		$fbdata = array();
	
	if(!empty($key))
    	$fsdata = $model->GetFSData($key,$date_duration);
	else
		$fsdata = array();
        
	if(!empty($key))
    	$gdata  = $model->GetGoogData($key,$date_duration);
	else
		$gdata = array();

?>
<tr> 
	<td><?php echo $g; ?></td> 
    <td>
    	<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/location/onelocation/id/<?=$fbs[0]['loc_id'];?>/val/1m"><?php echo ucfirst($fbs[0]['name']);?></a>
	</td> 
    <td><?php echo $value;?></td> 
    <td>
		<?php if($fbdata[0]['likes']>0) echo $fbdata[0]['likes']; else echo 0;?>
	</td> 
    <td><?php if(!empty($fbs[0]['googleurl'])) echo $gdata[0]['glikes']; else echo 'N/A'; ?></td> 
    <td>
    
	<?php
                        
    	$fbicon = (!empty($fbs[0]['fburl'])) ? 'facebook_icon.png' : 'facebook_icon.jpg';
        $fsicon = (!empty($fbs[0]['fsurl'])) ? 'foursquare-icon.png' : 'foursquare-icon.jpg';
        $gicon  = (!empty($fbs[0]['googleurl'])) ? 'google.jpg' : 'googlegray.jpg';
                            
	?>
    	<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/<?php echo $fbicon; ?>" />&nbsp;&nbsp;
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/<?php echo $gicon; ?>" />&nbsp;&nbsp;
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/<?php echo $fsicon; ?>" />
                            
	</td> 
                        
    <td>
    
	<?php
                        
    $camp = Location::model()->GetActiveCampaign($fbs[0]['loc_id']);
                        
    if(count($camp))
    {
    	$camp_fb = ($camp[0]['facebook_deals']=='yes' || $camp[0]['fb_posts']=='yes' || $camp[0]['fb_ads']=='yes') ? 'facebook_icon.png' : 'facebook_icon.jpg';'facebook_icon.png';	
        
		$camp_google = ($camp[0]['google_place']=='yes' || $camp[0]['google_adwords']=='yes') ? 'google.jpg' : 'googlegray.jpg';
        
		$camp_fscamp = ($camp[0]['foursquare_specials']=='yes') ? 'foursquare-icon.png' : 'foursquare-icon.jpg';
	
	}
    else
    {
    	$camp_fb = 'facebook_icon.jpg';	
        $camp_google = 'googlegray.jpg';
        $camp_fscamp = 'foursquare-icon.jpg';
	}
                        
    ?>
    
    	<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/<?php echo $camp_fb; ?>" />&nbsp;&nbsp;
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/<?php echo $camp_google; ?>" />&nbsp;&nbsp;
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/<?php echo $camp_fscamp; ?>" />
                            
	</td>
                        
    <td>
                            
    	<a class="icon-button edit" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/location/editlocation/id/<?=$fbs[0]['loc_id'];?>" title="Edit Page"><i class="icon-edit"></i></a>
        
        <a class="icon-button delete" href="javascript:confirmSubmit('<?php echo Yii::app()->request->baseUrl; ?>/index.php/location/deletelocation/id/<?php echo $fbs[0]['loc_id']; ?>');" title="Delete Page"><i class="icon-trash"></i></a>
                        
	</td>
                            
</tr>
                    
<?php 
                    
	$g++;					
} 

?>
                    
</tbody> 
</table>
                    
<?php if(count($allurl)>40) { ?>	
                                                    
<div id="table-pager-1" class="pager" style="padding-bottom:150px;">
	<div class="table-options">&nbsp;</div>
        <form>
            
            <select class="pagesize">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option selected="selected" value="40">40</option>
            </select>
            
            <a class="button small green first"><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/table_pager_first.png" alt="First" /></a>
            <a class="button small green prev"><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/table_pager_previous.png" alt="Previous" /></a>
            <input type="text" class="pagedisplay" disabled="disabled" />
            <a class="button small green next"><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/table_pager_next.png" alt="Next" /></a>
            <a class="button small green last"><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/table_pager_last.png" alt="Last" /></a>
        </form>
    </div>
	
	<?php 
	
		} 
	} 
	else 
	{ 
	
	?>
                			
    	<div class="alert alert-info">
        	<?php echo getContent('user.location.list.novenue',Yii::app()->session['language']); ?>
		</div>
                    
	<?php } ?>
                
</div>