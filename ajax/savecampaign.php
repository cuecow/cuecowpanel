<?php

include('../connection.php');

error_reporting(E_ALL ^ E_NOTICE);

if(isset($_REQUEST['timezone']))
{
	$GetZone = mysql_query('select * from zone where zone_id="'.$_REQUEST['timezone'].'"')or die(mysql_error());	
	
	if(mysql_num_rows($GetZone))
	{
		$FetchZone = mysql_fetch_assoc($GetZone);	
		date_default_timezone_set($FetchZone['name']);
	}
}

if(empty($_REQUEST['savedid']))
{
	if(strtotime($_REQUEST['start_date'])<strtotime($_REQUEST['end_date']))
	{
		if(trim($_REQUEST['group_ids'])=='undefined')
			$group_id_save = 0;
		else
			$group_id_save = trim($_REQUEST['group_ids']);
			
		if(trim($_REQUEST['page_id'])=='undefined')
			$page_id_save = 0;
		else
			$page_id_save = trim($_REQUEST['page_id']);

		$temp_start_time = explode(':',$_REQUEST['start_time']);
			
		$temp_start_date = explode('/',$_REQUEST['start_date']);
		
		if(count($temp_start_time))
			$start_date = @mktime($temp_start_time[0],$temp_start_time[1],0,$temp_start_date[0],$temp_start_date[1],$temp_start_date[2]);
		else
			$start_date = @mktime(0,0,0,$temp_start_date[0],$temp_start_date[1],$temp_start_date[2]);
		
		$temp_end_time = explode(':',$_REQUEST['end_time']);
		
		$temp_end_date = explode('/',$_REQUEST['end_date']);
		
		if(count($temp_end_time))
			$end_date = mktime($temp_end_time[0],$temp_end_time[1],0,$temp_end_date[0],$temp_end_date[1],$temp_end_date[2]);
		else
			$end_date = mktime(0,0,0,$temp_end_date[0],$temp_end_date[1],$temp_end_date[2]);
			
		
		$InsertCamp = mysql_query('insert into campaign(userid,name,group_ids,page_id,start_date,start_time,end_date,end_time,timezone,kpi,facebook_deals,foursquare_specials,google_place,fb_posts,twitter,fb_ads,google_adwords,dated,status) values("'.$_REQUEST['userid'].'","'.return_unicode($_REQUEST['name']).'","'.$group_id_save.'","'.$page_id_save.'","'.$start_date.'","'.$_REQUEST['start_time'].'","'.$end_date.'","'.$_REQUEST['end_time'].'","'.$_REQUEST['timezone'].'","'.$_REQUEST['kpi'].'","'.$_REQUEST['facebook_deals'].'","'.$_REQUEST['foursquare_specials'].'","'.$_REQUEST['google_place'].'","'.$_REQUEST['fb_posts'].'","'.$_REQUEST['twitter'].'","'.$_REQUEST['fb_ads'].'","'.$_REQUEST['google_adwords'].'","'.strtotime(now).'","notpublished")')or die(mysql_error());
		
		$LastCamp = mysql_insert_id();
		
		if($LastCamp)
		{
			if($_REQUEST['foursquare_specials']=='yes')
			{
				$campaign_id	= $LastCamp;
				$location_type	= $_REQUEST['venue_type'];
				$location		= $_REQUEST['location_type'];
				$sp_type 		= $_REQUEST['sp_type'];
				$count1 		= ($_REQUEST['count1']!='undefined') ? $_REQUEST['count1']:'';
				$count2 		= ($_REQUEST['count2']!='undefined') ? $_REQUEST['count2']:'';
				$count3 		= ($_REQUEST['count3']!='undefined') ? $_REQUEST['count3']:'';
				$unlockedText 	= $_REQUEST['unlockedText'];
				$offer 			= $_REQUEST['offer'];
				$finePrint 		= $_REQUEST['finePrint'];
				$cost 			= $_REQUEST['cost'];
				$status 		= 'pending';
				$dated 			= strtotime(now);
				
				$InsertSpecial = mysql_query('insert into fs_special(campaign_id,location_type,location,sp_type,count1,count2,count3,unlockedText,offer,finePrint,cost,status,dated) values("'.$campaign_id.'","'.$location_type.'","'.$location.'","'.$sp_type.'","'.$count1.'","'.$count2.'","'.$count3.'","'.$unlockedText.'","'.$offer.'","'.$finePrint.'","'.$cost.'","'.$status.'","'.$dated.'")')or die(mysql_error());
				
			}
			
			if($_REQUEST['fb_posts']=='yes')
			{
				$campaign_id	= $LastCamp;
				$post_title 	= return_unicode($_REQUEST['post_title']);
				$content_type 	= $_REQUEST['content_type'];
				$message 		= return_unicode($_REQUEST['message']);
				$url_link 		= ($_REQUEST['url_link']!='undefined') ? $_REQUEST['url_link']:'';
				$title 			= ($_REQUEST['title']!='undefined') ? $_REQUEST['title']:'';
				$description 	= ($_REQUEST['description']!='undefined') ? $_REQUEST['description']:'';
				$email_notify 	= $_REQUEST['email_notify'];
				$sel_wall		= $_REQUEST['sel_wall'];
				$selected_wall	= $_REQUEST['selected_wall'];
				
				$InsertFb = mysql_query('insert into campaign_fbpost(campaign_id,post_title,selected_wall_option,selected_wall,content_type,url_link,message,title,description,email_notify) values("'.$campaign_id.'","'.$post_title.'","'.$sel_wall.'","'.$selected_wall.'",'.$content_type.'","'.$url_link.'","'.$message.'","'.$title.'","'.$description.'","'.$email_notify.'")')or die(mysql_error());
				
			}
		}
		
		echo $LastCamp;
	}
}
else
{
	if(trim($_REQUEST['group_ids'])=='undefined')
		$group_id_save = 0;
	else
		$group_id_save = trim($_REQUEST['group_ids']);
		
	if(trim($_REQUEST['page_id'])=='undefined')
		$page_id_save = 0;
	else
		$page_id_save = trim($_REQUEST['page_id']);
		
	if($_REQUEST['start_time'])
		$temp_start_time = explode(':',$_REQUEST['start_time']);
	
	if($_REQUEST['start_date'])		
		$temp_start_date = explode('/',$_REQUEST['start_date']);
	
	if(count($temp_start_time))
		$start_date = mktime($temp_start_time[0],$temp_start_time[1],0,$temp_start_date[0],$temp_start_date[1],$temp_start_date[2]);
	else
		$start_date = mktime(0,0,0,$temp_start_date[0],$temp_start_date[1],$temp_start_date[2]);
	
	if($_REQUEST['end_time'])
		$temp_end_time = explode(':',$_REQUEST['end_time']);
	
	if($_REQUEST['end_date'])
		$temp_end_date = explode('/',$_REQUEST['end_date']);
	
	if(count($temp_end_time))
		$end_date = mktime($temp_end_time[0],$temp_end_time[1],0,$temp_end_date[0],$temp_end_date[1],$temp_end_date[2]);
	else
		$end_date = mktime(0,0,0,$temp_end_date[0],$temp_end_date[1],$temp_end_date[2]);
		
			
	$UpdateCamp = mysql_query('update campaign set name="'.return_unicode($_REQUEST['name']).'",group_ids="'.$group_id_save.'",page_id="'.$page_id_save.'",start_date="'.$start_date.'",start_time="'.$_REQUEST['start_time'].'",end_date="'.$end_date.'",end_time="'.$_REQUEST['end_time'].'",timezone="'.$_REQUEST['timezone'].'",kpi="'.$_REQUEST['kpi'].'",facebook_deals="'.$_REQUEST['facebook_deals'].'",foursquare_specials="'.$_REQUEST['foursquare_specials'].'",google_place="'.$_REQUEST['google_place'].'",fb_posts="'.$_REQUEST['fb_posts'].'",twitter="'.$_REQUEST['twitter'].'",fb_ads="'.$_REQUEST['fb_ads'].'",google_adwords="'.$_REQUEST['google_adwords'].'" where campaign_id="'.$_REQUEST['savedid'].'"')or die(mysql_error());
	
	if($_REQUEST['foursquare_specials']=='yes')
	{
		$campaign_id	= $_REQUEST['savedid'];
		$location_type	= $_REQUEST['venue_type'];
		$location		= $_REQUEST['location_type'];
		$sp_type 		= $_REQUEST['sp_type'];
		$count1 		= ($_REQUEST['count1']!='undefined') ? $_REQUEST['count1']:'';
		$count2 		= ($_REQUEST['count2']!='undefined') ? $_REQUEST['count2']:'';
		$count3 		= ($_REQUEST['count3']!='undefined') ? $_REQUEST['count3']:'';
		$unlockedText 	= $_REQUEST['unlockedText'];
		$offer 			= $_REQUEST['offer'];
		$finePrint 		= $_REQUEST['finePrint'];
		$cost 			= $_REQUEST['cost'];
		$status 		= 'pending';
		$dated 			= strtotime(now);
			
		$get_rec =	 mysql_query('select * from fs_special where campaign_id="'.$campaign_id.'"')or die(mysql_error());
		
		if(mysql_num_rows($get_rec))
		{
			$UpdateSpecial = mysql_query('update fs_special set location_type="'.$location_type.'",location="'.$location.'", sp_type="'.$sp_type.'",count1="'.$count1.'",count2="'.$count2.'",count3="'.$count3.'",unlockedText="'.$unlockedText.'",offer="'.$offer.'",finePrint="'.$finePrint.'",cost="'.$cost.'" where campaign_id="'.$campaign_id.'"')or die(mysql_error());
		}
		else
		{
			$InsertSpecial = mysql_query('insert into fs_special(campaign_id,location_type,location,sp_type,count1,count2,count3,unlockedText,offer,finePrint,cost,status,dated) values("'.$campaign_id.'","'.$location_type.'","'.$location.'","'.$sp_type.'","'.$count1.'","'.$count2.'","'.$count3.'","'.$unlockedText.'","'.$offer.'","'.$finePrint.'","'.$cost.'","'.$status.'","'.$dated.'")')or die(mysql_error());
		}
		
	}
		
	if($_REQUEST['fb_posts']=='yes')
	{
		$campaign_id	= $_REQUEST['savedid'];
		$post_title 	= return_unicode($_REQUEST['post_title']);
		$content_type 	= $_REQUEST['content_type'];
		$message 		= return_unicode($_REQUEST['message']);
		$url_link 		= ($_REQUEST['url_link']!='undefined') ? $_REQUEST['url_link']:'';
		$title 			= ($_REQUEST['title']!='undefined') ? $_REQUEST['title']:'';
		$description 	= ($_REQUEST['description']!='undefined') ? $_REQUEST['description']:'';
		$email_notify 	= $_REQUEST['email_notify'];
		$sel_wall		= $_REQUEST['sel_wall'];
		$selected_wall	= $_REQUEST['selected_wall'];
		
		$get_rec2 =	 mysql_query('select * from campaign_fbpost where campaign_id="'.$campaign_id.'"')or die(mysql_error());
		
		if(mysql_num_rows($get_rec2))
		{
			$UpdateFb = mysql_query('update campaign_fbpost set post_title="'.$post_title.'", selected_wall_option="'.$sel_wall.'", selected_wall="'.$selected_wall.'", content_type="'.$content_type.'",url_link="'.$url_link.'",message="'.$message.'",title="'.$title.'",description="'.$description.'",email_notify="'.$email_notify.'" where campaign_id="'.$campaign_id.'"')or die(mysql_error());
		}
		else
		{
			$InsertFb = mysql_query('insert into campaign_fbpost(campaign_id,post_title,selected_wall_option,selected_wall,content_type,url_link,message,title,description,email_notify) values("'.$campaign_id.'","'.$post_title.'","'.$sel_wall.'","'.$selected_wall.'","'.$content_type.'","'.$url_link.'","'.$message.'","'.$title.'","'.$description.'","'.$email_notify.'")')or die(mysql_error());
		}	
	}
	
	echo $_REQUEST['savedid'];
}

