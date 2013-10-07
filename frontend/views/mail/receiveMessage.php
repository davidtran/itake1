<h3><span style="font-size:13px; line-height:1.2em"><?php echo Yii::t('translatemail','Dear');?></span><span style="font-size:13px; line-height:1.2em">&nbsp;<?php echo $receiverName; ?></span><span style="font-size:13px; line-height:1.2em">,</span></h3>

<p><?php echo Yii::t('translatemail','You have got a new message from');?> <b><?php echo $senderName; ?></b> 
 cho sản phẩm <?php echo CHtml::link($productTitle,$productLink); ?>
 </p>

<blockquote>
<p><?php echo $message; ?></p>
</blockquote>

<p><?php echo Yii::t('translatemail','Best Regards');?>,</p>

<h3><strong>ITAKE TEAM</strong></h3>

<p><a href="http://itake.me">http://itake.me</a></p>