<?php

$AllGroups = $model_group->AllGroups();
                  
if(count($AllGroups)) 
{ 

?>
                      
<table class="table table-striped"> 
<thead> 
<tr> 
	<th>
    	<strong>
			<?php echo getContent('user.location.listgroup.column1',Yii::app()->session['language']); ?>
		</strong>
	</th> 
    <th>
    	<strong>
			<?php echo getContent('user.location.listgroup.column2',Yii::app()->session['language']); ?>
		</strong>
	</th> 
    <th>
    	<strong>
			<?php echo getContent('user.location.listgroup.column3',Yii::app()->session['language']); ?>
		</strong>
	</th> 
    <th>
    	<strong>
			<?php echo getContent('user.location.listgroup.column4',Yii::app()->session['language']); ?>
		</strong>
	</th> 
    <th>
    	<strong>
			<?php echo getContent('user.location.listgroup.column5',Yii::app()->session['language']); ?>
		</strong>
	</th>
</tr> 
</thead> 
<tbody> 

<?php 
                          
$h=1;

foreach($AllGroups as $all_group)
{
	$orig_loc = '';
                              
    if(!empty($all_group['locations']))
    {
    	$temp_loc = explode(',',$all_group['locations']);
                                  
		$total_location_show = count($temp_loc);
								  
        foreach($temp_loc as $key=>$value)
        {
			if($value)
			{
				$value = str_replace('loc_','',$value);
				$value = str_replace('fb_','',$value);
				
            	$find_loc = LocationGroup::model()->GetSpecLocation($value);
                $orig_loc .= $find_loc[0]['name'].', ';
			}
		}
	}
	else
		$total_location_show = 0;
                              
	$orig_pages = '';
                              
    if(!empty($all_group['fbpages']))
    {
    	$temp_pages = explode(',',$all_group['fbpages']);                      
		$total_fbpages_show = count($temp_pages);
								  
        foreach($temp_pages as $key=>$value)
        {
			if($value)
			{
            	$find_pages = LocationGroup::model()->GetSpecPage($value);
                $orig_pages .= $find_pages[0]['page_name'].', ';
			}
		}
	}
	else
		$total_fbpages_show = 0;
	
	?>
    <tr> 
    	<td><?php echo $h; ?></td> 
        <td><?php echo ucfirst($all_group['name']);?></td> 
        <td>There are <?php echo $total_location_show; //echo substr($orig_loc,0,-2);?> venues in this group </td> 
        <td>There are <?php echo $total_fbpages_show; //echo substr($orig_pages,0,-2);?> fb pages in this group</td> 
        <td>
        	<a class="icon-button edit" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/location/location/view/EditGroups/group_id/<?=$all_group['group_id'];?>" title="Edit Group"><i class="icon-edit"></i></a>
            <a class="icon-button delete" href="javascript:confirmSubmit('<?php echo Yii::app()->request->baseUrl; ?>/index.php/location/location/view/Groups/group_id/<?=$all_group['group_id'];?>/act/del');" title="Delete Group"><i class="icon-trash"></i></a>
		</td>
	</tr>
    <?php 
    
	$h++;
                          
    } 
    ?>
	</tbody> 
    </table>                  
<?php
} 
?>