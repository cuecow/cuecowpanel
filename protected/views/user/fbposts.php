<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/picker/anytime.css" />
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/picker/jquery-1.6.4.min.js" type="text/javascript" language="javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/picker/anytime.js" type="text/javascript" language="javascript"></script>

<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/ajax/css.css" type="text/css">

<script type="text/javascript">

function PermitContent(id,val)
{	
	if(val=='photos')
	{
		document.getElementById(id).style.display='block';
		document.getElementById('video_upload').style.display='none';
		
		cleardiv(1);
	}
	else if(val=='videos')
	{
		document.getElementById(id).style.display='block';
		document.getElementById('photo_upload').style.display='none';
	}
	else if(val=='nothing')
	{
		document.getElementById('video_upload').style.display='none';
		document.getElementById('photo_upload').style.display='none';
		
		document.getElementById(id).style.display='none';
		cleardiv(2);
	}
}

function dochanges(id,from,value)
{
	if(from=='title')
		document.getElementById(id).innerHTML='<strong>'+value+'</strong>';
	else
		document.getElementById(id).innerHTML=value;
}

var httpobj=false;
if(window.XMLHttpRequest)
	httpobj=new XMLHttpRequest();

if(window.ActiveXObject)
	httpobj=new ActiveXObject("Microsoft.XMLHTTP");	

function ChangeLabel(div1,div2)
{
	//document.getElementById(div1).style.display='none';
	//document.getElementById(div2).style.display='block';
}

function decreasepic()
{
	var current_pic = document.getElementById('current_pic').value;
	var total_pics = document.getElementById('total_images').value;
	var decreasedpic = parseInt(current_pic) - parseInt(1);
	
	if(current_pic > 1 )
	{
		document.getElementById('current_pic').value = decreasedpic ;
		show_thumb(total_pics, decreasedpic);
	}
}

function increasepic()
{
	var current_pic = document.getElementById('current_pic').value;
	var total_pics = document.getElementById('total_images').value;
	var increasedpic = parseInt(current_pic) + parseInt(1);
	
	if(current_pic >= 1 && parseInt(current_pic) <= parseInt(total_pics))
	{
		document.getElementById('current_pic').value = increasedpic ;
		show_thumb(total_pics, increasedpic);
	}
}

function thumbnail_display(val)
{
	if(val == true)
		$('.fb_preview_images').hide();
	else if(val == false)
		$('.fb_preview_images').show();
}

function show_thumb(tot_pics, current_pic)
{
	for(var i = 1 ; i <= parseInt(tot_pics) ; i++ )
	{
		document.getElementById('img_'+i).style.display = 'none';
	}
	
	document.getElementById('img_'+current_pic).style.display = 'block';
	document.getElementById('cur_lab_pic').innerHTML = current_pic + ' of ' + i;
	
	var new_img = $('#img_'+current_pic).attr('src');
	
	$('#current_pic_src').val(new_img);
}

function NNKeyCap(e) 
{
    if (e.which == 32) 
		return true;
	else
		return false;
}

function cleardiv(num)
{
	if(num==1)
		document.getElementById('ajaxload').innerHTML='<span class="field_title">&nbsp;&nbsp;</span>';
	else 
		document.getElementById('ajaxload').innerHTML='<span class="field_title">&nbsp;</span>';
}


