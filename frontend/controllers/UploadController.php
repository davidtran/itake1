<?php

class UploadController extends Controller
{
    
    public function behaviors()
    {
        return array(
            'seo'=>array('class'=> 'frontend.extensions.seo.components.SeoControllerBehavior')
        );
    }
    
    protected function solrImportProduct($product)
    {
        $solrImporter = new ProductModelSolrImporter();
        $solrImporter->addProduct($product);
        try
        {
            $solrImporter->importProduct();
        }
        catch (Exception $e)
        {
            throw new CHttpException(500, 'Có lỗi trong khi đăng tin, chúng tôi đang khắc phục điều này');
        }
    }

    protected function renderImage(Product &$product, $filename, $extension)
    {
        $thumbnail = ImageUtil::resize($product->image, Yii::app()->params['image.minWidth'], Yii::app()->params['image.minHeight']);
        $product->image_thumbnail = $thumbnail;
        
        
        $processed = 'images/content/processed/' . $filename . '.' . $extension;
        ProductImageUtil::drawImage($product, $product->image, $processed);
        $product->processed_image = $processed;       
    }

    public function actionIndex($category)
    {
        $returnUrl = $this->createUrl('/upload/index');
        $this->checkLogin('Vui lòng đăng nhập được khi sử dụng tính năng này', $returnUrl);
        $postedToFacebook = false;
        $product = new Product();
        $this->setupDefaultCity($product);
        $product->category_id = $category;
        if (isset($_POST['Product']))
        {
            $product->attributes = $_POST['Product'];
            $product->user_id = Yii::app()->user->getId();
         
                $imageMeta = $this->handleUploadImage($product);
                if ($imageMeta !== false && $product->validate(null, false) )
                {
                    if ($imageMeta !== false)
                    {
                        $this->renderImage($product, $imageMeta['filename'], $imageMeta['extension']);
                    }
                    if($product->save(false)){
                        $this->solrImportProduct($product);
                        if (Yii::app()->user->isFacebookUser)
                        {
                            try
                            {
                                FacebookUtil::getInstance()->shareProductToFacebook($product);
                                $postedToFacebook = true;
                            }
                            catch (FacebookApiException $e)
                            {
                                $postedToFacebook = false;
                                Yii::app()->session['PostedToFacebook'] = false;
                            }
                        }
                        Yii::app()->session['PostedProductId'] = $product->id;
                        Yii::app()->user->setFlash('success', 'Đăng tin thành công');
                        $this->redirect($product->getDetailUrl());
                    }
                    
                }
                else
                {
                    if (file_exists($product->image))
                    {
                        unlink($product->image);
                    }
                    if (file_exists($product->processed_image))
                    {
                        unlink($product->processed_image);
                    }
                }
            }
           
        
        $this->render('index', array(
            'product' => $product,
        
        ));
    }

    public function setupDefaultCity($product)
    {

        if ($product->lat == NULL && $product->lon == NULL)
        {
            $cityList = CityUtil::getCityList(true);
            $firstCity = current($cityList);
            $product->lat = $firstCity['latitude'];
            $product->lon = $firstCity['longitude'];
        }
        return $product;
    }

    public function actionEdit($id)
    {
        $this->checkLogin("Cần đăng nhập để chỉnh sửa sản phẩm", Yii::app()->request->requestUri);
        $product = Product::model()->findByPk($id);
        if ($product->user_id !== Yii::app()->user->model->id)
            throw new CHttpException(500, 'Bạn không thể chỉnh sửa mà không phải của bạn');
        if ($product != null)
        {
            if (isset($_POST['Product']))
            {
                $product->attributes = $_POST['Product'];
          
                    $imageMeta = $this->handleUploadImage($product);
                    if ($imageMeta !== false && $product->validate(null, false))
                    {
                        if ($imageMeta !== false)
                        {
                            $this->renderImage($product, $imageMeta['filename'], $imageMeta['extension']);
                        }
                        if($product->save(false)){
                            $this->solrImportProduct($product);
                            if (Yii::app()->user->isFacebookUser)
                            {
                                try
                                {
                                    FacebookUtil::getInstance()->shareProductToFacebook($product);
                                    $postedToFacebook = true;
                                }
                                catch (FacebookApiException $e)
                                {
                                    $postedToFacebook = false;
                                    Yii::app()->session['PostedToFacebook'] = false;
                                }
                            }
                            Yii::app()->session['PostedProductId'] = $product->id;
                            Yii::app()->user->setFlash('success', 'Đăng tin thành công');
                            $this->redirect($product->getDetailUrl());
                        }
                        
                    }
                   
                }
                $this->render('index', array(
                'product' => $product,
                'category' => $product->category
            ));
   
            }
           
        else
        {
            throw CHttpException(404, 'Không tìm thấy sản phẩm bạn cần');
        }
    }

