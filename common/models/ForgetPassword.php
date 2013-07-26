<?php

    class ForgetPassword extends CFormModel
    {
        private $_user;
        public $email;
        public $captcha;

        public function rules()
        {
            return array(
                array('email','email'),
                array('email','exist','className'=>'User','attributeName'=>'email'),            
                array('captcha','captcha'),
            );
        }

        public function resolveForgetPassword()
        {
            if($this->validate())
            {
                $this->_user = UserUtil::getUserByEmail($this->email);
                $newPassword = $this->generateRandomPassword();
                $this->_user->password = $newPassword;                
                $this->_user->save();
                $this->sendEmail($newPassword);                             
                return true;
            }
            return false;
        }


        protected function generateRandomPassword(){
            return StringUtil::generateRandomString(25);
        }

        protected function sendEmail($newPassword){
            EmailUtil::sendEmail(
                Yii::app()->params['email.adminEmail'], 
                $this->_user->email,
                'forgetPassword',
                array(
                    'user'=>$this->_user,
                    'newPassword'=>$newPassword
                ),
                'Bạn có yêu cầu mật khẩu mới tại ListenToMe.vn'
            );
        }
    }