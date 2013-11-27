<script type="text/javascript" src="https://ssl.ditonlinebetalingssystem.dk/integration/ewindow/paymentwindow.js" charset="UTF-8"></script>
   
<script type="text/javascript">
     paymentwindow = new PaymentWindow({
         <?php
         foreach ($post_data as $key => $value)
         {
             echo "'" . $key . "': \"" . $value . "\",\n";
         }
         ?>
         'hash': "<?php echo md5(implode("", array_values($post_data)) . "gpfgWG3332A5SUV"); ?>"
     });
</script>
 
<div class="container container-top">
	<div class="row-fluid" style="min-height:300px;">
    
        <ul class="nav nav-pills">
        
            <li <?php if($_REQUEST['view'] == '' || $_REQUEST['view'] == 'password') echo 'class="active"'; ?>><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/profile/view/password"><?php echo PageTitles::model()->SinglePageTitle('/user/profile','password'); ?></a></li>   
            
            <li <?php if($_REQUEST['view'] == 'email') echo 'class="active"'; ?>><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/profile/view/email"><?php echo PageTitles::model()->SinglePageTitle('/user/profile','email'); ?></a></li>
            
            <li <?php if($_REQUEST['view'] == 'editaccount') echo 'class="active"'; ?>><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/profile/view/editaccount"><?php echo PageTitles::model()->SinglePageTitle('/user/profile','editaccount'); ?></a></li> 
            
            <li <?php if($_REQUEST['view'] == 'changesubscription') echo 'class="active"'; ?>><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/profile/view/changesubscription"><?php echo PageTitles::model()->SinglePageTitle('/user/profile','changesubscription'); ?></a></li>
            
            <li <?php if($_REQUEST['view'] == 'medias') echo 'class="active"'; ?>><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/profile/view/medias"><?php echo PageTitles::model()->SinglePageTitle('/user/profile','medias'); ?></a></li> 
            
            <li <?php if($_REQUEST['view'] == 'selwall') echo 'class="active"'; ?>><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/profile/view/selwall"><?php echo PageTitles::model()->SinglePageTitle('/user/selwall','selwall'); ?></a></li> 
            
            <li <?php if($_REQUEST['view'] == 'accountingsetup') echo 'class="active"'; ?>><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/profile/view/accountingsetup"><?php echo PageTitles::model()->SinglePageTitle('/user/profile','accountingsetup'); ?></a></li>
            
            <li <?php if($_REQUEST['view'] == 'card') echo 'class="active"'; ?>><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/changecard/view/card"><?php echo PageTitles::model()->SinglePageTitle('/user/changecard','card'); ?></a></li>
            
            <?php
					
			$CheckTransaction = AccountForm::model()->GetUsersAllTransaction();
			
			if(count($CheckTransaction))
			{
			
			?>
            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/invoice">Invoice Detail</a></li>
			
			<?php	
			
			}
			
			?>
                    
        </ul>
        
        <div class="alert alert-info" style="margin-top:50px;">
            <a href="">Click here</a> to reload the form
        </div>
        
	</div>
</div>

<script>
paymentwindow.open();
</script>