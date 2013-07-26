<?php

class FacebookUtil
{
    const FB_LINE_BREAK = '%0D%0A';
    
    protected $_accessToken;
    protected static $instance;

    const FACEBOOK_FRIEND_IN_APP_SESSION_NAME = 'facebookFriendInApp';

    protected function __construct()
    {
        
    }

    /**
     * Get singleton instance
     * @return FacebookUtil
     */
    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function setAccessToken($accessToken)
    {
        //check token valid;
        if ($this->checkTokenValid($accessToken))
        {
            $this->_accessToken = $accessToken;
        }
        else
        {
            throw new CException('Invalid token');
        }
    }

    public function getAccessToken()
    {
        return $this->_accessToken;
    }

    public function checkTokenValid($token)
    {
        try
        {
            $user = Yii::app()->facebook->api('/me', array('access_token' => $token));
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public function postRegisterInfo()
    {
        $attachment = array(
            'name' => 'ListenToMe.vn - Trò chơi luyện nghe tiếng Anh qua video',
            'link' => 'http://listentome.vn',
            'description' => "Luyện nghe tiếng anh qua cách các video, tìm từ chính xác và ghi điểm để vượt qua các người chơi khác",
            'caption' => "ListenToMe.vn",
            'picture' => 'http://listentome.vn/images/logo-small.jpg',
            'message' => 'Tự nhiên tìm ra được một trang web làm bài tập tiếng anh hay ghê . Vừa xem video , vừa luyện nghe , vừa điền vào phụ đề bằng từ gợi ý . Bá đạo trên từng hạt gạo :v',
        );
        $attachment['access_token'] = $this->getAccessToken();
        Yii::app()->facebook->api("/me/feed", 'POST', $attachment);
    }

    public function getFacebookFriendList()
    {
        return Yii::app()->facebook->api('/me/friends', array(
                    'access_token' => $this->getAccessToken()
        ));
    }

    public function filterFacebookFriendInApp($facebookFriendList)
    {
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
            Yii::app()->session[self::FACEBOOK_FRIEND_IN_APP_SESSION_NAME] = $result;
            return $result;
        }
    }

    public function getFacebookFriendInApp($userId)
    {
        try
        {

            if (!isset(Yii::app()->session[self::FACEBOOK_FRIEND_IN_APP_SESSION_NAME]))
            {
                $facebookFriendList = $this->getFacebookFriendList($userId);
                $filterList = $this->filterFacebookFriendInApp($facebookFriendList);
                $filterList[] = $userId;
                Yii::app()->session[self::FACEBOOK_FRIEND_IN_APP_SESSION_NAME] = $filterList;
            }
            return Yii::app()->session[self::FACEBOOK_FRIEND_IN_APP_SESSION_NAME];
        }
        catch (Exception $e)
        {
            return false;
        }
        return false;
    }

    public function getSavedUserToken($userId)
    {
        $meta = UserMetaUtil::findMeta($userId, 'FacebookAccessToken');
        if ($meta != null)
        {
            return $meta->value;
        }
        return false;
    }

    public function saveUserToken($userId, $token)
    {
        UserMetaUtil::setMeta($userId, 'FacebookAccessToken', $token);
    }
    public function shareProductToFacebook(Product $product,$accessToken = null){     
        $args = array('message' => $this->makePostDescription($product));
        $args['image'] = '@' . realpath($product->image);
        if($accessToken!=null){
            $args['access_token'] = $accessToken;
        }        
        return Yii::app()->facebook->api('/me/photos', 'post', $args);
    }
    
    protected function makePostDescription(Product $product){
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
    
   

    public static function makeFacebookLoginUrl($returnUrl = null)
    {
        if($returnUrl == null){
            $returnUrl = Yii::app()->controller->createAbsoluteUrl('/site/index');            
        }        
        Yii::app()->controller->setReturnUrl($returnUrl);
        return Yii::app()->facebook->getLoginUrl(array(
            'scope' => 'email,publish_stream,user_status',            
            'redirect_uri'=>Yii::app()->controller->createAbsoluteUrl('/user/register')
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
       
}