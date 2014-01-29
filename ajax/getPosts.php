<?php
include('../connection.php');
include('../framework/yii.php');
include('../framework/web/CHttpSession.php');
//include('../protected/models/Fbpages.php');

///////////////////////////////////////////////////////////////////////////////////////////////
$session=new CHttpSession;
  $session->open();
  $old_posts = $session['old_post'];  // get session variable 'name1'
  $value2 = $session['name2'];
  

$user = $_REQUEST['user'];
$page_id = $_REQUEST['page_id'];
$posted_by_me = array();

$sql = mysql_query("SELECT token FROM user_pages_token where page_id=".$page_id." and user_id=".$user)or die(mysql_error());
        $get_page = mysql_fetch_assoc($sql);
//$fbposts_get = Fbposts::model()->GetPageToekn($records);
        $feed_url = file_get_contents('https://graph.facebook.com/'.$page_id.'/feed?access_token='.$get_page['token']);
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
         if($old_posts != NULL)
         {
             foreach($old_posts as $elementKey => $element) {
              
                    
                if($element->id) 
                {
                    $temp_t1 = explode('_',$element->id);	
                    $date_t = $temp_t1[0];
                

                if($date_t == $page_id){
                    //delete this particular object from the $array
                    unset($old_posts[$elementKey]);
                    } 
                }
            }
             
            foreach($posted_by_me as $key=>$value)
            {
                array_push($old_posts,$value);
            }
            
            $posted_by_me = $old_posts;
            //var_dump($old_posts); die();
         }
         
         
         function date_compare($a, $b)
            {
                $t1 = strtotime($a->created_time);
                $t2 = strtotime($b->created_time);
                return $t2 - $t1;
            }    
            usort($posted_by_me, 'date_compare');
            //var_dump($posted_by_me); die();
            
            $session['old_post'] = $posted_by_me;
            
            $result = $posted_by_me;
            $error = '';
            echo json_encode(array('error' => $error,'result'=>$result));











