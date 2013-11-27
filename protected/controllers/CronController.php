<?php

class CronController extends Controller {
/**
 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
 * using two-column layout. See 'protected/views/layouts/column2.php'.
 */
public $layout='//layouts/main';

/**
 * @return array action filters
 */
public function filters()
{
	return array(
		'accessControl', // perform access control for CRUD operations
	);
}

/**
 * Lists all models.
 */
public function actionIndex()
{
	echo '<h3>Cron Parameters are missing.</h3>';
}

public function actionCronEveryDay()
{
	ini_set('max_execution_time', 10000);
	
	$this->UpdateLocationBranches();
	$this->Epaysubscriptioncron();
}

public function actionCronEveryMinute()
{	
	ini_set('max_execution_time', 10000);
	
	$this->PostContentToFB();
	$this->RunCampaign();
	$this->VerifyCamapaign();
}

public function actionCronEveryHour()
{	
	ini_set('max_execution_time', 10000);
	
	$this->UpdateUserFBPages();
	$this->UpdateFBPagesRec();
}

public function actionCronTest()
{
	$model = new Cron();
	
	$fetch_group = $model->CronGetVenueGroup(78);
	
	if(count($fetch_group))
	{	
		if(!empty($fetch_group[0]['locations']))
		{
			$get_venue = $model->CronGetVenue(str_replace(',','#',$fetch_group[0]['locations']),true);
			if(count($get_venue))
			{
				$venueid = '';
				
				for($g =0; $g < count($get_venue); $g++)
				{
					$FSinfo = $model->CronFSvenueid($get_venue[$g]['loc_id']);
			
					if(count( $FSinfo ))
					{
						if( $g > 0) 
						{
							
							if($g>0)
								$this->AddSpecialToVenue($store_token, $id, $FSinfo[0]['id'], $new_end_date, $new_start_date);
							else
								$this->AddSpecialToVenue($store_token, $special_id, $FSinfo[0]['id'], $new_end_date, $new_start_date);
						}
					}
				}
			}
		}
	}
	
}

/**
 * function to verify running campaign on different medias
 */


public function VerifyCamapaign()
{
	$model = new Cron();
	
	$GetCampaigns = $model->CronGetPendingCampaign('active');	
	
	if( count($GetCampaigns) )
	{
		foreach( $GetCampaigns as $keys => $value )	
		{
			if( $value['foursquare_specials'] == 'yes' )
				$this->VerifyFSSpecial($value['campaign_id']);
			
			if( $value['fb_posts'] == 'yes' )
				$this->VerifyFBPost($value['campaign_id'], $value['userid']);
		}
	}
}

/**
 * function to verify Foursquare Special
 */
 
public function VerifyFSSpecial($campaign_id)
{
	$model = new Cron();
	$fs_specials = $model->CronCampFSSpecial($campaign_id);
	
	if( count($fs_specials) )
	{
		foreach( $fs_specials as $key => $value )	
		{
			if( $value['special'] != '' && $value['current_status'] == 'running' )	
			{
				$store_token = 'DU5BCOJZOF3RYKGN0X3VCA3RJTEEUTOGGO5QZ2ZAGUOGSEEO';
				
				if(strstr($value['special'],','))
				{
					$exp_diff_spc = explode(',',$value['special']);
					
					if( count($exp_diff_spc) )
					{
						foreach( $exp_diff_spc as $ke => $va )	
						{
							$specialid = $va;
							$url = 'https://api.foursquare.com/v2/specials/'.$specialid.'/?oauth_token='.$store_token.'&v='.date('Ymd'); 
							$result = file_get_contents($url);
							$result_array = json_decode($result);
							
							if( count($result_array) )
							{
								$fs_special_id = $result_array->response->special->id;
								
								if( $fs_specials_id == '' )
								{
									$model->CronRetireFSSpecial($value['fs_special_id'],'retired');
								}
							}
						}
					}
				}
				else
				{
					$specialid = $value['special'];
					$url = 'https://api.foursquare.com/v2/specials/'.$specialid.'/?oauth_token='.$store_token.'&v='.date('Ymd'); 
					$result = @file_get_contents($url);
					$result_array = json_decode($result);
					
					if( count($result_array) )
						$fs_special_id = $result_array->response->special->id;
					
					if( $fs_specials_id == '' )
						$model->CronRetireFSSpecial($value['fs_special_id'],'retired');
				}
			}
		}
	}
}

/**
 * function to verify Facebook Post
 */
 
public function VerifyFBPost($campaign_id, $user_id)
{
	$model = new Cron();
	$fbposts = $model->CronCampFBPost($campaign_id);
	
	if( count($fbposts) )
	{
		foreach( $fbposts as $key => $value )	
		{
			if( $value['posted_id'] != '' && $value['current_status'] == 'running' )	
			{
				$getToken = $model->CronUserAccessToken($user_id);
				
				if( count($getToken) )
				{
					$fbtoken = $getToken['fbtoken'];
					
					if( $fbtoken != '' )
					{
						$url = 'https://graph.facebook.com/'.$value['posted_id'].'?access_token='.$fbtoken ;	
						$result = @file_get_contents($url);
						$result_array = json_decode($result);
						
						if( count($result_array) )
							$post_id = $result_array->id;
						
						if( $post_id == '' )
							$model->CronRetireFBPost($value['campaign_fbpost_id'],'retired');
					}
				}
			}
		}
	}
}

/**
 * function to run campaign
 */
	 
public function RunCampaign()
{
	$model = new Cron();
	
	$get_camp = $model->CronGetPendingCampaign();

	if(count($get_camp))
	{
		foreach($get_camp as $rec)
		{
			if(!empty($rec['timezone']))
			{
				$show_time_zone = $model->CronGetZone($rec['timezone']);
				
				if(count($show_time_zone))
					date_default_timezone_set($show_time_zone['name']);
			}
			
			$today_date = date('m/d/Y');
			$time_now = date('h:i');
			
			if(!empty($rec['start_time']))
			{
				$temp_holder = explode(':',$rec['start_time']);
				
				//$new_start_date = mktime($temp_holder[0],$temp_holder[1],0,date('m',$rec['start_date']),date('d',$rec['start_date']-24*60*60),date('Y',$rec['start_date']));
				
				$new_start_date = mktime($temp_holder[0],$temp_holder[1],0,date('m',$rec['start_date']),date('d',$rec['start_date']),date('Y',$rec['start_date']));
				
			}
			else
				$new_start_date = $rec['start_date'];
				
			if(!empty($rec['end_time']))
			{
				$temp_holder = explode(':',$rec['end_time']);
				
				$new_end_date = mktime($temp_holder[0],$temp_holder[1],0,date('m',$rec['end_date']),date('d',$rec['end_date']),date('Y',$rec['end_date']));
			}
			else
				$new_end_date = $rec['end_date'];
				
			if( $new_start_date <= strtotime(now)/* && $new_end_date > strtotime(now)*/ )
			{	
				// get fs special
				$Fs = $model->CronGetFSSpecial($rec['campaign_id']);
				
				if(count($Fs))
				{	
					/*$clientId = 'QUNRJJX1Q1C4AODDII5EQQBMUKBYZ1JYLOYT4TLBH3QCM2AT';
					$clientSecret = 'YB1ADWVERZFETX5QVDGRU0NQJ5BA5JVZC12FD243WF5MSGQV';*/
					
					$clientId = '4Z42GIT2XAIR4LKEVSZFLYNYFAZLS34VCS2EOEJFAIM4TSX2';
					$clientSecret = '0HZ3JHMSFTKRXWOLGITBJJPXSE0JSLWK0BW3OQLYZNYD5FXD';
						
					$message='';
							
					if(!empty($rec['name']))
						$message .='name='.$Fs['name'];
						
					if(!empty($Fs['offer']))
						$message .='&text='.$Fs['offer'];
					
					if(!empty($Fs['unlockedText']))
						$message .='&unlockedText='.$Fs['unlockedText'];
					
					if(!empty($Fs['finePrint']))
						$message .='&finePrint='.$Fs['finePrint'];
						
					if(!empty($Fs['count1']))
						$message .='&count1='.$Fs['count1'];
						
					if(!empty($Fs['count2']))
						$message .='&count2='.$Fs['count2'];
						
					if(!empty($Fs['count3']))
						$message .='&count3='.$Fs['count3'];
						
					if(!empty($Fs['sp_type']))
						$message .='&type='.$Fs['sp_type'];
						
					if(!empty($Fs['cost']))
						$message .='&cost='.$Fs['cost'];
								
					$message .='&offerId=5000000';
					
					$token_data = $model->CronUserAccessToken($rec['userid']);
					
					if(count($token_data))
					{
						$store_token = $token_data['fstoken'];
					
						if(!empty($store_token))
						{
							$url = 'https://api.foursquare.com/v2/specials/add?oauth_token='.$store_token.'&v='.date('Ymd'); 
											
							$ch = curl_init(); 
							curl_setopt($ch, CURLOPT_URL,$url);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
							curl_setopt($ch, CURLOPT_POST, 1);
							curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
							curl_setopt($ch, CURLOPT_HEADER, 1);
							curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
							
							$result_fs = curl_exec($ch);
							
							curl_close($ch); 
		
							if(strstr($result_fs,'{"id":"'))
							{
								if(strstr($result_fs,'{"id":"'))
								{					
									$pos = strpos($result_fs,'{"id":"');
									$pos2 = strpos($result_fs,'","type');
									
									$id = substr($result_fs,$pos+7,($pos2-$pos)-7);
								}
								
								$res = $model->CronUpdateFSSpecial($id,$Fs['fs_special_id']);
							}	
						}
						
						$special_id = $id;
						
						if(!empty($Fs['location_type']) && !empty($Fs['location']))
						{
							if( $Fs['location_type'] == 1 )	
							{
								$fetch_venue = $model->CronGetVenue($Fs['location']);
								
								if(count($fetch_venue))
								{	
									$FSinfo = $model->CronFSvenueid($Fs['location']);
									
									if(count( $FSinfo ))
									{
										//add special to venue
										$this->AddSpecialToVenue($store_token, $special_id, $FSinfo[0]['id'], $new_end_date, $new_start_date);
									}
									
									if(!empty($fetch_venue['fsurl']))
									{	
										$temp_id = explode('/',$fetch_venue['fsurl']);	
										$venueid = $temp_id[count($temp_id)-1];
									}
								}
							}
							else if( $Fs['location_type'] == 2 )
							{
								$fetch_group = $model->CronGetVenueGroup($Fs['location']);
								
								if(count($fetch_group))
								{	
									if(!empty($fetch_group[0]['locations']))
									{
										$get_venue = $model->CronGetVenue(str_replace(',','#',$fetch_group[0]['locations']),true);
										if(count($get_venue))
										{
											$venueid = '';
											
											for($g =0; $g < count($get_venue); $g++)
											{
												$FSinfo = $model->CronFSvenueid($get_venue[$g]['loc_id']);
										
												if(count( $FSinfo ))
												{
													if( $g > 0) 
													{
														$url = 'https://api.foursquare.com/v2/specials/add?oauth_token='.$store_token.'&v='.date('Ymd'); 
											
														$ch = curl_init(); 
														curl_setopt($ch, CURLOPT_URL,$url);
														curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
														curl_setopt($ch, CURLOPT_POST, 1);
														curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
														curl_setopt($ch, CURLOPT_HEADER, 1);
														curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
														
														$result_fs = curl_exec($ch);
														
														curl_close($ch); 
									
														if(strstr($result_fs,'{"id":"'))
														{
															if(strstr($result_fs,'{"id":"'))
															{					
																$pos = strpos($result_fs,'{"id":"');
																$pos2 = strpos($result_fs,'","type');
																
																$id = substr($result_fs,$pos+7,($pos2-$pos)-7);
																
															}
															
															$res = $model->CronUpdateFSSpecial($special_id.'##'.$id,$Fs['fs_special_id']);
															$this->AddSpecialToVenue($store_token, $id, $FSinfo[0]['id'], $new_end_date, $new_start_date);
														}		
													}
													else
														$this->AddSpecialToVenue($store_token, $special_id, $FSinfo[0]['id'], $new_end_date, $new_start_date);			
												}
											}
										}
									}
								}
							}
							else if($Fs['location_type']==3)
							{
								$get_venue = $model->CronGetVenue($Fs['location']);
								
								if(count($get_venue))
								{
									$venueid = '';
									foreach($get_venue as $fetch_venue)
									{	
										$FSinfo = $model->CronFSvenueid($fetch_venue['loc_id']);
									
										if(count( $FSinfo ))
										{
											//add special to venue
											$this->AddSpecialToVenue($store_token, $special_id, $FSinfo[0]['id'], $new_end_date, $new_start_date);
										}
										
										if(!empty($fetch_venue['fsurl']))
										{	
											$temp_id = explode('/',$fetch_venue['fsurl']);	
											$venueid .= $temp_id[count($temp_id)-1].',';
										}
									}
									
									$venueid = substr($venueid,0,-1);
								}
							}
						}
					}
				}
				
				// get fb posts
				$twitter_rec = CampaignTwitter::model()->GetSpecificPost($rec['campaign_id']);

				if(count($twitter_rec))
				{	
					require("twitter/twitteroauth.php");
					
					$twitter_token = AccessToken::model()->GetUserTokenRecord($rec['userid']);
					
					if( $twitter_token[0]['twitter_oauth_token'] != '' &&  
							$twitter_token[0]['twitter_oauth_token_secret'] != '')
					{
						$twitter_oauth_token = $twitter_token[0]['twitter_oauth_token'];
						$twitter_oauth_token_secret = $twitter_token[0]['twitter_oauth_token_secret'];
						
						$twitteroauth = new TwitterOAuth($twitter_consumer_key, $twitter_consumer_secret, $twitter_oauth_token, $twitter_oauth_token_secret);
				
						$message = $twitter_rec[0]['message'];
						$post_tweet = $twitteroauth->post('statuses/update', array('status' => $message));
						
						$post_id = json_decode($post_id);
						
						$post_id = $post_tweet->id_str;
						
						if( $post_id != '' )	
							CampaignTwitter::model()->UpdateTweet($rec['campaign_id'], $post_id);
					}
				}
				
				// get fb posts
				$fb_rec = $model->CronCampaignFBPost($rec['campaign_id']);

				if(count($fb_rec))
				{	
					if(!empty($fb_rec['selected_wall_option']) || $fb_rec['selected_wall_option']>0)
					{
						if($fb_rec['selected_wall_option']==1)
						{
							$fetch_page = $model->CronGetFBPage($fb_rec['selected_wall'],$rec['userid']);

							if(count($fetch_page))
							{
								$page_id = $fetch_page['page_id'];
								
								$this->PostFBDataCampaign($page_id,$rec['campaign_id'],$rec['userid']);
							}
						}
						else if($fb_rec['selected_wall_option']==2)
						{						
							$group_page = array();
							
							$GetGroup = $model->CronGetVenueGroup($fb_rec['selected_wall'],$rec['userid']);
							
							if(count($GetGroup))
							{	
								if(!empty($GetGroup['fbpages']))
								{
									$temp_fbpages = explode(',',$GetGroup['fbpages']);	
									
									if(count($temp_fbpages))
									{
										foreach($temp_fbpages as $key=>$value)	
										{
											if(!empty($value))	
											{
												$fetch_page = $model->CronGetFBPage($value,$rec['userid']);
												
												if(count($fetch_page))
												{
													$page_id = $fetch_page['page_id'];
													
													$this->PostFBDataCampaign($page_id,$rec['campaign_id'],$rec['userid']);
												}
											}
										}
									}
								}
							}
						}
						else if($fb_rec['selected_wall_option']==3)
						{
							$get_page_orig = $model->CronGetFBPage('',$rec['userid']);
						
							if(count($get_page_orig))
							{
								foreach($fetch_page as $get_page_orig)
								{
									$page_id = $fetch_page['page_id'];
									
									$this->PostFBDataCampaign($page_id,$rec['campaign_id'],$rec['userid']);
								}
							}
						}
					}
				}		
				
				$update_status = $model->CronUpdateCampaign($rec['campaign_id']);
			}
		}
	}
}
 
public function AddSpecialToVenue($store_token, $special_id, $venue_id, $new_end_date, $new_start_date)
{
	$url = 'https://api.foursquare.com/v2/campaigns/add?oauth_token='.$store_token.'&v='.date('Ymd'); 
	
	$message_camp = '';
	$message_camp .='specialId='.$special_id;
	//$message_camp .='&groupId='.$final_group_id;
	$message_camp .='&venueId='.$venue_id;
	$message_camp .='&endAt='.$new_end_date;
	$message_camp .='&startAt='.$new_start_date;
	
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $message_camp);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				
	$result_fs = curl_exec($ch);
}


