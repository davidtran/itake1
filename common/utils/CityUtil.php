<?php

class CityUtil
{

    const ALL_ID = 0;

    // protected static $cityList = array(
    //     self::ALL_ID=>array(
    //         'name'=>'All cities',
    //         'hasLocation'=>false
    //     ),
    //     1=>array(
    //         'name'=>'Ha Noi',
    //         'englishName'=>'Hanoi',
    //         'hasLocation'=>true,
    //         'latitude'=>21.022983,
    //         'longitude'=>105.831878
    //     ),
    //     2=>array(
    //         'name'=>'Ho Chi Minh',
    //         'englishName'=>'Ho Chi Minh',
    //         'hasLocation'=>true,
    //         'latitude'=>10.771602,
    //         'longitude'=>106.69837
    //     ),        
    //     3=>array(
    //         'name'=>'Da Nang',
    //         'englishName'=>'Da Nang',
    //         'hasLocation'=>true,
    //         'latitude'=>16.051505,
    //         'longitude'=>108.214853
    //     ),        
    // );

    public static function getCityList($excludeAllSelect = false)
    {
        if (isset(Yii::app()->session['client_itake'])) {
            $countryCode = Yii::app()->session['client_itake'];
            $country = Country::model()->find('code=:code', array(':code' => $countryCode));
        }
        else {
            $country = Country::model()->findAll();
        }
        $cities = $country->cities;
        $cityList[0] = array(
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
        if ($excludeAllSelect) {
            $rs[self::ALL_ID] = '(' . LanguageUtil::t('All') . ')';
        }

        return $rs;
    }

    public static function getCityName($id)
    {
        $cities = self::getCityList();
        return isset($cities[$id]) ? LanguageUtil::t($cities[$id]['name']) : false;
    }

    public static function makeSelectCityUrl($id)
    {
        $name = self::getCityName($id);
        if ($name != false) {
            return Yii::app()->controller->createUrl(
                            '/site/city', array(
                        'id' => $id,
                        'name' => StringUtil::makeSlug($name)
                            )
            );
        }
        return false;
    }

    public static function getSelectedCityId()
    {
        if (isset(Yii::app()->session['LastCity'])) {
            return Yii::app()->session['LastCity'];
        }
        else {
            Yii::app()->session['LastCity'] = 0;
            return 0;
        }
    }

    public static function geoCheckIP($ip)
    {
        if (isset(Yii::app()->session['client_itake']))
            return Yii::app()->session['client_itake'];
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            throw new InvalidArgumentException("IP is not valid");
        }

        //contact ip-server
        $response = @file_get_contents('http://www.netip.de/search?query=' . $ip);
        if (empty($response)) {
            throw new InvalidArgumentException("Error contacting Geo-IP-Server");
        }

        //Array containing all regex-patterns necessary to extract ip-geoinfo from page
        $patterns = array();
        $patterns["domain"] = '#Domain: (.*?)&nbsp;#i';
        $patterns["country"] = '#Country: (.*?)&nbsp;#i';
        $patterns["state"] = '#State/Region: (.*?)<br#i';
        $patterns["town"] = '#City: (.*?)<br#i';

        //Array where results will be stored
        $ipInfo = array();

        //check response from ipserver for above patterns
        foreach ($patterns as $key => $pattern) {
            //store the result in array
            $ipInfo[$key] = preg_match($pattern, $response, $value) && !empty($value[1]) ? $value[1] : 'not found';
        }
        $countryCode = strtolower(substr($ipInfo['country'], 0, 2));

        $allCountries = Country::model()->findAll();
        $isContain = false;
        foreach ($allCountries as $idCountry => $ccode) {
            if ($ccode == $countryCode)
                $isContain = true;
        }
        if ($isContain)
        {
            Yii::app()->session['client_itake'] = $countryCode;
            if($countryCode=="vn")
            {
                Yii::app()->language = 'vi';
                Yii::app()->session['itake_lang']="vi";
            }
        }
        else{
            Yii::app()->session['client_itake'] = 'vn';
            Yii::app()->language = 'vi';
        }            
        return Yii::app()->session['client_itake'];
    }

}
