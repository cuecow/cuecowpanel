<div class="container container-top">
	<div class="row-fluid">    
    
		<div class="span6">
    		<div class="accordion" id="accordion1">
            
	            <div class="accordion-group">        	
                	
                    <?php if(!isset(Yii::app()->user->user_id)) { ?>
                    <div class="accordion-heading">
                    	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne" title="Click to open/close">Create Marketing Offer</a>
                    </div>
                    <?php } ?>
                    
                	<div id="collapseOne" class="accordion-body collapse in">

                		<div class="accordion-inner">
                	
                    	<?php if(empty($message)) { ?>
                		
                        <?php if($_REQUEST['key'] == 'Aew12KjyGG') { 
                                
							$form=$this->beginWidget('CActiveForm', array('id'=>'campaign-offer-form','htmlOptions'=>array('class'=>'styled'),'enableAjaxValidation'=>true,)); 
                                    
                            if(isset($_POST['MarketingOffer'])) { 
                        ?>									
                        	<div class="alert alert-error">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <? echo $form->errorSummary($model); ?>
                            </div>
						
						<? } if($_REQUEST['msg'] == 1) { ?>
                        	
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                Record added to system
                            </div>
                            
						<?php } ?>
        				
                        <div class="field-content-44">
                            <div class="login_field-content-44-left login"><label>Account Name:</label></div>
                            <div class="login_field-content-44-right left-content-fld">
                                <?php echo $form->textField($model,'account_name',array('class'=>'textbox','style'=>'width:300px;','value'=>$record['account_name'])); ?>
                            </div>
                        </div>
                    
                        <div class="clearfix"></div>
                        
                        <div class="field-content-44">
                            <div class="login_field-content-44-left login"><label>Subscription Type:</label></div>
                            <div class="login_field-content-44-right left-content-fld">
                                <?php 
												
								if(isset($_REQUEST['subscription_type']))
								{
									$SpecificRec = SubsriptionType::model()->GetSpecificRecbyName($_REQUEST['subscription_type']);
									$SelectedRec = $SpecificRec[0]['subscription_id'];
								}
								else if(isset($record['subscription_type_id']))
									$SelectedRec = $record['subscription_type_id'];
								else
									$SelectedRec = 2;
								
								$subscription_temp_array = SubsriptionType::model()->GetAllRec();
								
								$subscription_array = array();
								
								foreach($subscription_temp_array as $key_5=>$val_5)
								{
									$subscription_array[$key_5+1] = $val_5['name'];
								}
								
								echo $form->dropDownList($model,'subscription_type_id',$subscription_array,array('class'=>'textbox','style'=>'width:300px;','options'=>array($SelectedRec=>array('selected'=>'selected'))));
								 
								?>
                            </div>
                        </div>
                    
                        <div class="clearfix"></div>
                        
                        <?php
										
						if(!empty($_REQUEST['price_offered']))
							$price_offered = $_REQUEST['price_offered'];
						else if(!empty($_REQUEST['offered_price']))
							$price_offered = $_REQUEST['offered_price'];
						else if(isset($_REQUEST['subscription_type']))
						{
							$type_info = AccountForm::model()->CheckSubscriptionAmount($_REQUEST['subscription_type']);
							$price_offered = $type_info[0]['price'];
						}
						else
						{
							$type_info = AccountForm::model()->CheckSubscriptionAmount('Moo');
							$price_offered = $type_info[0]['price'];
						}
						
						?>
                        
                        <div class="field-content-44">
                            <div class="login_field-content-44-left login">
                            	<label>Price offered <br />(DKK eks. moms):</label>
                            </div>
                            <div class="login_field-content-44-right left-content-fld">
                                <?php echo $form->textField($model,'offered_price',array('class'=>'textbox','style'=>'width:300px;','value'=>$price_offered)); ?>
                            </div>
                        </div>
                    
                        <div class="clearfix"></div>
                        
                        <div class="field-content-44">
                            <div class="login_field-content-44-left login">
                            	<label>Industry:</label>
                            </div>
                            <div class="login_field-content-44-right left-content-fld">
                                <?php echo $form->textField($model,'Industry',array('class'=>'textbox','style'=>'width:300px;','value'=>$record['Industry'])); ?>
                            </div>
                        </div>
                    
                        <div class="clearfix"></div>
                        
                        <div class="field-content-44">
                            <div class="login_field-content-44-left login">
                            	<label>Email:</label>
                            </div>
                            <div class="login_field-content-44-right left-content-fld">
                                <?php echo $form->textField($model,'user_email',array('class'=>'textbox','style'=>'width:300px;','value'=>$record['user_email'])); ?>
                            </div>
                        </div>
                    
                        <div class="clearfix"></div>
                        
                        <div class="field-content-44">
                            <div class="login_field-content-44-left login">
                            	<label>First name:</label>
                            </div>
                            <div class="login_field-content-44-right left-content-fld">
                                <?php echo $form->textField($model,'user_fname',array('class'=>'textbox','style'=>'width:300px;','value'=>$record['user_fname'])); ?>
                            </div>
                        </div>
                    
                        <div class="clearfix"></div>
                        
                        <div class="field-content-44">
                            <div class="login_field-content-44-left login">
                            	<label>Last name:</label>
                            </div>
                            <div class="login_field-content-44-right left-content-fld">
                                <?php echo $form->textField($model,'user_lname',array('class'=>'textbox','style'=>'width:300px;','value'=>$record['user_lname'])); ?>
                            </div>
                        </div>
                    
                        <div class="clearfix"></div>
                        
                        <div class="field-content-44">
                            <div class="login_field-content-44-left login">
                            	<label>VAT No:</label>
                            </div>
                            <div class="login_field-content-44-right left-content-fld">
                                <?php echo $form->textField($model,'vat_no',array('class'=>'textbox','style'=>'width:300px;','value'=>$record['vat_no'])); ?>
                            </div>
                        </div>
                    
                        <div class="clearfix"></div>
                        
                        <div class="field-content-44">
                            <div class="login_field-content-44-left login">
                            	<label>Company Name:</label>
                            </div>
                            <div class="login_field-content-44-right left-content-fld">
                                <?php echo $form->textField($model,'company',array('class'=>'textbox','style'=>'width:300px;','value'=>$record['company'])); ?>
                            </div>
                        </div>
                    
                        <div class="clearfix"></div>
                        
                        <div class="field-content-44">
                            <div class="login_field-content-44-left login">
                            	<label>Address:</label>
                            </div>
                            <div class="login_field-content-44-right left-content-fld">
                                <?php echo $form->textField($model,'address',array('class'=>'textbox','style'=>'width:300px;','value'=>$record['address'])); ?>
                            </div>
                        </div>
                    
                        <div class="clearfix"></div>
                        
                        <div class="field-content-44">
                            <div class="login_field-content-44-left login">
                            	<label>City:</label>
                            </div>
                            <div class="login_field-content-44-right left-content-fld">
                                <?php echo $form->textField($model,'city',array('class'=>'textbox','style'=>'width:300px;','value'=>$record['city'])); ?>
                            </div>
                        </div>
                    
                        <div class="clearfix"></div>
                        
                        <div class="field-content-44">
                            <div class="login_field-content-44-left login">
                            	<label>Postal Code:</label>
                            </div>
                            <div class="login_field-content-44-right left-content-fld">
                                <?php echo $form->textField($model,'postal_code',array('class'=>'textbox','style'=>'width:300px;','value'=>$record['postal_code'])); ?>
                            </div>
                        </div>
                    
                        <div class="clearfix"></div>
                        
                        <div class="field-content-44">
                            <div class="login_field-content-44-left login">
                            	<label>Country:</label>
                            </div>
                            <div class="login_field-content-44-right left-content-fld">
                                <?php echo $form->textField($model,'country',array('class'=>'textbox','style'=>'width:300px;','value'=>$record['country'])); ?>
                            </div>
                        </div>
                    
                        <div class="clearfix"></div>
                        
                        <div class="field-content-44">
                            <div class="login_field-content-44-left login">&nbsp;</div>
                            <div class="login_field-content-44-right left-content-fld">
                                <input type="submit" value="Submit" class="btn btn-large btn-info" />
                                <input type="hidden" name="MarketingOffer[campaign_offer_id]" value="<?php echo $record['campaign_offer_id'] ?>" />
                                <input type="hidden" name="MarketingOffer[offer_guid]" value="<?php echo $record['campaign_offer_guid'] ?>" />
                            </div>
                        </div>
                    
                        <div class="clearfix"></div>
								
						<?php $this->endWidget(); ?>
                            
						</div>
					
                    </div>
                        
					<?php } else { ?>
                        
                        <div class="alert alert-error">
                        	Autorization required
                        </div>
                            
                    <?php } ?>
                    
				</div>		
                    
                <?php } else { ?>
                    
				<div class="tab_container">
                    	
                	<?php echo $message; ?>
                    <br /><br /><br /><br />
                    <input type="button" value="Continue" class="button large green" onclick="window.location.href='https://panel.cuecow.com/index.php/campaignOffer/index/key/Aew12KjyGG'" />
                    <br /><br />
                    &nbsp;
				</div>
                    
                <?php } ?>
                    
			</div>	
		</div>
        	 	
	</div>
</div>