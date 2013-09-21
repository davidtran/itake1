<?php

class UserImageUtil
{
    const USER_IMAGE_PLACEHOLDER = 'images/user-placeholder.jpg';
    public static function renderImage($user, $options = array())
    {
        $url = '';
        if ( !empty($user->image)) {
            $url = Yii::app()->baseUrl . DIRECTORY_SEPARATOR . ltrim($user->image, DIRECTORY_SEPARATOR);
        }
        else if (!empty($user->fbId)) {
            $url = "http://graph.facebook.com/" . $user->fbId . "/picture?type=large";
        }       
        $options = CMap::mergeArray($options, array(
            'onError'=>"this.onerror=null;this.src='".Yii::app()->baseUrl . DIRECTORY_SEPARATOR. self::USER_IMAGE_PLACEHOLDER."';"
        ));
        return CHtml::image($url, $user->username, $options);
    }

}