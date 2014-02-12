<?php
include('../connection.php');
include('../framework/yii.php');

$user = $_REQUEST['user'];

$sql = mysql_query("SELECT * FROM user_pages_token where user_id=".$user."") or die(mysql_error());

$rec = array();
$i = 0;

if($sql != null){
while ($row = mysql_fetch_assoc($sql)) {
    $rec[$i] = $row;
    //print_r('aabc');
    $i++;
}
}
$count = 0;

if($rec != null){
foreach($rec as $key => $value)
{
    $pg = $value['page_id'];
    $token = $value['token'];
    
    $feed_url = file_get_contents('https://graph.facebook.com/'.$pg.'/insights/page_impressions_organic?access_token='.$token);
    $page_url_res = json_decode($feed_url);
    
    $count = $count + ($page_url_res->data[1]->values[2]->value);
}
}
$count = number_format($count);

            $result = $count;
            $error = '';
            echo json_encode(array('error' => $error,'result'=>$result));

?>
