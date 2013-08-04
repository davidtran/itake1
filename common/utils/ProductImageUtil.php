<?php

/**
 * Generate a special image from product image. We can use that picture to post to facebook
 */
class ProductImageUtil{
    
    /**
     * Draw product info on product image
     * @param Product $product
     * @param type $source
     * @param type $dest
     * @return boolean success or not
     */
    public static function drawImage(Product $product,$source,$dest)
    {
        
        Yii::import('common.lib.wideimage.WideImage');
        $image = WideImage::loadFromFile($source);
        if ($image != null)
        {
            //resize image to 1024x768
            $image = $image->resize(1024,768,'inside','down');
            $height = $image->getHeight();
            $width = $image->getWidth();
            
            //draw a transparent black background
            //background height = 30% height of main picture
            $background = WideImage::load('images/background.png');            
            $backgroundHeight = $height*25/100;
            $image = $image->merge($background, 0, $height - $backgroundHeight, 75);
            $canvas = $image->getCanvas();
            
            //draw product info
            $canvas->useFont('font/mnbtitlefont.ttf', 35, $image->allocateColor(255, 255, 255));
            $canvas->writeText(30, $height - 140, strtoupper($product->title));
            
            $priceText = $product->price . ' VNĐ';
            $canvas->useFont('font/mnbtitlefont.ttf', 20, $image->allocateColor(255, 255, 255));
            $canvas->writeText(30, $height - 85, $priceText);
            $canvas->writeText(30, $height - 50, 'Liên hệ: ' . $product->user->username.' - '.$product->address->phone);
            return $image->saveToFile($dest);
        }        
        return false;
    }
    
}