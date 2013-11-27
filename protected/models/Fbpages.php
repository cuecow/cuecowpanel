<?php

/**
 * This is the model class for table "fbpages".
 *
 * The followings are the available columns in table 'fbpages':
 * @property string $id
 * @property string $page_name
 * @property string $page_id
 * @property string $for_public
 * @property string $for_fan
 * @property string $status
 */
class Fbpages extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Fbpages the static model class
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
		return 'fbpages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('page_id, for_public, for_fan', 'required'),
			array('status', 'length', 'max'=>7),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, page_name, page_id, for_public, for_fan, status', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'page_name' => 'Page Name',
			'page_id' => 'Page Id',
			'for_public' => 'Content for Public',
			'for_fan' => 'Content for Fans',
			'status' => 'Status',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('page_name',$this->page_name,true);
		$criteria->compare('page_id',$this->page_id,true);
		$criteria->compare('for_public',$this->for_public,true);
		$criteria->compare('for_fan',$this->for_fan,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function GetPages()
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM ".$this->tableName()." where user_id=".Yii::app()->user->user_id." and page_url != '' and status='active'" ;
		
		$result=$connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetAllPages()
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM ".$this->tableName()." where user_id=".Yii::app()->user->user_id ;
		
		$result=$connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetFBURL($link)
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM fburlinfo where link='".$link."'";
		
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function UpdateFbData($fburl_id,$likes,$checkins,$talking_about)
	{
		$connection = Yii::app()->db;
		
		$sql_data = 'INSERT INTO fburl_data(fburl_id,likes,checkins,talking_about_count,dated) VALUES("'.$fburl_id.'","'.$likes.'","'.$checkins.'","'.$talking_about.'","'.strtotime(now).'")';
				
		$result_data = $connection->createCommand($sql_data);
		$final_result = $result_data->execute();
		
		return $final_result;
	}
	
	public function VerifyFbDataDate($fburl_id)
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM fburl_data where fburl_id='".$fburl_id."' order by dated desc limit 0,1";
		
		$result = $connection->createCommand($sql)->queryAll();
		
		if(count($result))
			return date('m/d/Y',$result[0]['dated']);
		else
			return false;
	}
	
	public function GetUserSetPages()
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM fbpages_set_by_user where user_id=".Yii::app()->user->user_id ;
		
		$result=$connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetPagesExist()
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM ".$this->tableName()." where status='active'";
		
		$result=$connection->createCommand($sql)->queryAll();
		
		return count($result);
	}
	
	public function GetPagesExistId($id)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM ".$this->tableName()." where page_id='".$id."' and user_id=".Yii::app()->user->user_id ;
		
		$result=$connection->createCommand($sql)->queryAll();
		
		return count($result);
	}
	
	public function GetPage($id)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM ".$this->tableName()." where id='".$id."'";
		
		$result=$connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function StoreUserPages($page_name,$page_id,$page_url,$status = 'blocked',$fans = 0, $user_id = 0)
	{
		$connection = Yii::app()->db;
		 
		if($user_id > 0)
			$userid = $user_id;
		else
			$userid = Yii::app()->user->user_id;
			
		$sql_chk = "SELECT * FROM fbpages where user_id=".$userid." and page_id=".$page_id;
		$posts = $connection->createCommand($sql_chk)->queryAll();
		
		if(count($posts) == 0)
		{
			$sql = "insert into fbpages(user_id,page_id,page_name,page_url,status,fans) values('".$userid."','".$page_id."','".addslashes($page_name)."','".$page_url."','".$status."','".$fans."')";
			
			$result = $connection->createCommand($sql);
			
			$final_result = $result->execute();
		}
		else
		{
			$sql = "update fbpages set status='".$status."' where user_id='".$userid."' and page_id='".$page_id."'";
			
			$result = $connection->createCommand($sql);
			
			$final_result = $result->execute();
		}
				
		return $final_result;
	}
	
	public function CountUserPages($status = '')
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM fbpages where user_id=".Yii::app()->user->user_id;
		
		if($status != '')
			$sql .= " and status='".$status."'";
		
		$result = $connection->createCommand($sql)->queryAll();
		
		return count($result);
	}
	
	public function FetchUserPages()
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM fbpages where user_id=".Yii::app()->user->user_id;
		
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function UpdatepageStatus($status,$page_id)
	{
		$connection = Yii::app()->db;
		
		$sql = "update fbpages set status='".$status."' where user_id='".Yii::app()->user->user_id."' and id='".$page_id."'";
			
		$result = $connection->createCommand($sql);
			
		$final_result = $result->execute();	
	}
	
	public function UpdatePageStats($page_id,$fans,$tot_post,$url)
	{
		$connection = Yii::app()->db;
		
		$sql = "update fbpages set fans='".$fans."',new_post='".$tot_post."',page_url='".$url."' where page_id='".$page_id."'";
			
		$result = $connection->createCommand($sql);
			
		$final_result = $result->execute();	
	}
	
	public function SetAllPageBlocked()
	{
		$connection = Yii::app()->db;
		
		$sql = "update fbpages set status='blocked' where user_id=".Yii::app()->user->user_id;
			
		$result = $connection->createCommand($sql);
			
		$final_result = $result->execute();	
	}
	
	public function InsertSetBy()
	{
		$connection = Yii::app()->db;
		
		$sql_chk = "SELECT * FROM fbpages_set_by_user where user_id=".Yii::app()->user->user_id;
		$res = $connection->createCommand($sql_chk)->queryAll();
		
		if(count($res) == 0)
		{
			$sql = "insert into fbpages_set_by_user(user_id,set_by_user,dated) values('".Yii::app()->user->user_id."','yes','".strtotime(now)."')";
			
			$result = $connection->createCommand($sql);
			
			$final_result = $result->execute();	
		}
		else
		{
			$sql = "update fbpages_set_by_user set dated='".strtotime(now)."' where user_id=".Yii::app()->user->user_id;
			
			$result = $connection->createCommand($sql);
			
			$final_result = $result->execute();
		}
	}
	
	public function GetTablePages()
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM ".$this->tableName() ;
		
		$result=$connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function VerifyUserPages($user_id, $page_id)
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM ".$this->tableName()." where user_id=".$user_id." and page_id=".$page_id ;
		
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function DeletePages($pageids,$user_id)
	{
		$connection = Yii::app()->db;
		
		$sql = "DELETE from ".$this->tableName()." where page_id NOT IN (".$pageids.") and user_id=".$user_id ;
		
		$result = $connection->createCommand($sql);
		
		$res = $result->execute();
	}
}