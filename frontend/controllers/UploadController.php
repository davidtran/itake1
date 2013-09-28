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

    protected function solrImportProduct($product)
    {
        $solrImporter = new ProductModelSolrImporter();
        $solrImporter->addProduct($product);
        try {
            $solrImporter->importProduct();
        }
        catch (Exception $e) {
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
        if (false == $this->isLessThanPostLimit()) {
            die('Excess limit');
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

            $product->status = Product::STATUS_ACTIVE;
            if ($this->haveUploadedImage() && $product->validate(null, false)) {
                if ($product->save(false)) {
                    $this->solrImportProduct($product);
                    $this->saveUploadedImage($product);
                    if ($product->uploadToFacebook > 0) {
                        $this->postProductToFacebook($product);
                    }
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

                if ($product->validate(null, false)) {
                    if ($product->save(false)) {
                        $this->saveUploadedImage($product);
                        $this->solrImportProduct($product);
                        if ($product->uploadToFacebook > 0) {
                            $this->postProductToFacebook($product);
                        }
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

    public function haveUploadedImage()
    {
        $userFiles = Yii::app()->user->getState(self::IMAGE_STATE_VARIABLE, array());
        if (count($userFiles) > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function saveUploadedImage(Product $product)
    {
        $haveImage = true;
        if (Yii::app()->user->hasState(self::IMAGE_STATE_VARIABLE)) {
            $userImages = Yii::app()->user->getState(self::IMAGE_STATE_VARIABLE);
            $i = 1;
            foreach ($userImages as $index => $image) {

                if (is_file($image["path"])) {
                    $filename = str_replace(' ', '-', StringUtil::removeSpecialCharacter($product->title)) .
                            '_' .
                            $index .
                            '_' .
                            $product->id;
                    $ext = substr($image['filename'], strlen($image['filename']) - 3);
                    if (rename($image["path"], Yii::getPathOfAlias('www') . '/images/content/' . $filename . '.' . $ext)) {

                        $resize = ImageUtil::resize('images/content/' . $filename . '.' . $ext, Yii::app()->params['image.minWidth'], Yii::app()->params['image.minHeight']);
                        $imageModel = new ProductImage();
                        $imageModel->image = 'images/content/' . $filename . '.' . $ext;
                        $imageModel->thumbnail = $resize;
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
        return $haveImage;
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
        if ($rs == false) {
            if ($product->image == null) {
                $product->addError('image', $upload->getError());
                return false;
            }
        }
        else {

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
        $this->checkLogin('Vui lòng đăng nhập khi sử dụng chức năng này');
        $productId = Yii::app()->request->getParam('id');
        if ($productId) {
            $product = Product::model()->findByPk($productId);
            if ($product != null && $product->user_id == Yii::app()->user->getId()) {
                $solrImport = new ProductModelSolrImporter();
                $solrImport->deleteProduct($product);
                $product->delete();
                $this->renderAjaxResult(true);
            }
            else {
                $this->renderAjaxResult(false, 'Không thể xóa bài đăng này');
            }
        }
        $this->renderAjaxResult(false, 'Sai tham số');
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
        return false;
        $this->checkLogin();
        $addressId = Yii::app()->request->getPost('addressId');
        $productId = Yii::app()->request->getPost('productId');
        $product = Product::model()->findByPk($productId);
        $address = Address::model()->findByPk($addressId);
        $userId = Yii::app()->user->getId();
        if ($address != null && $product != null) {
            if ($product->user_id == $userId && $address->user_id == $userId) {
                if ($product->address_id != $address->id) {
                    $address->delete();
                    $this->renderAjaxResult(true);
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
                $address->delete();
                $this->renderAjaxResult(true);
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
        if (Yii::app()->user->isFacebookUser) {
            try {
                if ($product->uploadToFacebook) {
                    FacebookUtil::getInstance()->shareProductAlbum($product);
                }
                if (isset($_POST['FacebookPage'])) {
                    foreach ($_POST['FacebookPage'] as $page) {
                        FacebookUtil::getInstance()->shareProductAlbumToFanpage($product, $page);
                    }
                }
                $postedToFacebook = true;
            }
            catch (FacebookApiException $e) {
                $postedToFacebook = false;
                Yii::app()->session['PostedToFacebook'] = false;
            }
        }
    }

    protected function isLessThanPostLimit()
    {
        $limit = UserRegistry::getInstance()->getValue('PostLimit', Yii::app()->params['postLimitPerDay']);
        $sql = 'select count(*) from {{product}} where create_date = now() and user_id = :user_id';
        $countToday = Yii::app()->db->createCommand($sql)->bindValue('user_id',Yii::app()->user->getId())->queryScalar();        
        return $countToday < $limit;
    }

}