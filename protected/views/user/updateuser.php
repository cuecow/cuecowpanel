<?php if(Yii::app()->user->role == 'admin') { ?>

<? $form=$this->beginWidget('CActiveForm', array('action'=>Yii::app()->request->baseUrl.'/index.php/user/updateuser/view/Edit/user_id/'.$_REQUEST['user_id'],'id'=>'location-form','htmlOptions'=>array('class'=>'styled'),'enableAjaxValidation'=>true,)); ?>

<div class="container container-top">
	<div class="row-fluid">
	
		<?php include('edituser.php'); ?>
	
    </div>
</div>
    
<?php $this->endWidget(); ?>
  
<?php } else { ?>

<div class="container container-top">
	<div class="row-fluid">
    	<div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            You are not authorized to perform this action.
        </div>
	</div>
</div>

<?php } ?>