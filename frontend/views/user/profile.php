<?php 
    Yii::app()->
clientScript->registerScriptFile('http://maps.google.com/maps/api/js?sensor=true',CClientScript::POS_HEAD,false);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/gmaps.js',CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/masonry.pkgd.min.js',CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.infinitescroll.min.js',CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/nada/productDetails.js',CClientScript::POS_BEGIN);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/upclick-min.js',CClientScript::POS_BEGIN);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/nada/user.js',CClientScript::POS_BEGIN);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/nada/productControl.js',CClientScript::POS_BEGIN);
    $this->pageTitle = LanguageUtil::t('Product List -').'  '.LanguageUtil::t($user->username);
    $userData = CJSON::encode(JsonRenderAdapter::renderUser($user));
    Yii::app()->clientScript->registerScript('userdata',"var user = $userData;",  CClientScript::POS_HEAD);
?>
<div class="row-fluid profile-page">
    <div class="span2">
        <div class='nd_profile'>
            <div class="top">
                <div class="row-fluid">
                    <div class="span12 profile-name">
                        <div class="avatar">
                            <?php echo UserImageUtil::renderImage($user,array(
                'width'=>
                            100,
                'height'=>100,
                'style'=>'width: 100px;
                          height: 100px;',
                'class'=>'img-circle',
            )); ?>
                        </div>
                        <h3>
                            <?php echo $user->username;?></h3>
                    </div>                   
                </div>
                <?php if(UserUtil::canEdit($user)):?>
                <!--            <div id="bannerChanger">Đổi banner</div>
            -->
            <?php endif; ?>

            <div class="profile_detail">
                <div class="row-fluid">
                     <p class="alert alert-success"><?php echo $user->target;?></p>
                </div>
                <hr>
                 <div class="row-fluid">
                    <p><?php echo count($productDataProvider->getData());?> sản phẩm</p>
                </div>                
                <hr>                
                 
                 <div class="row-fluid">
                    <p><strong>Hotline mua hàng </strong><?php echo $user->phone;?></p>
                </div>
                <hr>
                 <?php if(UserUtil::canEdit($user)):?>               
                <div class="row-fluid">
                    <?php echo CHtml::link('<i class="icon-cogs"></i>
                Cập nhật thông tin',$this->createUrl('user/editProfile'),array(
                        'class'=>'btn btn-success center',
                    )); ?>                      
                </div>
                <?php endif; ?>
            </div>
    </div>
</div>
</div>
<div class="span10">
<div class="row-fluid">
    <div class="span8">
        <h1 class="title_font">
            Danh sách sản phẩm của
            <?php echo $user->username ?></h1>
    </div>
    <div class="span4 ">
        <div class="pagination pagination-centered pull-right" style="z-index: 999;
position: relative;right:30px;">
            <ul>
                <li class="active">
                    <a id="linkSort_0" href="/market/sortType.html?type=0">Đang bán</a>
                </li>
                <li>
                    <a href="/market/sold.html">Đã bán</a>
                </li>
            </ul>
        </div>
    </div>

</div>
<div class="row-fluid" id="fixWidthMasory"></div>
<?php
            if(count($productDataProvider->
getData())>0)
            {
            ?>
<?php $this->
renderPartial('_userProductBoard',array(
                'productList'=>$productDataProvider->getData(),
                'page'=>0,
                'user'=>$user
            ));

            }else {?>
<div class="alert alert-block">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h4>Bạn chưa có sản phẩm nào!</h4>

</div>
<?php } ?></div>
</div>
<div id="userProductLoading"></div>
<?php echo $this->
renderPartial('/site/_productDialog',array(),true,false); ?>
<?php Yii::app()->
clientScript->registerScript('layout-customize',
    "
    $('div.nd_profile').css('height',($(window).height() - 60)+'px');
    var div_parent = $('div.nd_profile').parent();
    $('div.nd_profile').css('width',($(div_parent).width())+'px');
    ", 
     CClientScript::POS_END); ?>