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
//        return array(
//            array(
//                'CheckTokenFilter +post,search,share,detail'
//            )
//        );
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

    public function actionSearch($latitude = null,$longitude =  null,$keyword = null, $category = null, $city = null, $country = null, $facebook = false, $page = 0)
    {
        $this->logRequest();
        $keyword = trim(filter_var($keyword, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));

        $city = 0;
        if (isset(Yii::app()->session['LastCity']))
        {
            $city = Yii::app()->session['LastCity'];
        }

        $solrAdapter = new SolrSearchAdapter();
        $solrAdapter->categoryId = $category;
        $solrAdapter->cityId = $city;
        $solrAdapter->page = $page;
        $solrAdapter->pageSize = 12;
        $solrAdapter->country = $country;
        $solrAdapter->keyword = $keyword;
        $solrAdapter->latitude = $latitude;
        $solrAdapter->longitude = $longitude;
        $solrAdapter->setSortType(SolrSortTypeUtil::TYPE_SCORE);
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

    public function actionPost()
    {
        $this->logRequest();
        if (isset($_REQUEST))
        {
            $model = new Product();
            $model->attributes = $_REQUEST;
            $model->saveImage();
            if ($model->save())
            {

                $this->renderAjaxResult(true, array(
                    'product' => JsonRenderAdapter::renderProduct($model)
                ));
            }
            else
            {
                $this->renderAjaxResult(false, array(
                    'errors' => $model->errors
                ));
            }
        }
        else
        {
            $this->renderAjaxResult(false, 'Invalid data');
        }
    }

    public function actionShare($productId, $access_token = null)
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
                $data = $fb->shareProductToFacebook($model);
                $this->renderAjaxResult(true, array(
                    'data' => $data
                ));
            }
            catch (FacebookApiException $e)
            {
                $this->renderAjaxResult(false, 'Invalid token or user is not authorized with Facebook');
            }
            catch (Exception $e)
            {
                $this->renderAjaxResult(false, 'Unknown error');
            }
        }
        else
        {
            $this->renderAjaxResult(false, 'Product not found');
        }
    }

}

?>
