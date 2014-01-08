<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript">

function show_hide(id)
{
	var cur_display=document.getElementById(id).style.display;
	
	if(cur_display=='block')
		document.getElementById(id).style.display='none';
	else if(cur_display=='none')
		document.getElementById(id).style.display='block';
}

function PermitContent(id,status)
{
	document.getElementById('text').style.display='none';
	document.getElementById('photo').style.display='none';
	document.getElementById('video').style.display='none';
	
	document.getElementById(id).style.display='block';
}

function ShedulePost(status)
{
	if(status==true)
		document.getElementById('dates').style.display='block';
	else
		document.getElementById('dates').style.display='none';
}

function QuickPost(cmfrm)
{
	var pageid = $('#current_page').val();
	var token = $('#current_token').val();
	var userid = $('#unique_user').val();
	
	if($('#quickcomment1').val()!='Enter new Post ...' && $('#quickcomment1').val()!='')
	{
		var comment = $('#quickcomment1').val();
		var resetbox = 'quickcomment1';
	}
	else if($('#quickcomment2').val()!='Enter new Post ...')
	{
		var comment = $('#quickcomment2').val();
		var resetbox = 'quickcomment2';
	}
	
	if(pageid && token && comment)
	{
		$('#add_new_post'+cmfrm).show();
		
		$.ajax({
			type : 'POST',
			url : '<?php echo Yii::app()->request->baseUrl; ?>/ajax/QuickPost.php',
			dataType : 'json',
			contentType: "application/x-www-form-urlencoded;charset=UTF-8",
			data: 'pageid='+ pageid + '&userid='+ userid + '&token='+ token +'&comment='+ comment,
			success : function(data)
			{
				$('#add_new_post'+cmfrm).hide();
				
				$('#'+resetbox).val('Post a comment ...');
				
//				var pathname = window.location.pathname;
//                                top.location.href = pathname;
                                LoadPageAgain(pageid,userid,token);
				
			},
			error : function(jqXHR, XMLHttpRequest, textStatus, errorThrown) {
				//alert(jqXHR.responseText);
			}
		});		
	}
}

function LoadPageAgain(pageid,userid,token)
{
	$('#post_content').html('<center><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" /></center>');
	
	$.ajax({
		type : 'POST',
		url : '<?php echo Yii::app()->request->baseUrl; ?>/ajax/loadwall.php',
		dataType : 'json',
		contentType: "application/x-www-form-urlencoded;charset=UTF-8",
		data: 'pageid='+ pageid + '&userid='+ userid + '&token='+ token,
		success : function(data){
			$('#post_content').html(data.msg);
			$('#post_content_others').html(data.msg_other);

			$('#current_page').val(pageid);
			$('#current_token').val(token);
		},
		error : function(jqXHR, XMLHttpRequest, textStatus, errorThrown) {
			//alert(jqXHR.responseText);
			$('#post_content').html('<center><spa style="color:#FFF;">Wall post not found.</span></center>');
		}
	});	
}

$(function(){
	
	$('.pressme').live("click",function(event){

		var temp_id = event.target.id;
		var strings = temp_id.split("_");

		var pageid = strings[0];
		var userid = $('#unique_user').val();
		var token =strings[1];

		$('#post_content').html('<center><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" /></center>');

		$.ajax({
			type : 'POST',
			url : '<?php echo Yii::app()->request->baseUrl; ?>/ajax/loadwall.php',
			dataType : 'json',
			contentType: "application/x-www-form-urlencoded;charset=UTF-8",
			data: 'pageid='+ pageid + '&userid='+ userid + '&token='+ token,
			success : function(data){
				$('#post_content').html(data.msg);
				$('#post_content_others').html(data.msg_other);
				
				$('#current_page').val(pageid);
				$('#current_token').val(token);
			},
			error : function(jqXHR, XMLHttpRequest, textStatus, errorThrown) {
				$('#post_content').html('<center><spa style="color:#FFF;">Wall post not found.</span></center>');
			}
		});	
		
	})
})

/*function LoadWall(pageid,userid,token)
{
	$('#post_content').html('<center><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" /></center>');

	$.ajax({
		type : 'POST',
		url : '<?php echo Yii::app()->request->baseUrl; ?>/ajax/loadwall.php',
		dataType : 'json',
		contentType: "application/x-www-form-urlencoded;charset=UTF-8",
		data: 'pageid='+ pageid + '&userid='+ userid + '&token='+ token,
		success : function(data){
			$('#post_content').html(data.msg);
		},
		error : function(jqXHR, XMLHttpRequest, textStatus, errorThrown) {
			//alert(jqXHR.responseText);
			$('#post_content').html('<center><spa style="color:#FF0000;">Wall post not found.</span></center>');
		}
	});	
}*/

