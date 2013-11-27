<?php

class TopVenues extends CWidget {

   public function run() 
   {
		$model = new Location;
      	
		$this->render('TopVenues', array('model'=>$model));
   }

}

?>