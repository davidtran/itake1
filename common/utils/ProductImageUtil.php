<?php

/**
 * Generate a special image from product image. We can use that picture to post to facebook
 */
class ProductImageUtil
{

    /**
     * Draw product info on product image
     * @param Product $product
     * @param type $source
     * @param type $dest
     * @return boolean success or not
     */
    public static function drawImage(Product $product, $source, $dest)
    {

        Yii::import('common.lib.wideimage.WideImage');
        $image = WideImage::loadFromFile($source);
        if ($image != null)
        {
            //resize image to 1024x768
            $normalFontSize = 30;
            $fontSize = $normalFontSize;
            if($image->getHeight() > 768){
                $image = $image->resize(null, 768, 'inside', 'down');                
                $titleFontSize = 35;
                $textFontSize = 30;
                $titleOffset = 1024 - 140;
                $priceOffset = 1024 - 85;
                $addressOffset = 1024 - 50;
            }else if($image->getWidth() > 600){
                $image = $image->resize(null,600,'inside','down');
                $titleFontSize = 30;
                $textFontSize = 18;
                $titleOffset = 600 - 130;
                $priceOffset = 600 - 81;
                $addressOffset = 600 - 52;                                
            }else{
                $image = $image->resize(null,420,'inside','down');
                $titleFontSize = 23;
                $textFontSize = 16;
                $titleOffset = 420 - 95;
                $priceOffset = 420 - 60;
                $addressOffset = 420 - 40;                                
            }
            
            $background = WideImage::load('images/background.png');
            $backgroundHeight = $image->getHeight() * 25 / 100;
            
            
            $canvas = $background->getCanvas();

            $marginLeft = 40;
            $titleFontSize = 70;
            $textFontSize = 50;      
            $canvas->useFont('font/mnbtitlefont.ttf', $titleFontSize, $background->allocateColor(0, 0, 0));
            $title = StringUtil::limitCharacter($product->title,45);
            $canvas->writeText($marginLeft, 45, ($title));
            $canvas->useFont('font/mnbtitlefont.ttf', $titleFontSize, $background->allocateColor(255, 255, 255));
            $title = StringUtil::limitCharacter($product->title,45);
            $canvas->writeText($marginLeft-1, 45-1, ($title));

            $priceText = preg_replace('/[^0-9]/', '', $product->price);
            $priceText = number_format($priceText) . ' VNĐ';            
            $canvas->useFont('font/mnbtitlefont.ttf', $textFontSize, $background->allocateColor(255, 255, 255));
            $canvas->writeText($marginLeft,170, $priceText);
            
            if ($product->address != null && $product->user != null)
            {
                $canvas->writeText($marginLeft,240, 'Liên hệ: ' . $product->user->username . ' - ' . $product->address->phone);
            }
            
            $background = $background->resize($image->getWidth(), $backgroundHeight, 'inside');
            $image = $image->merge($background,"right", "bottom", 70);
            return $image->saveToFile($dest);
        }
        return false;
    }

}