<?php

require(dirname(__FILE__).DIRECTORY_SEPARATOR.'facebook.php');

class FbLogin extends CInputWidget
{
	public $devappid;
    public $devsecret;
    public $cookie = TRUE;
    public $domain;
    public $options = array();
        
    public $FB;
    public $Session;
    public $user;
        
    protected $userid;
    protected $username;
    
    public function run()
	{	
    	$controller = $this->controller;
        $this->controller->createAction('fblogin');
        		
        if(Yii::app()->user->isGuest)
		{
        	$this->FB = new Facebook(array(
	  			'appId' => $this->devappid,
			  	'secret' => $this->devsecret,
	  			'cookie' => $this->cookie,
			));
			
			$this->Session =  $this->FB->getSession();
			$appids = $this->FB->getAppId();  
			
			if($this->Session) 
			{
				try 
				{
					$uid = $this->FB->getUser();
					$this->user = $this->FB->api('/me');
				} 
				catch (FacebookApiException $e) 
				{
					error_log($e);
				}
			}
	
			$this->userid = $this->user['id'];
			$this->username = $this->user['name'];	
		
	
        	$login = $this->FB->getLoginUrl();
        	$logout = $this->FB->getLogoutUrl();	
		}
        
        $url = $this->controller->createAbsoluteUrl('fblogin',array('username'=>$this->username,'userid'=>$this->userid,'logout'=>CHtml::encode($logout)));
        $this->user ? $this->controller->redirect( $url ) : null;
        
        if(Yii::app()->user->isGuest)
		{
        	$this->render('fbview',array('session'=>$this->Session,'user'=>$this->user,'login'=>$login,'logout'=>$logout,'appid'=>$appids));   
		}
		else
		{
		 	$this->FB = new Facebook(array(
				'appId' => $this->devappid,
				'secret' => $this->devsecret,
				'cookie' => $this->cookie,
			));		
		}
	}          
}