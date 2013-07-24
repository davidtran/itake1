<?php

/**
 * Import product data from array into solr
 */
class ProductArraySolrImporter extends ProductSolrImporter
{   
    
    protected function getImportableProductData($array){
        $result = array();
        foreach($array as $key=>$value){
            $result[$key] = $value;
        }
        if(isset($array['title'])){
            $result['suggest_terms'] = $array['title'];
        }
        return $result;
        
    }


    public function deleteProduct($product)
    {
        $this->deleteById($product['id']);
    }

}