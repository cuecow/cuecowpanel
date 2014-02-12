<?php
include('../connection.php');

include('../framework/yii.php');

if (empty($_REQUEST['pageid']) && empty($_REQUEST['userid']) && empty($_REQUEST['token'])) 
{
	$return['error'] = true;
	$return['msg'] = '';
}
else 
{
	$return['error'] = false;
		
	$rand_num = rand(50,5000);
	
	$feed_url = file_get_contents('https://graph.facebook.com/'.$_REQUEST['pageid'].'/feed?access_token='.$_REQUEST['token']);
	$feed_content = json_decode($feed_url);

	$sql = mysql_query("SELECT page_name FROM fbpages where page_id=".$_REQUEST['pageid'])or die(mysql_error());
	$get_page_name = mysql_fetch_assoc($sql);
	$page_name_mine = strtolower($get_page_name['page_name']);
	
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
					if($values->from->id == $_REQUEST['pageid'])
						array_push($posted_by_me,$values);
					else
						array_push($posted_by_others,$values);
				}
			}
		}
		
		$return['msg'] = '
		
		<div class="well">
                
        	<fieldset>
                
            	<img src="https://graph.facebook.com/'.$_REQUEST['pageid'].'/picture?type=square" width="35" height="32" /> &nbsp; <input type="text" class="fb-comment-field-style" id="quickcomment1" placeholder="Enter new Post ..." style="width:85%;" />
                    
                <div class="clearfix"></div>
                    
                <input type="button" value="Submit" class="btn btn-info" style="float:right; margin-right:23px;" onclick="QuickPost(1);" />
                    
			</fieldset>
                
		</div>
                
        <div class="quick_comment_cntnr" id="add_new_post1" align="center" style="display:none;">
        	<img src="'.Yii::app()->request->baseUrl.'/images/ajax-loader.gif" />
        </div>';
								
		if($posted_by_me)
		{
			foreach($posted_by_me as $key => $values)
			{
				if(!empty($values->message))
				{ 
					$comments_feed = json_decode(@file_get_contents('https://graph.facebook.com/'.$values->id.'/comments?access_token='.$fbposts_get[0]['token'].'&limit=1000'));
		
					$return['msg'] .= '<div class="well well-small" style="float:left;">
					
					<div id="div_'.$values->id.'" class="post-fb-cmnt-ajax">

    					<div class="post-fb-cmnt-otr-ajax">
                        
						<div class="post-fb-cmnt-inr-ajax">
							<img src="https://graph.facebook.com/'.$_REQUEST['pageid'].'/picture?type=square" />
						</div>
                        
						<div class="post-tbl-otr-ajax">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td class="facebook_pagename">'.$values->from->name.'</td>
							</tr>
							<tr>
								<td>';
									
								if($values->created_time) 
								{
									$temp_t1 = explode('T',$values->created_time);	
									$date_t = $temp_t1[0];
																		
									if($temp_t1[1])
										$temp_t2 = explode('+',$temp_t1[1]);
																		
									$time_t = $temp_t2[0];
								}
								
                        	$return['msg'] .= '<span class="facebook_time">';
                            
							$return['msg'] .= $date_t.' at '.$time_t;
                            
							if($values->application->name) 
								$return['msg'] .= 'via '.$values->application->name; 
								
                        $return['msg'] .= '</span>
                				
								</td>
            				</tr>
            				</table>
						</div>
                        
						<div class="post-otr-tbl-ajax" align="right">
							<a href="javascript:void(0);" onclick="javascript:show_confirm(\''.$values->id.'\',\''.$fbposts_get[0]['token'].'\',\'Are you sure, you want to delete this post?\');"><img src="'.Yii::app()->request->baseUrl.'/images/close.png" border="0" /></a>
						</div>
    				</div>
                    
					<div class="post-otr-span-ajax">
						<span class="facebook_message">
							'.$values->message.'
						</span>
					</div>
    
					<div class="facebook_picture">';
						if($values->picture) {
							$return['msg'] .= '<div class="facebook_image"><img src="'.$values->picture.'" /></div>';
						}
					$return['msg'] .= '</div>';
                    
	if(count($values->comments->data) > 3) 
	{
    
    	$return['msg'] .= '<div class="facebook_comments" id="show_fullcomments_'.$values->id.'" align="center">
        						<a href="javascript:void(0);" onclick="show_all_comments(\''.$values->id.'\');" style="text-decoration:underline;">view all '.$values->comments->count.' comments</a>
    						</div>';
	
	}
                    
    $return['msg'] .= '<div class="post-all-cmnts-fb">';
    
	$lastest_comment = array(); 
	
	if(count($values->comments->data) > 0 && count($comments_feed)) 
	{
        $return['msg'] .= '<div id="comments_'.$values->id.'" style="display:none; float:left;">
        <table style="margin-bottom:5px;" class="table">
        <tr>
            <td> 
                <div class="post-comnts-inner-fb">
                <table style="margin-bottom:5px;">';
                
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
					$return['msg'] .= '<tr>
                        <td width="60">';

                            if($value1->from->id)
                                $return['msg'] .= '<img src="https://graph.facebook.com/'.$value1->from->id.'/picture?type=square" width="40" height="40" />'; 
                            
                    $return['msg'] .= '</td>
                        <td>
                            <table class="post-all-tbl-fb">
                            <tr>
                                <td>
                                    <span class="post-tbl-span-fb">
                                        '.$value1->from->name.'
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span style="color:#000;">
                                        '.$value1->message.'
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>';
								
                                    if($value1->created_time) 
                                    {
                                        $temp_t_1 = explode('T',$value1->created_time);	
                                        $date_t_1 = $temp_t_1[0];
                                                                                    
                                        if($temp_t_1[1])
                                            $temp_t_2 = explode('+',$temp_t_1[1]);
                                                                                    
                                        $time_t_2 = $temp_t_2[0];
                                    }
                                    
                                    $return['msg'] .= $date_t_1.' at '.$time_t_2;
                                    
                                $return['msg'] .= '</td>
                            </tr>
                            </table>
                        </td>
                    </tr>';
					                        
                        if($h>$start_fill)
                            array_push($lastest_comment,$value1);
                        
                        $h++;
                    }
                    
                    $return['msg'] .= '</table>                                    
                    </div>
                
                </td>
            </tr>
            </table>
            </div>
                        
            <div id="short_comments_'.$values->id.'" class="comment-fb-box-outer shrt-cmnt-fb-comments">
                <table class="shrt-tbl-fb-comments">';
				    
                if(count($lastest_comment))
                {
					foreach($lastest_comment as $key1=>$val1)
					{
						
						$return['msg'] .= '<tr>
                                <td width="60">';
								
                                if($val1->from->id)
                                    $return['msg'] .= '<img src="https://graph.facebook.com/'.$val1->from->id.'/picture?type=square" width="40" height="40" />'; 
									
                                $return['msg'] .= '</td>
                                <td>
                                    <table class="fb-comment-table-cnt shrt-tbl-inner-fb>
                                    <tr>
                                        <td>
                                            <span class="shrt-inner-span-fb">'.$val1->from->name.'</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span style="color:#000;">
                                                '.$val1->message.'
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>';
										
                                        if($val1->created_time) 
                                        {
                                            $temp_t_1 = explode('T',$val1->created_time);	
                                            $date_t_1 = $temp_t_1[0];
                                                
                                            if($temp_t_1[1])
                                                $temp_t_2 = explode('+',$temp_t_1[1]);
                                                
                                            $time_t_2 = $temp_t_2[0];
                                        }
                                        
                                        $return['msg'] .= $date_t_1.' at '.$time_t_2;
                                        
                                        $return['msg'] .= '</td>
                                    </tr>
                                    </table>
                                </td>
                            </tr>';
							
                              }
                          }
						  
                      $return['msg'] .= '</table>
                  </div>';
                    
					}
                    
                     $return['msg'] .= '</div>
                    
                    <div class="shrt-tbl-outter-fb-cmnt" id="comments_box_'.$values->id.'">
                        <div class="inner-div-fb-cmnt">
                            <img src="https://graph.facebook.com/'.$_REQUEST['pageid'].'/picture?type=square" width="35" height="32" /> &nbsp;
                            <input type="text" class="fb-comment-field-style" name="comment_'.$values->id.'" id="comment_'.$values->id.'" placeholder="Post a comment ..." onkeyup="IdentifyMe(event,\''.$values->id.'\',\''.$fbposts_get[0]['token'].'\');" style="width:82%;" />
                        </div>
                    </div>
                 
                 </div>
            </div>';
			}
			else
				$return['msg'] .= '<div style="float:left; width:100%;"><center>No Wall Posts Found</center></div>';
		}
	}
		
		
	//$return['msg_other'] = '';
        
        $return['msg_other'] = '
		
		<div class="well">
                
        	<fieldset>
                
            	<img src="https://graph.facebook.com/'.$_REQUEST['pageid'].'/picture?type=square" width="35" height="32" /> &nbsp; <input type="text" class="fb-comment-field-style" id="quickcomment2" placeholder="Enter new Post ..." style="width:85%;" />
                    
                <div class="clearfix"></div>
                    
                <input type="button" value="Submit" class="btn btn-info btn-post-page" onclick="QuickPost(2);" />
                    
			</fieldset>
                
		</div>
                
        <div class="quick_comment_cntnr" id="add_new_post2" align="center" style="display:none;">
        	<img src="'.Yii::app()->request->baseUrl.'/images/ajax-loader.gif" />
        </div>';
		
