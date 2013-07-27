<div id='addressList'>
    <?php foreach($addressList as $address):?>        
        <?php echo $this->renderPartial('partial/addressItem',array('address'=>$address)); ?>
    <?php endforeach; ?>
</div>

