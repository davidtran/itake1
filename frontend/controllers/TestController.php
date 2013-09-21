<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TestController
 *
 * @author David Tran
 */
class TestController extends Controller
{
    public function actionShareProduct($id){
        $product = Product::model()->findByPk($id);
        if($product!=null){
            FacebookUtil::getInstance()->shareProductAlbum($product);
        }else{
            echo 'Product not found';
            exit;
        }
    }
    
    public function actionShareFanpage($id){
        $product = Product::model()->findByPk($id);
        if($product!=null){
            FacebookUtil::getInstance()->shareProductAlbumToFanpage($product,'145218035666025');
        }else{
            echo 'Product not found';
            exit;
        }
    }
}

?>
