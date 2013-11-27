<?php
include('../connection.php');

if (empty($_REQUEST['pageid']) && empty($_REQUEST['userid']) && empty($_REQUEST['token']) && empty($_REQUEST['comment'])) 
{
	$return['error'] = true;
	$return['msg'] = '';
}
else 
{
	$return['error'] = false;
		
	$page_id = $_REQUEST['pageid'];
	$access_token = $_REQUEST['token'];
	
	$message = $_REQUEST['comment'];
	$url  = "https://graph.facebook.com/" . $page_id . "/feed?&access_token=". $access_token; 
	
				
	$args = array(
		'message' => $message,
	);
	
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL,$url); // set url to post to 
	curl_setopt($ch, CURLOPT_FAILONERROR, 1); 
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // allow redirects 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable 
	curl_setopt($ch, CURLOPT_TIMEOUT, 0); // times out after Ns 
	curl_setopt($ch, CURLOPT_POST, 1); // set POST method 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
	curl_setopt($ch, CURLOPT_VERBOSE, 1); 
	curl_setopt($ch, CURLOPT_HEADER, 1); 
	curl_setopt($ch, CURLOPT_COOKIEFILE, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	$result = curl_exec($ch); // run the whole process 
	
	$return['msg'] = $result;
	
	curl_close($ch); 	
}

echo json_encode($return);

?>