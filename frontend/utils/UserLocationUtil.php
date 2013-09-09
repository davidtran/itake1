<?php

class UserLocationUtil
{

    protected static $instance = null;
    
    public $lat;
    public $lng;
    public $address;
    public $city;

    /**
     * Singleton
     * @return UserLocationUtil
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function __construct()
    {
        
    }             

    public function __set($name, $value)
    {
        UserRegistry::getInstance(true,false)->setValue('UserLocation_'.$name,$value);
    }
    
    public function __get($name)
    {
        return UserRegistry::getInstance(true,false)->getValue($name, null);
    }

}