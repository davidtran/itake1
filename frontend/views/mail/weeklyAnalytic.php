Hi <?php echo $username; ?> <br/>
Weekly summary<br/>
View: <?php echo $summary['view']; ?> <br/>
Like: <?php echo $summary['like']; ?> <br/>
Share: <?php echo $summary['share']; ?> <br/>

Details:<br/>
<?php 
$table = new CI_Table();
$table->set_heading('STT','Product','View','Like','Share');
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
Thanks,
iTake team.