<table class="table table-striped"> 

<?php 			
						
$rs_post=Fbposts::model()->latest_five_posts();
						
if(count($rs_post)) 
{	 
									
?>
<thead> 
<tr> 
	<th>
       	<strong>
		<?php echo getContent('user.dashboard.latestfbpost.column1',Yii::app()->session['language']); ?>
        </strong>
	</th> 
	<th>
      	<strong>
		<?php echo getContent('user.dashboard.latestfbpost.column2',Yii::app()->session['language']); ?>
        </strong>
	</th> 
	<th>
       	<strong>
		<?php echo getContent('user.dashboard.latestfbpost.column3',Yii::app()->session['language']); ?>
        </strong>
	</th> 
	<th>
    	<strong>
		<?php echo getContent('user.dashboard.latestfbpost.column4',Yii::app()->session['language']); ?>
        </strong>
	</th> 
	<th>
    	<strong>
		<?php echo getContent('user.dashboard.latestfbpost.column5',Yii::app()->session['language']); ?>
        </strong>
	</th> 
</tr> 
</thead> 
<tbody> 

<?php 
						
$i=1;
							
foreach($rs_post as $key=>$value)
{ 
	if($value['page_id']!=0)
	{
		$name = Fbposts::model()->GetPage($value['page_id']);
		$name_to_show = $name[0]['page_name'];
	}
	else if($value['group_id']!=0)
	{
		$group = Fbposts::model()->GetLoc($value['group_id']);
									
		if(count($group))
		{
			$name_to_show = '';
			
			foreach($group as $ke=>$va)
			{
				$fburl_info = Fbposts::model()->GetFbInfo($va['loc_id']);
				$name_to_show .= ucfirst($fburl_info[0]['name']).', ';
			}
		}
									
		$name_to_show = substr($name_to_show,0,strlen($name_to_show)-2);
	}
	else
		$name_to_show = '';
								
?>
                        
<tr> 
	<td align="center"><?php echo $i; ?></td> 
	<td>
       	<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/viewfbposts/<?=$value['post_id'];?>"><?=$value['name'];?></a>
    </td> 
	<td><?php echo $name_to_show; ?></td>
	<td align="center"><?=ucwords($value['content_type']);?></td> 
	<td align="center"><?=$value['status'];?></td>
</tr>

<?php 
		
	$i++; 
	$value = '';
} 
		
?>

</tbody> 
							
<?php

} 
else 
{
?>
	<div class="alert alert-info">
    	<center><?php echo getContent('user.dashboard.nofbpost',Yii::app()->session['language']); ?></center>
    </div>
							
<? } ?>

</table>