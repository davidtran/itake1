<?php

class SimpleProductAnalyticUtil{
    
    /**
     * Product data in array
     * @var array
     */
    protected $product;
    protected $facebookData = null;
    protected $like = 0;
    protected $share = 0;
    protected $view = 0;
    
    
    public function __construct($product)
    {
        $this->product = $product;
    }
    
    public function makeAnalytic(){
        //facebook
        $this->view = $this->product['view'];
        $this->getFacebookAnalytic();
        //view count
    }
    
    protected function getFacebookAnalytic(){
        $url = 'https://graph.facebook.com/fql?q=SELECT url, normalized_url, share_count, like_count, comment_count, total_count,commentsbox_count, comments_fbid, click_count FROM link_stat WHERE url="';
        $url.= Yii::app()->controller->createAbsoluteUrl('/product/details',array('id'=>$this->product['id']));
        $json = file_get_contents($url);
        $rs = array();
        if($url!=false){
            $array = CJSON::decode($json);
            if(isset($array['data'])){
                $this->facebookData = $array['data'];
                $this->like = $array['like_count'];
                $this->share = $array['share_count'];                
                
            }
        }
    }
    
    public function getLike(){
        return $this->like;
    }
    
    public function getShare(){
        return $this->share;
    }
    
    public function getView(){
        return $this->view;
    }
    
    
}