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
 
<!--<script type="text/javascript" src="http://www.epay.dk/js/standardwindow.js"></script>-->

<div id="login-wrapper">
	
	<div id="signup-form">
		
        <!--<center><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/ajax-loader.gif" /></center>-->
        
        <!--<form action="https://ssl.ditonlinebetalingssystem.dk/popup/default.asp" method="post" name="ePay" target="ePay_window" id="ePay">
            <input type="hidden" name="windowstate" value="2" />
            <input type="hidden" name="merchantnumber" value="<?php echo $post_data['merchantnumber']; ?>" />
            <input type="hidden" name="amount" value="<?php echo $post_data['amount']; ?>" />
            <input type="hidden" name="currency" value="<?php echo $post_data['currency']; ?>" />
            <input type="hidden" name="addfee" value="0" />
            <input type="hidden" name="orderid" value="<?php echo $post_data['orderid'] ?>" />
            <input type="hidden" name="subscription" value="<?php echo $post_data['subscription']; ?>" />
            <input type="hidden" name="accepturl"  value="<?php echo $post_data['accepturl']; ?>" />
            <input type="hidden" name="declineurl"  value="<?php echo $post_data['declineurl']; ?>" />
            <input type="hidden" name="callbackurl"  value="<?php echo $post_data['callbackurl']; ?>" />
            <input type="hidden" name="language"  value="<?php echo $post_data['language']; ?>" />
            <input type="hidden" name="instantcapture"  value="<?php echo $post_data['instantcapture']; ?>" />
        </form>-->
        
	</div>
</div>

<script>
paymentwindow.open();
//open_ePay_window();
</script>