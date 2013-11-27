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
					
</script>
		
							
<div id="add">
	<div class="field-content-44">
        <div class="login_field-content-44-left"><label><?php echo getContent('user.newcampaign.selwall',Yii::app()->session['language']); ?></label></div>
        <div class="field-content-44-right left-content-fld">
            <select style="height:40px; padding:10px; outline:none; width:350px;" name="sel_wall" id="sel_wall" onchange="LoadFBWall(this.value,<?php echo Yii::app()->user->user_id; ?>);">
                <option value="0">Select</option>
                <option value="1">Single Wall</option>
                <option value="2">Group of Wall</option>
                <option value="3">All Walls</option>
            </select><span id="fbwall_options" style="margin-left:20px;"></span>
        </div>
        
    </div>
    <div class="clearfix"></div>
    
    <div class="field-content-44">
        <div class="login_field-content-44-left"><label><?php echo getContent('user.newcampaign.posttitle',Yii::app()->session['language']); ?></label></div>
        <div class="field-content-44-right left-content-fld">
            <input type="text" name="fb_post_title" id="fb_post_title" class="small textbox" value="<?php if($PendingFBPost[0]['post_title']) echo $PendingFBPost[0]['post_title']; else echo 'Facebook post - created on '.date('m-d-Y'); ?>" />
        </div>
    </div>
    <div class="clearfix"></div>
     
    <div class="field-content-44">
        <div class="login_field-content-44-left">&nbsp;</div>
        <div class="field-content-44-right left-content-fld">
            <?php echo getContent('user.newcampaign.optional',Yii::app()->session['language']); ?>
        </div>
    </div>
    <div class="clearfix"></div>
    
    <div class="field-content-44">
        <div class="login_field-content-44-left"><label><?php echo getContent('user.newcampaign.entermessage',Yii::app()->session['language']); ?></label></div>
        <div class="field-content-44-right left-content-fld">
            <textarea name="textmsg" id="textmsg" style="width:610px; height:100px;" onkeypress="GetUrlVals(this.value,event);"><?php echo stripslashes($PendingFBPost[0]['message']) ?></textarea>
        </div>
    </div>
    <div class="clearfix"></div>
				
	<div class="field-content-44">
        <div class="login_field-content-44-left"><label><?php echo getContent('user.newcampaign.telluspost',Yii::app()->session['language']); ?></label></div>
        <div class="field-content-44-right left-content-fld">
            <input id="opt_nothing" class="radio" name="post_to" type="radio" value="nothing" <?php if(empty($PendingFBPost[0]['content_type']) || $PendingFBPost[0]['content_type']=='text') echo 'checked'; ?> onclick="PermitContent('content_upload','nothing');" /> <?php echo getContent('user.newcampaign.nothing',Yii::app()->session['language']); ?> &nbsp;&nbsp;&nbsp;&nbsp;
            <input id="opt_photo" class="radio" name="post_to" type="radio" value="photos" <?php if($PendingFBPost[0]['content_type']=='photo') echo 'checked'; ?> onclick="PermitContent('photo_upload','photos');" /> <?php echo getContent('user.newcampaign.photos',Yii::app()->session['language']); ?> &nbsp;&nbsp;&nbsp;&nbsp;
            <input id="opt_video" class="radio" name="post_to" type="radio" value="videos" <?php if($PendingFBPost[0]['content_type']=='video') echo 'checked'; ?> onclick="PermitContent('video_upload','videos');" /> <?php echo getContent('user.newcampaign.videos',Yii::app()->session['language']); ?> 
        </div>
    </div>
    <div class="clearfix"></div>
    
    <div class="field-content-44" style="display:<?php if($PendingFBPost[0]['content_type']=='photo') echo 'block;'; else echo 'none;'; ?>" id="photo_upload">
        <div class="login_field-content-44-left"><label><?php echo getContent('user.newcampaign.uploadphoto',Yii::app()->session['language']); ?></label></div>
        <div class="field-content-44-right left-content-fld">
            <input type="file" name="fb_photo" class="file" style="width:200px;" />
        </div>
    </div>
    <div class="clearfix"></div>
	
    <div class="field-content-44" style="display:<?php if($PendingFBPost[0]['content_type']=='video') echo 'block;'; else echo 'none;'; ?>;" id="video_upload">
        <div class="login_field-content-44-left"><label><?php echo getContent('user.newcampaign.uploadvideo',Yii::app()->session['language']); ?></label></div>
        <div class="field-content-44-right left-content-fld">
            <input type="file" name="fb_videophoto" class="file" style="width:180px;" />
        </div>
    </div>
    <div class="clearfix"></div>
    
    <div class="field-content-44" style="margin-top:10px;">
        <div class="login_field-content-44-left">&nbsp;</div>
        <div class="field-content-44-right left-content-fld">
            <input id="checkbox2" class="checkbox" name="Fbposts[email_notify]" type="checkbox" value="yes" <?php if($PendingFBPost[0]['email_notify']=='yes') echo 'checked'; ?> />  &nbsp; <?php echo getContent('user.newcampaign.emailcontentposted',Yii::app()->session['language']); ?>
        </div>
    </div>
    <div class="clearfix"></div>
	
    <!--<a href="javascript:void(0);" onclick="document.getElementById('fb_content').style.display='none'" class="btn btn-large"><?php echo getContent('user.newcampaign.done',Yii::app()->session['language']); ?></a>-->
                
			
</div>