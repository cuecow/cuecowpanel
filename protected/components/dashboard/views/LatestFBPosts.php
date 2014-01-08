<script>
function IdentifyMe(eve,id,access_token)
{

	if(eve.keyCode == 13)
		PostCommentFB(id,access_token);
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
                    //alert('abc');
			$('#comments_'+id).html(data.msg);
			$('#comment_'+id).val('');
		},
		error : function(XMLHttpRequest, textStatus, errorThrown) {}
	});	
}

</script>

<?php if(count($records)) { 
     
    //$w=1;                                
    foreach($records as $key=>$value)
    { 
        if($_REQUEST['page'] != '')
                $frst_page = $_REQUEST['page'];
        
        if($value['page_id'])
            $frst_page = $value['page_id'];

        $res_fbposts = Cron::model()->CronUserPageToken($frst_page, Yii::app()->user->user_id);
        
        //if($w==1)
        //{

        ?>
<!--            <input type="hidden" id="current_page" value="<?php //echo $frst_page; ?>" />
            <input type="hidden" id="current_token" value="<?php //echo $res_fbposts['token']; ?>" />-->

<?php

        //}

        //$w++;
                   
     } 
            		
}

if($frst_page)
{

		$fbposts_get = Fbposts::model()->GetPageToekn($frst_page);
		
		$feed_content = json_decode(@file_get_contents('https://graph.facebook.com/'.$frst_page.'/feed?access_token='.$fbposts_get[0]['token']));
		
		$get_page_name = Fbposts::model()->GetFBPageName($frst_page);
		$page_name_mine = strtolower($get_page_name[0]['page_name']);
			
		$posted_by_me = array();
		$posted_by_others = array();
                
                //var_dump($feed_content); die();
			
		if($feed_content)
		{
			foreach($feed_content as $key => $value)
			{
				foreach($value as $keys=>$values)
				{	
					if(!empty($values->message))
					{
                                            array_push($posted_by_me,$values);
						//if($values->from->id == $frst_page)
							//array_push($posted_by_me,$values);
						//else
							//array_push($posted_by_others,$values);
					}
				}
			}
		}
							
		?>
        
		<div class="tab-content">
        	
            <div class="tab-pane active" id="tab1">
            	
    <span id="post_content">
                
<!--                <div class="quick_comment_cntnr" id="add_new_post1" align="center" style="display:none;">
                    <img src="<?php //echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" />
                </div>-->
                <?php

if($posted_by_me)
{
    //var_dump('ac'); die();
    $count = 0;
	$j = 1;
	
	foreach($posted_by_me as $key => $values)
    {
            if($count == 10)
            {
                break;
            }
    	if(!empty($values->message))
		{ 
			//$comments_feed = json_decode(@file_get_contents('https://graph.facebook.com/'.$values->id.'/comments?access_token='.$fbposts_get[0]['token'].'&limit=1000'));
			
?>
<div id="div_msg<?php echo $values->id; ?>" class="well well-small post_width" style="float:left;">
	<div id="div_<?php echo $values->id; ?>" style="display:block; background:#FFF; padding:10px;border-radius:6px ; -moz-border-radius:6px; width:95%; float:left;">
    
    <!-- post's details -->
    <div style="width:100%; border-bottom:#EEE 1px solid; float:left;">
                        
        <div style="padding-bottom:10px; width:12%; margin-left:2%; float:left;">
            <img src="https://graph.facebook.com/<?php echo $frst_page; ?>/picture?type=square" />
        </div>
                        
		<div style="width:76%; float:left;">
        	<table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td class="facebook_pagename"><?php echo $values->from->name; ?></td>
            </tr>
            <tr>
                <td>
                    <?php 
                                
                    if($values->created_time) 
                    {
                        $temp_t1 = explode('T',$values->created_time);	
                        $date_t = $temp_t1[0];
                                                            
                        if($temp_t1[1])
                            $temp_t2 = explode('+',$temp_t1[1]);
                                                            
                        $time_t = $temp_t2[0];
                    }
                                                        
                    ?>
                        <span class="facebook_time">
                            <?php echo $date_t.' at '.$time_t; ?>
                            <?php if($values->application->name) echo 'via '.$values->application->name; ?>
                        </span>
                </td>
            </tr>
            </table>
		</div>
     
    </div>
                    
    <!-- post's message -->
    <div style="float:left; width:100%; padding-top:5px;">
        <span class="facebook_message">
            <?php echo $values->message; ?>
        </span>
    </div>
                    
    <!-- if post has picture in it -->
    <div class="facebook_picture">
        <?php if($values->picture) { ?>
            <div class="facebook_image"><img src="<?php echo $values->picture; ?>" /></div>
        <?php } ?>
    </div>
                    
    <!-- View all comments div -->
      
                    </div>
                    
                    <div style="margin:-9px; float:left; width:103.4%; margin-top:15px; border-top:#EEE 1px solid;" id="comments_box_<?php echo $values->id; ?>">
                        <div style="width:98%; padding:10px 0px 10px 20px; border:#000 0px solid;">
                            <div class="cmnt_position">
                            <img src="https://graph.facebook.com/<?php echo $frst_page; ?>/picture?type=square" width="35" height="32" />  &nbsp; </div>
                            <input type="text" name="comment_<?php echo $values->id; ?>" id="comment_<?php echo $values->id; ?>" placeholder="Post a comment ..." onkeyup="IdentifyMe(event,'<?php echo $values->id; ?>','<?php echo $fbposts_get[0]['token']; ?>');" style="width:82%;" />
                        </div>
                    </div>
                 
                 </div>
            
	<?php
		}
                $count++;
	}
?>
	<div style="float:left; width:100%;" id="more_data"></div>
    <?php
    
}
?>
                </div>
              </span>
                
            </div>
				
<!--            <div class="tab-pane" id="tab2">
            	
                <span id="post_content_others">
                
				<div class="quick_comment_cntnr" id="add_new_post2" align="center" style="display:none;">
                	<img src="<?php //echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" />
                </div>
	                
				
                
                </span>
                
			</div>        -->
 
<!--    <script>
    
    $('#FBTab a').click(function (e) {
      e.preventDefault();
      $(this).tab('show');
    })
    
    </script>-->
    	   
	<?php }
?>

