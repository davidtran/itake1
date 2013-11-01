<?php

class ApiUser extends CWebUser{
    private $_model;

    public function getModel()
    {
        if ($this->_model == null) {
            $this->_model = User::model()->findByPk($this->getId());
        }

        return $this->_model;
    }

    public function getIsFacebookUser()
    {
       
        if ($this->getModel() != null && $this->getModel()->fbId != null && trim($this->getModel()->fbId) != '') {            
            return true;
        }
        return false;
    }
    
    public function init() {                
        
        return parent::init();
    }
    
    public static function checkTokenAndLogin(){
        
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