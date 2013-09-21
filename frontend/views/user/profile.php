<?php 
    Yii::app()->clientScript->registerScriptFile('http://maps.google.com/maps/api/js?sensor=true',CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/gmaps.js',CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/masonry.pkgd.min.js',CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.infinitescroll.min.js',CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/nada/productDetails.js',CClientScript::POS_BEGIN);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/upclick-min.js',CClientScript::POS_BEGIN);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/nada/user.js',CClientScript::POS_BEGIN);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/nada/productControl.js',CClientScript::POS_BEGIN);
?>
<div class='nd_profile'>
    <div class="top" style="background-image: url('<?php echo Yii::app()->baseUrl.'/'.$user->getBanner();?>');background-repeat: no-repeat; ">
        <div class="row-fluid">            
            <div class="span6 profile-name">
                <div class="avatar">
            <?php echo UserImageUtil::renderImage($user,array(
                'width'=>120,
                'height'=>120,
                'style'=>'width: 120px;
                          height: 120px;',
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
            <div class="span6"></div>
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
<div class="row-fluid" id="fixWidthMasory"></div>
<div class="row-fluid" id="wrapper_productContainer" style="margin-top:20px;">       
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
</div>