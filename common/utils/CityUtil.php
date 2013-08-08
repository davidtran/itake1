<?php

class CityUtil{
    const ALL_ID= 0;
    protected static $cityList = array(
        self::ALL_ID=>array(
            'name'=>'All cities',
            'hasLocation'=>false
        ),
        1=>array(
            'name'=>'Ha Noi',
            'englishName'=>'Hanoi',
            'hasLocation'=>true,
            'latitude'=>21.022983,
            'longitude'=>105.831878
        ),
        2=>array(
            'name'=>'Ho Chi Minh',
            'englishName'=>'Ho Chi Minh',
            'hasLocation'=>true,
            'latitude'=>10.771602,
            'longitude'=>106.69837
        ),        
        3=>array(
            'name'=>'Da Nang',
            'englishName'=>'Da Nang',
            'hasLocation'=>true,
            'latitude'=>16.051505,
            'longitude'=>108.214853
        ),        
    );
    
    public static function getCityList($excludeAllSelect = false){
        $countryCode = 'vi';
        $country = Country::model()->find('code=:code',array(':code' =>$countryCode));
        $cities = $country->cities;
        $cityList = array();
         array_push($cityList, array(
                'name'=>'All cities',
                'hasLocation'=>false
        ));
        foreach ($cities as $city) {
           array_push($cityList, array(
                'name'=>$city->name,
                'englishName'=>$city->name,
                'hasLocation'=>true,
                'latitude'=>$city->latitude,
                'longitude'=>$city->longitude
           ));
        }
        $list =  $cities;
        if($excludeAllSelect){
            unset($list[self::ALL_ID]);
        }
        return $list;
        
    }
    
    /**
     * friendly data type for dropdown list
     */
    public static function getCityListData($excludeAllSelect = false){
        $rs = array();
        foreach(self::$cityList as $id=>$cityInfo){            
            $rs[$id] = $cityInfo['name'];
        }
        if($excludeAllSelect) {
            $rs[self::ALL_ID] = '(Thành phố)';
        }
        
        return $rs;
    }
    public static function getCityName($id){
        return isset(self::$cityList[$id])?LanguageUtil::t(self::$cityList[$id]['name']):false;
    }
    
    public static function makeSelectCityUrl($id){
        $name = self::getCityName($id);
        if($name != false){
            return Yii::app()->controller->createUrl(
                    '/site/city',
                    array(
                        'id'=>$id,
                        'name'=>StringUtil::makeSlug($name)
                    )
                );
        }
        return false;
    }
    
    public static function getSelectedCityId(){
        if(isset(Yii::app()->session['LastCity'])){
            return Yii::app()->session['LastCity'];
        }else{
            Yii::app()->session['LastCity'] = 0;
            return 0;
        }
    }
}
