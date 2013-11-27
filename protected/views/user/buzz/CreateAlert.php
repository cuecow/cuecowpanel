<?php

function createalert($query, $typ, $freq, $vol, $del, $lang) 
{
	require_once('gaapi/GoogleAlertService.php');
	
	$user = 'cuecow@gmail.com';
    $pass = 'cuec0w123';
	
    if ($user == null) { // no user, no session, then die
    	die("Session expired.. Please relogin.");
	}
    try 
	{
		
    	$service = new GoogleAlertService($user, $pass);
	} 
	catch (Exception $e) 
	{
    	die($e->getMessage());
	}

    $type = Type::forDescription($typ);
    $frequency = Frequency::forDescription($freq);
    $volume = Volume::forDescription($vol);
    $delivery = $del;
    $isFeed = ($delivery == 'feed') ? true : false;
		
	$ext = '';
	
	if($lang == "da") 
	{
		$ext = '.dk';
	}
	else 
	{
		$ext = '.com';
	}
    
	$alert = new GoogleAlert($query, $type, $frequency, $volume, $isFeed, $user);
		
	$service->createAlert($alert,$lang, $ext);
	 
	$message = "<h2>Your alert, has been successfully added!</h2>You will be redirected back shortly.";
	echo $message;
	header("refresh: 2; alerts/GetAlerts.php");
}

?>
