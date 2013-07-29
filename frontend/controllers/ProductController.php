<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductController
 *
 * @author David Tran
 */
class ProductController extends Controller
{

    protected $_product;

    public function actionDetails($id)
    {
        $product = $this->loadProduct($id);
        if($product->view ==null){
            $product->view = 0;
        }
        $product->view++;
        ProductViewCounterUtil::getInstance($product->id)->increaseView();
        $canonicalUrl = $this->createAbsoluteUrl('/product/details',array('id'=>$id));      
        $userProductDataProvider = $product->user->searchProduct(null, 10, 0);
        if(Yii::app()->request->isAjaxRequest){            
            //load ajax sao đây,
            //bên trong có các javascript nữa.
            //phải làm 1 file riêng hết
            $html = '';
            $html = $this->renderPartial('details',array(
                'product'=>$product,
               
                'userProductDataProvider' => $userProductDataProvider,
                'canonicalUrl'=>$canonicalUrl
                ),true,false);      
           $html = utf8_encode($html);       
           $html = iconv('utf-8','utf-8',$html);
           
           
            $this->renderAjaxResult(true,array(
                'html'=>$html,            
                'product'=>$product->attributes,
                'canonicalUrl'=>$canonicalUrl
            ));
        }else{
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/masonry.pkgd.min.js',CClientScript::POS_HEAD);
            Yii::app()->clientScript->registerScriptFile('http://maps.google.com/maps/api/js?sensor=true',CClientScript::POS_HEAD);
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/gmaps.js',CClientScript::POS_HEAD);
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.infinitescroll.min.js',CClientScript::POS_HEAD);            
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/nada/productDetails.js',CClientScript::POS_BEGIN);
            $productAttributes = json_encode($product->attributes);
            Yii::app()->clientScript->registerScript("productdetails","
                var product = $productAttributes;
                $(document).ready(function(){
                    loadRelateProduct(product);
                    loadUserProduct(product);
                    loadProductMap(product);
                });
                
            ",  CClientScript::POS_END);
            $this->render('detailPage', array(
                'product' => $product,              
                'userProductDataProvider' => $userProductDataProvider,
                'canonicalUrl'=>$canonicalUrl
            ));
        }
        
    }
    
    
    public function actionRelateProductList($id, $page = 0)
    {
        $product = $this->loadProduct($id);
        $productDataProvider = $product->searchRelateProduct(10, $page);
        $productDataProvider->getData();
        $empty = $page >= $productDataProvider->getPagination()->getPageCount();

        $html = '';
        if ($empty == false)
        {
            $html = $this->renderPartial('/product/_relateProductBoard', array(
                'page' => $page,
                'product' => $product,
                'productList' => $productDataProvider->getData()
            ), true, false);
        }
        echo $html;
        Yii::app()->end();
    }

    public function actionUserProductList($id, $page = 0)
    {
        $product = $this->loadProduct($id);
        $productDataProvider = $product->user->searchProduct(null,30, $page);
        $productList = $productDataProvider->getData();
        $empty = $page >= $productDataProvider->getPagination()->getPageCount();
        
        $html = '';
        if ($empty == false)
        {
            $html = $this->renderPartial('_userProductList',array(
                'page'=>$page,
                'productList'=>$productList,
                'product'=>$product
            ));
        }
        echo $html;
        Yii::app()->end();
    }

    protected function loadProduct($id)
    {
        if ($this->_product == null)
        {
            $this->_product = Product::model()->findByPk($id);
            if ($this->_product == null)
            {
                throw new CHttpException(404, 'Product not found');
            }
        }
        return $this->_product;
    }

}

?>