/**
 * function to post facebook posts
 */
 
public function PostContentToFB()
{
	$model = new Cron();
	
	$res_all_posts = $model->CronAllPosts();
	
	if(count($res_all_posts))
	{
		foreach($res_all_posts as $rec)
		{
			if(!empty($rec['post_zone']))
			{
				$show_time_zone = $model->CronGetZone($rec['post_zone']);
				
				if(count($show_time_zone))
					date_default_timezone_set($show_time_zone['name']);
			}

			$today_date = date('m/d/Y');
			$time_now = date('H:i');
			
			if($rec['post_date'] == $today_date && $rec['post_time'] <= $time_now)
			{
				if($rec['page_id'])
				{
					$fetch_page = $model->CronGetFBPage($rec['page_id'],$rec['user_id']);
					
					if(count($fetch_page))
					{
						$page_id = $fetch_page['page_id'];
							
						if(!empty($page_id) && !empty($rec['post_id']))
						{
							$this->PostData($page_id,$rec['post_id'],$rec['user_id']);
						}
					}
				}
				else if($rec['group_id'])
				{
					$group_page = array();
					
					$get_page_orig = $model->CronGroupFBPage($rec['group_id'],$rec['user_id']);
						
					if(count($get_page_orig))
					{
						foreach($get_page_orig as $fetch_page)
						{
							if($fetch_page['loc_id'])
							{
								$get_fbpageid = $model->CronFBURLInfo($fetch_page['loc_id']);
									
								if(count($get_fbpageid))
								{
									foreach($get_fbpageid as $store_group_page)
									{
										if(!in_array($store_group_page['id'],$group_page))
											array_push($group_page,$store_group_page['id']);
									}
								}
							}
						}
							
						if(count($group_page))
						{
							foreach($group_page as $key=>$value)
							{
								if(!empty($value) && !empty($rec['post_id']))
								{
									$this->PostData($value,$rec['post_id'],$rec['user_id']);
								}
							}
						}
					}
				}	
			}
		}
	}
}

