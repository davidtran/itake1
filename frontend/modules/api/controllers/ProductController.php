<?php

/**
 * Api for get, edit, delete product
 *
 * @author Khanh Nam
 */
class ProductController extends MobileController
{

    public function filters()
    {
        return array(
            array(
                'CheckTokenFilter + suggest,post,search,share,detail'
            ),
            array(
                'FacebookAccessCheckerFilter + search,share',
                'allowAjaxRequest'=>true
            )
        );
    }

    protected $_product;

    public function actionSuggest($term)
    {
        $this->logRequest();
        $adapter = new SuggestAdapter();
        $adapter->setKeyword($term);
        $suggests = $adapter->getSuggestion();
        echo json_encode($suggests);
    }

    public function actionSearch(
            $latitude = null,
            $longitude =  null,
            $keyword = null, 
            $category = null, 
            $city = null, 
            $country = null, 
            $facebook = 0, 
            $page = 0,
            $status = Product::STATUS_ACTIVE)
    {
        $this->logRequest();
        $keyword = trim(filter_var($keyword, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));

        $city = 0;       
        $solrAdapter = new SolrSearchAdapter();
        $solrAdapter->categoryId = $category;
        $solrAdapter->cityId = $city;
        $solrAdapter->page = $page;
        $solrAdapter->pageSize = 12;
        $solrAdapter->country = $country;
        $solrAdapter->keyword = $keyword;
        $solrAdapter->latitude = $latitude;
        $solrAdapter->longitude = $longitude;
        $solrAdapter->status = $status;
        $solrAdapter->facebookFriend = $facebook;
        $solrAdapter->setSortType(SolrSearchAdapter::TYPE_CREATE_DATE);
        $resultSet = $solrAdapter->search();        
        $productList = $resultSet->productList;
        $empty = $page * $solrAdapter->pageSize + $solrAdapter->pageSize > $resultSet->numFound;
        $list = array();        
        foreach ($productList as $product)
        {
            if($product!=null){
                $productViewData = JsonRenderAdapter::renderProduct($product);
                if($latitude !=null && $longitude!=null){
                    $distance = DistanceUtil::calculate($latitude, $longitude, $product->lat, $product->lon);
                    $productViewData['distance'] = $distance;
                }

                $list[] = $productViewData;
            }
            
        }
        $this->renderAjaxResult(true, array(
            'empty' => $empty,
            'list' => $list
        ));
    }

    public function actionDetail($id)
    {
        $product = Product::model()->findByPk($id);
        if ($product != null)
        {
            $this->renderAjaxResult(true, JsonRenderAdapter::renderProduct($product));
        }
        $this->renderAjaxResult(false);
    }
  
    public function actionShare($productId, $fanpageList = array(), $access_token = null)
    {
        $this->logRequest();
        $model = Product::model()->findByPk($productId);
        if ($model != null)
        {
            try
            {
                $fb = FacebookUtil::getInstance();
                if($access_token !=null){
                    $fb->setAccessToken($access_token);
                }
                $profile = $fb->shareProductAlbum($model);
                $fanpageResult[] = array();
                if(count($fanpageList) > 0){
                    foreach($fanpageList as $fanpage){
                        $fanpageResult = $fb->shareProductAlbumToFanpage($model, $fanpage);
                    }
                }
                $this->renderAjaxResult(true, array(
                    'data' => array(
                        'profile'=>$profile,
                        'fanpage'=>$fanpageResult
                    )
                ));
            }            
            catch (Exception $e)
            {
                $this->renderAjaxResult(false, $e->getMessage());
            }
        }
        else
        {
            $this->renderAjaxResult(false, 'Product not found');
        }
    }
    
    public function actionPost(){
        //image
        //product data
        //address
    }

}

?>
