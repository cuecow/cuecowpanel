<?php
$this->breadcrumbs=array(
	'Subsription Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SubsriptionType', 'url'=>array('index')),
	array('label'=>'Manage SubsriptionType', 'url'=>array('admin')),
);
?>

<h1>Create SubsriptionType</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>