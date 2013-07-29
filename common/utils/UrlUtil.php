<?php

    /*
     * To change this template, choose Tools | Templates
     * and open the template in the editor.
     */

    /**
     * Description of UrlUtil
     *
     * @author USER
     */
    class UrlUtil
    {

        public static function getImageUrl($filename)
        {
            return Yii::app()->request->getBaseUrl(true) . '/images/' . $filename;
        }
        
        public static function getAbsoluteUrl(){
            $request = Yii::app()->request;
            return $request->hostInfo.$request->url;
        }
                        
    }

?>
