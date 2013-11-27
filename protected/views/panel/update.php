
<div class="container container-top">
	<div class="row-fluid">
    
    	<div class="span6">
    		<div class="accordion" id="accordion1">
            
	            <div class="accordion-group">        	
                	<div id="collapseOne" class="accordion-body collapse in">
                    
                		<div class="accordion-inner">
						
							<?php
							
							$form=$this->beginWidget('CActiveForm', array('id'=>'subscription-form','htmlOptions'=>array('class'=>'styled'),'enableAjaxValidation'=>true,)); 
							
							if(isset($_POST['SubsriptionType']))
							{ 
							?>
                            
                            <div class="alert alert-error">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <? echo $form->errorSummary($model); ?>
                            </div>
                            	
							<? } ?>
							
                            <div class="field-content-44">
                        		<div class="login_field-content-44-left login"><label>Name:</label></div>
                            	<div class="login_field-content-44-right left-content-fld">
                            		<b><?php echo $model->name; ?></b>
                            	</div>
							</div>
                        
                        	<div class="clearfix"></div>
                            
                            <div class="field-content-44">
                        		<div class="login_field-content-44-left login"><label>Enter Price:</label></div>
                            	<div class="login_field-content-44-right left-content-fld">
                            		<?php echo $form->textField($model,'price',array('class'=>'textbox','style'=>'width:300px;')); ?>
                            	</div>
							</div>
                        
                        	<div class="clearfix"></div>
                            
                            <div class="field-content-44">
                        		<div class="login_field-content-44-left login"><label>User Limit:</label></div>
                            	<div class="login_field-content-44-right left-content-fld">
                            		<?php echo $form->textField($model,'max_num_users',array('class'=>'textbox','style'=>'width:300px;')); ?>
                            	</div>
							</div>
                        
                        	<div class="clearfix"></div>
                            
                            <div class="field-content-44">
                        		<div class="login_field-content-44-left login"><label>Venue Limit:</label></div>
                            	<div class="login_field-content-44-right left-content-fld">
                            		<?php echo $form->textField($model,'max_num_venues',array('class'=>'textbox','style'=>'width:300px;')); ?>
                            	</div>
							</div>
                        
                        	<div class="clearfix"></div>
                            
                            <div class="field-content-44">
                        		<div class="login_field-content-44-left login"><label>Campaign Limit:</label></div>
                            	<div class="login_field-content-44-right left-content-fld">
                            		<?php echo $form->textField($model,'max_num_campaigns',array('class'=>'textbox','style'=>'width:300px;')); ?>
                            	</div>
							</div>
                        
                        	<div class="clearfix"></div>
                            
                            <div class="field-content-44">
                        		<div class="login_field-content-44-left login"><label>App Limit:</label></div>
                            	<div class="login_field-content-44-right left-content-fld">
                            		<?php echo $form->textField($model,'max_num_apps',array('class'=>'textbox','style'=>'width:300px;')); ?>
                            	</div>
							</div>
                        
                        	<div class="clearfix"></div>
                            
                            <div class="field-content-44">
                        		<div class="login_field-content-44-left login"><label>Wall Limit:</label></div>
                            	<div class="login_field-content-44-right left-content-fld">
                            		<?php echo $form->textField($model,'max_num_walls',array('class'=>'textbox','style'=>'width:300px;')); ?>
                            	</div>
							</div>
                        
                        	<div class="clearfix"></div>
                            
                            <div class="field-content-44">
                        		<div class="login_field-content-44-left login">&nbsp;</div>
                            	<div class="login_field-content-44-right left-content-fld">
                            		<input type="submit" value="Submit" class="btn btn-large" />
                            	</div>
							</div>
                        
                        	<div class="clearfix"></div>
                            
                            
							<?php $this->endWidget(); ?>
						
						</div>
					</div>
				</div>		
			</div>	
		</div>
	</div>	 	
</div>