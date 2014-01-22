
<div id="login-wrapper">

	<div id="logo"><h1>Cue Cow</h1></div>
	
    <div class="login_div">
    	<div class="accordion" id="accordion1">
        	<?php $form=$this->beginWidget('CActiveForm', array('htmlOptions'=>array('class'=>'styled'),'enableClientValidation'=>true,'clientOptions'=>array('validateOnSubmit'=>true),)); ?>
            
        	<div class="accordion-group">
            	
                <div class="accordion-heading">
                	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne" title="Click to open/close">Login to Cuecow</a>
				</div>
                             
                
                <div id="collapseOne" class="accordion-body collapse in">
                	<div class="accordion-inner">
                    	<?php if(!is_numeric($facebook)) { ?>
                
						<?php if(isset($_POST['LoginForm'])){ ?>
                        <div class="alert alert-error">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <? echo $form->errorSummary($model); ?>
                        </div>
                        <?php } ?>
                        
                    	<div class="field-content-44">
                        	<div class="login_field-content-44-left login"><label>Email or Username:</label></div>
                            <div class="login_field-content-44-right left-content-fld">
                            	<?php echo $form->textField($model,'email',array('style'=>'width:300px;')); ?>
                            </div>
						</div>
                        
                        <div class="clearfix"></div>
                        
                        <div class="field-content-44">
                            <div class="login_field-content-44-left"><label>Password:</label></div>
                            
                            <div class="login_field-content-44-right left-content-fld">
                            	<?php echo $form->passwordField($model,'password',array('style'=>'width:300px;')); ?>
                            </div>
						</div>
                        
                        <div class="clearfix"></div>
                        
                        <div class="field-content-44" style="margin-top:10px;">
                        
                           <!-- <div class="login_field-content-44-left">
                            	&nbsp;
                            </div> -->
                            
                            <div class="login_field-content-44-right left-content-fld no-left-border">
                            	
                                <button class="btn btn-large" type="submit">Login</button>
                                
                                &nbsp;&nbsp;&nbsp;
                                
                                <a href="<?php echo $fbloginUrl; ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/topfb.png" alt="Login" /></a>	
                                                                
                            </div>
						</div>
                        
                        <br /><br /><br />
                        
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/site/resetpass">Forgot Password?</a>
                               
                        <div class="clearfix"></div>
                        
					</div>
				</div>
                
                <?php } else { ?>		
			
				<?php $contents = json_decode(file_get_contents('http://graph.facebook.com/'.$facebook));  ?>
			
				<?php $form=$this->beginWidget('CActiveForm', array('htmlOptions'=>array('class'=>'styled'),'enableClientValidation'=>true,'clientOptions'=>array('validateOnSubmit'=>true),)); ?>
                <label for="username">
                    <span>Welcome back, </span> <br /><br />
                    <center><img src="https://graph.facebook.com/<?php echo $facebook ?>/picture" /></center> <br /><center><strong><?php echo $contents->name ?></strong></center><br />
                </label>
                <?php echo $form->hiddenField($model,'email',array('class'=>'textbox')); ?>
                <?php echo $form->hiddenField($model,'password',array('class'=>'textbox')); ?>
                <input class="button red small" type="submit" value="Continue" />
			
				<?php } ?>
    	        
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
