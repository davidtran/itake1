<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class FacebookUserIdentity extends CUserIdentity
{

    const ERROR_EMAIL_INVALID = 3;
    const ERROR_USER_BAN = 4;

    public $email;

    public function __construct($email)
    {
        $this->email = $email;
        $this->username = $email;
    }

    private $_id;

    public function authenticate()
    {
        $user = User::model()->find('email=:email', array(
            'email' => $this->email
        ));
        if ($user == null)
        {
            $this->errorCode = self::ERROR_EMAIL_INVALID;
        }
        else if ($user->status != User::STATUS_ACTIVE)
        {

            $this->errorCode = self::ERROR_USER_BAN;
        }
        else
        {

            $this->errorCode = self::ERROR_NONE;
            $this->_id = $user->id;
        }

        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }

}