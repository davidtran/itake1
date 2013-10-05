<?php
Yii::import('common.lib.wideimage.WideImage');
class ImageUploadUtil{
    
    protected static $instance = array();
    protected $extension;
    protected $uploadName;

    const MAX_IMAGE_MB = 2;
    
    /**
     * Upload process description
     * @var String 
     */
    protected $error;
    private function __construct()
    {
        
    }
    
    /**
     * Singleton
     * @return ImageUploadUtil instance
     */
    public static function getInstance($uploadName)
    {
        if( ! isset(self::$instance[$uploadName])){
            self::$instance[$uploadName] = new static;
            self::$instance[$uploadName]->uploadName = $uploadName;
        }
        return self::$instance[$uploadName];
    }
    
    public function getError(){
        return $this->error;
    }
    public function handleUploadImage(            
            $destinationFolder,
            $destinationName,            
            $minWidth = null,
            $minHeight = null,
            $resizeWidth = null,
            $resizeHeight = null){
        
        if($minWidth == null) $minWidth = Yii::app()->params['image.minWidth'];
        if($minHeight == null) $minHeight = Yii::app()->params['image.minHeight'];
        if($resizeWidth == null) $resizeWidth = Yii::app()->params['image.maxWidth']; 
        if($resizeHeight == null) $resizeHeight = Yii::app()->params['image.maxHeight'];
        $uploadImage = CUploadedFile::getInstanceByName($this->uploadName);        
        $this->error = '';
    
        if ($uploadImage != null)
        {           
            $this->extension = $uploadImage->extensionName;
            if (in_array(mb_strtolower($uploadImage->extensionName),self::getAllowedExtension(), true) == false)
            {
                $allowedExtensionString = implode(', ',self::getAllowedExtension());
                $this->error = 'Định dạng ảnh phải là một trong các loại sau đây: '.$allowedExtensionString;
                return false;
            }

            if ($uploadImage->size > Yii::app()->params['postImageMaxSize'])
            {
                $this->error ='Kích thước ảnh không được quá '.Yii::app()->params['postImageMaxSize']. 'KB';
                return false;
            }
            
            $filename = $destinationFolder.'/'.$destinationName.'.'.$uploadImage->extensionName;
            $r=$uploadImage->saveAs($filename,true);       
            if($r == false){
                $this->error = 'Không thể lưu lại hình ảnh';
                return false;
            }
            $imageInfo = getimagesize($filename);

            if ($imageInfo[0] < $minWidth || $imageInfo[1] < $minHeight)
            {                
                @unlink($filename);
                $this->error = "Bề ngang ảnh phải lớn hơn $minWidth và bề rộng ảnh phải lớn hơn $minHeight";                
                return false;
            }
            
            if( ($imageInfo[0] < $resizeWidth || $imageInfo[1] < $resizeHeight) && $resizeWidth !=null && $resizeHeight !=null){
                $resize = ImageUtil::resize($filename, $resizeWidth,$resizeHeight);            
                return $resize;
            }
            return $filename;
            
        }
        $this->error = 'Không tìm thấy tập tin tải lên';
        return false;
    }
    
    public static function getAllowedExtension(){
        return array(
            'gif','jpg','jpeg','png','bmp'
        );
    }
    
    public function getExtension(){
        return $this->extension;
    }
}
