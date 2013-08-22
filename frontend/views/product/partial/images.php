<div class="flexslider">
    <ul class="slides">
        <?php foreach ($product->images as $image): ?>

            <li data-thumb="<?php echo Yii::app()->baseUrl . '/' . $image->thumbnail; ?>">
                <img class="img-polaroid" alt='<?php echo $product->title; ?>' src="<?php echo Yii::app()->baseUrl . '/' . $image->image; ?>" onError="this.onerror=null;this.src='http://www.placehold.it/400x400/EFEFEF/AAAAAA&text=<?php echo Yii::t('Default', 'Missing image'); ?>';"/>
            </li>


        <?php endforeach; ?>
    </ul>
</div>
