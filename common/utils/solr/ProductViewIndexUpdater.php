<?php

class ProductViewIndexUpdater{
        
    public function importProductViewCountData(){
        $list = $this->getProductViewCountData();
        $importer = new ProductArraySolrImporter();
        if(count($list)>0){
            foreach($list as $row){
                $importer->addProduct($row);
            }
        }
        $importer->importProduct();
    }
    
    protected function getProductViewCountData(){
        return Yii::app()->db->createCommand('select id,view from {{product}}')->queryAll();        
    }
}