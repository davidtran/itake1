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

        $newImageWidth  = 0;
        $newImageHeight = 0;  
        $baseTagHeight = 250;      

        $image = WideImage::loadFromFile($source);        
        if ($image != null)
        {
            //resize image to 1024x768
            $normalFontSize = 30;
            $fontSize = $normalFontSize;
            $marginLeft = 20;        
            if($image->getWidth() > 1024){
                $image = $image->resize(1024, 768, 'inside', 'down');                
                $titleFontSize = 50;
                $textFontSize = 40;                
                $priceOffset = 70;

            }else if($image->getWidth() > 640){
                $image = $image->resize(800,600,'inside','down');
                $titleFontSize = 35;
                $textFontSize = 27;
                $marginLeft = 15;                                   
            }else{
                $image = $image->resize(420,420,'inside','down');
                $titleFontSize = 25;
                $textFontSize = 20;
                $marginLeft = 10;   
            }
            
            $newImageWidth =  $image->getWidth();
            $newImageHeight = $image->getHeight();
            $image->saveToFile($dest);
            $icon1 = null;
            $gd_canvas = imagecreatetruecolor($newImageWidth,$newImageHeight);
            if (strpos($dest,'.png') !== false||strpos($dest,'.PNG') !== false) {
                $icon1 = imagecreatefrompng($dest);
            }
            else if (strpos($dest,'.jpg') !== false||strpos($dest,'.JPG') !== false) {
               $icon1 = imagecreatefromjpeg($dest);
            }else if (condition) {
                return false;
            }




                  //Set our text string 
            $string = ($product->title);         
            //Write our text to the existing image.
            $len = strlen($string);
            $titleFontSize = ($newImageWidth-2*$marginLeft)/$len/0.32;
            $baseTagHeight = $titleFontSize*6;            
            if($baseTagHeight>$newImageHeight/4)
            {
                $ratio =  $newImageHeight/4/$baseTagHeight;
                $baseTagHeight = $newImageHeight/4;
                $titleFontSize *= $ratio;
            }
            $offsetPos = $newImageHeight - $baseTagHeight;

            $icon2 = imagecreatefrompng(Yii::app()->basePath.'/www/images/background.png');

            //Set the background color
            $rgbColor = CategoryUtil::getCategoryColor($product->category->id);
            //$rgbColor = CategoryUtil::getCategoryColor(4);
            $bgColor = imagecolorallocate($icon2, $rgbColor['r'], $rgbColor['g'], $rgbColor['b']);                
                         
            imagealphablending($icon2, 1);
            imagecopy($gd_canvas, $icon1, 0, 0, 0, 0, $newImageWidth, $newImageHeight);
            imagecopymerge($gd_canvas, $icon2, 0, $newImageHeight-$baseTagHeight, 0, 0, $newImageWidth, $baseTagHeight,50);        


            //Set up some colors, use a dark gray as the background color
            $dark_grey = imagecolorallocate($gd_canvas, 0xcc, 0xcc, 0xcc);
            $white = imagecolorallocate($gd_canvas, 255, 255, 255);
            $shadow = imagecolorallocate($gd_canvas, 0, 0, 0);
             
            //Set the path to our true type font 
            $font_path = Yii::app()->basePath.'/www/font/mnbtitlefont.ttf';
                   
            imagettftext($gd_canvas, $titleFontSize, 0, $marginLeft, $offsetPos+$titleFontSize*2, $shadow, $font_path, $string);
            imagettftext($gd_canvas, $titleFontSize, 0, $marginLeft-1, $offsetPos+$titleFontSize*2-1, $white, $font_path, $string);
            $priceText = preg_replace('/[^0-9]/', '', $product->price);
            $priceText = number_format($priceText) . ' VNĐ';
            imagettftext($gd_canvas, $titleFontSize*0.9, 0, $marginLeft, $offsetPos+$titleFontSize*3.8, $dark_grey, $font_path, $priceText);
            imagefilledrectangle($gd_canvas,0, $newImageHeight-$titleFontSize*0.2, $newImageWidth, $newImageHeight, $bgColor);    
            if ($product->address != null && $product->user != null)
            {                
                imagettftext($gd_canvas, $titleFontSize*0.7, 0, $marginLeft, $newImageHeight-$titleFontSize*0.7, $dark_grey, $font_path, 'Liên hệ: ' . $product->user->username . ' - ' . $product->address->phone);
            }            
            



            
            imagepng($gd_canvas, $dest);
            //imagepng($gd_canvas, Yii::app()->basePath.'/www/images/content/merged_image.png');
            imagedestroy($gd_canvas);
            imagedestroy($icon2);
            imagedestroy($icon1);
            return true;

            // $background = WideImage::load('images/background.png');
            // $backgroundHeight = $image->getHeight() * 25 / 100;
            
            // $image = $image->merge($background, 0, $image->getHeight() - $backgroundHeight, 50);
            // $canvas = $image->getCanvas();

                        
            // $title = StringUtil::limitCharacter($product->title,60);
            // LogUtil::d("AAA".$image->getWidth());            
            // $titleFontSize = 1.1*$titleFontSize*$image->getWidth()/$selectedWidth;        
            // LogUtil::d("titleFontSize $titleFontSize");
            // $canvas->useFont('font/mnbtitlefont.ttf', $titleFontSize, $image->allocateColor(255, 255, 255));
            // $canvas->writeText($marginLeft, "bottom-".$titleOffset, ($product->title));

            // $priceText = preg_replace('/[^0-9]/', '', $product->price);
            // $priceText = number_format($priceText) . ' VNÄ';
            // $textFontSize = 1.1*$textFontSize*$image->getWidth()/$selectedWidth;  
            // $canvas->useFont('font/mnbtitlefont.ttf', $textFontSize, $image->allocateColor(255, 255, 255));
            // $canvas->writeText($marginLeft,"bottom-".$priceOffset, $priceText);
            // if ($product->address != null && $product->user != null)
            // {
            //     $canvas->writeText($marginLeft,"bottom-".$addressOffset, 'LiÃªn há»‡: ' . $product->user->username . ' - ' . $product->address->phone);
            // }

            // return $image->saveToFile($dest);
        }
        return false;
    }

}