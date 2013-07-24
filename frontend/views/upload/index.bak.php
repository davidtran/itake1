<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/btfileupload/bootstrap-fileupload.min.js', CClientScript::POS_HEAD);
$cs->registerCssFile(Yii::app()->baseUrl . '/js/btfileupload/bootstrap-fileupload.min.css');
Yii::app()->clientScript->registerScriptFile('//maps.google.com/maps/api/js?sensor=false', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/gmaps.js', CClientScript::POS_END);

$productInfo = json_encode($product->attributes);
$cityList = json_encode(CityUtil::getCityList(true));
$isNewRecord = $product->isNewRecord?'true':'false';
$cs->registerScript('product info', "
    var product = $productInfo;
    var cityList = $cityList;
    var isNewRecord = $isNewRecord;
        "   
        , CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/nada/upload-product.js?id=1', CClientScript::POS_END);
?>
<div class="row-fluid upload">
    <div class="span12">
        <div class="customupload">
<!--        <center>
            <?php if ($product->isNewRecord): ?>
                <h1>Đăng sản phẩm</h1>

            <?php else: ?>
                <h1>Chỉnh sửa sản phẩm</h1>
                <h3><?php echo $product->title; ?></h3>
            <?php endif; ?>
        </center>-->        
        <div class="row-fluid">
            <div class="progress_nav">
                <ul class="">
                        <li id="step1ThongTin" class="first-child current">
                                <a class="" href="javascript:void(0);">
                                <strong>1. Nhập thông tin đơn giản</strong>
                                <small>Nhanh &amp; dễ dàng</small>
                                <span class="arrow-right"><span></span></span>
                                </a> 	
                        </li>
                        <li id="step2DiaDiem" class="disable">
                                <a class="" href="javascript:void(0);">
                                <strong>2. Chọn địa điểm bán</strong>
                                <small>Đánh dấu địa chỉ trên bản đồ</small>
                                <span class="arrow-right"><span></span></span>
                                </a> 	
                        </li>
                        <li class="disable last-child">
                                <a href="javascript:void(0);">
                                <strong>3. Đăng bán ngay</strong>
                                <small>Tải tin đăng lên</small>  
                                </a>                                 
                        </li>
                </ul>
            </div>                    
         </div>  
         <div class="row-fluid">

        <?php
        $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id' => 'uploadProductForm',
             'type'=>'inline',
            'htmlOptions' => array(
                'enctype' => 'multipart/form-data'
            )
                ));
        ?>
        <?php echo $form->errorSummary($product); ?>       
        <div id="uploadStep1">
            <div class="row-fluid">
                <div class="span6">                    
                    <div class="rb-form-part">  
                        <div style="text-align: center;width:300px;">
                         <?php
                         $cates = CategoryUtil::getCategoryList();
                         $itemsCat = array();
                                 foreach ($cates as $cat){
                                     $itemsCat[$cat->id] = array('label'=>'<span class=" label '.$cat->styleName.'">'.$cat->iconAndNameHtml.'</span>','url'=>
                                         'javascript:selectCategoryAt('.$cat->id.',"'.$cat->icon.'","'.$cat->name.'","'.$cat->styleName.'")');
                                 }
                         $this->widget('bootstrap.widgets.TbButtonGroup', array(
                             'size' => 'large',                             
                             'type' => 'action', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                             'htmlOptions'=>array('id'=>'listCategory'),
                             'buttons' => array(
                                 array('label' => 'Chọn danh mục...','encodeLabel'=>false, 'items' => $itemsCat),
                             ),
                         ));                        
//                        echo $form->dropDownListRow(
//                                $product, 'category_id', CHtml::listData(CategoryUtil::getCategoryList(), 'id', 'iconAndNameHtml'),array('encode'=>false)
//                        );
                        echo $form->hiddenField($product, 'category_id');
                        ?>   
                             </div>
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new thumbnail" style="width: 300px; height: 300px;">
                                <?php if($product->image == null):?>
			    		<img src="http://www.placehold.it/300x300/EFEFEF/AAAAAA&text=Hình+SP" />
                                <?php else:?>
                                    <?php echo CHtml::image(Yii::app()->baseUrl.'/'.$product->image,'',array(
                                        'id'=>'productImageHoder'
                                    )); ?>
                                <?php endif; ?>
                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 300px; max-height: 300px; line-height: 20px;"></div>
                            <div style="text-align: center;width:300px;">
                                <span class="btn btn-file">
                                    <span class="fileupload-new">Chọn hình từ máy tính</span><span class="fileupload-exists">Đổi lại</span>
                                    <input type="file" name="productImage" id='productImage'/></span>
                                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Xóa</a>                                                                
                            </div>
                        </div>
                        <div class="alert alert-info" style="width:260px;">
                            <b>Lưu ý:</b> Bề ngang ảnh phải lớn hơn 640px và bề cao ảnh phải lớn hơn 480px
                        </div>
                    </div>
                </div>
                <div class="span5"> 
                    <div class="rb-form-part">                              
                        <?php echo $form->textFieldRow($product, 'title'); ?>  
                        
                        <?php                         
                        echo $form->textFieldRow($product, 'price', array('append' => 'VNĐ')); ?>
                        <?php echo $form->textFieldRow($product, 'phone'); ?>
                        <?php echo $form->textAreaRow($product, 'description'); ?>
                    </div> 
                     <?php
                    echo CHtml::link('<i class="icon-arrow-right"></i>   Tiếp tục', '#', array(
                        'class' => 'btn btn-info', 
                        'style'=>'margin-left:70%;',
                        'id' => 'btnFinishStep1'
                    ));
                    ?>
                </div>                 
            </div>           

        </div>    
    <div id="uploadStep2">
        <div class="row-fluid">
            <div class='span12'>                
                <div class="rb-form-part">                    
<?php echo $form->dropDownListRow($product, 'city', CityUtil::getCityListData(true)); ?>

                    <div id="advanceFeature">                    
                        <?php
                        echo $form->textFieldRow($product, 'locationText', array(
                            'placeholder' => 'Nhập vào địa chỉ và bấm enter'
                        ));
                        ?>                               
                        <?php
                        echo CHtml::link('<i class="icon-map-marker"></i>', '#', array(
                            'class' => 'btn btn-success',
                            'id' => 'btnSearchLocation'
                        ));
                        ?>
                    </div>


                    <label><span  class="label label-info"><i class="icon-info"></i></span>  Bạn có thể nhập vào địa chỉ và bấm Enter hoặc chọn trực tiếp trên bản đồ bằng cách nhấp chuột lên địa điểm trên bản đồ</label>
                </div>
                <div id='mapContainer'>
                    <div id="map"></div>
                <?php echo $form->hiddenField($product, 'lat'); ?>
                <?php echo $form->hiddenField($product, 'lon'); ?>
                </div>
                <div class="row-fluid" style="margin-top: 10px;">
                     <?php
                    echo CHtml::submitButton('Hoàn tất', array(
                        'id' => 'btnFinishStep2',                        
                        'class' => 'btn btn-success pull-right',                        
                        'data-loading-text' => 'Đang tải...'                        
                    ));
                    ?>
                     <?php
                    echo CHtml::link('<i class="icon-arrow-left"></i>   Quay lại', '#', array(
                        'class' => 'btn btn-info pull-left',
                        'id' => 'btnBackToStep1',                        
                    ));
                    ?>                   
                </div>
            </div>
        </div>


    </div>
              </div>       
<?php $this->endWidget(); ?>
        </div>
</div>
    </div>
</div>