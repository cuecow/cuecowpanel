<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	
	 // Need to store the user's ID:
	private $_id;
	 
	public function authenticate()
	{
		// check what the username / email ?
		$logincheck = User::model()->GetColumn($this->username);
		
		$user = User::model()->findByAttributes(array($logincheck=>$this->username,'status'=>'active'));

		if ($user===null) 
		{
	 		// No user found!
    		$this->errorCode=self::ERROR_USERNAME_INVALID;
		} 
		else if ($user->password !== $this->password )
	 	{ 
			// Invalid password!
    		$this->errorCode=self::ERROR_PASSWORD_INVALID;	
		}
		else
		{ 
			// Okay!
    		$this->errorCode=self::ERROR_NONE;
    		// Store the role in a session:
   			$this->setState('role', $user->role);
			$this->setState('user_id', $user->user_id);
			$this->_id = $user->user_id;
		}
	
		return !$this->errorCode;	
	}

	public function getId()
	{
		return $this->_id;
	}
}