<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{

    const ERROR_EMAIL_INVALID = 3;
    const ERROR_USER_BAN = 4;

    public $email;

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function __construct($email, $password = null)
    {
        $this->email = $email;
        $this->username = $email;
        $this->password = $password;
    }

    private $_id;

    public function authenticate($isFacebookLogin = false)
    {

        $user = User::model()->find('email=:email', array(
            'email' => $this->email
        ));
        if ($user == null)
            $this->errorCode = self::ERROR_EMAIL_INVALID;
        if($user!=null&&$user->isFbUser!=TRUE)
        {
            if ($user->password != md5(md5($this->password) . $user->salt))
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            else if ($user->status != User::STATUS_ACTIVE)
            {
                $this->errorCode = self::ERROR_USER_BAN;
            }
            else
            {
                $this->errorCode = self::ERROR_NONE;
                $this->_id = $user->id;
            }
        }
        else
        {
            if ($user->status != User::STATUS_ACTIVE)
            {

                $this->errorCode = self::ERROR_USER_BAN;
            }
            else
            {

                $this->errorCode = self::ERROR_NONE;
                $this->_id = $user->id;
            }
        }
        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }

}