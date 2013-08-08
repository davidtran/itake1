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
class LanguageUtil
{

    const LANGUAGE_KEY = 'user_language';
    const DEFAULT_LANGUAGE = 'en_US';

    public static function echoT($message)
    {
        echo Yii::t('Default', $message, null);
    }
        
    public static function t($message)
    {
        return Yii::t('Default', $message, null);
    }
    
    
    public static function getUserLanguage()
    {
        //get meta
        //get from perfer language
        if (Yii::app()->user->isGuest == false)
        {
            $meta = UserMetaUtil::findMeta(Yii::app()->user->getId(), self::LANGUAGE_KEY);
            if ($meta != null)
            {
                return $meta->value;
            }
        }
        if (isset(Yii::app()->request->cookies[md5(self::LANGUAGE_KEY)]))
        {
            return Yii::app()->request->cookies[md5(self::LANGUAGE_KEY)]->value;
        }
        $prefer = Yii::app()->request->getPreferredLanguage();
        if ($prefer !== false)
        {
            return $prefer;
        }
        return self::DEFAULT_LANGUAGE;
    }

    public static function saveUserLanguage($value)
    {
        if (Yii::app()->user->isGuets == false)
        {
            UserMetaUtil::setMeta(Yii::app()->user->getId(), self::LANGUAGE_KEY, $value);
        }
        Yii::app()->request->cookies[md5(self::LANGUAGE_KEY)] = new CHttpCookie(md5(self::LANGUAGE_KEY), $value);
    }

}
