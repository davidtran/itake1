<?php

class UserRegistry
{

    protected static $instance;
    
    /**
     * 
     * @param type $saveSession
     * @param type $saveMeta
     * @return UserRegistry
     */
    public static function getInstance($saveSession = true, $saveMeta = true)
    {
        if(self::$instance == null){
            self::$instance = new static($saveSession,$saveMeta);            
        }
        return self::$instance;
    }

    protected $saveSession = true;
    protected $saveMeta = true;

    public function __construct($saveSession, $saveMeta)
    {
        $this->saveSession = $saveSession;
        $this->saveMeta = $saveMeta;
    }

    protected $data;

    protected function makeKey($key)
    {
        return 'Registry_' . $key;
    }

    public function getValue($key, $defaultValue = null)
    {
        $key = $this->makeKey($key);
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }

        if ($this->saveSession && isset(Yii::app()->session[$key])) {
            return Yii::app()->session[$key];
        }

        if ($this->saveMeta && Yii::app()->user->isGuest == false) {
            $meta = UserMetaUtil::findMeta(Yii::app()->user->getId(), $key);
            if ($meta != null) {
                return $meta->value;
            }
        }
        return $defaultValue;
    }

    public function setValue($key, $value)
    {
        $key = $this->makeKey($key);
        $this->data[$key] = $value;
        if ($this->saveSession) {
            Yii::app()->session[$key] = $value;
        }

        if ($this->saveMeta && Yii::app()->user->isGuest == false) {
            UserMetaUtil::setMeta(Yii::app()->user->getId(), $key, $value);
        }
    }

}