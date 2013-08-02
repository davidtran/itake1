<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CategoryUtil
 *
 * @author Tuan NGUYEN
 */
class LogUtil
{
    public static function d($Message){
         Yii::log($Message, CLogger::LEVEL_ERROR, "DEV_DEBUG" );
    }      
    public static function i($Message){
         Yii::log($Message, CLogger::LEVEL_INFO, "DEV_DEBUG");
    }    
}

?>