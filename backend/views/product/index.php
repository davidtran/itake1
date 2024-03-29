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
	'dataProvider'=>$this->searchProduct(),
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
	
        array(
            'header'=>'Status',
            'value'=>'$data->getStatusText()'
        ),		
		'create_date',				
        array(
            'header'=>'Address',
            'value'=>'$data->address->cityModel->name.",".$data->address->address'
        ),        
        array(
            'header'=>'Phone',
            'value'=>'$data->address->phone'
        ),        	
		array(
            'name'=>'status',
            'value'=>'$data->getStatusText()'
        ),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{update}{delete}'
		),
	),
)); ?>
