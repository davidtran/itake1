<div id="addressListWrapper" class="slimScroll" data-height="250">
<div id='addressList' style="margin-top:10px;">	
    <?php foreach($addressList as $address):?>        
        <?php echo $this->renderPartial('partial/addressItem',array('address'=>$address)); ?>
    <?php endforeach; ?>
</div>
</div>

