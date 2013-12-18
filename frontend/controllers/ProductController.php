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
                'testLimit' => 2
            )
        );
    }

    public function actionDetails($id)
    {      
        
        ProductViewCounterUtil::getInstance($id)->increaseView();
        $product = $this->loadProduct($id);
        CityUtil::setSelectedCityId($product->address->city);
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
            $productAttributes = $product->attributes;
            $productAttributes['address']=$product->address->attributes;
            $this->renderAjaxResult(true, array(
                'html' => $html,
                'product' => $productAttributes,
                'canonicalUrl' => $canonicalUrl
            ));
        }
        else {
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/masonry.pkgd.min.js', CClientScript::POS_HEAD);
            Yii::app()->clientScript->registerScriptFile('http://maps.google.com/maps/api/js?sensor=true', CClientScript::POS_HEAD,false);
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/gmaps.js', CClientScript::POS_HEAD);
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.infinitescroll.min.js', CClientScript::POS_HEAD);
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/nada/productDetails.js', CClientScript::POS_BEGIN);
            $productAttributes = json_encode(JsonRenderAdapter::renderProduct($product));
            Yii::app()->clientScript->registerScript("productdetails", "
                var product = $productAttributes;
                $(document).ready(function(){
                    loadRelateProduct(product);
                    loadUserProduct(product);
                    loadProductMap(product);
                    trackingLink('$canonicalUrl');
                });                
            ", CClientScript::POS_END);
            $this->addMetaProperty('og:title', $product->title);
            $this->addMetaProperty('og:description', StringUtil::limitByWord($product->description, 100));
            if (count($product->images) > 0) {
                $this->addMetaProperty('og:image', Yii::app()->getBaseUrl(true) . '/' . $product->images[0]->thumbnail);
            }
            else if(strlen($product->image)>0)
            {
                $this->addMetaProperty('og:image', Yii::app()->getBaseUrl(true) . '/' . $product->image);
            }
            $this->addMetaProperty('og:url', $canonicalUrl);
            $this->addMetaProperty('og:type', 'product');
            $this->addMetaProperty('fb:app_id', Yii::app()->params['facebook.appId']);
            $this->metaDescription = StringUtil::limitByWord($product->description, 100);
            $this->metaKeywords = str_replace(' ', ',', strtolower(preg_replace('/[^0-9a-z\s]/', '', $product->title)));
            $this->canonical = $canonicalUrl;
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
        $adapter->cityId = $product->address->city;
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
        $adapter->cityId = $product->address->city;
        $adapter->country = $product->country;
        $adapter->setSortType(SolrSearchAdapter::TYPE_CREATE_DATE);
        $adapter->pageSize = 10;
        $adapter->excludeProduct($product->id);
        $result = $adapter->search();
        return $result->productList;
    }

    public function actionSold()
    {
        $id = Yii::app()->request->getPost('id');
        if($id!=null){
            $product = $this->loadProduct($id);
            $product->status = Product::STATUS_SOLD;
            if ($product->save()) {
                $this->renderAjaxResult(true,array(
                    'html'=>$product->renderHtml('',true)
                ));
            }
            else {
                $this->renderAjaxResult(false, 'Không thể lưu thông tin');
            }
        }
        
    }
    
    public function actionDelete()
    {
        $this->checkLogin('Vui lòng đăng nhập khi sử dụng chức năng này');
        $productId = Yii::app()->request->getParam('id');
        if ($productId) {
            $product = Product::model()->findByPk($productId);
            if ($product != null && $product->user_id == Yii::app()->user->getId()) {                
                if($product->delete()){
                    $this->renderAjaxResult(true);
                }else{
                    $this->renderAjaxResult(false, 'Không thể xóa bài đăng này');
                }
                
            }
            else {
                $this->renderAjaxResult(false, 'Không thể xóa bài đăng này');
            }
        }
        $this->renderAjaxResult(false, 'Sai tham số');
    }

    public function actionSendMessage($productId)
    {        
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
    
    public function renderMessageDialog()
    {
        $this->checkLogin();
        $productId = Yii::app()->request->getPost('productId');
        $product = $this->loadProduct($productId);
        $message = new SendMessageForm();
        $message->receiverId = $product->user_id;
        $message->productId = $product->id;
        $html = $this->renderPartial('/product/partial/messageDialog', array(
            'message' => $message
         ));
        return $html;
    }
    
    protected function renderItem($id){
        $product = $this->loadProduct($id);
        $html = $this->render('/site/_productItem',array(
            'product'=>$product
        ),true,false);
        $this->renderAjaxResult(true,array(
            'html'=>$html
        ));
    }

    public function actionUpProduct($id){
        $product = $this->loadProduct($id);
        $product->refreshUpdateDate();
        $this->renderAjaxResult(true);
    }

    public function actionRating(){
        if(Yii::app()->user->isGuest == false){
            $score = Yii::app()->request->getPost('value');
            $productId = Yii::app()->request->getPost('productId');
            $userId = Yii::app()->user->getId();       
            if(Rating::addRatingScore($userId,$productId,$score)){                    
                $this->renderAjaxResult(true,array(
                    'averageScore'=>Rating::getAverageScoreForProduct($productId),
                    'userCount'=>Rating::getTotalUserCountForProduct($productId),
                ));
            }       
        }else{
            $this->renderAjaxResult(false,'Please login before rating this product.');
        }
        
    }

}

?>
