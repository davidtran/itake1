<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LanguageUtil
 *
 * @author Nguyen TUan
 */
class LanguageUtil {
    public static function echoT($message) {
        echo Yii::t('Default',$message,null);
    }
    public static function t($message)
    {
    	return Yii::t('Default',$message,null);
    }
}
