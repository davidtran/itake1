<?php
$cs = Yii::app()->clientScript;
Yii::app()->clientScript->registerScriptFile('//maps.google.com/maps/api/js?sensor=false', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/gmaps.js', CClientScript::POS_END);

$productInfo = json_encode($product->attributes);
$cityList = json_encode(CityUtil::getCityList(true));
$isNewRecord = $product->isNewRecord ? 'true' : 'false';
$cs->registerScript('product info', "
    var product = $productInfo;
    var cityList = $cityList;
    var isNewRecord = $isNewRecord;
        "
        , CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/nada/dupload.js', CClientScript::POS_END);
?>
<div class="row-fluid upload">
    <div class="span12">
        <div class="customupload">

            <div class="row-fluid">

                <?php
                $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id' => 'uploadProductForm',
                
                    'htmlOptions' => array(
                        'enctype' => 'multipart/form-data'
                    )
                ));
                ?>
                <?php echo $form->errorSummary($product); ?>       
                <div id="uploadStep1">
                    <div class="row-fluid">

                        <div class="span12"> 
                            <div class="rb-form-part">                              
                                <?php echo $form->textFieldRow($product, 'title'); ?>  

                                <?php echo $form->textFieldRow($product, 'price', array('append' => 'VNĐ')); ?>
                                
                                <?php echo $form->textAreaRow($product, 'description'); ?>
                                <?php echo $form->hiddenField($product, 'category_id'); ?>   
                            </div> 
                            <h3>Hình ảnh</h3>   
                            <?php
                            $this->widget('ext.xupload.XUpload', array(
                                    'url' => Yii::app()->createUrl("/dUpload/upload"),
                                    'model' => $photos,
                                    'htmlOptions' => array('id' => 'uploadProductForm'),
                                    'attribute' => 'file',
                                    'multiple' => true,
                                    'formView' => 'application.views.dUpload.partial.photo_form',
                                    'downloadView' => 'application.views.dUpload.partial.download   ',   
                                )
                            );
                            ?>
                        </div>                 

                    </div>    
                    <div class="row-fluid">
                        <div class='span12'>                
                            <div class="rb-form-part">      
                                <?php echo $form->textFieldRow($product, 'phone'); ?>
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