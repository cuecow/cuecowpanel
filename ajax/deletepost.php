<?php
if (empty($_POST['id']) && empty($_POST['accesstoken'])) 
{
	$return['error'] = true;
	$return['msg'] = '';
}
else 
{
	$return['error'] = false;
	
	$comment_id = $_POST['id'];
	$access_token = $_POST['accesstoken'];
	$post_url = "https://graph.facebook.com/".$comment_id."/?access_token=".$access_token;
	
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $post_url);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	
	curl_exec($ch); // run the whole process 

	curl_close($ch);
	
	$return['msg'] = 0;
	
}

echo json_encode($return);
	

	
?>