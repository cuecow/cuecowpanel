<?php

if($posted_by_others)
{
	$j = 1;
	foreach($posted_by_others as $key => $values)
    {
    	if(!empty($values->message))
		{ 
			$comments_feed = json_decode(@file_get_contents('https://graph.facebook.com/'.$values->id.'/comments?access_token='.$fbposts_get[0]['token'].'&limit=1000'));
			
?>
			<div id="div_<?php echo $values->id; ?>" style="display:block; background:#FFF; padding:10px; margin-bottom:20px; border-radius:6px ; -moz-border-radius:6px; width:95%; float:left;">
            	<!-- post's details -->
                <div style="width:100%; border-bottom:#CCC 1px solid; float:left;">
                    
                    <div style="padding-bottom:10px; width:12%; margin-left:2%; float:left;">
                        <img src="https://graph.facebook.com/<?php echo $frst_page; ?>/picture?type=square" />
                    </div>
                    
                    <div style="width:76%; float:left;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td>
                                <span style="font-family:Verdana, Geneva, sans-serif; font-size:11px; color:#036; font-weight:bold;"><?php echo $values->from->name; ?></span>
                            </td>
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
                                    <span style="font-family:Verdana, Geneva, sans-serif; font-size:11px; color:#666; padding-top:10px;">
                                        <?php echo $date_t.' at '.$time_t; ?>
                                        <?php if($values->application->name) echo 'via '.$values->application->name; ?>
                                    </span>
                            </td>
                        </tr>
                        </table>
                    </div>
                    
                    <div style="width:10%; float:left;" align="right">
                        <a href="javascript:void(0);" onclick="javascript:show_confirm('<?php echo $values->id; ?>','<?php echo $fbposts_get[0]['token']; ?>','Are you sure, you want to delete this post?');"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/close.png" border="0" /></a>
                    </div>       
                    
                </div>
                
                <!-- post's message -->
                <div style="float:left; width:100%; padding-top:5px;">
                    <span style="font-size:11px; font-family:Verdana, Geneva, sans-serif; padding-bottom:15px;">
                        <?php echo $values->message; ?>
                    </span>
                </div>
                
                <!-- if post has picture in it -->
                <div style="float:left; width:100%; padding-top:10px;">
                    <?php if($values->picture) { ?>
                        <div style="border:#999 0px solid; padding:5px;"><img src="<?php echo $values->picture; ?>" /></div>
                    <?php } ?>
                </div>
                
                <!-- View all comments div -->
                <?php if($values->comments->count>3) { ?>
                <div style="padding:5px 4px 5px 5px; width:101.8%; height:37px; font-family:Verdana, Geneva, sans-serif; font-size:11px; margin-top:15px; margin-left:-1.8%; border:#000 0px solid; background:url('<?php echo Yii::app()->request->baseUrl; ?>/images/comments-expander.gif') repeat-x; float:left;" id="show_fullcomments_<?php echo $values->id; ?>" align="center">
                    <a href="javascript:void(0);" onclick="show_all_comments('<?php echo $values->id; ?>');" style="text-decoration:underline;">view all <?=$values->comments->count?> comments</a>
                </div>
                <?php } ?>
                
                <div style="float:left; width:100%;">
                
                    <?php  $lastest_comment = array(); if($values->comments->count>0 && count($comments_feed)) { ?>
                    
                    <!-- All Comment div -->                  
                    <div id="comments_<?php echo $values->id; ?>" style="display:none; float:left;">
                    <table style="margin-bottom:5px;">
                    <tr>
                        <td> 
                            <div style="padding:5px; width:450px; font-family:Verdana, Geneva, sans-serif; font-size:11px; margin-left:20px;">
                            <table style="margin-bottom:5px;">
                            <?php
                            
                            
                            
                            if($values->comments->count>3)
                                $start_fill = $values->comments->count - 3;
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
                                    <table style="margin:0px; padding:0px;">
                                    <tr>
                                        <td>
                                            <span style="font-family:Verdana, Geneva, sans-serif; font-size:11px; color:#036; font-weight:bold;">
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
                                            }
                                            
                                            echo $date_t_1.' at '.$time_t_2;
                                            
                                            ?>
                                        </td>
                                    </tr>
                                    </table>
                                </td>
                            </tr>
                            <?php
                                
                                if($h>$start_fill)
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
                    <div id="short_comments_<?php echo $values->id; ?>" style="padding:5px; width:450px; font-family:Verdana, Geneva, sans-serif; font-size:11px; margin-left:20px;">
                        <table style="margin:0px; padding:0px;">
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
                                            <table style="margin:0px; padding:0px;">
                                            <tr>
                                                <td>
                                                    <span style="font-family:Verdana, Geneva, sans-serif; font-size:11px; color:#036; font-weight:bold;"><?php echo $val1->from->name; ?></span>
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
                                                
                                                echo $date_t_1.' at '.$time_t_2;
                                                ?>
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
                
                <div style="background:#EEE; margin:-9px; float:left; width:103.4%; margin-top:15px;" id="comments_box_<?php echo $values->id; ?>">
                    <div style="width:98%; padding:10px 0px 10px 20px; border:#000 0px solid;">
                        <img src="https://graph.facebook.com/<?php echo $frst_page; ?>/picture?type=square" width="35" height="32" />
                        <input type="text" name="comment_<?php echo $values->id; ?>" id="comment_<?php echo $values->id; ?>" value="Post a comment ..." onfocus="if(this.value=='Post a comment ...')this.value='';" onblur="if(this.value=='') this.value='Post a comment ...';" style="width:85%; border:#CCC 1px solid; font-size:11px; padding:4px; color:#333;" onkeyup="IdentifyMe(event,'<?php echo $values->id; ?>','<?php echo $fbposts_get[0]['token']; ?>');" />
                    </div>
                </div>
             
             </div>
	<?php
		}
	}
?>
	<div style="float:left; width:100%;" id="more_data"></div>
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
?>