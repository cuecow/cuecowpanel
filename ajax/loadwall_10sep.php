<?php
include('../connection.php');

if (empty($_REQUEST['pageid']) && empty($_REQUEST['userid']) && empty($_REQUEST['token'])) 
{
	$return['error'] = true;
	$return['msg'] = '';
}
else 
{
	$return['error'] = false;
		
	$rand_num = rand(50,5000);
	
	$feed_url = @file_get_contents('https://graph.facebook.com/'.$_REQUEST['pageid'].'/feed?access_token='.$_REQUEST['token']);
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
	
	
	$return['msg'] = '';

    $return['msg'] .= '	<table width="100%">';
							
							if($posted_by_me)
							{
								foreach($posted_by_me as $key => $values)
								{
									if(!empty($values->message))
									{ 
										$comments_feed = json_decode(@file_get_contents('https://graph.facebook.com/'.$values->id.'/comments?access_token='.$fbposts_get[0]['token'].'&limit=1000'));
							
										$return['msg'] .= '<tr>
											<td width="100%">
												<div id="div_'.$values->id.'" style="display:block; background:#FFF; padding:10px; margin-bottom:20px; border-radius:6px ; -moz-border-radius:6px ; width:93%;">
												
													<table width="100%" cellpadding="0" cellspacing="0" border="0">
													<tr>
														<td>
														<table border="0" width="100%" cellpadding="0" cellspacing="0">
														<tr>
															<td width="2%;">&nbsp;</td>
															<td width="12%" style="padding-bottom:10px;"><img src="https://graph.facebook.com/'.$_REQUEST['pageid'].'/picture?type=square" /></td>
															<td width="76%">
																<table border="0" cellpadding="0" cellspacing="0" width="100%">
																<tr>
																	<td>
																		<span style="font-family:Verdana, Geneva, sans-serif; font-size:11px; color:#036; font-weight:bold;">'.$values->from->name.'</span>
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
																										
																	
																	$return['msg'] .= '<span style="font-family:Verdana, Geneva, sans-serif; font-size:11px; color:#666; padding-top:10px;">'.$date_t.' at '.$time_t;
																	if($values->application->name) $return['msg'] .= ' via '.$values->application->name;
																	
																	$return['msg'] .= '</span>
																	</td>
																</tr>
																</table>
															</td>
															<td width="10%" align="right">
																<a href="javascript:void(0);" onclick="javascript:show_confirm(\''.$values->id.'\',\''.$_REQUEST['token'].'\',\'Are you sure, you want to delete this post?\');"><img src="http://panel.cuecow.com/images/close.png" border="0" /></a>
															</td>
														</tr>
														<tr>
															<td></td>
															<td colspan="3" style="border-top:#CCC 1px solid;"></td>
														</tr>
														<tr>
															<td></td>
															<td colspan="3" style="padding-top:5px;">
																<span style="font-size:11px; font-family:Verdana, Geneva, sans-serif; padding-bottom:15px;">
																	'.$values->message.'
																</span>
															</td>
														</tr>
														<tr>
															<td></td>
															<td colspan="3">';
																
																if($values->picture)
																	$return['msg'] .= '<div style="border:#999 0px solid; padding:5px;"><img src="'.$values->picture.'" /></div>';
																	
															$return['msg'] .= '</td>
														</tr>
														<tr>
															<td colspan="4">';
															if($values->comments->count>3) {
																$return['msg'] .= '<div style="padding:5px 4px 5px 5px; width:102%; height:37px; font-family:Verdana, Geneva, sans-serif; font-size:11px; margin-top:15px; margin-left:-10px; border:#000 0px solid; background:url(\'http://panel.cuecow.com/images/comments-expander.gif\') repeat-x;" id="show_fullcomments_'.$values->id.'" align="center">
																	<a href="javascript:void(0);" onclick="show_all_comments(\''.$values->id.'\');" style="text-decoration:underline;">view all '.$values->comments->count.' comments</a>
																</div>';
																}
															$return['msg'] .= '</td>
														</tr>
														<tr>
															<td></td>
															<td colspan="3">';
																
																
																
																$return['msg'] .= '<div id="comments_'.$values->id.'" style="display:none;">
																<table style="margin-bottom:5px;">';
																
																$lastest_comment = array();
																
																if($values->comments->count>0 && count($comments_feed))
																{
																	$return['msg'] .= '<tr>
																	<td>';
																	
																	
																	for($h=1; $h<=count($values->comments); $h++) 
																	{ 
																	
																		$return['msg'] .= '<div style="padding:5px; width:450px; font-family:Verdana, Geneva, sans-serif; font-size:11px; margin-left:20px;">
																		<table style="margin-bottom:5px;">';
																		
																		
											
																		if($values->comments->count>3)
																			$start_fill = $values->comments->count - 3;
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
																				<table style="margin:0px; padding:0px;">
																				<tr>
																					<td>
																						<span style="font-family:Verdana, Geneva, sans-serif; font-size:11px; color:#036; font-weight:bold;">
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
																		</div>';
																	} 
																	
																	$return['msg'] .= '</td>
																</tr>';
																}
																
																$return['msg'] .= '</table>
																</div>
																
																<div id="short_comments_'.$values->id.'" style="padding:5px; width:450px; font-family:Verdana, Geneva, sans-serif; font-size:11px; margin-left:20px;">
																<table>';
																	
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
																					<table style="margin:0px; padding:0px;">
																					<tr>
																						<td>
																							<span style="font-family:Verdana, Geneva, sans-serif; font-size:11px; color:#036; font-weight:bold;">'.$val1->from->name.'</span>
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
																						
																						$return['msg'] .= $date_t_1.' at '.$time_t_2;
																						
																						$return['msg'] .= '</td>
																					</tr>
																					</table>
																				</td>
																			</tr>';
																	
																		}
																	}
																
																$return['msg'] .= '</table>
															</div>
																
															</td>
														</tr>
														</table>
														</td>
													</tr>
													</table>
													<div style="background:#EEE; margin:-9px;" id="comments_box_'.$values->id.'">
														<div style="width:98%; padding:10px 0px 10px 20px; border:#000 0px solid;">
															<img src="https://graph.facebook.com/'.$_REQUEST['pageid'].'/picture?type=square" width="35" height="32" />
															<input type="text" name="comment_'.$values->id.'" id="comment_'.$values->id.'" value="Post a comment ..." onfocus="if(this.value==\'Post a comment ...\')this.value=\'\';" onblur="if(this.value==\'\') this.value=\'Post a comment ...\';" style="width:480px; border:#CCC 1px solid; font-size:11px; padding:4px; color:#333;" onkeyup="IdentifyMe(event,\''.$values->id.'\',\''.$_REQUEST['token'].'\');" />
														</div>
													</div>
												
												</div>
											</td>
										</tr>';
									}
								}

								$return['msg'] .= '<tr><td id="more_data"></td></tr>';
								
								
								if($value->next)
								{
									$next_feed = @file_get_contents($value->next);
									$next_result = json_decode($next_feed);
									$next_feed_count = count($next_result->data);
																					
									if($next_feed_count)
									{
								
										$return['msg'] .= '<tr><td align="right" id="show_more"><a href="javascript:void(0);" onclick="javascript:ShowMoreData(\''.$value->next.'\',\'more_data\',\''.$_REQUEST['token'].'\');" style="color:#FFF; font-weight:bold; text-decoration:underline;">Show more</a></td></tr>';
								
								
									}
								}
							}
							else
								$return['msg'] .= '<tr><td style="color:#FF0000;"><center>No Wall Posts Found</center></td></tr>';
							
							$return['msg'] .= '</table>';
	
	$return['msg_other'] = '';
	
	$return['msg_other'] .= '<table width="100%">';
							
							if($posted_by_others)
							{
								foreach($posted_by_others as $key => $values)
								{
									if(!empty($values->message))
									{ 
										$comments_feed = json_decode(@file_get_contents('https://graph.facebook.com/'.$values->id.'/comments?access_token='.$fbposts_get[0]['token'].'&limit=1000'));
							
										$return['msg_other'] .= '<tr>
											<td width="100%">
												<div id="div_'.$values->id.'" style="display:block; background:#FFF; padding:10px; margin-bottom:20px; border-radius:6px ; -moz-border-radius:6px ; width:93%;">
												
													<table width="100%" cellpadding="0" cellspacing="0" border="0">
													<tr>
														<td>
														<table border="0" width="100%" cellpadding="0" cellspacing="0">
														<tr>
															<td width="2%;">&nbsp;</td>
															<td width="12%" style="padding-bottom:10px;"><img src="https://graph.facebook.com/'.$_REQUEST['pageid'].'/picture?type=square" /></td>
															<td width="76%">
																<table border="0" cellpadding="0" cellspacing="0" width="100%">
																<tr>
																	<td>
																		<span style="font-family:Verdana, Geneva, sans-serif; font-size:11px; color:#036; font-weight:bold;">'.$values->from->name.'</span>
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
																										
																	
																	$return['msg_other'] .= '<span style="font-family:Verdana, Geneva, sans-serif; font-size:11px; color:#666; padding-top:10px;">'.$date_t.' at '.$time_t;
																	if($values->application->name) $return['msg_other'] .= ' via '.$values->application->name;
																	
																	$return['msg_other'] .= '</span>
																	</td>
																</tr>
																</table>
															</td>
															<td width="10%" align="right">
																<a href="javascript:void(0);" onclick="javascript:show_confirm(\''.$values->id.'\',\''.$_REQUEST['token'].'\',\'Are you sure, you want to delete this post?\');"><img src="http://panel.cuecow.com/images/close.png" border="0" /></a>
															</td>
														</tr>
														<tr>
															<td></td>
															<td colspan="3" style="border-top:#CCC 1px solid;"></td>
														</tr>
														<tr>
															<td></td>
															<td colspan="3" style="padding-top:5px;">
																<span style="font-size:11px; font-family:Verdana, Geneva, sans-serif; padding-bottom:15px;">
																	'.$values->message.'
																</span>
															</td>
														</tr>
														<tr>
															<td></td>
															<td colspan="3">';
																
																if($values->picture)
																	$return['msg_other'] .= '<div style="border:#999 0px solid; padding:5px;"><img src="'.$values->picture.'" /></div>';
																	
															$return['msg_other'] .= '</td>
														</tr>
														<tr>
															<td colspan="4">';
															if($values->comments->count>3) {
																$return['msg_other'] .= '<div style="padding:5px 4px 5px 5px; width:102%; height:37px; font-family:Verdana, Geneva, sans-serif; font-size:11px; margin-top:15px; margin-left:-10px; border:#000 0px solid; background:url(\'http://panel.cuecow.com/images/comments-expander.gif\') repeat-x;" id="show_fullcomments_'.$values->id.'" align="center">
																	<a href="javascript:void(0);" onclick="show_all_comments(\''.$values->id.'\');" style="text-decoration:underline;">view all '.$values->comments->count.' comments</a>
																</div>';
																}
															$return['msg_other'] .= '</td>
														</tr>
														<tr>
															<td></td>
															<td colspan="3">';
																																
																$return['msg_other'] .= '<div id="comments_'.$values->id.'" style="display:none;">
																<table style="margin-bottom:5px;">';
																
																$lastest_comment = array();
																
																if($values->comments->count>0 && count($comments_feed))
																{
																	$return['msg_other'] .= '<tr>
																	<td>';
																	
																	
																	for($h=1; $h<=count($values->comments); $h++) 
																	{ 
																	
																		$return['msg_other'] .= '<div style="padding:5px; width:450px; font-family:Verdana, Geneva, sans-serif; font-size:11px; margin-left:20px;">
																		<table style="margin-bottom:5px;">';
																		
																		
																		
																		if($values->comments->count>3)
																			$start_fill = $values->comments->count - 3;
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
																						<span style="font-family:Verdana, Geneva, sans-serif; font-size:11px; color:#036; font-weight:bold;">
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
												
																			if($h>$start_fill)
																				array_push($lastest_comment,$value1);
																			
																			$h++;
																		}
																		
																		$return['msg_other'] .= '</table>                                    
																		</div>';
																		
																		$return['msg_other'] .= '<div id="short_comments_'.$values->id.'" style="padding:5px; width:450px; font-family:Verdana, Geneva, sans-serif; font-size:11px; margin-left:20px;">
																		<table>';
																																					
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
																							<table>
																							<tr>
																								<td>
																									<span style="font-family:Verdana, Geneva, sans-serif; font-size:11px; color:#036; font-weight:bold;">'.$val1->from->name.'</span>
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
																	
																	
																	$return['msg_other'] .= '</td>
																</tr>';
																}
																
																$return['msg_other'] .= '</table>
																</div>
															</td>
														</tr>
														</table>
														</td>
													</tr>
													</table>
													<div style="background:#EEE; margin:-9px;" id="comments_box_'.$values->id.'">
														<div style="width:98%; padding:10px 0px 10px 20px; border:#000 0px solid;">
															<img src="https://graph.facebook.com/'.$_REQUEST['pageid'].'/picture?type=square" width="35" height="32" />
															<input type="text" name="comment_'.$values->id.'" id="comment_'.$values->id.'" value="Post a comment ..." onfocus="if(this.value==\'Post a comment ...\')this.value=\'\';" onblur="if(this.value==\'\') this.value=\'Post a comment ...\';" style="width:480px; border:#CCC 1px solid; font-size:11px; padding:4px; color:#333;" onkeyup="IdentifyMe(event,\''.$values->id.'\',\''.$_REQUEST['token'].'\');" />
														</div>
													</div>
												
												</div>
											</td>
										</tr>';
									}
								}

								$return['msg_other'] .= '<tr><td id="more_data"></td></tr>';
								
								
								if($value->next)
								{
									$next_feed = @file_get_contents($value->next);
									$next_result = json_decode($next_feed);
									$next_feed_count = count($next_result->data);
																					
									if($next_feed_count)
									{
								
										$return['msg_other'] .= '<tr><td align="right" id="show_more"><a href="javascript:void(0);" onclick="javascript:ShowMoreData(\''.$value->next.'\',\'more_data\',\''.$_REQUEST['token'].'\');" style="color:#FFF; font-weight:bold; text-decoration:underline;">Show more</a></td></tr>';
								
								
									}
								}
							}
							else
								$return['msg_other'] .= '<tr><td style="color:#FF0000;"><center>No Wall Posts Found</center></td></tr>';
								
							$return['msg_other'] .= '</table>';
    
	}
	else
		$return['msg'] .='<tr><td align="center">No Posts Found</td></tr></table>';
	
	$return['msg'] .='<tr><td id="more_data'.$rand_num.'"></td></tr></table>';
}

echo json_encode($return);

?>