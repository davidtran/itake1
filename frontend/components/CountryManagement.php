<?php

class CountryManagement extends CApplicationComponent {

    public $defaultCountry = 'vn';
    protected $currentCountry = null;
    protected $currentCountryId = null;
    protected $countryModel = null;
    public function init() {
        $this->currentCountry = $this->getCountry();
        if ($this->currentCountry != false) {
            
            $this->setCountry($this->currentCountry);
        }else{
            $this->currentCountry = $this->defaultCountry;
            $this->setCountry($this->currentCountry);
        }
        return parent::init();
    }

    public function getCountry() {
        if (isset(Yii::app()->session[$this->getStoreKey()])) {
            return Yii::app()->session[$this->getStoreKey()];
        }

        if (Yii::app()->user->isGuest == false) {
            $meta = UserMetaUtil::findMeta(Yii::app()->user->getId(), $this->getStoreKey());
            if ($meta != null) {
                return $meta->value;
            }
        }

        if (isset(Yii::app()->request->cookies[md5($this->getStoreKey())])) {
            return Yii::app()->request->cookies[md5($this->getStoreKey())]->value;
        }

        try {
            $ip = CountryUtil::detectCountryById(Yii::app()->request->getUserHostAddress());
            return $ip;
        }
        catch (Exception $e) {
            //do nothing
        }

        return false;
    }

    public function setCountry($country) {
        $countryModel = Country::model()->find('code=:code', array(
            'code' => $country
        ));
        
        if ($countryModel != null) {
        
            $this->currentCountryId = $countryModel->id;
            $this->countryModel = $countryModel;
            if (Yii::app()->user->isGuest == false) {
                UserMetaUtil::setMeta(Yii::app()->user->getId(), $this->getStoreKey(), $country);
            }

            Yii::app()->request->cookies[md5($this->getStoreKey())] = new CHttpCookie(md5($this->getStoreKey()), $country);

            Yii::app()->session[$this->getStoreKey()] = $country;
        }
        else {
            throw new CException('Can not find country');
        }
    }

    protected function getStoreKey() {
        return 'UserCountryKey';
    }

    public function getCode() {
        return $this->currentCountry;
    }

    public function getId() {
        return $this->currentCountryId;
    }        
    
    public function getModel(){
        return $this->countryModel;
    }

}