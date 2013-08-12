<?php


/**
 * Api for get, edit, delete product
 *
 * @author Khanh Nam
 */
class ProductController extends Controller
{
    
    public function filters()
    {
        return array(
            array(
                'CheckTokenFilter +post,search,share,detail'
            )
        );
    }
    //put your code here
    protected $_product;

    protected function log()
    {
        $log = serialize($_REQUEST);
        $f = fopen('log', 'wb');
        fwrite($f, $log);
        fclose($f);
    }

    public function actionPost()
    {
        $this->log();
        if (isset($_REQUEST))
        {
            $model = new Product();
            $model->attributes = $_REQUEST;
            $model->saveImage();
            if ($model->save())
            {

                $this->renderAjaxResult(true, array(
                    'product' => $model->attributes
                ));
            }
            else
            {
                $this->renderAjaxResult(false, array(
                    'error' => $model->errors
                ));
            }
        }
        else
        {
            $this->renderAjaxResult(false, 'Invalid data');
        }
    }

    public function actionDetail($productId, $latitude = null, $longitude = null)
    {
        $model = Product::model()->findByPk($productId);
        if ($model != null)
        {
            $data = $model->attributes;
            if ($latitude != null && $longitude)
            {
                $data['distance'] = $model->getDistance($latitude, $longitude);
            }


            $this->renderAjaxResult(true, array(
                'product' => $data
            ));
        }
        else
        {
            $this->renderAjaxResult(false, 'Product not found');
        }
    }

    public function actionShare($productId,$token)
    {
        
        $model = Product::model()->findByPk($productId);
        if ($model != null)
        {
            try
            {
                $data = FacebookUtil::shareProductToFacebook($model, $token);
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

    public function actionSearch($keyword = null, $latitude = null, $longitude = null, $category = null, $city = null, $page = 0)
    {
        $keyword = strtolower($keyword);
        $productDataProvider = ProductUtil::searchProductByLocation($latitude, $longitude, $keyword, $category, $city, $page);
        $productList = $productDataProvider->getData();
        $result = array();
        foreach ($productList as $index => $product)
        {

            $result[$index] = $product->attributes;
            $result[$index]['distance'] = $product->getDistance($latitude, $longitude);
            $result[$index]['image'] = Yii::app()->getBaseUrl(true) . '/' . $product->image;
            if ($product->user != null)
            {
                $result[$index]['user'] = $product->user->getData();
            }
        }
        $this->renderAjaxResult(true, array(
            'list' => $result,
            'total'=>$productDataProvider->getTotalItemCount(),
            'page'=>$page
        ));
    }

}

?>
