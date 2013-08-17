<?php

class ApiUser extends CComponent
{

    public static $instance;
    protected $_token;
    protected $_user;
    protected $_isGuest = true;

    protected function __construct()
    {
        $this->_isGuest = true;
        if (isset($_REQUEST['token']))
        {            
            $this->_token = TokenUtil::loadToken();
            if ($this->_token != null)
            {
                $this->_isGuest = false;
                $this->_user = $this->_token->user;
            }            
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new static;
        }
        return self::$instance;
    }

    public function getModel()
    {
        return $this->_user;
    }

    public function getId()
    {
        return $this->_user->id;
    }

    public function getIsGuest()
    {
        return $this->_isGuest;
    }

}