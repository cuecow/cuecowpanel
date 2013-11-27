<?php if(Yii::app()->user->role=='admin') { ?>

<div class="container container-top">
	<div class="row-fluid">

				
	</div>
</div>

<div class="container_4" style="padding-top:20px;">
	<div class="grid_4" style="background:#FFF;">
		<div class="panel" style="border:0px; background:#FFF;">
			
			<div class="content">
			<?php 
			
			if($_REQUEST['view']=='Add' || isset($_POST['User'])) 
			{
				$this->widget('application.components.user.AddUser');	
			} 
			else if($_REQUEST['view'] == 'invoices')
			{
				include('UserInvoices.php');
			}
			else if($_REQUEST['view'] == 'detail_invoice')
			{
				?>
                <div style="float:left; width:650px; padding:20px 20px 100px 20px; border:#EEE 0px solid;">
                <table width="95%" border="0">
                <tr>
                    <td valign="top">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td width="100%" valign="top">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td width="23%"><b>InvoiceID:</b> </td>
                                    <td width="77%"><?php echo $invoice_id; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Payment Date:</b> </td>
                                    <td><?php echo $payment_date; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Cuecow APS - CVR:</b> </td>
                                    <td>33 57 24 84</td>
                                </tr>
                                </table>
                            </td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr><td>&nbsp;</td></tr>
                <tr>
                    <td>Dear <?php echo $username; ?>,</td>
                </tr>
                <tr>
                    <td>Thank you for subscribing to our services.<br /> We hereby send you an invoice covering the next period of use.</td>
                </tr>
                <tr><td>&nbsp;</td></tr>
                <tr>
                    <td><?php echo $address; ?></td>
                </tr>
                <tr><td>&nbsp;</td></tr>
                <tr>
                    <td>Cuecow subscriptiontype <b><?php echo $subscription_limit ?></b> <b><?php echo $total_amount; ?></b></td>
                </tr>
                <tr><td>&nbsp;</td></tr>
                <tr>
                    <td>Thank you for choosing <a href="http://www.cuecow.com" style="text-decoration:none;">cuecow.com</a> for your social media engagement platform.</td>
                </tr>
                </table>
            </div>
            <?
			}
			else if($_REQUEST['view'] == 'kreditnota')
			{
			?>
			
				<form name="kreditnota_form" action="" method="post" class="styled">
					
                    <?php if(!empty($kredinota_validate)) { ?>									
                    <div class="container_4 no-space push-down">
                        <div class="alert-wrapper error clearfix">
                            <div class="alert-text">
                                <?php echo $kredinota_validate; ?>
                                <a href="javascript:void(0);" class="close">Close</a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
				
					<fieldset>
						
						<label for="textField">
							<span class="field_title">Amount:</span>
							<input type="text" name="inv_amount" class="small textbox" value="<?php echo $trans_info[0]['amount']; ?>" />
						</label>
						<label for="textField">
							<span class="field_title">Tax:</span>
							<input type="text" name="inv_tax" class="small textbox" value="<?php echo $trans_info[0]['tax']; ?>" />
						</label>
						
						
						<div class="non-label-section">
							<input type="submit" value="Submit" class="button large green" />
                            <input type="hidden" name="inv_id" value="<?php echo $trans_info[0]['id']; ?>" />
						</div>
					
					</fieldset>
                    
				</form>
				
			<?php 
			}
			else
			{
				$this->widget('application.components.user.AllUserList');	
			} 
			
			?>
			</div>
            
		</div>
	</div>
</div>
<?php } else { ?>
<div class="container_4" style="padding-top:20px;">
	<div class="grid_4">
		<div class="panel">
			<h2 class="cap">Users</h2>
			<div class="content" align="center" style="color:#990000; font-size:20px; padding:150px 0px 150px 0px;">
				You are not authorized to perform this action.
			</div>
		</div>
	</div>
</div>
<?php } ?>

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