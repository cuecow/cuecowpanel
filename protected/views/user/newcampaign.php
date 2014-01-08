<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/foursquare.css" type="text/css" />

<?php include('campaign_script.php'); ?>

<form action="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/newcampaign" method="post" class="styled" enctype="multipart/form-data" onsubmit="return CheckForm(this);" name="campaign" id="create_campaign">

<div class="clearfix"></div>
<div class="container container-top">

	<?php if( $msg == 1 ){ ?>
    <div class="alert alert-error">
    	<button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo getContent('user.newcampaign.errdatemes',Yii::app()->session['language']); ?>
	</div>        
    <?php } ?>
    
    <div class="row-fluid">
	
        <?php 
                            
		date_default_timezone_set('Europe/Copenhagen');
						
		$dropdown = new Fbposts;
		$user_groups = $dropdown->PickUserNewGroup(); 

		$user_pages = $dropdown->UserPages();
		
		if($_REQUEST['camp'])
		{
			$PendingCamp = Campaign::model()->GetCampaign($_REQUEST['camp']);

			if($PendingCamp[0]['fb_posts']=='yes')
				$PendingFBPost = Campaign::model()->GetPendingFBCamp($PendingCamp[0]['campaign_id']);
			if($PendingCamp[0]['foursquare_specials']=='yes')
				$PendingFSspecials = Campaign::model()->GetPendingFSCamp($PendingCamp[0]['campaign_id']);
				
		}
						
		?>
                
        <div class="span6">
            <div class="accordion" id="accordion1">
                <div class="accordion-group">
                    <div class="accordion-heading">
                    	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne" title="Click to open/close">Campaign information</a>
                    </div>
                    
                    <div id="collapseOne" class="accordion-body collapse in">
                        <div class="accordion-inner">
                        	
                            <div class="field-content-44" id="campaign_name_error_cntnr" style="display:none;">
                            	<div class="field-content-44-left">&nbsp;</div>
                                <div class="field-content-44-right left-content-fld" id="campaign_name_error" style="color:#F00; font-style:italic;"></div>
                            </div>
                            <div class="clearfix"></div>
                            
                            <div class="field-content-44">
                                <div class="field-content-44-left">
                                    <label><?php echo getContent('user.newcampaign.campaignname',Yii::app()->session['language']); ?>:</label>
                                </div>
                                
                                <div class="field-content-44-right left-content-fld">
                                    <input class="textbox small" name="campaign_name" id="campaign_name" type="text" value="<?php if($_POST['campaign_name']) echo $_POST['campaign_name']; else echo $PendingCamp[0]['name']; ?>" />
                                </div>
                            </div>
                        	<div class="clearfix"></div>
                            
                            <div class="field-content-44">
                            	<div class="field-content-44-left"><label><?php echo getContent('user.newcampaign.desiredkpi',Yii::app()->session['language']); ?>:</label></div>
                            
	                            <div class="field-content-44-right left-content-fld">
		                            <input id="kpi" class="input-cnt-44-one" name="kpi" type="text" value="<?php if($_POST['kpi']) echo $_POST['kpi']; else echo $PendingCamp[0]['kpi']; ?>" />
        	                    </div>
                            </div>
                        	<div class="clearfix"></div>
                            
                            <div class="field-content-44" id="date_error_cntnr" style="display:none;">
                            	<div class="field-content-44-left">&nbsp;</div>
                                <div class="field-content-44-right left-content-fld" id="date_error" style="color:#F00; font-style:italic;"></div>
                            </div>
                            <div class="clearfix"></div>
                            
                            <div class="field-content-44">
                            	<div class="field-content-44-left"><label><?php echo getContent('user.newcampaign.startdateandtime',Yii::app()->session['language']); ?>:</label></div>
                            
	                            <div class="field-content-44-right left-content-fld">
                                	<input type="text" name="start_date" id="start_date" class="datepicker input-cnt-44-two" value="<?php if($_POST['start_date']) echo $_POST['start_date']; else if($PendingCamp[0]['start_date']) echo date('m/d/Y',$PendingCamp[0]['start_date']); ?>" />
                        			<input type="text" name="start_time" id="start_time" class="timepicker input-cnt-44-one" value="<?php if($_POST['start_time']) echo $_POST['start_time']; else echo $PendingCamp[0]['start_time']; ?>" />
                                </div>
                            
                            </div>
                            <input type="hidden" name="current_date" id="current_date" value="<?php echo date('m/d/Y'); ?>" />
                        	<div class="clearfix"></div>
                            
                            <div class="field-content-44">
                            	<div class="field-content-44-left"><label><?php echo getContent('user.newcampaign.enddateandtime',Yii::app()->session['language']); ?>:</label></div>
                            
	                            <div class="field-content-44-right left-content-fld">
    	                    		<input type="text" name="end_date" id="end_date" class="datepicker input-cnt-44-two" value="<?php if($_POST['end_date']) echo $_POST['end_date']; else if($PendingCamp[0]['end_date']) echo date('m/d/Y',$PendingCamp[0]['end_date']); ?>" />
			                        <input type="text" name="end_time" id="end_time" class="timepicker input-cnt-44-one" value="<?php if($_POST['end_time']) echo $_POST['end_time']; else  echo $PendingCamp[0]['end_time']; ?>" />    	
            	            
                	            </div>
                            </div>
                        	<div class="clearfix"></div>
                            
                            <div class="field-content-44" id="timezone_error_cntnr" style="display:none;">
                            	<div class="field-content-44-left">&nbsp;</div>
                                <div class="field-content-44-right left-content-fld" id="timezone_error" style="color:#F00; font-style:italic;"></div>
                            </div>
                            <div class="clearfix"></div>
                            
                            <?php 
                    
							$time_zone = User::model()->GetTimeZone();  
							$user_zone = User::model()->GetUserTimeZone();
							
							?>
                            
                            <div class="field-content-44">
                            	<div class="field-content-44-left"><label><?php echo getContent('user.newcampaign.timezone',Yii::app()->session['language']); ?>:</label></div>
                            
                           	 	<div class="field-content-44-right left-content-fld">
                                	<select name="timezone" id="timezone" style="height:30px; padding:5px; outline:none; width:250px;">
									<?php foreach($time_zone as $key=>$value) { ?>
                                    <option value="<?php echo $key; ?>" <?php if($PendingCamp[0]['timezone'] == $key ) echo 'selected="selected"'; else if($_POST['timezone'] == $key) echo 'selected'; else if($user_zone[0]['timestamp']==$key) echo 'selected'; else if($key == 33) echo 'selected'; ?>><?php echo $value; ?></option>
                                    <?php } ?>
                                	</select> 
                            	</div>
                            </div>
                        	<div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    
    	<div class="span6">
        	<div class="accordion-group">
            
            	<div class="accordion-heading">
            		<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo" title="Click to open/close"><?php echo getContent('user.newcampaign.selsocialmedia',Yii::app()->session['language']); ?></a>
            	</div>
                
                <div id="collapseTwo" class="accordion-body collapse in">
                    <div class="accordion-inner">
                        <div class="field-content-44">
                            <div class="field-content-44-left"><label><?php echo getContent('user.newcampaign.locationbased',Yii::app()->session['language']); ?>:</label></div>
                            
                            <div class="field-content-44-right field-checkbox-right">
                                <div class="checkbox-cotent-11">
                                    <label>
                                        <input id="fs_specials" class="checkbox" name="fs_specials" type="checkbox" onclick="javascript:OpenHideDiv('foursquare_specials_div',this.checked)" value="yes" <?php if($_POST['fs_specials'] == 'yes' || $PendingCamp[0]['foursquare_specials']=='yes') echo 'checked'; ?>  />
                                        <span class="social-tab-shadow"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/Foursquare.png" width="80" /></span>
                                    </label>
                                </div>
                                <div class="checkbox-cotent-11">
                                    <label>
                                        <input id="facebook_deals" class="checkbox" name="facebook_deals" type="checkbox" onclick="javascript:OpenHideDiv('facebook_places',this.checked)" value="yes" <?php if($PendingCamp[0]['facebook_deals']=='yes') echo 'checked'; ?> />
                                        <span class="social-tab-shadow"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/Fbdeals.png" width="80" /></span>
                                    </label>
                                </div>
                                <div class="checkbox-cotent-11">
                                    <label>
                                        <input id="google_places_chk" class="checkbox" name="google_places" type="checkbox" onclick="javascript:OpenHideDiv('google_places',this.checked)" value="yes" <?php if($PendingCamp[0]['google_place']=='yes') echo 'checked'; ?>  />
                                        <span class="social-tab-shadow"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/googleplaces.png" width="80" /></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    	
                        <div class="clearfix"></div>
                        
                        <div class="field-content-44 cnt-44">
                        	<div class="field-content-44-left"><label><?php echo getContent('user.newcampaign.messaging',Yii::app()->session['language']); ?>:</label></div>
                        
                        <div class="field-content-44-right field-checkbox-right">
                            <div class="checkbox-cotent-11">
                                <label>
                                    <input id="fbposts" class="checkbox" name="fbposts" type="checkbox" onclick="javascript:OpenHideDiv('facebook_campaign_post',this.checked)" value="yes" <?php if($_POST['fbposts'] == 'yes' || $PendingCamp[0]['fb_posts']=='yes') echo 'checked'; ?> />
                                    <span class="social-tab-shadow"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/Facebookposts.png" width="80" /></span>
                                </label>
                            </div>
                            <div class="checkbox-cotent-11">
                                <label>
                                    <input id="twitter" class="checkbox" name="twitter" type="checkbox" onclick="javascript:OpenHideDiv('twit_div',this.checked)" value="yes" <?php if($PendingCamp[0]['twitter']=='yes') echo 'checked'; ?> />
                                    <span class="social-tab-shadow"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/Twitter.png" width="80" /></span>
                                </label>
                            </div>
                            
                        </div>
                        </div><!-- field-content-44 -->
                    	<div class="clearfix"></div>
                    
                        <div class="field-content-44">
                        <div class="field-content-44-left"><label><?php echo getContent('user.newcampaign.boughtmedia',Yii::app()->session['language']); ?>:</label></div>
                        
                        <div class="field-content-44-right field-checkbox-right last-height-fix">
                            <div class="checkbox-cotent-11">
                                <label>
	                                <input id="FB_ads" class="checkbox" name="FB_ads" type="checkbox" onclick="javascript:OpenHideDiv('fb_ads',this.checked)" value="yes" <?php if($PendingCamp[0]['fb_ads']=='yes') echo 'checked'; ?> />
                                	<span class="social-tab-shadow"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/Fbads.png" width="80" /></span>
                                </label>
                            </div>
                            <div class="checkbox-cotent-11">
                                
                            </div>
                            <div class="checkbox-cotent-11 checkbox-cotent-11-last">
                                <label>
                                <input id="google_adwords" class="checkbox" name="google_adwords" onclick="javascript:OpenHideDiv('google_ads',this.checked)" type="checkbox" value="yes" <?php if($PendingCamp[0]['google_adwords']=='yes') echo 'checked'; ?> />
                                <span class="social-tab-shadow"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/Googleads.png" width="80" /></span>
                                </label>
                            </div>
                            
                        </div>
                        </div>
                    	<div class="clearfix"></div>
                    </div>
                </div>
        	</div>
        </div>
        
        
        <div class="clearfix"></div>
        
        <div class="accordion-group" id="facebook_places" style="margin-top:15px; display:<?php if($PendingCamp[0]['facebook_deals']=='yes') echo 'block;'; else echo 'none;'; ?>">
            
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseThree" title="Click to open/close"><?php echo getContent('user.newcampaign.fbdeals',Yii::app()->session['language']); ?></a>
            </div>
            
            <div id="collapseThree" class="accordion-body collapse in">
                <div class="accordion-inner">
                	<?php echo getContent('user.newcampaign.sorryfbdeals',Yii::app()->session['language']); ?>
                </div>
            </div>
            
		</div>
        
        <div class="clearfix"></div>
        
        <div class="accordion-group" id="facebook_places" style="margin-top:15px; display:<?php if($PendingCamp[0]['facebook_deals']=='yes') echo 'block;'; else echo 'none;'; ?>">
            
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion4" href="#collapseFour" title="Click to open/close"><?php echo getContent('user.newcampaign.fbdeals',Yii::app()->session['language']); ?></a>
            </div>
            
            <div id="collapseFour" class="accordion-body collapse in">
                <div class="accordion-inner">
                	
                </div>
            </div>
            
		</div>
        
        <div class="clearfix"></div>
        
        <div class="accordion-group" id="google_places" style="margin-top:15px; display:none;">
            
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion5" href="#collapseFive" title="Click to open/close"><?php echo getContent('user.newcampaign.googleplaces',Yii::app()->session['language']); ?></a>
            </div>
            
            <div id="collapseFive" class="accordion-body collapse in">
                <div class="accordion-inner">
                	<?php echo getContent('user.newcampaign.sorrygoogleplaces',Yii::app()->session['language']); ?>
                </div>
            </div>
            
		</div>
        
        <div class="clearfix"></div>

        <div class="accordion-group" id="twit_div" style="margin-top:15px; display:<?php if($PendingCamp[0]['twitter']=='yes') echo 'block;'; else echo 'none;'; ?>;">
            
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion6" href="#collapseSix" title="Click to open/close"><?php echo getContent('user.newcampaign.twitter',Yii::app()->session['language']); ?></a>
            </div>
            
            <div id="collapseSix" class="accordion-body collapse in">
                <div class="accordion-inner">
                	<?php include('campaigns/twitter.php') ?>
                </div>
            </div>
            
		</div>
        
        <div class="clearfix"></div>
        
        <div class="accordion-group" id="fb_ads" style="margin-top:15px; display:<?php if($PendingCamp[0]['fb_ads']=='yes') echo 'block;'; else echo 'none;'; ?>">
            
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion7" href="#collapseSeven" title="Click to open/close"><?php echo getContent('user.newcampaign.fbads',Yii::app()->session['language']); ?></a>
            </div>
            
            <div id="collapseSeven" class="accordion-body collapse in">
                <div class="accordion-inner">
                	<?php echo getContent('user.newcampaign.sorryfbads',Yii::app()->session['language']); ?>
                </div>
            </div>
            
		</div>
        
        <div class="clearfix"></div>
        
        <div class="accordion-group" id="google_ads" style="margin-top:15px; display:<?php if($PendingCamp[0]['google_adwords']=='yes') echo 'block;'; else echo 'none;'; ?>">
            
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion8" href="#collapseEight" title="Click to open/close"><?php echo getContent('user.newcampaign.googleads',Yii::app()->session['language']); ?></a>
            </div>
            
            <div id="collapseEight" class="accordion-body collapse in">
                <div class="accordion-inner">
                	<?php echo getContent('user.newcampaign.sorrygoogleads',Yii::app()->session['language']); ?>
                </div>
            </div>
            
		</div>
        
        <div class="clearfix"></div>
        
        <div class="accordion-group" id="facebook_campaign_post" style="margin-top:15px; display:<?php if($PendingCamp[0]['fb_posts']=='yes') echo 'block;'; else echo 'none;'; ?>">
            
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion9" href="#collapseNine" title="Click to open/close"><?php echo getContent('user.newcampaign.addfbpost',Yii::app()->session['language']); ?></a>
            </div>
            
            <div id="collapseNine" class="accordion-body collapse in">
                <div class="accordion-inner">
					<?php include('fbpost_campaign.php'); ?>
                </div>
            </div>
            
		</div>
        
        <div class="clearfix"></div>
        
        <div class="accordion-group" id="foursquare_specials_div" style="margin-top:15px; display:<?php if($PendingCamp[0]['foursquare_specials']=='yes') echo 'block;'; else echo 'none;'; ?>">
            
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion10" href="#collapseTen" title="Click to open/close"><?php echo getContent('user.newcampaign.fs',Yii::app()->session['language']); ?></a>
            </div>
            
            <div id="collapseTen" class="accordion-body collapse in">
                <div class="accordion-inner">
                	<?php include('FsSpecialBox.php'); ?>
                </div>
            </div>
            
		</div>
        
        <br />
        <input type="hidden" name="savedid" id="savedid" value="<?php echo $PendingCamp[0]['campaign_id']; ?>" />
        <input type="submit" name="submit" class="btn btn-large" style="float:right;" value="GO campaign" />
        
        
    </div>
</div>

</form> 
