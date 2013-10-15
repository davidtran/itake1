<?php

class SolrCommand extends ConsoleCommand{
    /*
     * This command should run per 2 hours
     * It's used to update view data for all product, View is counted into sort algothm
     */
    public function importViewData(){       
    }
    
    public function importExistProduct(){
        $productList = Product::model()->findAll();
        $importer = new ProductModelSolrImporter();
        foreach($productList as $product){
            $importer->addProduct($product);
        }
        $importer->importProduct();
    }
    
    public function clearIndex(){
        $productList = Product::model()->findAll();
        $importer = new ProductModelSolrImporter();
        foreach($productList as $product){
            $importer->deleteProduct($product);            
        }        
    }
}
