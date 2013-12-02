<?php

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			
			array('allow',  // allow all users to perform 'index' and 'view' actions
			'actions'=>array('index','view'),
			'users'=>array('*'),
			
		),
		
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('admin','delete','dashboard','statistics','campaign','facebook','newcampaign','editfacebook','deletefacebook','fbposts','viewfbposts','delpost','profile','usermanagement','updateuser','authmeida','deleteuser','buzz','postage','keywords','alert','getalert','deletealert','addalert','selectfbpages','Setintroflag','invoice','fbbenchmark','upgradesubscription','upgrade','payaccepted','downgrade','changecard','changecardaccepted','topbuzz','twitter','simulateuser'),
				'users'=>array('@'),
		),
		
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(''),
				'users'=>array('admin'),
		),
		
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionBuzz()
	{
		$model = new Buzz;
		
		if(isset($_POST))
		{
			// multiple recipients
			$to = $_POST['email'];
			$url = $_POST['url'];
			$body = $_POST['body'];
			
			// subject
			$subject = 'Social buzz: '.$url;
			
			// message
			$message = '
			Hi,<br />
			You\'ve recieved the following from Cuecow.com: <br /><br />'.$url.'<br /><br />
			<span style="font-style: italic; font-size: 11px;">'.$body.'</span><br /><br />Thanks,<br />Cuecow.com';
			
			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
			// Mail it
			//mail($to, $subject, $message, $headers);
		}
		
		$sources 		= $model->GetSources();
		$categories 	= $model->GetBuzzCategories();
		
		if(!empty($categories))
		{
			$temp_cat = explode('&',substr($categories[0]['categories'],0,-1));	
		}
		
		// Get Page Title
		$PageTitle = GetPageSubTitle($_SERVER['PATH_INFO'],$_REQUEST['view']);
		
		$this->render('buzz',array('model'=>$model,'sources'=>$sources,'categories'=>$temp_cat,'PageTitle'=>$PageTitle));
	}
	
	public function actionPostage()
	{
		$model = new Buzz;
		
		$sources = $model->GetSources();
		$categories 	= $model->GetBuzzCategories();
		
		if(!empty($categories))
		{
			$temp_cat = explode('&',substr($categories[0]['categories'],0,-1));	
		}
		
		$this->renderPartial('buzz/postage',array('model'=>$model,'sources'=>$sources,'categories'=>$temp_cat));	
	}
	
	public function actionFbbenchmark()
	{
		$model = new User;
		$error = '';
		$likes			= '';
		$checkins		= '';
		$talking_about	= '';
					
		if(isset($_POST['url']))
		{
			if(!empty($_POST['url']))
			{
				$urlinfo = Fbpages::model()->GetFBURL($_POST['url']);
				
				if(count($urlinfo))
				{
					$id = $urlinfo[0]['id'];
					$fburlid = $urlinfo[0]['fburl_id'];
					$contents 		= 	json_decode(file_get_contents('http://graph.facebook.com/'.$id));
				
					$likes			=	$contents->likes;
					$checkins		=	$contents->checkins;
					$talking_about	=	$contents->talking_about_count;
					
					$verify = Fbpages::model()->VerifyFbDataDate($fburlid);
					
					if($verify != date('m/d/Y'))
						Fbpages::model()->UpdateFbData($fburlid,$likes,$checkins,$talking_about);
				}
				else
					$error = 'URL not found in system.';
			}
			else
				$error = 'URL can not be blank.';
		}
		
		$this->render('benchmark',array('model'=>$model,'error'=>$error,'likes'=>$likes,'checkins'=>$checkins,'talking_about'=>$talking_about));
		
	}
	
	public function actionDeleteAlert()
	{
		$model = new Buzz;
		
		$sources = $model->GetSources();
		
		$this->render('buzz/deletealert',array('model'=>$model,'sources'=>$sources));	
	}
	
	public function actionKeywords()
	{
		$model = new Buzz;
		$run =false;
		
		if(isset($_POST))
		{
			$run = $model->addNewKeys($_POST['brand'], $userid, 1);
			$run = $model->addNewKeys($_POST['product'], $userid, 2);
			$run = $model->addNewKeys($_POST['person'], $userid, 3);
			$run = $model->addNewKeys($_POST['competitor'], $userid, 4);	
			$run = $model->addNewKeys($_POST['industry'], $userid, 5);
		}
		
		$sources = $model->GetSources();
		
		$this->redirect(array('user/buzz'));
		//$this->renderPartial('buzz/keywords',array('model'=>$model,'sources'=>$sources,'run'=>$run));	
	}
	
	public function actionAlert()
	{
		$model = new Buzz;
		
		$sources = $model->GetSources();
		
		$this->redirect(array('user/buzz'));
		//$this->render('buzz/alert',array('model'=>$model,'sources'=>$sources));	
	}
	
	public function actionAddAlert()
	{
		$model = new Buzz;
		
		$sources = $model->GetSources();
		
		$this->redirect(array('user/buzz'));
		//$this->render('buzz/addalert',array('model'=>$model,'sources'=>$sources));	
	}
	
	public function actionGetAlert()
	{
		$model = new Buzz;
		
		$sources = $model->GetSources();
				
		$this->render('buzz/getalert',array('model'=>$model,'sources'=>$sources));	
	}
		
	public function actionDashboard()
	{
		$model = new Location;
		
		// Get Page Title
		$PageTitle = GetPageSubTitle($_SERVER['PATH_INFO'],$_REQUEST['view']);
		
		$this->render('dashboard',array('model'=>$model,'PageTitle'=>$PageTitle));
		
	}
	
	public function actionTopbuzz()
	{
		$sources = Buzz::model()->GetSources();
		$categories = Buzz::model()->GetBuzzCategories();
		
		if(!empty($categories))
			$temp_cat = explode('&',substr($categories[0]['categories'],0,-1));	
			
		$this->renderPartial('topbuzz',array('sources'=>$sources,'categories'=>$temp_cat));
	}
	
	public function actionViewfbposts($id)
	{
		$model=Fbposts::model()->findByPk($id);
		$this->render('viewfbposts',array(
			'model'=>$model,
		));
	}
	
	
	public function actionSetintroflag()
	{
		$model = new User;
		
		$UpdateFlag = $model->SetIntroFlag($_REQUEST['user_id']);
	}
	
	public function actionInvoice()
	{
		$model = new User;
		$GetUser = $model->GetRecord();

		$Transaction = AccountForm::model()->GetUsersAllTransaction();
		
		$this->render('userinvoice',array('model'=>$model,'GetRows'=>$Transaction,'GetUser'=>$GetUser));
	}
	
	public function actionProfile()
	{
		$model = new User;
		$validate = 0;
		$updated = 0;
		
		$subscription_model = SubsriptionType::model()->GetAllRec();
		$subscription_array = array();
		
		if( count($subscription_model) )
		{
			foreach( $subscription_model as $keys => $values )	
				$subscription_array[$values['name']] = $values['name'];
		}
		
		if(isset($_POST['User']))
		{
			if($_POST['change'] == 'changepassword')
			{
				if(empty($_POST['User']['password']))
				{
					$model->addError('password','Current Password can not be blank');
					$validate=1;
				}
				
				if(empty($_POST['User']['npassword']))
				{
					$model->addError('npassword','New Password can not be blank');
					$validate=1;
				}
				
				if(empty($_POST['User']['cpassword']))
				{
					$model->addError('npassword','Confirm New Password can not be blank');
					$validate=1;
				}
				
				if($_POST['User']['cpassword'] != $_POST['User']['npassword'])
				{
					$model->addError('npassword','Confirm Password and New Password should be same.');
					$validate=1;
				}
				
				if($validate == 0)
				{
					
					$ValidatePassowrd = $model->ChangePassword($_POST['User']['password']);
					if($ValidatePassowrd)
					{
						$UpdatePassword = $model->UpdatePassword($_POST['User']['npassword']);
						if($UpdatePassword)
						{
							$updated=1;
						}
						else
							$model->addError('password','Password could not updated. Please try again.');
					}
					else
					{
						$model->addError('password','Current Password did not match.');
						$validate=1;
					}
				}
			}
			else if($_POST['change'] == 'accountingsetup')
			{
				if(empty($_POST['User']['accounting_email']))
				{
					$model->addError('accounting_email','Accounting Email can not be blank');
					$validate = 1;
				}
				
				
				if($validate == 0)
				{
					if($model->UpdateAccountingEmail($_POST['User']['accounting_email']))
						$updated = 1;
				}
			}
			else if($_POST['change'] == 'email')
			{
				if(empty($_POST['User']['temp_email']))
				{
					$model->addError('temp_email','Email can not be blank');
					$validate=1;
				}
				if(empty($_POST['User']['password']))
				{
					$model->addError('password','Password can not be blank');
					$validate=1;
				}
			
				if($validate == 0)
				{
					//code to enter new email
					$VerifyPassword=$model->ChangePassword($_POST['User']['password']);
					
					if($VerifyPassword)
					{
						$update_email=$model->UpdateEmail($_POST['User']['temp_email']);
						
						if($update_email==5)
						{
							$model->addError('temp_email','Current email and new email could not be same.');
							$validate=1;
						}
						else if($update_email)
						{
							$record = $model->GetRecord();
							
							$emailid=$_POST['User']['temp_email'];
							$id=$model->user_id;
								
							$subject='Change Email request on Cuecow';
								
							$mailcontent='Hello '.$record[0]['fname'].',<br /> We have got a request to use this email address on Cuecow.Please to verify this email address.<a href="http://panel.cuecow.com/index.php/site/login/ref/'.$record[0]['verify_code'].'/user/'.$record[0]['user_id'].'">click here</a><br />If this is not done by you.Please ignore this email.';
								
							$headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";
							
							$mail=mail($emailid,$subject,$mailcontent,$headers);	
							
							if($mail)
								$updated=1;
							else
							{
								$model->addError('temp_email','Email could not send. Please, try again.');
								$validate=1;
							}
						}
						else
						{
							$model->addError('temp_email','Email could not be updated. Please, try again.');
							$validate=1;
						}
					}
					else
					{
						$model->addError('password','password is not correct.');
						$validate=1;
					}
				}
			}
		}
		
		$GetUser = $model->GetRecord();
		
		if($_REQUEST['subact'] == 'sendinvoice')
		{
			$Transaction = AccountForm::model()->GetLatestTransaction(Yii::app()->user->user_id);
			
			if(count($Transaction))
			{
				$TransactionDate = substr($Transaction[0]['date'], 0, 4).'-'.substr($Transaction[0]['date'], 4, 2).'-'.substr($Transaction[0]['date'], 6, 2);
				
				$to_email = $GetUser[0]['accounting_email'];
				$from_email = 'admin@cuecow.com';
				$subject = 'Cuecow Invoice';
				
				$message = 'Dear [USERNAME],<br /><br />Thank you for subscribing to our social media engagement platform.<br />We hereby send you an invoice covering the next period of use.<br /><br />Best regards,<br />Cuecow <br /><br />[INVOICE_HTML]';
				
				$address = '';
				
				$mailcontent = file_get_contents('http://panel.cuecow.com/invoice/invoice.html');
				
				if(!empty($GetUser[0]['fname']))
				{
					$user_name = $GetUser[0]['fname'].' '.$GetUser[0]['lname'];
					$mailcontent = str_replace('[USERNAME]',$user_name,$mailcontent);
					$message = str_replace('[USERNAME]',$username,$message);
				}
				else if(!empty($GetUser[0]['account_name']))
				{
					$user_name = $GetUser[0]['account_name'];
					$mailcontent = str_replace('[USERNAME]',$user_name,$mailcontent);
					$message = str_replace('[USERNAME]',$username,$message);
				}
				else if($GetUser[0]['username'])
				{
					$user_name = $GetUser[0]['username'];
					$mailcontent = str_replace('[USERNAME]',$user_name,$mailcontent);
					$message = str_replace('[USERNAME]',$username,$message);
				}
				
				if(!empty($user_name))
					$address .= $user_name.'<br />';
				if(!empty($GetUser[0]['company']))
					$address .= $GetUser[0]['company'].'<br />';
				if(!empty($GetUser[0]['address']))
					$address .= $GetUser[0]['address'].'<br />';
				if(!empty($GetUser[0]['postal_code']))
					$address .= $GetUser[0]['postal_code'].' ';
				if(!empty($GetUser[0]['city']))
					$address .= $GetUser[0]['city'].'<br />';
				if(!empty($GetUser[0]['country']))
					$address .= $GetUser[0]['country'].'<br />';
				
				$mailcontent = str_replace('[ADDRESS]',$address,$mailcontent);
				$mailcontent = str_replace('[INVOICE_ID]',date('y').'-'.$Transaction[0]['id'],$mailcontent);
				$mailcontent = str_replace('[PAYMENT_DATE]',$TransactionDate,$mailcontent);
				$mailcontent = str_replace('[SUBSCRIPTION_LIMIT]',$TransactionDate.' to '.$GetUser[0]['subscriptionValidTo'],$mailcontent);
				$mailcontent = str_replace('[TOTAL_AMOUNT]',number_format($Transaction[0]['amount'],2,',','.').' DKK',$mailcontent);
				$mailcontent = str_replace('[TAX]',number_format($Transaction[0]['tax'],2,',','.').' DKK',$mailcontent);			
				$mailcontent = str_replace('[GRAND_TOTAL]',number_format($Transaction[0]['total_amount'],2,',','.').' DKK',$mailcontent);
				
				$message = str_replace('[INVOICE_HTML]',$mailcontents,$message);
				
				$pdf_name = 'Cuecow Invoice '.date('y').'_'.$Transaction[0]['id'].'.pdf';
				
				if(!file_exists(dirname(__FILE__).'/../../pdf/'.$pdf_name))
				{
					$mPDF1 = Yii::app()->ePdf->mpdf();
					$mPDF1->WriteHTML($mailcontent);
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
				
				if($mail)
				{
					$updated = 2;
					$this->redirect(array('user/profile/view/accountingsetup/inv/'.$updated));
				}
			}
			else
			{
				$updated = -1;
				$this->redirect(array('user/profile/view/accountingsetup/inv/'.$updated));
			}
		}
		

		if($_REQUEST['view']=='email' || $_POST['change']=='email')
			$view_val = 'email';
		else if($_REQUEST['view'] == 'password')
			$view_val = 'password';
		else if($_REQUEST['view']=='medias')
			$view_val = 'medias';
		else if($_REQUEST['view'] == 'accountingsetup')
			$view_val='accountingsetup';
		else if($_REQUEST['view'] == 'changesubscription')
			$view_val = 'changesubscription';
		else if($_REQUEST['view'] == 'selwall')
			$view_val = 'selwall';
		else if($_REQUEST['view'] == 'editaccount')
		{
			$view_val = 'editaccount';
			
			if($_REQUEST['act'] == 'del')
			{
				if(Yii::app()->user->role != 'admin')	
					$UpdateStatus = User::model()->UpdateUserStatus(Yii::app()->user->user_id, 'blocked');
				else
					$UpdateStatus = User::model()->UpdateUserStatus($_REQUEST['user'], 'blocked');
				
				if( $UpdateStatus && Yii::app()->user->role != 'admin')
					$this->redirect(array('site/logout'));
				else
					$this->redirect(array('user/usermanagement/view/List'));
			}
			
			if($_REQUEST['act'] == 'active')
			{
				if(Yii::app()->user->role == 'admin')	
				{
					$UpdateStatus = User::model()->UpdateUserStatus($_REQUEST['user'], 'active');
				
					$this->redirect(array('user/usermanagement/view/List'));
				}
			}
			
			$model = User::model()->findByPk(Yii::app()->user->user_id);
		
			$validate = 0;
			
			if(isset($_POST['User']))
			{
				if(empty($_POST['User']['fname']))
				{
					$model->addError('fname','First Name can not be blank');
					$validate++;
				}
				if(empty($_POST['User']['lname']))
				{
					$model->addError('lname','Last Name can not be blank');
					$validate++;
				}
					
				if( $validate == 0 )
				{
					$model->fname 		= 	$_POST['User']['fname'];
					$model->lname 		= 	$_POST['User']['lname'];
					$model->address 	= 	$_POST['User']['address'];
					$model->company 	= 	$_POST['User']['company'];
					$model->city 		= 	$_POST['User']['city'];
					$model->postal_code = 	$_POST['User']['postal_code'];
					$model->country 	= 	$_POST['User']['country'];
					$model->phone 		= 	$_POST['User']['phone'];
					$model->timestamp	= 	$_POST['User']['timestamp'];
						
					$model->save();
						
					$this->redirect(array('user/profile/view/editaccount'));
				}
			}
			
			//Get current subscription detail
			$SubscriptionDetail = SubsriptionType::model()->GetSpecificRecbyName($model->subscriptionType);
		}
		
		if( $_POST['selwallbtn'] == 'Activate' )
		{
			$total_walls_selected = count($_POST['wall']);
			
			$ValidateLimits = User::model()->ValidateLimits();
			
			$CountUserPages = Fbpages::model()->CountUserPages('active');
			
			if( /*$CountUserPages <= $ValidateLimits[0]['max_num_walls'] && */$total_walls_selected <= $ValidateLimits[0]['max_num_walls'] )
			{
				$UserPages = Fbpages::model()->FetchUserPages();
				
				if(count($UserPages) && count($_POST['wall']))
				{
					foreach($UserPages as $keys => $values)	
						Fbpages::model()->StoreUserPages('',$values['page_id'],'','blocked');	
				}
				
				if(count($_POST['wall']))
				{
					foreach( $_POST['wall'] as $key => $value )
						Fbpages::model()->StoreUserPages('',$value,'','active');
				}
				
				Yii::app()->user->setState('errroMsg', '');	
				
				$this->redirect(array('user/profile/view/selwall'));
			}
			else
			{
				Yii::app()->user->setState('errroMsg', 'you can not select more than '.$ValidateLimits[0]['max_num_walls'].' walls');	
				
				$this->redirect(array('user/profile/view/selwall'));
				
			}
		}
		
		if(!empty($_REQUEST['inv']))
			$updated = $_REQUEST['inv'];
		
		// Get Page Title
		$PageTitle = GetPageSubTitle($_SERVER['PATH_INFO'],$_REQUEST['view']);
		
		$this->render('profile',array('model'=>$model,'validate'=>$validate,'updated'=>$updated,'view_val'=>$view_val,'GetUser'=>$GetUser,'PageTitle'=>$PageTitle,'SubscriptionDetail'=>$SubscriptionDetail,'subscription_array'=>$subscription_array));
	}
	
	public function actionDowngrade()
	{
		$message = '';
		
		$SubscriptionInfo 	= SubsriptionType::model()->GetSpecificRec($_REQUEST['id']);
		
		$max_num_users 		= $SubscriptionInfo[0]['max_num_users'];
		
		$max_num_venues 	= $SubscriptionInfo[0]['max_num_venues'];
		$CountUserLocation 	= Location::model()->CountUserLocation();
		
		if( $CountUserLocation > $max_num_venues )
			$message .= '/venues/'.$max_num_venues;	
		
		$max_num_campaigns 	= $SubscriptionInfo[0]['max_num_campaigns'];
		$CountUserCampaign 	= Campaign::model()->CountUserCampaign();
		
		if( $CountUserCampaign > $max_num_campaigns )
			$message .= '/camapigns/'.$max_num_campaigns;	
		
		$max_num_apps 		= $SubscriptionInfo[0]['max_num_apps'];
		
		$max_num_walls 		= $SubscriptionInfo[0]['max_num_walls'];
		$CountUserPages 	= Fbpages::model()->CountUserPages();
		
		if( $CountUserPages > $max_num_walls )
			$message .= '/walls/'.$max_num_walls;	
		
		if($message !='' )
			$this->redirect(array('user/profile/view/changesubscription'.$message));
		else
			$this->redirect(array('user/upgrade/id/'.$_REQUEST['id']));
		
	}
	
	public function actionChangecard()
	{
		$model = new AccountForm;

		$UserInfo = User::model()->GetRecord();
						
		//$epay_merchant_number = '8010148';
		$epay_merchant_number = '5732417';
		
		$currency_no = 208;
		$epay_url = 'https://ssl.ditonlinebetalingssystem.dk/popup/default.asp';
		
		$payment_amount = 0;
		$tax = 0;
		$payment_amount_in_minor_units = ($payment_amount+$tax)*100;
		
		$post_data = array();
		
		$post_data['merchantnumber'] = $epay_merchant_number;
		$post_data['subscription'] = 1;
		$post_data['amount'] = $payment_amount_in_minor_units;
		$post_data['currency'] = $currency_no;
		
		$orderid = $model->randomPassword();
		$post_data['orderid'] = $orderid;
		
		$post_data['accepturl'] = 'http://panel.cuecow.com/index.php/user/changecardaccepted/subscription_type/'.$UserInfo[0]['subscriptionType'];
		$post_data['callbackurl'] = 'http://panel.cuecow.com/index.php/user/paycallback';
		
		$post_data['language'] = "2";
		$post_data['instantcapture'] = "1";
		
		$this->render('redirect',array('model'=>$model,'post_data'=>$post_data));
	}
	
	public function actionUpgrade()
	{
		$model = new AccountForm;

		$UserInfo = User::model()->GetRecord();
		
		$SubscriptionInfo = SubsriptionType::model()->GetSpecificRec($_REQUEST['id']);
						
		//$epay_merchant_number = '8010148';
		$epay_merchant_number = '5732417';
		
		$currency_no = 208;
		$epay_url = 'https://ssl.ditonlinebetalingssystem.dk/popup/default.asp';
		
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
		
		$post_data['accepturl'] = 'http://panel.cuecow.com/index.php/user/payaccepted/subscription_type/'.$SubscriptionInfo[0]['name'];
		$post_data['callbackurl'] = 'http://panel.cuecow.com/index.php/user/paycallback';
		
		$post_data['language'] = "2";
		$post_data['instantcapture'] = "1";
		
		$this->render('redirect',array('model'=>$model,'post_data'=>$post_data));
	}
	
	public function actionChangecardaccepted()
	{	
		$model = new AccountForm;
		
		$model_login = new LoginForm;
		
		$params = $_GET;
		$subscription_type = $_GET['subscription_type'];
		
		$var = "";
		
		foreach ($params as $key => $value)
		{
			if($key != "hash" && $key != 'subscription_type')
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
			$transid = $_GET['txnid'];
			$orderid = $_GET['orderid'];
			$transfee = $_GET['txnfee'];
			$total_amount = $_GET['amount']/100;
			$cur = $_GET['currency'];
			$date = $_GET['date'];
			$time = $_GET['time'];
			$userId = Yii::app()->user->user_id;
			
			$model->SaveTransactionChangeCard($subscriptionid,$transid,$orderid,$transfee,$total_amount,$cur,$date,$time,$userId);
		}
		
		$this->redirect(array('user/profile/view/password'));
	}
	
	public function actionPayaccepted()
	{
		print_r($_REQUEST);
		exit;
		
		$model = new AccountForm;
		
		$model_login = new LoginForm;
		
		$params = $_GET;
		$subscription_type = $_GET['subscription_type'];
		
		$var = "";
		
		foreach ($params as $key => $value)
		{
			if($key != "hash" && $key != 'subscription_type')
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
			
			$user_id = Yii::app()->user->user_id;
			
			$UserInfo = User::model()->GetOffRecord($user_id);
								
			if(!empty($user_id))
			{
				//save next billing date
				
				User::model()->UpdateSubscriptionValidTo($user_id);
				User::model()->UpdateSubscriptionType($user_id, $subscription_type);
				
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
			}
		}
		
		$this->redirect(array('user/profile/view/changesubscription'));
	}
	
	public function actionStatistics()
	{
		$this->render('statistics');
	}
	
	public function actionAuthMeida()
	{
		if($_REQUEST['auth']=='facebook')
		{
			$app_id = "452837591443453";
			$app_secret = "30f979ecc99c77764c13920446baf33a";
			
			$red_uri = "http://panel.cuecow.com/index.php/user/authmeida/auth/facebook";
											
			$code = $_REQUEST["code"];
			
			if(empty($code)) 
			{
				$dialog_url = "https://www.facebook.com/dialog/oauth?client_id=". $app_id ."&redirect_uri=". urlencode($red_uri)."&scope=manage_pages,offline_access,publish_stream,read_insights,read_stream";
				
				echo '<script>top.location.href="' . $dialog_url . '";</script>';
				
				exit;
			} 
			else 
			{
				$token_url = "https://graph.facebook.com/oauth/access_token?client_id=". $app_id . "&redirect_uri=" . urlencode($red_uri). "&client_secret=" . $app_secret. "&code=" . $code;
				
				$access_token = @file_get_contents($token_url);

				if($access_token)
				{
					$uid_url = "https://graph.facebook.com/me?" . $access_token;
					$uid_respns = json_decode(@file_get_contents($uid_url));
					$fbuid = $uid_respns->id;
					
					$store_fbuid = AccessToken::model()->StoreFBUID($fbuid);
					
					$accounts_url = "https://graph.facebook.com/me/accounts?".$access_token;
					$response = @file_get_contents($accounts_url);
				
					// Parse the return value and get the array of accounts we have
					// access to. This is returned in the data[] array. 
					$resp_obj = json_decode($response,true);
					$accounts = $resp_obj['data'];
					
					$GetLimitUsers = User::model()->ValidateLimits();
					
					$h = 1;
					
					foreach($accounts as $account)
					{
						$name = $account['name'];
						$access_token_page = $account['access_token'];
						$pageid = $account['id'];
						
						$page_url = "https://graph.facebook.com/?" . $pageid;
						$page_url_res = json_decode(@file_get_contents($page_url));
						$page_url = $page_url_res->link;
						$fans = $page_url_res->likes;
						
						$CountUserPages = Fbpages::model()->CountUserPages();
						
						if($h <= $GetLimitUsers[0]['max_num_walls'])
							$status = 'active';
						else
							$status = 'blocked';
						
						$store_page_token = AccessToken::model()->StorePageAccessToken($name,$access_token_page,$pageid);
						$store_page_user  = Fbpages::model()->StoreUserPages($name,$pageid,$page_url,$status,$fans);
						
						$h++;
					}
					
					$store_tokendata = AccessToken::model()->StoreAccessToken(str_replace('access_token=','',$access_token),'fbtoken');
					
					if( ($h-1) > $GetLimitUsers[0]['max_num_walls'] )
						$this->redirect(array('user/profile/view/selwall'));
					else
						$this->redirect(array('user/profile/view/medias'));
				}
			}
		}
		else if($_REQUEST['auth']=='foursquare')
		{
			//$clientId = 'QUNRJJX1Q1C4AODDII5EQQBMUKBYZ1JYLOYT4TLBH3QCM2AT';
			//$clientSecret = 'YB1ADWVERZFETX5QVDGRU0NQJ5BA5JVZC12FD243WF5MSGQV';
			
			$clientId = '4Z42GIT2XAIR4LKEVSZFLYNYFAZLS34VCS2EOEJFAIM4TSX2';
			$clientSecret = '0HZ3JHMSFTKRXWOLGITBJJPXSE0JSLWK0BW3OQLYZNYD5FXD';
				
			$redirectUri = "http://panel.cuecow.com/index.php/user/authmeida/auth/foursquare";
			
			$code = $_REQUEST["code"];
					
			if(empty($code)) 
			{
				$auth_url='https://foursquare.com/oauth2/authenticate?client_id='.$clientId.'&response_type=code&redirect_uri='.$redirectUri;
				
				?><script>window.location.href="<?php echo $auth_url; ?>";</script><?php
				exit;
			} 
			else 
			{
				$token_url = 'https://foursquare.com/oauth2/access_token?client_id='.$clientId.'&client_secret='.$clientSecret.'&grant_type=authorization_code&redirect_uri='.$redirectUri.'&code='.$code;
						
				$access_token = file_get_contents($token_url);
				$json_token=json_decode($access_token);
				$accessToken = $json_token->access_token;
						
				if($accessToken)
				{
					$store_tokendata=AccessToken::model()->StoreAccessToken($accessToken,'fstoken');
					$this->redirect(array('user/profile/view/medias'));
				}
			}
		}
		
		if($_REQUEST['auth'] == 'twitter')
		{
			require("twitter/twitteroauth.php");
			
			if( $_REQUEST['view'] == 'auth' )
			{
				$twitteroauth = new TwitterOAuth($twitter_consumer_key, $twitter_consumer_secret, Yii::app()->session['oauth_token'], Yii::app()->session['oauth_token_secret']);
			
				$access_token_twiter = $twitteroauth->getAccessToken(array('oauth_verifier' => $_GET['oauth_verifier'] ));	
				
				if(  $access_token_twiter['oauth_token'] != '' && $access_token_twiter['oauth_token_secret'] != '' )
				{	
					$store_tokendata = AccessToken::model()->StoreTwitterAccessToken($access_token_twiter['oauth_token'],$access_token_twiter['oauth_token_secret']);
					
					$this->redirect(array('user/profile/view/medias'));
				}
			}
			
			$twitteroauth = new TwitterOAuth($twitter_consumer_key, $twitter_consumer_secret);
			
			$request_token = $twitteroauth->getRequestToken('http://panel.cuecow.com/index.php/user/authmeida/auth/twitter/view/auth');
			
			Yii::app()->session['oauth_token'] = $request_token['oauth_token'];
			Yii::app()->session['oauth_token_secret'] = $request_token['oauth_token_secret'];
			
			if($twitteroauth->http_code==200)
			{
				$url = $twitteroauth->getAuthorizeURL($request_token['oauth_token']);
				header('Location: '. $url);
				exit;
			} 
			else 
			{
				die('Something wrong happened.');
			}
		}
		
		$this->redirect(array('user/profile/view/medias'));
	}
	
	public function actionCampaign()
	{
		$model = new Campaign;
		
		if($_REQUEST['act']=='del' && !empty($_REQUEST['id']) && is_numeric($_REQUEST['id']))
		{
			//retire foursquare special
			
			$campaign = $model->GetCampaign($_REQUEST['id']);
			
			if(count($campaign) && $campaign[0]['foursquare_specials'] == 'yes')
			{
				$campaign_id = $campaign[0]['campaign_id'];	
				$userid = $campaign[0]['userid'];	
				
				$FSCamapign = $model->GetPendingFSCamp($campaign_id);
				
				if(count($FSCamapign))
				{
					$special_id = $FSCamapign[0]['special'];
					
					if($special_id)
					{
						$token_data = Cron::model()->CronUserAccessToken($userid);
						
						if(count($token_data))
						{
							$store_token = $token_data['fstoken'];
						
							if(!empty($store_token))
							{
								if(strstr($special_id,','))
								{
									$spec_exp = explode(',',$special_id);
									
									if(count($spec_exp))
									{
										foreach( $spec_exp as $spec_val )	
										{
											$url = 'https://api.foursquare.com/v2/specials/'.$spec_val.'/retire?oauth_token='.$store_token.'&v='.date('Ymd'); 
												
											$ch = curl_init(); 
											curl_setopt($ch, CURLOPT_URL,$url);
											curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
											curl_setopt($ch, CURLOPT_POST, 1);
											curl_setopt($ch, CURLOPT_POSTFIELDS, '');
											curl_setopt($ch, CURLOPT_HEADER, 1);
											curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
											
											$result_fs = curl_exec($ch);
											
											curl_close($ch); 
										}
									}
								}
								else
								{
									$url = 'https://api.foursquare.com/v2/specials/'.$special_id.'/retire?oauth_token='.$store_token.'&v='.date('Ymd'); 
													
									$ch = curl_init(); 
									curl_setopt($ch, CURLOPT_URL,$url);
									curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
									curl_setopt($ch, CURLOPT_POST, 1);
									curl_setopt($ch, CURLOPT_POSTFIELDS, '');
									curl_setopt($ch, CURLOPT_HEADER, 1);
									curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
									
									$result_fs = curl_exec($ch);
									
									curl_close($ch); 
								}
							}
						}
					}
				}
			}
			
			if($campaign[0]['twitter'] == 'yes')
			{
				$campaign_id = $campaign[0]['campaign_id'];	
				$CheckPost = CampaignTwitter::model()->GetSpecificPost($campaign_id);
				
				if( count($CheckPost) )
					CampaignTwitter::model()->DeletePost($campaign_id);
			}
			
			if(count($campaign) && $campaign[0]['fb_posts'] == 'yes')
			{
				$campaign_id 	= $campaign[0]['campaign_id'];	
				$userid 		= $campaign[0]['userid'];	
				
				$FBPost = Cron::model()->CronCampFBPost($campaign_id);
				
				if( count($FBPost) )
				{
					$token_data = Cron::model()->CronUserAccessToken($userid);
							
					if(count($token_data))
					{
						$store_token = $token_data['fbtoken'];
						
						$url = 'https://graph.facebook.com/'.$FBPost[0]['posted_id'].'?access_token='.$store_token; 
														
						$ch = curl_init(); 
						curl_setopt($ch, CURLOPT_URL,$url);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
						curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
						curl_setopt($ch, CURLOPT_HEADER, 1);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
						
						$result_fs = curl_exec($ch);
						
						curl_close($ch); 
					}
				}
			}
			
			$delcampaign = Campaign::model()->DeleteCampaign($_REQUEST['id']);
			$this->redirect(array('user/campaign'));
			
			exit;	
		}
		
		if(isset($_REQUEST['lastid']))	
		{	
			//validate maximum campaigns
			
			$GetLimitUsers = User::model()->ValidateLimits();
			$CountUserCampaign = $model->CountUserCampaign();
			
			if($GetLimitUsers[0]['max_num_campaigns'] <= $CountUserCampaign && Yii::app()->user->user_id!=1)
			{
				$delcampaign = Campaign::model()->DeleteCampaign($_REQUEST['lastid']);
				$this->redirect(array('user/campaign/msg/maxerr'));
			}
			
			$GetRec=Campaign::model()->GetCampaign($_REQUEST['lastid']);
			
			if($GetRec[0]['foursquare_specials']=='yes')
			{
				$clientId = 'QUNRJJX1Q1C4AODDII5EQQBMUKBYZ1JYLOYT4TLBH3QCM2AT';
				$clientSecret = 'YB1ADWVERZFETX5QVDGRU0NQJ5BA5JVZC12FD243WF5MSGQV';
				
				$tokendata=FsSpecial::model()->ExistToken();
			
				if(count($tokendata)==0)
				{
					$redirectUri = 'http://panel.cuecow.com/index.php/user/campaign/lastid/'.$_REQUEST['lastid'];
					
					$code = $_REQUEST["code"];
					
					if(empty($code)) 
					{
						$auth_url='https://foursquare.com/oauth2/authenticate?client_id='.$clientId.'&response_type=code&redirect_uri='.$redirectUri;
						echo('<script>top.location.href="' . $auth_url . '";</script>');
					} 
					else 
					{
						$token_url='https://foursquare.com/oauth2/access_token?client_id='.$clientId.'&client_secret='.$clientSecret.'&grant_type=authorization_code&redirect_uri='.$redirectUri.'&code='.$code;
						
						$access_token = file_get_contents($token_url);
						$json_token=json_decode($access_token);
						$accessToken = $json_token->access_token;
						
						if($accessToken)
						{
							$save_token=FsSpecial::model()->InsertToken($accessToken);	
							$store_token=$accessToken;
						}
					}
				}
				else
				{
					$store_token=$tokendata[0]['token'];	
				}
				
				$pick_rec=FsSpecial::model()->PickRecord($_REQUEST['lastid']);	

				if($pick_rec[0]['status']=='pending')
				{
					$message='';
					
					if(!empty($pick_rec[0]['campaign_name']))
						$message .='name='.$pick_rec[0]['campaign_name'];
					if(!empty($pick_rec[0]['unlockedText']))
						$message .='&text='.$pick_rec[0]['unlockedText'];
					if(!empty($pick_rec[0]['finePrint']))
						$message .='&finePrint='.$pick_rec[0]['finePrint'];
					if(!empty($pick_rec[0]['count1']))
						$message .='&count1='.$pick_rec[0]['count1'];
					if(!empty($pick_rec[0]['count2']))
						$message .='&count2='.$pick_rec[0]['count2'];
					if(!empty($pick_rec[0]['count3']))
						$message .='&count3='.$pick_rec[0]['count3'];
					if(!empty($pick_rec[0]['sp_type']))
						$message .='&type='.$pick_rec[0]['sp_type'];
					if(!empty($pick_rec[0]['cost']))
						$message .='&cost='.$pick_rec[0]['cost'];
						
					$message .='&offerId=5000000';
					
					$url = 'https://api.foursquare.com/v2/specials/add?oauth_token='.$store_token.'&v='.date('Ymd'); 
		
					$ch = curl_init(); 
					curl_setopt($ch, CURLOPT_URL,$url);
					curl_setopt($ch, CURLOPT_FAILONERROR, 1); 
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
					curl_setopt($ch, CURLOPT_TIMEOUT, 0);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
					curl_setopt($ch, CURLOPT_VERBOSE, 1); 
					curl_setopt($ch, CURLOPT_HEADER, 1);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_COOKIEFILE, 1);  
					$result = curl_exec($ch);
					
					curl_close($ch); 
						
					if($result)
					{
						$UpdateRec=FsSpecial::model()->UpdateSpecial($_REQUEST['lastid']);				
					}
					else
					{
						$del_prev_token=FsSpecial::model()->DeleteToken();	
						echo('<script>top.location.href="' . $auth_url . '";</script>');	
					}
				}
			}
			
			$this->redirect(array('user/campaign'));
		}
		
		// Get Page Title
		$PageTitle = GetPageSubTitle($_SERVER['PATH_INFO'],$_REQUEST['view']);
		
		$this->render('campaign',array(
			'model'=>$model,
			'PageTitle'=>$PageTitle,
		));
	}
	
	public function actionFacebook()
	{
		$model = new Fbpages;
		
		$records = $model->GetPages();
		
		$app_id = "175992059155083";
		$app_secret = "bc3faf697da4f6a13dac4dfe16357df2";
		
		if($_REQUEST['lastid'])
		{
			$ExistRecord = $model->GetPage($_REQUEST['lastid']);
			$page_id = $ExistRecord[0]['page_id'];
		}
		else
		{
			$page_id = $_REQUEST['page_id'];
		}
	
		if($page_id)
		{
			$token_cntnr = AccessToken::model()->PageAuth($page_id);
			
			if($token_cntnr[0]['token'])
			{
				$app_id = '337597619588022';
				$page_access_token = $token_cntnr[0]['token'];
			  
				if($page_access_token)
				{
					$page_settings_url = "https://graph.facebook.com/" .$page_id . "/settings?access_token=" . $page_access_token;
					$response = file_get_contents($page_settings_url);
					$resp_obj = json_decode($response,true);
				  
					$add_tab = "https://graph.facebook.com/" .$page_id . "/tabs?app_id=" .$app_id. "&method=POST&access_token=" . $page_access_token;
					$reult = file_get_contents($add_tab);
					$resp_object = json_decode($reult,true);
				}
				else
				{
					$auth_page=1;
				}
			}
		}
		
		if($_REQUEST['lastid']!='')
			$this->redirect(array('facebook'));
		
		
		if(isset($_POST['Fbpages']))
		{
			$model->attributes = $_POST['Fbpages'];
			
			if($model->validate())
			{
				$strfburl=$_POST['Fbpages']['page_id'];
				$sfb=explode("/",$strfburl);
					
				$id_page=$sfb[count($sfb)-1];

				$contents = json_decode(file_get_contents('https://graph.facebook.com/'.trim($id_page)));
				
				if($contents->id)
				{				
					$id = $contents->id;
					
					$ExistRecord = $model->GetPagesExistId($id);
					
					if($ExistRecord==0)
					{
						$ExistPage = $model->GetPagesExist();
						
						if($ExistPage)
							$model->status = 'blocked';
						else
							$model->status = 'active';
						
						$model->user_id = Yii::app()->user->user_id;
						$model->page_id = $id;
						$model->page_url = $_POST['Fbpages']['page_id'];
						$model->page_name = $contents->name;
						
						$model->save();
						{
							$this->redirect(array('facebook','lastid'=>$model->id));
						}
					}
					else
					{
						$model->addError('page_id','This Page\'s record already exists.');
					}
				}
				else
					$model->addError('page_id','We could not picked up id of this page. Please try again.');
			}
		}
		
		if($_REQUEST['view']=='View')
		{
			$spec_rec=$model->GetPage($_REQUEST['id']);
		}
		
		$GetLimitUsers = User::model()->ValidateLimits();
		$CountUserPages = Fbpages::model()->CountUserPages();
		$UserSetPages = Fbpages::model()->GetUserSetPages();
		
		if($CountUserPages > $GetLimitUsers[0]['max_num_walls'] && count($UserSetPages)==0)
			$show_choose_message = 'yes';
		else
			$show_choose_message = 'no';
		
		
		$this->render('facebook',array(
			'model'=>$model,'records'=>$records ,
			'spec_rec'=>$spec_rec ,
			'show_choose_message'=>$show_choose_message,
			'PageTitle'=>$PageTitle,
		));
	}
	
	public function actionTwitter()
	{
		require("twitter/twitteroauth.php");
		
		$error = 0;
		$model = new AccessToken;
		
		$token = $model->GetUserTokenRecord(Yii::app()->user->user_id);

		$data = array();
		
		if( $token[0]['twitter_oauth_token'] != '' &&  $token[0]['twitter_oauth_token_secret'] != '')
		{
			$data['twitter_oauth_token'] = $token[0]['twitter_oauth_token'];
			$data['twitter_oauth_token_secret'] = $token[0]['twitter_oauth_token_secret'];
			$show_form = true;
		}
		else
			$show_form = false;
		
		if( isset($_POST['twitter_submit']) && $_POST['twitter_submit'] == 'done')
		{
			if( $_POST['textmsg'] != '' )
			{
				$twitteroauth = new TwitterOAuth($twitter_consumer_key, $twitter_consumer_secret, $data['twitter_oauth_token'], $data['twitter_oauth_token_secret']);
				
				$message = $_POST['textmsg'];
				$post_tweet = $twitteroauth->post('statuses/update', array('status' => $message));
				
				$post_id = $post_tweet->id_str;
				
				if( $post_id != '' )
				{
					$tweet = array();
					
					$tweet['user_id'] 	= Yii::app()->user->user_id;
					$tweet['message'] 	= $message;
					$tweet['post_id'] 	= $post_id;
					$tweet['dated'] 	= strtotime(now);
					
					Twitter::model()->SaveTweet($tweet);
					
					$msg = 'Message posted to twitter';
					$error = 0;
				}
				else
				{
					$msg = 'Please try again.';
					$error = 1;
				}
			}
			else
			{
				$msg = 'Please enter message to post';
				$error = 1;
			}
		}
		
		$this->render('twitter',array(
			'model' => $model,
			'msg' => $msg,
			'error' => $error,
			'show_form' => $show_form,
		));
	}
	
	public function actionFbposts()
	{
		$model = new Fbposts;
		
		if($_REQUEST['view']=='edit')
			$edit_post 	= $model->EditFBPost($_REQUEST['id']);
		
		$validate 		= 0;
		$url 			= "";
		$msg 			= "";
		$rb 			= 0;
		$spost 			= 0;
		$content 		= "";
		$schedulepost 	= "no";
		
		if(isset($_POST['Fbposts']))
		{	
			if(empty($_POST['groups']) && empty($_POST['page']))
			{
				$model->addError('url_link','Please select one out of groups and pages.');
				$validate++;
			}
			
			if(empty($_POST['textmsg']))
			{
				$model->addError('message','Message can not be blank');
				$validate++;
				$rb=3;
			}
			
			$url 				= 	$_POST['link_get'];
			$msg 				= 	$_POST['textmsg'];
			$link_title 		= 	$_POST['link_title'];
			$link_description 	= 	$_POST['link_description'];
			$post_date 			= 	$_POST['post_date'];
			$post_time 			= 	$_POST['post_time'];
			$post_zone 			= 	$_POST['timezone'];
			$email_notify 		= 	$_POST['email_notify'];
			$page_id 			= 	$_POST['page'];
			$group_id 			= 	$_POST['groups'];
			
			if($_POST['post_to']=="nothing")
				$content_type = "text";
			else if($_POST['post_to']=="photos")
				$content_type = "photo";
			else if($_POST['post_to']=="videos")
				$content_type = "video";
			
			if($validate==0)
			{
				if($_REQUEST['view']=='edit')
					$delete_post	 	= $model->DeleteFBPost($_POST['post_id']);
				
				$model->user_id			=	Yii::app()->user->user_id;
				$model->name			=	$_POST['Fbposts']['name'];
				$model->page_id			=	$page_id;
				$model->group_id		=	$group_id;
				$model->content_type	=	$content_type;
				$model->url_link		=	$url;
				$model->message			=	$msg;
				$model->post_zone		=	$post_zone;
				
				$model->title			=	$link_title;
				$model->description		=	$link_description;
				
				$model->post_date		=	$_POST['Fbposts']['post_date'];
				$model->post_time		=	$_POST['Fbposts']['post_time'];
				$model->status			=	'pending';
				$model->email_notify	=	$_POST['Fbposts']['email_notify'];
				
				if($content_type=='photo' && $_FILES['Fbposts']['name']['photo'])
				{
					$model->photo=CUploadedFile::getInstance($model,'photo');
					$model->photo->saveAs(Yii::getPathOfAlias('webroot').'/images/fbposts/'.$model->photo);
				}
				else if($content_type=='photo' && $_FILES['Fbposts']['name']['photo'] == '')
				{
					$model->photo		=	$_POST['prev_pic'];
				}
				else if($content_type=='video' && $_FILES['Fbposts']['name']['video'])
				{
					$model->video=CUploadedFile::getInstance($model,'video');
					$model->video->saveAs(Yii::getPathOfAlias('webroot').'/images/fbposts/'.$model->video);
				}
				else if($_POST['current_pic_src'] && !isset($_POST['no_thumb']))
				{
					$model->photo =	$_POST['current_pic_src'];
				}
				
				if($model->save())
				{
					if($_REQUEST['view']=='edit')
						$this->redirect(array('user/facebook/view/Manage'));
					else
						$this->redirect(array('user/facebook/view/Manage'));
				}
			}
		}
		
		$GetLimitUsers = User::model()->ValidateLimits();
		$CountUserPages = Fbpages::model()->CountUserPages();
		$UserSetPages = Fbpages::model()->GetUserSetPages();
		
		if($CountUserPages > $GetLimitUsers[0]['max_num_walls'] && count($UserSetPages)==0)
			$show_choose_message = 'yes';
		else
			$show_choose_message = 'no';
		
		// Get Page Title
		$PageTitle = GetPageSubTitle($_SERVER['PATH_INFO'],$_REQUEST['view']);
		
		$this->render('fbposts',array(
			'model'=>$model,
			'rb'=>$rb,
			'spost'=>$spost,
			'edit_post'=>$edit_post,
			'show_choose_message'=>$show_choose_message,
			'PageTitle'=>$PageTitle,
		));
	}
	
	public function actionselectfbpages()
	{
		$this->redirect(array('user/profile/view/selwall'));
		exit;
		
		$model = new Fbpages;
		$err_msg = '';
		
		$GetLimitUsers = User::model()->ValidateLimits();
		$MaxWalls = $GetLimitUsers[0]['max_num_walls'];
		
		if($_POST)
		{	
			if(count($_POST['fbpages'])>$MaxWalls)
			{
				$err_msg = 'You can not choose more than '.$MaxWalls.' pages.';	
			}
			else if(count($_POST['fbpages'])<=$MaxWalls)
			{
				$model->SetAllPageBlocked();
				
				foreach($_POST['fbpages'] as $fbpage)
					$model->UpdatepageStatus('active',$fbpage);
				
				$model->InsertSetBy();
				
				$this->redirect(array('user/facebook/view/Manage'));
			}			
		}
		
		$CheckIfAlreadySet = $model->GetUserSetPages();
		
		$allpages = $model->GetAllPages();
		
		if(count($CheckIfAlreadySet))
		{	
			if(count($allpages) < $MaxWalls)
				$show_message = 'no';
			else
				$show_message = 'yes';
		}
		else
		{
			$show_message = 'no';
		}
			
		$this->render('selectfbpages',array('model'=>$model,'show_message'=>$show_message,'allpages'=>$allpages,'err_msg'=>$err_msg));
	}
	
	public function actionEditfacebook($id)
	{
		$model=Fbpages::model()->findByPk($id);
		
		if(isset($_POST['Fbpages']))
		{
			$strfburl=$_POST['Fbpages']['page_url'];
			
			$sfb=explode("/",$strfburl);
					
			$id_page=$sfb[count($sfb)-1];
				
			$contents = json_decode(@file_get_contents('http://graph.facebook.com/'.$id_page));
			
			if($contents->id)
			{				
				$id = $contents->id;
		
				$model->page_url = $_POST['Fbpages']['page_url'];

				$model->page_name = $_POST['Fbpages']['page_name'];
				$model->page_id = $id;
				$model->for_public = $_POST['Fbpages']['for_public'];
				$model->for_fan = $_POST['Fbpages']['for_fan'];
				
				if($model->validate())
				{
					$model->save();
						$this->redirect(array('user/facebook/lastid/'.$model->id));
				}
			}
		}
		
		$this->render('editfacebook',array('model'=>$model));
	}
	
	public function actionDeletefacebook($id)
	{
		$model=Fbpages::model()->findByPk($id)->delete();
		
		// Update locations in group
		$UserGroups = LocationGroup::model()->AllGroups();
		
		if(count($UserGroups))
		{
			foreach($UserGroups as $key=>$value)	
			{
				$temp_fbpages = explode(',',$value['fbpages']);
				
				if(count($temp_fbpages))
				{
					$new_fbpages = '';
					
					foreach($temp_fbpages as $pages_key=>$pages_value)
					{
						if(!empty($pages_value))
						{
							$CheckFBPages = LocationGroup::model()->GetSpecPage($pages_value);
							
							if(count($CheckFBPages))
							{
								$new_fbpages .= $pages_value.',';
							}
						}
					}
					
					$UpdateNewPages = LocationGroup::model()->UpdatePagesGroup($value['group_id'],substr($new_fbpages,0,-1));
				}
			}
		}
		
		$this->redirect(array('user/facebook'));
	}
	
	public function actionDelpost($id)
	{
		$model=new Fbposts;
		
		$info=$model->GetPostInfo($id);
		$page_id=$info[0]['page_id'];
		
		if($info[0]['content']=='text')
		{
			$model=Fbposts::model()->findByPk($id)->delete();
		}
		else
		{
			if($info[0]['content_type']=='photo')
			{
				$file_name=$info[0]['photo'];
				$file_path=Yii::getPathOfAlias('webroot').'/images/fbposts/'.$file_name;
			}
			else if($info[0]['content_type']=='video')
			{
				$file_name=$info[0]['video'];
				$file_path=Yii::getPathOfAlias('webroot').'/images/fbposts/'.$file_name;
			}
			
			if(file_exists($file_path))
				unlink($file_path);
			
			$model=Fbposts::model()->findByPk($id)->delete();
		}
		
		$this->redirect(array('user/facebook/view/Manage/'));
	}
	
	public function actionDeleteuser()
	{
		$model = new User;
		
		if(!empty($_REQUEST['user_id']))
			$DelUser = $model->DeleteUser($_REQUEST['user_id']);
		
		$this->redirect(array('usermanagement/view/List'));
		
	}
	
	public function actionUpdateUser($user_id)
	{
		$model = User::model()->findByPk($user_id);
		$subscription_model = SubsriptionType::model()->GetAllRec();
		$subscription_array = array();
		
		if( count($subscription_model) )
		{
			foreach( $subscription_model as $keys => $values )	
				$subscription_array[$values['name']] = $values['name'];
		}
		
		$validate = 0;
		
		if(isset($_POST['User']))
		{
			if(empty($_POST['User']['fname']))
			{
				$model->addError('fname','First Name can not be blank');
				$validate++;
			}
			if(empty($_POST['User']['lname']))
			{
				$model->addError('lname','Last Name can not be blank');
				$validate++;
			}
			
			if($validate==0)
			{
				$model->fname 				= 	$_POST['User']['fname'];
				$model->lname 				= 	$_POST['User']['lname'];
				$model->address 			= 	$_POST['User']['address'];
				$model->company 			= 	$_POST['User']['company'];
				$model->city 				= 	$_POST['User']['city'];
				$model->postal_code 		= 	$_POST['User']['postal_code'];
				$model->subscriptionType	=	$_POST['User']['subscriptionType'];
				$model->subscriptionValidTo =	$_POST['User']['subscriptionValidTo'];
				$model->country 			= 	$_POST['User']['country'];
				$model->phone 				= 	$_POST['User']['phone'];
				$model->timestamp			= 	$_POST['User']['timestamp'];
				$model->next_payment		= 	$_POST['User']['next_payment'];
				
				$model->save();
					
				$this->redirect(array('user/usermanagement/view/List'));
			}
		}
		
		// Get Page Title
		$PageTitle = GetPageSubTitle($_SERVER['PATH_INFO'],$_REQUEST['view']);
		
		//Get current subscription detail
		//$SubscriptionDetail = SubsriptionType::model()->GetSpecificRecbyName($model->subscriptionType);
		$SubscriptionDetail = AccountForm::model()->GetTransactionInfo('user_id',$_REQUEST['user_id']);
		
		$this->render('updateuser',array('model'=>$model,'validate'=>$validate,'view'=>$_REQUEST['view'],'user_id'=>$_REQUEST['user_id'],'PageTitle'=>$PageTitle,'SubscriptionDetail'=>$SubscriptionDetail,'subscription_array'=>$subscription_array));
		
	}
	
	public function actionUsermanagement()
	{	
		$model = new User;
		
		if($_REQUEST['view'] == 'Kreditnota')
		{
			$invoice_info = AccountForm::model()->GetTransactionInfo('id',$_REQUEST['inv']);
				
			if(count($invoice_info[0]))
			{
				$kredit = array();
				if(count($invoice_info))
				{
					$kredit['tid'] 				= $invoice_info[0]['tid'];
					$kredit['orderid'] 			= $invoice_info[0]['orderid'];
					$kredit['amount'] 			= -$invoice_info[0]['amount'];
					$kredit['tax'] 				= -$invoice_info[0]['tax'];
					$kredit['total_amount'] 	= -$invoice_info[0]['total_amount'];
					$kredit['cur'] 				= $invoice_info[0]['cur'];
					$kredit['date'] 			= $invoice_info[0]['date'];
					$kredit['time'] 			= $invoice_info[0]['time'];
					$kredit['subscriptionid'] 	= $invoice_info[0]['subscriptionid'];
					$kredit['transfee'] 		= $invoice_info[0]['transfee'];
					$kredit['user_id'] 			= $invoice_info[0]['user_id'];
					$kredit['account_name'] 	= $invoice_info[0]['account_name'];
					$kredit['email'] 			= $invoice_info[0]['email'];
					$kredit['username'] 		= $invoice_info[0]['username'];
					$kredit['fname'] 			= $invoice_info[0]['fname'];
					$kredit['lname'] 			= $invoice_info[0]['lname'];
					$kredit['phone'] 			= $invoice_info[0]['phone'];
					$kredit['company'] 			= $invoice_info[0]['company'];
					$kredit['address'] 			= $invoice_info[0]['address'];
					$kredit['postal_code'] 		= $invoice_info[0]['postal_code'];
					$kredit['city'] 			= $invoice_info[0]['city'];
					$kredit['country'] 			= $invoice_info[0]['country'];
					$kredit['planid'] 			= $invoice_info[0]['planid'];
					$kredit['kreditnota_for_id']= $_REQUEST['inv'];
					$kredit['status'] 			= $invoice_info[0]['status'];

					$DuplicateRecord = AccountForm::model()->KreditNota($kredit);
					$UpdatePrev = AccountForm::model()->UpdateCreditMain($_REQUEST['inv']);
					
					$this->redirect(array('user/usermanagement/view/invoices'));
				}
			}
		}
		
		if($_REQUEST['view'] == 'detail_invoice')
		{
			$Transaction = AccountForm::model()->GetTransactionInfo('id',$_REQUEST['inv']);
			
			if(count($Transaction))
			{
				$record_to_show = '';
				
				$GetUser = User::model()->GetOffRecord($Transaction[0]['user_id']);
				
				if($Transaction[0]['date'])
					$TransactionDate = substr($Transaction[0]['date'], 0, 4).'-'.substr($Transaction[0]['date'], 4, 2).'-'.substr($Transaction[0]['date'], 6, 2);
				
				if(!empty($GetUser[0]['fname']))
					$username = $GetUser[0]['fname'].' '.$GetUser[0]['lname'];
				else if(!empty($GetUser[0]['account_name']))
					$username = $GetUser[0]['account_name'];
				else if($GetUser[0]['username'])
					$username = $GetUser[0]['username'];
								
				$address = '';
				
				if($Transaction[0]['amount']<0)
					$mailcontent = file_get_contents('http://panel.cuecow.com/invoice/kreditnota.html');
				else
					$mailcontent = file_get_contents('http://panel.cuecow.com/invoice/invoice.html');
				
				if(!empty($username))
					$address .= $username.'<br />';
				if(!empty($GetUser[0]['company']))
					$address .= $GetUser[0]['company'].'<br />';
				if(!empty($GetUser[0]['address']))
					$address .= $GetUser[0]['address'].'<br />';
				if(!empty($GetUser[0]['postal_code']))
					$address .= $GetUser[0]['postal_code'].' ';
				if(!empty($GetUser[0]['city']))
					$address .= $GetUser[0]['city'].'<br />';
				if(!empty($GetUser[0]['country']))
					$address .= $GetUser[0]['country'].'<br />';
				
				$mailcontent = str_replace('[ADDRESS]',$address,$mailcontent);
				$mailcontent = str_replace('[INVOICE_ID]',date('y').'-'.$Transaction[0]['id'],$mailcontent);
				$mailcontent = str_replace('[PAYMENT_DATE]',$TransactionDate,$mailcontent);
				$mailcontent = str_replace('[SUBSCRIPTION_LIMIT]',$TransactionDate.' to '.$GetUser[0]['subscriptionValidTo'],$mailcontent);
				$mailcontent = str_replace('[TOTAL_AMOUNT]',number_format($Transaction[0]['amount'],2,',','.').' DKK',$mailcontent);
				
				$mailcontent = str_replace('[TAX]',number_format($Transaction[0]['tax'],2,',','.'),$mailcontent);			
				$mailcontent = str_replace('[GRAND_TOTAL]',number_format($Transaction[0]['total_amount'],2,',','.').' DKK',$mailcontent);			
				
				$pdf_name = 'Cuecow Invoice '.date('y').'_'.$Transaction[0]['id'].'.pdf';
				
				if(!file_exists(dirname(__FILE__).'/../../pdf/'.$pdf_name))
				{
					$mPDF1 = Yii::app()->ePdf->mpdf();
					$mPDF1->WriteHTML($mailcontent);
					$mPDF1->Output(dirname(__FILE__).'/../../pdf/'.$pdf_name, EYiiPdf::OUTPUT_TO_FILE);	
				}
				
				echo '<script>window.location.href="http://panel.cuecow.com/pdf/'.$pdf_name.'"</script>';
				
			}
		}	
		
		if($_REQUEST['view'] == 'kreditnota')
			$trans_info = AccountForm::model()->GetTransactionInfo('id',$_REQUEST['inv']);
		
		$this->render('usermanagement',array('model'=>$model,'validate'=>$validate,'address'=>$address,'username'=>$username,'invoice_id'=>$invoice_id,'payment_date'=>$payment_date,'subscription_limit'=>$subscription_limit,'total_amount'=>$total_amount,'trans_info'=>$trans_info,'PageTitle'=>$PageTitle,'kredinota_validate'=>$kredinota_validate));
		
	}
	
	public function actionSimulateuser($user_id)
	{
		$model = new User();
		
		if(!isset(Yii::app()->user->prev_user_id) || Yii::app()->user->prev_user_id == '')
		{
			Yii::app()->user->setState('prev_user_id', Yii::app()->user->user_id);
			Yii::app()->user->setState('prev_role', Yii::app()->user->role);
		}
		
		$user_record = $model->GetOffRecord($user_id);
		
		Yii::app()->user->setState('user_id', $user_id);
		Yii::app()->user->setState('role', $user_record[0]['role']);
		
		if(isset(Yii::app()->user->prev_user_id) && $user_id == Yii::app()->user->prev_user_id)
		{
			Yii::app()->user->setState('prev_user_id', '');
			Yii::app()->user->setState('role', Yii::app()->user->prev_role);
			Yii::app()->user->setState('prev_role', '');
		}
		
		$this->redirect(array('user/dashboard'));
	}
	
	public function actionNewcampaign()
	{
		$model = new FsSpecial;
		$model_campaign= new Campaign;
		
		if($_POST['timezone'])
		{
			$timezone = $model->GetTimeZone($_POST['timezone']);
			
			if(isset($timezone[0]['name']))
				date_default_timezone_set($timezone[0]['name']);
		}
		
		$msg = 0;
		
		$token = AccessToken::model()->GetUserTokenRecord(Yii::app()->user->user_id);

		$data = array();
		
		if( $token[0]['twitter_oauth_token'] != '' &&  $token[0]['twitter_oauth_token_secret'] != '')
			$show_form = true;
		else
			$show_form = false;
			
		//if(!empty($_POST['campaign_name']) && strtotime($_POST['start_date'])<strtotime($_POST['end_date']) && !empty($_POST['start_time']) && !empty($_POST['end_time']))
		
		if(!empty($_POST['campaign_name']))
		{
                    
			$campaign_name 	 = $_POST['campaign_name'];
			
			$temp_start_time = explode(':',$_POST['start_time']);
			
			$temp_start_date = explode('/',$_POST['start_date']);
			
			if(count($temp_start_time))
				$start_date  = mktime($temp_start_time[0],$temp_start_time[1],0,$temp_start_date[0],$temp_start_date[1],$temp_start_date[2]);
			else
				$start_date  = mktime(0,0,0,$temp_start_date[0],$temp_start_date[1],$temp_start_date[2]);
			
			$temp_end_time   = explode(':',$_POST['end_time']);
			
			$temp_end_date   = explode('/',$_POST['end_date']);
			
			if(count($temp_end_time))
				$end_date = mktime($temp_end_time[0],$temp_end_time[1],0,$temp_end_date[0],$temp_end_date[1],$temp_end_date[2]);
			else
				$end_date = mktime(0,0,0,$temp_end_date[0],$temp_end_date[1],$temp_end_date[2]);
			
                        $today_date = date('m/d/Y');
			$groups				= $_POST['groups'];
			$pages				= $_POST['page'];
			$start_date			= $start_date;
			$start_time			= $_POST['start_time'];
			$end_date			= $end_date;
			$end_time 			= $_POST['end_time'];
			$timezone			= $_POST['timezone'];
			$kpi				= $_POST['kpi'];
			$facebook_deals 	= ($_POST['facebook_deals']=='yes') ? 'yes' : 'no';
			$fs_specials 		= ($_POST['fs_specials']=='yes') ? 'yes' : 'no';
			$google_places 		= ($_POST['google_places']=='yes') ? 'yes' : 'no';
			$fbposts 			= ($_POST['fbposts']=='yes') ? 'yes' : 'no';
			$twitter 			= ($_POST['twitter']=='yes') ? 'yes' : 'no';
			$FB_ads 			= ($_POST['FB_ads']=='yes') ? 'yes' : 'no';
			$google_adwords 	= ($_POST['google_adwords']=='yes') ? 'yes' : 'no';
			$userid 			= Yii::app()->user->user_id;
			$status				= 'pending';
			$dated				= strtotime($today_date);
			$lastid				= $_POST['savedid'];
                        
                        if($_POST['savedid'])
                        {
                            $SaveCamp = $model_campaign->SaveCamp($lastid,$userid,$campaign_name,$groups,$pages,$start_date,$start_time,$end_date,$end_time,$timezone,$kpi,$facebook_deals,$fs_specials,$google_places,$fbposts,$twitter,$FB_ads,$google_adwords,$dated,$status);
                            if($_POST['fbposts']=='yes')
				{
					$post_title = $_POST['fb_post_title'];
					$url = $_POST['link_get'];
					$msg = $_POST['textmsg'];
					$link_title = $_POST['link_title'];
					$link_description = $_POST['link_description'];
					$email_notify = $_POST['Fbposts']['email_notify'];
					$sel_wall		= $_REQUEST['sel_wall'];
					$selected_wall	= $_REQUEST['selected_wall'];
					
					if($_POST['post_to']=="nothing")
						$content_type = "text";
					else if($_POST['post_to']=="photos")
						$content_type = "photo";
					else if($_POST['post_to']=="videos")
						$content_type = "video";
						
					if($content_type=='photo' && $_FILES['fb_photo']['name'])
					{
						$get_tenp_ext = explode('.',$_FILES['fb_photo']['name']);
						$ext = $get_tenp_ext[count($get_tenp_ext)-1];
						
						$name_photo = strtotime(now).'.'.$ext;
						move_uploaded_file($_FILES['fb_photo']['tmp_name'],'images/fbposts/'.$name_photo);
					}
					else if($content_type=='video' && $_FILES['videophoto']['name'])
					{
						$get_tenp_ext = explode('.',$_FILES['videophoto']['name']);
						$ext = $get_tenp_ext[count($get_tenp_ext)-1];
						
						$name_video = strtotime(now).'.'.$ext;
						move_uploaded_file($_FILES['videophoto']['tmp_name'],'images/fbposts/'.$name_video);
					}
					
					$SaveFBCamp = $model_campaign->UpdateFBCamp($post_title,$sel_wall,$selected_wall,$url,$msg,$link_title,$link_description,$email_notify,$content_type,$name_photo,$name_video,$lastid);	
				}
                                
                                if( $_POST['fs_specials'] == 'yes' )
				{
					$sp_type = $_POST['sp_type'];
					
					if($sp_type == 'swarm')
					{
						$count1 = $_POST['swarm_people'];
						$count2 = $_POST['swarm_days'];
						
						$unlockedText = 'When '.$count1.' people are checked in at once with a maximum of '.$count2.' unlocks per day.';
					}
					else if($sp_type == 'friends')
					{
						$count1 = $_POST['friend_people'];
						
						$unlockedText = 'When '.$count1.' friends check in together.';
					}
					else if($sp_type == 'flash')
					{
						$count1 = $_POST['flash_people'];
						
						if($_POST['flash_time1'])
							$temp_count1 = explode(':',$_POST['flash_time1']);
						
						$count2 = $temp_count1[0];
						
						if($_POST['flash_time2'])
							$temp_count2 = explode(':',$_POST['flash_time2']);
						
						$count3 = $temp_count2[0];
						
						$unlockedText='When a customer is one of the first '.$count1.' people to check in between '.$_POST['flash_time1'].'  and '.$_POST['flash_time2'].' .';
					}
					else if($sp_type=='count')
					{
						$newbie_check=$_POST['newbie_check'];
						
						$count1 = 1;
						
						if($newbie_check=='any_venue')
							$unlockedText ='When a user checks in for the first time at any venue.';
						else
							$unlockedText='When a user checks in for the first time at each venue.';
					}
					else if($sp_type=='frequency')
					{
						$count1 = 1;
						
						$unlockedText='When anyone checks in.';
					}
					else if($sp_type=='regular')
					{
						if($_POST['loyalty_check']==1)
						{
							$count1=$_POST['loyalty_opt1'];
							$unlockedText='Every '.$count1.' check-ins';
						}
						else if($_POST['loyalty_check']==2)
						{
							$count1=$_POST['loyalty_opt2'];
							$unlockedText='When a customer checks in exactly '.$count1.' times';
						}
						else if($_POST['loyalty_check']==3)
						{
							$count1=$_POST['loyalty_opt3'];
							$count2=$_POST['loyalty_opt4'];
							$unlockedText='When a customer has checked in '.$count1.' or more times in the last '.$count3.' days.';
						}
						
						$unlockedText .=' Progress towards unlocking the special counts check-ins:';
						
						if($_POST['loyalty_check_venue']=='each_venue')
							$unlockedText .=' At each venue separately';
						else
							$unlockedText .=' Across all venues together';
					}
					else if($sp_type=='mayor')
					{
						$unlockedText='When a customer is the mayor and checks in.';
					}
					
					$offer = $_POST['offer'];
					$finePrint = $_POST['rules'];
					$cost = $_POST['cost'];
					
					$venue_type = $_POST['sel_venue'];
					$location_type = $_POST['groups'];
					
					$SaveFSCamp = $model_campaign->UpdateFSCamp($venue_type,$location_type,$sp_type,$count1,$count2,$count3,$unlockedText,$offer,$finePrint,$cost,$lastid);
				}
                        }
			 
			//$SaveCamp = $model_campaign->SaveCamp($lastid,$userid,$campaign_name,$groups,$pages,$start_date,$start_time,$end_date,$end_time,$timezone,$kpi,$facebook_deals,$fs_specials,$google_places,$fbposts,$twitter,$FB_ads,$google_adwords,$dated,$status);
                        else
                        {
                            
                        
			$lastid = $model_campaign->InsertCamp($userid,$campaign_name,$groups,$pages,$start_date,$start_time,$end_date,$end_time,$timezone,$kpi,$facebook_deals,$fs_specials,$google_places,$fbposts,$twitter,$FB_ads,$google_adwords,$dated,$status);
			
			if( $lastid > 0 )
			{	
				if( $_POST['facebook_deals'] == 'yes' )
				{
				
				}
				
				if( $_POST['twitter'] == 'yes' && $_POST['twittermsg'] != '' )
				{
					CampaignTwitter::model()->SaveMessage($lastid, $_POST['twittermsg']);
				}
			
				if( $_POST['fs_specials'] == 'yes' )
				{
					$sp_type = $_POST['sp_type'];
					
					if($sp_type == 'swarm')
					{
						$count1 = $_POST['swarm_people'];
						$count2 = $_POST['swarm_days'];
						
						$unlockedText = 'When '.$count1.' people are checked in at once with a maximum of '.$count2.' unlocks per day.';
					}
					else if($sp_type == 'friends')
					{
						$count1 = $_POST['friend_people'];
						
						$unlockedText = 'When '.$count1.' friends check in together.';
					}
					else if($sp_type == 'flash')
					{
						$count1 = $_POST['flash_people'];
						
						if($_POST['flash_time1'])
							$temp_count1 = explode(':',$_POST['flash_time1']);
						
						$count2 = $temp_count1[0];
						
						if($_POST['flash_time2'])
							$temp_count2 = explode(':',$_POST['flash_time2']);
						
						$count3 = $temp_count2[0];
						
						$unlockedText='When a customer is one of the first '.$count1.' people to check in between '.$_POST['flash_time1'].'  and '.$_POST['flash_time2'].' .';
					}
					else if($sp_type=='count')
					{
						$newbie_check=$_POST['newbie_check'];
						
						$count1 = 1;
						
						if($newbie_check=='any_venue')
							$unlockedText ='When a user checks in for the first time at any venue.';
						else
							$unlockedText='When a user checks in for the first time at each venue.';
					}
					else if($sp_type=='frequency')
					{
						$count1 = 1;
						
						$unlockedText='When anyone checks in.';
					}
					else if($sp_type=='regular')
					{
						if($_POST['loyalty_check']==1)
						{
							$count1=$_POST['loyalty_opt1'];
							$unlockedText='Every '.$count1.' check-ins';
						}
						else if($_POST['loyalty_check']==2)
						{
							$count1=$_POST['loyalty_opt2'];
							$unlockedText='When a customer checks in exactly '.$count1.' times';
						}
						else if($_POST['loyalty_check']==3)
						{
							$count1=$_POST['loyalty_opt3'];
							$count2=$_POST['loyalty_opt4'];
							$unlockedText='When a customer has checked in '.$count1.' or more times in the last '.$count3.' days.';
						}
						
						$unlockedText .=' Progress towards unlocking the special counts check-ins:';
						
						if($_POST['loyalty_check_venue']=='each_venue')
							$unlockedText .=' At each venue separately';
						else
							$unlockedText .=' Across all venues together';
					}
					else if($sp_type=='mayor')
					{
						$unlockedText='When a customer is the mayor and checks in.';
					}
					
					$offer = $_POST['offer'];
					$finePrint = $_POST['rules'];
					$cost = $_POST['cost'];
					
					$venue_type = $_POST['sel_venue'];
					$location_type = $_POST['groups'];
					
					$SaveFSCamp = $model_campaign->SaveFSCamp($venue_type,$location_type,$sp_type,$count1,$count2,$count3,$unlockedText,$offer,$finePrint,$cost,$lastid);
				}
				
				if($_POST['fbposts']=='yes')
				{
					$post_title = $_POST['fb_post_title'];
					$url = $_POST['link_get'];
					$msg = $_POST['textmsg'];
					$link_title = $_POST['link_title'];
					$link_description = $_POST['link_description'];
					$email_notify = $_POST['Fbposts']['email_notify'];
					$sel_wall		= $_REQUEST['sel_wall'];
					$selected_wall	= $_REQUEST['selected_wall'];
					
					if($_POST['post_to']=="nothing")
						$content_type = "text";
					else if($_POST['post_to']=="photos")
						$content_type = "photo";
					else if($_POST['post_to']=="videos")
						$content_type = "video";
						
					if($content_type=='photo' && $_FILES['fb_photo']['name'])
					{
						$get_tenp_ext = explode('.',$_FILES['fb_photo']['name']);
						$ext = $get_tenp_ext[count($get_tenp_ext)-1];
						
						$name_photo = strtotime(now).'.'.$ext;
						move_uploaded_file($_FILES['fb_photo']['tmp_name'],'images/fbposts/'.$name_photo);
					}
					else if($content_type=='video' && $_FILES['videophoto']['name'])
					{
						$get_tenp_ext = explode('.',$_FILES['videophoto']['name']);
						$ext = $get_tenp_ext[count($get_tenp_ext)-1];
						
						$name_video = strtotime(now).'.'.$ext;
						move_uploaded_file($_FILES['videophoto']['tmp_name'],'images/fbposts/'.$name_video);
					}
					
					$SaveFBCamp = $model_campaign->SaveFBCamp($post_title,$sel_wall,$selected_wall,$url,$msg,$link_title,$link_description,$email_notify,$content_type,$name_photo,$name_video,$lastid);	
				}
			}
                        }
			
			$this->redirect(array('campaign'));
		}
		
		if($_POST['submit'] == 'GO campaign' && (empty($_POST['campaign_name']) || empty($_POST['start_date']) || empty($_POST['end_date']) || empty($_POST['start_time']) || empty($_POST['end_time'])))
		{
                    
			$msg = 1;			
		}
		
		// Get Page Title
		$PageTitle = GetPageSubTitle($_SERVER['PATH_INFO'],$_REQUEST['view']);
		
		$this->render('newcampaign',array('msg'=>$msg,'PageTitle'=>$PageTitle,'show_form'=>$show_form));
	}
	
	public function get_http_response_code($url) 
	{
    	$headers = @get_headers($url);
	    return substr($headers[0], 9, 3);
	}
	
	public function get_http_response_code_google($url) 
	{
		$resURL = curl_init(); 
		curl_setopt($resURL, CURLOPT_URL, $url); 
		curl_setopt($resURL, CURLOPT_BINARYTRANSFER, 1); 
		curl_setopt($resURL, CURLOPT_HEADERFUNCTION, 'curlHeaderCallback'); 
		curl_setopt($resURL, CURLOPT_FAILONERROR, 1); 
		curl_exec ($resURL); 
		$intReturnCode = curl_getinfo($resURL, CURLINFO_HTTP_CODE); 
		curl_close ($resURL); 
		if ($intReturnCode != 200 && $intReturnCode != 302 && $intReturnCode != 304) { 
			return false;
		}
		else return true;
	}
	
	public function loadModel($id)
	{
		$model=Location::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='location-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}
