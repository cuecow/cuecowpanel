<?php

$account_name = getContent('site.account.accountname',Yii::app()->session['language']);

if(empty($account_name))
	echo '<script>window.location.href="'.Yii::app()->request->baseUrl.'/index.php/site/account/subscription/'.$_REQUEST['subscription'].'"</script>';
	
?>
<div id="login-wrapper">

	<!-- Display the Logo -->
	<div id="logo"><h1>Cue Cow</h1></div>
	
	<div class="span6 login_div">
    	<div class="accordion" id="accordion1">
			
            <div class="accordion-group">
            	
                <div class="accordion-heading">
                	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne" title="Click to open/close"><?php echo getContent('site.account.accountinfo',Yii::app()->session['language']); ?></a>
				</div>
                  
                <div id="collapseOne" class="accordion-body collapse in">
                	<div class="accordion-inner">
                    
					<?php $form=$this->beginWidget('CActiveForm', array('htmlOptions'=>array('class'=>'styled'),'enableClientValidation'=>true,'clientOptions'=>array('validateOnSubmit'=>true),)); ?>
                            
                        <?php if(isset($_POST['AccountForm']) && $error>0) { ?>
                        	
                            <div class="alert alert-error">
                              	<button type="button" class="close" data-dismiss="alert">&times;</button>
                              	<? echo $form->errorSummary($model); ?>
                            </div>
                            
                        <?php } ?>
            			                        
                        <div class="field-content-44">
                        	<div class="login_field-content-44-left login"><label>Account type :</label></div>
                            <div class="login_field-content-44-right left-content-fld">
                            	<?php echo ucfirst($_REQUEST['subscription']); ?>
                            </div>
						</div>
                        
                        <div class="clearfix"></div>
                        
                        <?php
						
						if(!isset($_REQUEST['offer_guid']))
						{
							$SubscriptionType = AccountForm::model()->CheckSubscriptionAmount(ucfirst($_REQUEST['subscription']));
							$Price = $SubscriptionType[0]['price']*1.25;
						}
						else
						{
							$SubscriptionType = MarketingOffer::model()->GetRecordWithGid($_REQUEST['offer_guid']);
							$Price = $SubscriptionType[0]['offered_price']*1.25;
						}
						
						
						?>
                        <div class="field-content-44">
                        	<div class="login_field-content-44-left login"><label>Price/month :</label></div>
                            <div class="login_field-content-44-right left-content-fld">
                            	<?php echo $Price; ?> kr (incl. 25% VAT)
                                <input type="hidden" name="offer_guid" value="<?php echo $_REQUEST['offer_guid'] ?>" />
                            </div>
						</div>
                        
                        <div class="clearfix"></div>
                        
						<?php 
                        
						if(!empty($_POST['AccountForm']['account_name']))
                            $account_name = $_POST['AccountForm']['account_name'];
                        else if(!empty($tele_camp_record['account_name'])) 
                            $account_name = $tele_camp_record['account_name'];
						else
                            $account_name = '';
                        
                        ?>
            			
                        <div class="field-content-44">
                        	<div class="login_field-content-44-left login"><label><span class="mendatory_red">*</span> <?php echo getContent('site.account.accountname',Yii::app()->session['language']); ?>:</label></div>
                            <div class="login_field-content-44-right left-content-fld">
                            	<?php echo $form->textField($model,'account_name',array('class'=>'textbox','value'=>$account_name,'style'=>'width:300px;')); ?>
                            </div>
						</div>
                        
                        <div class="clearfix"></div>
                      
            			<?php 
						
						if(!empty($_POST['AccountForm']['email']))
							$account_email = $_POST['AccountForm']['email'];	
						else if(!empty($tele_camp_record['user_email'])) 
							$account_email = $tele_camp_record['user_email'];
						else 
							$account_email = '';
			
						?>
            			
                        <div class="field-content-44">
                        	<div class="login_field-content-44-left login"><label><span class="mendatory_red">*</span> <?php echo getContent('site.account.email',Yii::app()->session['language']); ?>:</label></div>
                            <div class="login_field-content-44-right left-content-fld">
                            	<?php echo $form->textField($model,'email',array('class'=>'textbox','value'=>$account_email,'style'=>'width:300px;')); ?>
                            </div>
						</div>
                        
                        <div class="clearfix"></div>
                        
                        <div class="field-content-44">
                        	<div class="login_field-content-44-left login"><label><span class="mendatory_red">*</span> <?php echo getContent('site.account.emailrepeat',Yii::app()->session['language']); ?>:</label></div>
                            <div class="login_field-content-44-right left-content-fld">
                            	<input type="text" name="AccountForm[repeat_email]" class="textbox" value="<?php echo $account_email; ?>" style="width:300px;" />
                            </div>
						</div>
                        
                        <div class="clearfix"></div>
                        
                        <div class="field-content-44">
                        	<div class="login_field-content-44-left login"><label><?php echo getContent('site.account.username',Yii::app()->session['language']); ?>:</label></div>
                            <div class="login_field-content-44-right left-content-fld">
                            	<?php echo $form->textField($model,'username',array('class'=>'textbox','value'=>$_POST['AccountForm']['username'],'style'=>'width:300px;',' autocomplete'=>'off')); ?><br />
                                (<?php echo getContent('site.account.leaveblank',Yii::app()->session['language']); ?>)
                            </div>
						</div>
                        
                        <div class="clearfix"></div>
            			
                        <div class="field-content-44">
                        	<div class="login_field-content-44-left login"><label><span class="mendatory_red">*</span> <?php echo getContent('site.account.password',Yii::app()->session['language']); ?>:</label></div>
                            <div class="login_field-content-44-right left-content-fld">
                            	<?php echo $form->passwordField($model,'password',array('class'=>'textbox','style'=>'width:300px;')); ?>
                            </div>
						</div>
                        
                        <div class="clearfix"></div>
                   
						<?php 
                        
                        if(!empty($_POST['AccountForm']['fname']))
                            $account_fname = $_POST['AccountForm']['fname'];
						else if(!empty($tele_camp_record['user_fname'])) 
                            $account_fname = $tele_camp_record['user_fname'];
                        else 
                            $account_fname = '';
                        
                        ?>
            			
                        <div class="field-content-44">
                        	<div class="login_field-content-44-left login"><label><?php echo getContent('site.account.firstname',Yii::app()->session['language']); ?>:</label></div>
                            <div class="login_field-content-44-right left-content-fld">
                            	<?php echo $form->textField($model,'fname',array('class'=>'textbox','value'=>$account_fname,'style'=>'width:300px;')); ?>
                            </div>
						</div>
                        
                        <div class="clearfix"></div>
               
						<?php 
                        
						if(!empty($_POST['AccountForm']['lname']))
                            $account_lname = $_POST['AccountForm']['lname'];
                        else if(!empty($tele_camp_record['user_lname'])) 
                            $account_lname = $tele_camp_record['user_lname'];
                        else 
                            $account_lname = '';
                        
                        ?>
            			
                        <div class="field-content-44">
                        	<div class="login_field-content-44-left login"><label><?php echo getContent('site.account.lastname',Yii::app()->session['language']); ?>:</label></div>
                            <div class="login_field-content-44-right left-content-fld">
                            	<?php echo $form->textField($model,'lname',array('class'=>'textbox','value'=>$account_lname,'style'=>'width:300px;')); ?>
                            </div>
						</div>
                        
                        <div class="clearfix"></div>
                        
                        <?php 
                        
						if(!empty($_POST['AccountForm']['phone']))
                            $phone = $_POST['AccountForm']['phone'];
                        else if(!empty($tele_camp_record['phone'])) 
                            $phone = $tele_camp_record['phone'];
                        else 
                            $phone = '';
                        
                        ?>
                        
                        <div class="field-content-44">
                        	<div class="login_field-content-44-left login"><label><?php echo getContent('site.account.phone',Yii::app()->session['language']); ?>:</label></div>
                            <div class="login_field-content-44-right left-content-fld">
                            	<?php echo $form->textField($model,'phone',array('class'=>'textbox','style'=>'width:300px;','value'=>$phone)); ?>
                            </div>
						</div>
                        
                        <div class="clearfix"></div>
             
            			<h5>
							<?php echo getContent('site.account.companyinfo',Yii::app()->session['language']); ?>
                        </h5>
            
						<?php 
                        
						if(!empty($_POST['AccountForm']['company']))
                            $company_name = $_POST['AccountForm']['company'];
                        else if(!empty($tele_camp_record['company'])) 
                            $company_name = $tele_camp_record['company'];
                        else 
                            $company_name = '';
                        
                        ?>
            			
                        <div class="field-content-44">
                        	<div class="login_field-content-44-left login"><label><?php echo getContent('site.account.companyname',Yii::app()->session['language']); ?>:</label></div>
                            <div class="login_field-content-44-right left-content-fld">
                            	<?php echo $form->textField($model,'company',array('class'=>'textbox','value'=>$company_name,'style'=>'width:300px;')); ?>
                            </div>
						</div>
                        
                        <div class="clearfix"></div>
                        
						<?php 
                        
						if(!empty($_POST['AccountForm']['address']))
                            $address = $_POST['AccountForm']['address'];
                        else if(!empty($tele_camp_record['address'])) 
                            $address = $tele_camp_record['address'];
                        else 
                            $address = '';
                        
                        ?>
            			
                        <div class="field-content-44">
                        	<div class="login_field-content-44-left login"><label><?php echo getContent('site.account.address',Yii::app()->session['language']); ?>:</label></div>
                            <div class="login_field-content-44-right left-content-fld">
                            	<?php echo $form->textField($model,'address',array('class'=>'textbox','value'=>$address,'style'=>'width:300px;')); ?>
                            </div>
						</div>
                        
                        <div class="clearfix"></div>
                      
						<?php 
                        
						if(!empty($_POST['AccountForm']['postal_code']))
                            $postal_code = $_POST['AccountForm']['postal_code'];
                        else if(!empty($tele_camp_record['postal_code'])) 
                            $postal_code = $tele_camp_record['postal_code'];
                        else 
                            $postal_code = '';
                        
                        ?>
            			
                        <div class="field-content-44">
                        	<div class="login_field-content-44-left login"><label><?php echo getContent('site.account.zipcode',Yii::app()->session['language']); ?>:</label></div>
                            <div class="login_field-content-44-right left-content-fld">
                            	<?php echo $form->textField($model,'postal_code',array('class'=>'textbox','value'=>$postal_code,'style'=>'width:300px;')); ?>
                            </div>
						</div>
                        
                        <div class="clearfix"></div>
                                    
                        <?php 

                        if(!empty($_POST['AccountForm']['city']))
                            $city_name = $_POST['AccountForm']['city'];
                        else if(!empty($tele_camp_record['city'])) 
                            $city_name = $tele_camp_record['city'];
                        else 
                            $city_name = '';
                        
                        ?>
            			
                        <div class="field-content-44">
                        	<div class="login_field-content-44-left login"><label><?php echo getContent('site.account.city',Yii::app()->session['language']); ?>:</label></div>
                            <div class="login_field-content-44-right left-content-fld">
                            	<?php echo $form->textField($model,'city',array('class'=>'textbox','value'=>$city_name,'style'=>'width:300px;')); ?>
                            </div>
						</div>
                        
                        <div class="clearfix"></div>
                        
						<?php 
                        
						if(!empty($_POST['AccountForm']['country']))
                            $country_name = $_POST['AccountForm']['country'];
                        else if(!empty($tele_camp_record['country'])) 
                            $country_name = $tele_camp_record['country'];
                        else 
                            $country_name = '';
                        
                        ?>
            			
                        <div class="field-content-44">
                        	<div class="login_field-content-44-left login"><label><?php echo getContent('site.account.country',Yii::app()->session['language']); ?>:</label></div>
                            <div class="login_field-content-44-right left-content-fld">
                            	<?php echo $form->textField($model,'country',array('class'=>'textbox','value'=>$country_name,'style'=>'width:300px;')); ?>
                            </div>
						</div>
                        
                        <div class="clearfix"></div>
                        
                        <div class="field-content-44">
                        	<input type="checkbox" class="checkbox" name="AccountForm[terms]" value="yes" /> &nbsp; <?php echo getContent('site.account.terms',Yii::app()->session['language']); ?>
						</div>
                        
                        <div class="clearfix"></div>
                     
						<br />
            
                        <div style="margin-left:120px;">
                        	
                            <button class="btn btn-info btn-large" type="submit"><?php echo getContent('site.account.createaccount',Yii::app()->session['language']); ?></button>
                            
                            &nbsp;&nbsp;<input class="btn btn-large" type="button" value="<?php echo getContent('site.account.cancel',Yii::app()->session['language']); ?>" onclick="window.location.href='<?php echo $_SERVER['HTTP_REFERER']; ?>'" />
                            <input type="hidden" name="AccountForm[subscriptionType]" value="<?php echo $subscriptionType;  ?>" />
                        </div>            
            
						<?php $this->endWidget(); ?>
                            
                	</div>
				</div>
			</div>
		</div>    
	</div>
    
    <?php
	
	$file_handle = fopen("version.txt", "r");
	while (!feof($file_handle)) 
   		$version = fgets($file_handle);
	
	fclose($file_handle);
	
	?>
    
	<div class="under-form">Copyright &copy;<?php echo date('Y'); ?> Cuecow, <?php echo $version; ?>, User: anonymous, Role: None</div>