function GetUrlVals(value,e)
{
	var res = value.split(" ");
	var url = '';
	var regUrl = /^(((ht|f){1}(tp:[/][/]){1})|((www.){1}))[-a-zA-Z0-9@:%_\+.~#?&//=]+$/;
	
	var checkkey = NNKeyCap(e);
	
	if(checkkey)
	{
		for(i = 0; i < res.length; i++)
		{
			if(res[i].indexOf("www")!='-1' || res[i].indexOf("http")!='-1' || res[i].indexOf("https")!='-1')
				url = res[i];
		}

		if(regUrl.test(url) == true && document.getElementById('ajaxload').innerHTML=='<span class="field_title">&nbsp;</span>')
		{	
		
			if(httpobj)
			{		
				document.getElementById('ajaxload').innerHTML='<div align="center" id="load"><img src="<?php echo Yii::app()->request->baseUrl; ?>/ajax/load.gif" /></div>';
				
				url = '<?php echo Yii::app()->request->baseUrl; ?>/ajax/fbget.php?url=' + escape(url);
		
				httpobj.open("GET",url,true);	
				httpobj.onreadystatechange=function()
				{
					if(httpobj.readyState==4 && httpobj.status==200)
					{
						//alert(httpobj.responseText);
						document.getElementById('ajaxload').innerHTML=httpobj.responseText;
					}
				}	
				httpobj.send(null);	
			}
		}
	}
}

function ButtonShowHide()
{
	var sel_groups = $('#select_groups').val();
	var sel_pages = $('#select_pages').val();

	if(sel_groups==0 && sel_pages==0)
		$('#submit_button').hide();
	else
		$('#submit_button').show();
}

</script>

<div class="clearfix"></div>
<div class="container container-top">
    <div class="row-fluid">
    
<?php if($show_choose_message == 'yes') { ?>

<div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    We found more pages from your facebook account than your cuecow account allows you. Choose from them to activate, by <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/profile/view/selwall">Click here</a>.
</div>

<?php } ?>

<?php if($_REQUEST['view']=='edit') { ?>
            			
	<table style="width:100%;"> 
	<tbody> 
    <tr>
        <td>
        
            <?php $form=$this->beginWidget('CActiveForm', array('id'=>'fbposts-form','enableClientValidation'=>true,'htmlOptions'=>array('enctype'=>'multipart/form-data','class'=>'styled'),'clientOptions'=>array('validateOnSubmit'=>true,),)); ?>
    
            <?php if(isset($_POST['Fbposts'])){ ?>
                
                <div class="alert alert-error">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <? echo $form->errorSummary($model); ?>
                </div>
            <? } ?>
            
            <div id="add">
                    
			<?php 
                        
            $user_groups = $model->PickUserNewGroup(); 
            $user_pages = $model->UserPages();
            
			?>
                    
				<div style="padding-bottom:10px;">
                	
					<?php if(count($user_groups)==0 && count($user_pages)==0) { ?>
	                    
                        <center><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/facebook/view/Add">Please create a page to make posts.</a></center>									
                        
					<?php } else { ?>
                    
                    	<table cellpadding="0" cellspacing="0"> 
                        <tbody> 
                        <tr>
                            <td style="border:none;" width="45%">
                                <?php if(count($user_groups)) { ?>
                                <strong>Select Group</strong>
                                <?php } else echo '&nbsp;'; ?>
                            </td>
                            <td style="border:none;" width="10%">&nbsp;</td>
                            <td style="border:none;" width="45%">
                                <?php if(count($user_pages)) { ?>
                                <strong>Select Page</strong>
                                <?php } else echo '&nbsp;'; ?>
                            </td>
                        </tr>
                        <tr><td colspan="3">&nbsp;</td></tr>
                        <tr> 
                            <td align="left" style="border:none;">
                                <?php if(count($user_groups)) { ?>
                                <select style="height:40px; padding:10px; outline:none;" name="groups" id="select_groups" onchange="ButtonShowHide();">
                                    <option value="0" selected="selected">Select Group</option>
                                    <?php foreach($user_groups as $key=>$value) { if(!empty($value)) {   ?>
                                    <option value="<?php echo $value['group_id'];?>" <?php if($edit_post[0]['group_id']==$value['group_id']) echo 'selected'; ?>><?php echo $value['name'];?></option>
                                    <?php } } ?>
                                </select>
                                <?php } else { ?>
                                <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/location/view/Add" class="button large blue">Add new Location</a>
                                <?php } ?>
                            </td> 
                            <td align="center">
                                <?php if(count($user_pages)) { ?>
                                <strong>OR</strong>
                                <?php } else echo '&nbsp;'; ?>
                            </td>
                            <td>
                                <?php if(count($user_pages)) { ?>
                                <select  style="height:40px; padding:10px; outline:none;" name="page" id="select_pages" onchange="ButtonShowHide();">
                                    <option value="0" selected="selected">Select Page</option>
                                    <?php   foreach($user_pages as $key=>$value) { ?>
                                    <option value="<?php echo $value['id'];?>" <?php if($edit_post[0]['page_id']==$value['id']) echo 'selected'; ?>><?php echo $value['page_name'];?></option>
                                    <?php } ?>
                                </select>
                                <?php } else { ?>
                                <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/facebook/view/Add" class="button large blue">Add new Facebook Page</a>
                                <?php } ?>
                            </td> 
                        </tr>
                        </tbody> 
                        </table>
                        <?php } ?>
                    </div>
                    <hr />
                    <div class="field-content-44">
                        <div class="login_field-content-44-left"><label>Post Title:</label></div>
                        <?php
                
                        if(!empty($_POST['Fbposts']['name']))
                            $text_tit = $_POST['Fbposts']['name'];
                        else
                            $text_tit = 'Facebook post - created on '.date('m-d-Y');
                        ?>
                        
                        <div class="field-content-44-right left-content-fld">
                            <?php echo $form->textField($model,'name',array('class'=>'textbox','value'=>$text_tit)); ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    
                    <div class="field-content-44">
                        <div class="login_field-content-44-left">&nbsp;</div>
                        <div class="field-content-44-right left-content-fld">
                            Optional: Enter title or description of post for your own reference, or keep the preformatted title
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    
                    <div class="field-content-44">
                        <div class="login_field-content-44-left"><label>Enter Message:</label></div>
                        
                        <div class="field-content-44-right left-content-fld">
                            <textarea name="textmsg" id="textmsg" class="textarea" onkeypress="GetUrlVals(this.value,event);" style="width:610px; height:100px;"><?php echo $edit_post[0]['message']; ?></textarea>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    
                    <div class="field-content-44" id="ajaxload"></div>
                    <div class="clearfix"></div>
                         
                    <div class="field-content-44">
                        <div class="login_field-content-44-left"><label>Tell us what to post:</label></div>
                        
                        <div class="field-content-44-right left-content-fld">
                            <input id="radio1" class="radio" name="post_to" type="radio" value="nothing" <?php if($edit_post[0]['content_type']=='text') echo 'checked="checked"'; ?> onclick="PermitContent('content_upload','nothing');"  /> Nothing &nbsp;&nbsp;&nbsp;&nbsp;
                        <input id="radio1" class="radio" name="post_to" type="radio" value="photos" <?php if($edit_post[0]['content_type']=='photo') echo 'checked="checked"'; ?> onclick="PermitContent('photo_upload','photos');" /> Photos &nbsp;&nbsp;&nbsp;&nbsp;
                        <input id="radio1" class="radio" name="post_to" type="radio" value="videos" <?php if($edit_post[0]['content_type']=='video') echo 'checked="checked"'; ?> onclick="PermitContent('video_upload','videos');" /> Videos 
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    
                    <div class="field-content-44" style="display:<?php if($edit_post[0]['content_type']=='photo') echo 'block'; else echo 'none'; ?>;" id="photo_upload">
                        <div class="login_field-content-44-left"><label>Upload Photo:</label></div>
                        
                        <div class="field-content-44-right left-content-fld">
                        	<?php echo $form->fileField($model,'photo',array('class'=>'file','style'=>'width:220px;')); ?>
                        </div>
					</div>
                    <div class="clearfix"></div>
                    
                    <?php if($edit_post[0]['content_type'] == 'photo') { ?>
                    <label for="uploadField">
                        <img src="<? echo Yii::app()->request->baseUrl ?>/phpthumb/phpThumb.php?src=<? echo Yii::app()->request->baseUrl ?>/images/fbposts/<?php echo $edit_post[0]['photo']; ?>&h=200&w=230"  /><input type="hidden" name="prev_pic" id="prev_pic" value="<?=$edit_post[0]['photo']?>" />
                    </label>
                    <?php } ?>
                    
                    <div style="display:<?php if($edit_post[0]['content_type']=='video') echo 'block'; else echo 'none'; ?>;" id="video_upload">
                        <div class="login_field-content-44-left"><label>Upload Video:</label></div>
                        
                        <div class="field-content-44-right left-content-fld">
                        	<?php echo $form->fileField($model,'video',array('class'=>'file','style'=>'width:220px;')); ?>
                        </div>
					</div>
                    <div class="clearfix"></div>
                    
                    <?php if($edit_post[0]['content_type'] == 'video') { ?>
                    <label for="uploadField">
                        
                        <?php 
                        
                        $show_main = '<script type="text/javascript"> jwplayer("display_container").setup({ flashplayer: "'.Yii::app()->request->baseUrl.'/assets/js/mediaplayer/player.swf", file: "'.Yii::app()->request->baseUrl.'/images/fbposts/'.$edit_post[0]['video'].'", height: 200, width: 230 }); </script>';
                                    
                        ?>
                        
                        <span id="display_container"><?php echo $show_main; ?></span>
                        
                    </label>
                    <?php } ?>
                    <div class="clearfix"></div>
                    
                    <div class="field-content-44">
                        <div class="login_field-content-44-left"><label>Post this on:</label></div>
                        
                        <div class="field-content-44-right left-content-fld">
                        	<input type="text" name="Fbposts[post_date]" class="datepicker input-cnt-44-two" value="<?php echo $edit_post[0]['post_date']; ?>" />
                			<input type="text" name="Fbposts[post_time]" class="timepicker input-cnt-44-one" value="<?php echo $edit_post[0]['post_time']; ?>" />
                        
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    
                    <?php 
                    
                    $time_zone = User::model()->GetTimeZone();  
                    $user_zone = User::model()->GetUserTimeZone();
                    
                    ?>
                    
                    <div class="field-content-44">
                        <div class="login_field-content-44-left"><label>Time Zone:</label></div>
                        
                        <div class="field-content-44-right left-content-fld">
                        
                            <select name="timezone" id="timezone" style="height:40px; padding:10px; outline:none;">
                            <?php foreach($time_zone as $key=>$value) { ?>
                            <option value="<?php echo $key; ?>" <?php if($edit_post[0]['post_zone']==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                            <?php } ?>
                        </select>
                        
                        </div>
                    </div>
                    <div class="clearfix"></div>
                        
                    <label for="textField">
                        <input id="checkbox2" class="checkbox" name="Fbposts[email_notify]" type="checkbox" value="yes" <?php if($edit_post[0]['email_notify']=='yes') echo 'checked="checked"'; ?> />  Email me when content posted
                    </label>
                        
                    <div class="field-content-44" id="submit_button">
                        <div class="login_field-content-44-left">&nbsp;</div>
                        <div class="field-content-44-right left-content-fld">
                            <input type="submit" value="Update" class="btn" />
                            <input type="hidden" name="post_id" value="<?php echo $_REQUEST['id']; ?>" />
                        </select>
                        
                        </div>
                    </div>
                    <div class="clearfix"></div>
            </div>
            
            <?php $this->endWidget(); ?>
            
        </td>
    </tr>
    </tbody> 
	</table>	
            
<?php } else { ?>
						
<table width="100%"> 
<tbody> 
<tr>
    <td>
    
    <?php $form=$this->beginWidget('CActiveForm', array('id'=>'fbposts-form','enableClientValidation'=>true,'htmlOptions'=>array('enctype'=>'multipart/form-data','class'=>'styled'),'clientOptions'=>array('validateOnSubmit'=>true,),)); ?>
	
    
    <?php if(isset($_POST['Fbposts'])){ ?>
    	
		<div class="alert alert-error">
        	<button type="button" class="close" data-dismiss="alert">&times;</button>
            <? echo $form->errorSummary($model); ?>
		</div>
    
	<? } ?>
    
    <div id="add">
                
		<?php 
                    
        $user_groups = $model->PickUserNewGroup(); 
        $user_pages = $model->UserPages();
        
        ?>
            
        <div style="padding-bottom:10px;">
        <?php if(count($user_groups)==0 && count($user_pages)==0) { ?>
            <center><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/facebook/view/Add">Please create a page to make posts.</a></center>									
        <?php } else { ?>
            <table cellpadding="0" cellspacing="0"> 
            <tbody> 
            <tr>
                <td style="border:none;" width="45%">
                    <?php if(count($user_groups)) { ?>
                    <strong>Select Group</strong>
                    <?php } else echo '&nbsp;'; ?>
                </td>
                <td style="border:none;" width="10%">&nbsp;</td>
                <td style="border:none;" width="45%">
                    <?php if(count($user_pages)) { ?>
                    <strong>Select Page</strong>
                    <?php } else echo '&nbsp;'; ?>
                </td>
            </tr> 
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr> 
                <td>
                    <?php if(count($user_groups)) { ?>
                    <select style="height:40px; padding:10px; outline:none;" name="groups" id="select_groups" onchange="ButtonShowHide();">
                        <option value="0" selected="selected">Select Group</option>
                        <?php foreach($user_groups as $key=>$value) { if(!empty($value)) {   ?>
                        <option value="<?php echo $value['group_id'];?>"><?php echo $value['name'];?></option>
                        <?php } } ?>
                    </select>
                    <?php } else { ?>
                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/location/view/Add" class="button large blue">Add new Location</a>
                    <?php } ?>
                </td> 
                <td style="border:none;" align="center">
                    <?php if(count($user_pages)) { ?>
                    <strong>OR</strong>
                    <?php } else echo '&nbsp;'; ?>
                </td>
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
            </tr>
            </tbody> 
            </table>
        <?php } ?>
        </div>
            
        <hr />
        
        <div class="field-content-44">
            <div class="login_field-content-44-left"><label>Post Title:</label></div>
            <?php
    
            if(!empty($_POST['Fbposts']['name']))
                $text_tit = $_POST['Fbposts']['name'];
            else
                $text_tit = 'Facebook post - created on '.date('m-d-Y');
            ?>
            
            <div class="field-content-44-right left-content-fld">
                <?php echo $form->textField($model,'name',array('class'=>'textbox','value'=>$text_tit)); ?>
            </div>
        </div>
        <div class="clearfix"></div>
        
        <div class="field-content-44">
        	<div class="login_field-content-44-left">&nbsp;</div>
            <div class="field-content-44-right left-content-fld">
                Optional: Enter title or description of post for your own reference, or keep the preformatted title
            </div>
        </div>
        <div class="clearfix"></div>
        
        <div class="field-content-44">
            <div class="login_field-content-44-left"><label>Enter Message:</label></div>
            
            <div class="field-content-44-right left-content-fld">
                <textarea name="textmsg" id="textmsg" class="textarea" onkeypress="GetUrlVals(this.value,event);" style="width:615px; height:100px;"><?php echo $_POST['textmsg'] ?></textarea>
            </div>
            
        </div>
        <div class="clearfix"></div>
        
        <div class="field-content-44" id="ajaxload"></div>
        <div class="clearfix"></div>
          
        <div class="field-content-44">
            <div class="login_field-content-44-left"><label>Tell us what to post:</label></div>
            
            <div class="field-content-44-right left-content-fld">
                <input id="radio1" class="radio" name="post_to" type="radio" value="nothing" checked="checked" onclick="PermitContent('content_upload','nothing');"  /> Nothing &nbsp;&nbsp;&nbsp;&nbsp;
                <input id="radio1" class="radio" name="post_to" type="radio" value="photos" onclick="PermitContent('photo_upload','photos');" /> Photos &nbsp;&nbsp;&nbsp;&nbsp;
                <input id="radio1" class="radio" name="post_to" type="radio" value="videos" onclick="PermitContent('video_upload','videos');" /> Videos 
            </div>
            
        </div>
        <div class="clearfix"></div>
        
        <div class="field-content-44" style="display:none;" id="photo_upload">
            <div class="login_field-content-44-left"><label>Upload Photo:</label></div>
            
            <div class="field-content-44-right left-content-fld">
                <?php echo $form->fileField($model,'photo',array('class'=>'file','style'=>'width:220px;')); ?>
            </div>
            
        </div>
        <div class="clearfix"></div>
        
        <div class="field-content-44" style="display:none;" id="video_upload">
            <div class="login_field-content-44-left"><label>Upload Video:</label></div>
            
            <div class="field-content-44-right left-content-fld">
                <?php echo $form->fileField($model,'video',array('class'=>'file','style'=>'width:220px;')); ?>
            </div>
            
        </div>
        <div class="clearfix"></div>
        
        <div class="field-content-44">
            <div class="login_field-content-44-left"><label>Post this on:</label></div>
            
            <div class="field-content-44-right left-content-fld">
                <input type="text" name="Fbposts[post_date]" class="datepicker input-cnt-44-two" value="<?php echo date('m/d/Y'); ?>" />
                <input type="text" name="Fbposts[post_time]" class="timepicker input-cnt-44-one" value="<?php echo date('h:i',strtotime('+ 10 minute')); ?>" />
            </div>
            
        </div>
        <div class="clearfix"></div>
        
        <?php 
        
        $time_zone = User::model()->GetTimeZone();  
        $user_zone = User::model()->GetUserTimeZone();
        
        ?>
        
        <div class="field-content-44">
            <div class="login_field-content-44-left"><label>Time Zone:</label></div>
            
            <div class="field-content-44-right left-content-fld">
                <select name="timezone" id="timezone" style="height:40px; padding:10px; outline:none;">
                    <?php foreach($time_zone as $key=>$value) { ?>
                    <option value="<?php echo $key; ?>" <?php if($user_zone[0]['timestamp']==$key) echo 'selected' ; else if($key == 33) echo 'selected'; ?>><?php echo $value; ?></option>
                    <?php } ?>
                </select>
            </div>
            
        </div>
        <div class="clearfix"></div>
                
        
        <label for="textField">
			<input id="checkbox2" class="checkbox" name="Fbposts[email_notify]" type="checkbox" value="yes" checked="checked" />  Email me when content posted
        </label>
                
         <div class="field-content-44" id="submit_button" style="display:none;">
            <div class="login_field-content-44-left">&nbsp;</div>
            
            <div class="field-content-44-right left-content-fld" style="border:none;">
            
                <input type="submit" value="Submit" class="btn" />
                
            </div>
            
        </div>
        <div class="clearfix"></div>       
            
    </div>
    
    <?php $this->endWidget(); ?>
        
    </td>
</tr>
</tbody> 
</table>	
            
<?php } ?>
	</div>
</div>

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