function ShowMoreData(url,id,accesstoken)
{
	$('#'+id).html('<center><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" /></center>');

	$.ajax({
		type : 'POST',
		url : '<?php echo Yii::app()->request->baseUrl; ?>/ajax/loadmorewall.php',
		dataType : 'json',
		data: 'url='+ url + '&accesstoken='+ accesstoken,
		success : function(data){
			$('#show_more').html('');
			$('#post_content').append(data.msg);
			$('#post_content_others').append(data.msg_other);
			$('#'+id).html('');
			//$('#show_more').html(data.showmore);
		},
		error : function(XMLHttpRequest, textStatus, errorThrown) {
			$('#'+id).html('<center><spa style="color:#FF0000;">Wall post not found.</span></center>');
		}
	});	
}

function PostComment(id,accesstoken)
{
	$('#cnt_'+id).html('<textarea name="comment_'+ id +'" id="comment_'+ id +'" style="width:300px; outline:none;"></textarea><br /><input type="button" value="post" class="button small blue" onclick="PostCommentFB(\''+id+'\',\''+ accesstoken +'\');" /><input type="button" value="cancel" class="button small blue" onclick="CancelComment(\''+ id +'\')" />');
}

function CancelComment(id)
{
	$('#cnt_'+id).html('<a href="javascript:PostComment(\''+ id +'\');">Post Comment</a>');
}

function PostCommentFB(id,accesstoken)
{
	var msg = $("#comment_"+ id).val();
	if(msg!='')
	{
		CommenttoFB(id,msg,accesstoken);	
	}
	
	$('#cnt_'+id).html('<a href="javascript:PostComment(\''+ id +'\');">Post Comment</a>');
}

function CommenttoFB(id,message,accesstoken)
{
	$('#comments_'+id).html('<tr><td><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" /></td></tr>');

	$.ajax({
		type : 'POST',
		url : '<?php echo Yii::app()->request->baseUrl; ?>/ajax/postcomment.php',
		dataType : 'json',
		data: 'id='+ id + '&msg='+ message + '&accesstoken='+ accesstoken,
		success : function(data){
                    alert('abc');
			$('#comments_'+id).html(data.msg);
			$('#comment_'+id).val('');
		},
		error : function(XMLHttpRequest, textStatus, errorThrown) {}
	});	
}

function show_confirm(id,token,txt)
{
	var r=confirm(txt);
	
	if(r==true)
  	{
		DeletePost(id,token);
  	}
}

function DeletePost(id,token)
{
	$.ajax({
		type : 'POST',
		url : '<?php echo Yii::app()->request->baseUrl; ?>/ajax/deletepost.php',
		dataType : 'json',
		data: 'id='+ id + '&accesstoken='+ token,
		success : function(data)
		{
			//if(data.msg==1)
			$('#div_'+id).html('');
                        $('#div_msg'+id).hide();
		},
		error : function(XMLHttpRequest, textStatus, errorThrown) {//alert(errorThrown);
		}
	});	
}

function show_all_comments(id)
{
    alert('abc'); 
	document.getElementById('comments_'+id).style.display = 'block';
	document.getElementById('short_comments_'+id).style.display = 'none';
	document.getElementById('show_fullcomments_'+id).style.display = 'none';
}


</script>

<input type="hidden" id="unique_user" value="<?php echo Yii::app()->user->user_id; ?>" />

<div class="container container-top">
	<div class="row-fluid">

<?php if($show_choose_message == 'yes') { ?>
<div class="container_4 no-space push-down">
    <div class="alert-wrapper error clearfix">
        <div class="alert-text">
            We found more pages from your facebook account than your cuecow account allows you. Choose from them to activate, by <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/profile/view/selwall">Click here</a>.
            <a href="#" class="close">Close</a>
        </div>
    </div>
</div>
<?php } ?>

