<?php

class TopVenues extends CWidget {

   public function run() 
   {
		$model = new Location;
                $model_fb = new Fbpages;
                $reach = $model_fb->GetPagesDetail();
                $count = 0;
                //$reach_count = count($reach);
                
                foreach($reach as $key => $value)
                {
                    $pg = $value['page_id'];
                    $token = $value['token'];
                    //var_dump($pg); die();
                    $page_url = "https://graph.facebook.com/".$pg."/insights/page_impressions_organic?access_token=".$token;
                    $page_resp = @file_get_contents($page_url);
                    $page_url_res = json_decode($page_resp);
                    $count = $count + ($page_url_res->data[2]->values[1]->value);
                }
                $count = number_format($count);
		$this->render('TopVenues', array('model'=>$model, 'social_reach'=>$count));
   }

}

?>

<!--$pg = $reach[2]['page_id'];
                    $token = $reach[2]['token'];
                    //var_dump($pg); die();
                    $page_url = "https://graph.facebook.com/".$pg."/insights/page_impressions_organic?access_token=".$token;
                    $page_resp = @file_get_contents($page_url);
                    $page_url_res = json_decode($page_resp);
                    var_dump($page_url_res->data[2]->values[1]->value); die();-->