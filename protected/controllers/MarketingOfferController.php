<?php

class MarketingOfferController extends Controller
{	
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionIndex()
	{
		$model = new MarketingOffer;
		
		if(isset($_POST['MarketingOffer']))
		{	
			$model->account_name			= $_POST['MarketingOffer']['account_name'];
			$model->campaign_offer_guid		= guid();
			$model->subscription_type_id	= $_POST['MarketingOffer']['subscription_type_id'];
			$model->offered_price			= $_POST['MarketingOffer']['offered_price'];
			$model->Industry				= $_POST['MarketingOffer']['Industry'];
			$model->user_email				= $_POST['MarketingOffer']['user_email'];
			$model->user_fname				= $_POST['MarketingOffer']['user_fname'];
			$model->user_lname				= $_POST['MarketingOffer']['user_lname'];
			$model->vat_no					= $_POST['MarketingOffer']['vat_no'];
			$model->company					= $_POST['MarketingOffer']['company'];
			$model->address					= $_POST['MarketingOffer']['address'];
			$model->city					= $_POST['MarketingOffer']['city'];
			$model->postal_code				= $_POST['MarketingOffer']['postal_code'];
			$model->country					= $_POST['MarketingOffer']['country'];
			$model->dated					= date('Y-m-d H:i:s');
			
			if($model->validate())
			{
				if(!empty($_POST['MarketingOffer']['campaign_offer_id']) && !empty($_POST['MarketingOffer']['offer_guid']))
				{
					$UpdateRecord = $model->UpdateRecord($_POST['MarketingOffer']);
					
					$SubscriptionRec = SubsriptionType::model()->GetSpecificRec($_POST['MarketingOffer']['subscription_type_id']);
					
					$message = 'Dear '.$_POST['MarketingOffer']['account_name'];
					$message .= '<br /><br />We appreciate your interest in our social media platform, Cuecow. We hope you will enjoy using our platform to bring even more customers into your business.<br />';
					$message .= '<a href="http://panel.cuecow.com/index.php/site/account/subscription/'.$SubscriptionRec[0]['name'].'/offer_guid/'.$_POST['MarketingOffer']['offer_guid'].'">Please click here to get started</a>';
					$message .= '<br /><br />Best regards,<br />the Cuecow Team.<br /><br />';
					$message .= 'If you have any questions, please write to support@cuecow.com';
				}
				else
				{
					if($model->save())
					{
						$CampaignRecord = MarketingOffer::model()->GetRecord(Yii::app()->db->getLastInsertID());
						$SubscriptionRec = SubsriptionType::model()->GetSpecificRec($_POST['MarketingOffer']['subscription_type_id']);
						$to = $_POST['MarketingOffer']['user_email'];
						$from = 'admin@cuecow.com';
						
						$subject = 'Welcome to Cuecow';
						
						$message = 'Dear '.$_POST['MarketingOffer']['account_name'];
						$message .= '<br /><br />We appreciate your interest in our social media platform, Cuecow. We hope you will enjoy using our platform to bring even more customers into your business.<br />';
						$message .= '<a href="http://panel.cuecow.com/index.php/site/account/subscription/'.$SubscriptionRec[0]['name'].'/offer_guid/'.$CampaignRecord[0]['campaign_offer_guid'].'">Please click here to get started</a>';
						$message .= '<br /><br />Best regards,<br />the Cuecow Team.<br /><br />';
						$message .= 'If you have any questions, please write to support@cuecow.com';
						
						$headers = "From: " . strip_tags($from) . "\r\n";
						$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
						$headers .= "MIME-Version: 1.0\r\n";
						$headers .= "Content-Type: text/html; charset=utf-8\r\n";
						
						$mail = mail($to,$subject,$message,$headers);
						
					}
				}
			}
		}
		
		if(!empty($_REQUEST['offer_guid']))
			$record = $model->GetRecordWithGid($_REQUEST['offer_guid']);

		// Get Page Title
		$PageTitle = GetPageSubTitle($_SERVER['PATH_INFO'],$_REQUEST['view']);
		
		$this->render('index',array('model'=>$model,'PageTitle'=>$PageTitle,'message'=>$message,'record'=>$record[0]));
	}
	
	public function actionListing()
	{
		$model = new MarketingOffer;
		
		// Get Page Title
		$PageTitle = GetPageSubTitle($_SERVER['PATH_INFO'],$_REQUEST['view']);
		
		$this->render('listing',array('model'=>$model,'PageTitle'=>$PageTitle));
		
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}