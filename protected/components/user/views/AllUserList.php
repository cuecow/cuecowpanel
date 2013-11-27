 <div class="container container-top">
	<div class="row-fluid">
    
		<form name="paid_user_form" method="post" action="">
        	<input type="checkbox" name="paid_user" value="yes" <?php if( $_POST['paid_user'] == 'yes' || $_POST['filter'] == '') { ?> checked="checked" <?php } ?> onclick="this.form.submit();" /> &nbsp; Only showing paying customers <br /><br />
            <input type="hidden" name="filter" value="yes" />
        </form>
        
    	<?php 

		
		
		if( $_POST['paid_user'] == 'yes' || $_POST['filter'] == '')
		{
			$paid_customers = true;
			$AllUsers = $model->GetPaidUsers();
		}
		else
		{
			$paid_customers = false;
			$AllUsers = $model->GetAllUsers();
		}
		
		if(Yii::app()->user->role == 'admin') 
		{ 
			if(count($AllUsers))
			{
		
		?>      
        		
        		<table class="table table-striped table-bordered tablesorter" id="user_list">
				<thead> 
				<tr> 
					<th width="6%">S. No</th> 
					<th style="cursor:pointer;">Name</th> 
					<th style="cursor:pointer;">Email</th>
					<th style="cursor:pointer;" width="8%">Account type</th>
                    <th style="cursor:pointer;">Next payment date</th>
                    <th style="cursor:pointer;">Next payment amount</th>
                    <th style="cursor:pointer;">Latest payment date</th>
                    <th style="cursor:pointer;">Latest payment amount</th>
					<th style="cursor:pointer;">Phone</th>
                    <th style="cursor:pointer;">Status</th>
					<th>Action</th>
				</tr> 
				</thead> 
				<tbody>
					
				<?php 
				
				$h=1;
				
				foreach($AllUsers as $all_user)
				{
					$latestrans = AccountForm::model()->GetLatestTransactionInfo($all_user['user_id']);
					
					if($all_user['subscriptionType'])
						$SubscriptionDetail = SubsriptionType::model()->GetSpecificRecbyName($all_user['subscriptionType']);
						
				?>
                    <tr> 
                        <td align="center"><?php echo $h; ?></td> 
                        <td><?php echo ucfirst($all_user['fname']);?> <?php echo ucfirst($all_user['lname']);?></td> 
                        <td><?php echo $all_user['email'];?></td> 
                        <td><?php echo $all_user['subscriptionType']; ?></td>
                        <td><?php echo $all_user['subscriptionValidTo']; ?></td>
                        <td><?php echo $all_user['next_payment']; ?></td>
                        <!--<td><?php echo $SubscriptionDetail[0]['price']; ?></td>-->
                        <td>
                        <?php 
                            
                            if($latestrans[0]['date'])
                            {
                                $stringA = $latestrans[0]['date'];
                                $stringB = "-";
                                $length = strlen($stringA);
                                $temp1 = substr($stringA, 0, $length-4);
                                $temp2 = substr($stringA, $length-4, $length);
                                $temp3 = substr($stringA, $length-2, $length);
                                echo $temp1.$stringB.substr($temp2,0,-2).'-'.$temp3;
                            }
                            
                        ?>
                        </td>
                        <td><?php echo $latestrans[0]['amount']; ?></td>
                        <td><?php echo $all_user['phone'];?></td> 
                        <td align="center"><?php echo ucfirst($all_user['status']);?></td> 
                        <td align="center">
                            <a class="icon-button edit" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/updateuser/view/Edit/user_id/<?=$all_user['user_id'];?>" title="Edit User"><i class="icon-edit"></i></a>
                            <a class="icon-button delete" href="javascript:SubmitURL('<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/deleteuser/user_id/<?=$all_user['user_id'];?>');" title="Delete User"><i class="icon-trash"></i></a>
                            
                            <a class="icon-button" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/simulateuser/user_id/<?=$all_user['user_id'];?>" title="Simulates a session as if the user is logged in."><i class="icon-user"></i></a>
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
			else
			{
		?>
				<div class="alert alert-info">
                    <center>
                        No Record added yet
                    </center>
                </div>
		<?php
		
			}	
		} 
		
		?>
        
	</div>
</div>

<script>

function SubmitURL(url)
{
	var answer = confirm("Are you sure, you want to delete this user with all his stored data?")
	
	if (answer)
		window.location.href = url;
}

function ChnageCompany()
{
	$('#newcomp').html('<span class="field_title">Company:</span><input type="text" id="User_company" name="User[company]" class="small textbox" />');
}
 
</script>