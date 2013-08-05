<?php

    Yii::import('common.lib.wideimage.WideImage');

    class ImageUtil
    {

        public static $filename = null;
        const THUMB_FOLDER = 'images/thumb';
        const IMAGE_FOLDER = 'images';              

        /**
         * Resize image and return the new filename of image
         * @param integer $width
         * @param integer $height
         * @return string 
         */
        public static function resize($filename,$width, $height)
        {            
            self::$filename = $filename;
            $resizeFileName = self::getResizedImageFileName($width, $height);
            if (file_exists($resizeFileName) == false)
            {
                if (file_exists(self::$filename))
                {
                    self::doResize(self::$filename, $resizeFileName, $width, $height);
                }              
            }
            return $resizeFileName;
        }

        /**
         *
         * @param integer $width
         * @param integer $height
         * @return type 
         */
        protected static function getResizedImageFileName($width, $height)
        {
            $ext = substr(self::$filename, strlen(self::$filename) - 3, 3);
            $name = substr(self::$filename, 0, strlen(self::$filename) - 4);
            return $name . '_' . $width . 'x' . $height . '.' . $ext;
        }

        protected static function doResize($url, $resizedUrl, $width, $height)
        {            
            $image = WideImage::load($url);
            if ($image)
            {
                $image->resize($width, null)->saveToFile($resizedUrl, 80);
                return true;
            }
            return false;
        }

    }

?>
