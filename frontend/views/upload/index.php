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
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/nada/upload-address.js?id=1', CClientScript::POS_END);
?>
<div class="row-fluid upload">
    <div class="container-fluid">
        <div class="customupload">    
            <div class="row-fluid" style="margin-bottom:20px;"> 
                <div class="span8">    
                     <div class="row-fluid">
                        <h3 style="text-align: center;" class="title_font"><i class="icon-hand-right"></i>   <?php 
                                echo LanguageUtil::t('Post Ad to').'  '.$product->category->name ;
                                $this->pageTitle = LanguageUtil::t('Post Ad to').'  '.$product->category->name;
                            ?>
                        </h3>
                    </div>                    
                </div>
                <div class="span4">
                        <h3 style="text-align: right;" class="title_font"><i class="icon-eye-open"></i>  <?php LanguageUtil::echoT('Preview') ?></h3>
                </div>
            </div>
            <div class="row-fluid">
              
                <div id="uploadStep1">
                    <div class="row-fluid">
                        <div class="span8">                                
                            <div class="row-fluid">                               
                                <div class="span6" style="min-width:250px;">                                    
                                    <div class="rb-form-part" style="text-align:center;">                          
                                  
                                        <div class="alert alert-info" style="text-align: justify;background:transparent;border:none;max-width:180px;margin:0 auto;">

                                            <?php echo Yii::t('Default','<b>Warning:</b> The width of your image is larger than {width} pxs and its height is taller than {height} pxs',array('{width}'=>Yii::app()->params['image.minWidth'],'{height}'=>Yii::app()->params['image.minHeight'])) ?>
                                        </div>                                   
                                        <?php 
                                        $this->widget( 'frontend.extensions.xupload.XUpload', array(
                                            'url' => Yii::app( )->createUrl( "/upload/upload"),
                                            //our XUploadForm
                                            'model' => $photos,
                                            //We set this for the widget to be able to target our own form
                                            'htmlOptions' => array('id'=>'somemodel-form'),                                            
                                            'showForm'=>true,
                                            'attribute' => 'file',
                                            'multiple' => true,
                                            'autoUpload'=>true,
                                            //Note that we are using a custom view for our widget
                                            //Thats becase the default widget includes the 'form' 
                                            //which we don't want here
                                            'formView' => 'application.views.upload.partial.ajaxForm',
                                            'downloadView'=>'application.views.upload.partial.ajaxDownload',
                                            'uploadView'=>'application.views.upload.partial.ajaxUpload'
                                            )    
                                        );                                        
                                        ?>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="rb-form-part">                              
                                        <?php
                                        $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                                            'id' => 'uploadProductForm',                   
                                            'htmlOptions' => array(
                                                'enctype' => 'multipart/form-data'
                                            )
                                                ));
                                        ?>
                                        <?php echo $form->errorSummary($product); ?>       
                                        <input type="hidden" value ="<?php echo $product->category_id ?>" id="Product_category_id" name="Product[category_id]"/>                                        
                                        <?php echo $form->textFieldRow($product, 'title'); ?>                                          
                                        <?php echo $form->textFieldRow($product, 'price', array(
                                            'append' => 'VNĐ',                                            
                                            )); ?>                                        
                                        <?php //echo $form->textFieldRow($product, 'phone'); ?>
                                        <?php echo $form->textAreaRow($product, 'description'); ?>                                       
                                        <?php echo $form->hiddenField($product,'address_id'); ?>
                                        <br/>
                                       <!--  <div class="row-fluid" style="margin-bottom:-10px;">
                                            <p class="alert alert-info">Thêm hoặc chọn 1 địa chỉ bên dưới nếu có</p>
                                        </div> -->
                                        <?php echo CHtml::link('<i class="icon-map-marker"></i>  '.LanguageUtil::t('Add your address'),'#',array(
                                            'class'=>'btnAddressDialog flat btn btn-warning',
                                        )); ?>  
                                         <?php echo $form->error($product,'address_id'); ?>
                                        <?php 
                                        $addressList = $this->getAddressList();
                                        $this->renderPartial('partial/addressList',array(
                                            'addressList'=>$addressList
                                        ));
                                        ?>
                                    </div>                                     
                                </div>
                            </div>                           
                        </div>
                        <div class="span3 pull-right" style="border-left: dashed 1px #ccc;min-width: 250px;">                             
                            
                            <div class="productItem <?php echo $product->category->getStyleName(); ?>" style="width: 80%;float:right;">
                                <div class="row-fluid">
                                    <div class="product-detail">
                                        <div class="productImageLink fileupload" data-provides="fileupload">
                                            <a target="_blank" href="#" class="productLink" title="">
                                                <?php if($product->image == null):?>
                                                    <img class="productImage" src="http://www.placehold.it/300x300/EFEFEF/AAAAAA&text=<?php LanguageUtil::echoT('Your+ad+image') ?>">                                                         
                                                <?php else:?>
                                                    <?php echo CHtml::image(Yii::app()->baseUrl.'/'.$product->image,'',array(
                                                        'class'=>'productImage',
                                                        'onError'=>"this.onerror=null;this.src='http://www.placehold.it/300x300/EFEFEF/AAAAAA&text=<?php LanguageUtil::echoT('Your+ad+image') ?>';"
                                                    ));?>
                                                <?php endif; ?>
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
                                
                                <div class="row-fluid">  
                              
                                <?php                   
                                    $submitText = $product->isNewRecord ? LanguageUtil::t('Post Ad'): LanguageUtil::t('Update');
                                    echo CHtml::submitButton($submitText, array(
                                        'id' => 'btnFinishStep2',
                                        'encode'=>false,
                                        'class' => 'btn btn-success pull-left btn-large flat',
                                        'data-loading-text' => 'Đang gửi...',    
                                        'style'=>"margin-left:10px;"                     
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
<?php $this->renderPartial('partial/addressDialog'); ?>