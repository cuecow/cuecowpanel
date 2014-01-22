<?php
include('../connection.php');
include('../framework/yii.php');
//include('../protected/models/Fbpages.php');

$user = $_REQUEST['user'];

$posted_by_me = array();
$rec = array();
//$ids = array();

$sql = mysql_query("SELECT * FROM fbpages where user_id=".$user." AND page_url != '' AND status='active'") or die(mysql_error());

$i = 0;
while ($row = mysql_fetch_assoc($sql)) {
    $rec[$i] = $row;
    //print_r($row);
    $i++;
}

//$records_pages = mysql_fetch_array($sql);


foreach($rec as $key=>$value)
     {
   
         if($value['page_id'])
         {
            $frst_page = $value['page_id'];
         }
         //$ids = $frst_page;
         
        $sql = mysql_query("SELECT token FROM user_pages_token where page_id=".$frst_page." and user_id=".$user)or die(mysql_error());
        $get_page = mysql_fetch_assoc($sql);
//$fbposts_get = Fbposts::model()->GetPageToekn($records);
        $feed_url = file_get_contents('https://graph.facebook.com/'.$frst_page.'/feed?access_token='.$get_page['token']);
        $feed_content = json_decode($feed_url);
        
        
         if($feed_content)
         {
                foreach($feed_content as $key => $value)
                {
                        foreach($value as $keys=>$values)
                        {	
                                if(!empty($values->message))
                                {
                                    $values->acc = $get_page['token'];
                                    //array_push($values, $get_page['token']);
                                    array_push($posted_by_me,$values);
                                    
                                }
                               
                        }
                }
         }
     }
         //var_dump($posted_by_me); die();
     
        function date_compare($a, $b)
            {
                $t1 = strtotime($a->created_time);
                $t2 = strtotime($b->created_time);
                return $t2 - $t1;
            }    
            usort($posted_by_me, 'date_compare');
            
            $result = $posted_by_me;
            $error = '';
            echo json_encode(array('error' => $error,'result'=>$result));    
?>
