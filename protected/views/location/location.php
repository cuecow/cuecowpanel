
<?php 

if(!empty($_REQUEST['dataof']))
	$date_duration_allurl = strtotime(now)-($_REQUEST['dataof']*24*60*60);
else
	$date_duration_allurl = 0;
										
$all_locations = $model->getallurl($date_duration_allurl);

$h = 1;

foreach($all_locations as $loc1)
{
	if(!empty($loc1['fburl']))
	{
		$fbdata	= $model->GetFbLikes($loc1['loc_id']);
		$s = $fbdata[0]['latitude'].",".$fbdata[0]['lognitude']."*";
	}
	else if(!empty($loc1['fsurl']))
	{
		$fsdata = $model->GetFSData($loc1['loc_id']);
		$s = $fsdata[0]['latitude'].",".$fsdata[0]['lognitude']."*";
	}
	else if(!empty($loc1['googleurl']))
	{
		$gdata  = $model->GetGoogData($loc1['loc_id']);
		$s = $gdata[0]['latitude'].",".$gdata[0]['lognitude']."*";
	}
							
	$a = $a.$s;
	$var = substr($a,0,-1);	
	
	$h++;
}

?>

<script>
function confirmSubmit(url)
{
	var agree=confirm("Are you sure you wish to continue?");
	
	if (agree)
	{
		window.location.href=url;
		return true ;
	}
	else
		return false ;
}
</script>

<div class="container container-top">

	<div class="row-fluid">
	
    	<?php if($_REQUEST['view']=='List' || $_REQUEST['view']==''){ ?>
		
        	<?php include('LocationList.php'); ?>
							
		<?php } ?>
        
        <?php if($_REQUEST['view']=='Map'){ ?>
		
        	<?php include('LocationMap.php'); ?>
					
		<?php } ?>
            
        <?php if($_REQUEST['view']=='Add'){ ?>
        
        	<?php include('AddLocation.php'); ?>
        
        <?php } ?>
        
        <?php 
		
		if($_REQUEST['view']=='Groups' || $_REQUEST['view']=='AddGroups' || $_REQUEST['view']=='EditGroups')
		{ 
		
		?>
							
        	<script>
						
			$(function() 
			{
				$(".low input[type='button']").click(function()
				{  
					var arr = $(this).attr("name").split("2");
					var from = arr[0];  
					var to = arr[1];  
					$("#" + from + " option:selected").each(function()
					{  
						$("#" + to).append($(this).clone().attr('selected',true));
						$(this).remove();
					});
				});
			})
			
			function SelectAllOpt()
			{
				var arr = new Array;
				
				$("#right option").each  ( function() 
				{
				   $(this).attr('selected',true);
				});
			}
			
			</script>
                      
						    
		<?php if($_REQUEST['view']=='AddGroups' || $_REQUEST['view']=='EditGroups') { ?>
                  
			<?php include('AddEditGroups.php'); ?>
                      
		<?php } ?>
                  
		<?php if($_REQUEST['view']=='Groups') {?>
        
        	<?php include('LocationGroups.php'); ?>
                      
		<?php } ?>
                      
		</div>
								
		<?php
		
		} 
		
		?>
        
	</div>
    
</div>
                