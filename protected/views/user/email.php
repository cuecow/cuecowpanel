<?php
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
<span style="font-style: italic; font-size: 11px;">'.$body.'</span><br /><br />Thanks,<br />Cuecow.com
';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Mail it
if(mail($to, $subject, $message, $headers)) {
header('location: index.php');
} else {
echo '<strong>Mailing error!</strong>';
}
?>
