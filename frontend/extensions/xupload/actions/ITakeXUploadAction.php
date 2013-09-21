<?php
include_once 'XUploadAction.php';
class ITakeXUploadAction extends XUploadAction{
    
    protected function handleUploading(){
        $imageCount = 0;
        
        $userFiles = Yii::app()->user->getState($this->stateVariable, array());       
        $imageCount += count($userFiles);        
        $productId = Yii::app()->session->get('EditingProduct',false);
        if($productId !== false){
            $product = Product::model()->findByPk($productId);
            if($product!=null){
                $imageCount+=$product->imageCount;
            }
        }
        
        if($imageCount + 1 > Yii::app()->params['upload.maxImageNumber']){            
            echo json_encode(
                    array(
                        array(
                            "error" => Yii::t('xupload','Max number of files exceeded'),
                            )
                        )
                    );
            exit;
            
        }
        return parent::handleUploading();
    }
}
