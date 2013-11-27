<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'subscription_id'); ?>
		<?php echo $form->textField($model,'subscription_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'max_num_users'); ?>
		<?php echo $form->textField($model,'max_num_users'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'max_num_venues'); ?>
		<?php echo $form->textField($model,'max_num_venues'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'max_num_campaigns'); ?>
		<?php echo $form->textField($model,'max_num_campaigns'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'max_num_apps'); ?>
		<?php echo $form->textField($model,'max_num_apps'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'max_num_walls'); ?>
		<?php echo $form->textField($model,'max_num_walls'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->