function return_unicode($string)
{
	$string=str_replace('À','&Agrave;',$string);
	$string=str_replace('à','&agrave;',$string);
	$string=str_replace('Á','&Aacute;',$string);
	$string=str_replace('á','&aacute;',$string);
	$string=str_replace('Â','&Acirc;',$string);
	$string=str_replace('â','&acirc;',$string);
	$string=str_replace('Ã','&Atilde;',$string);
	$string=str_replace('ã','&atilde;',$string);
	$string=str_replace('Ä','&Auml;',$string);
	$string=str_replace('ä','&auml;',$string);
	$string=str_replace('Å','&Aring;',$string);
	$string=str_replace('å','&aring;',$string);
	$string=str_replace('Æ','&AElig;',$string);
	$string=str_replace('æ','&aelig;',$string);
	$string=str_replace('Ç','&Ccedil;',$string);
	$string=str_replace('ç','&ccedil;',$string);
	$string=str_replace('Ð','&ETH;',$string);
	$string=str_replace('ð','&eth;',$string);
	$string=str_replace('È','&Egrave;',$string);
	$string=str_replace('è','&egrave;',$string);
	$string=str_replace('É','&Eacute;',$string);
	$string=str_replace('é','&eacute;',$string);
	$string=str_replace('Ê','&Ecirc;',$string);
	$string=str_replace('ê','&ecirc;',$string);
	$string=str_replace('Ë','&Euml;',$string);
	$string=str_replace('ë','&euml;',$string);
	$string=str_replace('Ì','&Igrave;',$string);
	$string=str_replace('ì','&igrave;',$string);
	$string=str_replace('Í','&Iacute;',$string);
	$string=str_replace('í','&iacute;',$string);
	$string=str_replace('Î','&Icirc;',$string);
	$string=str_replace('î','&icirc;',$string);
	$string=str_replace('Ï','&Iuml;',$string);
	$string=str_replace('ï','&iuml;',$string);
	$string=str_replace('Ñ','&Ntilde;',$string);
	$string=str_replace('ñ','&ntilde;',$string);
	$string=str_replace('Ò','&Ograve;',$string);
	$string=str_replace('ò','&ograve;',$string);
	$string=str_replace('Ó','&Oacute;',$string);
	$string=str_replace('ó','&oacute;',$string);
	$string=str_replace('Ô','&Ocirc;',$string);
	$string=str_replace('ô','&ocirc;',$string);
	$string=str_replace('Õ','&Otilde;',$string);
	$string=str_replace('õ','&otilde;',$string);
	$string=str_replace('Ö','&Ouml;',$string);
	$string=str_replace('ö','&ouml;',$string);
	$string=str_replace('Ø','&Oslash;',$string);
	$string=str_replace('ø','&oslash;',$string);
	$string=str_replace('Œ','&OElig;',$string);
	$string=str_replace('œ','&oelig;',$string);
	$string=str_replace('ß','&szlig;',$string);
	$string=str_replace('Þ','&THORN;',$string);
	$string=str_replace('þ','&thorn;',$string);
	$string=str_replace('Ù','&Ugrave;',$string);
	$string=str_replace('ù','&ugrave;',$string);
	$string=str_replace('Ú','&Uacute;',$string);
	$string=str_replace('ú','&uacute;',$string);
	$string=str_replace('Û','&Ucirc;',$string);
	$string=str_replace('û','&ucirc;',$string);
	$string=str_replace('Ü','&Uuml;',$string);
	$string=str_replace('ü','&uuml;',$string);
	$string=str_replace('Ý','&Yacute;',$string);
	$string=str_replace('ý','&yacute;',$string);
	$string=str_replace('Ÿ','&Yuml;',$string);
	$string=str_replace('ÿ','&yuml;',$string);
	
	return $string;	
}

?>