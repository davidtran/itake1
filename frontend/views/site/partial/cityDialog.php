<div class="row-fluid">    
    <div class="modal hide fade" id='locationDialog' style="top:50%;">        
        <div class="modal-body" > 
            <div class="row-fluid">
                <h1><?php LanguageUtil::echoT('Please choose a city') ?></h1>
            </div>
            <?php
                $listCities = CityUtil::getCityList(true);  
            ?>
            <?php foreach ( $listCities as $cityId=>$city) {
               ?>

                <div class="row-fluid">
                    <a class="btn span6 offset3"href="<?php echo Yii::app()->createUrl('site/city',array('id'=>$cityId,'category'=>''))?>"><?php echo LanguageUtil::t($city['name']); ?></a>
                </div>       
               <?php
               //CityUtil::makeSelectCitychooseUrl($city),
            } ?>
              
        </div>
    </div>
</div>

