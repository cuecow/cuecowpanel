<div class="container container-top">
	<div class="row-fluid">
	
	<?php
			
	$record = $model->GetAllRec(); 
			
	if(count($record))
	{
	
	?>
			
		<table class="table table-striped">
		<thead> 
		<tr> 
			<th><strong>S. No</strong></th> 
			<th><strong>Name</strong></th> 
			<th><strong>Price</strong></th>
			<th><strong>User Limit</strong></th>
			<th><strong>Venue Limit</strong></th>
			<th><strong>Campaign Limit</strong></th>
            <th><strong>App Limit</strong></th>
            <th><strong>Wall Limit</strong></th>
            <th><strong>Action</strong></th>
		</tr> 
		</thead> 
		<tbody>
					
		<?php 
				
		$h=1;
				
		foreach($record as $rec)
		{
				
		?>
		<tr> 
			<td align="center"><?php echo $h; ?></td> 
			<td><?php echo ucfirst($rec['name']);?> <?php echo '- '.$rec['description']; ?></td> 
			<td align="center"><?php echo $rec['price'];?></td> 
			<td align="center"><?php echo $rec['max_num_users'];?></td> 
			<td align="center"><?php echo $rec['max_num_venues'];?></td> 
            <td align="center"><?php echo $rec['max_num_campaigns'];?></td> 
            <td align="center"><?php echo $rec['max_num_apps'];?></td> 
            <td align="center"><?php echo $rec['max_num_walls'];?></td> 
			<td align="center">
				<a class="icon-button edit" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/panel/update/id/<?=$rec['subscription_id'];?>" title="Edit Limits"><i class="icon-edit"></i></a>
			</td>
		</tr>
				
		<?php $h++;
				
		} 
				
		?>
							
		</tbody> 
		</table>					
				
	<?php
			 
	}
	else
	{
	
	?>
		<div class="alert alert-error">
			<strong>No Record added yet</strong>
        </div>
	
	<?php
	
	}	
	
	?>
	</div>
</div>