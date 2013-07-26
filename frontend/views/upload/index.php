<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/btfileupload/bootstrap-fileupload.min.js', CClientScript::POS_HEAD);
$cs->registerCssFile(Yii::app()->baseUrl . '/js/btfileupload/bootstrap-fileupload.min.css');
Yii::app()->clientScript->registerScriptFile('//maps.google.com/maps/api/js?sensor=false', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/gmaps.js', CClientScript::POS_END);

$productInfo = json_encode($product->attributes);
$cityList = json_encode(CityUtil::getCityList(true));
$contactInfo = json_encode(UserUtil::getContactInfo());
$isNewRecord = $product->isNewRecord ? 'true' : 'false';
$cs->registerScript('product info', "
    var product = $productInfo;
    var cityList = $cityList;
    var isNewRecord = $isNewRecord;
    var contactInfo = $contactInfo;
        "
        , CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/nada/upload-product.js?id=1', CClientScript::POS_END);
?>
<div class="row-fluid upload">
    <div class="container-fluid">
        <div class="customupload">
<!--        <center>
            <?php if ($product->isNewRecord): ?>
                        <h1>Đăng sản phẩm</h1>

            <?php else: ?>
                        <h1>Chỉnh sửa sản phẩm</h1>
                        <h3><?php echo $product->title; ?></h3>
            <?php endif; ?>
        </center>-->        
            <div class="row-fluid" style="display: none;">
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
                   
                    'htmlOptions' => array(
                        'enctype' => 'multipart/form-data'
                    )
                        ));
                ?>
                <?php //echo $form->errorSummary($product); ?>       
                <div id="uploadStep1">
                    <div class="row-fluid">
                        <div class="span8">    
                             <div class="row-fluid">
                                <h3 style="text-align: center;"><i class="icon-hand-right"></i>  Đăng tin <?php echo $product->category->name ?></h3>
                                </div>
                            <div class="row-fluid">                               
                                <div class="span6" style="min-width:250px;">                                    
                                    <div class="rb-form-part" style="text-align:center;">                          
                                        <input type="hidden" value ="<?php echo $product->category_id ?>" id="Product_category_id" name="Product[category_id]"/>
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="fileupload-new thumbnail" style="max-width: 200px; max-height: 200px;">
                                                <?php if ($product->image == null): ?>
                                                    <img src="http://www.placehold.it/300x300/EFEFEF/AAAAAA&text=Hình+SP"  style="max-width: 200px; max-height: 200px;"/>
                                                <?php else: ?>
                                                    <?php
                                                    echo CHtml::image(Yii::app()->baseUrl . '/' . $product->image, '', array(
                                                        'id' => 'productImageHoder'
                                                    ));
                                                    ?>
                                                <?php endif; ?>
                                            </div>
                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 200px; line-height: 20px;"></div>
                                            <div>
                                                <span class="btn btn-file">
                                                    <span class="fileupload-new">Chọn hình từ máy tính</span><span class="fileupload-exists">Đổi lại</span>
                                                    <input type="file" name="productImage" id='productImage'/></span>
                                                <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Xóa</a>                                                                
                                            </div>
                                        </div>
                                        <div class="alert alert-info" style="text-align: justify;margin-left: 5px;margin-right: 5px;">
                                            <b>Lưu ý:</b> Bề ngang ảnh phải lớn hơn 640px và bề cao ảnh phải lớn hơn 480px
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="rb-form-part"   >                              
                                        <?php echo $form->textFieldRow($product, 'title'); ?>  
                                        
                                        <?php echo $form->textFieldRow($product, 'price', array('append' => 'VNĐ')); ?>
                                        
                                        <?php echo $form->textFieldRow($product, 'phone'); ?>
                                        <?php echo $form->textAreaRow($product, 'description'); ?>
                                    </div>                                     
                                </div>
                            </div>
                        </div>
                        <div class="span4" style="border-left: dashed 1px #ccc;min-width: 250px;"> 
                            <h3 style="text-align: right;"><i class="icon-eye-open"></i>  Xem trước</h3>
                            <div class="productItem <?php echo $product->category->getStyleName(); ?>" style="width: 80%;float:right;">
                                <div class="row-fluid">
                                    <div class="product-detail">
                                        <div class="productImageLink fileupload" data-provides="fileupload">
                                            <a target="_blank" href="#" class="productLink" title="Laptop think pad">
                                                <img class="productImage" src="http://www.placehold.it/300x300/EFEFEF/AAAAAA&text=Hình+SP" alt="Laptop think pad">                                                         
                                            </a>
                                        </div>                
                                        <div class="productImageInfo">
                                            <div class="productImageTitle">TÊN SẢN PHẨM</div>
                                            <hr class="sep_item">                                            
                                        </div>
                                        <div class="productDescription">
                                            Mô tả sản phẩm           </div>
                                        
                                        <div class="productCreateDate" style="position: relative;">
                                            <div class="productImagePrice" style="font-size: 1.8em;">0,000 đ</div>                    
                                        </div>            
                                    </div>

                                </div>
                            </div>
                                  <?php
                                  if(!$hasContactInfo)
                                  {
                                        echo CHtml::link('<i class="icon-arrow-right"></i>   Tiếp tục', '#', array(
                                            'class' => 'btn btn-info btn-large flat pull-right',                                        
                                            'id' => 'btnFinishStep1',
                                            'style'=>'margin-top:10px;'
                                        ));           
                                  }
                                  else
                                  {
                                        echo CHtml::submitButton('Hoàn tất', array(
                                            'id' => 'btnFinishStep2',
                                            'class' => 'btn btn-success pull-right btn-large flat',
                                            'data-loading-text' => 'Đang tải...',
                                             'style'=>'margin-top:10px;'
                                        ));
                                  }
                                ?>
                        </div>                          
                    </div>                           
                </div>    
                <div id="uploadStep2">
                    <div class="row-fluid">
                        <div class='span12'>                
                            <div class="rb-form-part">                    
                                <?php echo $form->dropDownListRow($product, 'city', CityUtil::getCityListData(true),array('style'=>'min-width:300px;')); ?>

                                <div id="advanceFeature">                    
                                    <?php
                                    echo $form->textFieldRow($product, 'locationText', array(
                                        'placeholder' => 'Nhập vào địa chỉ và bấm enter',
                                        'style'=>'min-width:260px;'
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
                                    'class' => 'btn btn-success pull-right btn-large flat',
                                    'data-loading-text' => 'Đang tải...'
                                ));
                                ?>
                                <?php
                                echo CHtml::link('<i class="icon-arrow-left"></i>   Quay lại', '#', array(
                                    'class' => 'btn btn-info pull-left btn-large flat',
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