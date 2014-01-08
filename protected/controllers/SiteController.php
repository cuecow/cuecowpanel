<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->redirect('index.php/site/login');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}
	
	public function actionInsertcampaign()
	{
		$model = new User;
		
		if( isset($_POST) && $_POST['fname'] != '' && $_POST['company'] != '' && $_POST['email'] != '' && $_POST['password'] != '' )
		{
			
			$fname = $_POST['fname'];
			$lname = $_POST['lname'];
			$company = $_POST['company'];
			$email = $_POST['email'];
			$password = $_POST['password'];
			$subscriptionType = $_POST['subscriptionType'];
			$subscriptionValidTo = $_POST['subscriptionValidTo'];	
			
			$exist_email = $model->GetUser($email);
			
			if( count($exist_email) == 0 )
			{
				$model->fname = $fname;
				$model->lname = $lname;
				$model->company = $company ;
				$model->email = $email;
				$model->password = $password;
				$model->subscriptionType = $subscriptionType;
				$model->subscriptionValidTo = $subscriptionValidTo;
				
				$save = $model->save();
				
				echo $save;
			}
			else
				echo 'email exist';
		}
	}


	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}
	
	/**
	 * Displays the account page
	 */
	public function actionAccount()
	{
		$model = new AccountForm;
		$model_login = new LoginForm;
		$subscriptionType = $_GET['subscription'];
		$error = 0;
		
		
		if(empty($subscriptionType))
			echo '<script>window.location.href="http://www.cuecow.com/?page_id=27"</script>';
		else
		{
			$ExistSubscType = $model->CheckSubscriptionType($subscriptionType);
			
			if($ExistSubscType == 0)
				echo '<script>window.location.href="http://www.cuecow.com/?page_id=27"</script>';
		}
		
		if(isset($_POST['AccountForm']))
		{
			// Validate for mendatory fields
			
			if($_POST['AccountForm']['terms']!='yes')
			{
				$model->addError('account_name','Please accept the trading conditions before moving on');	
				$error++;
			}
			
			if(empty($_POST['AccountForm']['account_name']) || empty($_POST['AccountForm']['email']) || empty($_POST['AccountForm']['repeat_email']) || empty($_POST['AccountForm']['password']))
			{
				$model->addError('account_name','Fields marked with (*) are mandatory');	
				$error++;
			}
			
			// validate account name
			if(!empty($_POST['AccountForm']['account_name']) && !preg_match('/^[a-z0-9æøåÆØÅ\-\s]+$/i',$_POST['AccountForm']['account_name']))
			{
				$model->addError('account_name','"Account name" should only contain characters, numbers, spaces and dashes');
				$error++;	
			}
			
			// validate email
			if(!empty($_POST['AccountForm']['email']) && !filter_var($_POST['AccountForm']['email'], FILTER_VALIDATE_EMAIL))
			{
				$model->addError('email','Email is not in valid format');
				$error++;
			}
			
			//validate email and repeat email
			if(!empty($_POST['AccountForm']['email']) && !empty($_POST['AccountForm']['repeat_email']) && $_POST['AccountForm']['repeat_email'] != $_POST['AccountForm']['email'])
			{
				$model->addError('email','Email and Repeat Email should be same');
				$error++;	
			}
			
			//validate password
			if(!empty($_POST['AccountForm']['password']) && strlen($_POST['AccountForm']['password'])<6)
			{
				$model->addError('password','Password should be minimum 6 character long');
				$error++;	
			}
			
			if(!empty($_POST['AccountForm']['username']))
			{
				if($model->CheckUserName($_POST['AccountForm']['username']))
				{
					$model->addError('username','This username is already exists.');
					$error++;
				}
			}
			
			if(!empty($_POST['AccountForm']['email']))
			{
				if($model->CheckEmail($_POST['AccountForm']['email']))
				{
					$model->addError('email','This email is already registered with Cuecow, and needs to be unique.');
					$error++;
				}
			}
			
			// check if everything entered is valid
			if($error == 0)
			{
				if($model->CheckAccountName($_POST['AccountForm']['account_name'])==0)
				{
					if($_POST['AccountForm']['subscriptionType']!='Moo')
						$subscriptionStatus = 'pending';
					else
						$subscriptionStatus = 'approved';
					
					if($error == 0)
					{
						$account_name	 	= $_POST['AccountForm']['account_name'];
						$email			 	= $_POST['AccountForm']['email'];
						$username		 	= $_POST['AccountForm']['username'];
						$password		 	= $_POST['AccountForm']['password'];
						$subscriptionType 	= $_POST['AccountForm']['subscriptionType'];
						$fname 				= $_POST['AccountForm']['fname'];
						$lname 				= $_POST['AccountForm']['lname'];
						$phone 				= $_POST['AccountForm']['phone'];
						$company 			= $_POST['AccountForm']['company'];
						$address 			= $_POST['AccountForm']['address'];
						$postal_code 		= $_POST['AccountForm']['postal_code'];
						$city 				= $_POST['AccountForm']['city'];
						$country 			= $_POST['AccountForm']['country'];
						
						$SaveRecord = $model->SaveRec($account_name,$email,$username,$password,$subscriptionType,$subscriptionStatus,$fname,$lname,$phone,$company,$address,$postal_code,$city,$country);
						
						if($SaveRecord)
						{
							
							if($_POST['AccountForm']['subscriptionType']!='Moo')
							{	
								if($_REQUEST['offer_guid'])
									$guid = "/offer_guid/".$_REQUEST['offer_guid'];
									
								echo '<script>window.location.href="http://panel.cuecow.com/index.php/site/redirect/id/'.$SaveRecord.$guid.'"</script>';
								exit;
							}
							
							$to      = $_POST['AccountForm']['email'];
							$from	 = 'admin@cuecow.com';
							$subject = 'Cuecow Account Created';
							
							$headers = "From: " . strip_tags($from) . "\r\n";
							$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
							$headers .= "MIME-Version: 1.0\r\n";
							$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
							
							if($_POST['AccountForm']['username'])
								$mes = 'Username: '.$_POST['AccountForm']['username'];
							else
								$mes = 'Username: '.$_POST['AccountForm']['email'];
							
							$mes .= '<br />Password: '.$_POST['AccountForm']['password'];
							$message = 'Hello '.$_POST['AccountForm']['account_name'].' <br /><br /> Thank you for signing up at Cuecow. Your login information to the site is found below- <br /><br /> '.$mes.'<br /> Login URL: http://panel.cuecow.com';
							
							$mail = mail($to, $subject, $message, $headers);	
							
							// Payment section for paid accounts
							
							$userinfo = $model->GetUserInfoWithAccountName($_POST['AccountForm']['account_name']);
							
							if(!empty($userinfo[0]['user_id']))
							{
								$model_login->email 	= $_POST['AccountForm']['email'];
								$model_login->password 	= $_POST['AccountForm']['password'];
								
								if($model_login->login())
									$this->redirect(array('user/profile/view/medias'));
									
									//$this->redirect(array('user/dashboard/new/'.$_POST['AccountForm']['email']));
							}
						}
					}
				}
				else
				{
					$model->addError('account_name','This Account name already exists, try with another one');
					$error++;	
				}
			}
		}
		
		if(!empty($_REQUEST['offer_guid']))
		{
			$tele_record = MarketingOffer::model()->GetRecordWithGid($_REQUEST['offer_guid']);	
			
			$tele_camp_record = array('account_name'=>$tele_record[0]['account_name'],'user_email'=>$tele_record[0]['user_email'],'user_fname'=>$tele_record[0]['user_fname'],'user_lname'=>$tele_record[0]['user_lname'],'company'=>$tele_record[0]['company'],'address'=>$tele_record[0]['address'],'city'=>$tele_record[0]['city'],'postal_code'=>$tele_record[0]['postal_code'],'country'=>$tele_record[0]['country']);
		}
		
		$this->render('account',array('model'=>$model,'error'=>$error,'subscriptionType'=>$subscriptionType,'tele_camp_record'=>$tele_camp_record));
	}
	
	public function actionRedirect($id)
	{
		$model = new AccountForm;
		
		$UserInfo = User::model()->GetOffRecord($id);
		
		$SubscriptionInfo = $model->CheckSubscriptionAmount($UserInfo[0]['subscriptionType']);
						
		//$epay_merchant_number = '8010148';
		$epay_merchant_number = '5732417';
		
		$currency_no = 208;
		$epay_url = 'https://ssl.ditonlinebetalingssystem.dk/popup/default.asp';
		
		if($_REQUEST['offer_guid'])
		{
			$GetCampaignRecord = MarketingOffer::model()->GetRecordWithGid($_REQUEST['offer_guid']); 
			
			$payment_amount = $GetCampaignRecord[0]['offered_price'];
		}
		else
			$payment_amount = $SubscriptionInfo[0]['price'];
		
		$tax = ($payment_amount*25)/100;
		
		$payment_amount_in_minor_units = ($payment_amount+$tax)*100;
		
		$post_data = array();
		
		$post_data['merchantnumber'] = $epay_merchant_number;
		$post_data['subscription'] = 1;
		$post_data['amount'] = $payment_amount_in_minor_units;
		$post_data['currency'] = $currency_no;
		
		$orderid = $model->randomPassword();
		$post_data['orderid'] = $orderid;
		
		//gpfgWG3332A5SUV
		
		$account_name 	= $UserInfo[0]['account_name'];
		$email 			= $UserInfo[0]['email'];
		$username 		= $UserInfo[0]['username'];
		$fname 			= $UserInfo[0]['fname'];
		$lname 			= $UserInfo[0]['lname'];
		$phone 			= $UserInfo[0]['phone'];
		$company 		= $UserInfo[0]['company'];
		$address 		= $UserInfo[0]['address'];
		$postal_code 	= $UserInfo[0]['postal_code'];
		$city 			= $UserInfo[0]['city'];
		$country 		= $UserInfo[0]['country'];
		
		//save order_id and user_id relation
		$model->SaveTransactionrelation($post_data['orderid'],$id,$SubscriptionInfo[0]['subscription_id'],$payment_amount,$tax,$account_name,$email,$username,$fname,$lname,$phone,$company,$address,$postal_code,$city,$country);
		
		$post_data['accepturl'] = 'http://panel.cuecow.com/index.php/site/payaccepted';
		//$post_data['declineurl'] = 'http://panel.cuecow.com/index.php/site/paydeclined';
		$post_data['callbackurl'] = 'http://panel.cuecow.com/index.php/site/paycallback';
		
		$post_data['language'] = "2";
		$post_data['instantcapture'] = "1";
		
		$this->render('redirect',array('model'=>$model,'post_data'=>$post_data));
	}
	
	public function actionPaydeclined()
	{
		$model=new AccountForm;
		
		$transaction = $model->GetTransactionInfo('orderid',$_REQUEST['orderid']);
		
		if($transaction[0]['id'])
			$model->DeleteTransaction($transaction[0]['id']);
		
		if($transaction[0]['user_id'])
			User::model()->DeleteUser($transaction[0]['user_id']);
		
		$this->render('paydeclined',array('model'=>$model));
	}
	
	public function actionPayaccepted()
	{
		$model = new AccountForm;
		
		$model_login = new LoginForm;
		
		$params = $_GET;
		
		$var = "";
		
		foreach ($params as $key => $value)
		{
			if($key != "hash")
			{
				$var .= $value;
			}
		}
		  
		$genstamp = md5($var . "gpfgWG3332A5SUV");
		  
		if($genstamp != $_GET["hash"])
		{
			echo "Hash is not valid";
			exit();
		}
		else
		{
			//Hash is OK    
			
			$subscriptionid = $_GET['subscriptionid'];
			$transid = $_GET['tid'];
			$orderid = $_GET['orderid'];
			$total_amount = $_GET['amount']/100;
			$transfee = $_GET['transfee'];
			$cur = $_GET['cur'];
			$date = $_GET['date'];
			$time = $_GET['time'];
			
			$lastid = $model->SaveTransaction($transid,$orderid,$total_amount,$cur,$date,$time,$subscriptionid,$transfee);
			
			$transaction = $model->GetTransactionInfo('orderid',$_REQUEST['orderid']);
			
			$user_id = $transaction[0]['user_id'];
			$UserInfo = User::model()->GetOffRecord($user_id);
								
			if(!empty($user_id))
			{
				//save next billing date
				
				User::model()->UpdateSubscriptionValidTo($user_id);
				
				//send invoice
				
				if(count($transaction))
				{
					$TransactionDate = substr($transaction[0]['date'], 0, 4).'-'.substr($transaction[0]['date'], 4, 2).'-'.substr($transaction[0]['date'], 6, 2);
					
					$to_email = $UserInfo[0]['email'];
					$from_email = 'admin@cuecow.com';
					$subject = 'Cuecow Invoice';
					$message = 'Dear [USERNAME],<br /><br />Thank you for subscribing to our social media engagement platform.<br />We hereby send you an invoice covering the next period of use.<br /><br />Best regards,<br />Cuecow <br /><br />[INVOICE_HTML]';
					
					$mailcontents = file_get_contents('http://panel.cuecow.com/invoice/invoice.html');
					
					$address = '';
					
					if(!empty($UserInfo[0]['fname']))
					{
						$user_name = $UserInfo[0]['fname'].' '.$UserInfo[0]['lname'];
						$mailcontents = str_replace('[USERNAME]',$user_name,$mailcontents);
						$message = str_replace('[USERNAME]',$user_name,$message);
					}
					else if(!empty($UserInfo[0]['account_name']))
					{
						$user_name = $UserInfo[0]['account_name'];
						$mailcontents = str_replace('[USERNAME]',$user_name,$mailcontents);
						$message = str_replace('[USERNAME]',$user_name,$message);
					}
					else if($UserInfo[0]['username'])
					{
						$user_name = $UserInfo[0]['username'];
						$mailcontents = str_replace('[USERNAME]',$user_name,$mailcontents);
						$message = str_replace('[USERNAME]',$user_name,$message);
					}
					
					if(!empty($user_name))
						$address .= $user_name.'<br />';
					if(!empty($UserInfo[0]['company']))
						$address .= $UserInfo[0]['company'].'<br />';
					if(!empty($UserInfo[0]['address']))
						$address .= $UserInfo[0]['address'].'<br />';
					if(!empty($UserInfo[0]['postal_code']))
						$address .= $UserInfo[0]['postal_code'].' ';
					if(!empty($UserInfo[0]['city']))
						$address .= $UserInfo[0]['city'].'<br />';
					if(!empty($UserInfo[0]['country']))
						$address .= $UserInfo[0]['country'].'<br />';
					
					$date_end = strtotime(now) + (30*24*60*60);
					
					$mailcontents = str_replace('[ADDRESS]',$address,$mailcontents);
					$mailcontents = str_replace('[INVOICE_ID]',date('y').'-'.$transaction[0]['id'],$mailcontents);
					$mailcontents = str_replace('[PAYMENT_DATE]',$TransactionDate,$mailcontents);
					$mailcontents = str_replace('[SUBSCRIPTION_LIMIT]',$TransactionDate.' to '.date('Y-m-d',$date_end),$mailcontents);
					$mailcontents = str_replace('[TOTAL_AMOUNT]',number_format($transaction[0]['amount'],2,',','.').' DKK',$mailcontents);
					
					$mailcontents = str_replace('[TAX]',number_format($transaction[0]['tax'],2,',','.').' DKK',$mailcontents);			
					$mailcontents = str_replace('[GRAND_TOTAL]',number_format($transaction[0]['total_amount'],2,',','.').' DKK',$mailcontents);			
					
					$message = str_replace('[INVOICE_HTML]',$mailcontents,$message);
					
					$pdf_name = 'Cuecow Invoice '.date('y').'_'.$transaction[0]['id'].'.pdf';
					
					if(!file_exists(dirname(__FILE__).'/../../pdf/'.$pdf_name))
					{
						$mPDF1 = Yii::app()->ePdf->mpdf();
						$mPDF1->WriteHTML($mailcontents);
						$mPDF1->Output(dirname(__FILE__).'/../../pdf/'.$pdf_name, EYiiPdf::OUTPUT_TO_FILE);	
					}
					
					// a random hash will be necessary to send mixed content
					$separator = md5(time());
					
					// carriage return type (we use a PHP end of line constant)
					$eol = PHP_EOL;
					
					// main header (multipart mandatory)
					$headers = "From: ".$from_email.$eol;
					$headers .= "MIME-Version: 1.0".$eol;
					$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"".$eol.$eol;
					$headers .= "Content-Transfer-Encoding: 7bit".$eol;
					$headers .= "This is a MIME encoded message.".$eol.$eol;
					
					// message
					$headers .= "--".$separator.$eol;
					$headers .= "Content-Type: text/html; charset=\"utf-8\"".$eol;
					$headers .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
					$headers .= $message.$eol.$eol;
					
					// attachment
					$headers .= "--".$separator.$eol;
					
					$filename = $pdf_name;
					
					$agreement_file = dirname(__FILE__).'/../../pdf/'.$pdf_name;
					$file = fopen($agreement_file, 'rb');
					$pdf_contents = fread($file, filesize($agreement_file));
					fclose($file);
					
					$pdfdoc = $pdf_contents;
					
					$attachment = chunk_split(base64_encode($pdfdoc));
					$headers .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol;
					$headers .= "Content-Transfer-Encoding: base64".$eol;
					$headers .= "Content-Disposition: attachment".$eol.$eol;
					$headers .= $attachment.$eol.$eol;
					$headers .= "--".$separator.$eol;
					
					$headers .= "--".$separator."--";
					
					$mail = mail($to_email,$subject,$message,$headers);	
					
				}
								
								
				User::model()->UpdateUserSubscriptionStatus($user_id,'approved');
				
				$to      = $UserInfo[0]['email'];
				$from	 = 'admin@cuecow.com';
				$subject = 'Cuecow Account Created';
				
				$headers = "From: " . strip_tags($from) . "\r\n";
				$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				
				if($UserInfo[0]['username'])
					$mes = 'Username: '.$UserInfo[0]['username'];
				else
					$mes = 'Username: '.$UserInfo[0]['email'];
				
				$mes .= '<br />Password: '.$UserInfo[0]['password'];
				$message = 'Hello '.$UserInfo[0]['fname'].' <br /><br /> Thank you for signing up at Cuecow. Your login information to the site is found below- <br /><br /> '.$mes.'<br /> Login URL: http://panel.cuecow.com';
				
				$mail = mail($to, $subject, $message, $headers);
								
				$model_login->email = $UserInfo[0]['email'];
				$model_login->password = $UserInfo[0]['password'];
				
				if($model_login->login())
				{
					$this->redirect(Yii::app()->request->baseUrl.'/index.php/user/profile/view/medias');
						
					/*$social_check = AccessToken::model()->CheckAuth();
				
					if(count($social_check)==0) 
						$this->redirect(Yii::app()->request->baseUrl.'/index.php/user/profile/view/medias');
					else
						$this->redirect(array('user/dashboard/new/'.$UserInfo[0]['email']));*/
				}
			}
		}
		
		$this->render('payaccepted',array('model'=>$model));
	}
	
	public function actionPaycallback()
	{
		$model=new AccountForm;
		
		$this->render('paycallback',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;
		
		$facebook='';
		//var_dump(Yii::app()->user->auth_via); die();
		if(isset(Yii::app()->user->auth_via))
		{
                    //var_dump('abc'); die();
			$facebook = Yii::app()->user->auth_via;
		}
		
		
		if(isset(Yii::app()->user->user_id))
		{
                    //var_dump('abc1'); die();
			$this->redirect(Yii::app()->request->baseUrl.'/index.php/user/dashboard');
		}
		
		if(!empty($_REQUEST['ref']) && !empty($_REQUEST['user']))
		{
                    //var_dump('abc2'); die();
			$UpdateEmail = User::model()->SetEmail($_REQUEST['ref'],$_REQUEST['user']);	
			
			if($UpdateEmail)
				$this->redirect(Yii::app()->request->baseUrl.'/index.php/site/login/updated/1');
		}
		
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
                    //var_dump('abc3'); die();
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
                    //var_dump($_POST['LoginForm']); die();
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			
			if($model->validate() && $model->login())
			{
                            //var_dump('abc5'); die();
				$social_check = AccessToken::model()->CheckAuth();
			
				if(count($social_check)==0) 
					$this->redirect(Yii::app()->request->baseUrl.'/index.php/user/profile/view/medias');
				else
					$this->redirect(array('user/dashboard'));
			}
		}
		
		if(!isset(Yii::app()->user->user_id))
		{
                    //var_dump('abc6'); die();
			include('src/facebook.php');
			
			$facebook = new Facebook(array(
				'appId'		=> '452837591443453',
				'secret'	=> '30f979ecc99c77764c13920446baf33a',
			));
	
			$user = $facebook->getUser();
		
			if($user)
			{
                            //var_dump('abc7'); die();
				Yii::app()->session['flogout'] = $facebook->getLogoutUrl();
				
				$user_profile = $facebook->api('/me');

				if(count($user_profile))
				{
                                    //var_dump('abc8'); die();
					$facebook_id = $user_profile['id'];
					$account_name = $user_profile['username'];
					$fname = $user_profile['first_name'];
					$lname = $user_profile['last_name'];
					$address = $user_profile['location']['name'];
					$city = $user_profile['hometown']['name'];
					$email = $user_profile['email'];
					$password = '';
					
					$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	
					$length = 8;
					
					$size = strlen( $chars );
					for( $i = 0; $i < $length; $i++ )
						$password .= $chars[ rand( 0, $size - 1 ) ];
					
					$SaveRecord = $model->SaveRec($facebook_id,$account_name,$fname,$lname,$address,$city,$email,$password);
					
					if($SaveRecord)
					{	
						$model->email = $email;
						$model->password = $SaveRecord;
							
						if($model->login())
							$this->redirect(array('user/dashboard/new/'.$_POST['AccountForm']['email']));
						
					}
				}
			}
			else{
                            //var_dump('abc10'); die();
				$fbloginUrl = $facebook->getLoginUrl(array('scope'=> 'email,user_birthday,publish_stream,create_event,publish_checkins,offline_access','redirect_uri'=> 'http://panel.cuecow.com/index.php/site/login'));
                                //var_dump($fbloginUrl); die();
                        }
		}
		//var_dump('end'); die();
		// display the login form
		$this->render('login',array('model'=>$model,'facebook'=>$facebook,'fbloginUrl'=>$fbloginUrl));
	}
	
	public function actionResetpass()
	{
		$model=new User;
		
		if(isset($_POST['User']))
		{	
			if(empty($_POST['User']['email']))
			{
				$model->addError('email','Email can not be blank.');
			}
			else
			{
				$exist_user=$model->GetUser($_POST['User']['email']);
			
				if($exist_user)
				{
					$emailid=$exist_user[0]['email'];
					$from='scheduler@cuecow.com';
						
					$subject='Reset Password request on cuecow.com';
	
					$mailcontent=' We have got a request to regain the password.<br /><br /> Below is your password - . <br />'.$exist_user[0]['password'];
						
					$headers="MIME-Version: 1.0\n";
					$headers.="Content-type: text/html; charset=iso-8859-1\r\n";
					$headers.="Content-Transfer-Encoding: 8bit\n"; 
					$headers.="From:$from";
						
					$mail=mail($emailid,$subject,$mailcontent,$headers);
					#$mail=1;	
					
					if($mail)
					{
						$this->redirect(array('site/resetpass/send/yes'));
					}
					else
					{
						$this->redirect(array('site/resetpass/send/no'));
					}
				}
				else
				{
					$this->redirect(array('site/resetpass/send/failed'));
				}
			}
		}
		
		$this->render('resetpass',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}