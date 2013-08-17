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
        $productUrl = CHtml::normalizeUrl(array('/product/details','id'=>$this->product['id']));        
        $url = 'http://api.facebook.com/method/fql.query?query=select%20like_count,share_count%20from%20link_stat%20where%20url=%27'.$productUrl.'%27&format=json';                
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $json = curl_exec($ch);
        curl_close($ch);
        
        if($url!=false){
            $array = CJSON::decode($json);                    
            $this->facebookData = $array[0];
            $this->like = $array[0]['like_count'];
            $this->share = $array[0]['share_count'];                                            
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