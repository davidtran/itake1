<?php

    class ConfirmEmailForm extends CFormModel{
        public $user_id;
        public $email;
        
        protected $_userModel = null;
        public function __construct($scenario = '')
        {                        
            
        }
        
        public function rules()
        {
            return array(
                array('user_id,email','required','message'=>'Cần nhập các ô này'),
                array('user_id','exist','className'=>'User','attributeName'=>'id'),              
                array('email','checkEmailUnique'),
                array('email','email'),
            );
        }

        public function checkEmailUnique($attribute,$params){
            $exist = Yii::app()
                        ->db
                        ->createCommand('select count(*) from {{user}} where email=:email and id!=:id')
                        ->queryScalar(array(
                            'email'=>$this->email,
                            'id'=>$this->user_id
                        ));
            if(is_numeric($exist) && $exist > 0){
                $this->addError('email','Email "'.$this->email.'" đã được sử dụng.');
                return false;
            } 
            return true;                       
        }
        
        public function sendConfirmEmail(){
            $rs = false;
            if($this->validate() && false == UserEmail::isEmailVerified($this->email)
                ){
                $this->_userModel = User::model()->findByPk($this->user_id);
                $code = UserEmail::generateVerifyCode($this->email);
                $rs = UserEmail::sendVerifyEmail($this->_userModel,$code);
            }
            if( false == $rs){
                $this->addError('email','Không thể gửi email xác thực, vui lòng kiểm tra lại email');
                return false;
            }                        
            return true;
        }
        

    }
?>
