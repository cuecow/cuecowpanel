<?php

/**
 * This is the model class for table "access_token".
 *
 * The followings are the available columns in table 'access_token':
 * @property string $token_id
 * @property string $user_id
 * @property string $fbtoken
 * @property string $fstoken
 */
class AccessToken extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return AccessToken the static model class
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
		return 'access_token';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, fbtoken, fstoken', 'required'),
			array('user_id, fbtoken, fstoken', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('token_id, user_id, fbtoken, fstoken', 'safe', 'on'=>'search'),
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
			'token_id' => 'Token',
			'user_id' => 'User',
			'fbtoken' => 'Fbtoken',
			'fstoken' => 'Fstoken',
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

		$criteria->compare('token_id',$this->token_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('fbtoken',$this->fbtoken,true);
		$criteria->compare('fstoken',$this->fstoken,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function StoreAccessToken($access_token,$tokenmedia)
	{
		$connection=Yii::app()->db;
		
		$sql_chk="SELECT * FROM access_token where user_id=".Yii::app()->user->user_id;
		$posts=$connection->createCommand($sql_chk)->queryAll();
		
		if(count($posts)==0)
		{
			$sql="insert into access_token(user_id,".$tokenmedia.") values('".Yii::app()->user->user_id."','".$access_token."')";
			$result=$connection->createCommand($sql);
			$final_result=$result->execute();
		}
		else
		{
			$sql="update access_token set ".$tokenmedia."='".$access_token."' where user_id=".Yii::app()->user->user_id;
			$result=$connection->createCommand($sql);
			$final_result=$result->execute();
		}
				
		return $final_result;
	}
	
	public function StoreTwitterAccessToken($oauthtken,$oauthtokensecret)
	{
		$connection=Yii::app()->db;
		
		$sql_chk="SELECT * FROM access_token where user_id=".Yii::app()->user->user_id;
		$posts=$connection->createCommand($sql_chk)->queryAll();
		
		if(count($posts)==0)
		{
			$sql="insert into access_token(user_id,twitter_oauth_token,twitter_oauth_token_secret) values('".Yii::app()->user->user_id."','".$oauthtken."','".$oauthtokensecret."')";
			$result=$connection->createCommand($sql);
			$final_result=$result->execute();
		}
		else
		{
			$sql="update access_token set twitter_oauth_token='".$oauthtken."', twitter_oauth_token_secret= '".$oauthtokensecret."' where user_id=".Yii::app()->user->user_id;
			$result=$connection->createCommand($sql);
			$final_result=$result->execute();
		}
				
		return $final_result;
	}
	
	public function StorePageAccessToken($name,$access_token,$page_id,$user_id = 0)
	{
		$connection=Yii::app()->db;
		
		if($user_id > 0)
			$userid = $user_id;
		else
			$userid = Yii::app()->user->user_id;
			
		$sql_chk = "SELECT * FROM user_pages_token where user_id=".$userid." and page_id=".$page_id;
		$posts=$connection->createCommand($sql_chk)->queryAll();
		
		if(count($posts)==0)
		{
			$sql="insert into user_pages_token(user_id,page_id,name,token) values('".$userid."','".$page_id."','".addslashes($name)."','".$access_token."')";
			$result=$connection->createCommand($sql);
			$final_result=$result->execute();
		}
		else
		{
			$sql="update user_pages_token set token='".$access_token."' where user_id=".$userid." and page_id=".$page_id;
			$result=$connection->createCommand($sql);
			$final_result=$result->execute();
		}
				
		return $final_result;
	}
	
	public function StoreFBUID($uid)
	{
		$connection=Yii::app()->db;
		
		$sql="update user set facebook_id='".$uid."' where user_id=".Yii::app()->user->user_id;
		$result=$connection->createCommand($sql);
		$final_result=$result->execute();
				
		return $final_result;
	}
	
	public function CheckAuth()
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM ".$this->tableName()." where user_id=".Yii::app()->user->user_id;
		$check_token=$connection->createCommand($sql)->queryAll();
		
		return $check_token;
	}
	
	public function PageAuth($page_id)
	{
		$connection=Yii::app()->db;
		
		$sql="SELECT * FROM user_pages_token where user_id=".Yii::app()->user->user_id." and page_id=".$page_id;
		$check_token=$connection->createCommand($sql)->queryAll();
		
		return $check_token;
	}
	
	public function GetUserTokens()
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM ".$this->tableName();
		$check_token = $connection->createCommand($sql)->queryAll();
		
		return $check_token;	
	}
	
	public function GetUserTokenRecord($user_id)
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM access_token where user_id=".$user_id;
		$check_token = $connection->createCommand($sql)->queryAll();
		
		return $check_token;	
	}
	
	public function DeleteToken($id)
	{
		$connection = Yii::app()->db;
		
		$sql = "delete from ".$this->tableName()." where token_id=".$id;
		$result = $connection->createCommand($sql);
		$final_result = $result->execute();
				
		return $final_result;
	}
	
	public function DeleteUserPagesTokens($pageids,$user_id)
	{
		$connection = Yii::app()->db;
		
		$sql = "DELETE from user_pages_token where page_id NOT IN (".$pageids.") and user_id=".$user_id ;
		
		$result = $connection->createCommand($sql);
		
		$res = $result->execute();
	}
}