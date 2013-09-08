<?php
/* @var $this ProductController */
/* @var $model Product */

$this->breadcrumbs=array(
	'Products'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Product', 'url'=>array('index')),
);

?>

<h1>Manage Products</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
        array(
            'header'=>'Image',
            'type'=>'raw',
            'value'=>'CHtml::image(Yii::app()->params["frontendUrl"]."/".$data->getFirstImage(),"",array("width"=>100))'
        ),
		'title',
		'description',
		'price',
		'user_id',
		'image',
		/*
		'create_date',
		'lat',
		'lon',
		'phone',
		'category_id',
		'processed_image',
		'city',
		'locationText',
		'image_thumbnail',
		'view',
		'address_id',
		'country',
		*/
		array(
			'class'=>'CButtonColumn',
            'template'=>'{view}{delete}'
		),
	),
)); ?>
