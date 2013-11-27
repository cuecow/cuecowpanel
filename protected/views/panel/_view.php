<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('subscription_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->subscription_id), array('view', 'id'=>$data->subscription_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('max_num_users')); ?>:</b>
	<?php echo CHtml::encode($data->max_num_users); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('max_num_venues')); ?>:</b>
	<?php echo CHtml::encode($data->max_num_venues); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('max_num_campaigns')); ?>:</b>
	<?php echo CHtml::encode($data->max_num_campaigns); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('max_num_apps')); ?>:</b>
	<?php echo CHtml::encode($data->max_num_apps); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('max_num_walls')); ?>:</b>
	<?php echo CHtml::encode($data->max_num_walls); ?>
	<br />

	*/ ?>

</div>