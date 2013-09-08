<li class="span4">
    <div class="thumbnail categoryItem <?php echo $category->getStyleName(); ?>" id="categoryItem-<?php echo $category->id; ?>">
        <div class="row-fluid">
            <?php echo CHtml::image($category->image,$category->name,array(
                'onError'=>"this.src='http://www.placehold.it/300x300/EFEFEF/AAAAAA&text=Danh mục';"
            )); ?>

            <div class="row-fluid">
                <h3><?php echo $category->name; ?></h3>
                <p>
                    <?php echo $category->description; ?>
                </p>

            </div>
        </div>
    </div>
</li>
