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

<div class="clear"></div>

<div class="clearfix"></div>

<div class="container container-top">
	<div class="row-fluid">
    
		<?php
        
        $GetRows = AccountForm::model()->GetAllTransaction();
        
        ?>
		<table class="table table-striped">
        <thead> 
        <tr> 
            <th><strong>Invoice ID</strong></th> 
            <th><strong>Payment Date</strong></th> 
            <th><strong>Payment Amount</strong></th>
            <th><strong>Tax</strong></th>
            <th><strong>Account Name</strong></th>
            <th><strong>User Name </strong></th>
            <th></th>
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
            <td><?php echo $inv_value['id']; ?></td>
            <td><?php echo $TransactionDate; ?></td>
            <td>
                <?php 
                
                if($inv_value['amount'])
                    echo number_format($inv_value['amount'],0,2,',').' DKK'; 
                else
                    echo '-';
                
                ?> 
            </td>
            <td>
                <?php 
                                    
                if($inv_value['tax'])
                    echo number_format($inv_value['tax'],0,2,',').' DKK'; 
                else
                    echo '-';
                
                ?> 
            </td>
            <td align="center">
                <?php if($UserRec[0]['account_name']) echo $UserRec[0]['account_name']; else echo '-'; ?>
            </td>
            <td align="center">
                <?php if($UserRec[0]['username']) echo $UserRec[0]['username']; else echo '-'; ?>
            </td>
            <td align="center">
            
                <a href="#" onclick="OpenPdf('<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/usermanagement/view/detail_invoice/inv/<?php echo $inv_value['id']; ?>')" title="View Detail"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/details.png" /></a>
                
            </td>
            
            <td align="center">
            
            <?php if($inv_value['kreditnota_for_id']=='0') { ?>
            
                <a href="#" onclick="ConfirmKredit('<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/usermanagement/view/Kreditnota/inv/<?php echo $inv_value['id']; ?>')" title="Create kreditnota"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/credit_color.png" border="0" /></a>
                
            <?php } else { ?>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/credit_gray.png" />
            <?php } ?>
                
            </td>
        </tr>
        <?php 
                $TransactionDate = '';
            } 
        } 
        else 
        { 
        ?>
            <tr><td colspan="6" align="center"> No record found </td></tr>
        <?php 
        } 
        ?>
        </tbody>
        </table>
  
	</div>
</div>

<script>

function ConfirmKredit(url)
{
	if( confirm( " Are you sure you want to create a kreditnota for this invoice? It cannot be undone. ") )	
	{
		window.location.href = url;
	}
}

</script>