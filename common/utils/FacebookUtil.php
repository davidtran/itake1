<?php

class FacebookUtil
{
    const FB_LINE_BREAK = '%0D%0A';
    public static function shareProductToFacebook(Product $product,$accessToken = null){     
        $args = array('message' => self::makePostDescription($product));
        $args['image'] = '@' . realpath($product->processed_image);
        if($accessToken!=null){
            $args['access_token'] = $accessToken;
        }        
        return Yii::app()->facebook->api('/me/photos', 'post', $args);
    }
    
    protected static function makePostDescription(Product $product){
        $html = '';
        $html .= "Tên sản phẩm: $product->title".self::FB_LINE_BREAK;
        $html .= "Giá: ".number_format($product->price,0).' VNĐ'.self::FB_LINE_BREAK;
        $html .= "Người bán: ".$product->user->username.self::FB_LINE_BREAK;
        $html .= "Số điện thoại: ".$product->phone.self::FB_LINE_BREAK;
        $html .= $product->description.self::FB_LINE_BREAK;
        $html .= self::FB_LINE_BREAK;
        $html .= $product->getAbsoluteDetailUrl();
        return $html;
    }
    
    public static function postRegisterInfo()
    {
        $attachment = array(
            'name' => 'Name',
            'link' => 'http://nada.com',
            'description' => "Luyện nghe tiếng anh qua cách các video, tìm từ chính xác và ghi điểm để vượt qua các người chơi khác",
            'caption' => "ListenToMe.vn",
            'picture' => 'http://listentome.vn/images/logo-small.jpg',
            'message' => 'Tự nhiên tìm ra được một trang web làm bài tập tiếng anh hay ghê . Vừa xem video , vừa luyện nghe , vừa điền vào phụ đề bằng từ gợi ý . Bá đạo trên từng hạt gạo :v',
        );
        Yii::app()->facebook->api("/me/feed", 'POST', $attachment);
    }

    public static function getFacebookFriendInApp($accessToken = null)
    {
        //if($accessToken == null) $accessToken = self::checkFacebookAccess ();
        if (Yii::app()->user->isGuest == false && Yii::app()->user->model->isFbUser)
        {
            if (!isset(Yii::app()->session['facebookFriendInApp']))
            {
                $facebookFriendList = null;
                try
                {
                    $params = array();
                    
                    $facebookFriendList = Yii::app()->facebook->api('/me/friends',array(
                        'access_token'=>$accessToken
                    ));
                } catch (FacebookApiException $e)
                {
                    throw $e;
                }

                $result = array();
                if ($facebookFriendList != null)
                {
                    $friendIdArray = array();
                    foreach ($facebookFriendList['data'] as $facebookFriend)
                    {
                        $id = $facebookFriend['id'];
                        $friendIdArray[] = "'$id'";
                    }
                    $friendIdString = implode(',', $friendIdArray);
                    $friendList = Yii::app()
                                    ->db
                                    ->createCommand('select * from {{user}} where fbId in (' . $friendIdString . ')')
                                    ->queryAll();
                    $result = array();
                    foreach ($friendList as $friend)
                    {
                        $result[] = $friend['id'];
                    }
                    Yii::app()->session['facebookFriendInApp'] = $result;
                    return $result;
                }
            }
            else
            {
                return Yii::app()->session['facebookFriendInApp'];
            }
        }
        throw new CException(403,'Facebook login error');
    }

    public static function makeFacebookLoginUrl($returnUrl = null)
    {                
        if($returnUrl == null) $returnUrl = Yii::app()->controller->createAbsoluteUrl ('/site');
        return Yii::app()->facebook->getLoginUrl(array(
            'scope' => 'email,publish_stream,user_status',
            'redirect_uri' => $returnUrl
        ));
    }

    public static function makeFacebookLoginLink($text = null, $returnUrl = null)
    {
        if ($text == null)
            $text = 'Đăng nhập bằng Facebook';
        
        return CHtml::link(
            $text, self::makeFacebookLoginUrl($returnUrl), array(
                'id' => 'fb-timeline-btn',
                'class' => 'special-btn facebook badge-add-fb-timeline',            
            )
        );
    }
    
    /**
     * 
     * Deceprecated
     */
    public static function postProductToFacebook($product, $accessToken = null)
    {
        if($accessToken == null) $accessToken = self::checkFacebookAccess();
        $args = array('message' => $product->description);
        $args['image'] = '@' . realpath($product->image);
        $args['access_token'] = $accessToken;
        return Yii::app()->facebook->api('/me/photos', 'post', $args);
    }
    
    public static function checkFacebookAccess($checkSession = true)
    {
        if ($checkSession && isset(Yii::app()->session['FacebookAccessToken']))
        {
            return Yii::app()->session['FacebookAccessToken'];
        }
        if (Yii::app()->user->isGuest == false)
        {
            $userModel = Yii::app()->user->model;
            if ($userModel->fbId!=null)
            {

                $meta = UserMetaUtil::findMeta($userModel->id, 'FacebookAccessToken');
                if ($meta == null)
                {
                    Yii::app()->request->redirect(UserUtil::makeFacebookLoginUrl());
                }

                $access_token = $meta->value;

                try
                {
                    $user = Yii::app()->facebook->api('/me', array('access_token' => $access_token));
                    UserMetaUtil::setMeta(Yii::app()->user->getId(), 'FacebookAccessToken', $access_token);
                    Yii::app()->session['FacebookAccessToken'] = $access_token;
                    return $access_token;
                } catch (FacebookApiException $e)
                {
                    $url = UserUtil::makeFacebookLoginUrl();
                    Yii::app()->controller->redirect($url);
                }
            }
        }
    }

}