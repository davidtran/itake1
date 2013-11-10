<div class="row-fluid">    
    <div class="modal hide fade" id='cityDialog' style="top:50%;">        
        <div class="modal-body" > 
            <div class="row-fluid">
                <h3 class="intro_font center"><?php LanguageUtil::echoT('Please choose a city') ?></h3>
            </div>
            <?php
                $listCities = CityUtil::getCityList(true);  
            ?>
            <?php foreach ( $listCities as $cityId=>$city) {
               ?>

                <div class="row-fluid margin-top-5">
                    <a class="btn span6 offset3 btn-info"href="<?php echo CityUtil::makeSelectCityUrl($cityId)?>"><?php echo LanguageUtil::t($city['name']); ?></a>
                </div>       
               <?php
               //CityUtil::makeSelectCitychooseUrl($city),
            } ?>
              
        </div>
    </div>
</div>

