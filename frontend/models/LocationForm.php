<?php

class LocationForm extends CFormModel{
    public $address;
    public $lat;
    public $lng;
    public $city;
    public function rules(){
        return array(
            array('address','length','max'=>100),
            array('city,lat,lng','numerical'),
            arraY('address,lat,lng','required')
        );
    }
    
    public function attributeLabels()
    {
        return array(
            'address'=>'Địa chỉ'
        );
    }        
    
}