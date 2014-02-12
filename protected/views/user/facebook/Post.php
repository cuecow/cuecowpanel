<?php if(count($records)) { ?>

<div class="span6">
	<div class="accordion" id="accordion1">
    	<div class="accordion-group">
			<div class="accordion-heading">
            	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne" title="Click to open/close">Facebook Pages</a>
			</div>
            <div id="collapseOne" class="accordion-body collapse in">
            	<div class="accordion-inner">
                  
                    <table class="table table-hover" style="width:100%;">  
                    <thead> 
                    <tr> 
                        <th width="66%"><strong>Wall Name</strong></th>
                        <th width="17%"><strong>Fans</strong></th>
                        <th width="17%"><strong>New Posts</strong></th>
                    </tr> 
                    </thead> 
                    <tbody> 
                                    
                    <?php 
                                    
                    $w=1;

                    foreach($records as $key=>$value)
                    { 
						if($_REQUEST['page'] != '')
							$frst_page = $_REQUEST['page'];
                        if($value['page_id'] && $w==1)
                            $frst_page = $value['page_id'];
                        
                        
						$res_fbposts = Cron::model()->CronUserPageToken($frst_page, Yii::app()->user->user_id);

                    ?>
                    <tr> 
                        <td>
                            <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/facebook/view/post/page/<?php echo $value['page_id']; ?>"><?php echo $value['page_name']; ?></a>
                            <!--<span class="pressme" id="<?php echo $value['page_id']; ?>_<?php echo $res_fbposts['token']; ?>" style="cursor:pointer; color:#39F;"><?php echo $value['page_name']; ?></span>-->
                        </td> 
                        <td class="center"><?php echo $value['fans']; ?></td> 
                        <td class="center"><?php echo $value['new_post']; ?></td> 
                    </tr>
                    
					<?php 
                    
                    		if($w==1)
                    		{
                    
                    ?>
								<input type="hidden" id="current_page" value="<?php echo $frst_page; ?>" />
								<input type="hidden" id="current_token" value="<?php echo $res_fbposts['token']; ?>" />
                                        
                    <?php
					
                    		}
                    		
							$w++;
					} 
            		?>
                    </tbody> 
                    </table>
            
    			</div>
			</div>
		</div>
	</div>
</div>
            
<?php } else { ?>

<div class="alert alert-error">
	No page added yet
</div>
  
<?php } ?>

<?php
	
if($frst_page)
{
	
?>
	<div class="span6">
		
        <ul class="nav nav-tabs" id="FBTab">
        	<li class="active"><a href="#tab1" data-toggle="tab">Own Posts</a></li>
          	<li><a href="#tab2" data-toggle="tab">Posts by Others</a></li>
            <div style="float:right;">
               	<input type="button" value="Add New Post" class="btn" onclick="window.location.href='<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/fbposts'" />
            </div>
        </ul>
        
        
        <?php    
                    
		$fbposts_get = Fbposts::model()->GetPageToekn($frst_page);
		
		$feed_content = json_decode(@file_get_contents('https://graph.facebook.com/'.$frst_page.'/feed?access_token='.$fbposts_get[0]['token']));
		
		$get_page_name = Fbposts::model()->GetFBPageName($frst_page);
		$page_name_mine = strtolower($get_page_name[0]['page_name']);
			
		$posted_by_me = array();
		$posted_by_others = array();
			
		if($feed_content)
		{
			foreach($feed_content as $key => $value)
			{
				foreach($value as $keys=>$values)
				{	
					if(!empty($values->message))
					{ 
						if($values->from->id == $frst_page)
							array_push($posted_by_me,$values);
						else
							array_push($posted_by_others,$values);
					}
				}
			}
		}
							
		?>
        
		<div class="tab-content">
        	
            <div class="tab-pane active" id="tab1">
            	
                <span id="post_content">
                
                <div class="well">
                
                <fieldset>
                
                	<img src="https://graph.facebook.com/<?php echo $frst_page; ?>/picture?type=square" width="35" height="32" /> &nbsp; <input type="text" class="fb-comment-field-style" id="quickcomment1" placeholder="Enter new Post ..." style="width:85%;" />
                    
                    <div class="clearfix"></div>
                    
                	<input type="button" value="Submit" class="btn btn-info btn-post-page" onclick="QuickPost(1);" />
                    
              	</fieldset>
                
                </div>
                
                <div class="quick_comment_cntnr" id="add_new_post1" align="center" style="display:none;">
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" />
                </div>
                <?php
                $own = 1;
                include('fb_comments.php');
                $own = 0;
                ?>
                
                </span>
                
            </div>
				
            <div class="tab-pane" id="tab2">
            	
                <span id="post_content_others">
                
            	<div class="well">
                
                    <fieldset>
                    
                        <img src="https://graph.facebook.com/<?php echo $frst_page; ?>/picture?type=square" width="35" height="32" /> &nbsp; <input type="text" id="quickcomment2" class="fb-comment-field-style" placeholder="Enter new Post ..." style="width:85%;" />
                        
                        <div class="clearfix"></div>
                        
                        <input type="button" value="Submit" class="btn btn-info btn-post-page" onclick="QuickPost(2);" />
                        
                    </fieldset>
                
                </div>
                
				<div class="quick_comment_cntnr" id="add_new_post2" align="center" style="display:none;">
                	<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" />
                </div>
	        <?php
                    $own = 0;
                    include('fb_comments.php');
                    $own = 1;
                ?>
                
                </span>
                
			</div>        
		</div>
	</div>
</div>
                    
    
    <script>
    
    $('#FBTab a').click(function (e) {
      e.preventDefault();
      $(this).tab('show');
    })
    
    </script>
    	
    
	<?php } ?> 
    </div>
            

<div id="add_post_form add-form-post-page" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
  		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    	<h3 id="myModalLabel">Terms of use</h3>
  	</div>
  	<div class="modal-body"><?php //include('addpost_form.php'); ?></div>
</div>  

<!--<div id="add_post_form"></div>-->

<script>

function ShowHideAddPostForm()
{
	var display = $("#add_post_form").css("display");
	
	if(display == 'none')
	{
		$("#add_post_form").fadeIn('slow');
	    $("#overlay").show().css({"opacity": "0.5"});
	}
	else if(display == 'block')
	{
		$("#overlay").hide().css({"opacity": "0"});
		$("#add_post_form").fadeOut('slow');
		$('#error_addform').hide();
		$('#error_addform').html('');
	}
}

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

function CheckPostForm()
{
	var err = '';
	var count = 0;

	if($('#select_groups').val()==0 && $('#select_pages').val()==0)
	{
		err += '&bull; Select one group OR one page for this post.<br />';
		count++;
	}
	
	if($('#Fbposts_name').val()=='')
	{
		err += '&bull; Please enter post title.<br />';
		count++;
	}
	
	if($('#Fbposts_name').val()=='')
	{
		err += '&bull; Please enter post title.<br />';
		count++;
	}
	
	if($('#textmsg').val() == '')
	{
		err += '&bull; Please enter post description.<br />';
		count++;
	}
	
	if($('#field1').val() == '' || $('#field2').val() == '')
	{
		err += '&bull; Please enter time to submit this post.<br />';
		count++;
	}
	
	if($('#timezone').val() == 0)
	{
		err += '&bull; Please select timezone.<br />';
		count++;
	}
	
	if(err!='' && count>0)
	{
		$('#error_addform').html(err);
		$('#error_addform').show();
		
		return false;
	}
	else
	{
		$('#error_addform').html('');
		$('#error_addform').hide();
		
		return true;	
	}
}


</script>