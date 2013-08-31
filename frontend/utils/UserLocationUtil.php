<?php

class UserLocationUtil
{

    protected static $instance = null;

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
        $this->location = $this->getLocation();
    }

    public function setLocation($value)
    {
        UserRegistry::getInstance(true,false)->getValue('UserLocation');
    }

    public function getLocation()
    {
        return UserRegistry::getInstance(true,false)->getValue('UserLocation',false);
    }

}