<?php

class UserImageUtil
{

    public static function renderImage($user, $options = array())
    {
        $url = '';
        if ($user->image != null && $user->image != User::USER_IMAGE_PLACEHOLDER) {

            $url = Yii::app()->baseUrl . DIRECTORY_SEPARATOR . ltrim($user->image, DIRECTORY_SEPARATOR);
        }
        else if (!empty($user->fbId)) {
            $url = "http://graph.facebook.com/" . $user->fbId . "/picture?type=large";
        }
        else {
            $url = User::USER_IMAGE_PLACEHOLDER;
            $url = Yii::app()->baseUrl . DIRECTORY_SEPARATOR . ltrim(User::USER_IMAGE_PLACEHOLDER, DIRECTORY_SEPARATOR);
        }
     
        return CHtml::image($url, $user->username, $options);
    }

}