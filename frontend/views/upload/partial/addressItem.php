<div class='addressItem'>
    <a class="close btnDeleteAddress" data-address-id="<?php echo $address->id; ?>" "href="#">&times;</a>
    <input type='radio' name='address-item' class='radio-address-item' value='<?php echo $address->id; ?>'/>
    <?php echo CityUtil::getCityName($address->city); ?>
    <br/>
    <?php if(trim($address->address)!=''):?>
        <?php echo $address->address; ?>
        <br/>
    <?php endif; ?>
    <?php echo CHtml::image(UploadProductUtil::getStaticGoogleMapUrl($address),'',array(
        'class'=>'googlemap'
    )); ?>
</div>