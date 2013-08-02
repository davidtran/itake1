<?php

/**
 * Class util to resolve some user-relate action: register, forget email, login
 */
class UserUtil
{

    const USER_IMAGE_PLACEHOLDER = 'images/user-placeholder.png';

    public static function findAvailableUser($userId)
    {
        $user = User::model()->find(array(
            'condition' => 'id=:id and status=:status',
            'params' => array(
                'id' => $userId,
                'status' => User::STATUS_ACTIVE
            )
        ));
        return $user;
    }

    /**
     * find a user by email
     * @param string $email 
     * @return User
     */
    public static function getUserByEmail($email)
    {
        assert('is_string($email)');
        $user = User::model()->find('email=:email', array('email' => $email));
        return $user;
    }

    public static function isUserNameExist($username)
    {
        $sql = 'select count(*) from {{user}} where username=:username';
        $exist = Yii::app()->db->createCommand($sql)->bindValue('username', $username)->queryScalar();
        if ($exist > 0)
        {
            return true;
        }
        return false;
    }

    /**
     * Make a login link
     * @return string 
     */
    public static function makeLoginUrl($returnUrl = null)
    {
        if ($returnUrl != null)
        {
            return Yii::app()->createAbsoluteUrl('/user/login', array(
                'returnUrl' => $returnUrl
            ));
        }
        else
        {
            return Yii::app()->createAbsoluteUrl('/user/login');
        }
    }

    public static function makeRegisterUrl($returnUrl = null)
    {
        return Yii::app()->createAbsoluteUrl('/user/register', array(
            'returnUrl' => $returnUrl
        ));
    }

    public static function makeUserProfileLink($user)
    {
        return CHtml::link(
        $user->username, array('/user/profile', 'id' => $user->id, 'name' => $user->username), array('title' => $user->target)
        );
    }

    public static function makeUserProfileUrl($user = null)
    {
        if ($user)
        {
            $user_id = null;
            if ($user instanceof User)
            {
                $user_id = $user->id;
            }
            else
            {
                $user_id = $user;
            }
            return Yii::app()->createUrl('/user/profile', array(
                'id' => $user_id,
                'name' => StringUtil::utf8ToAscii($user->username),
            )
            );
        }
        else
        {
            return Yii::app()->createUrl('/user/profile');
        }
    }

    public static function getProfileImageUrl(User $user = null)
    {
        $filename = null;

        if ($user != null)
        {
            if ($user->image != null)
            {
                if (stripos($user->image, 'http://') !== false || stripos($user->image, 'https://') !== false)
                {
                    return $user->image;
                }
                else if (substr($user->image, 0, 1) == '/')
                {
                    return $user->image;
                }
                else
                {
                    return Yii::app()->baseUrl . '/' . $user->image;
                }
            }
            else
            {
                if ($user->isFbUser)
                {
                    $fbData = unserialize($user->fbprofile);
                    if (isset($fbData['id']))
                    {
                        $fid = $fbData['id'];
                        $url = "http://graph.facebook.com/" . $fid . "/picture?type=large";
                        $headers = @get_headers($url, 1);
                        if (isset($headers['Location']))
                        {
                            return $url;
                        }
                    }
                }
            }
        }
        return Yii::app()->baseUrl . '/' . self::USER_IMAGE_PLACEHOLDER;
    }

    public static function makeLogoutUrl()
    {
        return Yii::app()->createAbsoluteUrl('/user/logout');
    }

    public static function publishLoginUserInfo()
    {
        if (!Yii::app()->user->isGuest)
        {
            $user = Yii::app()->user->getModel();
            if ($user != null)
            {
                $userInfo = json_encode($user->getContactInfo());

                Yii::app()->clientScript->registerScript('user-login-info-' . $user->id, <<<HERE
   var loginUser = $userInfo;
HERE
                , CClientScript::POS_HEAD);
            }
        }
    }

    public static function publishUserInfo(User $user)
    {

        $userInfo = json_encode($user->getContactInfo());

        Yii::app()->clientScript->registerScript('user-info-' . $user->id, <<<HERE
   var user = $userInfo;
HERE
        , CClientScript::POS_HEAD);
    }

    public static function canEdit($user)
    {
        if (Yii::app()->user->isGuest == false && Yii::app()->user->getId() == $user->id)
        {
            return true;
        }
        return false;
    }
    public static function hasContactInfo()
    {
        $user =  Yii::app()->user->model;
        return $user->phone!=null&&$user->lon!=null&&$user->lat!=null&&$user->locationText!=null&&$user->city!=null;
    }
    public static function getContactInfo(){
        $user =  Yii::app()->user->model;
        if($user==null)
            return null;
        return array(
            'phone'=>$user->phone,
            'lon'=>$user->lon,
            'lat'=>$user->lat,
            'locationText'=>$user->locationText,
            'city'=>$user->city
        );
    }
    public static function uploadProfile(User $user)
    {
        $uploadInstance = ImageUploadUtil::getInstance('profileImage');
        $oldImage = $user->image;
        $result = $uploadInstance->handleUploadImage('images/content/profile', 'profile_image_'.$user->id.'_'.rand(0,999), 180, 180, 300, 300);
        if($result == false){
            $user->addError('image', $uploadInstance->getError());            
            return false;
        }else{
            $user->image = $result;
            @unlink($oldImage);
            $user->save();
            return true;
        }        
            
    }
    
    public static function uploadBanner(User $user){
        $uploadInstance = ImageUploadUtil::getInstance('bannerImage');
        $oldBanner = $user->banner;
        $result = $uploadInstance->handleUploadImage( 'images/content/profile', 'banner_image_'.$user->id.'_'.rand(0,999), 1024, 768,1024,768);
        if($result == false){
            $user->addError('banner', $uploadInstance->getError());
            return false;
        }
        else{
            @unlink($oldBanner);
            $user->banner = $result;
            $user->save();
            return true;
        }
    }
    
    
    
    
}

