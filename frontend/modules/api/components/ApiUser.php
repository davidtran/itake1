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
        if ($this->_model != null && $this->_model->fbId != null && trim($this->_model->fbId) != '') {
            return true;
        }
        return false;
    }
    
    public function init() {                
        
        return parent::init();
    }
}