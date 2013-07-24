<?php 
    Yii::app()->clientScript->registerScriptFile('http://maps.google.com/maps/api/js?sensor=true',CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/gmaps.js',CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/masonry.pkgd.min.js',CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.infinitescroll.min.js',CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.elevateZoom-2.5.5.min.js', CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/nada/productDetails.js',CClientScript::POS_BEGIN);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/upclick-min.js',CClientScript::POS_BEGIN);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/nada/user.js',CClientScript::POS_BEGIN);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/nada/productControl.js',CClientScript::POS_BEGIN);
?>
<div class='nd_profile'>
    <div class="top" style="background-image: url('<?php echo Yii::app()->baseUrl.'/'.$user->getBanner();?>');background-repeat: no-repeat; background-size:100% 100%;">
        <div class="avatar">
            <?php echo CHtml::image($user->getProfileImageUrl(),$user->username,array(
                'width'=>120,
                'height'=>180,
                'style'=>'width: 120px;
                            height: 120px;',
                'class'=>'img-polaroid',
            )); ?>
            <?php if(UserUtil::canEdit($user)):?>
                <div id="avatarChanger">
                    Đổi avatar
                </div>
            <?php endif; ?>
        </div> 
        <?php if(UserUtil::canEdit($user)):?>
<!--            <div id="bannerChanger">Đổi banner</div>-->
        <?php endif; ?>
    </div>
    <div class="profile_detail">
<!--        <button type="button" class="btn btn-success">
            <span class="buttonText">Dõi theo</span> 
        </button>-->
        <ul class="userStats" style="float:right;">          
<!--            <li> <a href="/incion/boards/" class="active"> 92 Sản phẩm </a> </li>       -->
            <li> <a href="#"><?php echo count($productDataProvider->getData());?> sản phẩm </a> </li>
<!--            <li> <a href="#"> 272 dõi theo </a> </li>-->
        </ul>
    </div>        
</div>
<div class="row-fluid"  style="margin-top:20px;">       
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
            <h4>Ax, chưa có sản phẩm nào!</h4>
            Chưa tải lên sản phẩm nào từ trước. 
        </div>
        <?php } ?>
        <div id="userProductLoading"></div>    
    <?php echo $this->renderPartial('/site/_productDialog',array(),true,false); ?>
</div>