</div>


<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Terms of use</h3>
  </div>
  <div class="modal-body">
    
    <p><b>General Conditions</b></p>
	
    <p>To subscribe at CueCow it is assumed that the customer is an adult. If the customer is a minor, the agreement for use of our services only may happened with the consent of the authorities guardian.</p>
	<p>The customer is obliged to maintain and update its master data, including e-mail address because it is CueCow's primary way to contact the customer. Master data can be maintained through the customer control panel.<br />
	
    <b>Terms</b></p>
	<p>By ordering an account declares buyer / cardholder, the registrant agrees that the use does not infringe any third party’s name or trademark rights or otherwise contrary to Danish law.</p>
	<p>Renewal of services is generally automated as a subscription through CueCow’s control panel. Customer will receive reminders before renewal. It is solely the client’s responsibility to ensure timely un-subscription before additional renewal. When a buyer unsubscribe from our services it has to be don at least one day before monthly renewal.</p>
	
    <p>If CueCow want to cancel a subscription, this is done with 1 month’s written notice to the customer, however, CueCow has always the right without notice to close an account, if the customer has violated CueCow’s conditions. CueCow will then submit a written justification for the closure with regard to the condition is violated.</p>
	
    <p><b>Changing subscription</b></p>
	<p>The customer may at any time change the ordered subscription to a greater or lesser service free of charge.</p>
	
    <p><b>Use</b></p>
	<p>The purpose of CueCow’s locationbased social media platform is not to act as an external hard drive for storing media campaign materials. – But to act as a marketing and sales platform for companies, organizations and private people. It is not allowed to have larger file archives available.</p>
	
    <p><b>Content</b></p>
	<p>For Marketing and social media campaigns purposes CueCow continually assess the size of content used (photos/videos/music) that may overload our servers or cause crashes. If this is the case, CueCow are allowed at any time to remove these or temporarily disable access to those campaign elements. This will normally take place in consultation with the user.</p>
	
    <p><b>Law &amp; responsibility</b></p>
	<p>CueCow allow any information that is not contrary to the provisions of Danish and international law, with the exception of pornographic or otherwise controversial material, which may not be available on CueCow servers without prior agreement.</p>
	
    <p>CueCow shall not be liable for any loss as a result of indirect damage and consequential damages, including loss of anticipated profits, loss of data or their restoration, loss of goodwill, loss of means of payment, technical failures, unauthorized access, improper setup of the site or other similar consequential damages in connection with use of the system or loss as a result of lack of features in the system, whether CueCow has been advised of the possibility of such loss, and whether CueCow is to blame the loss on the basis of negligence or similar.</p>
	<p>CueCow is not liable for losses caused by force majeure, including legal requirements, regulatory actions or similar, failing power supplies, failure of telecommunications, fire, smoke damage, explosion, water damage, vandalism, burglary, terrorism or sabotage, strike, lockout, boycott or blockade. This applies even if CueCow is a party to the conflict, and although the conflict affects only parts of CueCow’s services and functions.</p>
    
	<p><b>Law &amp; responsibilities concerning content</b></p>
	<p>CueCow allows any information without limiting the nature or content that does not conflict with the provisions of the legislation, with the exception of pornographic or other controversial material.</p>
