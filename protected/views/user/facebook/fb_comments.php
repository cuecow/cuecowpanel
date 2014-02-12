<?php

if($own == 1)
{
    $posted_by_me = $posted_by_me;
}
else
{
    $posted_by_me = $posted_by_others;
}

if($posted_by_me)
{
	$j = 1;
	
	foreach($posted_by_me as $key => $values)
    {
    	if(!empty($values->message))
		{ 
			$comments_feed = json_decode(@file_get_contents('https://graph.facebook.com/'.$values->id.'/comments?access_token='.$fbposts_get[0]['token'].'&limit=1000'));
			
?>
<div id="div_msg<?php echo $values->id; ?>" class="well well-small fb-commentbox-cnt post-div-fb-comments">
	<div id="div_<?php echo $values->id; ?>" class="post-div-fb-comments-inner">
    
    <!-- post's details -->
    <div class="post-detail-fb-comments">
                        
        <div class="post-detail-inner-fb-comments">
            <img src="https://graph.facebook.com/<?php echo $values->from->id; ?>/picture?type=square" />
        </div>
                        
		<div class="post-detail-inner-fb">
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
                        
        <div class="post-detail-last-fb-comments" align="right">
            <a href="javascript:void(0);" onclick="javascript:show_confirm('<?php echo $values->id; ?>','<?php echo $fbposts_get[0]['token']; ?>','Are you sure, you want to delete this post?');"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/close.png" border="0" /></a>
        </div>       
        
    </div>
                    
    <!-- post's message -->
    <div class="post-message-fb-comments">
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
    <?php
        //var_dump(count($values->comments->data)); die();
    if(count($values->comments->data) > 3) {
        ?>
    
    <div class="facebook_comments" id="show_fullcomments_<?php echo $values->id; ?>" align="center">
        <a href="javascript:void(0);" onclick="show_all_comments('<?php echo $values->id; ?>');" style="text-decoration:underline;">view all <?=$values->comments->count?> comments</a>
    </div>
    <?php } ?>
                    
    <div class="post-all-cmnts-fb">
    
        <?php  $lastest_comment = array(); if(count($values->comments->data) > 0 && count($comments_feed)) { ?>
        
        <!-- All Comment div -->                  
        <div id="comments_<?php echo $values->id; ?>" class="post-all-cmnts-inner-fb">
        <table class="table-content-brd" style="margin-bottom:5px;" class="table">
        <tr>
            <td> 
                <div class="post-comnts-inner-fb">
                <table style="margin-bottom:5px;">
				<?php
                
                if(count($values->comments->data) > 3)
                {
                    $countt = count($values->comments->data);
                    $start_fill = $countt - 3;
                }
                else
                    $start_fill = 1;
                
                $h= 1;
                
                foreach($comments_feed->data as $key1=>$value1)
                {
                ?>
					<tr>
                        <td width="60">
                            <?php 
                            if($value1->from->id)
                                echo '<img src="https://graph.facebook.com/'.$value1->from->id.'/picture?type=square" width="40" height="40" />'; 
                            ?>
                        </td>
                        <td>
                            <table  class="post-all-tbl-fb">
                            <tr>
                                <td>
                                    <span class="post-tbl-span-fb">
                                        <?php echo $value1->from->name; ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span style="color:#000;">
                                        <?php echo $value1->message; ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php
                                    if($value1->created_time) 
                                    {
                                        $temp_t_1 = explode('T',$value1->created_time);	
                                        $date_t_1 = $temp_t_1[0];
                                                                                    
                                        if($temp_t_1[1])
                                            $temp_t_2 = explode('+',$temp_t_1[1]);
                                                                                    
                                        $time_t_2 = $temp_t_2[0];
                                    } ?>
                                    
                                    <span class="facebook_time">
                                        <?php echo $date_t_1.' at '.$time_t_2;; ?>
                            
                                    </span>
                                    
                                    
                                </td>
                            </tr>
                            </table>
                        </td>
                    </tr>
					<?php
                        
                        if($h>=$start_fill)
                            array_push($lastest_comment,$value1);
                        
                        $h++;
                    }
                    ?>
                    </table>                                    
                    </div>
                
                </td>
            </tr>
            </table>
            </div>
                        
            <!-- Short Comment div -->
            <div id="short_comments_<?php echo $values->id; ?>" class="comment-fb-box-outer shrt-cmnt-fb-comments">
                <table class="shrt-tbl-fb-comments">
				<?php
                    
                    if(count($lastest_comment))
                    {
                        foreach($lastest_comment as $key1=>$val1)
                        {
                            ?>
                            <tr>
                                <td width="60">
                                <?php 
                                if($val1->from->id)
                                    echo '<img src="https://graph.facebook.com/'.$val1->from->id.'/picture?type=square" width="40" height="40" />'; 
                                ?>
                                </td>
                                <td>
                                    <table class="fb-comment-table-cnt shrt-tbl-inner-fb">
                                    <tr>
                                        <td class="page-fb-name-td">
                                            <span class="shrt-inner-span-fb"><?php echo $val1->from->name; ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span style="color:#000;">
                                                <?php echo $val1->message; ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <?php
                                        if($val1->created_time) 
                                        {
                                            $temp_t_1 = explode('T',$val1->created_time);	
                                            $date_t_1 = $temp_t_1[0];
                                                
                                            if($temp_t_1[1])
                                                $temp_t_2 = explode('+',$temp_t_1[1]);
                                                
                                            $time_t_2 = $temp_t_2[0];
                                        }
                                        
                                        //echo $date_t_1.' at '.$time_t_2;
                                        ?>
                                    <span class="facebook_time">
                                        <?php echo $date_t_1.' at '.$time_t_2;; ?>
                            
                                    </span>
                                        </td>
                                    </tr>
                                    </table>
                                </td>
                            </tr>
						  <?php
                              }
                          }
                      ?>
                      </table>
                  </div>
                    
                    <?php } ?>
                    
                    </div>
                    
                    <div class="shrt-tbl-outter-fb-cmnt" id="comments_box_<?php echo $values->id; ?>">
                        <div class="inner-div-fb-cmnt">
                            <img src="https://graph.facebook.com/<?php echo $frst_page; ?>/picture?type=square" width="35" height="32" /> &nbsp;
                            <input type="text" class="fb-comment-field-style" name="comment_<?php echo $values->id; ?>" id="comment_<?php echo $values->id; ?>" placeholder="Post a comment ..." onkeyup="IdentifyMe(event,'<?php echo $values->id; ?>','<?php echo $fbposts_get[0]['token']; ?>');" style="width:82%;" />
                        </div>
                    </div>
                 
                 </div>
            </div>
	<?php
		}
	}
?>
	<div class="ouuter-div-fb-comments" id="more_data"></div>
    <?php
    if($value->next)
    {
        $next_feed = @file_get_contents($value->next);
        $next_result = json_decode($next_feed);
        $next_feed_count = count($next_result->data);
                                                        
        if($next_feed_count)
        {
    ?>
           <!-- <tr><td align="right" id="show_more"><a href="javascript:void(0);" onclick="javascript:ShowMoreData('<?php echo $value->next; ?>','more_data','<?php echo $fbposts_get[0]['token']; ?>');" style="color:#FFF; font-weight:bold; text-decoration:underline;">Show more</a></td></tr>-->
    
    <?php
        }
    }
}
$flag = 0;
?>