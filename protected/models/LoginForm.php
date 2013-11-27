<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $email;
	public $password;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that email and password are required,
	 * and password needs to be authenticated.
	 */
	 public function tableName()
	{
		return 'user';
	}
	public function rules()
	{
		return array(
			// email and password are required
			array('email, password', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Remember me next time',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity = new UserIdentity($this->email,$this->password);

			if(!$this->_identity->authenticate())
				$this->addError('password','Incorrect Email / Username or Password.');
		}
	}
	
	
	
	/**
	 * Logs in the user using the given email and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{	
			$this->_identity=new UserIdentity($this->email,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
	
	public function SaveRec($facebook_id,$account_name,$fname,$lname,$address,$city,$email,$password)
	{
		$connection = Yii::app()->db;
		
		$result_rec = $this->CheckExistsFb($facebook_id);

		if(count($result_rec)==0)
		{
			$sql="INSERT INTO ".$this->tableName(). "(facebook_id,account_name,fname,lname,address,city,email,password,subscriptionType,subscriptionStatus) VALUES('".$facebook_id."','".$account_name."','".$fname."','".$lname."','".$address."','".$city."','".$email."','".$password."','Moo','Approved')";
			
			$result = $connection->createCommand($sql);
			$final_result = $result->execute();
			
			return $password;
		}
		else
		{
			$sql="UPDATE ".$this->tableName(). " SET account_name = '".$account_name."',fname = '".$fname."',lname = '".$lname."',address = '".$address."',city = '".$city."',email = '".$email."' WHERE facebook_id=".$facebook_id;
			
			$result = $connection->createCommand($sql);
			$final_result = $result->execute();
			
			return $result_rec[0]['password'];
		}
	}
	
	public function CheckExistsFb($facebook_id)
	{
		$connection = Yii::app()->db;
		
		$sql = "SELECT * FROM ".$this->tableName(). " where facebook_id='".$facebook_id."'";
		$result_rec = $connection->createCommand($sql)->queryAll();
		
		return $result_rec;
	}
}
