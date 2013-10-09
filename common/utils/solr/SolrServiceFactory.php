<?php
Yii::import('common.extensions.solr.*');
require_once(dirname(__FILE__).'../../../extensions/solr/phpSolrClient'.DIRECTORY_SEPARATOR.'Service.php');
class SolrServiceFactory
{

    protected static $_service;

    /**
     * @return Apache_Solr_Service
     */
    public static function getInstance()
    {
        if (self::$_service == null) {
            self::$_service = new Apache_Solr_Service(
                    Yii::app()->params['solr.host'], Yii::app()->params['solr.port'], Yii::app()->params['solr.indexPath']
            );
            if (!self::$_service->ping()) {                
                throw new CException('Solr service not responding.');
            }
        }
        return self::$_service;
    }

    protected function __construct()
    {
        
    }

}