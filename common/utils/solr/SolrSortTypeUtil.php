<?php

class SolrSortTypeUtil
{

    const TYPE_CREATE_DATE = 0;
    const TYPE_SCORE = 1;
    const COOKIE_NAME = 'SolrSortType';

    protected static $instance;

    protected function __construct()
    {
        ;
    }
    
    /**
     * 
     * @return SolrSortTypeUtil
     */
    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new static;
        }
        return self::$instance;
    }

    public function getCurrentSortType()
    {
        $value = $this->getCookieValue();
        if ($value != null)
        {
            return $value;
        }
        return $this->getDefaultValue();
    }
    
    public function setSortType($value){
        $list = $this->getSortTypeList();
        if(isset($list[$value])){
            $this->setCookieValue($value);
        }else{
            throw new CException('Not supported');
        }
        
    }

    protected function getDefaultValue()
    {
        return self::TYPE_CREATE_DATE;
    }

    protected function getCookieValue()
    {
        if (isset(Yii::app()->request->cookies[self::COOKIE_NAME]))
        {
            return Yii::app()->request->cookies[self::COOKIE_NAME];
        }
        return null;
    }

    protected function setCookieValue($value)
    {
        Yii::app()->request->cookies[self::COOKIE_NAME] = new CHttpCookie(self::COOKIE_NAME,$value);
    }

    public function getSortTypeList()
    {
        return array(
            self::TYPE_CREATE_DATE => 'Thời gian',
            self::TYPE_SCORE => 'Xu hướng'
        );
    }
    
    public function getSortTypeLinkList(){
        $list = array();
        foreach($this->getSortTypeList() as $key=>$value){
            $list[$key] = CHtml::link($value,$this->makeSortTypeUrl($key));
        }
        return $list;
    }
    
    public function makeSortTypeUrl($type){
        return Yii::app()->controller->createUrl('/site/sortType',array(
            'type'=>$type
        )); 
    }

}