public function PostFBDataCampaign($page_id,$campaignid,$user_id)
{
	$model = new Cron();
	
	$token = $model->CronUserPageToken($page_id,$user_id);

	if(count($token))
		$access_token = $token['token'];
	
	$rec = $model->CronGetFBCampaignPost($campaignid);

	if(count($rec))
	{	
		if($rec['content_type']=='text')
		{
			$message = $rec['message'];
			$link = $rec['url_link'];
			$url  = "https://graph.facebook.com/" . $page_id . "/feed?&access_token=". $access_token; 
			
			$rec_message = $rec['message'];
			$rec_title = $rec['title'];
			$rec_desc = $rec['description'];
						
			$args = array(
				'message' => $rec_message,
				'link' => $rec['url_link'],
				'picture' => $rec['photo'],
				'title'=> $rec_title,
				'description' => $rec_desc,
			);
			
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL,$url); // set url to post to 
			curl_setopt($ch, CURLOPT_FAILONERROR, 1); 
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // allow redirects 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable 
			curl_setopt($ch, CURLOPT_TIMEOUT, 0); // times out after Ns 
			curl_setopt($ch, CURLOPT_POST, 1); // set POST method 
			curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
			curl_setopt($ch, CURLOPT_VERBOSE, 1); 
			curl_setopt($ch, CURLOPT_HEADER, 1); 
			curl_setopt($ch, CURLOPT_COOKIEFILE, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
			$result = curl_exec($ch); // run the whole process 
						
			curl_close($ch); 
			
			if(strstr($result,'{"id":"'))
			{					
				$pos = strpos($result,'{"id":"');
				
				$id = substr($result,$pos+7,-2);
				
				$update_status = $model->CronUpdateFBCampaignPost($id,$campaignid);
				
				if($rec['email_notify']=='yes')
				{
					$user_rec = $model->CronGetUser($rec['user_id']);
					
					if(count($user_rec))
					{
						if(!empty($user_rec['email']))
						{
							$to       = $user_rec[0]['email'];
							$from	  = 'scheduler@cuecow.com';
							$subject  = 'Schedules content posted on facebook via cuecow.';
							$message  = 'Hello '.$user_rec['fname'].',<br /> We have successfully posted content on your facebook page via cuecow..';
							
							$headers  = "From: " . strip_tags($from) . "\r\n";
							$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
							$headers .= "MIME-Version: 1.0\r\n";
							$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
							
							$mail = mail($to, $subject, $message, $headers);
						}
					}
				}
			}
		}
		else if($rec['content_type']=='photo' || $rec['content_type']=='video')
		{
			if($rec['content_type']=='photo')
			{
				$content_type = 'image';
				$file = $_SERVER['DOCUMENT_ROOT'].'/images/fbposts/'.$rec['photo'];
			}
			else
			{
				$content_type = 'video';
				$file = $_SERVER['DOCUMENT_ROOT'].'/images/fbposts/'.$rec['video'];
			}

			$rec_message = $rec['message'];
			$rec_title = $rec['name'];
			$rec_desc = $rec['message'];
						
			$args = array(
				'message' => $rec_message,
				'link' => $rec['url_link'],
				'title'=> $rec_title,
				'description' => $rec_desc,
				'source' => '@' . realpath($file)
			);
			
			//$args[basename($file)] = '@' . realpath($file);
			
			$tokens = $model->CronUserPageToken($page_id,$user_id);

			if(count($tokens))
				$token = $tokens['token'];
				
			$ch = curl_init();
							
			if($rec['content_type']=='photo')
			{
				$get_albums = 'https://graph.facebook.com/'.$page_id.'/albums?access_token='.$token;
				$feed_album_url = @file_get_contents($get_albums);								
				$feed_album_content = json_decode($feed_album_url);
				$album_id = '';
				
				if(count($feed_album_content))
				{
					foreach($feed_album_content as $ke=>$va)	
					{
						foreach($va as $values)
						{
							if($values->name == 'Wall Photos' && $values->link!='')
								$album_id = $values->id;
						}
					}
				}
				
				if(!empty($album_id))
					$url = 'https://graph.facebook.com/'.$album_id.'/photos?access_token='.$token;
				else
					$url = 'https://graph.facebook.com/'.$page_id.'/photos?access_token='.$token;
			}
			else
				$url = 'https://graph.facebook.com/'.$page_id.'/videos?access_token='.$token;
			
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // allow redirects 
			
			$data = curl_exec($ch);

			curl_close($ch);
					
			if(strstr($data,'{"id":"'))
			{
				$pos = strpos($data,'"post_id":"');
				
				$id = substr($data,$pos+11,-2);
				
				$model->CronUpdateFBCampaignPost($id,$campaignid);
			
				if($rec['email_notify']=='yes')
				{
					$user_rec = $model->CronGetUser($rec['user_id']);
					
					if(count($user_rec))
					{
						if(!empty($user_rec['email']))
						{
							$to      = $user_rec[0]['email'];
							$from	 = 'scheduler@cuecow.com';
							$subject = 'Schedules content posted on facebook via cuecow.';
							$message = 'Hello '.$user_rec['fname'].',<br /> We have successfully posted content on your facebook page via cuecow..';
							
							$headers = "From: " . strip_tags($from) . "\r\n";
							$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
							$headers .= "MIME-Version: 1.0\r\n";
							$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
							
							$mail=mail($to, $subject, $message, $headers);
						}
					}
				}
			}
		}	
	}
}

