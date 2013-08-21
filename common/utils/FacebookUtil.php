<?php

class FacebookUtil
{

    const FB_LINE_BREAK = '#';

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
            Yii::app()->facebook->setAccessToken($accessToken);
        }
        else
        {
            throw new CException('Invalid token');
        }
    }
    
    public function setExtendedAccessToken(){
        return Yii::app()->facebook->setExtendedAccessToken();
    }
    
    public function getAccessToken()
    {
        return $this->_accessToken;
    }

    public function checkTokenValid($token)
    {
        try
        {
            $user = Yii::app()->facebook->api('/me?access_token='.$this->_accessToken);              
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public function getFacebookFriendList()
    {
        return Yii::app()->facebook->api('/me/friends','post',array(
            'access_token'=>$this->_accessToken
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


    public function shareProductToFacebook(Product $product)
    {
        $args = array();   
        $args['picture'] = '@'.realpath($product->firstImage->facebook);        
        $desc = $this->makePostDescription($product);        
        $args['message'] = $desc;
        $args['access_token'] = $this->_accessToken;
        FacebookPostQueueUtil::queueCommand('/me/photos', 'POST', $args, $product->user_id);
        //return Yii::app()->facebook->api('/me/photos', 'POST', $args);       
    }

    protected function makePostDescription(Product $product)
    {     
        $address = '';
        if($product->locationText != ''){
            $address = $product->locationText. ',';
        }
        $address .= CityUtil::getCityName($product->city);
        $html ="$product->description                                                
               ".$product->getDetailUrl(true);               
        return $html;
    }
    
    protected static function fbLinkDescriptionNewLines($string)
    {
        $parts = explode(self::FB_LINE_BREAK, $string);
        $row_limit = 80;
        $message = '';
        foreach ($parts as $part)
        {
            $str_len = strlen($part);
            $diff = ($row_limit - $str_len);

            $message .= $part;

            for ($i = 0; $i <= $diff; $i++)
            {
                $message .= '%20';
            }
        }
        return $message;
    }

    public static function makeFacebookLoginUrl($returnUrl = null)
    {
        if ($returnUrl == null)
        {
            $returnUrl = Yii::app()->controller->createAbsoluteUrl('/site/index');
        }
        Yii::app()->controller->setReturnUrl($returnUrl);
        return Yii::app()->facebook->getLoginUrl(array(
                    'scope' => 'email,publish_stream,user_photos,manage_pages',
                    'redirect_uri' => Yii::app()->controller->createAbsoluteUrl('/user/register')
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
    
    public function getManagePageList(){     
        try{
            $uid = Yii::app()->user->model->fbId;
            $pages = Yii::app()->facebook->api(array(
                'method' => 'fql.query',
                'query' => 'SELECT page_id,name,page_url FROM page WHERE page_id in (select page_id from page_admin where uid='.$uid.')',
               // 'access_token'=>$this->_accessToken
                )
            );                              
            return $pages;
        }
        catch(Exception $e){
            return false;
        }        
    }
    
    public function shareProductToPage($product,$page){
        $args = array();   
        $args['picture'] = '@'.realpath($product->firstImage->facebook);        
        $desc = $this->makePostDescription($product);        
        $args['message'] = $desc;
        $args['page_id'] = $page;
        
        $pageInfo = Yii::app()->facebook->api("/$page/?fields=access_token");
        if(!empty($pageInfo)){
            $args['access_token'] = $pageInfo['access_token'];
        }
        //return Yii::app()->facebook->api('/'.$page.'/photos','POST',$args);
        FacebookPostQueueUtil::queueCommand("/$page/?fields=access_token", 'POST', $args, $product->user_id);
    }       

}