<?php

class LocationForm extends CFormModel{
    public $address;
    public $lat;
    public $lng;
    public function rules(){
        return array(
            array('address','length','max'=>100),
            array('lat,lng','numerical'),
            arraY('address,lat,lng','required')
        );
    }
    
    public function attributeLabels()
    {
        return array(
            'address'=>'Địa chỉ'
        );
    }
    
    public function save(){
        UserLocation::getInstance()->setLocation(array(
            $this->lat,$this->lng
        ));
    }        
}