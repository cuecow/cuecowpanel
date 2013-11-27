<div class="span6">
            
    <div class="accordion-inner" style="border:none; margin-top:0px;">
        
        <?php if(isset($_POST['User'])){ ?>
        
        <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <? echo $form->errorSummary($model); ?>
        </div>

        <?php } ?>
        
        <?php if($model->username) { ?>
        <div class="field-content-44">
            <div class="login_field-content-44-left login"><label>Username:</label></div>
            <div class="login_field-content-44-right left-content-fld">
                <?php echo $form->textField($model,'username',array('class'=>'small textbox','style'=>'width:300px;', 'readonly'=>'readonly')); ?>
            </div>
        </div>
    
        <div class="clearfix"></div>
        <?php } ?>
        
        <?php if($model->email) { ?>
        <div class="field-content-44">
            <div class="login_field-content-44-left login"><label>Email:</label></div>
            <div class="login_field-content-44-right left-content-fld">
                <?php echo $form->textField($model,'email',array('class'=>'small textbox','style'=>'width:300px;', 'readonly'=>'readonly')); ?>
            </div>
        </div>
    
        <div class="clearfix"></div>
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

        <?php //$company_list = User::model()->GetComapnies(); if(count($company_list) == 0) { ?>
        
         <div class="field-content-44">
            <div class="login_field-content-44-left login"><label>Company:</label></div>
            <div class="login_field-content-44-right left-content-fld">
                <?php echo $form->textField($model,'company',array('class'=>'small textbox','value'=>$_POST['User']['company'],'style'=>'width:300px;')); ?> 
            </div>
        </div>
    
        <div class="clearfix"></div>
        
        <?php //} else {  ?>
        <!--
        <div class="field-content-44">
            <div class="login_field-content-44-left login"><label>Company:</label></div>
            <div class="login_field-content-44-right left-content-fld">
                <?php //echo $form->dropDownList($model,'company',$company_list,array('style'=>'width:300px;')); ?>
            </div>
        </div>
    
        <div class="clearfix"></div>-->
        
        <?php //} ?>
        
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
        
        <?php if($model->status) { ?>
        <div class="field-content-44">
            <div class="login_field-content-44-left login"><label>Account Status:</label></div>
            <div class="login_field-content-44-right left-content-fld">
                <?php echo $form->textField($model,'status',array('class'=>'small textbox','style'=>'width:300px;', 'readonly'=>'readonly')); ?>
            </div>
        </div>
    
        <div class="clearfix"></div>
        <?php } ?>
        
        <?php if($model->subscriptionType) { ?>
        <div class="field-content-44">
            <div class="login_field-content-44-left login"><label>Subscription Type:</label></div>
            <div class="login_field-content-44-right left-content-fld">
            
            <?php if(Yii::app()->user->role == 'admin') { ?>
                <?php echo $form->dropDownList($model,'subscriptionType',$subscription_array,array('style'=>'width:300px;')); ?>
            <?php } else { ?>
            	<?php echo $form->textField($model,'subscriptionType',array('style'=>'width:300px;','readonly'=>'readonly')); ?>
            <?php } ?>
            
            </div>
        </div>
    
        <div class="clearfix"></div>
        <?php } ?>
        
        <?php if($model->subscriptionStatus) { ?>
        <div class="field-content-44">
            <div class="login_field-content-44-left login"><label>Subscription Status:</label></div>
            <div class="login_field-content-44-right left-content-fld">
                <?php echo $form->textField($model,'subscriptionStatus',array('class'=>'small textbox','style'=>'width:300px;', 'readonly'=>'readonly')); ?>
            </div>
        </div>
    
        <div class="clearfix"></div>
        <?php } ?>
        
        <?php if(isset($model->subscriptionValidTo)) { ?>
        <div class="field-content-44">
            <div class="login_field-content-44-left login"><label>Subscription Valid to:</label></div>
            <div class="login_field-content-44-right left-content-fld">
            	<?php if(Yii::app()->user->role == 'admin') { ?>
                	<?php echo $form->textField($model,'subscriptionValidTo',array('class'=>'datepicker input-cnt-44-two hasDatepicker')); ?> (yyyy-mm-dd)
                <?php } else { ?>
                	<?php echo $form->textField($model,'subscriptionValidTo',array('class'=>'datepicker input-cnt-44-two hasDatepicker','readonly'=>'readonly')); ?>
                <?php } ?>
            </div>
        </div>
    
        <div class="clearfix"></div>
        <?php } ?>

        <div class="field-content-44">
            <div class="login_field-content-44-left login">
                <label>Monthly subscription fee excl. VAT:</label>
            </div>
            <div class="login_field-content-44-right left-content-fld">
            <?php if(Yii::app()->user->role == 'admin') { ?>
            	<?php echo $form->textField($model,'next_payment',array('class'=>'small textbox','style'=>'width:50px;')); ?> DKK
            <?php } else { ?>
            	<?php echo $form->textField($model,'next_payment',array('class'=>'small textbox','style'=>'width:50px;','readonly'=>'readonly')); ?> DKK
            <?php } ?>
            </div>
        </div>
    
        <div class="clearfix"></div>
        
        <?php
        
		$tax = $model->next_payment*0.25;
		$amount = $model->next_payment + $tax;
		
        ?>
        
        <div class="field-content-44">
            <div class="login_field-content-44-left login">
                <label>Monthly subscription fee incl. VAT:</label>
            </div>
            <div class="login_field-content-44-right left-content-fld">
            
            	<input type="text" name="payment_with_tax" class="small textbox" style="width:50px;" readonly="readonly" value="<?php echo $amount; ?>" /> DKK
                
            </div>
        </div>
    
        <div class="clearfix"></div>
        
        <div class="field-content-44">
            
            <div class="login_field-content-44-left login">&nbsp;</div>
            <div class="login_field-content-44-right left-content-fld">
                <input type="submit" value="Update" class="btn btn-large btn-info" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php if($model->status == 'active') { ?>
                	<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/profile/view/editaccount/act/del<?php if($_REQUEST['view'] != 'editaccount') echo '/user/'.$_REQUEST['user_id']; ?>"><input type="button" value="Close account" class="btn btn-large btn-danger" /></a>
                <?php } else if(Yii::app()->user->role == 'admin') { ?>
                	<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/profile/view/editaccount/act/active<?php if($_REQUEST['view'] != 'editaccount') echo '/user/'.$_REQUEST['user_id']; ?>"><input type="button" value="Open account" class="btn btn-large btn-success" /></a>
                <?php } ?>
                <input type="hidden" name="edit" value="edit" />
            </div>
            
        </div>
    
        <div class="clearfix"></div>

    </div>
    
</div>
