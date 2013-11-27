<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/master.php?color=454e51" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/style.css" type="text/css" media="screen" />

<div id="alerts" style="width: 520px; height: 300px;">
<?php

//Needs few files in the mix
date_default_timezone_set('Europe/London');
require_once('api.php');
require_once('CreateAlert.php');

$userid = Yii::app()->user->user_id; 

if($_POST['submit']) 
{ 
    if(!empty($_POST['source']))
	{
		$source = 'site:'.$_POST['source'];
	}
	
	$clean = str_replace('OR ""' ,'', $_POST['Query']);
	$key = $clean.' '.$source.' -"cuecow#'.time().'"';
	//print $key;
	
	if(!empty($_POST['Delivery']))
		$email = $_POST['Delivery'];
	
	$howoften = $_POST['Frequency'];
	$volume = $_POST['Volume'];
	$delivery = 'feed';
	$type = $_POST['Type'];
	
	if(!empty($_POST['language'])) 
	{
		$lang = $_POST['language'];
	} 
	else 
	{
		$lang = 'en';
	}
	
	$id= time();
	
	$result = $model->InsertAlert($id,$key,$email,$howoften,$lang);
	
	if($result)
	{
		$create = createalert($key, $type, $howoften, $volume, $delivery, $lang);
	
        if (!function_exists('curl_init')) {
            die('Sorry cURL is not installed!');
        }

        $user = 'cuecow@gmail.com';
        $pass = 'cuec0w123';

        $service = new GoogleAlertService($user, $pass);
        $alerts = $service->getAlerts();
        //print_r( $alerts);
		
		$i = 1;
		foreach ($alerts as $alert) 
		{
			$alertkey = $alert->getQuery();
			if($alertkey == $key) 
			{
				$feed =  $alert->getFeedURL();
				$model->UpdateAlert($feed,$id,$key);
			}
			$i++;
		}
	}
  }
  
  header("refresh: 2; ".Yii::app()->request->baseUrl.'/index.php/user/getalert');
  ?>
<div style="clear:both;"></div>
</div>