<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $user_id
 * @property string $facebook_id
 * @property string $account_name
 * @property string $fname
 * @property string $lname
 * @property string $address
 * @property string $city
 * @property string $postal_code
 * @property string $country
 * @property string $phone
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $temp_email
 * @property string $verify_code
 * @property string $status
 * @property string $role
 * @property integer $timestamp
 */
class AccountForm extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return AccountForm the static model class
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
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('facebook_id, fname, lname, address, city, postal_code, country, phone, email, password, temp_email, verify_code, role, timestamp', 'required'),
			array('timestamp', 'numerical', 'integerOnly'=>true),
			array('facebook_id, verify_code', 'length', 'max'=>20),
			array('fname, lname, email, password, role', 'length', 'max'=>255),
			array('address, temp_email', 'length', 'max'=>500),
			array('city', 'length', 'max'=>200),
			array('postal_code, country, phone', 'length', 'max'=>100),
			array('status', 'length', 'max'=>7),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, facebook_id, fname, lname, address, city, postal_code, country, phone, email, password, temp_email, verify_code, status, role, timestamp', 'safe', 'on'=>'search'),
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
			'facebook_id' => 'Facebook',
			'account_name' => 'Account Name',
			'fname' => 'Fname',
			'lname' => 'Lname',
			'address' => 'Address',
			'city' => 'City',
			'postal_code' => 'Postal Code',
			'country' => 'Country',
			'phone' => 'Phone',
			'username' => 'Username',
			'email' => 'Email',
			'password' => 'Password',
			'temp_email' => 'Temp Email',
			'verify_code' => 'Verify Code',
			'status' => 'Status',
			'role' => 'Role',
			'timestamp' => 'Timestamp',
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

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('facebook_id',$this->facebook_id,true);
		$criteria->compare('fname',$this->fname,true);
		$criteria->compare('lname',$this->lname,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('postal_code',$this->postal_code,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('temp_email',$this->temp_email,true);
		$criteria->compare('verify_code',$this->verify_code,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('role',$this->role,true);
		$criteria->compare('timestamp',$this->timestamp);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function CheckAccountName($accountname)
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM ".$this->tableName(). " where account_name='".$accountname."'";
		
		$result = $connection->createCommand($sql)->queryAll();
		return count($result);
	}
	
	public function CheckUserName($username)
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM ".$this->tableName(). " where username='".$username."'";
		
		$result = $connection->createCommand($sql)->queryAll();
		
		return count($result);
	}
	
	public function CheckEmail($email)
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM ".$this->tableName(). " where email='".$email."'";
		
		$result = $connection->createCommand($sql)->queryAll();
		
		return count($result);
	}
	
	public function CheckSubscriptionType($type)
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM subsription_type where name='".$type."'";
		$result = $connection->createCommand($sql)->queryAll();
		
		return count($result);
	}
	
	public function GetSubscriptionPrice($id)
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM subsription_type where subscription_id = '".$id."'";
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function CheckSubscriptionAmount($type)
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM subsription_type where name='".$type."'";
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetUserInfoWithAccountName($accountname)
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM ".$this->tableName(). " where account_name='".$accountname."'";
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function SaveRec($account_name,$email,$username,$password,$subscription_type,$subscriptionStatus,$fname,$lname,$phone,$company,$address,$postal_code,$city,$country)
	{
		$connection=Yii::app()->db;
		$sql="INSERT INTO ".$this->tableName(). "(account_name,email,accounting_email,username,password,subscriptionType,subscriptionStatus,fname,lname,phone,company,address,postal_code,city,country,show_intro_tour) VALUES('".$account_name."','".$email."','".$email."','".$username."','".$password."','".$subscription_type."','".$subscriptionStatus."','".$fname."','".$lname."','".$phone."','".$company."','".$address."','".$postal_code."','".$city."','".$country."',1)";
		
		$result = $connection->createCommand($sql);
		$final_result = $result->execute();
		
		return Yii::app()->db->getLastInsertID();
	}
	
	public function SaveTransactionrelation($orderid,$userId,$PlanId,$amount,$tax,$account_name,$email,$username,$fname,$lname,$phone,$company,$address,$postal_code,$city,$country)
	{
		$connection = Yii::app()->db;
		
		$sql = 'insert into transaction(orderid,user_id,planid,amount,tax,account_name,email,username,fname,lname,phone,company,address,postal_code,city,country) values("'.$orderid.'","'.$userId.'","'.$PlanId.'","'.$amount.'","'.$tax.'","'.$account_name.'","'.$email.'","'.$username.'","'.$fname.'","'.$lname.'","'.$phone.'","'.$company.'","'.$address.'","'.$postal_code.'","'.$city.'","'.$country.'")';
		
		$result = $connection->createCommand($sql);
		$final_result = $result->execute();
		
		return true;
	}
	
	public function UpdateCreditMain($inv_id)
	{
		$connection = Yii::app()->db;
		
		$sql = 'update transaction set kreditnota_for_id="'.$inv_id.'" where id="'.$inv_id.'"';
		
		$result = $connection->createCommand($sql);
		$final_result = $result->execute();
		
		return true;
	}
	
	public function KreditNota($kredit = array())
	{
		$connection = Yii::app()->db;
		
		$sql = 'insert into transaction set ';
		$sql_temp = '';
		
		$g = 1;
		foreach($kredit as $key=>$value)
		{
			$sql_temp .= $key.'="'.$value.'"';
			
			if($g!=count($kredit))
				$sql_temp .=', ';
				
			$g++;
		}
		
		$query = $sql.$sql_temp;
		
		$result = $connection->createCommand($query);
		$final_result = $result->execute();
		
		return true;
	}
	
	public function GetTransactionInfo($column,$val)
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM transaction where ".$column."='".$val."'";
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetLatestTransaction($user)
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM transaction where user_id='".$user."' order by id desc limit 0,1";
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetAllTransaction()
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM transaction where status='paid' order by id desc";
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function GetUsersAllTransaction()
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM transaction where status='paid' and user_id='".Yii::app()->user->user_id."' order by id desc";
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
		
	public function DeleteTransaction($id)
	{
		$connection = Yii::app()->db;
		
		$sql = 'delete from transaction where id="'.$id.'"';
		
		$result = $connection->createCommand($sql);
		$final_result = $result->execute();
		
		return true;
	}
	
	public function SaveTransaction($tid,$orderid,$total_amount,$cur,$date,$time,$subscriptionid,$transfee)
	{
		//$date_end = strtotime(now) + (30*24*60*60);
		
		$connection = Yii::app()->db;
		
		//$sql = 'update transaction set tid="'.$tid.'",total_amount="'.$total_amount.'",cur="'.$cur.'",date="'.$date.'",time="'.$time.'",subscriptionid="'.$subscriptionid.'",transfee="'.$transfee.'",end_date="'.date('Y-m-d',$date_end).'",status="paid" where orderid="'.$orderid.'"';
		
		$sql = 'update transaction set tid="'.$tid.'",total_amount="'.$total_amount.'",cur="'.$cur.'",date="'.$date.'",time="'.$time.'",subscriptionid="'.$subscriptionid.'",transfee="'.$transfee.'",status="paid" where orderid="'.$orderid.'"';
		
		$result = $connection->createCommand($sql);
		$final_result = $result->execute();
		
		return Yii::app()->db->getLastInsertID();
	}
	
	function randomPassword() 
	{
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$pass = array();
		$alphaLength = strlen($alphabet) - 1;
		
		for ($i = 0; $i < 8; $i++) 
		{
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		
		return implode($pass);
	}
	
	public function GetLatestTransactionInfo($user_id)
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM transaction where user_id = '".$user_id."' order by id desc limit 0,1";
		$result = $connection->createCommand($sql)->queryAll();
		
		return $result;
	}
	
	public function SaveTransactionChangeCard($subscriptionid,$transid,$orderid,$transfee,$total_amount,$cur,$date,$time,$userId)
	{
		$connection = Yii::app()->db;
		
		$sql = 'insert into transaction(subscriptionid,tid,orderid,transfee,total_amount,cur,date,time,user_id) values("'.$subscriptionid.'","'.$transid.'","'.$orderid.'","'.$transfee.'","'.$total_amount.'","'.$cur.'","'.$date.'","'.$time.'","'.$userId.'")';
		
		$result = $connection->createCommand($sql);
		$final_result = $result->execute();
		
		return true;
	}
}