public function PostData($page_id,$postid,$user_id)
{
	$model = new Cron();
	
	$token = $model->CronUserPageToken($page_id,$user_id);

	if(count($token))
		$access_token = $token['token'];
	
	$rec = $model->CronGetFBPost($postid);
	
	if(count($rec))
	{	
		if($rec['content_type']=='text')
		{
			$message = $rec['message'];
			$link = $rec['url_link'];
			$url  = "https://graph.facebook.com/" . $page_id . "/feed?&access_token=". $access_token; 
			
			$rec_message = $rec['message'];
			$rec_title = $rec['title'];
			$rec_desc = $rec['description'];
						
			$args = array(
				'message' => $rec_message,
				'link' => $rec['url_link'],
				'picture' => $rec['photo'],
				'title'=> $rec_title,
				'description' => $rec_desc,
			);
			
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL,$url); // set url to post to 
			curl_setopt($ch, CURLOPT_FAILONERROR, 1); 
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // allow redirects 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable 
			curl_setopt($ch, CURLOPT_TIMEOUT, 0); // times out after Ns 
			curl_setopt($ch, CURLOPT_POST, 1); // set POST method 
			curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
			curl_setopt($ch, CURLOPT_VERBOSE, 1); 
			curl_setopt($ch, CURLOPT_HEADER, 1); 
			curl_setopt($ch, CURLOPT_COOKIEFILE, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
			$result = curl_exec($ch); // run the whole process 
						
			curl_close($ch); 
		
			if(strstr($result,'{"id":"'))
			{					
				$pos = strpos($result,'{"id":"');
				
				$id = substr($result,$pos+7,-2);
				
				$update_status = $model->CronUpdateFBPost($id,$postid);
				
				if($rec['email_notify']=='yes')
				{
					$user_rec = $model->CronGetUser($rec['user_id']);
					
					if(count($user_rec))
					{
						if(!empty($user_rec['email']))
						{
							$to       = $user_rec[0]['email'];
							$from	  = 'scheduler@cuecow.com';
							$subject  = 'Schedules content posted on facebook via cuecow.';
							$message  = 'Hello '.$user_rec['fname'].',<br /> We have successfully posted content on your facebook page via cuecow..';
							
							$headers  = "From: " . strip_tags($from) . "\r\n";
							$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
							$headers .= "MIME-Version: 1.0\r\n";
							$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
							
							$mail = mail($to, $subject, $message, $headers);
						}
					}
				}
			}
		}
		else if($rec['content_type']=='photo' || $rec['content_type']=='video')
		{
			if($rec['content_type']=='photo')
			{
				$content_type = 'image';
				$file = $_SERVER['DOCUMENT_ROOT'].'/images/fbposts/'.$rec['photo'];
			}
			else
			{
				$content_type = 'video';
				$file = $_SERVER['DOCUMENT_ROOT'].'/images/fbposts/'.$rec['video'];
			}

			$rec_message = $rec['message'];
			$rec_title = $rec['name'];
			$rec_desc = $rec['message'];
						
			$args = array(
				'message' => $rec_message,
				'link' => $rec['url_link'],
				'title'=> $rec_title,
				'description' => $rec_desc,
				'source' => '@' . realpath($file)
			);
			
			//$args[basename($file)] = '@' . realpath($file);
			
			$tokens = $model->CronUserPageToken($page_id,$user_id);

			if(count($tokens))
				$token = $tokens['token'];
				
			$ch = curl_init();
							
			if($rec['content_type']=='photo')
			{
				$get_albums = 'https://graph.facebook.com/'.$page_id.'/albums?access_token='.$token;
				$feed_album_url = @file_get_contents($get_albums);								
				$feed_album_content = json_decode($feed_album_url);
				$album_id = '';
				
				if(count($feed_album_content))
				{
					foreach($feed_album_content as $ke=>$va)	
					{
						foreach($va as $values)
						{
							if($values->name == 'Wall Photos' && $values->link!='')
								$album_id = $values->id;
						}
					}
				}
				
				if(!empty($album_id))
					$url = 'https://graph.facebook.com/'.$album_id.'/photos?access_token='.$token;
				else
					$url = 'https://graph.facebook.com/'.$page_id.'/photos?access_token='.$token;
			}
			else
				$url = 'https://graph.facebook.com/'.$page_id.'/videos?access_token='.$token;
			
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // allow redirects 
			
			$data = curl_exec($ch);

			curl_close($ch);
					
			if(strstr($data,'{"id":"'))
			{
				$pos = strpos($data,'"post_id":"');
				
				$id = substr($data,$pos+11,-2);
				
				$model->CronUpdateFBPost($id,$postid);
			
				if($rec['email_notify']=='yes')
				{
					$user_rec = $model->CronGetUser($rec['user_id']);
					
					if(count($user_rec))
					{
						if(!empty($user_rec['email']))
						{
							$to      = $user_rec[0]['email'];
							$from	 = 'scheduler@cuecow.com';
							$subject = 'Schedules content posted on facebook via cuecow.';
							$message = 'Hello '.$user_rec['fname'].',<br /> We have successfully posted content on your facebook page via cuecow..';
							
							$headers = "From: " . strip_tags($from) . "\r\n";
							$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
							$headers .= "MIME-Version: 1.0\r\n";
							$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
							
							$mail=mail($to, $subject, $message, $headers);
						}
					}
				}
			}
		}	
	}
}

