<?php

class ProductViewCounterUtil{
    protected static $instances = array();
    protected $_productId;
    const INCREASE_TIME_DISTANCE = 1800; //30 MINS
    public static function getInstance($productId){
        if(self::$instances[$productId]== null){
            self::$instances[$productId] = new ProductViewCounterUtil($productId);            
        }
        return self::$instances[$productId];
    }
    
    protected function __construct($productId)
    {
        $this->_productId = $productId;
    }
    
    public function increaseView(){
        $lastViewTime = $this->getLastViewTime();
        if($lastViewTime == null || (time() - $lastViewTime) > self::INCREASE_TIME_DISTANCE){
            $this->doIncreaseViewBySql();
            $this->setLastViewTime(time());
        }
    }
    
    public function doIncreaseViewBySql(){
        $sql = 'update {{product}} set view = view + 1 where id=:productId';
        Yii::app()->db->createCommand($sql)->bindValues(array(
            'productId'=>$this->_productId
        ))->query();
    }
    
    protected function getLastViewTime(){
        return Yii::app()->session->get($this->getSessionName(),null);
    }
    
    protected function setLastViewTime($datetime){
        Yii::app()->session[$this->getSessionName()]=$datetime;
    }


    protected function getSessionName(){
        return 'LASTPRODUCTVIEWTIME_'.$this->_productId;
    }
}