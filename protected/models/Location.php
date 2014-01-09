<?php

/**
 * This is the model class for table "location".
 *
 * The followings are the available columns in table 'location':
 * @property integer $loc_id
 * @property integer $user_id
 * @property string $fburl
 * @property string $fsurl
 * @property string $googleurl
 * @property string $dated
 */

class Location extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Location the static model class
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
		return 'location';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			
			//array('user_id', 'numerical', 'integerOnly'=>true),
			//array('fburl, fsurl, googleurl', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('loc_id, user_id, fburl, fsurl, googleurl', 'safe', 'on'=>'search'),
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
			'loc_id' => 'Loc',
			'user_id' => 'User',
			'fburl' => 'Facebook Url',
			'fsurl' => 'Foursquare Url',
			'googleurl' => 'Google Url',
			'dated'		=> 'Location add date',
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

		$criteria->compare('loc_id',$this->loc_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('fburl',$this->fburl,true);
		$criteria->compare('fsurl',$this->fsurl,true);
		$criteria->compare('googleurl',$this->googleurl,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getallurl( $date_durt = 0 )
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM location where user_id = ".Yii::app()->user->user_id;
		
		if( $date_durt > 0 )
			$sql.= " and dated>".$date_durt;
		
		$url = $connection->createCommand($sql)->queryAll();
		
		return $url;
	}
	
	public function GetSpecificUrl($id)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM location where user_id= ".Yii::app()->user->user_id." and loc_id=".$id ;
		$url=$connection->createCommand($sql)->queryAll();
		return $url;
	}
	
	public function fbdatalcname($id,$date_duration=0)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT lname FROM fbdata where loc_id= ".$id ;
		
		if($date_duration>0)
			$sql .=" and curdate >= ".$date_duration;
		
		$url=$connection->createCommand($sql)->queryAll();
		return $url;
	}
	
	public function getallurllikescheckins($id,$date_duration=0)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM dailylikes where id=(select max(id) from dailylikes where loc_id='".$id."') ";
		
		if($date_duration>0)
			$sql .=" and curdate > ".$date_duration;
		
		$url=$connection->createCommand($sql)->queryAll();
		return $url;
	}
	
	public function CountUserLocation()
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM location where user_id=".Yii::app()->user->user_id;
		
		$result = $connection->createCommand($sql)->queryAll();
		
		return count($result);
	}
	
	public function GetFbLikes( $loc_id,$date_duration = 0 )
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM fburlinfo FUI, fburl_data FBD where FUI.fburl_id=FBD.fburl_id and FUI.loc_id='".$loc_id."' ";
		
		if( $date_duration>0 )
			$sql .= " and FBD.dated > ".$date_duration;
		
		$sql .= " order by FBD.dated desc limit 0,1";

		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetFSData( $loc_id,$date_duration = 0 )
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM fsurlinfo FUI, fsurl_data FSD where FUI.fsurl_id=FSD.fsurl_id and FUI.loc_id='".$loc_id."' ";
		
		if( $date_duration > 0 )
			$sql .=" and FSD.dated > ".$date_duration;
		
		$sql .=" order by FSD.dated desc limit 0,1";
		
		$result=$connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetGoogData($loc_id,$date_duration=0)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM gurlinfo GUI, gurl_data GD where GUI.gurl_id=GD.gurl_id and GUI.loc_id='".$loc_id."' ";
		
		if($date_duration>0)
			$sql .=" and GD.dated > ".$date_duration;
		
		$sql .=" order by GD.dated desc limit 0,1";
		
		$result=$connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function getallurlcheckins($id,$date_duration=0)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM dailycheckins where check_id=(select max(check_id) from dailycheckins where loc_id='".$id."') ";
		
		if($date_duration>0)
			$sql .=" and curdate > ".$date_duration;
			
		$url=$connection->createCommand($sql)->queryAll();
		return $url;
	}
	
	public function DelData($loc_id,$table1,$table2,$fgkey)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM ".$table1." where loc_id= ".$loc_id;
		$result=$connection->createCommand($sql)->queryAll();
		
		if(!empty($result[0][$fgkey]))
		{
			$sql='DELETE from '.$table2.' where '.$fgkey.'='.$result[0][$fgkey];
			$del1=$connection->createCommand($sql)->execute();
			
			if($del1)
			{
				$sql2='DELETE from '.$table1.' where '.$fgkey.'='.$result[0][$fgkey];
				$del2=$connection->createCommand($sql2)->execute();
			}
		}
				
		return 1;
	}
	
	public function DelDemo($loc_id)
	{
		$connection=Yii::app()->db;
		
		$sql='DELETE from demographic_ages where loc_id='.$loc_id;
		$del_2=$connection->createCommand($sql)->execute();
		
		return 1;
	}
	
	public function insertfbdata($locid)
	{
	    $connection=Yii::app()->db;
		
		if($_POST['Location']['fburl']!='')
		{
			$strfburl=$_POST['Location']['fburl'];
			$sfb=explode("/",$strfburl);
			$id=$sfb[count($sfb)-1];
			$contents = json_decode(@file_get_contents('https://graph.facebook.com/'.$id));
			
			$id			=	$contents->id;
			$locname	=	$contents->name;
			$picture	=	$contents->picture;
			$link		=	$contents->link;
			$category	=	$contents->category;
			$website	=	$contents->website;
			$username	=	$contents->username;
			$city		=	$contents->location->city;
			$state		=	$contents->location->state;
			$country	=	$contents->location->country;
			$latitude	=	$contents->location->latitude;
			$lognitude	=	$contents->location->longitude;
			
			
			$likes			=	$contents->likes;
			$checkins		=	$contents->checkins;
			$talking_about	=	$contents->talking_about_count;
			
			$sql='INSERT INTO fburlinfo(loc_id,id,name,picture,link,category,website,username,city,state,country,latitude,lognitude) VALUES("'.$locid.'","'.$id.'","'.$locname.'","'.$picture.'","'.$link.'","'.$category.'","'.$website.'","'.$username.'","'.$city.'","'.$state.'","'.$country.'","'.$latitude.'","'.$lognitude.'")';
			
			$result=$connection->createCommand($sql);
			$final_result=$result->execute();
			
			$fburl_id=$this->GetMaxVal('fburlinfo','fburl_id');
			
			if($final_result)
			{
				$sql_data='INSERT INTO fburl_data(fburl_id,likes,checkins,talking_about_count,dated) VALUES("'.$fburl_id[0]['id'].'","'.$likes.'","'.$checkins.'","'.$talking_about.'","'.strtotime(now).'")';
				
				$result_data=$connection->createCommand($sql_data);
				$final_result=$result_data->execute();
			}
			
			$this->GetDemoDetails($id,$locid);
		}
									
		if($_POST['Location']['fsurl']!='')
		{
			$strfsurl=$_POST['Location']['fsurl'];
			$sfs=explode("/",$strfsurl);
			
			$id=$sfs[count($sfs)-1];
			
			$contentsfs = json_decode(@file_get_contents('https://api.foursquare.com/v2/venues/'.$id.'?oauth_token=WB1EEUGJ1QJXP0MNPUPGX5GRWJK0BYISN5YZONI0TOVZ31ID&v='.date('Ymd')));
			$id				=	$contentsfs->response->venue->id;
			$name			=	$contentsfs->response->venue->name;
			$phone			=	$contentsfs->response->venue->contact->phone;
			$formattedphone	=	$contentsfs->response->venue->contact->formattedPhone;
			$twitter		=	$contentsfs->response->venue->contact->twitter;
			$address		=	$contentsfs->response->venue->location->address;
			$city			=	$contentsfs->response->venue->location->city;
			$zip			=	$contentsfs->response->venue->location->postalCode;
			$state			=	$contentsfs->response->venue->location->state;
			$country		=	$contentsfs->response->venue->location->country;
			$latitude		=	$contentsfs->response->venue->location->lat;
			$lognitude		=	$contentsfs->response->venue->location->lng;
			
			$checkinsCount	=	$contentsfs->response->venue->stats->checkinsCount;
			$usersCount		=	$contentsfs->response->venue->stats->usersCount;
			$tipCount		=	$contentsfs->response->venue->stats->tipCount;
			
			$sql='INSERT INTO fsurlinfo(loc_id,id,name,phone,formattedphone,twitter,address,city,zip,state,country,latitude,lognitude) VALUES("'.$locid.'","'.$id.'","'.$name.'","'.$phone.'","'.$formattedphone.'","'.$twitter.'","'.$address.'","'.$city.'","'.$zip.'","'.$state.'","'.$country.'","'.$latitude.'","'.$lognitude.'")';
			
			$result=$connection->createCommand($sql);
			$final_result=$result->execute();
			
			$fsurl_id=$this->GetMaxVal('fsurlinfo','fsurl_id');
			
			if($final_result)
			{
				$sql_data='INSERT INTO fsurl_data(fsurl_id,checkinsCount,usersCount,tipCount,dated) VALUES("'.$fsurl_id[0]['id'].'","'.$checkinsCount.'","'.$usersCount.'","'.$tipCount.'","'.strtotime(now).'")';
				
				$result_data=$connection->createCommand($sql_data);
				$final_result=$result_data->execute();
			}
		}
		
		if($_POST['Location']['googleurl']!='')
		{
			$html 		= 	file_get_html($_POST['Location']['googleurl']);
			$longlat	=	strpos($html,"sll=");
			$sublonglat	=	substr($html,$longlat+4,23);
			
			if(strstr($sublonglat,'&'))
			{
				$amppos = strpos($sublonglat,'&');
				$sublonglat	=	substr($html,$longlat+4,$amppos);
			}
			
			$quotspace	=	strpos($sublonglat," ");
			if($quotspace)
				$ll			=	substr($sublonglat,0,$quotspace-1);
			else
				$ll			=	$sublonglat;
			
			$expll		=	explode(",",$ll);
			$lati		=	$expll[0];
			$longi		=	$expll[1];
			
			preg_match("/<title>([^>]*)<\/title>/si",$html,$match);
			
			$l 			=	 strip_tags($match[1]);
			
			$locname=$this->return_unicode($l);

			$strgoogle = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/place/search/json?location='.$lati.','.$longi.'&radius=500&name='.urlencode($locname).'&sensor=false&key=AIzaSyCjZdj2qvK8-_Dc5VKvzQtAN_7rIsJWZVM'));
			
			if($strgoogle->results[0]->reference)
			{
				$strgoogledata = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/place/details/json?reference='.$strgoogle->results[0]->reference.'&sensor=true&key=AIzaSyCjZdj2qvK8-_Dc5VKvzQtAN_7rIsJWZVM'));
				
				$glikes		=	$this->get_plusones($strgoogledata->result->website);
				$address	=	$strgoogledata->result->formatted_address;	
			}
			
			$sql='INSERT INTO gurlinfo(loc_id,name,address,latitude,lognitude) VALUES("'.$locid.'","'.$locname.'","'.$address.'","'.$lati.'","'.$longi.'")';
		
			$result=$connection->createCommand($sql);
			$final_result=$result->execute();
			
			$gurl_id=$this->GetMaxVal('gurlinfo','gurl_id');
			
			if($final_result)
			{
				$sql_data='INSERT INTO gurl_data(gurl_id,glikes,dated) VALUES("'.$gurl_id[0]['id'].'","'.$glikes.'","'.strtotime(now).'")';
				
				$result_data=$connection->createCommand($sql_data);
				$final_result=$result_data->execute();
			}
    	}	
	}
	
	public function updatesocialrecord($locid)
	{
	    $connection=Yii::app()->db;
		
		if($_POST['Location']['fburl']!='')
		{
			$strfburl	=	$_POST['Location']['fburl'];
			$sfb	=	explode("/",$strfburl);
			$id	=	$sfb[count($sfb)-1];
			$contents = json_decode(@file_get_contents('https://graph.facebook.com/'.$id));
			
			$id			=	$contents->id;
			$locname	=	$contents->name;
			$picture	=	$contents->picture;
			$link		=	$contents->link;
			$category	=	$contents->category;
			$website	=	$contents->website;
			$username	=	$contents->username;
			$city		=	$contents->location->city;
			$state		=	$contents->location->state;
			$country	=	$contents->location->country;
			$latitude	=	$contents->location->latitude;
			$lognitude	=	$contents->location->longitude;
			
			
			$likes			=	$contents->likes;
			$checkins		=	$contents->checkins;
			$talking_about	=	$contents->talking_about_count;
			
			$ExistRec	=	$this->PickExistRecord('fburlinfo','loc_id','id',$locid,$id);
			
			if(count($ExistRec)==0)
			{
				$sql='INSERT INTO fburlinfo(loc_id,id,name,picture,link,category,website,username,city,state,country,latitude,lognitude) VALUES("'.$locid.'","'.$id.'","'.$locname.'","'.$picture.'","'.$link.'","'.$category.'","'.$website.'","'.$username.'","'.$city.'","'.$state.'","'.$country.'","'.$latitude.'","'.$lognitude.'")';
				
			}
			else
			{
				$sql = 'UPDATE fburlinfo SET id="'.$id.'",name="'.$locname.'",picture="'.$picture.'",link="'.$link.'",category="'.$category.'",website="'.$website.'",username="'.$username.'",city="'.$city.'",state="'.$state.'",country="'.$country.'",latitude="'.$latitude.'",lognitude="'.$lognitude.'" where fburl_id="'.$ExistRec[0]['fburl_id'].'"';
				
			}
			
			$result=$connection->createCommand($sql);
			$final_result=$result->execute();
			
			$fburl_id=$this->GetMaxVal('fburlinfo','fburl_id');
			
			if($final_result)
			{
				$ExistRecs	=	$this->PickExistRecord('fburl_data','fburl_id','',$ExistRec[0]['fburl_id'],'');
				
				if(count($ExistRecs)==0)
				{
					$sql_data='INSERT INTO fburl_data(fburl_id,likes,checkins,talking_about_count,dated) VALUES("'.$fburl_id[0]['id'].'","'.$likes.'","'.$checkins.'","'.$talking_about.'","'.strtotime(now).'")';
					
					$result_data=$connection->createCommand($sql_data);
					$final_result=$result_data->execute();
				}
			}
		}
									
		if($_POST['Location']['fsurl']!='')
		{
			$strfsurl=$_POST['Location']['fsurl'];
			$sfs=explode("/",$strfsurl);
			
			$id=$sfs[count($sfs)-1];
			
			$contentsfs = json_decode(@file_get_contents('https://api.foursquare.com/v2/venues/'.$id.'?oauth_token=WB1EEUGJ1QJXP0MNPUPGX5GRWJK0BYISN5YZONI0TOVZ31ID&v='.date('Ymd')));
			$id				=	$contentsfs->response->venue->id;
			$name			=	$contentsfs->response->venue->name;
			$phone			=	$contentsfs->response->venue->contact->phone;
			$formattedphone	=	$contentsfs->response->venue->contact->formattedPhone;
			$twitter		=	$contentsfs->response->venue->contact->twitter;
			$address		=	$contentsfs->response->venue->location->address;
			$city			=	$contentsfs->response->venue->location->city;
			$zip			=	$contentsfs->response->venue->location->postalCode;
			$state			=	$contentsfs->response->venue->location->state;
			$country		=	$contentsfs->response->venue->location->country;
			$latitude		=	$contentsfs->response->venue->location->lat;
			$lognitude		=	$contentsfs->response->venue->location->lng;
			
			$checkinsCount	=	$contentsfs->response->venue->stats->checkinsCount;
			$usersCount		=	$contentsfs->response->venue->stats->usersCount;
			$tipCount		=	$contentsfs->response->venue->stats->tipCount;
			
			$ExistRec	=	$this->PickExistRecord('fsurlinfo','loc_id','id',$locid,$id);
			
			if(count($ExistRec)==0)
			{
				$sql='INSERT INTO fsurlinfo(loc_id,id,name,phone,formattedphone,twitter,address,city,zip,state,country,latitude,lognitude) VALUES("'.$locid.'","'.$id.'","'.$name.'","'.$phone.'","'.$formattedphone.'","'.$twitter.'","'.$address.'","'.$city.'","'.$zip.'","'.$state.'","'.$country.'","'.$latitude.'","'.$lognitude.'")';
			}
			else
			{	
				$sql='UPDATE fsurlinfo SET id="'.$id.'",name="'.$name.'",phone="'.$phone.'",formattedphone="'.$formattedphone.'",twitter="'.$twitter.'",address="'.$address.'",city="'.$city.'",zip="'.$zip.'",state="'.$state.'",country="'.$country.'",latitude="'.$latitude.'",lognitude="'.$lognitude.'" where fsurl_id="'.$ExistRec[0]['fsurl_id'].'"';
			}
			
			$result=$connection->createCommand($sql);
			$final_result=$result->execute();
			
			$fsurl_id=$this->GetMaxVal('fsurlinfo','fsurl_id');
			
			if($final_result)
			{
				$ExistRecs	=	$this->PickExistRecord('fsurl_data','fsurl_id','',$ExistRec[0]['fsurl_id'],'');
				
				if(count($ExistRecs)==0)
				{
				
					$sql_data='INSERT INTO fsurl_data(fsurl_id,checkinsCount,usersCount,tipCount,dated) VALUES("'.$fsurl_id[0]['id'].'","'.$checkinsCount.'","'.$usersCount.'","'.$tipCount.'","'.strtotime(now).'")';
					
					$result_data=$connection->createCommand($sql_data);
					$final_result=$result_data->execute();
				}
			}
		}
		
		if($_POST['Location']['googleurl']!='')
		{
			$html 		= 	file_get_html($_POST['Location']['googleurl']);
			$longlat	=	strpos($html,"sll=");
			$sublonglat	=	substr($html,$longlat+4,23);
			
			if(strstr($sublonglat,'&'))
			{
				$amppos = strpos($sublonglat,'&');
				$sublonglat	=	substr($html,$longlat+4,$amppos);
			}
			
			$quotspace	=	strpos($sublonglat," ");

			if($quotspace)
				$ll			=	substr($sublonglat,0,$quotspace-1);
			else
				$ll			=	$sublonglat;
			
			$expll		=	explode(",",$ll);
			$lati		=	$expll[0];
			$longi		=	$expll[1];
			
			preg_match("/<title>([^>]*)<\/title>/si",$html,$match);
			
			$l 			=	 strip_tags($match[1]);
			
			$locname=$this->return_unicode($l);
			
			$strgoogle=json_decode(@file_get_contents('https://maps.googleapis.com/maps/api/place/search/json?location='.$lati.','.$longi.'&radius=500&name='.$locname.'&sensor=false&key=AIzaSyCjZdj2qvK8-_Dc5VKvzQtAN_7rIsJWZVM'));
			
			if($strgoogle->results[0]->reference)
			{
				$strgoogledata=json_decode(@file_get_contents('https://maps.googleapis.com/maps/api/place/details/json?reference='.$strgoogle->results[0]->reference.'&sensor=true&key=AIzaSyCjZdj2qvK8-_Dc5VKvzQtAN_7rIsJWZVM'));
			
				$glikes		=	$this->get_plusones($strgoogledata->result->website);
				$address	=	$strgoogledata->result->formatted_address;	
			}
			
			$ExistRec	=	$this->PickExistRecord('gurlinfo','loc_id','',$locid,'');
			
			if(count($ExistRec)==0)
			{
				$sql='INSERT INTO gurlinfo(loc_id,name,address,latitude,lognitude) VALUES("'.$locid.'","'.$locname.'","'.$address.'","'.$lati.'","'.$longi.'")';
			}
			else
			{
				$sql='UPDATE gurlinfo SET name="'.$locname.'",address="'.$address.'",latitude="'.$lati.'",lognitude="'.$longi.'" where gurl_id="'.$ExistRec[0]['gurl_id'].'"';
			}
		
			$result=$connection->createCommand($sql);
			$final_result=$result->execute();
			
			$gurl_id=$this->GetMaxVal('gurlinfo','gurl_id');
			
			if($final_result)
			{
				$ExistRecs	=	$this->PickExistRecord('gurl_data','gurl_id','',$ExistRec[0]['gurl_id'],'');
				
				if(count($ExistRecs)==0)
				{
					$sql_data='INSERT INTO gurl_data(gurl_id,glikes,dated) VALUES("'.$gurl_id[0]['id'].'","'.$glikes.'","'.strtotime(now).'")';
					
					$result_data=$connection->createCommand($sql_data);
					$final_result=$result_data->execute();
				}
			}
    	}	
	
	}
	
	public function PickExistRecord($table,$field1,$field2=0,$value1,$value2=0)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM ".$table." where 1 ";
		
		if($value1!='')
			$sql .= " and ".$field1."=".$value1;
		
		if($field2!=0)
			$sql .=" and ".$field2."=".$value2;
		
		$loc=$connection->createCommand($sql)->queryAll();
		
		return $loc;
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
	
	public function getlocation()
	{
		
		$connection=Yii::app()->db;
		
		$sql="SELECT loc_id,fb_id,lati,longi,lname FROM fbdata where user_id= ".Yii::app()->user->user_id;
		
		$loc=$connection->createCommand($sql)->queryAll();
		
		return $loc;
	}
	
	public function StoreDemographic($loc_id,$data1,$date1,$data2,$date2,$data3,$date3)
	{
		$connection=Yii::app()->db;
		
		if($date1!=0)
		{
			$temp_date1=explode('T0',$date1);
			$date_1_temp=explode('-',$temp_date1[0]);
			$date_1=mktime(0,0,0,$date_1_temp[1],$date_1_temp[2],$date_1_temp[0]);
			
			$sql="SELECT * FROM demographic_ages where loc_id= ".$loc_id." and dated='".$date_1."'";
			$loc_1=$connection->createCommand($sql)->queryAll();
			
			if(count($loc_1)==0 && $data1)
			{			
				$sql_1="insert into demographic_ages set `loc_id`=".$loc_id.", ";
				
				foreach($data1 as $key=>$value)
				{
					$sql_1 .= '`'.$key.'`='.$value.',';
				}
				
				$sql_1 .= '`dated`="'.$date_1.'"';
				
				$result_1=$connection->createCommand($sql_1);
				
				$final_result_1=$result_1->execute();
			}
		}
		
		if($date2!=0)
		{
			$temp_date2=explode('T0',$date2);
			$date_2_temp=explode('-',$temp_date2[0]);
			$date_2=mktime(0,0,0,$date_2_temp[1],$date_2_temp[2],$date_2_temp[0]);
			
			$sql2="SELECT * FROM demographic_ages where loc_id= ".$loc_id." and dated='".$date_2."'";
			$loc_2=$connection->createCommand($sql2)->queryAll();
			
			if(count($loc_2)==0 && $data2)
			{
				$sql_2="insert into demographic_ages set `loc_id`=".$loc_id.", ";
				
				foreach($data2 as $key2=>$value2)
				{
					$sql_2 .= '`'.$key2.'`='.$value2.',';
				}
				
				$sql_2 .= '`dated`="'.$date_2.'"';
				
				$result_2=$connection->createCommand($sql_2);
				
				$final_result_2=$result_2->execute();
			}
		}		
		
		if($date3!=0)
		{
			$temp_date3=explode('T0',$date3);
			$date_3_temp=explode('-',$temp_date3[0]);
			$date_3=mktime(0,0,0,$date_3_temp[1],$date_3_temp[2],$date_3_temp[0]);
			
			
			$sql3="SELECT * FROM demographic_ages where loc_id= ".$loc_id." and dated='".$date_3."'";
			$loc_3=$connection->createCommand($sql3)->queryAll();
			
			if(count($loc_3)==0 && $data3)
			{
				$sql_3="insert into demographic_ages set `loc_id`=".$loc_id.", ";
				
				foreach($data3 as $key3=>$value3)
				{
					$sql_3 .= '`'.$key3.'`='.$value3.',';
				}
				
				$sql_3 .= '`dated`="'.$date_3.'"';
				
				$result_3=$connection->createCommand($sql_3);
				
				$final_result_3=$result_3->execute();
			}
		}
	}
	
	public function LocationInfo($loc_id)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM location where loc_id= ".$loc_id;
		
		$loc=$connection->createCommand($sql)->queryAll();
		
		return $loc;
	}
	
	public function getavgtotal()
	{	
		$connection=Yii::app()->db;
		
		$sql="SELECT tlikes,tcheckins FROM fbdata where curdate=(select max(curdate) from fbdata where loc_id='".$_REQUEST['id']."') ";

		$loc=$connection->createCommand($sql)->queryAll();
		
		return $loc;
	}
	
	public function GetDemoGraphic($loc_id,$cur_date)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * from demographic_ages where loc_id=".$loc_id." and dated>=".$cur_date;

		$loc=$connection->createCommand($sql)->queryAll();
		
		return $loc;
	}
	
	public function GetDemoIndi($loc_id,$cur_date,$letter)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * from demographic_ages where loc_id=".$loc_id." and dated>=".$cur_date;

		$loc=$connection->createCommand($sql)->queryAll();
		
		$total=0;
		
		foreach($loc as $key=>$value)
		{		
			$total = $total + $value[$letter];
		}
			
		return $total;
	}
	
	public function GetLastValue($curdate)
	{	
		$connection=Yii::app()->db;
		
		$sql="SELECT tlikes,tcheckins FROM fbdata where loc_id='".$_REQUEST['id']."' and curdate<=".$curdate;

		$loc=$connection->createCommand($sql)->queryAll();
		
		return $loc;
	}
	
	public function GetURLid($table,$loc_id)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM ".$table." where loc_id='".$loc_id."'";

		$fbloc=$connection->createCommand($sql)->queryAll();
		
		return $fbloc;
	}
	
	
	public function GetFSCampaigns($groupid)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM campaign C,fs_special FS where C.userid= ".Yii::app()->user->user_id." and C.status='active' and C.foursquare_specials='yes'";
		
		if(strstr($groupid,','))
			$vals = substr(trim($groupid),0,-1);
		if(strpos($groupid,',')==1)
			$vals = substr(trim($groupid),0,1);
		else
			$vals = $groupid;
		
		if(!empty($vals))
		{
			$vals = rtrim($vals, ',');
			$sql .=" and C.group_ids IN (".$vals.") ";
		}
		
		$sql .=" and FS.campaign_id = C.campaign_id and FS.special!=''";
		
		
		$result=$connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function Record($table,$field,$primekey,$dated)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM ".$table." where ".$field."='".$primekey."' and dated>=".$dated." order by dated asc";

		$result=$connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function PrevRecord($table,$field,$primekey,$dated,$prevdate)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM ".$table." where ".$field."='".$primekey."' and dated<=".$dated." and dated>=".$prevdate."  order by dated asc";

		$result=$connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetFBdata($curdate)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM fburl_data where fburl_id='".$fbutl_id."' and dated<=".$curdate;

		$fbloc=$connection->createCommand($sql)->queryAll();
		
		return $fbloc;
	}
	
	public function getlatestfblikes()
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM dailylikes where id=(select max(id) from dailylikes where loc_id='".$_REQUEST['id']."') ";
		$loc=$connection->createCommand($sql)->queryAll();
		
		return $loc;
	}
	
	public function GetDatedFBLikes($curdate)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM dailylikes where id=(select max(id) from dailylikes where loc_id='".$_REQUEST['id']."') and curdate<=".$curdate;
		$loc=$connection->createCommand($sql)->queryAll();
		
		return $loc;
	}
	
	public function getlatestfbcheckins()
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM dailycheckins where check_id=(select max(check_id) from dailycheckins where loc_id='".$_REQUEST['id']."') ";
		$loc=$connection->createCommand($sql)->queryAll();
		
		return $loc;
	}
	
	public function FBCurCheckins($curdate)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM dailycheckins where check_id=(select max(check_id) from dailycheckins where loc_id='".$_REQUEST['id']."')  and curdate<=".$curdate;
		$loc=$connection->createCommand($sql)->queryAll();
		
		return $loc;
	}
	
	public function getavglikes()
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT avg(likes) as avgdailylikes,sum(likes) as totl,avg(glikes) as avgdailyglikes,sum(glikes) as totg FROM dailylikes where loc_id='".$_REQUEST['id']."' ";
		$loc=$connection->createCommand($sql)->queryAll();
		
		return $loc;
	}
	
	public function GetLastLikes($curdate)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT avg(likes) as avgdailylikes,sum(likes) as totl,avg(glikes) as avgdailyglikes,sum(glikes) as totg FROM dailylikes where loc_id='".$_REQUEST['id']."' and curdate<=".$curdate;
		
		$loc=$connection->createCommand($sql)->queryAll();
		
		return $loc;
	}
	
	public function getcount()
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT count(*) as totc FROM fbdata WHERE  fbdata.loc_id =".$_REQUEST['id'];
		$loc=$connection->createCommand($sql)->queryAll();
		
		return $loc;
	}
	
	public function getonelocurl()
	{
		$nrows=7;
		
		if($_REQUEST['val']=='7d')
			$nrows=7;
			
		else if($_REQUEST['val']=='14d')
			$nrows=14;
			
		else if($_REQUEST['val']=='1m')
			$nrows=30;
			
		else if($_REQUEST['val']=='3m')
			$nrows=90;
			
		else if($_REQUEST['val']=='6m')
			$nrows=180;
			
		else if($_REQUEST['val']=='1y')
			$nrows=365;
			
		else if($_REQUEST['val']=='3y')
			$nrows=1095;
			
		else if($_REQUEST['val']=='6y')
			$nrows=2190;
			
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM location WHERE loc_id =".$_REQUEST['id'];
		$loc=$connection->createCommand($sql)->queryAll();
		return $loc;
		
	}
	
	public function getlikes()
	{
		$nrows=7;
		
		if($_REQUEST['val']=='7d')
			$nrows=7;
			
		else if($_REQUEST['val']=='14d')
			$nrows=14;
			
		else if($_REQUEST['val']=='1m')
			$nrows=30;
			
		elseif($_REQUEST['val']=='3m')
			$nrows=90;
			
		elseif($_REQUEST['val']=='6m')
			$nrows=180;
			
		else if($_REQUEST['val']=='1y')
			$nrows=365;
			
		elseif($_REQUEST['val']=='3y')
			$nrows=1095;
			
		elseif($_REQUEST['val']=='6y')
			$nrows=2190;
			
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM dailylikes WHERE loc_id =".$_REQUEST['id']." ORDER BY curdate ASC LIMIT ".$nrows;
		$loc=$connection->createCommand($sql)->queryAll();
		return $loc;
	}
	
	public function getfbcheckins()
	{
		$nrows=7;
		
		if($_REQUEST['val']=='7d')
			$nrows=7;
			
		if($_REQUEST['val']=='14d')
			$nrows=14;
			
		if($_REQUEST['val']=='1m')
			$nrows=30;
			
		if($_REQUEST['val']=='3m')
			$nrows=90;
			
		if($_REQUEST['val']=='6m')
			$nrows=180;
			
		if($_REQUEST['val']=='1y')
			$nrows=365;
			
		if($_REQUEST['val']=='3y')
			$nrows=1095;
			
		if($_REQUEST['val']=='6y')
			$nrows=2190;
			
		$connection=Yii::app()->db;
		
		$sql="SELECT *  FROM dailycheckins WHERE loc_id =".$_REQUEST['id']." ORDER BY curdate ASC LIMIT ".$nrows;
		$loc=$connection->createCommand($sql)->queryAll();
		return $loc;
	}
	
	public function checkexist($media)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM ".$this->tableName(). " where ".$media."= '".$_POST['Location'][$media]."' and user_id=".Yii::app()->user->user_id;
		
		$url=$connection->createCommand($sql)->queryAll();
		
		return count($url);
	}
	
	public function checkfbexist1()
	{
		$connection=Yii::app()->db;
		$sql="SELECT * FROM ".$this->tableName(). " where fburl= '".$_POST['Location']['fburl']."' and loc_id=".$_REQUEST['id'];
		
		$url=$connection->createCommand($sql)->queryAll();
		
		return count($url);
	}
	
	public function checkfsexist1()
	{
		$connection=Yii::app()->db;
		$sql="SELECT * FROM ".$this->tableName(). " where fsurl= '".$_POST['Location']['fsurl']."' and loc_id=".$_REQUEST['id'];
		
		$url=$connection->createCommand($sql)->queryAll();
		return count($url);
	}
	
	public function checkgoogleexist1()
	{
		$connection=Yii::app()->db;
		$sql="SELECT * FROM ".$this->tableName(). " where googleurl= '".$_POST['Location']['googleurl']."' and loc_id=".$_REQUEST['id'];
		
		$url=$connection->createCommand($sql)->queryAll();
		return count($url);
	}
	
	public function GetSpecToken()
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM access_token where user_id=".Yii::app()->user->user_id;
		$check_token=$connection->createCommand($sql)->queryAll();
		
		return $check_token;
	}
	
	public function GetTopLocation()
	{
		$connection=Yii::app()->db;
		
		$get_fb_data = 'SELECT FBD.fburl_id, SUM(`likes`) as likes,FBI.loc_id FROM `fburl_data` FBD,fburlinfo FBI where FBI.fburl_id=FBD.fburl_id GROUP BY `fburl_id` ORDER BY SUM(`likes`) DESC';
		$set_fb_data = $connection->createCommand($get_fb_data)->queryAll();
		
		$fb_array = array();
		
		if(count($set_fb_data))
		{
			foreach($set_fb_data as $key=>$value)	
				$fb_array[$value['loc_id']] = $value['likes'];
		}
		
		
		$get_fs_data = 'SELECT FBD.fsurl_id, SUM(`checkinsCount`) as checkins,FBI.loc_id FROM `fsurl_data` FBD,fsurlinfo FBI where FBI.fsurl_id=FBD.fsurl_id GROUP BY `fsurl_id` ORDER BY SUM(`checkinsCount`) DESC';
		$set_fs_info = $connection->createCommand($get_fs_data)->queryAll();
		
		$fs_array = array();

		if(count($set_fs_info))
		{
			foreach($set_fs_info as $key=>$value)	
				$fs_array[$value['loc_id']] = $value['checkins'];
		}
		
		$get_g_data = 'SELECT FBD.gurl_id, SUM(`glikes`) as glikes,FBI.loc_id FROM `gurl_data` FBD,gurlinfo FBI where FBI.gurl_id=FBD.gurl_id GROUP BY `gurl_id` ORDER BY SUM(`glikes`) DESC';
		$set_g_info = $connection->createCommand($get_g_data)->queryAll();
		
		$g_array = array();

		if(count($set_g_info))
		{
			foreach($set_g_info as $key=>$value)	
				$g_array[$value['loc_id']] = $value['glikes'];
		}
		
		$intersect = $fb_array + $fs_array + $g_array;
		
		if(count($intersect))
		{
			foreach($intersect as $key=>$value)
				$final_ids .= $key.',';
		}
		
		$final_ids = substr($final_ids,0,-1);
		
		$get_max_likes = '';
		
		if(!empty($final_ids))
			$sql = 'SELECT * from location where loc_id IN('.$final_ids.') and user_id = '.Yii::app()->user->user_id.' ORDER BY FIND_IN_SET(loc_id, "'.$final_ids.'")';
		else
			$sql = "SELECT * from location where (loc_id IN (SELECT loc_id from fburlinfo where fburl_id IN (SELECT fburl_id FROM  `fburl_data` GROUP BY `fburl_id` ORDER BY SUM(`likes`) DESC)) OR loc_id IN (SELECT loc_id from fsurlinfo where fsurl_id IN (SELECT fsurl_id FROM `fsurl_data` GROUP BY  `fsurl_id` ORDER BY SUM(`checkinsCount`) DESC)) OR loc_id IN (SELECT loc_id from gurlinfo where gurl_id IN (SELECT gurl_id FROM `gurl_data` GROUP BY  `gurl_id` ORDER BY SUM(`glikes`) DESC) )) and user_id = ".Yii::app()->user->user_id."";
		
		$location = $connection->createCommand($sql)->queryAll();

		return $location;
	}
	
	public function GetDemoDetails($page_id,$loc_id)
	{
		$access_token = $this->GetSpecToken();
		
		if($access_token[0]['fbtoken'])
		{
			$post_url = "https://graph.facebook.com/" . $page_id . "/insights/page_impressions_by_age_gender_unique/day?access_token=". $access_token[0]['fbtoken'];
			$response_in = @file_get_contents($post_url);
			
			$insights=json_decode($response_in,true);
	
			$data1=(!empty($insights['data'][0]['values'][0]['value'])) ? $insights['data'][0]['values'][0]['value']:0 ;
			$date1=(!empty($insights['data'][0]['values'][0]['end_time'])) ? $insights['data'][0]['values'][0]['end_time']:0 ;
			$data2=(!empty($insights['data'][0]['values'][1]['value'])) ? $insights['data'][0]['values'][1]['value']:0 ;
			$date2=(!empty($insights['data'][0]['values'][1]['end_time'])) ? $insights['data'][0]['values'][1]['end_time']:0 ;
			$data3=(!empty($insights['data'][0]['values'][2]['value'])) ? $insights['data'][0]['values'][2]['value']:0 ;
			$date3=(!empty($insights['data'][0]['values'][2]['end_time'])) ? $insights['data'][0]['values'][2]['end_time']:0 ;
									
			$this->StoreDemographic($loc_id,$data1,$date1,$data2,$date2,$data3,$date3);
		}
	}
	
	public function LocationAddress($fburl,$fsurl,$gurl,$loc_id)
	{
		$connection=Yii::app()->db;
		
		$sql_g="SELECT * FROM gurlinfo where loc_id= ".$loc_id;
		$url_g=$connection->createCommand($sql_g)->queryAll();
		
		if(empty($url_g[0]['address']))
		{
			$sql_fs="SELECT * FROM fsurlinfo where loc_id= ".$loc_id;
			$url_fs=$connection->createCommand($sql_fs)->queryAll();
			
			if(empty($url_fs[0]['address']) && empty($url_fs[0]['city']) && empty($url_fs[0]['country']))
			{
				$sql_fb = "SELECT * FROM fburlinfo where loc_id= ".$loc_id;
				$url_fb = $connection->createCommand($sql_fb)->queryAll();
				
				$address = '';
				
				if(trim(str_replace(',','',$url_fb[0]['city'])))
					$addrss .= $url_fb[0]['city'].',';
				if(trim(str_replace(',','',$url_fb[0]['state'])))
					$addrss .= $url_fb[0]['state'].',';
				if(trim(str_replace(',','',$url_fb[0]['city'])) && trim(str_replace(',','',$url_fb[0]['state'])))
					$addrss .= $url_fb[0]['country'];
				
				return $address;
			
			}
			else
			{
				$address = '';
				
				if(trim(str_replace(',','',$url_fs[0]['address'])))
					$addrss .= $url_fs[0]['address'].',';
				if(trim(str_replace(',','',$url_fs[0]['city'])))
					$addrss .= $url_fs[0]['city'].',';
				if(trim(str_replace(',','',$url_fs[0]['zip'])))
					$addrss .= $url_fs[0]['zip'].',';
				if(trim(str_replace(',','',$url_fs[0]['state'])))
					$addrss .= $url_fs[0]['state'].',';
				if(trim(str_replace(',','',$url_fs[0]['city'])) && trim(str_replace(',','',$url_fs[0]['state'])))
					$addrss .= $url_fs[0]['country'];
					
				return $address;
			}
		}
		else
			return $url_g[0]['address'];
	}
	
	public function LocationDim($fburl,$fsurl,$gurl,$loc_id)
	{
		$connection=Yii::app()->db;
		
		$sql_g="SELECT * FROM gurlinfo where loc_id= ".$loc_id;
		$url_g=$connection->createCommand($sql_g)->queryAll();
		
		if(empty($url_g[0]['latitude']) && empty($url_g[0]['lognitude']))
		{
			$sql_fs="SELECT * FROM fsurlinfo where loc_id= ".$loc_id;
			$url_fs=$connection->createCommand($sql_fs)->queryAll();
			
			if(empty($url_fs[0]['latitude']) && empty($url_fs[0]['lognitude']))
			{
				$sql_fb="SELECT * FROM fburlinfo where loc_id= ".$loc_id;
				$url_fb=$connection->createCommand($sql_fb)->queryAll();
				
				return $url_fb[0]['latitude'].'#'.$url_fb[0]['lognitude'];
			
			}
			else
				return $url_fs[0]['latitude'].'#'.$url_fs[0]['lognitude'];
		}
		else
			return $url_g[0]['latitude'].'#'.$url_g[0]['lognitude'];
	}
	
	public function LocationGoogleDim($gurl,$loc_id)
	{
		$connection=Yii::app()->db;
		
		$sql_g="SELECT * FROM gurlinfo where loc_id= ".$loc_id;
		$url_g=$connection->createCommand($sql_g)->queryAll();
		
		return $url_g[0]['latitude'].'#'.$url_g[0]['lognitude'];
	}
	
	public function SearchURL($url,$from,$id=0)
	{
		$connection=Yii::app()->db;
		
		if($from == 'fb') $column = 'fburl';
		else if($from == 'fs') $column = 'fsurl';
		else if($from == 'google') $column = 'googleurl';
		
		$sql = "SELECT * FROM location where ".$column." like '%".$url."%' and user_id=".Yii::app()->user->user_id;
		
		if($id>0)
			$sql .=" and loc_id!=".$id;
		
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function deletefromlocation($id)
	{
		$connection=Yii::app()->db;
		
		$sql='delete from location WHERE loc_id ='.$id; 
		$fbdel=$connection->createCommand($sql)->execute();
		
		return true;
	}
	
	public function deletefbdata($id)
	{
		$connection=Yii::app()->db;
		
		$sql='delete from fbdata WHERE loc_id ='.$id; 
		$fbdel=$connection->createCommand($sql)->execute();
		
		return true;
	}
	
	function return_unicode($string)
	{
		$string=str_replace('�','&Agrave;',$string);
		$string=str_replace('�','&agrave;',$string);
		$string=str_replace('�','&Aacute;',$string);
		$string=str_replace('�','&aacute;',$string);
		$string=str_replace('�','&Acirc;',$string);
		
		$string=str_replace('�','&acirc;',$string);
		
		$string=str_replace('�','&Atilde;',$string);
		
		$string=str_replace('�','&atilde;',$string);
		
		$string=str_replace('�','&Auml;',$string);
		
		$string=str_replace('�','&auml;',$string);
		
		$string=str_replace('�','&Aring;',$string);
		$string=str_replace('�','&aring;',$string);
		
		
		$string=str_replace('�','&AElig;',$string);
		
		$string=str_replace('�','&aelig;',$string);
		
		$string=str_replace('�','&Ccedil;',$string);
		$string=str_replace('�','&ccedil;',$string);
		
		$string=str_replace('�','&ETH;',$string);
		$string=str_replace('�','&eth;',$string);
		$string=str_replace('�','&Egrave;',$string);
		$string=str_replace('�','&egrave;',$string);
		$string=str_replace('�','&Eacute;',$string);
		$string=str_replace('�','&eacute;',$string);
		$string=str_replace('�','&Ecirc;',$string);
		$string=str_replace('�','&ecirc;',$string);
		$string=str_replace('�','&Euml;',$string);
		$string=str_replace('�','&euml;',$string);
		$string=str_replace('�','&Igrave;',$string);
		$string=str_replace('�','&igrave;',$string);
		$string=str_replace('�','&Iacute;',$string);
		$string=str_replace('�','&iacute;',$string);
		$string=str_replace('�','&Icirc;',$string);
		$string=str_replace('�','&icirc;',$string);
		$string=str_replace('�','&Iuml;',$string);
		$string=str_replace('�','&iuml;',$string);
		$string=str_replace('�','&Ntilde;',$string);
		$string=str_replace('�','&ntilde;',$string);
		$string=str_replace('�','&Ograve;',$string);
		$string=str_replace('�','&ograve;',$string);
		$string=str_replace('�','&Oacute;',$string);
		$string=str_replace('�','&oacute;',$string);
		$string=str_replace('�','&Ocirc;',$string);
		$string=str_replace('�','&ocirc;',$string);
		$string=str_replace('�','&Otilde;',$string);
		$string=str_replace('�','&otilde;',$string);
		$string=str_replace('�','&Ouml;',$string);
		$string=str_replace('�','&ouml;',$string);
		$string=str_replace('�','&Oslash;',$string);
		$string=str_replace('�','&oslash;',$string);
		$string=str_replace('�','&OElig;',$string);
		$string=str_replace('�','&oelig;',$string);
		$string=str_replace('�','&szlig;',$string);
		$string=str_replace('�','&THORN;',$string);
		$string=str_replace('�','&thorn;',$string);
		$string=str_replace('�','&Ugrave;',$string);
		$string=str_replace('�','&ugrave;',$string);
		$string=str_replace('�','&Uacute;',$string);
		$string=str_replace('�','&uacute;',$string);
		$string=str_replace('�','&Ucirc;',$string);
		$string=str_replace('�','&ucirc;',$string);
		$string=str_replace('�','&Uuml;',$string);
		$string=str_replace('�','&uuml;',$string);
		$string=str_replace('�','&Yacute;',$string);
		$string=str_replace('�','&yacute;',$string);
		$string=str_replace('�','&Yuml;',$string);
		$string=str_replace('�','&yuml;',$string);
		
		return $string;	
	}
	
	public function GetMaxVal($table,$primkey)
	{
		$connection=Yii::app()->db;
		$sql="SELECT MAX(".$primkey.") as id FROM ".$table;
		
		$result=$connection->createCommand($sql)->queryAll();
		return $result;
	}
	
	public function GetActiveCampaign($locid)
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT DISTINCT group_id FROM location_group where locations REGEXP '[[:<:]]".$locid."[[:>:]]' and userid=".Yii::app()->user->user_id;
		$result = $connection->createCommand($sql)->queryAll();
		
		$group_collection = '';
		if(count($result))
		{
			foreach($result as $key=>$value)
				$group_collection .= $value['group_id'].',';
		}
		
		$group_collection = substr($group_collection,0,-1);
		
		if(!empty($group_collection))
		{
			$sqls = "SELECT * FROM campaign where group_ids IN(".$group_collection.") and status='active' and end_date>'".strtotime(now)."' and userid=".Yii::app()->user->user_id;
			$results = $connection->createCommand($sqls)->queryAll();
		}
		
		return $results;
	}
}