<div class="container_4" style="padding-top:20px; background:#FFF;">
	<div class="grid_4" style="background:#FFF; border:none;">
		<div class="panel" style="background:#FFF; border:none;">
			
			<div class="content">
			
			<?php
			
			if($_REQUEST['view']=='Add')
			{ 
						
			?>
					
				<div style="border:#000000 0px solid; margin:50px 150px 50px 150px; width:870px;">
				
					<?php $form=$this->beginWidget('CActiveForm', array('id'=>'fbpage-form','enableClientValidation'=>true,'htmlOptions'=>array('class'=>'styled'),'clientOptions'=>array('validateOnSubmit'=>true,),)); ?>
						
					<?php if(isset($_POST['Fbpages'])){ ?>
													
					<div class="container_4 no-space push-down">
						<div class="alert-wrapper error clearfix">
							<div class="alert-text">
								<? echo $form->errorSummary($model); ?>
								<a href="#" class="close">Close</a>
							</div>
						</div>
					</div>
							
			<? } ?>

			<fieldset>
							
				<!-- Text Field -->
				<!--<label for="textField">
					<span class="field_title">Enter FB Page Name:</span>
					<?php echo $form->textField($model,'page_name',array('class'=>'textbox')); ?>
				</label>-->
				<label for="textField">
					<span class="field_title">Enter FB Page URL:</span>
					<?php echo $form->textField($model,'page_id',array('class'=>'textbox')); ?>
				</label>
				<label for="textField">
					<span class="field_title">Content for Public:</span>
					<?php echo $form->textArea($model,'for_public',array('class'=>'editor','id'=>'editor1')); ?> 
										
					<script type="text/javascript">
						CKEDITOR.replace( 'editor1', {
						extraPlugins : 'tableresize',
						toolbar : 'MyToolbar'
						});
					</script>				
				</label>
				<label for="textField">
					<span class="field_title">Content for Fans:</span>
					<?php echo $form->textArea($model,'for_fan',array('id'=>'editor2','class'=>'ckeditor')); ?> 
								
					<script type="text/javascript">
						CKEDITOR.replace( 'editor2', {
						extraPlugins : 'tableresize',
						toolbar : 'MyToolbar'
					});
					</script>				
				</label>
				
                <!-- Buttons -->
				<div class="non-label-section"><input type="submit" value="Submit" class="button medium green float_right" /></div>

				<span><a class="button small" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/facebook">Cancel</a></span>
						
				</fieldset>
						
			<?php $this->endWidget(); ?>

			</div>
					
<?php } else if($_REQUEST['view']=='View') { ?>
					
<ul class="tabs">
	<li><a href="#tab1">Public's Content</a></li>
	<li><a href="#tab2">Fan's Content</a></li>
</ul>
								
<div class="content tabbed">
	<div class="tab_container">
		<div id="tab1" class="tab_content">
			<div class="fb_preview">
				<div class="dummy_container">
					<div class="fb_container" style="min-height:700px;">
						<?php echo $spec_rec[0]['for_public']; ?>
					</div>
				</div>
			</div>
		</div>	
		<div id="tab2" class="tab_content">
			<div class="fb_preview">
				<div class="dummy_container">
					<div class="fb_container" style="min-height:700px;">
						<?php echo $spec_rec[0]['for_fan']; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>			
					
<?php } 

	else if($_REQUEST['view']=='post') { include('facebook/Post.php'); } 
		
	else if($_REQUEST['view']=='Manage') { 
		include('facebook/ManagePages.php'); 
	
	} else { 
	
?>
					
		<table class="styled" style="border:none;"> 
		<tbody> 
		<tr>
			<td style="border:none;">
			<?php if(count($records)) {	 ?>
				<table id="tablesorter-sample" class="styled" cellpadding="0" cellspacing="1"> 
				<thead> 
				<tr> 
					<th><strong>S. No.</strong></th> 
					<th width="200px;"><strong>Name</strong></th> 
					<th><strong>Page URL</strong></th> 
					<th><strong>Action</strong></th> 
				</tr> 
				</thead> 
				<tbody> 					
				<?php
								
				$g=1;
				foreach($records as $key=>$value)
				{ 
				
				?>
				<tr> 
                	<td align="center"><?php echo $g; ?></td> 
                    <td><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/facebook/view/View/id/<?php echo $value['id']; ?>"><?php echo $value['page_name']; ?></a></td> 
                    <td align="center"><?php echo $value['page_url']; ?></td> 
                    <td align="center">
                        <a class="icon-button edit" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/editfacebook/id/<?php echo $value['id']; ?>" title="Edit Page">Edit</a>
                        <a class="icon-button delete" href="javascript:void(0);" onclick="javascript:confirmSubmit('<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/deletefacebook/id/<?php echo $value['id']; ?>');" title="Delete Page">Delete</a>
                    </td>
                </tr>
				<?php 						
				
				$g++;
				} 
				?>
				</tbody> 
				</table>
				<?php } else { ?>
				<div class="container_4 no-space">
					<div class="alert-wrapper error clearfix">
						<div class="alert-text" align="center">
							No Pages added yet. Add a new one by clicking "Add new Page" link above.
						</div>
					</div>
				</div>
				<?php } ?>
				</td>
			</tr>
			</tbody> 
			</table>		
			<?php } ?>			
		</div>	
	</div>
</div>
</div>


<script>

function confirmSubmit(url)
{
	var agree=confirm("Are you sure you wish to continue?");

	if (agree)
	{
		window.location.href=url;
		return true;
	}
	else
		return false ;
}

function IdentifyMe(eve,id,access_token)
{
	if(eve.keyCode == 13)
		PostCommentFB(id,access_token);
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