/////////////////////////////////////////////////////////////////////////////////////////////
//
//
// $session=new CHttpSession;
//  $session->open();
// // $value1=$session['name1'];  // get session variable 'name1'
//  //$value2=$session['name2']; 
//
//$user = $_REQUEST['user'];
//if(isset($_REQUEST['page']))
//{
//    $rec = array();
//    //$posted_by_me = array();
//    $posted_by_me = $_REQUEST['old_post'];
//    
//    $session['list'] = 'umair';
//    $value2=$session['old_post'];
//    $new_array = array();
//    $new_array = $value2;
//    //var_dump($value2); die();
//    //Yii::app()->session['list'] = $posted_by_me;
//    //$um = Yii::app()->session['list'];
//    //var_dump(Yii::app()->session['list']); 
//    //die();
//    //$array = json_decode($posted_by_me);
//    //var_dump($posted_by_me);
//    //$pieces = explode(",", $posted_by_me);
//    //var_dump($pieces); die();
//    //var_dump(str_split($posted_by_me)); die();
//    //$json_string = '[' . $_REQUEST['old_post'] . ']';
//    //var_dump(json_decode($_REQUEST['old_post'], true)); die();
//    //var_dump(json_decode($_REQUEST['old_post'], true)); die();
//    //var_dump($_REQUEST['old_post']); die();
//    $page_id = $_REQUEST['page'];
//    
//    $sql = mysql_query("SELECT token FROM user_pages_token where page_id=".$page_id." and user_id=".$user)or die(mysql_error());
//        $get_page = mysql_fetch_assoc($sql);
////$fbposts_get = Fbposts::model()->GetPageToekn($records);
//        $feed_url = file_get_contents('https://graph.facebook.com/'.$page_id.'/feed?access_token='.$get_page['token']);
//        $feed_content = json_decode($feed_url);
//        
//        
//         if($feed_content)
//         {
//                foreach($feed_content as $key => $value)
//                {
//                        foreach($value as $keys=>$values)
//                        {	
//                                if(!empty($values->message))
//                                {
//                                    $values->acc = $get_page['token'];
//                                    //array_push($values, $get_page['token']);
//                                    array_push($rec,$values);
//                                    
//                                }
//                               
//                        }
//                }
//         }
//         $flag=0;
//         foreach($rec as $key=>$value)
//         {
// 
//             array_push($new_array, $value);
//             $flag++;
//         }
//         
//         //var_dump($rec); die();
////         $count = count($rec);
////         $i=0;
////         while($i <= $count){
//////             for($j=0; $j<=count($value2);$j++)
//////             {
//////                 $temp_t1 = explode('_',$value2[$j]->id);	
//////                $date_t = $temp_t1[0];
//////                if($date_t == $page_id)
//////                {
//////                    $value2[$j] = $rec[$i];     
//////                }   
//////             }
////             foreach($rec as $key1=>$value12){
////             $k=0;
////            foreach($new_array as $key=>$value)
////            {
////                $temp_t1 = explode('_',$value->id);	
////                $date_t = $temp_t1[0];
////                if($date_t == $page_id)
////                {
////                    //$value2[$k] = $rec[$i]; 
////                    //array_replace($value2[$k], $rec[$i]);
////                    //array_splice($value2[$k], $k, $rec[$i]);
////                    //array_push($new_[$k], $value12);
////                }
////                $k++;
////            }
////            $i++;
////         }
////         
////         }
//         function date_compare1($a, $b)
//            {
//                $t1 = strtotime($a->created_time);
//                $t2 = strtotime($b->created_time);
//                return $t2 - $t1;
//            }    
//            usort($new_array, 'date_compare1');
//            $result = $new_array;
//            $error = '';
//            echo json_encode(array('error' => $error,'result'=>$result));   
//         //var_dump($new_array); die();
//}
//else
//{
//    
//    
//$posted_by_me = array();
//$rec = array();
////$ids = array();
//
//$sql = mysql_query("SELECT * FROM fbpages where user_id=".$user." AND page_url != '' AND status='active'") or die(mysql_error());
//
//$i = 0;
//while ($row = mysql_fetch_assoc($sql)) {
//    $rec[$i] = $row;
//    //print_r($row);
//    $i++;
//}
//
////$records_pages = mysql_fetch_array($sql);
//
//
//foreach($rec as $key=>$value)
//     {
//   
//         if($value['page_id'])
//         {
//            $frst_page = $value['page_id'];
//         }
//         //$ids = $frst_page;
//         
//        $sql = mysql_query("SELECT token FROM user_pages_token where page_id=".$frst_page." and user_id=".$user)or die(mysql_error());
//        $get_page = mysql_fetch_assoc($sql);
////$fbposts_get = Fbposts::model()->GetPageToekn($records);
//        $feed_url = file_get_contents('https://graph.facebook.com/'.$frst_page.'/feed?access_token='.$get_page['token']);
//        $feed_content = json_decode($feed_url);
//        
//        
//         if($feed_content)
//         {
//                foreach($feed_content as $key => $value)
//                {
//                        foreach($value as $keys=>$values)
//                        {	
//                                if(!empty($values->message))
//                                {
//                                    $values->acc = $get_page['token'];
//                                    //array_push($values, $get_page['token']);
//                                    array_push($posted_by_me,$values);
//                                    
//                                }
//                               
//                        }
//                }
//         }
//     }
//     $session['old_post'] = $posted_by_me;
//}
//         //var_dump($posted_by_me); die();
//     
//        function date_compare($a, $b)
//            {
//                $t1 = strtotime($a->created_time);
//                $t2 = strtotime($b->created_time);
//                return $t2 - $t1;
//            }    
//            usort($posted_by_me, 'date_compare');
//            //var_dump($posted_by_me); die();
//            
//            $result = $posted_by_me;
//            $error = '';
//            echo json_encode(array('error' => $error,'result'=>$result));    
//
?>
