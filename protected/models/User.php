<?php

/**
 * This is the model class for table "tbl_user".
 *
 * The followings are the available columns in table 'tbl_user':
 * @property integer $user_id
 * @property string $username
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property integer $status
 * @property string $profile_type
 * @property string $user_role
 * @property string $register_date
 * @property string $update_date
 */
class User extends CActiveRecord
{
	public $email;
	public $password;
	private $_identity;
	
	public $npassword;
	public $cpassword;
	
	public $temp_email;
	/*public $rememberMe;*/

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

	/**
	* perform one-way encryption on the password before we store it in the database


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, password', 'required'),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
		
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
			'user_id' => 'User',
			'email' => 'Email',
			'password' => 'Password',
			
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())  // we only want to authenticate when no input errors
		{
			$identity=new UserIdentity($this->email,$this->password);
			$identity->authenticate();
			
			switch($identity->errorCode)
			{
				case UserIdentity::ERROR_NONE:
					Yii::app()->user->login($identity);
					break;
				case UserIdentity::ERROR_USERNAME_INVALID:
					$this->addError('email','Email  is incorrect.');
					break;
				default: // UserIdentity::ERROR_PASSWORD_INVALID
					$this->addError('password','Password is incorrect.');
					break;
			}
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	 
	public function login()
	{
		if($this->_identity===null)
		{
			//echo  $this->username."asd fasd";
			$this->_identity=new UserIdentity($_POST['LoginForm']['email'],$_POST['LoginForm']['password']);
			
			$this->_identity->authenticate();
		}
		
		//echo $this->_identity->errorCode; 
		if($this->_identity->errorCode===UserIdentity::ERROR_USERNAME_INVALID)
		{
			$this->addError('email','Email  is incorrect.');
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_PASSWORD_INVALID)
		{
			$this->addError('email','Password  is incorrect.');
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
		
			//$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		
		else
			return false;
	}
	
	public function ChangePassword($password)
	{
		$connection=Yii::app()->db;
		$sql="SELECT * FROM ".$this->tableName(). " where password='".$password."' and user_id=".Yii::app()->user->user_id;
		
		$result=$connection->createCommand($sql)->queryAll();
		return count($result);
	}
	
	public function GetRecord()
	{
		$connection = Yii::app()->db;
		$sql = "SELECT * FROM ".$this->tableName(). " where user_id=".Yii::app()->user->user_id;
		
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function ValidateLimits()
	{
		$connection = Yii::app()->db;
		
		$user_rec = $this->GetRecord();
		
		if(!empty($user_rec[0]['subscriptionType']))
		{
			$sql = "SELECT * FROM subsription_type where name='".$user_rec[0]['subscriptionType']."'";
		
			$result = $connection->createCommand($sql)->queryAll();
		}
		
		return $result;
	}
	
	public function CountAdminUsers()
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM ".$this->tableName()." where admin_id=".Yii::app()->user->user_id;
		
		$result = $connection->createCommand($sql)->queryAll();
		
		return count($result);
	}
	
	public function GetOffRecord($user)
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM ".$this->tableName(). " where user_id=".$user;
		
		$result = $connection->createCommand($sql)->queryAll();
		return $result;
	}
	
	public function GetSources()
	{
		$connection = Yii::app()->db;
		$sql = "SELECT * FROM sources";
		
		$result = $connection->createCommand($sql)->queryAll();
		return $result;
	}
	
	public function GetCatSources($cats)
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM buzz_search_terms WHERE user_id=".Yii::app()->user->user_id." AND buzzterm_category=".$cats;
		
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function BuzzSearchTerms($userid=0)
	{
		$connection = Yii::app()->db;
		$sql = "SELECT * FROM buzz_search_terms";
		
		if($userid>0)
			$sql .= " WHERE user_id=".Yii::app()->user->user_id;
		
		$result = $connection->createCommand($sql)->queryAll();
		return $result;
	}
	
	public function UpdatePassword($password)
	{
		$connection = Yii::app()->db;
		$sql = "UPDATE ".$this->tableName(). " SET password='".$password."'where user_id=".Yii::app()->user->user_id;
		
		$result = $connection->createCommand($sql);
		$final_result = $result->execute();
		
		return $final_result;
	}
	
	public function UpdateSubscriptionValidTo($user_id)
	{
		$connection = Yii::app()->db;
		
		$date_end = strtotime(now) + (30*24*60*60);
		
		$sql = "UPDATE ".$this->tableName(). " SET subscriptionValidTo='".date('Y-m-d',$date_end)."'where user_id=".$user_id;
		
		$result = $connection->createCommand($sql);
		$final_result = $result->execute();
		
		return $final_result;
	}
	
	public function UpdateSubscriptionType($user_id,$type)
	{
		$connection = Yii::app()->db;
		
		$sql = "UPDATE ".$this->tableName(). " SET subscriptionType='".$type."'where user_id=".$user_id;
		
		$result = $connection->createCommand($sql);
		
		$final_result = $result->execute();
		
		return $final_result;
	}
	
	public function UpdateAccountingEmail($new_email)
	{
		$connection = Yii::app()->db;
		
		$sql = "UPDATE ".$this->tableName(). " SET accounting_email='".$new_email."'where user_id=".Yii::app()->user->user_id;
		
		$result = $connection->createCommand($sql);
		$final_result = $result->execute();
		
		return $final_result;
	}
	
	public function UpdateEmail($email)
	{
		$connection=Yii::app()->db;
		
		$verify_code=$this->createRandomPassword();
		
		$record=$this->GetRecord();
		
		if($record[0]['email']!=$email)
		{
			$sql="UPDATE ".$this->tableName(). " SET temp_email='".$email."', verify_code='".$verify_code."' where user_id=".Yii::app()->user->user_id;
			
			$result=$connection->createCommand($sql);
			$final_result=$result->execute();
		}
		else
			$final_result=5;
			
		return $final_result;
	}
	
	public function createRandomPassword() 
	{ 
	    $chars = "abcdefghijkmnopqrstuvwxyz023456789"; 
    	srand((double)microtime()*1000000); 
		$i = 0; 
	    $pass = '' ; 

    	while ($i <= 7) 
		{ 
        	$num = rand() % 33; 
        	$tmp = substr($chars, $num, 1); 
        	$pass = $pass . $tmp; 
        	$i++; 
    	} 

    	return $pass; 
	} 
	
	public function UpdateUserSubscriptionStatus($user_id,$status)
	{
		$connection=Yii::app()->db;	
		
		$sql="UPDATE ".$this->tableName(). " SET subscriptionStatus='".$status."' where user_id=".$user_id;
			
		$result=$connection->createCommand($sql);
		$final_result=$result->execute();
		
		return $final_result;
	}
	
	public function UpdateUserStatus($user_id,$status)
	{
		$connection=Yii::app()->db;	
		
		$sql="UPDATE ".$this->tableName(). " SET status='".$status."' where user_id=".$user_id;
			
		$result=$connection->createCommand($sql);
		$final_result=$result->execute();
		
		return $final_result;
	}
	
	public function SetIntroFlag($user_id)
	{
		$connection = Yii::app()->db;	
		
		$sql = "UPDATE ".$this->tableName(). " SET show_intro_tour=0 where user_id=".$user_id;
			
		$result = $connection->createCommand($sql);
		$final_result = $result->execute();
		
		return $final_result;
	}
	
	public function SetEmail($verifyer,$user)
	{
		$connection=Yii::app()->db;
		
		$record=$this->GetOffRecord($user);
		
		if($record[0]['temp_email'])
		{
			$sql="UPDATE ".$this->tableName(). " SET email='".$record[0]['temp_email']."' where verify_code='".$verifyer."' and user_id=".$user;
			
			$result=$connection->createCommand($sql);
			$final_result=$result->execute();
			
			if($final_result)
			{
				$sql2="UPDATE ".$this->tableName(). " SET verify_code='', temp_email='' where user_id=".$user;
			
				$result2=$connection->createCommand($sql2);
				$final_result2=$result2->execute();
			}
		}
			
		return $final_result;
	}

	public function GetUser($email)
	{
		$connection = Yii::app()->db;
		
		$sql = "Select * from ".$this->tableName(). " where email='".$email."'";
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetUserID($id)
	{
		$connection = Yii::app()->db;
		
		$sql = "Select * from ".$this->tableName(). " where user_id='".$id."'";
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetTimeZone()
	{
		$connection = Yii::app()->db;
		
		$sql = "Select * from zone order by zone_id asc";
		$result = $connection->createCommand($sql)->queryAll();
		
		$zones = array('0'=>'Select Time Zone');
		
		foreach($result as $key=>$value)
			$zones[$value['zone_id']] = $value['zone'];
			
		return $zones;
	}
	
	public function GetUserTimeZone()
	{
		$connection = Yii::app()->db;
		
		$sql = "Select timestamp from user where user_id=".Yii::app()->user->user_id;
		$result = $connection->createCommand($sql)->queryAll();
			
		return $result;
	}

	public function GetAllUsers()
	{
		$connection=Yii::app()->db;
		
		$sql="Select * from ".$this->tableName()." where user_id>1";
		$result=$connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetPaidUsers()
	{
		$connection=Yii::app()->db;
		
		$sql="Select * from ".$this->tableName()." where next_payment > 0";
		$result=$connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetComapnies()
	{
		$connection=Yii::app()->db;
		
		$sql = "Select DISTINCT company from ".$this->tableName()." where company!=''";
		$result =$connection->createCommand($sql)->queryAll();
		
		$companies = array();
		
		foreach($result as $key=>$value)
			$companies[$value['company']] = $value['company'];
			
		return $companies;
	}
	
	public function GetColumn($value)
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM user where email='".$value."' OR username='".$value."'";
		$result = $connection->createCommand($sql)->queryAll();
		
		$return = 'email';
		
		if($result[0]['email'] == $value)
			return $return = 'email';
		else if($result[0]['username'] == $value)
			return $return = 'username';
		
		return $return;
	}
	
	public function DeleteUser($user)
	{
		$connection=Yii::app()->db;
		
		//delete from location if data available
		$sql_location		=	"Select * from location where user_id=".$user;
		$result_location	=	$connection->createCommand($sql_location)->queryAll();
		
		if(count($result_location))
		{
			foreach($result_location as $key=>$value)
			{
				//delete data from demographic_ages if available
				
				$sql_demographic_ages		=	"Select * from demographic_ages where loc_id=".$value['loc_id'];
				$result_demographic_ages	=	$connection->createCommand($sql_demographic_ages)->queryAll();
				
				if(count($result_demographic_ages))
				{
					$sql_del_demographic_ages			=	"delete from demographic_ages where loc_id=".$value['loc_id'];
					$result_del_demographic_ages		=	$connection->createCommand($sql_del_demographic_ages);
					$final_result_demographic_ages		=	$result_del_demographic_ages->execute();		
				}
			}
			
			$sql_del_location		=	"delete from location where user_id=".$user;
			$result_del_location	=	$connection->createCommand($sql_del_location);
			$final_result_location	=	$result_del_location->execute();
		}
				
		//delete from fbpages if data available
		$sql_fbpages		=	"Select * from fbpages where user_id=".$user;
		$result_fbpages		=	$connection->createCommand($sql_fbpages)->queryAll();
		
		if(count($result_fbpages))
		{
			$sql_del_fbpages		=	"delete from fbpages where user_id=".$user;
			$result_del_fbpages		=	$connection->createCommand($sql_del_fbpages);
			$final_result_fbpages	=	$result_del_fbpages->execute();
		}
		
		//delete from fbpost if data available
		$sql_fbpost		=	"Select * from fbpost where user_id=".$user;
		$result_fbpost	=	$connection->createCommand($sql_fbpost)->queryAll();
		
		if(count($result_fbpost))
		{
			$sql_del_fbpost			=	"delete from fbpost where user_id=".$user;
			$result_del_fbpost		=	$connection->createCommand($sql_del_fbpost);
			$final_result_fbpost	=	$result_del_fbpost->execute();
		}
		
		//delete from access_token if data available
		$sql_access_token		=	"Select * from access_token where user_id=".$user;
		$result_access_token	=	$connection->createCommand($sql_access_token)->queryAll();
		
		if(count($result_access_token))
		{
			$sql_del_access_token			=	"delete from access_token where user_id=".$user;
			$result_del_access_token		=	$connection->createCommand($sql_del_access_token);
			$final_result_access_token		=	$result_del_access_token->execute();
		}
		
		//delete from campaign if data available
		$sql_campaign		=	"Select * from campaign where userid=".$user;
		$result_campaign	=	$connection->createCommand($sql_campaign)->queryAll();
		
		if(count($result_campaign))
		{
			foreach($result_campaign as $key=>$value)
			{
				//delete from fs_special if data available
				$sql_fs_special		=	"Select * from fs_special where campaign_id=".$value['campaign_id'];
				$result_fs_special	=	$connection->createCommand($sql_fs_special)->queryAll();
		
				if(count($result_fs_special))
				{
					if( $result_fs_special['campaign_id'] != '' )
					{
						$sql_del_fs_special			=	"delete from fbpost where campaign_id=".$result_fs_special['campaign_id'];
						$result_del_fs_special		=	$connection->createCommand($sql_del_fs_special);
						$final_result_fs_special	=	$result_del_fs_special->execute();
					}
				}
			}
			
			if( $user )
			{
				$sql_del_campaign			=	"delete from campaign where userid=".$user;
				$result_del_campaign		=	$connection->createCommand($sql_del_campaign);
				$final_result_campaign		=	$result_del_campaign->execute();
			}
		}
		
		//delete from fs_token if data available
		$sql_fs_token		=	"Select * from fs_token where userid=".$user;
		$result_fs_token	=	$connection->createCommand($sql_fs_token)->queryAll();
		
		if(count($result_fs_token))
		{
			if( $user )
			{
				$sql_del_fs_token			=	"delete from access_token where user_id=".$user;
				$result_del_fs_token		=	$connection->createCommand($sql_del_fs_token);
				$final_result_fs_token		=	$result_del_fs_token->execute();
			}
		}
		
		$sql_del_user		=	"delete from user where user_id=".$user;
		$result_del_user	=	$connection->createCommand($sql_del_user);
		$final_result_user	=	$result_del_user->execute();
		
	}
	
	// warning user about defaulted subscription
	
	public function UserDefaultSubscription()
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM ".$this->tableName()." where user_id=".Yii::app()->user->user_id;
		
		$result = $connection->createCommand($sql)->queryAll();
		
		$message = '';
		$verifier = 0;
		
		if($result[0]['subscriptionValidTo']!='0000-00-00')
		{
			$subscriptionValidTo = $result[0]['subscriptionValidTo'];
			
			$next_month_date = date('Y-m-d', strtotime($subscriptionValidTo. ' + 31 days'));
			
			$date_today = date('Y-m-d');
			
			$now = time();
			$your_date = strtotime($subscriptionValidTo);
			$datediff = $now - $your_date;
			$num_days = floor($datediff/(60*60*24));

			if($subscriptionValidTo < $date_today)
			{
				if($subscriptionValidTo < $next_month_date && $num_days<=30)
				{
					if($num_days>1) $num_days .= ' days ago'; else $num_days .= ' day';
					$epay_remaningdays = getContent('epay.remaningdays',Yii::app()->session['language']);

					$message = str_replace('[NUMDAYS]',$num_days,$epay_remaningdays);
					$message = str_replace('[SUBSCRIPTIONURL]',Yii::app()->request->baseUrl.'/index.php/subscription',$message);
					
				}
				else if($subscriptionValidTo < $next_month_date && $num_days>30)
				{
					if($num_days>1) $num_days .= ' days ago'; else $num_days .= ' day';

					$epay_subscriptionover = getContent('epay.subscriptionover',Yii::app()->session['language']);
					
					$message = str_replace('[NUMDAYS]',$num_days,$epay_subscriptionover);
					$message = str_replace('[SUBSCRIPTIONURL]',Yii::app()->request->baseUrl.'/index.php/subscription',$message);
					
					$verifier = 1;
				}
			}
		}
		
		return $message.'#'.$verifier;
	}
	
}