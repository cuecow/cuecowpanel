<div class="container_4" style="padding-top:150px;">
	<div class="grid_4" style="background:#FFF;">
		<div class="panel" style="border:0px; background:#FFF; height:300px;">
            
            <script type="text/javascript" src="http://www.epay.dk/js/standardwindow.js"></script>
            <div id="login-wrapper">
            
                <!-- Start the white form block -->
                <div id="signup-form">
                    
                    <?php if($error == '') { ?>
                    <center>
                    	<img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/ajax-loader.gif" />
                    </center>
                    
                    <form action="https://ssl.ditonlinebetalingssystem.dk/popup/default.asp" method="post" name="ePay" target="ePay_window" id="ePay">
                    <input type="hidden" name="windowstate" value="2" />
                    <input type="hidden" name="merchantnumber" value="<?=$post_data['merchantnumber']?>" />
                        <input type="hidden" name="amount" value="<?=$post_data['amount']; ?>" />
                        <input type="hidden" name="currency" value="<?=$post_data['currency']; ?>" />
                        <input type="hidden" name="addfee" value="0" />
                        <input type="hidden" name="orderid" value="<?=$post_data['orderid'] ?>" />
                        <input type="hidden" name="subscription" value="<?=$post_data['subscription']; ?>" />
                        <input type="hidden" name="accepturl"  value="<?=$post_data['accepturl']; ?>" />
                        <input type="hidden" name="declineurl"  value="<?=$post_data['declineurl']; ?>" />
                        <input type="hidden" name="callbackurl"  value="<?=$post_data['callbackurl']; ?>" />
                        <input type="hidden" name="language"  value="<?=$post_data['language']; ?>" />
                        <input type="hidden" name="instantcapture"  value="<?=$post_data['instantcapture']; ?>" />
                    </form>
                    
                    <?php } else { ?>
                    
                    <div class="container_4 no-space push-down">
                        <div class="alert-wrapper error clearfix">
                            <div class="alert-text">
                                <? echo $error; ?>
                                <a href="javascript:void(0);" class="close">Close</a>
                            </div>
                        </div>
                    </div>
                    
                    <?php } ?>
                </div>
            </div>
            
            <script>
                
                open_ePay_window();
                
            </script>
            
		</div>
	</div>
</div>