<p><b>Platform Operation</b></p>

	<p>CueCow endeavors to ensure that all systems are available 24 hours a day, year round. CueCow is entitled to interrupt the operation when maintenance or other technical conditions make it necessary.</p>
    
	<p><b>Payment Terms</b></p>
	<p>All services at CueCow website is available in Danish Crones DKK and EURO and ex. VAT, unless otherwise stated. All services must be paid for online payments.</p>
    
	<p>It offers the possibility for automatic renewal of our services when the customer enters their credit card information in its control panel, and choose which products will automatically be renewed. The service may at any time &amp; canceled via the control panel, where map information can also be changed. Customer will receive reminder e-mail when an automatic renewal has taken place, receipt of payment can be found in the customer’s control panel. It is also possible to use the entered during normal payment card details, which will be presented as a possible method of payment. CueCow do not store customer credit card information.</p>
	
    <p><b>Online payment</b></p>
	<p>All online payments using Visa, Eurocard or Mastercard will not conferred fee from CueCow’s side. All Services ordered and paid for online will be set up immediately after which the amount at the same time will be deducted from your account.</p>
    
	<p>CueCow’s products and services are specially adapted to the customer and therefore the general right of withdrawal is not accepted according to the Danish Law for consumers Chapter 4 § 12 (right of withdrawal for distance).</p>
	
    <p><b>Termination Conditions</b></p>
	<p>All orders for hosting pre-billed for periods of 1 months Resignations of this happens automatically if the pay period is not extended by the customer. Extension of periods occurs through the customer’s control panel and can be made at any time platform data is not deleted.</p>
    
	<p><b>Support</b></p>
	<p>It is CueCow’s intention to be the cheapest of all social media dashboard providers – so we shaved our labor costs down to an absolute minimum. For the same reason we do not offer phone support available, but free online support through our ticket system.</p>
    
	<p><b>Competition</b></p>
	<p>The customer is not entitled to operate competing business with CueCow as long as the agreement is in use etc. in force.</p>
    
	<p><b>Jurisdiction</b></p>
	<p>The customer declares themselves in agreement with CueCow’s general trading conditions. CueCow reserves the right to make changes to the terms and conditions without notice. Any dispute arising in connection with this Agreement shall be settled under Danish law with the Maritime and Commercial Court in Copenhagen as venue in the first instance.</p>
    
	<p><b>Cuecow.com</b><br />
	Østbanegade 17.1th.<br />
	2100 Copenhagen<br />
	Denmark<br />
	support@cuecow.com<br />
	Phone +0045 28100838<br />
	Use the build-in Chat function on platform – please<br />
	CVR NO. 33572484</p>
    
  </div>
  <div class="modal-footer">
    <button class="btn btn-info" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>