<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ProductUtil
{

    const PAGE_SIZE = 20;   
    
    public static function increaseProductViewByProductId($productId){
        $sql = 'update {{product}} set view = view + 1 where id=:productId';
        Yii::app()->db->createCommand($sql)->bindValues(array(
            'productId'=>$productId
        ))->query();
    }        
    
    public static function getCanonicalLink($id){
        return Yii::app()->createAbsoluteUrl('/product/details', array('id' => $id));
    }

}

?>
