<?php

class LatestFBPosts extends CWidget {

   public function run() 
   {
		$model = new Location;
                $model2 = new Fbpages;
                $records = $model2->GetPages();
                //var_dump($records); die();
		$this->render('LatestFBPosts', array('model'=>$model, 'records'=>$records));
   }

}

?>