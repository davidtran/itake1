<?php

class CountryUtil{
    public static function getDefaultCountryId(){        
        $id = Yii::app()->db->createCommand('select id from {{country}} where code like :code')->queryScalar(array(
            'code'=>Yii::app()->params['country.default']
        ));
        return $id;
    }
}