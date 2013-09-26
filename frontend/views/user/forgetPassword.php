<?php
$this->pageTitle = LanguageUtil::t('Forgot password') ;
?>

    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'htmlOptions' => array(
            'class' => 'form-signin',
            'style'=>'margin-top:64px;'
        )
    ));
    ?>

    <h2 class="form-signin-heading"><?php LanguageUtil::echoT('Forgot password') ?></h2>  
    <hr/>
    <p></p>
    <?php
    if($sent==1):
        ?>
        <p class="alert-success">
            Email kèm mật khẩu mới đã được gởi đến địa chỉ <?php echo $model->email; ?>
        </p>
    <?php elseif($sent==-1): ?>
        <p class="alert-warning">
            Có lỗi trong quá trình lấy lại mật khẩu của bạn
        </p>
    <?php endif; ?>
    <?php echo $form->errorSummary($model); ?>
    <?php
    echo $form->textFieldRow($model, 'email', array(
        'placeholder' => LanguageUtil::t('Enter your email'),
        'class' => 'input-block-level'
    ));
    ?>
    <?php
    $this->widget('CCaptcha');
    echo $form->textFieldRow($model,'captcha',array(
        'placeholder' => LanguageUtil::t('Type your letters above to confirm'),
        'class' => 'input-block-level'
    ));
    ?>

    <hr/>
    <button class="btn btn-primary login" type="submit"><?php LanguageUtil::echoT('Send') ?></button>

    <br/>
    <br/>

    <?php $this->endWidget(); ?>