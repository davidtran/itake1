<?php
/* @var $this FeedbackController */
/* @var $model Feedback */

$this->breadcrumbs=array(
	'Feedbacks'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Feedback', 'url'=>array('index')),		
);
?>

<h1>View Feedback #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'username',
		'email',
		'url',
		'message',
		'create_date',
		'user_id',
		'ip',
	),
)); ?>
