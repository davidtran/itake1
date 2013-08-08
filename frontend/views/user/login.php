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
        <div class="span4 login-panel offset2" style="border-right:dashed 1px #ccc;">
            <?php
            $this->widget('bootstrap.widgets.TbAlert', array(
                'block' => true,
                'fade' => true,
                'closeText' => '×',
                'alerts' => array(
                    'error' => array('block' => true, 'fade' => true, 'closeText' => '×'),
                ),
            ));
            ?>
            <?php
            $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                'type' => 'inline',
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
                    'success' => array('block' => true, 'fade' => true, 'closeText' => '×'), // success, info, warning, error or danger
                ),
            ));
            ?>            
            <?php echo $form->errorSummary($model); ?>
            <?php
            echo $form->textFieldRow($model, 'username', array(
                'placeholder' => LanguageUtil::t('Email'),
                'class' => 'input-block-level'
            ));
            ?>
            <?php
            echo $form->passwordFieldRow($model, 'password', array(
                'placeholder' => LanguageUtil::t('Password'),
                'class' => 'input-block-level'
            ));
            ?>
            <?php //echo $form->checkBoxRow($model, 'rememberMe', array('value=1')); ?>
            <div style="float:right;width:100%;text-align: right; font-size:0.9em;">
                <?php echo CHtml::link(LanguageUtil::t('Forgot password').'?', array('/user/forgetPassword')); ?>                
            </div>  
            <div style="float:right;width:100%;">
                <button class="btn btn-primary login" type="submit" style="width:100%;height:50px;font-size:1.3em;"><?php LanguageUtil::echoT('Sign In'); ?></button>
            </div>           
            

            <style>
                #gplusSignIn {
                    display: inline-block;      
                    color: white;
                    width: 350px;      
                    height: 77px;
                    cursor: pointer;
                    background: url('../images/gplus_btn.png') no-repeat;
                    white-space: nowrap;
                }
                #customBtn:hover {
                    background: #e74b37;
                    cursor: hand;
                }
                span.label {
                    font-weight: bold;
                }
                span.icon {      
                    display: inline-block;
                    vertical-align: middle;
                    width: 35px;
                    height: 35px;      
                } 
            </style>
        </div>        
        <div class="span4">
             <div style="float:right;width:100%;margin-top: 40px;">
            <!--     <p style="font-family: 'Segoe UI Light',Arial,Helvetica,sans-serif;font-size:1.1em;">Dễ dàng chia sẽ tin đăng. ITAKE kết nối tới facebook của bạn để việc bán hàng của bạn nhanh chóng hơn, tiếp thị sản phẩm thêm hiệu quả. Hãy đăng nhập bằng facebook để chia sẻ sản phẩm bạn tới bạn bè trên facebook một cách tốt nhất.</p> -->                
                <h4 class="rb-h4" style="text-align: center;"><?php LanguageUtil::echoT('OR SIGN IN BY') ?></h4>
                <div class="fb-login-wrapper"> 
                    <?php if(Yii::app()->language=='vi'): ?>
                    <?php echo CHtml::link('', FacebookUtil::makeFacebookLoginUrl($returnUrl), array('class' => 'facebook-login')); ?>       
                    <?php else: ?>            
                      <?php echo CHtml::link('', FacebookUtil::makeFacebookLoginUrl($returnUrl), array('class' => 'facebook-login2')); ?>       
                    <?php endif; ?>            
                </div>    
            </div>
        </div>       
        <?php $this->endWidget(); ?> 
    </div>
    <div class="row-fluid" style="margin-top:20px;">        
        <div class="span8 offset2">
            <hr/>
            <p style="text-align:center;"><?php LanguageUtil::echoT('You do not have an account') ?>?  <?php echo CHtml::link(LanguageUtil::t('Create an account'), array('/user/register')); ?></p>
        </div>
    </div>
</div>