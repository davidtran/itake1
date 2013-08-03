<div class="row-fluid">
    <div span="span12">
        <div id="message-list">
            <?php foreach($list as $item):?>
                <?php echo $this->renderPartial('partial/listItem',array(
                    'item'=>$item
                )); ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>