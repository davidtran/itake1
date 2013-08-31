<?php

class SolrSortTypeUtil
{

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
        if (self::$instance == null) {
            self::$instance = new static;
        }
        return self::$instance;
    }

    public function getCurrentSortType()
    {
        return UserRegistry::getInstance()->getValue(self::COOKIE_NAME, SolrSearchAdapter::TYPE_CREATE_DATE);
    }

    public function setSortType($value)
    {

        $list = $this->getSortTypeList();
        if (isset($list[$value])) {
            UserRegistry::getInstance()->setValue(self::COOKIE_NAME, $value);
            return true;
        }
        else {
            throw new CException('Not supported');
        }
        return false;
    }

    protected function getDefaultValue()
    {
        return SolrSearchAdapter::TYPE_CREATE_DATE;
    }

    public function getSortTypeList()
    {
        return array(
            SolrSearchAdapter::TYPE_CREATE_DATE => 'Time',
            SolrSearchAdapter::TYPE_TREND => 'Trend',
            SolrSearchAdapter::TYPE_LOCATION =>'Near you'
        );
    }

    public function getSortTypeLinkList()
    {
        $list = array();
        foreach ($this->getSortTypeList() as $key => $value) {
            $list[$key] = CHtml::link(LanguageUtil::t($value), $this->makeSortTypeUrl($key),array(
                'id'=>'linkSort_'.$key
            ));
        }
        return $list;
    }

    public function makeSortTypeUrl($type)
    {
        return Yii::app()->controller->createUrl('/site/sortType', array(
                    'type' => $type
        ));
    }

}
