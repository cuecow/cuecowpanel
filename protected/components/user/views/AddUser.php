<? $form=$this->beginWidget('CActiveForm', array('action'=>Yii::app()->request->baseUrl.'/index.php/user/usermanagement/view/Add','id'=>'location-form','htmlOptions'=>array('class'=>'styled'),'enableAjaxValidation'=>true,)); ?>
				
<div class="container container-top">
	<div class="row-fluid">    
    
		<div class="span6">
    		<div class="accordion" id="accordion1">
            
	            <div class="accordion-group">        	
                	<div id="collapseOne" class="accordion-body collapse in">
                    
                		<div class="accordion-inner">
                    		
                            <?php if(isset($_POST['User']) && $validate>0){ ?>

                            <div class="alert alert-error">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <? echo $form->errorSummary($model); ?>
                            </div>
                            
                            <?php } ?>

                    		<div class="field-content-44">
                        		<div class="login_field-content-44-left login"><label>First Name:</label></div>
                            	<div class="login_field-content-44-right left-content-fld">
                            		<?php echo $form->textField($model,'fname',array('class'=>'small textbox','value'=>$_POST['User']['fname'],'style'=>'width:300px;')); ?>
                            	</div>
							</div>
                        
                        	<div class="clearfix"></div>
                            
                            <div class="field-content-44">
                        		<div class="login_field-content-44-left login"><label>Last Name:</label></div>
                            	<div class="login_field-content-44-right left-content-fld">
                            		<?php echo $form->textField($model,'lname',array('class'=>'small textbox','value'=>$_POST['User']['lname'],'style'=>'width:300px;')); ?>
                            	</div>
							</div>
                        
                        	<div class="clearfix"></div>
                            
                            <div class="field-content-44">
                        		<div class="login_field-content-44-left login"><label>Address:</label></div>
                            	<div class="login_field-content-44-right left-content-fld">
	                            	<?php echo $form->textField($model,'address',array('class'=>'small textbox','value'=>$_POST['User']['address'],'style'=>'width:300px;')); ?>
                            	</div>
							</div>
                        
                        	<div class="clearfix"></div>
                            
                            <?php 
							
							$company_list = User::model()->GetComapnies(); 
							
							if(count($company_list) == 0) { ?>
                            
                            <div class="field-content-44">
                        		<div class="login_field-content-44-left login"><label>Company:</label></div>
                            	<div class="login_field-content-44-right left-content-fld">
	                            	<?php echo $form->textField($model,'company',array('class'=>'small textbox','value'=>$_POST['User']['company'],'style'=>'width:300px;')); ?> 
                            	</div>
							</div>
                        
                        	<div class="clearfix"></div>
                        	
                            <?php } else {  ?>
                             
                            <div class="field-content-44">
                        		<div class="login_field-content-44-left login"><label>Company:</label></div>
                            	<div class="login_field-content-44-right left-content-fld">
                                	<?php echo $form->dropDownList($model,'company',$company_list,array('style'=>'width:300px;')); ?>
                            	</div>
							</div>
                        
                        	<div class="clearfix"></div>
                            
                            <?php } ?>
                             
                            <div class="field-content-44">
                        		<div class="login_field-content-44-left login"><label>City:</label></div>
                            	<div class="login_field-content-44-right left-content-fld">
	                            	<?php echo $form->textField($model,'city',array('class'=>'small textbox','value'=>$_POST['User']['city'],'style'=>'width:300px;')); ?>
                            	</div>
							</div>
                        
                        	<div class="clearfix"></div>
                            
                            <div class="field-content-44">
                        		<div class="login_field-content-44-left login"><label>Postal Code:</label></div>
                            	<div class="login_field-content-44-right left-content-fld">
	                            	<?php echo $form->textField($model,'postal_code',array('class'=>'small textbox','value'=>$_POST['User']['postal_code'],'style'=>'width:300px;')); ?>
                            	</div>
							</div>
                        
                        	<div class="clearfix"></div>
                            
                            <div class="field-content-44">
                        		<div class="login_field-content-44-left login"><label>Country:</label></div>
                            	<div class="login_field-content-44-right left-content-fld">
	                            	<?php echo $form->textField($model,'country',array('class'=>'small textbox','value'=>$_POST['User']['country'],'style'=>'width:300px;')); ?>
                            	</div>
							</div>
                        
                        	<div class="clearfix"></div>
                            
                            <div class="field-content-44">
                        		<div class="login_field-content-44-left login"><label>Phone:</label></div>
                            	<div class="login_field-content-44-right left-content-fld">
	                            	<?php echo $form->textField($model,'phone',array('class'=>'small textbox','value'=>$_POST['User']['phone'],'style'=>'width:300px;')); ?>
                            	</div>
							</div>
                        
                        	<div class="clearfix"></div>
                            
                            <?php $time_zone = User::model()->GetTimeZone();  ?>
                            
                            <div class="field-content-44">
                        		<div class="login_field-content-44-left login"><label>Time Zone:</label></div>
                            	<div class="login_field-content-44-right left-content-fld">
	                            	<?php echo $form->dropDownList($model,'timestamp',$time_zone,array('class'=>'chosen','style'=>'width:300px;')); ?>
                            	</div>
							</div>
                        
                        	<div class="clearfix"></div>
                            
                            <div class="field-content-44">
                        		<div class="login_field-content-44-left login"><label>Email:</label></div>
                            	<div class="login_field-content-44-right left-content-fld">
	                            	<?php echo $form->textField($model,'email',array('class'=>'small textbox','value'=>$_POST['User']['email'],'style'=>'width:300px;')); ?>
                            	</div>
							</div>
                        
                        	<div class="clearfix"></div>
                            
                            <div class="field-content-44">
                        		<div class="login_field-content-44-left login"><label>Password:</label></div>
                            	<div class="login_field-content-44-right left-content-fld">
	                            	<?php echo $form->passwordField($model,'password',array('class'=>'small textbox','style'=>'width:300px;')); ?>
                            	</div>
							</div>
                        
                        	<div class="clearfix"></div>
                            
                            <div class="field-content-44">
                            	
                                <div class="login_field-content-44-left login">&nbsp;</div>
                            	<div class="login_field-content-44-right left-content-fld">
	                        		<input type="submit" value="Submit" class="btn btn-large btn-info" />
                                
    	                            <?php echo $form->hiddenField($model,'admin_id',array('value'=>Yii::app()->user->user_id)); ?>
                                </div>
                                
							</div>
                        
                        	<div class="clearfix"></div>
                            
						</div>
			
            		</div>
				</div>
			</div> 
		</div>
        
	</div>                    
</div>
                    
<?php $this->endWidget(); ?>
			