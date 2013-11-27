<?php

class AllUserList extends CWidget {

   public function run() 
   {
		$model = new User;
      	
		$this->render('AllUserList', array('model'=>$model));
   }

}

?>