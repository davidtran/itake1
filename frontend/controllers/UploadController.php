<?php

Yii::import("frontend.extensions.xupload.models.XUploadForm");

class UploadController extends Controller
{

    const IMAGE_STATE_VARIABLE = 'xuploadFiles';

    public function actions()
    {
        return array(
            'upload' => array(
                'class' => 'frontend.extensions.xupload.actions.ITakeXUploadAction',
                'path' => Yii::getPathOfAlias('www') . '/images/content',
                'publicPath' => Yii::app()->getBaseUrl() . "/images/content",
                'formClass' => 'frontend.extensions.xupload.models.XUploadForm',
                'stateVariable' => self::IMAGE_STATE_VARIABLE,
                'secureFileNames' => true,
            ),
        );
    }

    public function behaviors()
    {
        return array(
            'seo' => array('class' => 'frontend.extensions.seo.components.SeoControllerBehavior')
        );
    }
    
    public function filters(){
        return array(
            array(
                'frontend.components.FacebookAccessCheckerFilter + index,edit'
            )
        );
    } 

    public function actionIndex($category)
    {
        $returnUrl = $this->createUrl('/upload/index');
        $this->checkLogin('Vui lòng đăng nhập được khi sử dụng tính năng này', $returnUrl);
        if (false == $this->isLessThanPostLimit()) {            
            $this->render('limited',array(
                'limit'=>Yii::app()->user->model->post_limit,
                'countToday'=>$this->countTodayPost()
            ));
            Yii::app()->end();
        }
        Yii::app()->session->add('EditingProduct', false);

        $product = new Product();
        $product->category_id = $category;
        $product->user_id = Yii::app()->user->getId();
        $address = new Address();
        $address->city = CityUtil::getSelectedCityId();
        $photos = new XUploadForm;
        if (isset($_POST['Product'])) {
            $product->attributes = $_POST['Product'];
            //echo mb_detect_encoding($product->title);exit;
            $product->status = Product::STATUS_ACTIVE;
            
            if ($this->haveUploadedImage() && $product->validate(null, false)) {
                if ($product->save(true)) {                    
                    $this->saveUploadedImage($product);                   
                    $this->postProductToFacebook($product);                   
                    Yii::app()->session['PostedProductId'] = $product->id;
                    Yii::app()->user->setFlash('success', 'Đăng tin thành công');
                    Yii::app()->user->setState(self::IMAGE_STATE_VARIABLE, null);
                    $this->redirect($product->getDetailUrl());
                }
            }
            Yii::app()->user->setState(self::IMAGE_STATE_VARIABLE, null);
        }
        else {
            Yii::app()->user->setState(self::IMAGE_STATE_VARIABLE, null);
        }


        $this->render('index', array(
            'product' => $product,
            'photos' => $photos,
            'address' => $address
        ));
    }

    public function actionEdit($id)
    {
        $this->checkLogin("Cần đăng nhập để chỉnh sửa sản phẩm", Yii::app()->request->requestUri);
        $product = Product::model()->findByPk($id);
        if ($product != null) {
            Yii::app()->session->add('EditingProduct', $id);
            if ($product->user_id !== Yii::app()->user->model->id)
                throw new CHttpException(500, 'Bạn không thể chỉnh sửa mà không phải của bạn');
            $photos = new XUploadForm;
            $address = null;
            if ($product->address != null) {
                $address = $product->address;
            }
            else {
                $address = new Address();
            }
            if (isset($_POST['Product'])) {
                $product->attributes = $_POST['Product'];

                if ($this->haveUploadedImage($product) && $product->validate(null, false)) {
                    if ($product->save(true)) {
                        $this->saveUploadedImage($product);                       
                        $this->postProductToFacebook($product);
                       
                        Yii::app()->session['PostedProductId'] = $product->id;
                        Yii::app()->user->setFlash('success', 'Chỉnh sửa tin thành công');
                        Yii::app()->user->setState(self::IMAGE_STATE_VARIABLE, null);
                        $this->redirect($product->getDetailUrl());
                    }
                }
                Yii::app()->user->setState(self::IMAGE_STATE_VARIABLE, null);
            }
            else {
                Yii::app()->user->setState(self::IMAGE_STATE_VARIABLE, null);
            }
            $this->render('index', array(
                'product' => $product,
                'category' => $product->category,
                'photos' => $photos,
                'address' => $address
            ));
        }
        else {
            throw CHttpException(404, 'Không tìm thấy sản phẩm bạn cần');
        }
    }

    protected function createUploadCategorySelect($category)
    {
        return $this->createUrl('step2', array('category' => $category->id, 'name' => $category->name));
    }

    public function haveUploadedImage(Product $product=null)
    {
        $userFiles = Yii::app()->user->getState(self::IMAGE_STATE_VARIABLE, array());

        if (count($userFiles) > 0) {
            return true;
        }
        else {
            if($product!=null)
            {
                $productImages =  ProductImage::model()->findAll("product_id=:product_id",array(':product_id'=>$product->id));
                return count($productImages)>0;
            }
            return false;
        }
    }

