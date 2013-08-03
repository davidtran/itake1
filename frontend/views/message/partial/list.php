<div id="messageListContainer">
    <?php foreach($list as $item):?>        
        <?php echo $this->renderPartial('partial/listItem',array('item'=>$item)); ?>
    <?php endforeach; ?>
</div>