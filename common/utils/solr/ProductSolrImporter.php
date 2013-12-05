<?php

/**
 * Abstract class to import product data into solr
 */
abstract class ProductSolrImporter
{
    /**
     *  @return Apache_Solr_Service
     */
    protected $solr;
    protected $documents = array();

    public function __construct()
    {
        $this->solr = SolrServiceFactory::getInstance();
    }

    /**
     * Import single or an array of product
     * @param type $product
     */
    public function importProduct()
    {
        try
        {
            $this->solr->addDocuments($this->documents);
            $this->solr->commit();
            $this->solr->optimize();
            return true;
        }
        catch (Exception $e)
        {         
            throw new CException('Solr error: ' . $e->getMessage());
        }
        return false;
    }

    abstract public function deleteProduct($product);

    public function addProduct($product){
        $this->documents[] = $this->makeProductDocument($product);
    }

    protected function deleteById($id)
    {
        try
        {
            $this->solr->deleteById($id);
            $this->solr->commit();
            return true;
        }
        catch (Exception $e)
        {
            throw new CException('Solr error: ' . $e->getMessage());
        }
        return false;
    }   

    protected function formatSolrDate($date)
    {
        return substr($date, 0, 10) . 'T' . substr($date, 11) . 'Z';
    }
    
    protected function makeProductDocument($product)
    {
        $document = new Apache_Solr_Document();
        $data = $this->getImportableProductData($product);
        foreach ($data as $key => $value)
        {
            $document->$key = $value;
        }
        return $document;
    }
    
    /**
     * Base on $product type is array or Product we have different implement
     */
    abstract protected function getImportableProductData($product);
    

}