<div id="categories-bar">          
    <div class="row-fluid">     
        <ul>
            <li><a href="<?php echo Yii::app()->createUrl('/site/index') ?>" title="<?php echo LanguageUtil::t('All')?>"><span class="nav-text all-cat-wrap selected mark"><small class="all-cat"></small><em></em>     &nbsp&nbsp<?php LanguageUtil::echoT('All') ?></span></a></li>                                                      
            <?php foreach (CategoryUtil::getCategoryList() as $category): ?>
                <li><a href="<?php echo $category->getUrl(); ?>" title='<?php echo LanguageUtil::t($category->name)?>'><span class="nav-text <?php echo $category->getStyleName(); ?>"><small><i class="<?php echo $category->icon; ?> icon-large"></i> <em></em></small>      &nbsp&nbsp<?php LanguageUtil::echoT( $category->name);  ?></span></a></li>
            <?php endforeach; ?>                    
        </ul>
    </div>    
</div>     