    public function saveUploadedImage(Product $product)
    {
        $haveImage = true;
        if (Yii::app()->user->hasState(self::IMAGE_STATE_VARIABLE)) {
            $userImages = Yii::app()->user->getState(self::IMAGE_STATE_VARIABLE);
            $i = 0;
            foreach ($userImages as $index => $image) {
                
                if (is_file($image["path"]))
                {
                    
                    $titleCut = mb_strlen($product->title,'utf-8')>50?mb_substr($product->title,0,50,'utf-8'):$product->title;
                    $filename = str_replace(' ', '-', StringUtil::removeSpecialCharacter(StringUtil::utf8ToAscii($titleCut))) .
                            '_'.
                            rand(0,9999).
                            '_' .
                            $product->id;
                    $fileNameArray = explode('.', $image['filename']);
                 
                    if(count($fileNameArray)>0){
                        
                        $ext = $fileNameArray[count($fileNameArray)-1];                                        
                        if (rename($image["path"], Yii::getPathOfAlias('www') . '/images/content/' . $filename . '.' . $ext)) {                        
                       
                            $thumbnail = ImageUtil::resize(
                                    'images/content/' . $filename . '.' . $ext, 
                                    Yii::app()->params['image.minWidth'], 
                                    Yii::app()->params['image.minHeight']);                                                
                            $mainImage = ImageUtil::resize(
                                    'images/content/' . $filename . '.' . $ext, 
                                    Yii::app()->params['image.maxWidth'], 
                                    Yii::app()->params['image.maxHeight']);                                                
                            $imageModel = new ProductImage();
                            $imageModel->image = $mainImage;
                            $imageModel->thumbnail = $thumbnail;
                            $processed = 'images/content/processed/' . $filename . '.' . $ext;
                            ProductImageUtil::drawImage($product, $imageModel->image, $processed);
                            $imageModel->facebook = $processed;
                            $imageModel->number = $i;
                            $imageModel->product_id = $product->id;
                            if ($imageModel->save()) {
                                $i++;
                                $haveImage = true;
                            }
                        }
                    }
                }
            }
        }
        return $haveImage;
    }

    public function actionGetGeoData($cityId)
    {
        $cityList = CityUtil::getCityList();
        if (isset($cityList[$cityId])) {
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
        if (isset($_POST['Address'])) {
            $address->attributes = $_POST['Address'];
            $address->create_date = date('Y-m-d H:i:s');
            $address->user_id = Yii::app()->user->id;
            if ($address->save()) {
                $this->renderAjaxResult(true, array(
                    'html' => $this->renderPartial(
                            'partial/addressItem', array(
                        'address' => $address
                            ), true, false
                    )
                ));
            }
            else {
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
        if ($address != null && $product != null) {
            if ($product->user_id == $userId && $address->user_id == $userId) {
                if ($product->address_id != $address->id) {
                    $address->status = Address::STATUS_INACTIVE;
                    if($address->save())
                        $this->renderAjaxResult(true);
                    else
                        $this->renderAjaxResult(false, 'Không thể xóa địa chỉ đang được sử dụng');
                }
                else {
                    $this->renderAjaxResult(false, 'Không thể xóa địa chỉ đang được sử dụng');
                }
            }
            else {
                $this->renderAjaxResult(false, 'Không thể xóa địa chỉ này');
            }
        }
        else {
            if ($address != null && $product == null) {
                $address->status = Address::STATUS_INACTIVE;
                if($address->save())
                    $this->renderAjaxResult(true);
                else
                    $this->renderAjaxResult(false, 'Không thể xóa địa chỉ đang được sử dụng');
            }
        }
    }

    public function actionDeleteImage($id)
    {
        $image = ProductImage::model()->findByPk($id);
        if ($image) {            
            $image->delete();
            $this->renderAjaxResult(true);            
        }
        else {
            $this->renderAjaxResult(false, Yii::t('Default', 'Image is not exist'));
        }
    }

    protected function getFacebookPageListData()
    {
        $pages = FacebookUtil::getInstance()->getManagePageList();
        if ($pages !== false) {
            $rs = array();
            foreach ($pages as $page) {
                $rs[$page['page_id']] = CHtml::link($page['name'], $page['page_url'], array(
                            'target' => '_blank'
                ));
            }
            return $rs;
        }
        return false;
    }

    protected function postProductToFacebook($product)
    {
        if (FacebookUtil::getInstance()->doUserHaveEnoughUploadPermission()) {
            try {                
                if ($product->uploadToFacebook) {
                    FacebookUtil::getInstance()->shareProductAlbum($product);
                }
                if (isset($_POST['FacebookPage'])) {
                    foreach ($_POST['FacebookPage'] as $page) {
                        FacebookUtil::getInstance()->shareProductAlbumToFanpage($product, $page);
                    }
                }                                
            }
            catch (Exception $e) {
                Yii::log('Post to facebook failed. '.$e->getMessage(),  CLogger::LEVEL_ERROR,'facebook');                
                Yii::app()->user->setFlash('error','Không thể đăng tin lên Facebook. Vui lòng thử lại sau.');                
            }
        }
    }

    protected function isLessThanPostLimit()
    {
        $limit = Yii::app()->user->model->post_limit;
        $countToday = $this->countTodayPost();        
        return $countToday < $limit;
    }
    
    protected function countTodayPost(){
        $sql = 'select count(*) from {{product}} where to_days(create_date) = to_days(now()) and user_id = :user_id';
        $countToday = Yii::app()->db->createCommand($sql)->bindValue('user_id',Yii::app()->user->getId())->queryScalar();        
        return $countToday;
    }    

}