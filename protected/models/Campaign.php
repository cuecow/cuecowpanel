<?php

/**
 * This is the model class for table "campaign".
 *
 * The followings are the available columns in table 'campaign':
 * @property string $campaign_id
 * @property string $name
 * @property string $facebook_deals
 * @property string $foursquare_specials
 * @property string $google_place
 * @property string $fb_posts
 * @property string $twitter
 * @property string $fb_ads
 * @property string $google_adwords
 * @property string $dated
 */
class Campaign extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Campaign the static model class
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
		return 'campaign';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			/*array('name, dated', 'required'),
			array('name', 'length', 'max'=>500),
			array('facebook_deals, foursquare_specials, google_place, fb_posts, twitter, fb_ads, google_adwords', 'length', 'max'=>3),
			array('dated', 'length', 'max'=>20),*/
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('campaign_id, name, facebook_deals, foursquare_specials, google_place, fb_posts, twitter, fb_ads, google_adwords, dated', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'campaign_id' => 'Campaign',
			'name' => 'Name',
			'facebook_deals' => 'Facebook Deals',
			'foursquare_specials' => 'Foursquare Specials',
			'google_place' => 'Google Place',
			'fb_posts' => 'Fb Posts',
			'twitter' => 'Twitter',
			'fb_ads' => 'Fb Ads',
			'google_adwords' => 'Google Adwords',
			'dated' => 'Dated',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('campaign_id',$this->campaign_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('facebook_deals',$this->facebook_deals,true);
		$criteria->compare('foursquare_specials',$this->foursquare_specials,true);
		$criteria->compare('google_place',$this->google_place,true);
		$criteria->compare('fb_posts',$this->fb_posts,true);
		$criteria->compare('twitter',$this->twitter,true);
		$criteria->compare('fb_ads',$this->fb_ads,true);
		$criteria->compare('google_adwords',$this->google_adwords,true);
		$criteria->compare('dated',$this->dated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function GetCampaign($campaign_id)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM campaign where campaign_id= ".$campaign_id;
		$result=$connection->createCommand($sql)->queryAll();
		return $result;
	}
	
	public function GetFSSpecial($campaign_id)
	{
		$connection = Yii::app()->db;
		$sql = 'select * from fs_special where campaign_id="'.$campaign_id.'"';
		
		$result = $connection->createCommand($sql)->queryAll();
		return $result[0];
	}
	
	public function GetPendingCampaign()
	{
		$connection=Yii::app()->db;
		
		$sql = "SELECT * FROM campaign where userid= ".Yii::app()->user->user_id." and status='notpublished'";
		$result = $connection->createCommand($sql)->queryAll();

		return $result;
	}
	
	
	public function GetActiveCampaigns()
	{
		$connection=Yii::app()->db;
		
		$sql = "SELECT * FROM campaign where userid= ".Yii::app()->user->user_id." and status='active'";
		$result = $connection->createCommand($sql)->queryAll();

		$camp_ids = '';
		
		if(count($result))
		{
			foreach($result as $key=>$value)	
			{
				if(!empty($value['timezone']))
				{
					$sql2 = "select * from zone where zone_id='".$value['timezone']."'";
					$result2 = $connection->createCommand($sql2)->queryAll();
		
					if(count($result2))
						date_default_timezone_set($result2[0]['name']);
				}
				
				$today_date = date('m/d/Y');
				$time_now = date('h:i');
				
				if(!empty($value['start_time']))
				{
					$temp_holder = explode(':',$value['start_time']);
					$new_start_date = mktime($temp_holder[0],$temp_holder[1],0,date('m',$value['start_date']),date('d',$value['start_date']),date('Y',$value['start_date']));
				}
				else
					$new_start_date = $value['start_date'];
					
				if(!empty($value['end_time']))
				{
					$temp_holder = explode(':',$value['end_time']);
					$new_end_date = mktime($temp_holder[0],$temp_holder[1],0,date('m',$value['end_date']),date('d',$value['end_date']),date('Y',$value['end_date']));
				}
				else
					$new_end_date = $value['end_date'];		
				
				if($new_start_date <= strtotime(now) && $new_end_date > strtotime(now))
					$camp_ids .= $value['campaign_id'].',';
			}

		}
		
		if(!empty($camp_ids))
			$sql ="SELECT * FROM campaign where userid= ".Yii::app()->user->user_id." and status='active' and campaign_id IN(".substr($camp_ids,0,-1).")";
		else
			$sql = "SELECT * FROM campaign where userid= 0 and status='active'";
			
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetLatestActiveCampaigns()
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM campaign where userid= ".Yii::app()->user->user_id." and status='active' and start_date<='".strtotime(now)."' and end_date>'".strtotime(now)."' order by dated desc limit 0,3";
		$result=$connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetPlanedCampaigns()
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM campaign where userid= ".Yii::app()->user->user_id." and status='pending'";
		$result=$connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function CountUserCampaign()
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM campaign where userid=".Yii::app()->user->user_id;
		
		$result = $connection->createCommand($sql)->queryAll();
		
		return count($result);
	}
	
	public function DeleteCampaign($id)
	{
		$connection=Yii::app()->db;
		
		$sql = 'delete from campaign WHERE campaign_id ='.$id.' and userid='.Yii::app()->user->user_id; 
		$campdel = $connection->createCommand($sql)->execute();
		
		if($campdel)
		{
			//delete from fbpost
			$sql_fb = 'delete from campaign_fbpost WHERE campaign_id ='.$id; 
			$fbdel = $connection->createCommand($sql_fb)->execute();
			
			//delete from fs special	
			$sql_fs = 'delete from fs_special WHERE campaign_id ='.$id; 
			$fsdel = $connection->createCommand($sql_fs)->execute();
		}
		
		return true;
	}
	
	public function GetPosts($campaign_id)
	{
		$connection=Yii::app()->db;
		
		$sql='select * from campaign_fbpost where campaign_id="'.$campaign_id.'" and posted_id!=""';
		$result=$connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetArchivedCampaigns()
	{
		$connection=Yii::app()->db;
		
		$sql = "SELECT * FROM campaign where userid= ".Yii::app()->user->user_id." and status='active'";
		$result = $connection->createCommand($sql)->queryAll();

		$camp_ids = '';
		
		if(count($result))
		{
			foreach($result as $key=>$value)	
			{
				if(!empty($value['timezone']))
				{
					$sql2 = "select * from zone where zone_id='".$value['timezone']."'";
					$result2 = $connection->createCommand($sql2)->queryAll();
		
					if(count($result2))
						date_default_timezone_set($result2[0]['name']);
				}
				
				$today_date = date('m/d/Y');
				$time_now = date('h:i');
				
				if(!empty($value['start_time']))
				{
					$temp_holder = explode(':',$value['start_time']);
					$new_start_date = mktime($temp_holder[0],$temp_holder[1],0,date('m',$value['start_date']),date('d',$value['start_date']-24*60*60),date('Y',$value['start_date']));
				}
				else
					$new_start_date = $value['start_date'];
					
				if(!empty($value['end_time']))
				{
					$temp_holder = explode(':',$value['end_time']);
					$new_end_date = mktime($temp_holder[0],$temp_holder[1],0,date('m',$value['end_date']),date('d',$value['end_date']-24*60*60),date('Y',$value['end_date']));
				}
				else
					$new_end_date = $value['end_date'];		
					
				if($new_start_date < strtotime($today_date) && $new_end_date<strtotime($today_date))
					$camp_ids .= $value['campaign_id'].',';
			}

		}

		if(!empty($camp_ids))		
			$sql = "SELECT * FROM campaign where userid= ".Yii::app()->user->user_id." and status='active' and campaign_id IN(".substr($camp_ids,0,-1).")";
		else
			$sql="SELECT * FROM campaign where userid= ".Yii::app()->user->user_id." and status='active' and start_date<'".strtotime($today_date)."' and end_date<'".strtotime($today_date)."' ";	
		

		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetPendingFBCamp($camp_id)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM campaign_fbpost where campaign_id= ".$camp_id;
		$result=$connection->createCommand($sql)->queryAll();
		return $result;
	}
	
	public function GetPageInfo($page_id)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM fbpages where id= ".$page_id;
		$result=$connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetGroupPages($group_id)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM location where group_ids=".$group_id;
		$result=$connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetPendingFSCamp($camp_id)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM fs_special where campaign_id= ".$camp_id;
		$result=$connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	
	public function SaveCamp($lastid,$userid,$campaign_name,$groups,$pages,$start_date,$start_time,$end_date,$end_time,$timezone,$kpi,$facebook_deals,$fs_specials,$google_places,$fb_posts,$twitter,$FB_ads,$google_adwords,$dated,$status)
	{
		$connection=Yii::app()->db;
		
		$sql = 'UPDATE campaign SET name="'.$campaign_name.'",group_ids="'.$groups.'",page_id="'.$pages.'",start_date="'.$start_date.'",start_time="'.$start_time.'",end_date="'.$end_date.'",end_time="'.$end_time.'",timezone="'.$timezone.'",kpi="'.$kpi.'",facebook_deals="'.$facebook_deals.'",foursquare_specials="'.$fs_specials.'",google_place="'.$google_places.'",fb_posts="'.$fb_posts.'",twitter="'.$twitter.'",fb_ads="'.$FB_ads.'",google_adwords="'.$google_adwords.'",dated="'.$dated.'",status="'.$status.'"
                    where campaign_id="'.$lastid.'" and userid="'.$userid.'"';
			
		$result=$connection->createCommand($sql);
		$final_result=$result->execute();
		
		return $final_result;
	}
	
	public function InsertCamp($userid,$campaign_name,$groups,$pages,$start_date,$start_time,$end_date,$end_time,$timezone,$kpi,$facebook_deals,$fs_specials,$google_places,$fb_posts,$twitter,$FB_ads,$google_adwords,$dated,$status)
	{
		$connection = Yii::app()->db;
		
		$sql = 'INSERT INTO campaign SET name="'.$campaign_name.'",group_ids="'.$groups.'",page_id="'.$pages.'",start_date="'.$start_date.'",start_time="'.$start_time.'",end_date="'.$end_date.'",end_time="'.$end_time.'",timezone="'.$timezone.'",kpi="'.$kpi.'",facebook_deals="'.$facebook_deals.'",foursquare_specials="'.$fs_specials.'",google_place="'.$google_places.'",fb_posts="'.$fb_posts.'",twitter="'.$twitter.'",fb_ads="'.$FB_ads.'",google_adwords="'.$google_adwords.'",dated="'.$dated.'",status="'.$status.'", userid="'.$userid.'"';
			
		$result = $connection->createCommand($sql);
		$final_result = $result->execute();
		
		return Yii::app()->db->getLastInsertID();;
	}
	
	function SpecZone($zoneid)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM zone where zone_id= ".$zoneid;
		$result=$connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function SaveFSCamp($venue_type,$location_type,$sp_type,$count1,$count2,$count3,$unlockedText,$offer,$finePrint,$cost,$lastid)
	{
		$connection=Yii::app()->db;
		
		//$sql = 'UPDATE fs_special SET location_type="'.$venue_type.'",location="'.$location_type.'",sp_type="'.$sp_type.'",count1="'.$count1.'",count2="'.$count2.'",count3="'.$count3.'",unlockedText="'.$unlockedText.'",offer="'.$offer.'",finePrint="'.$finePrint.'",cost="'.$cost.'",status="pending",dated="'.strtotime(now).'" where campaign_id="'.$lastid.'"';
		
		$sql = 'INSERT INTO fs_special SET location_type = "'.$venue_type.'",location = "'.$location_type.'",sp_type = "'.$sp_type.'",count1 = "'.$count1.'",count2 = "'.$count2.'",count3 = "'.$count3.'",unlockedText = "'.$unlockedText.'",offer = "'.$offer.'",finePrint = "'.$finePrint.'",cost = "'.$cost.'",status = "pending",dated = "'.strtotime(now).'", campaign_id = "'.$lastid.'"';
	
			
		$result=$connection->createCommand($sql);
		$final_result=$result->execute();
		
		return $final_result;
	}
	
	public function SaveFBCamp($post_title,$sel_wall,$selected_wall,$url,$msg,$link_title,$link_description,$email_notify,$content_type,$name_photo,$name_video,$lastid)
	{
		$connection=Yii::app()->db;
		
		//$sql = 'UPDATE campaign_fbpost SET post_title="'.$post_title.'", selected_wall_option="'.$sel_wall.'", selected_wall="'.$selected_wall.'", content_type="'.$content_type.'",photo="'.$name_photo.'",video="'.$name_video.'",url_link="'.$url.'",message="'.$msg.'",title="'.$link_title.'",description="'.$link_description.'",email_notify="'.$email_notify.'" where campaign_id="'.$lastid.'"';
		$sql = 'INSERT INTO campaign_fbpost SET post_title="'.$post_title.'", selected_wall_option="'.$sel_wall.'", selected_wall="'.$selected_wall.'", content_type="'.$content_type.'",photo="'.$name_photo.'",video="'.$name_video.'",url_link="'.$url.'",message="'.$msg.'",title="'.$link_title.'",description="'.$link_description.'",email_notify="'.$email_notify.'", campaign_id="'.$lastid.'"';
	
			
		$result=$connection->createCommand($sql);
		$final_result=$result->execute();
		
		return $final_result;
	}
        
        public function UpdateFBCamp($post_title,$sel_wall,$selected_wall,$url,$msg,$link_title,$link_description,$email_notify,$content_type,$name_photo,$name_video,$lastid)
        {
            $connection=Yii::app()->db;
		
		$sql = 'UPDATE campaign_fbpost SET post_title="'.$post_title.'", selected_wall_option="'.$sel_wall.'", selected_wall="'.$selected_wall.'", content_type="'.$content_type.'",photo="'.$name_photo.'",video="'.$name_video.'",url_link="'.$url.'",message="'.$msg.'",title="'.$link_title.'",description="'.$link_description.'",email_notify="'.$email_notify.'" where campaign_id="'.$lastid.'"';
		//$sql = 'UPDATE campaign_fbpost SET post_title="'.$post_title.'", selected_wall_option="'.$sel_wall.'", selected_wall="'.$selected_wall.'", content_type="'.$content_type.'",photo="'.$name_photo.'",video="'.$name_video.'",url_link="'.$url.'",message="'.$msg.'",title="'.$link_title.'",description="'.$link_description.'",email_notify="'.$email_notify.'" WHERE campaign_id="'.$lastid.'"';
	
			
		$result=$connection->createCommand($sql);
		$final_result=$result->execute();
		
		return $final_result;
        }
        
        public function UpdateFSCamp($venue_type,$location_type,$sp_type,$count1,$count2,$count3,$unlockedText,$offer,$finePrint,$cost,$lastid)
	{
		$connection=Yii::app()->db;
		
		$sql = 'UPDATE fs_special SET location_type="'.$venue_type.'",location="'.$location_type.'",sp_type="'.$sp_type.'",count1="'.$count1.'",count2="'.$count2.'",count3="'.$count3.'",unlockedText="'.$unlockedText.'",offer="'.$offer.'",finePrint="'.$finePrint.'",cost="'.$cost.'",status="pending",dated="'.strtotime(now).'" where campaign_id="'.$lastid.'"';
		
		//$sql = 'INSERT INTO fs_special SET location_type = "'.$venue_type.'",location = "'.$location_type.'",sp_type = "'.$sp_type.'",count1 = "'.$count1.'",count2 = "'.$count2.'",count3 = "'.$count3.'",unlockedText = "'.$unlockedText.'",offer = "'.$offer.'",finePrint = "'.$finePrint.'",cost = "'.$cost.'",status = "pending",dated = "'.strtotime(now).'", campaign_id = "'.$lastid.'"';
	
			
		$result=$connection->createCommand($sql);
		$final_result=$result->execute();
		
		return $final_result;
	}
}