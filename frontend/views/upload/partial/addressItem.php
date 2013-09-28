<div class='addressItem' style="margin-top:10px;">
    <div class="row-fluid" style="margin-top:3px;margin:-5px;">
    <div class="span6">
    <?php echo CHtml::image(UploadProductUtil::getStaticGoogleMapUrl($address),'',array(
    'class'=>'googlemap img-rounded'
 )); ?>
</div>    
    <div class="span6" style="padding:5px;">
         <!-- <a class="close btnDeleteAddress" data-address-id="<?php echo $address->id; ?>" href="#">&times;</a> -->
            <input type='radio' name='address-item' class='radio-address-item' value='<?php echo $address->id; ?>'/>
            <?php echo '<i class="icon-phone-sign"></i>  '.$address->phone; ?><br/>            
            <?php if(trim($address->address)!=''):?>
                <?php echo $address->address; ?>
                <br/>                
            <?php endif; ?>
             <?php echo '   &nbsp;&nbsp;&nbsp;&nbsp;  <i class="icon-map-marker"></i>  '.CityUtil::getCityName($address->city); ?> 
    </div>    
    </div>
</div>