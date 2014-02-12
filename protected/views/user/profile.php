<div class="container container-top">
	<div class="row-fluid">
    
        <ul class="nav nav-pills">
        
            <li <?php if($_REQUEST['view'] == '' || $_REQUEST['view'] == 'password') echo 'class="active"'; ?>><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/profile/view/password"><?php echo PageTitles::model()->SinglePageTitle('/user/profile','password'); ?></a></li>   
            
            <li <?php if($_REQUEST['view'] == 'email') echo 'class="active"'; ?>><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/profile/view/email"><?php echo PageTitles::model()->SinglePageTitle('/user/profile','email'); ?></a></li>
            
            <li <?php if($_REQUEST['view'] == 'editaccount') echo 'class="active"'; ?>><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/profile/view/editaccount"><?php echo PageTitles::model()->SinglePageTitle('/user/profile','editaccount'); ?></a></li> 
            
            <li <?php if($_REQUEST['view'] == 'changesubscription') echo 'class="active"'; ?>><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/profile/view/changesubscription"><?php echo PageTitles::model()->SinglePageTitle('/user/profile','changesubscription'); ?></a></li>
            
            <li <?php if($_REQUEST['view'] == 'medias') echo 'class="active"'; ?>><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/profile/view/medias"><?php echo PageTitles::model()->SinglePageTitle('/user/profile','medias'); ?></a></li> 
            
            <li <?php if($_REQUEST['view'] == 'selwall') echo 'class="active"'; ?>><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/profile/view/selwall"><?php echo PageTitles::model()->SinglePageTitle('/user/selwall','selwall'); ?></a></li> 
            
            <li <?php if($_REQUEST['view'] == 'accountingsetup') echo 'class="active"'; ?>><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/profile/view/accountingsetup"><?php echo PageTitles::model()->SinglePageTitle('/user/profile','accountingsetup'); ?></a></li>
            
            <li <?php if($_REQUEST['view'] == 'card') echo 'class="active"'; ?>><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/changecard/view/card"><?php echo PageTitles::model()->SinglePageTitle('/user/changecard','card'); ?></a></li>
            
            <?php
					
			$CheckTransaction = AccountForm::model()->GetUsersAllTransaction();
			
			if(count($CheckTransaction))
			{
			
			?>
            <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/invoice">Invoice Detail</a></li>
			
			<?php	
			
			}
			
			?>
                    
        </ul>
        
		<? $form=$this->beginWidget('CActiveForm', array('action'=>Yii::app()->request->baseUrl.'/index.php/user/profile/view/'.$view_val,'id'=>'location-form','htmlOptions'=>array('class'=>'styled'),'enableAjaxValidation'=>true,'focus'=>array($model,'fburl'),)); ?>
										
		<?php if($view_val=='password' || $view_val == '') { ?>
			
        	<?php if(isset($_POST['User']) && $validate>0){ ?>
                            
            	<div class="alert alert-error">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <? echo $form->errorSummary($model); ?>
                </div>
                                            
            <?php } if($updated) { ?>
                
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Your Password updated successfully.
                </div>
                                    
            <?php } 
                                                        
			$pass_value	= ($updated) ? '' : $_POST['User']['password'];
			$npass_value= ($updated) ? '' : $_POST['User']['npassword'];
			$cpass_value= ($updated) ? '' : $_POST['User']['cpassword'];
			
			?>
			
            <div class="field-content-44">
                <div class="profile_field-content-44-left"><label>Current Password:</label></div>
                <div class="profile_field-content-44-right left-content-fld">
                    <?php echo $form->passwordField($model,'password',array('value'=>$pass_value,'style'=>'width:300px;')); ?>
                </div>
            </div>
                
            <div class="clearfix"></div>
            
            <div class="field-content-44">
                <div class="profile_field-content-44-left"><label>New Password:</label></div>
                <div class="profile_field-content-44-right left-content-fld">
                    <?php echo $form->passwordField($model,'npassword',array('value'=>$npass_value,'style'=>'width:300px;')); ?>
                </div>
            </div>
                            
            <div class="clearfix"></div>
            
            <div class="field-content-44">
                <div class="profile_field-content-44-left"><label>Confirm Password:</label></div>
                <div class="profile_field-content-44-right left-content-fld">
                    <?php echo $form->passwordField($model,'cpassword',array('value'=>$cpass_value,'style'=>'width:300px;')); ?>
                </div>
            </div>
                
            <div class="clearfix"></div>
                        
            <div class="field-content-44">
                <div class="profile_field-content-44-left">&nbsp;</div>
                <div class="profile_field-content-44-right left-content-fld">
                    <input type="hidden" name="change" value="changepassword" />
                    <input type="submit" value="Change Password" class="btn" />
                </div>
            </div>
                
            <div class="clearfix"></div>
            
            <?php } else if($view_val=='email') { ?>
											
			<?php if(isset($_POST['User']) && $validate>0){ ?>
                
                <div class="alert alert-error">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <? echo $form->errorSummary($model); ?>
                </div>
                                
            <?php } if($updated) { ?>
                
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Verification Email sent to your new email address. Please check that.
                </div>
					
				<?php } ?>
                
                <div class="field-content-44">
                    <div class="profile_field-content-44-left"><label>New Email:</label></div>
                    <div class="profile_field-content-44-right left-content-fld">
                        <?php echo $form->textField($model,'temp_email',array('style'=>'width:300px;','value'=>$_POST['User']['email'])); ?>
                    </div>
                </div>
                    
                <div class="clearfix"></div>
                
                <div class="field-content-44">
                    <div class="profile_field-content-44-left"><label>Current Password:</label></div>
                    <div class="profile_field-content-44-right left-content-fld">
                        <?php echo $form->passwordField($model,'password',array('style'=>'width:300px;','value'=>$_POST['User']['password'])); ?>
                    </div>
                </div>
                            
                <div class="clearfix"></div>
                
                <div class="field-content-44">
                    <div class="profile_field-content-44-left">&nbsp;</div>
                    <div class="profile_field-content-44-right left-content-fld">
                        <input type="hidden" name="change" value="email" />
                        <input type="submit" value="Change Email" class="btn" />
                    </div>
                </div>
                    
                <div class="clearfix"></div>
                
                <?php } else if($view_val == 'editaccount') { ?>
                
                <? $form = $this->beginWidget('CActiveForm', array('action'=>Yii::app()->request->baseUrl.'/index.php/user/updateuser/view/Edit/user_id/'.$_REQUEST['user_id'],'id'=>'location-form','htmlOptions'=>array('class'=>'styled'),'enableAjaxValidation'=>true,)); ?>

                	<?php include('edituser.php'); ?>
                
				<?php $this->endWidget(); ?>                
                		
				<?php } else if($view_val == 'medias') { ?>
				
				<?php
                
                $SocialCheck = AccessToken::model()->CheckAuth();
                
				?>
				
                <div class="field-content-44">
                    <div class="profile_field-content-44-left">Facebook :</div>
                    <div class="profile_field-content-44-right left-content-fld">
                    	
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/authmeida/auth/facebook" class="btn btn-large btn-facebook"><i class="icon-facebook"></i> | Facebook &nbsp;&nbsp;&nbsp;&nbsp;</a>
                        
						<?php 
                    
						if(empty($SocialCheck[0]['fbtoken'])) 
							echo ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Press this button to authenticate us to fetch/post data from your facebook account';
						else
								echo ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You have authenticated us. <br /><br />If you change the settings of this application in your facebook account then please press this button again, otherwise we will not be able to fetch/post data.';
						
						?>
                        
                    </div>
                </div>
                    
                <div class="clearfix"></div>
                <div class="field-content-44">&nbsp;</div>
                
                <div class="field-content-44">
                    <div class="profile_field-content-44-left">Four Square :</div>
                    <div class="profile_field-content-44-right left-content-fld">
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/authmeida/auth/foursquare" class="btn btn-large btn-info"><i class="icon-foursquare"></i> | Foursquare</a>
                        <?php
                
						if(empty($SocialCheck[0]['fstoken'])) 
							echo ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Press this button to authenticate us to fetch/post data from your foursquare account';
						else
							echo ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You have authenticated us. <br /><br />If you change the settings of this application in your foursquare account then please press this button again, otherwise we will not be able to fetch/post data.';
		
		                ?>
                    </div>
                </div>
                    
                <div class="clearfix"></div>
                <div class="field-content-44">&nbsp;</div>
                
                <div class="field-content-44">
                    <div class="profile_field-content-44-left">Twitter :</div>
                    <div class="profile_field-content-44-right left-content-fld">
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/authmeida/auth/twitter" class="btn btn-large btn-info"><i class="icon-twitter"></i> | Twitter &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
                        <?php
                
						if(empty($SocialCheck[0]['twitter_oauth_token']) && empty($SocialCheck[0]['twitter_oauth_token_secret'])) 
							echo ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Press this button to authenticate us to tweet from your account';
						else
							echo ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You have authenticated us. <br /><br />If you change the settings of this application in your twitter account then please press this button again, otherwise we will not be able to tweet.';
		
		                ?>
                    </div>
                </div>
                    
                <div class="clearfix"></div>
                               
				<?php } else if( $view_val == 'accountingsetup' ) { ?>
							
				<?php if(isset($_POST['User']) && $validate>0){ ?>
                
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <? echo $form->errorSummary($model); ?>
                    </div>
                                
                <?php } if($updated == 1) { ?>
                    
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        Account Email has been changed successfully
                    </div>
            
                <?php } else if($updated == 2) { ?>
                    
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        Invoice has been sent to <?php echo $GetUser[0]['accounting_email']; ?>
                    </div>
                    
                <?php } else if($updated == -1) { ?>
                    
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        This user dont have any invoice to send
                    </div>
                    
                <?php } ?>
                
                <div class="field-content-44">
                    <div class="profile_field-content-44-left"><label>Accounting Email:</label></div>
                    <div class="profile_field-content-44-right left-content-fld">
                        <?php echo $form->textField($model,'accounting_email',array('style'=>'width:300px;','value'=>$GetUser[0]['accounting_email'])); ?>
                    </div>
                </div>
                    
                <div class="clearfix"></div>
                
                <div class="field-content-44">
                    <div class="profile_field-content-44-left">&nbsp;</div>
                    <div class="profile_field-content-44-right left-content-fld">
                        <input type="hidden" name="change" value="accountingsetup" />
                        <input type="submit" value="Save" class="btn" />
                        <a href="<?=Yii::app()->request->baseUrl?>/index.php/user/profile/view/<?=$view_val?>/subact/sendinvoice"><input type="button" value="Send latest invoice" class="btn btn-info" /></a>
                    </div>
                </div>
                    
                <div class="clearfix"></div>
                
                    
				<?php } else if($view_val=='changesubscription') { 
				
				$subscriptions = SubsriptionType::model()->GetAllRec(); ?>
                
                <?php if(isset($_REQUEST['venues']) || isset($_REQUEST['camapigns']) || isset($_REQUEST['walls'])) { ?>
                <div class="alert alert-error">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    
                    <?php 
					
					if($_REQUEST['venues']!='') 
						echo 'Only '.$_REQUEST['venues'].' Venues allowed for this subscription.<br />'; 
					if($_REQUEST['camapigns']!='') 
						echo 'Only '.$_REQUEST['camapigns'].' Campaigns allowed for this subscription.<br />'; 
					if($_REQUEST['walls']!='') 
						echo 'Only '.$_REQUEST['walls'].' Walls allowed for this subscription.<br />'; 
						
					?>
                    
                    
                </div>
                <?php } ?>
                
                <ul class="thumbnails">
                	<?php 
					
					$subscription_info = SubsriptionType::model()->GetSpecificRecbyName($GetUser[0]['subscriptionType']);
					$subscription_id = $subscription_info[0]['subscription_id']; 
					
					if(count($subscriptions)) { foreach($subscriptions as $key => $value) { ?>
  					<li class="span3">
    					<div class="thumbnail">
      						<table width="80%" class="table table-striped">
                            <tr><td style="border-top:none;"><center><h4><?php echo $value['name']; ?></h4></center></td></tr>
                            <tr>
                            	<td class="inner-td-profile-page">
                                	<center>
                                    	<sup>kr</sup> <?php if($value['price'] == 0) echo 'Free'; else echo $value['price']; ?> 
                                        <span style="font-size:12px; color:#999999;">/month</span>
                                    </center>
                                </td>
                            </tr>
                            <tr>
                            	<td style="height:170px;">
                                    <?php echo $value['description']; ?>
                                </td>
                            </tr>
                            <tr>
                            	<td>
                                	<center>
                                    <?php if($subscription_id != $value['subscription_id'] ) { ?>
                                    	<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/<?php if($subscription_id > $value['subscription_id']) echo 'downgrade'; else echo 'upgrade'; ?>/id/<?php echo $value['subscription_id']; ?>"><input type="button" value="<?php if($subscription_id > $value['subscription_id']) echo 'Downgrade'; else echo 'Upgrade'; ?>" class="btn btn-info btn-large"  /></a>
                                    <?php } else { ?>
                                    	<input type="button" value="Active" class="btn btn-large" disabled="disabled"  />
                                    <?php } ?>
                                    </center>
								</td>
                            </tr>
                            </table>
    					</div>
  					</li>
                    <?php } } ?>
				</ul>
                                
                <?php } else if( $view_val == 'selwall' ) { 
				
				$UserPages = Fbpages::model()->FetchUserPages();
				
				
				?>
                
                <?php if( isset(Yii::app()->user->errroMsg) && Yii::app()->user->errroMsg != '' ) { ?>
                <div class="alert alert-error">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?php echo Yii::app()->user->errroMsg; ?>
                    <?php Yii::app()->user->setState('errorMsg', '');	 ?>
                </div>
                <?php } ?>
                
                <?php if($UserPages) { ?>
                
                <form name="sel_fb_wall" method="post" action="">
                
                <table class="table table-striped" width="100%">
                <tr>
                	<th width="70%">Facebook wall</th>
                    <th width="20%">Status</th>
                    <th width="10%"><input type="checkbox" id="check" name="selall" value="yes" onclick="CheckUncheckAll(this.checked);" /></th>
                </tr>
                <?php foreach($UserPages as $key=>$value) { if( $value['page_name'] != '' ) { ?>
                <tr>
                	<td><?php echo $value['page_name']; ?></td>
                    <td>
						<?php 
						
						if( $value['status'] == 'active' )
						{
							echo '<span class="badge badge-success">&nbsp;&nbsp;'.
								ucfirst($value['status'])
							.'&nbsp;&nbsp;</span>'; 
						}
						else
						{
							echo '<span class="badge badge-important">'.
								ucfirst($value['status']).
							'</span>'; 
						}
						
						?>
                    </td>
                    <td><input type="checkbox" name="wall[]" value="<?php echo $value['page_id']; ?>" /></td>
                </tr>
                <?php } } ?>
                </table>
                
                <div class="outter-table-profile-pg">
                	<input type="submit" class="btn btn-info" name="selwallbtn" value="Activate" />
                </div>
                
                </form>
                
                <script>
				
				function CheckUncheckAll(val)
				{
					if( val == true )
						$('input:checkbox').attr('checked','checked');
					else if( val == false )
						$('input:checkbox').removeAttr('checked');
				}
				
				</script>
                
                <?php } else { ?>
				
                <div class="alert alert-error">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    No Pages found
                </div>
                
				<?php } ?>
                
                <?php } ?>
											
				<?php $this->endWidget(); ?>
	</div>
</div>