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
            if($image->getWidth() > 1024){
                $image = $image->resize(1024, 768, 'inside', 'down');                
                $titleFontSize = 35;
                $textFontSize = 30;
                $titleOffset = 1024 - 140;
                $priceOffset = 1024 - 85;
                $addressOffset = 1024 - 50;
            }else if($image->getWidth() > 640){
                $image = $image->resize(800,600,'inside','down');
                $titleFontSize = 30;
                $textFontSize = 18;
                $titleOffset = 600 - 138;
                $priceOffset = 600 - 81;
                $addressOffset = 600 - 52;                                
            }else{
                $image = $image->resize(420,420,'inside','down');
                $titleFontSize = 23;
                $textFontSize = 16;
                $titleOffset = 420 - 100;
                $priceOffset = 420 - 60;
                $addressOffset = 420 - 40;                                
            }
            
            $background = WideImage::load('images/background.png');
            $backgroundHeight = $image->getHeight() * 25 / 100;
            
            $image = $image->merge($background, 0, $image->getHeight() - $backgroundHeight, 50);
            $canvas = $image->getCanvas();

            
            $canvas->useFont('font/mnbtitlefont.ttf', $titleFontSize, $image->allocateColor(255, 255, 255));
            $title = StringUtil::limitCharacter($product->title,60);
            $canvas->writeText(30, $titleOffset, ($product->title));

            $priceText = preg_replace('/[^0-9]/', '', $product->price);
            $priceText = number_format($priceText) . ' VNĐ';
            $canvas->useFont('font/mnbtitlefont.ttf', $textFontSize, $image->allocateColor(255, 255, 255));
            $canvas->writeText(30,$priceOffset, $priceText);
            if ($product->address != null && $product->user != null)
            {
                $canvas->writeText(30,$addressOffset, 'Liên hệ: ' . $product->user->username . ' - ' . $product->address->phone);
            }

            return $image->saveToFile($dest);
        }
        return false;
    }

}