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

    public function behaviors()
    {
        return array(
            
                'seo'=>array('class'=> 'frontend.extensions.seo.components.SeoControllerBehavior')
            
        );
    }

    public function actionDetails($id)
    {
        ProductViewCounterUtil::getInstance($id)->increaseView();
        $product = $this->loadProduct($id);
        $canonicalUrl = $this->createAbsoluteUrl('/product/details', array('id' => $id));
        $relateProductList = $this->relatedProduct($product);
        if (Yii::app()->request->isAjaxRequest)
        {
            $html = '';
            $html = $this->renderPartial('details', array(
                'product' => $product,
                'relateProductList' => $relateProductList,
                'canonicalUrl' => $canonicalUrl
                    ), true, false);
            $html = utf8_encode($html);
            $html = iconv('utf-8', 'utf-8', $html);
            $this->renderAjaxResult(true, array(
                'html' => $html,
                'product' => $product->attributes,
                'canonicalUrl' => $canonicalUrl
            ));
        }
        else
        {
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/masonry.pkgd.min.js', CClientScript::POS_HEAD);
            Yii::app()->clientScript->registerScriptFile('http://maps.google.com/maps/api/js?sensor=true', CClientScript::POS_HEAD);
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/gmaps.js', CClientScript::POS_HEAD);
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.infinitescroll.min.js', CClientScript::POS_HEAD);
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/nada/productDetails.js', CClientScript::POS_BEGIN);
            $productAttributes = json_encode($product->attributes);
            Yii::app()->clientScript->registerScript("productdetails", "
                var product = $productAttributes;
                $(document).ready(function(){
                    loadRelateProduct(product);
                    loadUserProduct(product);
                    loadProductMap(product);
                });
                
            ", CClientScript::POS_END);
            $this->addMetaProperty('og:title', $product->title);
            $this->addMetaProperty('og:description', StringUtil::limitByWord($product->description, 100));
            $this->addMetaProperty('og:image', Yii::app()->getBaseUrl(true).'/'.$product->image);
            $this->addMetaProperty('og:url',$canonicalUrl);
            $this->addMetaProperty('og:type','product');
            $this->metaDescription = StringUtil::limitByWord($product->description, 100);
            $this->metaKeywords = str_replace(' ', ',', strtolower(preg_replace('/[^0-9a-z\s]/', '', $product->title)));
            $this->render('detailPage', array(
                'product' => $product,
                'relateProductList' => $relateProductList,
                'canonicalUrl' => $canonicalUrl
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
        $productDataProvider = $product->user->searchProduct(null, 30, $page);
        $productList = $productDataProvider->getData();
        $empty = $page >= $productDataProvider->getPagination()->getPageCount();

        $html = '';
        if ($empty == false)
        {
            $html = $this->renderPartial('_userProductList', array(
                'page' => $page,
                'productList' => $productList,
                'product' => $product
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
    
    protected function relatedProduct($product){
        $adapter = new SolrSearchAdapter();
        $adapter->keyword = $product->title;
        $adapter->categoryId = $product->category_id;
        $adapter->city = $product->city;
        $adapter->country = $product->country;
        $adapter->mm = 10;
        $adapter->setSortType(SolrSortTypeUtil::TYPE_CREATE_DATE);
        $adapter->excludeProduct($product->id);
        $result = $adapter->search();
        if(count($result->productList) < 10){
            $result->productList+=$this->searchCategory($product);
        }
        return $result->productList;
    }        
    
    protected function searchCategory($product){
        $adapter = new SolrSearchAdapter();        
        $adapter->categoryId = $product->category_id;
        $adapter->city = $product->city;
        $adapter->country = $product->country;        
        $adapter->setSortType(SolrSortTypeUtil::TYPE_CREATE_DATE);
        $adapter->pageSize = 10;
        $adapter->excludeProduct($product->id);
        $result = $adapter->search();
        
        return $result->productList;
    }

}

?>
