<?php

require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'phpSolrClient'.DIRECTORY_SEPARATOR.'Service.php');

class CSolrComponent extends CApplicationComponent{
    
    /**
    * Host name
    * 
    * @var strinf
    */
    public $host='localhost';
    
    /**
    * The port of the solr server
    * 
    * @var int
    */
    public $port='8983';
    
    /**
    * The Solr index (core)
    * 
    * @var string (the url path)
    */
    public $indexPath = '/solr';
    public $_solr;
    
    public function init()
    {  parent::init();
        if(!$this->host || !$this->indexPath)
            throw new CException('No server or index selected.');
        else 
            $this->_solr = new Apache_Solr_Service($this->host, $this->port, $this->indexPath);
        if (!$this->_solr->ping()){
            echo "$this->host, $this->port, $this->indexPath";
            throw new CException('Solr service not responding.');
        }
    }
    
    public function getClient(){
        return $this->_solr;
    }
}
?>
