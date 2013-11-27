<?php

class SubscriptionController extends Controller
{
	public function actionIndex()
	{
		if(!isset(Yii::app()->user->user_id) || Yii::app()->user->user_id=='')
			$this->redirect(array('site/login'));
		
		$error = '';
		
		$UserInfo = User::model()->GetOffRecord(Yii::app()->user->user_id);
		
		if(date('Y-m-d') > $UserInfo[0]['subscriptionValidTo'])
		{
			// Get Page Title
			$PageTitle = GetPageSubTitle($_SERVER['PATH_INFO'],$_REQUEST['view']);
	
			$LastTrans = AccountForm::model()->GetLatestTransaction(Yii::app()->user->user_id);
			
			$GetAmount = AccountForm::model()->GetSubscriptionPrice($LastTrans[0]['planid']);
			
			$epay_url = 'https://ssl.ditonlinebetalingssystem.dk/popup/default.asp';
			
			$plan_id = $LastTrans[0]['planid'];
			$plan_cost = $GetAmount[0]['price'];
				
			$payment_amount = $plan_cost;
			$tax = ($payment_amount*25)/100;
				
			$payment_amount_in_minor_units = ($payment_amount + $tax)*100;
					
			$post_data = array();
				
			//$post_data['merchantnumber'] = 8010148;
			$post_data['merchantnumber'] = 5732417;
			$post_data['subscription'] = 1;
			$post_data['amount'] = $payment_amount_in_minor_units;
			$post_data['currency'] = 208;
						
			$post_data['orderid'] = rand(105,500000);
			
			$payment_amount = $SubscriptionInfo[0]['price'];
			$tax = ($payment_amount*25)/100;
			
			$post_data['accepturl'] = 'http://panel.cuecow.com/index.php/subscription/payaccepted';
			$post_data['callbackurl'] = 'http://panel.cuecow.com/index.php/subscription/paycallback';
			
			$post_data['language'] = "2";
			$post_data['instantcapture'] = "1";
		}
		else
			$error = 'Your subscription is already in runing state.';
		
		$this->render('index',array('PageTitle'=>$PageTitle,'error'=>$error,'post_data'=>$post_data));
	}
	
	public function actionPaydeclined()
	{
		$this->redirect(array('user/dashboard'));
	}
	
	public function actionPayaccepted()
	{
		if($_GET['subscriptionid']>0)
		{
			$new_trans = array();
			
			$get_num_paid = Cron::model()->CronGetAllUserSubscription(Yii::app()->user->user_id);
			$LastTrans = AccountForm::model()->GetLatestTransaction(Yii::app()->user->user_id);
			
			$fetch_prev_trans = Cron::model()->CronGetSubscription('subscriptionid',$LastTrans['subscriptionid']);
			
			$GetAmount = AccountForm::model()->GetSubscriptionPrice($LastTrans[0]['planid']);
			$plan_id = $LastTrans[0]['planid'];
			$plan_cost = $GetAmount[0]['price'];
				
			$payment_amount = $plan_cost;
			$tax = ($payment_amount*25)/100;
				
			$payment_amount_in_minor_units = ($payment_amount + $tax)*100;
			
			$next_bill = strtotime(now) + (30*24*60*60);
			$date_end = date("Y-m-d", $next_bill);
			
			$new_trans['tid'] 			= $_GET['tid'];
			$new_trans['orderid'] 		= $_GET['orderid'].$get_num_paid;
			$new_trans['amount'] 		= $plan_cost;
			$new_trans['tax'] 			= $tax;
			$new_trans['total_amount'] 	= $_GET['amount'];
			$new_trans['cur'] 			= 208;
			$new_trans['date'] 			= date('Ymd');
			$new_trans['time'] 			= date('Hi');
			$new_trans['subscriptionid']= $_GET['subscriptionid'];
			$new_trans['transfee'] 		= $_GET['transfee'];
			$new_trans['user_id'] 		= Yii::app()->user->user_id;
			$new_trans['account_name'] 	= $LastTrans[0]['account_name'];
			$new_trans['email'] 		= $LastTrans[0]['email'];
			$new_trans['username'] 		= $LastTrans[0]['username'];
			$new_trans['fname'] 		= $LastTrans[0]['fname'];
			$new_trans['lname'] 		= $LastTrans[0]['lname'];
			$new_trans['phone'] 		= $LastTrans[0]['phone'];
			$new_trans['company'] 		= $LastTrans[0]['company'];
			$new_trans['address'] 		= $LastTrans[0]['address'];
			$new_trans['postal_code'] 	= $LastTrans[0]['postal_code'];
			$new_trans['city'] 			= $LastTrans[0]['city'];
			$new_trans['country'] 		= $LastTrans[0]['country'];
			$new_trans['planid'] 		= $LastTrans[0]['planid'];
			$new_trans['status'] 		= 'paid';
			
			$sql = 'insert into transaction set ';
			$sql_temp = '';
			
			$g = 1;
			foreach($new_trans as $key=>$value)
			{
				$sql_temp .= $key.'="'.$value.'"';
				
				if($g!=count($new_trans))
					$sql_temp .=', ';
					
				$g++;
			}
			
			$query = $sql.$sql_temp;
			
			$track_rec = Cron::model()->CronRunQuery($query);
					
			if($track_rec)
			{
				$update_user = 'update user set subscriptionValidTo="'.$date_end.'" where user_id="'.Yii::app()->user->user_id.'"';
				
				Cron::model()->CronRunQuery($update_user);
			}
				
			$this->redirect(array('user/dashboard'));
		}
		else
		{
			$response_vars = $this->CTH_getVariableFromUrl($payment_result);
					
			if( isset( $response_vars['errortext'] ) )
				$error .= $response_vars['errortext'];
			else
				$error .= 'Credit card could not changed. Please try again';
						
			$this->redirect(array('user/dashboard/error/'.$error));
		}
	}
}