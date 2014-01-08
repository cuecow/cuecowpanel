<?php

class AddUser extends CWidget {

   public function run() 
   {
		$model = new User;

		$validate=0;

		if(isset($_POST['User']))
		{
			if(empty($_POST['User']['fname']))
			{
				$model->addError('fname','First Name can not be blank');
				$validate++;
			}
			if(empty($_POST['User']['email']))
			{
				$model->addError('email','User Email can not be blank');
				$validate++;
			}
			if(empty($_POST['User']['password']))
			{
				$model->addError('password','Password can not be blank');
				$validate++;
			}
			
			$GetLimitUsers = $model->ValidateLimits();
			$GetExistingUsers = $model->CountAdminUsers();
			
			if($GetLimitUsers[0]['max_num_users'] <= $GetExistingUsers && Yii::app()->user->user_id!=1)
			{
				$model->addError('admin_id','You have reached the maximum number of users for your account. Please upgrade to create more users.');
				$validate++;
			}
			
			if($validate==0)
			{
				$CheckUser=$model->GetUser($_POST['User']['email']);
				
				if(count($CheckUser)==0)
				{
					$model->admin_id 	= 	$_POST['User']['admin_id'];
					$model->fname 		= 	$_POST['User']['fname'];
					$model->lname 		= 	$_POST['User']['lname'];
					$model->address 	= 	$_POST['User']['address'];
					$model->company 	= 	$_POST['User']['company'];
					$model->city 		= 	$_POST['User']['city'];
					$model->postal_code = 	$_POST['User']['postal_code'];
					$model->country 	= 	$_POST['User']['country'];
					$model->phone 		= 	$_POST['User']['phone'];
					$model->timestamp	= 	$_POST['User']['timestamp'];
					$model->email 		= 	$_POST['User']['email'];
					$model->password 	= 	$_POST['User']['password'];
					
					$model->save();
					
                                        $url = $this->controller->createUrl('user/Usermanagement');
                                        $this->controller->redirect($url);
					//$this->redirect(array('user/usermanagement'));
				}
				else
				{
					$model->addError('email','This email already exists.');
					$validate++;
				}
			}
		}
      	
		$this->render('AddUser', array('model'=>$model,'validate'=>$validate));
   }

}

?>