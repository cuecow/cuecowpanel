<div class="clear"></div>

<div class="clearfix"></div>

<div class="container container-top">
	<div class="row-fluid">

<script>
function confirmSubmit(url)
{
	var agree=confirm("Are you sure you wish to continue?");
	
	if (agree)
	{
		window.location.href=url;
		return true ;
	}
	else
		return false ;
}
</script>

<div class="clearfix"></div>
<div class="container container-top">
    <div class="row-fluid">
    
<?php 
if($_REQUEST['view']=='see') 
{  
	$spec_camp 	= Campaign::model()->GetCampaign($_REQUEST['id']);;  
	
	if($spec_camp[0]['foursquare_specials']=='yes')
		$fs_camp = Campaign::model()->GetPendingFSCamp($spec_camp[0]['campaign_id']);
	
	if($spec_camp[0]['fb_posts']=='yes')
		$fb_post = Campaign::model()->GetPendingFBCamp($spec_camp[0]['campaign_id']);
?>

<div class="span6">
	<div class="accordion" id="accordion1">
    	<div class="accordion-group">
        	<div class="accordion-heading">
            	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne" title="Click to open/close">Campaign information</a>
			</div>
                    
            <div id="collapseOne" class="accordion-body collapse in" style="min-height:242px;">
            	<div class="accordion-inner">
                        
                	<div class="field-content-44">
                    	<div class="field-content-44-left">
                        	<label>
								<?php echo getContent('user.newcampaign.campaignname',Yii::app()->session['language']); ?>:
                            </label>
						</div>
                                
                        <div class="field-content-44-right left-content-fld">
                        	<?php echo $spec_camp[0]['name']; ?>
                        </div>
					</div>
                    
                    <div class="clearfix"></div>
                    
                    <div class="field-content-44">
                    	<div class="field-content-44-left">
                        <label>
							<?php echo getContent('user.newcampaign.desiredkpi',Yii::app()->session['language']); ?>:
                        </label>
                        </div>
                        <div class="field-content-44-right left-content-fld">
		                	<?php echo $spec_camp[0]['kpi']; ?>
        	            </div>
					</div>
                    <div class="clearfix"></div>
                            
                    <div class="field-content-44">
                    	<div class="field-content-44-left"><label><?php echo getContent('user.newcampaign.startdateandtime',Yii::app()->session['language']); ?>:</label></div>
                            
	                    <div class="field-content-44-right left-content-fld">
                        	<?php if($spec_camp[0]['start_date']) echo date('m/d/Y',$spec_camp[0]['start_date']); ?> <?php echo '@'.$spec_camp[0]['start_time']; ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                            
                    <div class="field-content-44">
                    	<div class="field-content-44-left"><label><?php echo getContent('user.newcampaign.enddateandtime',Yii::app()->session['language']); ?>:</label></div>
                            
	                    <div class="field-content-44-right left-content-fld">
    	                	<?php if($spec_camp[0]['end_date']) echo date('m/d/Y',$spec_camp[0]['end_date']); ?> <?php echo '@'.$spec_camp[0]['end_time']; ?>
            	        </div>
					</div>
                    <div class="clearfix"></div>
                            
					<?php
    
                    if($spec_camp[0]['timezone'])
                        $timezone = Campaign::model()->SpecZone($spec_camp[0]['timezone']);
                        
                    ?>
                            
                    <div class="field-content-44">
                        <div class="field-content-44-left"><label><?php echo getContent('user.newcampaign.timezone',Yii::app()->session['language']); ?>:</label></div>
                    
                        <div class="field-content-44-right left-content-fld">
                            <?php echo $timezone[0]['zone']; ?>
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
                                <span class="social-tab-shadow"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/<?php if($spec_camp[0]['foursquare_specials']=='no') echo 'cuecow_grey/';  ?>Foursquare.png" width="80" /></span>
                            </label>
                        </div>
                        <div class="checkbox-cotent-11">
                            <label>
                                <span class="social-tab-shadow"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/Fbdeals.png" width="80" /></span>
                            </label>
                        </div>
                        <div class="checkbox-cotent-11">
                            <label>
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
                            <span class="social-tab-shadow"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/<?php if($spec_camp[0]['fb_posts']=='no') echo 'cuecow_grey/';  ?>Facebookposts.png" width="80" /></span>
                        </label>
                    </div>
                    <div class="checkbox-cotent-11">
                        <label>
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
                            <span class="social-tab-shadow"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/Fbads.png" width="80" /></span>
                        </label>
                    </div>
                    <div class="checkbox-cotent-11">
                        
                    </div>
                    <div class="checkbox-cotent-11 checkbox-cotent-11-last">
                        <label>
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
<?php 

if($spec_camp[0]['foursquare_specials']=='yes') 
{ 
	$fs_camp = Campaign::model()->GetPendingFSCamp($spec_camp[0]['campaign_id']); 

?>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/foursquare.css" type="text/css" />

<div class="span6" style="margin:0px; padding:0px;">
    <div class="accordion-group">
    
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseThree" title="Click to open/close"><?php echo getContent('user.campaign.foursquarespecials',Yii::app()->session['language']); ?></a>
        </div>
        
        <div id="collapseThree" class="accordion-body collapse in">
            <div class="accordion-inner">
            	<div class="specials" style="margin-left:150px;">
					<div id="createSpecial" class="specials">
                    	<div class="unlocked" id="preview">        
                        	<div id="previewScreen">
                            	<div id="flag">
                                
								<?php 
																
								if($fs_camp[0]['sp_type']=='swarm') 
								{
									$sp_type = 'Swarm';
									$sp_image = Yii::app()->request->baseUrl.'/images/foursquare/swarm_on.png';
								}
								else if($fs_camp[0]['sp_type']=='friends')
								{
									$sp_type = 'Friend';
									$sp_image = Yii::app()->request->baseUrl.'/images/foursquare/friends_on.png';
								}
								else if($fs_camp[0]['sp_type']=='flash')
								{
									$sp_type = 'Flash';
									$sp_image = Yii::app()->request->baseUrl.'/images/foursquare/flash_on.png';
								}
								else if($fs_camp[0]['sp_type']=='count')
								{
									$sp_type = 'Newbie';
									$sp_image = Yii::app()->request->baseUrl.'/images/foursquare/newbie_on.png';
								}
								else if($fs_camp[0]['sp_type']=='frequency')
								{
									$sp_type = 'Check-in';
									$sp_image = Yii::app()->request->baseUrl.'/images/foursquare/check-in_on.png';
								}
								else if($fs_camp[0]['sp_type']=='regular')
								{
									$sp_type = 'Loyalty';
									$sp_image = Yii::app()->request->baseUrl.'/images/foursquare/frequency_on.png';
								}
								else if($fs_camp[0]['sp_type']=='mayor')
								{
									$sp_type = 'Mayor';
									$sp_image = Yii::app()->request->baseUrl.'/images/foursquare/mayor_on.png';
								}
																	
								?>
                                <div id="previewIcon">
                                    <img src="<?php echo $sp_image; ?>" />
                                </div>
                                <span style="margin-left:20px;"><?php echo $sp_type; ?> <?php echo getContent('user.campaign.special',Yii::app()->session['language']); ?></span>
                            	</div>
                            	<div id="specialContainer" style="margin-left:32px;">
                                    <div class="specialContent">
                                        <p id="welcome"><?php echo getContent('user.campaign.welcomevenue',Yii::app()->session['language']); ?><span id="address"></span></p>
                                        <p id="helpText"><span class="deal"><?php echo getContent('user.campaign.specialoffer',Yii::app()->session['language']); ?></span></p>
                                        <p id="description"><span class="deal"><?php echo $fs_camp[0]['offer']; ?></span></p>
                                        <p id="lockedDescription"><span class="deal"></span></p>
                                    </div>
                                    <div id="explanation" align="left">
                                        <?php echo getContent('user.campaign.unlocked',Yii::app()->session['language']); ?>:
                                        <span class="unlocked"><?php echo $fs_camp[0]['unlockedText']; ?></span>
                                    </div>
                            	</div>
								<div id="fineprint" align="left"><?php echo $fs_camp[0]['finePrint']; ?></div>
                            </div>
                        </div>
					</div>
                </div>
            </div>
		</div>
	</div>
</div>
<?php } ?>

<?php 

if($spec_camp[0]['fb_posts']=='yes') 
{
	$fb_camp = Campaign::model()->GetPendingFBCamp($spec_camp[0]['campaign_id']); 
	
?>
<div class="clearfix">
<div class="span6" style="margin-left:30px;">
    <div class="accordion-group">
    
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion4" href="#collapseFour" title="Click to open/close"><?php echo getContent('user.campaign.fbposts',Yii::app()->session['language']); ?></a>
        </div>
        
        <div id="collapseFour" class="accordion-body collapse in">
            <div class="accordion-inner">
            	<table class="table" width="100%">
				<tr>
                	<td style="border:none;" width="30%"><b><?php echo getContent('user.campaign.posttitles',Yii::app()->session['language']); ?></b></td>
                    <td style="border:none;"><?php echo $fb_camp[0]['post_title']; ?></td>
				</tr>
                <tr>
                	<td style="border:none;"><b><?php echo getContent('user.campaign.message',Yii::app()->session['language']); ?></b></td>
                    <td style="border:none;"><?php echo $fb_camp[0]['message']; ?></td>
				</tr>
                <tr>
                	<td style="border:none;"><b><?php echo getContent('user.campaign.contenttype',Yii::app()->session['language']); ?></b></td>
                    <td style="border:none;"><?php echo ucfirst($fb_camp[0]['content_type']); ?></td>
				</tr>
                
				<?php if($fb_camp[0]['content_type']=='text' && !empty($fb_camp[0]['description'])) { ?>
                
                <tr>
                    <td style="border:none;"><b><?php echo getContent('user.campaign.description',Yii::app()->session['language']); ?></b></td>
                    <td style="border:none;"><?php echo $fb_camp[0]['description']; ?></td>
                </tr>
				<? } else if($fb_camp[0]['content_type']=='photo'){ ?>
                <tr>
                    <td style="border:none;"><b><?php echo getContent('user.campaign.photo',Yii::app()->session['language']); ?></b></td>
                    <td style="border:none;"><img src="<? echo Yii::app()->request->baseUrl ?>/phpthumb/phpThumb.php?src=<? echo Yii::app()->request->baseUrl ?>/images/fbposts/<?=$fb_camp[0]['photo'];?>&h=200&w=230"  /></td>
                </tr>
				<? } else if($fb_camp[0]['content_type']=='video'){ ?>
                <tr>
                    <td style="border:none;"><b><?php echo getContent('user.campaign.video',Yii::app()->session['language']); ?></b></td>
                    <td style="border:none;">
                    <?php 
                    
                    $show_main='<script type="text/javascript"> jwplayer("display_container").setup({ flashplayer: "/static/js/mediaplayer/player.swf", file: "/static/vid/a.flv", height: 200, width: 230 }); </script>';
                            
                    $show_main='<script type="text/javascript"> jwplayer("display_container").setup({ flashplayer: "'.Yii::app()->request->baseUrl.'/assets/js/mediaplayer/player.swf", file: "'.Yii::app()->request->baseUrl.'/images/fbposts/'.$fb_camp[0]['video'].'", height: 200, width: 230 }); </script>';
                                        
                    ?>
                    <span id="display_container"><?php echo $show_main; ?></span>			
                </td>
            </tr>
            <? } ?>
            <tr>
                <td style="border:none;"><b><?php echo getContent('user.campaign.notification',Yii::app()->session['language']); ?></b></td>
                <td style="border:none;"><?php echo ucfirst($fb_camp[0]['email_notify']); ?></td>
            </tr>
            </table>
            </div>
		</div>
	</div>
</div>

<?php } ?>

        	
        </div>	
    </div>
    
<?php } else { include('campaigns/CampaignListing.php'); } ?>   
     
</div>
