<script>
 

function OpenPdf(url)
{	
	var isFF = false;
	
	var val = navigator.userAgent.toLowerCase();
	
	if(val.indexOf("firefox") > -1)
		isFF = true;

	if( isFF == true )	
		alert('Please use Internet Explorer, Chrome, Safari or another browser for viewing the invoice. Firefox is not working at present.');
	else
		window.location.href = url;
}

</script>

<div class="clearfix"></div>
<div class="container container-top">
    <div class="row-fluid">
    	
         <ul class="nav nav-pills">
        
            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/profile/view/password"><?php echo PageTitles::model()->SinglePageTitle('/user/profile','password'); ?></a></li>   
            
            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/profile/view/email"><?php echo PageTitles::model()->SinglePageTitle('/user/profile','email'); ?></a></li>
            
            <li <?php if($_REQUEST['view'] == 'changesubscription') echo 'class="active"'; ?>><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/profile/view/changesubscription"><?php echo PageTitles::model()->SinglePageTitle('/user/profile','subscription'); ?></a></li>
            
            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/profile/view/medias"><?php echo PageTitles::model()->SinglePageTitle('/user/profile','medias'); ?></a></li> 
            
            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/profile/view/accountingsetup"><?php echo PageTitles::model()->SinglePageTitle('/user/profile','accountingsetup'); ?></a></li> 
            
            <?php
					
			$CheckTransaction = AccountForm::model()->GetUsersAllTransaction();
			
			if(count($CheckTransaction))
			{
			
			?>
            <li class="active"><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/invoice">Invoice Detail</a></li>
			
			<?php	
			
			}
			
			?>
                    
        </ul>
    
        <table class="table table-striped">
        <thead> 
        <tr> 
            <th><strong>Invoice ID</strong></th> 
            <th><strong>Payment Date</strong></th> 
            <th><strong>Payment Amount</strong></th>
            <th><strong>Tax</strong></th>
            <th></th>
        </tr> 
        </thead>
        <tbody>
        <?php 
        if(count($GetRows)) 
        { 
            foreach($GetRows as $inv_key=>$inv_value) 
            { 
                if($inv_value['date'])
                    $TransactionDate = substr($inv_value['date'], 0, 4).'-'.substr($inv_value['date'], 4, 2).'-'.substr($inv_value['date'], 6, 2);
                else
                    $TransactionDate = '-';
                
                $UserRec = User::model()->GetOffRecord($inv_value['user_id']);
        ?>
                <tr>        
                    <td align="center"><?php echo $inv_value['id']; ?></td>
                    <td align="center"><?php echo $TransactionDate; ?></td>
                    <td align="center">
                    <?php 
                    
                        if($inv_value['amount'])
                            echo number_format($inv_value['amount'],0,2,',').' DKK'; 
                        else
                            echo '-';
                    ?> 
                    </td>
                    <td align="center">
                    <?php 
                    
                        if($inv_value['tax'])
                            echo number_format($inv_value['tax'],0,2,',').' DKK'; 
                        else
                            echo '-';
                    ?> 
                    </td>
                    <td align="center">
                        <a href="#" onclick="OpenPdf('<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/usermanagement/view/detail_invoice/inv/<?php echo $inv_value['id']; ?>')" title="View Detail"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/details.png" /></a>
                        
                    </td>
                </tr>
        <?php 
                $TransactionDate = '';
            } 
        } 
        else 
        { 
        ?>
            <tr>
            	<td colspan="6"> 
            		<div class="alert alert-error">No record found </div>
            	</td>
			</tr>
        <?php 
        } 
        ?>
        </tbody>
        </table>
	</div>
</div>