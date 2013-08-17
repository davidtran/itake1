<?php

class ItakeSBaseFacebook extends SBaseFacebook {
    
    public function setAccessToken($access_token)
    {
//        $this->accessToken = $access_token;
//        $this->setPersistentData('access_token', $access_token);        
        return parent::setAccessToken($access_token);
    }
}