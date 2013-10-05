<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/btfileupload/bootstrap-fileupload.min.js', CClientScript::POS_HEAD);
$cs->registerCssFile(Yii::app()->baseUrl . '/js/btfileupload/bootstrap-fileupload.min.css');
Yii::app()->clientScript->registerScriptFile('//maps.google.com/maps/api/js?sensor=false', CClientScript::POS_END,false);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/gmaps.js', CClientScript::POS_END);
$placeholderImage = "http://www.placehold.it/300x300/EFEFEF/AAAAAA&text=" . Yii::t('Default', 'Your ad image');
$productInfo = json_encode($product->attributes);
$cityList = json_encode(CityUtil::getCityList(true));
$contactInfo = json_encode(UserUtil::getContactInfo());
$isNewRecord = $product->isNewRecord ? 'true' : 'false';
$noAddress = Yii::app()->user->model->addressCount == 0 ? 'true' : 'false';
$cs->registerScript('product info', "
    var product = $productInfo;
    var cityList = $cityList;
    var isNewRecord = $isNewRecord;
    var contactInfo = $contactInfo;
    var noAddress = $noAddress;
    var placeholderImage = '$placeholderImage'    "
        , CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/nada/upload-product.js?id=1', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/nada/map-util.js?id=1', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/nada/upload-address.js?id=1', CClientScript::POS_END);
?>
<div class="row-fluid upload">
    <div class="container-fluid">
        <div class="customupload">
            <div class="row-fluid" style="margin-bottom:20px;">
                <div class="span12">
                    <div class="row-fluid">
                        <h3 style="text-align: center;text-transform: uppercase;margin-bottom: 0px;" class="title_font"> <?php
                            echo LanguageUtil::t('Post Ad to') . '  ' . LanguageUtil::t($product->category->name);
                            $this->pageTitle = LanguageUtil::t('Post Ad to') . '  ' . LanguageUtil::t($product->category->name);
                            ?>
                        </h3>
                    </div>
                </div>
                <!--                    <div class="span4 hidden-phone">-->
                <!--                        <h3 style="text-align: right;" class="title_font"><i class="icon-eye-open"></i>  --><?php //LanguageUtil::echoT('Preview')  ?><!--</h3>-->
                <!--                    </div>-->
            </div>
            <div class="row-fluid" style="color: graytext">
                <div class="span4 center">
                    <span class="icon-stack icon-2x">
                        <i class="icon-circle icon-stack-base"></i>
                        <i class="icon-cloud-upload icon-light"></i>
                    </span>
                    Tải những hình ảnh sản phẩm lên
                    <hr class="margin-top-10">
                </div>
                <div class="span5 center">
                    <span class="icon-stack icon-2x">
                        <i class="icon-circle icon-stack-base"></i>
                        <i class="icon-pencil icon-light"></i>
                    </span>
                    Nhập thông tin và chọn địa chỉ liên hệ
                    <hr class="margin-top-10">
                </div>
                <div class="span3 center">
                    <span class="icon-stack icon-2x">
                        <i class="icon-circle icon-stack-base"></i>
                        <i class="icon-flag icon-light"></i>
                    </span>
                    Xem trước, chọn Fanpage và đăng
                    <hr class="margin-top-10">
                </div>

            </div>
            <div class="row-fluid margin-top-20">

                <div id="uploadStep1">
                    <div class="row-fluid">
                        <div class="span4">
                            <div class="row-fluid" style="min-width:220px;">
                                <?php
                                $this->widget('frontend.extensions.xupload.XUpload', array(
                                    'url' => Yii::app()->createUrl("/upload/upload"),
                                    'model' => $photos,
                                    'htmlOptions' => array('id' => 'somemodel-form'),
                                    'showForm' => true,
                                    'attribute' => 'file',
                                    'multiple' => true,
                                    'autoUpload' => true,
                                    'formView' => 'application.views.upload.partial.ajaxForm',
                                    'downloadView' => 'application.views.upload.partial.ajaxDownload',
                                    'uploadView' => 'application.views.upload.partial.ajaxUpload',
                                    'options' => array(
                                        'completed' => 'js:function(e,data){setTimeout(function(){updatePreviewImage();},200)}',
                                        'destroyed' => 'js:function(e,data){setTimeout(function(){updatePreviewImage();},200)}'
                                    )
                                        )
                                );
                                ?>

                                <?php foreach ($product->images as $image): ?>
                                    <?php
                                    $this->renderPartial('partial/uploadedImage', array(
                                        'image' => $image
                                    ));
                                    ?>
                                    <?php endforeach; ?>
                                <p class="alert alert-info" style="text-align: justify;">

                                    <?php echo Yii::t('Default', '<b>Notice:</b> The width of your image is larger than {width} pxs and its height is taller than {height} pxs', array('{width}' => Yii::app()->params['image.minWidth'], '{height}' => Yii::app()->params['image.minHeight'])) ?>

                                    <?php
                                    echo Yii::t('Default', '<b></b>Only allow {maxImage} images per product.', array(
                                        '{maxImage}' => Yii::app()->params['upload.maxImageNumber']
                                    ));
                                    ?>
                                </p>

                            </div>

                        </div>
                        <div class="span5">
                            <?php
                            $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                                'id' => 'uploadProductForm',
                                'type' => 'horizontal',
                                'htmlOptions' => array(
                                    'enctype' => 'multipart/form-data'
                                )
                            ));
                            ?>
                            <?php echo $form->errorSummary($product); ?>
                            <input type="hidden" value ="<?php echo $product->category_id ?>" id="Product_category_id" name="Product[category_id]"/>
                            <?php echo $form->textFieldRow($product, 'title', array('class' => 'span12', 'require')); ?>
                            <?php
                            echo $form->textFieldRow($product, 'price', array(
                                'class' => 'span12'
                            ));
                            ?>
                            <?php //echo $form->textFieldRow($product, 'phone');  ?>
                            <?php echo $form->textAreaRow($product, 'description', array('rows' => 4, 'class' => 'span12')); ?>
                            <?php echo $form->hiddenField($product, 'address_id'); ?>
                            <br/>
                            <!--  <div class="row-fluid" style="margin-bottom:-10px;">
                                 <p class="alert alert-info">Thêm hoặc chọn 1 địa chỉ bên dưới nếu có</p>
                             </div> -->
                            <div class="row-fluid">
                                <div class="control-group ">
                                    <label class="control-label required" for="Product_description"> <?php LanguageUtil::echoT('Address') ?><span class="required">*</span></label>
                                    <div class="row">
                                        <?php
                                        echo CHtml::link('<i class="icon-map-marker"></i>  ' . LanguageUtil::t('Add your address'), '#', array(
                                            'class' => 'btnAddressDialog flat btn pull-right',
                                        ));
                                        ?>
                                        <?php echo $form->error($product, 'address_id'); ?>
                                    </div>
                                    <div class="controls">
                                        <?php
                                        $addressList = $this->getAddressList();
                                        $this->renderPartial('partial/addressList', array(
                                            'addressList' => $addressList
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span3 pull-right" style="min-width: 250px;">
                            <div class="row-fluid">
                                <div class="productItem <?php echo $product->category->getStyleName(); ?> hidden-phone" style="width: 50%;float:right; ">
                                    <div class="row-fluid">
                                        <div class="product-detail">
                                            <div class="productImageLink fileupload" data-provides="fileupload">
                                                <a target="_blank" href="#" class="productLink" title="">
                                                    <?php if ($product->image == null): ?>
                                                        <img class="productImage" src="http://www.placehold.it/300x300/EFEFEF/AAAAAA&text=<?php LanguageUtil::echoT('Your+ad+image') ?>">
                                                    <?php else: ?>
                                                        <?php
                                                        echo CHtml::image(Yii::app()->baseUrl . '/' . $product->image, '', array(
                                                            'class' => 'productImage',
                                                            'onError' => "this.onerror=null;this.src='http://www.placehold.it/300x300/EFEFEF/AAAAAA&text=<?php LanguageUtil::echoT('Your+ad+image') ?>';"
                                                        ));
                                                        ?>
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
                            </div>
                            <br/>
                            <hr/>
                            <br/>
                            <div class="row-fluid">
                                <?php if (FacebookUtil::getInstance()->doUserHaveEnoughUploadPermission() == true): ?>                                        
                                    <div class="row-fluid" style="margin-left:10px;">
                                        <?php echo $form->checkBoxRow($product, 'uploadToFacebook'); ?>
                                    </div>                                        
                                    <p>
                                    </p>                                        
                                    <?php $pages = $this->getFacebookPageListData() ?>                                        
                                    <div class="row-fluid" style="margin-left:10px;">
                                        <label><?php echo LanguageUtil::t('Please choose one or many fanpages to share your post (optional)'); ?></label>
                                        <?php echo CHtml::checkBoxList('FacebookPage[]', '', $pages); ?>
                                    </div>                                                                         
                                <?php elseif(strlen(Yii::app()->user->model->fbId)>0): ?>
                                    <div class="row-fluid" style="margin-left:10px;">
                                        Kết nối tới Facebook bị lỗi hoặc iTake chưa đủ quyền để đăng tin lên profile và fanpage do bạn quản lý.
                                        <br/>
                                    <?php echo FacebookUtil::getInstance()->makeFacebookLoginLink('Click để kết nối iTake với Facebook',  Yii::app()->controller->createUrl('upload/index',array('category'=>$product->category->id,'name'=>$product->category->name))); ?>
                                    </div>
                                <?php else:?>
                                    Bạn chưa kết nối tài khoản với facebook nên bạn không thể đăng tin lên facebook của bạn và fanpage bán hàng.
                                    <br/>
                                    <?php echo FacebookUtil::getInstance()->makeFacebookLoginLink('Click để kết nối iTake với Facebook',  Yii::app()->controller->createUrl('upload/index',array('category'=>$product->category->id,'name'=>$product->category->name))); ?>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="row-fluid">
                <hr/>
                <?php
                $submitText = $product->isNewRecord ? LanguageUtil::t('Post Ad') : LanguageUtil::t('Update');
                echo CHtml::submitButton($submitText, array(
                    'id' => 'btnFinishStep2',
                    'encode' => false,
                    'class' => 'btn btn-success pull-right btn-large flat',
                    'data-loading-text' => 'Đang gửi...',
                    'style' => "margin-left:10px;margin-top:10px;"
                ));
                ?>

            </div>
<?php $this->endWidget(); ?>
        </div>
    </div>
</div>
</div>
<?php
$this->renderPartial('partial/addressDialog', array(
    'address' => $address
));
?>