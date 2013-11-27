<?php

if(!function_exists('GetPageTitle'))
{
	function GetPageTitle($pageurl,$view)
	{
		$temp_url = explode('/',$pageurl);
		
		if(count($temp_url))
		{
			$r = 1;
			$new_url = '';
			foreach($temp_url as $title_url)
			{
				if(!empty($title_url))	
				{
					$new_url .='/'.$title_url;
					$r++;
				}
				
				if($r>=3)
					break;
			}
			
			$result = PageTitles::model()->GetPageTitle($new_url,$view);

			return $result[0]['title'];
		}
	}
}

if(!function_exists('GetPageSubTitle'))
{
	function GetPageSubTitle($pageurl,$view)
	{
		$temp_url = explode('/',$pageurl);
		
		if(count($temp_url))
		{
			$r = 1;
			$new_url = '';
			foreach($temp_url as $title_url)
			{
				if(!empty($title_url))	
				{
					$new_url .='/'.$title_url;
					$r++;
				}
				
				if($r>=3)
					break;
			}
			
			$result = PageTitles::model()->GetPageTitle($new_url,$view);

			return $result[0]['page_subtitle'];
		}
	}
}

if(!function_exists('guid'))
{
	function guid()
	{
    	if (function_exists('com_create_guid')){
        	return com_create_guid();
	    }else{
    	    mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        	$charid = strtoupper(md5(uniqid(rand(), true)));
	        $hyphen = chr(45);// "-"
    	    $uuid = chr(123)// "{"
                .substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12)
                .chr(125);// "}"
        	return $uuid;
    	}
	}
}

if(!function_exists('getContent'))
{
	function getContent($contentId, $langId = 1, $defaultText = '')
	{	
		// for online server, uncomment belowe lines
		if(Yii::app()->cache->get($contentId.$langId)===false)
		{
			$GetRecord = Contents::model()->GetRecord($contentId,$langId);
			Yii::app()->cache->set($contentId.$langId, $GetRecord['content_text']);
			$GetRecord = $GetRecord['content_text'];
		}
    	else
			$GetRecord = Yii::app()->cache->get($contentId.$langId);
		
		if(!empty($GetRecord))
			return $GetRecord;
		else if($contentId == 'user.dashboard')
		{
			$content_helper = Contents::model()->GetRecord('default.introtext',$langId);
			return $GetRecord = $content_helper['content_text'];
		}
		

		// for local server uncomment below lines

		//$GetRecord = Contents::model()->GetRecord($contentId,$langId);
			
		return $GetRecord = $GetRecord['content_text'];
	}
}

if(!function_exists('findpage'))
{
	function findpage($pageid)
	{
		if($pageid != '/user/profile/view/medias')
		{
			$temp_url = explode('/',$pageid);
			
			if(count($temp_url))
			{
				$r = 1;
				$new_url = '';
				foreach($temp_url as $title_url)
				{
					if(!empty($title_url))	
					{
						$new_url .='/'.$title_url;
						$r++;
					}
					
					if($r>=3)
						break;
				}
			}
		}
		else
			$new_url = $pageid;
			
		$haystack = array('/user/dashboard'=>'dashboard.introtext','/location/location'=>'venue.introtext','/user/campaign'=>'campaign.introtext','/user/facebook'=>'pages.introtext','/user/buzz'=>'buzz.introtext','/user/profile/view/medias'=>'authentication.introtext');

		return $haystack[$new_url];
	}
}

if(!function_exists('newfindpage'))
{
	function newfindpage($pageid)
	{
		$temp_url = explode('/',$pageid);
			
		if(count($temp_url))
		{
			$r = 1;
			$new_url = '';
			foreach($temp_url as $title_url)
			{
				if(!empty($title_url))	
				{
					$new_url .=$title_url.'.';
					$r++;
				}
				
				/*if($r>=3)
					break;*/
			}
		}
		
		return substr($new_url,0,-1);
	}
}