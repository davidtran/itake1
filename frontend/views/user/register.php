<?php
$this->pageTitle = LanguageUtil::t('Participate in').' '.Yii::app()->name;

//$this->showHeader = false;
?>


<div class="container-fluid" style="margin-top: 24px;">
   <div class="row-fluid">
        <div class="span8 offset2">
        <h2 class="form-signin-heading"><i class="icon-group"></i> <?php LanguageUtil::echoT('Participate in')?> itake</h2>  
        <hr/>
        </div>
    </div>
  <div class="row-fluid margin-top-20">
   <div class="span4 login-panel offset2" style="border-right:dashed 1px #ccc;">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
      'type'=>'inline',
      'htmlOptions' => array(
        'class' => 'form-signin'
        )
      ));
      ?>      
      <?php
      $this->widget('bootstrap.widgets.TbAlert', array(
        'block' => true,
        'fade' => true,
        'closeText' => '×',
        'alerts' => array(
          'success' => array('block' => true, 'fade' => true, 'closeText' => '×'),
          ),
        ));
        ?>      
        <?php echo $form->errorSummary($user); ?>
        <?php echo $form->textFieldRow($user,'email',array(
          'placeholder'=>LanguageUtil::t('Email'),
          'class'=>'input-block-level',
            'autocomplete'=>'off'
          )); ?>
        <?php
        echo $form->textFieldRow($user, 'username', array(
          'placeholder' => LanguageUtil::t('Username'),
          'class' => 'input-block-level',
            'autocomplete'=>'off'
          ));
          ?>
          <?php
          echo $form->passwordFieldRow($user, 'password', array(
            'placeholder' => LanguageUtil::t('Password'),
            'class' => 'input-block-level',
              'autocomplete'=>'off'
            ));
            ?>
       <?php
        $this->widget('Captcha',array(
            'clickableImage'=>true,                      
            'imageOptions'=>array(
                'id'=>'registerCaptchaImage'
            )
        ));
        echo $form->textFieldRow($user,'captcha',array(
            'placeholder' => LanguageUtil::t('Type your letters above to confirm'),
            'class' => 'input-block-level'
        ));
        ?>
            <button class="btn btn-success login" type="submit" style="width:100%;height:50px;font-size:1.3em;"><?php LanguageUtil::echoT('Create an account') ?></button>                                  
          </div>  
          <div class="span4">
           <div style="float:right;width:100%;margin-top:50px;">
            <!--     <p style="font-family: 'Segoe UI Light',Arial,Helvetica,sans-serif;font-size:1.1em;">Dễ dàng chia sẽ tin đăng. ITAKE kết nối tới facebook của bạn để việc bán hàng của bạn nhanh chóng hơn, tiếp thị sản phẩm thêm hiệu quả. Hãy đăng nhập bằng facebook để chia sẻ sản phẩm bạn tới bạn bè trên facebook một cách tốt nhất.</p> -->                            
           <h4 class="rb-h4" style="text-align: center;"><?php LanguageUtil::echoT('OR SIGN UP BY') ?></h4>       
              <div class="fb-login-wrapper"> 
                    <?php if(Yii::app()->language=='vi'): ?>
                     <?php echo CHtml::link('', FacebookUtil::makeFacebookLoginUrl($this->createAbsoluteUrl('/site')), array('class' => 'facebook-login')); ?> 
                    <?php else: ?>            
                       <?php echo CHtml::link('', FacebookUtil::makeFacebookLoginUrl($this->createAbsoluteUrl('/site')), array('class' => 'facebook-login2')); ?>   
                    <?php endif; ?>            
                </div>      
          </div>
        </div>       
        <?php $this->endWidget(); ?>       
      </div>
    </div>