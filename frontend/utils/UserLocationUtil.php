<?php

class UserLocationUtil
{

    protected static $instance = null;
    
    protected $attributes = array(
        'lat',
        'lng',
        'address',
        'city'
    );
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
        if(in_array($name,$this->attributes,true)){
            UserRegistry::getInstance(true,true)->setValue('UserLocation_'.$name,$value);
        }
    }
    
    public function __get($name)
    {        
        if(in_array($name,$this->attributes,true)){            
            return UserRegistry::getInstance(true,true)->getValue('UserLocation_'.$name, null);
        }
        
    }
    
    public function removeLocation(){
        $this->lat = null;
        $this->lng = null;
        $this->address = null;
        $this->city = null;
    }

}