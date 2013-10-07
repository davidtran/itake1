<h3><span style="font-size:13px; line-height:1.2em"><?php echo Yii::t('translatemail','Dear');?></span><span style="font-size:13px; line-height:1.2em">&nbsp;<?php echo $username; ?></span><span style="font-size:13px; line-height:1.2em">,</span></h3>

<p><?php echo Yii::t('translatemail','You have just requested a new password for itake ACCOUNT. Please enter the auto generated password below when you sign in ITAKE next time');?>:</p>

<blockquote>
<p><?php echo $newPassword; ?></p>
</blockquote>

<p><?php echo Yii::t('translatemail','After you sign in');?> <strong>iTake</strong>, <?php echo Yii::t('translatemail','please change password by your new password');?>.&nbsp;</p>

<p> <?php echo Yii::t('translatemail','If you get any query during change the password, you could send an email to support@itake.me');?>.</p>

<p><?php echo Yii::t('translatemail','Best Regards');?>,</p>

<h3><strong>ITAKE TEAM</strong></h3>

<p><a href="http://itake.me">http://itake.me</a></p>