<?php
require_once('gaapi/GoogleAlertService.php');
  
$user = 'cuecow@gmail.com';
$pass = 'cuec0w123';

if ($user == null) { // no user, no session, then die
	die("Session expired.. Please relogin.");
}
try {

	$service = new GoogleAlertService($user, $pass);
} catch (Exception $e) {
	die($e->getMessage());
}

$id = $_GET['id'];
$service->deleteAlert($id);
$message = "<h2>Alert deleted successfully...</h2>You will be redirected back shortly.";
echo $message;
header("refresh: 2; ".Yii::app()->request->baseUrl.'/index.php/user/alert');
		
?>
