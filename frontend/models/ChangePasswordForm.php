<?php

class ChangePasswordForm extends CFormModel
{

    public $user_id;
    public $oldPassword;
    public $password;
    public $retypePassword;
    public $hideOldPassword = true;
    protected $_user;

    public function rules()
    {
        return array(
            array('user_id,password,retypePassword', 'required', 'message' => 'Cần nhập các ô này'),
            array('user_id', 'exist', 'className' => 'User', 'attributeName' => 'id'),
            array('password', 'length', 'min' => 6, 'message' => 'Tối thiếu là 6 ký tự'),
            array('password', 'compare', 'compareAttribute' => 'oldPassword', 'operator' => '!=', 'message' => 'Mật khẩu mới không được trùng với mật khẩu cũ'),
            array('oldPassword', 'checkOldPassword'),
            array('retypePassword', 'length', 'min' => 6),
            array('retypePassword', 'compare', 'compareAttribute' => 'password')
        );
    }

    public function __construct($scenario = '')
    {
        if (Yii::app()->user->isFacebookUser && false === UserRegistry::getInstance()->getValue('HaveChangedPassword', false)) {
            $this->hideOldPassword = true;
        }
        else {
            $this->hideOldPassword = false;
        }
        return parent::__construct($scenario);
    }

    public function init()
    {
        
    }

    public function checkOldPassword($attribute, $params)
    {        
        $user = User::model()->findByPk($this->user_id);
        if ($user != null) {
            $this->_user = $user;
            if ($this->hideOldPassword == false && $this->_user->password != User::model()->makeOptimizedPassword($this->oldPassword, $this->_user->salt)) {
                $this->addError('oldPassword', 'Mật khẩu cũ không chính xác');
            }
        }
        else {            
            $this->addError('user_id', 'Người dùng không tồn tại');
        }
    }

    public function beforeValidate()
    {        
        return parent::beforeValidate();
    }

    public function changePassword()
    {
        if ($this->validate()) {

            $this->_user->password = $this->password;

            if ($this->_user->save()) {
                $this->sendNewPasswordByEmail($this->password);
                return true;
            }
        }
        return false;
    }

    public function attributeLabels()
    {
        return array(
            'oldPassword' => LanguageUtil::t('Old password'),
            'password' => LanguageUtil::t('New password'),
            'retypePassword' => LanguageUtil::t('Reconfirm new password')
        );
    }

    protected function sendNewPasswordByEmail($newPassword)
    {
        EmailUtil::queue(
                Yii::app()->params['email.adminEmail'], $this->_user->email, 'changePassword', array(
                    'username' => $this->_user->username,
                    'email' => $this->_user->email,
                    'newPassword' => $newPassword
                ), 
                'Bạn vừa đổi mật khẩu tại ' . Yii::app()->name,
                false
        );
    }

}

?>
