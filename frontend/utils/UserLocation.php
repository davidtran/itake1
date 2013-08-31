<?php

class UserLocation
{

    protected static $instance = null;

    /**
     * Singleton
     * @return UserLocation
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    protected $location = null;

    public function __construct()
    {
        $this->location = $this->getLocation();
    }

    public function setLocation($value)
    {
        UserMetaUtil::setMeta(Yii::app()->user->getId(), 'UserLocation', $value);
        Yii::app()->user->setState('UserLocation', $value);
    }

    public function getLocation()
    {
        if (Yii::app()->user->getState('UserLocation', false) !== false) {
            return Yii::app()->user->getState('UserLocation');
        }
        else {
            $meta = UserMetaUtil::findMeta(Yii::app()->user->getId(), 'UserLocation');
            if ($meta != null) {
                Yii::app()->user->setState('UserLocation', $meta->value);
            }
            else {
                return false;
            }
        }
    }

}