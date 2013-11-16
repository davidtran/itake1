<?php
Yii::app()->clientScript->registerScript('changeslug','var canChangeSlug = '.CJavaScript::encode($canChangeSlug),  CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/nada/user.js',CClientScript::POS_BEGIN);
?>
<div class='container-fluid'>
	<div class="row-fluid">
		<div class="span12 center ">
      <div class="avatar">
        <?php
            echo UserImageUtil::renderImage($model,array(
            'width' => 70,
            'height' => 70,
            'style' => 'width: 100px;
            height: 100px;',
            'class' => 'img-circle',
            ));
        ?>
		</div>
  </div>
		<h1 class="title_font center" style="color:gray;font-size:1.8em;">
			CẬP NHẬT THÔNG TIN TÀI KHOẢN ITAKE
		</h1>
        <?php if($newUser):?>
        
        <?php endif; ?>
	</div>
	<div class="span8 offset3" id="profile"> 
        <center>
        <p class="alert-success alert">
            Chúc mừng bạn đã đến với itake.me, hãy dành ít phút để cập nhật thông tin của bạn
        </p>
        </center>
    <hr>
    <br>
  	<?php $this->renderPartial('_formProfile',array('model'=>$model)); ?>
	</div>
</div>
<?php if($canChangeSlug):?>
    <?php $this->renderPartial('_changeSlugDialog',array(
        'defaultSlug'=>$defaultSlug
    ));?>
<?php endif; ?>

