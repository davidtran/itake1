<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class FacebookLoginForm extends LoginForm
{

    public $username;    
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // username and password are required
            array('username', 'required'),            
        );
    }

    
    public function Login(){
        if ($this->_identity === null){
            $this->_identity = new FacebookUserIdentity($this->username);
            $this->_identity->authenticate();
        }        
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE)
        {
            $duration = 3600 * 24 * 30;
            Yii::app()->user->login($this->_identity, $duration);
            return true;
        }
        else
            return false;
    }

}
