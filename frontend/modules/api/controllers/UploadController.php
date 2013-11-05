<?php

class UploadController extends MobileController {
    
    public function filters()
    {
        return array(
            array(
                'CheckTokenFilter + create,edit,deleteImage,deleteAddress,'
            )
        );
    }
    
    public function actionCreate() {
        $categoryId = Yii::app()->request->getParam('categoryId');
        if ($categoryId != null) {
            $product = new Product();                                          
            if (isset($_POST['Product'])) {
                $product->attributes = $_POST['Product'];                
                if($product->address_id == null){
                    $address = $this->createAddressFromRequest();
                    if($address){
                        $product->address_id = $address->id;
                    }                    
                }
                if ($product->save()) {
                    if($this->saveImage($product)){
                        $this->renderAjaxResult(true,  JsonRenderAdapter::renderProduct($product));
                    }else{
                        $product->delete();
                        $this->renderAjaxResult(false,'Can not save image');
                    }                    
                }else{
                    $this->renderAjaxResult(false,array(
                        'errors'=>$product->errors
                    ));
                }
            }                                    
        }
        $this->renderAjaxResult(false,'Invalid parameter');
    }

    public function actionEdit($id) {
        $product = Product::model()->findByPk($id);
        if( $product != null ){
            if (isset($_POST['Product'])) {                
                if($this->saveImage($product)){
                    $product->attributes = $_POST['Product'];
                    if($product->save()){
                        $this->renderAjaxResult(true,  JsonRenderAdapter::renderProduct($product));
                    }else{
                        $this->renderAjaxResult(false,array(
                            'errors'=>$product->errors
                        ));
                    }
                }else{
                    $this->renderAjaxResult(false,'Invalid image');
                }                
            }
        }
        $this->renderAjaxResult(false,'Invalid parameter');
    }
    
    protected function createAddressFromRequest(){
        if(isset($_POST['Address'])){
            $address = new Address();
            $address->attributes = $_POST['Address'];
            if($address->save()){
                return $address;
            }           
        }
        return false;
    }
    
    protected function saveImage(Product $product){
        $uploadedImage = CUploadedFile::getInstanceByName('image');
        if ($uploadedImage != null) {
            $image = new ProductImage();
            $image->product_id = $product->id;
            $titleCut = mb_strlen($product->title, 'utf-8') > 20 ? mb_substr($product->title, 0, 20, 'utf-8') : $product->title;
            $filename = str_replace(' ', '-', StringUtil::removeSpecialCharacter(StringUtil::utf8ToAscii($titleCut))) .
                    '_' .
                    rand(0, 9999999) .
                    '_' .
                    $product->id;                                             
            $thumbnail = ImageUtil::resize(
                   'images/content/' . $filename . '.' . $uploadedImage->getExtensionName(), 
                    Yii::app()->params['image.minWidth'], 
                    Yii::app()->params['image.minHeight']
            );
            $mainImage = ImageUtil::resize(
                    'images/content/' . $filename . '.' . $uploadedImage->getExtensionName(), 
                    Yii::app()->params['image.maxWidth'], 
                    Yii::app()->params['image.maxHeight']
            );                     
            $image->image = $mainImage;
            $image->thumbnail = $thumbnail;
            $processed = 'images/content/processed/' . $filename . '.' . $ext;
            ProductImageUtil::drawImage($product, $image->image, $processed);
            $image->facebook = $processed;
            $image->number = 0;
            $image->product_id = $product->id;
            return $image->save();
        }
        
        if(false == $product->isNewRecord){
            return true;
        }
        return false;
        
    }

}