<?php

class SuggestAdapter
{

    /**
     * Solr client
     * @var Apache_Solr_Service
     */
    protected $_solr;
    protected $keyword = '*';

    public function __construct()
    {
        $this->_solr = Yii::app()->solrProduct->getClient();
    }

    public function setKeyword($keyword)
    {
        $this->keyword = filter_var(preg_replace('/%5B(?:[0-9]|[1-9][0-9]+)%5D=/', '=', $keyword), FILTER_SANITIZE_ENCODED);
    }

    /**
     * return array
     */
    public function getSuggestion()
    {
        $url = 'http://' . Yii::app()->solrProduct->host . ':' . Yii::app()->solrProduct->port . Yii::app()->solrProduct->indexPath . '/' . 'suggest' . '/?';
        $url.='fq=suggest_terms:' . strtolower($this->keyword) . '*';        
        $data = $this->_solr->_sendRawGet($url);
       
        $response = CJSON::decode($data->getRawResponse());
        $suggestData = $response['facet_counts']['facet_fields']['suggestions'];
        $result = array();
        asort($suggestData);
        foreach($suggestData as $key=>$value){
            $result[] = $key;
        }
        return $result;
    }

}