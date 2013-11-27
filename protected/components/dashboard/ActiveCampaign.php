<?php

class ActiveCampaign extends CWidget {

   public function run() 
   {
		$model = new Location;
      	
		$this->render('ActiveCampaign', array('model'=>$model));
   }

}

?>