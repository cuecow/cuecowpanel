<div style="float:right; margin-bottom:20px;">
	<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/fbposts"><input type="button" class="btn btn-large" value="<?php echo PageTitles::model()->SinglePageTitle('/user/fbposts',''); ?>" /></a>
</div>

<?php 			
				
$rs_post=Fbposts::model()->allpost();
					
if(count($rs_post)) 
{	 
							
?>
	<table class="table table-striped">
	<thead>
	<tr> 
		<th width="303"><strong>Name</strong></th> 
		<th width="197"><strong>Post to</strong></th> 
		<th width="53"><strong>Content</strong></th> 
		<th width="42"><strong>Status</strong></th> 
		<th width="55"><strong>Action</strong></th> 
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
	<td><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/viewfbposts/<?=$value['post_id'];?>"><?=$value['name'];?></a></td> 
	<td><?php echo $name_to_show; ?></td>
	<td align="center"><?=ucwords($value['content_type']);?></td> 
	<td align="center">
		<?=ucfirst($value['status']);?>
		<?php if($value['status']=='pending') echo '('.$value['post_date'].' at '.$value['post_time'].')'; ?>
	</td>
	<td align="center">
		
		<a class="icon-button delete" href="javascript:confirmSubmit('<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/delpost/<?php echo $value['post_id'];?>');" title="Delete Post"><i class="icon-trash"></i></a>
		
		<?php if($value['status']=='pending') { ?>
			<a class="icon-button edit" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/fbposts/view/edit/id/<?php echo $value['post_id'];?>" title="Edit Post"><i class="icon-edit"></i></a>
		<?php } else { ?>
			&nbsp;
		<?php } ?>
	
	</td>
</tr>
							
<?php 
										
$i++; 
$value = '';	

} 			

?>
                                                
</tbody> 
</table>
                                                
<? } else {?>
	
<div class="alert alert-error">
    No Posts added yet. Add a new one by clicking "Add new Post" link above.
</div>
						
<? } ?>