/**
 * function to update location branches (fb, fs & google)
 */
public function UpdateLocationBranches()
{
	$model = new Cron();
	
	include('google/simple_html_dom.php');
	
	$AllLocation = $model->CronAllLocations();
	
	foreach($AllLocation as $show_rec)
	{
		if(!empty($show_rec['fburl']))
		{
			$fb_record = $model->CronGetFBURL($show_rec['loc_id'],'fburlinfo');;
			
			if($fb_record['fburl_id'])
			{
				if($model->CronChekTodayRec('fburl_data','fburl_id',$fb_record['fburl_id'])==0)	
				{
					$page_id = $fb_record['id'];
				
					$contents 		= 	json_decode(@file_get_contents('http://graph.facebook.com/'.$page_id));
			
					$likes			=	$contents->likes;
					$checkins		=	$contents->checkins;
					$talking_about	=	$contents->talking_about_count;
			
					$AddData = $model->AddFBURLData($fb_record['fburl_id'],$likes,$checkins,$talking_about);
				}
			}

			$UserAccessToken = $model->CronUserAccessToken($show_rec['user_id']);
				
			if(count($UserAccessToken))
			{
				$loc_id = $show_rec['loc_id'];
				
				$record = $UserAccessToken;
				
				if($record['fbtoken'])
				{
					$post_url = "https://graph.facebook.com/" . $page_id . "/insights/page_impressions_by_age_gender_unique/day?access_token=". $record['fbtoken'];
			
					$response_in = @file_get_contents($post_url);
			
					$insights = json_decode($response_in,true);
			
					$data1 = (!empty($insights['data'][0]['values'][0]['value'])) ? 
								$insights['data'][0]['values'][0]['value']:0 ;
								
					$date1 = (!empty($insights['data'][0]['values'][0]['end_time'])) ? 
								$insights['data'][0]['values'][0]['end_time']:0 ;
								
					$data2 = (!empty($insights['data'][0]['values'][1]['value'])) ? 
								$insights['data'][0]['values'][1]['value']:0 ;
								
					$date2 = (!empty($insights['data'][0]['values'][1]['end_time'])) ? 
								$insights['data'][0]['values'][1]['end_time']:0 ;
								
					$data3 = (!empty($insights['data'][0]['values'][2]['value'])) ?
								$insights['data'][0]['values'][2]['value']:0 ;
								 
					$date3 = (!empty($insights['data'][0]['values'][2]['end_time'])) ? 
								$insights['data'][0]['values'][2]['end_time']:0 ;
						
						
					if($date1 != 0)
					{
						$temp_date1 = explode('T0',$date1);
						$date_1_temp = explode('-',$temp_date1[0]);
						$date_1 = mktime(0,0,0,$date_1_temp[1],$date_1_temp[2],$date_1_temp[0]);

						$loc_1 = $model->CronGetDemoAges($loc_id,$date_1);
							
						if(count($loc_1) == 0 && $data1)
						{			
							$sql_1 = "insert into demographic_ages set `loc_id`=".$loc_id.", ";
								
							foreach($data1 as $key=>$value)
							{
								$sql_1 .= '`'.$key.'`='.$value.',';
							}
								
							$sql_1 .= '`dated`="'.$date_1.'"';
								
							$model->CronRunQuery($sql_1);
						}
					}
						
					if($date2 != 0)
					{
						$temp_date2 = explode('T0',$date2);
						$date_2_temp = explode('-',$temp_date2[0]);
						$date_2 = mktime(0,0,0,$date_2_temp[1],$date_2_temp[2],$date_2_temp[0]);
						
						$loc_2 = $model->CronGetDemoAges($loc_id,$date_2);
						
						if(count($loc_2) == 0 && $data2)
						{
							$sql_2="insert into demographic_ages set `loc_id`=".$loc_id.", ";
							
							foreach($data2 as $key2=>$value2)
							{
								$sql_2 .= '`'.$key2.'`='.$value2.',';
							}
							
							$sql_2 .= '`dated`="'.$date_2.'"';
							
							$model->CronRunQuery($sql_2);
						}
					}		
						
					if($date3!=0)
					{
						$temp_date3 = explode('T0',$date3);
						$date_3_temp = explode('-',$temp_date3[0]);
						$date_3 = mktime(0,0,0,$date_3_temp[1],$date_3_temp[2],$date_3_temp[0]);
						
						$loc_3 = $model->CronGetDemoAges($loc_id,$date_3);
						
						if(count($loc_3) == 0 && $data3)
						{
							$sql_3="insert into demographic_ages set `loc_id`=".$loc_id.", ";
							
							foreach($data3 as $key3=>$value3)
							{
								$sql_3 .= '`'.$key3.'`='.$value3.',';
							}
							
							$sql_3 .= '`dated`="'.$date_3.'"';
							
							$model->CronRunQuery($sql_3);
						}
					}
				}
			}
		}
		
		if(!empty($show_rec['fsurl']))
		{
			$fs_record = $model->CronGetFBURL($show_rec['loc_id'],'fsurlinfo');
			
			if(count($fs_record))
			{
				if($fs_record['fsurl_id'])
				{
					if($model->CronChekTodayRec('fsurl_data','fsurl_id',$fs_record['fsurl_id'])==0)	
					{
						
						$id = $fs_record['id'];
					
						$contentsfs = json_decode(@file_get_contents('https://api.foursquare.com/v2/venues/'.$id.'?oauth_token=WB1EEUGJ1QJXP0MNPUPGX5GRWJK0BYISN5YZONI0TOVZ31ID&v='.date('Ymd')));
						
						$checkinsCount	=	$contentsfs->response->venue->stats->checkinsCount;
						$usersCount		=	$contentsfs->response->venue->stats->usersCount;
						$tipCount		=	$contentsfs->response->venue->stats->tipCount;
						
						$AddFSURLData = $model->AddFSURLData($fs_record['fsurl_id'],$checkinsCount,$usersCount,$tipCount);
					}
				}
			}
		}
		
		if(!empty($show_rec['googleurl']))
		{
			$g_record = $model->CronGetFBURL($show_rec['loc_id'],'gurlinfo');
			
			if(count($g_record))
			{
				if($g_record['gurl_id'])
				{
					if($model->CronChekTodayRec('gurl_data','gurl_id',$g_record['gurl_id'])==0)
					{
						$html 		= 	file_get_html($show_rec['googleurl']);
						$longlat	=	strpos($html,"sll=");
						$sublonglat	=	substr($html,$longlat+4,23);
						$quotspace	=	strpos($sublonglat," ");
						$ll			=	substr($sublonglat,0,$quotspace-1);
						
						$expll		=	explode(",",$ll);
						$lati		=	$expll[0];
						$longi		=	$expll[1];
						
						preg_match("/<title>([^>]*)<\/title>/si",$html,$match);
						
						$l 			=	 strip_tags($match[1]);
						
						$locname 	= $this->return_unicode($l);
					
						$strgoogle 	= json_decode(@file_get_contents('https://maps.googleapis.com/maps/api/place/search/json?location='.$lati.','.$longi.'&radius=500&name='.$locname.'&sensor=false&key=AIzaSyCjZdj2qvK8-_Dc5VKvzQtAN_7rIsJWZVM'));
						
						$strgoogledata = json_decode(@file_get_contents('https://maps.googleapis.com/maps/api/place/details/json?reference='.$strgoogle->results[0]->reference.'&sensor=true&key=AIzaSyCjZdj2qvK8-_Dc5VKvzQtAN_7rIsJWZVM'));
						
						$glikes		=	$this->get_plusones($strgoogledata->result->website);
						
						$model->AddGoogleData($g_record['gurl_id'],$glikes);
					}
				}
			}
		}
	}	
}

