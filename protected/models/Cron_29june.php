<?php

class Cron extends CActiveRecord
{
	//private $_identity;
	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}
	
	public function CronAllLocations()
	{
		$connection = Yii::app()->db;
		$sql = "SELECT * FROM location";
		
		$result = $connection->createCommand($sql)->queryAll();
		return $result;
	}
	
	public function CronGetVenue($loc_id,$in = false)
	{
		$connection = Yii::app()->db;
		
		if($in == true)
			$sql = 'select * from location where loc_id IN ("'.$loc_id.'")';
		else
			$sql = 'select * from location where loc_id="'.$loc_id.'"';
		
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function CronCampaignFBPost($campaign_id)
	{
		$connection = Yii::app()->db;
		$sql = 'select * from campaign_fbpost where campaign_id="'.$campaign_id.'" and posted_id=""';
		
		$result = $connection->createCommand($sql)->queryAll();
		return $result;
	}
	
	public function CronGetVenueGroup($group_id,$user_id = '')
	{
		$connection = Yii::app()->db;
		
		$sql = 'select * from location_group where group_id="'.$group_id.'"';
		
		if($user_id != '')
			$sql .=' and userid=='.$user_id;
		
		$result = $connection->createCommand($sql)->queryAll();
		return $result;
	}
	
	public function CronGetFBURL($locid,$tablename)
	{
		$connection = Yii::app()->db;
		$sql = 'select * from '.$tablename.' where loc_id="'.$locid.'"';
		
		$result = $connection->createCommand($sql)->queryAll();
		return $result[0];
	}
	
	public function AddFBURLData($fburl_id,$likes,$checkins,$talking_about)
	{
		$connection = Yii::app()->db;	
		
		if($likes == '' && $checkins == '' && $talking_about == '')
		{
			// do nothing
		}
		else
		{
			$sql = 'INSERT INTO fburl_data(fburl_id,likes,checkins,talking_about_count,`date`,dated) VALUES("'.$fburl_id.'","'.$likes.'","'.$checkins.'","'.$talking_about.'","'.date('Y-m-d').'","'.strtotime(now).'")';
				
			$result = $connection->createCommand($sql);
			$final_result = $result->execute();
			
			return $final_result;
		}
	}
	
	public function CronUserAccessToken($userid)
	{
		$connection = Yii::app()->db;
		$sql = 'SELECT * FROM access_token where user_id="'.$userid.'"';
		
		$result = $connection->createCommand($sql)->queryAll();
		return $result[0];
	}
	
	public function CronGetDemoAges($loc_id,$date)
	{
		$connection = Yii::app()->db;
		$sql = "SELECT * FROM demographic_ages where loc_id= ".$loc_id." and dated='".$date."'";
		
		$result = $connection->createCommand($sql)->queryAll();
		return $result[0];
	}
	
	public function CronRunQuery($sql)
	{
		$connection = Yii::app()->db;	
			
		$result = $connection->createCommand($sql);
		$final_result = $result->execute();
		
		return $final_result;
	}
	
	public function CronChekTodayRec($table,$column,$value)
	{
		$connection = Yii::app()->db;	
		
		$sql = "SELECT * FROM ".$table." where date='".date('Y-m-d')."' and ".$column."=".$value."";
		
		$result = $connection->createCommand($sql)->queryAll();

		return count($result);
	}
	
	public function AddFSURLData($fsurl_id,$checkinsCount,$usersCount,$tipCount)
	{
		$connection = Yii::app()->db;	
		
		$sql = 'INSERT INTO fsurl_data(fsurl_id,checkinsCount,usersCount,tipCount,`date`,dated) VALUES("'.$fsurl_id.'","'.$checkinsCount.'","'.$usersCount.'","'.$tipCount.'","'.date('Y-m-d').'","'.strtotime(now).'")';
			
		$result = $connection->createCommand($sql);
		$final_result = $result->execute();
		
		return $final_result;
	}
	
	public function AddGoogleData($gurl_id,$glikes)
	{
		$connection = Yii::app()->db;	
		
		$sql = 'INSERT INTO gurl_data(gurl_id,glikes,`date`,dated) VALUES("'.$gurl_id.'","'.$glikes.'","'.date('Y-m-d').'","'.strtotime(now).'")';
			
		$result = $connection->createCommand($sql);
		$final_result = $result->execute();
		
		return $final_result;
	}
	
	public function CronAllPosts()
	{
		$connection = Yii::app()->db;

		$sql = "SELECT * FROM fbpost where status = 'pending'";
		
		$result = $connection->createCommand($sql)->queryAll();
		return $result;
	}
	
	public function CronGetFBPost($postid)
	{
		$connection = Yii::app()->db;

		$sql = "select * from fbpost where post_id=".$postid;
		
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result[0];
	}
	
	public function CronGetZone($zone_id)
	{
		$connection = Yii::app()->db;
		$sql = "select * from zone where zone_id='".$zone_id."'";
		
		$result = $connection->createCommand($sql)->queryAll();
		return $result[0];
	}
	
	public function CronGetFSSpecial($campaign_id)
	{
		$connection = Yii::app()->db;
		$sql = 'select * from fs_special where campaign_id="'.$campaign_id.'" and special=""';
		
		$result = $connection->createCommand($sql)->queryAll();
		return $result[0];
	}
	
	public function CronGetFBPage($page_id = '',$user_id)
	{
		$connection = Yii::app()->db;
		
		$sql = 'select * from fbpages where user_id='.$user_id;
		
		if($page_id)
			$sql .= ' and id='.$page_id;
		
		$result = $connection->createCommand($sql)->queryAll();
		return $result[0];
	}
	
	public function CronGroupFBPage($group_id,$user_id)
	{
		$connection = Yii::app()->db;
		$sql = 'select * from location where group_ids like "%'.$group_id.'%" and user_id='.$user_id;
		
		$result = $connection->createCommand($sql)->queryAll();
		return $result;
	}
	
	public function CronFBURLInfo($loc_id)
	{
		$connection = Yii::app()->db;
		$sql = 'select * from fburlinfo where loc_id='.$loc_id;
		
		$result = $connection->createCommand($sql)->queryAll();
		return $result;
	}
	
	public function CronUserPageToken($page_id,$user_id)
	{
		$connection = Yii::app()->db;
		
		$sql = 'select * from user_pages_token where page_id='.$page_id.' and user_id='.$user_id.' order by pages_token_id desc limit 0,1';
		
		$result = $connection->createCommand($sql)->queryAll();

		return $result[0];
	}
	
	public function CronUpdateCampaign($campaign_id)
	{
		$connection = Yii::app()->db;	
		
		$sql = 'update campaign set status="active" where campaign_id="'.$campaign_id.'"';
			
		$result = $connection->createCommand($sql);
		$final_result = $result->execute();
		
		return $final_result;
	}
	
	public function CronUpdateFBPost($id,$postid)
	{
		$connection = Yii::app()->db;	
		
		$sql = 'update fbpost set status="posted", posted_id="'.$id.'" where post_id="'.$postid.'"';
			
		$result = $connection->createCommand($sql);
		$final_result = $result->execute();
		
		return $final_result;
	}
	
	public function CronUpdateFSSpecial($id,$fs_special_id)
	{
		$connection = Yii::app()->db;	
		
		$sql = 'UPDATE fs_special set status="posted",special="'.$id.'" where fs_special_id='.$fs_special_id;
			
		$result = $connection->createCommand($sql);
		$final_result = $result->execute();
		
		return $final_result;
	}
	
	public function CronGetUser($userid)
	{
		$connection = Yii::app()->db;	
		
		$sql = 'select * from user where user_id="'.$userid.'"';
			
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function CronGetPendingCampaign()
	{
		$connection = Yii::app()->db;	
		
		$sql = 'select * from campaign where status="pending"';
			
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function CronGetPendingPayments()
	{
		$connection = Yii::app()->db;	
		
		$sql = 'select * from user where subscriptionValidTo <= "'.date('Y-m-d').'" and status="active" and subscriptionType != "Moo"';
			
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function CronGetSubscriptionInfo($user_id)
	{
		$connection = Yii::app()->db;	
		
		$sql = 'select * from transaction where user_id="'.$user_id.'" order by id desc limit 0,1';
			
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result[0];
	}
	
	public function CronGetAllUserSubscription($user_id)
	{
		$connection = Yii::app()->db;	
		
		$sql = 'select * from transaction where user_id="'.$user_id.'"';
			
		$result = $connection->createCommand($sql)->queryAll();
		
		return count($result);
	}
	
	public function CronGetSubscription($column,$value)
	{
		$connection = Yii::app()->db;	
		
		$sql = 'select * from transaction where '.$column.'="'.$value.'"';
			
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result[0];
	}
	
	public function CronGetSubscriptionType($planid)
	{
		$connection = Yii::app()->db;	
		
		$sql = 'select * from subsription_type where subscription_id="'.$planid.'"';
			
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result[0];
	}
}