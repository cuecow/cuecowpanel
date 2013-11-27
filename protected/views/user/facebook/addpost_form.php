<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/picker/anytime.css" />
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/picker/jquery-1.6.4.min.js" type="text/javascript" language="javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/picker/anytime.js" type="text/javascript" language="javascript"></script>

<?php

$model_fb = new Fbposts;

$validate 		= 0;
$url 			= "";
$msg 			= "";
$rb 			= 0;
$spost 			= 0;
$content 		= "";
$schedulepost 	= "no";

$GetLimitUsers = User::model()->ValidateLimits();
$CountUserPages = Fbpages::model()->CountUserPages();
$UserSetPages = Fbpages::model()->GetUserSetPages();

?>
                
<table class="table"> 
<tbody>
<tr>
    <td>
    
        <?php $form=$this->beginWidget('CActiveForm', array('action'=>Yii::app()->request->baseUrl.'/index.php/user/fbposts','id'=>'fbposts-form','enableClientValidation'=>true,'htmlOptions'=>array('enctype'=>'multipart/form-data','class'=>'styled','onsubmit'=>'return CheckPostForm()'),'clientOptions'=>array('validateOnSubmit'=>true,),)); ?>

        <?php if(isset($_POST['Fbposts'])){ ?>
            
			<div class="alert alert-error">
            	<button type="button" class="close" data-dismiss="alert">&times;</button>
              	<? echo $form->errorSummary($model_fb); ?>
          	</div>
    
        <? } ?>
        
        <div id="add">

            <fieldset>
                
                <?php 
                    
                    $user_groups = $model_fb->PickUserNewGroup(); 
                    $user_pages = $model_fb->UserPages();
                ?>
                
                <div style="padding-bottom:10px;">
                    <?php if(count($user_groups)==0 && count($user_pages)==0) { ?>
                    <center><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/facebook/view/Add">Please create a page to make posts.</a></center>									<?php } else { ?>
                    <table id="tablesorter-sample" class="styled" cellpadding="0" cellspacing="0" style="border:none;"> 
                    <tbody> 
                    <tr>
                        <td style="border:none;" width="45%">
                            <?php if(count($user_pages)) { ?>
                            <strong>Select Page</strong>
                            <?php } else echo '&nbsp;'; ?>
                        </td>
                        <td style="border:none;" width="10%">&nbsp;</td>
                        <td style="border:none;" width="45%">
                            <?php if(count($user_groups)) { ?>
                            <strong>Select Group</strong>
                            <?php } else echo '&nbsp;'; ?>
                        </td>
                    </tr>
                    
                    <tr> 
                        <td align="left" style="border:none;">
                            <?php if(count($user_pages)) { ?>
                            <select  style="height:40px; padding:10px; outline:none;" name="page" id="select_pages" onchange="ButtonShowHide();">
                                <option value="0" selected="selected">Select Page</option>
                                <?php   foreach($user_pages as $key=>$value) { ?>
                                <option value="<?php echo $value['id'];?>"><?php echo $value['page_name'];?></option>
                                <?php } ?>
                            </select>
                            <?php } else { ?>
                            <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/facebook/view/Add" class="button large blue">Add new Facebook Page</a>
                            <?php } ?>
                        </td> 
                        <td style="border:none;" align="center">
                            <?php if(count($user_groups)) { ?>
                            <strong>OR</strong>
                            <?php } else echo '&nbsp;'; ?>
                        </td>
                        <td align="left" style="border:none;">
                            <?php if(count($user_groups)) { ?>
                            <select style="height:40px; padding:10px; outline:none;" name="groups" id="select_groups" onchange="ButtonShowHide();">
                                <option value="0" selected="selected">Select Group</option>
                                <?php foreach($user_groups as $key=>$value) { if(!empty($value)) {   ?>
                                <option value="<?php echo $value['group_id'];?>"><?php echo $value['name'];?></option>
                                <?php } } ?>
                            </select>
                            <?php } else { ?>
                            <!--<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/location/view/Add" class="button large blue">Add new Location</a>-->
                            <?php } ?>
                        </td> 
                    </tr>
                    </tbody> 
                    </table>
                    <?php } ?>
                </div>
                
                <hr />
                
                <label for="textBox">
                    <span class="field_title">Post Title:</span>
                    <?php

                    if(!empty($_POST['Fbposts']['name']))
                        $text_tit = $_POST['Fbposts']['name'];
                    else
                        $text_tit = 'Facebook post - created on '.date('m-d-Y');
                    ?>
                    <?php echo $form->textField($model_fb,'name',array('class'=>'textbox','value'=>$text_tit)); ?>
                </label>
                
                <div class="non-label-section">
                    <span>&nbsp;</span>
                    Optional: Enter title or description of post for your own reference, or keep the preformatted title
                </div>
                
                <label for="textField">
                    <span class="field_title">Enter Message:</span>
                    <textarea name="textmsg" id="textmsg" class="textarea" onkeypress="GetUrlVals(this.value,event);"><?php echo $_POST['textmsg'] ?></textarea>
                </label>
                
                <label for="textField" id="ajaxload" style="float:left; width:100%;"><span class="field_title">&nbsp;</span></label>
                
                <div style="clear:both;"></div>
                
                <label for="selectBox">
                    <span class="field_title">Tell us what to post:</span>
                    <input id="radio1" class="radio" name="post_to" type="radio" value="nothing" checked="checked" onclick="PermitContent('content_upload','nothing');"  /> Nothing &nbsp;&nbsp;&nbsp;&nbsp;
                    <input id="radio1" class="radio" name="post_to" type="radio" value="photos" onclick="PermitContent('photo_upload','photos');" /> Photos &nbsp;&nbsp;&nbsp;&nbsp;
                    <input id="radio1" class="radio" name="post_to" type="radio" value="videos" onclick="PermitContent('video_upload','videos');" /> Videos 
                </label>
                
                <div style="display:none;" id="photo_upload">
                    <label for="uploadField">
                        <span class="field_title">Upload Photo:</span>
                        <?php echo $form->fileField($model_fb,'photo',array('class'=>'file','style'=>'width:220px;')); ?>
                    </label>
                </div>
                
                <div style="display:none;" id="video_upload">
                    <label for="uploadField">
                        <span class="field_title">Upload Video:</span>
                        <?php echo $form->fileField($model_fb,'video',array('class'=>'file','style'=>'width:220px;')); ?>
                    </label>
                </div>
                
                <label for="textField">
                    <span class="field_title">Post this on:</span>
                    <input type="text" name="Fbposts[post_date]" id="addform_field1" class="small" readonly="readonly" value="<?php echo date('m/d/Y'); ?>" />
                    <input type="text" name="Fbposts[post_time]" id="addform_field2" class="verysmall" readonly="readonly" value="<?php echo date('h:i',strtotime('+ 10 minute')); ?>" />
                </label>
                    
                <script type="text/javascript">
                    AnyTime.picker( "addform_field1",
                        { format: "%m/%d/%z", baseYear: <?php echo date('Y'); ?>, earliest: new Date(<?php echo date('Y'); ?>,<?=date('m')-1?>,<?=date('d')?>,<?=date('H')?>,<?=date('i')?>,0), } );
                    $("#addform_field2").AnyTime_picker(
                        { format: "%H:%i", labelTitle: "Hour",
                        labelHour: "Hour", labelMinute: "Minute" } );
                </script>
                
                <?php 
                
                $time_zone = User::model()->GetTimeZone();  
                $user_zone = User::model()->GetUserTimeZone();
                
                ?>
                <label for="textField" style="width:575px;">
                    <span class="field_title">Time Zone :</span>
                    <select name="timezone" id="timezone" style="height:40px; padding:10px; outline:none;">
                        <?php foreach($time_zone as $key=>$value) { ?>
                        <option value="<?php echo $key; ?>" <?php if($user_zone[0]['timestamp']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                        <?php } ?>
                    </select>
                </label>
                
                    
                <label for="textField">
                    <input id="checkbox2" class="checkbox" name="Fbposts[email_notify]" type="checkbox" value="yes" checked="checked" />  Email me when content posted
                </label>
                    
                    
                
                <!-- Buttons -->
                <div class="non-label-section" id="submit_button" style="display:block;">
                    <input type="submit" value="Submit" class="button medium green float_right" />
                </div>

                <span><a class="button small" href="#" onclick="ShowHideAddPostForm()">Cancel</a></span>
            
            </fieldset>
            
        </div>
        
        <?php $this->endWidget(); ?>
        
    </td>
</tr>
</tbody> 
</table>	

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