public function Epaysubscriptioncron()
{
	require_once("epaysoap.php");
	
	$epay = new EpaySoap();
	
	$model = new Cron();
	
	//$merchantnumber = 8010148;
	$merchantnumber = 5732417;
	
	$get_today_pay_rec = $model->CronGetPendingPayments();
	
	if(count($get_today_pay_rec))
	{
		foreach($get_today_pay_rec as $show_today)
		{
			if( $show_today['next_payment'] > 0 )
			{
				//get subscription information
				
				$show_today_rec = $model->CronGetSubscriptionInfo($show_today['user_id']);
				
				if(count($show_today_rec))
				{
					$fetch_prev_trans = $model->CronGetSubscription('subscriptionid',$show_today_rec['subscriptionid']);
					
					$get_num_paid = $model->CronGetAllUserSubscription($show_today['user_id']);
				
					$fetch_plan = $model->CronGetSubscriptionType($show_today_rec['planid']);
					
					if(count($fetch_plan))
					{
						$price = $show_today['next_payment'];
						//$price = $fetch_plan['price'];
							
						$tax = $price * 0.25;
						$amount = $price + $tax;
						$next_bill = strtotime(now) + (30*24*60*60);
						$date_end = date("Y-m-d", $next_bill);
					}
				
					$new_trans = array();
					
					$return = $epay->authorize($merchantnumber, $show_today_rec['subscriptionid'], $show_today_rec['orderid'].$get_num_paid, $amount, 208, 1);
			
					$new_trans['tid'] 			= $return['transactionid'];
					$new_trans['orderid'] 		= $show_today_rec['orderid'].$get_num_paid;
					$new_trans['amount'] 		= $price;
					$new_trans['tax'] 			= $tax;
					$new_trans['total_amount'] 	= $amount;
					$new_trans['cur'] 			= $fetch_prev_trans['cur'];
					$new_trans['date'] 			= date('Ymd');
					$new_trans['time'] 			= date('Hi');
					$new_trans['subscriptionid']= $fetch_prev_trans['subscriptionid'];
					$new_trans['transfee'] 		= $return['transfee'];
					$new_trans['user_id'] 		= $fetch_prev_trans['user_id'];
					$new_trans['account_name'] 	= $fetch_prev_trans['account_name'];
					$new_trans['email'] 		= $fetch_prev_trans['email'];
					$new_trans['username'] 		= $fetch_prev_trans['username'];
					$new_trans['fname'] 		= $fetch_prev_trans['fname'];
					$new_trans['lname'] 		= $fetch_prev_trans['lname'];
					$new_trans['phone'] 		= $fetch_prev_trans['phone'];
					$new_trans['company'] 		= $fetch_prev_trans['company'];
					$new_trans['address'] 		= $fetch_prev_trans['address'];
					$new_trans['postal_code'] 	= $fetch_prev_trans['postal_code'];
					$new_trans['city'] 			= $fetch_prev_trans['city'];
					$new_trans['country'] 		= $fetch_prev_trans['country'];
					$new_trans['planid'] 		= $fetch_prev_trans['planid'];
						
					if($return['authorizeResult']==true)
						$new_trans['status'] 		= 'paid';
					else
						$new_trans['status'] 		= 'unpaid';
					
					$sql = 'insert into transaction set ';
					$sql_temp = '';
					
					$g = 1;
					foreach($new_trans as $key=>$value)
					{
						$sql_temp .= $key.'="'.$value.'"';
						
						if($g!=count($new_trans))
							$sql_temp .=', ';
							
						$g++;
					}
					
					$query = $sql.$sql_temp;
					
					if($return['pbsresponse'] == 0)
					{
						
						$track_rec = $model->CronRunQuery($query);
						
						if($track_rec)
						{
							$update_user = 'update user set subscriptionValidTo="'.$date_end.'" where user_id="'.$show_today['user_id'].'"';
							
							$model->CronRunQuery($update_user);
						}
					}
				}
			}
		}
	}
}

