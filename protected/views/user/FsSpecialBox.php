<?php

if( $PendingCamp[0]['foursquare_specials']=='yes' )
	$FSDetails = Cron::model()->CronCampFSSpecial($PendingCamp[0]['campaign_id']);
	
?>
<div class="content" id="fs_content">
    <table border="0" cellpadding="0" cellspacing="1">
    <thead>
    <tr>
        <th width="73%" align="left">
			<?php echo getContent('user.newcampaign.selvenuespecial',Yii::app()->session['language']); ?>
		</th>
        <th width="27%">
        	<?php echo getContent('user.newcampaign.fspreview',Yii::app()->session['language']); ?>
        </th>
    </tr>
    </thead>
    <tbody>
    <tr>
    	<td colspan="2">
            
            <div class="field-content-44" id="venue_error" style="color:#F00; font-style:italic;"></div>
            <div class="clearfix"></div>
                            
            <span style="border:none;">
                <select style="height:40px; padding:10px; outline:none; width:350px;" name="sel_venue" id="sel_venue" onchange="LoadCampSel(this.value,<?php echo Yii::app()->user->user_id; ?>);">
                    <option value="0">Select</option>
                    <option value="1" <?php if($FSDetails[0]['location_type'] == 1) echo 'selected="selected"'; ?>>Single Venues</option>
                    <option value="2" <?php if($FSDetails[0]['location_type'] == 2) echo 'selected="selected"'; ?>>Group of Venues</option>
                    <option value="3" <?php if($FSDetails[0]['location_type'] == 3) echo 'selected="selected"'; ?>>All Venues</option>
              </select>
            </span>
		</td>
	</tr>
    
    <tr>
        <td colspan="2" valign="top">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td>
                    <span id="sel_venue_errro" style="color:#F00; display:none;"><?php echo getContent('user.newcampaign.selmessage',Yii::app()->session['language']); ?></span>
                </td>
                <td>
                    <div style="display:<?php if( $FSDetails[0]['location_type'] > 0 ) echo 'block'; else echo 'none'; ?>;" id="sel_to_drop">
                    
					<?php
					
                    if( $FSDetails[0]['location_type'] == 1 )
                    {
                        $GetSel = Location::model()->getallurl();

                        echo '<select style="height:40px; padding:10px; outline:none; width:350px;" name="groups" id="groups"><option value="0">Select</option>';
                        
                        if(count($GetSel))
                        {
							foreach($GetSel as $ShowRes)
                            {
                                echo '<option value="'.$ShowRes['loc_id'].'"';
								
								if( $FSDetails[0]['location'] == $ShowRes['loc_id'] )
									echo 'selected="selected"';
								
								echo '>'.stripslashes(htmlentities($ShowRes['name'])).'</option>';
                            }
                        }
                        
                        echo '</select>';
                    }
                    else if( $FSDetails[0]['location_type'] == 2 )
                    {
                        echo '<select style="height:40px; padding:10px; outline:none; width:350px;" name="groups" id="groups"><option value="0">Select</option>';
                        
                        $GetSel = LocationGroup::model()->GetUserGroup();
                        
                        if( count($GetSel) )
                        {
							foreach( $GetSel as $ShowRes )
                            {
                                echo '<option value="'.$ShowRes['group_id'].'"';
								
								if( $FSDetails[0]['location'] == $ShowRes['group_id'] )
									echo 'selected="selected"';
								
								echo '>'.htmlentities($ShowRes['name']).'</option>';
                            }
                        }
                        
                        echo '</select>';
                    }
                    
					?>
                    
                    </div>
                </td>
    			<td>
					
                </td>
            </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <div class="accordion-wrapper">
                <div class="accordion-block nope" id="acc1">
                    <h4>1. <?php echo getContent('user.newcampaign.specialkind',Yii::app()->session['language']); ?></h4>
                    <div class="accordion-content" style="display:block;">
                        <table style="width:100%;">
                        <tr>
                            <td colspan="3" style="border:none;"><b><?php echo getContent('user.newcampaign.attractcustomers',Yii::app()->session['language']); ?></b></td>
                        </tr>
                        <tr>
                            <td width="5%" valign="top">
                                <input type="radio" name="sp_type" value="swarm" checked="checked" id="swarm" onClick="ChangeTitle('swarm_unlocked','Swarm');" />
                            </td>
                            <td width="80%">
                                <b><?php echo getContent('user.newcampaign.fsswarm',Yii::app()->session['language']); ?></b><br /><?php echo getContent('user.newcampaign.swarmlike',Yii::app()->session['language']); ?>
                            </td>
                            <td width="15%" align="center">
                                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/foursquare/swarm_on.png" id="swarm_pic" />
                            </td>
                        </tr>
                        <tr>
                            <td valign="top"><input type="radio" name="sp_type" value="friends" id="friend" onClick="ChangeTitle('friends_unlocked','Friends');" /></td>
                            <td>
                                <b><?php echo getContent('user.newcampaign.fsfriendspecial',Yii::app()->session['language']); ?></b><br /><?php echo getContent('user.newcampaign.fsfriendspeciallike',Yii::app()->session['language']); ?>
                            </td>
                            <td style="border:none;" align="center">
                                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/foursquare/friends_off.png" id="friends_pic" />
                            </td>
                        </tr>
                        <tr>
                            <td valign="top"><input type="radio" name="sp_type" value="flash" id="flash" onClick="ChangeTitle('flash_unlocked','Flash');" /></td>
                            <td style="border:none;">
                                <b><?php echo getContent('user.newcampaign.flashspecial',Yii::app()->session['language']); ?></b><br /><?php echo getContent('user.newcampaign.flashspeciallike',Yii::app()->session['language']); ?>
                            </td>
                            <td style="border:none;" align="center">
                                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/foursquare/flash_off.png" id="flash_pic" />
                            </td>
                        </tr>
                        <tr>
                            <td valign="top"><input type="radio" name="sp_type" value="count" id="newbie" onClick="ChangeTitle('newbie_unlocked','Newbie');" /></td>
                            <td style="border:none;">
                                <b><?php echo getContent('user.newcampaign.newbie',Yii::app()->session['language']); ?></b><br /><?php echo getContent('user.newcampaign.newbielike',Yii::app()->session['language']); ?>
                            </td>
                            <td style="border:none;" align="center">
                                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/foursquare/newbie_off.png" id="newbie_pic" />
                            </td>
                        </tr>
                        <tr>
                            <td valign="top"><input type="radio" name="sp_type" value="frequency" id="checkin" onClick="ChangeTitle('check-in_unlocked','Check-in');" /></td>
                            <td style="border:none;">
                                <b><?php echo getContent('user.newcampaign.checkin',Yii::app()->session['language']); ?></b><br /><?php echo getContent('user.newcampaign.checkinlike',Yii::app()->session['language']); ?>
                            </td>
                            <td style="border:none;" align="center">
                                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/foursquare/check-in_off.png" id="checkin_pic" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="border:none;"><b><?php echo getContent('user.newcampaign.reward',Yii::app()->session['language']); ?></b></td>
                        </tr>
                        <tr>
                            <td valign="top"><input type="radio" name="sp_type" value="regular" id="loyalty" onClick="ChangeTitle('frequency_unlocked','Loyalty');" /></td>
                            <td style="border:none;">
                                <b><?php echo getContent('user.newcampaign.loyalty',Yii::app()->session['language']); ?></b><br /><?php echo getContent('user.newcampaign.loyaltylike',Yii::app()->session['language']); ?>
                            </td>
                            <td style="border:none;" align="center">
                                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/foursquare/frequency_off.png" id="frequency_pic" />
                            </td>
                        </tr>
                        <tr>
                            <td valign="top"><input type="radio" name="sp_type" value="mayor" id="mayor" onClick="ChangeTitle('mayor_unlocked','Mayor');" /></td>
                            <td style="border:none;">
                                <b><?php echo getContent('user.newcampaign.mayor',Yii::app()->session['language']); ?></b><br /><?php echo getContent('user.newcampaign.mayorlike',Yii::app()->session['language']); ?>
                            </td>
                            <td style="border:none;" align="center">
                                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/foursquare/mayor_off.png" id="mayor_pic" />
                            </td>
                        </tr>
                        <tr>
                            <td style="border:none;"></td>
                            <td style="border:none;" colspan="2" align="left" class="fake">
                                <h2 style="cursor:pointer;" onclick="javascript:PutStep2();" class="btn btn-info"> &nbsp;&nbsp;Next&nbsp;&nbsp; </h2> 
                                <div style="position:relative; border:#000 0px solid; width:70px; margin-top:-30px; height:30px; cursor:pointer;" id="block_to_click" onclick="CheckVenueSelect();">&nbsp;</div>
                            </td>
                        </tr>
                        </table>
                    </div>
                </div>
                
                <div class="accordion-block" id="acc2_smaple">
                    <h5>2. When does the special get unlocked? </h5> 
                </div>
                
                <div class="accordion-block" id="acc2" style="display:none;">
                    <h4>2. When does the special get unlocked? </h4> 
                    <div class="accordion-content">
                        <table>
                        <tr>
                            <td style="border:none;" id="part2">
                                When &nbsp;&nbsp;<input type="text" class="input-cnt-44-one" name="swarm_prople" id="swarm_people" />&nbsp;&nbsp; people are checked in at once with a maximum of &nbsp;&nbsp;<input type="text" class="input-cnt-44-one" name="swarm_days" id="swarm_days" />&nbsp;&nbsp;  unlocks per day.
                            </td>
                        </tr>
                        <tr>
                            <td style="border:none;" align="left" class="fake2">
                                <h2 style="cursor:pointer;" onclick="javascript:StepChange(3);" class="btn btn-info"> &nbsp;&nbsp;Next&nbsp;&nbsp; </h2> 
                            </td>
                        </tr>
                        </table>
                    </div>
                </div>
                
                <div class="accordion-block" id="acc3_sample">
                    <h5>3. What is the offer?</h5>
                </div>
                
                <div class="accordion-block" id="acc3" style="display:none;">
                    <h4>3. What is the offer?</h4>
                    <div class="accordion-content">
                        <table class="styled" style="border:none;">
                        <tr>
                            <td style="border:none;" id="part3">
                                Offer Description<br /><br />
                                The offer the customer sees when they view your special.<br /><br />
                                
                                <textarea name="offer" id="offer" onKeyUp="javascript:PutPhoneHtml3(this.value);" class="small_txtarea"></textarea>
                                
                            </td>
                        </tr>
                        <tr>
                            <td style="border:none;" align="left" class="fake3">
                                <h2 style="cursor:pointer;" onclick="javascript:StepChange(4);" class="btn btn-info"> &nbsp;&nbsp;Next&nbsp;&nbsp; </h2> 
                            </td>
                        </tr>
                        </table>
                    </div>
                </div>
                
                <div class="accordion-block" id="acc4_sample">
                    <h5>4. Advanced features (optional)</h5>
                </div>
                
                <div class="accordion-block" id="acc4" style="display:none;">
                    <h4>4. Advanced features (optional)</h4>
                    <div class="accordion-content">
                        <table class="styled" style="border:none;">
                        <tr>
                            <td style="border:none;" id="part4">
                                Custom Unlocked Offer Description <br /><br />
                                Describe what the customer will receive, including any details that should only be viewed by users that unlock the special.<br /><br />
                                <textarea id="offer_same" name="offer_same" onKeyUp="javascript:PutPhoneHtml3(this.value);" class="small_txtarea"></textarea><br /><br />

                                Fine Print<br /><br />
                                Add any additional rules or conditions the customer should understand. (No HTML tags or links, please)
                                <textarea name="rules" id="rules" onKeyUp="javascript:PutPhoneHtml4(this.value);" class="small_txtarea"></textarea><br /><br />
                                
                                Cost : <input type="text" class="input-cnt-44-one" value="" name="cost" id="cost" />
                                
                            </td>
                        </tr>
                        <tr>
                            <td style="border:none;" align="left" class="fake4">
                                <a href="javascript:void(0);" onclick="document.getElementById('fs_content').style.display='none'" class="btn">Done</a>
                            </td>
                        </tr>
                        </table>
                    </div>
                </div>
                
            </div>
        </td>
        <td align="center" valign="top" style="font-size:16px; color:#000000; border:none;">
            <div class="specials">
                <div id="createSpecial" class="specials">
                    <div id="right">
                        <div class="unlocked" id="preview">
                              
                            <div id="previewScreen">
                                
                                <div id="flag">
                                    <div id="previewIcon">
                                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/foursquare/swarm_unlocked.png" />
                                    </div>
                                    <span>Swarm Special</span>
                                </div>
                                
                                <div id="specialContainer">
                                    <div class="specialContent">
                                        <p id="welcome">
                                            Welcome to Your Venue
                                            <span id="address"></span>
                                        </p>
                                        <p id="helpText">
                                            <span class="deal">Your special offer will go here to tell customers what they’ll receive</span>
                                        </p>
                                        <p id="description">
                                            <span class="deal"></span>
                                        </p>
                                        <p id="lockedDescription">
                                            <span class="deal"></span>
                                        </p>
                                    </div>
                                    <div id="explanation" align="left">
                                      Unlocked:
                                      <span class="unlocked"> for swarms of <span id="swarm_people_content">20</span> people (up to <span id="swarm_days_content">30</span> per day)</span>
                                    </div>
                                </div>
                                <div id="fineprint" align="left">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    </tbody>
    </table>
</div>
        
<script>

function PutPhoneHtml2(id,val)
{
	document.getElementById(id+'_content').innerHTML=val;
}

</script>