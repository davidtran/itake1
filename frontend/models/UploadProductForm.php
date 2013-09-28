<?php

class UploadProductForm extends CFormModel{
    public $uploadToFacebook = true;
    
    public function rules(){        
        $product = new Product();        
        $rules = array(
            array('uploadToFacebook','required'),
            array('uploadToFacebook','numerical','integerOnly'=>true)
        );
        return CMap::mergeArray($rules, $product->getRules());
    }        
    
    
}