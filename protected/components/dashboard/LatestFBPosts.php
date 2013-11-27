<?php

class LatestFBPosts extends CWidget {

   public function run() 
   {
		$model = new Location;
      	
		$this->render('LatestFBPosts', array('model'=>$model));
   }

}

?>