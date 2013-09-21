<?php
$this->pageTitle = LanguageUtil::t('Sign In').' ITAKE';

//$this->showHeader = false;
?>
<div class="container-fluid" style="margin-top: 74px;">
    <div class="row-fluid">
        <div class="span8 offset2">
        <h2 class="form-signin-heading"><i class="icon-signin"></i>  <?php LanguageUtil::echoT('Sign In'); ?></h2>          
        <hr/>
        </div>
    </div>
    <div class="row-fluid">
          
        <div class="span8 offset2">
             <div style="width:100%;margin-top: 40px;">
            <!--     <p style="font-family: 'Segoe UI Light',Arial,Helvetica,sans-serif;font-size:1.1em;">Dễ dàng chia sẽ tin đăng. ITAKE kết nối tới facebook của bạn để việc bán hàng của bạn nhanh chóng hơn, tiếp thị sản phẩm thêm hiệu quả. Hãy đăng nhập bằng facebook để chia sẻ sản phẩm bạn tới bạn bè trên facebook một cách tốt nhất.</p> -->                                
                <div class="fb-login-wrapper"> 
                    <?php if(Yii::app()->language=='vi'): ?>
                    <?php echo CHtml::link('', FacebookUtil::makeFacebookLoginUrl($returnUrl), array('class' => 'facebook-login')); ?>       
                    <?php else: ?>            
                      <?php echo CHtml::link('', FacebookUtil::makeFacebookLoginUrl($returnUrl), array('class' => 'facebook-login2')); ?>       
                    <?php endif; ?>            
                </div>    
            </div>
        </div>             
    </div>
    <div class="row-fluid" style="margin-top:20px;">        
        <div class="span8 offset2">            
            <p style="text-align:center;">Để sử dụng chức năng này bạn cần kết nối với Facebook.</p>
        </div>
    </div>
</div>