<?php

class AutoUserApiLogin{
    public static function autoLogin(){
        
        if (isset($_REQUEST['token']))
        {            
            $token = TokenUtil::loadToken($_REQUEST['token']);
            if ($token != null)
            {            
                $user = $token->user;
                $identity = new ApiUserIdentity($user);
                Yii::app()->user->login($identity);
                return true;
            }            
        }
        return false;
    }
}