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
            'seo' => array('class' => 'frontend.extensions.seo.components.SeoControllerBehavior')
        );
    }

    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => '0xFFFFFF',
                'transparent' => true,
                'testLimit' => 5
            )
        );
    }

    public function actionDetails($id)
    {
        ProductViewCounterUtil::getInstance($id)->increaseView();
        $product = $this->loadProduct($id);
        $canonicalUrl = $this->createAbsoluteUrl('/product/details', array('id' => $id));
        $relateProductList = $this->relatedProduct($product);
        if (Yii::app()->request->isAjaxRequest) {
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
        else {
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
            if (count($product->images) > 0) {
                $this->addMetaProperty('og:image', Yii::app()->getBaseUrl(true) . '/' . $product->images[0]->thumbnail);
            }
            $this->addMetaProperty('og:url', $canonicalUrl . "?v=1");
            $this->addMetaProperty('og:type', 'product');
            $this->addMetaProperty('fb:app_id', Yii::app()->params['facebook.appId']);
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
        if ($empty == false) {
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
        if ($empty == false) {
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
        if ($this->_product == null) {
            $this->_product = Product::model()->findByPk($id);
            if ($this->_product == null) {
                throw new CHttpException(404, 'Product not found');
            }
        }
        return $this->_product;
    }

    protected function relatedProduct($product)
    {
        $adapter = new SolrSearchAdapter();
        $adapter->keyword = $product->title;
        $adapter->categoryId = $product->category_id;
        $adapter->city = $product->city;
        $adapter->country = $product->country;
        $adapter->mm = 1;
        $adapter->setSortType(SolrSearchAdapter::TYPE_CREATE_DATE);
        $adapter->excludeProduct($product->id);
        $result = $adapter->search();
        if (count($result->productList) < 10) {
            $result->productList+=$this->searchCategory($product);
        }
        return $result->productList;
    }

    protected function searchCategory($product)
    {
        $adapter = new SolrSearchAdapter();
        $adapter->categoryId = $product->category_id;
        $adapter->city = $product->city;
        $adapter->country = $product->country;
        $adapter->setSortType(SolrSearchAdapter::TYPE_CREATE_DATE);
        $adapter->pageSize = 10;
        $adapter->excludeProduct($product->id);
        $result = $adapter->search();
        return $result->productList;
    }

    public function actionSold($productId)
    {
        $product = $this->loadProduct($productId);
        $product->status = Product::STATUS_SOLD;
        if ($product->save()) {
            $solrImporter = new ProductModelSolrImporter();
            $solrImporter->addProduct($product);
            try {
                $solrImporter->importProduct();
                $this->renderAjaxResult(true);
            }
            catch (Exception $e) {
                $this->renderAjaxResult(false, 'Không thể lưu thông tin');
            }
        }
        else {
            $this->renderAjaxResult(false, 'Không thể lưu thông tin');
        }
    }

    public function actionSendMessage($productId)
    {
        $this->checkLogin();        
        $product = $this->loadProduct($productId);        
        $message = new SendMessageForm();
        $message->receiverId = $product->user_id;
        $message->productId = $product->id;
        if (isset($_POST['SendMessageForm'])) {
            $message->attributes = $_POST['SendMessageForm'];
            if ($message->validate() && $message->send()) {
                $this->renderAjaxResult(true, 'Gửi tin nhắn thành công.');
            }
            else {                
                $this->renderAjaxResult(false, 'Không thể gửi được tin nhắn. Vui lòng thử lại sau.');
            }
        }
    }

    public function actionSendMessageDialog()
    {
        $this->checkLogin();
        $productId = Yii::app()->request->getPost('productId');
        $product = $this->loadProduct($productId);
        $message = new SendMessageForm();        
        $message->receiverId = $product->user_id;
        $message->productId = $product->id;
        $html = $this->renderPartial('/product/partial/messageDialog', array(
            'message' => $message
                ), true, false);
        $this->renderAjaxResult(true, array(
            'html' => $html
        ));
    }

}

?>
