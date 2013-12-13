<h3><span style="font-size:13px; line-height:1.2em"><?php echo Yii::t('translatemail','Dear');?></span><span style="font-size:13px; line-height:1.2em">&nbsp;<?php echo $username; ?></span><span style="font-size:13px; line-height:1.2em">,</span></h3>

<p><?php echo Yii::t('translatemail','Please finish your activation on itake.me by click the link below');?>:</p>

<p><?php echo CHtml::link($verifyUrl,$verifyUrl); ?></p>

<p><?php echo Yii::t('translatemail','Best Regards');?>,</p>

<h3><strong>ITAKE TEAM</strong></h3>

<p><a href="http://itake.me">http://itake.me</a></p>