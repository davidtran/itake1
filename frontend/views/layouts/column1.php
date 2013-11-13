<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="nav-bar-top">
    <div class="nd_logo ">
            <a class="logo" href="<?php 
            $selectCityId = CityUtil::getSelectedCityId();
            if($selectCityId!=0){
                echo CityUtil::makeSelectCityUrl($selectCityId);
            }else{
                echo $this->createUrl('/site'); 
            }
            ?>">
                <img src="/images/logo.png"/>
            </a>
            <small class="visible-desktop"></small>
        </div>
    <div class="frmSearch_wrapper">                          
        <div class="frmSearch">     
            <div class="locations hidden-phone">               
        <div class="btn-group">                      
            <Button class="btn dropdown-toggle" data-toggle="dropdown">                                    <i class="icon-map-marker"></i>
                <?php 
                //$selectCityId = CityUtil::getSelectedCityId();
                $selectCityId = CityUtil::getSelectedCityId();
                echo CityUtil::getCityName($selectCityId); ?>                            
                <span class="caret"></span>
            </Button>
            <ul class="dropdown-menu">
                <?php foreach(CityUtil::getCityListData(true) as $cityId=>$cityName):?>
                    <li>
                        <?php $currentCategory =  isset($_GET['category'])?$_GET['category']:NULL ?>
                    <?php echo CHtml::link(
                        LanguageUtil::t($cityName),
                        CityUtil::makeSelectCityUrl($cityId,$currentCategory),
                        array(
                            'title'=>LanguageUtil::t($cityName)
                            )); ?>       
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>                            
        </div>
<!--                        <div class="categories" data-is-hovering="">                            
                            <button id="categories-btn" class="btn" type="button"><i class="icon-th"></i> Danh mục</button>                            
                        </div>-->
                        <form action="<?php echo $this->createUrl('/site'); ?>" method="GET" name="search" class="navbar-search pull-left">
                            <div class="search_field pull-left">
                                <?php 
                                $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                    'name'=>'city',                                  
                                    'options'=>array(
                                        'minLength'=>'2',
                                        ),
                                    'htmlOptions'=>array(
                                        'style'=>'height:20px;',
                                        'autocomplete'=>'off',
                                        'name'=>'keyword',
                                        'class'=>'search-query',
                                        'placeholder'=>LanguageUtil::t('Search').'...'
                                        ),
                                    'sourceUrl'=>$this->createUrl('/site/suggest')
                                    ));
                                    ?>


                                    <div class="search hidden ui-Typeahead Module" style="display: none;">

                                        <ul class="results"></ul></div>
                                    </div>
                                    <button id="ndsearch_btn" class="submit" type="submit"><?php LanguageUtil::echoT('Search')?></button>
                                </form>
                            </div>   
                            <div class="user-controls hidden-phone">
                                <?php if( Yii::app()->user->isGuest == false ) :?>       
                                <!--                            <a style="margin-top:-5px;" href="<?php echo $this->createUrl('/upload'); ?>" class="btn btn-info" ><i class="icon-upload icon-white"></i>  Đăng bán</a>-->
                                <?php
                                $cates = CategoryUtil::getCategoryList();                                                                           
                                ?>       
                                <div id="listCategory" class="btn-group" style ="margin-top: -5px;">
                                    <a data-toggle="dropdown" class="btn btn-info dropdown-toggle" id="yw0" href="#"><i class="icon-upload"></i>  <?php echo LanguageUtil::echoT('Post Ad') ?> <span class="caret"></span></a>
                                    <ul id="yw1" class="dropdown-menu">
                                        <?php
                                        foreach ($cates as $cat){                                                                                     
                                            ?>
                                            <li>
                                                <a style="display:block; overflow:hidden;" tabindex="-1" href="<?php echo Yii::app()->controller->createUrl('upload/index',array(
                                                    'category'=>$cat->id,
                                                    'name'=>StringUtil::makeSlug($cat->name)
                                                    ));?>"
                                                    title="<?php echo LanguageUtil::t($cat->name)?>"
                                                    >                                                    
                                                    <span class=" label <?php echo $cat->styleName?>">
                                                        <?php echo $cat->iconAndNameHtml;?>
                                                    </span>
                                                    <small><?php echo LanguageUtil::t($cat->name)?></small>                                                    
                                                </a>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <div class="btn-group user-bar avatar-bar">                                 
                                    <a href="<?php echo Yii::app()->user->model->getUserProfileUrl(); ?>" class="btn flat" style="height: 34px;border-radius:0px;background: transparent;line-height: 34px;border-top:none;border-bottom: none;">
                                        <?php echo UserImageUtil::renderImage(Yii::app()->user->model,array(
                                            'width'=>30,
                                            'height'=>30,   
                                            'class'=>'img img-circle',
                                            'style'=>'width:30px; height:30px'
                                        )); ?>                                                                                   
                                   
                                      <em style="color:#000;font-style:normal;">
                                                <?php echo Yii::app()->user->model->username; ?>
                                            </em> 
                                           </a>   
                                        <button class="btn dropdown-toggle" style="height: 100%;border-radius:0px;background: transparent;border-top:none;border-bottom: none;" data-toggle="dropdown">
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" style="border-radius: 0px;">
                                            <li><?php echo CHtml::link(LanguageUtil::t('My profile'),Yii::app()->user->model->getUserProfileUrl()); ?></li>
                                            <li><?php echo CHtml::link(LanguageUtil::t('Update information'),$this->createUrl('/user/editProfile')); ?></li>                                    
                                            <li><a href="<?php echo $this->createUrl('/user/logout'); ?>"><?php LanguageUtil::echoT('Sign out') ?></a></li>
                                        </ul>
                                    </div>
                                <?php else: ?>
                                <!--                            <a href="<?php echo $this->createUrl('/user/register'); ?>" class="btn btn-info" ><i class="icon-user icon-white"></i>  Đăng ký</a>-->
                                    <a href="<?php echo Yii::app()->createUrl('user/register') ?>" class="btn  btn-info" title="Browse the market"><i class="icon-user"></i>  <?php echo LanguageUtil::t('Sign Up') ?></a>
                                    <a href="<?php echo Yii::app()->createUrl('user/login') ?>" class="btn btn-success" title="Browse the market"><i class="icon-signin"></i>  <?php echo LanguageUtil::t('Sign In') ?></a>
            
                            <?php endif; ?>
                        </div>     
                    </div>

                </div>

                <?php echo $content; ?>

                <?php $this->endContent(); ?>
                <?php $this->renderPartial('/feedback/partial/showFeedbackButton'); ?>