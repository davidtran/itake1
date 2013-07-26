<?php

class UploadController extends Controller
{
    protected function solrImportProduct($product){        
        $solrImporter = new ProductModelSolrImporter();
        $solrImporter->addProduct($product);
        try{
            $solrImporter->importProduct();
        }
        catch(Exception $e){
            throw new CHttpException(500,'Có lỗi trong khi đăng tin, chúng tôi đang khắc phục điều này');
        }
        
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
            $user = Yii::app()->user->model;
            $user->lon = $product->lon;
            $user->lat = $product->lat;
            $user->locationText = $product->locationText;            
            $user->city = $product->city;
            $user->phone = $product->phone;
            $user->save();
            $this->handleUploadImage($product);
            if ($product->validate(null,false) && $product->save(false))
            {                
                $this->solrImportProduct($product);
                if (Yii::app()->user->isFacebookUser)
                {
                    try
                    {
                        //FacebookUtil::shareProductToFacebook($product);
                        $postedToFacebook = true;
                    }
                    catch (FacebookApiException $e)
                    {
                        $postedToFacebook = false;
                        Yii::app()->session['PostedToFacebook'] = false;
                    }
                }
                Yii::app()->session['PostedProductId'] = $product->id;
                $this->redirect($this->createUrl('/upload/success'));
            }else{
                if(file_exists($product->image)){
                    unlink($product->image);
                }
                if(file_exists($product->processed_image)){
                    unlink($product->processed_image);
                }
            }
        }
        $hasContactInfo = false;
        if(UserUtil::hasContactInfo())
        {
            $hasContactInfo = true;
        }
        $this->render('index', array(
            'product' => $product,      
            'hasContactInfo'=>$hasContactInfo,
        ));
    }
   
    public function setupDefaultCity($product){
        
        if($product->lat == NULL && $product->lon == NULL){
            $cityList = CityUtil::getCityList(true);
            $firstCity = current($cityList);            
            $product->lat = $firstCity['latitude'];
            $product->lon = $firstCity['longitude'];
        }
        return $product;
        
        
    }
            
    public function actionEdit($id)
    {
        $product = Product::model()->findByPk($id);
        if ($product != null)
        {
            if (isset($_POST['Product']))
            {
                $product->attributes = $_POST['Product'];
                $this->handleUploadImage($product);
                if ($product->save())
                {
                    $this->solrImportProduct($product);
                    $this->redirect($product->getDetailUrl());
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

    public function actionUploadImage()
    {
        Yii::import('application.utils.ajaxupload.UploadHandler');
        $uploadHandler = new UploadHandler(array(
        ));
    }

    public function actionSuccess()
    {
        if (isset(Yii::app()->session['PostedProductId']))
        {
            $id = Yii::app()->session['PostedProductId'];
            $product = Product::model()->findByPk($id);
            if ($product != null)
            {
                $this->render('success', array(
                    'product' => $product
                ));
                $this->redirect($product->getDetailUrl());                
            }
            else
            {
                throw new CHttpException(404, 'Sản phẩm bạn tìm hiện không tồn tại');
            }
        }
        else
        {
            $this->redirect(array('/site'));
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
    protected function handleUploadImage(Product $product)
    {
        $upload = ImageUploadUtil::getInstance('productImage');
        $filename = str_replace(' ', '-', StringUtil::removeSpecialCharacter($product->title)) .
                '_' .
                rand(0, 999);


        $rs = $upload->handleUploadImage('images/content', $filename)  ;
        if ($rs == false)
        {
            $product->addError('image', $upload->getError());
            return false;
        }
        else
        {
            
            $raw = 'images/content/' . $filename . '.' . $upload->getExtension();
            $product->image_thumbnail = ImageUtil::resize($raw, Yii::app()->params['image.minWidth'], Yii::app()->params['image.minHeight']);
            $processed = 'images/content/processed/' . $filename . '.' . $upload->getExtension();
            $product->image = $raw;
            ProductImageUtil::drawImage($product, $raw, $processed);
            $product->processed_image = $processed;
        }
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
    public function actionUploadNew($category = null, $danhmuc = null){
         Yii::import("ext.xupload.models.XUploadForm");
        $model = new XUploadForm;
        $this -> render('uploadNew', array('model' => $model, ));        
    }
    public function actionUploadNew2(){         
        $this -> render('uploadNew2');        
    }
    public function actions()
    {
        return array(
            'upload'=>array(
                'class'=>'ext.xupload.actions.XUploadAction',
                'path' =>Yii::app() -> getBasePath() . "/../images/uploads",
                'publicPath' => Yii::app() -> getBaseUrl() . "/images/uploads",
            ),
        );
    }
    public function actionUploadItem(){
        $product = new Product;
        if(isset ($_POST['title'])&&isset ($_POST['price'])&&isset ($_POST['description'])&&isset ($_POST['link'])&&isset ($_POST['imageLink'])&&isset ($_POST['category']))
        {
            $product->title = $_POST['title'];
            $product->price = $_POST['price'];
            $product->description = $_POST['description'];
            $product->link = $_POST['link'];
            $user = Yii::app()->user->model;
            $product->lon = $user->lon;
            $product->lat = $user->lat;
            $product->locationText = $user->locationText;
            $product->city = $user->city;
            $product->phone = $user->phone;
            
            
            $filename = str_replace(' ', '-', StringUtil::removeSpecialCharacter($product->title)) .
                '_' .
                rand(0, 999);
            $extension = pathinfo($_POST['imageLink'], PATHINFO_EXTENSION);
            $fileLink = basename($_POST['imageLink']); 
            $raw = 'images/content/' . $filename . '.' . $extension;
            copy('images/uploads/'.date( "mdY" ).'/'.$fileLink,$raw);         
            unlink('images/uploads/'.date( "mdY" ).'/'.$fileLink);
            $product->image_thumbnail = ImageUtil::resize($raw, 400, 400);
            $processed = 'images/content/processed/' . $filename . '.' . $extension;
            $product->image = $raw;
            ProductImageUtil::drawImage($product, $raw, $processed);
            $product->processed_image = $processed;
            $product->category_id = $_POST['category'];
            $product->user_id = $user->id;
            if($product->save())
            {
               echo 'save success' ;
            }
            else
            {
                echo 'save fail' ;
            }
        }
        else{
            echo 'save fail' ;
        }
    }
}