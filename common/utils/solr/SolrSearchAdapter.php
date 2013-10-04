<?php

//researching
//http://dev.solr:8983/solr/select/?q=laptop&defType=dismax&fl=id,title,city_name,create_date,view,category_name,score&qf=title^60%20category_name^10%20description^30&bf=product(1.1,view)&bf=recip(ms(NOW,create_date),3.16e-11,1,1)
class SolrSearchAdapter
{

    const TYPE_CREATE_DATE = 0;
    const TYPE_TREND = 1;
    const TYPE_LOCATION = 2;

    protected $result;
    public $page;
    public $pageSize = 10;
    public $cityId = null;
    public $keyword = null;
    public $country = null;
    public $categoryId = null;
    public $latitude = null;
    public $longitude = null;
    public $facebookFriend;
    /**
     * Product status filter
     * @var int 
     */
    public $status = Product::STATUS_ACTIVE;
    protected $sortType = null;
    public $mm = 2;
    protected $excludeIdList = array();

    const DEFAULT_KEYWORD = '*:*';

    public function __construct()
    {
        $this->page = 0;
        $this->cityId = null;
        $this->sortType = self::TYPE_CREATE_DATE;
    }

    public function setSortType($value)
    {
        $this->sortType = $value;
    }
    
    public function getSortType(){
        return $this->sortType;
    }

    public function makeParam()
    {
        $fq = '';
        $params = array();

        if ($this->country != null) {
            $fq[] = 'country:' . $this->country;
        }
        if ($this->cityId != null && $this->cityId != CityUtil::ALL_ID) {
            $fq[] = 'city_id:' . $this->cityId;
        }
        if ($this->categoryId != null) {
            $fq[] = 'category_id:' . $this->categoryId;
        }
        $fq[] = 'status:'.$this->status;
        if($this->facebookFriend){
            $fq['user_id'] = $this->getFacebookFriendString();
        }
        $params['fq'] = $fq;
        $params['bf'] = array(
            'recip(abs(ms(NOW/DAY,create_date)),1,6.3E10,6.3E10)',            
        );
        $params['defType'] = 'edismax';
        $params['qf'] = 'title^60 description^20';
        $params['q.alt'] = '*:*';
        $params['mm'] = $this->mm;
        
        switch ($this->sortType) {
            case self::TYPE_CREATE_DATE:
                $params['sort'] = 'create_date desc';
                break;
            case self::TYPE_TREND:
                $params['bf'][] = 'product(1.1,view)';
                $params['sort'] = 'score desc';
                break;
            case self::TYPE_LOCATION:
                if ($this->latitude != null && $this->longitude != null) {
                    $params['bf'][] = 'recip(geodist(latlng,' . $this->latitude . ',' . $this->longitude . '),2,200,20)';
                }
                $params['sort'] = 'score desc';
                break;
        }        

        return $params;
    }

    public function setLocation($lat, $lng)
    {
        $this->latitude = floatval($lat);
        $this->longitude = floatval($lng);
    }

    public function makeQuery()
    {
        $keyword = null;
        if (trim($this->keyword) == '') {
            $keyword = self::DEFAULT_KEYWORD;
        }
        else {
            $keyword = $this->keyword;
        }
        if($this->facebookFriend && (false !== $facebookParam = $this->getFacebookFriendString())){
            $keyword='user_id:'.$facebookParam;
        }
        return strtolower($keyword);
    }

    protected function getOffset()
    {
        return $this->page * $this->pageSize;
    }

    public function search()
    {
        $solr = Yii::app()->solrProduct->getClient();
        try {
            $response = $solr->search($this->makeQuery(), $this->getOffset(), $this->pageSize, $this->makeParam());
            return $this->postSearch($response);
        }
        catch (Apache_Solr_HttpTransportException $e) {
            throw $e;
        }
    }

    /**
     * Transform 
     * @param type $response
     */
    protected function postSearch(Apache_Solr_Response $response)
    {
        $rawBody = $response->getRawResponse();
        $parsed = CJSON::decode($rawBody);
        $resultSet = new ProductSearchResult();
        $resultSet->numFound = $parsed['response']['numFound'];
        $resultSet->status = $parsed['responseHeader']['status'];
        $resultSet->queryTime = $parsed['responseHeader']['QTime'];
        $resultSet->productList = array();
        //$resultSet->start = $parsed['responseHeader']['start'];
        $docs = $parsed['response']['docs'];
        foreach ($docs as $doc) {
            if (!in_array($doc['id'], $this->excludeIdList, true)) {
                $product = Product::model()->findByPk(trim($doc['id']));
                if ($product != null && $product->status == $this->status) {
                    $product->title = $doc['title'];
                    $product->description = $doc['description'];
                    $resultSet->productList[] = $product;
                }
            }
        }
        return $resultSet;
    }

    public function excludeProduct($id)
    {
        $this->excludeIdList[] = $id;
    }
    
    /**
     * return a solr friendly array of facebook friend
     */
    protected function getFacebookFriendString(){
        if( !FacebookUtil::getInstance()->doUserHaveEnoughUploadPermission()){
            throw new CException('User must login to facebook first');
        }
        try{
            $friendList = FacebookUtil::getInstance()->getFacebookFriendInApp(Yii::app()->user->getId());                
        }
        catch(Exception $e){
            Yii::log($e->getMessage(),  CLogger::LEVEL_ERROR,'facebook');
            return '(99999999999999999999999)'; //no one have this user id, so it can't show any product
        }
        
       
        
        if($friendList !=false){
            $strList = '(';
            foreach($friendList as $index=>$friendId){
                $strList .= $friendId;
                if( count($friendList) -1  > $index){
                    $strList.=' or ';
                }
            }
            $strList.=')';
            return $strList;
        }
        return '(99999999999999999999999)'; //no one have this user id, so it can't show any product
    }

}