<li class="span3">
    <div class="thumbnail categoryItem <?php echo $category->getStyleName(); ?>" id="categoryItem-<?php echo $category->id; ?>">
        <div class="row-fluid">           
            <a  href="<?php echo Yii::app()->createUrl('site/list',array('category'=>$category->id)) ?>" title ="<?php echo LanguageUtil::t($category->name); ?>">
            <?php echo CHtml::image(Yii::app()->baseUrl.'/'.$category->image,$category->name,array(
                'onError'=>"this.src='http://www.placehold.it/300x300/EFEFEF/AAAAAA&text=Danh mục';"
            )); ?>
            </a>

            <div class="row-fluid">
                <b><?php echo $category->name; ?></b>
                <p>
                    <?php echo $category->description; ?>
                </p>

            </div>
        </div>
    </div>
</li>
