<?php

class SolrCommand extends ConsoleCommand{
    /*
     * This command should run per 2 hours
     * It's used to update view data for all product, View is counted into sort algothm
     */
    public function importViewData(){
        $viewImporter = new ProductViewIndexUpdater();
        $viewImporter->importProductViewCountData();
    }
    
    public function importExistProduct(){
        $productList = Product::model()->findAll();
        $importer = new ProductModelSolrImporter();
        foreach($productList as $product){
            $importer->addProduct($product);
        }
        $importer->importProduct();
    }
}
