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
            'value'=>function($data){
                $html = '';
                foreach($data->images as $image){
                    $html .= CHtml::image(Yii::app()->params["frontendUrl"]."/".$image->thumbnail,"",array("width"=>150));
                }
                echo $html;
            }
        ),
		'title',
		'description',
		'price',
        array(
            'name'=>'category_id',
            'value'=>'$data->category->name'
        ),
		'user_id',
		'image',
        array(
            'header'=>'Status',
            'value'=>'$data->getStatusText()'
        ),		
		'create_date',				
        array(
            'name'=>'Address',
            'value'=>'$data->address->cityModel->name.",".$data->address->address'
        ),        
        array(
            'name'=>'Phone',
            'value'=>'$data->address->phone'
        ),        
		'view',		
		array(
            'name'=>'Status',
            'value'=>'$data->getStatusText()'
        ),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{update}{delete}'
		),
	),
)); ?>