//	$return['msg_other'] = '<!-- Quick Comment -->
//						  <div class="quick_comment_box">
//							  <div class="quick_comment_cntnr quick_comment_title">Quick Post</div>
//							  <div class="quick_comment_cntnr">
//								  <img src="https://graph.facebook.com/'.$_REQUEST['pageid'].'/picture?type=square" width="35" height="32" />
//								  <input type="text" id="quickcomment2" value="Enter new Post ..." onfocus="if(this.value==\'Enter new Post ...\')this.value=\'\';" onblur="if(this.value==\'\') this.value=\'Enter new Post ...\';" class="quick_comment_txtbx" />
//								  
//								  <div class="quick_post_submit">
//									<input type="button" value="Submit" class="button small green float_right" onclick="QuickPost(2);" />
//								</div>
//								<div style="clear:both;"></div>
//								<div class="quick_comment_cntnr" id="add_new_post2" align="center" style="display:none;">
//									<img src="http://panel.cuecow.com/images/ajax-loader.gif" />
//								</div>
//							  </div>
//							  
//						  </div>
//						  <!-- Quick Comment -->';
		
		if($posted_by_others)
		{		
			foreach($posted_by_others as $key => $values)
			{
				if(!empty($values->message))
				{ 
					$comments_feed = json_decode(@file_get_contents('https://graph.facebook.com/'.$values->id.'/comments?access_token='.$fbposts_get[0]['token'].'&limit=1000'));
								
					$return['msg_other'] .= '<div class="well well-small" style="float:left;">
                                            <div id="div_'.$values->id.'" class="post-fb-cmnt-ajax">
									<!-- post\'s details -->
									<div style="width:100%; border-bottom:#CCC 1px solid; float:left;">
										
										<div class="post-fb-cmnt-inr-ajax">
											<img src="https://graph.facebook.com/'.$values->from->id.'/picture?type=square" />
										</div>
										
										<div class="post-tbl-otr-ajax">
											<table border="0" cellpadding="0" cellspacing="0" width="100%">
											<tr>
												<td>
													<span class="other-post-span-ajax">'.$values->from->name.'</span>
												</td>
											</tr>
											<tr>
												<td>';
														
											if($values->created_time) 
											{
												$temp_t1 = explode('T',$values->created_time);	
												$date_t = $temp_t1[0];
																							
												if($temp_t1[1])
													$temp_t2 = explode('+',$temp_t1[1]);
																							
												$time_t = $temp_t2[0];
											}
																						
											
											$return['msg_other'] .= '<span class="othr-pst-span-ajax">
															'.$date_t.' at '.$time_t;
											if($values->application->name) $return['msg_other'] .= ' via '.$values->application->name; 
											
											$return['msg_other'] .= '</span>
												</td>
											</tr>
											</table>
										</div>
										
										<div class="post-otr-tbl-ajax" align="right">
											<a href="javascript:void(0);" onclick="javascript:show_confirm(\''.$values->id.'\',\''.$fbposts_get[0]['token'].'\',\'Are you sure, you want to delete this post?\');"><img src="http://panel.cuecow.com/images/close.png" border="0" /></a>
										</div>
										
									</div>
									
									<!-- post\'s message -->
									<div class="post-otr-span-ajax">
										<span class="facebook_message">'.$values->message.'</span>
									</div>';
									
									if($values->picture) 
									{ 
										$return['msg_other'] .= '<div class="othr-pst-pic-ajax">
											<div class="othr-pic-inr-ajax"><img src="'.$values->picture.'" /></div>
										</div>';
									}
									
	
									if(count($values->comments->data) > 3) 
									{ 
									
										$return['msg_other'] .= '<div style="padding:5px 4px 5px 5px; width:101.8%; height:37px; margin-top:15px; margin-left:-1.8%; border:#000 0px solid; background:url(\'http://panel.cuecow.com/images/comments-expander.gif\') repeat-x; float:left;" id="show_fullcomments_'.$values->id.'" align="center">
											<a href="javascript:void(0);" onclick="show_all_comments(\''.$values->id.'\');" style="text-decoration:underline;">view all '.$values->comments->count.' comments</a>
										</div>';
									}
									
									
									$return['msg_other'] .= '<div style="float:left; width:100%;">';
					
									$lastest_comment = array(); 
									
									if(count($values->comments->data) > 0 && count($comments_feed)) 
									{
						
										$return['msg_other'] .= '<!-- All Comment div -->                  
											<div id="comments_'.$values->id.'" style="display:none; float:left;">
											<table style="margin-bottom:5px;">
											<tr>
												<td> 
													<div class="othr-all-cmnts-ajax">
													<table style="margin-bottom:5px;">';
													
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
								
														$return['msg_other'] .= '<tr>
															<td width="60">';
					
														if($value1->from->id)
															$return['msg_other'] .= '<img src="https://graph.facebook.com/'.$value1->from->id.'/picture?type=square" width="40" height="40" />'; 
									
														$return['msg_other'] .= '</td>
														<td>
															<table style="margin:0px; padding:0px;">
															<tr>
																<td>
																	<span style="color:#036; font-weight:bold;">
																		'.$value1->from->name.'
																	</span>
																 </td>
															</tr>
														<tr>
														<td>
															<span style="color:#000;">
																'.$value1->message.'
															</span>
														</td>
													</tr>
													<tr>
														<td>';
	
														if($value1->created_time) 
														{
															$temp_t_1 = explode('T',$value1->created_time);	
															$date_t_1 = $temp_t_1[0];
																										
															if($temp_t_1[1])
																$temp_t_2 = explode('+',$temp_t_1[1]);
																								
															$time_t_2 = $temp_t_2[0];
														}
												
														$return['msg_other'] .= $date_t_1.' at '.$time_t_2;
														
											$return['msg_other'] .= '</td>
													</tr>
													</table>
												</td>
											</tr>';
									
											if($h>=$start_fill)
												array_push($lastest_comment,$value1);
									
												$h++;
											}
											
								$return['msg_other'] .= '</table>                                    
											</div>
									</td>
								</tr>
								</table>
						</div>
						
						<!-- Short Comment div -->
						<div id="short_comments_'.$values->id.'" style="padding:5px; width:450px; margin-left:20px;">
							<table style="margin:0px; padding:0px;">';
								
								if(count($lastest_comment))
								{
									foreach($lastest_comment as $key1=>$val1)
									{
										$return['msg_other'] .= '<tr>
											<td width="60">';
											
											
											if($val1->from->id)
												$return['msg_other'] .= '<img src="https://graph.facebook.com/'.$val1->from->id.'/picture?type=square" width="40" height="40" />'; 
											
											$return['msg_other'] .= '</td>
											<td>
												<table style="margin:0px; padding:0px;">
												<tr>
													<td>
														<span style="color:#036; font-weight:bold;">'.$val1->from->name.'</span>
													</td>
												</tr>
												<tr>
													<td>
														<span style="color:#000;">'.$val1->message.'</span>
													</td>
												</tr>
												<tr>
													<td>';
													
													if($val1->created_time) 
													{
														$temp_t_1 = explode('T',$val1->created_time);	
														$date_t_1 = $temp_t_1[0];
															
														if($temp_t_1[1])
															$temp_t_2 = explode('+',$temp_t_1[1]);
															
														$time_t_2 = $temp_t_2[0];
													}
													
													$return['msg_other'] .= $date_t_1.' at '.$time_t_2;
													
													$return['msg_other'] .= '</td>
												</tr>
												</table>
											</td>
										</tr>';
									}
								}
							$return['msg_other'] .= '</table>
						</div>';
					}
					
					$return['msg_other'] .= '</div>
					
					<div class="shrt-tbl-outter-fb-cmnt" id="comments_box_'.$values->id.'">
						<div class="inner-div-fb-cmnt">
							<img src="https://graph.facebook.com/'.$_REQUEST['pageid'].'/picture?type=square" width="35" height="32" />
							<input type="text" class="fb-comment-field-style" name="comment_'.$values->id.'" id="comment_'.$values->id.'" value="Post a comment ..." onfocus="if(this.value==\'Post a comment ...\')this.value=\'\';" onblur="if(this.value==\'\') this.value=\'Post a comment ...\';" style="width:85%; border:#CCC 1px solid; font-size:11px; padding:4px; color:#333;" onkeyup="IdentifyMe(event,\''.$values->id.'\',\''.$fbposts_get[0]['token'].'\');" />
						</div>
					</div>
                                     </div>
				</div>';
															
				}
				else
					$return['msg_other'] .= '<div style="float:left; width:100%;"><center>No Wall Posts Found</center></div>';
			}
		}
		else
			$return['msg'] .='<div style="float:left; width:100%;"><center>No Wall Posts Found</center></div>';
		
		$return['msg'] .='<div style="float:left; width:100%;" id="more_data'.$rand_num.'"></div>';
	}
}

echo json_encode($return);

?>