<div id="addressListWrapper" class="slimScroll" data-height="250">
<div id='addressList' style="margin-top:10px;">	
    <?php foreach($addressList as $address):?>
        <?php if($address->status==Address::STATUS_ACTIVE||$address->status==NULL):?>
        <?php echo $this->renderPartial('partial/addressItem',array('address'=>$address)); ?>
        <?php endif;?>
    <?php endforeach; ?>
</div>
</div>

