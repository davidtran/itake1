<p><?php echo Yii::t('translatemail','Dear');?> <?php echo $username; ?>,</p>

<p><span style="line-height:1.6em"><?php echo Yii::t('translatemail','This email is sumary of result social share,view and like report. It will help you get better in your business');?></span></p>

<ul>
	<li><span style="line-height:1.6em"><strong>Total &nbsp;Views &nbsp; &nbsp;</strong>&nbsp; &nbsp;<?php echo $summary['view']; ?>&nbsp;</span></li>
	<li><strong>Total &nbsp;Likes &nbsp; &nbsp; </strong>&nbsp; &nbsp;<?php echo $summary['like']; ?>&nbsp;</li>
	<li><strong>Total Shares &nbsp; &nbsp;</strong>&nbsp; <?php echo $summary['share']; ?>&nbsp;</li>
</ul>

<?php 
$table = new CI_Table();
$table->set_heading('ID','Product','Views','Likes','Shares');
?>
<?php foreach($items as $index=>$item):?>
    <?php $table->add_row(
            $index+1,
            $item['link'],
            $item['view'],
            $item['like'],
            $item['share']
            ); ?>
<?php endforeach; ?>
<?php echo $table->generate(); ?>
<br/>

<h3><?php echo Yii::t('translatemail','If your have any query, feel free to ask via');?> <a href="mailto:support@itake.me?subject=Sale%20Report">support@itake.me</a></h3>

<h3><?php echo Yii::t('translatemail','Best regards');?>,</h3>

<h3><strong>ITAKE TEAM</strong></h3>

<p><a href="http://itake.me">http://itake.me</a></p>
