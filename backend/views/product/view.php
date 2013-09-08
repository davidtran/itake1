<?php
/* @var $this ProductController */
/* @var $model Product */

$this->breadcrumbs=array(
	'Products'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Product', 'url'=>array('index')),
	array('label'=>'Delete Product', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>View Product #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'description',
		'price',
		'user_id',
		'create_date',
		'lat',
		'lon',
		'phone',
		'category_id',
		'city',
		'locationText',
		'view',
		'country',
	),
)); ?>
<h3>Hình ảnh</h3>
<?php foreach($model->images as $image): ?>
    <?php echo CHtml::image(Yii::app()->params['frontendUrl'].'/'.$image->image,'',array('width'=>200)); ?>
    <br/>
<?php endforeach; ?>