public function get_plusones($url)
{
	$curl = curl_init();

	curl_setopt($curl, CURLOPT_URL, "https://clients6.google.com/rpc");
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $url . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]');
	
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	$curl_results = curl_exec ($curl);
	curl_close ($curl);
									 
	$json = json_decode($curl_results, true);
	$googleplus=intval( $json[0]['result']['metadata']['globalCounts']['count'] );
	return intval( $json[0]['result']['metadata']['globalCounts']['count'] );
}

public function UpdateFBPagesRec()
{
	$model = new Fbpages;
	
	$records = $model->GetTablePages();	
	
	foreach($records as $key=>$value)
	{               
		$contents = @file_get_contents('https://graph.facebook.com/'.$value['page_id']);
		
		$show_content = json_decode($contents);

		if($show_content->app_id == '' || $show_content->app_id == 0)
		{
			$tot_page_post = Fbposts::model()->CountSpecificPosts($value['id'],$value['user_id']);
			
			$fans = $show_content->likes;
			$totposts = $tot_page_post;
			$page_id = $value['page_id'];
			$url = $show_content->link;
			
			$UpdateStats = $model->UpdatePageStats($page_id, $fans, $totposts, $url);
			
		}
	}
}

public function UpdateUserFBPages()
{
	$model = new Fbpages;
	$token_model = new AccessToken;
	
	$tokens = $token_model->GetUserTokens();
	
	if( count($tokens) )
	{
		foreach( $tokens as $key => $value )	
		{
			$user_id = $value['user_id'];	
			$fb_token = $value['fbtoken'];
								
			$verify_user = User::model()->GetUserID($user_id);

			if( count($verify_user))
			{
				$accounts_url = "https://graph.facebook.com/me/accounts?access_token=".$fb_token;
				$response = @file_get_contents($accounts_url);
				
				$resp_obj = json_decode($response,true);
				
				if( $resp_obj['error'] != '')
				{
					//do nothing
				}
				else
				{
					$accounts = $resp_obj['data'];
				
					if( count($accounts) > 0 )
					{		
						$all_ids = '';
						
						foreach( $accounts as $key_acc => $value_acc )	
						{
							$name = $value_acc['name'];
							$access_token_page = $value_acc['access_token'];
							$page_id = $value_acc['id'];
							
							if($page_id)
							{	
								$all_ids .= $page_id.',';
								
								$verify_user_page = $model->VerifyUserPages($user_id, $page_id);
								
								if( count($verify_user_page) == 0 )
								{
									$page_url = "https://graph.facebook.com/" . $page_id;
									$page_resp = @file_get_contents($page_url);
									$page_url_res = json_decode($page_resp);
									$page_url = $page_url_res->link;
									$fans = $page_url_res->likes;
									
									$status = 'blocked';
									
									$store_page_token = $token_model->StorePageAccessToken($name,$access_token_page,$page_id,$user_id);
									$store_page_user  = $model->StoreUserPages($name,$page_id,$page_url,$status,$fans,$user_id);
								}
							}
						}
	
						if( $all_ids != '' )
						{
							$model->DeletePages(substr($all_ids,0,-1),$user_id);
							$token_model->DeleteUserPagesTokens(substr($all_ids,0,-1),$user_id);
						}
					}
				}
			}
			else
				$token_model->DeleteToken($value['token_id']);
		}
	}
}