    protected function createUploadCategorySelect($category)
    {
        return $this->createUrl('step2', array('category' => $category->id, 'name' => $category->name));
    }

    /**
     * Get image from upload form and check extension, file size, then resize to 1024x768 (max)
     * Draw info to image
     * @param Product $product
     * @return boolean upload successful
     */
    protected function handleUploadImage(Product &$product)
    {
        $upload = ImageUploadUtil::getInstance('productImage');
        $filename = str_replace(' ', '-', StringUtil::removeSpecialCharacter($product->title)) .
                '_' .
                rand(0, 999);


        $rs = $upload->handleUploadImage('images/content', $filename);
        if ($rs == false)
        {
            if ($product->image == null)
            {
                $product->addError('image', $upload->getError());
                return false;
            }
        }
        else
        {

            $raw = 'images/content/' . $filename . '.' . $upload->getExtension();
            $product->image = $raw;
            return array(
                'filename' => $filename,
                'extension' => $upload->getExtension(),
                'fullpath' => $raw
            );
        }
        return false;
    }

    public function actionDelete()
    {
        //check id
        //inject some crsf
        $this->checkLogin('Vui lòng đăng nhập khi sử dụng chức năng này');
        $productId = Yii::app()->request->getParam('id');
        if ($productId)
        {
            $product = Product::model()->findByPk($productId);
            if ($product != null && $product->user_id == Yii::app()->user->getId())
            {
                $solrImport = new ProductModelSolrImporter();
                $solrImport->deleteProduct($product);
                $product->delete();
                $this->renderAjaxResult(true);
            }
            else
            {
                $this->renderAjaxResult(false, 'Không thể xóa bài đăng này');
            }
        }
        $this->renderAjaxResult(false, 'Sai tham số');
    }

    public function actionGetGeoData($cityId)
    {
        $cityList = CityUtil::getCityList();
        if (isset($cityList[$cityId]))
        {
            $this->renderAjaxResult(true, $cityList[$cityId]);
        }
        $this->renderAjaxResult(false);
    }

    protected function getAddressList()
    {
        $addressList = Address::model()->findAll(array(
            'condition' => 'user_id = :id',
            'params' => array(
                'id' => Yii::app()->user->id
            ),
            'order' => 'create_date desc'
        ));
        return $addressList;
    }

    public function actionAddAddress()
    {
        $address = new Address();
        if (isset($_POST['Address']))
        {
            $address->attributes = $_POST['Address'];
            $address->create_date = date('Y-m-d H:i:s');
            $address->user_id = Yii::app()->user->id;
            if ($address->save())
            {
                $this->renderAjaxResult(true, array(
                    'html' => $this->renderPartial(
                            'partial/addressItem', array(
                        'address' => $address
                            ), true, false
                    )
                ));
            }
            else
            {
                $this->renderAjaxResult(false, 'Vui lòng nhập đầy đủ thông yêu cầu');
            }
        }
        $this->renderAjaxResult(false, "Không thể lưu địa chỉ");
    }

    public function actionDeleteAddress()
    {
        $this->checkLogin();
        $addressId = Yii::app()->request->getPost('addressId');
        $productId = Yii::app()->request->getPost('productId');
        $product = Product::model()->findByPk($productId);
        $address = Address::model()->findByPk($addressId);
        $userId = Yii::app()->user->getId();
        if ($address != null && $product != null)
        {
            if ($product->user_id == $userId && $address->user_id == $userId)
            {
                if ($product->address_id != $address->id)
                {
                    $address->delete();
                    $this->renderAjaxResult(true);
                }
                else
                {
                    $this->renderAjaxResult(false, 'Không thể xóa địa chỉ đang được sử dụng');
                }
            }
            else
            {
                $this->renderAjaxResult(false, 'Không thể xóa địa chỉ này');
            }
        }
        else
        {
            if ($address != null && $product == null)
            {
                $address->delete();
                $this->renderAjaxResult(true);
            }
        }
    }

}