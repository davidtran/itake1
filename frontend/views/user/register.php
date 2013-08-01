<?php
$this->pageTitle = 'Tạo tài khoản vào '.Yii::app()->name;

//$this->showHeader = false;
?>


<div class="container-fluid" style="margin-top: 74px;">
   <div class="row-fluid">
        <div class="span8 offset2">
        <h2 class="form-signin-heading"><i class="icon-group"></i>  Gia nhập itake</h2>  
        <hr/>
        </div>
    </div>
  <div class="row-fluid">
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
          'placeholder'=>'Địa chỉ email',
          'class'=>'input-block-level'
          )); ?>
        <?php
        echo $form->textFieldRow($user, 'username', array(
          'placeholder' => 'Tên của bạn',
          'class' => 'input-block-level'
          ));
          ?>
          <?php
          echo $form->passwordFieldRow($user, 'password', array(
            'placeholder' => 'Mật khẩu',
            'class' => 'input-block-level'
            ));
            ?>
            <button class="btn btn-success login" type="submit" style="width:100%;height:50px;font-size:1.3em;">Tạo tài khoản</button>                                  
          </div>  
          <div class="span4">
           <div style="float:right;width:100%;margin-top:50px;">
            <!--     <p style="font-family: 'Segoe UI Light',Arial,Helvetica,sans-serif;font-size:1.1em;">Dễ dàng chia sẽ tin đăng. ITAKE kết nối tới facebook của bạn để việc bán hàng của bạn nhanh chóng hơn, tiếp thị sản phẩm thêm hiệu quả. Hãy đăng nhập bằng facebook để chia sẻ sản phẩm bạn tới bạn bè trên facebook một cách tốt nhất.</p> -->                            
           <h4 class="rb-h4" style="text-align: center;">HOẶC ĐĂNG KÝ BẰNG</h4>
              <div class="fb-login-wrapper"> 
                <?php echo CHtml::link('', FacebookUtil::makeFacebookLoginUrl($this->createAbsoluteUrl('register')), array('class' => 'facebook-login')); ?>
              </div>     
          </div>
        </div>       
        <?php $this->endWidget(); ?>       
      </div>
    </div>