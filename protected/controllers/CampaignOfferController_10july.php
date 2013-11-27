<?php

class CampaignOfferController extends Controller
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
		$url = $_SERVER['REQUEST_URI'];
		
		$new_url = str_replace('campaignOffer','marketingOffer',$url);
		
		if($new_url)
			echo '<script>window.location.href="'.$new_url.'"</script>';
		else
			echo '<script>window.location.href="http://panel.cuecow.com"</script>';
	}
	
	public function actionListing()
	{
		$url = $_SERVER['REQUEST_URI'];
		
		$new_url = str_replace('campaignOffer','marketingOffer',$url);
		
		if($new_url)
			echo '<script>window.location.href="'.$new_url.'"</script>';
		else
			echo '<script>window.location.href="http://panel.cuecow.com"</script>';
	}
	
	public function actionCalculatedate()
	{
		print_r($_REQUEST);
		exit;
		
		if(!empty($_POST['startdate']) && !empty($_POST['starttime']))
		{
			$temp_start_time = explode(':',$_POST['starttime']);
			$temp_start_date = explode('/',$_POST['startdate']);
			
			if( count($temp_start_time) && count($temp_start_date) )
				$new_start_date = mktime($temp_start_time[0],$temp_start_time[1],0,$temp_start_date[0],$temp_start_date[1],$temp_start_date[2]);
		}
				
		if(!empty($_POST['enddate']) && !empty($_POST['endtime']))
		{
			$temp_end_time = explode(':',$_POST['endtime']);
			$temp_end_date = explode('/',$_POST['enddate']);
			
			if( count($temp_end_time) && count($temp_end_date) )
				$new_end_date = mktime($temp_end_time[0],$temp_end_time[1],0,$temp_end_date[0],$temp_end_date[1],$temp_end_date[2]);
			
		}
		
		if( $new_start_date != '' && $new_end_date != '')
		{
			if( $new_start_date < strtotime(now) )
				echo 'Start date can not be past date<br />';
			if( $new_start_date > $new_end_date )
				echo 'Start date should be smaller than End date<br />';
			if( $new_start_date == $new_end_date )
				echo 'Start and End date can not be equal<br />';
		}
		
		if( $_POST['startdate'] == $_POST['enddate'] )
			echo 'End date should be greater than Start date<br />';
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