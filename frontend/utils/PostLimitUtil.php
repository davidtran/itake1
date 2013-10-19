<?php

class UserPostLimitUtil{
    
    protected $userId;
    public function __construct($userId){
        $this->userId = $userId;
    }
    public function isLessThanPostLimit()
    {
        $limit = $this->getLimit();
        $countToday = $this->countTodayPost();        
        return $countToday < $limit;
    }
    
    public function countTodayPost(){        
        $sql = 'select count(*) from {{product}} where to_days(create_date) = to_days(now()) and user_id = :user_id';
        $countToday = Yii::app()->db->createCommand($sql)->bindValue('user_id',$this->userId)->queryScalar();        
        return $countToday;
    }
    
    public function getLimit(){
        $limit = UserRegistry::getInstance()->getValue('PostLimit', Yii::app()->params['postLimitPerDay']);
        return $limit;
    }
}