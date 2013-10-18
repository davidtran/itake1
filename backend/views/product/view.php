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
        array(
            'label'=>'Image',
            'type'=>'raw',
            'value'=>function($model){
                $html = '';
                foreach($model->images as $image){
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
            'value'=>$model->category->name
        ),
		'user_id',
		'image',
        array(
            'label'=>'Status',
            'value'=>$model->getStatusText()
        ),		
		'create_date',				
        array(
            'label'=>'Address',
            'value'=>$model->address->cityModel->name.",".$model->address->address
        ),        
        array(
            'label'=>'Phone',
            'value'=>$model->address->phone
        ),        
		'view',		
		array(
            'name'=>'status',
            'value'=>$model->getStatusText()
        ),
	),
)); ?>
<h3>Hình ảnh</h3>
<?php foreach($model->images as $image): ?>
    <?php echo CHtml::image(Yii::app()->params['frontendUrl'].'/'.$image->image,'',array('width'=>200)); ?>
    <br/>
<?php endforeach; ?>

