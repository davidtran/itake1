<?php 
    Yii::app()->clientScript->registerScriptFile('http://maps.google.com/maps/api/js?sensor=true',CClientScript::POS_HEAD,false);
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
<div class='nd_profile'>
    <div class="top" style="background-image: url('<?php echo Yii::app()->baseUrl.'/'.$user->getBanner();?>');background-repeat: no-repeat; ">
        <div style="position:absolute; bottom: 10px; right:10px;z-index:999;">
            <?php echo CHtml::link('<i class="icon-cogs"></i>    Cập nhật thông tin',$this->createUrl('user/editProfile'),array(
                        'class'=>'btnEditProfile btn btn-success pull-right',
                    )); ?>
        </div>
          
        <div class="row-fluid">            
            <div class="span12 profile-name">
                <div class="avatar">
            <?php echo UserImageUtil::renderImage($user,array(
                'width'=>100,
                'height'=>100,
                'style'=>'width: 100px;
                          height: 100px;',
                'class'=>'img-circle',
            )); ?>
            <?php if(UserUtil::canEdit($user)):?>
                <div id="avatarChanger">
                    <i class="icon-edit-sign icon-2x"></i> 
                </div>
            <?php endif; ?>
        </div>   
                <h3><?php echo $user->username;?></h3>
            </div>
        </div>
        <?php if(UserUtil::canEdit($user)):?>
<!--            <div id="bannerChanger">Đổi banner</div>-->
        <?php endif; ?>
    </div>
    <div class="profile_detail"style="display:none;">
<!--        <button type="button" class="btn btn-success">
            <span class="buttonText">Dõi theo</span> 
        </button>-->
        <ul class="userStats" style="float:right;">                     
            <li> <a href="#"><?php echo count($productDataProvider->getData());?> sản phẩm </a> </li>
<!--            <li> <a href="#"> 272 dõi theo </a> </li>-->
        </ul>
    </div>        
</div>
<div class="row-fluid margin-top-20" id="fixWidthMasory"></div>
 <?php
if(count($productDataProvider->getData())>0)
{
?>
<?php $this->renderPartial('_userProductBoard',array(
    'productList'=>$productDataProvider->getData(),
    'page'=>0,
    'user'=>$user
));

}else {?>
<div class="alert alert-block">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h4>Bạn chưa có sản phẩm nào!</h4>

</div>
<?php } ?>
<div id="userProductLoading"></div>
<?php echo $this->renderPartial('/site/_productDialog',array(),true,false); ?>
