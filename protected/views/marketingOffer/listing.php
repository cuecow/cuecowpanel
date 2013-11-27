<div class="container container-top">
	<div class="row-fluid">
		<?php
        if($_REQUEST['view']!='single')
        {
            $record = $model->GetAllRec(); 
        
            if(count($record))
            {
        ?>
        
            <table class="table table-striped">
            <thead> 
            <tr> 
                <th><strong>S. No</strong></th> 
                <th><strong>Account Name</strong></th> 
                <th><strong>Company Name</strong></th>
                <th><strong>Telephone</strong></th>
                <th><strong>Email</strong></th>
                <th><strong>Date Created</strong></th>
                <th><strong>Status</strong></th>
                <th><strong>View Detail</strong></th>
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
                <td align="center"><?php echo $rec['account_name'];?></td> 
                <td align="center"><?php echo $rec['company'];?></td> 
                <td align="center">-</td> 
                <td align="center"><?php echo $rec['user_email'];?></td> 
                <td align="center"><?php echo $rec['dated'];?></td> 
                <td align="center"><?php echo ucfirst($rec['status']);?></td> 
                <td align="center">
                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/campaignOffer/listing/view/single/id/<?=$rec['campaign_offer_id'];?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/details.png" border="0" /></a>
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
            <table id="tablesorter-sample" class="styled" cellpadding="0" cellspacing="1"> 
            <thead> 
            <tr> 
                <th align="center"><strong>No Record added yet</strong></th> 
            </tr> 
            </thead> 
            </table>
        <?php
            }
        }
        else
        {
            $record = $model->GetRecord($_REQUEST['id']); 
            
        ?>
        <table id="tablesorter-sample" class="styled" cellpadding="0" cellspacing="1"> 
        <thead> 
        <tr> 
            <th><strong>GUID</strong></th> 
            <th><strong>Account Name</strong></th> 
            <th><strong>Subscription Type</strong></th>
            <th><strong>Price Offered</strong></th>
            <th><strong>Industry</strong></th>
            <th><strong>Email</strong></th>
            <th><strong>Name</strong></th>
            <th><strong>VAT</strong></th>
            <th><strong>Company</strong></th>
            <th><strong>Address</strong></th>
            <th><strong>City</strong></th>
            <th><strong>Postal Code</strong></th>
            <th><strong>Country</strong></th>
            <th><strong>Status</strong></th>
            <th><strong>Date</strong></th>
        </tr> 
        </thead> 
        <tbody>
        <tr>
            <td><?php echo $record[0]['campaign_offer_guid']; ?></td>
            <td><?php echo $record[0]['account_name']; ?></td>
            <td>
                <?php 
                
                $Subscription = SubsriptionType::model()->GetSpecificRec($record[0]['subscription_type_id']); 
                echo $Subscription[0]['name']; 
                
                ?>
            </td>
            <td><?php echo $record[0]['offered_price']; ?></td>
            <td><?php echo $record[0]['Industry']; ?></td>
            <td><?php echo $record[0]['user_email']; ?></td>
            <td><?php echo $record[0]['user_fname']; ?> <?php echo $record[0]['user_lname']; ?></td>
            <td><?php echo $record[0]['vat_no']; ?></td>
            <td><?php echo $record[0]['company']; ?></td>
            <td><?php echo $record[0]['address']; ?></td>
            <td><?php echo $record[0]['city']; ?></td>
            <td><?php echo $record[0]['postal_code']; ?></td>
            <td><?php echo $record[0]['country']; ?></td>
            <td><?php echo ucfirst($record[0]['status']); ?></td>
            <td><?php if($record[0]['dated']!='') echo $record[0]['dated']; ?></td>
        </tr>
        </tbody>
        </table>
        <?php
        }
        ?>
	</div>
</div>
