<?php

class CityUtil{
    const ALL_ID= 0;
    protected static $cityList = array(
        self::ALL_ID=>array(
            'name'=>'Toàn quốc',
            'hasLocation'=>false
        ),
        1=>array(
            'name'=>'Hà Nội',
            'englishName'=>'Hanoi',
            'hasLocation'=>true,
            'latitude'=>21.022983,
            'longitude'=>105.831878
        ),
        2=>array(
            'name'=>'Hồ Chí Minh',
            'englishName'=>'Ho Chi Minh',
            'hasLocation'=>true,
            'latitude'=>10.771602,
            'longitude'=>106.69837
        ),        
        3=>array(
            'name'=>'Đà Nẵng',
            'englishName'=>'Da Nang',
            'hasLocation'=>true,
            'latitude'=>16.051505,
            'longitude'=>108.214853
        ),        
    );
    
    public static function getCityList($excludeAllSelect = false){
        
        $list =  self::$cityList;
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
            $rs[self::ALL_ID] = '(Tinh thanh)';
        }
        
        return $rs;
    }
    public static function getCityName($id){
        return isset(self::$cityList[$id])?self::$cityList[$id]['name']:false;
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
