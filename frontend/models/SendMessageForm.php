<?php

class SendMessageForm extends CFormModel{
    public $captcha;
    public $senderName;
    public $receiverId;      
    public $message;
    
    protected $_receiver;
    
    public function getReceiver(){
        if($this->_receiver == null){
            $this->_receiver = User::model()->findByPk($this->receiverId);
        }
        return $this->_receiver;
        
    }
    
    public function getRules(){
        return array(
            array('captcha','captcha'),
            array('captcha,senderName,receiverId,message','required'),
            array('receiverId','numerical','integerOnly'=>true),
            array('senderName','length','max'=>50),
            array('message','length','max'=>500),
            array('receiverId','exist','className'=>'User')
        );
    }
    
    public function beforeValidate()
    {        
        return parent::beforeValidate();
    }
    
    public function attributeLabels()
    {
        return array(
            'message'=>'Tin nhắn',
            'senderName'=>'Người gửi',
            'captcha'=>'Mã xác nhận'
        );
    }
    
    public function send(){                
        EmailUtil::queue(
                Yii::app()->params['email.adminEmail'], 
                $this->receiver->email, 
                'receiveMessage', 
                array(
                    'senderName'=>$this->senderName,
                    'receiverName'=>$this->receiver->username,
                    'message'=>$this->message,                   
                ), Yii::t('Default','You just received a message from iTake.me'));
    }
    
    
}