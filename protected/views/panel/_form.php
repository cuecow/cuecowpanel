<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'subsription-type-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'max_num_users'); ?>
		<?php echo $form->textField($model,'max_num_users'); ?>
		<?php echo $form->error($model,'max_num_users'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'max_num_venues'); ?>
		<?php echo $form->textField($model,'max_num_venues'); ?>
		<?php echo $form->error($model,'max_num_venues'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'max_num_campaigns'); ?>
		<?php echo $form->textField($model,'max_num_campaigns'); ?>
		<?php echo $form->error($model,'max_num_campaigns'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'max_num_apps'); ?>
		<?php echo $form->textField($model,'max_num_apps'); ?>
		<?php echo $form->error($model,'max_num_apps'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'max_num_walls'); ?>
		<?php echo $form->textField($model,'max_num_walls'); ?>
		<?php echo $form->error($model,'max_num_walls'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->