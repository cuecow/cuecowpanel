<?php
$this->breadcrumbs=array(
	'Subsription Types'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List SubsriptionType', 'url'=>array('index')),
	array('label'=>'Create SubsriptionType', 'url'=>array('create')),
	array('label'=>'Update SubsriptionType', 'url'=>array('update', 'id'=>$model->subscription_id)),
	array('label'=>'Delete SubsriptionType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->subscription_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SubsriptionType', 'url'=>array('admin')),
);
?>

<h1>View SubsriptionType #<?php echo $model->subscription_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'subscription_id',
		'name',
		'description',
		'price',
		'status',
		'max_num_users',
		'max_num_venues',
		'max_num_campaigns',
		'max_num_apps',
		'max_num_walls',
	),
)); ?>
