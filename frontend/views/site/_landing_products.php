<div class="row-fluid">
    <?php
        foreach($listProducts as $item)
        {
    ?>
     <?php if($item->images):?>
    <div class="intro-item-product">
       
           <a href="<?php echo $item->getDetailUrl(); ?>">
               <img src="<?php echo $item->images[0]->thumbnail; ?>"/>        
            </a>
    </div>    
    <?php endif;?>
    <?php
        }
    ?>
    
</div>