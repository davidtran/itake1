<?php

class WebUser extends CWebUser
{

    private $_model;

    public function getModel()
    {
        if ($this->_model == null)
        {
            $this->_model = User::model()->findByPk($this->getId());
        }

        return $this->_model;
    }

    public function getIsFacebookUser()
    {
        if ($this->model != null && $this->model->fbId != null && trim($this->model->fbId) != '')
        {
            return true;
        }
        return false;
    }

    public function init()
    {
        //check for login
        if ($this->model != null)
        {
            
        }
        parent::init();
    }

}