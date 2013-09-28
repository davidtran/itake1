<?php

class SendMessageForm extends CFormModel{
    public $captcha;
    public $senderName;
    public $receiverId;      
    public $message;
    public $productId;
    protected $_receiver;
    protected $_product;
    
    public function getReceiver(){
        if($this->_receiver == null){
            $this->_receiver = User::model()->findByPk($this->receiverId);
        }
        return $this->_receiver;
        
    }
    
    public function getRules(){
        return array(
            array('captcha','captcha'),
            array('captcha,senderName,receiverId,message,productId','required'),
            array('receiverId,productId','numerical','integerOnly'=>true),
            array('senderName','length','max'=>50,'min'=>1),
            array('message','length','max'=>500,'min'=>1),
            array('productId','exist','Product'),            
            array('userId','exist','User'),
            
        );
    }
    
    public function beforeValidate()
    {        
        $this->_product = Product::model()->findByPk($this->productId);
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
        return EmailUtil::queue(
                Yii::app()->params['email.adminEmail'], 
                $this->receiver->email, 
                'receiveMessage', 
                array(
                    'senderName'=>$this->senderName,
                    'receiverName'=>$this->_receiver->username,
                    'message'=>$this->message,                   
                    'productLink'=>$this->_product->getDetailUrl(true),
                    'productTitle'=>$this->_product->title,
                ), Yii::t('Default','You just received a message from iTake.me'));
    }
    
    
}