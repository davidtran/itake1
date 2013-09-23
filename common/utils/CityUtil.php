<?php

class CityUtil
{

    const ALL_ID = 0; 

    public static function getCityList($excludeAllSelect = false)
    {
     
        $cities = Yii::app()->country->getModel()->cities;
        $cityList[self::ALL_ID] = array(
            'name' => 'All cities',
            'hasLocation' => false
        );
        foreach ($cities as $city) {
            $cityList[$city->id] = array(
                'name' => $city->name,
                'englishName' => $city->name,
                'hasLocation' => true,
                'latitude' => $city->latitude,
                'longitude' => $city->longitude
            );
        }
        $list = $cityList;
        if ($excludeAllSelect) {
            unset($list[self::ALL_ID]);
        }
        return $list;
    }

    /**
     * friendly data type for dropdown list
     */
    public static function getCityListData($excludeAllSelect = false)
    {
        $rs = array();
        $cities = self::getCityList($excludeAllSelect);
        foreach ($cities as $cityId => $cityInfo) {
            $rs[$cityId] = $cityInfo['name'];
        }      

        return $rs;
    }

    public static function getCityName($id)
    {
        
        $city = City::model()->findByPk($id);
        if($city != null){
            return LanguageUtil::t($city->name);
        }
        return false;
        
    }

    public static function makeSelectCityUrl($id,$categoryId=NULL)
    {
        $name = self::getCityName($id);
        if ($name != false) {
            return Yii::app()->controller->createUrl(
                            '/site/city', array(
                        'id' => $id,
                        'name' => StringUtil::makeSlug($name),
                        'category'=>$categoryId
                            )
            );
        }
        return false;
    }

    public static function getSelectedCityId()
    {
        return UserRegistry::getInstance()->getValue('LastCity',0);
    }
            
    public static function setSelectedCityId($cityId)
    {
        UserRegistry::getInstance()->setValue('LastCity', $cityId);
    }

}
