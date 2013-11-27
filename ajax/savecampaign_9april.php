<?php

include('../connection.php');

if(empty($_REQUEST['savedid']))
{
	$InsertCamp = mysql_query('insert into campaign(userid,name,group_ids,page_id,start_date,end_date,kpi,facebook_deals,foursquare_specials,google_place,fb_posts,twitter,fb_ads,google_adwords,dated,status) values("'.$_REQUEST['userid'].'","'.$_REQUEST['name'].'","'.$_REQUEST['group_ids'].'","'.$_REQUEST['page_id'].'","'.$_REQUEST['start_date'].'","'.$_REQUEST['end_date'].'","'.$_REQUEST['kpi'].'","'.$_REQUEST['facebook_deals'].'","'.$_REQUEST['foursquare_specials'].'","'.$_REQUEST['google_place'].'","'.$_REQUEST['fb_posts'].'","'.$_REQUEST['twitter'].'","'.$_REQUEST['fb_ads'].'","'.$_REQUEST['google_adwords'].'","'.strtotime(now).'","pending")')or die(mysql_error());
	
	$LastCamp = mysql_insert_id();
	
	if($LastCamp)
	{
		if($_REQUEST['foursquare_specials']=='yes')
		{
			$campaign_id	= $LastCamp;
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
			
			$InsertSpecial = mysql_query('insert into fs_special(campaign_id,sp_type,count1,count2,count3,unlockedText,offer,finePrint,cost,status,dated) values("'.$campaign_id.'","'.$sp_type.'","'.$count1.'","'.$count2.'","'.$count3.'","'.$unlockedText.'","'.$offer.'","'.$finePrint.'","'.$cost.'","'.$status.'","'.$dated.'")')or die(mysql_error());
			
		}
		
		if($_REQUEST['fb_posts']=='yes')
		{
			$campaign_id	= $LastCamp;
			$post_title 	= $_REQUEST['post_title'];
			$content_type 	= $_REQUEST['content_type'];
			$message 		= $_REQUEST['message'];
			$url_link 		= ($_REQUEST['url_link']!='undefined') ? $_REQUEST['url_link']:'';
			$title 			= ($_REQUEST['title']!='undefined') ? $_REQUEST['title']:'';
			$description 	= ($_REQUEST['description']!='undefined') ? $_REQUEST['description']:'';
			$email_notify 	= $_REQUEST['email_notify'];
			
			$InsertFb = mysql_query('insert into campaign_fbpost(campaign_id,post_title,content_type,url_link,message,title,description,email_notify) values("'.$campaign_id.'","'.$post_title.'","'.$content_type.'","'.$url_link.'","'.$message.'","'.$title.'","'.$description.'","'.$email_notify.'")')or die(mysql_error());
			
		}
	}
	
	echo $LastCamp;
}
else
{
	$UpdateCamp = mysql_query('update campaign set name="'.$_REQUEST['name'].'",group_ids="'.$_REQUEST['group_ids'].'",page_id="'.$_REQUEST['page_id'].'",start_date="'.$_REQUEST['start_date'].'",end_date="'.$_REQUEST['end_date'].'",kpi="'.$_REQUEST['kpi'].'",facebook_deals="'.$_REQUEST['facebook_deals'].'",foursquare_specials="'.$_REQUEST['foursquare_specials'].'",google_place="'.$_REQUEST['google_place'].'",fb_posts="'.$_REQUEST['fb_posts'].'",twitter="'.$_REQUEST['twitter'].'",fb_ads="'.$_REQUEST['fb_ads'].'",google_adwords="'.$_REQUEST['google_adwords'].'" where campaign_id="'.$_REQUEST['savedid'].'"')or die(mysql_error());
	
	if($_REQUEST['foursquare_specials']=='yes')
	{
		$campaign_id	= $_REQUEST['savedid'];
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
			$UpdateSpecial = mysql_query('update fs_special set sp_type="'.$sp_type.'",count1="'.$count1.'",count2="'.$count2.'",count3="'.$count3.'",unlockedText="'.$unlockedText.'",offer="'.$offer.'",finePrint="'.$finePrint.'",cost="'.$cost.'" where campaign_id="'.$campaign_id.'"')or die(mysql_error());
		}
		else
		{
			$InsertSpecial = mysql_query('insert into fs_special(campaign_id,sp_type,count1,count2,count3,unlockedText,offer,finePrint,cost,status,dated) values("'.$campaign_id.'","'.$sp_type.'","'.$count1.'","'.$count2.'","'.$count3.'","'.$unlockedText.'","'.$offer.'","'.$finePrint.'","'.$cost.'","'.$status.'","'.$dated.'")')or die(mysql_error());
		}
		
	}
		
	if($_REQUEST['fb_posts']=='yes')
	{
		$campaign_id	= $_REQUEST['savedid'];
		$post_title 	= $_REQUEST['post_title'];
		$content_type 	= $_REQUEST['content_type'];
		$message 		= $_REQUEST['message'];
		$url_link 		= ($_REQUEST['url_link']!='undefined') ? $_REQUEST['url_link']:'';
		$title 			= ($_REQUEST['title']!='undefined') ? $_REQUEST['title']:'';
		$description 	= ($_REQUEST['description']!='undefined') ? $_REQUEST['description']:'';
		$email_notify 	= $_REQUEST['email_notify'];
		
		$get_rec2 =	 mysql_query('select * from campaign_fbpost where campaign_id="'.$campaign_id.'"')or die(mysql_error());
		
		if(mysql_num_rows($get_rec2))
		{
			$UpdateFb = mysql_query('update campaign_fbpost set post_title="'.$post_title.'",content_type="'.$content_type.'",url_link="'.$url_link.'",message="'.$message.'",title="'.$title.'",description="'.$description.'",email_notify="'.$email_notify.'" where campaign_id="'.$campaign_id.'"')or die(mysql_error());
		}
		else
		{
			$InsertFb = mysql_query('insert into campaign_fbpost(campaign_id,post_title,content_type,url_link,message,title,description,email_notify) values("'.$campaign_id.'","'.$post_title.'","'.$content_type.'","'.$url_link.'","'.$message.'","'.$title.'","'.$description.'","'.$email_notify.'")')or die(mysql_error());
		}	
	}
	
	echo $_REQUEST['savedid'];
}

?>