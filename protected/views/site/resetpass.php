<div id="login-wrapper">

	<!-- Display the Logo -->
	<div id="logo"><h1>Cuecow</h1></div>
	
	<div class="span6 login_div">
    	<div class="accordion" id="accordion1">
			
		<?php $form=$this->beginWidget('CActiveForm', array('htmlOptions'=>array('class'=>'styled'),'enableClientValidation'=>true,'clientOptions'=>array('validateOnSubmit'=>true),)); ?>
		
        <div class="accordion-group">
        	<div class="accordion-heading">
            	
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne" title="Click to open/close">Reset your password on Cuecow</a>
				
			</div>
                
            <div id="collapseOne" class="accordion-body collapse in">
            
            	<div class="accordion-inner">
                		
					<?php if(isset($_POST['User'])){ ?>
                    	<div class="alert alert-error">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                             <? echo $form->errorSummary($model); ?>
                        </div>
					<?php } ?>
				
					<?php if($_REQUEST['send']=='failed' || $_REQUEST['send']=='no'){ ?>
                        <div class="alert alert-error">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <?php echo ($_REQUEST['send']=='no') ? 'Password could not sent. Try again' : 'Email is not registered yet.'; ?>
                        </div>
                    <?php } ?>
				
					<?php if($_REQUEST['send']=='yes'){ ?>
                                
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            Password sent to your registered email.
                        </div>
                                
                    <?php } ?>
		
                        
                    <div class="field-content-44">
                        <div class="login_field-content-44-left login"><label>Enter your Email:</label></div>
                        <div class="login_field-content-44-right left-content-fld">
                            <?php echo $form->textField($model,'email',array('style'=>'width:300px;')); ?>
                        </div>
                    </div>
                    
                    <div class="clearfix"></div>
                    
                    <div class="field-content-44" style="margin-top:10px;">
                    
                        <div class="login_field-content-44-left">
                            &nbsp;
                        </div>
                        
                        <div class="login_field-content-44-right left-content-fld no-left-border">
                            <button class="btn btn-info" type="submit">Send Password</button>
                            &nbsp; &nbsp; &nbsp; 
                            <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/site/login"><button class="btn" type="button">Back to Login?</button></a>
                        </div>
                    </div>
                        
                    <div class="clearfix"></div>
                    
                </div>
    	        
			</div>    
				
		<?php $this->endWidget(); ?>
			
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
