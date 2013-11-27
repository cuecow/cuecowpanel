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
 
<div id="login-wrapper">
	
	<div id="signup-form">
		
        
	</div>
</div>

<script>
paymentwindow.open();
</script>