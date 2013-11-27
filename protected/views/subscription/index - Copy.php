<!-- BEGIN PAGE BREADCRUMBS/TITLE -->
<div class="container_4 no-space">
	<div id="page-heading" class="clearfix">
		
		<div class="grid_2 title-crumbs">
			<div class="page-wrap">
				
				<h1><?php echo $PageTitle; ?></h1>
				
			</div>
		</div>
	</div>
</div>
<!-- END PAGE BREADCRUMBS/TITLE -->

<?php if(!empty($error)) { ?>
<div class="container_4 no-space push-down">
	<div class="alert-wrapper error clearfix">
		<div class="alert-text">
			<? echo $error; ?>
			<a href="javascript:void(0);" class="close">Close</a>
		</div>
	</div>
</div>
<?php } ?>

<div class="container_4" style="padding-top:20px;">
	<div class="grid_4" style="background:#FFF;">
		<div class="panel" style="border:0px; background:#FFF;">
            
            
            
            <form class="styled" name="ChangeCredit" action="" method="post">
            
                <fieldset>
                            
                    <label for="textField">
                        <span class="field_title">Card Number:</span>
                        <input type="text" class="small textbox" name="card_number" autocomplete="off" />
                    </label>
                    
                    <label for="textField">
                        <span class="field_title">Cardholder name:</span>
                        <input type="text" class="small textbox" name="Cardholder_name" autocomplete="off" />
                    </label>
                    
                    <label for="textField">
                        <span class="field_title">Expiry month/year:</span>
                        <input type="text" class="small textbox" name="expiry_month" autocomplete="off" style="width:150px;" /> / <input type="text" class="small textbox" name="expiry_year" autocomplete="off" style="width:150px;" />
                    </label>
                    
                    <label for="textField">
                        <span class="field_title">Security code:</span>
                        <input type="text" class="small textbox" name="security_code" autocomplete="off" style="width:150px;" />
                    </label>
                    
                    <!-- Buttons -->
                    <div class="non-label-section">
                        <input type="submit" value="Submit" class="button large green" />
                        <input type="hidden" name="change_credit_card" value="yes" />
                    </div>
                
                </fieldset>
            
            </form>
                
		</div>
	</div>
</div>