public function return_unicode($string)
{
	$string = str_replace('À','&Agrave;',$string);
	$string = str_replace('à','&agrave;',$string);
	$string = str_replace('Á','&Aacute;',$string);
	$string = str_replace('á','&aacute;',$string);
	$string = str_replace('Â','&Acirc;',$string);
	$string = str_replace('â','&acirc;',$string);		
	$string = str_replace('Ã','&Atilde;',$string);		
	$string = str_replace('ã','&atilde;',$string);		
	$string = str_replace('Ä','&Auml;',$string);		
	$string = str_replace('ä','&auml;',$string);		
	$string = str_replace('Å','&Aring;',$string);
	$string = str_replace('å','&aring;',$string);		
	$string = str_replace('Æ','&AElig;',$string);		
	$string = str_replace('æ','&aelig;',$string);		
	$string = str_replace('Ç','&Ccedil;',$string);
	$string = str_replace('ç','&ccedil;',$string);		
	$string = str_replace('Ð','&ETH;',$string);
	$string = str_replace('ð','&eth;',$string);
	$string = str_replace('È','&Egrave;',$string);
	$string = str_replace('è','&egrave;',$string);
	$string = str_replace('É','&Eacute;',$string);
	$string = str_replace('é','&eacute;',$string);
	$string = str_replace('Ê','&Ecirc;',$string);
	$string = str_replace('ê','&ecirc;',$string);
	$string = str_replace('Ë','&Euml;',$string);
	$string = str_replace('ë','&euml;',$string);
	$string = str_replace('Ì','&Igrave;',$string);
	$string = str_replace('ì','&igrave;',$string);
	$string = str_replace('Í','&Iacute;',$string);
	$string = str_replace('í','&iacute;',$string);
	$string = str_replace('Î','&Icirc;',$string);
	$string = str_replace('î','&icirc;',$string);
	$string = str_replace('Ï','&Iuml;',$string);
	$string = str_replace('ï','&iuml;',$string);
	$string = str_replace('Ñ','&Ntilde;',$string);
	$string = str_replace('ñ','&ntilde;',$string);
	$string = str_replace('Ò','&Ograve;',$string);
	$string = str_replace('ò','&ograve;',$string);
	$string = str_replace('Ó','&Oacute;',$string);
	$string = str_replace('ó','&oacute;',$string);
	$string = str_replace('Ô','&Ocirc;',$string);
	$string = str_replace('ô','&ocirc;',$string);
	$string = str_replace('Õ','&Otilde;',$string);
	$string = str_replace('õ','&otilde;',$string);
	$string = str_replace('Ö','&Ouml;',$string);
	$string = str_replace('ö','&ouml;',$string);
	$string = str_replace('Ø','&Oslash;',$string);
	$string = str_replace('ø','&oslash;',$string);
	$string = str_replace('Œ','&OElig;',$string);
	$string = str_replace('œ','&oelig;',$string);
	$string = str_replace('ß','&szlig;',$string);
	$string = str_replace('Þ','&THORN;',$string);
	$string = str_replace('þ','&thorn;',$string);
	$string = str_replace('Ù','&Ugrave;',$string);
	$string = str_replace('ù','&ugrave;',$string);
	$string = str_replace('Ú','&Uacute;',$string);
	$string = str_replace('ú','&uacute;',$string);
	$string = str_replace('Û','&Ucirc;',$string);
	$string = str_replace('û','&ucirc;',$string);
	$string = str_replace('Ü','&Uuml;',$string);
	$string = str_replace('ü','&uuml;',$string);
	$string = str_replace('Ý','&Yacute;',$string);
	$string = str_replace('ý','&yacute;',$string);
	$string = str_replace('Ÿ','&Yuml;',$string);
	$string = str_replace('ÿ','&yuml;',$string);
	
	return $string;	
}}